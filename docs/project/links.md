# Links

From JSON API documentation:
* Specification: [specification](https://jsonapi.org/format/#document-links)

The `Links` object maps to a `links object`.
These are used to create the `links` section of the packet. From the documentation:

> Where specified, a links member can be used to represent links.

A `Links` object accepts the following instantiation arguments:

```php
    public function __construct(?array $array = []) 
    {
        // ...
    }
```

The array made from any of the following: 

| type            | detail                                                                |
|-----------------|-----------------------------------------------------------------------|
| string          | a string whose value is a URI-reference pointing to the link’s target |                        | string            |
| a `Link` object | a [Link](link.md) object                                              |
| null            | null if the link does not exist                                       |

The naming of these should be considered:

> link’s relation type SHOULD be inferred from the name of the link unless the link is a link object and the link 
> object has a rel member.

Example names might be `self`, `related`

## Fluent creation

Methods are available for fluent creation:

* `$links->setLinks()`
* `$links->addLink()`
* `$links->unsetLink()`

The class also exposes:

* `$links->process()`: returns a validated array of the links and link objects contained
