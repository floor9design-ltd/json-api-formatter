<?php
/**
 * SimpleSourceTest.php
 *
 * SimpleSourceTest class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit\Example\Source
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.0
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 *
 */

namespace Examples\Source;

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;
use Floor9design\JsonApiFormatter\Models\Error;
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\Source;
use PHPUnit\Framework\TestCase;

/**
 * SimpleSourceTest
 *
 * This runs the test in /docs/project/source.md
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit\Example\Source
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.0
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 */
class SimpleSourceTest extends TestCase
{
    /**
     * Test simple usage example.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testSimpleUsage(): void
    {
        $source = new Source(
            '/data',
            'user_id',
            'User access request'
        );

        // an example error:
        $error = new Error(
            '12656',
            null,
            '403',
            'HAL-9000-NOPE',
            'Access error',
            'Im sorry Dave, Im afraid I cant do that',
            $source
        );
        $errors = [$error];

        $json_api_response = new JsonApiFormatter();
        $response = $json_api_response->errorResponse($errors);
        $this->assertSame($this->getExpectedJson(), $response);
    }

    /**
     * @return string
     */
    protected function getExpectedJson(): string
    {
        // this minified example:
        return '{"errors":[{"id":"12656","status":"403","code":"HAL-9000-NOPE","title":"Access error","detail":"Im sorry Dave, Im afraid I cant do that","source":{"pointer":"/data","parameter":"user_id","header":"User access request"}}],"meta":{"status":null},"jsonapi":{"version":"1.1"}}';
    }
}
