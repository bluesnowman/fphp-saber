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

namespace Saber\Core\Bool {

	use \Saber\Control;
	use \Saber\Core;

	class Module {

		#region Methods -> Data Typing

		/**
		 * This method return the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the object to be converted
		 * @return Core\Int32                                       the value as an Int32
		 */
		public static function toInt32(Core\Bool $x) {
			return Core\Int32::create($x->unbox());
		}

		/**
		 * This method returns the value as a String.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the object to be converted
		 * @return Core\Int32                                       the value as a String
		 */
		public static function toString(Core\Bool $x) {
			return Core\String::create($x->__toString());
		}

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the object to be evaluated
		 * @return Core\String                                      the object's class type
		 */
		public static function typeOf(Core\Bool $x) {
			return Core\String::create(get_class($x));
		}

		#endregion

		#region Methods -> Equality

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Data $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Core\Bool $x, Core\Data $y) { // ==
			if ($y instanceof Core\Bool) {
				return Core\Bool::create($x->unbox() == $y->unbox());
			}
			return Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Data $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Core\Bool $x, Core\Data $y) { // ===
			if (get_class($x) === get_class($y)) {
				return Core\Bool::create($x->unbox() === $y->unbox());
			}
			return Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Data $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Core\Bool $x, Core\Data $y) { // !=
			return Core\Bool\Module::not(Core\Bool\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Data $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Core\Bool $x, Core\Data $y) { // !==
			return Core\Bool\Module::not(Core\Bool\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Logical

		/**
		 * This method returns whether both operands are "true".
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Bool $y                                      the right operand
		 * @return Core\Bool                                        whether both operands are "true"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_conjunction
		 */
		public static function and_(Core\Bool $x, Core\Bool $y) {
			return Core\Bool::create($x->unbox() && $y->unbox());
		}

		/**
		 * This method returns whether the left operand implies the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Bool $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand implies
		 *                                                          the right operand
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_implication
		 */
		public static function impl(Core\Bool $x, Core\Bool $y) {
			return Core\Bool::create(!$x->unbox() || $y->unbox());
		}

		/**
		 * This method returns whether at least one operand is "false".
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Bool $y                                      the right operand
		 * @return Core\Bool                                        whether at least one operand is "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_NAND
		 */
		public static function nand(Core\Bool $x, Core\Bool $y) {
			return Core\Bool::create(!($x->unbox() && $y->unbox()));
		}

		/**
		 * This method returns whether both operands are "false".
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Bool $y                                      the right operand
		 * @return Core\Bool                                        whether both operands are "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_NOR
		 */
		public static function nor(Core\Bool $x, Core\Bool $y) {
			return Core\Bool::create(!($x->unbox() || $y->unbox()));
		}

		/**
		 * This method returns whether the operand is "false".
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the operand
		 * @return Core\Bool                                        whether the operand is "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_negation
		 */
		public static function not(Core\Bool $x) {
			return Core\Bool::create(!$x->unbox());
		}

		/**
		 * This method returns whether at least one operand is "true".
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Bool $y                                      the right operand
		 * @return Core\Bool                                        whether at least one operand is "true"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_disjunction
		 */
		public static function or_(Core\Bool $x, Core\Bool $y) {
			return Core\Bool::create($x->unbox() || $y->unbox());
		}

		/**
		 * This method returns whether only if both operands are "true" or "false".
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Bool $y                                      the right operand
		 * @return Core\Bool                                        whether only if both operands are
		 *                                                          "true" or "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_equality
		 */
		public static function xnor(Core\Bool $x, Core\Bool $y) {
			return Core\Bool::create(!($x->unbox() xor $y->unbox()));
		}

		/**
		 * This method returns whether only one operand is "true".
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Bool $y                                      the right operand
		 * @return Core\Bool                                        whether only one operand is "true"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Exclusive_disjunction
		 */
		public static function xor_(Core\Bool $x, Core\Bool $y) {
			return Core\Bool::create($x->unbox() xor $y->unbox());
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Bool $y                                      the right operand
		 * @return Core\Int32                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Core\Bool $x, Core\Bool $y) {
			$__x = $x->unbox();
			$__y = $y->unbox();

			if (!$__x && $__y) {
				return Core\Int32::negative();
			}
			else if ($__x == $__y) {
				return Core\Int32::zero();
			}
			else { // ($__x && !$__y)
				return Core\Int32::one();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Bool $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Core\Bool $x, Core\Bool $y) { // >=
			return (Core\Bool\Module::compare($x, $y)->unbox() >= 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Bool $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Core\Bool $x, Core\Bool $y) { // >
			return (Core\Bool\Module::compare($x, $y)->unbox() > 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Bool $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Core\Bool $x, Core\Bool $y) { // <=
			return (Core\Bool\Module::compare($x, $y)->unbox() <= 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Bool $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Core\Bool $x, Core\Bool $y) { // <
			return (Core\Bool\Module::compare($x, $y)->unbox() < 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Bool $y                                      the right operand
		 * @return Core\Int32                                       the maximum value
		 */
		public static function max(Core\Bool $x, Core\Bool $y) {
			return (Core\Bool\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the left operand
		 * @param Core\Bool $y                                      the right operand
		 * @return Core\Int32                                       the minimum value
		 */
		public static function min(Core\Bool $x, Core\Bool $y) {
			return (Core\Bool\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Other

		/**
		 * This method returns a choice block.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the object to be evaluated
		 * @return Control\Monad\Choice                             the choice monad
		 */
		public static function choice(Core\Bool $x) {
			return Control\Monad::choice($x);
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @static
		 * @param Core\Bool $x                                      the object to be evaluated
		 * @return string                                           the object's hash code
		 */
		public static function hashCode(Core\Bool $x) {
			return Core\String::create($x->__toString());
		}

		#endregion

	}

}