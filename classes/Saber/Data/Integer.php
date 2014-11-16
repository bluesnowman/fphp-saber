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
	use \Saber\Throwable;

	/**
	 * @see http://php.net/manual/en/ref.gmp.php
	 * @see http://verysimple.com/2013/11/05/compile-php-extensions-for-mamp/
	 * @see http://coder1.com/articles/how-to-install-php-gmp-mac-osx-1037
	 */
	class Integer extends Data\Integral {

		#region Methods -> Implementation

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param string $value                                     the value to be assigned
		 */
		public function __construct($value) {
			$this->value = (string) $value;
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString() {
			return strval($this->value);
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
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function box($value/*...*/) {
			if (is_numeric($value)) {
				settype($value, 'integer');
			}
			$value = '' . $value;
			if (!preg_match('/^-?[1-9]?[0-9]+$/', $value)) {
				throw new Throwable\InvalidArgument\Exception('Unable to box value. Expected an integer, but got ":value".', array(':value' => $value));
			}
			return new Data\Integer($value);
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
			return new Data\Integer($value);
		}

		/**
		 * This method returns an object with a "-1" value.
		 *
		 * @access public
		 * @static
		 * @return Data\Integer                                     the object
		 */
		public static function negative() {
			return new Data\Integer(-1);
		}

		/**
		 * This method returns an object with a "1" value.
		 *
		 * @access public
		 * @static
		 * @return Data\Integer                                     the object
		 */
		public static function one() {
			return new Data\Integer(1);
		}

		/**
		 * This method returns an object with a "0" value.
		 *
		 * @access public
		 * @static
		 * @return Data\Integer                                     the object
		 */
		public static function zero() {
			return new Data\Integer(0);
		}

		#endregion

		#region Methods -> Arithmetic

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the operand
		 * @return Data\Integer                                     the result
		 */
		public static function abs(Data\Integer $x) {
			return Data\Integer::create(gmp_strval(gmp_abs($x->unbox())));
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the left operand
		 * @param Data\Integer $y                                   the right operand
		 * @return Data\Integer                                     the result
		 */
		public static function add(Data\Integer $x, Data\Integer $y) {
			return Data\Integer::create(gmp_strval(gmp_add($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the operand
		 * @return Data\Integer                                     the result
		 */
		public static function decrement(Data\Integer $x) {
			return Data\Integer::subtract($x, Data\Integer::one());
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the left operand
		 * @param Data\Integer $y                                   the right operand
		 * @return Data\Integer                                     the result
		 */
		public static function divide(Data\Integer $x, Data\Integer $y) {
			return Data\Integer::create(gmp_strval(gmp_div_q($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the greatest common divisor.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the left operand
		 * @param Data\Integer $y                                   the right operand
		 * @return Data\Integer                                     the result
		 */
		public static function gcd(Data\Integer $x, Data\Integer $y) {
			return Data\Integer::create(gmp_strval(gmp_gcd($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the operand
		 * @return Data\Integer                                     the result
		 */
		public static function increment(Data\Integer $x) {
			return Data\Integer::add($x, Data\Integer::one());
		}

		/**
		 * This method returns the result of finding the modulus of the specified value against this
		 * object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the left operand
		 * @param Data\Integer $y                                   the right operand
		 * @return Data\Integer                                     the result
		 */
		public static function modulo(Data\Integer $x, Data\Integer $y) {
			return Data\Integer::create(gmp_strval(gmp_div_r($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the left operand
		 * @param Data\Integer $y                                   the right operand
		 * @return Data\Integer                                     the result
		 */
		public static function multiply(Data\Integer $x, Data\Integer $y) {
			return Data\Integer::create(gmp_strval(gmp_mul($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the operand
		 * @return Data\Integer                                     the result
		 */
		public static function negate(Data\Integer $x) {
			return Data\Integer::create(gmp_strval(gmp_neg($x->unbox())));
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the left operand
		 * @param Data\Integer $y                                   the right operand
		 * @return Data\Integer                                     the result
		 */
		public static function subtract(Data\Integer $x, Data\Integer $y) {
			return Data\Integer::create(gmp_strval(gmp_sub($x->unbox(), $y->unbox())));
		}

		#endregion

		#region Methods -> Data Typing

		/**
		 * This method returns the value as a String.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the object to be converted
		 * @return Data\String                                      the value as a String
		 */
		public static function toString(Data\Integer $x) {
			return Data\String::create($x->__toString());
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the left operand
		 * @param Data\Integer $y                                   the right operand
		 * @return Data\Integer                                     the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Data\Integer $x, Data\Integer $y) {
			return Data\Int32::create(gmp_cmp($x->unbox(), $y->unbox()));
		}

		#endregion

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the left operand
		 * @param Data\Integer $y                                   the right operand
		 * @return Data\Bool                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Data\Integer $x, Data\Integer $y) { // >=
			return Data\Bool::create(Data\Integer::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the left operand
		 * @param Data\Integer $y                                   the right operand
		 * @return Data\Bool                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Data\Integer $x, Data\Integer $y) { // >
			return Data\Bool::create(Data\Integer::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the left operand
		 * @param Data\Integer $y                                   the right operand
		 * @return Data\Bool                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Data\Integer $x, Data\Integer $y) { // <=
			return Data\Bool::create(Data\Integer::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the left operand
		 * @param Data\Integer $y                                   the right operand
		 * @return Data\Bool                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Data\Integer $x, Data\Integer $y) { // <
			return Data\Bool::create(Data\Integer::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the left operand
		 * @param Data\Integer $y                                   the right operand
		 * @return Data\Integer                                     the maximum value
		 */
		public static function max(Data\Integer $x, Data\Integer $y) {
			return (Data\Integer::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the left operand
		 * @param Data\Integer $y                                   the right operand
		 * @return Data\Integer                                     the minimum value
		 */
		public static function min(Data\Integer $x, Data\Integer $y) {
			return (Data\Integer::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Other

		/**
		 * This method returns a choice block.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the object to be evaluated
		 * @return Control\Monad\Choice                             the choice monad
		 */
		public static function choice(Data\Integer $x) {
			return Control\Monad::choice($x);
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the object to be evaluated
		 * @return Data\String                                      the object's hash code
		 */
		public static function hashCode(Data\Integer $x) {
			return Data\String::create($x->__toString());
		}

		#endregion

		#region Methods -> Validation

		/**
		 * This method evaluates whether the operand is an even number.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the object to be evaluated
		 * @return Data\Bool                                        whether the operand is an even
		 *                                                          number
		 */
		public static function isEven(Data\Integer $x) {
			return Data\Bool::create(gmp_strval(gmp_div_r($x->unbox(), '2')) == '0');
		}

		/**
		 * This method evaluates whether the operand is an odd number.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the object to be evaluated
		 * @return Data\Bool                                        whether the operand is an odd
		 *                                                          number
		 */
		public static function isOdd(Data\Integer $x) {
			return Data\Bool::create(gmp_strval(gmp_div_r($x->unbox(), '2')) != '0');
		}

		/**
		 * This method returns whether the operand is a negative number.
		 *
		 * @access public
		 * @static
		 * @param Data\Integer $x                                   the object to be evaluated
		 * @return Data\Bool                                        whether the operand is a negative
		 *                                                          number
		 */
		public static function isNegative(Data\Integer $x) {
			return Data\Bool::create(gmp_sign($x->unbox()) == -1);
		}

		#endregion

	}

}