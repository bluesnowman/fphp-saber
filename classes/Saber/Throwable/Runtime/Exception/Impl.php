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

namespace Saber\Throwable\Runtime\Exception {

	use \Saber\Core;
	use \Saber\Data\String;
	use \Saber\Throwable;

	trait Impl {

		#region Traits

		use Core\Module\Dispatcher;

		#endregion

		#region Methods -> Initialization

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param array $args                                       the value(s) to be boxed
		 * @return Throwable\Runtime\Exception                      the boxed object
		 */
		public static function box(array $args) {
			$class = get_called_class();
			$reflection = new \ReflectionClass($class);
			$object = $reflection->newInstanceArgs($args);
			return $object;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed ...$args                                    the value(s) to be boxed
		 * @return Throwable\Runtime\Exception                      the boxed object
		 */
		public static function box2(...$args) {
			return static::box($args);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param array $args                                       the value(s) to be boxed
		 * @return Throwable\Runtime\Exception                      the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function make(array $args) {
			$class = get_called_class();
			$reflection = new \ReflectionClass($class);
			$object = $reflection->newInstanceArgs($args);
			return $object;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed ...$args                                    the value(s) to be boxed
		 * @return Throwable\Runtime\Exception                      the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function make2(...$args) {
			return static::make($args);
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method returns the exception code.
		 *
		 * @access public
		 * @return integer                                          the exception code
		 */
		public function __getCode() {
			return $this->getCode();
		}

		/**
		 * This method returns the source file's name.
		 *
		 * @access public
		 * @return string                                           the source file's name
		 */
		public function __getFile() {
			return $this->getFile();
		}

		/**
		 * This method returns the line at which the exception was thrown.
		 *
		 * @access public
		 * @return integer                                          the source line
		 */
		public function __getLine() {
			return $this->getLine();
		}

		/**
		 * This method returns the exception message.
		 *
		 * @access public
		 * @return string                                           the exception message
		 */
		public function __getMessage() {
			return $this->getMessage();
		}

		/**
		 * This method returns any backtrace information.
		 *
		 * @access public
		 * @return array                                            any backtrace information
		 */
		public function __getTrace() {
			return $this->getTrace();
		}

		/**
		 * This method returns the backtrace information as a string.
		 *
		 * @access public
		 * @return string                                           the backtrace information
		 */
		public function __getTraceAsString() {
			return $this->getTraceAsString();
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @return string                                           the object's hash code
		 */
		public function __hashCode() {
			return spl_object_hash($this);
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString() {
			return sprintf(
				'%s [ %s ]: %s ~ %s [ %d ]',
				$this->__typeOf(),
				$this->__getCode(),
				strip_tags($this->__getMessage()),
				$this->__getFile(),
				$this->__getLine()
			);
		}

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @return string                                           the object's class type
		 */
		public function __typeOf() {
			return get_class($this);
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @final
		 * @return String\Type                                      the object's hash code
		 */
		public final function hashCode() {
			return String\Type::box($this->__hashCode());
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return String\Type                                      the object as a string
		 */
		public final function toString() {
			return String\Type::box($this->__toString());
		}

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @final
		 * @return String\Type                                      the object's class type
		 */
		public final function typeOf() {
			return String\Type::box($this->__typeOf());
		}

		#endregion

	}

}