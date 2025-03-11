<?php
/**
 * AdvancedUsageTest.php
 *
 * AdvancedUsageTest class
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

namespace Examples\Errors;

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;
use Floor9design\JsonApiFormatter\Models\Error;
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\Link;
use Floor9design\JsonApiFormatter\Models\Links;
use Floor9design\JsonApiFormatter\Models\Meta;
use Floor9design\JsonApiFormatter\Models\Source;
use PHPUnit\Framework\TestCase;

/**
 * AdvancedUsageTest
 *
 * This runs the test in /docs/project/errors.md
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
class AdvancedUsageTest extends TestCase
{
    /**
     * Test advanced usage example.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testSimpleUsage(): void
    {
        $error_basic = new Error(
            '12657',
            null,
            '403',
            'HAL-9000-NOPE',
            'Access error',
            'Im sorry Dave, Im afraid I cant do that',
        );

        $links = new Links(
            [
                new Link('https://www.youtube.com/watch?v=c8N72t7aScY')
            ]
        );
        $source = new Source(
            [
                'pointer' => '/data/'
            ]
        );
        $meta = new Meta (
            [
                'book' => '2001, A Space Odyssey',
                'isbn' => '978-0-453-00269-1'
            ]
        );

        $error_complex = new Error(
            '12656',
            $links,
            '503',
            'HAL-9000-DEACTIVATED',
            'Service Unavailable',
            'My mind is going, I can feel it.',
            $source,
            $meta
        );

        $errors = [$error_basic, $error_complex];
        $json_api_formatter = new JsonApiFormatter();
        $response = $json_api_formatter->errorResponse($errors);

        $this->assertSame($this->getExpectedJson(), $response);
    }

    /**
     * @return string
     */
    protected function getExpectedJson(): string
    {
        // this minified example:
        return '{"errors":[{"id":"12657","status":"403","code":"HAL-9000-NOPE","title":"Access error","detail":"Im sorry Dave, Im afraid I cant do that"},{"id":"12656","status":"503","code":"HAL-9000-DEACTIVATED","title":"Service Unavailable","detail":"My mind is going, I can feel it.","source":{"pointer":"/data/"},"meta":{"book":"2001, A Space Odyssey","isbn":"978-0-453-00269-1"},"links":{"0":{"href":"https://www.youtube.com/watch?v=c8N72t7aScY"}}}],"meta":{"status":null},"jsonapi":{"version":"1.1"}}';
    }
}
