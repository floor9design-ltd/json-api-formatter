<?php
/**
 * LinkTest.php
 *
 * LinkTest class
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
use Floor9design\JsonApiFormatter\Interfaces\LinkInterface;
use Floor9design\JsonApiFormatter\Models\Link;
use Floor9design\JsonApiFormatter\Models\Meta;
use Floor9design\TestDataGenerator\Generator;
use Floor9design\TestingTools\Exceptions\TestingToolsException;
use Floor9design\TestingTools\Traits\AccessorTesterTrait;
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
 * @version   2.0.0
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @see       Link
 * @since     File available since Release 1.0
 */
class LinkTest extends TestCase
{
    use AccessorTesterTrait;

    // Accessors

    /**
     * Test link interfaces.
     *
     * @return void
     */
    public function testInheritance(): void
    {
        $link = new Link('test');
        $this->assertInstanceOf(
            LinkInterface::class,
            $link,
            'The Link was not an instance of LinkInterface'
        );
    }

    /**
     * @return void
     * @throws JsonApiFormatterException
     * @throws TestingToolsException
     */
    public function testAccessors(): void
    {
        $generator = new Generator();
        $link = new Link('test');

        // generic tests

        $strings = [
            'href' => [],
            'title' => [],
            'type' => [],
            'hreflang' => []
        ];
        $this->accessorTestStrings($strings, $link);

        $arrays = [
            'hreflang' => [],
            'link_relation_types' => [
                'config' => [
                    // string length value
                    'length' => 5,
                    // array length
                    'array_length' => 10
                ]
            ]
        ];
        $this->accessorTestArrays($arrays, $link);

        // direct tests

        $meta = new Meta();
        $link->setMeta($meta);
        $this->assertEquals($meta, $link->getMeta());

        // object
        $described_by = new Link($generator->randomUrl());
        $link->setDescribedBy($described_by);
        $this->assertEquals(
            $described_by,
            $link->getDescribedBy(),
            'The described_by accessors did not set/get correctly'
        );

        // string
        $described_by = $generator->randomUrl();
        $link->setDescribedBy($described_by);
        $this->assertEquals(
            $described_by,
            $link->getDescribedBy(),
            'The described_by accessors did not set/get correctly'
        );

        $rel_types = $link->getLinkRelationTypes();
        $valid_rel = array_rand($rel_types);

        $link->setRel($rel_types[$valid_rel]);
        $this->assertEquals(
            $rel_types[$valid_rel],
            $link->getRel(),
            'The rel accessors did not set/get correctly'
        );
    }

    /**
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testValidationRel(): void
    {
        $link = new Link('test');

        $invalid_rel = 'not_valid_rel';
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('The provided rel was not valid (see Link - $link_relation_types)');
        $link->setRel($invalid_rel);
    }

    /**
     * Test link constructor.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testConstructor(): void
    {
        $generator = new Generator();
        $link = new Link('test');

        $rel_types = $link->getLinkRelationTypes();
        $valid_rel = array_rand($rel_types);

        $href = $generator->randomUrl();
        $rel = $rel_types[$valid_rel];
        $described_by = new Link($generator->randomUrl());
        $title = $generator->randomString();
        $type = $generator->randomString();
        $hreflang = [$generator->randomUrl(), $generator->randomUrl()];
        $meta = new Meta();

        $link = new Link(
            $href,
            $described_by,
            $rel,
            $title,
            $type,
            $hreflang,
            $meta
        );

        $this->assertEquals(
            $href,
            $link->getHref(),
            'The href was not set by the constructor'
        );

        $this->assertEquals(
            $described_by,
            $link->getDescribedBy(),
            'The described_by was not set by the constructor'
        );

        $this->assertEquals(
            $rel,
            $link->getRel(),
            'The rel was not set by the constructor'
        );

        $this->assertEquals(
            $title,
            $link->getTitle(),
            'The title was not set by the constructor'
        );

        $this->assertEquals(
            $type,
            $link->getType(),
            'The type was not set by the constructor'
        );

        $this->assertEquals(
            $hreflang,
            $link->getHreflang(),
            'The hreflang was not set by the constructor'
        );

        $this->assertEquals(
            $meta,
            $link->getMeta(),
            'The meta was not set by the constructor'
        );
    }

    /**
     * Test link process()
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testProcess(): void
    {
        $generator = new Generator();
        $link = new Link('test');

        $rel_types = $link->getLinkRelationTypes();
        $valid_rel = array_rand($rel_types);

        $href = $generator->randomUrl();
        $rel = $rel_types[$valid_rel];
        $described_by = new Link($generator->randomUrl());
        $title = $generator->randomString();
        $type = $generator->randomString();
        $hreflang = [$generator->randomUrl(), $generator->randomUrl()];
        $meta = new Meta();

        // most basic
        $link = new Link($href);
        $processed_link = ['href' => $href];

        $this->assertEquals(
            $processed_link,
            $link->process(),
            'The link did not process correctly'
        );

        // complete
        $link = new Link(
            $href,
            $described_by,
            $rel,
            $title,
            $type,
            $hreflang,
            $meta
        );

        $processed_link = [
            'href' => $href,
            'describedby' => $described_by->process(),
            'rel' => $rel,
            'title' => $title,
            'type' => $type,
            'hreflang' => $hreflang,
            'meta' => $meta->process()
        ];

        $this->assertEquals(
            $processed_link,
            $link->process(),
            'The link did not process correctly'
        );
    }
}
