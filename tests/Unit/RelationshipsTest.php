<?php
/**
 * RelationshipsTest.php
 *
 * RelationshipsTest class
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
use Floor9design\JsonApiFormatter\Interfaces\RelationshipsInterface;
use Floor9design\JsonApiFormatter\Models\Meta;
use Floor9design\JsonApiFormatter\Models\Relationship;
use Floor9design\JsonApiFormatter\Models\RelationshipData;
use Floor9design\JsonApiFormatter\Models\RelationshipLinks;
use Floor9design\JsonApiFormatter\Models\Relationships;
use PHPUnit\Framework\TestCase;

/**
 * RelationshipsTest
 *
 * This test file tests the Relationships class.
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
class RelationshipsTest extends TestCase
{
    /**
     * Test accessors.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testAccessors()
    {
        $links = new RelationshipLinks(['test' => 'link']);
        $data = new RelationshipData("2", "test");
        $meta = new Meta();

        $relationship = new Relationship($links, $data, $meta);

        $relationships = new Relationships();
        $relationships->setRelationships(['test' => $relationship]);

        $this->assertEquals($relationship, $relationships->getRelationships()['test']);
    }

    /**
     * Test Relationships constructor.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testConstructor()
    {
        $links = new RelationshipLinks(['test' => 'link']);
        $data = new RelationshipData("2", "test");
        $meta = new Meta();

        $relationship = new Relationship($links, $data, $meta);

        $relationships = new Relationships(['test' => $relationship]);

        $this->assertEquals($relationship, $relationships->getRelationships()['test']);
    }

    /**
     * Test Relationships interfaces.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testInheritance(): void
    {
        $links = new RelationshipLinks(['test' => 'link']);
        $data = new RelationshipData("2", "test");
        $meta = new Meta();

        $relationship = new Relationship($links, $data, $meta);

        $relationships = new Relationships(['test' => $relationship]);

        $this->assertInstanceOf(
            RelationshipsInterface::class,
            $relationships,
            'The Relationships was not an instance of RelationshipsInterface'
        );
    }

    /**
     * Test addRelationships
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testAddRelationships()
    {
        $links = new RelationshipLinks(['test' => 'link']);
        $data = new RelationshipData("2", "test");
        $meta = new Meta();

        $relationship = new Relationship($links, $data, $meta);

        $links2 = new RelationshipLinks(['test' => 'link2']);
        $data2 = new RelationshipData("3", "test");
        $meta2 = new Meta();

        $relationship2 = new Relationship($links2, $data2, $meta2);

        $relationships = new Relationships(['test1' => $relationship]);
        $relationships->addRelationship('test2', $relationship2);

        $this->assertEquals($relationship, $relationships->getRelationships()['test1']);
        $this->assertEquals($relationship2, $relationships->getRelationships()['test2']);

        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('Relationships consist of Relationship objects.');
        $relationships->addRelationship('test3', [['bad-array']]);
    }

    /**
     * Test addRelationships
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testAddRelationshipArray()
    {
        $links = new RelationshipLinks(['test' => 'link']);
        $data = new RelationshipData("2", "test");
        $meta = new Meta();

        $relationship = new Relationship($links, $data, $meta);

        $links2 = new RelationshipLinks(['test' => 'link2']);
        $data2 = new RelationshipData("3", "test");
        $meta2 = new Meta();

        $relationship2 = new Relationship($links2, $data2, $meta2);

        $relationships = new Relationships(['test' => [$relationship, $relationship2]]);

        $this->assertEquals(
            [$relationship, $relationship2],
            $relationships->getRelationships()['test']
        );
    }

    /**
     * Test unsetRelationships
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testUnsetRelationships()
    {
        $links = new RelationshipLinks(['test' => 'link']);
        $data = new RelationshipData("2", "test");
        $meta = new Meta();

        $relationship = new Relationship($links, $data, $meta);

        $links2 = new RelationshipLinks(['test' => 'link2']);
        $data2 = new RelationshipData("3", "test");
        $meta2 = new Meta();

        $relationship2 = new Relationship($links2, $data2, $meta2);

        $relationships = new Relationships(
            [
                'test1' => $relationship,
                'test2' => $relationship2
            ]
        );

        $relationships->unsetRelationship('test2');

        $this->assertEquals($relationship, $relationships->getRelationships()['test1']);
        $this->assertFalse(property_exists($relationships, 'test2'));
    }

    /**
     * Test process()
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testProcess()
    {
        $links = new RelationshipLinks(['test' => 'link']);
        $data = new RelationshipData("2", "test");
        $meta = new Meta();

        $relationship = new Relationship($links, $data, $meta);

        $links2 = new RelationshipLinks(['test' => 'link2']);
        $data2 = new RelationshipData("3", "test");
        $meta2 = new Meta();

        $relationship2 = new Relationship($links2, $data2, $meta2);

        $relationships = new Relationships(
            [
                'test1' => $relationship,
                'test2' => $relationship2
            ]
        );


        $object_array = [
            'test1' => $relationship->process(),
            'test2' => $relationship2->process()
        ];

        $this->assertEquals($object_array, $relationships->process());
    }
}
