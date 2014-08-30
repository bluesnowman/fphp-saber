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

namespace Saber\Data {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Throwable;

	final class Bool implements Core\AnyVal {

		#region Traits

		use Core\AnyVal\Impl;

		#endregion

		#region Methods -> Boxing/Creation

		/**
		 * This method is called when the function is not defined and will attempt to remap
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
			if (preg_match('/^[a-z_][a-z0-9_]*$/i', $method)) {
				array_unshift($args, $this);
				$result = call_user_func_array(get_class($this). '\\Module::' . $method, $args);
				return $result;
			}
			else if (preg_match('/^__[a-z_][a-z0-9_]*$/i', $method)) {
				$name = substr($method, 2);
				if (method_exists($this, $name) && !in_array($name, array('assert', 'call', 'choice', 'iterator', 'unbox'))) {
					$result = call_user_func_array(array($this, $name), $args);
					if ($result instanceof Core\Any) {
						return $result->unbox();
					}
					return $result;
				}
			}
			throw new Throwable\UnimplementedMethod\Exception('Unable to call method. No method ":method" exists in class ":class".', array(':class' => $this->__typeOf(), ':method' => $method));
		}

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
			if ((func_num_args() > 1) && func_get_arg(1) && is_string($value) && in_array(strtolower($value), array('false', 'f', 'no', 'n', '0'))) {
				$value = false;
			}
			return new static($value);
		}

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param boolean $value                                    the value to be assigned
		 */
		public function __construct($value) {
			$this->value = (bool) $value;
		}

		/**
		 * This method returns an object with a "false" value.
		 *
		 * @access public
		 * @return Data\Bool                                        the object
		 */
		public static function false() {
			return Data\Bool::create(false);
		}

		/**
		 * This method returns an object with a "true" value.
		 *
		 * @access public
		 * @return Data\Bool                                        the object
		 */
		public static function true() {
			return Data\Bool::create(true);
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
			return ($this->unbox()) ? 'true' : 'false';
		}

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object's class type
		 */
		public function __typeOf() {
			return get_called_class();
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @param Data\Bool $that                                   the object to be compared
		 * @return Data\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public function compareTo(Data\Bool $that) {
			$x = $this->unbox();
			$y = $that->unbox();

			if (!$x && $y) {
				return Data\Int32::negative();
			}
			else if ($x == $y) {
				return Data\Int32::zero();
			}
			else { // ($x && !$y)
				return Data\Int32::one();
			}
		}

		#endregion

	}

}