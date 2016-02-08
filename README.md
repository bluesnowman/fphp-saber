Saber
==========

A functional PHP library, which promotes strong typing, immutable objects, and lazy evaluation.

[![License](https://poser.pugx.org/bluesnowman/fphp-saber/license.svg)](https://packagist.org/packages/bluesnowman/fphp-saber)
[![Latest Stable Version](https://poser.pugx.org/bluesnowman/fphp-saber/v/stable.svg)](https://packagist.org/packages/bluesnowman/fphp-saber)
[![Build Status](https://secure.travis-ci.org/bluesnowman/fphp-saber.svg)](http://travis-ci.org/bluesnowman/fphp-saber)
[![Dependency Status](https://www.versioneye.com/user/projects/5531e96410e7149066000cf8/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5531e96410e7149066000cf8)
[![Code Coverage](https://codeclimate.com/github/bluesnowman/fphp-saber/badges/gpa.svg)](https://codeclimate.com/github/bluesnowman/fphp-saber)
[![Issue Count](https://codeclimate.com/github/bluesnowman/fphp-saber/badges/issue_count.svg)](https://codeclimate.com/github/bluesnowman/fphp-saber)
[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/bluesnowman/fphp-saber.svg)](http://isitmaintained.com/project/bluesnowman/fphp-saber "Average time to resolve an issue")
[![Percentage of issues still open](http://isitmaintained.com/badge/open/bluesnowman/fphp-saber.svg)](http://isitmaintained.com/project/bluesnowman/fphp-saber "Percentage of issues still open")
[More...](https://www.openhub.net/p/fphp-saber)

### Requirements

* PHP 7.0+
* The [mbstring](http://php.net/manual/en/book.mbstring.php) extension or the [iconv](http://php.net/manual/en/book.iconv.php) extension (only if dealing with different character sets).
* The [gmp](http://php.net/manual/en/book.gmp.php) extension (only if using `IInteger\Type`).

### [Boxing](http://msdn.microsoft.com/en-us/library/yz2be5wk.aspx)

To "box" a PHP typed primitive or object, create an instance of the respective data type using the  class's `make` method.  This method enforces the type by converting the value to the correct data type.  If the value cannot be converted to the correct data type, an exception will be thrown.

````
$object = IInt32\Type::make(7);
````

For better performance, use the `box` method to avoid any unnecessary pre-processing that its corresponding `make` method might otherwise perform before creating the instance.

````
$object = IInt32\Type::box(7);
````

Some data types are initialized using a singleton method.  For instance, the `IUnit\Type` class is initialized like so:

````
$object = IUnit\Type::instance();
````

Similarly, other data types have more specific singleton methods.  Amongst these is the `ITrit` data type, which has three singleton methods for negative one, zero, and positive one.

````
$negative = ITrit\Type::negative();
$zero = ITrit\Type::zero();
$positive = ITrit\Type::positive();
````

It is recommend that you use these factory/singleton methods, when possible, instead of using the constructor to initialize a data type.  This is for both conventional reasons and implementation reasons.

To "unbox" a boxed object, call the `unbox` method on the respective class to get its value.

````
$value = $object->unbox();
````

### [Fluent API](http://en.wikipedia.org/wiki/Fluent_interface)

Many data types allow for a fluent API; therefore, many methods can be chained together in one statement.  Through the use of PHP's magical `__call` method, certain data types can access their respective module's methods as if they were instance methods.  (Methods in a module are defined similarly to how [extension methods](http://msdn.microsoft.com/en-us/library/bb383977.aspx) are defined in C#.)  For example, you can do the following:

````
$object = IInt32\Type::box(7)->increment()->decrement();
````

This statement is functionally equivalent to writing:

````
$object = IInt32\Module::decrement(IInt32\Module::increment(IInt32\Type::box(7)));
````

Note: this fluent API only works with methods that return `Core\Type` objects.

### Classes

A `Type` class defines a lean interface for a particular type.

A `Module` class defines a set of methods that are used to process its corresponding `Type` class.  All methods are static and must define for their first argument its corresponding `Type` class.

A `Utilities` class defines an assortment of methods that are related to its corresponding `Type` class.  All methods are static.

An `Iterator` class defines how a collection is counted and iterated over by PHP.

### Methods

In general, methods that are NOT preceded by two underscores will return a boxed object.

````
$object = IInt32\Type::box(7)->increment();
````

One notable exception to this rule is the `unbox` method.

Methods that are preceded by two underscores will return an unboxed value, which is typically a PHP typed primitive or object.  This is made possible via PHP's magical `__call` method.

````
$value = IInt32\Type::box(7)->__increment();
````

This is essentially functionally equivalent to writing:

````
$value = IInt32\Type::box(7)->increment()->unbox();
````

### Variables

This library has adopted the following naming conventions for certain variables:

`$c` usually represents a carried value.<br />
`$e` usually represents an exception.<br />
`$i`, `$j`, and `$k` usually represent an index or count.<br />
`$n` usually represents a quantity.<br />
`$p` usually represents a position.<br />
`$r` usually represents a result.<br />

`$x`, `$y`, and `$z` usually represent an object or a value.<br />
`$xs`, `$ys`, and `$zs` usually represent a collection of `$x`, `$y`, and `$z` objects/values, respectively.<br />
`$xss`, `$yss`, and `$zss` usually represent a collection of `$xs`, `$ys`, and `$zs` collections, respectively.<br />

`$xi`, `$yi`, and `$zi` usually represent an iterator for a collection of `$x`, `$y`, and `$z` objects/values, respectively.<br />
`$xsi`, `$ysi`, and `$zsi` usually represent an iterator for a collection of `$xs`, `$ys`, and `$zs` collections, respectively.<br />

### Callables

A `$closure` function does not have a predefined signature or return type; but, as a general rule, it should utilize Core\Type objects for parameter and return types.

````
function(?Core\Type... $m) : ?Core\Type
````

An `$operator` function is used to find the result of applying an operator to one or more operands.

````
function(Core\Type $c) : Core\Type
function(Core\Type $c, Core\Type $x) : Core\Type
````

A `$predicate` function is used to find the result of performing a Boolean evaluation.

````
function(Core\Type $x) : IBool\Type
function(Core\Type $x, IInt32\Type $i) : IBool\Type
````

A `$procedure` function is used to perform an operation that does NOT return a value (even though, technically, PHP does return a `null` value by default).  In cases where logic benefits to use a return statement to terminate a procedure prematurely, the return value must be either a `null` value or an `IUnit\Type` object.

````
function(Core\Type $x) : ?IUnit\Type
function(Core\Type $x, IInt32\Type $i) : ?IUnit\Type
````

A `$subroutine` function is used to perform an operation that does return a value.

````
function(Core\Type $x) : Core\Type
function(Core\Type $x, IInt32\Type $i) : Core\Type
````

A `$tryblock` function is used to process a block of code that may throw a runtime exception.

````
function() : Core\Type
````

### Choices

Objects can be evaluated against each other using the `when` clause.  A `when` clause is satisfied when both `x` and `y` match (i.e. when `$x->__eq($y)` evaluates to `true`).  If a match is encountered, the clause will cause the `$procedure` to be executed.

````
$x = IInt32\Type::box(8);
$y = IInt32\Type::box(8);

Control\Type::choice($x)
	->when($y, function(IInt32\Type $x) {
		// passes, do something
	})
	->otherwise(function(IInt32\Type $x) {
		// skipped
	})
->end();
````

Objects can also be evaluated against each other using the `unless` clause.  An `unless`  clause is satisfied when both `x` and `y` do NOT match (i.e. when `$x->__eq($y)` evaluates to `false`).  If the result of the match is false, the clause will cause the `$procedure` to be executed.

````
$x = IInt32\Type::box(8);
$y = IInt32\Type::box(7);

Control\Type::choice($x)
	->unless($y, function(IInt32\Type $x) {
		// passes, do something
	})
	->otherwise(function(IInt32\Type $x) {
		// skipped
	})
->end();
````

### Sequences

A list containing a sequence of numbers can be easily created by doing the following:
````
$object = IInt32\Module::sequence(IInt32\Type::zero(), IInt32\Type::box(5));
````
This means [0..5].  It will produce [0,1,2,3,4,5].

You can also generate sequences like [0,2..10], which will produce [0,2,4,6,8,10].
````
$object = IInt32\Module::sequence(IInt32\Type::zero(), ITuple\Type::box2(IInt32\Type::box(2), IInt32\Type::box(10)));
````

Similar methods exist as well for IDouble, IFloat, and IInteger.

### Exceptions

To throw an exception, do the following:

````
$message = 'Hi, my name is :name';
$tokens = array(':name' => 'Blue Snowman');
$code = IInt32\Type::zero();
Control\Exception\Module::raise(new Throwable\UnexpectedValue\Exception(
    $message, // optional
    $tokens,  // optional
    $code     // optional
));
````

Besides using the traditional `try/catch` statement, you can use the built in `try_` control feature:

````
$either = Control\Exception\Module::try_(function() {
	// do something that might cause an exception to be thrown
});
````

This will wrap the result into an `IEither\Type`.  Convention dictates that the exception will be wrapped in an `IEither\Left\Type` and a successful result will be wrapped in an `IEither\Right\Type`.

### Hierarchy

Below describes the relationships between data types:

````
+ Core\Type
  + Control\Type
    + Choice\Type
  + Data\Type
    + IBool\Type
    + IChar\Type
    + ICollection\Type
      + IEither\Type
        + Left\Type
        + Right\Type
      + IMap\Type
        + IHashMap\Type
      + IOption\Type
        + Some\Type
        + None\Type
      + ISet\Type
        + IHashSet\Type
      + ITuple\Type
      + IVector\Type
        + IArrayList\Type
        + ILinkedList\Type
        + IString\Type
    + INumber\Type
      + IFloating\Type : IFractional\Type
        + IDouble\Type : IReal\Type
        + IFloat\Type : IReal\Type
      + IIntegral\Type : IReal\Type
        + IInt32\Type
        + IInteger\Type
        + ITrit\Type
      + IRatio\Type : IFractional\Type
    + IObject\Type
    + IRegex\Type
    + IUnit\Type
  + Throwable\Runtime\Exception
    + Throwable\EmptyCollection\Exception
    + Throwable\InvalidArgument\Exception
    + Throwable\OutOfBounds\Exception
    + Throwable\Parse\Exception
    + Throwable\UnexpectedValue\Exception
    + Throwable\UnimplementedMethod\Exception
    + Throwable\Unknown\Exception
````

Most data types have a module associated with it.

ICollection types also have an iterator class so that the class can be used with PHP's `foreach` loop.  Because these iterator classes must conform to PHP's `Iterator` and `Countable` interfaces, methods in these classes do not necessarily conform to all of the conventions that this library otherwise uses (i.e. some non-doubly underscored methods will return PHP typed primitives instead their respective `Core\Type` objects).

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
make unit-test
````

To run just a specific group of unit tests, for example:

````
make unit-test GROUP=TypeTest
````

For more information regarding additional commands, see the [documentation](https://github.com/bluesnowman/fphp-saber/blob/master/Makefile) in the `Makefile` itself.

### Pull Requests

Help improve on this library.  If you have a bug fix, suggestion, or improvement, please submit a pull request along with any applicable test cases.

### License

Copyright 2014-2016 Blue Snowman

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

[http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0)

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
