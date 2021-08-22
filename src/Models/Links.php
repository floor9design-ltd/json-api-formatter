<?php
/**
 * Links.php
 *
 * Links class
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

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;

/**
 * Class Links
 *
 * Class to offer methods/properties to prepare data for a Links object
 * These are set to the v1.0 specification, defined at https://jsonapi.org/format/
 *
 * Note: links should be populated by either a Link object or a string
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
class Links
{
    // constructor

    /**
     * Links constructor.
     * Automatically sets up the provided array as properties
     * @phpstan-param array<Link|string>|null $array
     * @param array|null $array
     * @throws JsonApiFormatterException
     */
    public function __construct(?array $array = [])
    {
        if(is_iterable($array)) {
            foreach ($array as $name => $link) {
                $this->addLink($name, $link);
            }
        }
    }

    /**
     * @param string $name
     * @param string|Link $link
     * @return Links
     * @throws JsonApiFormatterException
     */
    public function addLink(string $name, $link): Links
    {
        // validate:
        $this->validateProperty($link);
        $this->$name = $link;

        return $this;
    }

    /**
     * @param string $name
     * @return Links
     */
    public function unsetLink(string $name): Links
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
            throw new JsonApiFormatterException('Links can only be populated with strings or Link objects');
        }

        return true;
    }

}
