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

namespace Saber\Data\Bool {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Bool;
	use \Saber\Data\Double;
	use \Saber\Data\Float;
	use \Saber\Data\Int32;
	use \Saber\Data\Integer;
	use \Saber\Data\String;

	final class Module extends Data\Module {

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the value to be evaluated
		 * @param Bool\Type $y                                      the default value
		 * @return Bool\Type                                        the result
		 */
		public static function nvl(Bool\Type $x = null, Bool\Type $y = null) {
			return ($x !== null) ? $x : (($y !== null) ? $y : Bool\Type::false());
		}

		/**
		 * This method returns the value as a Double. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the object to be converted
		 * @return Double\Type                                      the value as a Double
		 */
		public static function toDouble(Bool\Type $x) {
			return Double\Type::box($x->unbox());
		}

		/**
		 * This method returns the value as a Float. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the object to be converted
		 * @return Float\Type                                       the value as a Float
		 */
		public static function toFloat(Bool\Type $x) {
			return Float\Type::box($x->unbox());
		}

		/**
		 * This method returns the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the object to be converted
		 * @return Int32\Type                                       the value as an Int32
		 */
		public static function toInt32(Bool\Type $x) {
			return Int32\Type::box($x->unbox());
		}

		/**
		 * This method returns the value as an Integer. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the object to be converted
		 * @return Integer\Type                                     the value as an Integer
		 */
		public static function toInteger(Bool\Type $x) {
			return Integer\Type::box($x->unbox());
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Bool\Type $x, Core\Type $y) { // ==
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
		 * @param Bool\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Bool\Type $x, Core\Type $y) { // ===
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
		 * @param Bool\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Bool\Type $x, Core\Type $y) { // !=
			return Bool\Module::not(Bool\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Bool\Type $x, Core\Type $y) { // !==
			return Bool\Module::not(Bool\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Logical

		/**
		 * This method returns whether both operands are "true".
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether both operands are "true"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_conjunction
		 */
		public static function and_(Bool\Type $x, Bool\Type $y) {
			return Bool\Type::box($x->unbox() && $y->unbox());
		}

		/**
		 * This method returns whether the left operand implies the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand implies
		 *                                                          the right operand
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_implication
		 */
		public static function impl(Bool\Type $x, Bool\Type $y) {
			return Bool\Type::box(!$x->unbox() || $y->unbox());
		}

		/**
		 * This method returns whether at least one operand is "false".
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether at least one operand is "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_NAND
		 */
		public static function nand(Bool\Type $x, Bool\Type $y) {
			return Bool\Type::box(!($x->unbox() && $y->unbox()));
		}

		/**
		 * This method returns whether both operands are "false".
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether both operands are "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_NOR
		 */
		public static function nor(Bool\Type $x, Bool\Type $y) {
			return Bool\Type::box(!($x->unbox() || $y->unbox()));
		}

		/**
		 * This method returns whether the operand is "false".
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the operand
		 * @return Bool\Type                                        whether the operand is "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_negation
		 */
		public static function not(Bool\Type $x) {
			return Bool\Type::box(!$x->unbox());
		}

		/**
		 * This method returns whether at least one operand is "true".
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether at least one operand is "true"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_disjunction
		 */
		public static function or_(Bool\Type $x, Bool\Type $y) {
			return Bool\Type::box($x->unbox() || $y->unbox());
		}

		/**
		 * This method returns whether only if both operands are "true" or "false".
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether only if both operands are
		 *                                                          "true" or "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_equality
		 */
		public static function xnor(Bool\Type $x, Bool\Type $y) {
			return Bool\Type::box(!($x->unbox() xor $y->unbox()));
		}

		/**
		 * This method returns whether only one operand is "true".
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether only one operand is "true"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Exclusive_disjunction
		 */
		public static function xor_(Bool\Type $x, Bool\Type $y) {
			return Bool\Type::box($x->unbox() xor $y->unbox());
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Int32\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Bool\Type $x, Bool\Type $y) {
			if (($x === null) && ($y !== null)) {
				return Int32\Type::negative();
			}
			if (($x === null) && ($y === null)) {
				return Int32\Type::zero();
			}
			if (($x !== null) && ($y === null)) {
				return Int32\Type::one();
			}

			$__x = $x->unbox();
			$__y = $y->unbox();

			if (!$__x && $__y) {
				return Int32\Type::negative();
			}
			else if ($__x == $__y) {
				return Int32\Type::zero();
			}
			else { // ($__x && !$__y)
				return Int32\Type::one();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Bool\Type $x, Bool\Type $y) { // >=
			return Bool\Type::box(Bool\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Bool\Type $x, Bool\Type $y) { // >
			return Bool\Type::box(Bool\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Bool\Type $x, Bool\Type $y) { // <=
			return Bool\Type::box(Bool\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Bool\Type $x, Bool\Type $y) { // <
			return Bool\Type::box(Bool\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Int32\Type                                       the maximum value
		 */
		public static function max(Bool\Type $x, Bool\Type $y) {
			return (Bool\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Int32\Type                                       the minimum value
		 */
		public static function min(Bool\Type $x, Bool\Type $y) {
			return (Bool\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

	}

}