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

namespace Saber\Data\Object {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Int32;
	use \Saber\Data\Object;

	class Module {

		#region Methods -> Ordering

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Object\Type $x                                    the left operand
		 * @param Object\Type $y                                    the right operand
		 * @return Int32\Type                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(Object\Type $x, Object\Type $y) {
			return Int32\Module::zero();
		}

		#endregion

	}

}