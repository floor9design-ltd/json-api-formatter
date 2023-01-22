<?php
/**
 * JsonApiFormatterTest.php
 *
 * JsonApiFormatterTest class
 *
 * php 7.4+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   1.0
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 *
 */

namespace Floor9design\JsonApiFormatter\Tests\Unit;

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;
use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\DataResourceMeta;
use Floor9design\JsonApiFormatter\Models\Error;
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
use Floor9design\JsonApiFormatter\Models\Source;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use StdClass;

/**
 * JsonApiFormatterTest
 *
 * This test file tests the JsonApiFormatter.
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Tests\Unit
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   1.0
 * @link      https://github.com/floor9design-ltd/json-api-formatter
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 */
class JsonApiFormatterTest extends TestCase
{
    // Accessors

    /**
     * Test content_type accessors.
     *
     * @return void
     */
    public function testContentTypeAccessors()
    {
        $json_api_formatter = new JsonApiFormatter();

        // Static value
        $this->assertEquals($json_api_formatter->getContentType(), 'application/vnd.api+json');
    }

    /**
     * Test data accessors.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testDataAccessors()
    {
        $json_api_formatter = new JsonApiFormatter();
        $test_single_object = new DataResource('1', 'data', [0 => 'some_data']);
        $test_another_single_object = new DataResource('2', 'data', [0 => 'more_data']);
        $test_array = [$test_single_object, $test_another_single_object];
        $test_final_single_object = new DataResource('3', 'data', [0 => 'even_more_data']);
        $test_final_array = [$test_single_object, $test_another_single_object, $test_final_single_object];
        $test_added_key = 'foo';
        $test_added_value = 'bar';
        $test_single_object_added = new DataResource(
            '1',
            'data',
            [0 => 'some_data', $test_added_key => $test_added_value]
        );

        // Valid get and set
        $json_api_formatter->setData($test_single_object);
        $this->assertEquals($json_api_formatter->getData(), $test_single_object);

        // Valid get and set
        $json_api_formatter->setData($test_array);
        $this->assertEquals($json_api_formatter->getData(), $test_array);

        // Empty add
        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->addData($test_single_object);
        $this->assertEquals($json_api_formatter->getData(), $test_single_object);

        // Existing add to object
        $json_api_formatter->setData($test_single_object);
        $json_api_formatter->addData($test_another_single_object);
        $this->assertEquals($json_api_formatter->getData(), $test_array);

        // Existing add to an array
        $json_api_formatter->setData($test_array);
        $json_api_formatter->addData($test_final_single_object);
        $this->assertEquals($json_api_formatter->getData(), $test_final_array);

        // unset
        $reflection = self::getMethod('getBaseResponseArray');
        $test_object = new JsonApiFormatter();
        $test_object->unsetData();
        $response = $reflection->invokeArgs($test_object, []);
        $this->assertFalse(isset($response['data']));

        // add to a DataResource
        $json_api_formatter->setData($test_single_object);
        $json_api_formatter->addDataAttribute($test_added_key, $test_added_value);
        $this->assertEquals($test_single_object_added, $json_api_formatter->getData());

        // add to a DataResource: exception
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('addDataAttribute() can only be used with a single DataResource');
        $json_api_formatter->setData($test_array);
        $json_api_formatter->addDataAttribute('foo', 'bar');

    }

    /**
     * Test data accessors.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testDataAccessorsBadObject()
    {
        $json_api_formatter = new JsonApiFormatter();
        $test_bad_object = new StdClass();

        // Check bad data exception
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('$data needs to be either a DataResource or an array of DataResource objects');
        $json_api_formatter->setData($test_bad_object);
    }

    /**
     * Test data accessors.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testDataAccessorsBadArrayObject()
    {
        $json_api_formatter = new JsonApiFormatter();
        $test_bad_object = new StdClass();

        // Check bad data exception
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('$data needs to be either a DataResource or an array of DataResource objects');
        $json_api_formatter->setData([$test_bad_object]);
    }

    /**
     * Test errors accessors.
     *
     * @return void
     * @throws JsonApiFormatterException
     * @throws ReflectionException
     */
    public function testErrorsAccessors()
    {
        $error = new Error();
        $error->setStatus('400');
        $error->setTitle('Bad request');
        $error->setDetail('The request was not formed well');

        $error2 = new Error();
        $error2->setStatus('400');
        $error2->setTitle('Bad request 2');
        $error2->setDetail('The request was not formed well either');

        $test_error = [$error];
        $test_complete_errors = [$error, $error2];

        $json_api_formatter = new JsonApiFormatter();

        // Valid get and set
        $json_api_formatter->setErrors($test_error);
        $this->assertEquals($json_api_formatter->getErrors(), $test_error);

        // extend
        $json_api_formatter->addErrors([$error2]);
        $this->assertEquals($json_api_formatter->getErrors(), $test_complete_errors);

        // unset
        $reflection = self::getMethod('getBaseResponseArray');
        $test_object = new JsonApiFormatter();
        $test_object->unsetErrors();
        $response = $reflection->invokeArgs($test_object, []);
        $this->assertFalse(isset($response['errors']));

        $json_api_formatter = new JsonApiFormatter();
        $test_bad_object = new StdClass();

        // Check bad error object exception
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('$errors needs to be an array of Error objects');
        $json_api_formatter->setErrors([$test_bad_object]);
    }

