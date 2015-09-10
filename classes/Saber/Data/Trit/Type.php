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

namespace Saber\Data\Trit {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Integral;
	use \Saber\Data\String;
	use \Saber\Data\Trit;
	use \Saber\Throwable;

	/**
	 * @see http://en.wikipedia.org/wiki/Balanced_ternary
	 */
	final class Type extends Data\Type implements Integral\Type {

		#region Traits

		use Core\Dispatcher;

		#endregion

		#region Properties

		/**
		 * This variable stores the hash codes.
		 *
		 * @access protected
		 * @static
		 * @var array
		 */
		protected static $hashCodes = array(
			-1 => 'negative',
			 0 => 'zero',
			 1 => 'positive',
		);

		/**
		 * This variable stores the class path to this class' module.
		 *
		 * @access protected
		 * @static
		 * @var string
		 */
		protected static $module = '\\Saber\\Data\\Trit\\Module';

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
		 * This method enforces that the specified class is a covariant.
		 *
		 * @access public
		 * @static
		 * @param Trit\Type $x                                      the class to be evaluated
		 * @return Trit\Type                                        the class
		 */
		public static function covariant(Trit\Type $x) {
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Trit\Type                                        the boxed object
		 */
		public static function box($value) {
			return new Trit\Type($value);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Trit\Type                                        the boxed object
		 */
		public static function make($value) {
			if ($value < 0) {
				return Trit\Type::negative();
			}
			else if ($value == 0) {
				return Trit\Type::zero();
			}
			else { // ($value > 0)
				return Trit\Type::positive();
			}
		}

		/**
		 * This method returns an object with a "-1" value.
		 *
		 * @access public
		 * @static
		 * @return Trit\Type                                        the object
		 */
		public static function negative() {
			if (!isset(static::$singletons[-1])) {
				static::$singletons[-1] = new Trit\Type(-1);
			}
			return static::$singletons[-1];
		}

		/**
		 * This method returns an object with a "1" value.
		 *
		 * @access public
		 * @static
		 * @return Trit\Type                                        the object
		 */
		public static function positive() {
			if (!isset(static::$singletons[1])) {
				static::$singletons[1] = new Trit\Type(1);
			}
			return static::$singletons[1];
		}

		/**
		 * This method returns an object with a "0" value.
		 *
		 * @access public
		 * @static
		 * @return Trit\Type                                        the object
		 */
		public static function zero() {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new Trit\Type(0);
			}
			return static::$singletons[0];
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @final
		 * @param integer $value                                    the value to be assigned
		 */
		public final function __construct($value) {
			$this->value = (int) $value;
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object's hash code
		 */
		public final function __hashCode() {
			return static::$hashCodes[$this->value];
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object as a string
		 */
		public final function __toString() {
			return sprintf('%d', $this->value);
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param integer $depth                                    how many levels to unbox
		 * @return integer                                          the un-boxed value
		 */
		public final function unbox($depth = 0) {
			return $this->value;
		}

		#endregion

	}

}