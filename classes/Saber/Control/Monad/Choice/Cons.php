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
 
namespace Saber\Control\Monad\Choice {

	use \Saber\Control;
	use \Saber\Core;
 
	class Cons extends Control\Monad\Choice {

		/**
		 * This variable stores the function to be executed when condition is
		 * satisfied.
		 *
		 * @access protected
		 * @var callable
		 */
		protected $f;

		/**
		 * This variable stores the object to be evaluated.
		 *
		 * @access protected
		 * @var Core\Any
		 */
		protected $x;

		/**
		 * This variable stores the tail.
		 *
		 * @access protected
		 * @var Control\Monad\Choice
		 */
		protected $xs;

		/**
		 * This constructor initializes the class with the specified object and tail.
		 *
		 * @access public
		 * @param Core\Any $x                                       the object to be evaluated
		 * @param Control\Monad\Choice $xs                          the tail
		 */
		public function __construct(Core\Any $x, Control\Monad\Choice $xs) {
			$this->f = null;
			$this->x = $x;
			$this->xs = $xs;
		}

		/**
		 * This method releases any internal references to an object.
		 *
		 * @access public
		 */
		public function __destruct() {
			$this->f = null;
			$this->x = null;
			$this->xs = null;
		}

		/**
		 * This method causes the choice block to be closed and executed.
		 *
		 * @access public
		 * @return boolean                                          whether a clause has executed
		 */
		public function __end() {
			if (!$this->xs->end()) {
				$f = $this->f;
				if (($f !== null) && is_callable($f)) {
					return $f($this->x);
				}
				return false;
			}
			return true;
		}

		/**
		 * This method sets the procedure that will execute should no other clauses
		 * be satisfied.
		 *
		 * @access public
		 * @param callable $procedure                               the procedure to be executed
		 * @return Control\Monad\Choice                             a reference to the next choice
		 *                                                          monad node
		 */
		public function otherwise(callable $procedure) {
			$this->f = function($x) use ($procedure) {
				$procedure($x);
				return true;
			};
			return Control\Monad\Choice::cons($this->x, $this);
		}

		/**
		 * This method sets the procedure that will be executed should "y" not equal "x".
		 *
		 * @access public
		 * @param Core\Any $y                                       the object to be evaluated
		 *                                                          against
		 * @param callable $procedure                               the procedure to be executed
		 * @return Control\Monad\Choice                             a reference to the next choice
		 *                                                          monad node
		 */
		public function unless(Core\Any $y, callable $procedure) {
			$this->f = function($x) use ($y, $procedure) {
				if (!$y->__equals($x)) {
					$procedure($x);
					return true;
				}
				return false;
			};
			return Control\Monad\Choice::cons($this->x, $this);
		}

		/**
		 * This method sets the procedure that will be executed should "y" equal "x".
		 *
		 * @access public
		 * @param Core\Any $y                                       the object to be evaluated
		 *                                                          against
		 * @param callable $procedure                               the procedure to be executed
		 * @return Control\Monad\Choice                             a reference to the next choice
		 *                                                          monad node
		 */
		public function when(Core\Any $y, callable $procedure) {
			$this->f = function($x) use ($y, $procedure) {
				if ($y->__equals($x)) {
					$procedure($x);
					return true;
				}
				return false;
			};
			return Control\Monad\Choice::cons($this->x, $this);
		}

	}
 
}
