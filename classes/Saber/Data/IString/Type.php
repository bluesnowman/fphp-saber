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

namespace Saber\Data\IString {

	include_once(implode(DIRECTORY_SEPARATOR, array(dirname(__FILE__), '..', '..', 'Ext', 'mbstring.php')));

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IBool;
	use \Saber\Data\IChar;
	use \Saber\Data\IInt32;
	use \Saber\Data\IString;
	use \Saber\Data\IVector;
	use \Saber\Throwable;

	final class Type extends Data\Type implements Core\Boxable\Type, IVector\Type {

		#region Traits

		use Core\Dispatcher;

		#endregion

		#region Properties

		/**
		 * This variable stores the class path to this class' module.
		 *
		 * @access protected
		 * @static
		 * @var string
		 */
		protected static $module = '\\Saber\\Data\\IString\\Module';

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
		 * @param string $value                                     the value(s) to be boxed
		 * @return IString\Type                                     the boxed object
		 */
		public static function box(string $value) : IString\Type {
			return new IString\Type($value);
		}

		/**
		 * This method enforces that the specified class is a covariant.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $x                                   the class to be evaluated
		 * @return IString\Type                                     the class
		 */
		public static function covariant(IString\Type $x) : IString\Type {
			return $x;
		}

		/**
		 * This method returns an empty instance.
		 *
		 * @access public
		 * @static
		 * @return IString\Type                                     the string
		 */
		public static function empty_() : IString\Type {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new IString\Type('');
			}
			return static::$singletons[0];
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return IString\Type                                     the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function make($value) : IString\Type {
			if (!is_string($value)) {
				$type = gettype($value);
				if ($type == 'object') {
					$type = get_class($value);
				}
				throw new Throwable\InvalidArgument\Exception('Unable to box value. Expected a string, but got ":type".', array(':type' => $type));
			}
			if (func_num_args() > 1) {
				$encoding = func_get_arg(1);
				$value = mb_convert_encoding($value, IChar\Type::UTF_8_ENCODING, $encoding);
			}
			return new IString\Type($value);
		}

		/**
		 * This method creates a string of "n" length with every item set to the given object.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                     the object to be replicated
		 * @param IInt32\Type $n                                    the number of times to replicate
		 * @return IString\Type                                     the string
		 */
		public static function replicate(IChar\Type $x, IInt32\Type $n) : IString\Type {
			$buffer = '';
			$length = $n->unbox();

			for ($i = 0; $i < $length; $i++) {
				$buffer .= $x->__toString();
			}

			return IString\Type::box($buffer);
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
		 * @return string                                           the object's hash code
		 */
		public function __hashCode() : string {
			return md5($this->value);
		}

		/**
		 * This method returns the head object in this list.
		 *
		 * @access public
		 * @final
		 * @return string                                           the head object in this list
		 */
		public final function __head() : string {
			return mb_substr($this->value, 0, 1, IChar\Type::UTF_8_ENCODING);
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @final
		 * @return bool                                             whether the list is empty
		 */
		public final function __isEmpty() : bool {
			return (($this->value === null) || ($this->value === ''));
		}

		/**
		 * This method returns the item at the specified index.
		 *
		 * @access public
		 * @final
		 * @param IInt32\Type $i                                    the index of the item
		 * @return string                                           the item at the specified index
		 */
		public final function __item(IInt32\Type $i) : string {
			return mb_substr($this->value, $i->unbox(), 1, IChar\Type::UTF_8_ENCODING);
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @final
		 * @return int                                              the length of this array list
		 */
		public final function __length() : int {
			return mb_strlen($this->value, IChar\Type::UTF_8_ENCODING);
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

		/**
		 * This method returns the tail of this list.
		 *
		 * @access public
		 * @final
		 * @return string                                           the tail of this string
		 */
		public final function __tail() : string {
			return mb_substr($this->value, 1, $this->__length(), IChar\Type::UTF_8_ENCODING);
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the head object in this list.
		 *
		 * @access public
		 * @final
		 * @return IChar\Type                                       the head char in this string
		 */
		public final function head() : IChar\Type {
			return IChar\Type::box($this->__head());
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @final
		 * @return IBool\Type                                       whether the string is empty
		 */
		public final function isEmpty() : IBool\Type {
			return IBool\Type::box($this->__isEmpty());
		}

		/**
		 * This method returns the item at the specified index.
		 *
		 * @access public
		 * @final
		 * @param IInt32\Type $i                                    the index of the item
		 * @return IChar\Type                                       the item at the specified index
		 */
		public final function item(IInt32\Type $i) : IChar\Type {
			return IChar\Type::box($this->__item($i));
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @final
		 * @return IInt32\Type                                      the length of this string
		 */
		public final function length() : IInt32\Type {
			return IInt32\Type::box($this->__length());
		}

		/**
		 * This method returns the tail of this list.
		 *
		 * @access public
		 * @final
		 * @return IString\Type                                     the tail of this string
		 */
		public final function tail() : IString\Type {
			return new IString\Type($this->__tail());
		}

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