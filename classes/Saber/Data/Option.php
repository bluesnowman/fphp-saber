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

namespace Saber\Data {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Throwable;

	abstract class Option implements Core\AnyRef {

		#region Traits

		use Core\AnyRef\Impl;

		#endregion

		#region Methods -> Boxing/Creation

		/**
		 * This method returns a "none" option.
		 *
		 * @access public
		 * @static
		 * @return Data\Option\None                                 the "none" option
		 */
		public static function none() {
			return new Data\Option\None();
		}

		/**
		 * This method returns a "some" option.
		 *
		 * @access public
		 * @static
		 * @param Core\Any $object                                  the boxed object to be made an
		 *                                                          option
		 * @return Data\Option\Some                                 the "some" option
		 */
		public static function some(Core\Any $object) {
			return new Data\Option\Some($object);
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method returns whether this instance is a "some" option.
		 *
		 * @access public
		 * @return boolean                                          whether this instance is a "some"
		 *                                                          option
		 */
		public function __isDefined() {
			return ($this instanceof Data\Option\Some);
		}

		/**
		 * This method returns the boxed object as a string.
		 *
		 * @access public
		 * @return string                                           the boxed object as a string
		 */
		public function __toString() {
			return '' . $this->object();
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method (aka "every" or "forall") iterates over the elements in the collection, yielding each
		 * element to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether each element passed the
		 *                                                          truthy test
		 */
		public function all(callable $predicate) {
			return Data\Bool::create(!$this->__isDefined() || $predicate($this->object(), Data\Int32::zero())->unbox());
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the elements in the collection
		 * passed the truthy test.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether some of the elements
		 *                                                          passed the truthy test
		 */
		public function any(callable $predicate) {
			return $this->find($predicate)->isDefined();
		}

		/**
		 * This method binds the subroutine to the object within this option.
		 *
		 * @access public
		 * @param callable $subroutine                              the subroutine function to be applied
		 * @return Data\Option                                      the option
		 */
		public function bind(callable $subroutine) {
			return ($this->__isDefined()) ? $subroutine($this->object(), Data\Int32::zero()) : static::none();
		}

		/**
		 * This method iterates over the elements in the option, yielding each element to the
		 * procedure function.
		 *
		 * @access public
		 * @param callable $procedure                               the procedure function to be used
		 */
		public function each(callable $procedure) {
			if ($this->__isDefined()) {
				$procedure($this->object(), Data\Int32::zero());
			}
		}

		/**
		 * This method returns a collection of those elements that satisfy the predicate.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Option                                      the option
		 */
		public function filter(callable $predicate) {
			if ($this->__isDefined() && $predicate($this->object(), Data\Int32::zero())->unbox()) {
				return $this;
			}
			return static::none();
		}

		/**
		 * This method returns the first object in the collection that passes the truthy test, if any.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Option                                      an option containing the first object
		 *                                                          satisfying the predicate, if any
		 */
		public function find(callable $predicate) {
			if ($this->__isDefined() && $predicate($this->object(), Data\Int32::zero())->unbox()) {
				return $this;
			}
			return static::none();
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @return Data\Option\Iterator                             an iterator for this collection
		 */
		public function iterator() {
			return new Data\Option\Iterator($this);
		}

		/**
		 * This method returns whether this instance is a "some" option.
		 *
		 * @access public
		 * @final
		 * @return Data\Bool                                        whether this instance is a "some"
		 *                                                          option
		 */
		public final function isDefined() {
			return Data\Bool::create($this->__isDefined());
		}

		/**
		 * This method returns the length of this option.
		 *
		 * @access public
		 * @return Data\Int32                                       the length of this option
		 */
		public function length() {
			return ($this->__isDefined()) ? Data\Int32::one() : Data\Int32::zero();
		}

		/**
		 * This method applies each element in this option to the subroutine function.
		 *
		 * @access public
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return Data\Option                                      the option
		 */
		public function map(callable $subroutine) {
			return ($this->__isDefined()) ? static::some($subroutine($this->object())) : static::none();
		}

		/**
		 * This method returns the object stored within the option.
		 *
		 * @access public
		 * @abstract
		 * @return Core\Any                                         the stored object
		 */
		public abstract function object();

		/**
		 * This method returns this option if it has "some" object, otherwise, it returns the specified
		 * option.
		 *
		 * @access public
		 * @param Data\Option $option                               the alternative option
		 * @return Data\Option                                      the option
		 */
		public function orElse(Data\Option $option) {
			return ($this->__isDefined()) ? $this : $option;
		}

		/**
		 * This method returns this option's boxed object if is has "some" object; otherwise, it will
		 * return the specified object.
		 *
		 * @access public
		 * @param Core\Any $object                                  the alternative object
		 * @return Core\Any                                         the boxed object
		 */
		public function orSome(Core\Any $object) {
			return ($this->__isDefined()) ? $this->object() : $object;
		}

		/**
		 * This method returns the collection as an array.
		 *
		 * @access public
		 * @return Data\ArrayList                                   the collection as an array list
		 */
		public function toArray() {
			$array = array();

			if ($this->__isDefined()) {
				$array[] = $this->object();
			}

			return Data\ArrayList::create($array);
		}

		/**
		 * This method returns the option as a list.
		 *
		 * @access public
		 * @return Data\LinkedList                                  the option as a linked list
		 */
		public function toList() {
			return ($this->__isDefined()) ? Data\LinkedList::cons($this->object(), Data\LinkedList::nil()) : Data\LinkedList::nil();
		}

		#endregion

	}

}
