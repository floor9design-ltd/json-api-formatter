# Relationships

From JSON API documentation:

* Specification: [specification](https://jsonapi.org/format/#document-compound-documents)

The `Included` object maps to a `included member`.
These are used to create the `included` section of the packet. From the documentation:

> In a compound document, all included resources MUST be represented as an array of resource objects
> in a top-level included member.

An `Included` object accepts the following instantiation arguments:

```php
    public function __construct(?array $array = []) 
    {
        // ...
    }
```

The array made from any of the following:

| type  | detail                             |
|-------|------------------------------------|
| array | an array of `DataResource` objects |

## Fluent creation

Methods are available for fluent creation:

* `$included->setDataResources()`
* `$included->addDataResource()`

The class also exposes:

* `$included->process()`: returns a validated array of the Relationships and Relationship objects contained

The following shows a basic data object with two `Link`s inside a `Links` object.

```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\Included;

$json_api_formatter = new JsonApiFormatter();
$data_resource = new DataResource(
    '0896-24609',
    'shuttle',
    ['name' => 'Starbug']
);

// included is an array of data resources
$included_data_resource = new DataResource(
    'JMCRD',
    'mining_freighter',
    ['name' => 'Red Dwarf']
);
$included = new Included([$included_data_resource]);

$json_api_formatter->setIncluded($included);

$response = $json_api_formatter->dataResourceResponse($data_resource);
```

Outputs:

```json
{
  "data": {
    "id": "0896-24609",
    "type": "shuttle",
    "attributes": {
      "name": "Starbug"
    }
  },
  "meta": {
    "status": null
  },
  "jsonapi": {
    "version": "1.1"
  },
  "included": [
    {
      "id": "JMCRD",
      "type": "mining_freighter",
      "attributes": {
        "name": "Red Dwarf"
      }
    }
  ]
}
```

This is shown in [SimpleIncludedTest](../../tests/Unit/Examples/Included/SimpleIncludedTest.php)