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

namespace Saber\Data\IBool {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IBool;
	use \Saber\Data\IDouble;
	use \Saber\Data\IFloat;
	use \Saber\Data\IInt32;
	use \Saber\Data\IInteger;
	use \Saber\Data\IString;
	use \Saber\Data\ITrit;

	final class Module extends Data\Module {

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluate to null.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the value to be evaluated
		 * @param IBool\Type $y                                     the default value
		 * @return IBool\Type                                       the result
		 */
		public static function nvl(IBool\Type $x = null, IBool\Type $y = null) : IBool\Type {
			return $x ?? $y ?? IBool\Type::false();
		}

		/**
		 * This method returns the value as a IDouble. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the object to be converted
		 * @return IDouble\Type                                     the value as a IDouble
		 */
		public static function toDouble(IBool\Type $x) : IDouble\Type {
			return IDouble\Type::make($x->unbox());
		}

		/**
		 * This method returns the value as a IFloat. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the object to be converted
		 * @return IFloat\Type                                      the value as a IFloat
		 */
		public static function toFloat(IBool\Type $x) : IFloat\Type {
			return IFloat\Type::make($x->unbox());
		}

		/**
		 * This method returns the value as an IInt32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the object to be converted
		 * @return IInt32\Type                                      the value as an IInt32
		 */
		public static function toInt32(IBool\Type $x) : IInt32\Type {
			return IInt32\Type::make($x->unbox());
		}

		/**
		 * This method returns the value as an IInteger. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the object to be converted
		 * @return IInteger\Type                                    the value as an IInteger
		 */
		public static function toInteger(IBool\Type $x) : IInteger\Type {
			return IInteger\Type::make($x->unbox());
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(IBool\Type $x, Core\Type $y) : IBool\Type { // ==
			$type = $x->__typeOf();
			if ($y !== null) {
				if ($y instanceof $type) {
					return IBool\Type::box($x->unbox() == $y->unbox());
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(IBool\Type $x, Core\Type $y) : IBool\Type { // ===
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
		 * @param IBool\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(IBool\Type $x, Core\Type $y) : IBool\Type { // !=
			return IBool\Module::not(IBool\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(IBool\Type $x, Core\Type $y) : IBool\Type { // !==
			return IBool\Module::not(IBool\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param IBool\Type $y                                     the right operand
		 * @return ITrit\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(IBool\Type $x, IBool\Type $y) : ITrit\Type {
			$__x = $x->unbox();
			$__y = $y->unbox();

			if (!$__x && $__y) {
				return ITrit\Type::negative();
			}
			else if ($__x == $__y) {
				return ITrit\Type::zero();
			}
			else { // ($__x && !$__y)
				return ITrit\Type::positive();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param IBool\Type $y                                     the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(IBool\Type $x, IBool\Type $y) : IBool\Type { // >=
			return IBool\Type::box(IBool\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param IBool\Type $y                                     the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(IBool\Type $x, IBool\Type $y) : IBool\Type { // >
			return IBool\Type::box(IBool\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param IBool\Type $y                                     the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(IBool\Type $x, IBool\Type $y) : IBool\Type { // <=
			return IBool\Type::box(IBool\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param IBool\Type $y                                     the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(IBool\Type $x, IBool\Type $y) : IBool\Type { // <
			return IBool\Type::box(IBool\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param IBool\Type $y                                     the right operand
		 * @return IBool\Type                                       the maximum value
		 */
		public static function max(IBool\Type $x, IBool\Type $y) : IBool\Type {
			return (IBool\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param IBool\Type $y                                     the right operand
		 * @return IBool\Type                                       the minimum value
		 */
		public static function min(IBool\Type $x, IBool\Type $y) : IBool\Type {
			return (IBool\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Logical Operations

		/**
		 * This method returns whether both operands are "true".
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param IBool\Type $y                                     the right operand
		 * @return IBool\Type                                       whether both operands are "true"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_conjunction
		 */
		public static function and_(IBool\Type $x, IBool\Type $y) : IBool\Type {
			return IBool\Type::box($x->unbox() && $y->unbox());
		}

		/**
		 * This method returns whether the left operand implies the right operand.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param IBool\Type $y                                     the right operand
		 * @return IBool\Type                                       whether the left operand implies
		 *                                                          the right operand
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_implication
		 */
		public static function impl(IBool\Type $x, IBool\Type $y) : IBool\Type {
			return IBool\Type::box(!$x->unbox() || $y->unbox());
		}

		/**
		 * This method returns whether at least one operand is "false".
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param IBool\Type $y                                     the right operand
		 * @return IBool\Type                                       whether at least one operand is "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_NAND
		 */
		public static function nand(IBool\Type $x, IBool\Type $y) : IBool\Type {
			return IBool\Type::box(!($x->unbox() && $y->unbox()));
		}

		/**
		 * This method returns whether both operands are "false".
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param IBool\Type $y                                     the right operand
		 * @return IBool\Type                                       whether both operands are "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_NOR
		 */
		public static function nor(IBool\Type $x, IBool\Type $y) : IBool\Type {
			return IBool\Type::box(!($x->unbox() || $y->unbox()));
		}

		/**
		 * This method returns whether the operand is "false".
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the operand
		 * @return IBool\Type                                       whether the operand is "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_negation
		 */
		public static function not(IBool\Type $x) : IBool\Type {
			return IBool\Type::box(!$x->unbox());
		}

		/**
		 * This method returns whether at least one operand is "true".
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param IBool\Type $y                                     the right operand
		 * @return IBool\Type                                       whether at least one operand is "true"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_disjunction
		 */
		public static function or_(IBool\Type $x, IBool\Type $y) : IBool\Type {
			return IBool\Type::box($x->unbox() || $y->unbox());
		}

		/**
		 * This method returns whether only if both operands are "true" or "false".
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param IBool\Type $y                                     the right operand
		 * @return IBool\Type                                       whether only if both operands are
		 *                                                          "true" or "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_equality
		 */
		public static function xnor(IBool\Type $x, IBool\Type $y) : IBool\Type {
			return IBool\Type::box(!($x->unbox() xor $y->unbox()));
		}

		/**
		 * This method returns whether only one operand is "true".
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                     the left operand
		 * @param IBool\Type $y                                     the right operand
		 * @return IBool\Type                                       whether only one operand is "true"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Exclusive_disjunction
		 */
		public static function xor_(IBool\Type $x, IBool\Type $y) : IBool\Type {
			return IBool\Type::box($x->unbox() xor $y->unbox());
		}

		#endregion

	}

}