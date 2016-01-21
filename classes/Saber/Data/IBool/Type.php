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

namespace Saber\Data\IBool {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IBool;

	final class Type extends Data\Type {

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
		protected static $module = '\\Saber\\Data\\IBool\\Module';

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
		 * @param bool $value                                       the value(s) to be boxed
		 * @return IBool\Type                                       the boxed object
		 */
		public static function box(bool $value) : IBool\Type {
			return ($value) ? IBool\Type::true() : IBool\Type::false();
		}

		/**
		 * This method enforces that the specified class is a covariant.
		 *
		 * @access public
		 * @static
		 * @param IBool\Type $x                                      the class to be evaluated
		 * @return IBool\Type                                        the class
		 */
		public static function covariant(IBool\Type $x) : IBool\Type {
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return IBool\Type                                       the boxed object
		 */
		public static function make($value) : IBool\Type {
			if (is_string($value) && in_array(strtolower($value), array('false', 'f', 'no', 'n', '0', 'null', 'nil'))) {
				return IBool\Type::false();
			}
			return ($value) ? IBool\Type::true() : IBool\Type::false();
		}

		/**
		 * This method returns an object with a "false" value.
		 *
		 * @access public
		 * @return IBool\Type                                       the object
		 */
		public static function false() : IBool\Type {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new IBool\Type(false);
			}
			return static::$singletons[0];
		}

		/**
		 * This method returns an object with a "true" value.
		 *
		 * @access public
		 * @return IBool\Type                                       the object
		 */
		public static function true() : IBool\Type {
			if (!isset(static::$singletons[1])) {
				static::$singletons[1] = new IBool\Type(true);
			}
			return static::$singletons[1];
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @final
		 * @param boolean $value                                    the value to be assigned
		 */
		public final function __construct(bool $value) {
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
			return ($this->value) ? 'true' : 'false';
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param int $depth                                        how many levels to unbox
		 * @return boolean                                          the un-boxed value
		 */
		public final function unbox(int $depth = 0) {
			return $this->value;
		}

		#endregion

	}

}