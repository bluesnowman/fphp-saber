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

namespace Saber\Core\AnyErr {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Throwable;

	trait Impl {

		#region Traits

		use Core\AnyRef\Impl;

		#endregion

		#region Properties

		/**
		 * This variable stores the code associated with the exception.
		 *
		 * @access protected
		 * @var integer
		 */
		protected $code;

		#endregion

		#region Methods -> Boxing/Creation

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Core\Any                                         the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function box($value/*...*/) {
			$class = get_called_class();
			$reflection = new \ReflectionClass($class);
			$args = func_get_args();
			$object = $reflection->newInstanceArgs($args);
			return $object;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Core\Any                                         the boxed object
		 */
		public static function create($value/*...*/) {
			$class = get_called_class();
			$reflection = new \ReflectionClass($class);
			$args = func_get_args();
			$object = $reflection->newInstanceArgs($args);
			return $object;
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString() {
			return sprintf('%s [ %s ]: %s ~ %s [ %d ]', get_class($this), $this->getCode(), strip_tags($this->getMessage()), $this->getFile(), $this->getLine());
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @param Core\AnyErr $that                                 the object to be compared
		 * @return Data\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public function compareTo(Core\AnyErr $that) {
			$x = $this->getCode();
			$y = $that->getCode();

			if ($x < $y) {
				return Data\Int32::negative();
			}
			else if ($x == $y) {
				return Data\Int32::zero();
			}
			else { // ($x > $y)
				return Data\Int32::one();
			}
		}

		#endregion

	}

}