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

namespace Saber\Data\LinkedList {

	use \Saber\Data;
	use \Saber\Throwable;

	abstract class Module extends Collection\Module {

		#region Properties

		/**
		 * This variable stores a reference to a list's tail.
		 *
		 * @access protected
		 * @var LinkedList\Type
		 */
		protected $tail;

		#endregion

		#region Methods -> Boxing/Creation

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Data\Type                                         the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function box($value/*...*/) {
			if (is_array($value)) {
				$zs = LinkedList\Module::nil();
				for ($i = count($value) - 1; $i >= 0; $i--) {
					$zs = LinkedList\Module::prepend($zs, $value[$i]);
				}
				return $zs;
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
		 * @param Data\Type $head                                    the head to be used
		 * @param LinkedList\Type $tail                             the tail to be used
		 * @return LinkedList\Type\Cons                             the "cons" object
		 */
		public static function cons(Data\Type $head, LinkedList\Type $tail) {
			return new LinkedList\Type\Cons($head, $tail);
		}

		/**
		 * This method returns a "nil" object for a collection.
		 *
		 * @access public
		 * @static
		 * @return LinkedList\Type\Nil                              the "nil" object
		 */
		public static function nil() {
			return new LinkedList\Type\Nil();
		}

		/**
		 * This method creates a list of "n" length with every element set to the given object.
		 *
		 * @access public
		 * @static
		 * @param Int32 $n                                          the number of times to replicate
		 * @param Data\Type $y                                       the object to be replicated
		 * @return LinkedList\Type                                  the collection
		 */
		public static function replicate(Int32\Type $n, Data\Type $y) {
			if ($n->unbox() <= 0) {
				return LinkedList\Module::nil();
			}
			return LinkedList\Module::cons($y, LinkedList\Module::replicate(Int32\Module::decrement($n), $y));
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

			for ($zs = $this; ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$z = LinkedList\Module::head($zs);
				$buffer[] = ($depth > 0)
					? $z->unbox($depth - 1)
					: $z;
			}

			return $buffer;
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method (aka "every" or "forall") iterates over the elements in the collection, yielding each
		 * element to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether each element passed the
		 *                                                          truthy test
		 */
		public static function all(LinkedList\Type $xs, callable $predicate) {
			$i = Int32\Module::zero();

			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$z = LinkedList\Module::head($zs, $i);
				if (!$predicate($z, $i)->unbox()) {
					return Bool\Module::false();
				}
				$i = Int32\Module::increment($i);
			}

			return Bool\Module::true(); // yes, an empty list returns "true"
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the elements in the collection
		 * passed the truthy test.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether some of the elements
		 *                                                          passed the truthy test
		 */
		public static function any(LinkedList\Type $xs, callable $predicate) {
			return Option\Type::isDefined(LinkedList\Module::find($xs, $predicate));
		}

		/**
		 * This method appends the specified object to this object's collection. Performs in O(n) time.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Data\Type $object                                  the object to be appended
		 * @return LinkedList\Type                                  the collection
		 */
		public static function append(LinkedList\Type $xs, Data\Type $object) {
			return LinkedList\Module::concat($xs, LinkedList\Module::cons($object, LinkedList\Module::nil()));
		}

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param LinkedList\Type $that                             the object to be compared
		 * @return Int32\Type                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public abstract function compare(LinkedList\Type $xs, LinkedList\Type $that);

		/**
		 * This method concatenates a collection to this object's collection. Performs in O(n) time.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param LinkedList\Type $ys                               the collection to be concatenated
		 * @return LinkedList\Type                                  the collection
		 */
		public static function concat(LinkedList\Type $xs, LinkedList\Type $ys) {
			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs));
			$zs->tail = $ys;
			return $xs;
		}

		/**
		 * This method evaluates whether the specified object is contained within the collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Data\Type $y                                      the object to find
		 * @return Bool\Type                                        whether the specified object is
		 *                                                          contained within the collection
		 */
		public static function contains(LinkedList\Type $xs, Data\Type $y) {
			return LinkedList\Module::any($xs, function(Data\Type $x, Int32\Type $i) use ($y) {
				return call_user_func_array(array(get_class($x), 'eq'), array($x, $y));
			});
		}

		/**
		 * This method remove the first occurrence that equals the specified object.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Data\Type $y                                      the object to be removed
		 * @return LinkedList\Type                                  the collection
		 */
		public static function delete(LinkedList\Type $xs, Data\Type $y) {
			$start = LinkedList\Module::nil();
			$tail = null;

			$index = Int32\Module::zero();
			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$head = LinkedList\Module::head($zs);
				if (!call_user_func_array(array(get_class($head), 'eq'), array($head, $y))->unbox()) {
					$cons = LinkedList\Module::cons($head, LinkedList\Module::nil());

					if ($tail !== null) {
						$tail->tail = $cons;
					}
					else {
						$start = $cons;
					}

					$tail = $cons;
				}
				else {
					$cons = LinkedList\Module::tail($zs);

					if ($tail !== null) {
						$tail->tail = $cons;
					}
					else {
						$start = $cons;
					}

					break;
				}
				$index = Int32\Module::increment($index);
			}

			return $start;
		}

