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
 * @version   0.3.8
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
 * @version   0.3.8
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     File available since pre-release development cycle
 * @see       https://jsonapi.org/format/
 */
class DataResource
{
    // Properties

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
     * @phpstan-param array<mixed>|null $attributes
     * @param array|null $attributes
     */
    public function __construct(
        ?string $id = null,
        ?string $type = null,
        ?array $attributes = null
    ) {
        $this
            ->setId($id)
            ->setType($type)
            ->setAttributes($attributes);
    }

    /**
     * @phpstan-return array{id:string|null,type:string|null,attributes:array<mixed>|null}
     * @return array
     */
    public function toArray(): array
    {
        return [
          'id' => $this->getId(),
          'type' => $this->getType(),
          'attributes' => $this->getAttributes()
        ];
    }


}
