<?php
/**
 * RelationshipLinksTest.php
 *
 * RelationshipLinksTest class
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
use Floor9design\JsonApiFormatter\Models\Link;
use Floor9design\JsonApiFormatter\Models\RelationshipLinks;
use PHPUnit\Framework\TestCase;

/**
 * RelationshipLinksTest
 *
 * This test file tests the RelationshipLinks class.
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
class RelationshipLinksTest extends TestCase
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
        $link = new Link('http://world.com');
        $string = 'a string link';

        $links = new RelationshipLinks(
            [
                'object' => $link,
                'string' => $string
            ]
        );

        $this->assertEquals($link, $links->getLinks()['object']);
        $this->assertEquals($string, $links->getLinks()['string']);
    }

    /**
     * Test addRelationshipLinks
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testAddRelationshipLinks()
    {
        $link = new Link('http://world.com');
        $string = 'a string link';

        $links = new RelationshipLinks(['object' => $link]);
        $links->addLink('string', $string);

        $this->assertEquals($link, $links->getLinks()['object']);
        $this->assertEquals($string, $links->getLinks()['string']);
    }

    /**
     * Test unsetRelationshipLinks
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testUnsetRelationshipLinks()
    {
        $link = new Link('http://world.com');
        $string = 'a string link';

        $links = new RelationshipLinks(
            [
                'object' => $link,
                'string' => $string
            ]
        );
        $links->unsetLink('string');

        $this->assertEquals($link, $links->getLinks()['object']);
        $this->assertFalse(isset($links->getLinks()['string']));
    }

    /**
     * Test unsetRelationshipLinks
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testProcess()
    {
        $link = new Link('http://world.com');
        $string = 'a string link';
        $object_array = [
            'object' => $link->process(),
            'string' => $string
        ];

        $links = new RelationshipLinks(
            [
                'object' => $link,
                'string' => $string
            ]
        );

        $this->assertEquals((object)$object_array, $links->process());
    }

    /**
     * Test addRelationshipLinks
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testValidate()
    {
        $link = new Link('http://world.com');
        $bad_string = 2;

        $links = new RelationshipLinks(['object' => $link]);
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('RelationshipLinks can only be populated with strings or Link objects');
        $links->addLink('string', $bad_string);
    }

}
