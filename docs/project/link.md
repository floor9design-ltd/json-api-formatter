# Link

From JSON API documentation:
* Specification: [specification](https://jsonapi.org/format/#document-links-link-object)

The `Link` object maps to a `link object`.
`Link`s are contained within a [links](links.md) object.

> A "link object" is an object that represents a web link.

A `Link` object accepts the following instantiation arguments:

```php
    public function __construct(
        string $href = null,
        ?Link $described_by = null,
        ?string $rel = null,
        ?string $title = null,
        ?string $type = null,
        null|array|string $hreflang = null,
        ?MetaInterface $meta = null
    )
    {
        // ...
    }
```

All apart from `$href` are optional to allow dynamic construction of the object. From the documentation:

> A link object MUST contain the following member:

| member | detail                                                                      | type   |
|--------|-----------------------------------------------------------------------------|--------|
| href   | href: a string whose value is a URI-reference pointing to the link's target | string |

> In addition, a resource object MAY contain any of these top-level members:

| member      | detail                                                                                        | type              |
|-------------|-----------------------------------------------------------------------------------------------|-------------------|
| rel         | a string indicating the link's relation type                                                  | string            |
| describedby | a [Link](link.md) to a description document (e.g. OpenAPI or JSON Schema) for the link target | Link              |
| title       | a string which serves as a label for the destination of a link                                | string            |
| type        | a string indicating the media type of the link's target                                       | string            |
| hreflang    | a string or an array of strings indicating the language(s) of the link's target               | array&vert;string |
| meta        | a [Meta](meta.md) object containing non-standard meta-information about the link              | Meta              |

## Fluent creation:

Methods are available for fluent creation:

* `$link->setHref($href)`
* `$link->setDescribedBy($described_by)`
* `$link->setRel($rel)`
* `$link->setTitle($title)`
* `$link->setType($type)`
* `$link->setHreflang($hreflang)`
* `$link->setMeta($meta)`

The class also exposes:

* `$link->process()`: returns a validated array link

## Example

A `Link` object could be constructed as follows:

```php
use Floor9design\JsonApiFormatter\Models\Link;

$link = new Link(
    'https://www.youtube.com/watch?v=eEeTWVru1qc'
    'related',
    null, // this is an optional nested Link object: keeping it simple for an example!
    'All Wings Report In',
    'html',
    'en-US',
    new Meta(['comment' => 'One of the best role-call scenes ever'])
);
```

There are more examples on [Links](links.md)


