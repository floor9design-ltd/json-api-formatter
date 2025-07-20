<?php
/**
 * Relationship.php
 *
 * Relationship class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.1
 * @link      https://www.floor9design.com
 * @since     File available since pre-release development cycle
 *
 */

namespace Floor9design\JsonApiFormatter\Models;

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;
use Floor9design\JsonApiFormatter\Interfaces\DataResourceInterface;
use Floor9design\JsonApiFormatter\Interfaces\LinksInterface;
use Floor9design\JsonApiFormatter\Interfaces\MetaInterface;
use Floor9design\JsonApiFormatter\Interfaces\RelationshipInterface;
use stdClass;

/**
 * Class Relationship
 *
 * Class to offer methods/properties to prepare data for a Relationship object
 * These are set to the v1.1 specification, defined at https://jsonapi.org/format/
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.1
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     File available since pre-release development cycle
 * @see       https://jsonapi.org/format/
 */
class Relationship implements RelationshipInterface
{
    // properties

    /**
     * @var DataResourceInterface|array<DataResourceInterface>|null
     */
    protected DataResourceInterface|array|null $data;

    /**
     * @var LinksInterface|null
     */
    protected ?LinksInterface $links = null;

    /**
     * @var MetaInterface|null
     */
    protected ?MetaInterface $meta;

    // accessors

    /**
     * @return DataResourceInterface|array<DataResourceInterface>|null
     * @see $data
     */
    public function getData(): DataResourceInterface|array|null
    {
        return $this->data;
    }

    /**
     * @param DataResourceInterface|array<DataResourceInterface>|null $data
     * @return RelationshipInterface
     * @throws JsonApiFormatterException
     * @see $data
     */
    public function setData(DataResourceInterface|array|null $data): RelationshipInterface
    {
        if (is_array($data)) {
            foreach ($data as $value) {
                if (!$value instanceof DataResourceInterface) {
                    throw new JsonApiFormatterException(
                        'Data must be instance of or array of DataResourceInterface objects'
                    );
                }
            }
        }

        $this->data = $data;
        return $this;
    }

    /**
     * @return LinksInterface|null
     * @see $links
     */
    public function getLinks(): ?LinksInterface
    {
        return $this->links;
    }

    /**
     * @param LinksInterface|null $links
     * @return RelationshipInterface
     * @see $links
     */
    public function setLinks(?LinksInterface $links): RelationshipInterface
    {
        $this->links = $links;
        return $this;
    }

    /**
     * @return MetaInterface|null
     * @see $meta
     */
    public function getMeta(): ?MetaInterface
    {
        return $this->meta;
    }

    /**
     * @param MetaInterface|null $meta
     * @return RelationshipInterface
     * @see $meta
     */
    public function setMeta(?MetaInterface $meta): RelationshipInterface
    {
        $this->meta = $meta;
        return $this;
    }

    // constructor

    /**
     * Relationship constructor.
     * Automatically sets up the provided array as properties
     * @param LinksInterface|null $links
     * @param DataResourceInterface|array<DataResourceInterface>|null $data
     * @param MetaInterface|null $meta
     * @throws JsonApiFormatterException
     */
    public function __construct(
        DataResourceInterface|array|null $data = null,
        ?LinksInterface $links = null,
        ?MetaInterface $meta = null
    ) {
        $this
            ->setLinks($links)
            ->setData($data)
            ->setMeta($meta);
    }

    /**
     * @return array<string, stdClass>.
     * @throws JsonApiFormatterException
     */
    public function process(): array
    {
        $response = [];

        if ($this->getData() instanceof DataResourceInterface) {
            $response['data'] = $this->getData()->process();
        } elseif (is_array($this->getData())) {
            $data_array = [];
            foreach ($this->getData() as $data_resource_item) {
                $data_array[] = $data_resource_item->process();
            }
            $response['data'] = $data_array;
        }

        if ($this->getLinks() instanceof LinksInterface) {
            $response['links'] = $this->getLinks()->process();
        }

        if ($this->getMeta() instanceof Meta) {
            $response['meta'] = $this->getMeta()->process();
        }

        return $response;
    }

}
