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

$json_api_formatter = new JsonApiFormatter();
```

## Simple use

Most use cases fit the included simple-use functions. These are described as follows:

* [simple usage](usage_simple.md)

If you prefer to learn by example, there is also a tutorial that builds several responses:

* [example responses](usage_example_responses.md)

## Class reference

Each class is explained in detail here:

* [class reference](class_rererence.md)

## Outside the JSON packet

The JSON API requires a specific `Content-Type` header, which can be loaded by `getContentType()`:

```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;

$json_api_formatter = new JsonApiFormatter();
$content_type = $json_api_formatter->getContentType();
// application/vnd.api+json
```