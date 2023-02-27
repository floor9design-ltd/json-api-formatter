# Links

From JSON API documentation:
* Specification: [specification](https://jsonapi.org/format/#document-links)

The `Links` object maps to a `links object`.
These are used to create the `links` section of the packet. From the documentation:

> Where specified, a links member can be used to represent links.

A `Links` object accepts the following instantiation arguments:

```php
    public function __construct(?array $array = []) {
        // ...
    }
```

These are optional to allow dynamic construction of the object. The array should be an array of Link` objects. 

These can be modified using 

* `setLinks()`
* `addLink()`
* `unsetLink()`

The class also exposes:

* `process()`: returns a validated array of the data section
