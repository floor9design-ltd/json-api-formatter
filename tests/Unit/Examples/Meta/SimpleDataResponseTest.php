<?php
/**
 * SimpleDataResponseTest.php
 *
 * SimpleDataResponseTest class
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

namespace Examples\Meta;

use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\Link;
use Floor9design\JsonApiFormatter\Models\Links;
use Floor9design\JsonApiFormatter\Models\Meta;
use PHPUnit\Framework\TestCase;

/**
 * SimpleDataResponseTest
 *
 * This runs the test in /docs/project/meta.md
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit\Meta
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.0
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 */
class SimpleDataResponseTest extends TestCase
{
    /**
     * Data Response : Adding response links
     */
    public function testSimpleDataResponse()
    {
        $json_api_formatter = new JsonApiFormatter();
        $data_resource = new DataResource(
            'XD-1',
            'starship',
            ['name' => 'Discovery One']
        );

        // set up the meta
        $meta = new Meta(
            ['status' => '200']
        );

        // if you wish to overwrite existing content, use setMeta, else use addMeta
        $json_api_formatter->setMeta($meta);

        $response = $json_api_formatter->dataResourceResponse($data_resource);
        $this->assertSame($this->getExpectedJson(), $response);
    }

    /**
     * @return string
     */
    protected function getExpectedJson(): string
    {
        return '{"data":{"id":"XD-1","type":"starship","attributes":{"name":"Discovery One"}},"meta":{"status":"200"},"jsonapi":{"version":"1.1"}}';
    }
}
