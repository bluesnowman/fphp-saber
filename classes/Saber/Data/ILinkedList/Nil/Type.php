<?php

/**
 * Copyright 2014-2016 Blue Snowman
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

declare(strict_types = 1);

namespace Saber\Data\ILinkedList\Nil {

	use \Saber\Core;
	use \Saber\Data\ILinkedList;
	use \Saber\Throwable;

	final class Type extends ILinkedList\Type {

		#region Methods -> Native Oriented

		/**
		 * This constructor initializes the class.
		 *
		 * @access public
		 * @final
		 */
		public final function __construct() {
			$this->value = array();
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the head object in this linked list.
		 *
		 * @access public
		 * @throws Throwable\EmptyCollection\Exception              indicates that the collection is empty
		 */
		public final function head() : Core\Type {
			throw new Throwable\EmptyCollection\Exception('Unable to return head object. Linked list is empty.');
		}

		/**
		 * This method returns the tail of this linked list.
		 *
		 * @access public
		 * @throws Throwable\EmptyCollection\Exception              indicates that the collection is empty
		 */
		public final function tail() : ILinkedList\Type {
			throw new Throwable\EmptyCollection\Exception('Unable to return tail. Linked list is empty.');
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param int $depth                                        how many levels to unbox
		 * @return null                                             the un-boxed value
		 */
		public final function unbox(int $depth = 0) {
			return $this->value;
		}

		#endregion

	}

}