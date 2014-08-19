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

namespace Saber\Core {

	use \Saber\Core;
	use \Saber\Throwable;

	abstract class LinkedList extends Core\Collection {

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
		 * This method returns a "cons" object for a list.
		 *
		 * @access public
		 * @static
		 * @param Core\Any $head                                    the head to be used
		 * @param Core\LinkedList $tail                             the tail to be used
		 * @return Core\LinkedList\Cons                             the "cons" object
		 */
		public static function cons(Core\Any $head, Core\LinkedList $tail) {
			return new Core\LinkedList\Cons($head, $tail);
		}

		/**
		 * This method returns a "nil" object for a list.
		 *
		 * @access public
		 * @static
		 * @return Core\LinkedList\Nil                              the "nil" object
		 */
		public static function nil() {
			return new Core\LinkedList\Nil();
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
				$head = $xs->head();
				$buffer[] = ($depth > 0)
					? $head->unbox($depth - 1)
					: $head;
			}

			return $buffer;
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @return Core\Bool                                        whether the list is empty
		 */
		public function __isEmpty() {
			return ($this instanceof Core\LinkedList\Nil);
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method appends the specified object to this object's list. Performs in O(n) time.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be appended
		 * @return Core\LinkedList                                  the list
		 */
		public function append(Core\Any $object) {
			return $this->concat(static::cons($object, static::nil()));
		}

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @abstract
		 * @param Core\LinkedList $that                             the object to be compared
		 * @return Core\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public abstract function compareTo(Core\LinkedList $that);

		/**
		 * This method concatenates a list to this object's list. Performs in O(n) time.
		 *
		 * @access public
		 * @param Core\LinkedList $that                             the list to be concatenated
		 * @return Core\LinkedList                                  the list
		 */
		public function concat(Core\LinkedList $that) {
			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail());
			$xs->tail = $that;
			return $this;
		}

		/**
		 * This method evaluates whether the specified object is contained within the list.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to find
		 * @return Core\Bool                                        whether the specified object is
		 *                                                          contained within the list
		 */
		public function contains(Core\Any $object) {
			return $this->some(function(Core\Any $element, Core\Int32 $index) use ($object) {
				return $element->equals($object);
			});
		}

		/**
		 * This method remove the first occurrence that equals the specified object.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be removed
		 * @return Core\LinkedList                                  the list
		 */
		public function delete(Core\Any $object) {
			$start = static::nil();
			$tail = null;

			$index = Core\Int32::zero();
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
		 * This method returns the list after dropping the first "n" elements.
		 *
		 * @access public
		 * @param Core\Int32 $n                                     the number of elements to drop
		 * @return Core\LinkedList                                  the list
		 */
		public function drop(Core\Int32 $n) {
			$i = Core\Int32::zero();

			for ($xs = $this; ($i->unbox() < $n->unbox()) && ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$i = $i->increment();
			}

			return $xs;
		}

		/**
		 * This method return the list from element where the predicate function fails.
		 *
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\LinkedList                                  the list
		 */
		public function dropWhile(callable $predicate) {
			$index = Core\Int32::zero();

			for ($xs = $this; ! $xs->__isEmpty() && $predicate($xs->head(), $index)->unbox(); $xs = $xs->tail()) {
				$index = $index->increment();
			}

			return $xs;
		}

		/**
		 * This method return the list from element where the predicate function doesn't fail.
		 *
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\LinkedList                                  the list
		 */
		public function dropWhileEnd(callable $predicate) {
			return $this->dropWhile(function(Core\Any $object, Core\Int32 $index) use ($predicate) {
				return $predicate($object, $index)->not();
			});
		}

		/**
		 * This method iterates over the elements in the list, yielding each element to the
		 * callback function.
		 *
		 * @access public
		 * @param callable $procedure                               the procedure function to be used
		 */
		public function each(callable $procedure) {
			$index = Core\Int32::zero();

			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$procedure($xs->head(), $index);
				$index = $index->increment();
			}
		}

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @param Core\Int32 $index                                 the index of the element
		 * @return Core\Any                                         the element at the specified index
		 * @throws Throwable\OutOfBounds\Exception                  indicates the specified index
		 *                                                          cannot be found
		 */
		public function element(Core\Int32 $index) {
			$count = Core\Int32::zero();

			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				if ($count->__equals($index)) {
					return $xs->head();
				}
				$count = $count->increment();
			}

