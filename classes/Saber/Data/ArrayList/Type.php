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

namespace Saber\Data\ArrayList {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Collection;
	use \Saber\Throwable;

	class Type extends Collection\Type implements Core\Type\Boxable {

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param array $value                                      the value to be assigned
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public function __construct(array $value) {
			$this->value = $value;
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString() {
			return (string) serialize($this->unbox());
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @param integer $depth                                    how many levels to unbox
		 * @return array                                            the un-boxed value
		 */
		public function unbox($depth = 0) {
			if ($depth > 0) {
				$buffer = array();

				foreach ($this->value as $x) {
					$buffer[] = $x->unbox($depth - 1);
				}

				return $buffer;
			}
			return $this->value;
		}

	}

}