		/**
		 * This method returns the collection after dropping the first "n" elements.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Int32\Type $n                                     the number of elements to drop
		 * @return LinkedList\Type                                  the collection
		 */
		public static function drop(LinkedList\Type $xs, Int32\Type $n) {
			$i = Int32\Module::zero();

			for ($zs = $xs; ($i->unbox() < $n->unbox()) && ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$i = Int32\Module::increment($i);
			}

			return $zs;
		}

		/**
		 * This method return the collection from element where the predicate function fails.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return LinkedList\Type                                  the collection
		 */
		public static function dropWhile(LinkedList\Type $xs, callable $predicate) {
			$i = Int32\Module::zero();

			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox() && $predicate(LinkedList\Module::head($zs), $i)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$i = Int32\Module::increment($i);
			}

			return $zs;
		}

		/**
		 * This method return the collection from element where the predicate function doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return LinkedList\Type                                  the collection
		 */
		public static function dropWhileEnd(LinkedList\Type $xs, callable $predicate) {
			return LinkedList\Module::dropWhile($xs, function(Data\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method iterates over the elements in the collection, yielding each element to the
		 * callback function.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $procedure                               the procedure function to be used
		 */
		public static function each(LinkedList\Type $xs, callable $procedure) {
			$i = Int32\Module::zero();

			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$procedure(LinkedList\Module::head($zs), $i);
				$i = Int32\Module::increment($i);
			}
		}

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Int32\Type $i                                     the index of the element
		 * @return Data\Type                                        the element at the specified index
		 * @throws Throwable\OutOfBounds\Exception                  indicates the specified index
		 *                                                          cannot be found
		 */
		public static function element(LinkedList\Type $xs, Int32\Type $i) {
			$j = Int32\Module::zero();

			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				if (Int32\Module::eq($i, $j)->unbox()) {
					return LinkedList\Module::head($zs);
				}
				$j = Int32\Module::increment($j);
			}

			throw new Throwable\OutOfBounds\Exception('Unable to return element at index :index.', array(':index' => $i->unbox()));
		}

		/**
		 * This method returns a collection of those elements that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return LinkedList\Type                                  the collection
		 */
		public static function filter(LinkedList\Type $xs, callable $predicate) {
			$start = LinkedList\Module::nil();
			$tail = null;

			$i = Int32\Module::zero();
			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$z = LinkedList\Module::head($zs);
				if ($predicate($z, $i)->unbox()) {
					$ys = LinkedList\Module::cons($z, LinkedList\Module::nil());

					if ($tail !== null) {
						$tail->tail = $ys;
					}
					else {
						$start = $ys;
					}

					$tail = $ys;
				}
				$i = Int32\Module::increment($i);
			}

			return $start;
		}

		/**
		 * This method returns the first object in the collection that passes the truthy test, if any.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Option\Type                                      an option containing the first object
		 *                                                          satisfying the predicate, if any
		 */
		public static function find(LinkedList\Type $xs, callable $predicate) {
			$i = Int32\Module::zero();

			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$z = LinkedList\Module::head($zs);
				if ($predicate($z, $i)->unbox()) {
					return Option\Type::some($z);
				}
				$i = Int32\Module::increment($i);
			}

