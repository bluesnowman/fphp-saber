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
	use \Saber\Data\ArrayList;
	use \Saber\Throwable;

	class ArrayList extends Collection\Type {

		#region Methods -> Boxing/Creation

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Data\Type                                        the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function box($value/*...*/) {
			if (($value === null) || !is_array($value)) {
				$type = gettype($value);
				if ($type == 'object') {
					$type = get_class($value);
				}
				throw new Throwable\InvalidArgument\Exception('Unable to create array list. Expected an array, but got ":type".', array(':type' => $type));
			}
			foreach ($value as $object) {
				if (!(is_object($object) && ($object instanceof Core\Type))) {
					$type = gettype($value);
					if ($type == 'object') {
						$type = get_class($value);
					}
					throw new Throwable\InvalidArgument\Exception('Unable to create array list. Expected a boxed value, but got ":type".', array(':type' => $type));
				}
			}
			return new ArrayList\Type($value);
		}

		/**
		 * This method creates a list of "n" length with every element set to the given object.
		 *
		 * @access public
		 * @param Int32 $n                                          the number of times to replicate
		 * @param Data\Type $y                                      the object to be replicated
		 * @return ArrayList\Type                                   the collection
		 */
		public static function replicate(Int32\Type $n, Data\Type $y) {
			$buffer = array();

			for ($i = $n->unbox() - 1; $i >= 0; $i--) {
				$buffer[] = $y;
			}

			return new ArrayList\Type($buffer);
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

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
			$length = ArrayList\Module::length($xs);

			for ($i = Int32\Type::zero(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				if (!$predicate(ArrayList\Module::element($xs, $i), $i)->unbox()) {
					return Bool\Module::false();
				}
			}

			return Bool\Module::true(); // yes, an empty array returns "true"
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
			return Option\Type::isDefined(ArrayList\Module::find($xs, $predicate));
		}

		/**
		 * This method appends the specified object to this object's list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Data\Type $y                                      the object to be appended
		 * @return ArrayList\Type                                   the list
		 */
		public static function append(ArrayList\Type $xs, Data\Type $y) {
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
		 * @param Data\Type $y                                      the object to find
		 * @return Bool\Type                                        whether the specified object is
		 *                                                          contained within the list
		 */
		public static function contains(ArrayList\Type $xs, Data\Type $y) {
			return ArrayList\Module::any($xs, function(Data\Type $x, Int32\Type $i) use ($y) {
				return call_user_func_array(array(get_class($x), 'eq'), array($x, $y));
			});
		}

		/**
		 * This method remove the first occurrence that equals the specified object.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Data\Type $y                                      the object to be removed
		 * @return ArrayList\Type                                   the list
		 */
		public static function delete(ArrayList\Type $xs, Data\Type $y) {
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
			$length = ArrayList\Module::length($xs);

			for ($i = $n; Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				$buffer[] = ArrayList\Module::element($xs, $i);
			}

			return new ArrayList\Type($buffer);
		}

		/**
		 * This method return the list from element where the predicate function fails.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return ArrayList\Type                                   the list
		 */
		public static function dropWhile(ArrayList\Type $xs, callable $predicate) {
			$buffer = array();
			$length = ArrayList\Module::length($xs);

			$failed = false;
			for ($i = Int32\Type::zero(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				$x = ArrayList\Module::element($xs, $i);
				if (!$predicate($x, $i)->unbox() || $failed) {
					$buffer[] = $x;
					$failed = true;
				}
			}

			return new ArrayList\Type($buffer);
		}

		/**
		 * This method return the list from element where the predicate function doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return ArrayList\Type                                   the list
		 */
		public static function dropWhileEnd(ArrayList\Type $xs, callable $predicate) {
			return ArrayList\Module::dropWhile($xs, function(Data\Type $x, Int32\Type $i) use ($predicate) {
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
			$length = ArrayList\Module::length($xs);

			for ($i = Int32\Type::zero(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				$procedure(ArrayList\Module::element($xs, $i), $i);
			}
		}

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Int32\Type $i                                     the index of the element
		 * @return Data\Type                                        the element at the specified index
		 * @throws Throwable\OutOfBounds\Exception                  indicates the specified index
		 *                                                          cannot be found
		 */
		public static function element(ArrayList\Type $xs, Int32\Type $i) {
			return $xs->value[$i->unbox()];
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
			$length = ArrayList\Module::length($xs);

			for ($i = Int32\Type::zero(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				$x = ArrayList\Module::element($xs, $i);
				if ($predicate($x, $i)->unbox()) {
					$buffer[] = $x;
				}
			}

			return new ArrayList\Type($buffer);
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
			$length = ArrayList\Module::length($xs);

			for ($i = Int32\Type::zero(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				$x = ArrayList\Module::element($xs, $i);
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
			$x_length = ArrayList\Module::length($xs);

			for ($i = Int32\Type::zero(); Int32\Type::lt($i, $x_length)->unbox(); $i = Int32\Type::increment($i)) {
				$x = ArrayList\Module::element($xs, $i);
				if ($x instanceof ArrayList\Type) {
					$ys = ArrayList\Module::flatten($x);
					$y_length = ArrayList\Module::length($ys);
					for ($j = Int32\Type::zero(); Int32\Type::lt($j, $y_length)->unbox(); $j = Int32\Type::increment($j)) {
						$buffer[] = ArrayList\Module::element($ys, $j);
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
		 * @param Data\Type $initial                                the initial value to be used
		 * @return Data\Type                                        the result
		 */
		public static function foldLeft(ArrayList\Type $xs, callable $operator, Data\Type $initial) {
			$z = $initial;
			$length = ArrayList\Module::length($xs);

			for ($i = Int32\Type::zero(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				$z = $operator($z, ArrayList\Module::element($xs, $i));
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
		 * @param Data\Type $initial                                the initial value to be used
		 * @return Data\Type                                        the result
		 */
		public static function foldRight(ArrayList\Type $xs, callable $operator, Data\Type $initial) {
			$z = $initial;
			$length = ArrayList\Module::length($xs);

			for ($i = Int32\Type::decrement($length); Int32\Type::ge($i, Int32\Type::zero())->unbox(); $i = Int32\Type::decrement($length)) {
				$z = $operator($z, ArrayList\Module::element($xs, $i));
			}

			return $z;
		}

		/**
		 * This method returns the head object in this list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Data\Type                                        the head object in this list
		 */
		public static function head(ArrayList\Type $xs) {
			return ArrayList\Module::element($xs, Int32\Type::zero());
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
			return (!ArrayList\Module::isEmpty($xs)->unbox()) ? Option\Type::some(ArrayList\Module::head($xs)) : Option\Type::none();
		}

		/**
		 * This method return the index of the first occurrence of the object; otherwise, it returns -1;
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Data\Type $y                                      the object to be searched for
		 * @return Int32\Type                                       the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public static function indexOf(ArrayList\Type $xs, Data\Type $y) {
			$length = ArrayList\Module::length($xs);

			for ($i = Int32\Type::zero(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				$x = ArrayList\Module::element($xs, $i);
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
			$length = Int32\Type::decrement(ArrayList\Module::length($xs));

			for ($i = Int32\Type::zero(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				$buffer[] = ArrayList\Module::element($xs, $i);
			}

			return new ArrayList\Type($buffer);
		}

		/**
		 * The method intersperses the specified object between each element in the list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Data\Type $y                                      the object to be interspersed
		 * @return ArrayList\Type                                   the list
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function intersperse(ArrayList\Type $xs, Data\Type $y) {
			$buffer = array();
			$length = ArrayList\Module::length($xs);

			if ($length > 0) {
				$buffer[] = ArrayList\Module::element($xs, Int32\Type::zero());
				for ($i = Int32\Type::one(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
					$buffer[] = $y;
					$buffer[] = ArrayList\Module::element($xs, $i);
				}
			}

			return new ArrayList\Type($buffer);
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
			return Int32\Type::eq(ArrayList\Module::length($xs), Int32\Type::zero());
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return ArrayList\Type\Iterator                          an iterator for this collection
		 */
		public static function iterator(ArrayList\Type $xs) {
			return new ArrayList\Type\Iterator($xs);
		}

		/**
		 * This method returns the last element in this list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Data\Type                                        the last element in this linked
		 *                                                          list
		 */
		public static function last(ArrayList\Type $xs) {
			return ArrayList\Module::element($xs, Int32\Type::decrement(ArrayList\Module::length($xs)));
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
			return (!ArrayList\Module::isEmpty($xs)->unbox()) ? Option\Type::some(ArrayList\Module::last($xs)) : Option\Type::none();
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
			return Int32\Type::create(count($xs->unbox()));
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
			$length = ArrayList\Module::length($xs);

			for ($i = Int32\Type::zero(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				$buffer[] = $subroutine(ArrayList\Module::element($xs, $i), $i);
			}

			return new ArrayList\Type($buffer);
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
			return ArrayList\Module::all($xs, function(Data\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method prepends the specified object to the front of this list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param Data\Type $y                                      the object to be prepended
		 * @return ArrayList\Type                                   the list
		 */
		public static function prepend(ArrayList\Type $xs, Data\Type $y) {
			$buffer = $xs->unbox();
			array_unshift($buffer, $y);
			return new ArrayList\Type($buffer);
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
			return ArrayList\Module::filter($xs, function(Data\Type $x, Int32\Type $i) use ($predicate) {
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
			return new ArrayList\Type(array_reverse($xs->unbox()));
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
			return new ArrayList\Type(array_slice($xs->unbox(), $offset->unbox(), $length->unbox()));
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
			$buffer = array();
			$length = ArrayList\Module::length($xs);

			for ($i = Int32\Type::one(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				$buffer[] = ArrayList\Module::element($xs, $i);
			}

			return new ArrayList\Type($buffer);
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
			$length = Int32\Type::min($n, ArrayList\Module::length($xs));

			for ($i = Int32\Type::zero(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				$buffer[] = ArrayList\Module::element($xs, $i);
			}

			return new ArrayList\Type($buffer);
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
			$length = ArrayList\Module::length($xs);

			for ($i = Int32\Type::zero(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				$x = ArrayList\Module::element($xs, $i);
				if (!$predicate($x, $i)->unbox()) {
					break;
				}
				$buffer[] = $x;
			}

			return new ArrayList\Type($buffer);
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
			return ArrayList\Module::takeWhile($xs, function(Data\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method returns the collection as an array.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return ArrayList\Type                                   the collection as an array list
		 */
		public static function toArray(ArrayList\Type $xs) {
			return $xs;
		}

		/**
		 * This method returns the collection as a linked list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return LinkedList\Type                                  the collection as a linked list
		 */
		public static function toList(ArrayList\Type $xs) {
			$length = ArrayList\Module::length($xs);
			$zs = LinkedList\Module::nil();
			for ($i = Int32\Type::decrement($length); Int32\Type::ge($i, Int32\Type::zero())->unbox(); $i = Int32\Type::decrement($i)) {
				$zs = LinkedList\Module::prepend($zs, ArrayList\Module::element($xs, $i));
			}
			return $zs;
		}

		#endregion

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @param ArrayList\Type $ys                              the object to be compared
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

			$x_length = ArrayList\Module::length($xs);
			$y_length = ArrayList\Module::length($ys);

			if ($x_length < $y_length) {
				return Int32\Type::negative();
			}
			else if ($x_length > $y_length) {
				return Int32\Type::one();
			}
			else { // ($x_length == $y_length)
				for ($i = Int32\Type::zero(); Int32\Type::lt($i, $x_length)->unbox(); $i = Int32\Type::increment($i)) {
					$x = ArrayList\Module::element($xs, $i);
					$y = ArrayList\Module::element($ys, $i);
					$r = call_user_func_array(array(get_class($x), 'compare'), array($x, $y));
					if ($r->unbox() != 0) {
						return $r;
					}
				}
				return Int32\Type::one();
			}
		}

		#region Methods -> Object Oriented -> Boolean Operations

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
			return Bool\Module::not(ArrayList\Module::true($xs));
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
			$length = ArrayList\Module::length($xs);

			for ($i = Int32\Type::zero(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				if (Bool\Module::ni(Bool\Module::true(), ArrayList\Module::element($xs, $i))->unbox()) {
					return Bool\Module::false();
				}
			}

			return Bool\Module::true();
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
			$length = ArrayList\Module::length($xs);

			for ($i = Int32\Type::zero(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				if (!ArrayList\Module::element($xs, $i)->unbox()) {
					return Bool\Module::false();
				}
			}

			return Bool\Module::true();
		}

		#endregion

		#region Methods -> Object Oriented -> Numeric Operations

		/**
		 * This method returns the average of all elements in the list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Num\Type                                         the result
		 */
		public static function average(ArrayList\Type $xs) {
			if (ArrayList\Module::isEmpty($xs)->unbox()) {
				return Int32\Type::zero();
			}

			$length = ArrayList\Module::length($xs);
			$x = ArrayList\Module::element($xs, Int32\Type::zero());
			$t = Data\Type::typeOf($x);
			$y = $t::zero();

			for ($i = Int32\Type::one(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				$x = $x->add(ArrayList\Module::element($xs, $i));
				$y = $y->increment();
			}

			return $x->divide($y);
		}

		/**
		 * This method returns the product of all elements in the list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Num\Type                                         the result
		 */
		public static function product(ArrayList\Type $xs) {
			if (ArrayList\Module::isEmpty($xs)->unbox()) {
				return Int32\Type::one();
			}

			$length = ArrayList\Module::length($xs);

			$x = ArrayList\Module::element($xs, Int32\Type::zero());
			$number = get_class($x);

			for ($i = Int32\Type::one(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				$x = $number::multiply($x, ArrayList\Module::element($xs, $i));
			}

			return $x;
		}

		/**
		 * This method returns the sum of all elements in the list.
		 *
		 * @access public
		 * @static
		 * @param ArrayList\Type $xs                                the left operand
		 * @return Num\Type                                         the result
		 */
		public static function sum(ArrayList\Type $xs) {
			if (ArrayList\Module::isEmpty($xs)->unbox()) {
				return Int32\Type::zero();
			}

			$length = ArrayList\Module::length($xs);

			$x = ArrayList\Module::element($xs, Int32\Type::zero());
			$number = get_class($x);

			for ($i = Int32\Type::one(); Int32\Type::lt($i, $length)->unbox(); $i = Int32\Type::increment($i)) {
				$x = $number::add($x, ArrayList\Module::element($xs, $i));
			}

			return $x;
		}

		#endregion

	}

}