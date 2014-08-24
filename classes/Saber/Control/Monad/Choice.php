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
 
namespace Saber\Control\Monad {

	use \Saber\Control;
	use \Saber\Core;
	use \Saber\Data;
 
	abstract class Choice {

		#region Methods -> Boxing/Creation

		/**
		 * This method returns a "cons" object for a choice.
		 *
		 * @access public
		 * @static
		 * @param Core\Any $x                                       the object to be evaluated
		 * @param Control\Monad\Choice $xs                          the tail
		 * @return Control\Monad\Choice\Cons                        the "cons" object
		 */
		public static function cons(Core\Any $x, Control\Monad\Choice $xs) {
			return new Control\Monad\Choice\Cons($x, $xs);
		}

		/**
		 * This method returns a "nil" object for a choice.
		 *
		 * @access public
		 * @static
		 * @return Control\Monad\Choice\Nil                         the "nil" object
		 */
		public static function nil() {
			return new Control\Monad\Choice\Nil();
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

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method causes the choice block to be closed and executed.
		 *
		 * @access public
		 * @final
		 * @return Data\Bool                                        whether a clause has executed
		 */
		public final function end() {
			return Data\Bool::create($this->__end());
		}

		/**
		 * This method sets the procedure that will execute should no other clauses
		 * be satisfied.
		 *
		 * @access public
		 * @abstract
		 * @param callable $procedure                               the procedure to be executed
		 * @return Control\Monad\Choice                             a reference to the next choice
		 *                                                          monad node
		 */
		public abstract function otherwise(callable $procedure);

		/**
		 * This method sets the procedure that will be executed should "y" not equal "x".
		 *
		 * @access public
		 * @abstract
		 * @param Core\Any $y                                       the object to be evaluated
		 *                                                          against
		 * @param callable $procedure                               the procedure to be executed
		 * @return Control\Monad\Choice                             a reference to the next choice
		 *                                                          monad node
		 */
		public abstract function unless(Core\Any $y, callable $procedure);

		/**
		 * This method sets the procedure that will be executed should "y" equal "x".
		 *
		 * @access public
		 * @abstract
		 * @param Core\Any $y                                       the object to be evaluated
		 *                                                          against
		 * @param callable $procedure                               the procedure to be executed
		 * @return Control\Monad\Choice                             a reference to the next choice
		 *                                                          monad node
		 */
		public abstract function when(Core\Any $y, callable $procedure);

		#endregion

	}

}
