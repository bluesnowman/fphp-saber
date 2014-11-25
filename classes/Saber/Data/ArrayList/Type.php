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

namespace Saber\Data\ArrayList {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Bool;
	use \Saber\Data\Collection;
	use \Saber\Data\Int32;
	use \Saber\Data\String;
	use \Saber\Throwable;

	final class Type extends Collection\Type implements Core\Type\Boxable {

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
			$module = '\\Saber\\Data\\ArrayList\\Module';
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
		 * @param array $value                                      the value to be assigned
		 */
		public function __construct(array $value) {
			$this->value = $value;
		}

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @final
		 * @param Int32\Type $i                                     the index of the element
		 * @return mixed                                            the element at the specified index
		 */
		public final function __element(Int32\Type $i) {
			return $this->element($i)->unbox();
		}

		/**
		 * This method returns the head object in this list.
		 *
		 * @access public
		 * @final
		 * @return mixed                                            the head object in this list
		 */
		public final function __head() {
			return $this->head()->unbox();
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @final
		 * @return boolean                                          whether the list is empty
		 */
		public final function __isEmpty() {
			return empty($this->value);
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @final
		 * @return integer                                          the length of this array list
		 */
		public final function __length() {
			return count($this->value);
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object as a string
		 */
		public final function __toString() {
			return (string) serialize($this->unbox());
		}

		/**
		 * This method returns the tail of this list.
		 *
		 * @access public
		 * @final
		 * @return array                                            the tail of this list
		 */
		public final function __tail() {
			return array_slice($this->value, 1);
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @final
		 * @param Int32\Type $i                                     the index of the element
		 * @return mixed                                            the element at the specified index
		 */
		public final function element(Int32\Type $i) {
			return $this->value[$i->unbox()];
		}

		/**
		 * This method returns the head object in this list.
		 *
		 * @access public
		 * @final
		 * @return mixed                                            the head object in this list
		 */
		public final function head() {
			return $this->value[0];
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @final
		 * @return Bool\Type                                        whether the list is empty
		 */
		public final function isEmpty() {
			return Bool\Module::create($this->__isEmpty());
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @final
		 * @return Int32\Type                                       the length of this array list
		 */
		public final function length() {
			return Int32\Module::create($this->__length());
		}

		/**
		 * This method returns the tail of this list.
		 *
		 * @access public
		 * @final
		 * @return ArrayList\Type                                   the tail of this list
		 */
		public final function tail() {
			return new ArrayList\Type($this->__tail());
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param integer $depth                                    how many levels to unbox
		 * @return array                                            the un-boxed value
		 */
		public final function unbox($depth = 0) {
			if ($depth > 0) {
				$buffer = array();
				foreach ($this->value as $item) {
					$buffer[] = ($item instanceof Core\Type\Boxable)
						? $item->unbox($depth - 1)
						: $item;
				}
				return $buffer;
			}
			return $this->value;
		}

		#endregion

	}

}