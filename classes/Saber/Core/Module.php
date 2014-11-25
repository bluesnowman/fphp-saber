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

namespace Saber\Core {

	use \Saber\Control;
	use \Saber\Core;
	use \Saber\Data\String;
	use \Saber\Throwable;

	abstract class Module {

		#region Methods -> Implementation

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
		public static function __callStatic($method, $args) {
			$class = get_called_class();
			if (preg_match('/^__[a-z_][a-z0-9_]*$/i', $method)) {
				$method = substr($method, 2);
				if (!in_array($method, array('choice', 'unbox'))) {
					if (method_exists($class, $method)) {
						$result = call_user_func_array(array($class, $method), $args);
						if ($result instanceof Core\Type\Boxable) {
							return $result->unbox();
						}
						return $result;
					}
				}
			}
			throw new Throwable\UnimplementedMethod\Exception('Unable to call static method. No method ":method" exists in class ":class".', array(':class' => $class, ':method' => $method));
		}

		#endregion

		#region Methods -> Interface

		/**
		 * This method returns a choice block.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $x                                      the object to be evaluated
		 * @return Control\Monad\Choice                             the choice monad
		 */
		public static function choice(Core\Type $x) {
			return Control\Monad::choice($x);
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $x                                      the object to be evaluated
		 * @return String\Type                                      the object's hash code
		 */
		public static function hashCode(Core\Type $x) {
			return $x->hashCode();
		}

		/**
		 * This method returns the value as a String.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $x                                      the object to be converted
		 * @return String\Type                                      the value as a String
		 */
		public static function toString(Core\Type $x) {
			return $x->toString();
		}

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $x                                      the object to be evaluated
		 * @return String\Type                                      the object's class type
		 */
		public static function typeOf(Core\Type $x) {
			return $x->typeOf();
		}

		#endregion

	}

}