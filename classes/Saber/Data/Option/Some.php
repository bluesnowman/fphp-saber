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

	class Some extends Data\Option {

		#region Properties

		/**
		 * This variable stores the boxed object for this option.
		 *
		 * @access protected
		 * @var Core\Any
		 */
		protected $object;

		#endregion

		#region Methods -> Boxing/Creation

		/**
		 * This constructor initializes the class with the specified object.
		 *
		 * @access public
		 * @param Core\Any $object                                  the boxed object to be made an
		 *                                                          option
		 */
		public function __construct(Core\Any $object) {
			$this->object = $object;
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method returns the object stored within the option.
		 *
		 * @access public
		 * @return Core\Any                                         the stored object
		 */
		public function object() {
			return $this->object;
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
				$x = $this->object();
				$y = $this->object();
				if ($x === null) {
					return Data\Bool::create($y === null);
				}
				return $x->equals($y);
			}
			return Data\Bool::false();
		}

		#endregion

	}

}