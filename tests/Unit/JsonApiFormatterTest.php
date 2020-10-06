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
 * @version   1.0
 * @since     File available since Release 1.0
 *
 */

namespace Floor9design\JsonApiFormatter\Tests\Unit;

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use stdClass;

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
 * @version   1.0
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
        $test_partial_data = [
            'id' => '0',
            'type' => 'data',
        ];

        $test_complete_data = [
            'id' => '0',
            'type' => 'data',
            'attributes' => 'some_data'
        ];

        $json_api_formatter = new JsonApiFormatter();

        // Valid get and set
        $json_api_formatter->setData($test_complete_data);
        $this->assertEquals($json_api_formatter->getData(), $test_complete_data);

        // make a partial and extend
        $json_api_formatter->setData($test_partial_data);
        $json_api_formatter->addData(['attributes' => 'some_data']);
        $this->assertEquals($json_api_formatter->getData(), $test_complete_data);

        // unset
        $reflection = self::getMethod('getBaseResponseArray');
        $test_object = new JsonApiFormatter();
        $test_object->unsetData();
        $response = $reflection->invokeArgs($test_object, []);
        $this->assertFalse(isset($response['data']));

        // check that addData catches duplicates
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('The data provided clashes with existing data - it should be added manually');
        $json_api_formatter->addData(['attributes' => 'some_data']);

    }

    /**
     * Test errors accessors.
     *
     * @return void
     */
    public function testErrorsAccessors()
    {
        $error = new StdClass();
        $error->status = '400';
        $error->title = 'Bad request';
        $error->detail = 'The request was not formed well';

        $error2 = new StdClass();
        $error2->status = '400';
        $error2->title = 'Bad request 2';
        $error2->detail = 'The request was not formed well either';

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
    }

    /**
     * Test meta accessors.
     *
     * @return void
     */
    public function testMetaAccessors()
    {
        $test_default_meta = [
            'status' => null
        ];

        $test_partial_meta = [
            'status' => '200'
        ];

        $test_complete_meta = [
            'status' => '200',
            'info' => 'Request loaded in 34ms'
        ];

        $json_api_formatter = new JsonApiFormatter();

        // check the default value
        $this->assertEquals($json_api_formatter->getMeta(), $test_default_meta);

        // Valid get and set
        $json_api_formatter->setMeta($test_complete_meta);
        $this->assertEquals($json_api_formatter->getMeta(), $test_complete_meta);

        // make a partial and extend
        $json_api_formatter->setMeta($test_partial_meta);
        $json_api_formatter->addMeta(['info' => 'Request loaded in 34ms']);
        $this->assertEquals($json_api_formatter->getMeta(), $test_complete_meta);

        // check that addMeta catches duplicates
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('The meta provided clashes with existing meta - it should be added manually');
        $json_api_formatter->addMeta(['info' => 'Request loaded in 34ms']);
    }

    /**
     * Test jsonapi accessors.
     *
     * @return void
     */
    public function testJsonapiAccessors()
    {
        $test_default_jsonapi = (object)['version' => '1.0'];

        $test_replacement_meta = (object)['version' => '1.1'];

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
     */
    public function testIncludedAccessors()
    {
        $included_company = (object)[
            'type' => 'company',
            'id' => '1',
            'attributes' => [
                'company' => 'Joe Bloggs Ltd',
                'slug' => null
            ]
        ];

        $test_basic_included = [$included_company];
        $test_extended_included = [$included_company, $included_company];

        $json_api_formatter = new JsonApiFormatter();

        // Valid get and set
        $json_api_formatter->setIncluded($test_basic_included);
        $this->assertEquals($json_api_formatter->getIncluded(), $test_basic_included);

        // make a partial and extend
        $json_api_formatter->setIncluded($test_basic_included);
        $json_api_formatter->addIncluded([$included_company]);
        $this->assertEquals($json_api_formatter->getIncluded(), $test_extended_included);
    }

    /**
     * Test links accessors.
     *
     * @return void
     */
    public function testLinksAccessors()
    {
        $test_partial_links = (object)[
            'self' => 'http://example.com/posts'
        ];

        $test_complete_links = (object)[
            'self' => 'http://example.com/posts',
            'next' => 'http://example.com/more-posts'
        ];

        $json_api_formatter = new JsonApiFormatter();

        // Valid get and set
        $json_api_formatter->setLinks($test_complete_links);
        $this->assertEquals($json_api_formatter->getLinks(), $test_complete_links);

        // make a partial and extend
        $json_api_formatter->setLinks($test_partial_links);
        $json_api_formatter->addLinks(['next' => 'http://example.com/more-posts']);
        $this->assertEquals($json_api_formatter->getLinks(), $test_complete_links);
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
        $this->assertEquals($json_api_formatter->getMeta(), ['status' => null]);
        $this->assertEquals($json_api_formatter->getJsonapi(), (object)['version' => '1.0']);
        $this->assertNull($json_api_formatter->getIncluded());

        $meta = ['hello' => 'world'];
        $json_api = (object)['application/vnd.api+jsonv2'];
        $links = (object)[
            'self' => 'http://example.com/posts',
            'next' => 'http://example.com/more-posts'
        ];

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
            'jsonapi' => (object)['version' => '1.0']
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

        //
    }

    /**
     * Test that validation errors if you include data and errors together
     */
    public function testValidationDataAndErrors()
    {
        $reflection = self::getMethod('validateObject');
        $test_object = new JsonApiFormatter();

        $test_object->setData([]);
        $test_object->setErrors([]);

        // basic call
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('Both data and errors properties are set');
        $reflection->invokeArgs($test_object, []);
    }

    /**
     * Tests validation with good packets
     */
    public function testValidationData()
    {
        $reflection = self::getMethod('validateObject');
        $test_object = new JsonApiFormatter();

        // null data check
        $test_object->setData(null);
        $test_object->setErrors([]);

        $response = $reflection->invokeArgs($test_object, []);
        $this->assertTrue($response instanceof JsonApiFormatter);

        // null errors check
        $test_object->setData([]);
        $test_object->unsetErrors();

        // null errors check
        $response = $reflection->invokeArgs($test_object, []);
        $this->assertTrue($response instanceof JsonApiFormatter);

    }

    // Main functionality

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
        $error = new StdClass();
        $error->status = '400';
        $error->title = 'Bad request';
        $error->detail = 'The request was not formed well';

        $error2 = new StdClass();
        $error2->status = '400';
        $error2->title = 'Bad request 2';
        $error2->detail = 'The request was not formed well either';

        $test_errors = [$error, $error2];

        // make 2 manually checked correct arrays:
        $validated_array = [
            'errors' => [
                $error,
                $error2
            ],
            'meta' => (object)['status' => null],
            'jsonapi' => (object)['version' => '1.0']
        ];
        $validated_array2 = [
            'errors' => [
                $error2
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

    /**
     * Tests a badly formed json error response
     */
    public function testDataResourceResponseExceptionId()
    {
        $json_api_formatter = new JsonApiFormatter();

        // First exception hit is 'id'
        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('Data responses require the data id to be set');
        $json_api_formatter->dataResourceResponse();
    }

    /**
     * Tests a badly formed json error response
     */
    public function testDataResourceResponseExceptionType()
    {
        $json_api_formatter = new JsonApiFormatter();

        // Add an 'id', then run again triggering a 'type' exception
        $this->expectException(JsonApiFormatterException::class);
        $json_api_formatter->setData(['id' => '1']);
        $this->expectExceptionMessage('Data responses require the data type to be set');
        $json_api_formatter->dataResourceResponse();
    }

    /**
     * Tests a badly formed json error response
     */
    public function testDataResourceResponseExceptionAttributes()
    {
        $json_api_formatter = new JsonApiFormatter();

        // Further add a 'type', then run again triggering a 'attributes' exception
        $this->expectException(JsonApiFormatterException::class);
        $json_api_formatter->setData(['id' => '1', 'type' => 'user']);
        $this->expectExceptionMessage('Data responses cannot have an empty attributes array');
        $json_api_formatter->dataResourceResponse();
    }

    /**
     * Tests json data response against a validated json api response
     */
    public function testDataResourceResponse()
    {
        $id = (string)'2';
        $type = 'user';
        $attributes = [
            'name' => 'Joe Bloggs',
            'email' => 'joe@bloggs.com'
        ];

        // make a manually checked correct array:
        $validated_array = [
            'data' => [
                'id' => $id,
                'type' => $type,
                'attributes' => $attributes
            ],
            'meta' => (object)['status' => null],
            'jsonapi' => (object)['version' => '1.0']
        ];
        $validated_json = json_encode($validated_array, true);

        $json_api_formatter = new JsonApiFormatter();
        $response = $json_api_formatter->dataResourceResponse($id, $type, $attributes);
        $this->assertEquals($validated_json, $response);

        // Catch a zero as id (an add)
        $id = (string)'0';
        $type = 'user';
        $attributes = [
            'name' => 'Dave Bloggs',
            'email' => 'dave@bloggs.com'
        ];

        // make a manually checked correct array:
        $validated_array = [
            'data' => [
                'id' => $id,
                'type' => $type,
                'attributes' => $attributes
            ],
            'meta' => (object)['status' => null],
            'jsonapi' => (object)['version' => '1.0']
        ];
        $validated_json = json_encode($validated_array, true);

        $json_api_formatter = new JsonApiFormatter();
        $response = $json_api_formatter->dataResourceResponse($id, $type, $attributes);
        $this->assertEquals($validated_json, $response);
    }

    /**
     * Tests that invalid JSON is caught
     */
    public function testExportException()
    {
        $not_json = 'Not json';
        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->setData([]);

        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('The provided json was not valid');
        $json_api_formatter->import($not_json);
    }

    /**
     * Tests the export function
     */
    public function testExport()
    {
        $data = [
            'id' => '0',
            'type' => 'data',
            'attributes' => 'some_data'
        ];

        $error = [
            'status' => '400',
            'title' => 'Bad request',
            'detail' => 'The request was not formed well'
        ];

        // errors
        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->unsetData();
        $json_api_formatter->addErrors([$error]);

        $error_response_array = [
            'errors' => [$error],
            'meta' => [
                'status' => null
            ],
            'jsonapi' => (object)['version' => '1.0']
        ];

        $this->assertSame($json_api_formatter->export(), json_encode($error_response_array, true));

        // data
        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->unsetErrors();
        $json_api_formatter->addData($data);

        $error_response_array = [
            'data' => $data,
            'meta' => [
                'status' => null
            ],
            'jsonapi' => (object)['version' => '1.0']
        ];

        $this->assertSame($json_api_formatter->export(), json_encode($error_response_array, true));

        // meta

        $meta = [
            'status' => '200',
            'info' => 'Request loaded in 34ms'
        ];

        $json_api_formatter = new JsonApiFormatter();
        $json_api_formatter->unsetErrors();
        $json_api_formatter->addData($data);
        $json_api_formatter->setMeta($meta);

        $error_response_array = [
            'data' => $data,
            'meta' => $meta,
            'jsonapi' => (object)['version' => '1.0']
        ];

        $this->assertSame($json_api_formatter->export(), json_encode($error_response_array, true));
    }

    /**
     * Tests that invalid JSON is caught
     */
    public function testImportExceptionNotJson()
    {
        $not_json = 'a non-json string';
        $json_api_formatter = new JsonApiFormatter();

        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('The provided json was not valid');
        $json_api_formatter->import($not_json);
    }

    /**
     * Tests that badly formed json is caught (no data or errors properties in json)
     */
    public function testImportExceptionBadJson()
    {
        $bad_json = '{"foo":"bar"}';
        $json_api_formatter = new JsonApiFormatter();

        $this->expectException(JsonApiFormatterException::class);
        $this->expectExceptionMessage('The provided json does not match the json api standard');
        $json_api_formatter->import($bad_json);
    }

    /**
     * Tests that a data element correctly matches
     */
    public function testImportData()
    {
        $json_array = [
            'data' => [
                'id' => '0',
                'type' => 'test',
                'attributes' => [
                    'foo' => 'bar'
                ]
            ]
        ];

        $data_json = json_encode($json_array, true);
        $json_api_formatter = new JsonApiFormatter();

        $json_api_formatter->import($data_json);

        $this->assertEquals($json_api_formatter->getData(), $json_array['data']);
    }

    /**
     * Tests that errors correctly match
     */
    public function testImportErrors()
    {
        $json_array = [
            'errors' => [
                [
                    'status' => '400',
                    'title' => 'Bad request',
                    'detail' => 'The request was not formed well',
                ]
            ],
        ];

        $errors_json = json_encode($json_array, true);
        $json_api_formatter = new JsonApiFormatter();

        $json_api_formatter->import($errors_json);

        $this->assertEquals($json_api_formatter->getErrors(), $json_array['errors']);
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

        $this->assertEquals($json_api_formatter->getMeta(), $json_array['meta']);
    }

    // Non testing functions

    /**
     * Set up reflection method
     *
     * @param $name
     * @return mixed
     * @throws \ReflectionException
     */
    protected static function getMethod($name)
    {
        $class = new ReflectionClass(JsonApiFormatter::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
