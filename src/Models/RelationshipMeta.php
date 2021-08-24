<?php
/**
 * RelationshipMeta.php
 *
 * RelationshipMeta class
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

use stdClass;

/**
 * Class RelationshipMeta
 *
 * Class to offer methods/properties to prepare data for a RelationshipMeta object
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
class RelationshipMeta
{
    /**
     * @var array<object|string|int|null>
     */
    protected array $meta = [];

    /**
     * @return array<object|string|int|null>
     * @see $meta
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /**
     * @param array<object|string|int|null> $meta
     * @return RelationshipMeta
     * @see $meta
     */
    public function setMeta(array $meta): RelationshipMeta
    {
        $this->meta = $meta;
        return $this;
    }

    // constructor

    /**
     * RelationshipMeta constructor.
     * Automatically sets up the provided array as properties
     * @param array<object|string|int|null>|null $array
     */
    public function __construct(?array $array = [])
    {
        if(is_iterable($array)) {
            foreach ($array as $property => $value) {
                $this->meta[$property] = $value;
            }
        }
    }

    /**
     * @return stdClass a stdClass cleaned object suitable for encoding
     */
    public function process(): stdClass
    {
        $array = [];
        return (object)$this->getMeta();
    }

}
