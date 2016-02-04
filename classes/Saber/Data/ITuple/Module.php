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

namespace Saber\Data\ITuple {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\ICollection;
	use \Saber\Data\IInt32;
	use \Saber\Data\ILinkedList;
	use \Saber\Data\ITrit;
	use \Saber\Data\ITuple;

	final class Module extends Data\Module implements ICollection\Module {

		#region Methods -> Basic Operations

		/**
		 * This method returns the first item in the tuple.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the left operand
		 * @return Core\Type                                        the first item in the tuple
		 */
		public static function first(ITuple\Type $xs) : Core\Type {
			return $xs->first();
		}

		/**
		 * This method returns the item at the specified index.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the left operand
		 * @param IInt32\Type $i                                    the index of the item
		 * @return Core\Type                                        the item at the specified index
		 */
		public static function item(ITuple\Type $xs, IInt32\Type $i) : Core\Type {
			return $xs->item($i);
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the left operand
		 * @return IInt32\Type                                      the length of this array list
		 */
		public static function length(ITuple\Type $xs) : IInt32\Type {
			return $xs->length();
		}

		/**
		 * This method returns the second item in the tuple.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the left operand
		 * @return Core\Type                                        the second item in the tuple
		 */
		public static function second(ITuple\Type $xs) : Core\Type {
			return $xs->second();
		}

		/**
		 * This method returns a tuple with the items swapped.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the left operand
		 * @return ITuple\Type                                      a tuple with the item swapped
		 */
		public static function swap(ITuple\Type $xs) : ITuple\Type {
			return ITuple\Type::box2($xs->second(), $xs->first());
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the value to be evaluated
		 * @param ITuple\Type $ys                                   the default value
		 * @return ITuple\Type                                      the result
		 */
		public static function nvl(ITuple\Type $xs = null, ITuple\Type $ys = null) : ITuple\Type {
			return $xs ?? $ys ?? ITuple\Type::empty_();
		}

		/**
		 * This method returns the tuple as an array.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the operand
		 * @return IArrayList\Type                                  the tuple as an array list
		 */
		public static function toArrayList(ITuple\Type $xs) : IArrayList\Type {
			return IArrayList\Type::box($xs->unbox());
		}

		/**
		 * This method returns the tuple as a linked list.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the operand
		 * @return ILinkedList\Type                                 the tuple as a linked list
		 */
		public static function toLinkedList(ITuple\Type $xs) : ILinkedList\Type {
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
		 * @param ITuple\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(ITuple\Type $xs, Core\Type $ys) : IBool\Type { // ==
			$type = $xs->__typeOf();
			if ($ys instanceof $type) {
				return IBool\Type::box(ITuple\Module::compare($xs, $ys)->unbox() == 0);
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(ITuple\Type $xs, Core\Type $ys) : IBool\Type { // ===
			if ($xs->__typeOf() === $ys->__typeOf()) {
				return IBool\Type::box(ITuple\Module::compare($xs, $ys)->unbox() == 0);
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(ITuple\Type $xs, Core\Type $ys) : IBool\Type { // !=
			return IBool\Module::not(ITuple\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(ITuple\Type $xs, Core\Type $ys) : IBool\Type { // !==
			return IBool\Module::not(ITuple\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the left operand
		 * @param ITuple\Type $ys                                   the right operand
		 * @return ITrit\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(ITuple\Type $xs, ITuple\Type $ys) : ITrit\Type {
			$xsl = $xs->length();
			$ysl = $ys->length();

			$length = IInt32\Module::min($xsl, $ysl);

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$r = $xs->item($i)->compare($ys->item($i));
				if ($r->unbox() != 0) {
					return $r;
				}
			}

			return ITrit\Type::box($xsl->unbox() <=> $ysl->unbox());
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the left operand
		 * @param ITuple\Type $ys                                   the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(ITuple\Type $xs, ITuple\Type $ys) : IBool\Type { // >=
			return IBool\Type::box(ITuple\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the left operand
		 * @param ITuple\Type $ys                                   the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(ITuple\Type $xs, ITuple\Type $ys) : IBool\Type { // >
			return IBool\Type::box(ITuple\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the left operand
		 * @param ITuple\Type $ys                                   the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(ITuple\Type $xs, ITuple\Type $ys) : IBool\Type { // <=
			return IBool\Type::box(ITuple\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the left operand
		 * @param ITuple\Type $ys                                   the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(ITuple\Type $xs, ITuple\Type $ys) : IBool\Type { // <
			return IBool\Type::box(ITuple\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the left operand
		 * @param ITuple\Type $ys                                   the right operand
		 * @return ITuple\Type                                      the maximum value
		 */
		public static function max(ITuple\Type $xs, ITuple\Type $ys) : ITuple\Type {
			return (ITuple\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $xs                                   the left operand
		 * @param ITuple\Type $ys                                   the right operand
		 * @return ITuple\Type                                      the minimum value
		 */
		public static function min(ITuple\Type $xs, ITuple\Type $ys) : ITuple\Type {
			return (ITuple\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

		#region Methods -> Evaluating Operations

		/**
		 * This method evaluates whether the tuple is a pair.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $x                                    the object to be evaluated
		 * @return IBool\Type                                       whether the tuple is a pair
		 */
		public static function isPair(ITuple\Type $x) : IBool\Type {
			return $x->isPair();
		}

		#endregion

	}

}