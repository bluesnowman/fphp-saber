<?php

/**
 * Copyright 2014-2016 Blue Snowman
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

declare(strict_types = 1);

namespace Saber\Data\IHashMap {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IHashMap;
	use \Saber\Data\IInt32;
	use \Saber\Data\ILinkedList;
	use \Saber\Data\IMap;
	use \Saber\Data\ITrit;
	use \Saber\Data\ITuple;
	use \Saber\Data\IUnit;

	final class Module extends Data\Module implements IMap\Module {

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the items in the list, yielding each
		 * item to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                       whether each item passed the
		 *                                                          truthy test
		 */
		public static function all(IHashMap\Type $xs, callable $predicate) : IBool\Type {
			$xi = IHashMap\Module::iterator($xs);
			$i = IInt32\Type::zero();

			foreach ($xi as $k => $v) {
				$entry = ITuple\Type::box2($k, $v);
				if (!$predicate($entry, $i)->unbox()) {
					return IBool\Type::false();
				}
				$i = IInt32\Module::increment($i);
			}

			return IBool\Type::true(); // yes, an empty array returns "true"
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the items in the list passed the truthy
		 * test.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                       whether some of the items
		 *                                                          passed the truthy test
		 */
		public static function any(IHashMap\Type $xs, callable $predicate) : IBool\Type {
			$xi = IHashMap\Module::iterator($xs);
			$i = IInt32\Type::zero();

			foreach ($xi as $k => $v) {
				$entry = ITuple\Type::box2($k, $v);
				if ($predicate($entry, $i)->unbox()) {
					return IBool\Type::true();
				}
				$i = IInt32\Module::increment($i);
			}

			return IBool\Type::false();
		}

		/**
		 * This method removes all entries from the hash map.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @return IHashMap\Type                                    the hash map
		 */
		public static function clear(IHashMap\Type $xs) : IHashMap\Type {
			return IHashMap\Type::empty_();
		}

		/**
		 * This method returns all key/value pairs in the hash map.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @return IArrayList\Type                                  all key/value pairs in the
		 *                                                          collection
		 */
		public static function entries(IHashMap\Type $xs) : IArrayList\Type {
			return $xs->entries();
		}

		/**
		 * This method returns a hash set of those items that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @param callable $predicate                               the predicate function to be used
		 * @return IHashMap\Type                                    the hash map
		 */
		public static function filter(IHashMap\Type $xs, callable $predicate) : IHashMap\Type {
			$zs = IHashMap\Type::empty_();

			$xi = IHashMap\Module::iterator($xs);
			$i = IInt32\Type::zero();

			foreach ($xi as $k => $v) {
				$entry = ITuple\Type::box2($k, $v);
				if ($predicate($entry, $i)->unbox()) {
					$zs->putEntry($k, $v);
				}
				$i = IInt32\Module::increment($i);
			}

			return $zs;
		}

		/**
		 * This method applies a fold reduction on the list using the operator function.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Type $initial                                the initial value to be used
		 * @return Core\Type                                        the result
		 */
		public static function fold(IHashMap\Type $xs, callable $operator, Core\Type $initial) : Core\Type {
			$xi = IHashMap\Module::iterator($xs);
			$z = $initial;

			foreach ($xi as $k => $v) {
				$z = $operator($z, ITuple\Type::box2($k, $v));
			}

			return $z;
		}

		/**
		 * This method returns whether the specified key exists.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @param Core\Type $k                                      the key to be found
		 * @return IBool\Type                                       whether the key exists
		 */
		public static function hasKey(IHashMap\Type $xs, Core\Type $k) : IBool\Type {
			return $xs->hasKey($k);
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @return IBool\Type                                       whether the list is empty
		 */
		public static function isEmpty(IHashMap\Type $xs) : IBool\Type {
			return $xs->isEmpty();
		}

		/**
		 * This method returns the item associated with the specified key.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @param Core\Type $k                                      the key to be fetched
		 * @return Core\Type                                        the item associated with the
		 *                                                          specified key
		 */
		public static function item(IHashMap\Type $xs, Core\Type $k) : Core\Type {
			return $xs->item($k);
		}

		/**
		 * This method returns all of the items in the hash map.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @return IArrayList\Type                                  all items in the hash map
		 */
		public static function items(IHashMap\Type $xs) : IArrayList\Type {
			return $xs->items();
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @return IHashMap\Iterator                                an iterator for this collection
		 */
		public static function iterator(IHashMap\Type $xs) : IHashMap\Iterator {
			return new IHashMap\Iterator($xs);
		}

		/**
		 * This method returns all of the keys in the hash map.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @return IArrayList\Type                                  all keys in the hash map
		 */
		public static function keys(IHashMap\Type $xs) : IArrayList\Type {
			return $xs->keys();
		}

		/**
		 * This method applies each item in this hash set to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return IHashMap\Type                                    the hash map
		 */
		public static function map(IHashMap\Type $xs, callable $subroutine) : IHashMap\Type {
			$zs = IHashMap\Type::empty_();

			$xi = IHashMap\Module::iterator($xs);
			$i = IInt32\Type::zero();

			foreach ($xi as $k => $v) {
				$entry = ITuple\Type::box2($k, $v);
				$zs = IHashMap\Module::putEntry($zs, $subroutine($entry, $i));
				$i = IInt32\Module::increment($i);
			}

			return $zs;
		}

		/**
		 * This method returns a pair of hash maps: those items that satisfy the predicate and
		 * those items that do not satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map to be partitioned
		 * @param callable $predicate                               the predicate function to be used
		 * @return ITuple\Type                                      the results
		 */
		public static function partition(IHashMap\Type $xs, callable $predicate) : ITuple\Type {
			$passed = IHashMap\Type::empty_();
			$failed = IHashMap\Type::empty_();

			$xi = IHashMap\Module::iterator($xs);
			$i = IInt32\Type::zero();

			foreach ($xi as $k => $v) {
				$entry = ITuple\Type::box2($k, $v);
				if ($predicate($entry, $i)->unbox()) {
					$passed->putEntry($entry->first(), $entry->second());
				}
				else {
					$failed->putEntry($entry->first(), $entry->second());
				}
			}

			return ITuple\Type::box2($passed, $failed);
		}

		/**
		 * This method adds the item with the specified key to the hash map (if it doesn't
		 * already exist).
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @param ITuple\Type $entry                                the key/value pair to be put
		 *                                                          in the hash map
		 * @return IHashMap\Type                                    the hash map
		 */
		public static function putEntry(IHashMap\Type $xs, ITuple\Type $entry) : IHashMap\Type {
			$zs = IHashMap\Type::box($xs->unbox());
			$zs->putEntry($entry->first(), $entry->second());
			return $zs;
		}

		/**
		 * This method returns an item after removing it from the hash map.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @param Core\Type $k                                      the key associated with the
		 *                                                          item to be removed
		 * @return Core\Type                                        the item removed
		 */
		public static function removeKey(IHashMap\Type $xs, Core\Type $k) : Core\Type {
			$zs = IHashMap\Type::box($xs->unbox());
			$zs->removeKey($k);
			return $zs;
		}

		/**
		 * This method returns the size of this collection.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @return IInt32\Type                                      the size of this collection
		 */
		public static function size(IHashMap\Type $xs) : IInt32\Type {
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
		 * @param IHashMap\Type $xs                                 the value to be evaluated
		 * @param IHashMap\Type $ys                                 the default value
		 * @return IHashMap\Type                                    the result
		 */
		public static function nvl(IHashMap\Type $xs = null, IHashMap\Type $ys = null) : IHashMap\Type {
			return $xs ?? $ys ?? IHashMap\Type::empty_();
		}

		/**
		 * This method returns the hash map as an array.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @return IHashMap\Type                                    the hash map as an array list
		 */
		public static function toArrayList(IHashMap\Type $xs) : IHashMap\Type {
			$buffer = array();
			$xi = IHashMap\Module::iterator($xs);
			foreach ($xi as $x) {
				$buffer[] = $x;
			}
			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the hash map as a linked list.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the hash map
		 * @return ILinkedList\Type                                 the hash map as a linked list
		 */
		public static function toLinkedList(IHashMap\Type $xs) : ILinkedList\Type {
			$zs = ILinkedList\Type::nil();
			$xi = IHashMap\Module::iterator($xs);
			foreach ($xi as $x) {
				$zs = ILinkedList\Type::cons($x, $zs);
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
		 * @param IHashMap\Type $xs                                 the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(IHashMap\Type $xs, Core\Type $ys) : IBool\Type { // ==
			$type = $xs->__typeOf();
			if (($ys !== null) && ($ys instanceof $type)) {
				if (IInt32\Module::__eq($xs->size(), $ys->size())) {
					return IHashMap\Module::all($xs, function (ITuple\Type $x, IInt32\Type $i) use ($ys) {
						$key = $x->first();
						if ($ys->__hasKey($key)) {
							return $ys->item($key)->eq($x->second());
						}
						return IBool\Type::false();
					});
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(IHashMap\Type $xs, Core\Type $ys) : IBool\Type { // ===
			if (($ys !== null) && ($xs->__typeOf() === $ys->__typeOf())) {
				if (IInt32\Module::eq($xs->size(), $ys->size())) {
					return IBool\Type::box((string)serialize($xs) == (string)serialize($ys));
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(IHashMap\Type $xs, Core\Type $ys) : IBool\Type { // !=
			return IBool\Module::not(IHashMap\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(IHashMap\Type $xs, Core\Type $ys) : IBool\Type { // !==
			return IBool\Module::not(IHashMap\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the left operand
		 * @param IHashMap\Type $ys                                 the object to be compared
		 * @return ITrit\Type                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(IHashMap\Type $xs, IHashMap\Type $ys) : ITrit\Type {
			$x_length = $xs->__size();
			$y_length = $ys->__size();

			if ($x_length == $y_length) {
				$xi = IHashMap\Module::iterator($xs);

				foreach ($xi as $k => $v) {
					if (!$ys->__hasKey($k) || !$ys->item($k)->__eq($v)) {
						return ITrit\Type::make(strcmp((string)serialize($xs), (string)serialize($ys))); // order is not "stable"
					}
				}

				return ITrit\Type::zero();
			}
			else if ($x_length < $y_length) {
				return ITrit\Type::negative();
			}
			else { // ($x_length > $y_length)
				return ITrit\Type::positive();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the left operand
		 * @param IHashMap\Type $ys                                 the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(IHashMap\Type $xs, IHashMap\Type $ys) : IBool\Type { // >=
			return IBool\Type::box(IHashMap\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the left operand
		 * @param IHashMap\Type $ys                                 the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(IHashMap\Type $xs, IHashMap\Type $ys) : IBool\Type { // >
			return IBool\Type::box(IHashMap\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the left operand
		 * @param IHashMap\Type $ys                                 the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(IHashMap\Type $xs, IHashMap\Type $ys) : IBool\Type { // <=
			return IBool\Type::box(IHashMap\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the left operand
		 * @param IHashMap\Type $ys                                 the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(IHashMap\Type $xs, IHashMap\Type $ys) : IBool\Type { // <
			return IBool\Type::box(IHashMap\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the left operand
		 * @param IHashMap\Type $ys                                 the right operand
		 * @return IHashMap\Type                                    the maximum value
		 */
		public static function max(IHashMap\Type $xs, IHashMap\Type $ys) : IHashMap\Type {
			return (IHashMap\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                  the left operand
		 * @param IHashMap\Type $ys                                  the right operand
		 * @return IHashMap\Type                                     the minimum value
		 */
		public static function min(IHashMap\Type $xs, IHashMap\Type $ys) : IHashMap\Type {
			return (IHashMap\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

	}

}