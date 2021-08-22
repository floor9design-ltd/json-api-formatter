<?php
/**
 * Included.php
 *
 * Included class
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
 * Class Included
 *
 * Class to offer methods/properties to prepare data for an Included object
 * These are set to the v1.0 specification, defined at https://jsonapi.org/format/
 *
 * Note: included should be populated by DataResource objects
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
class Included
{
    // constructor

    /**
     * Included constructor.
     * Automatically sets up the provided array as properties
     * @phpstan-param array<DataResource>|null $array
     * @param array|null $array
     */
    public function __construct(?array $array = [])
    {
        if (is_iterable($array)) {
            foreach ($array as $name => $data_resource) {
                $this->addDataResource($name, $data_resource);
            }
        }
    }

    /**
     * @param string $name
     * @param DataResource $data_resource
     * @return Included
     */
    public function addDataResource(string $name, DataResource $data_resource): Included
    {
        $this->$name = $data_resource;
        return $this;
    }

    /**
     * @param string $name
     * @return Included
     */
    public function unsetDataResource(string $name): Included
    {
        unset($this->$name);
        return $this;
    }

    /**
     * @return array[]
     */
    public function toArray(): array
    {
        return (array)$this;
    }

}
