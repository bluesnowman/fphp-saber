<?php

/**
 * Copyright 2014-2015 Blue Snowman
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

namespace Saber\Data\Char {

	include_once(implode(DIRECTORY_SEPARATOR, array(dirname(__FILE__), '..', '..', 'Ext', 'mbstring.php')));

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Char;
	use \Saber\Data\String;
	use \Saber\Throwable;

	final class Type extends Data\Type {

		#region Traits

		use Core\Dispatcher;

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

		#region Properties

		/**
		 * This variable stores the class path to this class' module.
		 *
		 * @access protected
		 * @static
		 * @var string
		 */
		protected static $module = '\\Saber\\Data\\Char\\Module';

		/**
		 * This variable stores references to commonly used singletons.
		 *
		 * @access protected
		 * @static
		 * @var array
		 */
		protected static $singletons = array();

		#endregion

		#region Methods -> Initialization

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Char\Type                                        the boxed object
		 */
		public static function box($value) {
			return new Char\Type($value);
		}

		/**
		 * This method enforces that the specified class is a covariant.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the class to be evaluated
		 * @return Char\Type                                        the class
		 */
		public static function covariant(Char\Type $x) {
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @param string $encoding                                  the character encoding to use
		 * @return Char\Type                                        the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function make($value, $encoding = self::UTF_8_ENCODING) {
			if (is_string($value)) {
				if ($encoding != Char\Type::UTF_8_ENCODING) {
					$value = mb_convert_encoding($value, Char\Type::UTF_8_ENCODING, $encoding);
				}
				$length = mb_strlen($value, Char\Type::UTF_8_ENCODING);
				if ($length != 1) {
					throw new Throwable\InvalidArgument\Exception(
						'Unable to box value. Expected a character, but got "string" of length ":length".',
						array(':length' => $length)
					);
				}
				return new Char\Type($value);
			}
			else if (is_numeric($value)) {
				return new Char\Type(chr((int) $value));
			}
			else {
				$type = (is_object($value)) ? gettype($value) : get_class($value);
				throw new Throwable\InvalidArgument\Exception(
					'Unable to box value. Expected a character, but got ":type".',
					array(':type' => $type)
				);
			}
		}

		/**
		 * This method returns a character representing the "carriage return" value.
		 *
		 * @access public
		 * @static
		 * @return Char\Type                                        the character
		 */
		public static function cr() {
			if (!isset(static::$singletons["\r"])) {
				static::$singletons["\r"] = new Char\Type("\r");
			}
			return static::$singletons["\r"];
		}

		/**
		 * This method returns a character representing the "line feed" value.
		 *
		 * @access public
		 * @static
		 * @return Char\Type                                        the character
		 */
		public static function lf() {
			if (!isset(static::$singletons["\n"])) {
				static::$singletons["\n"] = new Char\Type("\n");
			}
			return static::$singletons["\n"];
		}

		/**
		 * This method returns a character representing the "space" value.
		 *
		 * @access public
		 * @static
		 * @return Char\Type                                        the character
		 */
		public static function space() {
			if (!isset(static::$singletons[' '])) {
				static::$singletons[' '] = new Char\Type(' ');
			}
			return static::$singletons[' '];
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @final
		 * @param string $value                                     the value to be assigned
		 */
		public final function __construct($value) {
			$this->value = (string) $value;
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object's hash code
		 */
		public final function __hashCode() {
			return $this->__toString();
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object as a string
		 */
		public final function __toString() {
			return $this->value;
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param integer $depth                                    how many levels to unbox
		 * @return string                                           the un-boxed value
		 */
		public final function unbox($depth = 0) {
			return $this->value;
		}

		#endregion

	}

}