    /**
     * Test errors accessors.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testErrorsAccessorsSetException()
    {
        $json_api_formatter = new JsonApiFormatter();
        $test_bad_object = new StdClass();

        // Check bad error object exception
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('$errors needs to be an array of Error objects');
        $json_api_formatter->setErrors([$test_bad_object]);
    }

    /**
     * Test errors accessors.
     *
     * @return void
     * @throws JsonApiFormatterException
     */
    public function testErrorsAccessorsAddException()
    {
        $json_api_formatter = new JsonApiFormatter();
        $test_bad_object = new StdClass();

        // Check bad error object exception
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('$errors needs to be an array of Error objects');
        $json_api_formatter->addErrors([$test_bad_object]);
    }

    /**
     * Test meta accessors.
     *
     * @return void
     * @throws JsonApiFormatterException
     * @throws ReflectionException
     */
    public function testMetaAccessors()
    {
        $test_default_meta = new Meta(
            [
                'status' => null
            ]
        );

        $test_partial_meta = new Meta(
            [
                'status' => '200'
            ]
        );

        $test_complete_meta = new Meta(
            [
                'status' => '200',
                'info' => 'Request loaded in 34ms'
            ]
        );

        $json_api_formatter = new JsonApiFormatter();

        // check the default value
        $this->assertEquals($test_default_meta, $json_api_formatter->getMeta());

        // Valid get and set
        $json_api_formatter->setMeta($test_complete_meta);
        $this->assertEquals($json_api_formatter->getMeta(), $test_complete_meta);

        // unset
        $reflection = self::getMethod('getBaseResponseArray');
        $test_object = new JsonApiFormatter();
        $test_object->unsetMeta();
        $response = $reflection->invokeArgs($test_object, []);
        $this->assertFalse(isset($response['meta']));

        // Empty add
        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->unsetMeta();
        $json_api_formatter->addMeta($test_complete_meta);
        $this->assertEquals($test_complete_meta, $json_api_formatter->getMeta());

        // make a partial and extend
        $json_api_formatter->setMeta($test_partial_meta);
        $json_api_formatter->addMeta(new Meta(['info' => 'Request loaded in 34ms']));
        $this->assertEquals($json_api_formatter->getMeta(), (object)$test_complete_meta);

        // force add some meta
        $json_api_formatter->addMeta(new Meta(['info' => 'Request loaded in 34ms']), true);
        $this->assertEquals($json_api_formatter->getMeta(), (object)$test_complete_meta);

        // check that addMeta catches duplicates
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('The meta provided clashes with existing meta - it should be added manually');
        $json_api_formatter->addMeta(new Meta(['info' => 'Request loaded in 34ms']));
    }

    /**
     * Test jsonapi accessors.
     *
     * @return void
     */
    public function testJsonapiAccessors()
    {
        $test_default_jsonapi = (object)['version' => '1.1'];

        $test_replacement_meta = (object)['version' => '1.2'];

        $json_api_formatter = new JsonApiFormatter();

        // check the default value
        $this->assertEquals($json_api_formatter->getJsonapi(), $test_default_jsonapi);

        // Valid get and set
        $json_api_formatter->setJsonapi($test_replacement_meta);
        $this->assertEquals($json_api_formatter->getJsonapi(), $test_replacement_meta);
    }

    /**
     * Test included accessors.
     *
     * @return void
     * @throws ReflectionException
     */
    public function testIncludedAccessors()
    {
        $included_company = new DataResource(
            "1",
            'company',
            [
                'company' => 'Joe Bloggs Ltd',
                'slug' => null
            ]
        );

        $included_company2 = new DataResource(
            "2",
            'company2',
            [
                'company' => 'Joe Bloggs Ltd',
                'slug' => null
            ]
        );

        $test_basic_included = [$included_company];
        $test_extended_included = [$included_company, $included_company2];
        $test_basic_included_object = new Included($test_basic_included);
        $test_extended_included_object = new Included($test_extended_included);

        $json_api_formatter = new JsonApiFormatter();

        // Valid get and set
        $json_api_formatter->setIncluded($test_basic_included_object);
        $this->assertEquals($json_api_formatter->getIncluded(), $test_basic_included_object);

        // make a partial and extend
        $json_api_formatter->setIncluded($test_basic_included_object);
        $json_api_formatter->addIncluded([$included_company2]);
        $this->assertEquals($json_api_formatter->getIncluded(), $test_extended_included_object);

        // unset
        $reflection = self::getMethod('getBaseResponseArray');
        $test_object = new JsonApiFormatter();
        $test_object->unsetIncluded();
        $response = $reflection->invokeArgs($test_object, []);
        $this->assertFalse(isset($response['included']));

        // force add some links
        $json_api_formatter->setIncluded($test_extended_included_object);
        $json_api_formatter->addIncluded(['second' => $included_company], true);
        $this->assertEquals($json_api_formatter->getIncluded(), $test_extended_included_object);
    }

