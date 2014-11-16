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
	use \Saber\Data;
	use \Saber\Throwable;

	interface Any {

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
		public static function box($value/*...*/);

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Core\Any                                         the boxed object
		 */
		public static function create($value/*...*/);

		/**
		 * This method releases any internal references to an object.
		 *
		 * @access public
		 */
		public function __destruct();

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @param integer $depth                                    how many levels to unbox
		 * @return mixed                                            the un-boxed value
		 */
		public function unbox($depth = 0);

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @return string                                           the object's hash code
		 */
		public function __hashCode();

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString();

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @return string                                           the object's class type
		 */
		public function __typeOf();

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method throws an exception should the predicate return fails.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @param mixed $other                                      the input aiding the assertion
		 * @return Core\Any                                         a reference to this object
		 * @throws Throwable\Runtime\Exception                      indicates that the test failed
		 */
		public function assert(callable $predicate, $other = null);

		/**
		 * This method returns a choice block.
		 *
		 * @access public
		 * @return Control\Monad\Choice                              the choice monad
		 */
		public function choice();

		/**
		 * This method evaluates whether the specified object is equal to the current object.
		 *
		 * @access public
		 * @param Core\Any $that                                    the object to be evaluated
		 * @return Data\Bool                                        whether the specified object is equal
		 *                                                          to the current object
		 */
		public function equals(Core\Any $that);

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @return Data\String                                      the object's hash code
		 */
		public function hashCode();

		/**
		 * This method evaluates whether the specified object is identical to the current object.
		 *
		 * @access public
		 * @param Core\Any $that                                    the object to be evaluated
		 * @return Data\Bool                                        whether the specified object is identical
		 *                                                          to the current object
		 */
		public function identical(Core\Any $that);

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @param Core\Any $that                                    a comparable value
		 * @return Core\Any                                         the maximum value
		 */
		public function max(Core\Any $that);

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @param Core\Any $that                                    a comparable value
		 * @return Core\Any                                         the minimum value
		 */
		public function min(Core\Any $that);

		/**
		 * This method echos out this object as a string.
		 *
		 * @access public
		 * @return Core\Any                                         a reference to this object
		 */
		public function show();

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return Data\String                                      the object as a string
		 */
		public function toString();

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @return Data\String                                      the object's class type
		 */
		public function typeOf();

		#endregion

	}

}