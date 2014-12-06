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

namespace Saber\Data\Regex {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Bool;
	use \Saber\Data\Int32;
	use \Saber\Data\Regex;
	use \Saber\Data\String;
	use \Saber\Data\Tuple;

	final class Module extends Data\Module {

		#region Methods -> Basic Operations

		/**
		 * This method returns whether the specified object matches the regular expression.
		 *
		 * @access public
		 * @static
		 * @param Regex\Type $x                                     the regular expression
		 * @param Core\Type $ys                                     the object to be evaluated
		 * @return Bool\Type                                        whether the specified object matches
		 *                                                          the regular expression
		 */
		public static function match(Regex\Type $x, Core\Type $ys) {
			return Bool\Type::box(preg_match($x->unbox(), $ys->__toString()));
		}

		/**
		 * This method returns a new string after replacing any matches with the specified
		 * replacement.
		 *
		 * @access public
		 * @static
		 * @param Regex\Type $x                                     the regular expression
		 * @param Tuple\Type $ys                                    a tuple containing the replacement
		 *                                                          and the object that is the subject
		 * @return String\Type                                      the string after being processed
		 */
		public static function replace(Regex\Type $x, Tuple\Type $ys) {
			return String\Type::box(preg_replace($x->unbox(), $ys->first()->__toString(), $ys->second()->__toString()));
		}

		/**
		 * This method returns an array of sub-strings that were split on the regular expression.
		 *
		 * @access public
		 * @static
		 * @param Regex\Type $x                                     the regular expression
		 * @param Core\Type $ys                                     the object to be split
		 * @return ArrayList\Type                                   an array of sub-strings
		 */
		public static function split(Regex\Type $x, Core\Type $ys) {
			$buffer = ($ys instanceof Tuple\Type)
				? preg_split($x->unbox(), $ys->first()->__toString(), $ys->second()->__toString())
				: preg_split($x->unbox(), $ys->__toString());
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
		 * @param Regex\Type $x                                     the value to be evaluated
		 * @param Regex\Type $y                                     the default value
		 * @return Regex\Type                                       the result
		 */
		public static function nvl(Regex\Type $x = null, Regex\Type $y = null) {
			return ($x !== null) ? $x : (($y !== null) ? $y : Regex\Type::box('/^.*$/'));
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the specified object is equal to the current object.
		 *
		 * @access public
		 * @static
		 * @param Regex\Type $xs                                    the left operand
		 * @param Core\Type $ys                                     the object to be evaluated
		 * @return Bool\Type                                        whether the specified object is equal
		 *                                                          to the current object
		 */
		public static function eq(Regex\Type $xs, Core\Type $ys) {
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
		 * @param Regex\Type $xs                                    the left operand
		 * @param Core\Type $ys                                     the object to be evaluated
		 * @return Bool\Type                                        whether the specified object is identical
		 *                                                          to the current object
		 */
		public static function id(Regex\Type $xs, Core\Type $ys) {
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
		 * @param Regex\Type $xs                                    the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Regex\Type $xs, Core\Type $ys) { // !=
			return Bool\Module::not(Regex\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Regex\Type $xs                                    the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Regex\Type $xs, Core\Type $ys) { // !==
			return Bool\Module::not(Regex\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @static
		 * @param Regex\Type $xs                                    the left operand
		 * @param Regex\Type $ys                                    the object to be compared
		 * @return Int32\Type                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public static function compare(Regex\Type $xs, Regex\Type $ys) {
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
		 * @param Regex\Type $xs                                    the left operand
		 * @param Regex\Type $ys                                    the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Regex\Type $xs, Regex\Type $ys) { // >=
			return Bool\Type::box(Regex\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Regex\Type $xs                                    the left operand
		 * @param Regex\Type $ys                                    the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Regex\Type $xs, Regex\Type $ys) { // >
			return Bool\Type::box(Regex\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Regex\Type $xs                                    the left operand
		 * @param Regex\Type $ys                                    the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Regex\Type $xs, Regex\Type $ys) { // <=
			return Bool\Type::box(Regex\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Regex\Type $xs                                    the left operand
		 * @param Regex\Type $ys                                    the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Regex\Type $xs, Regex\Type $ys) { // <
			return Bool\Type::box(Regex\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Regex\Type $xs                                    the left operand
		 * @param Regex\Type $ys                                    the right operand
		 * @return Int32\Type                                       the maximum value
		 */
		public static function max(Regex\Type $xs, Regex\Type $ys) {
			return (Regex\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Regex\Type $xs                                    the left operand
		 * @param Regex\Type $ys                                    the right operand
		 * @return Int32\Type                                       the minimum value
		 */
		public static function min(Regex\Type $xs, Regex\Type $ys) {
			return (Regex\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

	}

}