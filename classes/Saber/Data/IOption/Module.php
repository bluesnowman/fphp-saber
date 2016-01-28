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

namespace Saber\Data\IOption {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\ICollection;
	use \Saber\Data\IEither;
	use \Saber\Data\IInt32;
	use \Saber\Data\ILinkedList;
	use \Saber\Data\IOption;
	use \Saber\Data\IString;
	use \Saber\Data\ITrit;
	use \Saber\Data\IUnit;

	final class Module extends Data\Module implements ICollection\Module {

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the items in the collection, yielding each
		 * item to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                       whether each item passed the
		 *                                                          truthy test
		 */
		public static function all(IOption\Type $xs, callable $predicate) : IBool\Type {
			return IBool\Module::or_(IBool\Module::not($xs->isDefined()), $predicate($xs->item(), IInt32\Type::zero()));
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the items in the collection
		 * passed the truthy test.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                       whether some of the items
		 *                                                          passed the truthy test
		 */
		public static function any(IOption\Type $xs, callable $predicate) : IBool\Type {
			return IOption\Module::find($xs, $predicate)->isDefined();
		}

		/**
		 * This method binds the subroutine to the object within this option.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param callable $subroutine                              the subroutine function to be applied
		 * @return IOption\Type                                     the option
		 */
		public static function bind(IOption\Type $xs, callable $subroutine) : IOption\Type {
			return ($xs->__isDefined())
				? IOption\Type::covariant($subroutine($xs->item(), IInt32\Type::zero()))
				: IOption\Type::none();
		}

		/**
		 * This method iterates over the items in the option, yielding each item to the
		 * procedure function.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param callable $procedure                               the procedure function to be used
		 */
		public static function each(IOption\Type $xs, callable $procedure) {
			if ($xs->__isDefined()) {
				IUnit\Type::covariant($procedure($xs->item(), IInt32\Type::zero()));
			}
		}

		/**
		 * This method returns a collection of those items that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IOption\Type                                     the option
		 */
		public static function filter(IOption\Type $xs, callable $predicate) : IOption\Type {
			if (IBool\Module::and_($xs->isDefined(), $predicate($xs->item(), IInt32\Type::zero()))->unbox()) {
				return $xs;
			}
			return IOption\Type::none();
		}

		/**
		 * This method returns the first object in the collection that passes the truthy test, if any.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IOption\Type                                     an option containing the first object
		 *                                                          satisfying the predicate, if any
		 */
		public static function find(IOption\Type $xs, callable $predicate) : IOption\Type {
			if (IBool\Module::and_($xs->isDefined(), $predicate($xs->item(), IInt32\Type::zero()))->unbox()) {
				return $xs;
			}
			return IOption\Type::none();
		}

		/**
		 * This method returns the item stored within the option.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @return Core\Type                                        the stored item
		 */
		public static function item(IOption\Type $xs) : Core\Type {
			return $xs->item();
		}
		
		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @return IOption\Iterator                                 an iterator for this collection
		 */
		public static function iterator(IOption\Type $xs) : IOption\Iterator {
			return new IOption\Iterator($xs);
		}

		/**
		 * This method returns the length of this option.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @return IInt32\Type                                      the length of this option
		 */
		public static function length(IOption\Type $xs) : IInt32\Type {
			return $xs->size();
		}

		/**
		 * This method applies each item in this option to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return IOption\Type                                     the option
		 */
		public static function map(IOption\Type $xs, callable $subroutine) : IOption\Type {
			return ($xs->__isDefined())
				? IOption\Type::some($subroutine($xs->item()))
				: IOption\Type::none();
		}

		/**
		 * This method returns this option if it has "some" object, otherwise, it returns the specified
		 * option.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param IOption\Type $ys                                  the alternative option
		 * @return IOption\Type                                     the option
		 */
		public static function orElse(IOption\Type $xs, IOption\Type $ys) : IOption\Type {
			return ($xs->__isDefined()) ? $xs : $ys;
		}

		/**
		 * This method returns this option's boxed object if is has "some" object; otherwise, it will
		 * return the specified object.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param Core\Type $y                                      the alternative object
		 * @return Core\Type                                        the boxed object
		 */
		public static function orSome(IOption\Type $xs, Core\Type $y) : Core\Type {
			return ($xs->__isDefined()) ? $xs->item() : $y;
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the value to be evaluated
		 * @param IOption\Type $ys                                  the default value
		 * @return IOption\Type                                     the result
		 */
		public static function nvl(IOption\Type $xs = null, IOption\Type $ys = null) : IOption\Type {
			return ($xs !== null) ? $xs : (($ys !== null) ? $ys : IOption\Type::none());
		}

		/**
		 * This method returns the option as an array.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the operand
		 * @return IArrayList\Type                                  the option as an array list
		 */
		public static function toArrayList(IOption\Type $xs) : IArrayList\Type {
			$buffer = array();

			if ($xs->__isDefined()) {
				$buffer[] = $xs->item();
			}

			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns this option's object in an IEither\Left\Type if defined; otherwise,
		 * returns the specified object in an IEither\Right\Type.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the operand
		 * @param Core\Type $x                                      the object to be returned
		 *                                                          if option is not defined
		 * @return IEither\Type                                     the either
		 */
		public static function toLeft(IOption\Type $xs, Core\Type $x) : IEither\Type {
			return ($xs->__isDefined())
				? IEither\Type::left($xs->item())
				: IEither\Type::right($x);
		}

		/**
		 * This method returns the option as a linked list.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the operand
		 * @return ILinkedList\Type                                 the option as a linked list
		 */
		public static function toLinkedList(IOption\Type $xs) : ILinkedList\Type {
			return ($xs->__isDefined())
				? ILinkedList\Type::cons($xs->item())
				: ILinkedList\Type::nil();
		}

		/**
		 * This method returns the option.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the operand
		 * @return IOption\Type                                     the option
		 */
		public static function toOption(IOption\Type $xs) : IOption\Type {
			return $xs;
		}

		/**
		 * This method returns this option's object in an IEither\Right\Type if defined; otherwise,
		 * returns the specified object in an IEither\Left\Type.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the operand
		 * @param Core\Type $x                                      the object to be returned
		 *                                                          if option is not defined
		 * @return IEither\Type                                     the either
		 */
		public static function toRight(IOption\Type $xs, Core\Type $x) : IEither\Type {
			return ($xs->__isDefined())
				? IEither\Type::right($xs->item())
				: IEither\Type::left($x);
		}

		#endregion

		#region Methods -> Evaluating Operations

		/**
		 * This method returns whether this instance is a "some" option.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the operand
		 * @return IBool\Type                                       whether this instance is a "some"
		 *                                                          option
		 */
		public static function isDefined(IOption\Type $xs) : IBool\Type {
			return $xs->isDefined();
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the specified object is equal to the current object.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the object to be evaluated
		 * @return IBool\Type                                       whether the specified object is equal
		 *                                                          to the current object
		 */
		public static function eq(IOption\Type $xs, Core\Type $ys) : IBool\Type {
			if ($ys !== null) {
				$type = $xs->__typeOf();
				if ($ys instanceof $type) {
					if ($ys instanceof IOption\Some\Type) {
						$x = $xs->item();
						$y = $ys->item();
						if ($x === null) {
							return IBool\Type::box($y === null);
						}
						else if ($x instanceof Core\Equality\Type) {
							return $x->eq($y);
						}
						return IBool\Type::box(spl_object_hash($x) === spl_object_hash($y));
					}
					else {
						if ($ys instanceof IOption\None\Type) {
							return IBool\Type::true();
						}
					}
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the specified object is identical to the current object.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the object to be evaluated
		 * @return IBool\Type                                       whether the specified object is identical
		 *                                                          to the current object
		 */
		public static function id(IOption\Type $xs, Core\Type $ys) : IBool\Type {
			if ($ys !== null) {
				if ($xs->__typeOf() === $ys->__typeOf()) {
					if ($ys instanceof IOption\Some\Type) {
						$x = $xs->item();
						$y = $ys->item();
						if ($x === null) {
							return IBool\Type::box($y === null);
						}
						else if ($x instanceof Core\Equality\Type) {
							return $x->id($y);
						}
						return IBool\Type::box(spl_object_hash($x) === spl_object_hash($y));
					}
					else {
						if ($ys instanceof IOption\None\Type) {
							return IBool\Type::true();
						}
					}
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(IOption\Type $xs, Core\Type $ys) : IBool\Type { // !=
			return IBool\Module::not(IOption\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(IOption\Type $xs, Core\Type $ys) : IBool\Type { // !==
			return IBool\Module::not(IOption\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param IOption\Type $ys                                  the object to be compared
		 * @return ITrit\Type                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(IOption\Type $xs, IOption\Type $ys) : ITrit\Type {
			$x = $xs->__isDefined();
			$y = $ys->__isDefined();

			if (!$x && $y) {
				return ITrit\Type::negative();
			}
			if (!$x && !$y) {
				return ITrit\Type::zero();
			}
			if ($x && !$y) {
				return ITrit\Type::positive();
			}

			$x = $xs->item();
			$y = $ys->item();

			if (($x === null) && ($y !== null)) {
				return ITrit\Type::negative();
			}
			if (($x === null) && ($y === null)) {
				return ITrit\Type::zero();
			}
			if (($x !== null) && ($y === null)) {
				return ITrit\Type::positive();
			}

			if ($x instanceof Core\Comparable\Type) {
				return call_user_func_array(array($x, 'compare'), array($y));
			}

			return IString\Module::compare(Core\Module::hashCode($x), Core\Module::hashCode($y));
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param IOption\Type $ys                                  the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(IOption\Type $xs, IOption\Type $ys) : IBool\Type { // >=
			return IBool\Type::box(IOption\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param IOption\Type $ys                                  the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(IOption\Type $xs, IOption\Type $ys) : IBool\Type { // >
			return IBool\Type::box(IOption\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param IOption\Type $ys                                  the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(IOption\Type $xs, IOption\Type $ys) : IBool\Type { // <=
			return IBool\Type::box(IOption\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param IOption\Type $ys                                  the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(IOption\Type $xs, IOption\Type $ys) : IBool\Type { // <
			return IBool\Type::box(IOption\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param IOption\Type $ys                                  the right operand
		 * @return IOption\Type                                     the maximum value
		 */
		public static function max(IOption\Type $xs, IOption\Type $ys) : IOption\Type {
			return (IOption\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param IOption\Type $xs                                  the left operand
		 * @param IOption\Type $ys                                  the right operand
		 * @return IOption\Type                                     the minimum value
		 */
		public static function min(IOption\Type $xs, IOption\Type $ys) : IOption\Type {
			return (IOption\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

	}

}
