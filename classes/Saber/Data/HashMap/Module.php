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

namespace Saber\Data\HashMap {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Bool;
	use \Saber\Data\HashMap;
	use \Saber\Data\Int32;
	use \Saber\Data\LinkedList;
	use \Saber\Data\Map;
	use \Saber\Data\Trit;
	use \Saber\Data\Tuple;
	use \Saber\Data\Unit;

	final class Module extends Data\Module implements Map\Module {

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the items in the list, yielding each
		 * item to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether each item passed the
		 *                                                          truthy test
		 */
		public static function all(HashMap\Type $xs, callable $predicate) {
			$xi = HashMap\Module::iterator($xs);
			$i = Int32\Type::zero();

			foreach ($xi as $k => $v) {
				$entry = Tuple\Type::box($k, $v);
				if (!$predicate($entry, $i)->unbox()) {
					return Bool\Type::false();
				}
				$i = Int32\Module::increment($i);
			}

			return Bool\Type::true(); // yes, an empty array returns "true"
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the items in the list passed the truthy
		 * test.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether some of the items
		 *                                                          passed the truthy test
		 */
		public static function any(HashMap\Type $xs, callable $predicate) {
			$xi = HashMap\Module::iterator($xs);
			$i = Int32\Type::zero();

			foreach ($xi as $k => $v) {
				$entry = Tuple\Type::box($k, $v);
				if ($predicate($entry, $i)->unbox()) {
					return Bool\Type::true();
				}
				$i = Int32\Module::increment($i);
			}

			return Bool\Type::false();
		}

		/**
		 * This method removes all entries from the hash map.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @return HashMap\Type                                     the hash map
		 */
		public static function clear(HashMap\Type $xs) {
			return HashMap\Type::empty_();
		}

		/**
		 * This method returns all key/value pairs in the hash map.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @return ArrayList\Type                                   all key/value pairs in the
		 *                                                          collection
		 */
		public static function entries(HashMap\Type $xs) {
			return $xs->entries();
		}

		/**
		 * This method returns a hash set of those items that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @param callable $predicate                               the predicate function to be used
		 * @return HashMap\Type                                     the hash map
		 */
		public static function filter(HashMap\Type $xs, callable $predicate) {
			$zs = HashMap\Type::empty_();

			$xi = HashMap\Module::iterator($xs);
			$i = Int32\Type::zero();

			foreach ($xi as $k => $v) {
				$entry = Tuple\Type::box($k, $v);
				if ($predicate($entry, $i)->unbox()) {
					$zs->putEntry($k, $v);
				}
				$i = Int32\Module::increment($i);
			}

			return $zs;
		}

		/**
		 * This method applies a fold reduction on the list using the operator function.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Type $initial                                the initial value to be used
		 * @return Core\Type                                        the result
		 */
		public static function fold(HashMap\Type $xs, callable $operator, Core\Type $initial) {
			$xi = HashMap\Module::iterator($xs);
			$z = $initial;

			foreach ($xi as $k => $v) {
				$entry = Tuple\Type::box($k, $v);
				$z = $operator($z, $entry);
			}

			return $z;
		}

		/**
		 * This method returns whether the specified key exists.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @param Core\Type $k                                      the key to be found
		 * @return Bool\Type                                        whether the key exists
		 */
		public static function hasKey(HashMap\Type $xs, Core\Type $k) {
			return $xs->hasKey($k);
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @return Bool\Type                                        whether the list is empty
		 */
		public static function isEmpty(HashMap\Type $xs) {
			return $xs->isEmpty();
		}

		/**
		 * This method returns the item associated with the specified key.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @param Core\Type $k                                      the key to be fetched
		 * @return Core\Type                                        the item associated with the
		 *                                                          specified key
		 */
		public static function item(HashMap\Type $xs, Core\Type $k) {
			return $xs->item($k);
		}

		/**
		 * This method returns all of the items in the hash map.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @return ArrayList\Type                                   all items in the hash map
		 */
		public static function items(HashMap\Type $xs) {
			return $xs->items();
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @return HashMap\Iterator                                 an iterator for this collection
		 */
		public static function iterator(HashMap\Type $xs) {
			return new HashMap\Iterator($xs);
		}

		/**
		 * This method returns all of the keys in the hash map.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @return ArrayList\Type                                   all keys in the hash map
		 */
		public static function keys(HashMap\Type $xs) {
			return $xs->keys();
		}

		/**
		 * This method applies each item in this hash set to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return HashMap\Type                                     the hash map
		 */
		public static function map(HashMap\Type $xs, callable $subroutine) {
			$zs = HashMap\Type::empty_();

			$xi = HashMap\Module::iterator($xs);
			$i = Int32\Type::zero();

			foreach ($xi as $k => $v) {
				$entry = Tuple\Type::box($k, $v);
				$zs = HashMap\Module::putEntry($zs, $subroutine($entry, $i));
				$i = Int32\Module::increment($i);
			}

			return $zs;
		}

		/**
		 * This method returns a pair of hash maps: those items that satisfy the predicate and
		 * those items that do not satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map to be partitioned
		 * @param callable $predicate                               the predicate function to be used
		 * @return Tuple\Type                                       the results
		 */
		public static function partition(HashMap\Type $xs, callable $predicate) {
			$passed = HashMap\Type::empty_();
			$failed = HashMap\Type::empty_();

			$xi = HashMap\Module::iterator($xs);
			$i = Int32\Type::zero();

			foreach ($xi as $k => $v) {
				$entry = Tuple\Type::box($k, $v);
				if ($predicate($entry, $i)->unbox()) {
					$passed->putEntry($entry->first(), $entry->second());
				}
				else {
					$failed->putEntry($entry->first(), $entry->second());
				}
			}

			return Tuple\Type::box($passed, $failed);
		}

		/**
		 * This method adds the item with the specified key to the hash map (if it doesn't
		 * already exist).
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @param Tuple\Type $entry                                 the key/value pair to be put
		 *                                                          in the hash map
		 * @return HashMap\Type                                     the hash map
		 */
		public static function putEntry(HashMap\Type $xs, Tuple\Type $entry) {
			$zs = HashMap\Type::box($xs->unbox());
			$zs->putEntry($entry->first(), $entry->second());
			return $zs;
		}

		/**
		 * This method returns an item after removing it from the hash map.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @param Core\Type $k                                      the key associated with the
		 *                                                          item to be removed
		 * @return Core\Type                                        the item removed
		 */
		public static function removeKey(HashMap\Type $xs, Core\Type $k) {
			$zs = HashMap\Type::box($xs->unbox());
			$zs->removeKey($k);
			return $zs;
		}

		/**
		 * This method returns the size of this collection.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @return Int32\Type                                       the size of this collection
		 */
		public static function size(HashMap\Type $xs) {
			return $xs->size();
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the value to be evaluated
		 * @param HashMap\Type $ys                                  the default value
		 * @return HashMap\Type                                     the result
		 */
		public static function nvl(HashMap\Type $xs = null, HashMap\Type $ys = null) {
			return ($xs !== null) ? $xs : (($ys !== null) ? $ys : HashMap\Type::empty_());
		}

		/**
		 * This method returns the hash map as an array.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @return HashMap\Type                                     the hash map as an array list
		 */
		public static function toArrayList(HashMap\Type $xs) {
			$buffer = array();
			$xi = HashMap\Module::iterator($xs);
			foreach ($xi as $x) {
				$buffer[] = $x;
			}
			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the hash map as a linked list.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the hash map
		 * @return LinkedList\Type                                  the hash map as a linked list
		 */
		public static function toLinkedList(HashMap\Type $xs) {
			$zs = LinkedList\Type::nil();
			$xi = HashMap\Module::iterator($xs);
			foreach ($xi as $x) {
				$zs = LinkedList\Type::cons($x, $zs);
			}
			return $zs;
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(HashMap\Type $xs, Core\Type $ys) { // ==
			$type = $xs->__typeOf();
			if (($ys !== null) && ($ys instanceof $type)) {
				if (Int32\Module::__eq($xs->size(), $ys->size())) {
					return HashMap\Module::all($xs, function (Tuple\Type $x, Int32\Type $i) use ($ys) {
						$key = $x->first();
						if ($ys->__hasKey($key)) {
							return $ys->item($key)->eq($x->second());
						}
						return Bool\Type::false();
					});
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(HashMap\Type $xs, Core\Type $ys) { // ===
			if (($ys !== null) && ($xs->__typeOf() === $ys->__typeOf())) {
				if (Int32\Module::eq($xs->size(), $ys->size())) {
					return Bool\Type::box((string)serialize($xs) == (string)serialize($ys));
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(HashMap\Type $xs, Core\Type $ys) { // !=
			return Bool\Module::not(HashMap\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(HashMap\Type $xs, Core\Type $ys) { // !==
			return Bool\Module::not(HashMap\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the left operand
		 * @param HashMap\Type $ys                                  the object to be compared
		 * @return Trit\Type                                        whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(HashMap\Type $xs, HashMap\Type $ys) {
			$x_length = $xs->__size();
			$y_length = $ys->__size();

			if ($x_length == $y_length) {
				$xi = HashMap\Module::iterator($xs);

				foreach ($xi as $k => $v) {
					if (!$ys->__hasKey($k) || !$ys->item($k)->__eq($v)) {
						return Trit\Type::make(strcmp((string)serialize($xs), (string)serialize($ys)));
					}
				}

				return Trit\Type::zero();
			}
			else if ($x_length < $y_length) {
				return Trit\Type::negative();
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
		 * @param HashMap\Type $xs                                  the left operand
		 * @param HashMap\Type $ys                                  the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(HashMap\Type $xs, HashMap\Type $ys) { // >=
			return Bool\Type::box(HashMap\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the left operand
		 * @param HashMap\Type $ys                                  the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(HashMap\Type $xs, HashMap\Type $ys) { // >
			return Bool\Type::box(HashMap\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the left operand
		 * @param HashMap\Type $ys                                  the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(HashMap\Type $xs, HashMap\Type $ys) { // <=
			return Bool\Type::box(HashMap\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the left operand
		 * @param HashMap\Type $ys                                  the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(HashMap\Type $xs, HashMap\Type $ys) { // <
			return Bool\Type::box(HashMap\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the left operand
		 * @param HashMap\Type $ys                                  the right operand
		 * @return HashMap\Type                                     the maximum value
		 */
		public static function max(HashMap\Type $xs, HashMap\Type $ys) {
			return (HashMap\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param HashMap\Type $xs                                  the left operand
		 * @param HashMap\Type $ys                                  the right operand
		 * @return HashMap\Type                                     the minimum value
		 */
		public static function min(HashMap\Type $xs, HashMap\Type $ys) {
			return (HashMap\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

	}

}