<?php
/**
 * ErrorTest.php
 *
 * ErrorTest class
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

use Floor9design\JsonApiFormatter\Models\Error;
use Floor9design\JsonApiFormatter\Models\Links;
use Floor9design\TestDataGenerator\Generator;
use Floor9design\TestingTools\Exceptions\TestingToolsException;
use Floor9design\TestingTools\Traits\AccessorTesterTrait;
use PHPUnit\Framework\TestCase;
use StdClass;

/**
 * ErrorTest
 *
 * This test file tests the Error.
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
class ErrorTest extends TestCase
{
    use AccessorTesterTrait;

    // Accessors

    /**
     * Test data accessors.
     *
     * @return void
     * @throws TestingToolsException
     */
    public function testBasicAccessors()
    {
        $error = new Error();

        $this->accessorTestStrings(
            [
                'id' => [],
                'status' => [],
                'code' => [],
                'title' => [],
                'detail' => []
            ],
            $error
        );

        $links = new Links();
        $error->setLinks($links);
        $this->assertEquals($links, $error->getLinks());

        $source = new StdClass();
        $error->setSource($source);
        $this->assertEquals($source, $error->getSource());
    }

    /**
     * Test Error::process()
     *
     * @return void
     */
    public function testProcess()
    {
        $generator = new Generator();

        $array = [
            'id' => $generator->randomString(),
            'links' => new Links(),
            'status' => $generator->randomString(),
            'code' => $generator->randomString(),
            'title' => $generator->randomString(),
            'detail' => $generator->randomString(),
            'source' => new StdClass,
        ];

        $error = new Error(
            $array['id'],
            $array['links'],
            $array['status'],
            $array['code'],
            $array['title'],
            $array['detail'],
            $array['source']
        );

        $this->assertEquals($error->process(), $array);
    }

    /**
     * Test Error::toArray
     *
     * @return void
     */
    public function testProcessNullProperties()
    {
        $generator = new Generator();

        $array = [
            'id' => $generator->randomString(),
            'links' => new Links(),
            'status' => $generator->randomString(),
            'code' => $generator->randomString(),
            'title' => $generator->randomString(),
            'detail' => $generator->randomString(),
            'source' => new StdClass,
        ];

        $error = new Error(
            $array['id'],
            $array['links'],
            $array['status'],
            $array['code'],
            $array['title'],
            $array['detail'],
            $array['source']
        );

        // should do nothing
        $this->assertEquals($error->process(), $array);

        // remove one by one, then check
        $error->setId(null);
        $this->assertArrayNotHasKey('id', $error->process());
        $error->setLinks(null);
        $this->assertArrayNotHasKey('links', $error->process());
        $error->setStatus(null);
        $this->assertArrayNotHasKey('status', $error->process());
        $error->setCode(null);
        $this->assertArrayNotHasKey('code', $error->process());
        $error->setTitle(null);
        $this->assertArrayNotHasKey('title', $error->process());
        $error->setDetail(null);
        $this->assertArrayNotHasKey('detail', $error->process());
        $error->setSource(null);
        $this->assertArrayNotHasKey('source', $error->process());

    }
}