    /**
     * Test links accessors.
     *
     * @return void
     * @throws JsonApiFormatterException
     * @throws ReflectionException
     */
    public function testLinksAccessors()
    {
        $test_partial_links = new Links(['self' => 'http://example.com/posts']);

        $test_complete_links = new Links(
            [
                'self' => 'http://example.com/posts',
                'next' => 'http://example.com/more-posts'
            ]
        );

        $json_api_formatter = new JsonApiFormatter();

        // Valid get and set
        $json_api_formatter->setLinks($test_complete_links);
        $this->assertEquals($json_api_formatter->getLinks(), $test_complete_links);

        // make a partial and extend
        $json_api_formatter->setLinks($test_partial_links);
        $json_api_formatter->addLinks(['next' => 'http://example.com/more-posts']);
        $this->assertEquals($json_api_formatter->getLinks(), $test_complete_links);

        // unset
        $reflection = self::getMethod('getBaseResponseArray');
        $test_object = new JsonApiFormatter();
        $test_object->unsetLinks();
        $response = $reflection->invokeArgs($test_object, []);
        $this->assertFalse(isset($response['links']));

        // force add some links
        $json_api_formatter->setLinks($test_complete_links);
        $json_api_formatter->addLinks(['next' => 'http://example.com/more-posts'], true);
        $this->assertEquals($json_api_formatter->getLinks(), (object)$test_complete_links);

        // check that addLinks catches duplicates
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('The link provided clashes with existing links - it should be added manually');
        $json_api_formatter->addLinks(['next' => 'http://example.com/more-posts']);
    }

    // Constructor

    /**
     * Test the constructor sets the object up correctly
     */
    public function testConstructor()
    {
        $json_api_formatter = new JsonApiFormatter();

        // Defaults
        $this->assertEquals($json_api_formatter->getContentType(), 'application/vnd.api+json');
        $this->assertEquals($json_api_formatter->getData(), null);
        $this->assertEquals($json_api_formatter->getErrors(), []);
        $this->assertEquals($json_api_formatter->getMeta(), new Meta(['status' => null]));
        $this->assertEquals($json_api_formatter->getJsonapi(), (object)['version' => '1.1']);
        $this->assertNull($json_api_formatter->getIncluded());

        $meta = new Meta(['hello' => 'world']);
        $json_api = (object)['application/vnd.api+jsonv2'];
        $links = new Links(
            [
                'self' => 'http://example.com/posts',
                'next' => 'http://example.com/more-posts'
            ]
        );

        $json_api_formatter = new JsonApiFormatter(
            $meta,
            $json_api,
            $links
        );

        // Instantiated items
        $this->assertEquals($json_api_formatter->getMeta(), $meta);
        $this->assertEquals($json_api_formatter->getJsonapi(), $json_api);
        $this->assertEquals($json_api_formatter->getLinks(), $links);
    }

    // Internal method/reflection testing

    /**
     * Tests that encode correctly encodes an array
     */
    public function testCorrectEncode()
    {
        $base_response_array = [
            'data' => null,
            'errors' => [],
            'meta' => [
                'status' => null
            ],
            'jsonapi' => (object)['version' => '1.1']
        ];
        $test_response_array = [
            'data' => [],
            'meta' => [
                'status' => 'changed'
            ],
            'jsonapi' => (object)['version' => '2.0']
        ];

        $reflection = self::getMethod('correctEncode');
        $test_object = new JsonApiFormatter();

        // basic call
        $response = $reflection->invokeArgs($test_object, []);
        $this->assertSame($response, json_encode($base_response_array, true));

        // modified call
        $response = $reflection->invokeArgs($test_object, ['array' => $test_response_array]);
        $this->assertSame($response, json_encode($test_response_array, true));
    }

    // Main functionality : base

    /**
     * @throws ReflectionException
     */
    public function testAutoIncludeJsonapi()
    {
        $reflection = self::getMethod('getBaseResponseArray');
        $test_object = new JsonApiFormatter();
        $test_object->autoIncludeJsonapi();

        // basic call
        $response = $reflection->invokeArgs($test_object, []);

        $this->assertEquals("1.0", $response['jsonapi']->version ?? '');
    }

    // Main functionality : data resources

