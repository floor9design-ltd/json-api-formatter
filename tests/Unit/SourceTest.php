<?php
/**
 * SourceTest.php
 *
 * SourceTest class
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
 * @version   2.0.0
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
     */
    public function testConstructor()
    {
        $pointer = '/data';
        $parameter = 'test-parameter';
        $header = 'test-header';

        $source = new Source($pointer, $parameter, $header);
        $this->assertEquals($pointer, $source->getPointer());
        $this->assertEquals($parameter, $source->getParameter());
        $this->assertEquals($header, $source->getHeader());
    }

    /**
     * Test source constructor.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testProcess()
    {
        $pointer = '/data';
        $parameter = 'test-parameter';
        $header = 'test-header';

        $array = [
            'pointer' => $pointer,
            'parameter' => $parameter,
            'header' => $header,
        ];
        $source = new Source($pointer, $parameter, $header);
        $this->assertEquals($source->process(), $array);
    }

}
