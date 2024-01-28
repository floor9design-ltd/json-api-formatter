<?php
/**
 * ExampleResponsesTest.php
 *
 * ExampleResponsesTest class
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

use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\DataResourceMeta;
use Floor9design\JsonApiFormatter\Models\Included;
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\Link;
use Floor9design\JsonApiFormatter\Models\Links;
use Floor9design\JsonApiFormatter\Models\Meta;
use Floor9design\JsonApiFormatter\Models\Relationship;
use Floor9design\JsonApiFormatter\Models\RelationshipData;
use Floor9design\JsonApiFormatter\Models\RelationshipLinks;
use Floor9design\JsonApiFormatter\Models\RelationshipMeta;
use Floor9design\JsonApiFormatter\Models\Relationships;
use PHPUnit\Framework\TestCase;

/**
 * ExampleResponsesTest
 *
 * This is a runnable test equivalent of the tutorials
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.0
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @see       /docs/project/usage_example_responses.md
 * @since     File available since Release 1.0
 */
class ExampleResponsesTest extends TestCase
{
    /**
     * Data Response : Single resource
     */
    public function testDataResponseSingleResource()
    {
        $validated_json = '{"data":{"id":"NCC-1701-A","type":"starship","attributes":{"name":"Enterprise"}},"meta":{"status":null},"jsonapi":{"version":"1.1"}}';

        // instantiate a new instance of the formatter:
        $json_api_formatter = new JsonApiFormatter();

        // setup a data resource:
        $data_resource = new DataResource(
            'NCC-1701-A',
            'starship',
            ['name' => 'Enterprise']
        );

        $response = $json_api_formatter->dataResourceResponse($data_resource);
        $this->assertEquals($validated_json, $response);
    }

    /**
     * Data Response : Adding response meta
     */
    public function testDataResponseResponseMeta()
    {
        $validated_json = '{"data":{"id":"XD-1","type":"starship","attributes":{"name":"Discovery One"}},"meta":{"status":"200"},"jsonapi":{"version":"1.1"}}';

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
        $this->assertEquals($validated_json, $response);
    }

    /**
     * Data Response : Adding response meta
     */
    public function testDataResponseResourceMeta()
    {
        $validated_json = '{"data":{"id":"ECF-270","type":"starship","attributes":{"name":"Rocinante"},"meta":{"previous_name":"MCRN Tachi"}},"meta":{"status":null},"jsonapi":{"version":"1.1"}}';

        $json_api_formatter = new JsonApiFormatter();
        $data_resource = new DataResource(
            'ECF-270',
            'starship',
            ['name' => 'Rocinante']
        );

        // Assign the meta to the data resource
        $data_resource_meta = new DataResourceMeta(
            ['previous_name' => 'MCRN Tachi']
        );
        $data_resource->setDataResourceMeta($data_resource_meta);

        $response = $json_api_formatter->dataResourceResponse($data_resource);
        $this->assertEquals($validated_json, $response);
    }

    /**
     * Data Response : Adding response links
     */
    public function testDataResponseResourceLinks()
    {
        $validated_json = '{"data":{"id":"unregistered","type":"battlecruiser","attributes":{"name":"Hyperion"}},"meta":{"status":null},"jsonapi":{"version":"1.1"},"links":{"self":"https://starcraft.fandom.com/wiki/Hyperion","support":{"href":"https://starcraft.fandom.com/wiki/Viking"}}}';

        $json_api_formatter = new JsonApiFormatter();
        $data_resource = new DataResource(
            'unregistered',
            'battlecruiser',
            ['name' => 'Hyperion']
        );

        // links can be either a URL or a structured array (href and meta)
        $links = new Links(
            [
                'self' => 'https://starcraft.fandom.com/wiki/Hyperion',
                'support' => new Link('https://starcraft.fandom.com/wiki/Viking')
            ]
        );
        $json_api_formatter->setLinks($links);

        $response = $json_api_formatter->dataResourceResponse($data_resource);
        $this->assertEquals($validated_json, $response);
    }

