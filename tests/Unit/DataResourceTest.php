<?php
/**
 * DataResourceTest.php
 *
 * DataResourceTest class
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

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;
use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\Meta;
use Floor9design\JsonApiFormatter\Models\Relationship;
use Floor9design\JsonApiFormatter\Models\RelationshipData;
use Floor9design\JsonApiFormatter\Models\RelationshipLinks;
use Floor9design\JsonApiFormatter\Models\Relationships;
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
 * @version   2.0.0
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

        $array = ['hello' => 'world'];
        $meta = new Meta($array);
        $data_resource->setMeta($meta);
        $this->assertEquals($meta, $data_resource->getMeta());

        $links = new RelationshipLinks();
        $data = new RelationshipData();
        $meta = new Meta();

        $relationships = new Relationships([new Relationship($links, $data, $meta)]);
        $data_resource->setRelationships($relationships);
        $this->assertEquals($relationships, $data_resource->getRelationships());
    }

    /**
     * Test DataResource::process()
     *
     * @return void
     */
    public function testProcess()
    {
        $data_resource = new DataResource(
            "2",
            "test",
            ["hello" => "world"]
        );

        // data resource meta

        $this->assertEquals(
            ["id" => "2", "type" => "test", "attributes" => ["hello" => "world"]],
            $data_resource->process(),
            'Basic data resource toArray failed'
        );

        $array = ['hello' => 'world'];
        $meta = new Meta($array);
        $data_resource->setMeta($meta);

        $this->assertEquals(
            [
                "id" => "2",
                "type" => "test",
                "attributes" => ["hello" => "world"],
                "meta" => $array
            ],
            $data_resource->process(),
            'Data resource with meta toArray failed'
        );

        // data resource meta with relationships

        $links = new RelationshipLinks();
        $data = new RelationshipData();
        $meta = new Meta();

        $relationships = new Relationships([new Relationship($links, $data, $meta)]);
        $data_resource->setRelationships($relationships);

        $array = ['hello' => 'world'];
        $meta = new Meta($array);
        $data_resource->setMeta($meta);

        $this->assertEquals(
            [
                "id" => "2",
                "type" => "test",
                "attributes" => ["hello" => "world"],
                "meta" => $array,
                "relationships" => $relationships->process()
            ],
            $data_resource->process(),
            'Data resource with meta and relationships toArray failed'
        );
    }

    /**
     * Test DataResource::validate() with no type
     *
     * @return void
     */
    public function testValidateNoType()
    {
        $data_resource = new DataResource();
        $message = 'The DataResource was not formed well. ';
        $message .= 'Definition 7.2: A resource object MUST contain at least the following top-level members: type';

        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage($message);
        $data_resource->process();
    }
}
