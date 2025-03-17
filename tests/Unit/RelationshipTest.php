<?php
/**
 * RelationshipTest.php
 *
 * RelationshipTest class
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
use Floor9design\JsonApiFormatter\Models\Links;
use Floor9design\JsonApiFormatter\Models\Meta;
use Floor9design\JsonApiFormatter\Models\Relationship;
use PHPUnit\Framework\TestCase;

/**
 * RelationshipTest
 *
 * This test file tests the Relationship class.
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
class RelationshipTest extends TestCase
{
    // Accessors

    /**
     * Test accessors
     */
    public function testAccessors()
    {
        $relationship = new Relationship();

        $links = new Links();
        $relationship->setLinks($links);
        $this->assertEquals($links, $relationship->getLinks());

        $data = new DataResource();
        $relationship->setData($data);
        $this->assertEquals($data, $relationship->getData());

        $meta = new Meta();
        $relationship->setMeta($meta);
        $this->assertEquals($meta, $relationship->getMeta());
    }

    /**
     * Test link constructor.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testConstructor()
    {
        $data = new DataResource();
        $links = new Links();
        $meta = new Meta();

        $relationship = new Relationship($data, $links, $meta);

        $this->assertEquals($links, $relationship->getLinks());
        $this->assertEquals($data, $relationship->getData());
        $this->assertEquals($meta, $relationship->getMeta());
    }

    /**
     * Test meta constructor.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testProcess()
    {
        $links = new Links();
        $data = new DataResource('0', 'test');
        $meta = new Meta();

        $array = [
            'links' => $links->process(),
            'data' => $data->process(),
            'meta' => $meta->process()
        ];

        $relationship = new Relationship($data, $links, $meta);

        $this->assertEquals($array, $relationship->process());
    }
}
