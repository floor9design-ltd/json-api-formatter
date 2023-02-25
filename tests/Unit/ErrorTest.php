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
 * @version   1.3.1
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 *
 */

namespace Floor9design\JsonApiFormatter\Tests\Unit;

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;
use Floor9design\JsonApiFormatter\Models\Error;
use Floor9design\JsonApiFormatter\Models\Links;
use Floor9design\JsonApiFormatter\Models\Meta;
use Floor9design\JsonApiFormatter\Models\Source;
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
 * @version   1.3.1
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

        $source = new Source();
        $error->setSource($source);
        $this->assertEquals($source, $error->getSource());

        $meta = new Meta();
        $error->setMeta($meta);
        $this->assertEquals($meta, $error->getMeta());
    }

    /**
     * Test Error::process()
     *
     * @return void
     * @throws JsonApiFormatterException
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
            'source' => new Source(),
            'meta' => new Meta()
        ];

        $error = new Error(
            $array['id'],
            $array['links'],
            $array['status'],
            $array['code'],
            $array['title'],
            $array['detail'],
            $array['source'],
            $array['meta']
        );

        // some items are processed
        $array['links'] = (object)$array['links']->process();
        $array['source'] = $array['source']->process();
        $array['meta'] = (object)$array['meta']->process();

        $this->assertEquals($error->process(), $array);
    }

    /**
     * Test Error::toArray
     *
     * @return void
     * @throws JsonApiFormatterException
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
            'source' => new Source(),
            'meta' => new Meta()
        ];

        $error = new Error(
            $array['id'],
            $array['links'],
            $array['status'],
            $array['code'],
            $array['title'],
            $array['detail'],
            $array['source'],
            $array['meta']
        );

        // some items are processed
        $array['links'] = (object)$array['links']->process();
        $array['source'] = $array['source']->process();
        $array['meta'] = (object)$array['meta']->process();

        // should do nothing
        $this->assertEquals($array, $error->process());

        // remove one by one, then check
        $error->setId(null);
        $this->assertArrayNotHasKey('id', $error->process());

        // set it again so that the others don't error due to being empty:
        $error->setId($array['id']);

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
        $error->setMeta(null);
        $this->assertArrayNotHasKey('meta', $error->process());

        // now check for exception when empty:
        $error->setId(null);
        $this->expectException(JsonApiFormatterException::class);
        $error->process();
    }
}
