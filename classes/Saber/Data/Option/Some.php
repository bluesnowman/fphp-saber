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

namespace Saber\Data\Option {

	use \Saber\Data;

	class Some extends Data\Option {

		#region Properties

		/**
		 * This variable stores the boxed object for this option.
		 *
		 * @access protected
		 * @var Data\Type
		 */
		protected $object;

		#endregion

		#region Methods -> Implementation

		/**
		 * This constructor initializes the class with the specified object.
		 *
		 * @access public
		 * @param Data\Type $object                                 the boxed object to be made an
		 *                                                          option
		 */
		public function __construct(Data\Type $object) {
			$this->object = $object;
		}

		/**
		 * This method returns the object stored within the option.
		 *
		 * @access public
		 * @return Data\Type                                        the stored object
		 */
		public function object() {
			return $this->object;
		}

		#endregion

	}

}