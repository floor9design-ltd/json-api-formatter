<?php
/**
 * DataResourceTest.php
 *
 * DataResourceTest class
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
use Floor9design\TestingTools\Exceptions\TestingToolsException;
use Floor9design\TestingTools\Traits\AccessorTesterTrait;
use PHPUnit\Framework\TestCase;

/**
 * DataResourceTest
 *
 * This test file tests the DataResource.
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
class DataResourceTest extends TestCase
{

    use AccessorTesterTrait;

    // Accessors

    /**
     * Test data accessors.
     *
     * @return void
     * @throws TestingToolsException
     */
    public function testDataAccessors()
    {
        $data_resource = new DataResource();

        $this->accessorTestStrings(
            [
                'id' => [],
                'type' => []
            ],
            $data_resource
        );

        $this->accessorTestArrays(
            [
                'attributes' => []
            ],
            $data_resource
        );
    }

    /**
     * Test DataResource::toArray()
     *
     * @return void
     * @throws TestingToolsException
     */
    public function testToArray()
    {
        $data_resource = new DataResource("2", "test", ["hello" => "world"]);

        $this->assertEquals(
            ["id" => "2", "type" => "test", "attributes" => ["hello" => "world"]],
            $data_resource->toArray()
        );
    }

}