    /**
     * Tests that data resources throw an exception with no data
     */
    public function testDataResourceResponseNoData()
    {
        $json_api_formatter = new JsonApiFormatter();

        // Instantiates with a null:
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('Data needs to be set to a data resource or array of data resources');
        $json_api_formatter->dataResourceResponse();
    }

    /**
     * Tests json data response against a validated json api response
     */
    public function testDataResourceResponse()
    {
        $json_api_formatter = new JsonApiFormatter();
        $id = (string)'2';
        $id2 = (string)'3';
        $id3 = (string)'4';
        $id4 = (string)'5';
        $type = 'user';
        $attributes = [
            'name' => 'Joe Bloggs',
            'email' => 'joe@bloggs.com'
        ];

        $array = ['hello' => 'world'];
        $data_resource_meta = new DataResourceMeta($array);

        $relationship_links = new RelationshipLinks();
        $relationship_data = new RelationshipData('2', 'test');
        $relationship_meta = new RelationshipMeta();
        $relationships = new Relationships(
            ['foo' => new Relationship($relationship_links, $relationship_data, $relationship_meta)]
        );

        $resource_array = ['id' => $id, 'type' => $type, 'attributes' => $attributes];
        $resource_array2 = ['id' => $id2, 'type' => $type, 'attributes' => $attributes];
        $resource_array3 = [
            'id' => $id3,
            'type' => $type,
            'attributes' => $attributes,
            'meta' => $data_resource_meta->process()
        ];
        $resource_array4 = [
            'id' => $id4,
            'type' => $type,
            'attributes' => $attributes,
            'relationships' => $relationships->process()
        ];

        $data_resource = new DataResource($id, $type, $attributes);
        $data_resource2 = new DataResource($id2, $type, $attributes);
        $data_resource3 = new DataResource($id3, $type, $attributes, $data_resource_meta);
        $data_resource4 = new DataResource($id4, $type, $attributes, null, $relationships);

        // Single data resource

        // make a manually checked correct array:
        $validated_array = [
            'data' => $resource_array,
            'meta' => (object)['status' => null],
            'jsonapi' => (object)['version' => '1.0']
        ];

        $validated_json = json_encode($validated_array, true);
        $response = $json_api_formatter->dataResourceResponse($data_resource);
        $this->assertEquals($validated_json, $response);

        // Data resource array

        $validated_array = [
            'data' => [$resource_array, $resource_array2],
            'meta' => (object)['status' => null],
            'jsonapi' => (object)['version' => '1.0']
        ];

        $validated_array_json = json_encode($validated_array, true);

        $json_api_formatter = new JsonApiFormatter();
        $response = $json_api_formatter->dataResourceResponse([$data_resource, $data_resource2]);

        $this->assertEquals($validated_array_json, $response);

        // Empty array (still valid)

        $validated_array = [
            'data' => [],
            'meta' => (object)['status' => null],
            'jsonapi' => (object)['version' => '1.0']
        ];

        $validated_array_json = json_encode($validated_array, true);

        $json_api_formatter = new JsonApiFormatter();
        $response = $json_api_formatter->dataResourceResponse([]);

        $this->assertEquals($validated_array_json, $response);

        // Data resource array with data resource meta

        $validated_array = [
            'data' => [$resource_array2, $resource_array3],
            'meta' => (object)['status' => null],
            'jsonapi' => (object)['version' => '1.0']
        ];

        $validated_array_json = json_encode($validated_array, true);

        $json_api_formatter = new JsonApiFormatter();
        $response = $json_api_formatter->dataResourceResponse([$data_resource2, $data_resource3]);

        $this->assertEquals($validated_array_json, $response);

        // Data resource array with relationships

        $validated_array = [
            'data' => [$resource_array, $resource_array4],
            'meta' => (object)['status' => null],
            'jsonapi' => (object)['version' => '1.0']
        ];

        $validated_array_json = json_encode($validated_array, true);

        $json_api_formatter = new JsonApiFormatter();
        $response = $json_api_formatter->dataResourceResponse([$data_resource, $data_resource4]);

        $this->assertEquals($validated_array_json, $response);
    }

    /**
     * Tests exceptions are thrown with bad objects
     */
    public function testDataResourceResponseObjectException()
    {
        $json_api_formatter = new JsonApiFormatter();

        // Single data resource

        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('$data needs to be either a DataResource or an array of DataResource objects');
        $json_api_formatter->dataResourceResponse(new StdCLass());
    }

    /**
     * Tests exceptions are thrown with bad objects
     */
    public function testDataResourceResponseArrayException()
    {
        $json_api_formatter = new JsonApiFormatter();

        // Single data resource

        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('$data needs to be either a DataResource or an array of DataResource objects');
        $json_api_formatter->dataResourceResponse([new StdCLass()]);
    }

    // Main functionality: error responses

