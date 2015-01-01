<?php

/**
 * Copyright 2014-2015 Blue Snowman
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

namespace Saber\Data\Ratio {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Bool;
	use \Saber\Data\Double;
	use \Saber\Data\Float;
	use \Saber\Data\Fractional;
	use \Saber\Data\Int32;
	use \Saber\Data\Integer;
	use \Saber\Data\Ratio;
	use \Saber\Data\Trit;

	final class Module extends Data\Module implements Fractional\Module {

		#region Methods -> Arithmetic Operations

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the operand
		 * @return Ratio\Type                                       the result
		 */
		public static function abs(Ratio\Type $x) {
			if (Ratio\Module::isNegative($x)->unbox()) {
				return Ratio\Module::negate($x);
			}
			return $x;
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the left operand
		 * @param Ratio\Type $y                                     the right operand
		 * @return Ratio\Type                                       the result
		 */
		public static function add(Ratio\Type $x, Ratio\Type $y) {
			if (Int32\Module::signum($y->numerator())->unbox() == 0) {
				return $x;
			}
			if (Int32\Module::signum($x->numerator())->unbox() == 0) {
				return $y;
			}
			if (Int32\Module::eq($x->denominator(), $y->denominator())->unbox()) {
				return Ratio\Type::box(Int32\Module::add($x->numerator(), $y->numerator()), $x->denominator());
			}
			return Ratio\Type::make(
				Int32\Module::add(Int32\Module::multiply($x->numerator(), $y->denominator()), Int32\Module::multiply($y->numerator(), $x->denominator())),
				Int32\Module::multiply($x->denominator(), $y->denominator())
			);
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the left operand
		 * @param Ratio\Type $y                                     the right operand
		 * @return Ratio\Type                                       the result
		 */
		public static function divide(Ratio\Type $x, Ratio\Type $y) {
			return Ratio\Module::multiply($x, Ratio\Module::invert($y));
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the left operand
		 * @param Ratio\Type $y                                     the right operand
		 * @return Ratio\Type                                       the result
		 */
		public static function multiply(Ratio\Type $x, Ratio\Type $y) {
			return Ratio\Type::make(
				Int32\Module::multiply($x->numerator(), $y->numerator()),
				Int32\Module::multiply($x->denominator(), $y->denominator())
			);
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the operand
		 * @return Ratio\Type                                       the result
		 */
		public static function negate(Ratio\Type $x) {
			return Ratio\Type::make(Int32\Module::negate($x->numerator()), $x->denominator());
		}

		/**
		 * This method returns the ratio raised to the power of the specified exponent.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the operand
		 * @param Int32\Type $exponent                              the exponent to be raised by
		 * @return Ratio\Type                                       the result
		 */
		public static function pow(Ratio\Type $x, Int32\Type $exponent) {
			return Ratio\Type::make(
				Int32\Module::pow($x->numerator(), $exponent),
				Int32\Module::pow($x->denominator(), $exponent)
			);
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the left operand
		 * @param Ratio\Type $y                                     the right operand
		 * @return Ratio\Type                                       the result
		 */
		public static function subtract(Ratio\Type $x, Ratio\Type $y) {
			return Ratio\Module::add($x, Ratio\Module::negate($y));
		}

		#endregion

		#region Methods -> Basic Operations

		/**
		 * This method returns the reciprocal.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the ratio to be inverted
		 * @return Ratio\Type                                       the reciprocal
		 */
		public static function invert(Ratio\Type $x) {
			return Ratio\Type::make($x->denominator(), $x->numerator());
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the value to be evaluated
		 * @param Ratio\Type $y                                     the default value
		 * @return Ratio\Type                                       the result
		 */
		public static function nvl(Ratio\Type $x = null, Ratio\Type $y = null) {
			return ($x !== null) ? $x : (($y !== null) ? $y : Ratio\Type::zero());
		}

		/**
		 * This method returns the value as a Double. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the object to be converted
		 * @return Double\Type                                      the value as a Double
		 */
		public static function toDouble(Ratio\Type $x) {
			return (Ratio\Module::isInteger($x)->unbox())
				? Int32\Module::toDouble($x->numerator())
				: Double\Module::divide(Int32\Module::toDouble($x->numerator()), Int32\Module::toDouble($x->denominator()));
		}

		/**
		 * This method returns the value as a Float. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the object to be converted
		 * @return Float\Type                                       the value as a Float
		 */
		public static function toFloat(Ratio\Type $x) {
			return Double\Module::toFloat(Ratio\Module::toDouble($x));
		}

		/**
		 * This method returns the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the object to be converted
		 * @return Int32\Type                                       the value as an Int32
		 */
		public static function toInt32(Ratio\Type $x) {
			return Double\Module::toInt32(Ratio\Module::toDouble($x));
		}

		/**
		 * This method returns the value as an Integer. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the object to be converted
		 * @return Integer\Type                                     the value as an Integer
		 */
		public static function toInteger(Ratio\Type $x) {
			return Double\Module::toInteger(Ratio\Module::toDouble($x));
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Ratio\Type $x, Core\Type $y) { // ==
			$type = $x->__typeOf();
			if ($y instanceof $type) {
				return Bool\Module::and_(
					Int32\Module::eq($x->numerator(), $y->numerator()),
					Int32\Module::eq($x->denominator(), $y->denomintor())
				);
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Ratio\Type $x, Core\Type $y) { // ===
			if ($x->__typeOf() === $y->__typeOf()) {
				return Bool\Module::and_(
					Int32\Module::id($x->numerator(), $y->numerator()),
					Int32\Module::id($x->denominator(), $y->denomintor())
				);
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Ratio\Type $x, Core\Type $y) { // !=
			return Bool\Module::not(Ratio\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Ratio\Type $x, Core\Type $y) { // !==
			return Bool\Module::not(Ratio\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the left operand
		 * @param Ratio\Type $y                                     the right operand
		 * @return Trit\Type                                        the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Ratio\Type $x, Ratio\Type $y) {
			return Int32\Module::compare(
				Int32\Module::multiply($x->numerator(), $y->denominator()),
				Int32\Module::multiply($y->numerator(), $x->denominator())
			);
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the left operand
		 * @param Ratio\Type $y                                     the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Ratio\Type $x, Ratio\Type $y) { // >=
			return Bool\Type::box(Ratio\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the left operand
		 * @param Ratio\Type $y                                     the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Ratio\Type $x, Ratio\Type $y) { // >
			return Bool\Type::box(Ratio\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the left operand
		 * @param Ratio\Type $y                                     the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Ratio\Type $x, Ratio\Type $y) { // <=
			return Bool\Type::box(Ratio\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the left operand
		 * @param Ratio\Type $y                                     the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Ratio\Type $x, Ratio\Type $y) { // <
			return Bool\Type::box(Ratio\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the left operand
		 * @param Ratio\Type $y                                     the right operand
		 * @return Ratio\Type                                       the maximum value
		 */
		public static function max(Ratio\Type $x, Ratio\Type $y) {
			return (Ratio\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the left operand
		 * @param Ratio\Type $y                                     the right operand
		 * @return Ratio\Type                                       the minimum value
		 */
		public static function min(Ratio\Type $x, Ratio\Type $y) {
			return (Ratio\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Evaluating Operations

		/**
		 * This method returns whether the ratio is a whole number.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the ratio to be evaluated
		 * @return Bool\Type                                        whether the ratio is a whole
		 *                                                          number
		 */
		public static function isInteger(Ratio\Type $x) {
			return Bool\Module::or_(
				Int32\Module::eq($x->numerator(), Int32\Type::zero()),
				Int32\Module::eq($x->denominator(), Int32\Type::one())
			);
		}

		/**
		 * This method returns whether the operand is a negative number.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the object to be evaluated
		 * @return Bool\Type                                        whether the operand is a negative
		 *                                                          number
		 */
		public static function isNegative(Ratio\Type $x) {
			$a = Int32\Module::isNegative($x->numerator())->unbox();
			$b = Int32\Module::isNegative($x->denominator())->unbox();
			return Bool\Type::box(($a || $b) && ($a != $b));
		}

		#endregion

	}

}