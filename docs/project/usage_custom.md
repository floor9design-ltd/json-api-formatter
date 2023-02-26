# Custom usage

It is relatively easy to create custom objects.
There are comprehensive accessors, as well basic defaults. To see these in detail, review the reference section.

Note: when manually creating the objects, they should be formed as per structure of a json api type.
These classes offer basic validation, but it is not comprehensive.

## A quick background

The various parts of a response are mapped to models. For example, a `data resource` maps to a `DataResource` class.

The available classes are:

* `DataResource`
  * ...and its child meta objects:`DataResourceMeta`
* `Included`
* `Links`
  * ...and its child link objects: `Link`
* `Meta`
* `Relationships`
  * ...and its child `Relationship`  
    * ...and their child objects: `RelationshipData`, `RelationshipLinks`, `RelationshipMeta`

These map to the JSONAPI structures as described in the spec.

## Example Approach

Here is an example of fluently populating then exporting a json api response: 

```php
use Floor9design\JsonApiFormatter\Models\JsonApiFormatter;

// Some example data:
$id = "2"; 
$type = 'test';
$attributes = ['test' => 'data'];

$json_api_response = new JsonApiFormatter();

$response = $json_api_response
    // unset the items that are not relevant
    ->unsetErrors()
    ->unsetLinks()
    // add the relevant items
    ->autoIncludeJsonapi()
    ->addData(['id' => $id])
    ->addData(['type' => $type])
    ->addData(['attributes' => $attributes])
    ->addMeta(['info' => 'object created'])
    // export the response
    ->export();
```

## Reference

The following accessors exist:

* `getData()`
* `getErrors()`
* `getMeta()`
* `getJsonapi()`
* `getContentType()`

The following methods are available to manually change the object:

* `setData()`
* `setErrors()`
* `setMeta()`
* `setContentType()` 
* `setJsonapi()` 


If you are creating the objects fluently, the following `add` methods can be used to avoid get/set syntactic hassle.

* `addData()` 
* `addDataAttribute()`
* `addErrors()`
* `addMeta()`

To offer flexibility, the following `unset` methods also exist: 

* `unsetData()`
* `unsetErrors()`
* `unsetMeta()`
* `unsetData()`

If you are setting up an object manually, the following auto populates the standard values:

* `autoIncludeJsonapi()`
