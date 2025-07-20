<?php
/**
 * SourceInterface.php
 *
 * SourceInterface class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Interfaces
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.1
 * @link      https://www.floor9design.com
 * @since     2.0.1
 *
 */

namespace Floor9design\JsonApiFormatter\Interfaces;

use Floor9design\JsonApiFormatter\Models\Source;

/**
 * Class SourceInterface
 *
 * Interface for Source objects.
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Interfaces
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.1
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     2.0.1
 * @see       Source
 */
interface SourceInterface
{
    /**
     * Process a Link into an array ready for json encoding
     *
     * @return array<string>
     */
    public function process(): array;

}
