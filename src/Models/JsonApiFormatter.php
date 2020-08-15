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
trait JsonApiFormatter
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
     * @return array
     * @see $base_response_array
     */
    public function getBaseApiResponseArray(): array
    {
        return $this->base_response_array;
    }

    /**
     * @return null|array
     */
    public function getData(): ?array
    {
        return $this->base_response_array['data'] ?? null;
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
     */
    public function addData(array $extra_data): JsonApiFormatter
    {
        $this->setData(array_merge($this->getData() ?? [], $extra_data));
        return $this;
    }

    /**
     * @return null|array
     */
    public function getErrors(): ?array
    {
        return $this->base_response_array['errors'] ?? null;
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
    public function addError(array $extra_errors): JsonApiFormatter
    {
        $this->setErrors(array_merge($this->getErrors() ?? [], $extra_errors));
        return $this;
    }

    /**
     * @return null|array
     */
    public function getMeta(): ?array
    {
        return $this->base_response_array['meta'] ?? null;
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
     */
    public function addMeta(array $extra_meta): JsonApiFormatter
    {
        $this->setMeta(array_merge($this->getMeta() ?? [], $extra_meta));
        return $this;
    }

    /**
     * @return null|array
     */
    public function getJsonapi(): ?array
    {
        return $this->base_response_array['jsonapi'] ?? null;
    }

    /**
     * Fluently sets jsonapi to the $base_response_array['jsonapi']
     *
     * @param array $jsonapi
     * @return JsonApiFormatter
     */
    public function setJsonapi(array $jsonapi): JsonApiFormatter
    {
        $this->base_response_array['jsonapi'] = $jsonapi;
        return $this;
    }

    /**
     * @return null|array
     */
    public function getLinks(): ?array
    {
        return $this->base_response_array['links'] ?? null;
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
     * @return null|array
     */
    public function getIncluded(): ?array
    {
        return $this->base_response_array['included'] ?? null;
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

    // Main functionality

    //public function errorResponseArray()

}
