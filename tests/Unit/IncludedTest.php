<?php
/**
 * IncludedTest.php
 *
 * IncludedTest class
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

use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\Included;
use Floor9design\TestingTools\Exceptions\TestingToolsException;
use PHPUnit\Framework\TestCase;

/**
 * IncludedTest
 *
 * This test file tests the Included class.
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
class IncludedTest extends TestCase
{
    // Accessors

    /**
     * Test included constructor.
     *
     * @return void
     */
    public function testConstructor()
    {
        $data_resource = new DataResource("2", "test", ["hello" => "world"]);
        $included = new Included(['test' => $data_resource]);

        $this->assertEquals($data_resource, $included->test);
    }

    /**
     * Test addDataResource
     *
     * @return void
     */
    public function testAddDataResource()
    {
        $data_resource = new DataResource("2", "test", ["hello" => "world"]);
        $data_resource2 = new DataResource("2", "test", ["foo" => "bar"]);

        $included = new Included(['first' => $data_resource]);
        $included->addDataResource('second', $data_resource2);

        $this->assertEquals($data_resource, $included->first);
        $this->assertEquals($data_resource2, $included->second);
    }

    /**
     * Test unsetDataResource
     *
     * @return void
     */
    public function testUnsetDataResource()
    {
        $data_resource = new DataResource("2", "test", ["hello" => "world"]);
        $data_resource2 = new DataResource("2", "test", ["foo" => "bar"]);

        $included = new Included(['first' => $data_resource, 'second' => $data_resource2]);

        $included->unsetDataResource('first');

        $this->assertEquals($data_resource2, $included->second);
        $this->assertFalse(property_exists($included, 'first'));
    }

    /**
     * Test unsetDataResource
     *
     * @return void
     * @throws TestingToolsException
     */
    public function testToArray()
    {
        $data_resource = new DataResource("2", "test", ["hello" => "world"]);
        $data_resource2 = new DataResource("2", "test", ["foo" => "bar"]);

        $included = new Included(['first' => $data_resource, 'second' => $data_resource2]);

        $object_array = [
            'first' => $data_resource,
            'second' => $data_resource2
        ];

        $this->assertEquals($object_array, $included->toArray());
    }

}
