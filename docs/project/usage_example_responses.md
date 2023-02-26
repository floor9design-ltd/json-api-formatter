# Example responses

## Introduction

This is a tutorial that works through many of the basics. It is echoed in the unit test `ExampleResponsesTest` and is 
designed to give a working overview of the classes.

Remember: this software confirms to the JSONAPI standard, so it's a good idea to keep the definition/references nearby.
These code snippets will create validated code from the provided web validator.

* [Validator](https://www.jsonschemavalidator.net/)
* [Official definition/format](https://jsonapi.org/format/)
* Tests: `tests/Unit/ExampleResponsesTest.php`

## DataResponses

Data responses are the main use case for an API.

### Data Response : Single resource

Single data resources simple as it comes really: 

```php
// include classes
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\DataResource;

// instantiate a new instance of the formatter:
$json_api_formatter = new JsonApiFormatter();

// setup a data resource:
$data_resource = new DataResource(
    'NCC-1701-A',
    'starship',
    ['name' => 'Enterprise']
);

$response = $json_api_formatter->dataResourceResponse($data_resource);
```
`$response` is the following json:
```json
{
  "data": {
    "id": "NCC-1701-A",
    "type": "starship",
    "attributes": {
      "name": "Enterprise"
    }
  },
  "meta": {
    "status": null
  },
  "jsonapi": {
    "version": "1.0"
  }
}
```
Note that this is separate to the entire response meta (see below).

### Data Response : Adding response meta

The response can offer meta information. By default there is already basic request information included, but this can
be extended or overwritten.

```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\Meta;

$json_api_formatter = new JsonApiFormatter();
$data_resource = new DataResource(
    'XD-1',
    'starship',
    ['name' => 'Discovery One']
);

// set up the meta
$meta = new Meta(
    ['status' => '200']
);

// if you wish to overwrite existing content, use setMeta, else use addMeta
$json_api_formatter->setMeta($meta);

$response = $json_api_formatter->dataResourceResponse($data_resource);
```
`$response` is the following json:
```json
{
  "data": {
    "id": "XD-1",
    "type": "starship",
    "attributes": {
      "name": "Discovery One"
    }
  },
  "meta": {
    "status": "200"
  },
  "jsonapi": {
    "version": "1.0"
  }
}
```
### Data Response : Single resource with resource meta

Single data resources can have their own meta (`DataResourceMeta`):

```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\DataResourceMeta;

$json_api_formatter = new JsonApiFormatter();
$data_resource = new DataResource(
    'ECF-270',
    'starship',
    ['name' => 'Rocinante']
);

// Assign the meta to the data resource
$data_resource_meta = new DataResourceMeta(
    ['previous_name' => 'MCRN Tachi']
);
$data_resource->setDataResourceMeta($data_resource_meta);

$response = $json_api_formatter->dataResourceResponse($data_resource);
```
`$response` is the following json:
```json
{
  "data": {
    "id": "ECF-270",
    "type": "starship",
    "attributes": {
      "name": "Rocinante"
    },
    "meta": {
      "previous_name": "MCRN Tachi"
    }
  },
  "meta": {
    "status": null
  },
  "jsonapi": {
    "version": "1.0"
  }
}
```
### Data Response : Single resource with response links

Single data resources can offer links relevant to the response

```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\DataResource;

$json_api_formatter = new JsonApiFormatter();
$data_resource = new DataResource(
    'unregistered',
    'battlecruiser',
    ['name' => 'Hyperion']
);

// links can be either a URL or a structured array (href, meta) inside a Links object
$links = new Links(
    [
        'self' => 'https://starcraft.fandom.com/wiki/Hyperion',
        'support' => new Link(
            [
                'href' => 'https://starcraft.fandom.com/wiki/Viking',
            ]
        )
    ]
);
$json_api_formatter->setLinks($links);

$response = $json_api_formatter->dataResourceResponse($data_resource);
```
`$response` is the following json:
```json
{
  "data": {
    "id": "unregistered",
    "type": "battlecruiser",
    "attributes": {
      "name": "Hyperion"
    }
  },
  "meta": {
    "status": null
  },
  "jsonapi": {
    "version": "1.0"
  },
  "links": {
    "self": "https://starcraft.fandom.com/wiki/Hyperion",
    "support": {
      "href": "https://starcraft.fandom.com/wiki/Viking"
    }
  }
}
```
### Data Response : Single resource with some included data 

Single data resources can offer included data resources.
```php
// include classes
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
`$response` is the following json:
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
    "version": "1.0"
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
### Data Response : Single resource with relationships

Single data resources can offer relationships. These also can have links and meta relevant to the included
resources. Note that the relationship data resource is limited.
```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\DataResource;
use Floor9design\JsonApiFormatter\Models\Relationship;
use Floor9design\JsonApiFormatter\Models\RelationshipData;
use Floor9design\JsonApiFormatter\Models\RelationshipLinks;
use Floor9design\JsonApiFormatter\Models\RelationshipMeta;
use Floor9design\JsonApiFormatter\Models\Relationships

$json_api_formatter = new JsonApiFormatter();
$data_resource = new DataResource(
    'red-5',
    'x-wing',
    ['pilot' => 'Luke Skywalker']
);

// each relationship is similar to a separate object, with slightly less content in the main data resource
$relationship_one_data = new RelationshipData('red-2', 'x-wing');
$relationship_one_meta = new RelationshipMeta(['pilot' => 'Wedge Antilles']);
$relationship_one_links = new RelationshipLinks(['good_scene' => 'https://www.youtube.com/watch?v=eEeTWVru1qc']);
$relationship_one = new Relationship(
    $relationship_one_links,
    $relationship_one_data,
    $relationship_one_meta
);

$relationship_two_data = new RelationshipData('red-october', 'submarine ');
$relationship_two_meta = new RelationshipMeta(['captain' => 'Marko Aleksandrovich Ramius']);
// alternate link build
$relationship_two_links = new RelationshipLinks(
    [
        'good_meme' => new Link(['href' => 'https://www.youtube.com/watch?v=CF18ojCoo5k'])
    ]
);
$relationship_two = new Relationship(
    $relationship_two_links,
    $relationship_two_data,
    $relationship_two_meta
);

$relationships = new Relationships(['wingman' => $relationship_one, 'backup' => $relationship_two]);

// These are relationships to the main data, so are added to the main data resource:
$data_resource->setRelationships($relationships);

$response = $json_api_formatter->dataResourceResponse($data_resource);
```
`$response` is the following json:
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
    "version": "1.0"
  }
}
```
### Data Response : Multiple objects

The data resource can be either a `DataResource` or an array of `DataResources`.

```php
// include classes
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;
use Floor9design\JsonApiFormatter\Models\DataResource;

// instantiate a new instance of the formatter:
$json_api_formatter = new JsonApiFormatter();

// add data resources:
$data_resource = new DataResource(
    'BSG75',
    'battlestar',
    ['name' => 'Galactica']
);

$data_resource2 = new DataResource(
    'BSG62',
    'battlestar',
    ['name' => 'Pegasus']
);

$response = $json_api_formatter->dataResourceResponse([$data_resource, $data_resource2]);

```
`$response` is the following json:
```json
{
  "data": [
    {
      "id": "BSG75",
      "type": "battlestar",
      "attributes": {
        "name": "Galactica"
      }
    },
    {
      "id": "BSG62",
      "type": "battlestar",
      "attributes": {
        "name": "Pegasus"
      }
    }
  ],
  "meta": {
    "status": null
  },
  "jsonapi": {
    "version": "1.0"
  }
}
