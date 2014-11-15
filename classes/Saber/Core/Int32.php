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

	final class Int32 extends Core\Integral {

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
			return new static($value);
		}

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
		 * This method returns an object with a "0" value.
		 *
		 * @access public
		 * @return Core\Int32                                       the object
		 */
		public static function zero() {
			return new Core\Int32(0);
		}

		/**
		 * This method returns an object with a "1" value.
		 *
		 * @access public
		 * @return Core\Int32                                       the object
		 */
		public static function one() {
			return new Core\Int32(1);
		}

		/**
		 * This method returns an object with a "-1" value.
		 *
		 * @access public
		 * @return Core\Int32                                       the object
		 */
		public static function negative() {
			return new Core\Int32(-1);
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

		#region Methods -> Native Oriented

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString() {
			return sprintf('%d', $this->value);
		}

		#endregion

	}

}