			throw new Throwable\OutOfBounds\Exception('Unable to return element at index :index.', array(':index' => $index->unbox()));
		}

		/**
		 * This method (aka "all" or "forall") iterates over the elements in the list, yielding each
		 * element to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\Bool                                        whether each element passed the
		 *                                                          truthy test
		 */
		public function every(callable $predicate) { // aka "all" or "forall"
			$index = Core\Int32::zero();

			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				if (!$predicate($xs->head(), $index)->unbox()) {
					return Core\Bool::false();
				}
				$index = $index->increment();
			}

			return Core\Bool::true(); // yes, empty list returns "true"
		}

		/**
		 * This method returns a list of those elements that satisfy the predicate.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\LinkedList                                  the list
		 */
		public function filter(callable $predicate) {
			$start = static::nil();
			$tail = null;

			$index = Core\Int32::zero();
			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$head = $xs->head();
				if ($predicate($head, $index)->unbox()) {
					$cons = static::cons($head, static::nil());

					if ($tail !== null) {
						$tail->tail = $cons;
					}
					else {
						$start = $cons;
					}

					$tail = $cons;
				}
				$index = $index->increment();
			}

			return $start;
		}

		/**
		 * This method returns the first object in the list that passes the truthy test.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\Any                                         the first element
		 * @throws Throwable\EmptyCollection\Exception              indicates that the collection is empty
		 */
		public function first(callable $predicate) {
			$index = Core\Int32::zero();

			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$head = $xs->head();
				if ($predicate($head, $index)->unbox()) {
					return $head;
				}
				$index = $index->increment();
			}

			throw new Throwable\EmptyCollection\Exception('Unable to return first object. Linked list is empty.');
		}

		/**
		 * This method applies a left-fold reduction on the list using the operator function.
		 *
		 * @access public
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Any $initial                                 the initial value to be used
		 * @return Core\Any                                         the result
		 */
		public function foldLeft(callable $operator, Core\Any $initial) {
			$x = $initial;

			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$x = $operator($x, $xs->head());
			}

			return $x;
		}

		/**
		 * This method applies a right-fold reduction on the list using the operator function.
		 *
		 * @access public
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Any $initial                                 the initial value to be used
		 * @return Core\Any                                         the result
		 */
		public function foldRight(callable $operator, Core\Any $initial) {
			if ($this->__isEmpty()) {
				return $initial;
			}

			return $operator($this->head(), $this->tail()->foldRight($operator, $initial));
		}

		/**
		 * This method returns the head object in this list.
		 *
		 * @access public
		 * @abstract
		 * @return Core\Any                                         the head object in this linked
		 *                                                          list
		 */
		public abstract function head();

		/**
		 * This method return the index of the first occurrence of the object; otherwise, it returns -1;
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be searched for
		 * @return Core\Int32                                       the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public function indexOf(Core\Any $object) {
			$index = Core\Int32::zero();

			for ($xs = $this->tail(); ! $xs->__isEmpty(); $xs = $xs->tail()) {
				if ($object->__equals($xs->head())) {
					return $index;
				}
				$index = $index->increment();
			}

			return Core\Int32::negative();
		}

		/**
		 * This method returns all but the last element of in the list.
		 *
		 * @access public
		 * @return Core\LinkedList                                  the list, minus the last
		 *                                                          element
		 */
		public function init() {
			$start = static::nil();
			$tail = null;

			for ($xs = $this; ! $xs->__isEmpty() && ! $xs->tail()->__isEmpty(); $xs = $xs->tail()) {
				$cons = static::cons($xs->head(), static::nil());

				if ($tail !== null) {
					$tail->tail = $cons;
				}
				else {
					$start = $cons;
				}

				$tail = $cons;
			}

			return $start;
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @final
		 * @return Core\Bool                                        whether the list is empty
		 */
		public final function isEmpty() {
			return Core\Bool::box($this->__isEmpty());
		}

		/**
		 * The method intersperses the specified object between each element in the list.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be interspersed
		 * @return Core\LinkedList                                  the list
		 */
		public function intersperse(Core\Any $object) {
			return ($this->__isEmpty() || $this->tail()->__isEmpty())
				? $this
				: static::cons($this->head(), static::cons($object, $this->tail()->intersperse($object)));
		}

		/**
		 * This method returns the last element in this list.
		 *
		 * @access public
		 * @return Core\Any                                         the last element in this linked
		 *                                                          list
		 */
		public function last() {
			$head = $this->head();

			for ($xs = $this->tail(); ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$head = $xs->head();
			}

			return $head;
		}

		/**
		 * This method returns the length of this list. Performs in O(n) time.
		 *
		 * @access public
		 * @return Core\Int32                                       the length of this list
		 */
		public function length() {
			return $this->foldLeft(function(Core\Int32 $length) {
				return $length->increment();
			}, Core\Int32::zero());
		}

		/**
		 * This method applies each element in this list to the subroutine function.
		 *
		 * @access public
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return Core\LinkedList                                  the list
		 */
		public function map(callable $subroutine) {
			$start = static::nil();
			$tail = null;

			$index = Core\Int32::zero();
			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$cons = static::cons($subroutine($xs->head(), $index), static::nil());

				if ($tail !== null) {
					$tail->tail = $cons;
				}
				else {
					$start = $cons;
				}

				$tail = $cons;
				$index = $index->increment();
			}

			return $start;
		}

		/**
		 * This method iterates over the elements in the list, yielding each element to the
		 * predicate function, or fails the falsy test.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\Bool                                        whether each element passed the
		 *                                                          falsy test
		 */
		public function none(callable $predicate) {
			return $this->every(function(Core\Any $object, Core\Int32 $index) use ($predicate) {
				return $predicate($object, $index)->not();
			});
		}

		/**
		 * This method prepends the specified object to the front of this list.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be prepended
		 * @return Core\LinkedList                                  the list
		 */
		public function prepend(Core\Any $object) {
			return static::cons($object, $this);
		}

		/**
		 * This method returns the list within the specified range.
		 *
		 * @access public
		 * @param Core\Int32 $start                                 the starting index
		 * @param Core\Int32 $end                                   the ending index
		 * @return Core\LinkedList                                  the list
		 */
		public function range(Core\Int32 $start, Core\Int32 $end) {
			return $this->take($end)->drop($start);
		}

		/**
		 * This method returns a list of those elements that don't satisfy the predicate.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\LinkedList                                  the list
		 */
		public function remove(callable $predicate) {
			return $this->filter(function(Core\Any $element, Core\Int32 $index) use ($predicate) {
				return $predicate($element, $index)->not();
			});
		}

		/**
		 * This method reverses the order of the elements in this list.
		 *
		 * @access public
		 * @return Core\LinkedList                                  the list
		 */
		public function reverse() {
			return $this->foldLeft(function(Core\LinkedList $tail, Core\Any $head) {
				return static::cons($head, $tail);
			}, static::nil());
		}

		/**
		 * This method returns the extracted slice of the list.
		 *
		 * @access public
		 * @param Core\Int32 $offset                                the starting index
		 * @param Core\Int32 $length                                the length of the slice
		 * @return Core\LinkedList                                  the list
		 */
		public function slice(Core\Int32 $offset, Core\Int32 $length) {
			return $this->take($length->add($offset))->drop($offset);
		}

		/**
		 * This method (aka "any") returns whether some of the elements in the list passed the truthy
		 * test.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\Bool                                        whether some of the elements
		 *                                                          passed the truthy test
		 */
		public function some($predicate) {
			$index = Core\Int32::zero();

			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				if ($predicate($xs->head(), $index)->unbox()) {
					return Core\Bool::true();
				}
				$index = $index->increment();
			}

			return Core\Bool::false();
		}

		/**
		 * This method returns the tail of this list.
		 *
		 * @access public
		 * @abstract
		 * @return Core\LinkedList                                  the tail of this list
		 */
		public abstract function tail();

		/**
		 * This method returns the first "n" elements in the list.
		 *
		 * @access public
		 * @param Core\Int32 $n                                     the number of elements to take
		 * @return Core\LinkedList                                  the list
		 */
		public function take(Core\Int32 $n) {
			return (($n->unbox() <= 0) || $this->__isEmpty())
				? static::nil()
				: static::cons($this->head(), $this->tail()->take($n->subtract(Core\Int32::one())));
		}

		/**
		 * This method returns each element in this list until the predicate fails.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\LinkedList                                  the list
		 */
		public function takeWhile(callable $predicate) {
			$start = static::nil();
			$tail = null;

			$taking = true;

			$index = Core\Int32::zero();
			for ($xs = $this; ! $xs->__isEmpty() && $taking; $xs = $xs->tail()) {
				$head = $xs->head();

				if ($predicate($head, $index)->unbox()) {
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
					$taking = false;
				}

				$index = $index->increment();
			}

			return $start;
		}

		/**
		 * This method returns each element in this list until the predicate doesn't fail.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\LinkedList                                  the list
		 */
		public function takeWhileEnd(callable $predicate) {
			return $this->takeWhile(function(Core\Any $object, Core\Int32 $index) use ($predicate) {
				return $predicate($object, $index)->not();
			});
		}

		#endregion

		#region Methods -> Object Oriented -> Boolean Operations

		/**
		 * This method (aka "truthy") returns whether all of the elements of the list evaluate
		 * to true.
		 *
		 * @access public
		 * @return Core\Bool                                        whether all of the elements of
		 *                                                          the list evaluate to true
		 */
		public function and_() {
			return $this->truthy();
		}

		/**
		 * This method (aka "falsy") returns whether all of the elements of the list evaluate
		 * to false.
		 *
		 * @access public
		 * @return Core\Bool                                        whether all of the elements of
		 *                                                          the list evaluate to false
		 *
		 * @see http://www.sitepoint.com/javascript-truthy-falsy/
		 */
		public function or_() {
			return $this->falsy();
		}

		/**
		 * This method returns whether all of the elements of the list strictly evaluate to
		 * false.
		 *
		 * @access public
		 * @return Core\Bool                                        whether all of the elements of
		 *                                                          the list strictly evaluate
		 *                                                          to false
		 */
		public function false() {
			return $this->true()->not();
		}

		/**
		 * This method (aka "or") returns whether all of the elements of the list evaluate to
		 * false.
		 *
		 * @access public
		 * @return Core\Bool                                        whether all of the elements of
		 *                                                          the list evaluate to false
		 *
		 * @see http://www.sitepoint.com/javascript-truthy-falsy/
		 */
		public function falsy() {
			return $this->truthy()->not();
		}

		/**
		 * This method returns whether all of the elements of the list strictly evaluate
		 * to true.
		 *
		 * @access public
		 * @return Core\Bool                                        whether all of the elements of
		 *                                                          the list strictly evaluate
		 *                                                          to true
		 */
		public function true() {
			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				if ($xs->head()->unbox() !== true) {
					return Core\Bool::false();
				}
			}
			return Core\Bool::true();
		}

		/**
		 * This method (aka "and") returns whether all of the elements of the list evaluate to
		 * true.
		 *
		 * @access public
		 * @return Core\Bool                                        whether all of the elements of
		 *                                                          the list evaluate to true
		 */
		public function truthy() {
			for ($xs = $this; ! $xs->__isEmpty(); $xs = $xs->tail()) {
				if (!$xs->head()->unbox()) {
					return Core\Bool::false();
				}
			}
			return Core\Bool::true();
		}

		#endregion

		#region Methods -> Object Oriented -> Numeric Operations

		/**
		 * This method returns the average of all elements in the list.
		 *
		 * @access public
		 * @return Core\Num                                         the result
		 */
		public function average() {
			$xs = $this;

			if ($xs->__isEmpty()) {
				return Core\Int32::zero();
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
		 * This method returns the product of all elements in the list.
		 *
		 * @access public
		 * @return Core\Num                                         the result
		 */
		public function product() {
			$xs = $this;

			if ($xs->__isEmpty()) {
				return Core\Int32::one();
			}

			$x = $xs->head();

			for ($xs = $xs->tail(); ! $xs->__isEmpty(); $xs = $xs->tail()) {
				$x = $x->multiply($xs->head());
			}

			return $x;
		}

		/**
		 * This method returns the sum of all elements in the list.
		 *
		 * @access public
		 * @return Core\Num                                         the result
		 */
		public function sum() {
			$xs = $this;

			if ($xs->__isEmpty()) {
				return Core\Int32::zero();
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