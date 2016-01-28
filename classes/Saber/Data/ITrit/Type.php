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

namespace Saber\Data\ITrit {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IIntegral;
	use \Saber\Data\IString;
	use \Saber\Data\ITrit;
	use \Saber\Throwable;

	/**
	 * @see http://en.wikipedia.org/wiki/Balanced_ternary
	 */
	final class Type extends Data\Type implements IIntegral\Type {

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
		protected static $module = '\\Saber\\Data\\ITrit\\Module';

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
		 * @param ITrit\Type $x                                     the class to be evaluated
		 * @return ITrit\Type                                       the class
		 */
		public static function covariant(ITrit\Type $x) : ITrit\Type {
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param int $value                                        the value(s) to be boxed
		 * @return ITrit\Type                                       the boxed object
		 */
		public static function box(int $value) : ITrit\Type {
			return new ITrit\Type($value);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return ITrit\Type                                       the boxed object
		 */
		public static function make($value) : ITrit\Type {
			if ($value < 0) {
				return ITrit\Type::negative();
			}
			else if ($value == 0) {
				return ITrit\Type::zero();
			}
			else { // ($value > 0)
				return ITrit\Type::positive();
			}
		}

		/**
		 * This method returns an object with a "-1" value.
		 *
		 * @access public
		 * @static
		 * @return ITrit\Type                                       the object
		 */
		public static function negative() : ITrit\Type {
			if (!isset(static::$singletons[-1])) {
				static::$singletons[-1] = new ITrit\Type(-1);
			}
			return static::$singletons[-1];
		}

		/**
		 * This method returns an object with a "1" value.
		 *
		 * @access public
		 * @static
		 * @return ITrit\Type                                       the object
		 */
		public static function positive() : ITrit\Type {
			if (!isset(static::$singletons[1])) {
				static::$singletons[1] = new ITrit\Type(1);
			}
			return static::$singletons[1];
		}

		/**
		 * This method returns an object with a "0" value.
		 *
		 * @access public
		 * @static
		 * @return ITrit\Type                                       the object
		 */
		public static function zero() : ITrit\Type {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new ITrit\Type(0);
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
		 * @param int $value                                        the value to be assigned
		 */
		public final function __construct(int $value) {
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
		 * @param int $depth                                        how many levels to unbox
		 * @return integer                                          the un-boxed value
		 */
		public final function unbox(int $depth = 0) {
			return $this->value;
		}

		#endregion

	}

}