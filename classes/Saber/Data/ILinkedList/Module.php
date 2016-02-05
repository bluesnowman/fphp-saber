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

namespace Saber\Data\ILinkedList {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\ICollection;
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
		 * This method (aka "every" or "forall") iterates over the items in the collection, yielding each
		 * item to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                       whether each item passed the
		 *                                                          truthy test
		 */
		public static function all(ILinkedList\Type $xs, callable $predicate) : IBool\Type {
			$i = IInt32\Type::zero();

			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				$z = ILinkedList\Module::head($zs, $i);
				if (!$predicate($z, $i)->unbox()) {
					return IBool\Type::false();
				}
				$i = IInt32\Module::increment($i);
			}

			return IBool\Type::true(); // yes, an empty list returns "true"
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the items in the collection
		 * passed the truthy test.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                       whether some of the items
		 *                                                          passed the truthy test
		 */
		public static function any(ILinkedList\Type $xs, callable $predicate) : IBool\Type {
			return IOption\Module::isDefined(ILinkedList\Module::find($xs, $predicate));
		}

		/**
		 * This method appends the specified object to this object's collection. Performs in O(n) time.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param Core\Type $y                                      the object to be appended
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function append(ILinkedList\Type $xs, Core\Type $y) : ILinkedList\Type {
			return ILinkedList\Module::concat($xs, ILinkedList\Type::cons($y));
		}

		/**
		 * This method returns a tuple where the first item contains longest prefix of the linked
		 * list that does not satisfy the predicate and the second item contains the remainder.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the linked list
		 * @param callable $predicate                               the predicate function to be used
		 * @return ITuple\Type                                      the tuple
		 */
		public static function break_(ILinkedList\Type $xs, callable $predicate) : ITuple\Type {
			return ILinkedList\Module::span($xs, function(Core\Type $x, IInt32\Type $i) use ($predicate) : IBool\Type {
				return IBool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method concatenates a collection to this object's collection. Performs in O(n) time.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param ILinkedList\Type $ys                              the collection to be concatenated
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function concat(ILinkedList\Type $xs, ILinkedList\Type $ys) : ILinkedList\Type {
			if (!$xs->__isEmpty()) {
				$zs = $xs;
				while (!$zs->tail()->__isEmpty()) {
					$zs = $zs->tail();
				}
				$zs->tail = $ys;
				return $xs;
			}
			return $ys;
		}

		/**
		 * This method evaluates whether the specified object is contained within the collection.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param Core\Type $y                                      the object to find
		 * @return IBool\Type                                       whether the specified object is
		 *                                                          contained within the collection
		 */
		public static function contains(ILinkedList\Type $xs, Core\Type $y) : IBool\Type {
			return ILinkedList\Module::any($xs, function(Core\Type $x, IInt32\Type $i) use ($y) : IBool\Type {
				return $x->eq($y);
			});
		}

		/**
		 * This method remove the first occurrence that equals the specified object.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param Core\Type $y                                      the object to be removed
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function delete(ILinkedList\Type $xs, Core\Type $y) : ILinkedList\Type {
			$start = ILinkedList\Type::nil();
			$tail = null;

			$index = IInt32\Type::zero();
			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				$head = $zs->head();
				if (!$head->__eq($y)) {
					$cons = ILinkedList\Type::cons($head);

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
				$index = IInt32\Module::increment($index);
			}

			return $start;
		}

		/**
		 * This method returns the collection after dropping the first "n" items.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param IInt32\Type $n                                    the number of items to drop
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function drop(ILinkedList\Type $xs, IInt32\Type $n) : ILinkedList\Type {
			$i = IInt32\Type::zero();

			for ($zs = $xs; ($i->unbox() < $n->unbox()) && !$zs->__isEmpty(); $zs = $zs->tail()) {
				$i = IInt32\Module::increment($i);
			}

			return $zs;
		}

		/**
		 * This method returns the collection from item where the predicate function fails.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function dropWhile(ILinkedList\Type $xs, callable $predicate) : ILinkedList\Type {
			$i = IInt32\Type::zero();

			for ($zs = $xs; !$zs->__isEmpty() && $predicate($zs->head(), $i)->unbox(); $zs = $zs->tail()) {
				$i = IInt32\Module::increment($i);
			}

			return $zs;
		}

		/**
		 * This method returns the collection from item where the predicate function doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function dropWhileEnd(ILinkedList\Type $xs, callable $predicate) : ILinkedList\Type {
			return ILinkedList\Module::dropWhile($xs, function(Core\Type $x, IInt32\Type $i) use ($predicate) : IBool\Type {
				return IBool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method iterates over the items in the collection, yielding each item to the
		 * callback function.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param callable $procedure                               the procedure function to be used
		 */
		public static function each(ILinkedList\Type $xs, callable $procedure) {
			for ($i = IInt32\Type::zero(), $zs = $xs; !$zs->__isEmpty(); $i = IInt32\Module::increment($i), $zs = $zs->tail()) {
				IUnit\Type::covariant($procedure($zs->head(), $i));
			}
		}

		/**
		 * This method returns a collection of those items that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function filter(ILinkedList\Type $xs, callable $predicate) : ILinkedList\Type {
			$start = ILinkedList\Type::nil();
			$tail = null;

			$i = IInt32\Type::zero();
			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				$z = $zs->head();
				if ($predicate($z, $i)->unbox()) {
					$ys = ILinkedList\Type::cons($z);

					if ($tail !== null) {
						$tail->tail = $ys;
					}
					else {
						$start = $ys;
					}

					$tail = $ys;
				}
				$i = IInt32\Module::increment($i);
			}

			return $start;
		}

		/**
		 * This method returns the first object in the collection that passes the truthy test, if any.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IOption\Type                                     an option containing the first object
		 *                                                          satisfying the predicate, if any
		 */
		public static function find(ILinkedList\Type $xs, callable $predicate) : IOption\Type {
			$i = IInt32\Type::zero();

			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				$z = $zs->head();
				if ($predicate($z, $i)->unbox()) {
					return IOption\Type::some($z);
				}
				$i = IInt32\Module::increment($i);
			}

			return IOption\Type::none();
		}

		/**
		 * This method returns the linked list flattened.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @return ILinkedList\Type                                 the flattened linked list
		 */
		public static function flatten(ILinkedList\Type $xs) : ILinkedList\Type {
			$start = ILinkedList\Type::nil();
			$tail = null;

			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				$z = $zs->head();

				$ys = ($z instanceof ICollection\Type)
					? ILinkedList\Module::toLinkedList(ILinkedList\Module::flatten($z))
					: ILinkedList\Type::cons($z);

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
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Type $initial                                the initial value to be used
		 * @return Core\Type                                        the result
		 */
		public static function foldLeft(ILinkedList\Type $xs, callable $operator, Core\Type $initial) : Core\Type {
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
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Type $initial                                the initial value to be used
		 * @return Core\Type                                        the result
		 */
		public static function foldRight(ILinkedList\Type $xs, callable $operator, Core\Type $initial) : Core\Type {
			$z = $initial;

			if ($xs->__isEmpty()) {
				return $z;
			}

			return $operator($xs->head(), ILinkedList\Module::foldRight($xs->tail(), $operator, $z));
		}

		/**
		 * This method returns the head object in this collection.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @return Core\Type                                        the head object in this linked
		 *                                                          collection
		 */
		public static function head(ILinkedList\Type $xs) : Core\Type {
			return $xs->head();
		}

		/**
		 * This method returns an option using the head for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @return IOption\Type                                     the option
		 */
		public static function headOption(ILinkedList\Type $xs) : IOption\Type {
			return (!$xs->__isEmpty()) ? IOption\Type::some($xs->head()) : IOption\Type::none();
		}

		/**
		 * This method returns the index of the first occurrence of the object; otherwise, it returns -1;
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param Core\Type $y                                      the object to be searched for
		 * @return IInt32\Type                                      the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public static function indexOf(ILinkedList\Type $xs, Core\Type $y) : IInt32\Type {
			for ($i = 0, $zs = $xs; !$zs->__isEmpty(); $i++, $zs = $zs->tail()) {
				$z = $zs->head();
				if ($z->__eq($y)) {
					return IInt32\Type::box($i);
				}
			}
			return IInt32\Type::negative();
		}

		/**
		 * This method returns all but the last item of in the collection.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @return ILinkedList\Type                                 the collection, minus the last
		 *                                                          item
		 */
		public static function init(ILinkedList\Type $xs) : ILinkedList\Type {
			$start = ILinkedList\Type::nil();
			$tail = null;

			for ($zs = $xs; !$zs->__isEmpty() && !$zs->tail()->__isEmpty(); $zs = $zs->tail()) {
				$ys = ILinkedList\Type::cons($zs->head());

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
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param Core\Type $y                                      the object to be interspersed
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function intersperse(ILinkedList\Type $xs, Core\Type $y) : ILinkedList\Type {
			return ($xs->__isEmpty() || $xs->tail()->__isEmpty())
				? $xs
				: ILinkedList\Type::cons($xs->head(), ILinkedList\Type::cons($y, ILinkedList\Module::intersperse($xs->tail(), $y)));
		}

		/**
		 * This method (aka "null") returns whether this collection is empty.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @return IBool\Type                                       whether the collection is empty
		 */
		public static function isEmpty(ILinkedList\Type $xs) : IBool\Type {
			return $xs->isEmpty();
		}

		/**
		 * This method returns the item at the specified index.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param IInt32\Type $i                                    the index of the item
		 * @return Core\Type                                        the item at the specified index
		 * @throws Throwable\OutOfBounds\Exception                  indicates the specified index
		 *                                                          cannot be found
		 */
		public static function item(ILinkedList\Type $xs, IInt32\Type $i) : Core\Type {
			return $xs->item($i);
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @return ILinkedList\Iterator                             an iterator for this collection
		 */
		public static function iterator(ILinkedList\Type $xs) : ILinkedList\Iterator {
			return new ILinkedList\Iterator($xs);
		}

		/**
		 * This method returns the last item in this collection.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @return Core\Type                                        the last item in this collection
		 */
		public static function last(ILinkedList\Type $xs) : Core\Type {
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
		 * @param ILinkedList\Type $xs                              the left operand
		 * @return IOption\Type                                     the option
		 */
		public static function lastOption(ILinkedList\Type $xs) : IOption\Type {
			return (!$xs->__isEmpty()) ? IOption\Type::some(ILinkedList\Module::last($xs)) : IOption\Type::none();
		}

		/**
		 * This method returns the length of this collection. Performs in O(n) time.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @return IInt32\Type                                      the length of this collection
		 */
		public static function length(ILinkedList\Type $xs) : IInt32\Type {
			return $xs->length();
		}

		/**
		 * This method returns an option containing the value paired with the lookup key x.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xss                             the left operand
		 * @param Core\Equality\Type $x                             the key being looked up
		 * @return IOption\Type                                     an option containing the associated
		 *                                                          value
		 * @throws Throwable\UnexpectedValue\Exception              indicates that the list is not
		 *                                                          associative
		 */
		public static function lookup(ILinkedList\Type $xss, Core\Equality\Type $x) : IOption\Type {
			if ($xss->__isEmpty()) {
				return IOption\Type::none();
			}

			$xs = $xss->head();

			if (!ITuple\Module::isPair($xs)->unbox()) {
				throw new Throwable\UnexpectedValue\Exception('Unable to process tuple. Expected a length of "2", but got a length of ":length".', array(':length' => $xs->__length()));
			}

			if ($x->__eq(ITuple\Module::first($xs))) {
				return IOption\Type::some(ITuple\Module::second($xs));
			}

			return ILinkedList\Module::lookup($xss->tail(), $x);
		}

		/**
		 * This method applies each item in this collection to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function map(ILinkedList\Type $xs, callable $subroutine) : ILinkedList\Type {
			$start = ILinkedList\Type::nil();
			$tail = null;

			$i = IInt32\Type::zero();
			for ($zs = $xs; !$zs->__isEmpty(); $zs = $zs->tail()) {
				$ys = ILinkedList\Type::cons($subroutine($zs->head(), $i));

				if ($tail !== null) {
					$tail->tail = $ys;
				}
				else {
					$start = $ys;
				}

				$tail = $ys;
				$i = IInt32\Module::increment($i);
			}

			return $start;
		}

		/**
		 * This method iterates over the items in the collection, yielding each item to the
		 * predicate function, or fails the falsy test.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                       whether each item passed the
		 *                                                          falsy test
		 */
		public static function none(ILinkedList\Type $xs, callable $predicate) : IBool\Type {
			return ILinkedList\Module::all($xs, function(Core\Type $x, IInt32\Type $i) use ($predicate) : IBool\Type {
				return IBool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method returns a linked list containing only unique items from the specified
		 * linked list (i.e. duplicates are removed).
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the linked list to be processed
		 * @return ILinkedList\Type                                 an linked list with the duplicates
		 *                                                          removed
		 */
		public static function nub(ILinkedList\Type $xs) : ILinkedList\Type {
			$zs = IHashSet\Type::empty_();

			return ILinkedList\Module::filter($xs, function(Core\Type $x, IInt32\Type $i) use ($zs) : IBool\Type {
				if ($zs->__hasItem($x)) {
					return IBool\Type::false();
				}
				$zs->putItem($x);
				return IBool\Type::true();
			});
		}

		/**
		 * This method returns a pair of linked lists: those items that satisfy the predicate and
		 * those items that do not satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the linked list to be partitioned
		 * @param callable $predicate                               the predicate function to be used
		 * @return ITuple\Type                                      the results
		 */
		public static function partition(ILinkedList\Type $xs, callable $predicate) : ITuple\Type {
			return ITuple\Type::box2(
				ILinkedList\Module::filter($xs, $predicate),
				ILinkedList\Module::reject($xs, $predicate)
			);
		}

		/**
		 * This method returns a linked list of values matching the specified key.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xss                             the linked list to be processed
		 * @param Core\Type $k                                      the key associated with value to be
		 *                                                          plucked
		 * @return ILinkedList\Type                                 a list of values matching the specified
		 *                                                          key
		 */
		public static function pluck(ILinkedList\Type $xss, Core\Type $k) : ILinkedList\Type {
			return ILinkedList\Module::map($xss, function(IHashMap\Type $xs, IInt32\Type $i) use ($k) : Core\Type {
				return $xs->item($k);
			});
		}

		/**
		 * This method prepends the specified object to the front of this collection.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param Core\Type $y                                      the object to be prepended
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function prepend(ILinkedList\Type $xs, Core\Type $y) : ILinkedList\Type {
			return ILinkedList\Type::cons($y, $xs);
		}

		/**
		 * This method returns the collection within the specified range.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param IInt32\Type $start                                the starting index
		 * @param IInt32\Type $end                                  the ending index
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function range(ILinkedList\Type $xs, IInt32\Type $start, IInt32\Type $end) : ILinkedList\Type {
			return ILinkedList\Module::drop(ILinkedList\Module::take($xs, $end), $start);
		}

		/**
		 * This method (aka "remove") returns a linked list containing those items that do not
		 * satisfy the predicate.  Opposite of "filter".
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the linked list
		 * @param callable $predicate                               the predicate function to be used
		 * @return ILinkedList\Type                                 a linked list containing those items
		 *                                                          that do not satisfy the predicate
		 */
		public static function reject(ILinkedList\Type $xs, callable $predicate) : ILinkedList\Type {
			return ILinkedList\Module::filter($xs, function(Core\Type $x, IInt32\Type $i) use ($predicate) : IBool\Type {
				return IBool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method reverses the order of the items in this collection.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function reverse(ILinkedList\Type $xs) : ILinkedList\Type {
			return ILinkedList\Module::foldLeft($xs, function(ILinkedList\Type $tail, Core\Type $head) : ILinkedList\Type {
				return ILinkedList\Type::cons($head, $tail);
			}, ILinkedList\Type::nil());
		}

		/**
		 * This method shuffles the items in the linked list using the Fisher-Yates shuffle.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the linked list to be shuffled
		 * @return ILinkedList\Type                                 the shuffled linked list
		 *
		 * @see http://en.wikipedia.org/wiki/Fisher%E2%80%93Yates_shuffle
		 */
		public static function shuffle(ILinkedList\Type $xs) : ILinkedList\Type {
			$buffer = $xs->unbox();
			$length = count($buffer);

			for ($i = $length - 1; $i > 0; $i--) {
				$j = rand(0, $i);
				$value = $buffer[$j];
				$buffer[$j] = $buffer[$i];
				$buffer[$i] = $value;
			}

			return ILinkedList\Type::box($buffer);
		}

		/**
		 * This method returns the extracted slice of the collection.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param IInt32\Type $offset                               the starting index
		 * @param IInt32\Type $length                               the length of the slice
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function slice(ILinkedList\Type $xs, IInt32\Type $offset, IInt32\Type $length) : ILinkedList\Type {
			return ILinkedList\Module::drop(ILinkedList\Module::take($xs, IInt32\Module::add($length, $offset)), $offset);
		}

		/**
		 * This method returns a tuple where the first item contains longest prefix of the linked
		 * list that satisfies the predicate and the second item contains the remainder.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the linked list
		 * @param callable $predicate                               the predicate function to be used
		 * @return ITuple\Type                                      the tuple
		 */
		public static function span(ILinkedList\Type $xs, callable $predicate) : ITuple\Type {
			return ITuple\Type::box2(
				ILinkedList\Module::takeWhile($xs, $predicate),
				ILinkedList\Module::dropWhile($xs, $predicate)
			);
		}

		/**
		 * This method returns a tuple where the first item contains the first "n" items
		 * in the linked list and the second item contains the remainder.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the linked list
		 * @param IInt32\Type $n                                    the number of items to take
		 * @return ITuple\Type                                      the tuple
		 */
		public static function split(ILinkedList\Type $xs, IInt32\Type $n) : ITuple\Type {
			return ITuple\Type::box2(
				ILinkedList\Module::take($xs, $n),
				ILinkedList\Module::drop($xs, $n)
			);
		}

		/**
		 * This method returns the tail of this list.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @return ILinkedList\Type                                 the tail of this list
		 */
		public static function tail(ILinkedList\Type $xs) : ILinkedList\Type {
			return $xs->tail();
		}

		/**
		 * This method returns the first "n" items in the collection.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param IInt32\Type $n                                    the number of items to take
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function take(ILinkedList\Type $xs, IInt32\Type $n) : ILinkedList\Type {
			if (($n->unbox() <= 0) || $xs->__isEmpty()) {
				return ILinkedList\Type::nil();
			}
			return ILinkedList\Type::cons($xs->head(), ILinkedList\Module::take($xs->tail(), IInt32\Module::decrement($n)));
		}

		/**
		 * This method returns each item in this collection until the predicate fails.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function takeWhile(ILinkedList\Type $xs, callable $predicate) : ILinkedList\Type {
			$start = ILinkedList\Type::nil();
			$tail = null;

			$taking = true;

			$i = IInt32\Type::zero();
			for ($zs = $xs; !$zs->__isEmpty() && $taking; $zs = $zs->tail()) {
				$z = $zs->head();

				if ($predicate($z, $i)->unbox()) {
					$ys = ILinkedList\Type::cons($z);

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

				$i = IInt32\Module::increment($i);
			}

			return $start;
		}

		/**
		 * This method returns each item in this collection until the predicate doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function takeWhileEnd(ILinkedList\Type $xs, callable $predicate) : ILinkedList\Type {
			return ILinkedList\Module::takeWhile($xs, function(Core\Type $x, IInt32\Type $i) use ($predicate) : IBool\Type {
				return IBool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method returns a tuple of two (or more) linked lists after splitting a linked list of
		 * tuple groupings.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xss                             a linked list of tuple groupings
		 * @return ITuple\Type                                      a tuple of two (or more) linked lists
		 */
		public static function unzip(ILinkedList\Type $xss) : ITuple\Type {
			$as = array();
			$bs = array();

			ILinkedList\Module::each($xss, function(ITuple\Type $xs, IInt32\Type $i) use (&$as, &$bs) {
				$as[] = $xs->first();
				$bs[] = $xs->second();
			});

			return ITuple\Type::box2(ILinkedList\Type::box($as), ILinkedList\Type::box($bs));
		}

		/**
		 * This method returns a new list of tuple pairings.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param ILinkedList\Type $ys                              the right operand
		 * @return ILinkedList\Type                                 a new list of tuple pairings
		 */
		public static function zip(ILinkedList\Type $xs, ILinkedList\Type $ys) : ILinkedList\Type {
			$start = ILinkedList\Type::nil();
			$tail = null;

			for ($as = $xs, $bs = $ys; !$as->__isEmpty() && !$bs->__isEmpty(); $as = $as->tail(), $bs = $bs->tail()) {
				$tuple = ITuple\Type::box2($as->head(), $bs->head());

				$cons = ILinkedList\Type::cons($tuple);

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
		 * @param ILinkedList\Type $xs                              the value to be evaluated
		 * @param ILinkedList\Type $ys                              the default value
		 * @return ILinkedList\Type                                 the result
		 */
		public static function nvl(ILinkedList\Type $xs = null, ILinkedList\Type $ys = null) : ILinkedList\Type {
			return $xs ?? $ys ?? ILinkedList\Type::empty_();
		}

		/**
		 * This method returns the collection as an array.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the operand
		 * @return IArrayList\Type                                  the collection as an array list
		 */
		public static function toArrayList(ILinkedList\Type $xs) : IArrayList\Type {
			$buffer = array();
			ILinkedList\Module::each($xs, function(Core\Type $x) use ($buffer) {
				$buffer[] = $x;
			});
			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the collection as a linked list.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the operand
		 * @return ILinkedList\Type                                 the collection as a linked list
		 */
		public static function toLinkedList(ILinkedList\Type $xs) : ILinkedList\Type {
			return $xs;
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(ILinkedList\Type $xs, Core\Type $ys) : IBool\Type { // ==
			if ($ys instanceof ILinkedList\Type) {
				for ($as = $xs, $bs = $ys; !$as->__isEmpty() && !$bs->__isEmpty(); $as = $as->tail(), $bs = $bs->tail()) {
					$r = $as->head()->eq($bs->head());
					if (!$r->unbox()) {
						return $r;
					}
				}

				$x_length = $xs->__length();
				$y_length = $ys->__length();

				if ($x_length == $y_length) {
					return IBool\Type::true();
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(ILinkedList\Type $xs, Core\Type $ys) : IBool\Type { // ===
			if (($ys !== null) && ($xs->__typeOf() == $ys->typeOf())) {
				for ($as = $xs, $bs = $ys; !$as->__isEmpty() && !$bs->__isEmpty(); $as = $as->tail(), $bs = $bs->tail()) {
					$r = $as->head()->id($bs->head());
					if (!$r->unbox()) {
						return $r;
					}
				}

				$x_length = $xs->__length();
				$y_length = $ys->__length();

				if ($x_length == $y_length) {
					return IBool\Type::true();
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(ILinkedList\Type $xs, Core\Type $ys) : IBool\Type { // !=
			return IBool\Module::not(ILinkedList\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(ILinkedList\Type $xs, Core\Type $ys) : IBool\Type { // !==
			return IBool\Module::not(ILinkedList\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param ILinkedList\Type $ys                              the right operand
		 * @return ITrit\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(ILinkedList\Type $xs, ILinkedList\Type $ys) : ITrit\Type {
			for ($as = $xs, $bs = $ys; !$as->__isEmpty() && !$bs->__isEmpty(); $as = $as->tail(), $bs = $bs->tail()) {
				$r = $as->head()->compare($bs->head());
				if ($r->unbox() != 0) {
					return $r;
				}
			}

			$x_length = $xs->__length();
			$y_length = $ys->__length();

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
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param ILinkedList\Type $ys                              the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(ILinkedList\Type $xs, ILinkedList\Type $ys) : IBool\Type { // >=
			return IBool\Type::box(ILinkedList\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param ILinkedList\Type $ys                              the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(ILinkedList\Type $xs, ILinkedList\Type $ys) : IBool\Type { // >
			return IBool\Type::box(ILinkedList\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param ILinkedList\Type $ys                              the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(ILinkedList\Type $xs, ILinkedList\Type $ys) : IBool\Type { // <=
			return IBool\Type::box(ILinkedList\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param ILinkedList\Type $ys                              the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(ILinkedList\Type $xs, ILinkedList\Type $ys) : IBool\Type { // <
			return IBool\Type::box(ILinkedList\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param ILinkedList\Type $ys                              the right operand
		 * @return ILinkedList\Type                                 the maximum value
		 */
		public static function max(ILinkedList\Type $xs, ILinkedList\Type $ys) : ILinkedList\Type {
			return (ILinkedList\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @param ILinkedList\Type $ys                              the right operand
		 * @return ILinkedList\Type                                 the minimum value
		 */
		public static function min(ILinkedList\Type $xs, ILinkedList\Type $ys) : ILinkedList\Type {
			return (ILinkedList\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

		#region Methods -> Logical Operations

		/**
		 * This method (aka "true") returns whether all of the items of the collection evaluate
		 * to true.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @return IBool\Type                                       whether all of the items of
		 *                                                          the collection evaluate to true
		 */
		public static function and_(ILinkedList\Type $xs) : IBool\Type {
			return ILinkedList\Module::all($xs, function(IBool\Type $x, IInt32\Type $i) : IBool\Type {
				return $x;
			});
		}

		/**
		 * This method returns whether any of the items of the collection evaluate to true.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $xs                              the left operand
		 * @return IBool\Type                                       whether all of the items of
		 *                                                          the collection evaluate to false
		 */
		public static function or_(ILinkedList\Type $xs) : IBool\Type {
			return ILinkedList\Module::any($xs, function(IBool\Type $x, IInt32\Type $i) : IBool\Type {
				return $x;
			});
		}

		#endregion

	}

}