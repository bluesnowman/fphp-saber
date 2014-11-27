Saber
==========

A functional php library.

### Requirements

* PHP 5.4+
* The [mbstring](http://php.net/manual/en/book.mbstring.php) extension (only if dealing with different character sets).
* The [gmp](http://php.net/manual/en/book.gmp.php) extension (only if using `Integer\Type`).

### [Boxing](http://msdn.microsoft.com/en-us/library/yz2be5wk.aspx)

Most classes implement the boxing interface.  Classes that implement this interface will have three method: `make`, `box`, and `unbox`.

To "box" a PHP typed primitive or object, create an instance of the respective data type using the  class's `make` method.  This method enforces type safety by converting the value to correct type.  If the value cannot be converted to the correct data type, an exception will be thrown.

````
$object = Int32\Type::make(7);
````

For better performance, use the `box` method to avoid type conversion.

````
$object = Int32\Type::box(7);
````
It is recommend that you use either the `make` method or the `box` instead of using the constructor when initializing a data type.

To "unbox" a boxed object, call the `unbox` method on the respective class to get its value.

````
$value = $object->unbox();
````

### [Fluent API](http://en.wikipedia.org/wiki/Fluent_interface)

This library allow for a fluent API; therefore, methods can be chained.  Most classes are not limited to just their methods, but also have access to their module's methods as well by way of PHP's magical `__call` method.  For example, you can do the following:

````
$object = Int32\Type::box(7)->increment()->decrement();
````

This is the same as doing:

````
$object = Int32\Module::decrement(Int32\Module::increment(Int32\Type::box(7)));
````

### Methods

In general, methods that are NOT preceded by two underscores will return a boxed object.  An exception to this rule is the `unbox` method.

````
$object = Int32\Type::box(7)->increment();
````

Methods that are preceded by two underscores will return an unboxed value, which is typically a PHP typed primitive or object.  This is made possible via PHP's magical `__call` method.

````
$value = Int32\Type::box(7)->__increment();
````

### Variables

This library has adopted the following naming conventions for certain variables:

`$x`, `$y`, and `$z` usually represent an object or a value.<br />
`$xs`, `$ys`, and `$zs` usually represent a collection of `$x`, `$y`, and `$z` objects/values, respectively.<br />
`$xss`, `$yss`, and `$zss` usually represent a collection of `$xs`, `$ys`, and `$zs` collections, respectively.<br />

`$c` usually represents a carry.<br />
`$i`, `$j`, and `$k` usually represent an index.<br />
`$n` usually represents a count.<br />

`$f` usually represents a function (i.e. a callable); however, it is preferred to use one of the naming conventions in the next section.<br />

### Callables

An `$operator` function is used to find the result of applying an operation to one or two operands.

````
Core\Type function(Core\Type $c)
Core\Type function(Core\Type $c, Core\Type $x)
````

A `$predicate` function is used to find the result of performing a Boolean evaluation.

````
Bool\Type function(Core\Type $x)
Bool\Type function(Core\Type $x, Int32\Type $i)
````

A `$procedure` function is used to perform an operation that does NOT return a value.

````
null function(Core\Type $x)
null function(Core\Type $x, Int32\Type $i)
````

A `$subroutine` function is used to perform an operation that does return a value.

````
Core\Type function(Core\Type $x)
Core\Type function(Core\Type $x, Int32\Type $i)
````

### Choices

Objects can be evaluated against each other using the `when` clause.  A `when` clause is satisfied when both `x` and `y` match (i.e. when `$x->__eq($y)` evaluates to `true`).  If a match is encountered, the clause will cause the `$procedure` to be executed.

````
$x = Int32\Type::box(8);
$y = Int32\Type::box(8);

Control\Monad::choice($x)
	->when($y, function(Int32\Type $x) {
		// passes, do something
	})
	->otherwise(function(Int32\Type $x) {
		// skipped
	})
->end();
````

Objects can also be evaluated against each other using the `unless` clause.  An `unless`  clause is satisfied when both `x` and `y` do NOT match (i.e. when `$x->__eq($y)` evaluates to `false`).  If the result of the match is false, the clause will cause the `$procedure` to be executed.

````
$x = Int32\Type::make(8);
$y = Int32\Type::make(7);

Control\Monad::choice($x)
	->unless($y, function(Int32\Type $x) {
		// passes, do something
	})
	->otherwise(function(Int32\Type $x) {
		// skipped
	})
->end();
````

### Hierarchy

Below is a list of data types:

````
+ Core\Type
  + Control\Type
    + Choice\Type
  + Data\Type
    + Bool\Type
    + Char\Type
    + Collection\Type
      + ArrayList\Type
      + LinkedList\Type
      + Option\Type
      + String\Type
    + Num\Type
      + Floating\Type
        + Double\Type
        + Float\Type
      + Integral\Type
        + Int32\Type
        + Integer\Type
    + Object\Type
    + Tuple\Type
    + Unit\Type
  + Throwable\Runtime\Exception
    + Throwable\EmptyCollection\Exception
    + Throwable\InvalidArgument\Exception
    + Throwable\OutOfBounds\Exception
    + Throwable\UnexpectedValue\Exception
    + Throwable\UnimplementedMethod\Exception
````

Most data types have a module associated with it.  A module contains a set of common static methods for processing its respective data type.

Collection types also have an iterator class so that the class can be used with the PHP's `foreach` loop.  Because these iterator classes have to conform to PHP's predefined interface, methods in this class act more native than like the rest of this library (i.e. many methods returns native PHP values instead of Saber objects).


### Unit Tests

This library provides a convenient `Makefile` for installing, updating, and uninstalling [Composer](https://getcomposer.org/) and [PHPUnit](http://phpunit.de/).  Similarly, this `Makefile` can also be used to run any unit test included in this library.

To run this `Makefile`, navigate to the folder where it is located on your hard-drive and then type any of the following commands:

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

To run just a specific group of unit tests, for example:

````
make execute GROUP=AnyVal
````

For more information, see the [documentation](https://github.com/bluesnowman/fphp-saber/blob/master/Makefile)
in the `Makefile` itself.

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
