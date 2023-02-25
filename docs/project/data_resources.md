# DataResource objects

The `DataResource` object maps to a [resource object](https://jsonapi.org/format/#document-resource-objects).
These are used to create the `data` section of data: the document's primary data.

Note: JSON API is designed so that related data/relationships can be nested here. Metadata and other items live 
elsewhere. This is your primary object.

A `DataResource` object accepts the following instantiation arguments: 

```php
    public function __construct(
        ?string $id = null,
        ?string $type = null,
        ?array $attributes = null,
        ?DataResourceMeta $data_resource_meta = null,
        ?Relationships $relationships = null
    ) {
        // ...
    }
```

These are all optional to allow dynamic construction of the object. However, from the documentation:

> A resource object MUST contain at least the following top-level members:
> * id
> * type
 
## Example usage

An example basic instantiation might be:

```php 
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\DataResource;

$data_resource = new DataResource(
    'NCC-1701-A',
    'starship',
    ['name' => 'Enterprise']
);
```

As per the [example responses](usage-example-responses.md), this can be processed quickly to be a JSON object:

```php 
$response = $json_api_formatter->dataResourceResponse($data_resource);
```

## Other methods

The class also exposes:

* `process()`: returns a validated array of the data section