    /**
     * Tests a badly formed json error response
     */
    public function testErrorResponseException()
    {
        $json_api_formatter = new JsonApiFormatter();

        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('Error responses cannot have an empty errors array');
        $json_api_formatter->errorResponse();
    }

    /**
     * Tests json error response against a validated json api response
     */
    public function testErrorResponse()
    {
        $error = new Error();
        $error->setStatus('400');
        $error->setTitle('Bad request');
        $error->setDetail('The request was not formed well');

        $error2 = new Error();
        $error->setStatus('400');
        $error2->setTitle('Bad request 2');
        $error2->setDetail('The request was not formed well either');

        $test_errors = [$error, $error2];

        // make 2 manually checked correct arrays:
        $validated_array = [
            'errors' => [
                // remember to clear nulls by flattening using process()
                $error->process(),
                $error2->process()
            ],
            'meta' => (object)['status' => null],
            'jsonapi' => (object)['version' => '1.0']
        ];
        $validated_array2 = [
            'errors' => [
                // remember to clear nulls by flattening using process()
                $error2->process()
            ],
            'meta' => (object)['status' => null],
            'jsonapi' => (object)['version' => '1.0']
        ];

        $validated_json = json_encode($validated_array, true);
        $validated_json2 = json_encode($validated_array2, true);

        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->setErrors($test_errors);

        $response = $json_api_formatter->errorResponse();
        $this->assertEquals($validated_json, $response);

        $json_api_formatter = new JsonApiFormatter();
        $response = $json_api_formatter->errorResponse([$error2]);
        $this->assertEquals($validated_json2, $response);
    }

    // reset

    /**
     * Tests that the JsonApiFormatter can be reset
     *
     * @throws JsonApiFormatterException
     * @throws ReflectionException
     */
    public function testReset()
    {
        // set up the objects
        $data_id = "0";
        $data_type = "test";
        $data_attributes = ['test' => 'some_data'];
        $data = new DataResource($data_id, $data_type, $data_attributes);

        $error = new Error();
        $error
            ->setStatus('400')
            ->setTitle('Bad request')
            ->setDetail('The request was not formed well');

        $included_company_id = "1";
        $included_company_type = "company";
        $included_company_attributes = [
            'company' => 'Joe Bloggs Ltd',
            'slug' => null
        ];
        $included_company = new DataResource(
            $included_company_id, $included_company_type, $included_company_attributes
        );
        $included = new Included([$included_company]);

        $links = new Links(
            [
                'self' => 'http://example.com/posts',
                'next' => 'http://example.com/more-posts'
            ]
        );

        $meta = new Meta(
            [
                'status' => '200',
                'info' => 'Request loaded in 34ms'
            ]
        );

        // test data
        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->addData($data);
        $json_api_formatter->reset();
        $reflection = self::getMethod('getBaseResponseArray');
        $response = $reflection->invokeArgs($json_api_formatter, []);
        $this->assertFalse(isset($response['data']));

        // test errors
        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->addErrors([$error]);
        $json_api_formatter->reset();
        $reflection = self::getMethod('getBaseResponseArray');
        $response = $reflection->invokeArgs($json_api_formatter, []);
        $this->assertFalse(isset($response['errors']));

        // test included
        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->setIncluded($included);
        $json_api_formatter->reset();
        $reflection = self::getMethod('getBaseResponseArray');
        $response = $reflection->invokeArgs($json_api_formatter, []);
        $this->assertFalse(isset($response['included']));

        // test links
        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->setLinks($links);
        $json_api_formatter->reset();
        $reflection = self::getMethod('getBaseResponseArray');
        $response = $reflection->invokeArgs($json_api_formatter, []);
        $this->assertFalse(isset($response['links']));

        // test meta
        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->setMeta($meta);
        $json_api_formatter->reset();
        $reflection = self::getMethod('getBaseResponseArray');
        $response = $reflection->invokeArgs($json_api_formatter, []);
        $this->assertFalse(isset($response['meta']));
    }

    // Main functionality: export