    /**
     * Data Response : Adding response with included objects
     */
    public function testDataResponseResourceIncluded()
    {
        $validated_json = '{"data":{"id":"0896-24609","type":"shuttle","attributes":{"name":"Starbug"}},"meta":{"status":null},"jsonapi":{"version":"1.1"},"included":[{"id":"JMCRD","type":"mining_freighter","attributes":{"name":"Red Dwarf"}}]}';

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
        $this->assertEquals($validated_json, $response);
    }

    /**
     * Data Response : Adding response with relationships
     */
    public function testDataResponseResourceRelationships()
    {
        $validated_json = '{"data":{"id":"red-5","type":"x-wing","attributes":{"pilot":"Luke Skywalker"},"relationships":{"wingman":{"data":{"id":"red-2","type":"x-wing"},"links":{"good_scene":"https://www.youtube.com/watch?v=eEeTWVru1qc"},"meta":{"pilot":"Wedge Antilles"}},"backup":{"data":{"id":"red-october","type":"submarine "},"links":{"good_meme":{"href":"https://www.youtube.com/watch?v=CF18ojCoo5k"}},"meta":{"captain":"Marko Aleksandrovich Ramius"}}}},"meta":{"status":null},"jsonapi":{"version":"1.1"}}';

        $json_api_formatter = new JsonApiFormatter();
        $data_resource = new DataResource(
            'red-5',
            'x-wing',
            ['pilot' => 'Luke Skywalker']
        );

        // each relationship is similar to a separate object, with slightly less content in the main data resource
        $relationship_one_data = new RelationshipData('red-2', 'x-wing');
        $relationship_one_meta = new RelationshipMeta(['pilot' => 'Wedge Antilles']);
        $relationship_one_links = new RelationshipLinks(['good_scene' => 'https://www.youtube.com/watch?v=eEeTWVru1qc']);
        $relationship_one = new Relationship(
            $relationship_one_links,
            $relationship_one_data,
            $relationship_one_meta
        );

        $relationship_two_data = new RelationshipData('red-october', 'submarine ');
        $relationship_two_meta = new RelationshipMeta(['captain' => 'Marko Aleksandrovich Ramius']);
        // alternate link build
        $relationship_two_links = new RelationshipLinks(
            [
                'good_meme' => new Link('https://www.youtube.com/watch?v=CF18ojCoo5k')
            ]
        );
        $relationship_two = new Relationship(
            $relationship_two_links,
            $relationship_two_data,
            $relationship_two_meta
        );

        $relationships = new Relationships(['wingman' => $relationship_one, 'backup' => $relationship_two]);

        // These are relationships to the main data, so are added to the main data resource:
        $data_resource->setRelationships($relationships);

        $response = $json_api_formatter->dataResourceResponse($data_resource);
        $this->assertEquals($validated_json, $response);
    }

    /**
     * Data Response : Single object
     */
    public function testDataResponseMultipleObjects()
    {
        $validated_json = '{"data":[{"id":"BSG75","type":"battlestar","attributes":{"name":"Galactica"}},{"id":"BSG62","type":"battlestar","attributes":{"name":"Pegasus"}}],"meta":{"status":null},"jsonapi":{"version":"1.1"}}';

        // instantiate a new instance of the formatter:
        $json_api_formatter = new JsonApiFormatter();

        // add data resources:
        $data_resource = new DataResource(
            'BSG75',
            'battlestar',
            ['name' => 'Galactica']
        );

        $data_resource2 = new DataResource(
            'BSG62',
            'battlestar',
            ['name' => 'Pegasus']
        );

        $response = $json_api_formatter->dataResourceResponse([$data_resource, $data_resource2]);
        $this->assertEquals($validated_json, $response);
    }

}
