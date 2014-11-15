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

	use \Saber\Data;

	class Double extends Data\Floating {

		#region Methods -> Boxing/Creation

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param double $value                                     the value to be assigned
		 */
		public function __construct($value) {
			$this->value = (double) $value;
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @return Data\Double                                      the absolute value
		 */
		public function abs() {
			return Data\Double::create(abs($this->unbox()));
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @param Data\Double $that                                 the value to be added
		 * @return Data\Double                                      the result
		 */
		public function add(Data\Double $that) {
			return Data\Double::create($this->unbox() + $that->unbox());
		}

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @param Data\Double $that                                 the object to be compared
		 * @return Data\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public function compareTo(Data\Double $that) {
			$x = $this->unbox();
			$y = $that->unbox();

			if ($x < $y) {
				return Data\Int32::negative();
			}
			else if ($x == $y) {
				return Data\Int32::zero();
			}
			else { // ($x > $y)
				return Data\Int32::one();
			}
		}

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @return Data\Double                                      the result
		 */
		public function decrement() {
			return $this->subtract(Data\Double::one());
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @param Data\Double $that                                 the value to be divided
		 * @return Data\Double                                      the result
		 */
		public function divide(Data\Double $that) {
			return Data\Double::create($this->unbox() / $that->unbox());
		}

		/**
		 * This method recursively calculates the greatest common divisor.
		 *
		 * @access protected
		 * @param double $a                                         the "this" value to be processed
		 * @param double $b                                         the "that" value to be processed
		 * @return float                                            the greatest common divisor
		 *
		 * @see http://stackoverflow.com/questions/13828011/look-for-the-gcd-greatest-common-divisor-of-more-than-2-integers
		 */
		protected function _gcd($a, $b) {
		    return $b > .01 ? $this->_gcd($b, fmod($a, $b)) : $a;
		}

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @return Data\Double                                      the result
		 */
		public function increment() {
			return $this->add(Data\Double::one());
		}

		/**
		 * This method returns the result of finding the modulus of the specified value against this
		 * object's value.
		 *
		 * @access public
		 * @param Data\Double $that                                 the value to be divided
		 * @return Data\Double                                      the result
		 */
		public function modulo(Data\Double $that) {
			return Data\Double::create(fmod($this->unbox(), $that->unbox()));
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @param Data\Double $that                                 the value to be multiplied
		 * @return Data\Double                                      the result
		 */
		public function multiply(Data\Double $that) {
			return Data\Double::create($this->unbox() * $that->unbox());
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @return Data\Double                                      the result
		 */
		public function negate() {
			return Data\Double::create($this->unbox() * -1.0);
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @param Data\Double $that                                 the value to be subtracted
		 * @return Data\Double                                      the result
		 */
		public function subtract(Data\Double $that) {
			return Data\Double::create($this->unbox() - $that->unbox());
		}

		#endregion

	}

}