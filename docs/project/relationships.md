# Relationships

From JSON API documentation:

* Specification: [specification](https://jsonapi.org/format/#document-resource-objects)

The `Relationships` object maps to a `Relationships object`.
These are used to create the `relationships` section of the packet. From the documentation:

> The value of the relationships key MUST be an object (a “relationships object”). Each member of a relationships
> object represents a “relationship” from the resource object in which it has been defined to other resource objects.

A `Relationships` object accepts the following instantiation arguments:

```php
    public function __construct(?array $array = []) 
    {
        // ...
    }
```

The array made from any of the following:

| type                    | detail                                   |
|-------------------------|------------------------------------------|
| a `Relationship` object | a [Relationship](relationship.md) object |
| array                   | an array of Relationship objects         |

## Fluent creation

Methods are available for fluent creation:

* `$relationships->setRelationships()`
* `$relationships->addRelationship()`
* `$relationships->unsetRelationship()`

The class also exposes:

* `$Relationships->process()`: returns a validated array of the Relationships and Relationship objects contained

The following shows a basic data object with two `Link`s inside a `Links` object.

```php
    $json_api_formatter = new JsonApiFormatter();
    $data_resource = new DataResource(
        'unregistered',
        'battlecruiser',
        ['name' => 'Hyperion']
    );

    $links = new Links(
        [
            'self' => 'https://starcraft.fandom.com/wiki/Hyperion',
            'support' => new Link('https://starcraft.fandom.com/wiki/Viking')
        ]
    );
    $json_api_formatter->setLinks($links);
    $response = $json_api_formatter->dataResourceResponse($data_resource);
```

Outputs:

```json
{
  "data": {
    "id": "red-5",
    "type": "x-wing",
    "attributes": {
      "pilot": "Luke Skywalker"
    },
    "relationships": {
      "wingman": {
        "data": {
          "id": "red-2",
          "type": "x-wing"
        },
        "links": {
          "good_scene": "https://www.youtube.com/watch?v=eEeTWVru1qc"
        },
        "meta": {
          "pilot": "Wedge Antilles"
        }
      },
      "backup": {
        "data": {
          "id": "red-october",
          "type": "submarine "
        },
        "links": {
          "good_meme": {
            "href": "https://www.youtube.com/watch?v=CF18ojCoo5k"
          }
        },
        "meta": {
          "captain": "Marko Aleksandrovich Ramius"
        }
      }
    }
  },
  "meta": {
    "status": null
  },
  "jsonapi": {
    "version": "1.1"
  }
}
```