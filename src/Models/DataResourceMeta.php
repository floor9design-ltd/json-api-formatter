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
 * @version   0.5.0
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
 * @version   0.5.0
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     File available since pre-release development cycle
 * @see       https://jsonapi.org/format/
 */
class DataResourceMeta
{
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
            foreach ($array as $property => $value) {
                $this->$property = $value;
            }
        }
    }

    /**
     * @return array[]
     */
    public function toArray(): array
    {
        return (array)$this;
    }

}
