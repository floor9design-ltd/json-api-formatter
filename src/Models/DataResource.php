<?php
/**
 * DataResource.php
 *
 * DataResource class
 *
 * php 7.4+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   0.5.0
 * @link      https://www.floor9design.com
 * @since     File available since pre-release development cycle
 *
 */

namespace Floor9design\JsonApiFormatter\Models;

/**
 * Class DataResource
 *
 * Class to offer methods/properties to prepare data for a DataResource
 * These are set to the v1.0 specification, defined at https://jsonapi.org/format/
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   0.5.0
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     File available since pre-release development cycle
 * @see       https://jsonapi.org/format/
 */
class DataResource
{
    // properties

    /**
     * @var DataResourceMeta|null
     */
    var ?DataResourceMeta $data_resource_meta;

    /**
     * @var string|null
     */
    var ?string $id = null;

    /**
     * @var string|null
     */
    var ?string $type = null;

    /**
     * @phpstan-var array[]
     * @var array|null
     */
    var ?array $attributes = null;

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
     * @return DataResource
     * @see $data_resource_meta
     */
    public function setDataResourceMeta(?DataResourceMeta $data_resource_meta): DataResource
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
     * @return DataResource
     * @see $id
     */
    public function setId(?string $id): DataResource
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
     * @return DataResource
     * @see $type
     */
    public function setType(?string $type): DataResource
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @phpstan-return array<mixed>|null
     * @return array|null
     * @see $attributes
     */
    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    /**
     * @phpstan-param array<mixed>|null $attributes
     * @param array|null $attributes
     * @return DataResource
     * @see $attributes
     */
    public function setAttributes(?array $attributes): DataResource
    {
        $this->attributes = $attributes;
        return $this;
    }

    // constructor

    /**
     * DataResource constructor.
     * @param string|null $id
     * @param string|null $type
     * @param array<mixed>|null $attributes
     * @param DataResourceMeta|null $data_resource_meta
     */
    public function __construct(
        ?string $id = null,
        ?string $type = null,
        ?array $attributes = null,
        ?DataResourceMeta $data_resource_meta = null
    ) {
        $this
            ->setId($id)
            ->setType($type)
            ->setAttributes($attributes)
            ->setDataResourceMeta($data_resource_meta);
    }

    /**
     * @phpstan-return array{id:string|null,type:string|null,attributes:array<mixed>|null,meta?:array<mixed>|null}
     * @return array
     */
    public function toArray(): array
    {
        // always return core:

        $array = [
          'id' => $this->getId(),
          'type' => $this->getType(),
          'attributes' => $this->getAttributes()
        ];

        // return DataResourceMeta if set, else clean
        if(($this->getDataResourceMeta() instanceof DataResourceMeta)) {
            $array['meta'] = $this->getDataResourceMeta()->toArray();
        }

        return $array;
    }

}
