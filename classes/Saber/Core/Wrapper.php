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

namespace Saber\Core {

	use \Saber\Core;

	class Wrapper implements Core\AnyRef {

		#region Traits

		use Core\AnyRef\Impl;

		#endregion

		#region Methods -> Boxing/Creation

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param mixed $value                                      the value to be assigned
		 */
		public function __construct($value) {
			$this->value = $value;
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @param Core\Wrapper $that                                the object to be compared
		 * @return Core\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public function compareTo(Core\Wrapper $that) {
			return Core\Int32::zero();
		}

		#endregion

	}

}