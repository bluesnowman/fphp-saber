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

	use \Saber\Data;
	use \Saber\Throwable;

	abstract class Type {

		#region Properties

		/**
		 * This variable stores the value for the boxed object.
		 *
		 * @access protected
		 * @var mixed
		 */
		protected $value;

		#endregion

		#region Methods -> Implementation

		/**
		 * This method releases any internal references to an object.
		 *
		 * @access public
		 */
		public function __destruct() {
			$this->value = null;
		}

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
			$class = get_class($this);
			if (preg_match('/^__[a-z_][a-z0-9_]*$/i', $method)) {
				$method = substr($method, 2);
				if (!in_array($method, array('choice', 'unbox', 'value'))) {
					if (method_exists($class, $method)) {
						array_unshift($args, $this);
						$result = call_user_func_array(array($class, $method), $args);
						if ($result instanceof Data\Type\Boxable) {
							return $result->unbox();
						}
						return $result;
					}
				}
			}
			else {
				if (!in_array($method, array('value'))) {
					if (method_exists($class, $method)) {
						array_unshift($args, $this);
						$result = call_user_func_array(array($class, $method), $args);
						return $result;
					}
				}
			}
			throw new Throwable\UnimplementedMethod\Exception('Unable to call method. No method ":method" exists in class ":class".', array(':class' => $class, ':method' => $method));
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @abstract
		 * @return string                                           the object as a string
		 */
		public abstract function __toString();

		#endregion

		#region Methods -> Data Typing

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @static
		 * @param Data\Type $x                                      the object to be evaluated
		 * @return Data\String                                      the object's class type
		 */
		public static function typeOf(Data\Type $x) {
			return Data\String::create(get_class($x));
		}

	}

}