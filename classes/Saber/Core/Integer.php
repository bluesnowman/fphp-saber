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

namespace Saber\Core {

	use \Saber\Core;
	use \Saber\Throwable;

	/**
	 * @see http://php.net/manual/en/ref.gmp.php
	 * @see http://verysimple.com/2013/11/05/compile-php-extensions-for-mamp/
	 * @see http://coder1.com/articles/how-to-install-php-gmp-mac-osx-1037
	 */
	class Integer extends Core\Integral {

		#region Methods -> Boxing/Creation

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Core\Any                                         the boxed object
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
			return new static($value);
		}

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param string $value                                     the value to be assigned
		 */
		public function __construct($value) {
			$this->value = (string) $value;
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @return Core\Integer                                     the absolute value
		 */
		public function abs() {
			return Core\Integer::create(gmp_strval(gmp_abs($this->unbox())));
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @param Core\Integer $that                                the value to be added
		 * @return Core\Integer                                     the result
		 */
		public function add(Core\Integer $that) {
			return Core\Integer::create(gmp_strval(gmp_add($this->unbox(), $that->unbox())));
		}

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @param Core\Integer $that                                the object to be compared
		 * @return Core\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public function compareTo(Core\Integer $that) {
			return Core\Int32::create(gmp_cmp($this->unbox(), $that->unbox()));
		}

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @return Core\Integer                                     the result
		 */
		public function decrement() {
			return $this->subtract(Core\Integer::one());
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @param Core\Integer $that                                the value to be divided
		 * @return Core\Integer                                     the result
		 */
		public function divide(Core\Integer $that) {
			return Core\Integer::create(gmp_strval(gmp_div_q($this->unbox(), $that->unbox())));
		}

		/**
		 * This method evaluates whether this object's value is an even number.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this object's value is
		 *                                                          an even number
		 */
		public function even() {
			return Core\Bool::create(gmp_strval(gmp_div_r($this->unbox(), '2')) == '0');
		}

		/**
		 * This method returns the greatest common divisor.
		 *
		 * @access public
		 * @param Core\Integer $that                                the value to be processed
		 * @return Core\Integer                                     the greatest common divisor
		 */
		public function gcd(Core\Integer $that) {
			return Core\Integer::create(gmp_strval(gmp_gcd($this->unbox(), $that->unbox())));
		}

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @return Core\Integer                                     the result
		 */
		public function increment() {
			return $this->add(Core\Integer::one());
		}

		/**
		 * This method returns whether the number is negative.
		 *
		 * @access public
		 * @return Core\Bool                                        whether the number is negative
		 */
		public function isNegative() {
			return Core\Bool::create(gmp_sign($this->unbox()) == -1);
		}

		/**
		 * This method returns the result of finding the modulus of the specified value against this
		 * object's value.
		 *
		 * @access public
		 * @param Core\Integer $that                                the value to be divided
		 * @return Core\Integer                                     the result
		 */
		public function modulo(Core\Integer $that) {
			return Core\Integer::create(gmp_strval(gmp_div_r($this->unbox(), $that->unbox())));
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @param Core\Integer $that                                the value to be multiplied
		 * @return Core\Integer                                     the result
		 */
		public function multiply(Core\Integer $that) {
			return Core\Integer::create(gmp_strval(gmp_mul($this->unbox(), $that->unbox())));
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @return Core\Integer                                     the result
		 */
		public function negate() {
			return Core\Integer::create(gmp_strval(gmp_neg($this->unbox())));
		}

		/**
		 * This method evaluates whether this object's value is an odd number.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this object's value is
		 *                                                          an odd number
		 */
		public function odd() {
			return Core\Bool::create(gmp_strval(gmp_div_r($this->unbox(), '2')) != '0');
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @param Core\Integer $that                                the value to be subtracted
		 * @return Core\Integer                                     the result
		 */
		public function subtract(Core\Integer $that) {
			return Core\Integer::create(gmp_strval(gmp_sub($this->unbox(), $that->unbox())));
		}

		#endregion

	}

}