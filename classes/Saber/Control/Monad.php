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

namespace Saber\Control {

	use \Saber\Control;
	use \Saber\Data;

	class Monad {

		/**
		 * This method returns a choice monad for evaluating an object.
		 *
		 * @access public
		 * @static
		 * @param Data\Type $x                                      the object to be evaluated
		 * @return Control\Monad\Choice                             the choice monad
		 */
		public static function choice(Data\Type $x) {
			return Control\Monad\Choice::cons($x, Control\Monad\Choice::nil());
		}

	}

}