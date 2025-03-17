# Errors

## Background

From JSON API documentation:

* Specification: [specification](https://jsonapi.org/format/#errors)
* Example: [example](https://jsonapi.org/examples/#error-objects)

## Errors

Error responses are an array of Error objects. You can choose whether to collect errors or return at the first
opportunity.

## The `Error` object

> An error object may have the following members, and must contain at least one of:

| member | detail                                                                                               | type   |
|--------|------------------------------------------------------------------------------------------------------|--------|
| id     | a unique identifier for this particular occurrence of the problem                                    | string |
| links  | [links object](links.md)                                                                             | Links  |
| status | the HTTP status code applicable to this problem                                                      | string |
| code   | an application-specific error code                                                                   | string |
| title  | summary of the problem                                                                               | string |
| detail | explanation specific to this occurrence of the problem                                               | string |
| source | [source object](source.md) used used to indicate which part of the request document caused the error | Source |
| meta   | [meta object](meta.md)                                                                               | Meta   |

## Fluent creation:

Methods are available for fluent creation:

* `$error->setId($id)`
* `$error->setLinks($links)`
* `$error->setStatus($status)`
* `$error->setCode($code)`
* `$error->setTitle($title)`
* `$error->setDetail($detail)`
* `$error->setSource($source)`
* `$error->setMeta($meta)`

## Simple usage

In many cases, a simple return is required. For example, a 403.

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
// A JSON string, good for direct output 
// $response = '{"errors":[{"id":"12656","status":"403" ... '

$response_array = $json_api_formatter->errorResponseArray($errors);
// an array 
```

`$response` is:

```json
{
  "errors": [
    {
      "id": "12656",
      "status": "403",
      "code": "HAL-9000-NOPE",
      "title": "Access error",
      "detail": "Im sorry Dave, Im afraid I cant do that"
    }
  ],
  "meta": {
    "status": null
  },
  "jsonapi": {
    "version": "1.1"
  }
}
```

This is shown in [SimpleUsageTest](../../tests/Unit/Examples/Errors/SimpleUsageTest.php)

## Advanced usage

Note that both the `Error` and `JsonApiFormatter` object can dynamically build their content. This can be useful when
a system suffers a recoverable error and wishes to continue. Use the `addErrors()` method to do this.

The following adds a simple error, as well as a more complex one:

```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\Error;

// Create a basic error
$error_basic = new Error(
    '12656',
    null,
    '403',
    'HAL-9000-NOPE',
    'Access error',
    'Im sorry Dave, Im afraid I cant do that',
);

// Create an error with Link, Source and Meta objects
$links = new Links(
    [
        new Link('https://www.youtube.com/watch?v=c8N72t7aScY')
    ]
);
$source = new Source('/data/');
$meta = new Meta (
    [
        'book' => '2001, A Space Odyssey',
        'isbn' => '978-0-453-00269-1'
    ]
);

$error_complex = new Error(
    '12656',
    $links,
    '503',
    'HAL-9000-DEACTIVATED',
    'Service Unavailable',
    'My mind is going, I can feel it.',
    $source,
    $meta
);

$errors = [$error_basic, $error_complex];
$json_api_formatter = new JsonApiFormatter();

$response = $json_api_formatter->errorResponse($errors);
```

`$response` is:

```json
{
  "errors": [
    {
      "id": "12657",
      "status": "403",
      "code": "HAL-9000-NOPE",
      "title": "Access error",
      "detail": "Im sorry Dave, Im afraid I cant do that"
    },
    {
      "id": "12656",
      "status": "503",
      "code": "HAL-9000-DEACTIVATED",
      "title": "Service Unavailable",
      "detail": "My mind is going, I can feel it.",
      "source": {
        "pointer": "/data/"
      },
      "meta": {
        "book": "2001, A Space Odyssey",
        "isbn": "978-0-453-00269-1"
      },
      "links": {
        "0": {
          "href": "https://www.youtube.com/watch?v=c8N72t7aScY"
        }
      }
    }
  ],
  "meta": {
    "status": null
  },
  "jsonapi": {
    "version": "1.1"
  }
}
```

This is shown in [AdvancedUsageTest](../../tests/Unit/Examples/Errors/AdvancedUsageTest.php)