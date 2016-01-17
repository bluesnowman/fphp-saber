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

namespace Saber\Data\IInt32 {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IDouble;
	use \Saber\Data\IFloat;
	use \Saber\Data\IInt32;
	use \Saber\Data\IInteger;
	use \Saber\Data\IIntegral;
	use \Saber\Data\IString;
	use \Saber\Data\ITrit;
	use \Saber\Data\ITuple;

	final class Module extends Data\Module implements IIntegral\Module {

		#region Methods -> Arithmetic Operations

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the operand
		 * @return IInt32\Type                                       the result
		 */
		public static function abs(IInt32\Type $x) {
			return IInt32\Type::box(abs($x->unbox()));
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param IInt32\Type $y                                     the right operand
		 * @return IInt32\Type                                       the result
		 */
		public static function add(IInt32\Type $x, IInt32\Type $y) {
			return IInt32\Type::box($x->unbox() + $y->unbox());
		}

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the operand
		 * @return IInt32\Type                                       the result
		 */
		public static function decrement(IInt32\Type $x) {
			return IInt32\Module::subtract($x, IInt32\Type::one());
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param IInt32\Type $y                                     the right operand
		 * @return IInt32\Type                                       the result
		 */
		public static function divide(IInt32\Type $x, IInt32\Type $y) {
			return IInt32\Type::box(intdiv($x->unbox(), $y->unbox()));
		}

		/**
		 * This method computes the nth factorial number.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $n                                     the operand
		 * @return IInt32\Type                                       the result
		 */
		public static function factorial(IInt32\Type $n) {
			return (IInt32\Module::eq($n, IInt32\Type::zero())->unbox())
				? IInt32\Type::one()
				: IInt32\Module::multiply($n, IInt32\Module::factorial(IInt32\Module::decrement($n)));
		}

		/**
		 * This method computes the nth fibonacci number.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $n                                     the operand
		 * @return IInt32\Type                                       the result
		 */
		public static function fibonacci(IInt32\Type $n) {
			return (IInt32\Module::le($n, IInt32\Type::one())->unbox())
				? $n
				: IInt32\Module::add(IInt32\Module::fibonacci(IInt32\Module::decrement($n)), IInt32\Module::fibonacci(IInt32\Module::subtract($n, IInt32\Type::box(2))));
		}

		/**
		 * This method returns the greatest common divisor.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param IInt32\Type $y                                     the right operand
		 * @return IInt32\Type                                       the result
		 */
		public static function gcd(IInt32\Type $x, IInt32\Type $y) {
			return ($y->unbox() == 0) ? $x : IInt32\Module::gcd($y, IInt32\Module::modulo($x, $y));
		}

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the operand
		 * @return IInt32\Type                                       the result
		 */
		public static function increment(IInt32\Type $x) {
			return IInt32\Module::add($x, IInt32\Type::one());
		}

		/**
		 * This method returns the result of finding the modulus of the specified value against this
		 * object's value.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param IInt32\Type $y                                     the right operand
		 * @return IInt32\Type                                       the result
		 */
		public static function modulo(IInt32\Type $x, IInt32\Type $y) {
			return IInt32\Type::box($x->unbox() % $y->unbox());
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param IInt32\Type $y                                     the right operand
		 * @return IInt32\Type                                       the result
		 */
		public static function multiply(IInt32\Type $x, IInt32\Type $y) {
			return IInt32\Type::box($x->unbox() * $y->unbox());
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the operand
		 * @return IInt32\Type                                       the result
		 */
		public static function negate(IInt32\Type $x) {
			return IInt32\Type::box($x->unbox() * -1);
		}

		/**
		 * This method returns the number raised to the power of the specified exponent.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the operand
		 * @param IInt32\Type $exponent                              the exponent to be raised by
		 * @return IInt32\Type                                       the result
		 */
		public static function pow(IInt32\Type $x, IInt32\Type $exponent) {
			return IInt32\Type::box(pow($x->unbox(), $exponent->unbox()));
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param IInt32\Type $y                                     the right operand
		 * @return IInt32\Type                                       the result
		 */
		public static function subtract(IInt32\Type $x, IInt32\Type $y) {
			return IInt32\Type::box($x->unbox() - $y->unbox());
		}

		#endregion

		#region Methods -> Basic Operations

		/**
		 * This method returns a list of all numbers for the specified sequence.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     where to start
		 * @param Core\Type $y                                      either an integer representing
		 *                                                          the end of the sequence or a
		 *                                                          tuple describing the sequence
		 * @return IArrayList\Type                                   an empty array list
		 */
		public static function sequence(IInt32\Type $x, Core\Type $y) {
			$buffer = array();

			if ($y instanceof ITuple\Type) {
				$s = IInt32\Module::subtract($y->first(), $x);
				$n = $y->second();
			}
			else { // ($y instanceof IInt32\Type)
				$s = IInt32\Type::one();
				$n = $y;
			}

			if (IInt32\Module::isNegative($s)->unbox()) {
				for ($i = $x; IInt32\Module::ge($i, $n)->unbox(); $i = IInt32\Module::add($i, $s)) {
					$buffer[] = $i;
				}
			}
			else {
				for ($i = $x; IInt32\Module::le($i, $n)->unbox(); $i = IInt32\Module::add($i, $s)) {
					$buffer[] = $i;
				}
			}

			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns -1, 0 or 1 when the value is negative, zero, or positive.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the number to be evaluated
		 * @return ITrit\Type                                        the result
		 */
		public static function signum(IInt32\Type $x) {
			return ITrit\Type::make($x->unbox());
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the value to be evaluated
		 * @param IInt32\Type $y                                     the default value
		 * @return IInt32\Type                                       the result
		 */
		public static function nvl(IInt32\Type $x = null, IInt32\Type $y = null) {
			return ($x !== null) ? $x : (($y !== null) ? $y : IInt32\Type::zero());
		}

		/**
		 * This method returns the value as a IDouble. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the object to be converted
		 * @return IDouble\Type                                      the value as a IDouble
		 */
		public static function toDouble(IInt32\Type $x) {
			return IDouble\Type::box($x->unbox());
		}

		/**
		 * This method returns the value as a IFloat. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the object to be converted
		 * @return IFloat\Type                                       the value as a IFloat
		 */
		public static function toFloat(IInt32\Type $x) {
			return IFloat\Type::box($x->unbox());
		}

		/**
		 * This method returns the value as an IInt32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the object to be converted
		 * @return IInt32\Type                                       the value as an IInt32
		 */
		public static function toInt32(IInt32\Type $x) {
			return IInt32\Type::box($x->unbox());
		}

		/**
		 * This method returns the value as an IInteger. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the object to be converted
		 * @return IInteger\Type                                     the value as an IInteger
		 */
		public static function toInteger(IInt32\Type $x) {
			return IInteger\Type::box($x->unbox());
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(IInt32\Type $x, Core\Type $y) { // ==
			$type = $x->__typeOf();
			if ($y instanceof $type) {
				return IBool\Type::box($x->unbox() == $y->unbox());
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(IInt32\Type $x, Core\Type $y) { // ===
			if ($x->__typeOf() === $y->__typeOf()) {
				return IBool\Type::box($x->unbox() === $y->unbox());
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(IInt32\Type $x, Core\Type $y) { // !=
			return IBool\Module::not(IInt32\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(IInt32\Type $x, Core\Type $y) { // !==
			return IBool\Module::not(IInt32\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param IInt32\Type $y                                     the right operand
		 * @return ITrit\Type                                        the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(IInt32\Type $x, IInt32\Type $y) {
			return ITrit\Type::box($x->unbox() <=> $y->unbox());
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param IInt32\Type $y                                     the right operand
		 * @return IBool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(IInt32\Type $x, IInt32\Type $y) { // >=
			return IBool\Type::box(IInt32\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param IInt32\Type $y                                     the right operand
		 * @return IBool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(IInt32\Type $x, IInt32\Type $y) { // >
			return IBool\Type::box(IInt32\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param IInt32\Type $y                                     the right operand
		 * @return IBool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(IInt32\Type $x, IInt32\Type $y) { // <=
			return IBool\Type::box(IInt32\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param IInt32\Type $y                                     the right operand
		 * @return IBool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(IInt32\Type $x, IInt32\Type $y) { // <
			return IBool\Type::box(IInt32\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param IInt32\Type $y                                     the right operand
		 * @return IInt32\Type                                       the maximum value
		 */
		public static function max(IInt32\Type $x, IInt32\Type $y) {
			return (IInt32\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the left operand
		 * @param IInt32\Type $y                                     the right operand
		 * @return IInt32\Type                                       the minimum value
		 */
		public static function min(IInt32\Type $x, IInt32\Type $y) {
			return (IInt32\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Evaluating Operations

		/**
		 * This method evaluates whether the operand is an even number.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the object to be evaluated
		 * @return IBool\Type                                        whether the operand is an even
		 *                                                          number
		 */
		public static function isEven(IInt32\Type $x) {
			return IBool\Type::box(($x->unbox() % 2) == 0);
		}

		/**
		 * This method returns whether the operand is a negative number.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the object to be evaluated
		 * @return IBool\Type                                        whether the operand is a negative
		 *                                                          number
		 */
		public static function isNegative(IInt32\Type $x) {
			return IBool\Type::box($x->unbox() < 0);
		}

		/**
		 * This method evaluates whether the operand is an odd number.
		 *
		 * @access public
		 * @static
		 * @param IInt32\Type $x                                     the object to be evaluated
		 * @return IBool\Type                                        whether the operand is an odd
		 *                                                          number
		 */
		public static function isOdd(IInt32\Type $x) {
			return IBool\Type::box(($x->unbox() % 2) != 0);
		}

		#endregion

	}

}