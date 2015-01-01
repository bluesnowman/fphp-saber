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
 
namespace Saber\Control\Choice\Nil {

	use \Saber\Control;
	use \Saber\Core;
	use \Saber\Throwable;
 
	final class Type extends Control\Choice\Type {

		/**
		 * This method causes the choice block to be closed and executed.
		 *
		 * @access public
		 * @final
		 * @return boolean                                          whether a clause has executed
		 */
		public final function __end() {
			return false;
		}

		/**
		 * This method sets the procedure that will execute should no other clauses
		 * be satisfied.
		 *
		 * @access public
		 * @final
		 * @param callable $procedure                               the procedure to be executed
		 * @return Control\Choice\Type                              a reference to the next choice
		 *                                                          monad node
		 * @throws Throwable\UnimplementedMethod\Exception          indicates that this method cannot
		 *                                                          be called
		 */
		public final function otherwise(callable $procedure) {
			throw new Throwable\UnimplementedMethod\Exception('Method :method has not been implemented.', array(':method' => __FUNCTION__));
		}

		/**
		 * This method sets the procedure that will be executed should "y" not equal "x".
		 *
		 * @access public
		 * @final
		 * @param Core\Equality\Type $y                             the object to be evaluated
		 *                                                          against
		 * @param callable $procedure                               the procedure to be executed
		 * @return Control\Choice\Type                              a reference to the next choice
		 *                                                          monad node
		 * @throws Throwable\UnimplementedMethod\Exception          indicates that this method cannot
		 *                                                          be called
		 */
		public final function unless(Core\Equality\Type $y, callable $procedure) {
			throw new Throwable\UnimplementedMethod\Exception('Method :method has not been implemented.', array(':method' => __FUNCTION__));
		}

		/**
		 * This method sets the procedure that will be executed should "y" equal "x".
		 *
		 * @access public
		 * @final
		 * @param Core\Equality\Type $y                             the object to be evaluated
		 *                                                          against
		 * @param callable $procedure                               the procedure to be executed
		 * @return Control\Choice\Type                              a reference to the next choice
		 *                                                          monad node
		 * @throws Throwable\UnimplementedMethod\Exception          indicates that this method cannot
		 *                                                          be called
		 */
		public final function when(Core\Equality\Type $y, callable $procedure) {
			throw new Throwable\UnimplementedMethod\Exception('Method :method has not been implemented.', array(':method' => __FUNCTION__));
		}

	}
 
}