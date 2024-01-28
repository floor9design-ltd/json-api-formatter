<?php
/**
 * RelationshipLinks.php
 *
 * RelationshipLinks class
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
use stdClass;

/**
 * Class RelationshipLinks
 *
 * Class to offer methods/properties to prepare data for a RelationshipLinks object
 * These are set to the v1.0 specification, defined at https://jsonapi.org/format/
 *
 * Note: links should be populated by either a Link object or a string
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
class RelationshipLinks
{
    /**
     * @var array<Link|string>
     */
    protected array $links = [];

    /**
     * @return array<Link|string>
     * @see $links
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    // constructor

    /**
     * RelationshipLinks constructor.
     * Automatically sets up the provided array as properties
     * @phpstan-param array<Link|string>|null $array
     * @param array|null $array
     * @throws JsonApiFormatterException
     */
    public function __construct(?array $array = [])
    {
        if (is_iterable($array)) {
            foreach ($array as $name => $link) {
                $this->addLink($name, $link);
            }
        }
    }

    /**
     * @param string $name
     * @param string|Link $link
     * @return RelationshipLinks
     * @throws JsonApiFormatterException
     */
    public function addLink(string $name, $link): RelationshipLinks
    {
        // validate:
        $this->validateProperty($link);
        $this->links[$name] = $link;

        return $this;
    }

    /**
     * @param string $name
     * @return RelationshipLinks
     */
    public function unsetLink(string $name): RelationshipLinks
    {
        unset($this->links[$name]);
        return $this;
    }

    /**
     * @param mixed|Link|string $value
     * @return bool
     * @throws JsonApiFormatterException
     */
    private function validateProperty($value): bool
    {
        if (
            !($value instanceof Link || is_string($value))
        ) {
            throw new JsonApiFormatterException('RelationshipLinks can only be populated with strings or Link objects');
        }

        return true;
    }

    /**
     * @return stdClass a stdClass cleaned object suitable for encoding
     */
    public function process(): stdClass
    {
        $array = [];
        foreach ($this->getLinks() as $key => $link) {
            if (is_string($link)) {
                $array[$key] = $link;
            } else {
                $array[$key] = $link->process();
            }
        }

        return (object)$array;
    }
}