    /**
     * Tests the export function
     */
    public function testExport()
    {
        $data_id = "0";
        $data_type = "test";
        $data_attributes = ['test' => 'some_data'];
        $data = new DataResource($data_id, $data_type, $data_attributes);

        $error = new Error();
        $error
            ->setStatus('400')
            ->setTitle('Bad request')
            ->setDetail('The request was not formed well');

        // errors
        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->unsetData();
        $json_api_formatter->addErrors([$error]);

        $error_response_array = [
            // remember to clear nulls by flattening using process()
            'errors' => [(object)$error->process()],
            'meta' => [
                'status' => null
            ],
            'jsonapi' => (object)['version' => '1.1']
        ];

        $this->assertSame($json_api_formatter->export(), json_encode($error_response_array, true));

        // data
        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->unsetErrors();
        $json_api_formatter->addData($data);

        $data_resource_response_array = [
            'data' => $data->process(),
            'meta' => [
                'status' => null
            ],
            'jsonapi' => (object)['version' => '1.1']
        ];

        $this->assertSame(json_encode($data_resource_response_array, true), $json_api_formatter->export());

        // meta

        $meta = new Meta(
            [
                'status' => '200',
                'info' => 'Request loaded in 34ms'
            ]
        );

        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->unsetErrors();
        $json_api_formatter->addData($data);
        $json_api_formatter->setMeta($meta);

        $meta_response_array = [
            'data' => $data->process(),
            'meta' => $meta->process(),
            'jsonapi' => (object)['version' => '1.1']
        ];

        $this->assertSame($json_api_formatter->export(), json_encode($meta_response_array, true));

        // included
        $included_data_resource = new DataResource(
            '2',
            'test',
            ['foo' => 'bar']
        );

        $included = new Included([$included_data_resource]);

        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->unsetErrors();
        $json_api_formatter->addData($data);
        $json_api_formatter->setIncluded($included);

        $included_response_array = [
            'data' => $data->process(),
            'meta' => [
                'status' => null
            ],
            'jsonapi' => (object)['version' => '1.1'],
            'included' => $included->process()
        ];

        $this->assertSame($json_api_formatter->export(), json_encode($included_response_array, true));
    }

    /**
     * Tests the export function
     */
    public function testExportException()
    {
        $data_id = "0";
        $data_type = "test";
        $data_attributes = ['test' => 'some_data'];
        $data = new DataResource($data_id, $data_type, $data_attributes);

        // data
        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->unsetErrors();
        $json_api_formatter->addData($data);

        // Now add errors

        $error = new Error();
        $error
            ->setStatus('400')
            ->setTitle('Bad request')
            ->setDetail('The request was not formed well');

        // errors
        $json_api_formatter->addErrors([$error]);

        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessageMatches('/The provided json structure does not match the json api standard/');
        $json_api_formatter->export();
    }

    // Main functionality: import

    /**
     * Tests the export function
     */
    public function testImportException()
    {
        // data
        $json_api_formatter = new JsonApiFormatter();

        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessageMatches('/The provided json was not valid/');
        $json_api_formatter->import("Not json");
    }

    /**
     * Tests that a data element correctly matches
     */
    public function testImportDataObject()
    {
        $json_array = [
            'data' => [
                'id' => '0',
                'type' => 'test',
                'attributes' => [
                    'foo' => 'bar'
                ]
            ],
            'included' => [
                [
                    'id' => '0',
                    'type' => 'test',
                    'attributes' => [
                        'foo' => 'bar'
                    ]
                ]
            ]
        ];

        $data_json = json_encode($json_array, true);

        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->import($data_json);

        $this->assertEquals($json_api_formatter->getData()->process(), $json_array['data']);
    }

    /**
     * Tests that a data element correctly matches
     */
    public function testImportDataArray()
    {
        $data_array1 = [
            'id' => '0',
            'type' => 'test',
            'attributes' => [
                'foo' => 'bar'
            ]
        ];

        $data_array2 = [
            'id' => '1',
            'type' => 'test',
            'attributes' => [
                'foo' => 'bar'
            ]
        ];

        $json_array = [
            'data' => [$data_array1, $data_array2],
        ];

        $data_json = json_encode($json_array, true);

        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->import($data_json);

        $this->assertEquals($json_api_formatter->getData()[0]->process(), $data_array1);
        $this->assertEquals($json_api_formatter->getData()[1]->process(), $data_array2);
    }

    /**
     * Tests that a data element correctly matches
     */
    public function testImportEmptyDataArray()
    {
        $json_array = [
            'data' => [],
        ];

        $data_json = json_encode($json_array, true);

        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->import($data_json);

        $this->assertEquals($json_api_formatter->getData(), []);
    }

    /**
     * Tests that errors correctly match
     */
    public function testImportErrors()
    {
        $links = new Links(
            [
                'http://link.com',
                new Link(
                    ['href' => 'http://world.com']
                )
            ]
        );

        $source = new Source(
            ['hello' => 'world']
        );
        $status = '400';
        $code = '400';
        $title = 'Bad request';
        $detail = 'The request was not formed well';

        $error = new Error(
            null,
            $links,
            $status,
            $code,
            $title,
            $detail,
            $source
        );

        $json_array = [
            'errors' =>
                [
                    [
                        'status' => $status,
                        'code' => $code,
                        'title' => $title,
                        'detail' => $detail,
                        'links' => [
                            'http://link.com',
                            ['href' => 'http://world.com']
                        ],
                        'source' => ['hello' => 'world']
                    ]
                ]
        ];

        $errors_json = json_encode($json_array, true);
        $json_api_formatter = new JsonApiFormatter();

        $json_api_formatter->import($errors_json);

        $errors = $json_api_formatter->getErrors();
        $error = $errors[0];

        // test
        $this->assertEquals($status, $error->getStatus());
        $this->assertEquals($code, $error->getCode());
        $this->assertEquals($title, $error->getTitle());
        $this->assertEquals($detail, $error->getDetail());
        $this->assertEquals($links, $error->getLinks());
        $this->assertEquals($source, $error->getSource());
    }

