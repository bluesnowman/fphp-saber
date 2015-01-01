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

namespace Saber\Control {

	use \Saber\Control;
	use \Saber\Core;
	use \Saber\Data\String;

	abstract class Type implements Core\Type {

		#region Methods -> Initialization

		/**
		 * This method returns a choice monad for evaluating an object.
		 *
		 * @access public
		 * @static
		 * @param Core\Equality\Type $x                             the object to be evaluated
		 * @return Control\Choice\Type                              the choice monad
		 */
		public static function choice(Core\Equality\Type $x) {
			return Control\Choice\Type::cons($x, Control\Choice\Type::nil());
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object's hash code
		 */
		public final function __hashCode() {
			return spl_object_hash($this);
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object as a string
		 */
		public final function __toString() {
			return $this->__hashCode();
		}

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object's class type
		 */
		public final function __typeOf() {
			return get_class($this);
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @final
		 * @return String\Type                                      the object's hash code
		 */
		public final function hashCode() {
			return String\Type::box($this->__hashCode());
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return String\Type                                      the object as a string
		 */
		public final function toString() {
			return String\Type::box($this->__toString());
		}

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @final
		 * @return String\Type                                      the object's class type
		 */
		public final function typeOf() {
			return String\Type::box($this->__typeOf());
		}

		#endregion

	}

}