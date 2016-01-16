<?php

/**
 * Copyright 2014-2015 Blue Snowman
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

namespace Saber\Data\IOption\Some {

	use \Saber\Core;
	use \Saber\Data\IOption;

	final class Type extends IOption\Type {

		#region Methods -> Native Oriented

		/**
		 * This constructor initializes the class with the specified item.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $x                                      the item to be stored
		 */
		public final function __construct(Core\Type $x) {
			$this->value = $x;
		}

		#region Methods -> Object Oriented

		/**
		 * This method returns the item stored within the option.
		 *
		 * @access public
		 * @final
		 * @return Core\Type                                        the stored item
		 */
		public final function item() {
			return $this->value;
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param integer $depth                                    how many levels to unbox
		 * @return mixed                                            the un-boxed value
		 */
		public final function unbox($depth = 0) {
			if ($depth > 0) {
				if ($this->value instanceof Core\Boxable\Type) {
					$this->value->unbox($depth - 1);
				}
			}
			return $this->value;
		}

		#endregion

	}

}