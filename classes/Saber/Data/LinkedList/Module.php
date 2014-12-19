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

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Bool;
	use \Saber\Data\Collection;
	use \Saber\Data\HashMap;
	use \Saber\Data\Int32;
	use \Saber\Data\LinkedList;
	use \Saber\Data\Option;
	use \Saber\Data\Trit;
	use \Saber\Data\Tuple;
	use \Saber\Data\Unit;
	use \Saber\Data\Vector;
	use \Saber\Throwable;

	final class Module extends Data\Module implements Vector\Module {

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the items in the collection, yielding each
		 * item to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether each item passed the
		 *                                                          truthy test
		 */
		public static function all(LinkedList\Type $xs, callable $predicate) {
			$i = Int32\Type::zero();

			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				$z = LinkedList\Module::head($zs, $i);
				if (!$predicate($z, $i)->unbox()) {
					return Bool\Type::false();
				}
				$i = Int32\Module::increment($i);
			}

			return Bool\Type::true(); // yes, an empty list returns "true"
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the items in the collection
		 * passed the truthy test.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether some of the items
		 *                                                          passed the truthy test
		 */
		public static function any(LinkedList\Type $xs, callable $predicate) {
			return Option\Module::isDefined(LinkedList\Module::find($xs, $predicate));
		}

		/**
		 * This method appends the specified object to this object's collection. Performs in O(n) time.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Core\Type $y                                      the object to be appended
		 * @return LinkedList\Type                                  the collection
		 */
		public static function append(LinkedList\Type $xs, Core\Type $y) {
			return LinkedList\Module::concat($xs, LinkedList\Type::cons($y));
		}

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
			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail());
			$zs->tail = $ys;
			return $xs;
		}

		/**
		 * This method evaluates whether the specified object is contained within the collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Core\Type $y                                      the object to find
		 * @return Bool\Type                                        whether the specified object is
		 *                                                          contained within the collection
		 */
		public static function contains(LinkedList\Type $xs, Core\Type $y) {
			return LinkedList\Module::any($xs, function(Core\Type $x, Int32\Type $i) use ($y) {
				return call_user_func_array(array(get_class($x), 'eq'), array($x, $y));
			});
		}

		/**
		 * This method remove the first occurrence that equals the specified object.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Core\Type $y                                      the object to be removed
		 * @return LinkedList\Type                                  the collection
		 */
		public static function delete(LinkedList\Type $xs, Core\Type $y) {
			$start = LinkedList\Type::nil();
			$tail = null;

			$index = Int32\Type::zero();
			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				$head = $zs->head();
				if (!call_user_func_array(array(get_class($head), 'eq'), array($head, $y))->unbox()) {
					$cons = LinkedList\Type::cons($head);

					if ($tail !== null) {
						$tail->tail = $cons;
					}
					else {
						$start = $cons;
					}

					$tail = $cons;
				}
				else {
					$cons = $zs->tail();

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
		 * This method returns the collection after dropping the first "n" items.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Int32\Type $n                                     the number of items to drop
		 * @return LinkedList\Type                                  the collection
		 */
		public static function drop(LinkedList\Type $xs, Int32\Type $n) {
			$i = Int32\Type::zero();

			for ($zs = $xs; ($i->unbox() < $n->unbox()) && !$zs->__isEmpty(); $zs = $zs->tail()) {
				$i = Int32\Module::increment($i);
			}

			return $zs;
		}

		/**
		 * This method returns the collection from item where the predicate function fails.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return LinkedList\Type                                  the collection
		 */
		public static function dropWhile(LinkedList\Type $xs, callable $predicate) {
			$i = Int32\Type::zero();

			for ($zs = $xs; !$zs->__isEmpty() && $predicate($zs->head(), $i)->unbox(); $zs = $zs->tail()) {
				$i = Int32\Module::increment($i);
			}

			return $zs;
		}

		/**
		 * This method returns the collection from item where the predicate function doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return LinkedList\Type                                  the collection
		 */
		public static function dropWhileEnd(LinkedList\Type $xs, callable $predicate) {
			return LinkedList\Module::dropWhile($xs, function(Core\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method iterates over the items in the collection, yielding each item to the
		 * callback function.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $procedure                               the procedure function to be used
		 */
		public static function each(LinkedList\Type $xs, callable $procedure) {
			$i = Int32\Type::zero();

			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				Unit\Type::covariant($procedure($zs->head(), $i));
				$i = Int32\Module::increment($i);
			}
		}

		/**
		 * This method returns a collection of those items that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return LinkedList\Type                                  the collection
		 */
		public static function filter(LinkedList\Type $xs, callable $predicate) {
			$start = LinkedList\Type::nil();
			$tail = null;

			$i = Int32\Type::zero();
			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				$z = $zs->head();
				if ($predicate($z, $i)->unbox()) {
					$ys = LinkedList\Type::cons($z);

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
			$i = Int32\Type::zero();

			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				$z = $zs->head();
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
			$start = LinkedList\Type::nil();
			$tail = null;

			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				$z = $zs->head();

				$ys = ($z instanceof Collection\Type)
					? LinkedList\Module::toLinkedList(LinkedList\Module::flatten($z))
					: LinkedList\Type::cons($z);

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
		 * @param Core\Type $initial                                the initial value to be used
		 * @return Core\Type                                        the result
		 */
		public static function foldLeft(LinkedList\Type $xs, callable $operator, Core\Type $initial) {
			$c = $initial;

			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				$z = $zs->head();
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
		 * @param Core\Type $initial                                the initial value to be used
		 * @return Core\Type                                        the result
		 */
		public static function foldRight(LinkedList\Type $xs, callable $operator, Core\Type $initial) {
			$z = $initial;

			if ($xs->__isEmpty()) {
				return $z;
			}

			return $operator($xs->head(), LinkedList\Module::foldRight($xs->tail(), $operator, $z));
		}

		/**
		 * This method returns the head object in this collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Core\Type                                        the head object in this linked
		 *                                                          collection
		 */
		public static function head(LinkedList\Type $xs) {
			return $xs->head();
		}

		/**
		 * This method returns an option using the head for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Option\Type                                      the option
		 */
		public static function headOption(LinkedList\Type $xs) {
			return (!$xs->__isEmpty()) ? Option\Type::some($xs->head()) : Option\Type::none();
		}

		/**
		 * This method returns the index of the first occurrence of the object; otherwise, it returns -1;
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Core\Type $y                                      the object to be searched for
		 * @return Int32\Type                                       the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public static function indexOf(LinkedList\Type $xs, Core\Type $y) {
			$i = Int32\Type::zero();

			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				$z = $zs->head();
				if (call_user_func_array(array(get_class($z), 'eq'), array($z, $y))->unbox()) {
					return $i;
				}
				$i = Int32\Module::increment($i);
			}

			return Int32\Type::negative();
		}

		/**
		 * This method returns all but the last item of in the collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return LinkedList\Type                                  the collection, minus the last
		 *                                                          item
		 */
		public static function init(LinkedList\Type $xs) {
			$start = LinkedList\Type::nil();
			$tail = null;

			for ($zs = $xs; !$zs->__isEmpty() && !$zs->tail()->__isEmpty(); $zs = $zs->tail()) {
				$ys = LinkedList\Type::cons($zs->head());

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
		 * The method intersperses the specified object between each item in the collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Core\Type $y                                      the object to be interspersed
		 * @return LinkedList\Type                                  the collection
		 */
		public static function intersperse(LinkedList\Type $xs, Core\Type $y) {
			return ($xs->__isEmpty() || $xs->tail()->__isEmpty())
				? $xs
				: LinkedList\Type::cons($xs->head(), LinkedList\Type::cons($y, LinkedList\Module::intersperse($xs->tail(), $y)));
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
			return $xs->isEmpty();
		}

		/**
		 * This method returns the item at the specified index.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Int32\Type $i                                     the index of the item
		 * @return Core\Type                                        the item at the specified index
		 * @throws Throwable\OutOfBounds\Exception                  indicates the specified index
		 *                                                          cannot be found
		 */
		public static function item(LinkedList\Type $xs, Int32\Type $i) {
			return $xs->item($i);
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return LinkedList\Iterator                              an iterator for this collection
		 */
		public static function iterator(LinkedList\Type $xs) {
			return new LinkedList\Iterator($xs);
		}

		/**
		 * This method returns the last item in this collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Core\Type                                        the last item in this collection
		 */
		public static function last(LinkedList\Type $xs) {
			$z = $xs->head();
			for ($zs = $xs->tail(); !$zs->__isEmpty(); $zs = $zs->tail()) {
				$z = $zs->head();
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
			return (!$xs->__isEmpty()) ? Option\Type::some(LinkedList\Module::last($xs)) : Option\Type::none();
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
			return $xs->length();
		}

		/**
		 * This method returns an option containing the value paired with the lookup key x.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xss                              the left operand
		 * @param Core\Equality\Type $x                             the key being looked up
		 * @return Option\Type                                      an option containing the associated
		 *                                                          value
		 * @throws Throwable\UnexpectedValue\Exception              indicates that the list is not
		 *                                                          associative
		 */
		public static function lookup(LinkedList\Type $xss, Core\Equality\Type $x) {
			if ($xss->__isEmpty()) {
				return Option\Type::none();
			}

			$xs = $xss->head();

			if (!Tuple\Module::isPair($xs)->unbox()) {
				throw new Throwable\UnexpectedValue\Exception('Unable to process tuple. Expected a length of "2", but got a length of ":length".', array(':length' => $xs->__length()));
			}

			if ($x->__eq(Tuple\Module::first($xs))) {
				return Option\Type::some(Tuple\Module::second($xs));
			}

			return LinkedList\Module::lookup($xss->tail(), $x);
		}

		/**
		 * This method applies each item in this collection to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return LinkedList\Type                                  the collection
		 */
		public static function map(LinkedList\Type $xs, callable $subroutine) {
			$start = LinkedList\Type::nil();
			$tail = null;

			$i = Int32\Type::zero();
			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				$ys = LinkedList\Type::cons($subroutine($zs->head(), $i));

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
		 * This method iterates over the items in the collection, yielding each item to the
		 * predicate function, or fails the falsy test.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether each item passed the
		 *                                                          falsy test
		 */
		public static function none(LinkedList\Type $xs, callable $predicate) {
			return LinkedList\Module::all($xs, function(Core\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method returns a pair of linked lists: those items that satisfy the predicate and
		 * those items that do not satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the linked list to be partitioned
		 * @param callable $predicate                               the predicate function to be used
		 * @return Tuple\Type                                       the results
		 */
		public static function partition(LinkedList\Type $xs, callable $predicate) {
			$passed = LinkedList\Type::nil();
			$passed_tail = null;
			$failed = LinkedList\Type::nil();
			$failed_tail = null;

			$i = Int32\Type::zero();
			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				$a = $zs->head();

				$as = LinkedList\Type::cons($a);

				if ($predicate($a, $i)->unbox()) {
					if ($passed_tail !== null) {
						$passed_tail->tail = $as;
					}
					else {
						$passed = $as;
					}
					$passed_tail = $as;
				}
				else {
					if ($failed_tail !== null) {
						$failed_tail->tail = $as;
					}
					else {
						$failed = $as;
					}
					$failed_tail = $as;
				}

				$i = Int32\Module::increment($i);
			}

			return Tuple\Type::box($passed, $failed);
		}

		/**
		 * This method returns a linked list of values matching the specified key.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xss                              the linked list to be processed
		 * @param Core\Type $k                                      the key associated with value to be
		 *                                                          plucked
		 * @return LinkedList\Type                                  a list of values matching the specified
		 *                                                          key
		 */
		public static function pluck(LinkedList\Type $xss, Core\Type $k) {
			return LinkedList\Module::map($xss, function(HashMap\Type $xs, Int32\Type $i) use ($k) {
				return $xs->item($k);
			});
		}

		/**
		 * This method prepends the specified object to the front of this collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Core\Type $y                                      the object to be prepended
		 * @return LinkedList\Type                                  the collection
		 */
		public static function prepend(LinkedList\Type $xs, Core\Type $y) {
			return LinkedList\Type::cons($y, $xs);
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
		 * This method (aka "reject") returns a collection of those items that don't satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return LinkedList\Type                                  the collection
		 */
		public static function remove(LinkedList\Type $xs, callable $predicate) {
			return LinkedList\Module::filter($xs, function(Core\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method reverses the order of the items in this collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return LinkedList\Type                                  the collection
		 */
		public static function reverse(LinkedList\Type $xs) {
			return LinkedList\Module::foldLeft($xs, function(LinkedList\Type $tail, Core\Type $head) {
				return LinkedList\Type::cons($head, $tail);
			}, LinkedList\Type::nil());
		}

		/**
		 * This method shuffles the items in the linked list using the Fisher-Yates shuffle.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the linked list to be shuffled
		 * @return LinkedList\Type                                  the shuffled linked list
		 *
		 * @see http://en.wikipedia.org/wiki/Fisher%E2%80%93Yates_shuffle
		 */
		public static function shuffle(LinkedList\Type $xs) {
			$buffer = $xs->unbox();
			$length = count($buffer);

			for ($i = $length - 1; $i > 0; $i--) {
				$j = rand(0, $i);
				$value = $buffer[$j];
				$buffer[$j] = $buffer[$i];
				$buffer[$i] = $value;
			}

			return LinkedList\Type::box($buffer);
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
		 * This method returns the tail of this list.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return LinkedList\Type                                  the tail of this list
		 */
		public static function tail(LinkedList\Type $xs) {
			return $xs->tail();
		}

		/**
		 * This method returns the first "n" items in the collection.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Int32\Type $n                                     the number of items to take
		 * @return LinkedList\Type                                  the collection
		 */
		public static function take(LinkedList\Type $xs, Int32\Type $n) {
			if (($n->unbox() <= 0) || $xs->__isEmpty()) {
				return LinkedList\Type::nil();
			}
			return LinkedList\Type::cons($xs->head(), LinkedList\Module::take($xs->tail(), Int32\Module::decrement($n)));
		}

		/**
		 * This method returns each item in this collection until the predicate fails.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return LinkedList\Type                                  the collection
		 */
		public static function takeWhile(LinkedList\Type $xs, callable $predicate) {
			$start = LinkedList\Type::nil();
			$tail = null;

			$taking = true;

			$i = Int32\Type::zero();
			for ($zs = $xs; !$zs->__isEmpty() && $taking; $zs = $zs->tail()) {
				$z = $zs->head();

				if ($predicate($z, $i)->unbox()) {
					$ys = LinkedList\Type::cons($z);

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
		 * This method returns each item in this collection until the predicate doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return LinkedList\Type                                  the collection
		 */
		public static function takeWhileEnd(LinkedList\Type $xs, callable $predicate) {
			return LinkedList\Module::takeWhile($xs, function(Core\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method returns a new list of tuple pairings.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param LinkedList\Type $ys                               the right operand
		 * @return LinkedList\Type                                  a new list of tuple pairings
		 */
		public static function zip(LinkedList\Type $xs, LinkedList\Type $ys) {
			$start = LinkedList\Type::nil();
			$tail = null;

			for ($as = $xs, $bs = $ys; !$as->__isEmpty() && !$bs->__isEmpty(); $as = $as->tail(), $bs = $bs->tail()) {
				$tuple = Tuple\Type::box($as->head(), $bs->head());

				$cons = LinkedList\Type::cons($tuple);

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

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the value to be evaluated
		 * @param LinkedList\Type $ys                               the default value
		 * @return LinkedList\Type                                  the result
		 */
		public static function nvl(LinkedList\Type $xs = null, LinkedList\Type $ys = null) {
			return ($xs !== null) ? $xs : (($ys !== null) ? $ys : LinkedList\Type::empty_());
		}

		/**
		 * This method returns the collection as an array.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the operand
		 * @return ArrayList\Type                                   the collection as an array list
		 */
		public static function toArrayList(LinkedList\Type $xs) {
			$buffer = array();
			LinkedList\Module::each($xs, function(Core\Type $x) use ($buffer) {
				$buffer[] = $x;
			});
			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the collection as a linked list.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the operand
		 * @return LinkedList\Type                                  the collection as a linked list
		 */
		public static function toLinkedList(LinkedList\Type $xs) {
			return $xs;
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(LinkedList\Type $xs, Core\Type $ys) { // ==
			if ($ys !== null) {
				$x = ($xs instanceof LinkedList\Nil\Type);
				$y = ($ys instanceof LinkedList\Nil\Type);

				if (($x && !$y) || (!$x && $y)) {
					return Bool\Type::false();
				}
				if ($x && $y) {
					return Bool\Type::true();
				}

				for ($as = $xs, $bs = $ys; !$as->__isEmpty() && !$bs->__isEmpty(); $as = $as->tail(), $bs = $bs->tail()) {
					$r = $as->head()->eq($bs->head());
					if (!$r->unbox()) {
						return $r;
					}
				}

				$x_length = $xs->__length();
				$y_length = $ys->__length();

				if ($x_length < $y_length) {
					return Bool\Type::false();
				}
				else if ($x_length == $y_length) {
					return Bool\Type::true();
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(LinkedList\Type $xs, Core\Type $ys) { // ===
			if ($ys !== null) {
				if ($xs->__typeOf() !== $ys->typeOf()) {
					return Bool\Type::false();
				}

				for ($as = $xs, $bs = $ys; !$as->__isEmpty() && !$bs->__isEmpty(); $as = $as->tail(), $bs = $bs->tail()) {
					$r = $as->head()->id($bs->head());
					if (!$r->unbox()) {
						return $r;
					}
				}

				$x_length = $xs->__length();
				$y_length = $ys->__length();

				if ($x_length < $y_length) {
					return Bool\Type::false();
				}
				else if ($x_length == $y_length) {
					return Bool\Type::true();
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(LinkedList\Type $xs, Core\Type $ys) { // !=
			return Bool\Module::not(LinkedList\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(LinkedList\Type $xs, Core\Type $ys) { // !==
			return Bool\Module::not(LinkedList\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param LinkedList\Type $ys                               the right operand
		 * @return Trit\Type                                        the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(LinkedList\Type $xs, LinkedList\Type $ys) {
			$x = ($xs instanceof LinkedList\Nil\Type);
			$y = ($ys instanceof LinkedList\Nil\Type);

			if (!$x && $y) {
				return Trit\Type::negative();
			}
			if ($x && $y) {
				return Trit\Type::zero();
			}
			if ($x && !$y) {
				return Trit\Type::positive();
			}

			for ($as = $xs, $bs = $ys; !$as->__isEmpty() && !$bs->__isEmpty(); $as = $as->tail(), $bs = $bs->tail()) {
				$r = $as->head()->compare($bs->head());
				if ($r->unbox() != 0) {
					return $r;
				}
			}

			$x_length = $xs->__length();
			$y_length = $ys->__length();

			if ($x_length < $y_length) {
				return Trit\Type::negative();
			}
			else if ($x_length == $y_length) {
				return Trit\Type::zero();
			}
			else { // ($x_length > $y_length)
				return Trit\Type::positive();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param LinkedList\Type $ys                               the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(LinkedList\Type $xs, LinkedList\Type $ys) { // >=
			return Bool\Type::box(LinkedList\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param LinkedList\Type $ys                               the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(LinkedList\Type $xs, LinkedList\Type $ys) { // >
			return Bool\Type::box(LinkedList\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param LinkedList\Type $ys                               the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(LinkedList\Type $xs, LinkedList\Type $ys) { // <=
			return Bool\Type::box(LinkedList\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param LinkedList\Type $ys                               the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(LinkedList\Type $xs, LinkedList\Type $ys) { // <
			return Bool\Type::box(LinkedList\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param LinkedList\Type $ys                               the right operand
		 * @return Int32\Type                                       the maximum value
		 */
		public static function max(LinkedList\Type $xs, LinkedList\Type $ys) {
			return (LinkedList\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @param LinkedList\Type $ys                               the right operand
		 * @return Int32\Type                                       the minimum value
		 */
		public static function min(LinkedList\Type $xs, LinkedList\Type $ys) {
			return (LinkedList\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

		#region Methods -> Logical Operations

		/**
		 * This method (aka "truthy") returns whether all of the items of the collection evaluate
		 * to true.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Bool\Type                                        whether all of the items of
		 *                                                          the collection evaluate to true
		 */
		public static function and_(LinkedList\Type $xs) {
			return LinkedList\Module::truthy($xs);
		}

		/**
		 * This method (aka "falsy") returns whether all of the items of the collection evaluate
		 * to false.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Bool\Type                                        whether all of the items of
		 *                                                          the collection evaluate to false
		 *
		 * @see http://www.sitepoint.com/javascript-truthy-falsy/
		 */
		public static function or_(LinkedList\Type $xs) {
			return LinkedList\Module::falsy($xs);
		}

		/**
		 * This method returns whether all of the items of the collection strictly evaluate to
		 * false.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Bool\Type                                        whether all of the items of
		 *                                                          the collection strictly evaluate
		 *                                                          to false
		 */
		public static function false(LinkedList\Type $xs) {
			return Bool\Module::not(LinkedList\Type::true($xs));
		}

		/**
		 * This method (aka "or") returns whether all of the items of the collection evaluate to
		 * false.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Bool\Type                                        whether all of the items of
		 *                                                          the collection evaluate to false
		 *
		 * @see http://www.sitepoint.com/javascript-truthy-falsy/
		 */
		public static function falsy(LinkedList\Type $xs) {
			return Bool\Module::not(LinkedList\Module::truthy($xs));
		}

		/**
		 * This method returns whether all of the items of the collection strictly evaluate
		 * to true.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Bool\Type                                        whether all of the items of
		 *                                                          the collection strictly evaluate
		 *                                                          to true
		 */
		public static function true(LinkedList\Type $xs) {
			if ($xs->__isEmpty()) {
				return Bool\Type::true();
			}

			if ($xs->__head() !== true) {
				return Bool\Type::false();
			}

			return LinkedList\Module::true($xs->tail());
		}

		/**
		 * This method (aka "and") returns whether all of the items of the collection evaluate to
		 * true.
		 *
		 * @access public
		 * @static
		 * @param LinkedList\Type $xs                               the left operand
		 * @return Bool\Type                                        whether all of the items of
		 *                                                          the collection evaluate to true
		 */
		public static function truthy(LinkedList\Type $xs) {
			if ($xs->__isEmpty()) {
				return Bool\Type::true();
			}

			if (!$xs->__head()) {
				return Bool\Type::false();
			}

			return LinkedList\Module::truthy($xs->tail());
		}

		#endregion

	}

}