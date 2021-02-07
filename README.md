# json-api-formatter

[![Latest Version](https://img.shields.io/github/v/release/floor9design-ltd/json-api-formatter?include_prereleases&style=plastic)](https://github.com/floor9design-ltd/json-api-formatter/releases)
[![Packagist](https://img.shields.io/packagist/v/floor9design/json-api-formatter?style=plastic)](https://packagist.org/packages/floor9design/json-api-formatter)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=plastic)](LICENCE.md)

[![Build Status](https://img.shields.io/travis/floor9design-ltd/json-api-formatter?style=plastic)](https://travis-ci.com/github/floor9design-ltd/json-api-formatter)
[![Build Status](https://img.shields.io/codecov/c/github/floor9design-ltd/json-api-formatter?style=plastic)](https://codecov.io/gh/floor9design-ltd/json-api-formatter)

[![Github Downloads](https://img.shields.io/github/downloads/floor9design-ltd/json-api-formatter/total?style=plastic)](https://github.com/floor9design-ltd/json-api-formatter)
[![Packagist Downloads](https://img.shields.io/packagist/dt/floor9design/json-api-formatter?style=plastic)](https://packagist.org/packages/floor9design/json-api-formatter)


A set classes that allow for creating JSON API compliant objects

## Introduction

The JSON API has a precise response format. This set of classes allows these to be easy created and interrogated,
meaning easy and reliable output/input processing. 

## Features

[![Latest Version](https://img.shields.io/github/v/release/floor9design-ltd/json-api-formatter?include_prereleases&style=plastic)](https://github.com/floor9design-ltd/json-api-formatter/releases)
[![Packagist](https://img.shields.io/packagist/v/floor9design/json-api-formatter?style=plastic)](https://packagist.org/packages/floor9design/json-api-formatter)

The classes offer:

* easy methods to wrap and unwrap content
* default values and settings out of the box, improving the quality of response
* fluent programming approach, allowing objects to be build on the fly

## Install

Via Composer/packagist

[![Packagist Downloads](https://img.shields.io/packagist/dt/floor9design/json-api-formatter?style=plastic)](https://packagist.org/packages/floor9design/json-api-formatter)

``` bash
composer require floor9design/json-api-formatter
```

Via git

[![Github Downloads](https://img.shields.io/github/downloads/floor9design-ltd/json-api-formatter/total?style=plastic)](https://github.com/floor9design-ltd/json-api-formatter)

``` bash
git clone https://github.com/floor9design-ltd/json-api-formatter.git
```
Or: 
``` bash
git clone git@github.com:floor9design-ltd/json-api-formatter.git
```

## Usage

This is discussed in the usage document.

* [usage](docs/project/usage.md)

## Setup

There are no specific config setup steps required. 
The class should autoload in PSR-4 compliant systems. If you are using the class on its own, simply include it 
however is most appropriate.

## Testing

[![Build Status](https://img.shields.io/travis/floor9design-ltd/json-api-formatter?style=plastic)](https://travis-ci.com/github/floor9design-ltd/json-api-formatter)
[![Build Status](https://img.shields.io/codecov/c/github/floor9design-ltd/json-api-formatter?style=plastic)](https://codecov.io/gh/floor9design-ltd/json-api-formatter)

Tests can be run as follows:

* `./vendor/phpunit/phpunit/phpunit`

The following tests and also creates code coverage (usually maintained at 100%)

* `./vendor/phpunit/phpunit/phpunit --coverage-html docs/tests/`

## Credits

- [Rick](https://github.com/elb98rm)

## Changelog

A changelog is generated here:

* [Change log](CHANGELOG.md)

## License

This software is available under the MIT licence. 

* [License File](LICENCE.md)
