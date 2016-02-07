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

namespace Saber\Data\IEither {

	use \Saber\Core;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IEither;
	use \Saber\Data\ILinkedList;
	use \Saber\Data\IOption;

	abstract class Projection {

		#region Properties

		/**
		 * This variable stores the either type.
		 *
		 * @access protected
		 * @var IEither\Type
		 */
		protected $either;

		#endregion

		#region Methods -> Native Oriented

		public function __construct(IEither\Type $either) {
			$this->either = $either;
		}

		#endregion

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the items in the collection, yielding each
		 * item to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @abstract
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                       whether each item passed the
		 *                                                          truthy test
		 */
		public abstract function all(callable $predicate) : IBool\Type;

		/**
		 * This method (aka "exists" or "some") returns whether some of the items in the collection
		 * passed the truthy test.
		 *
		 * @access public
		 * @abstract
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                       whether some of the items
		 *                                                          passed the truthy test
		 */
		public abstract function any(callable $predicate) : IBool\Type;

		/**
		 * This method binds the specified subroutine to the projection's object.
		 *
		 * @access public
		 * @abstract
		 * @param callable $subroutine                              the subroutine to bind
		 * @return IEither\Type                                     the either
		 */
		public abstract function bind(callable $subroutine) : IEither\Type;

		/**
		 * This method iterates over the items in the either, yielding each item to the
		 * procedure function.
		 *
		 * @access public
		 * @abstract
		 * @param callable $procedure                               the procedure function to be used
		 * @return IEither\Projection                               the projection
		 */
		public abstract function each(callable $procedure) : IEither\Projection;

		/**
		 * This method returns the either that the projection was created.
		 *
		 * @access public
		 * @final
		 * @return IEither\Type                                     the either
		 */
		public final function either() : IEither\Type {
			return $this->either;
		}

		/**
		 * This method returns a collection of those items that satisfy the predicate.
		 *
		 * @access public
		 * @abstract
		 * @param callable $predicate                               the predicate function to be used
		 * @return IEither\Type                                     the either
		 */
		public abstract function filter(callable $predicate) : IEither\Type;

		/**
		 * This method returns the item stored within the option.
		 *
		 * @access public
		 * @abstract
		 * @return Core\Type                                        the stored item
		 */
		public abstract function item() : Core\Type;

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @final
		 * @return IArrayList\Iterator                              an iterator for this collection
		 */
		public final function iterator() : IArrayList\Iterator {
			return IArrayList\Module::iterator($this->toArrayList());
		}

		/**
		 * This method applies each item in this either to the subroutine function.
		 *
		 * @access public
		 * @abstract
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return IEither\Type                                     the either
		 */
		public abstract function map(callable $subroutine) : IEither\Type;

		/**
		 * This method returns this either's object if is has "some" object; otherwise, it will
		 * return the specified object.
		 *
		 * @access public
		 * @abstract
		 * @param Core\Type $y                                      the alternative object
		 * @return Core\Type                                        the boxed object
		 */
		public abstract function orSome(Core\Type $y) : Core\Type;

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the either as an array.
		 *
		 * @access public
		 * @abstract
		 * @return IArrayList\Type                                  the either as an array list
		 */
		public abstract function toArrayList() : IArrayList\Type;

		/**
		 * This method returns the either as a linked list.
		 *
		 * @access public
		 * @abstract
		 * @return ILinkedList\Type                                 the either as a linked list
		 */
		public abstract function toLinkedList() : ILinkedList;

		/**
		 * This method returns the either as an option.
		 *
		 * @access public
		 * @abstract
		 * @return IOption\Type                                     the either as an option
		 */
		public abstract function toOption() : IOption\Type;

		#endregion

	}

}