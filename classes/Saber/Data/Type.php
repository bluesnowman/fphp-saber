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

namespace Saber\Data {

	use \Saber\Core;
	use \Saber\Throwable;

	abstract class Type implements Core\Type, Core\Boxable\Type, Core\Comparable\Type, Core\Equality\Type, \JsonSerializable {

		#region Properties

		/**
		 * This variable stores the value for the boxed object.
		 *
		 * @access protected
		 * @var mixed
		 */
		protected $value;

		#endregion

		#region Methods -> Implementation

		/**
		 * This method releases any internal references to an object.
		 *
		 * @access public
		 */
		public function __destruct() {
			unset($this->value);
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @return string                                           the object's hash code
		 */
		public function __hashCode() {
			return spl_object_hash($this);
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @abstract
		 * @return string                                           the object as a string
		 */
		public abstract function __toString();

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
		 * @return IString\Type                                      the object's hash code
		 */
		public final function hashCode() {
			return IString\Type::box($this->__hashCode());
		}

		/**
		 * This method returns data which can be serialized by json_encode(), which is
		 * a value of any type other than a resource.
		 *
		 * @access public
		 * @return mixed
		 */
		public function jsonSerialize() {
			return $this->unbox(PHP_INT_MAX);
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return IString\Type                                      the object as a string
		 */
		public final function toString() {
			return IString\Type::box($this->__toString());
		}

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @final
		 * @return IString\Type                                      the object's class type
		 */
		public final function typeOf() {
			return IString\Type::box($this->__typeOf());
		}

		#endregion

	}

}