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

namespace Saber\Data\IArrayList {

	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IInt32;
	use \Saber\Data\IVector;

	final class Iterator extends Data\Iterator implements IVector\Iterator {

		/**
		 * This variable stores a reference to the collection being iterated.
		 *
		 * @access protected
		 * @var IArrayList\Type
		 */
		protected $xs;

		/**
		 * This variable stores the current position.
		 *
		 * @access protected
		 * @var IInt32\Type
		 */
		protected $i;

		/**
		 * This constructor initializes this class with the specified collection.
		 *
		 * @access public
		 * @final
		 * @param IArrayList\Type $xs                               the collection to be iterated
		 */
		public final function __construct(IArrayList\Type $xs) {
			$this->xs = $xs;
			$this->i = IInt32\Type::zero();
		}

		/**
		 * This method releases any internal references to an object.
		 *
		 * @access public
		 * @final
		 */
		public final function __destruct() {
			$this->xs = null;
			$this->i = null;
		}

		/**
		 * This method returns the length of the collection.
		 *
		 * @access public
		 * @final
		 * @return int                                              the length of the collection
		 */
		public final function count() : int {
			return $this->xs->__length();
		}

		/**
		 * This method returns the current object.
		 *
		 * @access public
		 * @final
		 * @return mixed                                            the current object
		 */
		public final function current() {
			return $this->xs->item($this->i);
		}

		/**
		 * This method returns the current key.
		 *
		 * @access public
		 * @final
		 * @return IInt32\Type                                      the current key
		 */
		public final function key() : IInt32\Type {
			return $this->i;
		}

		/**
		 * This method causes the iterator to advance to the next object.
		 *
		 * @access public
		 * @final
		 * @return IBool\Type                                       whether there are more objects
		 */
		public final function next() : IBool\Type {
			$this->i = IInt32\Module::increment($this->i);
			return IBool\Type::box($this->valid());
		}

		/**
		 * This method rewinds the iterator.
		 *
		 * @access public
		 * @final
		 */
		public final function rewind() {
			$this->i = IInt32\Type::zero();
		}

		/**
		 * This method returns whether the iterator is still valid.
		 *
		 * @access public
		 * @final
		 * @return bool                                             whether there are more objects
		 */
		public final function valid() : bool {
			return ($this->i->unbox() < $this->xs->__length());
		}

	}

}