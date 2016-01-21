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

namespace Saber\Data\IObject {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IObject;
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
		protected static $module = '\\Saber\\Data\\IObject\\Module';

		#endregion

		#region Methods -> Initialization

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return IObject\Type                                      the boxed object
		 */
		public static function box($value) {
			return new IObject\Type($value);
		}

		/**
		 * This method enforces that the specified class is a covariant.
		 *
		 * @access public
		 * @static
		 * @param IObject\Type $x                                    the class to be evaluated
		 * @return IObject\Type                                      the class
		 */
		public static function covariant(IObject\Type $x) {
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return IObject\Type                                      the boxed object
		 */
		public static function make($value) {
			return new IObject\Type($value);
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @final
		 * @param mixed $value                                      the value to be assigned
		 */
		public final function __construct($value) {
			$this->value = $value;
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object as a string
		 */
		public final function __toString() {
			$type = gettype($this->value);
			switch ($type) {
				case 'boolean':
					return ($this->value) ? 'true' : 'false';
				case 'double':
					return sprintf('%F', $this->value);
				case 'integer':
					return sprintf('%d', $this->value);
				case 'NULL':
					return 'null';
				case 'object':
					return $this->value->__toString();
				case 'string':
					return $this->value;
				default:
					throw new Throwable\Parse\Exception('Invalid cast. Could not convert value of ":type" to a string.', array(':type' => $type));
			}
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param int $depth                                        how many levels to unbox
		 * @return mixed                                            the un-boxed value
		 */
		public final function unbox(int $depth = 0) {
			return $this->value;
		}

		#endregion

	}

}