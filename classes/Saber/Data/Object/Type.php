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

namespace Saber\Data\Object {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Throwable;

	final class Type extends Data\Type implements Core\Type\Boxable {

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
			$module = '\\Saber\\Data\\Object\\Module';
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
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param mixed $value                                      the value to be assigned
		 */
		public function __construct($value) {
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
		 * @param integer $depth                                    how many levels to unbox
		 * @return mixed                                            the un-boxed value
		 */
		public final function unbox($depth = 0) {
			return $this->value;
		}

		#endregion

	}

}