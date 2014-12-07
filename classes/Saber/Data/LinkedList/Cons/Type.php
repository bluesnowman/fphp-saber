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

namespace Saber\Data\LinkedList\Cons {

	use \Saber\Core;
	use \Saber\Data\Bool;
	use \Saber\Data\Int32;
	use \Saber\Data\LinkedList;
	use \Saber\Throwable;

	final class Type extends LinkedList\Type {

		#region Properties

		/**
		 * This variable stores the tail of this linked list.
		 *
		 * @access protected
		 * @var LinkedList\Type
		 */
		protected $tail;

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This constructor initializes the class with the specified values.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $head                                   the object to be assigned
		 *                                                          to the head
		 * @param LinkedList\Type $tail                             the tail to be linked
		 */
		public final function __construct(Core\Type $head, LinkedList\Type $tail) {
			$this->value = $head;
			$this->tail = $tail;
		}

		/**
		 * This method releases any internal references to an object.
		 *
		 * @access public
		 * @final
		 */
		public final function __destruct() {
			$this->value = null;
			$this->tail = null;
		}

		/**
		 * This method sets the value for the specified key.
		 *
		 * @access public
		 * @final
		 * @param string $name                                      the name of the property
		 * @param mixed $value                                      the value of the property
		 * @throws Throwable\InvalidProperty\Exception              indicates that the specified property
		 *                                                          is either inaccessible or undefined
		 */
		public final function __set($name, $value) {
			if (!in_array($name, array('tail'))) {
				throw new Throwable\InvalidProperty\Exception('Unable to set the specified property. Property ":name" is either inaccessible or undefined.', array(':name' => $name));
			}
			$this->$name = $value;
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the head object in this linked list.
		 *
		 * @access public
		 * @final
		 * @return Core\Type                                        the head object in this linked
		 *                                                          list
		 */
		public final function head() {
			return $this->value;
		}

		/**
		 * This method returns the tail of this linked list.
		 *
		 * @access public
		 * @final
		 * @return LinkedList\Type                                  the tail of this linked list
		 */
		public final function tail() {
			return $this->tail;
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param integer $depth                                    how many levels to unbox
		 * @return array                                            the un-boxed value
		 */
		public final function unbox($depth = 0) {
			$buffer = array();
			for ($zs = $this; ! $zs->__isEmpty(); $zs = $zs->tail()) {
				$z = $zs->head();
				$buffer[] = (($depth > 0) && ($z instanceof Core\Boxable\Type))
					? $z->unbox($depth - 1)
					: $z;
			}
			return $buffer;
		}

		#endregion

	}

}