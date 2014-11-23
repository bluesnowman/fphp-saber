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

	use \Saber\Control;
	use \Saber\Data;
	use \Saber\Throwable;

	class Module extends Data\Integral {

		#region Methods -> Implementation

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param integer $value                                    the value to be assigned
		 */
		public function __construct($value) {
			$this->value = (int) $value;
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString() {
			return sprintf('%d', $this->value);
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
			return new Data\Int32($value);
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
			return new Data\Int32($value);
		}

		/**
		 * This method returns an object with a "-1" value.
		 *
		 * @access public
		 * @static
		 * @return Data\Int32                                       the object
		 */
		public static function negative() {
			return new Data\Int32(-1);
		}

		/**
		 * This method returns an object with a "1" value.
		 *
		 * @access public
		 * @static
		 * @return Data\Int32                                       the object
		 */
		public static function one() {
			return new Data\Int32(1);
		}

		/**
		 * This method returns an object with a "0" value.
		 *
		 * @access public
		 * @static
		 * @return Data\Int32                                       the object
		 */
		public static function zero() {
			return new Data\Int32(0);
		}

		#endregion

		#region Methods -> Arithmetic

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the operand
		 * @return Data\Int32                                       the result
		 */
		public static function abs(Data\Int32 $x) {
			return Data\Int32::create(abs($x->unbox()));
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Int32 $y                                     the right operand
		 * @return Data\Int32                                       the result
		 */
		public static function add(Data\Int32 $x, Data\Int32 $y) {
			return Data\Int32::create($x->unbox() + $y->unbox());
		}

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the operand
		 * @return Data\Int32                                       the result
		 */
		public static function decrement(Data\Int32 $x) {
			return Data\Int32::subtract($x, Data\Int32::one());
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Int32 $y                                     the right operand
		 * @return Data\Int32                                       the result
		 */
		public static function divide(Data\Int32 $x, Data\Int32 $y) {
			return Data\Int32::create($x->unbox() / $y->unbox());
		}

		/**
		 * This method returns the greatest common divisor.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Int32 $y                                     the right operand
		 * @return Data\Int32                                       the result
		 */
		public static function gcd(Data\Int32 $x, Data\Int32 $y) {
			return Data\Int32::create(Data\Int32::_gcd(abs($x->unbox()), abs($y->unbox())));
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
		    return $y ? Data\Int32::_gcd($y, $x % $y) : $x;
		}

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the operand
		 * @return Data\Int32                                       the result
		 */
		public static function increment(Data\Int32 $x) {
			return Data\Int32::add($x, Data\Int32::one());
		}

		/**
		 * This method returns the result of finding the modulus of the specified value against this
		 * object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Int32 $y                                     the right operand
		 * @return Data\Int32                                       the result
		 */
		public static function modulo(Data\Int32 $x, Data\Int32 $y) {
			return Data\Int32::create($x->unbox() % $y->unbox());
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Int32 $y                                     the right operand
		 * @return Data\Int32                                       the result
		 */
		public static function multiply(Data\Int32 $x, Data\Int32 $y) {
			return Data\Int32::create($x->unbox() * $y->unbox());
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the operand
		 * @return Data\Int32                                       the result
		 */
		public static function negate(Data\Int32 $x) {
			return Data\Int32::create($x->unbox() * -1);
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Int32 $y                                     the right operand
		 * @return Data\Int32                                       the result
		 */
		public static function subtract(Data\Int32 $x, Data\Int32 $y) {
			return Data\Int32::create($x->unbox() - $y->unbox());
		}

		#endregion

		#region Methods -> Data Typing

		/**
		 * This method return the value as a Double. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the object to be converted
		 * @return Data\Double                                      the value as a Double
		 */
		public static function toDouble(Data\Int32 $x) {
			return Data\Double::create($x->unbox());
		}

		/**
		 * This method return the value as a Float. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the object to be converted
		 * @return Data\Float                                       the value as a Float
		 */
		public static function toFloat(Data\Int32 $x) {
			return Data\Float::create($x->unbox());
		}

		/**
		 * This method return the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the object to be converted
		 * @return Data\Int32                                       the value as an Int32
		 */
		public static function toInt32(Data\Int32 $x) {
			return Data\Int32::create($x->unbox());
		}

		/**
		 * This method return the value as an Integer. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the object to be converted
		 * @return Data\Integer                                     the value as an Integer
		 */
		public static function toInteger(Data\Int32 $x) {
			return Data\Integer::create($x->unbox());
		}

		/**
		 * This method returns the value as a String.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the object to be converted
		 * @return Data\String                                      the value as a String
		 */
		public static function toString(Data\Int32 $x) {
			return Data\String::create($x->__toString());
		}

		#endregion

		#region Methods -> Equality

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Data\Int32 $x, Data\Type $y) { // ==
			$class = get_class($x);
			if ($y instanceof $class) {
				return Data\Bool::create($x->unbox() == $y->unbox());
			}
			return Data\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Data\Int32 $x, Data\Type $y) { // ===
			if (get_class($x) === get_class($y)) {
				return Data\Bool::create($x->unbox() === $y->unbox());
			}
			return Data\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Data\Int32 $x, Data\Type $y) { // !=
			return Data\Bool::not(Data\Int32::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Data\Int32 $x, Data\Type $y) { // !==
			return Data\Bool::not(Data\Int32::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Int32 $y                                     the right operand
		 * @return Data\Int32                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Data\Int32 $x, Data\Int32 $y) {
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
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Int32 $y                                     the right operand
		 * @return Data\Bool                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Data\Int32 $x, Data\Int32 $y) { // >=
			return Data\Bool::create(Data\Int32::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Int32 $y                                     the right operand
		 * @return Data\Bool                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Data\Int32 $x, Data\Int32 $y) { // >
			return Data\Bool::create(Data\Int32::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Int32 $y                                     the right operand
		 * @return Data\Bool                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Data\Int32 $x, Data\Int32 $y) { // <=
			return Data\Bool::create(Data\Int32::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Int32 $y                                     the right operand
		 * @return Data\Bool                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Data\Int32 $x, Data\Int32 $y) { // <
			return Data\Bool::create(Data\Int32::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Int32 $y                                     the right operand
		 * @return Data\Int32                                       the maximum value
		 */
		public static function max(Data\Int32 $x, Data\Int32 $y) {
			return (Data\Int32::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the left operand
		 * @param Data\Int32 $y                                     the right operand
		 * @return Data\Int32                                       the minimum value
		 */
		public static function min(Data\Int32 $x, Data\Int32 $y) {
			return (Data\Int32::compare($x, $y)->unbox() <= 0) ? $x : $y;
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
		 * @param Data\Int32 $x                                     the object to be evaluated
		 * @return Data\String                                      the object's hash code
		 */
		public static function hashCode(Data\Int32 $x) {
			return Data\String::create($x->__toString());
		}

		#endregion

		#region Methods -> Validation

		/**
		 * This method evaluates whether the operand is an even number.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the object to be evaluated
		 * @return Data\Bool                                        whether the operand is an even
		 *                                                          number
		 */
		public static function isEven(Data\Int32 $x) {
			return Data\Bool::create(($x->unbox() % 2) == 0);
		}

		/**
		 * This method evaluates whether the operand is an odd number.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the object to be evaluated
		 * @return Data\Bool                                        whether the operand is an odd
		 *                                                          number
		 */
		public static function isOdd(Data\Int32 $x) {
			return Data\Bool::create(($x->unbox() % 2) != 0);
		}

		/**
		 * This method returns whether the operand is a negative number.
		 *
		 * @access public
		 * @static
		 * @param Data\Int32 $x                                     the object to be evaluated
		 * @return Data\Bool                                        whether the operand is a negative
		 *                                                          number
		 */
		public static function isNegative(Data\Int32 $x) {
			return Data\Bool::create($x->unbox() < 0);
		}

		#endregion

	}

}