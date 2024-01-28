<?php
/**
 * Included.php
 *
 * Included class
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
 * @version   2.0.0
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     File available since pre-release development cycle
 * @see       https://jsonapi.org/format/
 */
class Included
{
    /**
     * @var array<DataResource>
     */
    var array $data_resources = [];

    /**
     * @return array<DataResource>
     * @see $data_resources
     */
    public function getDataResources(): array
    {
        return $this->data_resources;
    }

    /**
     * @param array<DataResource> $data_resources
     * @return Included
     * @see $data_resources
     */
    public function setDataResources(array $data_resources): Included
    {
        $this->data_resources = $data_resources;
        return $this;
    }

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
            foreach ($array as $data_resource) {
                $this->addDataResource($data_resource);
            }
        }
    }

    /**
     * @param DataResource $data_resource
     * @return Included
     */
    public function addDataResource(DataResource $data_resource): Included
    {
        $this->data_resources[] = $data_resource;
        return $this;
    }

    /**
     * @return array<array{id:string|null,type:string|null,attributes:array<mixed>|null,meta?:array<mixed>|null}>
     */
    public function process(): array
    {
        $array = [];

        foreach($this->getDataResources() as $data_resource){
            $array[] = $data_resource->process();
        }

        return $array;
    }

}
