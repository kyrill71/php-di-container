# php-di-container
Dependency injection container in PHP

This is a simple automatic dependency injection container in PHP.

## Basic setup
To install this package, run the following command in the root of your project:
```
composer require kyrill/php-di-container:dev-main
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
$container->register(Classname::class, [arguments]);
```
#### Register classes by a file
You can make a json file with the following structure, to register the classes, aliases or interfaces:
```json
{
  "services": {
    "namespace\\classname": {
      "arguments": {
        "test": "\\Kyrill\\PhpDiContainer\\TestInterface",
        "foo": "bar"
      }
    },
    "namespace\\alias": {
      "class": "Kyrill\\PhpDiContainer\\Test",
      "arguments": {
        "test": "Kyrill\\PhpDiContainer\\TestInterface",
        "foo": "bar"
      }
    }
  }
}
```
You can use aliases to register classes or interfaces. Aliases are useful if you want to use a class or interface with a different name. For aliases and interfaces you have to use the `class` key. The `arguments` key is optional. If you want to use a class or interface without arguments.

#### Register class by function
To register the file you need to make a `FileReader` class. This class needs to implement the `FileReaderInterface`. You can register the file by using the `registerFile` function. By default there is a `JsonFileReader` class. This class reads a json file and registers the classes or interfaces. But you can make your own `FileReader` class.
```php
<?php
$classRegistar = new ClassRegistar();
$classRegistar->registerFile('.\di.json', new JsonFileReader(), $container);
```
### Get a class
You can get a class by using the `resolve` function. If want to get an alias you just put the aliasname with quotes like this: 'aliasname' in the function.
```php
<?php
$container->resolve(Classname::class);
```
### make your own FileReader
To make your own `FileReader` class you need to implement the `FileReaderInterface`. This interface has one function `readFile`. This function needs to return an array with the classes, aliases or interfaces.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details