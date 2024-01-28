<?php
/**
 * MetaTest.php
 *
 * MetaTest class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.0
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 *
 */

namespace Floor9design\JsonApiFormatter\Tests\Unit;

use Floor9design\JsonApiFormatter\Models\Meta;
use PHPUnit\Framework\TestCase;

/**
 * MetaTest
 *
 * This test file tests the Meta.
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.0
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 */
class MetaTest extends TestCase
{
    // Accessors

    /**
     * Test meta constructor.
     *
     * @return void
     */
    public function testConstructor()
    {
        $array = ['hello' => 'world'];
        $meta = new Meta($array);
        $this->assertEquals($meta->getMeta()['hello'], 'world');
    }

    /**
     * Test meta constructor.
     *
     * @return void
     */
    public function testProcess()
    {
        $array = ['hello' => 'world'];
        $meta = new Meta($array);
        $this->assertEquals($meta->process(), $array);
    }

}
