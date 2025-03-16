<?php
/**
 * SimpleDataResourceTest.php
 *
 * SimpleDataResourceTest class
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
use Floor9design\JsonApiFormatter\Models\Meta;
use PHPUnit\Framework\TestCase;

/**
 * SimpleDataResourceTest
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
class SimpleDataResourceTest extends TestCase
{
    /**
     * Data Response : Adding response links
     */
    public function testSimpleDataResource()
    {
        $json_api_formatter = new JsonApiFormatter();
        $data_resource = new DataResource(
            'ECF-270',
            'starship',
            ['name' => 'Rocinante']
        );

        // Assign the meta to the data resource
        $data_resource_meta = new Meta(
            ['previous_name' => 'MCRN Tachi']
        );
        $data_resource->setMeta($data_resource_meta);

        $response = $json_api_formatter->dataResourceResponse($data_resource);
        $this->assertSame($this->getExpectedJson(), $response);
    }

    /**
     * @return string
     */
    protected function getExpectedJson(): string
    {
        return '{"data":{"id":"ECF-270","type":"starship","attributes":{"name":"Rocinante"},"meta":{"previous_name":"MCRN Tachi"}},"meta":{"status":null},"jsonapi":{"version":"1.1"}}';
    }
}
