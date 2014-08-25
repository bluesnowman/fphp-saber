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

	include_once(implode(DIRECTORY_SEPARATOR, array(dirname(__FILE__), '..', 'Extension', 'mbstring.php')));

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Throwable;

	class String extends Data\Collection {

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
			//$encoding = (func_num_args() > 1) ? func_get_arg(1) : 'UTF-8';
			if (!is_string($value)) {
				$type = gettype($value);
				if ($type == 'object') {
					$type = get_class($value);
				}
				throw new Throwable\InvalidArgument\Exception('Unable to box value. Expected a string, but got ":type".', array(':type' => $type));
			}
			return new static($value);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Core\Any                                         the boxed object
		 */
		public static function create($value/*...*/) {
			return new static($value);
		}

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param string $value                                     the value to be assigned
		 */
		public function __construct($value) {
			$this->value = (string) $value;
		}

		/**
		 * This method creates a string of "n" length with every element set to the given object.
		 *
		 * @access public
		 * @param Int32 $n                                          the number of times to replicate
		 * @param Core\Any $y                                       the object to be replicated
		 * @return Data\String                                      the string
		 */
		public static function replicate(Data\Int32 $n, Core\Any $y) {
			$buffer = '';
			$length = $n->unbox();

			for ($i = 0; $i < $length; $i++) {
				$buffer .= $y->__toString();
			}

			return new static($buffer);
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method (aka "null") returns whether this string is empty.
		 *
		 * @access public
		 * @return boolean                                          whether the string is empty
		 */
		public function __isEmpty() {
			return ($this->__length() == 0);
		}

		/**
		 * This method returns the length of this string.
		 *
		 * @access public
		 * @return integer                                          the length of this string
		 */
		public function __length() {
			return mb_strlen($this->unbox(), Data\Char::UTF_8_ENCODING);
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method (aka "every" or "forall") iterates over the elements in the string, yielding each
		 * element to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether each element passed the
		 *                                                          truthy test
		 */
		public function all(callable $predicate) {
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$x = mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING);
				if (!$predicate(Data\Char::create($x), Data\Int32::create($i))->unbox()) {
					return Data\Bool::false();
				}
			}

			return Data\Bool::true(); // yes, an empty string returns "true"
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the elements in the string
		 * passed the truthy test.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether some of the elements
		 *                                                          passed the truthy test
		 */
		public function any($predicate) {
			return $this->find($predicate)->isDefined();
		}

		/**
		 * This method appends the specified object to this object's string.
		 *
		 * @access public
		 * @param Data\Char $char                                   the object to be appended
		 * @return Data\String                                      the string
		 */
		public function append(Data\Char $char) {
			$this->value .= $char->unbox();
			return $this;
		}

		/**
		 * This method concatenates a string to this object's string.
		 *
		 * @access public
		 * @param Data\String $that                                 the string to be concatenated
		 * @return Data\String                                      the string
		 */
		public function concat(Data\String $that) {
			$this->value .= $that->unbox();
			return $this;
		}

		/**
		 * This method evaluates whether the specified object is contained within the string.
		 *
		 * @access public
		 * @param Core\Any $y                                       the object to find
		 * @return Data\Bool                                        whether the specified object is
		 *                                                          contained within the string
		 */
		public function contains(Core\Any $y) {
			return $this->any(function(Core\Any $x, Data\Int32 $i) use ($y) {
				return $x->equals($y);
			});
		}

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @param Data\String $that                                 the object to be compared
		 * @return Data\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public function compareTo(Data\String $that) {
			$x_length = $this->__length();
			$y_length = $that->__length();

			for ($i = 0; $i < $x_length && $i < $y_length; $i++) {
				$x = Data\Char::create(mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING));
				$y = Data\Char::create(mb_substr($that->unbox(), $i, 1, Data\Char::UTF_8_ENCODING));
				$r = $x->compareTo($y);
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
		 * @param Core\Any $y                                       the object to be removed
		 * @return Data\String                                      the string
		 */
		public function delete(Core\Any $y) {
			$buffer = '';
			$length = $this->__length();
			$skip = false;

			for ($i = 0; $i < $length; $i++) {
				$x = Data\Char::create(mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING));
				if ($x->__equals($y) && !$skip) {
					$skip = true;
					continue;
				}
				$buffer .= $x->unbox();
			}

			return new static($buffer);
		}

		/**
		 * This method returns the string after dropping the first "n" elements.
		 *
		 * @access public
		 * @param Data\Int32 $n                                     the number of elements to drop
		 * @return Data\String                                      the string
		 */
		public function drop(Data\Int32 $n) {
			$buffer = '';
			$length = $this->__length();

			for ($i = $n->unbox(); $i < $length; $i++) {
				$buffer .= mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING);
			}

			return new static($buffer);
		}

		/**
		 * This method return the string from element where the predicate function fails.
		 *
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\String                                      the string
		 */
		public function dropWhile(callable $predicate) {
			$buffer = '';
			$length = $this->__length();

			$failed = false;
			for ($i = 0; $i < $length; $i++) {
				$x = mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING);
				if (!$predicate(Data\Char::create($x), Data\Int32::create($i))->unbox() || $failed) {
					$buffer .= $x;
					$failed = true;
				}
			}

			return new static($buffer);
		}

		/**
		 * This method return the string from element where the predicate function doesn't fail.
		 *
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\String                                      the string
		 */
		public function dropWhileEnd(callable $predicate) {
			return $this->dropWhile(function(Core\Any $x, Data\Int32 $i) use ($predicate) {
				return $predicate($x, $i)->not();
			});
		}

		/**
		 * This method iterates over the elements in the string, yielding each element to the procedure
		 * function.
		 *
		 * @access public
		 * @param callable $procedure                               the procedure function to be used
		 */
		public function each(callable $procedure) {
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$procedure(Data\Char::create(mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING)), Data\Int32::create($i));
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

			if (($i < 0) || ($i >= $this->__length())) {
				throw new Throwable\OutOfBounds\Exception('Unable to return element at index :index.', array(':index' => $i));
			}

			return Data\Char::create(mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING));
		}

		/**
		 * This method returns a string of those elements that satisfy the predicate.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\String                                      the string
		 */
		public function filter(callable $predicate) {
			$buffer = '';
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$x = mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING);
				if ($predicate(Data\Char::create($x), Data\Int32::create($i))->unbox()) {
					$buffer .= $x;
				}
			}

			return new static($buffer);
		}

		/**
		 * This method returns the first object in the collection that passes the truthy test, if any.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Option                                      an option containing the first object
		 *                                                          satisfying the predicate, if any
		 */
		public function find(callable $predicate) {
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$x = Data\Char::create(mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING));
				if ($predicate($x, Data\Int32::create($i))->unbox()) {
					return Data\Option::some($x);
				}
			}

			return Data\Option::none();
		}

		/**
		 * This method applies a left-fold reduction on the string using the operator function.
		 *
		 * @access public
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Any $initial                                 the initial value to be used
		 * @return Core\Any                                         the result
		 */
		public function foldLeft(callable $operator, Core\Any $initial) {
			$z = $initial;
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$z = $operator($z, Data\Char::create(mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING)));
			}

			return $z;
		}

		/**
		 * This method applies a right-fold reduction on the string using the operation function.
		 *
		 * @access public
		 * @param callable $operator                                the operator function to be used
		 * @param Core\Any $initial                                 the initial value to be used
		 * @return Core\Any                                         the result
		 */
		public function foldRight(callable $operator, Core\Any $initial) {
			$z = $initial;
			$length = $this->__length();

			for ($i = $length - 1; $i >= 0; $i--) {
				$z = $operator($z, Data\Char::create(mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING)));
			}

			return $z;
		}

		/**
		 * This method returns the head object in this string.
		 *
		 * @access public
		 * @return Core\Any                                         the head object in this string
		 */
		public function head() {
			return Data\Char::create(mb_substr($this->unbox(), 0, 1, Data\Char::UTF_8_ENCODING));
		}

		/**
		 * This method returns an option using the head for the boxed object.
		 *
		 * @access public
		 * @return Data\Option                                      the option
		 */
		public function headOption() {
			return (!$this->__isEmpty()) ? Data\Option::some($this->head()) : Data\Option::none();
		}

		/**
		 * This method return the index of the first occurrence of the object; otherwise, it returns -1;
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be searched for
		 * @return Data\Int32                                       the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public function indexOf(Core\Any $object) {
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$x = Data\Char::create(mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING));
				if ($x->__equals($object)) {
					return Data\Int32::create($i);
				}
			}

			return Data\Int32::negative();
		}

		/**
		 * This method returns all but the last element of in the string.
		 *
		 * @access public
		 * @return Data\String                                      the string, minus the last
		 *                                                          element
		 */
		public function init() {
			$buffer = '';
			$length = $this->__length() - 1;

			for ($i = 0; $i < $length; $i++) {
				$buffer .= mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING);
			}

			return new static($buffer);
		}

		/**
		 * This method (aka "null") returns whether this string is empty.
		 *
		 * @access public
		 * @final
		 * @return Data\Bool                                        whether the string is empty
		 */
		public final function isEmpty() {
			return Data\Bool::create($this->__isEmpty());
		}

		/**
		 * The method intersperses the specified object between each element in the string.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be interspersed
		 * @return Data\String                                      the string
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public function intersperse(Core\Any $object) {
			$buffer = '';
			$length = $this->__length();

			if ($length > 0) {
				$buffer .= mb_substr($this->unbox(), 0, 1, Data\Char::UTF_8_ENCODING);
				for ($i = 1; $i < $length; $i++) {
					$buffer .= $object->__toString();
					$buffer .= mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING);
				}
			}

			return new static($buffer);
		}

		/**
		 * This method returns the last element in this string.
		 *
		 * @access public
		 * @return Core\Any                                         the last element in this linked
		 *                                                          string
		 */
		public function last() {
			return Data\Char::create(mb_substr($this->unbox(), $this->__length() - 1, 1, Data\Char::UTF_8_ENCODING));
		}

		/**
		 * This method returns an option using the last for the boxed object.
		 *
		 * @access public
		 * @return Data\Option                                      the option
		 */
		public function lastOption() {
			return (!$this->__isEmpty()) ? Data\Option::some($this->last()) : Data\Option::none();
		}

		/**
		 * This method returns the length of this string.
		 *
		 * @access public
		 * @final
		 * @return Data\Int32                                       the length of this string
		 */
		public final function length() {
			return Data\Int32::create($this->__length());
		}

		/**
		 * This method applies each element in this string to the subroutine function.
		 *
		 * @access public
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return Data\String                                      the string
		 */
		public function map(callable $subroutine) {
			$buffer = '';
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$buffer .= $subroutine(Data\Char::create(mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING)), Data\Int32::create($i))->unbox();
			}

			return new static($buffer);
		}

		/**
		 * This method iterates over the elements in the string, yielding each element to the
		 * predicate function, or fails the falsy test.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether each element passed the
		 *                                                          falsy test
		 */
		public function none(callable $predicate) {
			return $this->all(function(Core\Any $object, Data\Int32 $index) use ($predicate) {
				return $predicate($object, $index)->not();
			});
		}

		/**
		 * This method prepends the specified object to the front of this string.
		 *
		 * @access public
		 * @param Core\Any $object                                  the object to be prepended
		 * @return Data\String                                      the string
		 */
		public function prepend(Core\Any $object) {
			return new static($object->__toString() . $this->unbox());
		}

		/**
		 * This method returns the string within the specified range.
		 *
		 * @access public
		 * @param Data\Int32 $start                                 the starting index
		 * @param Data\Int32 $end                                   the ending index
		 * @return Data\String                                      the string
		 */
		public function range(Data\Int32 $start, Data\Int32 $end) {
			return $this->take($end)->drop($start);
		}

		/**
		 * This method returns a string of those elements that don't satisfy the predicate.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\String                                      the string
		 */
		public function remove(callable $predicate) {
			return $this->filter(function(Core\Any $x, Data\Int32 $i) use ($predicate) {
				return $predicate($x, $i)->not();
			});
		}

		/**
		 * This method reverses the order of the elements in this string.
		 *
		 * @access public
		 * @return Data\String                                   the string
		 */
		public function reverse() {
			$buffer = '';

			for ($i = $this->__length() - 1; $i >= 0; $i--) {
				$buffer .= mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING);
			}

			return new static($buffer);
		}

		/**
		 * This method returns the extracted slice of the string.
		 *
		 * @access public
		 * @param Data\Int32 $offset                                the starting index
		 * @param Data\Int32 $length                                the length of the slice
		 * @return Data\String                                      the string
		 */
		public function slice(Data\Int32 $offset, Data\Int32 $length) {
			return new static(mb_substr($this->unbox(), $offset->unbox(), $length->unbox(), Data\Char::UTF_8_ENCODING));
		}

		/**
		 * This method returns the tail of this string.
		 *
		 * @access public
		 * @return Data\String                                      the tail of this string
		 */
		public function tail() {
			$buffer = '';
			$length = $this->__length();

			for ($i = 1; $i < $length; $i++) {
				$buffer .= mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING);
			}

			return new static($buffer);
		}

		/**
		 * This method returns the first "n" elements in the string.
		 *
		 * @access public
		 * @param Data\Int32 $n                                     the number of elements to take
		 * @return Data\String                                      the string
		 */
		public function take(Data\Int32 $n) {
			$buffer = '';
			$length = min($n->unbox(), $this->__length());

			for ($i = 0; $i < $length; $i++) {
				$buffer .= mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING);
			}

			return new static($buffer);
		}

		/**
		 * This method returns each element in this string until the predicate fails.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\String                                      the string
		 */
		public function takeWhile(callable $predicate) {
			$buffer = '';
			$length = $this->__length();

			for ($i = 0; $i < $length; $i++) {
				$x = mb_substr($this->unbox(), $i, 1, Data\Char::UTF_8_ENCODING);;
				if (!$predicate(Data\Char::create($x), Data\Int32::create($i))->unbox()) {
					break;
				}
				$buffer .= $x;
			}

			return new static($buffer);
		}

		/**
		 * This method returns each element in this string until the predicate doesn't fail.
		 *
		 * @access public
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\String                                      the string
		 */
		public function takeWhileEnd(callable $predicate) {
			return $this->takeWhile(function(Core\Any $x, Data\Int32 $i) use ($predicate) {
				return $predicate($x, $i)->not();
			});
		}

		#endregion

	}

}
