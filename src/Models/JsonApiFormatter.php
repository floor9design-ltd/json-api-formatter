<?php
/**
 * JsonApiFormatter.php
 *
 * JsonApiFormatter class
 *
 * php 8.0+
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.2
 * @link      https://www.floor9design.com
 * @since     File available since pre-release development cycle
 *
 */

namespace Floor9design\JsonApiFormatter\Models;

use Floor9design\JsonApiFormatter\Exceptions\JsonApiFormatterException;
use stdClass;

/**
 * Class JsonApiFormatter
 *
 * Class to offer methods/properties to format items ready for a Json Api request.
 * These are set to the v1.1 specification, defined at https://jsonapi.org/format/
 *
 * @category  None
 * @package   Floor9design\JsonApiFormatter\Models
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   2.0.2
 * @link      https://www.floor9design.com
 * @link      https://jsonapi.org/
 * @link      https://jsonapi-validator.herokuapp.com/
 * @since     File available since pre-release development cycle
 * @see       https://jsonapi.org/format/
 */
class JsonApiFormatter
{
    // Properties

    /**
     * @var string The precise response type expected by JSON API
     */
    protected string $content_type = 'application/vnd.api+json';

    /**
     * A clean array to populate, including the main required elements
     *
     * @phpstan-var array{data?:array<DataResource>|DataResource|null,errors?:array<Error>,included?:Included,links?:Links,meta?:Meta|null,jsonapi?:StdClass}
     * @var array
     */
    protected array $base_response_array = [
        'data' => null, // can exist as null
        'errors' => [], // must be an array
        'meta' => null, // must be an object
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
     * @return array{data?:array<DataResource>|DataResource|null,errors?:array<Error>,included?:Included,links?:Links,meta?:Meta|null,jsonapi?:StdClass}
     * @see $base_response_array
     */
    protected function getBaseResponseArray(): array
    {
        return $this->base_response_array;
    }

    /**
     * @phpstan-return array<DataResource>|DataResource|null
     * @return null|array|DataResource
     */
    public function getData()
    {
        return $this->getBaseResponseArray()['data'] ?? null;
    }

    /**
     * Fluently sets data to the $base_response_array['data']
     *
     * @phpstan-param array<DataResource>|DataResource|null $data
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
     * Fluently adds an item to a single DataResource.
     * Often DataResources are built on the fly, and sometimes these need to be added on the fly... this is simply a
     * convenient method to do this.
     *
     * @param string $key
     * @param mixed $value
     * @return JsonApiFormatter
     * @throws JsonApiFormatterException
     */
    public function addDataAttribute(string $key, $value): JsonApiFormatter
    {
        if (!$this->getData() || !($this->getData() instanceof DataResource)) {
            $message = 'addDataAttribute() can only be used with a single DataResource';
            throw new JsonApiFormatterException($message);
        }

        $attributes = $this->getData()->getAttributes();
        $attributes[$key] = $value;

        $this->getData()->setAttributes($attributes);

        return $this;
    }

    /**
     * @phpstan-return array<Error>|null
     * @return array|null
     */
    public function getErrors(): ?array
    {
        return $this->getBaseResponseArray()['errors'] ?? null;
    }

    /**
     * Fluently sets errors to the $base_response_array['errors']
     *
     * @phpstan-param array<Error> $errors
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
     * @phpstan-param array<Error> $extra_errors
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
     * @return null|Meta
     */
    public function getMeta(): ?Meta
    {
        return $this->getBaseResponseArray()['meta'] ?? null;
    }

    /**
     * Fluently sets meta to the $base_response_array['meta']
     *
     * @param Meta $meta
     * @return JsonApiFormatter
     */
    public function setMeta(Meta $meta): JsonApiFormatter
    {
        $this->base_response_array['meta'] = $meta;
        return $this;
    }

    /**
     * Fluently adds meta to $base_response_array['meta']
     * @param Meta $extra_meta
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
        $existing_meta_content = $meta->getMeta();
        $updated_meta_content = $existing_meta_content;

        foreach ($extra_meta->process() as $key => $new_meta_content) {
            if (!$overwrite && isset($existing_meta_content[$key])) {
                throw new JsonApiFormatterException(
                    'The meta provided clashes with existing meta - it should be added manually'
                );
            }

            $updated_meta_content[$key] = $new_meta_content;
        }

        $this->setMeta(new Meta($updated_meta_content));

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
     * @return Stdclass|null
     */
    public function getJsonApi(): JsonApiObject
    {
        return $this->base_response_array['jsonapi'];
    }

    /**
     * Fluently sets jsonapi to the $base_response_array['jsonapi']
     *
     * @param StdClass $jsonapi
     * @return JsonApiFormatter
     */
    public function setJsonApi(JsonApiObject $jsonapi): JsonApiFormatter
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
        $this->base_response_array['jsonapi'] = $this->getJsonApi()->process();
        return $this;
    }

