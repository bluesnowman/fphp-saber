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

namespace Saber\Data\HashSet {

	use \Saber\Data;
	use \Saber\Data\HashSet;
	use \Saber\Data\Set;

	final class Module extends Data\Module implements Set\Module {

		#region Methods -> Basic Operations

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $xs                                  the left operand
		 * @return HashSet\Iterator                                 an iterator for this collection
		 */
		public static function iterator(HashSet\Type $xs) {
			return new HashSet\Iterator($xs);
		}

		#endregion

	}

}