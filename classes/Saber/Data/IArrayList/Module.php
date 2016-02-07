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

namespace Saber\Data\IArrayList {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IHashMap;
	use \Saber\Data\IHashSet;
	use \Saber\Data\IInt32;
	use \Saber\Data\ILinkedList;
	use \Saber\Data\IOption;
	use \Saber\Data\ITrit;
	use \Saber\Data\ITuple;
	use \Saber\Data\IUnit;
	use \Saber\Data\IVector;
	use \Saber\Throwable;

	final class Module extends Data\Module implements IVector\Module {

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the items in the list, yielding each
		 * item to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                       whether each item passed the
		 *                                                          truthy test
		 */
		public static function all(IArrayList\Type $xs, callable $predicate) : IBool\Type {
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				if (!$predicate($xs->item($i), $i)->unbox()) {
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
		 * @param IArrayList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                       whether some of the items
		 *                                                          passed the truthy test
		 */
		public static function any(IArrayList\Type $xs, callable $predicate) : IBool\Type {
			return IOption\Module::isDefined(IArrayList\Module::find($xs, $predicate));
		}

		/**
		 * This method appends the specified object to this object's list.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param Core\Type $y                                      the object to be appended
		 * @return IArrayList\Type                                  the list
		 */
		public static function append(IArrayList\Type $xs, Core\Type $y) : IArrayList\Type {
			$buffer = $xs->unbox();
			$buffer[] = $y;
			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns a tuple where the first item contains longest prefix of the array
		 * list that does not satisfy the predicate and the second item contains the remainder.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the array list
		 * @param callable $predicate                               the predicate function to be used
		 * @return ITuple\Type                                      the tuple
		 */
		public static function break_(IArrayList\Type $xs, callable $predicate) : ITuple\Type {
			return IArrayList\Module::span($xs, function(Core\Type $x, IInt32\Type $i) use ($predicate) : IBool\Type {
				return IBool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method concatenates a list to this object's list.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param IArrayList\Type $ys                               the list to be concatenated
		 * @return IArrayList\Type                                  the list
		 */
		public static function concat(IArrayList\Type $xs, IArrayList\Type $ys) : IArrayList\Type {
			$buffer = $xs->unbox();
			foreach ($ys->unbox() as $y) {
				$buffer[] = $y;
			}
			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method evaluates whether the specified object is contained within the list.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param Core\Type $y                                      the object to find
		 * @return IBool\Type                                       whether the specified object is
		 *                                                          contained within the list
		 */
		public static function contains(IArrayList\Type $xs, Core\Type $y) : IBool\Type {
			return IArrayList\Module::any($xs, function(Core\Type $x, IInt32\Type $i) use ($y) : IBool\Type {
				return $x->eq($y);
			});
		}

		/**
		 * This method remove the first occurrence that equals the specified object.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param Core\Type $y                                      the object to be removed
		 * @return IArrayList\Type                                  the list
		 */
		public static function delete(IArrayList\Type $xs, Core\Type $y) : IArrayList\Type {
			$buffer = array();
			$skip = false;

			foreach ($xs->unbox() as $z) {
				if ($z->__eq($y) && !$skip) {
					$skip = true;
					continue;
				}
				$buffer[] = $z;
			}

			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the list after dropping the first "n" items.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param IInt32\Type $n                                    the number of items to drop
		 * @return IArrayList\Type                                  the list
		 */
		public static function drop(IArrayList\Type $xs, IInt32\Type $n) : IArrayList\Type {
			$buffer = array();
			$length = $xs->length();

			for ($i = $n; IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$buffer[] = $xs->item($i);
			}

			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the list from item where the predicate function fails.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IArrayList\Type                                  the list
		 */
		public static function dropWhile(IArrayList\Type $xs, callable $predicate) : IArrayList\Type {
			$buffer = array();
			$length = $xs->length();

			$failed = false;
			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$x = $xs->item($i);
				if (!$predicate($x, $i)->unbox() || $failed) {
					$buffer[] = $x;
					$failed = true;
				}
			}

			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the list from item where the predicate function doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IArrayList\Type                                  the list
		 */
		public static function dropWhileEnd(IArrayList\Type $xs, callable $predicate) : IArrayList\Type {
			return IArrayList\Module::dropWhile($xs, function(Core\Type $x, IInt32\Type $i) use ($predicate) : IBool\Type {
				return IBool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method iterates over the items in the list, yielding each item to the procedure
		 * function.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param callable $procedure                               the procedure function to be used
		 * @return IArrayList\Type                                  the list
		 */
		public static function each(IArrayList\Type $xs, callable $procedure) : IArrayList\Type {
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				IUnit\Type::covariant($procedure($xs->item($i), $i));
			}

			return $xs;
		}

		/**
		 * This method returns a list of those items that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IArrayList\Type                                  the list
		 */
		public static function filter(IArrayList\Type $xs, callable $predicate) : IArrayList\Type {
			$buffer = array();
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$x = $xs->item($i);
				if ($predicate($x, $i)->unbox()) {
					$buffer[] = $x;
				}
			}

			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the first object in the collection that passes the truthy test, if any.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IOption\Type                                     an option containing the first object
		 *                                                          satisfying the predicate, if any
		 */
		public static function find(IArrayList\Type $xs, callable $predicate) : IOption\Type {
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$x = $xs->item($i);
				if ($predicate($x, $i)->unbox()) {
					return IOption\Type::some($x);
				}
			}

			return IOption\Type::none();
		}

		/**
		 * This method returns the array list flattened.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @return IArrayList\Type                                  the flattened array list
		 */
		public static function flatten(IArrayList\Type $xs) : IArrayList\Type {
			$buffer = array();
			$x_length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $x_length)->unbox(); $i = IInt32\Module::increment($i)) {
				$x = $xs->item($i);
				if ($x instanceof IArrayList\Type) {
					$ys = IArrayList\Module::flatten($x);
					$y_length = $ys->length();
					for ($j = IInt32\Type::zero(); IInt32\Module::lt($j, $y_length)->unbox(); $j = IInt32\Module::increment($j)) {
						$buffer[] = $ys->item($j);
					}
				}
				else {
					$buffer[] = $x;
				}
			}

			return $buffer;
		}

		/**
		 * This method applies a left-fold reduction on the list using the operator function.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Type $initial                                the initial value to be used
		 * @return Core\Type                                        the result
		 */
		public static function foldLeft(IArrayList\Type $xs, callable $operator, Core\Type $initial) : Core\Type {
			$z = $initial;
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$z = $operator($z, $xs->item($i));
			}

			return $z;
		}

		/**
		 * This method applies a right-fold reduction on the list using the operation function.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Type $initial                                the initial value to be used
		 * @return Core\Type                                        the result
		 */
		public static function foldRight(IArrayList\Type $xs, callable $operator, Core\Type $initial) : Core\Type {
			$z = $initial;
			$length = $xs->length();

			for ($i = IInt32\Module::decrement($length); IInt32\Module::ge($i, IInt32\Type::zero())->unbox(); $i = IInt32\Module::decrement($i)) {
				$z = $operator($z, $xs->item($i));
			}

			return $z;
		}

		/**
		 * This method returns a hash map of lists of items that are considered in the same group.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the array list to be processed
		 * @param callable $subroutine                              the subroutine to be used
		 * @return IHashMap\Type                                    a hash map of lists of items that
		 *                                                          are considered in the same group
		 */
		public static function group(IArrayList\Type $xs, callable $subroutine) : IHashMap\Type {
			$groups = IHashMap\Type::empty_();

			IArrayList\Module::each($xs, function(Core\Type $x, IInt32\Type $i) use ($groups, $subroutine) {
				$key = $subroutine($x, $i);

				$item = ($groups->__hasKey($key))
					? $groups->item($key)->unbox()
					: array();

				$item[] = $x;

				$groups->putEntry($key, IArrayList\Type::box($item));
			});

			return $groups;
		}

		/**
		 * This method returns the head object in this list.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @return Core\Type                                        the head object in this list
		 */
		public static function head(IArrayList\Type $xs) : Core\Type {
			return $xs->item(IInt32\Type::zero());
		}

		/**
		 * This method returns an option using the head for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @return IOption\Type                                     the option
		 */
		public static function headOption(IArrayList\Type $xs) : IOption\Type {
			return ($xs->__isEmpty()) ? IOption\Type::none() : IOption\Type::some($xs->tail());
		}

		/**
		 * This method returns the index of the first occurrence of the object; otherwise, it returns -1;
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param Core\Type $y                                      the object to be searched for
		 * @return IInt32\Type                                      the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public static function indexOf(IArrayList\Type $xs, Core\Type $y) : IInt32\Type {
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$x = $xs->item($i);
				if ($x->__eq($y)) {
					return $i;
				}
			}

			return IInt32\Type::negative();
		}

		/**
		 * This method returns the index of the first occurrence that satisfies the predicate; otherwise,
		 * it returns -1;
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IInt32\Type                                      the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public static function indexWhere(IArrayList\Type $xs, callable $predicate) : IInt32\Type {
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				if ($predicate($xs->item($i), $i)->unbox()) {
					return $i;
				}
			}

			return IInt32\Type::negative();
		}

		/**
		 * This method returns all but the last item of in the list.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @return IArrayList\Type                                  the list, minus the last item
		 */
		public static function init(IArrayList\Type $xs) : IArrayList\Type {
			$buffer = array();
			$length = IInt32\Module::decrement($xs->length());

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$buffer[] = $xs->item($i);
			}

			return IArrayList\Type::box($buffer);
		}

		/**
		 * The method intersperses the specified object between each item in the list.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param Core\Type $y                                      the object to be interspersed
		 * @return IArrayList\Type                                  the list
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function intersperse(IArrayList\Type $xs, Core\Type $y) : IArrayList\Type {
			$buffer = array();
			$length = $xs->length();

			if ($length > 0) {
				$buffer[] = $xs->item(IInt32\Type::zero());
				for ($i = IInt32\Type::one(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
					$buffer[] = $y;
					$buffer[] = $xs->item($i);
				}
			}

			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @return IBool\Type                                       whether the list is empty
		 */
		public static function isEmpty(IArrayList\Type $xs) : IBool\Type {
			return $xs->isEmpty();
		}

		/**
		 * This method returns the item at the specified index.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param IInt32\Type $i                                    the index of the item
		 * @return Core\Type                                        the item at the specified index
		 * @throws Throwable\OutOfBounds\Exception                  indicates the specified index
		 *                                                          cannot be found
		 */
		public static function item(IArrayList\Type $xs, IInt32\Type $i) : Core\Type {
			return $xs->item($i);
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @return IArrayList\Iterator                              an iterator for this collection
		 */
		public static function iterator(IArrayList\Type $xs) : IArrayList\Iterator {
			return new IArrayList\Iterator($xs);
		}

		/**
		 * This method returns the last item in this list.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @return mixed                                            the last item in this linked
		 *                                                          list
		 */
		public static function last(IArrayList\Type $xs) {
			return $xs->item(IInt32\Module::decrement($xs->length()));
		}

		/**
		 * This method returns an option using the last for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @return IOption\Type                                     the option
		 */
		public static function lastOption(IArrayList\Type $xs) : IOption\Type {
			return ($xs->__isEmpty()) ? IOption\Type::none() : IOption\Type::some(IArrayList\Module::last($xs));
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @return IInt32\Type                                      the length of this array list
		 */
		public static function length(IArrayList\Type $xs) : IInt32\Type {
			return $xs->length();
		}

		/**
		 * This method returns an option containing the value paired with the lookup key x.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xss                              the left operand
		 * @param Core\Equality\Type $x                             the key being looked up
		 * @return IOption\Type                                     an option containing the associated
		 *                                                          value
		 * @throws Throwable\UnexpectedValue\Exception              indicates that the list is not
		 *                                                          associative
		 */
		public static function lookup(IArrayList\Type $xss, Core\Equality\Type $x) : IOption\Type {
			$length = $xss->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$zs = $xss->item($i);

				if (!ITuple\Module::isPair($zs)->unbox()) {
					throw new Throwable\UnexpectedValue\Exception('Unable to process tuple. Expected a length of "2", but got a length of ":length".', array(':length' => $zs->__length()));
				}

				if ($x->__eq(ITuple\Module::first($zs))) {
					return IOption\Type::some(ITuple\Module::second($zs));
				}
			}

			return IOption\Type::none();
		}

		/**
		 * This method applies each item in this list to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return IArrayList\Type                                  the list
		 */
		public static function map(IArrayList\Type $xs, callable $subroutine) : IArrayList\Type {
			$buffer = array();
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$buffer[] = $subroutine($xs->item($i), $i);
			}

			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method iterates over the items in the list, yielding each item to the
		 * predicate function, or fails the falsy test.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                       whether each item passed the
		 *                                                          falsy test
		 */
		public static function none(IArrayList\Type $xs, callable $predicate) : IBool\Type {
			return IArrayList\Module::all($xs, function(Core\Type $x, IInt32\Type $i) use ($predicate) : IBool\Type {
				return IBool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method returns an array list containing only unique items from the specified
		 * array list (i.e. duplicates are removed).
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the array list to be processed
		 * @return IArrayList\Type                                  an array list with the duplicates
		 *                                                          removed
		 */
		public static function nub(IArrayList\Type $xs) : IArrayList\Type {
			$zs = IHashSet\Type::empty_();

			return IArrayList\Module::filter($xs, function(Core\Type $x, IInt32\Type $i) use ($zs) : IBool\Type {
				if ($zs->__hasItem($x)) {
					return IBool\Type::false();
				}
				$zs->putItem($x);
				return IBool\Type::true();
			});
		}

		/**
		 * This method returns a pair of array lists: those items that satisfy the predicate and
		 * those items that do not satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the array list to be partitioned
		 * @param callable $predicate                               the predicate function to be used
		 * @return ITuple\Type                                      the results
		 */
		public static function partition(IArrayList\Type $xs, callable $predicate) : ITuple\Type {
			$passed = array();
			$failed = array();

			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$x = $xs->item($i);
				if ($predicate($x, $i)->unbox()) {
					$passed[] = $x;
				}
				else {
					$failed[] = $x;
				}
			}

			return ITuple\Type::box2(IArrayList\Type::box($passed), IArrayList\Type::box($failed));
		}

		/**
		 * This method returns a list of values matching the specified key.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xss                              the array list to be processed
		 * @param Core\Type $k                                      the key associated with value to be
		 *                                                          plucked
		 * @return IArrayList\Type                                  a list of values matching the specified
		 *                                                          key
		 */
		public static function pluck(IArrayList\Type $xss, Core\Type $k) : IArrayList\Type {
			return IArrayList\Module::map($xss, function(IHashMap\Type $xs, IInt32\Type $i) use ($k) : Core\Type {
				return $xs->item($k);
			});
		}

		/**
		 * This method prepends the specified object to the front of this list.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param Core\Type $y                                      the object to be prepended
		 * @return IArrayList\Type                                  the list
		 */
		public static function prepend(IArrayList\Type $xs, Core\Type $y) : IArrayList\Type {
			$buffer = $xs->unbox();
			array_unshift($buffer, $y);
			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the list within the specified range.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param IInt32\Type $start                                the starting index
		 * @param IInt32\Type $end                                  the ending index
		 * @return IArrayList\Type                                  the list
		 */
		public static function range(IArrayList\Type $xs, IInt32\Type $start, IInt32\Type $end) : IArrayList\Type {
			return IArrayList\Module::drop(IArrayList\Module::take($xs, $end), $start);
		}

		/**
		 * This method (aka "remove") returns an array list containing those items that do not
		 * satisfy the predicate.  Opposite of "filter".
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the array list
		 * @param callable $predicate                               the predicate function to be used
		 * @return IArrayList\Type                                  an array list containing those items
		 *                                                          that do not satisfy the predicate
		 */
		public static function reject(IArrayList\Type $xs, callable $predicate) : IArrayList\Type {
			return IArrayList\Module::filter($xs, function(Core\Type $x, IInt32\Type $i) use ($predicate) : IBool\Type {
				return IBool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method reverses the order of the items in this list.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @return IArrayList\Type                                  the list
		 */
		public static function reverse(IArrayList\Type $xs) : IArrayList\Type {
			return IArrayList\Type::box(array_reverse($xs->unbox()));
		}

		/**
		 * This method shuffles the items in the array list using the Fisher-Yates shuffle.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the array list to be shuffled
		 * @return IArrayList\Type                                  the shuffled array list
		 *
		 * @see http://en.wikipedia.org/wiki/Fisher%E2%80%93Yates_shuffle
		 */
		public static function shuffle(IArrayList\Type $xs) : IArrayList\Type {
			$buffer = $xs->unbox();
			$length = count($buffer);

			for ($i = $length - 1; $i > 0; $i--) {
				$j = rand(0, $i);
				$value = $buffer[$j];
				$buffer[$j] = $buffer[$i];
				$buffer[$i] = $value;
			}

			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the extracted slice of the list.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param IInt32\Type $offset                               the starting index
		 * @param IInt32\Type $length                               the length of the slice
		 * @return IArrayList\Type                                  the list
		 */
		public static function slice(IArrayList\Type $xs, IInt32\Type $offset, IInt32\Type $length) : IArrayList\Type {
			return IArrayList\Type::box(array_slice($xs->unbox(), $offset->unbox(), $length->unbox()));
		}

		/**
		 * This method returns a tuple where the first item contains longest prefix of the array
		 * list that satisfies the predicate and the second item contains the remainder.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the array list
		 * @param callable $predicate                               the predicate function to be used
		 * @return ITuple\Type                                      the tuple
		 */
		public static function span(IArrayList\Type $xs, callable $predicate) : ITuple\Type {
			return ITuple\Type::box2(
				IArrayList\Module::takeWhile($xs, $predicate),
				IArrayList\Module::dropWhile($xs, $predicate)
			);
		}

		/**
		 * This method returns a tuple where the first item contains the first "n" items
		 * in the array list and the second item contains the remainder.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the array list
		 * @param IInt32\Type $n                                    the number of items to take
		 * @return ITuple\Type                                      the tuple
		 */
		public static function split(IArrayList\Type $xs, IInt32\Type $n) : ITuple\Type {
			return ITuple\Type::box2(
				IArrayList\Module::take($xs, $n),
				IArrayList\Module::drop($xs, $n)
			);
		}

		/**
		 * This method returns the tail of this list.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @return IArrayList\Type                                  the tail of this list
		 */
		public static function tail(IArrayList\Type $xs) : IArrayList\Type {
			return $xs->tail();
		}

		/**
		 * This method returns an option using the tail for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @return IOption\Type                                     the option
		 */
		public static function tailOption(IArrayList\Type $xs) : IOption\Type {
			return ($xs->__isEmpty()) ? IOption\Type::none() : IOption\Type::some($xs->tail());
		}

		/**
		 * This method returns the first "n" items in the list.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param IInt32\Type $n                                    the number of items to take
		 * @return IArrayList\Type                                  the list
		 */
		public static function take(IArrayList\Type $xs, IInt32\Type $n) : IArrayList\Type {
			$buffer = array();
			$length = IInt32\Module::min($n, $xs->length());

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$buffer[] = $xs->item($i);
			}

			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns each item in this list until the predicate fails.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IArrayList\Type                                  the list
		 */
		public static function takeWhile(IArrayList\Type $xs, callable $predicate) : IArrayList\Type {
			$buffer = array();
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$x = $xs->item($i);
				if (!$predicate($x, $i)->unbox()) {
					break;
				}
				$buffer[] = $x;
			}

			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns each item in this list until the predicate doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IArrayList\Type                                  the list
		 */
		public static function takeWhileEnd(IArrayList\Type $xs, callable $predicate) : IArrayList\Type {
			return IArrayList\Module::takeWhile($xs, function(Core\Type $x, IInt32\Type $i) use ($predicate) : IBool\Type {
				return IBool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method returns a tuple of two (or more) array lists after splitting an array list of
		 * tuple groupings.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xss                              an array list of tuple groupings
		 * @return ITuple\Type                                      a tuple of two (or more) array lists
		 */
		public static function unzip(IArrayList\Type $xss) : ITuple\Type {
			$as = array();
			$bs = array();

			$length = $xss->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$xs = $xss->item($i);
				$as[] = $xs->first();
				$bs[] = $xs->second();
			}

			return ITuple\Type::box2(IArrayList\Type::box($as), IArrayList\Type::box($bs));
		}

		/**
		 * This method returns a new list of tuple pairings.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param IArrayList\Type $ys                               the right operand
		 * @return IArrayList\Type                                  a new list of tuple pairings
		 */
		public static function zip(IArrayList\Type $xs, IArrayList\Type $ys) : IArrayList\Type {
			$buffer = array();
			$length = IInt32\Module::min($xs->length(), $ys->length());

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$buffer[] = ITuple\Type::box2($xs->item($i), $ys->item($i));
			}

			return IArrayList\Type::box($buffer);
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the value to be evaluated
		 * @param IArrayList\Type $ys                               the default value
		 * @return IArrayList\Type                                  the result
		 */
		public static function nvl(IArrayList\Type $xs = null, IArrayList\Type $ys = null) : IArrayList\Type {
			return $xs ?? $ys ?? IArrayList\Type::empty_();
		}

		/**
		 * This method returns the collection as an array.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the operand
		 * @return IArrayList\Type                                  the collection as an array list
		 */
		public static function toArrayList(IArrayList\Type $xs) : IArrayList\Type {
			return $xs;
		}

		/**
		 * This method returns the collection as a linked list.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the operand
		 * @return ILinkedList\Type                                 the collection as a linked list
		 */
		public static function toLinkedList(IArrayList\Type $xs) : ILinkedList\Type {
			$length = $xs->length();
			$zs = ILinkedList\Type::nil();
			for ($i = IInt32\Module::decrement($length); IInt32\Module::ge($i, IInt32\Type::zero())->unbox(); $i = IInt32\Module::decrement($i)) {
				$zs = ILinkedList\Type::cons($xs->item($i), $zs);
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
		 * @param IArrayList\Type $xs                               the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(IArrayList\Type $xs, Core\Type $ys) : IBool\Type { // ==
			$type = $xs->__typeOf();
			if ($ys instanceof $type) {
				$x_length = $xs->__length();
				$y_length = $ys->__length();

				for ($i = 0; ($i < $x_length) && ($i < $y_length); $i++) {
					$p = IInt32\Type::box($i);
					$r = $xs->item($p)->eq($ys->item($p));
					if (!$r->unbox()) {
						return $r;
					}
				}

				return IBool\Type::box($x_length == $y_length);
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(IArrayList\Type $xs, Core\Type $ys) : IBool\Type { // ===
			if ($ys !== null) {
				if ($xs->__typeOf() === $ys->__typeOf()) {
					$x_length = $xs->__length();
					$y_length = $ys->__length();

					for ($i = 0; ($i < $x_length) && ($i < $y_length); $i++) {
						$p = IInt32\Type::box($i);
						$r = $xs->item($p)->id($ys->item($p));
						if (!$r->unbox()) {
							return $r;
						}
					}

					return IBool\Type::box($x_length == $y_length);
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(IArrayList\Type $xs, Core\Type $ys) : IBool\Type { // !=
			return IBool\Module::not(IArrayList\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(IArrayList\Type $xs, Core\Type $ys) : IBool\Type { // !==
			return IBool\Module::not(IArrayList\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param IArrayList\Type $ys                               the object to be compared
		 * @return ITrit\Type                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(IArrayList\Type $xs, IArrayList\Type $ys) : ITrit\Type {
			$x_length = $xs->__length();
			$y_length = $ys->__length();

			for ($i = 0; ($i < $x_length) && ($i < $y_length); $i++) {
				$p = IInt32\Type::box($i);
				$r = $xs->item($p)->compare($ys->item($p));
				if ($r->unbox() != 0) {
					return $r;
				}
			}

			if ($x_length < $y_length) {
				return ITrit\Type::negative();
			}
			else if ($x_length == $y_length) {
				return ITrit\Type::zero();
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
		 * @param IArrayList\Type $xs                               the left operand
		 * @param IArrayList\Type $ys                               the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(IArrayList\Type $xs, IArrayList\Type $ys) : IBool\Type { // >=
			return IBool\Type::box(IArrayList\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param IArrayList\Type $ys                               the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(IArrayList\Type $xs, IArrayList\Type $ys) : IBool\Type { // >
			return IBool\Type::box(IArrayList\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param IArrayList\Type $ys                               the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(IArrayList\Type $xs, IArrayList\Type $ys) : IBool\Type { // <=
			return IBool\Type::box(IArrayList\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param IArrayList\Type $ys                               the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(IArrayList\Type $xs, IArrayList\Type $ys) : IBool\Type { // <
			return IBool\Type::box(IArrayList\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param IArrayList\Type $ys                               the right operand
		 * @return IArrayList\Type                                  the maximum value
		 */
		public static function max(IArrayList\Type $xs, IArrayList\Type $ys) : IArrayList\Type {
			return (IArrayList\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @param IArrayList\Type $ys                               the right operand
		 * @return IArrayList\Type                                  the minimum value
		 */
		public static function min(IArrayList\Type $xs, IArrayList\Type $ys) : IArrayList\Type {
			return (IArrayList\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

		#region Methods -> Logical Operations

		/**
		 * This method (aka "true") returns whether all of the items of the list evaluate
		 * to true.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @return IBool\Type                                       whether all of the items of
		 *                                                          the list evaluate to true
		 */
		public static function and_(IArrayList\Type $xs) : IBool\Type {
			return IArrayList\Module::all($xs, function(IBool\Type $x, IInt32\Type $i) : IBool\Type {
				return $x;
			});
		}

		/**
		 * This method returns whether any of the items of the list evaluate to true.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                               the left operand
		 * @return IBool\Type                                       whether all of the items of
		 *                                                          the list evaluate to false
		 */
		public static function or_(IArrayList\Type $xs) : IBool\Type {
			return IArrayList\Module::any($xs, function(IBool\Type $x, IInt32\Type $i) : IBool\Type {
				return $x;
			});
		}

		#endregion

	}

}