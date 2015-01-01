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

namespace Saber\Data\Either\Right {

	use \Saber\Core;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Bool;
	use \Saber\Data\Either;
	use \Saber\Data\Int32;
	use \Saber\Data\LinkedList;
	use \Saber\Data\Option;
	use \Saber\Data\Unit;
	use \Saber\Throwable;

	final class Projection extends Either\Projection {

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the items in the collection, yielding each
		 * item to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @final
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether each item passed the
		 *                                                          truthy test
		 */
		public function all(callable $predicate) {
			return Bool\Type::box($this->either->__isLeft() || $predicate($this->either->object(), Int32\Type::zero())->unbox());
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the items in the collection
		 * passed the truthy test.
		 *
		 * @access public
		 * @final
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether some of the items
		 *                                                          passed the truthy test
		 */
		public function any(callable $predicate) {
			return Bool\Type::box($this->either->__isRight() && $predicate($this->either->object(), Int32\Type::zero())->unbox());
		}

		/**
		 * This method binds the specified subroutine to the projection's object.
		 *
		 * @access public
		 * @final
		 * @param callable $subroutine                              the subroutine to bind
		 * @return Either\Type                                      the either
		 */
		public function bind(callable $subroutine) {
			return ($this->either->__isRight())
				? Either\Type::covariant($subroutine($this->either->object(), Int32\Type::zero()))
				: Either\Type::left($this->either->projectLeft()->object());
		}

		/**
		 * This method iterates over the items in the either, yielding each item to the
		 * procedure function.
		 *
		 * @access public
		 * @final
		 * @param callable $procedure                               the procedure function to be used
		 */
		public function each(callable $procedure) {
			if ($this->either->__isRight()) {
				Unit\Type::covariant($procedure($this->either->object(), Int32\Type::zero()));
			}
		}

		/**
		 * This method returns a collection of those items that satisfy the predicate.
		 *
		 * @access public
		 * @final
		 * @param callable $predicate                               the predicate function to be used
		 * @return Either\Type                                      the either
		 */
		public function filter(callable $predicate) {
			return ($this->either->__isRight())
				? ($predicate($this->either->object(), Int32\Type::zero())->unbox())
					? Option\Type::some(Either\Type::right($this->either->object()))
					: Option\Type::none()
				: Option\Type::none();
		}

		/**
		 * This method applies each item in this either to the subroutine function.
		 *
		 * @access public
		 * @final
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return Either\Type                                      the either
		 */
		public function map(callable $subroutine) {
			return ($this->either->__isRight())
				? Either\Type::right($subroutine($this->either->object(), Int32\Type::zero()))
				: Either\Type::left($this->either->projectLeft()->object());
		}

		/**
		 * This method returns the object stored within the option.
		 *
		 * @access public
		 * @final
		 * @return Core\Type                                        the stored object
		 */
		public function object() {
			if (!$this->either->__isRight()) {
				throw new Throwable\UnimplementedMethod\Exception('Method :method has not been implemented.', array(':method' => __FUNCTION__));
			}
			return $this->either->object();
		}

		/**
		 * This method returns this either's object if is has "some" object; otherwise, it will
		 * return the specified object.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $y                                      the alternative object
		 * @return Core\Type                                        the boxed object
		 */
		public function orSome(Core\Type $y) {
			return ($this->either->__isRight())
				? $this->either->object()
				: $y;
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the either as an array.
		 *
		 * @access public
		 * @final
		 * @return ArrayList\Type                                   the either as an array list
		 */
		public function toArrayList() {
			return ($this->either->__isRight())
				? ArrayList\Type::box(array($this->either->object()))
				: ArrayList\Type::empty_();
		}

		/**
		 * This method returns the either as a linked list.
		 *
		 * @access public
		 * @final
		 * @return LinkedList\Type                                  the either as a linked list
		 */
		public function toLinkedList() {
			return ($this->either->__isRight())
				? LinkedList\Type::cons($this->either->object())
				: LinkedList\Type::nil();
		}

		/**
		 * This method returns the either as an option.
		 *
		 * @access public
		 * @final
		 * @return Option\Type                                      the either as an option
		 */
		public function toOption() {
			return ($this->either->__isRight())
				? Option\Type::some($this->either->object())
				: Option\Type::none();
		}

		#endregion

	}

}