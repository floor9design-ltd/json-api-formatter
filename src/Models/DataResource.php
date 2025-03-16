<?php
/**
 * DataResource.php
 *
 * DataResource class
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

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;
use Floor9design\JsonApiFormatter\Interfaces\DataResourceInterface;
use Floor9design\JsonApiFormatter\Interfaces\MetaInterface;

/**
 * Class DataResource
 *
 * Class to offer methods/properties to prepare data for a DataResource
 * These are set to the v1.1 specification, defined at https://jsonapi.org/format/
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
class DataResource implements DataResourceInterface
{
    // properties

    /**
     * @var array<mixed>|null
     */
    public ?array $attributes = null;

    /**
     * @var MetaInterface|null
     */
    public ?MetaInterface $meta = null;

    /**
     * @var string|null
     */
    public ?string $id = null;

    /**
     * @var Relationships|null
     */
    public ?Relationships $relationships = null;

    /**
     * @var string|null
     */
    public ?string $type = null;

    // accessors

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
     * @return DataResourceInterface
     * @see $attributes
     */
    public function setAttributes(?array $attributes): DataResourceInterface
    {
        $this->attributes = $attributes;
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
     * @return DataResourceInterface
     * @see $meta
     */
    public function setMeta(?MetaInterface $meta): DataResourceInterface
    {
        $this->meta = $meta;
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
     * @return DataResourceInterface
     * @see $id
     */
    public function setId(?string $id): DataResourceInterface
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Relationships|null
     * @see $relationships
     */
    public function getRelationships(): ?Relationships
    {
        return $this->relationships;
    }

    /**
     * @param Relationships|null $relationships
     * @return DataResourceInterface
     * @see $relationships
     */
    public function setRelationships(?Relationships $relationships): DataResourceInterface
    {
        $this->relationships = $relationships;
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
     * @return DataResourceInterface
     * @see $type
     */
    public function setType(?string $type): DataResourceInterface
    {
        $this->type = $type;
        return $this;
    }

    // constructor

    /**
     * DataResource constructor.
     * @param string|null $id
     * @param string|null $type
     * @param array<mixed>|null $attributes
     * @param MetaInterface|null $meta
     * @param Relationships|null $relationships
     */
    public function __construct(
        ?string $id = null,
        string $type = null,
        ?array $attributes = null,
        ?MetaInterface $meta = null,
        ?Relationships $relationships = null
    ) {
        $this
            ->setId($id)
            ->setType($type)
            ->setAttributes($attributes)
            ->setMeta($meta)
            ->setRelationships($relationships);
    }

    /**
     * @phpstan-return array{id:string|null,type:string|null,attributes:array<mixed>|null,meta?:array<mixed>|null}
     * @return array
     * @throws JsonApiFormatterException
     */
    public function process(): array
    {
        $this->validate();

        // always return core:
        $array = [
            'id' => $this->getId(),
            'type' => $this->getType(),
            'attributes' => $this->getAttributes()
        ];

        // return Meta if set, else clean
        if (($this->getMeta() instanceof MetaInterface)) {
            $array['meta'] = $this->getMeta()->process();
        }

        // return Meta if set, else clean
        if (($this->getRelationships() instanceof Relationships)) {
            $array['relationships'] = $this->getRelationships()->process();
        }

        return $array;
    }

    /**
     * Validates the DataResource structure
     *
     * @return DataResourceInterface
     * @throws JsonApiFormatterException
     */
    protected function validate(): DataResourceInterface
    {
        if ($this->getType() === null) {
            $message = 'The DataResource was not formed well. ';
            $message .= 'Definition 7.2: A resource object MUST contain at least the following top-level members: type';
            throw new JsonApiFormatterException($message);
        }

        return $this;
    }

}
