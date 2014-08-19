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

namespace Saber\Core\LinkedList {

	use \Saber\Core;

	class Cons extends Core\LinkedList {

		#region Properties

		/**
		 * This variable stores the tail of this linked list.
		 *
		 * @access protected
		 * @var Core\LinkedList
		 */
		protected $tail;

		#endregion

		#region Methods -> Boxing/Creation

		/**
		 * This constructor initializes the class with the specified values.
		 *
		 * @access public
		 * @param Core\Any $head                                    the object to be assigned
		 *                                                          to the head
		 * @param Core\LinkedList $tail                             the tail to be linked
		 */
		public function __construct(Core\Any $head, Core\LinkedList $tail) {
			$this->value = $head;
			$this->tail = $tail;
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @param Core\LinkedList $that                             the object to be compared
		 * @return Core\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public function compareTo(Core\LinkedList $that) {
			$xs = $this;
			$ys = $that;

			for (; ! $xs->__isEmpty() && ! $ys->__isEmpty(); $xs = $xs->tail(), $ys = $ys->tail()) {
				$r = $xs->head()->compareTo($ys->head());
				if ($r->unbox() != 0) {
					return $r;
				}
			}

			$x_length = $xs->length();
			$y_length = $ys->length();

			if ($x_length < $y_length) {
				return Core\Int32::negative();
			}
			else if ($x_length == $y_length) {
				return Core\Int32::zero();
			}
			else { // ($x_length > $y_length)
				return Core\Int32::one();
			}
		}

		/**
		 * This method evaluates whether the specified object is equal to the current object.
		 *
		 * @access public
		 * @param Core\Any $that                                    the object to be evaluated
		 * @return Core\Bool                                        whether the specified object is equal
		 *                                                          to the current object
		 */
		public function equals(Core\Any $that) {
			if (($that === null) || ($this->__typeOf() != $that->__typeOf())) {
				return Core\Bool::false();
			}
			return Core\Bool::box($this->head()->__equals($that->head()) && $this->tail()->__equals($that->tail()));
		}

		/**
		 * This method returns the head object in this linked list.
		 *
		 * @access public
		 * @return Core\Any                                         the head object in this linked
		 *                                                          list
		 */
		public function head() {
			return $this->value;
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
			if (($that === null) || ($this->__typeOf() != $that->__typeOf())) {
				return Core\Bool::false();
			}
			return Core\Bool::box($this->head()->__identical($that->head()) && $this->tail()->__identical($that->tail()));
		}

		/**
		 * This method returns the tail of this linked list.
		 *
		 * @access public
		 * @return Core\LinkedList                                  the tail of this linked list
		 */
		public function tail() {
			return $this->tail;
		}

		#endregion

	}

}