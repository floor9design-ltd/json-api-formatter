<?php
/**
 * SourceTest.php
 *
 * SourceTest class
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
use Floor9design\JsonApiFormatter\Models\Source;
use PHPUnit\Framework\TestCase;

/**
 * SourceTest
 *
 * This test file tests the Source.
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
class SourceTest extends TestCase
{
    // Accessors

    /**
     * Test source constructor.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testConstructor()
    {
        $array = ['pointer' => '/data'];
        $source = new Source($array);
        $this->assertEquals($source->getSource(), $array);
    }

    /**
     * Test source constructor.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testProcess()
    {
        $array = ['pointer' => '/data'];
        $source = new Source($array);
        $this->assertEquals($source->process(), $array);
    }

}
