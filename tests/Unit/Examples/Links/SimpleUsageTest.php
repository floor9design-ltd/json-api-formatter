<?php
/**
 * SimpleUsageTest.php
 *
 * SimpleUsageTest class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit\Example\Links
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.0
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 *
 */

namespace Examples\Links;

use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\Link;
use Floor9design\JsonApiFormatter\Models\Links;
use PHPUnit\Framework\TestCase;

/**
 * SimpleUsageTest
 *
 * This runs the test in /docs/project/links.md
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit\Example\Links
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.0
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 */
class SimpleUsageTest extends TestCase
{
    /**
     * Data Response : Adding response links
     */
    public function testSimpleUsage()
    {
        $json_api_formatter = new JsonApiFormatter();
        $data_resource = new DataResource(
            'unregistered',
            'battlecruiser',
            ['name' => 'Hyperion']
        );

        $links = new Links(
            [
                'self' => 'https://starcraft.fandom.com/wiki/Hyperion',
                'support' => new Link('https://starcraft.fandom.com/wiki/Viking')
            ]
        );
        $json_api_formatter->setLinks($links);

        $response = $json_api_formatter->dataResourceResponse($data_resource);
        $this->assertEquals($this->getExpectedJson(), $response);
    }

    /**
     * @return string
     */
    protected function getExpectedJson(): string
    {
        return '{"data":{"id":"unregistered","type":"battlecruiser","attributes":{"name":"Hyperion"}},"meta":{"status":null},"jsonapi":{"version":"1.1"},"links":{"self":"https://starcraft.fandom.com/wiki/Hyperion","support":{"href":"https://starcraft.fandom.com/wiki/Viking"}}}';
    }
}
