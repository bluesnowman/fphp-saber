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

namespace Saber\Data\IDouble {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IDouble;
	use \Saber\Data\IFloating;
	use \Saber\Data\IReal;
	use \Saber\Data\IString;

	final class Type extends Data\Type implements IFloating\Type, IReal\Type {

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
		protected static $module = '\\Saber\\Data\\IDouble\\Module';

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
		 * @param float $value                                      the value(s) to be boxed
		 * @return IDouble\Type                                     the boxed object
		 */
		public static function box(float $value) : IDouble\Type {
			return new IDouble\Type($value);
		}

		/**
		 * This method enforces that the specified class is a covariant.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the class to be evaluated
		 * @return IDouble\Type                                     the class
		 */
		public static function covariant(IDouble\Type $x) : IDouble\Type {
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return IDouble\Type                                     the boxed object
		 */
		public static function make($value) : IDouble\Type {
			return new IDouble\Type((float) $value);
		}

		/**
		 * This method returns an object with a "-1" value.
		 *
		 * @access public
		 * @static
		 * @return IDouble\Type                                     the object
		 */
		public static function negative() : IDouble\Type {
			if (!isset(static::$singletons[-1])) {
				static::$singletons[-1] = new IDouble\Type(-1.0);
			}
			return static::$singletons[-1];
		}

		/**
		 * This method returns an object with a "1" value.
		 *
		 * @access public
		 * @static
		 * @return IDouble\Type                                     the object
		 */
		public static function one() : IDouble\Type {
			if (!isset(static::$singletons[1])) {
				static::$singletons[1] = new IDouble\Type(1.0);
			}
			return static::$singletons[1];
		}

		/**
		 * This method returns an object with a "0" value.
		 *
		 * @access public
		 * @static
		 * @return IDouble\Type                                     the object
		 */
		public static function zero() : IDouble\Type {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new IDouble\Type(0.0);
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
		public final function __construct(float $value) {
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
			return sprintf('%F', $this->value);
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param int $depth                                        how many levels to unbox
		 * @return double                                           the un-boxed value
		 */
		public final function unbox(int $depth = 0) {
			return $this->value;
		}

		#endregion

	}

}