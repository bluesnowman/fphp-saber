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

namespace Saber\Data\Tuple {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Throwable;

	class Module {

		#region Properties

		/**
		 * This variable stores the number of objects in the tuple.
		 *
		 * @access protected
		 * @var mixed
		 */
		protected $count;

		#endregion

		#region Methods -> Boxing/Creation

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Core\Any                                         the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function box($value/*...*/) {
			$value = func_get_args();
			if (($value === null) || !is_array($value)) {
				$type = gettype($value);
				if ($type == 'object') {
					$type = get_class($value);
				}
				throw new Throwable\InvalidArgument\Exception('Unable to box value(s). Expected an array, but got ":type".', array(':type' => $type));
			}
			$count = func_num_args();
			if ($count < 2) {
				throw new Throwable\InvalidArgument\Exception('Unable to box value(s). Tuple must have at least 2 objects, but got ":count".', array(':count' => $count));
			}
			foreach ($value as $object) {
				if (!(is_object($object) && ($object instanceof Core\Any))) {
					$type = gettype($value);
					if ($type == 'object') {
						$type = get_class($value);
					}
					throw new Throwable\InvalidArgument\Exception('Unable to box value(s). Expected a boxed object, but got ":type".', array(':type' => $type));
				}
			}
			return new static($value);
		}

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param array $value                                      the value to be assigned
		 */
		public function __construct(array $value) {
			$this->value = $value;
			$this->count = count($value);
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @param integer $depth                                    how many levels to unbox
		 * @return array                                            the un-boxed value
		 */
		public function unbox($depth = 0) {
			$buffer = array();

			for ($i = 0; $i < $this->count; $i++) {
				$value = $this->value[$i];
				$buffer[] = ($depth > 0)
					? $value->unbox($depth - 1)
					: $value;
			}

			return $buffer;
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @param Data\Tuple $that                                  the object to be compared
		 * @return Data\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public function compareTo(Data\Tuple $that) {
			$x_length = $this->length();
			$y_length = $this->length();

			for ($i = 0; $i < $x_length && $i < $y_length; $i++) {
				$r = $this->value[$i]->compareTo($that->value[$i]);
				if ($r->unbox() != 0) {
					return $r;
				}
			}

			if ($x_length < $y_length) {
				return Data\Int32::negative();
			}
			else if ($x_length == $y_length) {
				return Data\Int32::zero();
			}
			else { // ($x_length > $y_length)
				return Data\Int32::one();
			}
		}

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @param Data\Int32 $index                                 the index of the element
		 * @return Core\Any                                         the element at the specified index
		 * @throws Throwable\OutOfBounds\Exception                  indicates the specified index
		 *                                                          cannot be found
		 */
		public function element(Data\Int32 $index) {
			$i = $index->unbox();

			if (($i < 0) || ($i >= $this->count)) {
				throw new Throwable\OutOfBounds\Exception('Unable to return element at index :index.', array(':index' => $i));
			}

			return $this->value[$i];
		}

		/**
		 * This method returns the first element in the tuple.
		 *
		 * @access public
		 * @return Core\Any                                         the first element in the tuple
		 */
		public function first() {
			$this->assert(function($other) {
				return Data\Bool::create($other == $this->length());
			}, 2);

			return $this->value[0];
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @return Data\Int32                                       the length of this array list
		 */
		public function length() {
			return $this->count;
		}

		/**
		 * This method returns the second element in the tuple.
		 *
		 * @access public
		 * @return Core\Any                                         the second element in the tuple
		 */
		public function second() {
			$this->assert(function($other) {
				return Data\Bool::create($other == $this->length());
			}, 2);

			return $this->value[1];
		}

		/**
		 * This method returns a tuple with the elements swapped.
		 *
		 * @access public
		 * @return Core\Any                                         a tuple with the element swapped
		 */
		public function swap() {
			$this->assert(function($other) {
				return Data\Bool::create($other == $this->length());
			}, 2);

			return Data\Tuple::create($this->value[1], $this->value[0]);
		}

		#endregion

	}

}