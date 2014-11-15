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

namespace Saber\Core\Int32 {

	use \Saber\Control;
	use \Saber\Core;

	class Module {

		#region Methods -> Arithmetic

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the operand
		 * @return Core\Int32                                       the result
		 */
		public static function abs(Core\Int32 $x) {
			return Core\Int32::create(abs($x->unbox()));
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the left operand
		 * @param Core\Int32 $y                                     the right operand
		 * @return Core\Int32                                       the result
		 */
		public static function add(Core\Int32 $x, Core\Int32 $y) {
			return Core\Int32::create($x->unbox() + $y->unbox());
		}

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the operand
		 * @return Core\Int32                                       the result
		 */
		public static function decrement(Core\Int32 $x) {
			return Core\Int32\Module::subtract($x, Core\Int32::one());
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the left operand
		 * @param Core\Int32 $y                                     the right operand
		 * @return Core\Int32                                       the result
		 */
		public static function divide(Core\Int32 $x, Core\Int32 $y) {
			return Core\Int32::create($x->unbox() / $y->unbox());
		}

		/**
		 * This method returns the greatest common divisor.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the left operand
		 * @param Core\Int32 $y                                     the right operand
		 * @return Core\Int32                                       the result
		 */
		public static function gcd(Core\Int32 $x, Core\Int32 $y) {
			return Core\Int32::create(Core\Int32\Module::_gcd(abs($x->unbox()), abs($y->unbox())));
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
		    return $y ? Core\Int32\Module::_gcd($y, $x % $y) : $x;
		}

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the operand
		 * @return Core\Int32                                       the result
		 */
		public static function increment(Core\Int32 $x) {
			return Core\Int32\Module::add($x, Core\Int32::one());
		}

		/**
		 * This method returns the result of finding the modulus of the specified value against this
		 * object's value.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the left operand
		 * @param Core\Int32 $y                                     the right operand
		 * @return Core\Int32                                       the result
		 */
		public static function modulo(Core\Int32 $x, Core\Int32 $y) {
			return Core\Int32::create($x->unbox() % $y->unbox());
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the left operand
		 * @param Core\Int32 $y                                     the right operand
		 * @return Core\Int32                                       the result
		 */
		public static function multiply(Core\Int32 $x, Core\Int32 $y) {
			return Core\Int32::create($x->unbox() * $y->unbox());
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the operand
		 * @return Core\Int32                                       the result
		 */
		public static function negate(Core\Int32 $x) {
			return Core\Int32::create($x->unbox() * -1);
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the left operand
		 * @param Core\Int32 $y                                     the right operand
		 * @return Core\Int32                                       the result
		 */
		public static function subtract(Core\Int32 $x, Core\Int32 $y) {
			return Core\Int32::create($x->unbox() - $y->unbox());
		}

		#endregion

		#region Methods -> Data Typing

		/**
		 * This method return the value as a Double. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the object to be converted
		 * @return Core\Double                                      the value as a Double
		 */
		public static function toDouble(Core\Int32 $x) {
			return Core\Double::create($x->unbox());
		}

		/**
		 * This method return the value as a Float. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the object to be converted
		 * @return Core\Float                                       the value as a Float
		 */
		public static function toFloat(Core\Int32 $x) {
			return Core\Float::create($x->unbox());
		}

		/**
		 * This method return the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the object to be converted
		 * @return Core\Int32                                       the value as an Int32
		 */
		public static function toInt32(Core\Int32 $x) {
			return Core\Int32::create($x->unbox());
		}

		/**
		 * This method return the value as an Integer. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the object to be converted
		 * @return Core\Integer                                     the value as an Integer
		 */
		public static function toInteger(Core\Int32 $x) {
			return Core\Integer::create($x->unbox());
		}

		/**
		 * This method returns the value as a String.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the object to be converted
		 * @return Core\String                                      the value as a String
		 */
		public static function toString(Core\Int32 $x) {
			return Core\String::create($x->__toString());
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the left operand
		 * @param Core\Int32 $y                                     the right operand
		 * @return Core\Int32                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Core\Int32 $x, Core\Int32 $y) {
			$__x = $x->unbox();
			$__y = $y->unbox();

			if ($__x < $__y) {
				return Core\Int32::negative();
			}
			else if ($__x == $__y) {
				return Core\Int32::zero();
			}
			else { // ($__x > $__y)
				return Core\Int32::one();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the left operand
		 * @param Core\Int32 $y                                     the right operand
		 * @return Core\Bool                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Core\Int32 $x, Core\Int32 $y) { // >=
			return (Core\Int32\Module::compare($x, $y)->unbox() >= 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the left operand
		 * @param Core\Int32 $y                                     the right operand
		 * @return Core\Bool                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Core\Int32 $x, Core\Int32 $y) { // >
			return (Core\Int32\Module::compare($x, $y)->unbox() > 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the left operand
		 * @param Core\Int32 $y                                     the right operand
		 * @return Core\Bool                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Core\Int32 $x, Core\Int32 $y) { // <=
			return (Core\Int32\Module::compare($x, $y)->unbox() <= 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the left operand
		 * @param Core\Int32 $y                                     the right operand
		 * @return Core\Bool                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Core\Int32 $x, Core\Int32 $y) { // <
			return (Core\Int32\Module::compare($x, $y)->unbox() < 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the left operand
		 * @param Core\Int32 $y                                     the right operand
		 * @return Core\Int32                                       the maximum value
		 */
		public static function max(Core\Int32 $x, Core\Int32 $y) {
			return (Core\Int32\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the left operand
		 * @param Core\Int32 $y                                     the right operand
		 * @return Core\Int32                                       the minimum value
		 */
		public static function min(Core\Int32 $x, Core\Int32 $y) {
			return (Core\Int32\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Other

		/**
		 * This method returns a choice block.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the object to be evaluated
		 * @return Control\Monad\Choice                             the choice monad
		 */
		public static function choice(Core\Int32 $x) {
			return Control\Monad::choice($x);
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the object to be evaluated
		 * @return Core\String                                      the object's hash code
		 */
		public static function hashCode(Core\Int32 $x) {
			return Core\String::create($x->__toString());
		}

		#endregion

		#region Methods -> Validation

		/**
		 * This method evaluates whether the operand is an even number.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the object to be evaluated
		 * @return Core\Bool                                        whether the operand is an even
		 *                                                          number
		 */
		public static function isEven(Core\Int32 $x) {
			return Core\Bool::create(($x->unbox() % 2) == 0);
		}

		/**
		 * This method evaluates whether the operand is an odd number.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the object to be evaluated
		 * @return Core\Bool                                        whether the operand is an odd
		 *                                                          number
		 */
		public static function isOdd(Core\Int32 $x) {
			return Core\Bool::create(($x->unbox() % 2) != 0);
		}

		/**
		 * This method returns whether the operand is a negative number.
		 *
		 * @access public
		 * @static
		 * @param Core\Int32 $x                                     the object to be evaluated
		 * @return Core\Bool                                        whether the operand is a negative
		 *                                                          number
		 */
		public static function isNegative(Core\Int32 $x) {
			return Core\Bool::create($x->unbox() < 0);
		}

		#endregion

	}

}