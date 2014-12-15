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

namespace Saber\Data\HashMap {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Bool;
	use \Saber\Data\HashMap;
	use \Saber\Data\Map;

	final class Iterator extends Data\Iterator implements Map\Iterator {

		/**
		 * This variable stores a reference to the array iterator.
		 *
		 * @access protected
		 * @var HashMap\Type
		 */
		protected $iterator;

		/**
		 * This variable stores a reference to the collection being iterated.
		 *
		 * @access protected
		 * @var HashMap\Type
		 */
		protected $xs;

		/**
		 * This constructor initializes this class with the specified collection.
		 *
		 * @access public
		 * @final
		 * @param HashMap\Type $xs                                  the collection to be iterated
		 */
		public final function __construct(HashMap\Type $xs) {
			$this->iterator = new \RecursiveIteratorIterator(new HashMap\RecursiveArrayOnlyIterator($xs->unbox()));
			$this->xs = $xs;
		}

		/**
		 * This method releases any internal references to an object.
		 *
		 * @access public
		 * @final
		 */
		public final function __destruct() {
			$this->iterator = null;
			$this->xs = null;
		}

		/**
		 * This method returns the size of the collection.
		 *
		 * @access public
		 * @final
		 * @return integer                                          the size of the collection
		 */
		public final function count() {
			return $this->xs->__size();
		}

		/**
		 * This method returns the current object.
		 *
		 * @access public
		 * @final
		 * @return mixed                                            the current object
		 */
		public final function current() {
			$entry = $this->iterator->current();
			return $entry->second();
		}

		/**
		 * This method returns the current key.
		 *
		 * @access public
		 * @final
		 * @return Core\Type                                        the current key
		 */
		public final function key() {
			$entry = $this->iterator->current();
			return $entry->first();
		}

		/**
		 * This method causes the iterator to advance to the next object.
		 *
		 * @access public
		 * @final
		 * @return Bool\Type                                        whether there are more objects
		 */
		public final function next() {
			$this->iterator->next();
			return Bool\Type::box($this->valid());
		}

		/**
		 * This method rewinds the iterator.
		 *
		 * @access public
		 * @final
		 */
		public final function rewind() {
			$this->iterator->rewind();
		}

		/**
		 * This method returns whether the iterator is still valid.
		 *
		 * @access public
		 * @final
		 * @return boolean                                          whether there are more objects
		 */
		public final function valid() {
			return $this->iterator->valid();
		}

	}

	class RecursiveArrayOnlyIterator extends \RecursiveArrayIterator {

		/**
		 * This method returns whether the current has children.
		 *
		 * @access public
		 * @return boolean                                          whether the current has children
		 */
		public function hasChildren() {
			return is_array($this->current());
		}

	}

}