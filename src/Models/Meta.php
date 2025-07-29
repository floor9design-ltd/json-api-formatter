<?php
/**
 * Meta.php
 *
 * Meta class
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

use Floor9design\JsonApiFormatter\Interfaces\MetaInterface;

/**
 * Class Meta
 *
 * Class to offer methods/properties to prepare data for a Meta object
 * These are set to the v1.1 specification, defined at https://jsonapi.org/format/
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
 * @link      https://jsonapi.org/format/#document-meta
 * @since     File available since pre-release development cycle
 */
class Meta implements MetaInterface
{
    // properties

    /**
     * @var array<mixed>
     */
    protected array $meta = [];

    // accessors

    /**
     * @return array<mixed>
     * @see $meta
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /**
     * @param array<mixed> $meta
     * @return Meta
     * @see $meta
     */
    public function setMeta(array $meta): Meta
    {
        $this->meta = $meta;
        return $this;
    }

    // constructor

    /**
     * Meta constructor.
     * Automatically sets up the provided array as properties
     * @param array<mixed>|null $array
     */
    public function __construct(?array $array = [])
    {
        if (is_iterable($array)) {
            $this->setMeta($array);
        }
    }

    /**
     * @return array<mixed>
     */
    public function process(): array
    {
        return $this->getMeta();
    }

}
