# json-api-formatter

[![Latest Version](https://img.shields.io/github/v/release/floor9design-ltd/json-api-formatter?include_prereleases&style=plastic)](https://github.com/floor9design-ltd/json-api-formatter/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=plastic)](LICENCE.md)
[![Build Status](https://img.shields.io/travis/json-api-formatter/master.svg?style=plastic)](https://travis-ci.org/elb98rm/json-api-formatter)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/json-api-formatter/json-api-formatter.svg?style=plastic)](https://scrutinizer-ci.com/g/floor9design/json-api-formatter/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/json-api-formatter/json-api-formatter.svg?style=plastic)](https://scrutinizer-ci.com/g/floor9design/json-api-formatter)
[![Total Downloads](https://img.shields.io/packagist/dt/league/json-api-formatter.svg?style=plastic)](https://packagist.org/packages/floor9design/json-api-formatter)

A set classes that allow for creating JSON API compliant objects

## Introduction

The JSON API has a precise response format. This set of classes allows these to be easy created and interrogated,
meaning easy and reliable output/input processing. 

## Features

The classes offer:

* easy methods to wrap and unwrap content
* default values and settings out of the box, improving the quality of response
* fluent programming approach, allowing objects to be build on the fly

## Install

Via Composer

``` bash
composer require floor9design/json-api-formatter
```

## Usage

This is to be discussed in the usage document.

* [usage](docs/project/usage.md)

## Setup

There are no specific config setup steps required. 
The class should autoload in PSR-4 compliant systems. If you are using the class on its own, simply include it 
however is most appropriate.

## Testing

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
