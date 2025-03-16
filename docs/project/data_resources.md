# DataResource objects

From JSON API documentation:
* Specification: [specification](https://jsonapi.org/format/#document-resource-objects)

The `DataResource` object maps to a `resource object`.
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
    ) 
    {
        // ...
    }
```

These are optional to allow dynamic construction of the object. However, from the documentation:

> A resource object MUST contain at least the following top-level members:

| member | detail                                                                                            | type   |
|--------|---------------------------------------------------------------------------------------------------|--------|
| id     | a unique identifier for this particular occurrence of the problem                                 | string |
| type   | a type member is used to describe resource objects that share common attributes and relationships | string |

> Exception: The id member is not required when the resource object originates at the client and represents a new 
> resource to be created on the server. In that case, a client MAY include a lid member to uniquely identify the 
> resource by type locally within the document.

> In addition, a resource object MAY contain any of these top-level members:

| member        | detail                                                      | type          |
|---------------|-------------------------------------------------------------|---------------|
| attributes    | A associative array (*) representing an `attributes` object | array         |
| relationships | [relationships object](relationships.md)                    | Relationships |
| links         | [links object](links.md)                                    | Links         |
| meta          | [meta object](meta.md)                                      | Meta          |

(*) Note: in JSON this is an object, but within php it is simpler and more appropriate to use an associative array as 
this is all it is.

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

As per the [example responses](usage_example_responses.md), this can be processed quickly to be a JSON object:

```php 
$response = $json_api_formatter->dataResourceResponse($data_resource);
```

## Other methods

The class also exposes:

* `process()`: returns a validated array of the data section