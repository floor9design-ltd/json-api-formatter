<?php
/**
 * DataResourceInterface.php
 *
 * DataResourceInterface class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Interfaces
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.2
 * @link      https://www.floor9design.com
 * @since     2.0.0
 *
 */

namespace Floor9design\JsonApiFormatter\Interfaces;

use Floor9design\JsonApiFormatter\Models\DataResource;

/**
 * Class DataResourceInterface
 *
 * Interface for DataResource objects.
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Interfaces
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.2
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     2.0.0
 * @see       DataResource
 */
interface DataResourceInterface
{
    /**
     * Process a Link into an array ready for json encoding
     *
     * @return array<mixed>
     */
    public function process(): array;

}
