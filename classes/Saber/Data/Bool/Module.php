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

namespace Saber\Bool\Type {

	use \Saber\Control;
	use \Saber\Data;

	class Module extends Data\Module {

		#region Methods -> Instantiation

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Bool\Type                                        the boxed object
		 */
		public static function box($value/*...*/) {
			if ((func_num_args() > 1) && func_get_arg(1) && is_string($value) && in_array(strtolower($value), array('false', 'f', 'no', 'n', '0'))) {
				$value = false;
			}
			return new Bool\Type($value);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Bool\Type                                        the boxed object
		 */
		public static function create($value/*...*/) {
			return new Bool\Type($value);
		}

		/**
		 * This method returns an object with a "false" value.
		 *
		 * @access public
		 * @return Bool\Type                                        the object
		 */
		public static function false() {
			return Bool\Module::create(false);
		}

		/**
		 * This method returns an object with a "true" value.
		 *
		 * @access public
		 * @return Bool\Type                                        the object
		 */
		public static function true() {
			return Bool\Module::create(true);
		}

		#endregion

		#region Methods -> Data Typing

		/**
		 * This method return the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the object to be converted
		 * @return Int32\Type                                       the value as an Int32
		 */
		public static function toInt32(Bool\Type $x) {
			return Int32\Type::create($x->unbox());
		}

		/**
		 * This method returns the value as a String.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the object to be converted
		 * @return String\Type                                      the value as a String
		 */
		public static function toString(Bool\Type $x) {
			return String\Module::create($x->__toString());
		}

		#endregion

		#region Methods -> Equality

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Bool\Type $x, Data\Type $y) { // ==
			$class = get_class($x);
			if ($y instanceof $class) {
				return Bool\Module::create($x->unbox() == $y->unbox());
			}
			return Bool\Module::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Bool\Type $x, Data\Type $y) { // ===
			if (get_class($x) === get_class($y)) {
				return Bool\Module::create($x->unbox() === $y->unbox());
			}
			return Bool\Module::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Bool\Type $x, Data\Type $y) { // !=
			return Bool\Module::not(Bool\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Bool\Type $x, Data\Type $y) { // !==
			return Bool\Module::not(Bool\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Logical

		/**
		 * This method returns whether both operands are "true".
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether both operands are "true"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_conjunction
		 */
		public static function and_(Bool\Type $x, Bool\Type $y) {
			return Bool\Module::create($x->unbox() && $y->unbox());
		}

		/**
		 * This method returns whether the left operand implies the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand implies
		 *                                                          the right operand
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_implication
		 */
		public static function impl(Bool\Type $x, Bool\Type $y) {
			return Bool\Module::create(!$x->unbox() || $y->unbox());
		}

		/**
		 * This method returns whether at least one operand is "false".
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether at least one operand is "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_NAND
		 */
		public static function nand(Bool\Type $x, Bool\Type $y) {
			return Bool\Module::create(!($x->unbox() && $y->unbox()));
		}

		/**
		 * This method returns whether both operands are "false".
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether both operands are "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_NOR
		 */
		public static function nor(Bool\Type $x, Bool\Type $y) {
			return Bool\Module::create(!($x->unbox() || $y->unbox()));
		}

		/**
		 * This method returns whether the operand is "false".
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the operand
		 * @return Bool\Type                                        whether the operand is "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_negation
		 */
		public static function not(Bool\Type $x) {
			return Bool\Module::create(!$x->unbox());
		}

		/**
		 * This method returns whether at least one operand is "true".
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether at least one operand is "true"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_disjunction
		 */
		public static function or_(Bool\Type $x, Bool\Type $y) {
			return Bool\Module::create($x->unbox() || $y->unbox());
		}

		/**
		 * This method returns whether only if both operands are "true" or "false".
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether only if both operands are
		 *                                                          "true" or "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_equality
		 */
		public static function xnor(Bool\Type $x, Bool\Type $y) {
			return Bool\Module::create(!($x->unbox() xor $y->unbox()));
		}

		/**
		 * This method returns whether only one operand is "true".
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether only one operand is "true"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Exclusive_disjunction
		 */
		public static function xor_(Bool\Type $x, Bool\Type $y) {
			return Bool\Module::create($x->unbox() xor $y->unbox());
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Int32\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Bool\Type $x, Bool\Type $y) {
			$__x = $x->unbox();
			$__y = $y->unbox();

			if (!$__x && $__y) {
				return Int32\Type::negative();
			}
			else if ($__x == $__y) {
				return Int32\Type::zero();
			}
			else { // ($__x && !$__y)
				return Int32\Type::one();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Bool\Type $x, Bool\Type $y) { // >=
			return Bool\Module::create(Bool\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Bool\Type $x, Bool\Type $y) { // >
			return Bool\Module::create(Bool\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Bool\Type $x, Bool\Type $y) { // <=
			return Bool\Module::create(Bool\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Bool\Type $x, Bool\Type $y) { // <
			return Bool\Module::create(Bool\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Int32\Type                                       the maximum value
		 */
		public static function max(Bool\Type $x, Bool\Type $y) {
			return (Bool\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the left operand
		 * @param Bool\Type $y                                      the right operand
		 * @return Int32\Type                                       the minimum value
		 */
		public static function min(Bool\Type $x, Bool\Type $y) {
			return (Bool\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Other

		/**
		 * This method returns a choice block.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the object to be evaluated
		 * @return Control\Monad\Choice                             the choice monad
		 */
		public static function choice(Bool\Type $x) {
			return Control\Monad::choice($x);
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @static
		 * @param Bool\Type $x                                      the object to be evaluated
		 * @return String\Type                                      the object's hash code
		 */
		public static function hashCode(Bool\Type $x) {
			return String\Module::create($x->__toString());
		}

		#endregion

	}

}