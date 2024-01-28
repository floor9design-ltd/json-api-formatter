# Simple use

Note, there is a lot to learn about JSONAPI, you may find the linked examples an easy way to learn these.

## Basic overview

The main functionality is provided by: `JsonApiFormatter`.

The JsonApi specification uses several objects (and arrays of objects) to encapsulate the responses. These are mapped
to the following php items:

* object: `DataResource`
* object: `Error`
* array: `Included`
* object: `Link`
* object: `Source`
* object: `Meta`

## Usage

The main methods return a json string. 

If you use a framework such as Symfony or Laravel which prefers an array, then you can also use the `...Array()` 
methods which are also exposed. Remember to check that your implementation is correctly encoding these - often they 
are incorrect. You may prefer to use the preformatted code responses:

* [framework responses](framework_responses.md)

## data resources

Data resources can be quickly created using the `dataResourceResponse()` function.

The following arguments are required:

* `id` : id for the data resource (string)
* `type` : type of resource (string)
* `attributes` : array of resource properties 

```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;

// Some example data:
$id = "2"; 
$type = 'test';
$attributes = ['test' => 'data'];

$json_api_formatter = new JsonApiFormatter();

$response = $json_api_formatter->dataResourceResponse($id, $type, $attributes); 
// a json string, good for direct output 

$response = $json_api_formatter->dataResourceResponseArray($id, $type, $attributes); 
// an array 
```

## errors

Errors can be quickly created using the `errorResponse()` function.

```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\Error;

// an example error:
$error = new Error(
    '12656',
    null,
    '403',
    'HAL-9000-NOPE',
    'Access error',
    'Im sorry Dave, Im afraid I cant do that',
);
$errors = [$error];

$json_api_formatter = new JsonApiFormatter();

$response = $json_api_formatter->errorResponse($errors);
// a json string, good for direct output 

$response = $json_api_formatter->errorResponseArray($errors);
// an array 
```

See more detail at:

* [error documentation](errors.md)

