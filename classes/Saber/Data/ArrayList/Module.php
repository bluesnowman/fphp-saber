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

namespace Saber\Data\ArrayList {

	use \Saber\Core;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Bool;
	use \Saber\Data\Int32;
	use \Saber\Data\LinkedList;
	use \Saber\Data\Option;
	use \Saber\Data\Tuple;
	use \Saber\Data\Vector;
	use \Saber\Throwable;

	class Module extends Vector\Module {

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the elements in the list, yielding each
		 * element to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether each element passed the
		 *                                                          truthy test
		 */
		public static function all(ArrayList\Type $xs, callable $predicate) {
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				if (!$predicate($xs->element($i), $i)->unbox()) {
					return Bool\Type::false();
				}
			}

			return Bool\Type::true(); // yes, an empty array returns "true"
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the elements in the list passed the truthy
		 * test.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether some of the elements
		 *                                                          passed the truthy test
		 */
		public static function any(ArrayList\Type $xs, callable $predicate) {
			return Option\Module::isDefined(ArrayList\Module::find($xs, $predicate));
		}

		/**
		 * This method appends the specified object to this object's list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Core\Type $y                                      the object to be appended
		 * @return ArrayList\Type                                   the list
		 */
		public static function append(ArrayList\Type $xs, Core\Type $y) {
			$buffer = $xs->unbox();
			$buffer[] = $y;
			return new ArrayList\Type($buffer);
		}

		/**
		 * This method concatenates a list to this object's list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param ArrayList\Type $ys                                the list to be concatenated
		 * @return ArrayList\Type                                   the list
		 */
		public static function concat(ArrayList\Type $xs, ArrayList\Type $ys) {
			$buffer = $xs->unbox();
			foreach ($ys->unbox() as $y) {
				$buffer[] = $y;
			}
			return new ArrayList\Type($buffer);
		}

		/**
		 * This method evaluates whether the specified object is contained within the list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Core\Type $y                                      the object to find
		 * @return Bool\Type                                        whether the specified object is
		 *                                                          contained within the list
		 */
		public static function contains(ArrayList\Type $xs, Core\Type $y) {
			return ArrayList\Module::any($xs, function(Core\Type $x, Int32\Type $i) use ($y) {
				return call_user_func_array(array(get_class($x), 'eq'), array($x, $y));
			});
		}

		/**
		 * This method remove the first occurrence that equals the specified object.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Core\Type $y                                      the object to be removed
		 * @return ArrayList\Type                                   the list
		 */
		public static function delete(ArrayList\Type $xs, Core\Type $y) {
			$buffer = array();
			$skip = false;

			foreach ($xs->unbox() as $z) {
				if (call_user_func_array(array(get_class($z), 'eq'), array($z, $y))->unbox() && !$skip) {
					$skip = true;
					continue;
				}
				$buffer[] = $z;
			}

			return new ArrayList\Type($buffer);
		}

