<?php
/**
 * Relationships.php
 *
 * Relationships class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.3
 * @link      https://www.floor9design.com
 * @since     File available since pre-release development cycle
 *
 */

namespace Floor9design\JsonApiFormatter\Models;

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;
use Floor9design\JsonApiFormatter\Interfaces\RelationshipInterface;
use Floor9design\JsonApiFormatter\Interfaces\RelationshipsInterface;

/**
 * Class Relationships
 *
 * Class to offer methods/properties to prepare data for a Relationships object
 * These are set to the v1.1 specification, defined at https://jsonapi.org/format/
 *
 * NoteRelationshipsInterface should be populated by a Relationship object
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.3
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     File available since pre-release development cycle
 * @see       https://jsonapi.org/format/
 */
class Relationships implements RelationshipsInterface
{
    // properties

    /**
     * @var array<RelationshipInterface>
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
     * @return RelationshipsInterface
     * @see $relationships
     */
    public function setRelationships(array $relationships): RelationshipsInterface
    {
        $this->relationships = $relationships;
        return $this;
    }

    // constructor

    /**
     * Relationships constructor.
     * Automatically sets up the provided array as properties
     * @param array<Relationship|array<Relationship>>|null $array
     * @throws JsonApiFormatterException
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
     * @param RelationshipInterface|array<RelationshipInterface> $relationship
     * @return RelationshipsInterface
     * @throws JsonApiFormatterException
     */
    public function addRelationship(string $name, Relationship|array $relationship): RelationshipsInterface
    {
        if (is_array($relationship)) {
            foreach ($relationship as $name => $relationship_item) {
                if (!$relationship_item instanceof RelationshipInterface) {
                    throw new JsonApiFormatterException('Relationships consist of Relationship objects.');
                }
            }
        }

        $this->relationships[$name] = $relationship;
        return $this;
    }

    /**
     * @param string $name
     * @return RelationshipsInterface
     */
    public function unsetRelationship(string $name): RelationshipsInterface
    {
        unset($this->relationships[$name]);
        return $this;
    }

    /**
     * @return array<mixed>
     * @throws JsonApiFormatterException
     */
    public function process(): array
    {
        $array = [];
        foreach ($this->getRelationships() as $key => $relationship) {
            if (is_array($relationship)) {
                $relationship_array = [];
                foreach ($relationship as $name => $relationship_item) {
                    $relationship_array[$name] = $relationship_item->process();
                }
            } else {
                $array[$key] = $relationship->process();
            }
        }
        return $array;
    }

}