    /**
     * Tests that errors correctly match
     */
    public function testImportErrorsNullSource()
    {
        $links = new Links(
            [
                'http://link.com',
                new Link(
                    ['href' => 'http://world.com']
                )
            ]
        );
        $status = '400';
        $code = '400';
        $title = 'Bad request';
        $detail = 'The request was not formed well';

        $error = new Error(
            null,
            $links,
            $status,
            $code,
            $title,
            $detail
        );

        $json_array = [
            'errors' =>
                [
                    [
                        'status' => $status,
                        'code' => $code,
                        'title' => $title,
                        'detail' => $detail,
                        'links' => [
                            'http://link.com',
                            ['href' => 'http://world.com']
                        ],
                        'source' => null
                    ]
                ]
        ];

        $errors_json = json_encode($json_array, true);
        $json_api_formatter = new JsonApiFormatter();

        $json_api_formatter->import($errors_json);

        $errors = $json_api_formatter->getErrors();
        $error = $errors[0];

        // test
        $this->assertEquals($status, $error->getStatus());
        $this->assertEquals($code, $error->getCode());
        $this->assertEquals($title, $error->getTitle());
        $this->assertEquals($detail, $error->getDetail());
        $this->assertEquals($links, $error->getLinks());
        $this->assertNull($error->getSource());
    }

    /**
     * Tests that meta correctly matches
     */
    public function testImportMeta()
    {
        $json_array = [
            'data' => [
                'id' => '0',
                'type' => 'test',
                'attributes' => [
                    'foo' => 'bar'
                ]
            ],
            'meta' => [
                'status' => '200'
            ],
        ];

        $meta_json = json_encode($json_array, true);
        $json_api_formatter = new JsonApiFormatter();

        $json_api_formatter->import($meta_json);

        $this->assertEquals($json_api_formatter->getMeta(), new Meta($json_array['meta']));
    }

    /**
     * Tests that included correctly matches
     */
    public function testImportIncluded()
    {
        $json_array = [
            'data' => [
                'id' => '0',
                'type' => 'test',
                'attributes' => [
                    'foo' => 'bar'
                ]
            ],
            'meta' => [
                'status' => '200'
            ],
            'included' => [
                [
                    "id" => "2",
                    "type" => "test",
                    "attributes" => [
                        "foo" => "bar"
                    ]
                ]
            ]
        ];

        $included_json = json_encode($json_array, true);
        $json_api_formatter = new JsonApiFormatter();

        $json_api_formatter->import($included_json);

        $included_data_resource = new DataResource("2", "test", ["foo" => "bar"]);
        $this->assertEquals($json_api_formatter->getIncluded(), new Included([$included_data_resource]));
    }

    // Main functionality : validation

    /**
     * @throws JsonApiFormatterException
     */
    public function testQuickValidatorArrayExceptionNone()
    {
        $json_api_formatter = new JsonApiFormatter();

        $bad_array = [];

        // First exception hit is 'id'
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage(
            'The provided json structure does not match the json api standard - no data or error array found'
        );
        $json_api_formatter->quickValidatorArray($bad_array);
    }

    /**
     * @throws JsonApiFormatterException
     */
    public function testQuickValidatorArrayExceptionBoth()
    {
        $json_api_formatter = new JsonApiFormatter();

        $bad_array = ['data' => [], 'errors' => []];

        // First exception hit is 'id'
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage(
            'The provided json structure does not match the json api standard - only one data or error array must be used'
        );
        $json_api_formatter->quickValidatorArray($bad_array);
    }

    /**
     * @throws JsonApiFormatterException
     */
    public function testQuickValidatorDataResourceArraySingle()
    {
        $json_api_formatter = new JsonApiFormatter();

        $good_array = ['id' => "2", "type" => "test", "attributes" => ["hello" => "world"]];
        $bad_array = ['id' => "2"];

        $this->assertTrue($json_api_formatter->quickValidatorDataResourceArray($good_array));

        // First exception hit is 'type'
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage(
            'The provided array is not valid. It needs to be a DataResource object in array form, or an array of DataResource objects in array form'
        );
        $json_api_formatter->quickValidatorDataResourceArray($bad_array);
    }

