<?php
/**
 * LinksTest.php
 *
 * LinksTest class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.1
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 *
 */

namespace Floor9design\JsonApiFormatter\Tests\Unit;

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;
use Floor9design\JsonApiFormatter\Models\Link;
use Floor9design\JsonApiFormatter\Models\Links;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * LinksTest
 *
 * This test file tests the Links class.
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.1
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 */
class LinksTest extends TestCase
{
    /**
     * tests accessors
     */
    public function testAccessors()
    {
        $link = new Link('http://world.com');

        $links = new Links();
        $links->setLinks([$link]);

        $this->assertEquals([$link], $links->getLinks());
    }

    /**
     * Test link constructor.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testConstructor()
    {
        $link = new Link('http://world.com');
        $string = 'a string link';

        $links = new Links(
            [
                'object' => $link,
                'string' => $string
            ]
        );

        $this->assertEquals($link, $links->getLinks()['object']);
        $this->assertEquals($string, $links->getLinks()['string']);
    }

    /**
     * Test addLinks
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testAddLinks()
    {
        $link = new Link('http://world.com');
        $string = 'a string link';

        $links = new Links(['object' => $link]);
        $links->addLink('string', $string);
        $links->addLink('null', null);

        $this->assertEquals($link, $links->getLinks()['object']);
        $this->assertEquals($string, $links->getLinks()['string']);
        $this->assertNull($links->getLinks()['null']);
    }

    /**
     * Test unsetLinks
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testUnsetLinks()
    {
        $link = new Link('http://world.com');
        $string = 'a string link';

        $links = new Links(
            [
                'object' => $link,
                'string' => $string
            ]
        );
        $links->unsetLink('string');

        $this->assertEquals($link, $links->getLinks()['object']);
        $this->assertArrayNotHasKey('string', $links->getLinks());
    }

    /**
     * Test process()
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testProcess()
    {
        $link = new Link('http://world.com');
        $string = 'a string link';
        $object_array = [
            'object' => $link,
            'string' => $string
        ];
        $processed_array = [
            'object' => $link->process(),
            'string' => $string
        ];

        $links = new Links($object_array);

        $this->assertEquals($processed_array, $links->process());
    }
}
