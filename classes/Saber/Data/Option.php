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
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString() {
			return (string) serialize($this->object());
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
			return Data\Option::none();
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
			return Data\Option::none();
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

		#region Methods -> Equality

		/**
		 * This method evaluates whether the specified object is equal to the current object.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param Data\Type $ys                                     the object to be evaluated
		 * @return Data\Bool                                        whether the specified object is equal
		 *                                                          to the current object
		 */
		public static function eq(Data\Option $xs, Data\Type $ys) {
			$class = get_class($xs);
			if ($ys instanceof $class) {
				if ($ys instanceof Data\Option\Some) {
					$x = $xs->object();
					$y = $ys->object();
					if ($x === null) {
						return Data\Bool::create($y === null);
					}
					$module = get_class($x);
					$method = 'eq';
					if (method_exists($module, $method)) {
						return call_user_func_array(array($module, $method), array($x, $y));
					}
					return Data\Bool::create(spl_object_hash($x) === spl_object_hash($y));
				}
				else if ($ys instanceof Data\Option\None) {
					return Data\Bool::true();
				}
			}
			return Data\Bool::false();
		}

		/**
		 * This method evaluates whether the specified object is identical to the current object.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param Data\Type $ys                                     the object to be evaluated
		 * @return Data\Bool                                        whether the specified object is identical
		 *                                                          to the current object
		 */
		public static function id(Data\Option $xs, Data\Type $ys) {
			if (get_class($xs) === get_class($ys)) {
				if ($ys instanceof Data\Option\Some) {
					$x = $xs->object();
					$y = $ys->object();
					if ($x === null) {
						return Data\Bool::create($y === null);
					}
					$module = get_class($x);
					$method = 'id';
					if (method_exists($module, $method)) {
						return call_user_func_array(array($module, $method), array($x, $y));
					}
					return Data\Bool::create(spl_object_hash($x) === spl_object_hash($y));
				}
				else if ($ys instanceof Data\Option\None) {
					return Data\Bool::true();
				}
			}
			return Data\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param Data\Type $ys                                     the right operand
		 * @return Data\Bool                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Data\Option $xs, Data\Type $ys) { // !=
			return Data\Bool::not(Data\Option::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param Data\Type $ys                                     the right operand
		 * @return Data\Bool                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Data\Option $xs, Data\Type $ys) { // !==
			return Data\Bool::not(Data\Option::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param Data\Option $ys                                   the object to be compared
		 * @return Data\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(Data\Option $xs, Data\Option $ys) {
			$x = Data\Option::isDefined($xs)->unbox();
			$y = Data\Option::isDefined($ys)->unbox();

			if (!$x && $y) {
				return Data\Int32::negative();
			}
			if (!$x && !$y) {
				return Data\Int32::zero();
			}
			if ($x && !$y) {
				return Data\Int32::one();
			}

			$x = $xs->object();
			$y = $ys->object();

			if (($x === null) && ($y !== null)) {
				return Data\Int32::negative();
			}
			if (($x === null) && ($y === null)) {
				return Data\Int32::zero();
			}
			if (($x !== null) && ($y === null)) {
				return Data\Int32::one();
			}

			$module = get_class($x);
			$method = 'compare';
			if (method_exists($module, $method)) {
				return call_user_func_array(array($module, $method), array($x, $y));
			}
			return Data\String::compare(Data\String::create(spl_object_hash($x)), Data\String::create(spl_object_hash($y)));
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param Data\Option $ys                                   the right operand
		 * @return Data\Bool                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Data\Option $xs, Data\Option $ys) { // >=
			return Data\Bool::create(Data\Option::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param Data\Option $ys                                   the right operand
		 * @return Data\Bool                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Data\Option $xs, Data\Option $ys) { // >
			return Data\Bool::create(Data\Option::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param Data\Option $ys                                   the right operand
		 * @return Data\Bool                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Data\Option $xs, Data\Option $ys) { // <=
			return Data\Bool::create(Data\Option::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param Data\Option $ys                                   the right operand
		 * @return Data\Bool                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Data\Option $xs, Data\Option $ys) { // <
			return Data\Bool::create(Data\Option::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param Data\Option $ys                                   the right operand
		 * @return Data\Int32                                       the maximum value
		 */
		public static function max(Data\Option $xs, Data\Option $ys) {
			return (Data\Option::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Data\Option $xs                                   the left operand
		 * @param Data\Option $ys                                   the right operand
		 * @return Data\Int32                                       the minimum value
		 */
		public static function min(Data\Option $xs, Data\Option $ys) {
			return (Data\Option::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

	}

}
