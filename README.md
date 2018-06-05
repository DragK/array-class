# ArrayClass - Array as object for PHP
Lightweight php package to work with arrays like (but fitted to PHP) in JavaScript or C#, 
so you can for example, chain methods. Immutable-first. Collections-like.

Project was built having in mind, that this library has to:
* be lightweight
* be fast 
* be full tested
* be strict typed for better security
* have documentation
* be like JavaScript/C# array object

## Work in progress
* docs 
* homepage

## Installation
Install the latest version with 
```
$ composer require dragk/array-class
```

## Basic Usage
```php
<?php

use DragK\ArrayClass;

$array = new ArrayClass([1, 3, 2, 4]);
$result = $array
            ->sort()
            ->reverse()
            ->map(function($value){
                return $value**2;
            })
            ->filter(function($value) {
                return $value > 8 ;
            })
            ->reduce(function($result, $value) {
                return $result + $value;
            });

var_dump($result); // int(25)
```

## Documentation
* [List of methods](src/ArrayInterface.php)

## About
### Requirments
* PHP 7.0 or above

### Submitting suggestions
Bugs, feature request and code style/approach hints are tracked on GitHub

### License
ArrayClass is licensed under the MIT License - see the LICENSE file for details

### Acknowledgements
This library is inspired by [JavaScript Array Object](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array),
although most concepts have been adjusted to fit to the PHP world.