<?php
 
/**
 * Copyright 2014-2016 Blue Snowman
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

declare(strict_types = 1);

namespace Saber\Control\Choice\Cons {

	use \Saber\Control;
	use \Saber\Core;
	use \Saber\Data\IUnit;

	final class Type extends Control\Choice\Type {

		/**
		 * This variable stores the predicate that is called when evaluating the equality.
		 *
		 * @access protected
		 * @var callable
		 */
		protected $predicate;

		/**
		 * This variable stores the object to be evaluated.
		 *
		 * @access protected
		 * @var Core\Equality\Type
		 */
		protected $x;

		/**
		 * This variable stores the tail.
		 *
		 * @access protected
		 * @var Control\Choice\Type
		 */
		protected $xs;

		/**
		 * This constructor initializes the class with the specified object and tail.
		 *
		 * @access public
		 * @final
		 * @param Core\Equality\Type $x                             the object to be evaluated
		 * @param Control\Choice\Type $xs                           the tail
		 */
		public final function __construct(Core\Equality\Type $x, Control\Choice\Type $xs) {
			$this->predicate = null;
			$this->x = $x;
			$this->xs = $xs;
		}

		/**
		 * This method releases any internal references to an object.
		 *
		 * @access public
		 * @final
		 */
		public final function __destruct() {
			$this->predicate = null;
			$this->x = null;
			$this->xs = null;
		}

		/**
		 * This method causes the choice block to be closed and executed.
		 *
		 * @access public
		 * @final
		 * @return bool                                             whether a clause has executed
		 */
		public final function __end() : bool {
			if (!$this->xs->__end()) {
				$predicate = $this->predicate;
				if (($predicate !== null) && is_callable($predicate)) {
					return $predicate($this->x);
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
		 * @final
		 * @param callable $procedure                               the procedure to be executed
		 * @return Control\Choice\Type                              a reference to the next choice
		 *                                                          monad node
		 */
		public final function otherwise(callable $procedure) : Control\Choice\Type {
			$this->predicate = function($x) use ($procedure) {
				IUnit\Type::covariant($procedure($x));
				return true;
			};
			return Control\Choice\Type::cons($this->x, $this);
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
		 */
		public final function unless(Core\Equality\Type $y, callable $procedure) : Control\Choice\Type {
			$this->predicate = function($x) use ($y, $procedure) {
				if (!$y->__eq($x)) {
					IUnit\Type::covariant($procedure($x));
					return true;
				}
				return false;
			};
			return Control\Choice\Type::cons($this->x, $this);
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
		 */
		public final function when(Core\Equality\Type $y, callable $procedure) : Control\Choice\Type {
			$this->predicate = function($x) use ($y, $procedure) {
				if ($y->__eq($x)) {
					IUnit\Type::covariant($procedure($x));
					return true;
				}
				return false;
			};
			return Control\Choice\Type::cons($this->x, $this);
		}

	}
 
}
