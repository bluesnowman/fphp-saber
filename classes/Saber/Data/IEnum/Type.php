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

namespace Saber\Data\IEnum {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IInt32;
	use \Saber\Data\IString;
	use \Saber\Throwable;

	abstract class Type extends Data\Type {

		/**
		 * This variable stores the name assigned to the enumeration.
		 *
		 * @access protected
		 * @var IString\Type                                         the name of the enumeration
		 */
		protected $name;

		/**
		 * This variable stores the ordinal value assigned to the enumeration.
		 *
		 * @access protected
		 * @var IInt32\Type                                          the ordinal value assigned to the enumeration
		 */
		protected $ordinal;

		#region Methods -> Native Oriented

		/**
		 * This constructor initializes the enumeration with the specified properties.
		 *
		 * @abstract
		 * @access protected
		 * @param IString\Type $name                                 the name associated with the item
		 * @param Core\Type $item                                   the item to be stored
		 */
		protected abstract function __construct(IString\Type $name, Core\Type $item);

		/**
		 * This destructor ensures that any resources are properly disposed.
		 *
		 * @access public
		 */
		public function __destruct() {
			parent::__destruct();
			unset($this->name);
			unset($this->ordinal);
		}

		/**
		 * This method returns the item stored to the enumeration.
		 *
		 * @access public
		 * @final
		 * @return mixed                                            the stored item's value
		 */
		public final function __item() {
			return $this->item()->unbox();
		}

		/**
		 * This method returns the name assigned to the enumeration.
		 *
		 * @access public
		 * @return string                                           the name assigned to the enumeration
		 */
		public function __name() {
			return $this->name->unbox();
		}

		/**
		 * This method returns the ordinal value assigned to the enumeration.
		 *
		 * @access public
		 * @return integer                                          the ordinal value assigned to the enumeration
		 */
		public function __ordinal() {
			return $this->ordinal->unbox();
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           a string representing the enumeration
		 */
		public final function __toString() {
			return $this->value->__toString();
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the item stored within the enumeration.
		 *
		 * @access public
		 * @final
		 * @return Core\Type                                        the stored item
		 */
		public final function item() {
			return $this->value;
		}

		/**
		 * This method returns the name assigned to the enumeration.
		 *
		 * @access public
		 * @final
		 * @return IString\Type                                      the name assigned to the enumeration
		 */
		public final function name() {
			return $this->name;
		}

		/**
		 * This method returns the ordinal value assigned to the enumeration.
		 *
		 * @access public
		 * @final
		 * @return IInt32\Type                                       the ordinal value assigned to the enumeration
		 */
		public final function ordinal() {
			return $this->ordinal;
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
