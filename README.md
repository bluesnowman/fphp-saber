fphp-saber
==========

A functional php library.


### Common Signatures for Callables:

An `operator` function is used to find the result of applying an operation to two operands.

````
$operator = function(FP\Any $carry, FP\Any $element) : FP\Any;
````

A `predicate` function is used to find the result of preforming a Boolean evaluation.

````
$predicate = function(FP\Any $element, FP\Int32 $index) : FP\Bool;
````

A `procedure` function is used to preform an operation without returning a value.

````
$procedure = function(FP\Any $element, FP\Int32 $index) : FP\Unit;
````

A `subroutine` function is used to preform an operation that does return a value.

````
$subroutine = function(FP\Any $element, FP\Int32 $index) : FP\Any;
````
