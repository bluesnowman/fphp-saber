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

	include_once(implode(DIRECTORY_SEPARATOR, array(dirname(__FILE__), '..', 'Extension', 'mbstring.php')));

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Throwable;

	/**
	 * @see http://www.haskell.org/ghc/docs/6.4.2/html/libraries/base/Data-Char.html
	 */
	class Char implements Core\AnyVal {

		#region Traits

		use Core\AnyVal\Impl;

		#endregion

		#region Constants

		/**
		 * This constant stores the string representing a UTF-8 encoding.
		 *
		 * @access public
		 * @const string
		 */
		const UTF_8_ENCODING = 'UTF-8';

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
			if (is_string($value)) {
				if (func_num_args() > 1) {
					$encoding = func_get_arg(1);
					$value = mb_convert_encoding($value, Data\Char::UTF_8_ENCODING, $encoding);
				}
				$length = mb_strlen($value, Data\Char::UTF_8_ENCODING);
				if ($length != 1) {
					throw new Throwable\InvalidArgument\Exception('Unable to box value. Expected a character, but got "string" of length ":length".', array(':length' => $length));
				}
				return new static($value);
			}
			else if (!is_string($value) && is_numeric($value)) {
				return new static(chr((int) $value));
			}
			else {
				$type = gettype($value);
				if ($type == 'object') {
					$type = get_class($value);
				}
				throw new Throwable\InvalidArgument\Exception('Unable to box value. Expected a character, but got ":type".', array(':type' => $type));
			}
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Core\Any                                         the boxed object
		 */
		public static function create($value/*...*/) {
			return new static($value);
		}

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param char $value                                       the value to be assigned
		 */
		public function __construct($value) {
			$this->value = (string) $value;
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @param Data\Char $that                                   the object to be compared
		 * @return Data\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public function compareTo(Data\Char $that) {
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

		#endregion

	}

}