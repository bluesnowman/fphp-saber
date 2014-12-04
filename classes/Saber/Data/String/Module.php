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

namespace Saber\Data\String {

	include_once(implode(DIRECTORY_SEPARATOR, array(dirname(__FILE__), '..', '..', 'Ext', 'mbstring.php')));

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Bool;
	use \Saber\Data\Char;
	use \Saber\Data\Int32;
	use \Saber\Data\LinkedList;
	use \Saber\Data\Option;
	use \Saber\Data\String;
	use \Saber\Data\Vector;
	use \Saber\Throwable;

	final class Module extends Data\Module implements Vector\Module {

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the elements in the string, yielding each
		 * element to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether each element passed the
		 *                                                          truthy test
		 */
		public static function all(String\Type $xs, callable $predicate) {
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$x = String\Module::element($xs, $i);
				if (!$predicate($x, $i)->unbox()) {
					return Bool\Type::false();
				}
			}

			return Bool\Type::true(); // yes, an empty string returns "true"
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the elements in the string
		 * passed the truthy test.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether some of the elements
		 *                                                          passed the truthy test
		 */
		public static function any(String\Type $xs, callable $predicate) {
			return Option\Module::isDefined(String\Module::find($xs, $predicate));
		}

		/**
		 * This method appends the specified object to this object's string.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param Char\Type $y                                      the object to be appended
		 * @return String\Type                                      the string
		 */
		public static function append(String\Type $xs, Char\Type $y) {
			return String\Type::box($xs->unbox() . $y->unbox());
		}

		/**
		 * This method concatenates a string to this object's string.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param String\Type $ys                                   the string to be concatenated
		 * @return String\Type                                      the string
		 */
		public static function concat(String\Type $xs, String\Type $ys) {
			return String\Type::box($xs->unbox() . $ys->unbox());
		}

		/**
		 * This method evaluates whether the specified object is contained within the string.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param Char\Type $y                                      the object to find
		 * @return Bool\Type                                        whether the specified object is
		 *                                                          contained within the string
		 */
		public static function contains(String\Type $xs, Char\Type $y) {
			return String\Module::any($xs, function(Char\Type $x, Int32\Type $i) use ($y) {
				return Char\Module::eq($x, $y);
			});
		}

		/**
		 * This method remove the first occurrence that equals the specified object.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param Char\Type $y                                      the object to be removed
		 * @return String\Type                                      the string
		 */
		public static function delete(String\Type $xs, Char\Type $y) {
			$buffer = '';
			$length = $xs->length();
			$skip = false;

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$x = String\Module::element($xs, $i);
				if (Char\Module::eq($x, $y)->unbox() && !$skip) {
					$skip = true;
					continue;
				}
				$buffer .= $x->unbox();
			}

			return String\Type::box($buffer);
		}

		/**
		 * This method returns the string after dropping the first "n" elements.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param Int32\Type $n                                     the number of elements to drop
		 * @return String\Type                                      the string
		 */
		public static function drop(String\Type $xs, Int32\Type $n) {
			$buffer = '';
			$length = $xs->length();

			for ($i = $n; Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$buffer .= String\Module::element($xs, $i);
			}

			return String\Type::box($buffer);
		}

		/**
		 * This method returns the string from element where the predicate function fails.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return String\Type                                      the string
		 */
		public static function dropWhile(String\Type $xs, callable $predicate) {
			$buffer = '';
			$length = $xs->length();

			$failed = false;
			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$x = String\Module::element($xs, $i);
				if (!$predicate($x, $i)->unbox() || $failed) {
					$buffer .= $x->unbox();
					$failed = true;
				}
			}

