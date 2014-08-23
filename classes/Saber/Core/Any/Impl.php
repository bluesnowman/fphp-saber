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

namespace Saber\Core\Any {

	use \Saber\Control;
	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Throwable;

	trait Impl {

		#region Properties

		/**
		 * This variable stores the value for the boxed object.
		 *
		 * @access protected
		 * @var mixed
		 */
		protected $value;

		#endregion

		#region Methods -> Boxing/Creation

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
			return new static($value);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Core\Any                                         the boxed object
		 */
		public static function create($value/*...*/) {
			return new static($value);
		}

		/**
		 * This method releases any internal references to an object.
		 *
		 * @access public
		 */
		public function __destruct() {
			$this->value = null;
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @param integer $depth                                    how many levels to unbox
		 * @return mixed                                            the un-boxed value
		 */
		public function unbox($depth = 0) {
			return $this->value;
		}

		#endregion

		#region Methods -> Native Oriented

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
			if (preg_match('/^__[a-z_][a-z0-9_]*$/i', $method)) {
				$name = substr($method, 2);
				if (method_exists($this, $name) && !in_array($name, array('assert', 'call', 'choice', 'unbox'))) {
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
		 * This method throws an exception should the predicate return fails.
		 *
		 * @access public
		 * @final
		 * @param callable $predicate                               the predicate function to be used
		 * @param mixed $other                                      the input aiding the assertion
		 * @return Core\Any                                         a reference to this object
		 * @throws Throwable\UnexpectedValue\Exception              indicates that the test failed
		 */
		public final function assert(callable $predicate, $other = null) {
			$result = $predicate($other);
			if ($result instanceof Core\Any) {
				$result = $result->unbox();
			}
			if (!$result) {
				throw new Throwable\UnexpectedValue\Exception('Failed assertion in class ":type".', array(':type' => $this->__typeOf()));
			}
			return $this;
		}

		/**
		 * This method returns a choice block.
		 *
		 * @access public
		 * @return Control\Monad\Choice                              the choice monad
		 */
		public function choice() {
			return Control\Monad::choice($this);
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @final
		 * @return Data\String                                      the object's hash code
		 */
		public final function hashCode() {
			return Data\String::create($this->__hashCode());
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @param Core\Any $that                                    a comparable value
		 * @return Core\Any                                         the maximum value
		 */
		public function max(Core\Any $that) {
			return ($this->__compareTo($that) > 0) ? $this : $that;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @param Core\Any $that                                    a comparable value
		 * @return Core\Any                                         the minimum value
		 */
		public function min(Core\Any $that) {
			return ($this->__compareTo($that) <= 0) ? $this : $that;
		}

		/**
		 * This method echos out this object as a string.
		 *
		 * @access public
		 * @return Core\Any                                         a reference to this object
		 */
		public function show() {
			echo $this->__toString();
			return $this;
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return Data\String                                      the object as a string
		 */
		public final function toString() {
			return Data\String::create($this->__toString());
		}

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @final
		 * @return Data\String                                      the object's class type
		 */
		public final function typeOf() {
			return Data\String::create($this->__typeOf());
		}

		#endregion

	}

}