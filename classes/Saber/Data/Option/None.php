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

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Throwable;

	class None extends Data\Option {

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method returns the object stored within the option.
		 *
		 * @access public
		 * @abstract
		 * @return Core\Any                                         the stored object
		 * @throws Throwable\UnimplementedMethod\Exception          indicates that this method cannot
		 *                                                          be called
		 */
		public function object() {
			throw new Throwable\UnimplementedMethod\Exception('Method :method has not been implemented.', array(':method' => __FUNCTION__));
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
			if (($that !== null) && ($that instanceof static)) {
				return Data\Bool::true();
			}
			return Data\Bool::false();
		}

		#endregion

	}

}