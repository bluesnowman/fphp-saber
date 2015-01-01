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

		#region Methods -> Initialization

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Throwable\Runtime\Exception                      the boxed object
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
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Throwable\Runtime\Exception                      the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function make($value/*...*/) {
			$class = get_called_class();
			$reflection = new \ReflectionClass($class);
			$args = func_get_args();
			$object = $reflection->newInstanceArgs($args);
			return $object;
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method is called when a method is not defined and will attempt to remap
		 * the call.  Particularly, this method provides a shortcut means of unboxing a method's
		 * result when the method name is preceded by a double-underscore.
		 *
		 * @access public
		 * @param string $method                                    the method being called
		 * @param array $args                                       the arguments associated with the call
		 * @return mixed                                            the un-boxed value
		 * @throws Throwable\UnimplementedMethod\Exception          indicates that the class has not
		 *                                                          implemented the called method
		 */
		public function __call($method, $args) {
			$module = '\\Saber\\Throwable\\Runtime\\Exception\\Module';
			if (preg_match('/^__[a-z_][a-z0-9_]*$/i', $method)) {
				$method = substr($method, 2);
				if (!in_array($method, array('call', 'choice', 'iterator', 'unbox'))) {
					if (method_exists($module, $method)) {
						array_unshift($args, $this);
						$result = call_user_func_array(array($module, $method), $args);
						if ($result instanceof Core\Boxable\Type) {
							return $result->unbox();
						}
						return $result;
					}
				}
			}
			else {
				if (method_exists($module, $method)) {
					array_unshift($args, $this);
					$result = call_user_func_array(array($module, $method), $args);
					return $result;
				}
			}
			throw new Throwable\UnimplementedMethod\Exception('Unable to call method. No method ":method" exists in module ":module".', array(':module' => $module, ':method' => $method));
		}

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