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

Most use cases fit the included simple-use functions. These are described as follows:

* [simple usage](usage-simple.md)

There is also a tutorial that builds several repsonses:

* [example responses](usage-example-responses.md)

## Creating a custom object

If you need to make a custom object, then this is also possible:

* [custom usage](usage-custom.md)

## Outside of the JSON

The JSON API requires a specific `Content-Type` header, which can be loaded by `getContentType()`:

```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;

$json_api_response = new JsonApiFormatter();
$content_type = $json_api_response->getContentType();
// application/vnd.api+json
```

The `dataResourceResponse()` returns a JSON API compliant json string.