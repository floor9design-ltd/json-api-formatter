<?php
/**
 * SimpleRelationshipsTest.php
 *
 * SimpleRelationshipsTest class
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

namespace Examples\Relationships;

use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\Link;
use Floor9design\JsonApiFormatter\Models\Links;
use Floor9design\JsonApiFormatter\Models\Meta;
use Floor9design\JsonApiFormatter\Models\Relationship;
use Floor9design\JsonApiFormatter\Models\Relationships;
use PHPUnit\Framework\TestCase;

/**
 * SimpleRelationshipsTest
 *
 * This runs the test in /docs/project/relationships.md
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit\Relationships
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.0
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 */
class SimpleRelationshipTest extends TestCase
{
    /**
     * Data Response : Adding response links
     */
    public function testSimpleRelationship()
    {
        $json_api_formatter = new JsonApiFormatter();
        $data_resource = new DataResource(
            'red-5',
            'x-wing',
            ['pilot' => 'Luke Skywalker']
        );

        // each relationship is similar to a separate object, with slightly less content in the main data resource
        $relationship_one_data = new DataResource('red-2', 'x-wing');
        $relationship_one_meta = new Meta(['pilot' => 'Wedge Antilles']);
        $relationship_one_links = new Links(
            ['good_scene' => 'https://www.youtube.com/watch?v=eEeTWVru1qc']
        );
        $relationship_one = new Relationship(
            $relationship_one_data,
            $relationship_one_links,
            $relationship_one_meta
        );

        $relationship_two_data = new DataResource('red-october', 'submarine');
        $relationship_two_meta = new Meta(['captain' => 'Marko Aleksandrovich Ramius']);
        // alternate link build
        $relationship_two_links = new Links(
            [
                'good_meme' => new Link('https://www.youtube.com/watch?v=CF18ojCoo5k')
            ]
        );
        $relationship_two = new Relationship(
            $relationship_two_data,
            $relationship_two_links,
            $relationship_two_meta
        );

        $relationships = new Relationships(['wingman' => $relationship_one, 'backup' => $relationship_two]);

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
        return '{"data":{"id":"red-5","type":"x-wing","attributes":{"pilot":"Luke Skywalker"},"relationships":{"wingman":{"data":{"id":"red-2","type":"x-wing"},"links":{"good_scene":"https://www.youtube.com/watch?v=eEeTWVru1qc"},"meta":{"pilot":"Wedge Antilles"}},"backup":{"data":{"id":"red-october","type":"submarine"},"links":{"good_meme":{"href":"https://www.youtube.com/watch?v=CF18ojCoo5k"}},"meta":{"captain":"Marko Aleksandrovich Ramius"}}}},"meta":{"status":null},"jsonapi":{"version":"1.1"}}';
    }
}
