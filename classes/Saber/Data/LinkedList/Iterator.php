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

namespace Saber\Data\LinkedList {

	use \Saber\Data\Bool;
	use \Saber\Data\Int32;
	use \Saber\Data\LinkedList;

	final class Iterator implements \Countable, \Iterator {

		/**
		 * This variable stores a reference to the first node in the collection.
		 *
		 * @access protected
		 * @var LinkedList\Type
		 */
		protected $xs;

		/**
		 * This variable stores a reference to the current node in the collection.
		 *
		 * @access protected
		 * @var LinkedList\Type
		 */
		protected $ys;

		/**
		 * This variable stores the current position.
		 *
		 * @access protected
		 * @var Int32\Type
		 */
		protected $i;

		/**
		 * This constructor initializes this class with the specified collection.
		 *
		 * @access public
		 * @final
		 * @param LinkedList\Type $linkedList                       the collection to be iterated
		 */
		public final function __construct(LinkedList\Type $linkedList) {
			$this->xs = $linkedList;
			$this->ys = $linkedList;
			$this->i = Int32\Type::zero();
		}

		/**
		 * This method releases any internal references to an object.
		 *
		 * @access public
		 * @final
		 */
		public final function __destruct() {
			$this->xs = null;
			$this->ys = null;
			$this->i = null;
		}

		/**
		 * This method returns the length of the collection.
		 *
		 * @access public
		 * @final
		 * @return integer                                          the length of the collection
		 */
		public final function count() {
			return $this->xs->__length();
		}

		/**
		 * This method returns the current object.
		 *
		 * @access public
		 * @final
		 * @return LinkedList\Type                                  the current object
		 */
		public final function current() {
			$this->ys->head();
		}

		/**
		 * This method returns the current key.
		 *
		 * @access public
		 * @final
		 * @return Int32\Type                                       the current key
		 */
		public final function key() {
			return $this->i;
		}

		/**
		 * This method causes the iterator to advance to the next object.
		 *
		 * @access public
		 * @final
		 * @return Bool\Type                                        whether there are more objects
		 */
		public final function next() {
			$this->ys = $this->ys->tail();
			$this->i = Int32\Module::increment($this->i);
			return Bool\Type::box($this->valid());
		}

		/**
		 * This method rewinds the iterator.
		 *
		 * @access public
		 * @final
		 */
		public final function rewind() {
			$this->ys = $this->xs;
			$this->i = Int32\Type::zero();
		}

		/**
		 * This method returns whether the iterator is still valid.
		 *
		 * @access public
		 * @final
		 * @return boolean                                          whether there are more objects
		 */
		public final function valid() {
			return !$this->ys->__isEmpty();
		}

	}

}