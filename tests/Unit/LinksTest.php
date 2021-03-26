<?php
/**
 * LinksTest.php
 *
 * LinksTest class
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

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;
use Floor9design\JsonApiFormatter\Models\Link;
use Floor9design\JsonApiFormatter\Models\Links;
use Floor9design\TestingTools\Exceptions\TestingToolsException;
use PHPUnit\Framework\TestCase;

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
 * @version   1.0
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 */
class LinksTest extends TestCase
{
    // Accessors

    /**
     * Test link constructor.
     *
     * @return void
     * @throws TestingToolsException
     */
    public function testConstructor()
    {
        $array = ['hello' => 'world'];
        $link = new Link($array);
        $string = 'a string link';

        $links = new Links(
            [
                'object' => $link,
                'string' => $string
            ]
        );

        $this->assertEquals($link, $links->object);
        $this->assertEquals($string, $links->string);
    }

    /**
     * Test addLinks
     *
     * @return void
     * @throws TestingToolsException
     */
    public function testAddLinks()
    {
        $array = ['hello' => 'world'];
        $link = new Link($array);
        $string = 'a string link';

        $links = new Links(['object' => $link]);
        $links->addLink('string', $string);

        $this->assertEquals($link, $links->object);
        $this->assertEquals($string, $links->string);
    }

    /**
     * Test unsetLinks
     *
     * @return void
     * @throws TestingToolsException
     */
    public function testUnsetLinks()
    {
        $array = ['hello' => 'world'];
        $link = new Link($array);
        $string = 'a string link';

        $links = new Links(
            [
                'object' => $link,
                'string' => $string
            ]
        );
        $links->unsetLink('string');

        $this->assertEquals($link, $links->object);
        $this->assertFalse(property_exists( $links, 'string'));
    }

    /**
     * Test unsetLinks
     *
     * @return void
     * @throws TestingToolsException
     */
    public function testToArray()
    {
        $array = ['hello' => 'world'];
        $link = new Link($array);
        $string = 'a string link';
        $object_array = [
            'object' => $link,
            'string' => $string
        ];

        $links = new Links($object_array);

        $this->assertEquals($object_array, $links->toArray());
    }

    /**
     * Test addLinks
     *
     * @return void
     * @throws TestingToolsException
     */
    public function testValidate()
    {
        $array = ['hello' => 'world'];
        $link = new Link($array);
        $bad_string = 2;

        $links = new Links(['object' => $link]);
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('Links can only be populated with strings or Link objects');
        $links->addLink('string', $bad_string);
    }

}