			return Option\Type::none();
		}

		/**
		 * This method returns the linked list flattened.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return LinkedList\Type                                  the flattened linked list
		 */
		public static function flatten(LinkedList\Type $xs) {
			$start = LinkedList\Module::nil();
			$tail = null;

			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$z = LinkedList\Module::head($zs);

				$ys = ($z instanceof Collection\Type)
					? LinkedList\Module::toList(LinkedList\Module::flatten($z))
					: LinkedList\Module::cons($z, LinkedList\Module::nil());

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
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param Data\Type $initial                                 the initial value to be used
		 * @return Data\Type                                         the result
		 */
		public static function foldLeft(LinkedList\Type $xs, callable $operator, Data\Type $initial) {
			$c = $initial;

			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$z = LinkedList\Module::head($zs);
				$c = $operator($c, $z);
			}

			return $c;
		}

		/**
		 * This method applies a right-fold reduction on the collection using the operator function.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param Data\Type $initial                                 the initial value to be used
		 * @return Data\Type                                         the result
		 */
		public static function foldRight(LinkedList\Type $xs, callable $operator, Data\Type $initial) {
			$z = $initial;

			if (LinkedList\Module::isEmpty($xs)) {
				return $z;
			}

			return $operator(LinkedList\Module::head($xs), LinkedList\Module::foldRight(LinkedList\Module::tail($xs), $operator, $z));
		}

		/**
		 * This method returns the head object in this collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Data\Type                                         the head object in this linked
		 *                                                          collection
		 */
		public abstract function head(LinkedList\Type $xs);

		/**
		 * This method returns an option using the head for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Option\Type                                      the option
		 */
		public static function headOption(LinkedList\Type $xs) {
			return (!LinkedList\Module::isEmpty($xs)->unbox()) ? Option\Type::some(LinkedList\Module::head($xs)) : Option\Type::none();
		}

		/**
		 * This method return the index of the first occurrence of the object; otherwise, it returns -1;
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Data\Type $y                                      the object to be searched for
		 * @return Int32\Type                                       the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public static function indexOf(LinkedList\Type $xs, Data\Type $y) {
			$i = Int32\Module::zero();

			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs); $zs = LinkedList\Module::tail($zs)) {
				$z = LinkedList\Module::head($zs);
				if (call_user_func_array(array(get_class($z), 'eq'), array($z, $y))->unbox()) {
					return $i;
				}
				$i = Int32\Module::increment($i);
			}

			return Int32\Module::negative();
		}

		/**
		 * This method returns all but the last element of in the collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return LinkedList\Type                                  the collection, minus the last
		 *                                                          element
		 */
		public static function init(LinkedList\Type $xs) {
			$start = LinkedList\Module::nil();
			$tail = null;

			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox() && ! LinkedList\Module::isEmpty(LinkedList\Module::tail($zs))->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$ys = LinkedList\Module::cons(LinkedList\Module::head($zs), LinkedList\Module::nil());

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
		 * The method intersperses the specified object between each element in the collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Data\Type $y                                      the object to be interspersed
		 * @return LinkedList\Type                                  the collection
		 */
		public static function intersperse(LinkedList\Type $xs, Data\Type $y) {
			return (LinkedList\Module::isEmpty($xs) || LinkedList\Module::isEmpty(LinkedList\Module::tail($xs))->unbox())
				? $xs
				: LinkedList\Module::cons(LinkedList\Module::head($xs), LinkedList\Module::cons($y, LinkedList\Module::intersperse(LinkedList\Module::tail($xs), $y)));
		}

		/**
		 * This method (aka "null") returns whether this collection is empty.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Bool\Type                                        whether the collection is empty
		 */
		public static function isEmpty(LinkedList\Type $xs) {
			return Bool\Module::create($xs instanceof LinkedList\Type\Nil);
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return LinkedList\Type\Iterator                         an iterator for this collection
		 */
		public static function iterator(LinkedList\Type $xs) {
			return new LinkedList\Type\Iterator($xs);
		}

		/**
		 * This method returns the last element in this collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Data\Type                                        the last element in this collection
		 */
		public static function last(LinkedList\Type $xs) {
			$z = LinkedList\Module::head($xs);

			for ($zs = LinkedList\Module::tail($xs); ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$z = LinkedList\Module::head($zs);
			}

			return $z;
		}

		/**
		 * This method returns an option using the last for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Option\Type                                      the option
		 */
		public static function lastOption(LinkedList\Type $xs) {
			return (!LinkedList\Module::isEmpty($xs)->unbox()) ? Option\Type::some(LinkedList\Module::last($xs)) : Option\Type::none();
		}

		/**
		 * This method returns the length of this collection. Performs in O(n) time.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Int32\Type                                       the length of this collection
		 */
		public static function length(LinkedList\Type $xs) {
			return LinkedList\Module::foldLeft($xs, function(Int32\Type $length) {
				return Int32\Module::increment($length);
			}, Int32\Module::zero());
		}

		/**
		 * This method applies each element in this collection to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return LinkedList\Type                                  the collection
		 */
		public static function map(LinkedList\Type $xs, callable $subroutine) {
			$start = LinkedList\Module::nil();
			$tail = null;

			$i = Int32\Module::zero();
			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$ys = LinkedList\Module::cons($subroutine(LinkedList\Module::head($zs), $i), LinkedList\Module::nil());

				if ($tail !== null) {
					$tail->tail = $ys;
				}
				else {
					$start = $ys;
				}

				$tail = $ys;
				$i = Int32\Module::increment($i);
			}

			return $start;
		}

		/**
		 * This method iterates over the elements in the collection, yielding each element to the
		 * predicate function, or fails the falsy test.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether each element passed the
		 *                                                          falsy test
		 */
		public static function none(LinkedList\Type $xs, callable $predicate) {
			return LinkedList\Module::all($xs, function(Data\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method prepends the specified object to the front of this collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Data\Type $y                                      the object to be prepended
		 * @return LinkedList\Type                                  the collection
		 */
		public static function prepend(LinkedList\Type $xs, Data\Type $y) {
			return LinkedList\Module::cons($y, $xs);
		}

		/**
		 * This method returns the collection within the specified range.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Int32\Type $start                                 the starting index
		 * @param Int32\Type $end                                   the ending index
		 * @return LinkedList\Type                                  the collection
		 */
		public static function range(LinkedList\Type $xs, Int32\Type $start, Int32\Type $end) {
			return LinkedList\Module::drop(LinkedList\Module::take($xs, $end), $start);
		}

		/**
		 * This method returns a collection of those elements that don't satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return LinkedList\Type                                  the collection
		 */
		public static function remove(LinkedList\Type $xs, callable $predicate) {
			return LinkedList\Module::filter($xs, function(Data\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method reverses the order of the elements in this collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return LinkedList\Type                                  the collection
		 */
		public static function reverse(LinkedList\Type $xs) {
			return LinkedList\Module::foldLeft($xs, function(LinkedList\Type $tail, Data\Type $head) {
				return LinkedList\Module::cons($head, $tail);
			}, LinkedList\Module::nil());
		}

		/**
		 * This method returns the extracted slice of the collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Int32\Type $offset                                the starting index
		 * @param Int32\Type $length                                the length of the slice
		 * @return LinkedList\Type                                  the collection
		 */
		public static function slice(LinkedList\Type $xs, Int32\Type $offset, Int32\Type $length) {
			return LinkedList\Module::drop(LinkedList\Module::take($xs, Int32\Module::add($length, $offset)), $offset);
		}

		/**
		 * This method returns the tail of this collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return LinkedList\Type                                  the tail of this collection
		 */
		public abstract function tail(LinkedList\Type $xs);

		/**
		 * This method returns the first "n" elements in the collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Int32\Type $n                                     the number of elements to take
		 * @return LinkedList\Type                                  the collection
		 */
		public static function take(LinkedList\Type $xs, Int32\Type $n) {
			if (($n->unbox() <= 0) || LinkedList\Module::isEmpty($xs)->unbox()) {
				return LinkedList\Module::nil();
			}
			return LinkedList\Module::cons(LinkedList\Module::head($xs), LinkedList\Module::take(LinkedList\Module::tail($xs), Int32\Module::decrement($n)));
		}

		/**
		 * This method returns each element in this collection until the predicate fails.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return LinkedList\Type                                  the collection
		 */
		public static function takeWhile(LinkedList\Type $xs, callable $predicate) {
			$start = LinkedList\Module::nil();
			$tail = null;

			$taking = true;

			$i = Int32\Module::zero();
			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox() && $taking; $zs = LinkedList\Module::tail($zs)) {
				$z = LinkedList\Module::head($zs);

				if ($predicate($z, $i)->unbox()) {
					$ys = LinkedList\Module::cons($z, LinkedList\Module::nil());

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

				$i = Int32\Module::increment($i);
			}

			return $start;
		}

		/**
		 * This method returns each element in this collection until the predicate doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return LinkedList\Type                                  the collection
		 */
		public static function takeWhileEnd(LinkedList\Type $xs, callable $predicate) {
			return LinkedList\Module::takeWhile($xs, function(Data\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method returns the collection as an array.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return ArrayList\Type                                   the collection as an array list
		 */
		public static function toArray(LinkedList\Type $xs) {
			$buffer = array();

			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$buffer[] = LinkedList\Module::head($zs);
			}

			return ArrayList\Module::create($buffer);
		}

		/**
		 * This method returns the collection as a linked list.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return LinkedList\Type                                  the collection as a linked list
		 */
		public static function toList(LinkedList\Type $xs) {
			return $xs;
		}

		#endregion

		#region Methods -> Object Oriented -> Boolean Operations

		/**
		 * This method (aka "truthy") returns whether all of the elements of the collection evaluate
		 * to true.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Bool\Type                                        whether all of the elements of
		 *                                                          the collection evaluate to true
		 */
		public static function and_(LinkedList\Type $xs) {
			return LinkedList\Module::truthy($xs);
		}

		/**
		 * This method (aka "falsy") returns whether all of the elements of the collection evaluate
		 * to false.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Bool\Type                                        whether all of the elements of
		 *                                                          the collection evaluate to false
		 *
		 * @see http://www.sitepoint.com/javascript-truthy-falsy/
		 */
		public static function or_(LinkedList\Type $xs) {
			return LinkedList\Module::falsy($xs);
		}

		/**
		 * This method returns whether all of the elements of the collection strictly evaluate to
		 * false.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Bool\Type                                        whether all of the elements of
		 *                                                          the collection strictly evaluate
		 *                                                          to false
		 */
		public static function false(LinkedList\Type $xs) {
			return Bool\Module::not(LinkedList\Module::true($xs));
		}

		/**
		 * This method (aka "or") returns whether all of the elements of the collection evaluate to
		 * false.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Bool\Type                                        whether all of the elements of
		 *                                                          the collection evaluate to false
		 *
		 * @see http://www.sitepoint.com/javascript-truthy-falsy/
		 */
		public static function falsy(LinkedList\Type $xs) {
			return Bool\Module::not(LinkedList\Module::truthy($xs));
		}

		/**
		 * This method returns whether all of the elements of the collection strictly evaluate
		 * to true.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Bool\Type                                        whether all of the elements of
		 *                                                          the collection strictly evaluate
		 *                                                          to true
		 */
		public static function true(LinkedList\Type $xs) {
			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				if (LinkedList\Module::head($zs)->unbox() !== true) {
					return Bool\Module::false();
				}
			}
			return Bool\Module::true();
		}

		/**
		 * This method (aka "and") returns whether all of the elements of the collection evaluate to
		 * true.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Bool\Type                                        whether all of the elements of
		 *                                                          the collection evaluate to true
		 */
		public static function truthy(LinkedList\Type $xs) {
			for ($zs = $xs; ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				if (!LinkedList\Module::head($zs)->unbox()) {
					return Bool\Module::false();
				}
			}
			return Bool\Module::true();
		}

		#endregion

		#region Methods -> Object Oriented -> Numeric Operations

		/**
		 * This method returns the average of all elements in the collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Num\Type                                         the result
		 */
		public static function average(LinkedList\Type $xs) {
			$zs = $xs;

			if (LinkedList\Module::isEmpty($zs)->unbox()) {
				return Int32\Module::zero();
			}

			$z = LinkedList\Module::head($zs);

			$t = $z->__typeOf();
			$y = $t::zero();

			for ($zs = LinkedList\Module::tail($zs); ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$z = $z->add(LinkedList\Module::head($zs));
				$y = $y->increment();
			}

			return $z->divide($y);
		}

		/**
		 * This method returns the product of all elements in the collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Num\Type                                         the result
		 */
		public static function product(LinkedList\Type $xs) {
			$zs = $xs;

			if (LinkedList\Module::isEmpty($zs)->unbox()) {
				return Int32\Module::one();
			}

			$z = LinkedList\Module::head($zs);
			$number = get_class($z);

			for ($zs = LinkedList\Module::tail($zs); ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$z = $number::multiply($z, LinkedList\Module::head($zs));
			}

			return $z;
		}

		/**
		 * This method returns the sum of all elements in the collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Num\Type                                         the result
		 */
		public static function sum(LinkedList\Type $xs) {
			$zs = $xs;

			if (LinkedList\Module::isEmpty($zs)->unbox()) {
				return Int32\Module::zero();
			}

			$z = LinkedList\Module::head($zs);
			$number = get_class($z);

			for ($zs = LinkedList\Module::tail($zs); ! LinkedList\Module::isEmpty($zs)->unbox(); $zs = LinkedList\Module::tail($zs)) {
				$z = $number::add($z, LinkedList\Module::head($zs));
			}

			return $z;
		}

		#endregion

	}

}