    /**
     * @return null|Links
     */
    public function getLinks(): ?Links
    {
        return $this->getBaseResponseArray()['links'] ?? null;
    }

    /**
     * Fluently sets links to the $base_response_array['links']
     *
     * @param Links $links
     * @return JsonApiFormatter
     */
    public function setLinks(Links $links): JsonApiFormatter
    {
        $this->base_response_array['links'] = $links;
        return $this;
    }

    /**
     * Fluently adds an array of links items to $base_response_array['links'] object
     * @phpstan-param array<Link> $extra_links
     * @param array $extra_links
     * @param bool $overwrite allows overwrites of existing keys
     * @return JsonApiFormatter
     * @throws JsonApiFormatterException
     */
    public function addLinks(array $extra_links, bool $overwrite = false): JsonApiFormatter
    {
        $links = $this->getLinks() ?? new Links();

        foreach ($extra_links as $name => $new_link) {
            $links->addLink($name, $new_link, $overwrite);
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
     * @phpstan-return Included|null
     * @return array|null
     */
    public function getIncluded(): ?Included
    {
        return $this->getBaseResponseArray()['included'] ?? null;
    }

    /**
     * Fluently sets included to the $base_response_array['included']
     *
     * @param Included $included
     * @return JsonApiFormatter
     */
    public function setIncluded(Included $included): JsonApiFormatter
    {
        $this->base_response_array['included'] = $included;
        return $this;
    }

    /**
     * Fluently adds included to $base_response_array['included']
     * @param array<DataResource> $extra_included
     * @return JsonApiFormatter
     */
    public function addIncluded(array $extra_included): JsonApiFormatter
    {
        $included = $this->getIncluded() ?? new Included();

        foreach ($extra_included as $new_data_resource) {
            $included->addDataResource($new_data_resource);
        }

        $this->setIncluded($included);
        return $this;
    }

    /**
     * Fluently unset $base_response_array['included']
     * @return JsonApiFormatter
     */
    public function unsetIncluded(): JsonApiFormatter
    {
        unset($this->base_response_array['included']);
        return $this;
    }

    // constructor

    /**
     * Sets up the object quickly with optional items
     *
     * JsonApiFormatter constructor.
     * @param Meta|null $meta
     * @param stdClass|null $json_api
     * @param Links|null $links
     */
    public function __construct(
        ?Meta $meta = null,
        ?JsonApiObject $json_api = null,
        ?Links $links = null
    ) {
        if ($meta ?? false) {
            $this->setMeta($meta);
        } else {
            $this->setMeta(new Meta(['status' => null]));
        }

        if ($json_api ?? false) {
            $this->setJsonApi($json_api);
        } else {
            $this->setJsonApi(new JsonApiObject());
        }

        if ($links ?? false) {
            $this->setLinks($links);
        }
    }

    // protected functions

    /**
     * Correctly encodes the string, catching issues such as:
     * "you need to specify associative array, else it is invalid json"
     *
     * It also strips optional null items.
     * @param array{data?:array<DataResource>|DataResource|null, errors?:array<Error>, included?:Included,links?:Links,meta?:Meta|null,jsonapi?:StdClass}|null $array
     * @return string
     * @throws JsonApiFormatterException
     */
    protected function correctEncode(?array $array = []): string
    {
        if (!$array) {
            // dont change base array, use $array as output
            $array = $this->getBaseResponseArray();
        }

        // strip nulls from errors using the process() functionality:

        if (
            isset($array['errors']) &&
            is_iterable($array['errors'])
        ) {
            // rewrite errors to ensure a clean array:
            $errors = [];
            foreach ($array['errors'] as $key => $error) {
                $errors[$key] = $error->process();
            }
            $array['errors'] = $errors;
        }

        // the included array must NOT be associative:
        if (
            isset($array['included']) &&
            $array['included'] instanceof Included
        ) {
            // overwrite as array
            $array['included'] = $array['included']->process();
        }

        // format links
        if (
            isset($array['links']) &&
            $array['links'] instanceof Links
        ) {
            $array['links'] = $array['links']->process();
        }

        // format meta
        if (
            isset($array['meta']) &&
            $array['meta'] instanceof Meta
        ) {
            $array['meta'] = $array['meta']->process();
        }

        // ensure that data objects are formatted
        if (
            isset($array['data']) &&
            is_iterable($array['data'])
        ) {
            // rewrite data_resources to ensure a clean array:
            $data_resources = [];
            foreach ($array['data'] as $key => $data_resource) {
                $data_resources[$key] = $data_resource->process();
            }
            $array['data'] = $data_resources;
        } elseif (
            isset($array['data']) &&
            $array['data'] instanceof DataResource
        ) {
            $array['data'] = $array['data']->process();
        }
        $array = $this->normalizeRelationshipsRecursive($array);

        $encoded = json_encode($array, JSON_UNESCAPED_SLASHES);
        if (!$encoded) {
            throw new JsonApiFormatterException('The provided array was not able to be encoded');
        }

        return $encoded;
    }

    protected function normalizeRelationshipsRecursive(array $input): array
    {
        foreach ($input as $key => &$value) {
            if ($key === 'relationships' && is_array($value)) {
                $value = (object) $value;
            } elseif (is_array($value)) {
                $value = $this->normalizeRelationshipsRecursive($value);
            }
        }
        return $input;
    }

    // Main functionality:

    /**
     * Resets the JsonApiFormatter formatter, clearing the data to defaults
     * This can be useful if the class is being used as a singleton or similar service
     *
     * @return JsonApiFormatter
     */
    public function reset(): JsonApiFormatter
    {
        $this
            ->unsetData()
            ->unsetErrors()
            ->unsetIncluded()
            ->unsetLinks()
            ->unsetMeta();

        return $this;
    }

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
        $this->autoIncludeJsonapi();
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
        if (!$decoded_json || !is_array($decoded_json)) {
            throw new JsonApiFormatterException('The provided json was not valid');
        }

        // attempt to set up data
        if (
            ($decoded_json['data'] ?? false) ||
            ($decoded_json['data'] ?? false) === []
        ) {
            // validate it
            $this->quickValidatorDataResourceArray($decoded_json['data']);

            // specific case of an empty array
            if ($decoded_json['data'] === []) {
                $this->setData([]);
            } elseif ($decoded_json['data']['type'] ?? false) {
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

                // clear first, else will end up with an extra array of the defaults
                $this->unsetData();
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

                    foreach ($error['links'] as $key => $link) {
                        if (is_string($link)) {
                            $links->addLink($key, $link);
                        } else {
                            $href = $link['href'] ?? null;

                            if ($link['described_by'] ?? null) {
                                if (is_string($link['described_by'])) {
                                    $described_by = $link['described_by'];
                                } else {
                                    // set up a new Link
                                    $described_by = new Link(
                                        $link['described_by']['href']
                                    );
                                    if ($link['described_by']['rel'] ?? false) {
                                        $described_by->setRel($link['described_by']['rel']);
                                    }
                                    if ($link['described_by']['title'] ?? false) {
                                        $described_by->setTitle($link['described_by']['title']);
                                    }
                                    if ($link['described_by']['type'] ?? false) {
                                        $described_by->setType($link['described_by']['type']);
                                    }
                                    if ($link['described_by']['hreflang'] ?? false) {
                                        $described_by->setType($link['described_by']['hreflang']);
                                    }
                                    if ($link['described_by']['meta'] ?? false) {
                                        $described_by->setType($link['described_by']['meta']);
                                    }
                                }
                            } else {
                                $described_by = null;
                            }

                            $rel = $link['rel'] ?? null;
                            $title = $link['title'] ?? null;
                            $type = $link['type'] ?? null;
                            $hreflang = $link['hreflang'] ?? null;

                            if ($link['meta'] ?? false) {
                                $meta = new Meta($link['meta']);
                            } else {
                                $meta = null;
                            }

                            $new_link = new Link($href, $described_by, $rel, $title, $type, $hreflang, $meta);
                            $links->addLink($key, $new_link);
                        }
                    }
                }

                if ($error['source'] ?? false) {
                    $source = new Source(
                        $error['source']['pointer'] ?? null,
                        $error['source']['parameter'] ?? null,
                        $error['source']['header'] ?? null,
                    );
                } else {
                    $source = null;
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
        foreach ($decoded_json['included'] ?? [] as $included) {
            // validate it
            $this->quickValidatorDataResourceArray($included);

            $this->addIncluded(
                [
                    new DataResource(
                        $included['id'],
                        $included['type'],
                        $included['attributes']
                    )
                ]
            );
        }

        return $this;
    }

    /**
     * @phpstan-param array<Error> $errors
     * @param array $errors
     * @return string
     * @throws JsonApiFormatterException
     */
    public function errorResponse(array $errors = []): string
    {
        $this->errorResponseArray($errors);
        return $this->correctEncode();
    }

    /**
     * @phpstan-param array<Error> $errors
     * @param array $errors
     * @phpstan-return array{errors?:array<Error>,links?:Links,meta?:Meta|null,jsonapi?:StdClass}
     * @return array
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
        if (!$this->getErrors()) {
            throw new JsonApiFormatterException('Error responses cannot have an empty errors array');
        }

        $this->autoIncludeJsonapi();

        return $this->getBaseResponseArray();
    }

    /**
     * @phpstan-param array<DataResource>|DataResource $data_resources
     * @param array|DataResource $data_resources
     * @return string
     * @throws JsonApiFormatterException
     */
    public function dataResourceResponse($data_resources = null): string
    {
        $this->dataResourceResponseArray($data_resources);
        return $this->correctEncode();
    }

    /**
     * @phpstan-param array<DataResource>|DataResource $data_resources
     * @param array|DataResource $data_resources
     * @phpstan-return array{data?:array<DataResource>|DataResource|null,included?:Included,links?:Links,meta?:Meta|null,jsonapi?:StdClass}
     * @return array
     * @throws JsonApiFormatterException
     */
    public function dataResourceResponseArray($data_resources = null): array
    {
        // clear errors: it must not be set in a dataResource response
        unset($this->base_response_array['errors']);

        // load if it's not been provided:
        if ($data_resources !== null) {
            $this->setData($data_resources);
        }

        // if it's still null, it needs data!:
        if ($this->getData() === null) {
            $message = 'Data needs to be set to a data resource or array of data resources';
            throw new JsonApiFormatterException($message);
        }

        $this->autoIncludeJsonapi();
        return $this->getBaseResponseArray();
    }

    // other useful functionality

    /**
     * Performs a quick validation of internal setup against some basic rules.
     * eg: data and errors set.
     *
     * @phpstan-param array{data?:array<DataResource>|DataResource|null,errors?:array<Error>,included?:Included,links?:Links,meta?:Meta|null,jsonapi?:StdClass} $array
     * @param array $array
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
     * @param array{id?:string|null,type?:string|null,attributes?:array|null}|array<mixed> $array
     * @return bool
     * @throws JsonApiFormatterException
     */
    public function quickValidatorDataResourceArray(array $array): bool
    {
        $message = 'The provided array is not valid.';

        if (
            array_key_exists('id', $array) &&
            array_key_exists('type', $array) &&
            array_key_exists('attributes', $array)
        ) {
            // singular object
            try {
                $this->validateDataResourceArray($array);
            } catch (JsonApiFormatterException $e) {
                throw new JsonApiFormatterException($message . ' ' . $e->getMessage());
            }
        } else {
            // multiple objects
            foreach ($array as $data_resource) {
                if (is_array($data_resource)) {
                    try {
                        $this->validateDataResourceArray($data_resource);
                    } catch (JsonApiFormatterException $e) {
                        throw new JsonApiFormatterException($message . ' ' . $e->getMessage());
                    }
                } else {
                    $detail = ' It needs to be a DataResource object in array form, or an array of DataResource objects in array form';
                    throw new JsonApiFormatterException($message . $detail);
                }
            }
        }

        return true;
    }

    /**
     * Internal validator for a array representation of a data resource
     *
     * @phpstan-param array{id?:string|null,type?:string|null,attributes?:array|null}|array<mixed> $data_resource_array
     * @param array $data_resource_array
     * @return bool
     * @throws JsonApiFormatterException
     */
    public function validateDataResourceArray(array $data_resource_array): bool
    {
        // no id
        if (!array_key_exists('id', $data_resource_array)) {
            $message = 'Resource objects require an id.';
            throw new JsonApiFormatterException($message);
        }

        // id needs to be string
        if (!is_string($data_resource_array['id'])) {
            $message = 'A resource object id must be a string.';
            throw new JsonApiFormatterException($message);
        }

        // type required
        if (!array_key_exists('type', $data_resource_array)) {
            $message = 'Resource objects require a type.';
            throw new JsonApiFormatterException($message);
        }
        // type needs to be a string
        if (!is_string($data_resource_array['type'])) {
            $message = 'A resource object type must be a string.';
            throw new JsonApiFormatterException($message);
        }

        // no attributes
        if (!array_key_exists('attributes', $data_resource_array)) {
            $message = 'Resource objects require an attributes array.';
            throw new JsonApiFormatterException($message);
        }

        // attributes needs to be an array
        if (!is_array($data_resource_array['attributes'])) {
            $message = 'A resource object attributes must be an array.';
            throw new JsonApiFormatterException($message);
        }

        return true;
    }

    /**
     * Checks to see if the loaded contents are for a DataResource response
     *
     * @return bool
     */
    public function isDataResourceResponse(): bool
    {
        if ($this->getData() && !$this->getErrors()) {
            return true;
        }

        return false;
    }

    /**
     * Checks to see if the loaded contents are for an Error response
     *
     * @return bool
     */
    public function isErrorResponse(): bool
    {
        if (!$this->getData() && $this->getErrors()) {
            return true;
        }

        return false;
    }

}