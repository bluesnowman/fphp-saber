Saber
==========

A functional php library.

### Requirements

* PHP 5.4+
* The [mbstring](http://php.net/manual/en/book.mbstring.php) extension (only if dealing with different character sets).
* The [gmp](http://php.net/manual/en/book.gmp.php) extension (only if using `Data\Integer`).

### [Boxing](http://msdn.microsoft.com/en-us/library/yz2be5wk.aspx)

To "box" a PHP typed primitive or object, create an instance of the respective data type using the
class's `box` method.  This method enforces type safety.

````
$object = Data\Int32::box(7);
````

For better performance, type safety can be ignored by using the `create` method to create an instance
of the respective data type.  (It recommended to use this method instead of calling the constructor
directly.)

````
$object = Data\Int32::create(7);
````

To "unbox" a boxed object, call the `unbox` method on the respective class to get its value.

````
$value = $object->unbox();
````

### [Fluent API](http://en.wikipedia.org/wiki/Fluent_interface)

This library generally implements a fluent API; therefore, methods can be chained.

````
$object = Data\Int32::box(7)->increment()->decrement();
````

### Methods

In general, methods that are NOT preceded by two underscores will return a boxed object.  An
exception to this rule is the `unbox` method.

````
$object = Data\Int32::box(7)->increment();
````

Methods that are preceded by two underscores will return the unboxed value, which is typically
a PHP typed primitive or object.  This is made possible via PHP's magical `__call` method.

````
$value = Data\Int32::box(7)->__increment();
````

### Variables

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
Core\Any function(Core\Any $c)
Core\Any function(Core\Any $c, Core\Any $x)
````

A `$predicate` function is used to find the result of performing a Boolean evaluation.

````
Data\Bool function(Core\Any $x)
Data\Bool function(Core\Any $x, Data\Int32 $i)
````

A `$procedure` function is used to perform an operation that does NOT return a value.

````
Data\Unit function(Core\Any $x)
Data\Unit function(Core\Any $x, Data\Int32 $i)
````

A `$subroutine` function is used to perform an operation that does return a value.

````
Core\Any function(Core\Any $x)
Core\Any function(Core\Any $x, Data\Int32 $i)
````

### Choices

Objects can be evaluated against each other using the `when` clause.  A `when` clause is
satisfied when both `x` and `y` match (i.e. when `$x->equals($y)` evaluates to `true`).

````
$x = Data\Int32::box(8);
$y = Data\Int32::box(8);

Control\Monad::choice($x)
	->when($y, function(Data\Int32 $x) {
		// passes, do something
	})
	->otherwise(function(Data\Int32 $x) {
		// skipped
	})
->end();
````

Objects can also be evaluated against each other using the `unless` clause.  An `unless`
clause is satisfied when both `x` and `y` do NOT match (i.e. when `$x->equals($y)` evaluates
to `false`).

````
$x = Data\Int32::box(8);
$y = Data\Int32::box(7);

Control\Monad::choice($x)
	->unless($y, function(Data\Int32 $x) {
		// passes, do something
	})
	->otherwise(function(Data\Int32 $x) {
		// skipped
	})
->end();
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
    + Collection\Type
      + Data\ArrayList
        + Data\ArrayList\Iterator
      + Data\LinkedList
        + Data\LinkedList\Iterator
      + Data\Option
        + Data\Option\Iterator
      + Data\String
        + Data\String\Iterator
    + Data\Tuple
    + Data\Wrapper
  + Core\AnyVal
    + Data\Bool
    + Data\Char
    + Num\Type
      + Floating\Type
        + Data\Double
        + Data\Float
      + Integral\Type
        + Data\Int32
        + Data\Integer
    + Data\Unit
+ Core\AnyCtrl
  + Control\Monad
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

To run just a specific group of unit tests, for example:

````
make execute GROUP=AnyVal
````

For more information, see the [documentation](https://github.com/bluesnowman/fphp-saber/blob/master/Makefile)
in the `Makefile` itself.

### Pull Requests

Help improve on this library.  If you have a bug fix, suggestion, or improvement, please submit a
pull request along with any applicable test cases.

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
