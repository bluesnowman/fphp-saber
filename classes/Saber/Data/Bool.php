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

	use \Saber\Control;
	use \Saber\Data;

	class Bool extends Data\Type implements Data\Type\Boxable, Data\Val {

		#region Methods -> Implementation

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param boolean $value                                    the value to be assigned
		 */
		public function __construct($value) {
			$this->value = (bool) $value;
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString() {
			return ($this->value) ? 'true' : 'false';
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
		 * @return Data\Type                                        the boxed object
		 */
		public static function box($value/*...*/) {
			if ((func_num_args() > 1) && func_get_arg(1) && is_string($value) && in_array(strtolower($value), array('false', 'f', 'no', 'n', '0'))) {
				$value = false;
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
		 * @return Data\Type                                        the boxed object
		 */
		public static function create($value/*...*/) {
			return new static($value);
		}

		/**
		 * This method returns an object with a "false" value.
		 *
		 * @access public
		 * @return Data\Bool                                        the object
		 */
		public static function false() {
			return Data\Bool::create(false);
		}

		/**
		 * This method returns an object with a "true" value.
		 *
		 * @access public
		 * @return Data\Bool                                        the object
		 */
		public static function true() {
			return Data\Bool::create(true);
		}

		#endregion

		#region Methods -> Data Typing

		/**
		 * This method return the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the object to be converted
		 * @return Data\Int32                                       the value as an Int32
		 */
		public static function toInt32(Data\Bool $x) {
			return Data\Int32::create($x->unbox());
		}

		/**
		 * This method returns the value as a String.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the object to be converted
		 * @return Data\String                                      the value as a String
		 */
		public static function toString(Data\Bool $x) {
			return Data\String::create($x->__toString());
		}

		#endregion

		#region Methods -> Equality

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Data\Bool $x, Data\Type $y) { // ==
			$class = get_class($x);
			if ($y instanceof $class) {
				return Data\Bool::create($x->unbox() == $y->unbox());
			}
			return Data\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Data\Bool $x, Data\Type $y) { // ===
			if (get_class($x) === get_class($y)) {
				return Data\Bool::create($x->unbox() === $y->unbox());
			}
			return Data\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Data\Bool $x, Data\Type $y) { // !=
			return Data\Bool::not(Data\Bool::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Data\Bool $x, Data\Type $y) { // !==
			return Data\Bool::not(Data\Bool::id($x, $y));
		}

		#endregion

		#region Methods -> Logical

		/**
		 * This method returns whether both operands are "true".
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Bool $y                                      the right operand
		 * @return Data\Bool                                        whether both operands are "true"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_conjunction
		 */
		public static function and_(Data\Bool $x, Data\Bool $y) {
			return Data\Bool::create($x->unbox() && $y->unbox());
		}

		/**
		 * This method returns whether the left operand implies the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Bool $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand implies
		 *                                                          the right operand
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_implication
		 */
		public static function impl(Data\Bool $x, Data\Bool $y) {
			return Data\Bool::create(!$x->unbox() || $y->unbox());
		}

		/**
		 * This method returns whether at least one operand is "false".
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Bool $y                                      the right operand
		 * @return Data\Bool                                        whether at least one operand is "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_NAND
		 */
		public static function nand(Data\Bool $x, Data\Bool $y) {
			return Data\Bool::create(!($x->unbox() && $y->unbox()));
		}

		/**
		 * This method returns whether both operands are "false".
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Bool $y                                      the right operand
		 * @return Data\Bool                                        whether both operands are "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_NOR
		 */
		public static function nor(Data\Bool $x, Data\Bool $y) {
			return Data\Bool::create(!($x->unbox() || $y->unbox()));
		}

		/**
		 * This method returns whether the operand is "false".
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the operand
		 * @return Data\Bool                                        whether the operand is "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_negation
		 */
		public static function not(Data\Bool $x) {
			return Data\Bool::create(!$x->unbox());
		}

		/**
		 * This method returns whether at least one operand is "true".
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Bool $y                                      the right operand
		 * @return Data\Bool                                        whether at least one operand is "true"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_disjunction
		 */
		public static function or_(Data\Bool $x, Data\Bool $y) {
			return Data\Bool::create($x->unbox() || $y->unbox());
		}

		/**
		 * This method returns whether only if both operands are "true" or "false".
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Bool $y                                      the right operand
		 * @return Data\Bool                                        whether only if both operands are
		 *                                                          "true" or "false"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Logical_equality
		 */
		public static function xnor(Data\Bool $x, Data\Bool $y) {
			return Data\Bool::create(!($x->unbox() xor $y->unbox()));
		}

		/**
		 * This method returns whether only one operand is "true".
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Bool $y                                      the right operand
		 * @return Data\Bool                                        whether only one operand is "true"
		 *
		 * @see http://en.wikipedia.org/wiki/Truth_table#Exclusive_disjunction
		 */
		public static function xor_(Data\Bool $x, Data\Bool $y) {
			return Data\Bool::create($x->unbox() xor $y->unbox());
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Bool $y                                      the right operand
		 * @return Data\Int32                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Data\Bool $x, Data\Bool $y) {
			$__x = $x->unbox();
			$__y = $y->unbox();

			if (!$__x && $__y) {
				return Data\Int32::negative();
			}
			else if ($__x == $__y) {
				return Data\Int32::zero();
			}
			else { // ($__x && !$__y)
				return Data\Int32::one();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Bool $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Data\Bool $x, Data\Bool $y) { // >=
			return Data\Bool::create(Data\Bool::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Bool $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Data\Bool $x, Data\Bool $y) { // >
			return Data\Bool::create(Data\Bool::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Bool $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Data\Bool $x, Data\Bool $y) { // <=
			return Data\Bool::create(Data\Bool::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Bool $y                                      the right operand
		 * @return Data\Bool                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Data\Bool $x, Data\Bool $y) { // <
			return Data\Bool::create(Data\Bool::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Bool $y                                      the right operand
		 * @return Data\Int32                                       the maximum value
		 */
		public static function max(Data\Bool $x, Data\Bool $y) {
			return (Data\Bool::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the left operand
		 * @param Data\Bool $y                                      the right operand
		 * @return Data\Int32                                       the minimum value
		 */
		public static function min(Data\Bool $x, Data\Bool $y) {
			return (Data\Bool::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Other

		/**
		 * This method returns a choice block.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the object to be evaluated
		 * @return Control\Monad\Choice                             the choice monad
		 */
		public static function choice(Data\Bool $x) {
			return Control\Monad::choice($x);
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the object to be evaluated
		 * @return Data\String                                      the object's hash code
		 */
		public static function hashCode(Data\Bool $x) {
			return Data\String::create($x->__toString());
		}

		#endregion

	}

}