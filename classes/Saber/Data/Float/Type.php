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

namespace Saber\Data\Float {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Float;
	use \Saber\Data\Floating;
	use \Saber\Data\Real;
	use \Saber\Data\String;
	use \Saber\Throwable;

	final class Type extends Data\Type implements Floating\Type, Real\Type {

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
		protected static $module = '\\Saber\\Data\\Float\\Module';

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
		 * @return Float\Type                                       the boxed object
		 */
		public static function box($value/*...*/) {
			return new Float\Type($value);
		}

		/**
		 * This method enforces that the specified class is covariant.
		 *
		 * @access public
		 * @static
		 * @param Float\Type $x                                     the class to be evaluated
		 * @return Float\Type                                       the class
		 */
		public static function covariant(Float\Type $x) {
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Float\Type                                       the boxed object
		 */
		public static function make($value/*...*/) {
			return new Float\Type($value);
		}

		/**
		 * This method returns an object with a "-1" value.
		 *
		 * @access public
		 * @static
		 * @return Float\Type                                       the object
		 */
		public static function negative() {
			if (!isset(static::$singletons[-1])) {
				static::$singletons[-1] = new Float\Type(-1.0);
			}
			return static::$singletons[-1];
		}

		/**
		 * This method returns an object with a "1" value.
		 *
		 * @access public
		 * @static
		 * @return Float\Type                                       the object
		 */
		public static function one() {
			if (!isset(static::$singletons[1])) {
				static::$singletons[1] = new Float\Type(1.0);
			}
			return static::$singletons[1];
		}

		/**
		 * This method returns an object with a "0" value.
		 *
		 * @access public
		 * @static
		 * @return Float\Type                                       the object
		 */
		public static function zero() {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new Float\Type(0.0);
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
		 * @param float $value                                      the value to be assigned
		 */
		public final function __construct($value) {
			$this->value = (double) $value;
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object's hash code
		 */
		public final function __hashCode() {
			return $this->__toString() . 'f';
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object as a string
		 */
		public final function __toString() {
			return sprintf('%F', $this->value);
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param integer $depth                                    how many levels to unbox
		 * @return float                                            the un-boxed value
		 */
		public final function unbox($depth = 0) {
			return $this->value;
		}

		#endregion

	}

}