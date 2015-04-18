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

namespace Saber\Core {

	use \Saber\Core;
	use \Saber\Data\String;
	use \Saber\Throwable;

	trait Dispatcher {

		#region Properties

		/**
		 * This variable stores any mixins that can be used to extends this data type.
		 *
		 * @access protected
		 * @static
		 * @var array
		 */
		protected static $mixins = array();

		#endregion

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
			if (preg_match('/^__[a-z_][a-z0-9_]*$/i', $method)) {
				$method = substr($method, 2);
				if (!in_array($method, array('call', 'choice', 'iterator', 'unbox'))) {
					if (isset(static::$mixins[$method])) {
						array_unshift($args, $this);
						$result = call_user_func_array(static::$mixins[$method], $args);
						if ($result instanceof Core\Boxable\Type) {
							return $result->unbox();
						}
						return $result;
					}
					else if (method_exists(static::$module, $method)) {
						array_unshift($args, $this);
						$result = call_user_func_array(array(static::$module, $method), $args);
						if ($result instanceof Core\Boxable\Type) {
							return $result->unbox();
						}
						return $result;
					}
				}
			}
			else {
				if (isset(static::$mixins[$method])) {
					array_unshift($args, $this);
					return call_user_func_array(static::$mixins[$method], $args);
				}
				else if (method_exists(static::$module, $method)) {
					array_unshift($args, $this);
					return call_user_func_array(array(static::$module, $method), $args);
				}
			}
			throw new Throwable\UnimplementedMethod\Exception('Unable to call method. No method ":method" exists in module ":module".', array(':module' => static::$module, ':method' => $method));
		}

		#endregion

		#region Methods -> Extensible

		/**
		 * This method allows for the class to be extend with custom utility functions.
		 *
		 * @access public
		 * @static
		 * @param String\Type $name                                 the name of the mixin
		 * @param callable $closure                                 the custom utility function
		 */
		public static function mixin(String\Type $name, callable $closure) {
			static::$mixins[$name->unbox()] = $closure;
		}

		#endregion

	}

}