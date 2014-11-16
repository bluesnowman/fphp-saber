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

namespace Saber\Data {

	use \Saber\Control;
	use \Saber\Data;

	class Double extends Data\Floating {

		#region Methods -> Implementation

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param double $value                                     the value to be assigned
		 */
		public function __construct($value) {
			$this->value = (double) $value;
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString() {
			return sprintf('%F', $this->value);
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @param integer $depth                                    how many levels to unbox
		 * @return mixed                                            the un-boxed value
		 */
		public function unbox($depth = 0) {
			return $this->value;
		}

		#endregion

		#region Methods -> Instantiation

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Data\Type                                        the boxed object
		 */
		public static function box($value/*...*/) {
			return new Data\Double($value);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Data\Type                                        the boxed object
		 */
		public static function create($value/*...*/) {
			return new Data\Double($value);
		}

		/**
		 * This method returns an object with a "-1" value.
		 *
		 * @access public
		 * @static
		 * @return Data\Double                                      the object
		 */
		public static function negative() {
			return new Data\Double(-1.0);
		}

		/**
		 * This method returns an object with a "1" value.
		 *
		 * @access public
		 * @static
		 * @return Data\Double                                      the object
		 */
		public static function one() {
			return new Data\Double(1.0);
		}

		/**
		 * This method returns an object with a "0" value.
		 *
		 * @access public
		 * @static
		 * @return Data\Double                                      the object
		 */
		public static function zero() {
			return new Data\Double(0.0);
		}

		#endregion

		#region Methods -> Arithmetic

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the operand
		 * @return Data\Double                                      the result
		 */
		public static function abs(Data\Double $x) {
			return Data\Double::create(abs($x->unbox()));
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the left operand
		 * @param Data\Double $y                                    the right operand
		 * @return Data\Double                                      the result
		 */
		public static function add(Data\Double $x, Data\Double $y) {
			return Data\Double::create($x->unbox() + $y->unbox());
		}

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the operand
		 * @return Data\Double                                      the result
		 */
		public static function decrement(Data\Double $x) {
			return Data\Double::subtract($x, Data\Double::one());
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the left operand
		 * @param Data\Double $y                                    the right operand
		 * @return Data\Double                                      the result
		 */
		public static function divide(Data\Double $x, Data\Double $y) {
			return Data\Double::create($x->unbox() / $y->unbox());
		}

		/**
		 * This method recursively calculates the greatest common divisor.
		 *
		 * @access protected
		 * @static
		 * @param double $x                                         the left operand
		 * @param double $y                                         the right operand
		 * @return double                                           the result
		 *
		 * @see http://stackoverflow.com/questions/13828011/look-for-the-gcd-greatest-common-divisor-of-more-than-2-integers
		 */
		protected function _gcd($x, $y) {
		    return ($y > 0.01) ? Data\Double::_gcd($y, fmod($x, $y)) : $x;
		}

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the operand
		 * @return Data\Double                                      the result
		 */
		public static function increment(Data\Double $x) {
			return Data\Double::add($x, Data\Double::one());
		}

		/**
		 * This method returns the result of finding the modulus of the specified value against this
		 * object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the left operand
		 * @param Data\Double $y                                    the right operand
		 * @return Data\Double                                      the result
		 */
		public static function modulo(Data\Double $x, Data\Double $y) {
			return Data\Double::create(fmod($x->unbox(), $y->unbox()));
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the left operand
		 * @param Data\Double $y                                    the right operand
		 * @return Data\Double                                      the result
		 */
		public static function multiply(Data\Double $x, Data\Double $y) {
			return Data\Double::create($x->unbox() * $y->unbox());
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the operand
		 * @return Data\Double                                      the result
		 */
		public static function negate(Data\Double $x) {
			return Data\Double::create($x->unbox() * -1.0);
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the left operand
		 * @param Data\Double $y                                    the right operand
		 * @return Data\Double                                      the result
		 */
		public static function subtract(Data\Double $x, Data\Double $y) {
			return Data\Double::create($x->unbox() - $y->unbox());
		}

		#endregion

		#region Methods -> Data Typing

		/**
		 * This method return the value as a Double. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the object to be converted
		 * @return Data\Double                                      the value as a Double
		 */
		public static function toDouble(Data\Double $x) {
			return Data\Double::create($x->unbox());
		}

		/**
		 * This method return the value as a Float. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the object to be converted
		 * @return Data\Float                                       the value as a Float
		 */
		public static function toFloat(Data\Double $x) {
			return Data\Float::create($x->unbox());
		}

		/**
		 * This method return the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the object to be converted
		 * @return Data\Int32                                       the value as an Int32
		 */
		public static function toInt32(Data\Double $x) {
			return Data\Int32::create($x->unbox());
		}

		/**
		 * This method return the value as an Integer. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the object to be converted
		 * @return Data\Integer                                     the value as an Integer
		 */
		public static function toInteger(Data\Double $x) {
			return Data\Integer::create($x->unbox());
		}

		/**
		 * This method returns the value as a String.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the object to be converted
		 * @return Data\String                                      the value as a String
		 */
		public static function toString(Data\Double $x) {
			return Data\String::create($x->__toString());
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the left operand
		 * @param Data\Double $y                                    the right operand
		 * @return Data\Int32                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Data\Double $x, Data\Double $y) {
			$__x = $x->unbox();
			$__y = $y->unbox();

			if ($__x < $__y) {
				return Data\Int32::negative();
			}
			else if ($__x == $__y) {
				return Data\Int32::zero();
			}
			else { // ($__x > $__y)
				return Data\Int32::one();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the left operand
		 * @param Data\Double $y                                    the right operand
		 * @return Data\Bool                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Data\Double $x, Data\Double $y) { // >=
			return Data\Bool::create(Data\Double::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the left operand
		 * @param Data\Double $y                                    the right operand
		 * @return Data\Bool                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Data\Double $x, Data\Double $y) { // >
			return Data\Bool::create(Data\Double::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the left operand
		 * @param Data\Double $y                                    the right operand
		 * @return Data\Bool                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Data\Double $x, Data\Double $y) { // <=
			return Data\Bool::create(Data\Double::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the left operand
		 * @param Data\Double $y                                    the right operand
		 * @return Data\Bool                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Data\Double $x, Data\Double $y) { // <
			return Data\Bool::create(Data\Double::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the left operand
		 * @param Data\Double $y                                    the right operand
		 * @return Data\Double                                      the maximum value
		 */
		public static function max(Data\Double $x, Data\Double $y) {
			return (Data\Double::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the left operand
		 * @param Data\Double $y                                    the right operand
		 * @return Data\Double                                      the minimum value
		 */
		public static function min(Data\Double $x, Data\Double $y) {
			return (Data\Double::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Other

		/**
		 * This method returns a choice block.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the object to be evaluated
		 * @return Control\Monad\Choice                             the choice monad
		 */
		public static function choice(Data\Int32 $x) {
			return Control\Monad::choice($x);
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the object to be evaluated
		 * @return Data\String                                      the object's hash code
		 */
		public static function hashCode(Data\Double $x) {
			return Data\String::create($x->__toString());
		}

		#endregion

		#region Methods -> Validation

		/**
		 * This method returns whether the operand is a negative number.
		 *
		 * @access public
		 * @static
		 * @param Data\Double $x                                    the object to be evaluated
		 * @return Data\Bool                                        whether the operand is a negative
		 *                                                          number
		 */
		public static function isNegative(Data\Double $x) {
			return Data\Bool::create($x->unbox() < 0);
		}

		#endregion

	}

}