			return String\Type::box($buffer);
		}

		/**
		 * This method returns the string from element where the predicate function doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return String\Type                                      the string
		 */
		public static function dropWhileEnd(String\Type $xs, callable $predicate) {
			return String\Module::dropWhile($xs, function(Core\Type $x, Int32\Type $i) use ($predicate) {
				return $predicate($x, $i)->not();
			});
		}

		/**
		 * This method iterates over the elements in the string, yielding each element to the procedure
		 * function.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param callable $procedure                               the procedure function to be used
		 */
		public static function each(String\Type $xs, callable $procedure) {
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$procedure(String\Module::element($xs, $i), $i);
			}
		}

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param Int32\Type $i                                     the index of the element
		 * @return Char\Type                                        the element at the specified index
		 * @throws Throwable\OutOfBounds\Exception                  indicates the specified index
		 *                                                          cannot be found
		 */
		public static function element(String\Type $xs, Int32\Type $i) {
			return $xs->element($i);
		}

		/**
		 * This method returns a string of those elements that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return String\Type                                      the string
		 */
		public static function filter(String\Type $xs, callable $predicate) {
			$buffer = '';
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$x = $xs->element($i);
				if ($predicate($x, $i)->unbox()) {
					$buffer .= $x->unbox();
				}
			}

			return String\Type::box($buffer);
		}

		/**
		 * This method returns the first object in the collection that passes the truthy test, if any.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Option\Type                                      an option containing the first object
		 *                                                          satisfying the predicate, if any
		 */
		public static function find(String\Type $xs, callable $predicate) {
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
		 * This method returns the string flattened.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @return String\Type                                      the flattened string
		 */
		public static function flatten(String\Type $xs) {
			return $xs;
		}

		/**
		 * This method applies a left-fold reduction on the string using the operator function.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param Char\Type $initial                                the initial value to be used
		 * @return Char\Type                                        the result
		 */
		public static function foldLeft(String\Type $xs, callable $operator, Char\Type $initial) {
			$z = $initial;
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$z = $operator($z, $xs->element($i));
			}

			return $z;
		}

		/**
		 * This method applies a right-fold reduction on the string using the operation function.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param Char\Type $initial                                the initial value to be used
		 * @return Char\Type                                        the result
		 */
		public static function foldRight(String\Type $xs, callable $operator, Char\Type $initial) {
			$z = $initial;
			$length = $xs->length();

			for ($i = Int32\Module::decrement($length); Int32\Module::ge($i, Int32\Type::zero())->unbox(); $i = Int32\Module::decrement($i)) {
				$z = $operator($z, $xs->element($i));
			}

			return $z;
		}

		/**
		 * This method returns the head object in this string.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @return Char\Type                                        the head object in this string
		 */
		public static function head(String\Type $xs) {
			return $xs->head();
		}

		/**
		 * This method returns an option using the head for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @return Option\Type                                      the option
		 */
		public static function headOption(String\Type $xs) {
			return (!$xs->__isEmpty()) ? Option\Type::some($xs->head()) : Option\Type::none();
		}

		/**
		 * This method returns the index of the first occurrence of the object; otherwise, it returns -1;
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param Core\Type $object                                 the object to be searched for
		 * @return Int32\Type                                       the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public static function indexOf(String\Type $xs, Core\Type $object) {
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$x = $xs->element($i);
				if (Char\Module::eq($x, $object)->unbox()) {
					return $i;
				}
			}

			return Int32\Type::negative();
		}

		/**
		 * This method returns all but the last element of in the string.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @return String\Type                                      the string, minus the last
		 *                                                          element
		 */
		public static function init(String\Type $xs) {
			$buffer = '';
			$length = Int32\Module::decrement($xs->length());

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$buffer .= $xs->__element($i);
			}

			return String\Type::box($buffer);
		}

		/**
		 * The method intersperses the specified object between each element in the string.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param Core\Type $y                                      the object to be interspersed
		 * @return String\Type                                      the string
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function intersperse(String\Type $xs, Core\Type $y) {
			$buffer = '';
			$length = $xs->length();

			if ($length->unbox() > 0) {
				$buffer .= String\Module::element($xs, Int32\Type::zero())->unbox();
				for ($i = Int32\Type::one(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
					$buffer .= $y->__toString();
					$buffer .= $xs->__element($i);
				}
			}

			return String\Type::box($buffer);
		}

		/**
		 * This method (aka "null") returns whether this string is empty.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @return Bool\Type                                        whether the string is empty
		 */
		public static function isEmpty(String\Type $xs) {
			return $xs->isEmpty();
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @return String\Iterator                                  an iterator for this collection
		 */
		public static function iterator(String\Type $xs) {
			return new String\Iterator($xs);
		}

		/**
		 * This method returns the last element in this string.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @return Char\Type                                        the last element in this linked
		 *                                                          string
		 */
		public static function last(String\Type $xs) {
			return $xs->element(Int32\Module::decrement($xs->length()));
		}

		/**
		 * This method returns an option using the last for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @return Option\Type                                      the option
		 */
		public static function lastOption(String\Type $xs) {
			return (!$xs->__isEmpty()) ? Option\Type::some(String\Module::last($xs)) : Option\Type::none();
		}

		/**
		 * This method returns the length of this string.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @return Int32\Type                                       the length of this string
		 */
		public static function length(String\Type $xs) {
			return $xs->length();
		}

		/**
		 * This method applies each element in this string to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return String\Type                                      the string
		 */
		public static function map(String\Type $xs, callable $subroutine) {
			$buffer = '';
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$buffer .= $subroutine($xs->element($i), $i)->unbox();
			}

			return String\Type::box($buffer);
		}

		/**
		 * This method iterates over the elements in the string, yielding each element to the
		 * predicate function, or fails the falsy test.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return Bool\Type                                        whether each element passed the
		 *                                                          falsy test
		 */
		public static function none(String\Type $xs, callable $predicate) {
			return String\Module::all($xs, function(Core\Type $object, Int32\Type $index) use ($predicate) {
				return Bool\Module::not($predicate($object, $index));
			});
		}

		/**
		 * This method prepends the specified object to the front of this string.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param Core\Type $object                                 the object to be prepended
		 * @return String\Type                                      the string
		 */
		public static function prepend(String\Type $xs, Core\Type $object) {
			return String\Type::box($object->__toString() . $xs->__toString());
		}

		/**
		 * This method returns the string within the specified range.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param Int32\Type $start                                 the starting index
		 * @param Int32\Type $end                                   the ending index
		 * @return String\Type                                      the string
		 */
		public static function range(String\Type $xs, Int32\Type $start, Int32\Type $end) {
			return String\Module::drop(String\Module::take($xs, $end), $start);
		}

		/**
		 * This method returns a string of those elements that don't satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return String\Type                                      the string
		 */
		public static function remove(String\Type $xs, callable $predicate) {
			return String\Module::filter($xs, function(Core\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method reverses the order of the elements in this string.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @return String\Type                                      the string
		 */
		public static function reverse(String\Type $xs) {
			$buffer = '';
			$length = $xs->length();

			for ($i = Int32\Module::decrement($length); Int32\Module::ge($i, Int32\Type::zero())->unbox(); $i = Int32\Module::decrement($i)) {
				$buffer .= $xs->__element($i);
			}

			return String\Type::box($buffer);
		}

		/**
		 * This method returns the extracted slice of the string.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param Int32\Type $offset                                the starting index
		 * @param Int32\Type $length                                the length of the slice
		 * @return String\Type                                      the string
		 */
		public static function slice(String\Type $xs, Int32\Type $offset, Int32\Type $length) {
			return String\Type::box(mb_substr($xs->unbox(), $offset->unbox(), $length->unbox(), Char\Type::UTF_8_ENCODING));
		}

		/**
		 * This method returns the tail of this string.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @return String\Type                                      the tail of this string
		 */
		public static function tail(String\Type $xs) {
			return $xs->tail();
		}

		/**
		 * This method returns the first "n" elements in the string.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param Int32\Type $n                                     the number of elements to take
		 * @return String\Type                                      the string
		 */
		public static function take(String\Type $xs, Int32\Type $n) {
			$buffer = '';
			$length = Int32\Module::min($n, $xs->length());

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$buffer .= $xs->__element($i);
			}

			return String\Type::box($buffer);
		}

		/**
		 * This method returns each element in this string until the predicate fails.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return String\Type                                      the string
		 */
		public static function takeWhile(String\Type $xs, callable $predicate) {
			$buffer = '';
			$length = $xs->length();

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$x = $xs->element($i);
				if (!$predicate($x, $i)->unbox()) {
					break;
				}
				$buffer .= $x->unbox();
			}

			return String\Type::box($buffer);
		}

		/**
		 * This method returns each element in this string until the predicate doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return String\Type                                      the string
		 */
		public static function takeWhileEnd(String\Type $xs, callable $predicate) {
			return String\Module::takeWhile($xs, function(Core\Type $x, Int32\Type $i) use ($predicate) {
				return Bool\Module::not($predicate($x, $i));
			});
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the value to be evaluated
		 * @param String\Type $ys                                   the default value
		 * @return String\Type                                      the result
		 */
		public static function nvl(String\Type $xs = null, String\Type $ys = null) {
			return ($xs !== null) ? $xs : (($ys !== null) ? $ys : String\Type::empty_());
		}

		/**
		 * This method returns the collection as an array.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the operand
		 * @return String\Type                                      the collection as an array list
		 */
		public static function toArrayList(String\Type $xs) {
			$buffer = array();
			String\Module::each($xs, function(Char\Type $x, Int32\Type $i) use ($buffer) {
				$buffer[] = $x;
			});
			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the collection as a linked list.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the operand
		 * @return LinkedList\Type                                  the collection as a linked list
		 */
		public static function toLinkedList(String\Type $xs) {
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
		 * This method evaluates whether the specified object is equal to the current object.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the object to be evaluated
		 * @return Bool\Type                                        whether the specified object is equal
		 *                                                          to the current object
		 */
		public static function eq(String\Type $xs, Core\Type $ys) {
			$type = $xs->__typeOf();
			if ($ys !== null) {
				if ($ys instanceof $type) {
					return Bool\Type::box($xs->unbox() == $ys->unbox());
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the specified object is identical to the current object.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the object to be evaluated
		 * @return Bool\Type                                        whether the specified object is identical
		 *                                                          to the current object
		 */
		public static function id(String\Type $xs, Core\Type $ys) {
			if ($ys !== null) {
				if ($xs->__typeOf() === $ys->__typeOf()) {
					return Bool\Type::box($xs->unbox() === $ys->unbox());
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(String\Type $xs, Core\Type $ys) { // !=
			return Bool\Module::not(String\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(String\Type $xs, Core\Type $ys) { // !==
			return Bool\Module::not(String\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param String\Type $ys                                   the object to be compared
		 * @return Int32\Type                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(String\Type $xs, String\Type $ys) {
			if (($xs === null) && ($ys !== null)) {
				return Int32\Type::negative();
			}
			if (($xs === null) && ($ys === null)) {
				return Int32\Type::zero();
			}
			if (($xs !== null) && ($ys === null)) {
				return Int32\Type::one();
			}

			$r = strcmp($xs->unbox(), $ys->unbox());

			if ($r < 0) {
				return Int32\Type::negative();
			}
			else if ($r == 0) {
				return Int32\Type::zero();
			}
			else {
				return Int32\Type::one();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param String\Type $ys                                   the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(String\Type $xs, String\Type $ys) { // >=
			return Bool\Type::box(String\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param String\Type $ys                                   the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(String\Type $xs, String\Type $ys) { // >
			return Bool\Type::box(String\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param String\Type $ys                                   the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(String\Type $xs, String\Type $ys) { // <=
			return Bool\Type::box(String\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param String\Type $ys                                   the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(String\Type $xs, String\Type $ys) { // <
			return Bool\Type::box(String\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param String\Type $ys                                   the right operand
		 * @return Int32\Type                                       the maximum value
		 */
		public static function max(String\Type $xs, String\Type $ys) {
			return (String\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @param String\Type $ys                                   the right operand
		 * @return Int32\Type                                       the minimum value
		 */
		public static function min(String\Type $xs, String\Type $ys) {
			return (String\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

	}

}
