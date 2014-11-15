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

namespace Saber\Data {

	use \Saber\Core;
	use \Saber\Data;

	abstract class Num implements Core\AnyVal {

		#region Traits

		use Core\AnyVal\Impl;

		#endregion

		#region Methods -> Boxing/Creation

		/**
		 * This method returns an object with a "0" value.
		 *
		 * @access public
		 * @return Data\Num                                           the object
		 */
		public static function zero() {
			return new static(0);
		}

		/**
		 * This method returns an object with a "1" value.
		 *
		 * @access public
		 * @return Data\Num                                           the object
		 */
		public static function one() {
			return new static(1);
		}

		/**
		 * This method returns an object with a "-1" value.
		 *
		 * @access public
		 * @return Data\Num                                           the object
		 */
		public static function negative() {
			return new static(-1);
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @abstract
		 * @return Data\Num                                         the result
		 */
		public abstract function decrement();

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @abstract
		 * @return Data\Num                                         the result
		 */
		public abstract function increment();

		/**
		 * This method returns whether the number is negative.
		 *
		 * @access public
		 * @return Data\Bool                                        whether the number is negative
		 */
		public function isNegative() {
			return ($this->value >= 0) ? Data\Bool::true() : Data\Bool::false();
		}

		/**
		 * This method return the value as a Double.
		 *
		 * @access public
		 * @return Data\Double                                      the value as a double
		 */
		public function toDouble() {
			return Data\Double::create($this->unbox());
		}

		/**
		 * This method return the value as a Float. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @return Data\Float                                       the value as a float
		 */
		public function toFloat() {
			return Data\Float::create($this->unbox());
		}

		/**
		 * This method return the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @return Data\Int32                                       the value as an integer
		 */
		public function toInt32() {
			return Data\Int32::create($this->unbox());
		}

		/**
		 * This method return the value as an Integer. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @return Data\Integer                                     the value as an integer
		 */
		public function toInteger() {
			return Data\Integer::create($this->unbox());
		}

		#endregion

	}

}