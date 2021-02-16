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
     * @return null|array
     */
    public function getData(): ?array
    {
        return $this->getBaseResponseArray()['data'] ?? null;
    }

    /**
     * Fluently sets data to the $base_response_array['data']
     *
     * @param array|null $data
     * @return JsonApiFormatter
     */
    public function setData(?array $data = null): JsonApiFormatter
    {
        // cast id to be a string:
        if($data['id'] ?? false) {
            $data['id'] = (string)$data['id'];
        }

        $this->base_response_array['data'] = $data;
        return $this;
    }

    /**
     * Fluently adds data to $base_response_array['data']
     * @param array $extra_data
     * @param bool $overwrite allows overwrites of existing keys
     * @return JsonApiFormatter
     * @throws JsonApiFormatterException
     */
    public function addData(array $extra_data, bool $overwrite = false): JsonApiFormatter
    {
        // catch duplicates
        if (!$overwrite && array_intersect_key($this->getData() ?? [], $extra_data)) {
            throw new JsonApiFormatterException(
                'The data provided clashes with existing data - it should be added manually'
            );
        }

        $this->setData(array_merge($this->getData() ?? [], $extra_data));
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
     */
    public function setErrors(array $errors): JsonApiFormatter
    {
        $this->base_response_array['errors'] = $errors;
        return $this;
    }

    /**
     * Fluently adds error to $base_response_array['errors']
     * @param array $extra_errors
     * @return JsonApiFormatter
     */
    public function addErrors(array $extra_errors): JsonApiFormatter
    {
        $errors = $this->getErrors() ?? [];
        foreach ($extra_errors as $error) {
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
    public function getMeta(): ?stdClass
    {
        return $this->getBaseResponseArray()['meta'] ?? null;
    }

    /**
     * Fluently sets meta to the $base_response_array['meta']
     *
     * @param stdClass $meta
     * @return JsonApiFormatter
     */
    public function setMeta(stdClass $meta): JsonApiFormatter
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
    public function addMeta(array $extra_meta, bool $overwrite = false): JsonApiFormatter
    {
        $meta = $this->getMeta();
        if (!$meta) {
            $meta = new stdClass();
        }

        // catch duplicates
        foreach ($extra_meta as $key => $new_meta) {
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
    public function getLinks(): ?stdClass
    {
        return $this->getBaseResponseArray()['links'] ?? null;
    }

    /**
     * Fluently sets links to the $base_response_array['links']
     *
     * @param stdClass $links
     * @return JsonApiFormatter
     */
    public function setLinks(stdClass $links): JsonApiFormatter
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
        $links = $this->getLinks() ?? new stdClass();

        // catch duplicates
        foreach ($extra_links as $key => $new_link) {
            if (!$overwrite && property_exists($links, $key)) {
                throw new JsonApiFormatterException(
                    'The link provided clashes with existing links - it should be added manually'
                );
            }

            $links->$key = $new_link;
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
        ?stdClass $meta = null,
        ?stdClass $json_api = null,
        ?stdClass $links = null
    ) {
        // Cant form an object before instantiation, so do it here:
        $this->base_response_array['jsonapi'] = (object)['version' => '1.0'];

        if ($meta ?? false) {
            $this->setMeta($meta);
        } else {
            $this->setMeta((object)['status' => null]);
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

        // throws its own exceptions
        $this->quickValidatorArray($decoded_json);

        // attempt to set up data
        if ($decoded_json['data'] ?? false) {
            $this->setData($decoded_json['data']);
        }

        // attempt to set up errors
        if ($decoded_json['errors'] ?? false) {
            $this->setErrors($decoded_json['errors']);
        }

        // attempt to set up meta
        if ($decoded_json['meta'] ?? false) {
            $this->setMeta((object)$decoded_json['meta']);
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
     * @param string|null $id
     * @param string|null $type
     * @param array|null $attributes
     * @return string
     * @throws JsonApiFormatterException
     */
    public function dataResourceResponse(
        ?string $id = null,
        ?string $type = null,
        ?array $attributes = null
    ): string {
        $this->dataResourceResponseArray($id, $type, $attributes);
        return $this->correctEncode();
    }

    /**
     * @param string|null $id
     * @param string|null $type
     * @param array|null $attributes
     * @return array
     * @throws JsonApiFormatterException
     */
    public function dataResourceResponseArray(
        ?string $id = null,
        ?string $type = null,
        ?array $attributes = null
    ): array {
        // clear errors: it must not be set in an dataResource response
        unset($this->base_response_array['errors']);

        // if no data is passed, try to load this object's data:
        if (
            $type &&
            (
                $id !== null ||
                $id === "0" // catch string zero, which evaluates to false.
            ) &&
            $attributes &&
            count($attributes) != 0
        ) {
            // Manually set/add the data where needed (overwrite)
            $data = [
                'id' => $id,
                'type' => $type,
                'attributes' => $attributes
            ];
            $this->setData($data);
        }

        // Catch empty id array: it needs to exist!
        if (!isset($this->getData()['id'])) {
            throw new JsonApiFormatterException("Data responses require the data id to be set");
        }

        // Catch empty type array: it needs to exist!
        if (!($this->getData()['type'] ?? false)) {
            throw new JsonApiFormatterException("Data responses require the data type to be set");
        }

        // Catch empty attributes array: it needs to exist!
        if (count($this->getData()['attributes'] ?? []) == 0) {
            throw new JsonApiFormatterException("Data responses cannot have an empty attributes array");
        }

        $this->autoIncludeJsonapi();

        return $this->getBaseResponseArray();
    }

    // other useful functionality

    /**
     * Performs a quick validation against some basic rules.
     * This is not a schema validation.
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

        // resource validation:

        // no id
        if(array_key_exists('data', $array) && !array_key_exists('id', $array['data'])) {
            $message .= 'resource objects require an id';
            throw new JsonApiFormatterException($message);
        }

        // id needs to be string
        if(array_key_exists('data', $array) && !is_string($array['data']['id'])) {
            $message .= 'a resource object id must be a string';
            throw new JsonApiFormatterException($message);
        }

        // type required
        if(array_key_exists('data', $array) && !array_key_exists('type', $array['data'])) {
            $message .= 'resource objects require a type';
            throw new JsonApiFormatterException($message);
        }
        // type needs to be a string
        if(array_key_exists('data', $array) && !is_string($array['data']['type'])) {
            $message .= 'a resource object type must be a string';
            throw new JsonApiFormatterException($message);
        }

        // no attributes
        if(array_key_exists('data', $array) && !array_key_exists('attributes', $array['data'])) {
            $message .= 'resource objects require an attributes array';
            throw new JsonApiFormatterException($message);
        }

        // attributes needs to be an array
        if(array_key_exists('data', $array) && !is_array($array['data']['attributes'])) {
            $message .= 'a resource object attributes must be an array';
            throw new JsonApiFormatterException($message);
        }

        return true;

    }

}
