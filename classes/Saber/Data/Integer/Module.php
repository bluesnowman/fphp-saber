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

namespace Saber\Data\Integer {

	use \Saber\Control;
	use \Saber\Core;
	use \Saber\Data\Bool;
	use \Saber\Data\Int32;
	use \Saber\Data\Integer;
	use \Saber\Data\Integral;
	use \Saber\Data\String;
	use \Saber\Throwable;

	/**
	 * @see http://php.net/manual/en/ref.gmp.php
	 * @see http://verysimple.com/2013/11/05/compile-php-extensions-for-mamp/
	 * @see http://coder1.com/articles/how-to-install-php-gmp-mac-osx-1037
	 */
	class Module extends Integral\Module {

		#region Methods -> Instantiation

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Core\Type                                        the boxed object
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
			return new Integer\Type($value);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Integer\Type                                     the boxed object
		 */
		public static function create($value/*...*/) {
			return new Integer\Type($value);
		}

		/**
		 * This method returns an object with a "-1" value.
		 *
		 * @access public
		 * @static
		 * @return Integer\Type                                     the object
		 */
		public static function negative() {
			return new Integer\Type(-1);
		}

		/**
		 * This method returns an object with a "1" value.
		 *
		 * @access public
		 * @static
		 * @return Integer\Type                                     the object
		 */
		public static function one() {
			return new Integer\Type(1);
		}

		/**
		 * This method returns an object with a "0" value.
		 *
		 * @access public
		 * @static
		 * @return Integer\Type                                     the object
		 */
		public static function zero() {
			return new Integer\Type(0);
		}

		#endregion

		#region Methods -> Arithmetic

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the operand
		 * @return Integer\Type                                     the result
		 */
		public static function abs(Integer\Type $x) {
			return Integer\Module::create(gmp_strval(gmp_abs($x->unbox())));
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the result
		 */
		public static function add(Integer\Type $x, Integer\Type $y) {
			return Integer\Module::create(gmp_strval(gmp_add($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the operand
		 * @return Integer\Type                                     the result
		 */
		public static function decrement(Integer\Type $x) {
			return Integer\Module::subtract($x, Integer\Module::one());
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the result
		 */
		public static function divide(Integer\Type $x, Integer\Type $y) {
			return Integer\Module::create(gmp_strval(gmp_div_q($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the greatest common divisor.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the result
		 */
		public static function gcd(Integer\Type $x, Integer\Type $y) {
			return Integer\Module::create(gmp_strval(gmp_gcd($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the operand
		 * @return Integer\Type                                     the result
		 */
		public static function increment(Integer\Type $x) {
			return Integer\Module::add($x, Integer\Module::one());
		}

		/**
		 * This method returns the result of finding the modulus of the specified value against this
		 * object's value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the result
		 */
		public static function modulo(Integer\Type $x, Integer\Type $y) {
			return Integer\Module::create(gmp_strval(gmp_div_r($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the result
		 */
		public static function multiply(Integer\Type $x, Integer\Type $y) {
			return Integer\Module::create(gmp_strval(gmp_mul($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the operand
		 * @return Integer\Type                                     the result
		 */
		public static function negate(Integer\Type $x) {
			return Integer\Module::create(gmp_strval(gmp_neg($x->unbox())));
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the result
		 */
		public static function subtract(Integer\Type $x, Integer\Type $y) {
			return Integer\Module::create(gmp_strval(gmp_sub($x->unbox(), $y->unbox())));
		}

		#endregion

		#region Methods -> Equality

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Integer\Type $x, Core\Type $y) { // ==
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
		 * @param Integer\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Integer\Type $x, Core\Type $y) { // ===
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
		 * @param Integer\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Integer\Type $x, Core\Type $y) { // !=
			return Bool\Module::not(Integer\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Integer\Type $x, Core\Type $y) { // !==
			return Bool\Module::not(Integer\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Integer\Type $x, Integer\Type $y) {
			if (($x === null) && ($y !== null)) {
				return Int32\Module::negative();
			}
			if (($x === null) && ($y === null)) {
				return Int32\Module::zero();
			}
			if (($x !== null) && ($y === null)) {
				return Int32\Module::one();
			}

			return Int32\Module::create(gmp_cmp($x->unbox(), $y->unbox()));
		}

		#endregion

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Integer\Type $x, Integer\Type $y) { // >=
			return Bool\Module::create(Integer\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Integer\Type $x, Integer\Type $y) { // >
			return Bool\Module::create(Integer\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Integer\Type $x, Integer\Type $y) { // <=
			return Bool\Module::create(Integer\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Integer\Type $x, Integer\Type $y) { // <
			return Bool\Module::create(Integer\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the maximum value
		 */
		public static function max(Integer\Type $x, Integer\Type $y) {
			return (Integer\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the minimum value
		 */
		public static function min(Integer\Type $x, Integer\Type $y) {
			return (Integer\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Validation

		/**
		 * This method evaluates whether the operand is an even number.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the object to be evaluated
		 * @return Bool\Type                                        whether the operand is an even
		 *                                                          number
		 */
		public static function isEven(Integer\Type $x) {
			return Bool\Module::create(gmp_strval(gmp_div_r($x->unbox(), '2')) == '0');
		}

		/**
		 * This method evaluates whether the operand is an odd number.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the object to be evaluated
		 * @return Bool\Type                                        whether the operand is an odd
		 *                                                          number
		 */
		public static function isOdd(Integer\Type $x) {
			return Bool\Module::create(gmp_strval(gmp_div_r($x->unbox(), '2')) != '0');
		}

		/**
		 * This method returns whether the operand is a negative number.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the object to be evaluated
		 * @return Bool\Type                                        whether the operand is a negative
		 *                                                          number
		 */
		public static function isNegative(Integer\Type $x) {
			return Bool\Module::create(gmp_sign($x->unbox()) == -1);
		}

		#endregion

	}

}