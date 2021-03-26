<?php
/**
 * JsonApiFormatter.php
 *
 * JsonApiFormatter class
 *
 * php 7.4+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   1.0
 * @link      https://www.floor9design.com
 * @since     File available since Release 1.0
 *
 */

namespace Floor9design\JsonApiFormatter\Models;

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;
use stdClass;

/**
 * Class JsonApiFormatter
 *
 * Class to offer methods/properties to format items ready for a Json Api request.
 * These are set to the v1.0 specification, defined at https://jsonapi.org/format/
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   1.0
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     File available since Release 1.0
 * @see       https://jsonapi.org/format/
 */
class JsonApiFormatter
{
    // Properties

    /**
     * @var string The precise response type expected by JSON API
     */
    public string $content_type = 'application/vnd.api+json';

    /**
     * A clean array to populate, including the main required elements
     *
     * @var array
     */
    protected array $base_response_array = [
        'data' => null, // can exist as null
        'errors' => [], // must be an array
        'meta' => null // must be an object
    ];

    // Accessors and advanced accessors

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->content_type;
    }

    /**
     * @return array
     * @see $base_response_array
     */
    protected function getBaseResponseArray(): array
    {
        return $this->base_response_array;
    }

    /**
     * @return null|array|DataResource
     */
    public function getData()
    {
        return $this->getBaseResponseArray()['data'] ?? null;
    }

    /**
     * Fluently sets data to the $base_response_array['data']
     *
     * @param DataResource|array|null $data
     * @return JsonApiFormatter
     * @throws JsonApiFormatterException
     */
    public function setData($data = null): JsonApiFormatter
    {
        // catch bad data:
        if (!($data instanceof DataResource || is_array($data))) {
            $error = '$data needs to be either a DataResource or an array of DataResource objects';
            throw new JsonApiFormatterException($error);
        }

        if (is_array($data)) {
            foreach ($data as $datum) {
                if (!$datum instanceof DataResource) {
                    $error = '$data needs to be either a DataResource or an array of DataResource objects';
                    throw new JsonApiFormatterException($error);
                }
            }
        }

        $this->base_response_array['data'] = $data;
        return $this;
    }

    /**
     * Fluently adds data to $base_response_array['data']
     * @param DataResource $extra_data
     * @return JsonApiFormatter
     * @throws JsonApiFormatterException
     */
    public function addData(DataResource $extra_data): JsonApiFormatter
    {
        $data = $this->getData();

        if (is_array($data)) {
            // add to an existing array
            $data[] = $extra_data;
            $this->setData($data);
        } else {
            if ($data) {
                // turn data into an array
                $array_data = [$data, $extra_data];
                $this->setData($array_data);
            } else {
                // add a singular data
                $this->setData($extra_data);
            }
        }

        return $this;
    }

    /**
     * Fluently unset $base_response_array['data']
     * @return JsonApiFormatter
     */
    public function unsetData(): JsonApiFormatter
    {
        unset($this->base_response_array['data']);
        return $this;
    }

    /**
     * @return null|array
     */
    public function getErrors(): ?array
    {
        return $this->getBaseResponseArray()['errors'] ?? null;
    }

    /**
     * Fluently sets errors to the $base_response_array['errors']
     *
     * @param array $errors
     * @return JsonApiFormatter
     * @throws JsonApiFormatterException
     */
    public function setErrors(array $errors): JsonApiFormatter
    {
        foreach ($errors as $error) {
            if (!$error instanceof Error) {
                $error_message = '$errors needs to be an array of Error objects';
                throw new JsonApiFormatterException($error_message);
            }
        }

        $this->base_response_array['errors'] = $errors;
        return $this;
    }

    /**
     * Fluently adds error to $base_response_array['errors']
     * @param array $extra_errors
     * @return JsonApiFormatter
     * @throws JsonApiFormatterException
     */
    public function addErrors(array $extra_errors): JsonApiFormatter
    {
        $errors = $this->getErrors() ?? [];
        foreach ($extra_errors as $error) {
            if (!$error instanceof Error) {
                $error_message = '$errors needs to be an array of Error objects';
                throw new JsonApiFormatterException($error_message);
            }

            $errors[] = $error;
        }

        $this->setErrors($errors);
        return $this;
    }

    /**
     * Fluently unset $base_response_array['errors']
     * @return JsonApiFormatter
     */
    public function unsetErrors(): JsonApiFormatter
    {
        unset($this->base_response_array['errors']);
        return $this;
    }

    /**
     * @return null|stdClass
     */
    public function getMeta(): ?Meta
    {
        return $this->getBaseResponseArray()['meta'] ?? null;
    }

    /**
     * Fluently sets meta to the $base_response_array['meta']
     *
     * @param stdClass $meta
     * @return JsonApiFormatter
     */
    public function setMeta(Meta $meta): JsonApiFormatter
    {
        $this->base_response_array['meta'] = $meta;
        return $this;
    }

    /**
     * Fluently adds meta to $base_response_array['meta']
     * @param array $extra_meta
     * @param bool $overwrite allows overwrites of existing keys
     * @return JsonApiFormatter
     * @throws JsonApiFormatterException
     */
    public function addMeta(Meta $extra_meta, bool $overwrite = false): JsonApiFormatter
    {
        $meta = $this->getMeta();
        if (!$meta) {
            $meta = new Meta();
        }

        // catch duplicates
        foreach ($extra_meta->toArray() as $key => $new_meta) {
            if (!$overwrite && property_exists($meta, $key)) {
                throw new JsonApiFormatterException(
                    'The meta provided clashes with existing meta - it should be added manually'
                );
            }

            $meta->$key = $new_meta;
        }


        $this->setMeta($meta);

        return $this;
    }

    /**
     * Fluently unset $base_response_array['meta']
     * @return JsonApiFormatter
     */
    public function unsetMeta(): JsonApiFormatter
    {
        unset($this->base_response_array['meta']);
        return $this;
    }

    /**
     * @return null|array
     */
    public function getJsonapi(): ?StdClass
    {
        return $this->getBaseResponseArray()['jsonapi'] ?? null;
    }

    /**
     * Fluently sets jsonapi to the $base_response_array['jsonapi']
     *
     * @param object $jsonapi
     * @return JsonApiFormatter
     */
    public function setJsonapi(object $jsonapi): JsonApiFormatter
    {
        $this->base_response_array['jsonapi'] = $jsonapi;
        return $this;
    }

    /**
     * Fluently sets jsonapi to the $base_response_array['jsonapi'] to the standard value
     *
     * @return JsonApiFormatter
     */
    public function autoIncludeJsonapi(): JsonApiFormatter
    {
        // Cant form an object before instantiation, so do it here:
        $this->base_response_array['jsonapi'] = (object)['version' => '1.0'];
        return $this;
    }

    /**
     * @return null|array
     */
    public function getLinks(): ?Links
    {
        return $this->getBaseResponseArray()['links'] ?? null;
    }

    /**
     * Fluently sets links to the $base_response_array['links']
     *
     * @param stdClass $links
     * @return JsonApiFormatter
     */
    public function setLinks(Links $links): JsonApiFormatter
    {
        $this->base_response_array['links'] = $links;
        return $this;
    }

    /**
     * Fluently adds an array of links items to $base_response_array['links'] object
     * @param array $extra_links
     * @param bool $overwrite allows overwrites of existing keys
     * @return JsonApiFormatter
     * @throws JsonApiFormatterException
     */
    public function addLinks(array $extra_links, bool $overwrite = false): JsonApiFormatter
    {
        $links = $this->getLinks() ?? new Links();

        // catch duplicates
        foreach ($extra_links as $name => $new_link) {
            if (!$overwrite && property_exists($links, $name)) {
                throw new JsonApiFormatterException(
                    'The link provided clashes with existing links - it should be added manually'
                );
            }

            $links->addLink($name, $new_link);
        }

        $this->setLinks($links);
        return $this;
    }

    /**
     * Fluently unset $base_response_array['links']
     * @return JsonApiFormatter
     */
    public function unsetLinks(): JsonApiFormatter
    {
        unset($this->base_response_array['links']);
        return $this;
    }

    /**
     * @return null|array
     */
    public function getIncluded(): ?array
    {
        return $this->getBaseResponseArray()['included'] ?? null;
    }

    /**
     * Fluently sets included to the $base_response_array['included']
     *
     * @param array $included
     * @return JsonApiFormatter
     */
    public function setIncluded(array $included): JsonApiFormatter
    {
        $this->base_response_array['included'] = $included;
        return $this;
    }

    /**
     * Fluently adds included to $base_response_array['included']
     * @param array $extra_included
     * @param bool $overwrite
     * @return JsonApiFormatter
     * @throws JsonApiFormatterException
     */
    public function addIncluded(array $extra_included): JsonApiFormatter
    {
        $includeds = $this->getIncluded() ?? [];

        foreach ($extra_included as $included) {
            $includeds[] = $included;
        }

        $this->setIncluded($includeds);
        return $this;
    }

    // constructor

    /**
     * Sets up the object quickly with optional items
     *
     * JsonApiFormatter constructor.
     * @param stdClass|null $meta
     * @param stdClass|null $json_api
     * @param stdClass|null $links
     */
    public function __construct(
        ?Meta $meta = null,
        ?stdClass $json_api = null,
        ?Links $links = null
    ) {
        // Cant form an object before instantiation, so do it here:
        $this->base_response_array['jsonapi'] = (object)['version' => '1.0'];

        if ($meta ?? false) {
            $this->setMeta($meta);
        } else {
            $this->setMeta(new Meta(['status' => null]));
        }

        if ($json_api ?? false) {
            $this->setJsonapi($json_api);
        }

        if ($links ?? false) {
            $this->setLinks($links);
        }
    }

    // private functions

    /**
     * Correctly encodes the string, catching issues such as:
     * "you need to specify associative array, else it is invalid json"
     *
     * @param array|null $array $array
     * @return string
     */
    private function correctEncode(?array $array = null): string
    {
        if ($array) {
            $content = $array;
        } else {
            $content = $this->getBaseResponseArray();
        }

        return json_encode($content, true);
    }

    // Main functionality:

    /**
     * Attempts to export the current contents in a valid JSON string.
     * This will validate the data but will not set it up correctly for you.
     *
     * You probably actually want to use the other functions: eg dataResourceResponse
     *
     * @return string
     * @throws JsonApiFormatterException
     * @see errorResponse
     * @see dataResourceResponse
     *
     */
    public function export(): string
    {
        $this->quickValidatorArray($this->getBaseResponseArray());
        return $this->correctEncode();
    }

    /**
     * Attempts to import/decode a json api compliant string into a JsonApiFormatter object,
     * setting the appropriate properties
     *
     * @param string $json The source json
     * @return JsonApiFormatter
     * @throws JsonApiFormatterException
     */
    public function import(string $json): JsonApiFormatter
    {
        $decoded_json = json_decode($json, true);

        // not json
        if (!$decoded_json) {
            throw new JsonApiFormatterException('The provided json was not valid');
        }

        // attempt to set up data
        if ($decoded_json['data'] ?? false) {
            // validate it
            $this->quickValidatorDataResourceArray($decoded_json['data']);

            if ($decoded_json['data']['type'] ?? false) {
                // singular
                $this->setData(
                    new DataResource(
                        $decoded_json['data']['id'],
                        $decoded_json['data']['type'],
                        $decoded_json['data']['attributes']
                    )
                );
            } else {
                // array
                foreach ($decoded_json['data'] as $datum) {
                    $this->addData(
                        new DataResource(
                            $datum['id'],
                            $datum['type'],
                            $datum['attributes']
                        )
                    );
                }
            }
        }

        // attempt to set up errors
        if ($decoded_json['errors'] ?? false) {
            $errors = [];

            foreach ($decoded_json['errors'] as $error) {
                // import links
                if ($error['links'] ?? null) {
                    $links = new Links();

                    foreach ($error['links'] as $link) {
                        if (is_string($link)) {
                            $links[] = $link;
                        } else {
                            $new_link = new Link($link);
                            $links[] = $new_link;
                        }
                    }
                }

                // format source
                $source = $error['source'] ?? null;
                if ($source) {
                    $source = (object)$source;
                }

                $errors[] = new Error(
                    $error['id'] ?? null,
                    $links ?? null,
                    $error['status'] ?? null,
                    $error['code'] ?? null,
                    $error['title'] ?? null,
                    $error['detail'] ?? null,
                    $source
                );
            }

            $this->setErrors($errors);
        }

        // attempt to set up meta
        if ($decoded_json['meta'] ?? false) {
            $this->setMeta(new Meta($decoded_json['meta']));
        }

        // attempt to set up included
        if ($decoded_json['included'] ?? false) {
            $this->setIncluded($decoded_json['included']);
        }

        return $this;
    }

    /**
     * @param array $errors
     * @return string
     * @throws JsonApiFormatterException
     */
    public function errorResponse(
        array $errors = []
    ): string {
        $this->errorResponseArray($errors);
        return $this->correctEncode();
    }

    /**
     * @param array $errors
     * @return string
     * @throws JsonApiFormatterException
     */
    public function errorResponseArray(
        array $errors = []
    ): array {
        // clear data and links: it must not be set in an error response
        $this->unsetData()->unsetLinks();

        // if no errors are passed, try to load this object's errors:
        if (!count($errors) == 0) {
            $this->addErrors($errors);
        }

        // Catch empty errors array: it needs to exist!
        if (count($this->getErrors()) == 0) {
            throw new JsonApiFormatterException("Error responses cannot have an empty errors array");
        }

        $this->autoIncludeJsonapi();

        return $this->getBaseResponseArray();
    }

    /**
     * @param array|DataResource $data_resources
     * @return string
     * @throws JsonApiFormatterException
     */
    public function dataResourceResponse($data_resources = null): string
    {
        // if there's no resources provided, load internally
        if (!$data_resources) {
            $data_resources = $this->getData();

            // empty is not allowed::
            if (!$data_resources) {
                throw new JsonApiFormatterException('A Data resource requires data to be generated');
            }
        }
        $this->dataResourceResponseArray($data_resources);
        return $this->correctEncode();
    }

    /**
     * @param array|DataResource $data_resources
     * @return array
     * @throws JsonApiFormatterException
     */
    public function dataResourceResponseArray($data_resources): array
    {
        // clear errors: it must not be set in an dataResource response
        unset($this->base_response_array['errors']);

        // catch bad data:
        if (!($data_resources instanceof DataResource || is_array($data_resources))) {
            $error = '$data_resources needs to be a data resource or array of data resources';
            throw new JsonApiFormatterException($error);
        }

        if ($data_resources instanceof DataResource) {
            $this->addData($data_resources);
        } else {
            foreach ($data_resources as $data_resource) {
                if (!$data_resource instanceof DataResource) {
                    $error = '$data_resources needs to be a data resource or array of data resources';
                    throw new JsonApiFormatterException($error);
                }
                $this->addData($data_resource);
            }
        }

        $this->autoIncludeJsonapi();

        return $this->getBaseResponseArray();
    }

    // other useful functionality

    /**
     * Performs a quick validation  of internal setup against some basic rules.
     * eg: data and errors set.
     *
     * @param $array
     * @return bool
     * @throws JsonApiFormatterException
     */
    public function quickValidatorArray(array $array): bool
    {
        $message = 'The provided json structure does not match the json api standard - ';

        // it must have either have data OR errors
        if (!array_key_exists('data', $array) && !array_key_exists('errors', $array)) {
            $message .= 'no data or error array found';
            throw new JsonApiFormatterException($message);
        }

        if (array_key_exists('data', $array) && array_key_exists('errors', $array)) {
            $message .= 'only one data or error array must be used';
            throw new JsonApiFormatterException($message);
        }

        return true;
    }

    /**
     * Performs a quick validation for Data against some basic rules.
     * This is not a schema validation, "But it'll give it a shot..."
     *
     * @param $array
     * @return bool
     * @throws JsonApiFormatterException
     */
    public function quickValidatorDataResourceArray(array $array): bool
    {
        $message = 'The provided json structure does not match the json api standard - ';

        // check object type:

        // singular object
        if (
            // do OR here to allow a graceful failure that provides validation context
            array_key_exists('id', $array) ||
            array_key_exists('type', $array) ||
            array_key_exists('attributes', $array)
        ) {
            try {
                $this->validateDataResourceArray($array);
            } catch (JsonApiFormatterException $e) {
                throw new JsonApiFormatterException($message . $e->getMessage());
            }
        } else {
            foreach ($array as $data_resource) {
                try {
                    $this->validateDataResourceArray($data_resource);
                } catch (JsonApiFormatterException $e) {
                    throw new JsonApiFormatterException($message . $e->getMessage());
                }
            }
        }

        return true;
    }

    /**
     * Internal validator for a array representation of a data resource
     *
     * @param array $data_resource_array
     * @return bool
     * @throws JsonApiFormatterException
     */
    public function validateDataResourceArray(array $data_resource_array): bool
    {
        // no id
        if (!array_key_exists('id', $data_resource_array)) {
            $message = 'resource objects require an id';
            throw new JsonApiFormatterException($message);
        }

        // id needs to be string
        if (!is_string($data_resource_array['id'])) {
            $message = 'a resource object id must be a string';
            throw new JsonApiFormatterException($message);
        }

        // type required
        if (!array_key_exists('type', $data_resource_array)) {
            $message = 'resource objects require a type';
            throw new JsonApiFormatterException($message);
        }
        // type needs to be a string
        if (!is_string($data_resource_array['type'])) {
            $message = 'a resource object type must be a string';
            throw new JsonApiFormatterException($message);
        }

        // no attributes
        if (!array_key_exists('attributes', $data_resource_array)) {
            $message = 'resource objects require an attributes array';
            throw new JsonApiFormatterException($message);
        }

        // attributes needs to be an array
        if (!is_array($data_resource_array['attributes'])) {
            $message = 'a resource object attributes must be an array';
            throw new JsonApiFormatterException($message);
        }

        return true;
    }

}
