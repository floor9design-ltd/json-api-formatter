# Class Reference

## Base Classes

All structures are based around a `JsonApiFormatter` object

* [JsonApiFormatter](jsonapiformatter.md)

This is constructed of a number of subclasses

* [DataResource](data_resources.md)
* [Errors](errors.md) and the related [Source](source.md)
* [Links](links.md) and the related [Link](link.md)
* [Meta](meta.md)
* [Relationships](relationships.md)
* [Included](included.md)
* [Source](source.md)

## Interfaces

All class objects implement Interfaces, and use an *[object]Interface* naming convention.

For example:

* `Links` implements `LinksInterface`

All accessors typehint to the Interface version of what they are accessing.