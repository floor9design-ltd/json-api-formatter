<?php
/**
 * DataResourceMeta.php
 *
 * DataResourceMeta class
 *
 * php 7.4+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   1.3.1
 * @link      https://www.floor9design.com
 * @since     File available since pre-release development cycle
 *
 */

namespace Floor9design\JsonApiFormatter\Models;

/**
 * Class DataResourceMeta
 *
 * Class to offer methods/properties to prepare data for a DataResourceMeta object
 * These are set to the v1.0 specification, defined at https://jsonapi.org/format/
 *
 * Note this is the same as a Meta, but is included within a DataResource
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   1.3.1
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     File available since pre-release development cycle
 * @see       https://jsonapi.org/format/
 */
class DataResourceMeta
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
     * @return DataResourceMeta
     * @see $meta
     */
    public function setMeta(array $meta): DataResourceMeta
    {
        $this->meta = $meta;
        return $this;
    }


    // constructor

    /**
     * DataResourceMeta constructor.
     * Automatically sets up the provided array as properties
     * @phpstan-param array<object|string|int|null>|null $array
     * @param array|null $array
     */
    public function __construct(?array $array = [])
    {
        if(is_iterable($array)) {
            $this->setMeta($array);
        }
    }

    /**
     * @return array<int|object|string|null>
     */
    public function process(): array
    {
        return $this->getMeta();
    }

}
