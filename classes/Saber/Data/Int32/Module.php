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
	use \Saber\Data\Bool;
	use \Saber\Data\Double;
	use \Saber\Data\Float;
	use \Saber\Data\Int32;
	use \Saber\Data\Integer;
	use \Saber\Data\Integral;
	use \Saber\Data\String;

	class Module extends Integral\Module {

		#region Methods -> Instantiation

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Int32\Type                                       the boxed object
		 */
		public static function box($value/*...*/) {
			return new Int32\Type($value);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Int32\Type                                       the boxed object
		 */
		public static function create($value/*...*/) {
			return new Int32\Type($value);
		}

		/**
		 * This method returns an object with a "-1" value.
		 *
		 * @access public
		 * @static
		 * @return Int32\Type                                       the object
		 */
		public static function negative() {
			return new Int32\Type(-1);
		}

		/**
		 * This method returns an object with a "1" value.
		 *
		 * @access public
		 * @static
		 * @return Int32\Type                                       the object
		 */
		public static function one() {
			return new Int32\Type(1);
		}

		/**
		 * This method returns an object with a "0" value.
		 *
		 * @access public
		 * @static
		 * @return Int32\Type                                       the object
		 */
		public static function zero() {
			return new Int32\Type(0);
		}

		#endregion

		#region Methods -> Arithmetic

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the operand
		 * @return Int32\Type                                       the result
		 */
		public static function abs(Int32\Type $x) {
			return Int32\Module::create(abs($x->unbox()));
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
			return Int32\Module::create($x->unbox() + $y->unbox());
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
			return Int32\Module::subtract($x, Int32\Module::one());
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
			return Int32\Module::create($x->unbox() / $y->unbox());
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
			return Int32\Module::create(Int32\Module::_gcd(abs($x->unbox()), abs($y->unbox())));
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
			return Int32\Module::add($x, Int32\Module::one());
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
			return Int32\Module::create($x->unbox() % $y->unbox());
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
			return Int32\Module::create($x->unbox() * $y->unbox());
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
			return Int32\Module::create($x->unbox() * -1);
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
			return Int32\Module::create($x->unbox() - $y->unbox());
		}

		#endregion

		#region Methods -> Data Typing

		/**
		 * This method return the value as a Double. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the object to be converted
		 * @return Double\Type                                      the value as a Double
		 */
		public static function toDouble(Int32\Type $x) {
			return Double\Module::create($x->unbox());
		}

		/**
		 * This method return the value as a Float. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the object to be converted
		 * @return Float\Type                                       the value as a Float
		 */
		public static function toFloat(Int32\Type $x) {
			return Float\Module::create($x->unbox());
		}

		/**
		 * This method return the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the object to be converted
		 * @return Int32\Type                                       the value as an Int32
		 */
		public static function toInt32(Int32\Type $x) {
			return Int32\Module::create($x->unbox());
		}

		/**
		 * This method return the value as an Integer. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $x                                     the object to be converted
		 * @return Integer\Type                                     the value as an Integer
		 */
		public static function toInteger(Int32\Type $x) {
			return Integer\Module::create($x->unbox());
		}

		#endregion

		#region Methods -> Equality

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
				return Bool\Module::create($x->unbox() == $y->unbox());
			}
			return Bool\Module::false();
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
				return Bool\Module::create($x->unbox() === $y->unbox());
			}
			return Bool\Module::false();
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

		#region Methods -> Ordering

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
				return Int32\Module::negative();
			}
			if (($x === null) && ($y === null)) {
				return Int32\Module::zero();
			}
			if (($x !== null) && ($y === null)) {
				return Int32\Module::one();
			}

			$__x = $x->unbox();
			$__y = $y->unbox();

			if ($__x < $__y) {
				return Int32\Module::negative();
			}
			else if ($__x == $__y) {
				return Int32\Module::zero();
			}
			else { // ($__x > $__y)
				return Int32\Module::one();
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
			return Bool\Module::create(Int32\Module::compare($x, $y)->unbox() >= 0);
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
			return Bool\Module::create(Int32\Module::compare($x, $y)->unbox() > 0);
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
			return Bool\Module::create(Int32\Module::compare($x, $y)->unbox() <= 0);
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
			return Bool\Module::create(Int32\Module::compare($x, $y)->unbox() < 0);
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

		#region Methods -> Validation

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
			return Bool\Module::create(($x->unbox() % 2) == 0);
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
			return Bool\Module::create(($x->unbox() % 2) != 0);
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
			return Bool\Module::create($x->unbox() < 0);
		}

		#endregion

	}

}