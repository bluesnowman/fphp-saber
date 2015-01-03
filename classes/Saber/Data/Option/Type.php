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

namespace Saber\Data\Option {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Bool;
	use \Saber\Data\Collection;
	use \Saber\Data\Int32;
	use \Saber\Data\Option;
	use \Saber\Data\String;
	use \Saber\Throwable;

	abstract class Type extends Data\Type implements Core\Boxable\Type, Collection\Type {

		#region Properties

		/**
		 * This variable stores any mixins that can be used to extends this data type.
		 *
		 * @access protected
		 * @static
		 * @var array
		 */
		protected static $mixins = array();

		/**
		 * This variable stores the class path to this class' module.
		 *
		 * @access protected
		 * @static
		 * @var string
		 */
		protected static $module = '\\Saber\\Data\\Option\\Module';

		/**
		 * This variable stores references to commonly used singletons.
		 *
		 * @access protected
		 * @static
		 * @var array
		 */
		protected static $singletons = array();

		#endregion

		#region Methods -> Initialization

		/**
		 * This method enforces that the specified class is covariant.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $x                                    the class to be evaluated
		 * @return Option\Type                                      the class
		 * @throw Throwable\InvalidArgument\Exception               indicated that the specified class
		 *                                                          is not a covariant
		 */
		public static function covariant(Option\Type $x) {
			if (!($x instanceof static)) {
				throw new Throwable\InvalidArgument\Exception('Invalid class type.  Expected a class of type ":type1", but got ":type2".', array(':type1' => get_called_class(), ':type2' => get_class($x)));
			}
			return $x;
		}

		/**
		 * This method returns a "none" option.
		 *
		 * @access public
		 * @static
		 * @return Option\None\Type                                 the "none" option
		 */
		public static function none() {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new Option\None\Type();
			}
			return static::$singletons[0];
		}

		/**
		 * This method returns a "some" option.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $x                                      the object to be wrapped
		 * @return Option\Some\Type                                 the "some" option
		 */
		public static function some(Core\Type $x) {
			return new Option\Some\Type($x);
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
		 * This method returns the size of this option.
		 *
		 * @access public
		 * @final
		 * @return integer                                          the size of this option
		 */
		public final function __size() {
			return ($this->__isDefined()) ? 1 : 0;
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
			return Bool\Type::box($this->__isDefined());
		}

		/**
		 * This method returns the object stored within the option.
		 *
		 * @access public
		 * @abstract
		 * @return Core\Type                                        the stored object
		 */
		public abstract function object();

		/**
		 * This method returns the size of this option.
		 *
		 * @access public
		 * @final
		 * @return Int32\Type                                       the size of this option
		 */
		public final function size() {
			return Int32\Type::box($this->__size());
		}

		#endregion

	}

}