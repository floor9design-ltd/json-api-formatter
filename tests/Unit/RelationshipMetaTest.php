<?php
/**
 * RelationshipMetaTest.php
 *
 * RelationshipMetaTest class
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

use Floor9design\JsonApiFormatter\Models\RelationshipMeta;
use Floor9design\TestingTools\Exceptions\TestingToolsException;
use Floor9design\TestingTools\Traits\AccessorTesterTrait;
use PHPUnit\Framework\TestCase;

/**
 * RelationshipMetaTest
 *
 * This test file tests the RelationshipMeta.
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
class RelationshipMetaTest extends TestCase
{
    use AccessorTesterTrait;

    // Accessors

    /**
     * Test accessors.
     *
     * @return void
     * @throws TestingToolsException
     */
    public function testAccessors()
    {
        $meta = new RelationshipMeta();

        $this->accessorTestArrays(
            [
                'meta' => []
            ],
            $meta
        );
    }

    /**
     * Test meta constructor.
     *
     * @return void
     */
    public function testConstructor()
    {
        $array = ['hello' => 'world'];
        $meta = new RelationshipMeta($array);
        $this->assertEquals($meta->getMeta()['hello'], 'world');
    }

    /**
     * Test meta constructor.
     *
     * @return void
     */
    public function testProcess()
    {
        $array = ['hello' => 'world'];
        $meta = new RelationshipMeta($array);
        $this->assertEquals($meta->process(), (object)$array);
    }

}
