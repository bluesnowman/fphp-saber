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

namespace Saber\Data\IEither\Right {

	use \Saber\Core;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IEither;
	use \Saber\Data\IInt32;
	use \Saber\Data\ILinkedList;
	use \Saber\Data\IOption;
	use \Saber\Data\IUnit;
	use \Saber\Throwable;

	final class Projection extends IEither\Projection {

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the items in the collection, yielding each
		 * item to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @final
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                       whether each item passed the
		 *                                                          truthy test
		 */
		public function all(callable $predicate) : IBool\Type {
			return IBool\Type::box($this->either->__isLeft() || $predicate($this->either->item(), IInt32\Type::zero())->unbox());
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the items in the collection
		 * passed the truthy test.
		 *
		 * @access public
		 * @final
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                       whether some of the items
		 *                                                          passed the truthy test
		 */
		public function any(callable $predicate) : IBool\Type {
			return IBool\Type::box($this->either->__isRight() && $predicate($this->either->item(), IInt32\Type::zero())->unbox());
		}

		/**
		 * This method binds the specified subroutine to the projection's object.
		 *
		 * @access public
		 * @final
		 * @param callable $subroutine                              the subroutine to bind
		 * @return IEither\Type                                     the either
		 */
		public function bind(callable $subroutine) : IEither\Type {
			return ($this->either->__isRight())
				? IEither\Type::covariant($subroutine($this->either->item(), IInt32\Type::zero()))
				: IEither\Type::left($this->either->projectLeft()->item());
		}

		/**
		 * This method iterates over the items in the either, yielding each item to the
		 * procedure function.
		 *
		 * @access public
		 * @final
		 * @param callable $procedure                               the procedure function to be used
		 * @return IEither\Projection                               the projection
		 */
		public function each(callable $procedure) : IEither\Projection {
			if ($this->either->__isRight()) {
				IUnit\Type::covariant($procedure($this->either->item(), IInt32\Type::zero()));
			}
			return $this;
		}

		/**
		 * This method returns a collection of those items that satisfy the predicate.
		 *
		 * @access public
		 * @final
		 * @param callable $predicate                               the predicate function to be used
		 * @return IEither\Type                                     the either
		 */
		public function filter(callable $predicate) : IEither\Type {
			return ($this->either->__isRight())
				? ($predicate($this->either->item(), IInt32\Type::zero())->unbox())
					? IOption\Type::some(IEither\Type::right($this->either->item()))
					: IOption\Type::none()
				: IOption\Type::none();
		}

		/**
		 * This method returns the item stored within the option.
		 *
		 * @access public
		 * @final
		 * @return Core\Type                                        the stored item
		 */
		public function item() : Core\Type {
			if (!$this->either->__isRight()) {
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
		 * @return IEither\Type                                     the either
		 */
		public function map(callable $subroutine) : IEither\Type {
			return ($this->either->__isRight())
				? IEither\Type::right($subroutine($this->either->item(), IInt32\Type::zero()))
				: IEither\Type::left($this->either->projectLeft()->item());
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
		public function orSome(Core\Type $y) : Core\Type {
			return ($this->either->__isRight())
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
		 * @return IArrayList\Type                                  the either as an array list
		 */
		public function toArrayList() : IArrayList\Type {
			return ($this->either->__isRight())
				? IArrayList\Type::box(array($this->either->item()))
				: IArrayList\Type::empty_();
		}

		/**
		 * This method returns the either as a linked list.
		 *
		 * @access public
		 * @final
		 * @return ILinkedList\Type                                 the either as a linked list
		 */
		public function toLinkedList() : ILinkedList\Type {
			return ($this->either->__isRight())
				? ILinkedList\Type::cons($this->either->item())
				: ILinkedList\Type::nil();
		}

		/**
		 * This method returns the either as an option.
		 *
		 * @access public
		 * @final
		 * @return IOption\Type                                     the either as an option
		 */
		public function toOption() : IOption\Type {
			return ($this->either->__isRight())
				? IOption\Type::some($this->either->item())
				: IOption\Type::none();
		}

		#endregion

	}

}