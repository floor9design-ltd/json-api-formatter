<?php
/**
 * RelationshipData.php
 *
 * RelationshipData class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.0
 * @link      https://www.floor9design.com
 * @since     File available since pre-release development cycle
 *
 */

namespace Floor9design\JsonApiFormatter\Models;

use stdClass;

/**
 * Class RelationshipData
 *
 * Class to offer methods/properties to prepare data for a RelationshipData object
 * These are set to the v1.0 specification, defined at https://jsonapi.org/format/
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.0
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     File available since pre-release development cycle
 * @see       https://jsonapi.org/format/
 */
class RelationshipData
{
    // properties

    /**
     * @var DataResourceMeta|null
     */
    var ?DataResourceMeta $data_resource_meta = null;

    /**
     * @var string|null
     */
    var ?string $id = null;

    /**
     * @var string|null
     */
    var ?string $type = null;

    // accessors

    /**
     * @return DataResourceMeta|null
     * @see $data_resource_meta
     */
    public function getDataResourceMeta(): ?DataResourceMeta
    {
        return $this->data_resource_meta;
    }

    /**
     * @param DataResourceMeta|null $data_resource_meta
     * @return RelationshipData
     * @see $data_resource_meta
     */
    public function setDataResourceMeta(?DataResourceMeta $data_resource_meta): RelationshipData
    {
        $this->data_resource_meta = $data_resource_meta;
        return $this;
    }

    /**
     * @return string|null
     * @see $id
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return RelationshipData
     * @see $id
     */
    public function setId(?string $id): RelationshipData
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     * @see $type
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return RelationshipData
     * @see $type
     */
    public function setType(?string $type): RelationshipData
    {
        $this->type = $type;
        return $this;
    }
    
    // constructor

    /**
     * RelationshipData constructor.
     * Automatically sets up the provided array as properties
     * @param string|null $id
     * @param string|null $type
     * @param DataResourceMeta|null $data_resource_meta
     */
    public function __construct(
        ?string $id = null,
        ?string $type = null,
        ?DataResourceMeta $data_resource_meta = null
    )
    {
        $this
            ->setId($id)
            ->setType($type)
            ->setDataResourceMeta($data_resource_meta);
    }

    /**
     * @return stdClass a stdClass cleaned object suitable for encoding
     */
    public function process(): stdClass
    {
        // always return core:
        $array = [
            'id' => $this->getId(),
            'type' => $this->getType()
        ];

        // return DataResourceMeta if set, else clean
        if(($this->getDataResourceMeta() instanceof DataResourceMeta)) {
            $array['meta'] = $this->getDataResourceMeta()->process();
        }

        return (object)$array;
    }

}
