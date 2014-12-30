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

namespace Saber\Data\HashSet {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Bool;
	use \Saber\Data\HashSet;
	use \Saber\Data\Int32;
	use \Saber\Data\LinkedList;
	use \Saber\Data\Set;
	use \Saber\Data\Trit;
	use \Saber\Data\Tuple;
	use \Saber\Data\Unit;
	use \Saber\Throwable;

	final class Module extends Data\Module implements Set\Module {

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the items in the list, yielding each
		 * item to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the hash set
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether each item passed the
		 *                                                          truthy test
		 */
		public static function all(HashSet\Type $xs, callable $predicate) {
			$xi = HashSet\Module::iterator($xs);

			foreach ($xi as $i => $x) {
				if (!$predicate($x, $i)->unbox()) {
					return Bool\Type::false();
				}
			}

			return Bool\Type::true(); // yes, an empty array returns "true"
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the items in the list passed the truthy
		 * test.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the hash set
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether some of the items
		 *                                                          passed the truthy test
		 */
		public static function any(HashSet\Type $xs, callable $predicate) {
			$xi = HashSet\Module::iterator($xs);

			foreach ($xi as $i => $x) {
				if ($predicate($x, $i)->unbox()) {
					return Bool\Type::true();
				}
			}

			return Bool\Type::false();
		}

		/**
		 * This method removes all entries from the hash set.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the hash set
		 * @return HashSet\Type                                     the hash set
		 */
		public static function clear(HashSet\Type $xs) {
			return HashSet\Type::empty_();
		}

		/**
		 * This method returns a hash set which represents the (asymmetric) difference between
		 * the two specified hash sets.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the first hash set
		 * @param HashSet\Type $ys                                  the second hash set
		 * @return HashSet\Type                                     a hash set which represents the (asymmetric)
		 *                                                          difference of the two specified hash sets
		 */
		public static function difference(HashSet\Type $xs, HashSet\Type $ys) {
			$zs = HashSet\Type::box($xs->unbox());
			$yi = HashSet\Module::iterator($ys);
			foreach ($yi as $y) {
				$zs->removeItem($y);
			}
			return $zs;
		}

		/**
		 * This method returns a hash set of those items that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the hash set
		 * @param callable $predicate                               the predicate function to be used
		 * @return HashSet\Type                                     the hash set
		 */
		public static function filter(HashSet\Type $xs, callable $predicate) {
			$zs = HashSet\Type::empty_();

			$xi = HashSet\Module::iterator($xs);

			foreach ($xi as $i => $x) {
				if ($predicate($x, $i)->unbox()) {
					$zs->putItem($x);
				}
			}

			return $zs;
		}

		/**
		 * This method applies a fold reduction on the list using the operator function.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the hash set
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Type $initial                                the initial value to be used
		 * @return Core\Type                                        the result
		 */
		public static function fold(HashSet\Type $xs, callable $operator, Core\Type $initial) {
			$xi = HashSet\Module::iterator($xs);
			$z = $initial;

			foreach ($xi as $x) {
				$z = $operator($z, $x);
			}

			return $z;
		}

		/**
		 * This method returns the item associated with the specified key.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the hash set
		 * @param Core\Type $x                                      the item to be found
		 * @return Bool\Type                                        whether the item exists
		 */
		public static function hasItem(HashSet\Type $xs, Core\Type $x) {
			return $xs->hasItem($x);
		}

		/**
		 * This method returns a hash set which represents the intersection between the two
		 * specified sets.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the first hash set
		 * @param HashSet\Type $ys                                  the second hash set
		 * @return HashSet\Type                                     a hash set which represents the intersection
		 *                                                          of the two specified hash sets
		 */
		public static function intersection(HashSet\Type $xs, HashSet\Type $ys) {
			$zs = HashSet\Type::empty_();
			$yi = HashSet\Module::iterator($ys);
			foreach ($yi as $y) {
				if ($xs->__hasItem($y)) {
					$zs->putItem($zs);
				}
			}
			return $zs;
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the hash set
		 * @return Bool\Type                                        whether the list is empty
		 */
		public static function isEmpty(HashSet\Type $xs) {
			return $xs->isEmpty();
		}

		/**
		 * This method returns whether the second hash set is a subset of the first hash set.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the first hash set
		 * @param HashSet\Type $ys                                  the second hash set
		 * @return Bool\Type                                        whether the second hash set is a
		 *                                                          subset of the first hash set
		 */
		public static function isSubset(HashSet\Type $xs, HashSet\Type $ys) {
			$yi = HashSet\Module::iterator($ys);
			foreach ($yi as $y) {
				if (!$xs->__hasItem($y)) {
					return Bool\Type::false();
				}
			}
			return Bool\Type::true();
		}

		/**
		 * This method returns whether the second hash set is a superset of the first hash set.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the first hash set
		 * @param HashSet\Type $ys                                  the second hash set
		 * @return Bool\Type                                        whether the second hash set is a
		 *                                                          superset of the first hash set
		 */
		public static function isSuperset(HashSet\Type $xs, HashSet\Type $ys) {
			$xi = HashSet\Module::iterator($xs);
			foreach ($xi as $x) {
				if (!$ys->__hasItem($x)) {
					return Bool\Type::false();
				}
			}
			return Bool\Type::true();
		}

		/**
		 * This method returns all of the items in the hash set.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the hash set
		 * @return ArrayList\Type                                   all items in the hash set
		 */
		public static function items(HashSet\Type $xs) {
			return $xs->items();
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the hash set
		 * @return HashSet\Iterator                                 an iterator for this collection
		 */
		public static function iterator(HashSet\Type $xs) {
			return new HashSet\Iterator($xs);
		}

		/**
		 * This method applies each item in this hash set to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the hash set
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return HashSet\Type                                     the hash set
		 */
		public static function map(HashSet\Type $xs, callable $subroutine) {
			$zs = HashSet\Type::empty_();

			$xi = HashSet\Module::iterator($xs);

			foreach ($xi as $i => $x) {
				$zs->putItem($subroutine($x, $i));
			}

			return $zs;
		}

		/**
		 * This method returns a pair of hash sets: those items that satisfy the predicate and
		 * those items that do not satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the hash set to be partitioned
		 * @param callable $predicate                               the predicate function to be used
		 * @return Tuple\Type                                       the results
		 */
		public static function partition(HashSet\Type $xs, callable $predicate) {
			$passed = HashSet\Type::empty_();
			$failed = HashSet\Type::empty_();

			$xi = HashSet\Module::iterator($xs);

			foreach ($xi as $i => $x) {
				if ($predicate($x, $i)->unbox()) {
					$passed->putItem($x);
				}
				else {
					$failed->putItem($x);
				}
			}

			return Tuple\Type::box($passed, $failed);
		}

		/**
		 * This method returns the power set of the specified hash set.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the hash set to be used
		 * @return HashSet\Type                                     the power set
		 */
		public static function powerset(HashSet\Type $xs) {
			$css = HashSet\Type::empty_();
			$css->putItem(HashSet\Type::empty_());
			$xi = HashSet\Module::iterator($xs);
			foreach ($xi as $x) {
				$as = HashSet\Type::empty_();
				$csi = HashSet\Module::iterator($css);
				foreach ($csi as $cs) {
					$as->putItem($cs);
					$bs = HashSet\Type::box($cs);
					$bs->putItem($x);
					$as->putItem($bs);
				}
				$css = $as;
			}
			return $css;
		}

		/**
		 * This method puts the item into the hash set (if it doesn't already exist).
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the hash set
		 * @param Core\Type $x                                      the item to be stored
		 * @return HashSet\Type                                     the hash set
		 */
		public static function putItem(HashSet\Type $xs, Core\Type $x) {
			$zs = HashSet\Type::box($xs->unbox());
			$zs->putItem($x);
			return $zs;
		}

		/**
		 * This method returns the hash set with the item removed.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the hash set
		 * @param Core\Type $x                                      the item to be removed
		 * @return HashSet\Type                                     the hash set
		 */
		public static function removeItem(HashSet\Type $xs, Core\Type $x) {
			$zs = HashSet\Type::box($xs->unbox());
			$zs->removeItem($x);
			return $zs;
		}

		/**
		 * This method returns the size of this collection.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the hash set
		 * @return Int32\Type                                       the size of this collection
		 */
		public static function size(HashSet\Type $xs) {
			return $xs->size();
		}

		/**
		 * This method returns a hash set which represents the symmetric difference between
		 * the two specified hash sets.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the first hash set
		 * @param HashSet\Type $ys                                  the second hash set
		 * @return HashSet\Type                                     a hash set which represents the symmetric
		 *                                                          difference of the two specified sets
		 */
		public static function symmetricDifference(HashSet\Type $xs, HashSet\Type $ys) {
			$as = HashSet\Module::union($xs, $ys);
			$bs = HashSet\Module::intersection($xs, $ys);
			$cs = HashSet\Module::difference($as, $bs);
			return $cs;
		}

		/**
		 * This method returns a hash set which represents the union of the two specified hash sets.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the first hash set
		 * @param HashSet\Type $ys                                  the second hash set
		 * @return HashSet\Type                                     a hash set which represents the union
		 *                                                          of the two specified hash sets
		 */
		public static function union(HashSet\Type $xs, HashSet\Type $ys) {
			$zs = HashSet\Type::box($xs->unbox());
			$yi = HashSet\Module::iterator($ys);
			foreach ($yi as $y) {
				$zs->putItem($y);
			}
			return $zs;
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the value to be evaluated
		 * @param HashSet\Type $ys                                  the default value
		 * @return HashSet\Type                                     the result
		 */
		public static function nvl(HashSet\Type $xs = null, HashSet\Type $ys = null) {
			return ($xs !== null) ? $xs : (($ys !== null) ? $ys : HashSet\Type::empty_());
		}

		/**
		 * This method returns the hash set as an array.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the operand
		 * @return HashSet\Type                                     the hash set as an array list
		 */
		public static function toArrayList(HashSet\Type $xs) {
			$buffer = array();
			$xi = HashSet\Module::iterator($xs);
			foreach ($xi as $x) {
				$buffer[] = $x;
			}
			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the hash set as a linked list.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the operand
		 * @return LinkedList\Type                                  the hash set as a linked list
		 */
		public static function toLinkedList(HashSet\Type $xs) {
			$zs = LinkedList\Type::nil();
			$xi = HashSet\Module::iterator($xs);
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
		 * @param HashSet\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(HashSet\Type $xs, Core\Type $ys) { // ==
			$type = $xs->__typeOf();
			if (($ys !== null) && ($ys instanceof $type)) {
				if (Int32\Module::eq($xs->size(), $ys->size())->unbox()) {
					return HashSet\Module::all($xs, function (Core\Type $x, Int32\Type $i) use ($ys) {
						return $ys->hasItem($x);
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
		 * @param HashSet\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(HashSet\Type $xs, Core\Type $ys) { // ===
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
		 * @param HashSet\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(HashSet\Type $xs, Core\Type $ys) { // !=
			return Bool\Module::not(HashSet\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(HashSet\Type $xs, Core\Type $ys) { // !==
			return Bool\Module::not(HashSet\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the left operand
		 * @param HashSet\Type $ys                                  the object to be compared
		 * @return Trit\Type                                        whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(HashSet\Type $xs, HashSet\Type $ys) {
			$x_length = $xs->__size();
			$y_length = $ys->__size();

			if ($x_length == $y_length) {
				$xi = HashSet\Module::iterator($xs);

				foreach ($xi as $x) {
					if (!$ys->__hasItem($x)) {
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
		 * @param HashSet\Type $xs                                  the left operand
		 * @param HashSet\Type $ys                                  the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(HashSet\Type $xs, HashSet\Type $ys) { // >=
			return Bool\Type::box(HashSet\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the left operand
		 * @param HashSet\Type $ys                                  the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(HashSet\Type $xs, HashSet\Type $ys) { // >
			return Bool\Type::box(HashSet\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the left operand
		 * @param HashSet\Type $ys                                  the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(HashSet\Type $xs, HashSet\Type $ys) { // <=
			return Bool\Type::box(HashSet\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the left operand
		 * @param HashSet\Type $ys                                  the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(HashSet\Type $xs, HashSet\Type $ys) { // <
			return Bool\Type::box(HashSet\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the left operand
		 * @param HashSet\Type $ys                                  the right operand
		 * @return HashSet\Type                                     the maximum value
		 */
		public static function max(HashSet\Type $xs, HashSet\Type $ys) {
			return (HashSet\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the left operand
		 * @param HashSet\Type $ys                                  the right operand
		 * @return HashSet\Type                                     the minimum value
		 */
		public static function min(HashSet\Type $xs, HashSet\Type $ys) {
			return (HashSet\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

	}

}