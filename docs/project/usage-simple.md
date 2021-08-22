# Simple use

## Basic overview

The main functionality is provided by: `JsonApiFormatter`.

The JsonApi specification uses several objects (and arryas of objects) to encapsulate the responses. These are mapped
to the following php items:

* object: `DataResource`
* object: `Error`
* array: `Included`
* object: `Link`
* object: `Meta`

## Usage

Each method returns a json string. 

If you use a framework such as Symfony or Laravel which prefers an array, then you can also use the `...Array()` 
methods which are also exposed. Remember to check that your implementation is correctly encoding these. 

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

$json_api_response = new JsonApiFormatter();

$response = $json_api_response->dataResourceResponse($id, $type, $attributes); 
// a json string, good for direct output 

$response = $json_api_response->dataResourceResponseArray($id, $type, $attributes); 
// an array 
```

## errors

Errors can be quickly created using the `errorResponse()` function.

The following arguments are required:

* `errors` : array of error objects

```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;

// an example error:
$error = (object)['test' => 'error'];
$errors = [$error];

$json_api_response = new JsonApiFormatter();

$response = $json_api_response->errorResponse($errors);
// a json string, good for direct output 

$response = $json_api_response->errorResponseArray($errors);
// an array 
```