    /**
     * @throws JsonApiFormatterException
     */
    public function testQuickValidatorDataResourceArrayArray()
    {
        $json_api_formatter = new JsonApiFormatter();

        $good_array = [
            ['id' => "2", "type" => "test", "attributes" => ["hello" => "world"]],
            ['id' => "3", "type" => "test", "attributes" => ["hello" => "world"]],
        ];
        $bad_array = [['id' => "2"], ['id' => "3"]];

        $this->assertTrue($json_api_formatter->quickValidatorDataResourceArray($good_array));

        // First exception hit is 'type'
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage(
            'The provided array is not valid. Resource objects require a type'
        );
        $json_api_formatter->quickValidatorDataResourceArray($bad_array);
    }

    /**
     * @throws JsonApiFormatterException
     */
    public function testValidateDataResourceArray()
    {
        $json_api_formatter = new JsonApiFormatter();

        $good_array = ['id' => "2", "type" => "test", "attributes" => ["hello" => "world"]];

        $this->assertTrue($json_api_formatter->quickValidatorDataResourceArray($good_array));
    }

    /**
     * @throws JsonApiFormatterException
     */
    public function testValidateDataResourceArrayExceptionId()
    {
        $json_api_formatter = new JsonApiFormatter();

        $bad_array = [['type' => "test"]];

        // First exception hit is 'id'
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage(
            'The provided array is not valid. Resource objects require an id.'
        );
        $json_api_formatter->quickValidatorDataResourceArray($bad_array);
    }

    /**
     * @throws JsonApiFormatterException
     */
    public function testValidateDataResourceArrayExceptionBadId()
    {
        $json_api_formatter = new JsonApiFormatter();

        $bad_array = [['id' => 2]];

        // First exception hit is 'id'
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage(
            'The provided array is not valid. A resource object id must be a string.'
        );
        $json_api_formatter->quickValidatorDataResourceArray($bad_array);
    }

    /**
     * @throws JsonApiFormatterException
     */
    public function testValidateDataResourceArrayExceptionType()
    {
        $json_api_formatter = new JsonApiFormatter();

        $bad_array = [['id' => "2"]];

        // First exception hit is 'id'
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage(
            'The provided array is not valid. Resource objects require a type.'
        );
        $json_api_formatter->quickValidatorDataResourceArray($bad_array);
    }

    /**
     * @throws JsonApiFormatterException
     */
    public function testValidateDataResourceArrayExceptionBadType()
    {
        $json_api_formatter = new JsonApiFormatter();

        $bad_array = [['id' => "2", "type" => 2]];

        // First exception hit is 'id'
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage(
            'The provided array is not valid. A resource object type must be a string.'
        );
        $json_api_formatter->quickValidatorDataResourceArray($bad_array);
    }

    /**
     * @throws JsonApiFormatterException
     */
    public function testValidateDataResourceArrayExceptionAttributes()
    {
        $json_api_formatter = new JsonApiFormatter();

        $bad_array = [['id' => "2", "type" => "test"]];

        // First exception hit is 'id'
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage(
            'The provided array is not valid. Resource objects require an attributes array.'
        );
        $json_api_formatter->quickValidatorDataResourceArray($bad_array);
    }

    /**
     * @throws JsonApiFormatterException
     */
    public function testValidateDataResourceArrayExceptionBadAttributes()
    {
        $json_api_formatter = new JsonApiFormatter();

        $bad_array = ['id' => "2", "type" => "test", "attributes" => 2];

        // First exception hit is 'id'
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage(
            'The provided array is not valid. A resource object attributes must be an array.'
        );
        $json_api_formatter->quickValidatorDataResourceArray($bad_array);
    }

    /**
     * @throws JsonApiFormatterException
     */
    public function testIsDataResourceResponse()
    {
        $json_api_formatter = new JsonApiFormatter();

        $json_api_formatter->setData(new DataResource('1', 'test', ['hello' => 'world']));

        $this->assertTrue(
            $json_api_formatter->isDataResourceResponse(),
            'isDataResourceResponse did not find a data response'
        );

        $json_api_formatter->reset();

        $json_api_formatter->setErrors([new Error('0')]);

        $this->assertFalse(
            $json_api_formatter->isDataResourceResponse(),
            'isDataResourceResponse found a data response when it should not have'
        );
    }

    /**
     * @throws JsonApiFormatterException
     */
    public function testIsErrorResponse()
    {
        $json_api_formatter = new JsonApiFormatter();

        $json_api_formatter->setData(new DataResource('1', 'test', ['hello' => 'world']));

        $this->assertFalse(
            $json_api_formatter->isErrorResponse(),
            'isDataResourceResponse found an error response when it should not have'
        );

        $json_api_formatter->reset();

        $json_api_formatter->setErrors([new Error('0')]);

        $this->assertTrue(
            $json_api_formatter->isErrorResponse(),
            'isDataResourceResponse did not find an error response'
        );
    }

    // Non testing functions

    /**
     * Set up reflection method
     *
     * @param $name
     * @return ReflectionMethod
     * @throws ReflectionException
     */
    protected static function getMethod($name): ReflectionMethod
    {
        $class = new ReflectionClass(JsonApiFormatter::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
