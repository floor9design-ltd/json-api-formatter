# Meta

From JSON API documentation:
* Specification: [specification](https://jsonapi.org/format/#document-meta)

The `Meta` object maps to a `meta object`. The `Meta` object can be used to include non-standard meta-information..

A `Meta` object accepts the following instantiation arguments:

```php
    public function __construct(?array $array = [])
    {
        // ...
    }
```

The array has no defined shape, but will be converted to be associative when output.

## Example

A `Meta` object could be constructed as follows:

```php
use Floor9design\JsonApiFormatter\Models\Meta;

$meta_information = [
    'pilot' => 'Wedge Antilles'
];

$meta = new Meta($meta_information);
```

## Adding Meta to the `DataResponse`

Meta can be added to the base `DataResponse` class:

```php 
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\Meta;

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
```

The response would be: 

```json

{
  "data": {
    "id": "XD-1",
    "type": "starship",
    "attributes": {
      "name": "Discovery One"
    }
  },
  "meta": {
    "status": "200"
  },
  "jsonapi": {
    "version": "1.1"
  }
}

```

This is an ideal place for information such as Copyright.

This is shown in [SimpleDataResourceTest](../../tests/Unit/Examples/Meta/SimpleDataResourceTest.php)

## Child `Meta` objects

Meta objects can be part of children, such as `DataResource` objects

```php

use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\Meta;

$json_api_formatter = new JsonApiFormatter();
$data_resource = new DataResource(
    'ECF-270',
    'starship',
    ['name' => 'Rocinante']
);

// Assign the meta to the data resource
$data_resource_meta = new Meta(
    ['previous_name' => 'MCRN Tachi']
);
$data_resource->setMeta($data_resource_meta);

$response = $json_api_formatter->dataResourceResponse($data_resource);

```

The response would be:

```json

{
  "data": {
    "id": "ECF-270",
    "type": "starship",
    "attributes": {
      "name": "Rocinante"
    },
    "meta": {
      "previous_name": "MCRN Tachi"
    }
  },
  "meta": {
    "status": null
  },
  "jsonapi": {
    "version": "1.1"
  }
}

```

This is shown in [SimpleDataResponseTest](../../tests/Unit/Examples/Meta/SimpleDataResponseTest.php)