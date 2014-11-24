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

namespace Saber\Data\String {

	use \Saber\Data;

	class Iterator implements \Countable, \Iterator {

		/**
		 * This variable stores a reference to the collection being iterated.
		 *
		 * @access protected
		 * @var String\Type
		 */
		protected $collection;

		/**
		 * This variable stores the current position.
		 *
		 * @access protected
		 * @var Int32\Type
		 */
		protected $position;

		/**
		 * This constructor initializes this class with the specified collection.
		 *
		 * @access public
		 * @param String\Type $string                               the collection to be iterated
		 */
		public function __construct(String\Type $string) {
			$this->collection = $string;
			$this->position = Int32\Type::zero();
		}

		/**
		 * This method releases any internal references to an object.
		 *
		 * @access public
		 */
		public function __destruct() {
			$this->collection = null;
			$this->position = null;
		}

		/**
		 * This method returns the length of the collection.
		 *
		 * @access public
		 * @return integer                                          the length of the collection
		 */
		public function count() {
			return $this->collection->__length();
		}

		/**
		 * This method returns the current object.
		 *
		 * @access public
		 * @return Char\Type                                        the current object
		 */
		public function current() {
			$this->collection->element($this->position);
		}

		/**
		 * This method returns the current key.
		 *
		 * @access public
		 * @return Int32\Type                                       the current key
		 */
		public function key() {
			return $this->position;
		}

		/**
		 * This method causes the iterator to advance to the next object.
		 *
		 * @access public
		 * @return Bool\Type                                        whether there are more objects
		 */
		public function next() {
			$this->position = $this->position->increment();
			return Bool\Module::create($this->valid());
		}

		/**
		 * This method rewinds the iterator.
		 *
		 * @access public
		 */
		public function rewind() {
			$this->position = Int32\Type::zero();
		}

		/**
		 * This method returns whether the iterator is still valid.
		 *
		 * @access public
		 * @return boolean                                          whether there are more objects
		 */
		public function valid() {
			return ($this->position->unbox() < $this->collection->__length());
		}

	}

}