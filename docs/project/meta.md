# Meta

From JSON API documentation:
* Specification: [specification](https://jsonapi.org/format/#document-meta)

The `Meta` object can be used to include non-standard meta-information.

A `Meta` object accepts the following instantiation arguments:

```php
    public function __construct(?array $array = [])
    {
        // ...
    }
```

The array has no defined shape, but will be converted to be associative when output.

## Example

A `Meta` object could be constructed as follows:

```php
use Floor9design\JsonApiFormatter\Models\Meta;

$meta_information = [
    'pilot' => 'Wedge Antilles'
];

$meta = new Meta($meta_information);
```

