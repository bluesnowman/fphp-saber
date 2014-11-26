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

namespace Saber\Data\Option {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Bool;
	use \Saber\Data\Int32;
	use \Saber\Data\Option;
	use \Saber\Data\String;
	use \Saber\Throwable;

	abstract class Type extends Data\Type {

		#region Methods -> Native Oriented

		/**
		 * This method is called when a method is not defined and will attempt to remap
		 * the call.  Particularly, this method provides a shortcut means of unboxing a method's
		 * result when the method name is preceded by a double-underscore.
		 *
		 * @access public
		 * @final
		 * @param string $method                                    the method being called
		 * @param array $args                                       the arguments associated with the call
		 * @return mixed                                            the un-boxed value
		 * @throws Throwable\UnimplementedMethod\Exception          indicates that the class has not
		 *                                                          implemented the called method
		 */
		public final function __call($method, $args) {
			$module = '\\Saber\\Data\\Option\\Module';
			if (preg_match('/^__[a-z_][a-z0-9_]*$/i', $method)) {
				$method = substr($method, 2);
				if (!in_array($method, array('choice', 'unbox'))) {
					if (method_exists($module, $method)) {
						array_unshift($args, $this);
						$result = call_user_func_array(array($module, $method), $args);
						if ($result instanceof Core\Type\Boxable) {
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
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object's hash code
		 */
		public final function __hashCode() {
			return spl_object_hash($this->object());
		}

		/**
		 * This method returns whether this instance is a "some" option.
		 *
		 * @access public
		 * @final
		 * @return boolean                                          whether this instance is a "some"
		 *                                                          option
		 */
		public final function __isDefined() {
			return ($this instanceof Option\Some\Type);
		}

		/**
		 * This method returns the length of this option.
		 *
		 * @access public
		 * @final
		 * @return integer                                          the length of this option
		 */
		public final function __length() {
			return ($this->__isDefined()) ? 1 : 0;
		}

		/**
		 * This method returns the object stored within the option.
		 *
		 * @access public
		 * @final
		 * @return mixed                                            the stored object
		 */
		public final function __object() {
			return $this->object()->unbox();
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object as a string
		 */
		public final function __toString() {
			return (string) serialize($this->object());
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns whether this instance is a "some" option.
		 *
		 * @access public
		 * @final
		 * @return Bool\Type                                        whether this instance is a "some"
		 *                                                          option
		 */
		public final function isDefined() {
			return Bool\Module::create($this->__isDefined());
		}

		/**
		 * This method returns the length of this option.
		 *
		 * @access public
		 * @final
		 * @return Int32\Type                                       the length of this option
		 */
		public final function length() {
			return Int32\Module::create($this->__length());
		}

		/**
		 * This method returns the object stored within the option.
		 *
		 * @access public
		 * @abstract
		 * @return Core\Type                                        the stored object
		 */
		public abstract function object();

		#endregion

	}

}