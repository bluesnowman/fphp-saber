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

namespace Saber\Core\AnyVal {

	use \Saber\Core;
	use \Saber\Throwable;

	trait Impl {

		#region Traits

		use Core\Any\Impl;

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @return string                                           the object's hash code
		 */
		public function __hashCode() {
			return $this->__toString();
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString() {
			return '' . $this->unbox();
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method evaluates whether the specified object is equal to the current object.
		 *
		 * @access public
		 * @param Core\Any $that                                    the object to be evaluated
		 * @return Core\Bool                                        whether the specified object is equal
		 *                                                          to the current object
		 */
		public function equals(Core\Any $that) {
			if ($that !== null) {
				return Core\Bool::box(($that instanceof static) && ($this->unbox() == $that->unbox()));
			}
			return Core\Bool::false();
		}

		/**
		 * This method evaluates whether the specified object is identical to the current object.
		 *
		 * @access public
		 * @param Core\Any $that                                    the object to be evaluated
		 * @return Core\Bool                                        whether the specified object is identical
		 *                                                          to the current object
		 */
		public function identical(Core\Any $that) {
			if ($that !== null) {
				return Core\Bool::box(($that instanceof static) && ($this->unbox() === $that->unbox()));
			}
			return Core\Bool::false();
		}

		#endregion

	}

}