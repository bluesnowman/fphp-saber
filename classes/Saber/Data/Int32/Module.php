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

namespace Saber\Data\Int32 {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Bool;
	use \Saber\Data\Double;
	use \Saber\Data\Float;
	use \Saber\Data\Int32;
	use \Saber\Data\Integer;
	use \Saber\Data\Integral;
	use \Saber\Data\String;
	use \Saber\Data\Tuple;

	class Module extends Data\Module implements Integral\Module {

		#region Methods -> Arithmetic Operations

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the operand
		 * @return Int32\Type                                       the result
		 */
		public static function abs(Int32\Type $x) {
			return Int32\Type::box(abs($x->unbox()));
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Int32\Type $y                                     the right operand
		 * @return Int32\Type                                       the result
		 */
		public static function add(Int32\Type $x, Int32\Type $y) {
			return Int32\Type::box($x->unbox() + $y->unbox());
		}

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the operand
		 * @return Int32\Type                                       the result
		 */
		public static function decrement(Int32\Type $x) {
			return Int32\Module::subtract($x, Int32\Type::one());
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Int32\Type $y                                     the right operand
		 * @return Int32\Type                                       the result
		 */
		public static function divide(Int32\Type $x, Int32\Type $y) {
			return Int32\Type::box($x->unbox() / $y->unbox());
		}

		/**
		 * This method computes the nth factorial number.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $n                                     the operand
		 * @return Int32\Type                                       the result
		 */
		public static function factorial(Int32\Type $n) {
			return (Int32\Module::eq($n, Int32\Type::zero())->unbox())
				? Int32\Type::one()
				: Int32\Module::multiply($n, Int32\Module::factorial(Int32\Module::decrement($n)));
		}

		/**
		 * This method computes the nth fibonacci number.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $n                                     the operand
		 * @return Int32\Type                                       the result
		 */
		public static function fibonacci(Int32\Type $n) {
			return (Int32\Module::le($n, Int32\Type::one())->unbox())
				? $n
				: Int32\Module::add(Int32\Module::fibonacci(Int32\Module::decrement($n)), Int32\Module::fibonacci(Int32\Module::subtract($n, Int32\Type::box(2))));
		}

		/**
		 * This method returns the greatest common divisor.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Int32\Type $y                                     the right operand
		 * @return Int32\Type                                       the result
		 */
		public static function gcd(Int32\Type $x, Int32\Type $y) {
			return Int32\Type::box(Int32\Module::_gcd(abs($x->unbox()), abs($y->unbox())));
		}

		/**
		 * This method recursively calculates the greatest common divisor.
		 *
		 * @access protected
		 * @static
		 * @param integer $x                                        the left operand
		 * @param integer $y                                        the right operand
		 * @return integer                                          the result
		 *
		 * @see http://stackoverflow.com/questions/13828011/look-for-the-gcd-greatest-common-divisor-of-more-than-2-integers
		 */
		protected static function _gcd($x, $y) {
		    return $y ? Int32\Module::_gcd($y, $x % $y) : $x;
		}

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the operand
		 * @return Int32\Type                                       the result
		 */
		public static function increment(Int32\Type $x) {
			return Int32\Module::add($x, Int32\Type::one());
		}

		/**
		 * This method returns the result of finding the modulus of the specified value against this
		 * object's value.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Int32\Type $y                                     the right operand
		 * @return Int32\Type                                       the result
		 */
		public static function modulo(Int32\Type $x, Int32\Type $y) {
			return Int32\Type::box($x->unbox() % $y->unbox());
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Int32\Type $y                                     the right operand
		 * @return Int32\Type                                       the result
		 */
		public static function multiply(Int32\Type $x, Int32\Type $y) {
			return Int32\Type::box($x->unbox() * $y->unbox());
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the operand
		 * @return Int32\Type                                       the result
		 */
		public static function negate(Int32\Type $x) {
			return Int32\Type::box($x->unbox() * -1);
		}

		/**
		 * This method returns the number raised to the power of the specified exponent.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the operand
		 * @param Int32\Type $exponent                              the exponent to be raised by
		 * @return Int32\Type                                       the result
		 */
		public static function pow(Int32\Type $x, Int32\Type $exponent) {
			return Int32\Type::box(pow($x->unbox(), $exponent->unbox()));
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Int32\Type $y                                     the right operand
		 * @return Int32\Type                                       the result
		 */
		public static function subtract(Int32\Type $x, Int32\Type $y) {
			return Int32\Type::box($x->unbox() - $y->unbox());
		}

		#endregion

		#region Methods -> Basic Operations

		/**
		 * This method returns a list of all numbers for the specified sequence.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     where to start
		 * @param Core\Type $y                                      either an integer representing
		 *                                                          the end of the sequence or a
		 *                                                          tuple describing the sequence
		 * @return ArrayList\Type                                   an empty array list
		 */
		public static function sequence(Int32\Type $x, Core\Type $y) {
			$buffer = array();

			if ($y instanceof Tuple\Type) {
				$s = Int32\Module::subtract($y->first(), $x);
				$n = $y->second();
			}
			else { // ($y instanceof Int32\Type)
				$s = Int32\Type::one();
				$n = $y;
			}

			if (Int32\Module::isNegative($s)->unbox()) {
				for ($i = $x; Int32\Module::ge($i, $n)->unbox(); $i = Int32\Module::add($i, $s)) {
					$buffer[] = $i;
				}
			}
			else {
				for ($i = $x; Int32\Module::le($i, $n)->unbox(); $i = Int32\Module::add($i, $s)) {
					$buffer[] = $i;
				}
			}

			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method returns -1, 0 or 1 when the value is negative, zero, or positive.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the number to be evaluated
		 * @return Int32\Type                                       the result
		 */
		public static function signum(Int32\Type $x) {
			$value = $x->unbox();
			if ($value < 0) {
				return Int32\Type::negative();
			}
			else if ($value == 0) {
				return Int32\Type::zero();
			}
			else { // ($value > 0)
				return Int32\Type::one();
			}
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the value to be evaluated
		 * @param Int32\Type $y                                     the default value
		 * @return Int32\Type                                       the result
		 */
		public static function nvl(Int32\Type $x = null, Int32\Type $y = null) {
			return ($x !== null) ? $x : (($y !== null) ? $y : Int32\Type::zero());
		}

		/**
		 * This method returns the value as a Double. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the object to be converted
		 * @return Double\Type                                      the value as a Double
		 */
		public static function toDouble(Int32\Type $x) {
			return Double\Type::box($x->unbox());
		}

		/**
		 * This method returns the value as a Float. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the object to be converted
		 * @return Float\Type                                       the value as a Float
		 */
		public static function toFloat(Int32\Type $x) {
			return Float\Type::box($x->unbox());
		}

		/**
		 * This method returns the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the object to be converted
		 * @return Int32\Type                                       the value as an Int32
		 */
		public static function toInt32(Int32\Type $x) {
			return Int32\Type::box($x->unbox());
		}

		/**
		 * This method returns the value as an Integer. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the object to be converted
		 * @return Integer\Type                                     the value as an Integer
		 */
		public static function toInteger(Int32\Type $x) {
			return Integer\Type::box($x->unbox());
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Int32\Type $x, Core\Type $y) { // ==
			$type = $x->__typeOf();
			if ($y instanceof $type) {
				return Bool\Type::box($x->unbox() == $y->unbox());
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Int32\Type $x, Core\Type $y) { // ===
			if ($x->__typeOf() === $y->__typeOf()) {
				return Bool\Type::box($x->unbox() === $y->unbox());
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Int32\Type $x, Core\Type $y) { // !=
			return Bool\Module::not(Int32\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Int32\Type $x, Core\Type $y) { // !==
			return Bool\Module::not(Int32\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Int32\Type $y                                     the right operand
		 * @return Int32\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Int32\Type $x, Int32\Type $y) {
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

			if ($__x < $__y) {
				return Int32\Type::negative();
			}
			else if ($__x == $__y) {
				return Int32\Type::zero();
			}
			else { // ($__x > $__y)
				return Int32\Type::one();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Int32\Type $y                                     the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Int32\Type $x, Int32\Type $y) { // >=
			return Bool\Type::box(Int32\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Int32\Type $y                                     the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Int32\Type $x, Int32\Type $y) { // >
			return Bool\Type::box(Int32\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Int32\Type $y                                     the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Int32\Type $x, Int32\Type $y) { // <=
			return Bool\Type::box(Int32\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Int32\Type $y                                     the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Int32\Type $x, Int32\Type $y) { // <
			return Bool\Type::box(Int32\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Int32\Type $y                                     the right operand
		 * @return Int32\Type                                       the maximum value
		 */
		public static function max(Int32\Type $x, Int32\Type $y) {
			return (Int32\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the left operand
		 * @param Int32\Type $y                                     the right operand
		 * @return Int32\Type                                       the minimum value
		 */
		public static function min(Int32\Type $x, Int32\Type $y) {
			return (Int32\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Evaluating Operations

		/**
		 * This method evaluates whether the operand is an even number.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the object to be evaluated
		 * @return Bool\Type                                        whether the operand is an even
		 *                                                          number
		 */
		public static function isEven(Int32\Type $x) {
			return Bool\Type::box(($x->unbox() % 2) == 0);
		}

		/**
		 * This method evaluates whether the operand is an odd number.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the object to be evaluated
		 * @return Bool\Type                                        whether the operand is an odd
		 *                                                          number
		 */
		public static function isOdd(Int32\Type $x) {
			return Bool\Type::box(($x->unbox() % 2) != 0);
		}

		/**
		 * This method returns whether the operand is a negative number.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the object to be evaluated
		 * @return Bool\Type                                        whether the operand is a negative
		 *                                                          number
		 */
		public static function isNegative(Int32\Type $x) {
			return Bool\Type::box($x->unbox() < 0);
		}

		#endregion

	}

}