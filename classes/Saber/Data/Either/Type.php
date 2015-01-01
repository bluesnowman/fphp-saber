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

namespace Saber\Data\Either {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Bool;
	use \Saber\Data\Collection;
	use \Saber\Data\Either;
	use \Saber\Data\String;
	use \Saber\Data\Unit;
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
		protected static $module = '\\Saber\\Data\\Either\\Module';

		#endregion

		#region Methods -> Initialization

		/**
		 * This method enforces that the specified class is covariant.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $x                                      the class to be evaluated
		 * @return Either\Type                                      the class
		 * @throw Throwable\InvalidArgument\Exception               indicated that the specified class
		 *                                                          is not a covariant
		 */
		public static function covariant(Core\Type $x) {
			if (!($x instanceof static)) {
				throw new Throwable\InvalidArgument\Exception('Invalid class type.  Expected a class of type ":type1", but got ":type2".', array(':type1' => get_called_class(), ':type2' => get_class($x)));
			}
			return $x;
		}

		/**
		 * This method returns a left node containing the specified value.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $x                                      the object to be boxed
		 * @return Either\Left\Type                                 a left node
		 */
		public static function left(Core\Type $x = null) {
			if ($x === null) {
				$x = Unit\Type::instance();
			}
			return new Either\Left\Type($x);
		}

		/**
		 * This method returns a right node containing the specified value.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $x                                      the object to be boxed
		 * @return Either\Right\Type                                a right node
		 */
		public static function right(Core\Type $x = null) {
			if ($x === null) {
				$x = Unit\Type::instance();
			}
			return new Either\Right\Type($x);
		}

		#endregion

		#region Methods -> Extensible

		/**
		 * This method allows for the class to be extend with custom utility functions.
		 *
		 * @access public
		 * @static
		 * @param String\Type $name                                 the name of the mixin
		 * @param callable $function                                the custom utility function
		 */
		public static function mixin(String\Type $name, callable $function) {
			static::$mixins[$name->unbox()] = $function;
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
					if (method_exists(static::$module, $method)) {
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
				if (method_exists(static::$module, $method)) {
					array_unshift($args, $this);
					$result = call_user_func_array(array(static::$module, $method), $args);
					return $result;
				}
			}
			throw new Throwable\UnimplementedMethod\Exception('Unable to call method. No method ":method" exists in module ":module".', array(':module' => static::$module, ':method' => $method));
		}

		/**
		 * This constructor initializes the class with the specified object.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $x                                      the object to be boxed
		 */
		public final function __construct(Core\Type $x) {
			$this->value = $x;
		}

		/**
		 * This method returns whether the node is a Left\Type.
		 *
		 * @access public
		 * @final
		 * @return boolean                                          whether the node is a Left\Type
		 */
		public final function __isLeft() {
			return ($this instanceof Either\Left\Type);
		}

		/**
		 * This method returns whether the node is a Right\Type.
		 *
		 * @access public
		 * @final
		 * @return boolean                                          whether the node is a Right\Type
		 */
		public final function __isRight() {
			return ($this instanceof Either\Right\Type);
		}

		/**
		 * This method returns the object stored within the either.
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
			return (string) serialize($this->value);
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns whether the node is a Left\Type.
		 *
		 * @access public
		 * @final
		 * @return Bool\Type                                        whether the node is a Left\Type
		 */
		public final function isLeft() {
			return Bool\Type::box($this->__isLeft());
		}

		/**
		 * This method returns whether the node is a Right\Type.
		 *
		 * @access public
		 * @final
		 * @return Bool\Type                                        whether the node is a Right\Type
		 */
		public final function isRight() {
			return Bool\Type::box($this->__isRight());
		}

		/**
		 * This method returns the object stored within the either.
		 *
		 * @access public
		 * @final
		 * @return Core\Type                                        the stored object
		 */
		public final function object() {
			return $this->value;
		}

		/**
		 * This method returns a left projection of this either.
		 *
		 * @access public
		 * @final
		 * @return Either\Left\Projection                           a left projection
		 */
		public final function projectLeft() {
			return new Either\Left\Projection($this);
		}

		/**
		 * This method returns a right projection of this either.
		 *
		 * @access public
		 * @final
		 * @return Either\Right\Projection                          a right projection
		 */
		public final function projectRight() {
			return new Either\Right\Projection($this);
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param integer $depth                                    how many levels to unbox
		 * @return mixed                                            the un-boxed value
		 */
		public final function unbox($depth = 0) {
			if ($depth > 0) {
				if ($this->value instanceof Core\Boxable\Type) {
					$this->value->unbox($depth - 1);
				}
			}
			return $this->value;
		}

		#endregion

	}

}