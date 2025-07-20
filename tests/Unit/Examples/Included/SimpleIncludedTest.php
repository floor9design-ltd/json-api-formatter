<?php
/**
 * SimpleIncludedTest.php
 *
 * SimpleIncludedTest class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit\Examples\Included
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.1
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 *
 */

namespace Examples\Included;

use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\Included;
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\Link;
use Floor9design\JsonApiFormatter\Models\Links;
use Floor9design\JsonApiFormatter\Models\Meta;
use Floor9design\JsonApiFormatter\Models\Relationship;
use Floor9design\JsonApiFormatter\Models\Relationships;
use PHPUnit\Framework\TestCase;

/**
 * SimpleIncludedTest
 *
 * This runs the test in /docs/project/relationships.md
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit\Examples\Included
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.1
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 */
class SimpleIncludedTest extends TestCase
{
    /**
     * Data Response : Adding response links
     */
    public function testSimpleRelationship()
    {
        $json_api_formatter = new JsonApiFormatter();
        $data_resource = new DataResource(
            '0896-24609',
            'shuttle',
            ['name' => 'Starbug']
        );

        // included is an array of data resources
        $included_data_resource = new DataResource(
            'JMCRD',
            'mining_freighter',
            ['name' => 'Red Dwarf']
        );
        $included = new Included([$included_data_resource]);

        $json_api_formatter->setIncluded($included);

        $response = $json_api_formatter->dataResourceResponse($data_resource);
        $this->assertSame($this->getExpectedJson(), $response);
    }

    /**
     * @return string
     */
    protected function getExpectedJson(): string
    {
        return '{"data":{"id":"0896-24609","type":"shuttle","attributes":{"name":"Starbug"}},"meta":{"status":null},"jsonapi":{"version":"1.1"},"included":[{"id":"JMCRD","type":"mining_freighter","attributes":{"name":"Red Dwarf"}}]}';
    }
}
