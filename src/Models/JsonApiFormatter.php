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
 * @version   1.0
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
    protected $base_response_array = [
        'data' => [],
        'errors' => [],
        'meta' => [
            'status' => null
        ]
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
     * @param array $data
     * @return JsonApiFormatter
     */
    public function setData(array $data): JsonApiFormatter
    {
        $this->base_response_array['data'] = $data;
        return $this;
    }

    /**
     * Fluently adds data to $base_response_array['data']
     * @param array $extra_data
     * @return JsonApiFormatter
     * @throws JsonApiFormatterException
     */
    public function addData(array $extra_data): JsonApiFormatter
    {
        // catch duplicates
        if (array_intersect_key($this->getData(), $extra_data)) {
            throw new JsonApiFormatterException(
                'The data provided clashes with existing data - it should be added manually'
            );
        }

        $this->setData(array_merge($this->getData() ?? [], $extra_data));
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
        $this->setErrors(array_merge($this->getErrors() ?? [], $extra_errors));
        return $this;
    }

    /**
     * @return null|array
     */
    public function getMeta(): ?array
    {
        return $this->getBaseResponseArray()['meta'] ?? null;
    }

    /**
     * Fluently sets meta to the $base_response_array['meta']
     *
     * @param array $meta
     * @return JsonApiFormatter
     */
    public function setMeta(array $meta): JsonApiFormatter
    {
        $this->base_response_array['meta'] = $meta;
        return $this;
    }

    /**
     * Fluently adds meta to $base_response_array['meta']
     * @param array $extra_meta
     * @return JsonApiFormatter
     * @throws JsonApiFormatterException
     */
    public function addMeta(array $extra_meta): JsonApiFormatter
    {
        // catch duplicates
        if (array_intersect_key($this->getMeta(), $extra_meta)) {
            throw new JsonApiFormatterException(
                'The meta provided clashes with existing meta - it should be added manually'
            );
        }

        $this->setMeta(array_merge($this->getMeta() ?? [], $extra_meta));
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
     * @param array $jsonapi
     * @return JsonApiFormatter
     */
    public function setJsonapi(object $jsonapi): JsonApiFormatter
    {
        $this->base_response_array['jsonapi'] = $jsonapi;
        return $this;
    }

    /**
     * @return null|array
     */
    public function getLinks(): ?array
    {
        return $this->getBaseResponseArray()['links'] ?? null;
    }

    /**
     * Fluently sets links to the $base_response_array['links']
     *
     * @param array $links
     * @return JsonApiFormatter
     */
    public function setLinks(array $links): JsonApiFormatter
    {
        $this->base_response_array['links'] = $links;
        return $this;
    }

    /**
     * Fluently adds included to $base_response_array['links']
     * @param array $extra_links
     * @return JsonApiFormatter
     */
    public function addLinks(array $extra_links): JsonApiFormatter
    {
        $this->setLinks(array_merge($this->getLinks() ?? [], $extra_links));
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
     * @return JsonApiFormatter
     */
    public function addIncluded(array $extra_included): JsonApiFormatter
    {
        $this->setIncluded(array_merge($this->getIncluded() ?? [], $extra_included));
        return $this;
    }

    // constructor

    /**
     * Sets up the object quickly with optional items
     *
     * JsonApiFormatter constructor.
     * @param array|null $meta
     * @param array|null $json_api
     * @param array|null $links
     */
    public function __construct(
        ?array $meta = null,
        ?object $json_api = null,
        ?array $links = null
    ) {
        // Cant form an object before instantiation, so do it here:
        $this->base_response_array['jsonapi'] = (object)['version' => '1.0'];

        if ($meta ?? false) {
            $this->setMeta($meta);
        }

        if ($json_api ?? false) {
            $this->setJsonapi($json_api);
        }

        if ($links ?? false) {
            $this->addLinks($links);
        }
    }

    // private functions

    /**
     * Correctly encodes the string, catching issues such as:
     * "you need to specify associative array, else it is invalid json"
     *
     * @param array $array
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

    // Main functionality

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

        //badly formed - must have either data or errors
        if (
            !($decoded_json['data'] ?? false) &&
            !($decoded_json['errors'] ?? false)
        ) {
            throw new JsonApiFormatterException('The provided json does not match the json api standard');
        }

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
            $this->setMeta($decoded_json['meta']);
        }

        return $this;
    }

    /**
     * @param array $errors
     * @param array $meta
     * @return string
     * @throws JsonApiFormatterException
     */
    public function errorResponse(
        array $errors = []
    ): string {
        // clear data: it must not be set in an error response
        unset($this->base_response_array['data']);

        // if no errors are passed, try to load this object's errors:
        if (!count($errors) == 0) {
            $this->addErrors($errors);
        }

        // Catch empty errors array: it needs to exist!
        if (count($this->getErrors()) == 0) {
            throw new JsonApiFormatterException("Error responses cannot have an empty errors array");
        }

        return $this->correctEncode();
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
        // Catch empty errors array: it needs to exist!
        if (!isset($this->getData()['id'])) {
            throw new JsonApiFormatterException("Data responses require the data id to be set");
        }

        // Catch empty errors array: it needs to exist!
        if (!($this->getData()['type'] ?? false)) {
            throw new JsonApiFormatterException("Data responses require the data type to be set");
        }

        // Catch empty errors array: it needs to exist!
        if (count($this->getData()['attributes'] ?? []) == 0) {
            throw new JsonApiFormatterException("Data responses cannot have an empty attributes array");
        }

        return $this->correctEncode();
    }

}