		/**
		 * This method returns the list after dropping the first "n" elements.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Int32\Type $n                                     the number of elements to drop
		 * @return ArrayList\Type                                   the list
		 */
		public static function drop(ArrayList\Type $xs, Int32\Type $n) {
			$buffer = array();
			$length = $xs->length();

			for ($i = $n; Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$buffer[] = $xs->element($i);
			}

			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the list from element where the predicate function fails.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return ArrayList\Type                                   the list
		 */
		public static function dropWhile(ArrayList\Type $xs, callable $predicate) {
			$buffer = array();
			$length = $xs->length();

			$failed = false;
			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$x = $xs->element($i);
				if (!$predicate($x, $i)->unbox() || $failed) {
					$buffer[] = $x;
					$failed = true;
				}
			}

			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the list from element where the predicate function doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return ArrayList\Type                                   the list
		 */
		public static function dropWhileEnd(ArrayList\Type $xs, callable $predicate) {
			return ArrayList\Module::dropWhile($xs, function(Core\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method iterates over the elements in the list, yielding each element to the procedure
		 * function.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $procedure                               the procedure function to be used
		 */
		public static function each(ArrayList\Type $xs, callable $procedure) {
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$procedure($xs->element($i), $i);
			}
		}

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Int32\Type $i                                     the index of the element
		 * @return Core\Type                                        the element at the specified index
		 * @throws Throwable\OutOfBounds\Exception                  indicates the specified index
		 *                                                          cannot be found
		 */
		public static function element(ArrayList\Type $xs, Int32\Type $i) {
			return $xs->element($i);
		}

		/**
		 * This method returns a list of those elements that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return ArrayList\Type                                   the list
		 */
		public static function filter(ArrayList\Type $xs, callable $predicate) {
			$buffer = array();
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$x = $xs->element($i);
				if ($predicate($x, $i)->unbox()) {
					$buffer[] = $x;
				}
			}

			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the first object in the collection that passes the truthy test, if any.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Option\Type                                      an option containing the first object
		 *                                                          satisfying the predicate, if any
		 */
		public static function find(ArrayList\Type $xs, callable $predicate) {
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$x = $xs->element($i);
				if ($predicate($x, $i)->unbox()) {
					return Option\Type::some($x);
				}
			}

			return Option\Type::none();
		}

		/**
		 * This method returns the array list flattened.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return ArrayList\Type                                   the flattened array list
		 */
		public static function flatten(ArrayList\Type $xs) {
			$buffer = array();
			$x_length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $x_length)->unbox(); $i = Int32\Module::increment($i)) {
				$x = $xs->element($i);
				if ($x instanceof ArrayList\Type) {
					$ys = ArrayList\Module::flatten($x);
					$y_length = $ys->length();
					for ($j = Int32\Type::zero(); Int32\Module::lt($j, $y_length)->unbox(); $j = Int32\Module::increment($j)) {
						$buffer[] = $ys->element($j);
					}
				}
				else {
					$buffer[] = $x;
				}
			}

			return $buffer;
		}

		/**
		 * This method applies a left-fold reduction on the list using the operator function.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Type $initial                                the initial value to be used
		 * @return Core\Type                                        the result
		 */
		public static function foldLeft(ArrayList\Type $xs, callable $operator, Core\Type $initial) {
			$z = $initial;
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$z = $operator($z, $xs->element($i));
			}

			return $z;
		}

		/**
		 * This method applies a right-fold reduction on the list using the operation function.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Type $initial                                the initial value to be used
		 * @return Core\Type                                        the result
		 */
		public static function foldRight(ArrayList\Type $xs, callable $operator, Core\Type $initial) {
			$z = $initial;
			$length = $xs->length();

			for ($i = Int32\Module::decrement($length); Int32\Module::ge($i, Int32\Type::zero())->unbox(); $i = Int32\Module::decrement($i)) {
				$z = $operator($z, $xs->element($i));
			}

			return $z;
		}

		/**
		 * This method returns the head object in this list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Core\Type                                        the head object in this list
		 */
		public static function head(ArrayList\Type $xs) {
			return $xs->element(Int32\Type::zero());
		}

		/**
		 * This method returns an option using the head for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Option\Type                                      the option
		 */
		public static function headOption(ArrayList\Type $xs) {
			return (!$xs->__isEmpty()) ? Option\Type::some($xs->head()) : Option\Type::none();
		}

		/**
		 * This method returns the index of the first occurrence of the object; otherwise, it returns -1;
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Core\Type $y                                      the object to be searched for
		 * @return Int32\Type                                       the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public static function indexOf(ArrayList\Type $xs, Core\Type $y) {
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$x = $xs->element($i);
				if (call_user_func_array(array(get_class($x), 'eq'), array($x, $y))->unbox()) {
					return $i;
				}
			}

			return Int32\Type::negative();
		}

		/**
		 * This method returns all but the last element of in the list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return ArrayList\Type                                   the list, minus the last
		 *                                                          element
		 */
		public static function init(ArrayList\Type $xs) {
			$buffer = array();
			$length = Int32\Module::decrement($xs->length());

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$buffer[] = $xs->element($i);
			}

