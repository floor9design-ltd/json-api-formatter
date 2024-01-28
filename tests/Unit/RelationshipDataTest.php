<?php
/**
 * RelationshipDataTest.php
 *
 * RelationshipDataTest class
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

use Floor9design\JsonApiFormatter\Models\DataResourceMeta;
use Floor9design\JsonApiFormatter\Models\RelationshipData;
use Floor9design\TestingTools\Exceptions\TestingToolsException;
use Floor9design\TestingTools\Traits\AccessorTesterTrait;
use PHPUnit\Framework\TestCase;

/**
 * RelationshipDataTest
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
class RelationshipDataTest extends TestCase
{

    use AccessorTesterTrait;

    // Accessors

    /**
     * Test accessors.
     *
     * @return void
     * @throws TestingToolsException
     */
    public function testAccessors()
    {
        $relationship_data = new RelationshipData();

        $this->accessorTestStrings(
            [
                'id' => [],
                'type' => []
            ],
            $relationship_data
        );

        $array = ['hello' => 'world'];
        $relationship_data_meta = new DataResourceMeta($array);
        $relationship_data->setDataResourceMeta($relationship_data_meta);
        $this->assertEquals($relationship_data_meta, $relationship_data->getDataResourceMeta());
    }

    /**
     * Test RelationshipData::process()
     *
     * @return void
     */
    public function testProcess()
    {
        $relationship_data = new RelationshipData(
            "2",
            "test"
        );

        // data resource meta

        $this->assertEquals(
            (object)["id" => "2", "type" => "test"],
            $relationship_data->process(),
            'Basic data resource toArray failed'
        );

        $array = ['hello' => 'world'];
        $relationship_data_meta = new DataResourceMeta($array);
        $relationship_data->setDataResourceMeta($relationship_data_meta);

        $this->assertEquals(
            (object)[
                "id" => "2",
                "type" => "test",
                "meta" => $array
            ],
            $relationship_data->process(),
            'Data resource with meta toArray failed'
        );
    }

}
