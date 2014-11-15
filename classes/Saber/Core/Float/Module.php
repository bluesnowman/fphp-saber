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

namespace Saber\Core\Float {

	use \Saber\Control;
	use \Saber\Core;

	class Module {

		#region Methods -> Arithmetic

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the operand
		 * @return Core\Float                                       the result
		 */
		public static function abs(Core\Float $x) {
			return Core\Float::create(abs($x->unbox()));
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the left operand
		 * @param Core\Float $y                                     the right operand
		 * @return Core\Float                                       the result
		 */
		public static function add(Core\Float $x, Core\Float $y) {
			return Core\Float::create($x->unbox() + $y->unbox());
		}

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the operand
		 * @return Core\Float                                       the result
		 */
		public static function decrement(Core\Float $x) {
			return Core\Float\Module::subtract($x, Core\Float::one());
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the left operand
		 * @param Core\Float $y                                     the right operand
		 * @return Core\Float                                       the result
		 */
		public static function divide(Core\Float $x, Core\Float $y) {
			return Core\Float::create($x->unbox() / $y->unbox());
		}

		/**
		 * This method recursively calculates the greatest common divisor.
		 *
		 * @access protected
		 * @static
		 * @param float $x                                          the left operand
		 * @param float $y                                          the right operand
		 * @return float                                            the result
		 *
		 * @see http://stackoverflow.com/questions/13828011/look-for-the-gcd-greatest-common-divisor-of-more-than-2-integers
		 */
		protected function _gcd($x, $y) {
		    return ($y > 0.01) ? Core\Float\Module::_gcd($y, fmod($x, $y)) : $x;
		}

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the operand
		 * @return Core\Float                                       the result
		 */
		public static function increment(Core\Float $x) {
			return Core\Float\Module::add($x, Core\Float::one());
		}

		/**
		 * This method returns the result of finding the modulus of the specified value against this
		 * object's value.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the left operand
		 * @param Core\Float $y                                     the right operand
		 * @return Core\Float                                       the result
		 */
		public static function modulo(Core\Float $x, Core\Float $y) {
			return Core\Float::create(fmod($x->unbox(), $y->unbox()));
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the left operand
		 * @param Core\Float $y                                     the right operand
		 * @return Core\Float                                       the result
		 */
		public static function multiply(Core\Float $x, Core\Float $y) {
			return Core\Float::create($x->unbox() * $y->unbox());
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the operand
		 * @return Core\Float                                       the result
		 */
		public static function negate(Core\Float $x) {
			return Core\Float::create($x->unbox() * -1.0);
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the left operand
		 * @param Core\Float $y                                     the right operand
		 * @return Core\Float                                       the result
		 */
		public static function subtract(Core\Float $x, Core\Float $y) {
			return Core\Float::create($x->unbox() - $y->unbox());
		}

		#endregion

		#region Methods -> Data Typing

		/**
		 * This method return the value as a Double. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the object to be converted
		 * @return Core\Double                                      the value as a Double
		 */
		public static function toDouble(Core\Float $x) {
			return Core\Double::create($x->unbox());
		}

		/**
		 * This method return the value as a Float. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the object to be converted
		 * @return Core\Float                                       the value as a Float
		 */
		public static function toFloat(Core\Float $x) {
			return Core\Float::create($x->unbox());
		}

		/**
		 * This method return the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the object to be converted
		 * @return Core\Int32                                       the value as an Int32
		 */
		public static function toInt32(Core\Float $x) {
			return Core\Int32::create($x->unbox());
		}

		/**
		 * This method return the value as an Integer. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the object to be converted
		 * @return Core\Integer                                     the value as an Integer
		 */
		public static function toInteger(Core\Float $x) {
			return Core\Integer::create($x->unbox());
		}

		/**
		 * This method returns the value as a String.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the object to be converted
		 * @return Core\String                                      the value as a String
		 */
		public static function toString(Core\Float $x) {
			return Core\String::create($x->__toString());
		}

		#endregion
		
		#region Methods -> Ordering

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the left operand
		 * @param Core\Float $y                                     the right operand
		 * @return Core\Int32                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Core\Float $x, Core\Float $y) {
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
		 * @param Core\Float $x                                     the left operand
		 * @param Core\Float $y                                     the right operand
		 * @return Core\Bool                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Core\Float $x, Core\Float $y) { // >=
			return (Core\Float\Module::compare($x, $y)->unbox() >= 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the left operand
		 * @param Core\Float $y                                     the right operand
		 * @return Core\Bool                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Core\Float $x, Core\Float $y) { // >
			return (Core\Float\Module::compare($x, $y)->unbox() > 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the left operand
		 * @param Core\Float $y                                     the right operand
		 * @return Core\Bool                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Core\Float $x, Core\Float $y) { // <=
			return (Core\Float\Module::compare($x, $y)->unbox() <= 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the left operand
		 * @param Core\Float $y                                     the right operand
		 * @return Core\Bool                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Core\Float $x, Core\Float $y) { // <
			return (Core\Float\Module::compare($x, $y)->unbox() < 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the left operand
		 * @param Core\Float $y                                     the right operand
		 * @return Core\Float                                       the maximum value
		 */
		public static function max(Core\Float $x, Core\Float $y) {
			return (Core\Float\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the left operand
		 * @param Core\Float $y                                     the right operand
		 * @return Core\Float                                       the minimum value
		 */
		public static function min(Core\Float $x, Core\Float $y) {
			return (Core\Float\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
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
		 * @param Core\Float $x                                     the object to be evaluated
		 * @return Core\String                                      the object's hash code
		 */
		public static function hashCode(Core\Float $x) {
			return Core\String::create($x->__toString());
		}

		#endregion
		
		#region Methods -> Validation
		
		/**
		 * This method returns whether the operand is a negative number.
		 *
		 * @access public
		 * @static
		 * @param Core\Float $x                                     the object to be evaluated
		 * @return Core\Bool                                        whether the operand is a negative
		 *                                                          number
		 */
		public static function isNegative(Core\Float $x) {
			return Core\Bool::create($x->unbox() < 0);
		}

		#endregion
		
	}

}