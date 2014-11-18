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

	use \Saber\Data;
	use \Saber\Throwable;

	abstract class Option extends Data\Collection {

		#region Methods -> Implementation

		/**
		 * This method returns the object stored within the option.
		 *
		 * @access public
		 * @abstract
		 * @return Data\Type                                        the stored object
		 */
		public abstract function object();

		/**
		 * This method returns the boxed object as a string.
		 *
		 * @access public
		 * @return string                                           the boxed object as a string
		 */
		public function __toString() {
			return '' . $this->object();
		}

		#endregion

		#region Methods -> Instantiation

		/**
		 * This method returns a "none" option.
		 *
		 * @access public
		 * @static
		 * @return Data\Option\None                                 the "none" option
		 */
		public static function none() {
			return new Data\Option\None();
		}

		/**
		 * This method returns a "some" option.
		 *
		 * @access public
		 * @static
		 * @param Data\Type $x                                      the boxed object to be made an
		 *                                                          option
		 * @return Data\Option\Some                                 the "some" option
		 */
		public static function some(Data\Type $x) {
			return new Data\Option\Some($x);
		}

		#endregion

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the elements in the collection, yielding each
		 * element to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether each element passed the
		 *                                                          truthy test
		 */
		public static function all(Data\Option $xs, callable $predicate) {
			return Data\Bool::or_(Data\Bool::not(Data\Option::isDefined($xs)), $predicate($xs->object(), Data\Int32::zero()));
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the elements in the collection
		 * passed the truthy test.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether some of the elements
		 *                                                          passed the truthy test
		 */
		public static function any(Data\Option $xs, callable $predicate) {
			return Data\Option::isDefined(Data\Option::find($xs, $predicate));
		}

		/**
		 * This method binds the subroutine to the object within this option.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param callable $subroutine                              the subroutine function to be applied
		 * @return Data\Option                                      the option
		 */
		public static function bind(Data\Option $xs, callable $subroutine) {
			return (Data\Option::isDefined($xs)->unbox())
				? $subroutine($xs->object(), Data\Int32::zero())
				: Data\Option::none();
		}

		/**
		 * This method iterates over the elements in the option, yielding each element to the
		 * procedure function.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param callable $procedure                               the procedure function to be used
		 */
		public static function each(Data\Option $xs, callable $procedure) {
			if (Data\Option::isDefined($xs)->unbox()) {
				$procedure($xs->object(), Data\Int32::zero());
			}
		}

		/**
		 * This method returns a collection of those elements that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Option                                      the option
		 */
		public static function filter(Data\Option $xs, callable $predicate) {
			if (Data\Bool::and_(Data\Option::isDefined($xs), $predicate($xs->object(), Data\Int32::zero()))->unbox()) {
				return $xs;
			}
			return static::none();
		}

		/**
		 * This method returns the first object in the collection that passes the truthy test, if any.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Option                                      an option containing the first object
		 *                                                          satisfying the predicate, if any
		 */
		public static function find(Data\Option $xs, callable $predicate) {
			if (Data\Bool::and_(Data\Option::isDefined($xs), $predicate($xs->object(), Data\Int32::zero()))->unbox()) {
				return $xs;
			}
			return static::none();
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @return Data\Option\Iterator                             an iterator for this collection
		 */
		public static function iterator(Data\Option $xs) {
			return new Data\Option\Iterator($xs);
		}

		/**
		 * This method returns the length of this option.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @return Data\Int32                                       the length of this option
		 */
		public static function length(Data\Option $xs) {
			return (Data\Option::isDefined($xs)->unbox()) ? Data\Int32::one() : Data\Int32::zero();
		}

		/**
		 * This method applies each element in this option to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return Data\Option                                      the option
		 */
		public static function map(Data\Option $xs, callable $subroutine) {
			return (Data\Option::isDefined($xs)->unbox()) ? Data\Option::some($subroutine($xs->object())) : Data\Option::none();
		}

		/**
		 * This method returns this option if it has "some" object, otherwise, it returns the specified
		 * option.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param Data\Option $ys                                   the alternative option
		 * @return Data\Option                                      the option
		 */
		public static function orElse(Data\Option $xs, Data\Option $ys) {
			return (Data\Option::isDefined($xs)->unbox()) ? $xs : $ys;
		}

		/**
		 * This method returns this option's boxed object if is has "some" object; otherwise, it will
		 * return the specified object.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param Data\Type $y                                      the alternative object
		 * @return Data\Type                                        the boxed object
		 */
		public static function orSome(Data\Option $xs, Data\Type $y) {
			return (Data\Option::isDefined($xs)->unbox()) ? $xs->object() : $y;
		}

		/**
		 * This method returns the collection as an array.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the operand
		 * @return Data\ArrayList                                   the collection as an array list
		 */
		public static function toArray(Data\Option $xs) {
			$array = array();

			if (Data\Option::isDefined($xs)->unbox()) {
				$array[] = $xs->object();
			}

			return Data\ArrayList::create($array);
		}

		/**
		 * This method returns the option as a list.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the operand
		 * @return Data\LinkedList                                  the option as a linked list
		 */
		public static function toList(Data\Option $xs) {
			return (Data\Option::isDefined($xs)->unbox())
				? Data\LinkedList::cons($xs->object(), Data\LinkedList::nil())
				: Data\LinkedList::nil();
		}

		#endregion

		#region Methods -> Validation

		/**
		 * This method returns whether this instance is a "some" option.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the operand
		 * @return Data\Bool                                        whether this instance is a "some"
		 *                                                          option
		 */
		public static function isDefined(Data\Option $xs) {
			return Data\Bool::create($xs instanceof Data\Option\Some);
		}

		#endregion

	}

}
