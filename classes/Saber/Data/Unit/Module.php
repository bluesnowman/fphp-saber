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

		#region Methods -> Equality

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
			$type = $x->__typeOf();
			if ($y instanceof $type) {
				return Bool\Module::true();
			}
			return Bool\Module::false();
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
			if ($x->__typeOf() === $y->__typeOf()) {
				return Bool\Module::create($x->__hashCode() === $y->__hashCode());
			}
			return Bool\Module::false();
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

		#region Methods -> Ordering

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
			if (($x === null) && ($y !== null)) {
				return Int32\Module::negative();
			}
			if (($x === null) && ($y === null)) {
				return Int32\Module::zero();
			}
			if (($x !== null) && ($y === null)) {
				return Int32\Module::one();
			}

			$r = strcmp($x->__hashCode(), $y->__hashCode());

			if ($r < 0) {
				return Int32\Module::negative();
			}
			else if ($r == 0) {
				return Int32\Module::zero();
			}
			else {
				return Int32\Module::one();
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
			return Bool\Module::create(Unit\Module::compare($x, $y)->unbox() >= 0);
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
			return Bool\Module::create(Unit\Module::compare($x, $y)->unbox() > 0);
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
			return Bool\Module::create(Unit\Module::compare($x, $y)->unbox() <= 0);
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
			return Bool\Module::create(Unit\Module::compare($x, $y)->unbox() < 0);
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