<?php
/**
 * Links.php
 *
 * Links class
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
use Floor9design\JsonApiFormatter\Interfaces\LinkInterface;
use Floor9design\JsonApiFormatter\Interfaces\LinksInterface;

/**
 * Class Links
 *
 * Class to offer methods/properties to prepare data for a Links object
 * These are set to the v1.1 specification, defined at https://jsonapi.org/format/
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
class Links implements LinksInterface
{
    /**
     * @var array<string|Link>
     */
    protected array $links = [];

    /**
     * @return array<string|LinkInterface>
     * @see $links
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @param array<string|LinkInterface> $links
     * @return Links
     * @see $links
     */
    public function setLinks(array $links): LinksInterface
    {
        $this->links = $links;
        return $this;
    }

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
        if (is_iterable($array)) {
            foreach ($array as $name => $link) {
                $this->addLink($name, $link);
            }
        }
    }

    /**
     * @param string $name
     * @param string|LinkInterface|null $link
     * @param bool $overwrite
     * @return LinksInterface
     * @throws JsonApiFormatterException
     */
    public function addLink(string $name, string|LinkInterface|null $link, bool $overwrite = false): LinksInterface
    {
        if (isset($this->getLinks()[$name]) && !$overwrite) {
            $message = 'The link provided clashes with existing links - it should be added manually';
            throw new JsonApiFormatterException($message);
        }

        $this->links[$name] = $link;

        return $this;
    }

    /**
     * @param string $name
     * @return LinksInterface
     */
    public function unsetLink(string $name): LinksInterface
    {
        unset($this->links[$name]);
        return $this;
    }

    /**
     * @return array<array<string, array|string|null>|string>
     * @throws JsonApiFormatterException
     */
    public function process(): array
    {
        $array = [];

        foreach ($this->getLinks() as $key => $link) {
            if ($link instanceof LinkInterface) {
                $array[$key] = $link->process();
            } elseif (is_string($link)) {
                $array[$key] = $link;
            }
        }

        return $array;
    }

}
