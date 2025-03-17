# Relationships

From JSON API documentation:

* Specification: [specification](https://jsonapi.org/format/#document-resource-objects)

The `Relationships` object maps to a `Relationships object`.
These are used to create the `relationships` section of the packet. From the documentation:

> The value of the relationships key MUST be an object (a “relationships object”). Each member of a relationships
> object represents a “relationship” from the resource object in which it has been defined to other resource objects.

***Gotcha***: relationships are not the content of the relationship: they are meta data about it. If you want to
include a relationship with the child object(s), add this to the relationship, then include them using a `Related`
object.

A `Relationships` object accepts the following instantiation arguments:

```php
    public function __construct(?array $array = []) 
    {
        // ...
    }
```

The array made from any of the following:

| type                    | detail                                    |
|-------------------------|-------------------------------------------|
| a `Relationship` object | a [Relationship](relationships.md) object |
| array                   | an array of Relationship objects          |

## Fluent creation

Methods are available for fluent creation:

* `$relationships->setRelationships()`
* `$relationships->addRelationship()`
* `$relationships->unsetRelationship()`

The following shows a basic data object with two `Link`s inside a `Links` object. These are one-to-one relationships.

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

This is shown in [SimpleRelationshipTest](../../tests/Unit/Examples/Relationships/SimpleRelationshipTest.php)

## One-to-many relationships

```php 

$json_api_formatter = new JsonApiFormatter();
$data_resource = new DataResource(
    'red-5',
    'x-wing',
    ['pilot' => 'Luke Skywalker']
);

// each relationship is similar to a separate object, with slightly less content in the main data resource
$relationship_one_data = new DataResource('red-2', 'x-wing');
$relationship_two_data = new DataResource('red-october', 'submarine');

$relationship_links = new Links(
    [
        'good_meme' => new Link('https://www.youtube.com/watch?v=CF18ojCoo5k')
    ]
);

$relationship_one = new Relationship(
    [$relationship_one_data, $relationship_two_data],
    $relationship_links
);

$relationships = new Relationships(['wingman' => $relationship_one]);

// These are relationships to the main data, so are added to the main data resource:
$data_resource->setRelationships($relationships);

$response = $json_api_formatter->dataResourceResponse($data_resource);

```

This gives:

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
        "data": [
          {
            "id": "red-2",
            "type": "x-wing"
          },
          {
            "id": "red-october",
            "type": "submarine"
          }
        ],
        "links": {
          "good_meme": {
            "href": "https://www.youtube.com/watch?v=CF18ojCoo5k"
          }
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

This is shown in
[SimpleRelationshipsArrayTest](../../tests/Unit/Examples/Relationships/SimpleRelationshipsArrayTest.php)