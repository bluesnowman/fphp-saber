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

namespace Saber\Data\String {

	include_once(implode(DIRECTORY_SEPARATOR, array(dirname(__FILE__), '..', '..', 'Ext', 'mbstring.php')));

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Bool;
	use \Saber\Data\Char;
	use \Saber\Data\Int32;
	use \Saber\Data\String;
	use \Saber\Data\Vector;
	use \Saber\Throwable;

	final class Type extends Data\Type implements Core\Boxable\Type, Vector\Type {

		#region Properties

		/**
		 * This variable stores the class path to this class' module.
		 *
		 * @access protected
		 * @static
		 * @var string
		 */
		protected static $module = '\\Saber\\Data\\String\\Module';

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
		 * This method enforces that the specified class is covariant.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $x                                      the class to be evaluated
		 * @return String\Type                                      the class
		 * @throw Throwable\InvalidArgument\Exception               indicated that the specified class
		 *                                                          is not a covariant
		 */
		public static function covariant(Core\Type $x) {
			if (!($x instanceof static)) {
				throw new Throwable\InvalidArgument\Exception('Invalid class type.  Expected a class of type ":type1", but got ":type2".', array(':type1' => get_called_class(), ':type2' => get_class($x)));
			}
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return String\Type                                      the boxed object
		 */
		public static function box($value/*...*/) {
			return new String\Type($value);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return String\Type                                      the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function make($value/*...*/) {
			if (!is_string($value)) {
				$type = gettype($value);
				if ($type == 'object') {
					$type = get_class($value);
				}
				throw new Throwable\InvalidArgument\Exception('Unable to box value. Expected a string, but got ":type".', array(':type' => $type));
			}
			if (func_num_args() > 1) {
				$encoding = func_get_arg(1);
				$value = mb_convert_encoding($value, Char\Type::UTF_8_ENCODING, $encoding);
			}
			return new String\Type($value);
		}

		/**
		 * This method returns an empty instance.
		 *
		 * @access public
		 * @static
		 * @return String\Type                                      the string
		 */
		public static function empty_() {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new String\Type('');
			}
			return static::$singletons[0];
		}

		/**
		 * This method creates a string of "n" length with every item set to the given object.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the object to be replicated
		 * @param Int32\Type $n                                     the number of times to replicate
		 * @return String\Type                                      the string
		 */
		public static function replicate(Char\Type $x, Int32\Type $n) {
			$buffer = '';
			$length = $n->unbox();

			for ($i = 0; $i < $length; $i++) {
				$buffer .= $x->__toString();
			}

			return String\Type::box($buffer);
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method is called when a method is not defined and will attempt to remap
		 * the call.  Particularly, this method provides a shortcut means of unboxing a method's
		 * result when the method name is preceded by a double-underscore.
		 *
		 * @access public
		 * @final
		 * @param string $method                                    the method being called
		 * @param array $args                                       the arguments associated with the call
		 * @return mixed                                            the un-boxed value
		 * @throws Throwable\UnimplementedMethod\Exception          indicates that the class has not
		 *                                                          implemented the called method
		 */
		public final function __call($method, $args) {
			if (preg_match('/^__[a-z_][a-z0-9_]*$/i', $method)) {
				$method = substr($method, 2);
				if (!in_array($method, array('call', 'choice', 'iterator', 'unbox'))) {
					if (method_exists(static::$module, $method)) {
						array_unshift($args, $this);
						$result = call_user_func_array(array(static::$module, $method), $args);
						if ($result instanceof Core\Boxable\Type) {
							return $result->unbox();
						}
						return $result;
					}
				}
			}
			else {
				if (method_exists(static::$module, $method)) {
					array_unshift($args, $this);
					$result = call_user_func_array(array(static::$module, $method), $args);
					return $result;
				}
			}
			throw new Throwable\UnimplementedMethod\Exception('Unable to call method. No method ":method" exists in module ":module".', array(':module' => static::$module, ':method' => $method));
		}

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
		 * This method returns the head object in this list.
		 *
		 * @access public
		 * @final
		 * @return string                                           the head object in this list
		 */
		public final function __head() {
			return mb_substr($this->value, 0, 1, Char\Type::UTF_8_ENCODING);
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @final
		 * @return boolean                                          whether the list is empty
		 */
		public final function __isEmpty() {
			return (($this->value === null) || ($this->value === ''));
		}

		/**
		 * This method returns the item at the specified index.
		 *
		 * @access public
		 * @final
		 * @param Int32\Type $i                                     the index of the item
		 * @return string                                           the item at the specified index
		 */
		public final function __item(Int32\Type $i) {
			return mb_substr($this->value, $i->unbox(), 1, Char\Type::UTF_8_ENCODING);
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @final
		 * @return integer                                          the length of this array list
		 */
		public final function __length() {
			return mb_strlen($this->value, Char\Type::UTF_8_ENCODING);
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
		public final function __tail() {
			return mb_substr($this->value, 1, $this->__length(), Char\Type::UTF_8_ENCODING);
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the head object in this list.
		 *
		 * @access public
		 * @final
		 * @return Char\Type                                        the head char in this string
		 */
		public final function head() {
			return Char\Type::box($this->__head());
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @final
		 * @return Bool\Type                                        whether the string is empty
		 */
		public final function isEmpty() {
			return Bool\Type::box($this->__isEmpty());
		}

		/**
		 * This method returns the item at the specified index.
		 *
		 * @access public
		 * @final
		 * @param Int32\Type $i                                     the index of the item
		 * @return Char\Type                                        the item at the specified index
		 */
		public final function item(Int32\Type $i) {
			return Char\Type::box($this->__item($i));
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @final
		 * @return Int32\Type                                       the length of this string
		 */
		public final function length() {
			return Int32\Type::box($this->__length());
		}

		/**
		 * This method returns the tail of this list.
		 *
		 * @access public
		 * @final
		 * @return String\Type                                      the tail of this string
		 */
		public final function tail() {
			return new String\Type($this->__tail());
		}

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