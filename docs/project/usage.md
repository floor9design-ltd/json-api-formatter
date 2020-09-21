# Usage

It is a good idea to have the JSON API definitions to hand:

* [JSON API definition](https://jsonapi.org/format/)

## Setup

The class can be included by whatever method is appropriate:

```php
// Example PSR-4 include
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
```
The object can then be instantiated:

```php
// Example PSR-4 include
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;

$json_api_response = new JsonApiFormatter();
```

## Simple use

### data resources

Data resources can be quickly created using the `dataResourceResponse()` function.

```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;

// Some example data:
$id = "2"; 
$type = 'test';
$attributes = ['test' => 'data'];

$json_api_response = new JsonApiFormatter();

$response = $json_api_response->dataResourceResponse($id, $type, $attributes);
```

## Using an object manually

The following accessors exist:

* `getData()`
* `getErrors()`
* `getMeta()`
* `getJsonapi()`
* `getContentType()`

The following methods are available to manually change the object:

* `setData()`
* `setErrors()`
* `setMeta()`

If you are creating the objects fluently, the following `add` methods can be used to avoid get/set syntactic hassle.

* `addData()` 
* `addErrors()`
* `addMeta()`

The following functions also exist to change the standard values for a response:

* `setContentType()` 
* `setJsonapi()` 

If manually creating the objects, they should be formed as per structure of a json api type.
There is basic validation, but it is not comprehensive.

```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;

// Some example data:
$id = "2"; 
$type = 'test';
$attributes = ['test' => 'data'];

$json_api_response = new JsonApiFormatter();

$json_api_response->addData(['id' => $id]);
$json_api_response->addData(['type' => $type]);
$json_api_response->addData(['attributes' => $attributes]);
$json_api_response->addMeta(['info' => 'object created']);

$response = $json_api_response->dataResourceResponse();

```

## Responses

The JSON API requires a specific `Content-Type` header, which can be loaded by `getContentType()`:

```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;

$json_api_response = new JsonApiFormatter();
$content_type = $json_api_response->getContentType();
// application/vnd.api+json
```

The `dataResourceResponse()` returns a JSON API compliant json string.