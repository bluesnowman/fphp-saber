Saber
==========

A functional php library.

### Requirements

* PHP 5.4+
* The [mbstring](http://php.net/manual/en/book.mbstring.php) extension.
* The [gmp](http://php.net/manual/en/book.gmp.php) extension (only if using `Core\Integer`).

### [Boxing](http://msdn.microsoft.com/en-us/library/yz2be5wk.aspx)

To "box" a PHP typed primitive or object, create an instance of the respective data type using a
class's `box` method.  The `box` is enforces type safety.

````
$object = Core\Int32::box(23);
````

For better performance, type safety can be ignored by using the `create` method to create an instance
of the respective data type.

````
$object = Core\Int32::create(23);
````

To "unbox" a boxed object, call the `unbox` method on the respective class to get its value.

````
$value = $object->unbox();
````

### [Fluent API](http://en.wikipedia.org/wiki/Fluent_interface)

This library generally implements a fluent API; therefore, methods can be chained.

````
$object = Core\Int32::box(23)->increment()->increment();
````

### Methods

Methods that are NOT preceded by two underscores will return a boxed object.  The only exception
to this rule is the `unbox` method.

````
$object = Core\Int32::box(23)->increment();
````

Methods that are preceded by two underscores will return the unboxed value, which is typically a
PHP typed primitive or object.

````
$value = Core\Int32::box(23)->__increment();
````

### Callables

An `operator` function is used to find the result of applying an operation to one or two operands.

````
$operator = function(Core\Any $carry, Core\Any $element) { return [Core\Any]; };
````

A `predicate` function is used to find the result of preforming a Boolean evaluation.

````
$predicate = function(Core\Any $element, Core\Int32 $index) { return [Core\Bool]; };
````

A `procedure` function is used to preform an operation without returning a value.

````
$procedure = function(Core\Any $element, Core\Int32 $index) { return [Core\Unit]; };
````

A `subroutine` function is used to preform an operation that does return a value.

````
$subroutine = function(Core\Any $element, Core\Int32 $index) { return [Core\Any]; };
````

### Hierarchy

````
+ Core\Any
  + Core\AnyRef
    + Core\AnyErr
      + Throwable\Runtime\Exception
        + Throwable\EmptyCollection\Exception
        + Throwable\InvalidArgument\Exception
        + Throwable\OutOfBounds\Exception
        + Throwable\UnexpectedValue\Exception
        + Throwable\UnimplementedMethod\Exception
    + Core\Collection
      + Core\ArrayList
      + Core\LinkedList
      + Core\String
    + Core\Tuple
    + Core\Wrapper
  + Core\AnyVal
    + Core\Bool
    + Core\Char
    + Core\Num
      + Core\Floating
        + Core\Double
        + Core\Float
      + Core\Integral
        + Core\Int32
        + Core\Integer
    + Core\Nothing
    + Core\Unit
````

### Unit Tests

This library provides a convenient `Makefile` for installing, updating, and uninstalling
[Composer](https://getcomposer.org/) and [PHPUnit](http://phpunit.de/).  Similarly, this
`Makefile` can also be used to run any unit test included in this library.

To run this `Makefile`, navigate to the folder where it is located on your hard-drive and
then type any of the following commands:

To install both Composer and PHPUnit:

````
make install
````

To update both Composer and PHPUnit:

````
make update
````

To uninstall both Composer and PHPUnit:

````
make uninstall
````

To run all unit tests:

````
make execute
````

To run just a specific group of unit tests:

````
make execute GROUP=AnyVal
````

For more information, see the [documentation](https://github.com/bluesnowman/fphp-saber/blob/master/Makefile) in the `Makefile` file itself.

### Pull Requests

Help improve on this library.  If you have a bug fix, suggestion, or improvement, please submit a pull request along with any applicable test cases.

### License

Copyright 2014 Blue Snowman

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

[http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0)

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
