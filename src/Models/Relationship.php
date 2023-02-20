<?php
/**
 * Relationship.php
 *
 * Relationship class
 *
 * php 7.4+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   1.3.0
 * @link      https://www.floor9design.com
 * @since     File available since pre-release development cycle
 *
 */

namespace Floor9design\JsonApiFormatter\Models;

use stdClass;

/**
 * Class Relationship
 *
 * Class to offer methods/properties to prepare data for a Relationship object
 * These are set to the v1.0 specification, defined at https://jsonapi.org/format/
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   1.3.0
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     File available since pre-release development cycle
 * @see       https://jsonapi.org/format/
 */
class Relationship
{

    /**
     * @var RelationshipData|null
     */
    var ?RelationshipData $data;

    /**
     * @var RelationshipLinks|null
     */
    var ?RelationshipLinks $links = null;

    /**
     * @var RelationshipMeta|null
     */
    var ?RelationshipMeta $meta;

    // accessors

    /**
     * @return RelationshipData|null
     * @see $data
     */
    public function getData(): ?RelationshipData
    {
        return $this->data;
    }

    /**
     * @param RelationshipData|null $data
     * @return Relationship
     * @see $data
     */
    public function setData(?RelationshipData $data): Relationship
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return RelationshipLinks|null
     * @see $links
     */
    public function getLinks(): ?RelationshipLinks
    {
        return $this->links;
    }

    /**
     * @param RelationshipLinks|null $links
     * @return Relationship
     * @see $links
     */
    public function setLinks(?RelationshipLinks $links): Relationship
    {
        $this->links = $links;
        return $this;
    }

    /**
     * @return RelationshipMeta|null
     * @see $meta
     */
    public function getMeta(): ?RelationshipMeta
    {
        return $this->meta;
    }

    /**
     * @param RelationshipMeta|null $meta
     * @return Relationship
     * @see $meta
     */
    public function setMeta(?RelationshipMeta $meta): Relationship
    {
        $this->meta = $meta;
        return $this;
    }

    // constructor

    /**
     * Relationship constructor.
     * Automatically sets up the provided array as properties
     * @param RelationshipLinks|null $links
     * @param RelationshipData|null $data
     * @param RelationshipMeta|null $meta
     */
    public function __construct(
        ?RelationshipLinks $links = null,
        ?RelationshipData $data = null,
        ?RelationshipMeta $meta = null
    ) {
        $this
            ->setLinks($links)
            ->setData($data)
            ->setMeta($meta);
    }

    /**
     * @return array<string, stdClass>.
     */
    public function process(): array
    {
        $response = [];

        if($this->getData() instanceof RelationshipData) {
            $response['data'] = $this->getData()->process();
        }

        if($this->getLinks() instanceof RelationshipLinks) {
            $response['links'] = $this->getLinks()->process();
        }

        if($this->getMeta() instanceof RelationshipMeta) {
            $response['meta'] = $this->getMeta()->process();
        }

        return $response;
    }

}
