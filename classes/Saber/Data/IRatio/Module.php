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

namespace Saber\Data\IRatio {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IBool;
	use \Saber\Data\IDouble;
	use \Saber\Data\IFloat;
	use \Saber\Data\IFractional;
	use \Saber\Data\IInt32;
	use \Saber\Data\IInteger;
	use \Saber\Data\IRatio;
	use \Saber\Data\ITrit;

	final class Module extends Data\Module implements IFractional\Module {

		#region Methods -> Arithmetic Operations

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the operand
		 * @return IRatio\Type                                      the result
		 */
		public static function abs(IRatio\Type $x) : IRatio\Type {
			if (IRatio\Module::isNegative($x)->unbox()) {
				return IRatio\Module::negate($x);
			}
			return $x;
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the left operand
		 * @param IRatio\Type $y                                    the right operand
		 * @return IRatio\Type                                      the result
		 */
		public static function add(IRatio\Type $x, IRatio\Type $y) : IRatio\Type {
			if (IInt32\Module::signum($y->numerator())->unbox() == 0) {
				return $x;
			}
			if (IInt32\Module::signum($x->numerator())->unbox() == 0) {
				return $y;
			}
			if (IInt32\Module::eq($x->denominator(), $y->denominator())->unbox()) {
				return IRatio\Type::box(IInt32\Module::add($x->numerator(), $y->numerator()), $x->denominator());
			}
			return IRatio\Type::make(
				IInt32\Module::add(IInt32\Module::multiply($x->numerator(), $y->denominator()), IInt32\Module::multiply($y->numerator(), $x->denominator())),
				IInt32\Module::multiply($x->denominator(), $y->denominator())
			);
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the left operand
		 * @param IRatio\Type $y                                    the right operand
		 * @return IRatio\Type                                      the result
		 */
		public static function divide(IRatio\Type $x, IRatio\Type $y) : IRatio\Type {
			return IRatio\Module::multiply($x, IRatio\Module::invert($y));
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the left operand
		 * @param IRatio\Type $y                                    the right operand
		 * @return IRatio\Type                                      the result
		 */
		public static function multiply(IRatio\Type $x, IRatio\Type $y) : IRatio\Type {
			return IRatio\Type::make(
				IInt32\Module::multiply($x->numerator(), $y->numerator()),
				IInt32\Module::multiply($x->denominator(), $y->denominator())
			);
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the operand
		 * @return IRatio\Type                                      the result
		 */
		public static function negate(IRatio\Type $x) : IRatio\Type {
			return IRatio\Type::make(IInt32\Module::negate($x->numerator()), $x->denominator());
		}

		/**
		 * This method returns the ratio raised to the power of the specified exponent.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the operand
		 * @param IInt32\Type $exponent                             the exponent to be raised by
		 * @return IRatio\Type                                      the result
		 */
		public static function pow(IRatio\Type $x, IInt32\Type $exponent) : IRatio\Type {
			return IRatio\Type::make(
				IInt32\Module::pow($x->numerator(), $exponent),
				IInt32\Module::pow($x->denominator(), $exponent)
			);
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the left operand
		 * @param IRatio\Type $y                                    the right operand
		 * @return IRatio\Type                                      the result
		 */
		public static function subtract(IRatio\Type $x, IRatio\Type $y) : IRatio\Type {
			return IRatio\Module::add($x, IRatio\Module::negate($y));
		}

		#endregion

		#region Methods -> Basic Operations

		/**
		 * This method returns the reciprocal.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the ratio to be inverted
		 * @return IRatio\Type                                      the reciprocal
		 */
		public static function invert(IRatio\Type $x) : IRatio\Type {
			return IRatio\Type::make($x->denominator(), $x->numerator());
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the value to be evaluated
		 * @param IRatio\Type $y                                    the default value
		 * @return IRatio\Type                                      the result
		 */
		public static function nvl(IRatio\Type $x = null, IRatio\Type $y = null) : IRatio\Type {
			return ($x !== null) ? $x : (($y !== null) ? $y : IRatio\Type::zero());
		}

		/**
		 * This method returns the value as a IDouble. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the object to be converted
		 * @return IDouble\Type                                     the value as a IDouble
		 */
		public static function toDouble(IRatio\Type $x) : IDouble\Type {
			return (IRatio\Module::isInteger($x)->unbox())
				? IInt32\Module::toDouble($x->numerator())
				: IDouble\Module::divide(IInt32\Module::toDouble($x->numerator()), IInt32\Module::toDouble($x->denominator()));
		}

		/**
		 * This method returns the value as a IFloat. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the object to be converted
		 * @return IFloat\Type                                      the value as a IFloat
		 */
		public static function toFloat(IRatio\Type $x) : IFloat\Type {
			return IDouble\Module::toFloat(IRatio\Module::toDouble($x));
		}

		/**
		 * This method returns the value as an IInt32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the object to be converted
		 * @return IInt32\Type                                      the value as an IInt32
		 */
		public static function toInt32(IRatio\Type $x) : IInt32\Type {
			return IDouble\Module::toInt32(IRatio\Module::toDouble($x));
		}

		/**
		 * This method returns the value as an IInteger. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the object to be converted
		 * @return IInteger\Type                                    the value as an IInteger
		 */
		public static function toInteger(IRatio\Type $x) : IInteger\Type {
			return IDouble\Module::toInteger(IRatio\Module::toDouble($x));
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(IRatio\Type $x, Core\Type $y) : IBool\Type { // ==
			$type = $x->__typeOf();
			if ($y instanceof $type) {
				return IBool\Module::and_(
					IInt32\Module::eq($x->numerator(), $y->numerator()),
					IInt32\Module::eq($x->denominator(), $y->denomintor())
				);
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(IRatio\Type $x, Core\Type $y) : IBool\Type { // ===
			if ($x->__typeOf() === $y->__typeOf()) {
				return IBool\Module::and_(
					IInt32\Module::id($x->numerator(), $y->numerator()),
					IInt32\Module::id($x->denominator(), $y->denomintor())
				);
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(IRatio\Type $x, Core\Type $y) : IBool\Type { // !=
			return IBool\Module::not(IRatio\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(IRatio\Type $x, Core\Type $y) : IBool\Type { // !==
			return IBool\Module::not(IRatio\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the left operand
		 * @param IRatio\Type $y                                    the right operand
		 * @return ITrit\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(IRatio\Type $x, IRatio\Type $y) : ITrit\Type {
			return IInt32\Module::compare(
				IInt32\Module::multiply($x->numerator(), $y->denominator()),
				IInt32\Module::multiply($y->numerator(), $x->denominator())
			);
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the left operand
		 * @param IRatio\Type $y                                    the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(IRatio\Type $x, IRatio\Type $y) : IBool\Type  { // >=
			return IBool\Type::box(IRatio\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the left operand
		 * @param IRatio\Type $y                                    the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(IRatio\Type $x, IRatio\Type $y) : IBool\Type  { // >
			return IBool\Type::box(IRatio\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the left operand
		 * @param IRatio\Type $y                                    the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(IRatio\Type $x, IRatio\Type $y) : IBool\Type  { // <=
			return IBool\Type::box(IRatio\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the left operand
		 * @param IRatio\Type $y                                    the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(IRatio\Type $x, IRatio\Type $y) : IBool\Type  { // <
			return IBool\Type::box(IRatio\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the left operand
		 * @param IRatio\Type $y                                    the right operand
		 * @return IRatio\Type                                      the maximum value
		 */
		public static function max(IRatio\Type $x, IRatio\Type $y) : IRatio\Type {
			return (IRatio\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the left operand
		 * @param IRatio\Type $y                                    the right operand
		 * @return IRatio\Type                                      the minimum value
		 */
		public static function min(IRatio\Type $x, IRatio\Type $y) : IRatio\Type {
			return (IRatio\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Evaluating Operations

		/**
		 * This method returns whether the ratio is a whole number.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the ratio to be evaluated
		 * @return IBool\Type                                       whether the ratio is a whole
		 *                                                          number
		 */
		public static function isInteger(IRatio\Type $x) : IBool\Type {
			return IBool\Module::or_(
				IInt32\Module::eq($x->numerator(), IInt32\Type::zero()),
				IInt32\Module::eq($x->denominator(), IInt32\Type::one())
			);
		}

		/**
		 * This method returns whether the operand is a negative number.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                    the object to be evaluated
		 * @return IBool\Type                                       whether the operand is a negative
		 *                                                          number
		 */
		public static function isNegative(IRatio\Type $x) : IBool\Type {
			$a = IInt32\Module::isNegative($x->numerator())->unbox();
			$b = IInt32\Module::isNegative($x->denominator())->unbox();
			return IBool\Type::box(($a || $b) && ($a != $b));
		}

		#endregion

	}

}