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

	include_once(implode(DIRECTORY_SEPARATOR, array(dirname(__FILE__), '..', 'Ext', 'mbstring.php')));

	use \Saber\Data;
	use \Saber\Throwable;

	class String extends Data\Collection implements Data\Type\Boxable {

		#region Methods -> Implementation

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
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string the object as a string
		 */
		public function __toString() {
			return $this->value;
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @param integer $depth                                    how many levels to unbox
		 * @return mixed                                            the un-boxed value
		 */
		public function unbox($depth = 0) {
			return $this->value;
		}

		#endregion

		#region Methods -> Instantiation

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Data\String                                      the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function box($value/*...*/) {
			if (!is_string($value)) {
				$type = gettype($value);
				if ($type == 'object') {
					$type = get_class($value);
				}
				throw new Throwable\InvalidArgument\Exception('Unable to box value. Expected a string, but got ":type".', array(':type' => $type));
			}
			if (func_num_args() > 1) {
				$encoding = func_get_arg(1);
				$value = mb_convert_encoding($value, Data\Char::UTF_8_ENCODING, $encoding);
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
		 * @return Data\String                                      the boxed object
		 */
		public static function create($value/*...*/) {
			return new static($value);
		}

		/**
		 * This method creates a string of "n" length with every element set to the given object.
		 *
		 * @access public
		 * @static
		 * @param Int32 $n                                          the number of times to replicate
		 * @param Data\Type $y                                       the object to be replicated
		 * @return Data\String                                      the string
		 */
		public static function replicate(Data\Int32 $n, Data\Type $y) {
			$buffer = '';
			$length = $n->unbox();

			for ($i = 0; $i < $length; $i++) {
				$buffer .= $y->__toString();
			}

			return Data\String::create($buffer);
		}

		#endregion

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the elements in the string, yielding each
		 * element to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether each element passed the
		 *                                                          truthy test
		 */
		public static function all(Data\String $xs, callable $predicate) {
			$length = Data\String::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$x = Data\String::element($xs, $i);
				if (!$predicate($x, $i)->unbox()) {
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
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether some of the elements
		 *                                                          passed the truthy test
		 */
		public static function any(Data\String $xs, callable $predicate) {
			return Data\Option::isDefined(Data\String::find($xs, $predicate));
		}

		/**
		 * This method appends the specified object to this object's string.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\Char $char                                   the object to be appended
		 * @return Data\String                                      the string
		 */
		public static function append(Data\String $xs, Data\Char $char) {
			return Data\String::create($xs->unbox() . $char->unbox());
		}

		/**
		 * This method concatenates a string to this object's string.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\String $ys                                   the string to be concatenated
		 * @return Data\String                                      the string
		 */
		public static function concat(Data\String $xs, Data\String $ys) {
			return Data\String::create($xs->unbox() . $ys->unbox());
		}

		/**
		 * This method evaluates whether the specified object is contained within the string.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\Char $y                                      the object to find
		 * @return Data\Bool                                        whether the specified object is
		 *                                                          contained within the string
		 */
		public static function contains(Data\String $xs, Data\Char $y) {
			return Data\String::any($xs, function(Data\Char $x, Data\Int32 $i) use ($y) {
				return Data\Char::eq($x, $y);
			});
		}

		/**
		 * This method remove the first occurrence that equals the specified object.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\Char $y                                      the object to be removed
		 * @return Data\String                                      the string
		 */
		public static function delete(Data\String $xs, Data\Char $y) {
			$buffer = '';
			$length = Data\String::length($xs);
			$skip = false;

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$x = Data\String::element($xs, $i);
				if (Data\Bool::eq($x, $y)->unbox() && !$skip) {
					$skip = true;
					continue;
				}
				$buffer .= $x->unbox();
			}

			return Data\String::create($buffer);
		}

		/**
		 * This method returns the string after dropping the first "n" elements.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\Int32 $n                                     the number of elements to drop
		 * @return Data\String                                      the string
		 */
		public static function drop(Data\String $xs, Data\Int32 $n) {
			$buffer = '';
			$length = Data\String::length($xs);

			for ($i = $n; Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$buffer .= Data\String::element($xs, $i);
			}

			return Data\String::create($buffer);
		}

		/**
		 * This method return the string from element where the predicate function fails.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\String                                      the string
		 */
		public static function dropWhile(Data\String $xs, callable $predicate) {
			$buffer = '';
			$length = Data\String::length($xs);

			$failed = false;
			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$x = Data\String::element($xs, $i);
				if (!$predicate($x, $i)->unbox() || $failed) {
					$buffer .= $x->unbox();
					$failed = true;
				}
			}

			return Data\String::create($buffer);
		}

		/**
		 * This method return the string from element where the predicate function doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\String                                      the string
		 */
		public static function dropWhileEnd(Data\String $xs, callable $predicate) {
			return Data\String::dropWhile($xs, function(Data\Type $x, Data\Int32 $i) use ($predicate) {
				return $predicate($x, $i)->not();
			});
		}

		/**
		 * This method iterates over the elements in the string, yielding each element to the procedure
		 * function.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param callable $procedure                               the procedure function to be used
		 */
		public static function each(Data\String $xs, callable $procedure) {
			$length = Data\String::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$procedure(Data\String::element($xs, $i), $i);
			}
		}

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\Int32 $i                                     the index of the element
		 * @return Data\Char                                        the element at the specified index
		 * @throws Throwable\OutOfBounds\Exception                  indicates the specified index
		 *                                                          cannot be found
		 */
		public static function element(Data\String $xs, Data\Int32 $i) {
			if (Data\Bool::or_(Data\Int32::lt($i, Data\Int32::zero()), Data\Int32::ge($i, Data\String::length($xs)))->unbox()) {
				throw new Throwable\OutOfBounds\Exception('Unable to return element at index :index.', array(':index' => $i->unbox()));
			}
			return Data\Char::create(mb_substr($xs->unbox(), $i->unbox(), 1, Data\Char::UTF_8_ENCODING));
		}

		/**
		 * This method returns a string of those elements that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\String                                      the string
		 */
		public static function filter(Data\String $xs, callable $predicate) {
			$buffer = '';
			$length = Data\String::length($xs)->unbox();

			for ($i = 0; $i < $length; $i++) {
				$x = mb_substr($xs->unbox(), $i, 1, Data\Char::UTF_8_ENCODING);
				if ($predicate(Data\Char::create($x), Data\Int32::create($i))->unbox()) {
					$buffer .= $x;
				}
			}

			return Data\String::create($buffer);
		}

		/**
		 * This method returns the first object in the collection that passes the truthy test, if any.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Option                                      an option containing the first object
		 *                                                          satisfying the predicate, if any
		 */
		public static function find(Data\String $xs, callable $predicate) {
			$length = Data\String::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$x = Data\String::element($xs, $i);
				if ($predicate($x, $i)->unbox()) {
					return Data\Option::some($x);
				}
			}

			return Data\Option::none();
		}

		/**
		 * This method returns the string flattened.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @return Data\String                                      the flattened string
		 */
		public static function flatten(Data\String $xs) {
			return $xs;
		}

		/**
		 * This method applies a left-fold reduction on the string using the operator function.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param Data\Type $initial                                the initial value to be used
		 * @return Data\Type                                        the result
		 */
		public static function foldLeft(Data\String $xs, callable $operator, Data\Type $initial) {
			$z = $initial;
			$length = Data\String::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$z = $operator($z, Data\String::element($xs, $i));
			}

			return $z;
		}

		/**
		 * This method applies a right-fold reduction on the string using the operation function.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param Data\Type $initial                                the initial value to be used
		 * @return Data\Type                                        the result
		 */
		public static function foldRight(Data\String $xs, callable $operator, Data\Type $initial) {
			$z = $initial;
			$length = Data\String::length($xs);

			for ($i = Data\Int32::decrement($length); Data\Int32::ge($i, Data\Int32::zero())->unbox(); $i = Data\Int32::decrement($length)) {
				$z = $operator($z, Data\String::element($xs, $i));
			}

			return $z;
		}

		/**
		 * This method returns the head object in this string.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @return Data\Type                                        the head object in this string
		 */
		public static function head(Data\String $xs) {
			return Data\String::element($xs, Data\Int32::zero());
		}

		/**
		 * This method returns an option using the head for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @return Data\Option                                      the option
		 */
		public static function headOption(Data\String $xs) {
			return (!Data\String::isEmpty($xs)->unbox()) ? Data\Option::some(Data\String::head($xs)) : Data\Option::none();
		}

		/**
		 * This method return the index of the first occurrence of the object; otherwise, it returns -1;
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\Type $object                                 the object to be searched for
		 * @return Data\Int32                                       the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public static function indexOf(Data\String $xs, Data\Type $object) {
			$length = Data\String::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$x = Data\String::element($xs, $i);
				if (Data\Char::eq($x, $object)->unbox()) {
					return $i;
				}
			}

			return Data\Int32::negative();
		}

		/**
		 * This method returns all but the last element of in the string.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @return Data\String                                      the string, minus the last
		 *                                                          element
		 */
		public static function init(Data\String $xs) {
			$buffer = '';
			$length = Data\String::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$buffer .= Data\String::element($xs, $i)->unbox();
			}

			return Data\String::create($buffer);
		}

		/**
		 * This method (aka "null") returns whether this string is empty.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @return Data\Bool                                        whether the string is empty
		 */
		public static function isEmpty(Data\String $xs) {
			return Data\Int32::eq(Data\String::length($xs), Data\Int32::zero());
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @return Data\String\Iterator                             an iterator for this collection
		 */
		public static function iterator(Data\String $xs) {
			return new Data\String\Iterator($xs);
		}

		/**
		 * The method intersperses the specified object between each element in the string.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\Type $object                                 the object to be interspersed
		 * @return Data\String                                      the string
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function intersperse(Data\String $xs, Data\Type $object) {
			$buffer = '';
			$length = Data\String::length($xs)->unbox();

			if ($length > 0) {
				$buffer .= mb_substr($xs->unbox(), 0, 1, Data\Char::UTF_8_ENCODING);
				for ($i = 1; $i < $length; $i++) {
					$buffer .= $object->__toString();
					$buffer .= mb_substr($xs->unbox(), $i, 1, Data\Char::UTF_8_ENCODING);
				}
			}

			return Data\String::create($buffer);
		}

		/**
		 * This method returns the last element in this string.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @return Data\Type                                        the last element in this linked
		 *                                                          string
		 */
		public static function last(Data\String $xs) {
			return Data\Char::create(mb_substr($xs->unbox(), Data\String::length($xs)->unbox() - 1, 1, Data\Char::UTF_8_ENCODING));
		}

		/**
		 * This method returns an option using the last for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @return Data\Option                                      the option
		 */
		public static function lastOption(Data\String $xs) {
			return (!Data\String::isEmpty($xs)->unbox()) ? Data\Option::some(Data\String::last($xs)) : Data\Option::none();
		}

		/**
		 * This method returns the length of this string.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @return Data\Int32                                       the length of this string
		 */
		public static function length(Data\String $xs) {
			return Data\Int32::create(mb_strlen($xs->unbox(), Data\Char::UTF_8_ENCODING));
		}

		/**
		 * This method applies each element in this string to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return Data\String                                      the string
		 */
		public static function map(Data\String $xs, callable $subroutine) {
			$buffer = '';
			$length = Data\String::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$buffer .= $subroutine(Data\String::element($xs, $i), $i)->unbox();
			}

			return Data\String::create($buffer);
		}

		/**
		 * This method iterates over the elements in the string, yielding each element to the
		 * predicate function, or fails the falsy test.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\Bool                                        whether each element passed the
		 *                                                          falsy test
		 */
		public static function none(Data\String $xs, callable $predicate) {
			return Data\String::all($xs, function(Data\Type $object, Data\Int32 $index) use ($predicate) {
				return Data\Bool::not($predicate($object, $index));
			});
		}

		/**
		 * This method prepends the specified object to the front of this string.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\Type $object                                 the object to be prepended
		 * @return Data\String                                      the string
		 */
		public static function prepend(Data\String $xs, Data\Type $object) {
			return Data\String::create($object->__toString() . $xs->__toString());
		}

		/**
		 * This method returns the string within the specified range.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\Int32 $start                                 the starting index
		 * @param Data\Int32 $end                                   the ending index
		 * @return Data\String                                      the string
		 */
		public static function range(Data\String $xs, Data\Int32 $start, Data\Int32 $end) {
			return Data\String::drop(Data\String::take($xs, $end), $start);
		}

		/**
		 * This method returns a string of those elements that don't satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\String                                      the string
		 */
		public static function remove(Data\String $xs, callable $predicate) {
			return Data\String::filter($xs, function(Data\Type $x, Data\Int32 $i) use ($predicate) {
				return Data\Bool::not($predicate($x, $i));
			});
		}

		/**
		 * This method reverses the order of the elements in this string.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @return Data\String                                      the string
		 */
		public static function reverse(Data\String $xs) {
			$buffer = '';
			$length = Data\String::length($xs);

			for ($i = Data\Int32::decrement($length); Data\Int32::ge($i, Data\Int32::zero())->unbox(); $i = Data\Int32::decrement($length)) {
				$buffer .= Data\String::element($xs, $i)->unbox();
			}

			return Data\String::create($buffer);
		}

		/**
		 * This method returns the extracted slice of the string.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\Int32 $offset                                the starting index
		 * @param Data\Int32 $length                                the length of the slice
		 * @return Data\String                                      the string
		 */
		public static function slice(Data\String $xs, Data\Int32 $offset, Data\Int32 $length) {
			return Data\String::create(mb_substr($xs->unbox(), $offset->unbox(), $length->unbox(), Data\Char::UTF_8_ENCODING));
		}

		/**
		 * This method returns the tail of this string.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @return Data\String                                      the tail of this string
		 */
		public static function tail(Data\String $xs) {
			$buffer = '';
			$length = Data\String::length($xs);

			for ($i = Data\Int32::one(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$buffer .= Data\String::element($xs, $i)->unbox();
			}

			return Data\String::create($buffer);
		}

		/**
		 * This method returns the first "n" elements in the string.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\Int32 $n                                     the number of elements to take
		 * @return Data\String                                      the string
		 */
		public static function take(Data\String $xs, Data\Int32 $n) {
			$buffer = '';
			$length = Data\Int32::min($n, Data\String::length($xs));

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$buffer .= Data\String::element($xs, $i)->unbox();
			}

			return Data\String::create($buffer);
		}

		/**
		 * This method returns each element in this string until the predicate fails.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\String                                      the string
		 */
		public static function takeWhile(Data\String $xs, callable $predicate) {
			$buffer = '';
			$length = Data\String::length($xs);

			for ($i = Data\Int32::zero(); Data\Int32::lt($i, $length)->unbox(); $i = Data\Int32::increment($i)) {
				$x = Data\String::element($xs, $i);
				if (!$predicate($x, $i)->unbox()) {
					break;
				}
				$buffer .= $x->unbox();
			}

			return Data\String::create($buffer);
		}

		/**
		 * This method returns each element in this string until the predicate doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Data\String                                      the string
		 */
		public static function takeWhileEnd(Data\String $xs, callable $predicate) {
			return Data\String::takeWhile($xs, function(Data\Type $x, Data\Int32 $i) use ($predicate) {
				return Data\Bool::not($predicate($x, $i));
			});
		}

		#endregion

		#region Methods -> Equality

		/**
		 * This method evaluates whether the specified object is equal to the current object.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\Type $ys                                     the object to be evaluated
		 * @return Data\Bool                                        whether the specified object is equal
		 *                                                          to the current object
		 */
		public static function eq(Data\String $xs, Data\Type $ys) {
			$class = get_class($xs);
			if ($ys instanceof $class) {
				return Data\Bool::create($xs->unbox() == $ys->unbox());
			}
			return Data\Bool::false();
		}

		/**
		 * This method evaluates whether the specified object is identical to the current object.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\Type $ys                                     the object to be evaluated
		 * @return Data\Bool                                        whether the specified object is identical
		 *                                                          to the current object
		 */
		public static function id(Data\String $xs, Data\Type $ys) {
			if (get_class($xs) === get_class($ys)) {
				return Data\Bool::create($xs->unbox() === $ys->unbox());
			}
			return Data\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\Type $ys                                     the right operand
		 * @return Data\Bool                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Data\String $xs, Data\Type $ys) { // !=
			return Data\Bool::not(Data\Option::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\Type $ys                                     the right operand
		 * @return Data\Bool                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Data\String $xs, Data\Type $ys) { // !==
			return Data\Bool::not(Data\Option::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\String $ys                                   the object to be compared
		 * @return Data\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(Data\String $xs, Data\String $ys) {
			if (($xs === null) && ($ys !== null)) {
				return Data\Int32::negative();
			}
			if (($xs === null) && ($ys === null)) {
				return Data\Int32::zero();
			}
			if (($xs !== null) && ($ys === null)) {
				return Data\Int32::one();
			}

			$r = strcmp($xs->unbox(), $ys->unbox());

			if ($r < 0) {
				return Data\Int32::negative();
			}
			else if ($r == 0) {
				return Data\Int32::zero();
			}
			else {
				return Data\Int32::one();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\String $ys                                   the right operand
		 * @return Data\Bool                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Data\String $xs, Data\String $ys) { // >=
			return Data\Bool::create(Data\String::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\String $ys                                   the right operand
		 * @return Data\Bool                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Data\String $xs, Data\String $ys) { // >
			return Data\Bool::create(Data\String::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\String $ys                                   the right operand
		 * @return Data\Bool                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Data\String $xs, Data\String $ys) { // <=
			return Data\Bool::create(Data\String::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\String $ys                                   the right operand
		 * @return Data\Bool                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Data\String $xs, Data\String $ys) { // <
			return Data\Bool::create(Data\String::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\String $ys                                   the right operand
		 * @return Data\Int32                                       the maximum value
		 */
		public static function max(Data\String $xs, Data\String $ys) {
			return (Data\String::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Data\String $xs                                   the left operand
		 * @param Data\String $ys                                   the right operand
		 * @return Data\Int32                                       the minimum value
		 */
		public static function min(Data\String $xs, Data\String $ys) {
			return (Data\String::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

	}

}
