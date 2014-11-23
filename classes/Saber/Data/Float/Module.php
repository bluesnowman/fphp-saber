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

namespace Saber\Data\Float {

	use \Saber\Control;
	use \Saber\Data;

	class Module extends Floating\Type {

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
			return new Data\Float($value);
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
			return new Data\Float($value);
		}

		/**
		 * This method returns an object with a "-1" value.
		 *
		 * @access public
		 * @static
		 * @return Data\Float                                       the object
		 */
		public static function negative() {
			return new Data\Float(-1.0);
		}

		/**
		 * This method returns an object with a "1" value.
		 *
		 * @access public
		 * @static
		 * @return Data\Float                                       the object
		 */
		public static function one() {
			return new Data\Float(1.0);
		}

		/**
		 * This method returns an object with a "0" value.
		 *
		 * @access public
		 * @static
		 * @return Data\Float                                       the object
		 */
		public static function zero() {
			return new Data\Float(0.0);
		}

		#endregion

		#region Methods -> Arithmetic

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the operand
		 * @return Data\Float                                       the result
		 */
		public static function abs(Float\Type $x) {
			return Float\Module::create(abs($x->unbox()));
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the left operand
		 * @param Float\Type $y                                     the right operand
		 * @return Data\Float                                       the result
		 */
		public static function add(Float\Type $x, Float\Type $y) {
			return Float\Module::create($x->unbox() + $y->unbox());
		}

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the operand
		 * @return Data\Float                                       the result
		 */
		public static function decrement(Float\Type $x) {
			return Float\Module::subtract($x, Float\Module::one());
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the left operand
		 * @param Float\Type $y                                     the right operand
		 * @return Data\Float                                       the result
		 */
		public static function divide(Float\Type $x, Float\Type $y) {
			return Float\Module::create($x->unbox() / $y->unbox());
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
		    return ($y > 0.01) ? Float\Module::_gcd($y, fmod($x, $y)) : $x;
		}

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the operand
		 * @return Data\Float                                       the result
		 */
		public static function increment(Float\Type $x) {
			return Float\Module::add($x, Float\Module::one());
		}

		/**
		 * This method returns the result of finding the modulus of the specified value against this
		 * object's value.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the left operand
		 * @param Float\Type $y                                     the right operand
		 * @return Data\Float                                       the result
		 */
		public static function modulo(Float\Type $x, Float\Type $y) {
			return Float\Module::create(fmod($x->unbox(), $y->unbox()));
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the left operand
		 * @param Float\Type $y                                     the right operand
		 * @return Data\Float                                       the result
		 */
		public static function multiply(Float\Type $x, Float\Type $y) {
			return Float\Module::create($x->unbox() * $y->unbox());
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the operand
		 * @return Data\Float                                       the result
		 */
		public static function negate(Float\Type $x) {
			return Float\Module::create($x->unbox() * -1.0);
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the left operand
		 * @param Float\Type $y                                     the right operand
		 * @return Data\Float                                       the result
		 */
		public static function subtract(Float\Type $x, Float\Type $y) {
			return Float\Module::create($x->unbox() - $y->unbox());
		}

		#endregion

		#region Methods -> Data Typing

		/**
		 * This method return the value as a Double. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the object to be converted
		 * @return Data\Double                                      the value as a Double
		 */
		public static function toDouble(Float\Type $x) {
			return Double\Module::create($x->unbox());
		}

		/**
		 * This method return the value as a Float. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the object to be converted
		 * @return Data\Float                                       the value as a Float
		 */
		public static function toFloat(Float\Type $x) {
			return Float\Module::create($x->unbox());
		}

		/**
		 * This method return the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the object to be converted
		 * @return Data\Int32                                       the value as an Int32
		 */
		public static function toInt32(Float\Type $x) {
			return Data\Int32::create($x->unbox());
		}

		/**
		 * This method return the value as an Integer. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the object to be converted
		 * @return Data\Integer                                     the value as an Integer
		 */
		public static function toInteger(Float\Type $x) {
			return Data\Integer::create($x->unbox());
		}

		/**
		 * This method returns the value as a String.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the object to be converted
		 * @return Data\String                                      the value as a String
		 */
		public static function toString(Float\Type $x) {
			return String\Module::create($x->__toString());
		}

		#endregion

		#region Methods -> Equality

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Float\Type $x, Data\Type $y) { // ==
			$class = get_class($x);
			if ($y instanceof $class) {
				return Bool\Module::create($x->unbox() == $y->unbox());
			}
			return Bool\Module::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Float\Type $x, Data\Type $y) { // ===
			if (get_class($x) === get_class($y)) {
				return Bool\Module::create($x->unbox() === $y->unbox());
			}
			return Bool\Module::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Float\Type $x, Data\Type $y) { // !=
			return Bool\Module::not(Float\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Float\Type $x, Data\Type $y) { // !==
			return Bool\Module::not(Float\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the left operand
		 * @param Float\Type $y                                     the right operand
		 * @return Data\Int32                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Float\Type $x, Float\Type $y) {
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
		 * @param Float\Type $x                                     the left operand
		 * @param Float\Type $y                                     the right operand
		 * @return Data\Bool                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Float\Type $x, Float\Type $y) { // >=
			return Bool\Module::create(Float\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the left operand
		 * @param Float\Type $y                                     the right operand
		 * @return Data\Bool                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Float\Type $x, Float\Type $y) { // >
			return Bool\Module::create(Float\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the left operand
		 * @param Float\Type $y                                     the right operand
		 * @return Data\Bool                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Float\Type $x, Float\Type $y) { // <=
			return Bool\Module::create(Float\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the left operand
		 * @param Float\Type $y                                     the right operand
		 * @return Data\Bool                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Float\Type $x, Float\Type $y) { // <
			return Bool\Module::create(Float\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the left operand
		 * @param Float\Type $y                                     the right operand
		 * @return Data\Float                                       the maximum value
		 */
		public static function max(Float\Type $x, Float\Type $y) {
			return (Float\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the left operand
		 * @param Float\Type $y                                     the right operand
		 * @return Data\Float                                       the minimum value
		 */
		public static function min(Float\Type $x, Float\Type $y) {
			return (Float\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
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
		 * @param Float\Type $x                                     the object to be evaluated
		 * @return Data\String                                      the object's hash code
		 */
		public static function hashCode(Float\Type $x) {
			return String\Module::create($x->__toString());
		}

		#endregion
		
		#region Methods -> Validation

		/**
		 * This method returns whether the operand is a negative number.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the object to be evaluated
		 * @return Data\Bool                                        whether the operand is a negative
		 *                                                          number
		 */
		public static function isNegative(Float\Type $x) {
			return Bool\Module::create($x->unbox() < 0);
		}

		#endregion
		
	}

}