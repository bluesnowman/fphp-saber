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

namespace Saber\Data\ITrit {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IBool;
	use \Saber\Data\IDouble;
	use \Saber\Data\IFloat;
	use \Saber\Data\IInt32;
	use \Saber\Data\IInteger;
	use \Saber\Data\ITrit;

	final class Module extends Data\Module {

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the value to be evaluated
		 * @param ITrit\Type $y                                      the default value
		 * @return ITrit\Type                                        the result
		 */
		public static function nvl(ITrit\Type $x = null, ITrit\Type $y = null) {
			return ($x !== null) ? $x : (($y !== null) ? $y : ITrit\Type::zero());
		}

		/**
		 * This method returns the value as a IBool. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the object to be converted
		 * @return IBool\Type                                        the value as a IBool
		 */
		public static function toBool(ITrit\Type $x) {
			return ITrit\Module::eq($x, ITrit\Type::zero());
		}

		/**
		 * This method returns the value as a IDouble. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the object to be converted
		 * @return IDouble\Type                                      the value as a IDouble
		 */
		public static function toDouble(ITrit\Type $x) {
			return IDouble\Type::make($x->unbox());
		}

		/**
		 * This method returns the value as a IFloat. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the object to be converted
		 * @return IFloat\Type                                       the value as a IFloat
		 */
		public static function toFloat(ITrit\Type $x) {
			return IFloat\Type::make($x->unbox());
		}

		/**
		 * This method returns the value as an IInt32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the object to be converted
		 * @return IInt32\Type                                       the value as an IInt32
		 */
		public static function toInt32(ITrit\Type $x) {
			return IInt32\Type::make($x->unbox());
		}

		/**
		 * This method returns the value as an IInteger. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the object to be converted
		 * @return IInteger\Type                                     the value as an IInteger
		 */
		public static function toInteger(ITrit\Type $x) {
			return IInteger\Type::make($x->unbox());
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(ITrit\Type $x, Core\Type $y) { // ==
			$type = $x->__typeOf();
			if (($y !== null) && ($y instanceof $type)) {
				return IBool\Type::box($x->unbox() == $y->unbox());
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(ITrit\Type $x, Core\Type $y) { // ===
			if ($y !== null) {
				if ($x->__typeOf() === $y->__typeOf()) {
					return IBool\Type::box($x->unbox() === $y->unbox());
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(ITrit\Type $x, Core\Type $y) { // !=
			return IBool\Module::not(ITrit\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(ITrit\Type $x, Core\Type $y) { // !==
			return IBool\Module::not(ITrit\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the left operand
		 * @param ITrit\Type $y                                      the right operand
		 * @return ITrit\Type                                        the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(ITrit\Type $x, ITrit\Type $y) {
			$__x = $x->unbox();
			$__y = $y->unbox();

			if ($__x < $__y) {
				return ITrit\Type::negative();
			}
			else if ($__x == $__y) {
				return ITrit\Type::zero();
			}
			else { // ($__x > $__y)
				return ITrit\Type::positive();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the left operand
		 * @param ITrit\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(ITrit\Type $x, ITrit\Type $y) { // >=
			return IBool\Type::box(ITrit\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the left operand
		 * @param ITrit\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(ITrit\Type $x, ITrit\Type $y) { // >
			return IBool\Type::box(ITrit\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the left operand
		 * @param ITrit\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(ITrit\Type $x, ITrit\Type $y) { // <=
			return IBool\Type::box(ITrit\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the left operand
		 * @param ITrit\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(ITrit\Type $x, ITrit\Type $y) { // <
			return IBool\Type::box(ITrit\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the left operand
		 * @param ITrit\Type $y                                      the right operand
		 * @return ITrit\Type                                        the maximum value
		 */
		public static function max(ITrit\Type $x, ITrit\Type $y) {
			return (ITrit\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param ITrit\Type $x                                      the left operand
		 * @param ITrit\Type $y                                      the right operand
		 * @return ITrit\Type                                        the minimum value
		 */
		public static function min(ITrit\Type $x, ITrit\Type $y) {
			return (ITrit\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

	}

}