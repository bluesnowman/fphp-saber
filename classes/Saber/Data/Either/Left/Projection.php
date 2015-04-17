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

namespace Saber\Data\Either\Left {

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
		public final function all(callable $predicate) {
			return Bool\Type::box($this->either->__isRight() || $predicate($this->either->item(), Int32\Type::zero())->unbox());
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
		public final function any(callable $predicate) {
			return Bool\Type::box($this->either->__isLeft() && $predicate($this->either->item(), Int32\Type::zero())->unbox());
		}

		/**
		 * This method binds the specified subroutine to the projection's object.
		 *
		 * @access public
		 * @final
		 * @param callable $subroutine                              the subroutine to bind
		 * @return Either\Type                                      the either
		 */
		public final function bind(callable $subroutine) {
			return ($this->either->__isLeft())
				? Either\Type::covariant($subroutine($this->either->item(), Int32\Type::zero()))
				: Either\Type::right($this->either->projectLeft()->item());
		}

		/**
		 * This method iterates over the items in the either, yielding each item to the
		 * procedure function.
		 *
		 * @access public
		 * @final
		 * @param callable $procedure                               the procedure function to be used
		 */
		public final function each(callable $procedure) {
			if ($this->either->__isLeft()) {
				Unit\Type::covariant($procedure($this->either->item(), Int32\Type::zero()));
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
		public final function filter(callable $predicate) {
			return ($this->either->__isLeft())
				? ($predicate($this->either->item(), Int32\Type::zero())->unbox())
					? Option\Type::some(Either\Type::left($this->either->item()))
					: Option\Type::none()
				: Option\Type::none();
		}

		/**
		 * This method returns the item stored within the option.
		 *
		 * @access public
		 * @final
		 * @return Core\Type                                        the stored item
		 */
		public final function item() {
			if (!$this->either->__isLeft()) {
				throw new Throwable\UnimplementedMethod\Exception('Method :method has not been implemented.', array(':method' => __FUNCTION__));
			}
			return $this->either->item();
		}

		/**
		 * This method applies each item in this either to the subroutine function.
		 *
		 * @access public
		 * @final
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return Either\Type                                      the either
		 */
		public final function map(callable $subroutine) {
			return ($this->either->__isLeft())
				? Either\Type::left($subroutine($this->either->item(), Int32\Type::zero()))
				: Either\Type::right($this->either->projectRight()->item());
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
		public final function orSome(Core\Type $y) {
			return ($this->either->__isLeft())
				? $this->either->item()
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
		public final function toArrayList() {
			return ($this->either->__isLeft())
				? ArrayList\Type::box(array($this->either->item()))
				: ArrayList\Type::empty_();
		}

		/**
		 * This method returns the either as a linked list.
		 *
		 * @access public
		 * @final
		 * @return LinkedList\Type                                  the either as a linked list
		 */
		public final function toLinkedList() {
			return ($this->either->__isLeft())
				? LinkedList\Type::cons($this->either->item())
				: LinkedList\Type::nil();
		}

		/**
		 * This method returns the either as an option.
		 *
		 * @access public
		 * @final
		 * @return Option\Type                                      the either as an option
		 */
		public final function toOption() {
			return ($this->either->__isLeft())
				? Option\Type::some($this->either->item())
				: Option\Type::none();
		}

		#endregion

	}

}