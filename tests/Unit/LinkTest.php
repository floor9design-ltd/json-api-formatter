<?php
/**
 * LinkTest.php
 *
 * LinkTest class
 *
 * php 7.4+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   1.0
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 *
 */

namespace Floor9design\JsonApiFormatter\Tests\Unit;

use Floor9design\JsonApiFormatter\Models\Link;
use PHPUnit\Framework\TestCase;

/**
 * LinkTest
 *
 * This test file tests the Link.
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   1.0
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 */
class LinkTest extends TestCase
{
    // Accessors

    /**
     * Test link constructor.
     *
     * @return void
     */
    public function testConstructor()
    {
        $array = ['hello' => 'world'];
        $link = new Link($array);
        $this->assertEquals($link->hello, 'world');
    }

    /**
     * Test link constructor.
     *
     * @return void
     */
    public function testToArray()
    {
        $array = ['hello' => 'world'];
        $link = new Link($array);
        $this->assertEquals($link->toArray(), $array);
    }

}
