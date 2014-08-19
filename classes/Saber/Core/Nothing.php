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
	use \Saber\Throwable;

	class Nothing implements Core\AnyVal {

		#region Traits

		use Core\AnyVal\Impl;

		#endregion

		#region Methods -> Boxing/Creation

		/**
		 * This constructor initializes the class.
		 *
		 * @access public
		 */
		public function __construct() {
			$this->value = null;
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString() {
			return 'nothing';
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @param Core\Nothing $that                                the object to be compared
		 * @return Core\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public function compareTo(Core\Nothing $that) {
			return Core\Int32::zero();
		}

		#endregion

	}

}