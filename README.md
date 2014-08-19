fphp-saber
==========

A functional php library.


### Common Signatures for Callables:

An `operator` function is used to find the result of applying an operation to two operands.

````
$operator = function(Core\Any $carry, Core\Any $element) : Core\Any;
````

A `predicate` function is used to find the result of preforming a Boolean evaluation.

````
$predicate = function(Core\Any $element, Core\Int32 $index) : Core\Bool;
````

A `procedure` function is used to preform an operation without returning a value.

````
$procedure = function(Core\Any $element, Core\Int32 $index) : Core\Unit;
````

A `subroutine` function is used to preform an operation that does return a value.

````
$subroutine = function(Core\Any $element, Core\Int32 $index) : Core\Any;
````
