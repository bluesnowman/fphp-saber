<?php

/**
 * Copyright 2014-2016 Blue Snowman
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

declare(strict_types = 1);

namespace Saber\Data\IRegex {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IInt32;
	use \Saber\Data\IRegex;
	use \Saber\Data\IString;
	use \Saber\Data\ITrit;
	use \Saber\Data\ITuple;

	final class Module extends Data\Module {

		#region Methods -> Basic Operations

		/**
		 * This method returns whether the specified object matches the regular expression.
		 *
		 * @access public
		 * @static
		 * @param IRegex\Type $x                                    the regular expression
		 * @param Core\Type $ys                                     the object to be evaluated
		 * @return IBool\Type                                       whether the specified object matches
		 *                                                          the regular expression
		 */
		public static function match(IRegex\Type $x, Core\Type $ys) : IBool\Type {
			return IBool\Type::box(preg_match($x->unbox(), $ys->__toString()));
		}

		/**
		 * This method returns a new string after replacing any matches with the specified
		 * replacement.
		 *
		 * @access public
		 * @static
		 * @param IRegex\Type $x                                    the regular expression
		 * @param ITuple\Type $ys                                   a tuple containing the replacement
		 *                                                          and the object that is the subject
		 * @return IString\Type                                     the string after being processed
		 */
		public static function replace(IRegex\Type $x, ITuple\Type $ys) : IString\Type {
			return IString\Type::box(preg_replace($x->unbox(), $ys->first()->__toString(), $ys->second()->__toString()));
		}

		/**
		 * This method returns an array of sub-strings that were split on the regular expression.
		 *
		 * @access public
		 * @static
		 * @param IRegex\Type $x                                    the regular expression
		 * @param Core\Type $ys                                     the object to be split
		 * @return IArrayList\Type                                  an array of sub-strings
		 */
		public static function split(IRegex\Type $x, Core\Type $ys) : IArrayList\Type {
			$zs = ($ys instanceof ITuple\Type)
				? preg_split($x->unbox(), $ys->first()->__toString(), $ys->second()->__toString())
				: preg_split($x->unbox(), $ys->__toString());
			return IArrayList\Type::box(array_map(function($z) {
				return IString\Type::box($z);
			}, $zs));
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param IRegex\Type $x                                    the value to be evaluated
		 * @param IRegex\Type $y                                    the default value
		 * @return IRegex\Type                                      the result
		 */
		public static function nvl(IRegex\Type $x = null, IRegex\Type $y = null) : IRegex\Type {
			return ($x !== null) ? $x : (($y !== null) ? $y : IRegex\Type::box('/^.*$/'));
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the specified object is equal to the current object.
		 *
		 * @access public
		 * @static
		 * @param IRegex\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the object to be evaluated
		 * @return IBool\Type                                       whether the specified object is equal
		 *                                                          to the current object
		 */
		public static function eq(IRegex\Type $xs, Core\Type $ys) : IBool\Type {
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
		 * @param IRegex\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the object to be evaluated
		 * @return IBool\Type                                       whether the specified object is identical
		 *                                                          to the current object
		 */
		public static function id(IRegex\Type $xs, Core\Type $ys) : IBool\Type {
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
		 * @param IRegex\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(IRegex\Type $xs, Core\Type $ys) : IBool\Type { // !=
			return IBool\Module::not(IRegex\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IRegex\Type $xs                                   the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return IBool\Type                                       whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(IRegex\Type $xs, Core\Type $ys) : IBool\Type { // !==
			return IBool\Module::not(IRegex\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param IRegex\Type $xs                                   the left operand
		 * @param IRegex\Type $ys                                   the object to be compared
		 * @return ITrit\Type                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(IRegex\Type $xs, IRegex\Type $ys) : ITrit\Type {
			return ITrit\Type::make(strcmp($xs->unbox(), $ys->unbox()));
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IRegex\Type $xs                                   the left operand
		 * @param IRegex\Type $ys                                   the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(IRegex\Type $xs, IRegex\Type $ys) : IBool\Type { // >=
			return IBool\Type::box(IRegex\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IRegex\Type $xs                                   the left operand
		 * @param IRegex\Type $ys                                   the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(IRegex\Type $xs, IRegex\Type $ys) : IBool\Type { // >
			return IBool\Type::box(IRegex\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IRegex\Type $xs                                   the left operand
		 * @param IRegex\Type $ys                                   the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(IRegex\Type $xs, IRegex\Type $ys) : IBool\Type { // <=
			return IBool\Type::box(IRegex\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IRegex\Type $xs                                   the left operand
		 * @param IRegex\Type $ys                                   the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(IRegex\Type $xs, IRegex\Type $ys) : IBool\Type { // <
			return IBool\Type::box(IRegex\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param IRegex\Type $xs                                   the left operand
		 * @param IRegex\Type $ys                                   the right operand
		 * @return IRegex\Type                                      the maximum value
		 */
		public static function max(IRegex\Type $xs, IRegex\Type $ys) : IRegex\Type {
			return (IRegex\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param IRegex\Type $xs                                   the left operand
		 * @param IRegex\Type $ys                                   the right operand
		 * @return IRegex\Type                                      the minimum value
		 */
		public static function min(IRegex\Type $xs, IRegex\Type $ys) : IRegex\Type {
			return (IRegex\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

	}

}