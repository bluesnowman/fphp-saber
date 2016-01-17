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

namespace Saber\Data\IRegex {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IRegex;
	use \Saber\Data\IString;
	use \Saber\Throwable;

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
		protected static $module = '\\Saber\\Data\\IRegex\\Module';

		#endregion

		#region Methods -> Initialization

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param string $value                                     the value(s) to be boxed
		 * @return IRegex\Type                                       the boxed expression
		 */
		public static function box($value) {
			return new IRegex\Type($value);
		}

		/**
		 * This method enforces that the specified class is a covariant.
		 *
		 * @access public
		 * @static
		 * @param IRegex\Type $x                                     the class to be evaluated
		 * @return IRegex\Type                                       the class
		 */
		public static function covariant(IRegex\Type $x) {
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param string $value                                     the value(s) to be boxed
		 * @return IRegex\Type                                       the boxed expression
		 */
		public static function make($value) {
			return new IRegex\Type(preg_quote($value));
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
			return spl_object_hash($this);
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
