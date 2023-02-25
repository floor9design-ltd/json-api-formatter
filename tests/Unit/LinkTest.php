<?php
/**
 * LinkTest.php
 *
 * LinkTest class
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
use Floor9design\JsonApiFormatter\Models\Link;
use PHPUnit\Framework\TestCase;

/**
 * LinkTest
 *
 * This test file tests the Link.
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
class LinkTest extends TestCase
{
    // Accessors

    /**
     * Test link constructor.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testConstructor()
    {
        $array = ['href' => 'http://world.com'];
        $link = new Link($array);
        $this->assertEquals($link->getLink(), $array);
    }

    /**
     * Test link constructor.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testProcess()
    {
        // href
        $array = ['href' => 'http://world.com'];
        $link = new Link($array);
        $this->assertEquals($link->process(), $array);

        // only keeps href and meta
        $array = [
            'href' => 'http://world.com',
            'meta' => ['hello' => 'world'],
            'another' => 'ignored'
        ];
        $link = new Link($array);

        $processed = [
            'href' => 'http://world.com',
            'meta' => (object)['hello' => 'world']
        ];

        $this->assertEquals($link->process(), $processed);

        // throws an exception if no href:
        $array = [
            'meta' => ['hello' => 'world'],
        ];

        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage(
            'The provided link data should be an array containing the key href'
        );
        $link = new Link($array);
    }

}
