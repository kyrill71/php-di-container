# php-di-container
Dependency injection container in PHP

This is a simple automatic dependency injection container in PHP.

## Basic setup
To install this package, run the following command in the root of your project:
```
composer require Kyrill\PhpDiContainer
```
## Usage
### Create a container
You can create a container by instantiating the `Container` class.
```php
<?php
use Kyrill\PhpDiContainer\Container;
$container = new Container();
```

---

### Register a class

You don't need to register a class. All classes would be automatically resolved unless there is an argument in the
constructor that isn't a class.

#### Register a class with a function

You can register a class with a function. First give the clas a unique name, then put the class: "class definition" in
the function in the class definitions gave it the namespace of the class and the arguments. after that define if the
class is a singleton or not. By default, a class is not a singleton. If you don't want to use arguments you can leave the array empty.
```php
$container->register('name', new ClassDefinition(['argument1', 'argument2'], 'namespace\\classname/', true));
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

##### Register file

To register the file you need to make a `ClassRegistar` class. You can register the file by using the `registerFile`
function. By default, there is a `JsonFileReader` class. This class reads a json file and registers the classes or
interfaces. But you can make your own `FileReader` class.
```php
$classRegister = new ClassRegistar();
$classRegister->registerFile('.\di.json', new JsonFileReader(), $container);
```

##### Make Your Own `FileReader`

To create your own `FileReader` class, implement the `FileReaderInterface`. This interface defines a single method:
`readFile()`. The method must return an array of classes, aliases, or interfaces.

The file must start with the keyword `services`, and all classes, aliases, or interfaces should be listed under it.

---

### Get a Class

You can retrieve a class using the `resolve` function. To resolve an alias, pass the alias namespace as a string, like this:
`'namespace\\alias'`.
```php
<?php
$container->resolve(Classname::class);
```
## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details