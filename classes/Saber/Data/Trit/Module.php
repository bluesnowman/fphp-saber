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

namespace Saber\Data\Trit {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Bool;
	use \Saber\Data\Double;
	use \Saber\Data\Float;
	use \Saber\Data\Int32;
	use \Saber\Data\Integer;
	use \Saber\Data\Trit;

	final class Module extends Data\Module {

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the value to be evaluated
		 * @param Trit\Type $y                                      the default value
		 * @return Trit\Type                                        the result
		 */
		public static function nvl(Trit\Type $x = null, Trit\Type $y = null) {
			return ($x !== null) ? $x : (($y !== null) ? $y : Trit\Type::zero());
		}

		/**
		 * This method returns the value as a Double. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the object to be converted
		 * @return Double\Type                                      the value as a Double
		 */
		public static function toDouble(Trit\Type $x) {
			return Double\Type::box($x->unbox());
		}

		/**
		 * This method returns the value as a Float. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the object to be converted
		 * @return Float\Type                                       the value as a Float
		 */
		public static function toFloat(Trit\Type $x) {
			return Float\Type::box($x->unbox());
		}

		/**
		 * This method returns the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the object to be converted
		 * @return Int32\Type                                       the value as an Int32
		 */
		public static function toInt32(Trit\Type $x) {
			return Int32\Type::box($x->unbox());
		}

		/**
		 * This method returns the value as an Integer. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the object to be converted
		 * @return Integer\Type                                     the value as an Integer
		 */
		public static function toInteger(Trit\Type $x) {
			return Integer\Type::box($x->unbox());
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Trit\Type $x, Core\Type $y) { // ==
			$type = $x->__typeOf();
			if ($y !== null) {
				if ($y instanceof $type) {
					return Bool\Type::box($x->unbox() == $y->unbox());
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Trit\Type $x, Core\Type $y) { // ===
			if ($y !== null) {
				if ($x->__typeOf() === $y->__typeOf()) {
					return Bool\Type::box($x->unbox() === $y->unbox());
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Trit\Type $x, Core\Type $y) { // !=
			return Bool\Module::not(Trit\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Trit\Type $x, Core\Type $y) { // !==
			return Bool\Module::not(Trit\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the left operand
		 * @param Trit\Type $y                                      the right operand
		 * @return Trit\Type                                        the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Trit\Type $x, Trit\Type $y) {
			$__x = $x->unbox();
			$__y = $y->unbox();

			if ($__x < $__y) {
				return Trit\Type::negative();
			}
			else if ($__x == $__y) {
				return Trit\Type::zero();
			}
			else { // ($__x > $__y)
				return Trit\Type::positive();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the left operand
		 * @param Trit\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Trit\Type $x, Trit\Type $y) { // >=
			return Bool\Type::box(Trit\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the left operand
		 * @param Trit\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Trit\Type $x, Trit\Type $y) { // >
			return Bool\Type::box(Trit\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the left operand
		 * @param Trit\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Trit\Type $x, Trit\Type $y) { // <=
			return Bool\Type::box(Trit\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the left operand
		 * @param Trit\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Trit\Type $x, Trit\Type $y) { // <
			return Bool\Type::box(Trit\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the left operand
		 * @param Trit\Type $y                                      the right operand
		 * @return Trit\Type                                        the maximum value
		 */
		public static function max(Trit\Type $x, Trit\Type $y) {
			return (Trit\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the left operand
		 * @param Trit\Type $y                                      the right operand
		 * @return Trit\Type                                        the minimum value
		 */
		public static function min(Trit\Type $x, Trit\Type $y) {
			return (Trit\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

	}

}