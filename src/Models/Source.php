<?php
/**
 * Source.php
 *
 * Source class
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
 * Class Source
 *
 * Class to offer methods/properties to prepare data for a Source object
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
class Source
{
    /**
     * @var array<string|array<int|float|string>|stdClass>
     */
    protected array $source = [];

    // accessors

    /**
     * @return array<string|array<int|float|string>|stdClass>
     * @see $source
     */
    public function getSource(): array
    {
        return $this->source;
    }

    /**
     * @param array<string|array<int|float|string>> $source
     * @return Source
     * @see $source
     */
    public function setSource(array $source): Source
    {
        // @todo : implement validateSourceArray()
        // = $this->validateSourceArray($source);
        $this->source = $source;
        return $this;
    }

    // constructor

    /**
     * Source constructor.
     * Automatically sets up the provided array as properties
     * @phpstan-param array<array<int|float|string>|string>|null $array
     * @param array|null $array
     * @throws JsonApiFormatterException
     */
    public function __construct(?array $array = [])
    {
        if(is_array($array)) {
            $this->setSource($array);
        }
    }

    /**
     * @return array<string|array<int|float|string>|stdClass>
     */
    public function process(): array
    {
        return $this->getSource();
    }

}
