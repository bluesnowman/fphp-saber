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

namespace Saber\Data\Either {

	use \Saber\Core;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Bool;
	use \Saber\Data\Either;
	use \Saber\Data\LinkedList;
	use \Saber\Data\Option;

	abstract class Projection {

		#region Properties

		/**
		 * This variable stores the either type.
		 *
		 * @access protected
		 * @var Either\Type
		 */
		protected $either;

		#endregion

		#region Methods -> Native Oriented

		public function __construct(Either\Type $either) {
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
		 * @return Bool\Type                                        whether each item passed the
		 *                                                          truthy test
		 */
		public abstract function all(callable $predicate);

		/**
		 * This method (aka "exists" or "some") returns whether some of the items in the collection
		 * passed the truthy test.
		 *
		 * @access public
		 * @abstract
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether some of the items
		 *                                                          passed the truthy test
		 */
		public abstract function any(callable $predicate);

		/**
		 * This method binds the specified subroutine to the projection's object.
		 *
		 * @access public
		 * @abstract
		 * @param callable $subroutine                              the subroutine to bind
		 * @return Either\Type                                      the either
		 */
		public abstract function bind(callable $subroutine);

		/**
		 * This method iterates over the items in the either, yielding each item to the
		 * procedure function.
		 *
		 * @access public
		 * @abstract
		 * @param callable $procedure                               the procedure function to be used
		 */
		public abstract function each(callable $procedure);

		/**
		 * This method returns the either that the projection was created.
		 *
		 * @access public
		 * @final
		 * @return Either\Type                                      the either
		 */
		public final function either() {
			$this->either;
		}

		/**
		 * This method returns a collection of those items that satisfy the predicate.
		 *
		 * @access public
		 * @abstract
		 * @param callable $predicate                               the predicate function to be used
		 * @return Either\Type                                      the either
		 */
		public abstract function filter(callable $predicate);

		/**
		 * This method returns the item stored within the option.
		 *
		 * @access public
		 * @abstract
		 * @return Core\Type                                        the stored item
		 */
		public abstract function item();

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @final
		 * @return ArrayList\Iterator                               an iterator for this collection
		 */
		public final function iterator() {
			return ArrayList\Module::iterator($this->toArrayList());
		}

		/**
		 * This method applies each item in this either to the subroutine function.
		 *
		 * @access public
		 * @abstract
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return Either\Type                                      the either
		 */
		public abstract function map(callable $subroutine);

		/**
		 * This method returns this either's object if is has "some" object; otherwise, it will
		 * return the specified object.
		 *
		 * @access public
		 * @abstract
		 * @param Core\Type $y                                      the alternative object
		 * @return Core\Type                                        the boxed object
		 */
		public abstract function orSome(Core\Type $y);

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the either as an array.
		 *
		 * @access public
		 * @abstract
		 * @return ArrayList\Type                                   the either as an array list
		 */
		public abstract function toArrayList();

		/**
		 * This method returns the either as a linked list.
		 *
		 * @access public
		 * @abstract
		 * @return LinkedList\Type                                  the either as a linked list
		 */
		public abstract function toLinkedList();

		/**
		 * This method returns the either as an option.
		 *
		 * @access public
		 * @abstract
		 * @return Option\Type                                      the either as an option
		 */
		public abstract function toOption();

		#endregion

	}

}