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

namespace Saber\Data\Unit {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Bool;
	use \Saber\Data\Int32;
	use \Saber\Data\Unit;

	class Module extends Data\Module {

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param Unit\Type $x                                      the value to be evaluated
		 * @param Unit\Type $y                                      the default value
		 * @return Unit\Type                                        the result
		 */
		public static function nvl(Unit\Type $x = null, Unit\Type $y = null) {
			return ($x !== null) ? $x : (($y !== null) ? $y : Unit\Type::instance());
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Unit\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Unit\Type $x, Core\Type $y) { // ==
			$type = ($x === null) ? '\\Saber\\Data\\Unit\\Type' : $x->__typeOf();
			return Bool\Type::box(($y === null) || ($y instanceof $type));
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Unit\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Unit\Type $x, Core\Type $y) { // ===
			$type = ($x === null) ? '\\Saber\\Data\\Unit\\Type' : $x->__typeOf();
			return Bool\Type::box(($y === null) || ($type === $y->__typeOf()));
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Unit\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Unit\Type $x, Core\Type $y) { // !=
			return Bool\Module::not(Unit\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Unit\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Unit\Type $x, Core\Type $y) { // !==
			return Bool\Module::not(Unit\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Unit\Type $x                                      the left operand
		 * @param Unit\Type $y                                      the right operand
		 * @return Int32\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Unit\Type $x, Unit\Type $y) {
			if (Unit\Module::eq($x, $y)->unbox()) {
				return Int32\Type::zero();
			}

			$r = strcmp($x->__typeOf(), $y->__typeOf());

			if ($r < 0) {
				return Int32\Type::negative();
			}
			else if ($r > 0) {
				return Int32\Type::one();
			}
			else {
				return Int32\Type::zero();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Unit\Type $x                                      the left operand
		 * @param Unit\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Unit\Type $x, Unit\Type $y) { // >=
			return Bool\Type::box(Unit\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Unit\Type $x                                      the left operand
		 * @param Unit\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Unit\Type $x, Unit\Type $y) { // >
			return Bool\Type::box(Unit\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Unit\Type $x                                      the left operand
		 * @param Unit\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Unit\Type $x, Unit\Type $y) { // <=
			return Bool\Type::box(Unit\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Unit\Type $x                                      the left operand
		 * @param Unit\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Unit\Type $x, Unit\Type $y) { // <
			return Bool\Type::box(Unit\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Unit\Type $x                                      the left operand
		 * @param Unit\Type $y                                      the right operand
		 * @return Unit\Type                                        the maximum value
		 */
		public static function max(Unit\Type $x, Unit\Type $y) {
			return (Unit\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Unit\Type $x                                      the left operand
		 * @param Unit\Type $y                                      the right operand
		 * @return Unit\Type                                        the minimum value
		 */
		public static function min(Unit\Type $x, Unit\Type $y) {
			return (Unit\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

	}

}