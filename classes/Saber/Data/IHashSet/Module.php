<?php

/**
 * Copyright 2014-2015 Blue Snowman
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

namespace Saber\Data\IHashISet {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IHashISet;
	use \Saber\Data\IInt32;
	use \Saber\Data\ILinkedList;
	use \Saber\Data\ISet;
	use \Saber\Data\ITrit;
	use \Saber\Data\ITuple;
	use \Saber\Data\IUnit;
	use \Saber\Throwable;

	final class Module extends Data\Module implements ISet\Module {

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the items in the list, yielding each
		 * item to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the hash set
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                        whether each item passed the
		 *                                                          truthy test
		 */
		public static function all(IHashISet\Type $xs, callable $predicate) {
			$xi = IHashISet\Module::iterator($xs);

			foreach ($xi as $i => $x) {
				if (!$predicate($x, $i)->unbox()) {
					return IBool\Type::false();
				}
			}

			return IBool\Type::true(); // yes, an empty array returns "true"
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the items in the list passed the truthy
		 * test.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the hash set
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                        whether some of the items
		 *                                                          passed the truthy test
		 */
		public static function any(IHashISet\Type $xs, callable $predicate) {
			$xi = IHashISet\Module::iterator($xs);

			foreach ($xi as $i => $x) {
				if ($predicate($x, $i)->unbox()) {
					return IBool\Type::true();
				}
			}

			return IBool\Type::false();
		}

		/**
		 * This method removes all entries from the hash set.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the hash set
		 * @return IHashISet\Type                                     the hash set
		 */
		public static function clear(IHashISet\Type $xs) {
			return IHashISet\Type::empty_();
		}

		/**
		 * This method returns a hash set which represents the symmetric difference between
		 * the two specified hash sets.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the first hash set
		 * @param IHashISet\Type $ys                                  the second hash set
		 * @return IHashISet\Type                                     a hash set which represents the symmetric
		 *                                                          difference of the two specified sets
		 */
		public static function difference(IHashISet\Type $xs, IHashISet\Type $ys) {
			$as = IHashISet\Module::union($xs, $ys);
			$bs = IHashISet\Module::intersection($xs, $ys);
			$cs = IHashISet\Module::without($as, $bs);
			return $cs;
		}

		/**
		 * This method returns a hash set of those items that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the hash set
		 * @param callable $predicate                               the predicate function to be used
		 * @return IHashISet\Type                                     the hash set
		 */
		public static function filter(IHashISet\Type $xs, callable $predicate) {
			$zs = IHashISet\Type::empty_();

			$xi = IHashISet\Module::iterator($xs);

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
		 * @param IHashISet\Type $xs                                  the hash set
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Type $initial                                the initial value to be used
		 * @return Core\Type                                        the result
		 */
		public static function fold(IHashISet\Type $xs, callable $operator, Core\Type $initial) {
			$xi = IHashISet\Module::iterator($xs);
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
		 * @param IHashISet\Type $xs                                  the hash set
		 * @param Core\Type $x                                      the item to be found
		 * @return IBool\Type                                        whether the item exists
		 */
		public static function hasItem(IHashISet\Type $xs, Core\Type $x) {
			return $xs->hasItem($x);
		}

		/**
		 * This method returns a hash set which represents the intersection between the two
		 * specified sets.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the first hash set
		 * @param IHashISet\Type $ys                                  the second hash set
		 * @return IHashISet\Type                                     a hash set which represents the intersection
		 *                                                          of the two specified hash sets
		 */
		public static function intersection(IHashISet\Type $xs, IHashISet\Type $ys) {
			$zs = IHashISet\Type::empty_();
			$yi = IHashISet\Module::iterator($ys);
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
		 * @param IHashISet\Type $xs                                  the hash set
		 * @return IBool\Type                                        whether the list is empty
		 */
		public static function isEmpty(IHashISet\Type $xs) {
			return $xs->isEmpty();
		}

		/**
		 * This method returns whether the second hash set is a subset of the first hash set.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the first hash set
		 * @param IHashISet\Type $ys                                  the second hash set
		 * @return IBool\Type                                        whether the second hash set is a
		 *                                                          subset of the first hash set
		 */
		public static function isSubset(IHashISet\Type $xs, IHashISet\Type $ys) {
			$yi = IHashISet\Module::iterator($ys);
			foreach ($yi as $y) {
				if (!$xs->__hasItem($y)) {
					return IBool\Type::false();
				}
			}
			return IBool\Type::true();
		}

		/**
		 * This method returns whether the second hash set is a superset of the first hash set.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the first hash set
		 * @param IHashISet\Type $ys                                  the second hash set
		 * @return IBool\Type                                        whether the second hash set is a
		 *                                                          superset of the first hash set
		 */
		public static function isSuperset(IHashISet\Type $xs, IHashISet\Type $ys) {
			$xi = IHashISet\Module::iterator($xs);
			foreach ($xi as $x) {
				if (!$ys->__hasItem($x)) {
					return IBool\Type::false();
				}
			}
			return IBool\Type::true();
		}

		/**
		 * This method returns all of the items in the hash set.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the hash set
		 * @return IArrayList\Type                                   all items in the hash set
		 */
		public static function items(IHashISet\Type $xs) {
			return $xs->items();
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the hash set
		 * @return IHashISet\Iterator                                 an iterator for this collection
		 */
		public static function iterator(IHashISet\Type $xs) {
			return new IHashISet\Iterator($xs);
		}

		/**
		 * This method applies each item in this hash set to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the hash set
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return IHashISet\Type                                     the hash set
		 */
		public static function map(IHashISet\Type $xs, callable $subroutine) {
			$zs = IHashISet\Type::empty_();

			$xi = IHashISet\Module::iterator($xs);

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
		 * @param IHashISet\Type $xs                                  the hash set to be partitioned
		 * @param callable $predicate                               the predicate function to be used
		 * @return ITuple\Type                                       the results
		 */
		public static function partition(IHashISet\Type $xs, callable $predicate) {
			$passed = IHashISet\Type::empty_();
			$failed = IHashISet\Type::empty_();

			$xi = IHashISet\Module::iterator($xs);

			foreach ($xi as $i => $x) {
				if ($predicate($x, $i)->unbox()) {
					$passed->putItem($x);
				}
				else {
					$failed->putItem($x);
				}
			}

			return ITuple\Type::box2($passed, $failed);
		}

		/**
		 * This method returns the power set of the specified hash set.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the hash set to be used
		 * @return IHashISet\Type                                     the power set
		 */
		public static function powerset(IHashISet\Type $xs) {
			$css = IHashISet\Type::empty_();
			$css->putItem(IHashISet\Type::empty_());
			$xi = IHashISet\Module::iterator($xs);
			foreach ($xi as $x) {
				$as = IHashISet\Type::empty_();
				$csi = IHashISet\Module::iterator($css);
				foreach ($csi as $cs) {
					$as->putItem($cs);
					$bs = IHashISet\Type::box($cs);
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
		 * @param IHashISet\Type $xs                                  the hash set
		 * @param Core\Type $x                                      the item to be stored
		 * @return IHashISet\Type                                     the hash set
		 */
		public static function putItem(IHashISet\Type $xs, Core\Type $x) {
			$zs = IHashISet\Type::box($xs->unbox());
			$zs->putItem($x);
			return $zs;
		}

		/**
		 * This method returns the hash set with the item removed.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the hash set
		 * @param Core\Type $x                                      the item to be removed
		 * @return IHashISet\Type                                     the hash set
		 */
		public static function removeItem(IHashISet\Type $xs, Core\Type $x) {
			$zs = IHashISet\Type::box($xs->unbox());
			$zs->removeItem($x);
			return $zs;
		}

		/**
		 * This method returns the size of this collection.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the hash set
		 * @return IInt32\Type                                       the size of this collection
		 */
		public static function size(IHashISet\Type $xs) {
			return $xs->size();
		}

		/**
		 * This method returns a hash set which represents the union of the two specified hash sets.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the first hash set
		 * @param IHashISet\Type $ys                                  the second hash set
		 * @return IHashISet\Type                                     a hash set which represents the union
		 *                                                          of the two specified hash sets
		 */
		public static function union(IHashISet\Type $xs, IHashISet\Type $ys) {
			$zs = IHashISet\Type::box($xs->unbox());
			$yi = IHashISet\Module::iterator($ys);
			foreach ($yi as $y) {
				$zs->putItem($y);
			}
			return $zs;
		}

		/**
		 * This method returns a hash set which represents the asymmetric difference between
		 * the two specified hash sets.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the first hash set
		 * @param IHashISet\Type $ys                                  the second hash set
		 * @return IHashISet\Type                                     a hash set which represents the (asymmetric)
		 *                                                          difference of the two specified hash sets
		 */
		public static function without(IHashISet\Type $xs, IHashISet\Type $ys) {
			$zs = IHashISet\Type::box($xs->unbox());
			$yi = IHashISet\Module::iterator($ys);
			foreach ($yi as $y) {
				$zs->removeItem($y);
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
		 * @param IHashISet\Type $xs                                  the value to be evaluated
		 * @param IHashISet\Type $ys                                  the default value
		 * @return IHashISet\Type                                     the result
		 */
		public static function nvl(IHashISet\Type $xs = null, IHashISet\Type $ys = null) {
			return ($xs !== null) ? $xs : (($ys !== null) ? $ys : IHashISet\Type::empty_());
		}

		/**
		 * This method returns the hash set as an array.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the operand
		 * @return IHashISet\Type                                     the hash set as an array list
		 */
		public static function toArrayList(IHashISet\Type $xs) {
			$buffer = array();
			$xi = IHashISet\Module::iterator($xs);
			foreach ($xi as $x) {
				$buffer[] = $x;
			}
			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the hash set as a linked list.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the operand
		 * @return ILinkedList\Type                                  the hash set as a linked list
		 */
		public static function toLinkedList(IHashISet\Type $xs) {
			$zs = ILinkedList\Type::nil();
			$xi = IHashISet\Module::iterator($xs);
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
		 * @param IHashISet\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(IHashISet\Type $xs, Core\Type $ys) { // ==
			$type = $xs->__typeOf();
			if (($ys !== null) && ($ys instanceof $type)) {
				if (IInt32\Module::eq($xs->size(), $ys->size())->unbox()) {
					return IHashISet\Module::all($xs, function (Core\Type $x, IInt32\Type $i) use ($ys) {
						return $ys->hasItem($x);
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
		 * @param IHashISet\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(IHashISet\Type $xs, Core\Type $ys) { // ===
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
		 * @param IHashISet\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(IHashISet\Type $xs, Core\Type $ys) { // !=
			return IBool\Module::not(IHashISet\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(IHashISet\Type $xs, Core\Type $ys) { // !==
			return IBool\Module::not(IHashISet\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the left operand
		 * @param IHashISet\Type $ys                                  the object to be compared
		 * @return ITrit\Type                                        whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(IHashISet\Type $xs, IHashISet\Type $ys) {
			$x_length = $xs->__size();
			$y_length = $ys->__size();

			if ($x_length == $y_length) {
				$xi = IHashISet\Module::iterator($xs);

				foreach ($xi as $x) {
					if (!$ys->__hasItem($x)) {
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
		 * @param IHashISet\Type $xs                                  the left operand
		 * @param IHashISet\Type $ys                                  the right operand
		 * @return IBool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(IHashISet\Type $xs, IHashISet\Type $ys) { // >=
			return IBool\Type::box(IHashISet\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the left operand
		 * @param IHashISet\Type $ys                                  the right operand
		 * @return IBool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(IHashISet\Type $xs, IHashISet\Type $ys) { // >
			return IBool\Type::box(IHashISet\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the left operand
		 * @param IHashISet\Type $ys                                  the right operand
		 * @return IBool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(IHashISet\Type $xs, IHashISet\Type $ys) { // <=
			return IBool\Type::box(IHashISet\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the left operand
		 * @param IHashISet\Type $ys                                  the right operand
		 * @return IBool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(IHashISet\Type $xs, IHashISet\Type $ys) { // <
			return IBool\Type::box(IHashISet\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the left operand
		 * @param IHashISet\Type $ys                                  the right operand
		 * @return IHashISet\Type                                     the maximum value
		 */
		public static function max(IHashISet\Type $xs, IHashISet\Type $ys) {
			return (IHashISet\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param IHashISet\Type $xs                                  the left operand
		 * @param IHashISet\Type $ys                                  the right operand
		 * @return IHashISet\Type                                     the minimum value
		 */
		public static function min(IHashISet\Type $xs, IHashISet\Type $ys) {
			return (IHashISet\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

	}

}