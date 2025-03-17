# Source

## Background

From JSON API documentation:

* Specification: [specification](https://jsonapi.org/format/#errors)

## The `Source` object

> an object containing references to the primary source of the error. It SHOULD include one of the following members
> or be omitted:

| member    | detail                                                                              | type   |
|-----------|-------------------------------------------------------------------------------------|--------|
| pointer   | a JSON Pointer [RFC6901] to the value in the request document that caused the error | string |
| parameter | a string indicating which URI query parameter caused the error.                     | string |
| header    | a string indicating the name of a single request header which caused the error      | string |

## Simple usage

These are used inside `Error`s. Here is an example response:

Errors can be quickly created using the `errorResponse()` function.

```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\Error;

$source = new Source(
    '/data',
    'user_id',
    'User access request'
);

// an example error:
$error = new Error(
    '12656',
    null,
    '403',
    'HAL-9000-NOPE',
    'Access error',
    'Im sorry Dave, Im afraid I cant do that',
    $source
);
$errors = [$error];

$json_api_formatter = new JsonApiFormatter();

$response = $json_api_formatter->errorResponse($errors);
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
      "detail": "Im sorry Dave, Im afraid I cant do that",
      "source": {
        "pointer": "/data",
        "parameter": "user_id",
        "header": "User access request"
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

This is shown in [SimpleSourceTest](../../tests/Unit/Examples/Source/SimpleSourceTest.php)