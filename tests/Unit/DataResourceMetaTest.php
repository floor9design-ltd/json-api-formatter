<?php
/**
 * DataResourceMetaTest.php
 *
 * DataResourceMetaTest class
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

use Floor9design\JsonApiFormatter\Models\DataResourceMeta;
use PHPUnit\Framework\TestCase;

/**
 * DataResourceMetaTest
 *
 * This test file tests the DataResourceMeta.
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
class DataResourceMetaTest extends TestCase
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
        $data_resource_meta = new DataResourceMeta($array);
        $this->assertEquals($data_resource_meta->getMeta()['hello'], 'world');
    }

    /**
     * Test meta constructor.
     *
     * @return void
     */
    public function testProcess()
    {
        $array = ['hello' => 'world'];
        $data_resource_meta = new DataResourceMeta($array);
        $this->assertEquals($data_resource_meta->process(), $array);
    }

}
