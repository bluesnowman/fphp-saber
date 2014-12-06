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

namespace Saber\Data\Either {

	use \Saber\Data;
	use \Saber\Data\Either;

	final class Module extends Data\Module {

		#region Methods -> Basic Operations

		/**
		 * This method returns a tuple with the elements swapped.
		 *
		 * @access public
		 * @static
		 * @param Either\Type $xs                                   the left operand
		 * @return Either\Type                                      a tuple with the element swapped
		 */
		public static function swap(Either\Type $xs) {
			$x = $xs->unbox();
			return ($xs->__isLeft()) ? Either\Type::right($x) : Either\Type::left($x);
		}

		#endregion

	}

}