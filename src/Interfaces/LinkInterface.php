<?php
/**
 * LinkInterface.php
 *
 * LinkInterface class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Interfaces
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.3
 * @link      https://www.floor9design.com
 * @since     File available since pre-release development cycle
 *
 */

namespace Floor9design\JsonApiFormatter\Interfaces;

use Floor9design\JsonApiFormatter\Models\Link;

/**
 * Class LinkInterface
 *
 * Interface for Link objects.
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Interfaces
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.3
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     2.0.0
 * @see       Link
 */
interface LinkInterface
{
    /**
     * Process a Link into an array ready for JSON encoding
     *
     * @return array<string,array<mixed>>
     */
    public function process(): array;
}
