<?php
/**
 * IncludedTest.php
 *
 * IncludedTest class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit\Examples\Included
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
use Floor9design\JsonApiFormatter\Interfaces\IncludedInterface;
use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\Included;
use PHPUnit\Framework\TestCase;

/**
 * IncludedTest
 *
 * This test file tests the Included class.
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit\Examples\Included
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.0
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
        $included = new Included([$data_resource]);

        $this->assertEquals([$data_resource], $included->getDataResources());
    }

    /**
     * Test included interfaces.
     *
     * @return void
     */
    public function testInheritance(): void
    {
        $data_resource = new DataResource("2", "test", ["hello" => "world"]);
        $included = new Included([$data_resource]);
        $this->assertInstanceOf(
            IncludedInterface::class,
            $included,
            'The Meta was not an instance of MetaInterface'
        );
    }

    /**
     * Test addDataResource
     *
     * @return void
     */
    public function testAccessors()
    {
        $data_resource = new DataResource("2", "test", ["hello" => "world"]);
        $data_resource2 = new DataResource("2", "test", ["foo" => "bar"]);

        $included = new Included([$data_resource]);
        $included->addDataResource($data_resource2);

        $this->assertEquals([$data_resource, $data_resource2], $included->getDataResources());

        $included->setDataResources([$data_resource2]);
        $this->assertEquals([$data_resource2], $included->getDataResources());
    }

    /**
     * Test unsetDataResource
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testProcess()
    {
        $data_resource = new DataResource("2", "test", ["hello" => "world"]);
        $data_resource2 = new DataResource("2", "test", ["foo" => "bar"]);

        $included = new Included([$data_resource, $data_resource2]);

        $object_array = [$data_resource->process(), $data_resource2->process()];

        $this->assertEquals($object_array, $included->process());
    }

}
