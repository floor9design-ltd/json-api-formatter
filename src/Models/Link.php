<?php
/**
 * Link.php
 *
 * Link class
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
use stdClass;

/**
 * Class Link
 *
 * Class to offer methods/properties to prepare data for a Link object
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
class Link
{
    /**
     * @var array<string|array<int|float|string>|stdClass>
     */
    protected array $link = [];

    // accessors

    /**
     * @return array<string|array<int|float|string>|stdClass>
     * @see $link
     */
    public function getLink(): array
    {
        return $this->link;
    }

    /**
     * @param array<string|array<int|float|string>> $link
     * @return Link
     * @throws JsonApiFormatterException
     * @see $link
     */
    public function setLink(array $link): Link
    {
        $this->link = $this->validateLinkArray($link);
        return $this;
    }

    // constructor

    /**
     * Link constructor.
     * Automatically sets up the provided array as properties
     * @phpstan-param array<array<int|float|string>|string>|null $array
     * @param array|null $array
     * @throws JsonApiFormatterException
     */
    public function __construct(?array $array = [])
    {
        if(is_array($array)) {
            $this->setLink($array);
        }
    }

    /**
     * Validates the link
     *
     * @param array<array<int|float|string>|string> $link
     * @return array<string, stdClass|string>
     * @throws JsonApiFormatterException
     */
    protected function validateLinkArray(array $link): array
    {
        // link object must contain href and it must be a string
        if(
            isset($link['href']) &&
            is_string($link['href'])
        ) {
            $processed['href'] = $link['href'];

            // link object must contain href
            if(
                isset($link['meta']) &&
                is_array($link['meta'])
                ){
                // convert the provided array into a stdClass
                $processed['meta'] = (object)$link['meta'];
            }
        } else {
            $message = 'The provided link data should be an array containing the key href';
            throw new JsonApiFormatterException($message);
        }
        return $processed;
    }

    /**
     * @return array<string|array<int|float|string>|stdClass>
     */
    public function process(): array
    {
        return $this->getLink();
    }

}
