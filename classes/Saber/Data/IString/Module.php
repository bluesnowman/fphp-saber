<?php

/**
 * Copyright 2014-2015 Blue Snowman
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

namespace Saber\Data\IString {

	include_once(implode(DIRECTORY_SEPARATOR, array(dirname(__FILE__), '..', '..', 'Ext', 'mbstring.php')));

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IChar;
	use \Saber\Data\IHashMap;
	use \Saber\Data\IInt32;
	use \Saber\Data\ILinkedList;
	use \Saber\Data\IOption;
	use \Saber\Data\IString;
	use \Saber\Data\ITrit;
	use \Saber\Data\ITuple;
	use \Saber\Data\IUnit;
	use \Saber\Data\IVector;
	use \Saber\Throwable;

	final class Module extends Data\Module implements IVector\Module {

		#region Methods -> Basic Operations

		/**
		 * This method (aka "every" or "forall") iterates over the items in the string, yielding each
		 * item to the predicate function, or fails the truthy test.  Opposite of "none".
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                        whether each item passed the
		 *                                                          truthy test
		 */
		public static function all(IString\Type $xs, callable $predicate) {
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$x = IString\Module::item($xs, $i);
				if (!$predicate($x, $i)->unbox()) {
					return IBool\Type::false();
				}
			}

			return IBool\Type::true(); // yes, an empty string returns "true"
		}

		/**
		 * This method (aka "exists" or "some") returns whether some of the items in the string
		 * passed the truthy test.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                        whether some of the items
		 *                                                          passed the truthy test
		 */
		public static function any(IString\Type $xs, callable $predicate) {
			return IOption\Module::isDefined(IString\Module::find($xs, $predicate));
		}

		/**
		 * This method appends the specified object to this object's string.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IChar\Type $y                                      the object to be appended
		 * @return IString\Type                                      the string
		 */
		public static function append(IString\Type $xs, IChar\Type $y) {
			return IString\Type::box($xs->unbox() . $y->unbox());
		}

		/**
		 * This method returns a tuple where the first item contains longest prefix of the string
		 * that does not satisfy the predicate and the second item contains the remainder.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the string
		 * @param callable $predicate                               the predicate function to be used
		 * @return ITuple\Type                                       the tuple
		 */
		public static function break_(IString\Type $xs, callable $predicate) {
			return IString\Module::span($xs, function(Core\Type $x, IInt32\Type $i) use ($predicate) {
				return IBool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method concatenates a string to this object's string.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IString\Type $ys                                   the string to be concatenated
		 * @return IString\Type                                      the string
		 */
		public static function concat(IString\Type $xs, IString\Type $ys) {
			return IString\Type::box($xs->unbox() . $ys->unbox());
		}

		/**
		 * This method evaluates whether the specified object is contained within the string.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IChar\Type $y                                      the object to find
		 * @return IBool\Type                                        whether the specified object is
		 *                                                          contained within the string
		 */
		public static function contains(IString\Type $xs, IChar\Type $y) {
			return IString\Module::any($xs, function(IChar\Type $x, IInt32\Type $i) use ($y) {
				return IChar\Module::eq($x, $y);
			});
		}

		/**
		 * This method remove the first occurrence that equals the specified object.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IChar\Type $y                                      the object to be removed
		 * @return IString\Type                                      the string
		 */
		public static function delete(IString\Type $xs, IChar\Type $y) {
			$buffer = '';
			$length = $xs->length();
			$skip = false;

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$x = IString\Module::item($xs, $i);
				if (IChar\Module::eq($x, $y)->unbox() && !$skip) {
					$skip = true;
					continue;
				}
				$buffer .= $x->unbox();
			}

			return IString\Type::box($buffer);
		}

		/**
		 * This method returns the string after dropping the first "n" items.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IInt32\Type $n                                     the number of items to drop
		 * @return IString\Type                                      the string
		 */
		public static function drop(IString\Type $xs, IInt32\Type $n) {
			$buffer = '';
			$length = $xs->length();

			for ($i = $n; IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$buffer .= IString\Module::item($xs, $i);
			}

			return IString\Type::box($buffer);
		}

		/**
		 * This method returns the string from item where the predicate function fails.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IString\Type                                      the string
		 */
		public static function dropWhile(IString\Type $xs, callable $predicate) {
			$buffer = '';
			$length = $xs->length();

			$failed = false;
			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$x = IString\Module::item($xs, $i);
				if (!$predicate($x, $i)->unbox() || $failed) {
					$buffer .= $x->unbox();
					$failed = true;
				}
			}

			return IString\Type::box($buffer);
		}

		/**
		 * This method returns the string from item where the predicate function doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IString\Type                                      the string
		 */
		public static function dropWhileEnd(IString\Type $xs, callable $predicate) {
			return IString\Module::dropWhile($xs, function(Core\Type $x, IInt32\Type $i) use ($predicate) {
				return $predicate($x, $i)->not();
			});
		}

		/**
		 * This method iterates over the items in the string, yielding each item to the procedure
		 * function.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param callable $procedure                               the procedure function to be used
		 */
		public static function each(IString\Type $xs, callable $procedure) {
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				IUnit\Type::covariant($procedure(IString\Module::item($xs, $i), $i));
			}
		}

		/**
		 * This method returns a string of those items that satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IString\Type                                      the string
		 */
		public static function filter(IString\Type $xs, callable $predicate) {
			$buffer = '';
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$x = $xs->item($i);
				if ($predicate($x, $i)->unbox()) {
					$buffer .= $x->unbox();
				}
			}

			return IString\Type::box($buffer);
		}

		/**
		 * This method returns the first object in the collection that passes the truthy test, if any.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IOption\Type                                      an option containing the first object
		 *                                                          satisfying the predicate, if any
		 */
		public static function find(IString\Type $xs, callable $predicate) {
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$x = $xs->item($i);
				if ($predicate($x, $i)->unbox()) {
					return IOption\Type::some($x);
				}
			}

			return IOption\Type::none();
		}

		/**
		 * This method returns the string flattened.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @return IString\Type                                      the flattened string
		 */
		public static function flatten(IString\Type $xs) {
			return $xs;
		}

		/**
		 * This method applies a left-fold reduction on the string using the operator function.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param IChar\Type $initial                                the initial value to be used
		 * @return IChar\Type                                        the result
		 */
		public static function foldLeft(IString\Type $xs, callable $operator, IChar\Type $initial) {
			$z = $initial;
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$z = $operator($z, $xs->item($i));
			}

			return $z;
		}

		/**
		 * This method applies a right-fold reduction on the string using the operation function.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param callable $operator                                the operator function to be used
		 * @param IChar\Type $initial                                the initial value to be used
		 * @return IChar\Type                                        the result
		 */
		public static function foldRight(IString\Type $xs, callable $operator, IChar\Type $initial) {
			$z = $initial;
			$length = $xs->length();

			for ($i = IInt32\Module::decrement($length); IInt32\Module::ge($i, IInt32\Type::zero())->unbox(); $i = IInt32\Module::decrement($i)) {
				$z = $operator($z, $xs->item($i));
			}

			return $z;
		}

		/**
		 * This method returns a formatted string using the specified vector of objects.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the string to be formatted
		 * @param IVector\Type $args                                 the objects to be incorporated
		 * @return IString\Type                                      the newly formatted string
		 */
		public static function format(IString\Type $xs, IVector\Type $ys) {
			$buffer = $xs->unbox();
			$length = $ys->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$search = '{' . $i->__toString() . '}';
				$buffer = str_replace($search, $ys->item($i)->__toString(), $buffer);
			}

			return IString\Type::box($buffer);
		}

		/**
		 * This method returns a hash map of lists of characters that are considered in the same group.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $xs                                the array list to be processed
		 * @param callable $subroutine                              the subroutine to be used
		 * @return IHashMap\Type                                     a hash map of lists of characters that
		 *                                                          are considered in the same group
		 */
		public static function group(IArrayList\Type $xs, callable $subroutine) {
			$groups = IHashMap\Type::empty_();

			IString\Module::each($xs, function(IChar\Type $x, IInt32\Type $i) use ($groups, $subroutine) {
				$key = $subroutine($x, $i);

				$item = ($groups->__hasKey($key))
					? $groups->item($key)->unbox()
					: '';

				$item .= $x->unbox();

				$groups->putEntry($key, IString\Type::box($item));
			});

			return $groups;
		}

		/**
		 * This method returns the head object in this string.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @return IChar\Type                                        the head object in this string
		 */
		public static function head(IString\Type $xs) {
			return $xs->head();
		}

		/**
		 * This method returns an option using the head for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @return IOption\Type                                      the option
		 */
		public static function headIOption(IString\Type $xs) {
			return (!$xs->__isEmpty())
				? IOption\Type::some($xs->head())
				: IOption\Type::none();
		}

		/**
		 * This method returns the index of the first occurrence of the object; otherwise, it returns -1;
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param Core\Type $object                                 the object to be searched for
		 * @return IInt32\Type                                       the index of the first occurrence
		 *                                                          or otherwise -1
		 */
		public static function indexOf(IString\Type $xs, Core\Type $object) {
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$x = $xs->item($i);
				if (IChar\Module::eq($x, $object)->unbox()) {
					return $i;
				}
			}

			return IInt32\Type::negative();
		}

		/**
		 * This method returns all but the last item of in the string.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @return IString\Type                                      the string, minus the last
		 *                                                          item
		 */
		public static function init(IString\Type $xs) {
			$buffer = '';
			$length = IInt32\Module::decrement($xs->length());

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$buffer .= $xs->__item($i);
			}

			return IString\Type::box($buffer);
		}

		/**
		 * The method intersperses the specified object between each item in the string.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param Core\Type $y                                      the object to be interspersed
		 * @return IString\Type                                      the string
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function intersperse(IString\Type $xs, Core\Type $y) {
			$buffer = '';
			$length = $xs->length();

			if ($length->unbox() > 0) {
				$buffer .= IString\Module::item($xs, IInt32\Type::zero())->unbox();
				for ($i = IInt32\Type::one(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
					$buffer .= $y->__toString();
					$buffer .= $xs->__item($i);
				}
			}

			return IString\Type::box($buffer);
		}

		/**
		 * This method (aka "null") returns whether this string is empty.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @return IBool\Type                                        whether the string is empty
		 */
		public static function isEmpty(IString\Type $xs) {
			return $xs->isEmpty();
		}

		/**
		 * This method returns the item at the specified index.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IInt32\Type $i                                     the index of the item
		 * @return IChar\Type                                        the item at the specified index
		 * @throws Throwable\OutOfBounds\Exception                  indicates the specified index
		 *                                                          cannot be found
		 */
		public static function item(IString\Type $xs, IInt32\Type $i) {
			return $xs->item($i);
		}

		/**
		 * This method returns an iterator for this collection.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @return IString\Iterator                                  an iterator for this collection
		 */
		public static function iterator(IString\Type $xs) {
			return new IString\Iterator($xs);
		}

		/**
		 * This method returns the last item in this string.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @return IChar\Type                                        the last item in this linked
		 *                                                          string
		 */
		public static function last(IString\Type $xs) {
			return $xs->item(IInt32\Module::decrement($xs->length()));
		}

		/**
		 * This method returns an option using the last for the boxed object.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @return IOption\Type                                      the option
		 */
		public static function lastIOption(IString\Type $xs) {
			return (!$xs->__isEmpty())
				? IOption\Type::some(IString\Module::last($xs))
				: IOption\Type::none();
		}

		/**
		 * This method returns the length of this string.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @return IInt32\Type                                       the length of this string
		 */
		public static function length(IString\Type $xs) {
			return $xs->length();
		}

		/**
		 * This method applies each item in this string to the subroutine function.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param callable $subroutine                              the subroutine function to be used
		 * @return IString\Type                                      the string
		 */
		public static function map(IString\Type $xs, callable $subroutine) {
			$buffer = '';
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$buffer .= $subroutine($xs->item($i), $i)->unbox();
			}

			return IString\Type::box($buffer);
		}

		/**
		 * This method iterates over the items in the string, yielding each item to the
		 * predicate function, or fails the falsy test.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IBool\Type                                        whether each item passed the
		 *                                                          falsy test
		 */
		public static function none(IString\Type $xs, callable $predicate) {
			return IString\Module::all($xs, function(Core\Type $object, IInt32\Type $index) use ($predicate) {
				return IBool\Module::not($predicate($object, $index));
			});
		}

		/**
		 * This method returns a pair of strings: those items that satisfy the predicate and
		 * those items that do not satisfy the predicate.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the string to be partitioned
		 * @param callable $predicate                               the predicate function to be used
		 * @return ITuple\Type                                       the results
		 */
		public static function partition(IString\Type $xs, callable $predicate) {
			$passed = '';
			$failed = '';

			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$x = $xs->item($i);
				if ($predicate($x, $i)->unbox()) {
					$passed .= $x->unbox();
				}
				else {
					$failed .= $x->unbox();
				}
			}

			return ITuple\Type::box2(IString\Type::box($passed), IString\Type::box($failed));
		}

		/**
		 * This method prepends the specified object to the front of this string.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param Core\Type $object                                 the object to be prepended
		 * @return IString\Type                                      the string
		 */
		public static function prepend(IString\Type $xs, Core\Type $object) {
			return IString\Type::box($object->__toString() . $xs->__toString());
		}

		/**
		 * This method returns the string within the specified range.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IInt32\Type $start                                 the starting index
		 * @param IInt32\Type $end                                   the ending index
		 * @return IString\Type                                      the string
		 */
		public static function range(IString\Type $xs, IInt32\Type $start, IInt32\Type $end) {
			return IString\Module::drop(IString\Module::take($xs, $end), $start);
		}

		/**
		 * This method (aka "remove") returns a string containing those characters that do not
		 * satisfy the predicate.  Opposite of "filter".
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the string
		 * @param callable $predicate                               the predicate function to be used
		 * @return IString\Type                                      a string containing those characters
		 *                                                          that do not satisfy the predicate
		 */
		public static function reject(IString\Type $xs, callable $predicate) {
			return IString\Module::filter($xs, function(Core\Type $x, IInt32\Type $i) use ($predicate) {
				return IBool\Module::not($predicate($x, $i));
			});
		}

		/**
		 * This method reverses the order of the items in this string.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @return IString\Type                                      the string
		 */
		public static function reverse(IString\Type $xs) {
			$buffer = '';
			$length = $xs->length();

			for ($i = IInt32\Module::decrement($length); IInt32\Module::ge($i, IInt32\Type::zero())->unbox(); $i = IInt32\Module::decrement($i)) {
				$buffer .= $xs->__item($i);
			}

			return IString\Type::box($buffer);
		}

		/**
		 * This method returns the extracted slice of the string.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IInt32\Type $offset                                the starting index
		 * @param IInt32\Type $length                                the length of the slice
		 * @return IString\Type                                      the string
		 */
		public static function slice(IString\Type $xs, IInt32\Type $offset, IInt32\Type $length) {
			return IString\Type::box(mb_substr($xs->unbox(), $offset->unbox(), $length->unbox(), IChar\Type::UTF_8_ENCODING));
		}

		/**
		 * This method returns a tuple where the first item contains longest prefix of the string
		 * that satisfies the predicate and the second item contains the remainder.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the string
		 * @param callable $predicate                               the predicate function to be used
		 * @return ITuple\Type                                       the tuple
		 */
		public static function span(IString\Type $xs, callable $predicate) {
			return ITuple\Type::box2(
				IString\Module::takeWhile($xs, $predicate),
				IString\Module::dropWhile($xs, $predicate)
			);
		}

		/**
		 * This method returns a tuple where the first item contains the first "n" characters
		 * in the string and the second item contains the remainder.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the string
		 * @param IInt32\Type $n                                     the number of characters to take
		 * @return ITuple\Type                                       the tuple
		 */
		public static function split(IString\Type $xs, IInt32\Type $n) {
			return ITuple\Type::box2(
				IString\Module::take($xs, $n),
				IString\Module::drop($xs, $n)
			);
		}

		/**
		 * This method returns the tail of this string.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @return IString\Type                                      the tail of this string
		 */
		public static function tail(IString\Type $xs) {
			return $xs->tail();
		}

		/**
		 * This method returns the first "n" items in the string.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IInt32\Type $n                                     the number of items to take
		 * @return IString\Type                                      the string
		 */
		public static function take(IString\Type $xs, IInt32\Type $n) {
			$buffer = '';
			$length = IInt32\Module::min($n, $xs->length());

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$buffer .= $xs->__item($i);
			}

			return IString\Type::box($buffer);
		}

		/**
		 * This method returns each item in this string until the predicate fails.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IString\Type                                      the string
		 */
		public static function takeWhile(IString\Type $xs, callable $predicate) {
			$buffer = '';
			$length = $xs->length();

			for ($i = IInt32\Type::zero(); IInt32\Module::lt($i, $length)->unbox(); $i = IInt32\Module::increment($i)) {
				$x = $xs->item($i);
				if (!$predicate($x, $i)->unbox()) {
					break;
				}
				$buffer .= $x->unbox();
			}

			return IString\Type::box($buffer);
		}

		/**
		 * This method returns each item in this string until the predicate doesn't fail.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param callable $predicate                               the predicate function to be used
		 * @return IString\Type                                      the string
		 */
		public static function takeWhileEnd(IString\Type $xs, callable $predicate) {
			return IString\Module::takeWhile($xs, function(Core\Type $x, IInt32\Type $i) use ($predicate) {
				return IBool\Module::not($predicate($x, $i));
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
		 * @param IString\Type $xs                                   the value to be evaluated
		 * @param IString\Type $ys                                   the default value
		 * @return IString\Type                                      the result
		 */
		public static function nvl(IString\Type $xs = null, IString\Type $ys = null) {
			return ($xs !== null) ? $xs : (($ys !== null) ? $ys : IString\Type::empty_());
		}

		/**
		 * This method returns the collection as an array.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the operand
		 * @return IString\Type                                      the collection as an array list
		 */
		public static function toArrayList(IString\Type $xs) {
			$buffer = array();
			IString\Module::each($xs, function(IChar\Type $x, IInt32\Type $i) use ($buffer) {
				$buffer[] = $x;
			});
			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the collection as a linked list.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the operand
		 * @return ILinkedList\Type                                  the collection as a linked list
		 */
		public static function toLinkedList(IString\Type $xs) {
			$length = $xs->length();
			$zs = ILinkedList\Type::nil();
			for ($i = IInt32\Module::decrement($length); IInt32\Module::ge($i, IInt32\Type::zero())->unbox(); $i = IInt32\Module::decrement($i)) {
				$zs = ILinkedList\Type::cons($xs->item($i), $zs);
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
		 * @param IString\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the object to be evaluated
		 * @return IBool\Type                                        whether the specified object is equal
		 *                                                          to the current object
		 */
		public static function eq(IString\Type $xs, Core\Type $ys) {
			$type = $xs->__typeOf();
			if ($ys !== null) {
				if ($ys instanceof $type) {
					return IBool\Type::box($xs->unbox() == $ys->unbox());
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the specified object is identical to the current object.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the object to be evaluated
		 * @return IBool\Type                                        whether the specified object is identical
		 *                                                          to the current object
		 */
		public static function id(IString\Type $xs, Core\Type $ys) {
			if ($ys !== null) {
				if ($xs->__typeOf() === $ys->__typeOf()) {
					return IBool\Type::box($xs->unbox() === $ys->unbox());
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(IString\Type $xs, Core\Type $ys) { // !=
			return IBool\Module::not(IString\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(IString\Type $xs, Core\Type $ys) { // !==
			return IBool\Module::not(IString\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IString\Type $ys                                   the object to be compared
		 * @return ITrit\Type                                        whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(IString\Type $xs, IString\Type $ys) {
			return ITrit\Type::make(strcmp($xs->unbox(), $ys->unbox()));
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IString\Type $ys                                   the right operand
		 * @return IBool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(IString\Type $xs, IString\Type $ys) { // >=
			return IBool\Type::box(IString\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IString\Type $ys                                   the right operand
		 * @return IBool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(IString\Type $xs, IString\Type $ys) { // >
			return IBool\Type::box(IString\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IString\Type $ys                                   the right operand
		 * @return IBool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(IString\Type $xs, IString\Type $ys) { // <=
			return IBool\Type::box(IString\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IString\Type $ys                                   the right operand
		 * @return IBool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(IString\Type $xs, IString\Type $ys) { // <
			return IBool\Type::box(IString\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IString\Type $ys                                   the right operand
		 * @return IString\Type                                      the maximum value
		 */
		public static function max(IString\Type $xs, IString\Type $ys) {
			return (IString\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @param IString\Type $ys                                   the right operand
		 * @return IString\Type                                      the minimum value
		 */
		public static function min(IString\Type $xs, IString\Type $ys) {
			return (IString\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

	}

}
