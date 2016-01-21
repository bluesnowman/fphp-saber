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

namespace Saber\Core {

	use \Saber\Data\IString;

	interface Type {

		#region Methods -> Native Oriented

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @return string                                           the object's hash code
		 */
		public function __hashCode() : string;

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString();

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @return string                                           the object's class type
		 */
		public function __typeOf() : string;

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @return IString\Type                                     the object's hash code
		 */
		public function hashCode() : IString\Type;

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return IString\Type                                     the object as a string
		 */
		public function toString() : IString\Type;

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @return IString\Type                                     the object's class type
		 */
		public function typeOf() : IString\Type;

		#endregion

	}

}