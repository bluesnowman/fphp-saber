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

	include_once(implode(DIRECTORY_SEPARATOR, array(dirname(__FILE__), '..', 'Extension', 'mbstring.php')));

	use \Saber\Core;
	use \Saber\Throwable;

	/**
	 * @see http://www.haskell.org/ghc/docs/6.4.2/html/libraries/base/Data-Char.html
	 */
	final class Char extends Core\Data implements Core\Data\Boxable, Core\Data\Val {

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
		 * @return Core\Data                                        the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function box($value/*...*/) {
			if (is_string($value)) {
				if (func_num_args() > 1) {
					$encoding = func_get_arg(1);
					$value = mb_convert_encoding($value, Core\Char::UTF_8_ENCODING, $encoding);
				}
				$length = mb_strlen($value, Core\Char::UTF_8_ENCODING);
				if ($length != 1) {
					throw new Throwable\InvalidArgument\Exception('Unable to box value. Expected a character, but got "string" of length ":length".', array(':length' => $length));
				}
				return new Core\Char($value);
			}
			else if (!is_string($value) && is_numeric($value)) {
				return new Core\Char(chr((int) $value));
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
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param char $value                                       the value to be assigned
		 */
		public function __construct($value) {
			$this->value = (string) $value;
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
			return $this->value;
		}

		#endregion

	}

}