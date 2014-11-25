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
	use \Saber\Throwable;

	class Type extends Data\Type implements Core\Type\Boxable {

		#region Methods -> Implementation

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param mixed $value                                      the value to be assigned
		 */
		public function __construct($value) {
			$this->value = $value;
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString() {
			$type = gettype($this->value);
			switch ($type) {
				case 'boolean':
					return ($this->value) ? 'true' : 'false';
				case 'double':
					return sprintf('%F', $this->value);
				case 'integer':
					return sprintf('%d', $this->value);
				case 'object':
					return $this->value->__toString();
				case 'string':
					return $this->value;
				default:
					throw new Throwable\Parse\Exception('Invalid cast. Could not convert value of ":type" to a string.', array(':type' => $type));
			}
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @param integer $depth                                    how many levels to unbox
		 * @return mixed                                            the un-boxed value
		 */
		public function unbox($depth = 0) {
			return $this->value;
		}

		#endregion

	}

}