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

namespace Saber\Data\Option\None {

	use \Saber\Core;
	use \Saber\Data\Option;
	use \Saber\Throwable;

	class Type extends Option\Type {

		#region Methods -> Object Oriented

		/**
		 * This method returns the object stored within the option.
		 *
		 * @access public
		 * @return Core\Type                                        the stored object
		 * @throws Throwable\UnimplementedMethod\Exception          indicates that this method cannot
		 *                                                          be called
		 */
		public function object() {
			throw new Throwable\UnimplementedMethod\Exception('Method :method has not been implemented.', array(':method' => __FUNCTION__));
		}

		#endregion

	}

}