			return ArrayList\Type::box($buffer);
		}

		/**
		 * The method intersperses the specified object between each element in the list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Core\Type $y                                      the object to be interspersed
		 * @return ArrayList\Type                                   the list
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function intersperse(ArrayList\Type $xs, Core\Type $y) {
			$buffer = array();
			$length = $xs->length();

			if ($length > 0) {
				$buffer[] = $xs->element(Int32\Type::zero());
				for ($i = Int32\Type::one(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
					$buffer[] = $y;
					$buffer[] = $xs->element($i);
				}
			}

			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Bool\Type                                        whether the list is empty
		 */
		public static function isEmpty(ArrayList\Type $xs) {
			return $xs->isEmpty();
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return ArrayList\Iterator                               an iterator for this collection
		 */
		public static function iterator(ArrayList\Type $xs) {
			return new ArrayList\Iterator($xs);
		}

		/**
		 * This method returns the last element in this list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return mixed                                            the last element in this linked
		 *                                                          list
		 */
		public static function last(ArrayList\Type $xs) {
			return $xs->element(Int32\Module::decrement($xs->length()));
		}

		/**
		 * This method returns an option using the last for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Option\Type                                      the option
		 */
		public static function lastOption(ArrayList\Type $xs) {
			return (!$xs->__isEmpty()) ? Option\Type::some(ArrayList\Module::last($xs)) : Option\Type::none();
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Int32\Type                                       the length of this array list
		 */
		public static function length(ArrayList\Type $xs) {
			return $xs->length();
		}

		/**
		 * This method applies each element in this list to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return ArrayList\Type                                   the list
		 */
		public static function map(ArrayList\Type $xs, callable $subroutine) {
			$buffer = array();
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$buffer[] = $subroutine($xs->element($i), $i);
			}

			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method iterates over the elements in the list, yielding each element to the
		 * predicate function, or fails the falsy test.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether each element passed the
		 *                                                          falsy test
		 */
		public static function none(ArrayList\Type $xs, callable $predicate) {
			return ArrayList\Module::all($xs, function(Core\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method prepends the specified object to the front of this list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Core\Type $y                                      the object to be prepended
		 * @return ArrayList\Type                                   the list
		 */
		public static function prepend(ArrayList\Type $xs, Core\Type $y) {
			$buffer = $xs->unbox();
			array_unshift($buffer, $y);
			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the list within the specified range.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Int32\Type $start                                 the starting index
		 * @param Int32\Type $end                                   the ending index
		 * @return ArrayList\Type                                   the list
		 */
		public static function range(ArrayList\Type $xs, Int32\Type $start, Int32\Type $end) {
			return ArrayList\Module::drop(ArrayList\Module::take($xs, $end), $start);
		}

		/**
		 * This method returns a list of those elements that don't satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return ArrayList\Type                                   the list
		 */
		public static function remove(ArrayList\Type $xs, callable $predicate) {
			return ArrayList\Module::filter($xs, function(Core\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method reverses the order of the elements in this list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return ArrayList\Type                                   the list
		 */
		public static function reverse(ArrayList\Type $xs) {
			return ArrayList\Type::box(array_reverse($xs->unbox()));
		}

		/**
		 * This method returns the extracted slice of the list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Int32\Type $offset                                the starting index
		 * @param Int32\Type $length                                the length of the slice
		 * @return ArrayList\Type                                   the list
		 */
		public static function slice(ArrayList\Type $xs, Int32\Type $offset, Int32\Type $length) {
			return ArrayList\Type::box(array_slice($xs->unbox(), $offset->unbox(), $length->unbox()));
		}

		/**
		 * This method returns the tail of this list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return ArrayList\Type                                   the tail of this list
		 */
		public static function tail(ArrayList\Type $xs) {
			return $xs->tail();
		}

		/**
		 * This method returns the first "n" elements in the list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Int32\Type $n                                     the number of elements to take
		 * @return ArrayList\Type                                   the list
		 */
		public static function take(ArrayList\Type $xs, Int32\Type $n) {
			$buffer = array();
			$length = Int32\Module::min($n, $xs->length());

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$buffer[] = $xs->element($i);
			}

			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method returns each element in this list until the predicate fails.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return ArrayList\Type                                   the list
		 */
		public static function takeWhile(ArrayList\Type $xs, callable $predicate) {
			$buffer = array();
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$x = $xs->element($i);
				if (!$predicate($x, $i)->unbox()) {
					break;
				}
				$buffer[] = $x;
			}

			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method returns each element in this list until the predicate doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return ArrayList\Type                                   the list
		 */
		public static function takeWhileEnd(ArrayList\Type $xs, callable $predicate) {
			return ArrayList\Module::takeWhile($xs, function(Core\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method returns a new list of tuple pairings.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param ArrayList\Type $ys                                the right operand
		 * @return ArrayList\Type                                   a new list of tuple pairings
		 */
		public static function zip(ArrayList\Type $xs, ArrayList\Type $ys) {
			$buffer = array();
			$length = Int32\Module::min($xs->length(), $ys->length());

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$buffer[] = Tuple\Type::box($xs->element($i), $ys->element($i));
			}

			return ArrayList\Type::box($buffer);
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the value to be evaluated
		 * @param ArrayList\Type $ys                                the default value
		 * @return ArrayList\Type                                   the result
		 */
		public static function nvl(ArrayList\Type $xs = null, ArrayList\Type $ys = null) {
			return ($xs !== null) ? $xs : (($ys !== null) ? $ys : ArrayList\Type::empty_());
		}

		/**
		 * This method returns the collection as an array.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the operand
		 * @return ArrayList\Type                                   the collection as an array list
		 */
		public static function toArrayList(ArrayList\Type $xs) {
			return $xs;
		}

		/**
		 * This method returns the collection as a linked list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the operand
		 * @return LinkedList\Type                                  the collection as a linked list
		 */
		public static function toLinkedList(ArrayList\Type $xs) {
			$length = $xs->length();
			$zs = LinkedList\Type::nil();
			for ($i = Int32\Module::decrement($length); Int32\Module::ge($i, Int32\Type::zero())->unbox(); $i = Int32\Module::decrement($i)) {
				$zs = LinkedList\Module::prepend($zs, $xs->element($i));
			}
			return $zs;
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(ArrayList\Type $xs, Core\Type $ys) { // ==
			$type = $xs->__typeOf();
			if ($ys !== null) {
				if ($ys instanceof $type) {
					$x_length = $xs->__length();
					$y_length = $ys->__length();

					for ($i = 0; ($i < $x_length) && ($i < $y_length); $i++) {
						$p = Int32\Type::box($i);
						$r = $xs->element($p)->eq($ys->element($p));
						if (!$r->unbox()) {
							return $r;
						}
					}

					return Bool\Type::box($x_length == $y_length);
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(ArrayList\Type $xs, Core\Type $ys) { // ===
			if ($ys !== null) {
				if ($xs->__typeOf() === $ys->__typeOf()) {
					$x_length = $xs->__length();
					$y_length = $ys->__length();

					for ($i = 0; ($i < $x_length) && ($i < $y_length); $i++) {
						$p = Int32\Type::box($i);
						$r = $xs->element($p)->id($ys->element($p));
						if (!$r->unbox()) {
							return $r;
						}
					}

					return Bool\Type::box($x_length == $y_length);
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(ArrayList\Type $xs, Core\Type $ys) { // !=
			return Bool\Module::not(ArrayList\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(ArrayList\Type $xs, Core\Type $ys) { // !==
			return Bool\Module::not(ArrayList\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param ArrayList\Type $ys                                the object to be compared
		 * @return Int32\Type                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(ArrayList\Type $xs, ArrayList\Type $ys) {
			if (($xs === null) && ($ys !== null)) {
				return Int32\Type::negative();
			}
			if (($xs === null) && ($ys === null)) {
				return Int32\Type::zero();
			}
			if (($xs !== null) && ($ys === null)) {
				return Int32\Type::one();
			}

			$x_length = $xs->__length();
			$y_length = $ys->__length();

			for ($i = 0; ($i < $x_length) && ($i < $y_length); $i++) {
				$p = Int32\Type::box($i);
				$r = $xs->element($p)->compare($ys->element($p));
				if ($r->unbox() != 0) {
					return $r;
				}
			}

			if ($x_length < $y_length) {
				return Int32\Type::negative();
			}
			else if ($x_length == $y_length) {
				return Int32\Type::zero();
			}
			else { // ($x_length > $y_length)
				return Int32\Type::one();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param ArrayList\Type $ys                                the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(ArrayList\Type $xs, ArrayList\Type $ys) { // >=
			return Bool\Type::box(ArrayList\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param ArrayList\Type $ys                                the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(ArrayList\Type $xs, ArrayList\Type $ys) { // >
			return Bool\Type::box(ArrayList\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param ArrayList\Type $ys                                the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(ArrayList\Type $xs, ArrayList\Type $ys) { // <=
			return Bool\Type::box(ArrayList\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param ArrayList\Type $ys                                the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(ArrayList\Type $xs, ArrayList\Type $ys) { // <
			return Bool\Type::box(ArrayList\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param ArrayList\Type $ys                                the right operand
		 * @return Int32\Type                                       the maximum value
		 */
		public static function max(ArrayList\Type $xs, ArrayList\Type $ys) {
			return (ArrayList\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param ArrayList\Type $ys                                the right operand
		 * @return Int32\Type                                       the minimum value
		 */
		public static function min(ArrayList\Type $xs, ArrayList\Type $ys) {
			return (ArrayList\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

		#region Methods -> Boolean Operations

		/**
		 * This method (aka "truthy") returns whether all of the elements of the list evaluate
		 * to true.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Bool\Type                                        whether all of the elements of
		 *                                                          the list evaluate to true
		 */
		public static function and_(ArrayList\Type $xs) {
			return ArrayList\Module::truthy($xs);
		}

		/**
		 * This method (aka "falsy") returns whether all of the elements of the list evaluate
		 * to false.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Bool\Type                                        whether all of the elements of
		 *                                                          the list evaluate to false
		 *
		 * @see http://www.sitepoint.com/javascript-truthy-falsy/
		 */
		public static function or_(ArrayList\Type $xs) {
			return ArrayList\Module::falsy($xs);
		}

		/**
		 * This method returns whether all of the elements of the list strictly evaluate to
		 * false.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Bool\Type                                        whether all of the elements of
		 *                                                          the list strictly evaluate
		 *                                                          to false
		 */
		public static function false(ArrayList\Type $xs) {
			return Bool\Module::not(ArrayList\Type::true($xs));
		}

		/**
		 * This method (aka "or") returns whether all of the elements of the list evaluate to
		 * false.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Bool\Type                                        whether all of the elements of
		 *                                                          the list evaluate to false
		 *
		 * @see http://www.sitepoint.com/javascript-truthy-falsy/
		 */
		public static function falsy(ArrayList\Type $xs) {
			return Bool\Module::not(ArrayList\Module::truthy($xs));
		}

		/**
		 * This method returns whether all of the elements of the list strictly evaluate
		 * to true.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Bool\Type                                        whether all of the elements of
		 *                                                          the list strictly evaluate
		 *                                                          to true
		 */
		public static function true(ArrayList\Type $xs) {
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				if (Bool\Module::ni(Bool\Type::true(), $xs->element($i))->unbox()) {
					return Bool\Type::false();
				}
			}

			return Bool\Type::true();
		}

		/**
		 * This method (aka "and") returns whether all of the elements of the list evaluate to
		 * true.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Bool\Type                                        whether all of the elements of
		 *                                                          the list evaluate to true
		 */
		public static function truthy(ArrayList\Type $xs) {
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				if (!$xs->__element($i)) {
					return Bool\Type::false();
				}
			}

			return Bool\Type::true();
		}

		#endregion

	}

}