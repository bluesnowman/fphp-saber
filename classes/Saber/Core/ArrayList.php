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

namespace Saber\Core {

	use \Saber\Core;
	use \Saber\Throwable;

	class ArrayList extends Core\Collection {

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
			if (($value === null) || !is_array($value)) {
				$type = gettype($value);
				if ($type == 'object') {
					$type = get_class($value);
				}
				throw new Throwable\InvalidArgument\Exception('Unable to create array list. Expected an array, but got ":type".', array(':type' => $type));
			}
			foreach ($value as $object) {
				if (!(is_object($object) && ($object instanceof Core\Any))) {
					$type = gettype($value);
					if ($type == 'object') {
						$type = get_class($value);
					}
					throw new Throwable\InvalidArgument\Exception('Unable to create array list. Expected a boxed value, but got ":type".', array(':type' => $type));
				}
			}
			return new Core\ArrayList($value);
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
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @param integer $depth                                    how many levels to unbox
		 * @return array                                            the un-boxed value
		 */
		public function unbox($depth = 0) {
			if ($depth > 0) {
				$buffer = array();

				foreach ($this->value as $value) {
					$buffer[] = $value->unbox($depth - 1);
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
		 * @return Core\Bool                                        whether the list is empty
		 */
		public function __isEmpty() {
			return ($this->__length() == 0);
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @return integer                                          the length of this array list
		 */
		public function __length() {
			return count($this->value);
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method appends the specified object to this object's list.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be appended
		 * @return Core\ArrayList                                   the list
		 */
		public function append(Core\Any $object) {
			$this->value[] = $object;
			return $this;
		}

		/**
		 * This method concatenates a list to this object's list.
		 *
		 * @access public
		 * @param Core\ArrayList $that                              the list to be concatenated
		 * @return Core\ArrayList                                   the list
		 */
		public function concat(Core\ArrayList $that) {
			foreach ($that->unbox() as $value) {
				$this->value[] = $value;
			}
			return $this;
		}

		/**
		 * This method evaluates whether the specified object is contained within the list.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to find
		 * @return Core\Bool                                        whether the specified object is
		 *                                                          contained within the list
		 */
		public function contains(Core\Any $object) {
			return $this->some(function(Core\Any $element, Core\Int32 $index) use ($object) {
				return $element->equals($object);
			});
		}

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @param Core\ArrayList $that                              the object to be compared
		 * @return Core\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public function compareTo(Core\ArrayList $that) {
			$x_length = $this->__length();
			$y_length = $that->__length();

			for ($i = 0; $i < $x_length && $i < $y_length; $i++) {
				$r = $this->value[$i]->compareTo($that->value[$i]);
				if ($r->unbox() != 0) {
					return $r;
				}
			}

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
		 * This method remove the first occurrence that equals the specified object.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be removed
		 * @return Core\ArrayList                                   the list
		 */
		public function delete(Core\Any $object) {
			$buffer = array();
			$skip = false;

			foreach ($this->value as $value) {
				if ($value->__equals($object) && !$skip) {
					$skip = true;
					continue;
				}
				$buffer[] = $value;
			}

			return new static($buffer);
		}

		/**
		 * This method returns the list after dropping the first "n" elements.
		 *
		 * @access public
		 * @param Core\Int32 $n                                     the number of elements to drop
		 * @return Core\ArrayList                                   the list
		 */
		public function drop(Core\Int32 $n) {
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
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\ArrayList                                   the list
		 */
		public function dropWhile(callable $predicate) {
			$buffer = array();
			$length = $this->__length();

			$failed = false;
			for ($i = 0; $i < $length; $i++) {
				if (!$predicate($this->value[$i], Core\Int32::box($i))->unbox() || $failed) {
					$buffer[] = $this->value[$i];
					$failed = true;
				}
			}

			return new static($buffer);
		}

		/**
		 * This method return the list from element where the predicate function doesn't fail.
		 *
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\ArrayList                                   the list
		 */
		public function dropWhileEnd(callable $predicate) {
			return $this->dropWhile(function(Core\Any $object, Core\Int32 $index) use ($predicate) {
				return $predicate($object, $index)->not();
			});
		}

		/**
		 * This method iterates over the elements in the list, yielding each element to the procedure
		 * function.
		 *
		 * @access public
		 * @param callable $procedure                               the procedure function to be used
		 */
		public function each(callable $procedure) {
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$procedure($this->value[$i], Core\Int32::box($i));
			}
		}

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @param Core\Int32 $index                                 the index of the element
		 * @return Core\Any                                         the element at the specified index
		 * @throws Throwable\OutOfBounds\Exception                  indicates the specified index
		 *                                                          cannot be found
		 */
		public function element(Core\Int32 $index) {
			$i = $index->unbox();

			if (($i < 0) || ($i >= $this->length())) {
				throw new Throwable\OutOfBounds\Exception('Unable to return element at index :index.', array(':index' => $i));
			}

			return $this->value[$i];
		}

		/**
		 * This method (aka "all" or "forall") iterates over the elements in the list, yielding each
		 * element to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\Bool                                        whether each element passed the
		 *                                                          truthy test
		 */
		public function every(callable $predicate) { // aka "all" or "forall"
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				if (!$predicate($this->value[$i], Core\Int32::box($i))->unbox()) {
					return Core\Bool::false();
				}
			}

			return Core\Bool::true(); // yes, empty list returns "true"
		}

		/**
		 * This method returns a list of those elements that satisfy the predicate.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\ArrayList                                   the list
		 */
		public function filter(callable $predicate) {
			$buffer = array();
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$value = $this->value[$i];
				if ($predicate($value, Core\Int32::box($i))->unbox()) {
					$buffer[] = $value;
				}
			}

			return new static($buffer);
		}

		/**
		 * This method returns the first object in the list that passes the truthy test.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\Any                                         the first element
		 * @throws Throwable\EmptyCollection\Exception              indicates that the collection is empty
		 */
		public function first(callable $predicate) {
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$value = $this->value[$i];
				if ($predicate($value, Core\Int32::box($i))->unbox()) {
					return $value;
				}
			}

			throw new Throwable\EmptyCollection\Exception('Unable to return first object. Linked list is empty.');
		}

		/**
		 * This method applies a left-fold reduction on the list using the operator function.
		 *
		 * @access public
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Any $initial                                 the initial value to be used
		 * @return Core\Any                                         the result
		 */
		public function foldLeft(callable $operator, Core\Any $initial) {
			$x = $initial;
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$x = $operator($x, $this->value[$i]);
			}

			return $x;
		}

		/**
		 * This method applies a right-fold reduction on the list using the operation function.
		 *
		 * @access public
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Any $initial                                 the initial value to be used
		 * @return Core\Any                                         the result
		 */
		public function foldRight(callable $operator, Core\Any $initial) {
			$x = $initial;
			$length = $this->__length();

			for ($i = $length - 1; $i >= 0; $i--) {
				$x = $operator($x, $this->value[$i]);
			}

			return $x;
		}

		/**
		 * This method returns the head object in this list.
		 *
		 * @access public
		 * @return Core\Any                                         the head object in this list
		 */
		public function head() {
			return $this->value[0];
		}

		/**
		 * This method return the index of the first occurrence of the object; otherwise, it returns -1;
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be searched for
		 * @return Core\Int32                                       the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public function indexOf(Core\Any $object) {
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				if ($object->__equals($this->value[$i])) {
					return Core\Int32::box($i);
				}
			}

			return Core\Int32::negative();
		}

		/**
		 * This method returns all but the last element of in the list.
		 *
		 * @access public
		 * @return Core\ArrayList                                   the list, minus the last
		 *                                                          element
		 */
		public function init() {
			$buffer = array();
			$length = $this->__length() - 1;

			for ($i = 0; $i < $length; $i++) {
				$buffer[] = $this->value[$i];
			}

			return new static($buffer);
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @final
		 * @return Core\Bool                                        whether the list is empty
		 */
		public final function isEmpty() {
			return Core\Bool::box($this->__isEmpty());
		}

		/**
		 * The method intersperses the specified object between each element in the list.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be interspersed
		 * @return Core\ArrayList                                   the list
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public function intersperse(Core\Any $object) {
			$buffer = array();
			$length = $this->__length();

			if ($length > 0) {
				$value = $this->value[0];

				$class = get_class($value);
				if ($object instanceof $class) {
					throw new Throwable\InvalidArgument\Exception('Unable to create array list. Expected type ":class", but got ":type".', array(':class' => $class, ':type' => get_class($object)));
				}

				$buffer[] = $value;
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
		 * @return Core\Any                                         the last element in this linked
		 *                                                          list
		 */
		public function last() {
			return $this->value[$this->__length() - 1];
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @final
		 * @return Core\Int32                                       the length of this array list
		 */
		public final function length() {
			return Core\Int32::box($this->__length());
		}

		/**
		 * This method applies each element in this list to the subroutine function.
		 *
		 * @access public
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return Core\ArrayList                                   the list
		 */
		public function map(callable $subroutine) {
			$buffer = array();
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$buffer[] = $subroutine($this->value[$i], Core\Int32::box($i));
			}

			return new static($buffer);
		}

		/**
		 * This method iterates over the elements in the list, yielding each element to the
		 * predicate function, or fails the falsy test.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\Bool                                        whether each element passed the
		 *                                                          falsy test
		 */
		public function none(callable $predicate) {
			return $this->every(function(Core\Any $object, Core\Int32 $index) use ($predicate) {
				return $predicate($object, $index)->not();
			});
		}

		/**
		 * This method prepends the specified object to the front of this list.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be prepended
		 * @return Core\ArrayList                                   the list
		 */
		public function prepend(Core\Any $object) {
			array_unshift($this->value, $object);
			return $this;
		}

		/**
		 * This method returns the list within the specified range.
		 *
		 * @access public
		 * @param Core\Int32 $start                                 the starting index
		 * @param Core\Int32 $end                                   the ending index
		 * @return Core\ArrayList                                   the list
		 */
		public function range(Core\Int32 $start, Core\Int32 $end) {
			return $this->take($end)->drop($start);
		}

		/**
		 * This method returns a list of those elements that don't satisfy the predicate.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\ArrayList                                   the list
		 */
		public function remove(callable $predicate) {
			return $this->filter(function(Core\Any $object, Core\Int32 $index) use ($predicate) {
				return $predicate($object, $index)->not();
			});
		}

		/**
		 * This method reverses the order of the elements in this list.
		 *
		 * @access public
		 * @return Core\ArrayList                                   the list
		 */
		public function reverse() {
			return new static(array_reverse($this->value));
		}

		/**
		 * This method returns the extracted slice of the list.
		 *
		 * @access public
		 * @param Core\Int32 $offset                                the starting index
		 * @param Core\Int32 $length                                the length of the slice
		 * @return Core\ArrayList                                   the list
		 */
		public function slice(Core\Int32 $offset, Core\Int32 $length) {
			return new static(array_slice($this->value, $offset->unbox(), $length->unbox()));
		}

		/**
		 * This method (aka "any") returns whether some of the elements in the list passed the truthy
		 * test.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\Bool                                        whether some of the elements
		 *                                                          passed the truthy test
		 */
		public function some($predicate) {
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				if ($predicate($this->value[$i], Core\Int32::box($i))->unbox()) {
					return Core\Bool::true();
				}
			}

			return Core\Bool::false();
		}

		/**
		 * This method returns the tail of this list.
		 *
		 * @access public
		 * @return Core\ArrayList                                   the tail of this list
		 */
		public function tail() {
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
		 * @param Core\Int32 $n                                     the number of elements to take
		 * @return Core\ArrayList                                   the list
		 */
		public function take(Core\Int32 $n) {
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
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\ArrayList                                   the list
		 */
		public function takeWhile(callable $predicate) {
			$buffer = array();
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$value = $this->value[$i];
				if (!$predicate($value, Core\Int32::box($i))->unbox()) {
					break;
				}
				$buffer[] = $value;
			}

			return new static($buffer);
		}

		/**
		 * This method returns each element in this list until the predicate doesn't fail.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Core\ArrayList                                   the list
		 */
		public function takeWhileEnd(callable $predicate) {
			return $this->takeWhile(function(Core\Any $object, Core\Int32 $index) use ($predicate) {
				return $predicate($object, $index)->not();
			});
		}

		#endregion

		#region Methods -> Object Oriented -> Boolean Operations

		/**
		 * This method (aka "truthy") returns whether all of the elements of the list evaluate
		 * to true.
		 *
		 * @access public
		 * @return Core\Bool                                        whether all of the elements of
		 *                                                          the list evaluate to true
		 */
		public function and_() {
			return $this->truthy();
		}

		/**
		 * This method (aka "falsy") returns whether all of the elements of the list evaluate
		 * to false.
		 *
		 * @access public
		 * @return Core\Bool                                        whether all of the elements of
		 *                                                          the list evaluate to false
		 *
		 * @see http://www.sitepoint.com/javascript-truthy-falsy/
		 */
		public function or_() {
			return $this->falsy();
		}

		/**
		 * This method returns whether all of the elements of the list strictly evaluate to
		 * false.
		 *
		 * @access public
		 * @return Core\Bool                                        whether all of the elements of
		 *                                                          the list strictly evaluate
		 *                                                          to false
		 */
		public function false() {
			return $this->true()->not();
		}

		/**
		 * This method (aka "or") returns whether all of the elements of the list evaluate to
		 * false.
		 *
		 * @access public
		 * @return Core\Bool                                        whether all of the elements of
		 *                                                          the list evaluate to false
		 *
		 * @see http://www.sitepoint.com/javascript-truthy-falsy/
		 */
		public function falsy() {
			return $this->truthy()->not();
		}

		/**
		 * This method returns whether all of the elements of the list strictly evaluate
		 * to true.
		 *
		 * @access public
		 * @return Core\Bool                                        whether all of the elements of
		 *                                                          the list strictly evaluate
		 *                                                          to true
		 */
		public function true() {
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				if ($this->value[$i]->unbox() !== true) {
					return Core\Bool::false();
				}
			}

			return Core\Bool::true();
		}

		/**
		 * This method (aka "and") returns whether all of the elements of the list evaluate to
		 * true.
		 *
		 * @access public
		 * @return Core\Bool                                        whether all of the elements of
		 *                                                          the list evaluate to true
		 */
		public function truthy() {
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				if (!$this->value[$i]->unbox()) {
					return Core\Bool::false();
				}
			}

			return Core\Bool::true();
		}

		#endregion

		#region Methods -> Object Oriented -> Numeric Operations

		/**
		 * This method returns the average of all elements in the list.
		 *
		 * @access public
		 * @return Core\Num                                         the result
		 */
		public function average() {
			if ($this->__isEmpty()) {
				return Core\Int32::zero();
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
		 * @return Core\Num                                         the result
		 */
		public function product() {
			if ($this->__isEmpty()) {
				return Core\Int32::one();
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
		 * @return Core\Num                                         the result
		 */
		public function sum() {
			if ($this->__isEmpty()) {
				return Core\Int32::zero();
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