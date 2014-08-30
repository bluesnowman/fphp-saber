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

namespace Saber\Data\Bool {

	use \Saber\Data;

	class Module {

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
		public static function implies(Data\Bool $x, Data\Bool $y) {
			return Data\Bool::create(!$x->unbox() || $y->unbox());
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
			return Data\Bool::create(!$x->unbox() || !$y->unbox());
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
			return Data\Bool::create(!$x->unbox() && !$y->unbox());
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
		 * This method converts the boolean value to a string value.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the object to be converted
		 * @return Data\String                                      an object representing the converted
		 *                                                          value
		 */
		public static function toString(Data\Bool $x) {
			return Data\String::create($x->__toString());
		}

		/**
		 * This method casts the boolean value to an int32 value.
		 *
		 * @access public
		 * @static
		 * @param Data\Bool $x                                      the object to be casted
		 * @return Data\Int32                                       an object representing the casted
		 *                                                          value
		 */
		public static function toInt32(Data\Bool $x) {
			return Data\Int32::create($x->unbox());
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

	}

}