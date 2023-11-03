# php-di-container
Dependency injection container in PHP

This is a simple automatic dependency injection container in PHP.

## Basic setup
To install this package, run the following command in the root of your project:
```
composer require kyrill/php-di-container
```
## Usage
### Create a container
You can create a container by instantiating the `Container` class.
```php
<?php
use Kyrill\DIContainer\Container;
$container = new Container();
```
### Register a class
#### Register a class with a function
You can register a class with a function.
```php
<?php
$container->register('namespace\classname',[arguments];
```
#### Register a class with a file
You can make a json file with the following structure, to register the classes or interfaces:
```json
{
  "services": {
    "\\namespace\\classname": {},
    "\\namespace\\classname": {
      "class": "\\Kyrill\\PhpDiContainer\\Test",
      "arguments": {
        "testdfgf": "\\Kyrill\\PhpDiContainer\\TestInterface",
        "foo": "bar"
      }
    },
    "\\namespace\\alias": {
      "class": "\\Kyrill\\PhpDiContainer\\Test",
      "arguments": {
        "testdfgf": "\\Kyrill\\PhpDiContainer\\TestInterface",
        "foo": "bar"
      }
    }
  }
}
```
To register the file you can use the following function:
```php
<?php
$container->registerFile('.\di.json');
```
### Get a class
You can get a class by using the `resolve` function.
```php
<?php
$container->resolve('namespace\classname');
```
## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details