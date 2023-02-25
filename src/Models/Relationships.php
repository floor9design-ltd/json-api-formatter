<?php
/**
 * Relationships.php
 *
 * Relationships class
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

use stdClass;

/**
 * Class Relationships
 *
 * Class to offer methods/properties to prepare data for a Relationships object
 * These are set to the v1.0 specification, defined at https://jsonapi.org/format/
 *
 * Note: Relationships should be populated by a Relationship object
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
class Relationships
{
    // properties

    /**
     * @var array<Relationship>
     */
    protected array $relationships = [];

    // accessors

    /**
     * @return array<Relationship>
     * @see $relationships
     */
    public function getRelationships(): array
    {
        return $this->relationships;
    }

    /**
     * @param array<Relationship> $relationships
     * @return Relationships
     * @see $relationships
     */
    public function setRelationships(array $relationships): Relationships
    {
        $this->relationships = $relationships;
        return $this;
    }

    // constructor

    /**
     * Relationships constructor.
     * Automatically sets up the provided array as properties
     * @param array<Relationship>|null $array
     */
    public function __construct(?array $array = [])
    {
        if (is_iterable($array)) {
            foreach ($array as $name => $relationship) {
                $this->addRelationship($name, $relationship);
            }
        }
    }

    /**
     * @param string $name
     * @param Relationship $relationship
     * @return Relationships
     */
    public function addRelationship(string $name, Relationship $relationship): Relationships
    {
        $this->relationships[$name] = $relationship;
        return $this;
    }

    /**
     * @param string $name
     * @return Relationships
     */
    public function unsetRelationship(string $name): Relationships
    {
        unset($this->relationships[$name]);
        return $this;
    }

    /**
     * @return stdClass a stdClass cleaned object suitable for encoding
     */
    public function process(): stdClass
    {
        $array = [];
        foreach ($this->getRelationships() as $key => $relationship) {
            $array[$key] = $relationship->process();
        }

        return (object)$array;
    }

}
