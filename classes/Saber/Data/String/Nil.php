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

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Throwable;

	class Nil extends Data\String {

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @param Data\String $that                                 the object to be compared
		 * @return Data\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public function compareTo(Data\String $that) {
			if ($that instanceof Data\String\Nil) {
				return Data\Int32::zero();
			}
			return Data\Int32::negative();
		}

		/**
		 * This method evaluates whether the specified object is equal to the current object.
		 *
		 * @access public
		 * @param Core\Any $that                                    the object to be evaluated
		 * @return Data\Bool                                        whether the specified object is equal
		 *                                                          to the current object
		 */
		public function equals(Core\Any $that) {
			return Data\Bool::create(($that !== null) && ($that instanceof static));
		}

		/**
		 * This method returns the head object in this string.
		 *
		 * @access public
		 * @throws Throwable\EmptyCollection\Exception              indicates that the collection is empty
		 */
		public function head() {
			throw new Throwable\EmptyCollection\Exception('Unable to return head object. String is empty.');
		}

		/**
		 * This method evaluates whether the specified object is identical to the current object.
		 *
		 * @access public
		 * @param Core\Any $that                                    the object to be evaluated
		 * @return Data\Bool                                        whether the specified object is identical
		 *                                                          to the current object
		 */
		public function identical(Core\Any $that) {
			return Data\Bool::create(($that !== null) && ($that instanceof static));
		}

		/**
		 * This method returns the tail of this string.
		 *
		 * @access public
		 * @throws Throwable\EmptyCollection\Exception              indicates that the collection is empty
		 */
		public function tail() {
			throw new Throwable\EmptyCollection\Exception('Unable to return tail. String is empty.');
		}

		#endregion

	}

}