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
			return new static($value);
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

			return new static($buffer);
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

		#region Methods -> Native Oriented

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return boolean                                          whether the list is empty
		 */
		public static function __isEmpty(Data\ArrayList $xs) {
			return ($this->__length() == 0);
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return integer                                          the length of this array list
		 */
		public static function __length(Data\ArrayList $xs) {
			return count($this->value);
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
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				if (!$predicate($this->value[$i], Data\Int32::create($i))->unbox()) {
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
			return $this->find($predicate)->isDefined();
		}

		/**
		 * This method appends the specified object to this object's list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Type $object                                  the object to be appended
		 * @return Data\ArrayList                                   the list
		 */
		public static function append(Data\Type $object) {
			$this->value[] = $object;
			return $this;
		}

		/**
		 * This method concatenates a list to this object's list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\ArrayList $that                              the list to be concatenated
		 * @return Data\ArrayList                                   the list
		 */
		public static function concat(Data\ArrayList $that) {
			foreach ($that->unbox() as $y) {
				$this->value[] = $y;
			}
			return $this;
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
		public static function contains(Data\Type $y) {
			return $this->any(function(Data\Type $x, Data\Int32 $i) use ($y) {
				return $x->equals($y);
			});
		}

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\ArrayList $that                              the object to be compared
		 * @return Data\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compareTo(Data\ArrayList $that) {
			$x_length = $this->__length();
			$y_length = $that->__length();

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
		 * This method remove the first occurrence that equals the specified object.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Type $object                                 the object to be removed
		 * @return Data\ArrayList                                   the list
		 */
		public static function delete(Data\Type $object) {
			$buffer = array();
			$skip = false;

			foreach ($this->value as $x) {
				if ($x->__equals($object) && !$skip) {
					$skip = true;
					continue;
				}
				$buffer[] = $x;
			}

			return new static($buffer);
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
		public static function drop(Data\Int32 $n) {
			$buffer = array();
			$length = $this->__length();

			for ($i = $n->unbox(); $i < $length; $i++) {
				$buffer[] = $this->value[$i];
			}

			return new static($buffer);
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
			$length = $this->__length();

			$failed = false;
			for ($i = 0; $i < $length; $i++) {
				if (!$predicate($this->value[$i], Data\Int32::create($i))->unbox() || $failed) {
					$buffer[] = $this->value[$i];
					$failed = true;
				}
			}

			return new static($buffer);
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
			return $this->dropWhile(function(Data\Type $object, Data\Int32 $index) use ($predicate) {
				return $predicate($object, $index)->not();
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
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$procedure($this->value[$i], Data\Int32::create($i));
			}
		}

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Int32 $index                                 the index of the element
		 * @return Data\Type                                         the element at the specified index
		 * @throws Throwable\OutOfBounds\Exception                  indicates the specified index
		 *                                                          cannot be found
		 */
		public static function element(Data\Int32 $index) {
			$i = $index->unbox();

			if (($i < 0) || ($i >= $this->length())) {
				throw new Throwable\OutOfBounds\Exception('Unable to return element at index :index.', array(':index' => $i));
			}

			return $this->value[$i];
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
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$x = $this->value[$i];
				if ($predicate($x, Data\Int32::create($i))->unbox()) {
					$buffer[] = $x;
				}
			}

			return new static($buffer);
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
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$x = $this->value[$i];
				if ($predicate($x, Data\Int32::create($i))->unbox()) {
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
		 * @return Data\ArrayList                                  the flattened array list
		 */
		public static function flatten(Data\ArrayList $xs) {
			$array = array();

			$xs = $this;
			$x_length = $xs->__length();

			for ($i = 0; $i < $x_length; $i++) {
				$x = $xs->element($i);
				if ($x instanceof Data\Collection) {
					$ys = $x->flatten()->toArray();
					$y_length = $ys->__length();
					for ($j = 0; $j < $y_length; $j++) {
						$array[] = $ys->element($j);
					}
				}
				else {
					$array[] = $x;
				}
			}

			return $array;
		}

		/**
		 * This method applies a left-fold reduction on the list using the operator function.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param Data\Type $initial                                 the initial value to be used
		 * @return Data\Type                                         the result
		 */
		public static function foldLeft(Data\ArrayList $xs, callable $operator, Data\Type $initial) {
			$z = $initial;
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$z = $operator($z, $this->value[$i]);
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
		 * @param Data\Type $initial                                 the initial value to be used
		 * @return Data\Type                                         the result
		 */
		public static function foldRight(Data\ArrayList $xs, callable $operator, Data\Type $initial) {
			$z = $initial;
			$length = $this->__length();

			for ($i = $length - 1; $i >= 0; $i--) {
				$z = $operator($z, $this->value[$i]);
			}

			return $z;
		}

		/**
		 * This method returns the head object in this list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Type                                         the head object in this list
		 */
		public static function head(Data\ArrayList $xs) {
			return $this->value[0];
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
			return (!$this->__isEmpty()) ? Data\Option::some($this->head()) : Data\Option::none();
		}

		/**
		 * This method return the index of the first occurrence of the object; otherwise, it returns -1;
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Type $object                                 the object to be searched for
		 * @return Data\Int32                                       the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public static function indexOf(Data\Type $object) {
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				if ($object->__equals($this->value[$i])) {
					return Data\Int32::create($i);
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
			$length = $this->__length() - 1;

			for ($i = 0; $i < $length; $i++) {
				$buffer[] = $this->value[$i];
			}

			return new static($buffer);
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
			return new Data\ArrayList\Iterator($this);
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
			return Data\Bool::create($this->__isEmpty());
		}

		/**
		 * The method intersperses the specified object between each element in the list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Type $object                                  the object to be interspersed
		 * @return Data\ArrayList                                   the list
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function intersperse(Data\Type $object) {
			$buffer = array();
			$length = $this->__length();

			if ($length > 0) {
				$x = $this->value[0];

				$class = get_class($x);
				if ($object instanceof $class) {
					throw new Throwable\InvalidArgument\Exception('Unable to create array list. Expected type ":class", but got ":type".', array(':class' => $class, ':type' => get_class($object)));
				}

				$buffer[] = $x;
				for ($i = 1; $i < $length; $i++) {
					$buffer[] = $this->value[$i];
				}
			}

			return new static($buffer);
		}

		/**
		 * This method returns the last element in this list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @return Data\Type                                         the last element in this linked
		 *                                                          list
		 */
		public static function last(Data\ArrayList $xs) {
			return $this->value[$this->__length() - 1];
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
			return (!$this->__isEmpty()) ? Data\Option::some($this->last()) : Data\Option::none();
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
			return Data\Int32::create($this->__length());
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
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$buffer[] = $subroutine($this->value[$i], Data\Int32::create($i));
			}

			return new static($buffer);
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
			return $this->all(function(Data\Type $object, Data\Int32 $index) use ($predicate) {
				return $predicate($object, $index)->not();
			});
		}

		/**
		 * This method prepends the specified object to the front of this list.
		 *
		 * @access public
		 * @static
		 * @param Data\ArrayList $xs                                the left operand
		 * @param Data\Type $object                                  the object to be prepended
		 * @return Data\ArrayList                                   the list
		 */
		public static function prepend(Data\Type $object) {
			array_unshift($this->value, $object);
			return $this;
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
		public static function range(Data\Int32 $start, Data\Int32 $end) {
			return $this->take($end)->drop($start);
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
			return $this->filter(function(Data\Type $object, Data\Int32 $index) use ($predicate) {
				return $predicate($object, $index)->not();
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
			return new static(array_reverse($this->value));
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
		public static function slice(Data\Int32 $offset, Data\Int32 $length) {
			return new static(array_slice($this->value, $offset->unbox(), $length->unbox()));
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
			$length = $this->__length();

			for ($i = 1; $i < $length; $i++) {
				$buffer[] = $this->value[$i];
			}

			return new static($buffer);
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
		public static function take(Data\Int32 $n) {
			$buffer = array();
			$length = min($n->unbox(), $this->__length());

			for ($i = 0; $i < $length; $i++) {
				$buffer[] = $this->value[$i];
			}

			return new static($buffer);
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
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$x = $this->value[$i];
				if (!$predicate($x, Data\Int32::create($i))->unbox()) {
					break;
				}
				$buffer[] = $x;
			}

			return new static($buffer);
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
			return $this->takeWhile(function(Data\Type $object, Data\Int32 $index) use ($predicate) {
				return $predicate($object, $index)->not();
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
			return $this;
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
			$list = Data\LinkedList::nil();

			for ($i = $this->__length() - 1; $i >= 0; $i--) {
				$list = $list->prepend($this->value[$i]);
			}

			return $list;
		}

		#endregion

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
			return $this->truthy();
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
			return $this->falsy();
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
			return $this->true()->not();
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
			return $this->truthy()->not();
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
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				if ($this->value[$i]->unbox() !== true) {
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
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				if (!$this->value[$i]->unbox()) {
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
			if ($this->__isEmpty()) {
				return Data\Int32::zero();
			}

			$length = $this->__length();
			$x = $this->value[0];
			$t = $x->__typeOf();
			$y = $t::zero();

			for ($i = 1; $i < $length; $i++) {
				$x = $x->add($this->value[$i]);
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
			if ($this->__isEmpty()) {
				return Data\Int32::one();
			}

			$length = $this->__length();
			$x = $this->value[0];

			for ($i = 1; $i < $length; $i++) {
				$x = $x->multiply($this->value[$i]);
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
			if ($this->__isEmpty()) {
				return Data\Int32::zero();
			}

			$length = $this->__length();
			$x = $this->value[0];

			for ($i = 1; $i < $length; $i++) {
				$x = $x->add($this->value[$i]);
			}

			return $x;
		}

		#endregion

	}

}