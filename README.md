Saber
==========

A functional PHP library, which promotes strong typing, immutable objects, and lazy evaluation.

### Requirements

* PHP 5.4+
* The [mbstring](http://php.net/manual/en/book.mbstring.php) extension or the [iconv](http://php.net/manual/en/book.iconv.php) extension (only if dealing with different character sets).
* The [gmp](http://php.net/manual/en/book.gmp.php) extension (only if using `Integer\Type`).

### [Boxing](http://msdn.microsoft.com/en-us/library/yz2be5wk.aspx)

To "box" a PHP typed primitive or object, create an instance of the respective data type using the  class's `make` method.  This method enforces the type by converting the value to the correct data type.  If the value cannot be converted to the correct data type, an exception will be thrown.

````
$object = Int32\Type::make(7);
````

For better performance, use the `box` method to avoid any unnecessary preprocessing that its corresponding `make` method might otherwise perform before creating the instance.

````
$object = Int32\Type::box(7);
````

Some data types are initialized using a singleton method.  For instance, the `Unit\Type` class is initialized like so:

````
$object = Unit\Type::instance();
````

Similarly, other data types have more specific singleton methods.  Amongst these are the `Num` classes, which have singletons for negative one, zero, and positive one.

````
$negative = Int32\Type::negative();
$zero = Int32\Type::zero();
$one = Int32\Type::one();
````

It is recommend that you use these factory/singleton methods, when possible, instead of using the constructor to initialize a data type.  This is for both conventional reasons and implementation reasons.

To "unbox" a boxed object, call the `unbox` method on the respective class to get its value.

````
$value = $object->unbox();
````

### [Fluent API](http://en.wikipedia.org/wiki/Fluent_interface)

Many data types allow for a fluent API; therefore, many methods can be chained together in one statement.  Through the use of PHP's magical `__call` method, certain data types can access their respective module's methods as well as if they were instance methods.  For example, you can do the following:

````
$object = Int32\Type::box(7)->increment()->decrement();
````

This statement is functionally equivalent to writing:

````
$object = Int32\Module::decrement(Int32\Module::increment(Int32\Type::box(7)));
````

Note this fluent API only works with methods that return `Core\Type` objects.

### Methods

In general, methods that are NOT preceded by two underscores will return a boxed object.

````
$object = Int32\Type::box(7)->increment();
````

An exception to this rule is the `unbox` method.

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
`$p` usually represents a position.<br />

`$e` usually represents an exception.<br />

### Callables

An `$operator` function is used to find the result of applying an operator to one or more operands.

````
Core\Type function(Core\Type $c)
Core\Type function(Core\Type $c, Core\Type $x)
````

A `$predicate` function is used to find the result of performing a Boolean evaluation.

````
Bool\Type function(Core\Type $x)
Bool\Type function(Core\Type $x, Int32\Type $i)
````

A `$procedure` function is used to perform an operation that does NOT return a value (even though, technically, it does return a `null` value by default).  In cases where logic benefits to use a return statement to terminate a procedure prematurely, it is recommended that the return value is either a `null` value or an `Unit\Type` object.

````
null function(Core\Type $x)
null function(Core\Type $x, Int32\Type $i)
Unit\Type function(Core\Type $x)
Unit\Type function(Core\Type $x, Int32\Type $i)
````

A `$subroutine` function is used to perform an operation that does return a value.

````
Core\Type function(Core\Type $x)
Core\Type function(Core\Type $x, Int32\Type $i)
````

A `$tryblock` function is used to process a block of code that may throw a runtime exception.

````
Core\Type function()
Core\Type function()
````

### Choices

Objects can be evaluated against each other using the `when` clause.  A `when` clause is satisfied when both `x` and `y` match (i.e. when `$x->__eq($y)` evaluates to `true`).  If a match is encountered, the clause will cause the `$procedure` to be executed.

````
$x = Int32\Type::box(8);
$y = Int32\Type::box(8);

Control\Type::choice($x)
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
$x = Int32\Type::box(8);
$y = Int32\Type::box(7);

Control\Type::choice($x)
	->unless($y, function(Int32\Type $x) {
		// passes, do something
	})
	->otherwise(function(Int32\Type $x) {
		// skipped
	})
->end();
````

### Sequences

A list containing a sequence of numbers can be easily created by doing the following:
````
$object = Int32\Module::sequence(Int32\Type::zero(), Int32\Type::box(5));
````
This means [0..5].  It will produce [0,1,2,3,4,5].

You can also generate sequences like [0,2..10], which will produce [0,2,4,6,8,10].
````
$object = Int32\Module::sequence(Int32\Type::zero(), Tuple\Type::box(Int32\Type::box(2), Int32\Type::box(10)));
````

Similar methods exist as well for Double, Float, and Integer.

### Exceptions

To throw an exception, do the following:

````
$message = 'Hi, my name is :name';
$name = 'Blue Snowman';
$code = Int32\Type::zero();
Control\Exception\Module::raise(new Throwable\UnexpectedValue\Exception(
    $message,                // optional
    array(':name' => $name), // optional
    $code                    // optional
));
````

Besides using the traditional `try/catch` statement, you can use the built in `try_` control feature:

````
$either = Control\Exception\Module::try_(function() {
	// do something that might cause an exception to be thrown
});
````

This will wrap the result into an `Either\Type`.  Convention dictates that the exception will be wrapped in an `Either\Left\Type` and a successful result will be wrapped in an `Either\Right\Type`.

### Hierarchy

Below describes the relationships between data types:

````
+ Core\Type
  + Control\Type
    + Choice\Type
  + Data\Type
    + Bool\Type
    + Char\Type
    + Collection\Type
      + Either\Type
        + Either\Left\Type
        + Either\Right\Type
      + Map\Type
        + HashMap\Type
      + Option\Type
      + Set\Type
        + HashSet\Type
      + Tuple\Type
      + Vector\Type
        + ArrayList\Type
        + LinkedList\Type
        + String\Type
    + Num\Type
      + Floating\Type : Fractional\Type
        + Double\Type : Real\Type
        + Float\Type : Real\Type
      + Integral\Type : Real\Type
        + Int32\Type
        + Integer\Type
        + Trit\Type
      + Ratio\Type : Fractional\Type
    + Object\Type
    + Unit\Type
  + Throwable\Runtime\Exception
    + Throwable\EmptyCollection\Exception
    + Throwable\InvalidArgument\Exception
    + Throwable\OutOfBounds\Exception
    + Throwable\Parse\Exception
    + Throwable\UnexpectedValue\Exception
    + Throwable\UnimplementedMethod\Exception
    + Throwable\Unknown\Exception
  + Util\Type
    + Regex\Type
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
make execute GROUP=TypeTest
````

For more information regarding additional commands, see the [documentation](https://github.com/bluesnowman/fphp-saber/blob/master/Makefile) in the `Makefile` itself.

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
