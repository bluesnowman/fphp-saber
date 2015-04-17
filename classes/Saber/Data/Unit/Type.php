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

namespace Saber\Data\Unit {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\String;
	use \Saber\Data\Unit;
	use \Saber\Throwable;

	final class Type extends Data\Type {

		#region Traits

		use Core\Module\Dispatcher;

		#endregion

		#region Properties

		/**
		 * This variable stores the class path to this class' module.
		 *
		 * @access protected
		 * @static
		 * @var string
		 */
		protected static $module = '\\Saber\\Data\\Unit\\Module';

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
		 * @param Unit\Type $x                                      the class to be evaluated
		 * @return Unit\Type                                        the class
		 */
		public static function covariant(Unit\Type $x = null) {
			if ($x === null) {
				return Unit\Type::instance();
			}
			return $x;
		}

		/**
		 * This method returns an instance of this type.
		 *
		 * @access public
		 * @static
		 * @return Unit\Type                                        an instance of this type
		 */
		public static function instance() {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new Unit\Type();
			}
			return static::$singletons[0];
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This constructor initializes the class.
		 *
		 * @access public
		 * @final
		 */
		public final function __construct() {
			$this->value = null;
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
			return 'null';
		}

		#endregion

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param integer $depth                                    how many levels to unbox
		 * @return mixed                                            the un-boxed value
		 */
		public final function unbox($depth = 0) {
			return $this->value;
		}

		#endregion

	}

}