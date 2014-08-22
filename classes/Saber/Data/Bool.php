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

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Throwable;

	class Bool implements Core\AnyVal {

		#region Traits

		use Core\AnyVal\Impl;

		#endregion

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
			if ((func_num_args() > 1) && func_get_arg(1) && is_string($value) && in_array(strtolower($value), array('false', 'f', 'no', 'n', '0'))) {
				$value = false;
			}
			return new static($value);
		}

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param boolean $value                                    the value to be assigned
		 */
		public function __construct($value) {
			$this->value = (bool) $value;
		}

		/**
		 * This method returns an object with a "false" value.
		 *
		 * @access public
		 * @return Data\Bool                                        the object
		 */
		public static function false() {
			return Data\Bool::create(false);
		}

		/**
		 * This method returns an object with a "true" value.
		 *
		 * @access public
		 * @return Data\Bool                                        the object
		 */
		public static function true() {
			return Data\Bool::create(true);
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString() {
			return ($this->unbox()) ? 'true' : 'false';
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method returns whether both sides evaluate to true for the result to be true.
		 *
		 * @access public
		 * @param Data\Bool $that                                   the object to be compared
		 * @return Data\Bool                                        whether both sides evaluate to true
		 */
		public function and_(Data\Bool $that) {
			return Data\Bool::create($this->unbox() && $that->unbox());
		}

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @param Data\Bool $that                                   the object to be compared
		 * @return Data\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public function compareTo(Data\Bool $that) {
			$x = $this->unbox();
			$y = $that->unbox();

			if (!$x && $y) {
				return Data\Int32::negative();
			}
			else if ($x == $y) {
				return Data\Int32::zero();
			}
			else { // ($x && !$y)
				return Data\Int32::one();
			}
		}

		/**
		 * This method returns whether at least one side is true for the result to be true.
		 *
		 * @access public
		 * @param Data\Bool $that                                   the object to be compared
		 * @return Data\Bool                                        whether at least one side is true
		 */
		public function or_(Data\Bool $that) {
			return Data\Bool::create($this->unbox() || $that->unbox());
		}

		/**
		 * This method returns whether at least one side is false for the result to be true.
		 *
		 * @access public
		 * @param Data\Bool $that                                   the object to be compared
		 * @return Data\Bool                                        whether at least one side is false
		 */
		public function nand(Data\Bool $that) {
			return Data\Bool::create(!($this->unbox() && $that->unbox()));
		}

		/**
		 * This method returns whether both sides evaluate to false for the result to be true.
		 *
		 * @access public
		 * @param Data\Bool $that                                   the object to be compared
		 * @return Data\Bool                                        whether both sides evaluate to false
		 */
		public function nor(Data\Bool $that) {
			return Data\Bool::create(!($this->unbox() || $that->unbox()));
		}

		/**
		 * This method returns the negation.
		 *
		 * @access public
		 * @return Data\Bool                                        the negation
		 */
		public function not() {
			return Data\Bool::create(!$this->unbox());
		}

		/**
		 * This method return the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @return Data\Int32                                       the value as an integer
		 */
		public function toInt32() {
			return Data\Int32::create($this->unbox());
		}

		/**
		 * This method returns whether one side evaluates to true, but not both, for the result to
		 * be true.
		 *
		 * @access public
		 * @param Data\Bool $that                                   the object to be compared
		 * @return Data\Bool                                        whether one side evaluates to true,
		 *                                                          but not both
		 */
		public function xor_(Data\Bool $that) {
			return Data\Bool::create($this->unbox() xor $that->unbox());
		}

		#endregion

	}

}