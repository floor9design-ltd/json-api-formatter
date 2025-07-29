<?php
/**
 * ErrorInterface.php
 *
 * ErrorInterface class
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
 * @since     2.0.0
 *
 */

namespace Floor9design\JsonApiFormatter\Interfaces;

use Floor9design\JsonApiFormatter\Models\Error;

/**
 * Class ErrorInterface
 *
 * Interface for Error objects.
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
 * @see       Error
 */
interface ErrorInterface
{
    /**
     * Process a Link into an array ready for json encoding
     *
     * @return array<mixed>
     */
    public function process(): array;

}
