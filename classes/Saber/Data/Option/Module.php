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

namespace Saber\Data\Option {

	use \Saber\Data;
	use \Saber\Throwable;

	abstract class Module extends Collection\Module {

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
		 * @return Option\Type\None                                 the "none" option
		 */
		public static function none() {
			return new Option\Type\None();
		}

		/**
		 * This method returns a "some" option.
		 *
		 * @access public
		 * @static
		 * @param Data\Type $x                                      the boxed object to be made an
		 *                                                          option
		 * @return Option\Type\Some                                 the "some" option
		 */
		public static function some(Data\Type $x) {
			return new Option\Type\Some($x);
		}

		#endregion

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the elements in the collection, yielding each
		 * element to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether each element passed the
		 *                                                          truthy test
		 */
		public static function all(Option\Type $xs, callable $predicate) {
			return Bool\Module::or_(Bool\Module::not(Option\Type::isDefined($xs)), $predicate($xs->object(), Int32\Type::zero()));
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the elements in the collection
		 * passed the truthy test.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether some of the elements
		 *                                                          passed the truthy test
		 */
		public static function any(Option\Type $xs, callable $predicate) {
			return Option\Type::isDefined(Option\Type::find($xs, $predicate));
		}

		/**
		 * This method binds the subroutine to the object within this option.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param callable $subroutine                              the subroutine function to be applied
		 * @return Option\Type                                      the option
		 */
		public static function bind(Option\Type $xs, callable $subroutine) {
			return (Option\Type::isDefined($xs)->unbox())
				? $subroutine($xs->object(), Int32\Type::zero())
				: Option\Type::none();
		}

		/**
		 * This method iterates over the elements in the option, yielding each element to the
		 * procedure function.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param callable $procedure                               the procedure function to be used
		 */
		public static function each(Option\Type $xs, callable $procedure) {
			if (Option\Type::isDefined($xs)->unbox()) {
				$procedure($xs->object(), Int32\Type::zero());
			}
		}

		/**
		 * This method returns a collection of those elements that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Option\Type                                      the option
		 */
		public static function filter(Option\Type $xs, callable $predicate) {
			if (Bool\Module::and_(Option\Type::isDefined($xs), $predicate($xs->object(), Int32\Type::zero()))->unbox()) {
				return $xs;
			}
			return Option\Type::none();
		}

		/**
		 * This method returns the first object in the collection that passes the truthy test, if any.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Option\Type                                      an option containing the first object
		 *                                                          satisfying the predicate, if any
		 */
		public static function find(Option\Type $xs, callable $predicate) {
			if (Bool\Module::and_(Option\Type::isDefined($xs), $predicate($xs->object(), Int32\Type::zero()))->unbox()) {
				return $xs;
			}
			return Option\Type::none();
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @return Option\Type\Iterator                             an iterator for this collection
		 */
		public static function iterator(Option\Type $xs) {
			return new Option\Type\Iterator($xs);
		}

		/**
		 * This method returns the length of this option.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @return Int32\Type                                       the length of this option
		 */
		public static function length(Option\Type $xs) {
			return (Option\Type::isDefined($xs)->unbox()) ? Int32\Type::one() : Int32\Type::zero();
		}

		/**
		 * This method applies each element in this option to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return Option\Type                                      the option
		 */
		public static function map(Option\Type $xs, callable $subroutine) {
			return (Option\Type::isDefined($xs)->unbox()) ? Option\Type::some($subroutine($xs->object())) : Option\Type::none();
		}

		/**
		 * This method returns this option if it has "some" object, otherwise, it returns the specified
		 * option.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the alternative option
		 * @return Option\Type                                      the option
		 */
		public static function orElse(Option\Type $xs, Option\Type $ys) {
			return (Option\Type::isDefined($xs)->unbox()) ? $xs : $ys;
		}

		/**
		 * This method returns this option's boxed object if is has "some" object; otherwise, it will
		 * return the specified object.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Data\Type $y                                      the alternative object
		 * @return Data\Type                                        the boxed object
		 */
		public static function orSome(Option\Type $xs, Data\Type $y) {
			return (Option\Type::isDefined($xs)->unbox()) ? $xs->object() : $y;
		}

		/**
		 * This method returns the collection as an array.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the operand
		 * @return ArrayList\Type                                   the collection as an array list
		 */
		public static function toArray(Option\Type $xs) {
			$array = array();

			if (Option\Type::isDefined($xs)->unbox()) {
				$array[] = $xs->object();
			}

			return ArrayList\Module::create($array);
		}

		/**
		 * This method returns the option as a list.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the operand
		 * @return LinkedList\Type                                  the option as a linked list
		 */
		public static function toList(Option\Type $xs) {
			return (Option\Type::isDefined($xs)->unbox())
				? LinkedList\Module::cons($xs->object(), LinkedList\Module::nil())
				: LinkedList\Module::nil();
		}

		#endregion

		#region Methods -> Validation

		/**
		 * This method returns whether this instance is a "some" option.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the operand
		 * @return Bool\Type                                        whether this instance is a "some"
		 *                                                          option
		 */
		public static function isDefined(Option\Type $xs) {
			return Bool\Module::create($xs instanceof Option\Type\Some);
		}

		#endregion

		#region Methods -> Equality

		/**
		 * This method evaluates whether the specified object is equal to the current object.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Data\Type $ys                                     the object to be evaluated
		 * @return Bool\Type                                        whether the specified object is equal
		 *                                                          to the current object
		 */
		public static function eq(Option\Type $xs, Data\Type $ys) {
			$class = get_class($xs);
			if ($ys instanceof $class) {
				if ($ys instanceof Option\Type\Some) {
					$x = $xs->object();
					$y = $ys->object();
					if ($x === null) {
						return Bool\Module::create($y === null);
					}
					$module = get_class($x);
					$method = 'eq';
					if (method_exists($module, $method)) {
						return call_user_func_array(array($module, $method), array($x, $y));
					}
					return Bool\Module::create(spl_object_hash($x) === spl_object_hash($y));
				}
				else if ($ys instanceof Option\Type\None) {
					return Bool\Module::true();
				}
			}
			return Bool\Module::false();
		}

		/**
		 * This method evaluates whether the specified object is identical to the current object.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Data\Type $ys                                     the object to be evaluated
		 * @return Bool\Type                                        whether the specified object is identical
		 *                                                          to the current object
		 */
		public static function id(Option\Type $xs, Data\Type $ys) {
			if (get_class($xs) === get_class($ys)) {
				if ($ys instanceof Option\Type\Some) {
					$x = $xs->object();
					$y = $ys->object();
					if ($x === null) {
						return Bool\Module::create($y === null);
					}
					$module = get_class($x);
					$method = 'id';
					if (method_exists($module, $method)) {
						return call_user_func_array(array($module, $method), array($x, $y));
					}
					return Bool\Module::create(spl_object_hash($x) === spl_object_hash($y));
				}
				else if ($ys instanceof Option\Type\None) {
					return Bool\Module::true();
				}
			}
			return Bool\Module::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Data\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Option\Type $xs, Data\Type $ys) { // !=
			return Bool\Module::not(Option\Type::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Data\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Option\Type $xs, Data\Type $ys) { // !==
			return Bool\Module::not(Option\Type::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the object to be compared
		 * @return Int32\Type                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(Option\Type $xs, Option\Type $ys) {
			$x = Option\Type::isDefined($xs)->unbox();
			$y = Option\Type::isDefined($ys)->unbox();

			if (!$x && $y) {
				return Int32\Type::negative();
			}
			if (!$x && !$y) {
				return Int32\Type::zero();
			}
			if ($x && !$y) {
				return Int32\Type::one();
			}

			$x = $xs->object();
			$y = $ys->object();

			if (($x === null) && ($y !== null)) {
				return Int32\Type::negative();
			}
			if (($x === null) && ($y === null)) {
				return Int32\Type::zero();
			}
			if (($x !== null) && ($y === null)) {
				return Int32\Type::one();
			}

			$module = get_class($x);
			$method = 'compare';
			if (method_exists($module, $method)) {
				return call_user_func_array(array($module, $method), array($x, $y));
			}
			return String\Module::compare(String\Module::create(spl_object_hash($x)), String\Module::create(spl_object_hash($y)));
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Option\Type $xs, Option\Type $ys) { // >=
			return Bool\Module::create(Option\Type::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Option\Type $xs, Option\Type $ys) { // >
			return Bool\Module::create(Option\Type::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Option\Type $xs, Option\Type $ys) { // <=
			return Bool\Module::create(Option\Type::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Option\Type $xs, Option\Type $ys) { // <
			return Bool\Module::create(Option\Type::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the right operand
		 * @return Int32\Type                                       the maximum value
		 */
		public static function max(Option\Type $xs, Option\Type $ys) {
			return (Option\Type::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Option\Type $xs                                   the left operand
		 * @param Option\Type $ys                                   the right operand
		 * @return Int32\Type                                       the minimum value
		 */
		public static function min(Option\Type $xs, Option\Type $ys) {
			return (Option\Type::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

	}

}
