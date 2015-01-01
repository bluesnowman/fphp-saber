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
 
namespace Saber\Control\Choice {

	use \Saber\Control;
	use \Saber\Core;
	use \Saber\Data\Bool;
	use \Saber\Data\String;
 
	abstract class Type implements Core\Type {

		#region Properties

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
		 * This method returns a "cons" object for a choice.
		 *
		 * @access public
		 * @static
		 * @param Core\Equality\Type $x                             the object to be evaluated
		 * @param Control\Choice\Type $xs                           the tail
		 * @return Control\Choice\Type                              the "cons" object
		 */
		public static function cons(Core\Equality\Type $x, Control\Choice\Type $xs) {
			if ($xs !== null) {
				return new Control\Choice\Cons\Type($x, $xs);
			}
			return new Control\Choice\Cons\Type($x, Control\Choice\Type::nil());
		}

		/**
		 * This method returns a "nil" object for a choice.
		 *
		 * @access public
		 * @static
		 * @return Control\Choice\Type                              the "nil" object
		 */
		public static function nil() {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new Control\Choice\Nil\Type();
			}
			return static::$singletons[0];
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method causes the choice block to be closed and executed.
		 *
		 * @access public
		 * @abstract
		 * @return boolean                                          whether a clause has executed
		 */
		public abstract function __end();

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object's hash code
		 */
		public final function __hashCode() {
			return spl_object_hash($this);
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object as a string
		 */
		public final function __toString() {
			return $this->__hashCode();
		}

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object's class type
		 */
		public final function __typeOf() {
			return get_class($this);
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method causes the choice block to be closed and executed.
		 *
		 * @access public
		 * @final
		 * @return Bool\Type                                        whether a clause has executed
		 */
		public final function end() {
			return Bool\Type::box($this->__end());
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @final
		 * @return String\Type                                      the object's hash code
		 */
		public final function hashCode() {
			return String\Type::box($this->__hashCode());
		}

		/**
		 * This method sets the procedure that will execute should no other clauses
		 * be satisfied.
		 *
		 * @access public
		 * @abstract
		 * @param callable $procedure                               the procedure to be executed
		 * @return Control\Choice\Type                              a reference to the next choice
		 *                                                          monad node
		 */
		public abstract function otherwise(callable $procedure);

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return String\Type                                      the object as a string
		 */
		public final function toString() {
			return String\Type::box($this->__toString());
		}

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @final
		 * @return String\Type                                      the object's class type
		 */
		public final function typeOf() {
			return String\Type::box($this->__typeOf());
		}

		/**
		 * This method sets the procedure that will be executed should "y" not equal "x".
		 *
		 * @access public
		 * @abstract
		 * @param Core\Equality\Type $y                             the object to be evaluated
		 *                                                          against
		 * @param callable $procedure                               the procedure to be executed
		 * @return Control\Choice\Type                              a reference to the next choice
		 *                                                          monad node
		 */
		public abstract function unless(Core\Equality\Type $y, callable $procedure);

		/**
		 * This method sets the procedure that will be executed should "y" equal "x".
		 *
		 * @access public
		 * @abstract
		 * @param Core\Equality\Type $y                             the object to be evaluated
		 *                                                          against
		 * @param callable $procedure                               the procedure to be executed
		 * @return Control\Choice\Type                              a reference to the next choice
		 *                                                          monad node
		 */
		public abstract function when(Core\Equality\Type $y, callable $procedure);

		#endregion

	}

}
