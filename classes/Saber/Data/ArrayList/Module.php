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

	class ArrayList extends Data\Collection {

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
				if (!(is_object($object) && ($object instanceof Data\Type))) {
					$type = gettype($value);
					if ($type == 'object') {
						$type = get_class($value);
					}
					throw new Throwable\InvalidArgument\Exception('Unable to create array list. Expected a boxed value, but got ":type".', array(':type' => $type));
				}
			}
			return new Data\ArrayList($value);
		}

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param array $value                                      the value to be assigned
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public function __construct(array $value) {
			$this->value = $value;
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString() {
			return (string) serialize($this->unbox());
		}

		/**
		 * This method creates a list of "n" length with every element set to the given object.
		 *
		 * @access public
		 * @param Int32 $n                                          the number of times to replicate
		 * @param Data\Type $y                                      the object to be replicated
		 * @return Data\ArrayList                                   the collection
		 */
		public static function replicate(Data\Int32 $n, Data\Type $y) {
			$buffer = array();

			for ($i = $n->unbox() - 1; $i >= 0; $i--) {
				$buffer[] = $y;
			}

			return new Data\ArrayList($buffer);
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @param integer $depth                                    how many levels to unbox
		 * @return array                                            the un-boxed value
		 */
		public function unbox($depth = 0) {
			if ($depth > 0) {
				$buffer = array();

				foreach ($this->value as $x) {
					$buffer[] = $x->unbox($depth - 1);
				}

				return $buffer;
			}
			return $this->value;
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method (aka "every" or "forall") iterates over the elements in the list, yielding each
		 * element to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether each element passed the
		 *                                                          truthy test
		 */
		public static function all(Data\ArrayList $xs, callable $predicate) {
			$length = Data\ArrayList::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				if (!$predicate(Data\ArrayList::element($xs, $i), $i)->unbox()) {
					return Data\Bool::false();
				}
			}

			return Data\Bool::true(); // yes, an empty array returns "true"
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the elements in the list passed the truthy
		 * test.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether some of the elements
		 *                                                          passed the truthy test
		 */
		public static function any(Data\ArrayList $xs, callable $predicate) {
			return Data\Option::isDefined(Data\ArrayList::find($xs, $predicate));
		}

		/**
		 * This method appends the specified object to this object's list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Type $y                                      the object to be appended
		 * @return Data\ArrayList                                   the list
		 */
		public static function append(Data\ArrayList $xs, Data\Type $y) {
			$buffer = $xs->unbox();
			$buffer[] = $y;
			return new Data\ArrayList($buffer);
		}

		/**
		 * This method concatenates a list to this object's list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\ArrayList $ys                                the list to be concatenated
		 * @return Data\ArrayList                                   the list
		 */
		public static function concat(Data\ArrayList $xs, Data\ArrayList $ys) {
			$buffer = $xs->unbox();
			foreach ($ys->unbox() as $y) {
				$buffer[] = $y;
			}
			return new Data\ArrayList($buffer);
		}

		/**
		 * This method evaluates whether the specified object is contained within the list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Type $y                                      the object to find
		 * @return Data\Bool                                        whether the specified object is
		 *                                                          contained within the list
		 */
		public static function contains(Data\ArrayList $xs, Data\Type $y) {
			return Data\ArrayList::any($xs, function(Data\Type $x, Data\Int32 $i) use ($y) {
				return call_user_func_array(array(get_class($x), 'eq'), array($x, $y));
			});
		}

		/**
		 * This method remove the first occurrence that equals the specified object.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Type $y                                      the object to be removed
		 * @return Data\ArrayList                                   the list
		 */
		public static function delete(Data\ArrayList $xs, Data\Type $y) {
			$buffer = array();
			$skip = false;

			foreach ($xs->unbox() as $z) {
				if (call_user_func_array(array(get_class($z), 'eq'), array($z, $y))->unbox() && !$skip) {
					$skip = true;
					continue;
				}
				$buffer[] = $z;
			}

			return new Data\ArrayList($buffer);
		}

		/**
		 * This method returns the list after dropping the first "n" elements.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Int32 $n                                     the number of elements to drop
		 * @return Data\ArrayList                                   the list
		 */
		public static function drop(Data\ArrayList $xs, Data\Int32 $n) {
			$buffer = array();
			$length = Data\ArrayList::length($xs);

			for ($i = $n; Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$buffer[] = Data\ArrayList::element($xs, $i);
			}

			return new Data\ArrayList($buffer);
		}

		/**
		 * This method return the list from element where the predicate function fails.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\ArrayList                                   the list
		 */
		public static function dropWhile(Data\ArrayList $xs, callable $predicate) {
			$buffer = array();
			$length = Data\ArrayList::length($xs);

			$failed = false;
			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$x = Data\ArrayList::element($xs, $i);
				if (!$predicate($x, $i)->unbox() || $failed) {
					$buffer[] = $x;
					$failed = true;
				}
			}

			return new Data\ArrayList($buffer);
		}

		/**
		 * This method return the list from element where the predicate function doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\ArrayList                                   the list
		 */
		public static function dropWhileEnd(Data\ArrayList $xs, callable $predicate) {
			return Data\ArrayList::dropWhile($xs, function(Data\Type $x, Data\Int32 $i) use ($predicate) {
				return Data\Bool::not($predicate($x, $i));
			});
		}

		/**
		 * This method iterates over the elements in the list, yielding each element to the procedure
		 * function.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param callable $procedure                               the procedure function to be used
		 */
		public static function each(Data\ArrayList $xs, callable $procedure) {
			$length = Data\ArrayList::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$procedure(Data\ArrayList::element($xs, $i), $i);
			}
		}

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Int32 $i                                     the index of the element
		 * @return Data\Type                                        the element at the specified index
		 * @throws Throwable\OutOfBounds\Exception                  indicates the specified index
		 *                                                          cannot be found
		 */
		public static function element(Data\ArrayList $xs, Data\Int32 $i) {
			return $xs->value[$i->unbox()];
		}

		/**
		 * This method returns a list of those elements that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\ArrayList                                   the list
		 */
		public static function filter(Data\ArrayList $xs, callable $predicate) {
			$buffer = array();
			$length = Data\ArrayList::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$x = Data\ArrayList::element($xs, $i);
				if ($predicate($x, $i)->unbox()) {
					$buffer[] = $x;
				}
			}

			return new Data\ArrayList($buffer);
		}

		/**
		 * This method returns the first object in the collection that passes the truthy test, if any.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Option                                      an option containing the first object
		 *                                                          satisfying the predicate, if any
		 */
		public static function find(Data\ArrayList $xs, callable $predicate) {
			$length = Data\ArrayList::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$x = Data\ArrayList::element($xs, $i);
				if ($predicate($x, $i)->unbox()) {
					return Data\Option::some($x);
				}
			}

			return Data\Option::none();
		}

		/**
		 * This method returns the array list flattened.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\ArrayList                                   the flattened array list
		 */
		public static function flatten(Data\ArrayList $xs) {
			$buffer = array();
			$x_length = Data\ArrayList::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $x_length)->unbox(); $i = Data\Int32::increment($i)) {
				$x = Data\ArrayList::element($xs, $i);
				if ($x instanceof Data\ArrayList) {
					$ys = Data\ArrayList::flatten($x);
					$y_length = Data\ArrayList::length($ys);
					for ($j = Data\Int32::zero(); Data\Int32::lt($j, $y_length)->unbox(); $j = Data\Int32::increment($j)) {
						$buffer[] = Data\ArrayList::element($ys, $j);
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
		 * @param Data\ArrayList $xs                                the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param Data\Type $initial                                the initial value to be used
		 * @return Data\Type                                        the result
		 */
		public static function foldLeft(Data\ArrayList $xs, callable $operator, Data\Type $initial) {
			$z = $initial;
			$length = Data\ArrayList::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$z = $operator($z, Data\ArrayList::element($xs, $i));
			}

			return $z;
		}

		/**
		 * This method applies a right-fold reduction on the list using the operation function.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param Data\Type $initial                                the initial value to be used
		 * @return Data\Type                                        the result
		 */
		public static function foldRight(Data\ArrayList $xs, callable $operator, Data\Type $initial) {
			$z = $initial;
			$length = Data\ArrayList::length($xs);

			for ($i = Data\Int32::decrement($length); Data\Int32::ge($i, Data\Int32::zero())->unbox(); $i = Data\Int32::decrement($length)) {
				$z = $operator($z, Data\ArrayList::element($xs, $i));
			}

			return $z;
		}

		/**
		 * This method returns the head object in this list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Type                                        the head object in this list
		 */
		public static function head(Data\ArrayList $xs) {
			return Data\ArrayList::element($xs, Data\Int32::zero());
		}

		/**
		 * This method returns an option using the head for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Option                                      the option
		 */
		public static function headOption(Data\ArrayList $xs) {
			return (!Data\ArrayList::isEmpty($xs)->unbox()) ? Data\Option::some(Data\ArrayList::head($xs)) : Data\Option::none();
		}

		/**
		 * This method return the index of the first occurrence of the object; otherwise, it returns -1;
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Type $y                                      the object to be searched for
		 * @return Data\Int32                                       the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public static function indexOf(Data\ArrayList $xs, Data\Type $y) {
			$length = Data\ArrayList::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$x = Data\ArrayList::element($xs, $i);
				if (call_user_func_array(array(get_class($x), 'eq'), array($x, $y))->unbox()) {
					return $i;
				}
			}

			return Data\Int32::negative();
		}

		/**
		 * This method returns all but the last element of in the list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\ArrayList                                   the list, minus the last
		 *                                                          element
		 */
		public static function init(Data\ArrayList $xs) {
			$buffer = array();
			$length = Data\Int32::decrement(Data\ArrayList::length($xs));

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$buffer[] = Data\ArrayList::element($xs, $i);
			}

			return new Data\ArrayList($buffer);
		}

		/**
		 * The method intersperses the specified object between each element in the list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Type $y                                      the object to be interspersed
		 * @return Data\ArrayList                                   the list
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function intersperse(Data\ArrayList $xs, Data\Type $y) {
			$buffer = array();
			$length = Data\ArrayList::length($xs);

			if ($length > 0) {
				$buffer[] = Data\ArrayList::element($xs, Data\Int32::zero());
				for ($i = Data\Int32::one(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
					$buffer[] = $y;
					$buffer[] = Data\ArrayList::element($xs, $i);
				}
			}

			return new Data\ArrayList($buffer);
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Bool                                        whether the list is empty
		 */
		public static function isEmpty(Data\ArrayList $xs) {
			return Data\Int32::eq(Data\ArrayList::length($xs), Data\Int32::zero());
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\ArrayList\Iterator                          an iterator for this collection
		 */
		public static function iterator(Data\ArrayList $xs) {
			return new Data\ArrayList\Iterator($xs);
		}

		/**
		 * This method returns the last element in this list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Type                                        the last element in this linked
		 *                                                          list
		 */
		public static function last(Data\ArrayList $xs) {
			return Data\ArrayList::element($xs, Data\Int32::decrement(Data\ArrayList::length($xs)));
		}

		/**
		 * This method returns an option using the last for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Option                                      the option
		 */
		public static function lastOption(Data\ArrayList $xs) {
			return (!Data\ArrayList::isEmpty($xs)->unbox()) ? Data\Option::some(Data\ArrayList::last($xs)) : Data\Option::none();
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Int32                                       the length of this array list
		 */
		public static function length(Data\ArrayList $xs) {
			return Data\Int32::create(count($xs->unbox()));
		}

		/**
		 * This method applies each element in this list to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return Data\ArrayList                                   the list
		 */
		public static function map(Data\ArrayList $xs, callable $subroutine) {
			$buffer = array();
			$length = Data\ArrayList::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$buffer[] = $subroutine(Data\ArrayList::element($xs, $i), $i);
			}

			return new Data\ArrayList($buffer);
		}

		/**
		 * This method iterates over the elements in the list, yielding each element to the
		 * predicate function, or fails the falsy test.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether each element passed the
		 *                                                          falsy test
		 */
		public static function none(Data\ArrayList $xs, callable $predicate) {
			return Data\ArrayList::all($xs, function(Data\Type $x, Data\Int32 $i) use ($predicate) {
				return Data\Bool::not($predicate($x, $i));
			});
		}

		/**
		 * This method prepends the specified object to the front of this list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Type $y                                      the object to be prepended
		 * @return Data\ArrayList                                   the list
		 */
		public static function prepend(Data\ArrayList $xs, Data\Type $y) {
			$buffer = $xs->unbox();
			array_unshift($buffer, $y);
			return new Data\ArrayList($buffer);
		}

		/**
		 * This method returns the list within the specified range.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Int32 $start                                 the starting index
		 * @param Data\Int32 $end                                   the ending index
		 * @return Data\ArrayList                                   the list
		 */
		public static function range(Data\ArrayList $xs, Data\Int32 $start, Data\Int32 $end) {
			return Data\ArrayList::drop(Data\ArrayList::take($xs, $end), $start);
		}

		/**
		 * This method returns a list of those elements that don't satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\ArrayList                                   the list
		 */
		public static function remove(Data\ArrayList $xs, callable $predicate) {
			return Data\ArrayList::filter($xs, function(Data\Type $x, Data\Int32 $i) use ($predicate) {
				return Data\Bool::not($predicate($x, $i));
			});
		}

		/**
		 * This method reverses the order of the elements in this list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\ArrayList                                   the list
		 */
		public static function reverse(Data\ArrayList $xs) {
			return new Data\ArrayList(array_reverse($xs->unbox()));
		}

		/**
		 * This method returns the extracted slice of the list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Int32 $offset                                the starting index
		 * @param Data\Int32 $length                                the length of the slice
		 * @return Data\ArrayList                                   the list
		 */
		public static function slice(Data\ArrayList $xs, Data\Int32 $offset, Data\Int32 $length) {
			return new Data\ArrayList(array_slice($xs->unbox(), $offset->unbox(), $length->unbox()));
		}

		/**
		 * This method returns the tail of this list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\ArrayList                                   the tail of this list
		 */
		public static function tail(Data\ArrayList $xs) {
			$buffer = array();
			$length = Data\ArrayList::length($xs);

			for ($i = Data\Int32::one(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$buffer[] = Data\ArrayList::element($xs, $i);
			}

			return new Data\ArrayList($buffer);
		}

		/**
		 * This method returns the first "n" elements in the list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Int32 $n                                     the number of elements to take
		 * @return Data\ArrayList                                   the list
		 */
		public static function take(Data\ArrayList $xs, Data\Int32 $n) {
			$buffer = array();
			$length = Data\Int32::min($n, Data\ArrayList::length($xs));

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$buffer[] = Data\ArrayList::element($xs, $i);
			}

			return new Data\ArrayList($buffer);
		}

		/**
		 * This method returns each element in this list until the predicate fails.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\ArrayList                                   the list
		 */
		public static function takeWhile(Data\ArrayList $xs, callable $predicate) {
			$buffer = array();
			$length = Data\ArrayList::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$x = Data\ArrayList::element($xs, $i);
				if (!$predicate($x, $i)->unbox()) {
					break;
				}
				$buffer[] = $x;
			}

			return new Data\ArrayList($buffer);
		}

		/**
		 * This method returns each element in this list until the predicate doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\ArrayList                                   the list
		 */
		public static function takeWhileEnd(Data\ArrayList $xs, callable $predicate) {
			return Data\ArrayList::takeWhile($xs, function(Data\Type $x, Data\Int32 $i) use ($predicate) {
				return Data\Bool::not($predicate($x, $i));
			});
		}

		/**
		 * This method returns the collection as an array.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\ArrayList                                   the collection as an array list
		 */
		public static function toArray(Data\ArrayList $xs) {
			return $xs;
		}

		/**
		 * This method returns the collection as a linked list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\LinkedList                                  the collection as a linked list
		 */
		public static function toList(Data\ArrayList $xs) {
			$length = Data\ArrayList::length($xs);
			$zs = Data\LinkedList::nil();
			for ($i = Data\Int32::decrement($length); Data\Int32::ge($i, Data\Int32::zero())->unbox(); $i = Data\Int32::decrement($i)) {
				$zs = Data\LinkedList::prepend($zs, Data\ArrayList::element($xs, $i));
			}
			return $zs;
		}

		#endregion

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\ArrayList $ys                              the object to be compared
		 * @return Data\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(Data\ArrayList $xs, Data\ArrayList $ys) {
			if (($xs === null) && ($ys !== null)) {
				return Data\Int32::negative();
			}
			if (($xs === null) && ($ys === null)) {
				return Data\Int32::zero();
			}
			if (($xs !== null) && ($ys === null)) {
				return Data\Int32::one();
			}

			$x_length = Data\ArrayList::length($xs);
			$y_length = Data\ArrayList::length($ys);

			if ($x_length < $y_length) {
				return Data\Int32::negative();
			}
			else if ($x_length > $y_length) {
				return Data\Int32::one();
			}
			else { // ($x_length == $y_length)
				for ($i = Data\Int32::zero(); Data\Int32::lt($i, $x_length)->unbox(); $i = Data\Int32::increment($i)) {
					$x = Data\ArrayList::element($xs, $i);
					$y = Data\ArrayList::element($ys, $i);
					$r = call_user_func_array(array(get_class($x), 'compare'), array($x, $y));
					if ($r->unbox() != 0) {
						return $r;
					}
				}
				return Data\Int32::one();
			}
		}

		#region Methods -> Object Oriented -> Boolean Operations

		/**
		 * This method (aka "truthy") returns whether all of the elements of the list evaluate
		 * to true.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Bool                                        whether all of the elements of
		 *                                                          the list evaluate to true
		 */
		public static function and_(Data\ArrayList $xs) {
			return Data\ArrayList::truthy($xs);
		}

		/**
		 * This method (aka "falsy") returns whether all of the elements of the list evaluate
		 * to false.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Bool                                        whether all of the elements of
		 *                                                          the list evaluate to false
		 *
		 * @see http://www.sitepoint.com/javascript-truthy-falsy/
		 */
		public static function or_(Data\ArrayList $xs) {
			return Data\ArrayList::falsy($xs);
		}

		/**
		 * This method returns whether all of the elements of the list strictly evaluate to
		 * false.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Bool                                        whether all of the elements of
		 *                                                          the list strictly evaluate
		 *                                                          to false
		 */
		public static function false(Data\ArrayList $xs) {
			return Data\Bool::not(Data\ArrayList::true($xs));
		}

		/**
		 * This method (aka "or") returns whether all of the elements of the list evaluate to
		 * false.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Bool                                        whether all of the elements of
		 *                                                          the list evaluate to false
		 *
		 * @see http://www.sitepoint.com/javascript-truthy-falsy/
		 */
		public static function falsy(Data\ArrayList $xs) {
			return Data\Bool::not(Data\ArrayList::truthy($xs));
		}

		/**
		 * This method returns whether all of the elements of the list strictly evaluate
		 * to true.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Bool                                        whether all of the elements of
		 *                                                          the list strictly evaluate
		 *                                                          to true
		 */
		public static function true(Data\ArrayList $xs) {
			$length = Data\ArrayList::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				if (Data\Bool::ni(Data\Bool::true(), Data\ArrayList::element($xs, $i))->unbox()) {
					return Data\Bool::false();
				}
			}

			return Data\Bool::true();
		}

		/**
		 * This method (aka "and") returns whether all of the elements of the list evaluate to
		 * true.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Bool                                        whether all of the elements of
		 *                                                          the list evaluate to true
		 */
		public static function truthy(Data\ArrayList $xs) {
			$length = Data\ArrayList::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				if (!Data\ArrayList::element($xs, $i)->unbox()) {
					return Data\Bool::false();
				}
			}

			return Data\Bool::true();
		}

		#endregion

		#region Methods -> Object Oriented -> Numeric Operations

		/**
		 * This method returns the average of all elements in the list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Num                                         the result
		 */
		public static function average(Data\ArrayList $xs) {
			if (Data\ArrayList::isEmpty($xs)->unbox()) {
				return Data\Int32::zero();
			}

			$length = Data\ArrayList::length($xs);
			$x = Data\ArrayList::element($xs, Data\Int32::zero());
			$t = Data\Type::typeOf($x);
			$y = $t::zero();

			for ($i = Data\Int32::one(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$x = $x->add(Data\ArrayList::element($xs, $i));
				$y = $y->increment();
			}

			return $x->divide($y);
		}

		/**
		 * This method returns the product of all elements in the list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Num                                         the result
		 */
		public static function product(Data\ArrayList $xs) {
			if (Data\ArrayList::isEmpty($xs)->unbox()) {
				return Data\Int32::one();
			}

			$length = Data\ArrayList::length($xs);

			$x = Data\ArrayList::element($xs, Data\Int32::zero());
			$number = get_class($x);

			for ($i = Data\Int32::one(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$x = $number::multiply($x, Data\ArrayList::element($xs, $i));
			}

			return $x;
		}

		/**
		 * This method returns the sum of all elements in the list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Num                                         the result
		 */
		public static function sum(Data\ArrayList $xs) {
			if (Data\ArrayList::isEmpty($xs)->unbox()) {
				return Data\Int32::zero();
			}

			$length = Data\ArrayList::length($xs);

			$x = Data\ArrayList::element($xs, Data\Int32::zero());
			$number = get_class($x);

			for ($i = Data\Int32::one(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$x = $number::add($x, Data\ArrayList::element($xs, $i));
			}

			return $x;
		}

		#endregion

	}

}