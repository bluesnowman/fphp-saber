<?php

/**
 * Copyright 2014-2016 Blue Snowman
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

declare(strict_types = 1);

namespace Saber\Data\IChar {

	include_once(implode(DIRECTORY_SEPARATOR, array(dirname(__FILE__), '..', '..', 'Ext', 'mbstring.php')));

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IChar;
	use \Saber\Data\IString;
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
		protected static $module = '\\Saber\\Data\\IChar\\Module';

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
		 * @return IChar\Type                                       the boxed object
		 */
		public static function box(string $value) : IChar\Type {
			return new IChar\Type($value);
		}

		/**
		 * This method enforces that the specified class is a covariant.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                     the class to be evaluated
		 * @return IChar\Type                                       the class
		 */
		public static function covariant(IChar\Type $x) : IChar\Type {
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
		 * @return IChar\Type                                       the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function make($value, $encoding = self::UTF_8_ENCODING) : IChar\Type {
			if (is_string($value)) {
				if ($encoding != IChar\Type::UTF_8_ENCODING) {
					$value = mb_convert_encoding($value, IChar\Type::UTF_8_ENCODING, $encoding);
				}
				$length = mb_strlen($value, IChar\Type::UTF_8_ENCODING);
				if ($length != 1) {
					throw new Throwable\InvalidArgument\Exception(
						'Unable to box value. Expected a character, but got "string" of length ":length".',
						array(':length' => $length)
					);
				}
				return new IChar\Type($value);
			}
			else if (is_numeric($value)) {
				return new IChar\Type(chr((int) $value));
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
		 * @return IChar\Type                                        the character
		 */
		public static function cr() : IChar\Type {
			if (!isset(static::$singletons["\r"])) {
				static::$singletons["\r"] = new IChar\Type("\r");
			}
			return static::$singletons["\r"];
		}

		/**
		 * This method returns a character representing the "line feed" value.
		 *
		 * @access public
		 * @static
		 * @return IChar\Type                                        the character
		 */
		public static function lf() : IChar\Type {
			if (!isset(static::$singletons["\n"])) {
				static::$singletons["\n"] = new IChar\Type("\n");
			}
			return static::$singletons["\n"];
		}

		/**
		 * This method returns a character representing the "space" value.
		 *
		 * @access public
		 * @static
		 * @return IChar\Type                                        the character
		 */
		public static function space() : IChar\Type {
			if (!isset(static::$singletons[' '])) {
				static::$singletons[' '] = new IChar\Type(' ');
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
		public final function __construct(string $value) {
			$this->value = $value;
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object's hash code
		 */
		public final function __hashCode() : string {
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
		 * @param int $depth                                        how many levels to unbox
		 * @return string                                           the un-boxed value
		 */
		public final function unbox(int $depth = 0) {
			return $this->value;
		}

		#endregion

	}

}