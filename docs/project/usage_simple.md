# Simple use

Note, there is a lot to learn about JSONAPI, you may find the linked examples an easy way to learn these.

## Basic overview

The main functionality is provided by: `JsonApiFormatter`.

The JsonApi specification uses several objects (and arrays of objects) to encapsulate the responses. These are mapped
to the following php items:

| item           | concept                                                |
|----------------|--------------------------------------------------------|
| `DataResource` | A place where data lives                               |
| `Relationship` | Details about a relationship (but not the actual data) |
| `Included`     | Included relevant or requested data                    |
| `Link`         | A link to another resource (internal or external)      |
| `Meta`         | Meta data                                              |
| `Error`        | An error                                               |
| `Source`       | Details about the source of an error                   |

Several of these have "collection classes", for example: `Errors` and `Error`. These have rules or other setups that 
elevate them above a basic array.

## Usage

The main methods return a json string. 

## Example of a basic data resources response

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

This is enough for most use cases, but JSON API has a lot of extra features. You can learn about these in:

* [class reference](class_rererence.md)
* [example responses](usage_example_responses.md)

## Example of an error response

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

