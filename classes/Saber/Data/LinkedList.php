<?php

/**
 * Copyright 2014 Blue Snowman
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Saber\Data {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Throwable;

	abstract class LinkedList extends Data\Collection {

		#region Methods -> Boxing/Creation

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Core\Any                                         the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function box($value/*...*/) {
			if (is_array($value)) {
				$buffer = static::nil();
				for ($i = count($value) - 1; $i >= 0; $i--) {
					$buffer = $buffer->prepend($value[$i]);
				}
				return $buffer;
			}
			else {
				$type = gettype($value);
				if ($type == 'object') {
					$type = get_class($value);
				}
				throw new Throwable\InvalidArgument\Exception('Unable to box value. Expected an array, but got ":type".', array(':type' => $type));
			}
		}

		/**
		 * This method returns a "cons" object for a collection.
		 *
		 * @access public
		 * @static
		 * @param Core\Any $head                                    the head to be used
		 * @param Data\LinkedList $tail                             the tail to be used
		 * @return Data\LinkedList\Cons                             the "cons" object
		 */
		public static function cons(Core\Any $head, Data\LinkedList $tail) {
			return new Data\LinkedList\Cons($head, $tail);
		}

		/**
		 * This method returns a "nil" object for a collection.
		 *
		 * @access public
		 * @static
		 * @return Data\LinkedList\Nil                              the "nil" object
		 */
		public static function nil() {
			return new Data\LinkedList\Nil();
		}

		/**
		 * This method creates a list of "n" length with every element set to the given object.
		 *
		 * @access public
		 * @param Int32 $n                                          the number of times to replicate
		 * @param Core\Any $y                                       the object to be replicated
		 * @return Data\LinkedList                                  the collection
		 */
		public static function replicate(Data\Int32 $n, Core\Any $y) {
			if ($n->unbox() <= 0) {
				return static::nil();
			}
			return static::cons($y, static::replicate($n->decrement(), $y));
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @param integer $depth                                    how many levels to un-box
		 * @return array                                            the un-boxed value
		 */
		public function unbox($depth = 0) {
			$buffer = array();

			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$x = $xs->head();
				$buffer[] = ($depth > 0)
					? $x->unbox($depth - 1)
					: $x;
			}

			return $buffer;
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method (aka "null") returns whether this collection is empty.
		 *
		 * @access public
		 * @return boolean                                          whether the collection is empty
		 */
		public function __isEmpty() {
			return ($this instanceof Data\LinkedList\Nil);
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method (aka "every" or "forall") iterates over the elements in the collection, yielding each
		 * element to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether each element passed the
		 *                                                          truthy test
		 */
		public function all(callable $predicate) {
			$i = Data\Int32::zero();

			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				if (!$predicate($xs->head(), $i)->unbox()) {
					return Data\Bool::false();
				}
				$i = $i->increment();
			}

			return Data\Bool::true(); // yes, an empty list returns "true"
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the elements in the collection
		 * passed the truthy test.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether some of the elements
		 *                                                          passed the truthy test
		 */
		public function any($predicate) {
			return $this->find($predicate)->isDefined();
		}

		/**
		 * This method appends the specified object to this object's collection. Performs in O(n) time.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be appended
		 * @return Data\LinkedList                                  the collection
		 */
		public function append(Core\Any $object) {
			return $this->concat(static::cons($object, static::nil()));
		}

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @abstract
		 * @param Data\LinkedList $that                             the object to be compared
		 * @return Data\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public abstract function compareTo(Data\LinkedList $that);

		/**
		 * This method concatenates a collection to this object's collection. Performs in O(n) time.
		 *
		 * @access public
		 * @param Data\LinkedList $that                             the collection to be concatenated
		 * @return Data\LinkedList                                  the collection
		 */
		public function concat(Data\LinkedList $that) {
			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail());
			$xs->tail = $that;
			return $this;
		}

		/**
		 * This method evaluates whether the specified object is contained within the collection.
		 *
		 * @access public
		 * @param Core\Any $y                                       the object to find
		 * @return Data\Bool                                        whether the specified object is
		 *                                                          contained within the collection
		 */
		public function contains(Core\Any $y) {
			return $this->any(function(Core\Any $x, Data\Int32 $i) use ($y) {
				return $x->equals($y);
			});
		}

		/**
		 * This method remove the first occurrence that equals the specified object.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be removed
		 * @return Data\LinkedList                                  the collection
		 */
		public function delete(Core\Any $object) {
			$start = static::nil();
			$tail = null;

			$index = Data\Int32::zero();
			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$head = $xs->head();
				if (!$object->__equals($head)) {
					$cons = static::cons($head, static::nil());

					if ($tail !== null) {
						$tail->tail = $cons;
					}
					else {
						$start = $cons;
					}

					$tail = $cons;
				}
				else {
					$cons = $xs->tail();

					if ($tail !== null) {
						$tail->tail = $cons;
					}
					else {
						$start = $cons;
					}

					break;
				}
				$index = $index->increment();
			}

			return $start;
		}

		/**
		 * This method returns the collection after dropping the first "n" elements.
		 *
		 * @access public
		 * @param Data\Int32 $n                                     the number of elements to drop
		 * @return Data\LinkedList                                  the collection
		 */
		public function drop(Data\Int32 $n) {
			$i = Data\Int32::zero();

			for ($xs = $this; ($i->unbox() < $n->unbox()) && ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$i = $i->increment();
			}

			return $xs;
		}

		/**
		 * This method return the collection from element where the predicate function fails.
		 *
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\LinkedList                                  the collection
		 */
		public function dropWhile(callable $predicate) {
			$i = Data\Int32::zero();

			for ($xs = $this; ! $xs->__isEmpty() && $predicate($xs->head(), $i)->unbox(); $xs = $xs->tail()) {
				$i = $i->increment();
			}

			return $xs;
		}

		/**
		 * This method return the collection from element where the predicate function doesn't fail.
		 *
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\LinkedList                                  the collection
		 */
		public function dropWhileEnd(callable $predicate) {
			return $this->dropWhile(function(Core\Any $object, Data\Int32 $index) use ($predicate) {
				return $predicate($object, $index)->not();
			});
		}

		/**
		 * This method iterates over the elements in the collection, yielding each element to the
		 * callback function.
		 *
		 * @access public
		 * @param callable $procedure                               the procedure function to be used
		 */
		public function each(callable $procedure) {
			$i = Data\Int32::zero();

			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$procedure($xs->head(), $i);
				$i = $i->increment();
			}
		}

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @param Data\Int32 $index                                 the index of the element
		 * @return Core\Any                                         the element at the specified index
		 * @throws Throwable\OutOfBounds\Exception                  indicates the specified index
		 *                                                          cannot be found
		 */
		public function element(Data\Int32 $index) {
			$i = Data\Int32::zero();

			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				if ($i->__equals($index)) {
					return $xs->head();
				}
				$i = $i->increment();
			}

			throw new Throwable\OutOfBounds\Exception('Unable to return element at index :index.', array(':index' => $index->unbox()));
		}

		/**
		 * This method returns a collection of those elements that satisfy the predicate.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\LinkedList                                  the collection
		 */
		public function filter(callable $predicate) {
			$start = static::nil();
			$tail = null;

			$i = Data\Int32::zero();
			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$x = $xs->head();
				if ($predicate($x, $i)->unbox()) {
					$ys = static::cons($x, static::nil());

					if ($tail !== null) {
						$tail->tail = $ys;
					}
					else {
						$start = $ys;
					}

					$tail = $ys;
				}
				$i = $i->increment();
			}

			return $start;
		}

		/**
		 * This method returns the first object in the collection that passes the truthy test, if any.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Option                                      an option containing the first object
		 *                                                          satisfying the predicate, if any
		 */
		public function find(callable $predicate) {
			$i = Data\Int32::zero();

			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$x = $xs->head();
				if ($predicate($x, $i)->unbox()) {
					return Data\Option::some($x);
				}
				$i = $i->increment();
			}

			return Data\Option::none();
		}

		/**
		 * This method returns the linked list flattened.
		 *
		 * @access public
		 * @return Data\LinkedList                                  the flattened linked list
		 */
		public function flatten() {
			$start = static::nil();
			$tail = null;

			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$x = $xs->head();

				$ys = ($x instanceof Data\Collection)
					? $x->flatten()->toList()
					: static::cons($x, static::nil());

				if ($tail !== null) {
					$tail->tail = $ys;
				}
				else {
					$start = $ys;
				}

				$tail = $ys;
			}

			return $start;
		}

		/**
		 * This method applies a left-fold reduction on the collection using the operator function.
		 *
		 * @access public
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Any $initial                                 the initial value to be used
		 * @return Core\Any                                         the result
		 */
		public function foldLeft(callable $operator, Core\Any $initial) {
			$z = $initial;

			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$z = $operator($z, $xs->head());
			}

			return $z;
		}

		/**
		 * This method applies a right-fold reduction on the collection using the operator function.
		 *
		 * @access public
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Any $initial                                 the initial value to be used
		 * @return Core\Any                                         the result
		 */
		public function foldRight(callable $operator, Core\Any $initial) {
			$z = $initial;

			if ($this->__isEmpty()) {
				return $z;
			}

			return $operator($this->head(), $this->tail()->foldRight($operator, $z));
		}

		/**
		 * This method returns the head object in this collection.
		 *
		 * @access public
		 * @abstract
		 * @return Core\Any                                         the head object in this linked
		 *                                                          collection
		 */
		public abstract function head();

		/**
		 * This method returns an option using the head for the boxed object.
		 *
		 * @access public
		 * @return Data\Option                                      the option
		 */
		public function headOption() {
			return (!$this->__isEmpty()) ? Data\Option::some($this->head()) : Data\Option::none();
		}

		/**
		 * This method return the index of the first occurrence of the object; otherwise, it returns -1;
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be searched for
		 * @return Data\Int32                                       the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public function indexOf(Core\Any $object) {
			$i = Data\Int32::zero();

			for ($xs = $this->tail(); ! $xs->__isEmpty(); $xs = $xs->tail()) {
				if ($object->__equals($xs->head())) {
					return $i;
				}
				$i = $i->increment();
			}

			return Data\Int32::negative();
		}

		/**
		 * This method returns all but the last element of in the collection.
		 *
		 * @access public
		 * @return Data\LinkedList                                  the collection, minus the last
		 *                                                          element
		 */
		public function init() {
			$start = static::nil();
			$tail = null;

			for ($xs = $this; ! $xs->__isEmpty() && ! $xs->tail()->__isEmpty(); $xs = $xs->tail()) {
				$ys = static::cons($xs->head(), static::nil());

				if ($tail !== null) {
					$tail->tail = $ys;
				}
				else {
					$start = $ys;
				}

				$tail = $ys;
			}

			return $start;
		}

		/**
		 * This method (aka "null") returns whether this collection is empty.
		 *
		 * @access public
		 * @final
		 * @return Data\Bool                                        whether the collection is empty
		 */
		public final function isEmpty() {
			return Data\Bool::create($this->__isEmpty());
		}

		/**
		 * The method intersperses the specified object between each element in the collection.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be interspersed
		 * @return Data\LinkedList                                  the collection
		 */
		public function intersperse(Core\Any $object) {
			return ($this->__isEmpty() || $this->tail()->__isEmpty())
				? $this
				: static::cons($this->head(), static::cons($object, $this->tail()->intersperse($object)));
		}

		/**
		 * This method returns the last element in this collection.
		 *
		 * @access public
		 * @return Core\Any                                         the last element in this collection
		 */
		public function last() {
			$x = $this->head();

			for ($xs = $this->tail(); ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$x = $xs->head();
			}

			return $x;
		}

		/**
		 * This method returns an option using the last for the boxed object.
		 *
		 * @access public
		 * @return Data\Option                                      the option
		 */
		public function lastOption() {
			return (!$this->__isEmpty()) ? Data\Option::some($this->last()) : Data\Option::none();
		}

		/**
		 * This method returns the length of this collection. Performs in O(n) time.
		 *
		 * @access public
		 * @return Data\Int32                                       the length of this collection
		 */
		public function length() {
			return $this->foldLeft(function(Data\Int32 $length) {
				return $length->increment();
			}, Data\Int32::zero());
		}

		/**
		 * This method applies each element in this collection to the subroutine function.
		 *
		 * @access public
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return Data\LinkedList                                  the collection
		 */
		public function map(callable $subroutine) {
			$start = static::nil();
			$tail = null;

			$i = Data\Int32::zero();
			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$ys = static::cons($subroutine($xs->head(), $i), static::nil());

				if ($tail !== null) {
					$tail->tail = $ys;
				}
				else {
					$start = $ys;
				}

				$tail = $ys;
				$i = $i->increment();
			}

			return $start;
		}

		/**
		 * This method iterates over the elements in the collection, yielding each element to the
		 * predicate function, or fails the falsy test.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether each element passed the
		 *                                                          falsy test
		 */
		public function none(callable $predicate) {
			return $this->all(function(Core\Any $object, Data\Int32 $index) use ($predicate) {
				return $predicate($object, $index)->not();
			});
		}

		/**
		 * This method prepends the specified object to the front of this collection.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be prepended
		 * @return Data\LinkedList                                  the collection
		 */
		public function prepend(Core\Any $object) {
			return static::cons($object, $this);
		}

		/**
		 * This method returns the collection within the specified range.
		 *
		 * @access public
		 * @param Data\Int32 $start                                 the starting index
		 * @param Data\Int32 $end                                   the ending index
		 * @return Data\LinkedList                                  the collection
		 */
		public function range(Data\Int32 $start, Data\Int32 $end) {
			return $this->take($end)->drop($start);
		}

		/**
		 * This method returns a collection of those elements that don't satisfy the predicate.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\LinkedList                                  the collection
		 */
		public function remove(callable $predicate) {
			return $this->filter(function(Core\Any $x, Data\Int32 $i) use ($predicate) {
				return $predicate($x, $i)->not();
			});
		}

		/**
		 * This method reverses the order of the elements in this collection.
		 *
		 * @access public
		 * @return Data\LinkedList                                  the collection
		 */
		public function reverse() {
			return $this->foldLeft(function(Data\LinkedList $tail, Core\Any $head) {
				return static::cons($head, $tail);
			}, static::nil());
		}

		/**
		 * This method returns the extracted slice of the collection.
		 *
		 * @access public
		 * @param Data\Int32 $offset                                the starting index
		 * @param Data\Int32 $length                                the length of the slice
		 * @return Data\LinkedList                                  the collection
		 */
		public function slice(Data\Int32 $offset, Data\Int32 $length) {
			return $this->take($length->add($offset))->drop($offset);
		}

		/**
		 * This method returns the tail of this collection.
		 *
		 * @access public
		 * @abstract
		 * @return Data\LinkedList                                  the tail of this collection
		 */
		public abstract function tail();

		/**
		 * This method returns the first "n" elements in the collection.
		 *
		 * @access public
		 * @param Data\Int32 $n                                     the number of elements to take
		 * @return Data\LinkedList                                  the collection
		 */
		public function take(Data\Int32 $n) {
			return (($n->unbox() <= 0) || $this->__isEmpty())
				? static::nil()
				: static::cons($this->head(), $this->tail()->take($n->subtract(Data\Int32::one())));
		}

		/**
		 * This method returns each element in this collection until the predicate fails.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\LinkedList                                  the collection
		 */
		public function takeWhile(callable $predicate) {
			$start = static::nil();
			$tail = null;

			$taking = true;

			$i = Data\Int32::zero();
			for ($xs = $this; ! $xs->__isEmpty() && $taking; $xs = $xs->tail()) {
				$x = $xs->head();

				if ($predicate($x, $i)->unbox()) {
					$ys = static::cons($x, static::nil());

					if ($tail !== null) {
						$tail->tail = $ys;
					}
					else {
						$start = $ys;
					}

					$tail = $ys;
				}
				else {
					$taking = false;
				}

				$i = $i->increment();
			}

			return $start;
		}

		/**
		 * This method returns each element in this collection until the predicate doesn't fail.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\LinkedList                                  the collection
		 */
		public function takeWhileEnd(callable $predicate) {
			return $this->takeWhile(function(Core\Any $object, Data\Int32 $index) use ($predicate) {
				return $predicate($object, $index)->not();
			});
		}

		/**
		 * This method returns the collection as an array.
		 *
		 * @access public
		 * @return Data\ArrayList                                   the collection as an array list
		 */
		public function toArray() {
			$array = array();

			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$array[] = $xs->head();
			}

			return Data\ArrayList::create($array);
		}

		/**
		 * This method returns the collection as a linked list.
		 *
		 * @access public
		 * @return Data\LinkedList                                  the collection as a linked list
		 */
		public function toList() {
			return $this;
		}

		#endregion

		#region Methods -> Object Oriented -> Boolean Operations

		/**
		 * This method (aka "truthy") returns whether all of the elements of the collection evaluate
		 * to true.
		 *
		 * @access public
		 * @return Data\Bool                                        whether all of the elements of
		 *                                                          the collection evaluate to true
		 */
		public function and_() {
			return $this->truthy();
		}

		/**
		 * This method (aka "falsy") returns whether all of the elements of the collection evaluate
		 * to false.
		 *
		 * @access public
		 * @return Data\Bool                                        whether all of the elements of
		 *                                                          the collection evaluate to false
		 *
		 * @see http://www.sitepoint.com/javascript-truthy-falsy/
		 */
		public function or_() {
			return $this->falsy();
		}

		/**
		 * This method returns whether all of the elements of the collection strictly evaluate to
		 * false.
		 *
		 * @access public
		 * @return Data\Bool                                        whether all of the elements of
		 *                                                          the collection strictly evaluate
		 *                                                          to false
		 */
		public function false() {
			return $this->true()->not();
		}

		/**
		 * This method (aka "or") returns whether all of the elements of the collection evaluate to
		 * false.
		 *
		 * @access public
		 * @return Data\Bool                                        whether all of the elements of
		 *                                                          the collection evaluate to false
		 *
		 * @see http://www.sitepoint.com/javascript-truthy-falsy/
		 */
		public function falsy() {
			return $this->truthy()->not();
		}

		/**
		 * This method returns whether all of the elements of the collection strictly evaluate
		 * to true.
		 *
		 * @access public
		 * @return Data\Bool                                        whether all of the elements of
		 *                                                          the collection strictly evaluate
		 *                                                          to true
		 */
		public function true() {
			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				if ($xs->head()->unbox() !== true) {
					return Data\Bool::false();
				}
			}
			return Data\Bool::true();
		}

		/**
		 * This method (aka "and") returns whether all of the elements of the collection evaluate to
		 * true.
		 *
		 * @access public
		 * @return Data\Bool                                        whether all of the elements of
		 *                                                          the collection evaluate to true
		 */
		public function truthy() {
			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				if (!$xs->head()->unbox()) {
					return Data\Bool::false();
				}
			}
			return Data\Bool::true();
		}

		#endregion

		#region Methods -> Object Oriented -> Numeric Operations

		/**
		 * This method returns the average of all elements in the collection.
		 *
		 * @access public
		 * @return Data\Num                                         the result
		 */
		public function average() {
			$xs = $this;

			if ($xs->__isEmpty()) {
				return Data\Int32::zero();
			}

			$x = $xs->head();

			$t = $x->__typeOf();
			$y = $t::zero();

			for ($xs = $xs->tail(); ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$x = $x->add($xs->head());
				$y = $y->increment();
			}

			return $x->divide($y);
		}

		/**
		 * This method returns the product of all elements in the collection.
		 *
		 * @access public
		 * @return Data\Num                                         the result
		 */
		public function product() {
			$xs = $this;

			if ($xs->__isEmpty()) {
				return Data\Int32::one();
			}

			$x = $xs->head();

			for ($xs = $xs->tail(); ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$x = $x->multiply($xs->head());
			}

			return $x;
		}

		/**
		 * This method returns the sum of all elements in the collection.
		 *
		 * @access public
		 * @return Data\Num                                         the result
		 */
		public function sum() {
			$xs = $this;

			if ($xs->__isEmpty()) {
				return Data\Int32::zero();
			}

			$x = $xs->head();

			for ($xs = $xs->tail(); ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$x = $x->add($xs->head());
			}

			return $x;
		}

		#endregion

	}

}