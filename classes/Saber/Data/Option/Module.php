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

namespace Saber\Data\Option {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Bool;
	use \Saber\Data\Collection;
	use \Saber\Data\Int32;
	use \Saber\Data\LinkedList;
	use \Saber\Data\Option;
	use \Saber\Data\String;

	final class Module extends Data\Module implements Collection\Module {

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the elements in the collection, yielding each
		 * element to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether each element passed the
		 *                                                          truthy test
		 */
		public static function all(Option\Type $xs, callable $predicate) {
			return Bool\Module::or_(Bool\Module::not($xs->isDefined()), $predicate($xs->object(), Int32\Type::zero()));
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the elements in the collection
		 * passed the truthy test.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether some of the elements
		 *                                                          passed the truthy test
		 */
		public static function any(Option\Type $xs, callable $predicate) {
			return Option\Module::find($xs, $predicate)->isDefined();
		}

		/**
		 * This method binds the subroutine to the object within this option.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param callable $subroutine                              the subroutine function to be applied
		 * @return Option\Type                                      the option
		 */
		public static function bind(Option\Type $xs, callable $subroutine) {
			return ($xs->__isDefined())
				? $subroutine($xs->object(), Int32\Type::zero())
				: Option\Type::none();
		}

		/**
		 * This method iterates over the elements in the option, yielding each element to the
		 * procedure function.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param callable $procedure                               the procedure function to be used
		 */
		public static function each(Option\Type $xs, callable $procedure) {
			if ($xs->__isDefined()) {
				$procedure($xs->object(), Int32\Type::zero());
			}
		}

		/**
		 * This method returns a collection of those elements that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Option\Type                                      the option
		 */
		public static function filter(Option\Type $xs, callable $predicate) {
			if (Bool\Module::and_($xs->isDefined(), $predicate($xs->object(), Int32\Type::zero()))->unbox()) {
				return $xs;
			}
			return Option\Type::none();
		}

		/**
		 * This method returns the first object in the collection that passes the truthy test, if any.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Option\Type                                      an option containing the first object
		 *                                                          satisfying the predicate, if any
		 */
		public static function find(Option\Type $xs, callable $predicate) {
			if (Bool\Module::and_($xs->isDefined(), $predicate($xs->object(), Int32\Type::zero()))->unbox()) {
				return $xs;
			}
			return Option\Type::none();
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @return Option\Iterator                                  an iterator for this collection
		 */
		public static function iterator(Option\Type $xs) {
			return new Option\Iterator($xs);
		}

		/**
		 * This method returns the length of this option.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @return Int32\Type                                       the length of this option
		 */
		public static function length(Option\Type $xs) {
			return $xs->length();
		}

		/**
		 * This method applies each element in this option to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return Option\Type                                      the option
		 */
		public static function map(Option\Type $xs, callable $subroutine) {
			return ($xs->__isDefined()) ? Option\Type::some($subroutine($xs->object())) : Option\Type::none();
		}

		/**
		 * This method returns the object stored within the option.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @return Core\Type                                        the stored object
		 */
		public static function object(Option\Type $xs) {
			return $xs->object();
		}

		/**
		 * This method returns this option if it has "some" object, otherwise, it returns the specified
		 * option.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the alternative option
		 * @return Option\Type                                      the option
		 */
		public static function orElse(Option\Type $xs, Option\Type $ys) {
			return ($xs->__isDefined()) ? $xs : $ys;
		}

		/**
		 * This method returns this option's boxed object if is has "some" object; otherwise, it will
		 * return the specified object.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Core\Type $y                                      the alternative object
		 * @return Core\Type                                        the boxed object
		 */
		public static function orSome(Option\Type $xs, Core\Type $y) {
			return ($xs->__isDefined()) ? $xs->object() : $y;
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the value to be evaluated
		 * @param Option\Type $ys                                   the default value
		 * @return Option\Type                                      the result
		 */
		public static function nvl(Option\Type $xs = null, Option\Type $ys = null) {
			return ($xs !== null) ? $xs : (($ys !== null) ? $ys : Option\Type::none());
		}

		/**
		 * This method returns the collection as an array.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the operand
		 * @return ArrayList\Type                                   the collection as an array list
		 */
		public static function toArrayList(Option\Type $xs) {
			$buffer = array();

			if ($xs->__isDefined()) {
				$buffer[] = $xs->object();
			}

			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the option as a list.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the operand
		 * @return LinkedList\Type                                  the option as a linked list
		 */
		public static function toLinkedList(Option\Type $xs) {
			return ($xs->__isDefined())
				? LinkedList\Type::cons($xs->object(), LinkedList\Type::nil())
				: LinkedList\Type::nil();
		}

		#endregion

		#region Methods -> Evaluating Operations

		/**
		 * This method returns whether this instance is a "some" option.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the operand
		 * @return Bool\Type                                        whether this instance is a "some"
		 *                                                          option
		 */
		public static function isDefined(Option\Type $xs) {
			return $xs->isDefined();
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the specified object is equal to the current object.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the object to be evaluated
		 * @return Bool\Type                                        whether the specified object is equal
		 *                                                          to the current object
		 */
		public static function eq(Option\Type $xs, Core\Type $ys) {
			if ($ys !== null) {
				$type = $xs->__typeOf();
				if ($ys instanceof $type) {
					if ($ys instanceof Option\Some\Type) {
						$x = $xs->object();
						$y = $ys->object();
						if ($x === null) {
							return Bool\Type::box($y === null);
						}
						else if ($x instanceof Core\Equality\Type) {
							return $x->eq($y);
						}
						return Bool\Type::box(spl_object_hash($x) === spl_object_hash($y));
					}
					else {
						if ($ys instanceof Option\None\Type) {
							return Bool\Type::true();
						}
					}
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the specified object is identical to the current object.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the object to be evaluated
		 * @return Bool\Type                                        whether the specified object is identical
		 *                                                          to the current object
		 */
		public static function id(Option\Type $xs, Core\Type $ys) {
			if ($ys !== null) {
				if ($xs->__typeOf() === $ys->__typeOf()) {
					if ($ys instanceof Option\Some\Type) {
						$x = $xs->object();
						$y = $ys->object();
						if ($x === null) {
							return Bool\Type::box($y === null);
						}
						else if ($x instanceof Core\Equality\Type) {
							return $x->id($y);
						}
						return Bool\Type::box(spl_object_hash($x) === spl_object_hash($y));
					}
					else {
						if ($ys instanceof Option\None\Type) {
							return Bool\Type::true();
						}
					}
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Option\Type $xs, Core\Type $ys) { // !=
			return Bool\Module::not(Option\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Option\Type $xs, Core\Type $ys) { // !==
			return Bool\Module::not(Option\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the object to be compared
		 * @return Int32\Type                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(Option\Type $xs, Option\Type $ys) {
			if (($xs === null) && ($ys !== null)) {
				return Int32\Type::negative();
			}
			if (($xs === null) && ($ys === null)) {
				return Int32\Type::zero();
			}
			if (($xs !== null) && ($ys === null)) {
				return Int32\Type::one();
			}

			$x = $xs->__isDefined();
			$y = $ys->__isDefined();

			if (!$x && $y) {
				return Int32\Type::negative();
			}
			if (!$x && !$y) {
				return Int32\Type::zero();
			}
			if ($x && !$y) {
				return Int32\Type::one();
			}

			$x = $xs->object();
			$y = $ys->object();

			if (($x === null) && ($y !== null)) {
				return Int32\Type::negative();
			}
			if (($x === null) && ($y === null)) {
				return Int32\Type::zero();
			}
			if (($x !== null) && ($y === null)) {
				return Int32\Type::one();
			}

			if ($x instanceof Core\Comparable\Type) {
				return call_user_func_array(array($x, 'compare'), array($y));
			}

			return String\Module::compare(Core\Module::hashCode($x), Core\Module::hashCode($y));
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Option\Type $xs, Option\Type $ys) { // >=
			return Bool\Type::box(Option\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Option\Type $xs, Option\Type $ys) { // >
			return Bool\Type::box(Option\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Option\Type $xs, Option\Type $ys) { // <=
			return Bool\Type::box(Option\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Option\Type $xs, Option\Type $ys) { // <
			return Bool\Type::box(Option\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the right operand
		 * @return Int32\Type                                       the maximum value
		 */
		public static function max(Option\Type $xs, Option\Type $ys) {
			return (Option\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the right operand
		 * @return Int32\Type                                       the minimum value
		 */
		public static function min(Option\Type $xs, Option\Type $ys) {
			return (Option\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

	}

}
