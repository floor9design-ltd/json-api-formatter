<?php
/**
 * SimpleRelationshipsTest.php
 *
 * SimpleRelationshipsTest class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit\Examples\Relationships
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.1
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 *
 */

namespace Examples\Relationships;

use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\Link;
use Floor9design\JsonApiFormatter\Models\Links;
use Floor9design\JsonApiFormatter\Models\Relationship;
use Floor9design\JsonApiFormatter\Models\Relationships;
use PHPUnit\Framework\TestCase;

/**
 * SimpleRelationshipsTest
 *
 * This runs the test in /docs/project/relationships.md
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit\Examples\Relationships
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.1
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 */
class SimpleRelationshipsArrayTest extends TestCase
{
    /**
     * Data Response : Adding response links
     */
    public function testSimpleRelationshipArray()
    {
        $json_api_formatter = new JsonApiFormatter();
        $data_resource = new DataResource(
            'red-5',
            'x-wing',
            ['pilot' => 'Luke Skywalker']
        );

        // each relationship is similar to a separate object, with slightly less content in the main data resource
        $relationship_one_data = new DataResource('red-2', 'x-wing');
        $relationship_two_data = new DataResource('red-october', 'submarine');

        $relationship_links = new Links(
            [
                'good_meme' => new Link('https://www.youtube.com/watch?v=CF18ojCoo5k')
            ]
        );

        $relationship_one = new Relationship(
            [$relationship_one_data, $relationship_two_data],
            $relationship_links
        );

        $relationships = new Relationships(['wingman' => $relationship_one]);

        // These are relationships to the main data, so are added to the main data resource:
        $data_resource->setRelationships($relationships);

        $response = $json_api_formatter->dataResourceResponse($data_resource);
        $this->assertSame($this->getExpectedJson(), $response);
    }

    /**
     * @return string
     */
    protected function getExpectedJson(): string
    {
        return '{"data":{"id":"red-5","type":"x-wing","attributes":{"pilot":"Luke Skywalker"},"relationships":{"wingman":{"data":[{"id":"red-2","type":"x-wing"},{"id":"red-october","type":"submarine"}],"links":{"good_meme":{"href":"https://www.youtube.com/watch?v=CF18ojCoo5k"}}}}},"meta":{"status":null},"jsonapi":{"version":"1.1"}}';
    }
}
