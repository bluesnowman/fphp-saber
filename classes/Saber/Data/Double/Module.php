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

namespace Saber\Data\Double {

	use \Saber\Core;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Bool;
	use \Saber\Data\Double;
	use \Saber\Data\Float;
	use \Saber\Data\Floating;
	use \Saber\Data\Int32;
	use \Saber\Data\Integer;
	use \Saber\Data\String;
	use \Saber\Data\Tuple;

	class Module extends Floating\Module {

		#region Methods -> Arithmetic

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the operand
		 * @return Double\Type                                      the result
		 */
		public static function abs(Double\Type $x) {
			return Double\Type::box(abs($x->unbox()));
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Double\Type $y                                    the right operand
		 * @return Double\Type                                      the result
		 */
		public static function add(Double\Type $x, Double\Type $y) {
			return Double\Type::box($x->unbox() + $y->unbox());
		}

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the operand
		 * @return Double\Type                                      the result
		 */
		public static function decrement(Double\Type $x) {
			return Double\Module::subtract($x, Double\Type::one());
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Double\Type $y                                    the right operand
		 * @return Double\Type                                      the result
		 */
		public static function divide(Double\Type $x, Double\Type $y) {
			return Double\Type::box($x->unbox() / $y->unbox());
		}

		/**
		 * This method recursively calculates the greatest common divisor.
		 *
		 * @access protected
		 * @static
		 * @param double $x                                         the left operand
		 * @param double $y                                         the right operand
		 * @return double                                           the result
		 *
		 * @see http://stackoverflow.com/questions/13828011/look-for-the-gcd-greatest-common-divisor-of-more-than-2-integers
		 */
		protected function _gcd($x, $y) {
		    return ($y > 0.01) ? Double\Module::_gcd($y, fmod($x, $y)) : $x;
		}

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the operand
		 * @return Double\Type                                      the result
		 */
		public static function increment(Double\Type $x) {
			return Double\Module::add($x, Double\Type::one());
		}

		/**
		 * This method returns the result of finding the modulus of the specified value against this
		 * object's value.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Double\Type $y                                    the right operand
		 * @return Double\Type                                      the result
		 */
		public static function modulo(Double\Type $x, Double\Type $y) {
			return Double\Type::box(fmod($x->unbox(), $y->unbox()));
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Double\Type $y                                    the right operand
		 * @return Double\Type                                      the result
		 */
		public static function multiply(Double\Type $x, Double\Type $y) {
			return Double\Type::box($x->unbox() * $y->unbox());
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the operand
		 * @return Double\Type                                      the result
		 */
		public static function negate(Double\Type $x) {
			return Double\Type::box($x->unbox() * -1.0);
		}

		/**
		 * This method returns a list of all numbers for the specified sequence.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    where to start
		 * @param Core\Type $y                                      either an integer representing
		 *                                                          the end of the sequence or a
		 *                                                          tuple describing the sequence
		 * @return ArrayList\Type                                   an empty array list
		 */
		public static function sequence(Double\Type $x, Core\Type $y) {
			$buffer = array();

			if ($y instanceof Tuple\Type) {
				$s = Double\Module::subtract($y->first(), $x);
				$n = $y->second();
			}
			else { // ($y instanceof Double\Type)
				$s = Double\Type::one();
				$n = $y;
			}

			for ($i = $x; Double\Module::le($i, $n)->unbox(); $i = Double\Module::add($i, $s)) {
				$buffer[] = $i;
			}

			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Double\Type $y                                    the right operand
		 * @return Double\Type                                      the result
		 */
		public static function subtract(Double\Type $x, Double\Type $y) {
			return Double\Type::box($x->unbox() - $y->unbox());
		}

		#endregion

		#region Methods -> Conversion

		/**
		 * This method return the value as a Double. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the object to be converted
		 * @return Double\Type                                      the value as a Double
		 */
		public static function toDouble(Double\Type $x) {
			return Double\Type::box($x->unbox());
		}

		/**
		 * This method return the value as a Float. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the object to be converted
		 * @return Float\Type                                       the value as a Float
		 */
		public static function toFloat(Double\Type $x) {
			return Float\Type::box($x->unbox());
		}

		/**
		 * This method return the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the object to be converted
		 * @return Int32\Type                                       the value as an Int32
		 */
		public static function toInt32(Double\Type $x) {
			return Int32\Type::box($x->unbox());
		}

		/**
		 * This method return the value as an Integer. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the object to be converted
		 * @return Integer\Type                                     the value as an Integer
		 */
		public static function toInteger(Double\Type $x) {
			return Integer\Type::box($x->unbox());
		}

		#endregion

		#region Methods -> Equality

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Double\Type $x, Core\Type $y) { // ==
			$type = $x->__typeOf();
			if ($y !== null) {
				if ($y instanceof $type) {
					return Bool\Type::box($x->unbox() == $y->unbox());
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Double\Type $x, Core\Type $y) { // ===
			if ($y !== null) {
				if ($x->__typeOf() === $y->__typeOf()) {
					return Bool\Type::box($x->unbox() === $y->unbox());
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Double\Type $x, Core\Type $y) { // !=
			return Bool\Module::not(Double\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Double\Type $x, Core\Type $y) { // !==
			return Bool\Module::not(Double\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Double\Type $y                                    the right operand
		 * @return Int32\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Double\Type $x, Double\Type $y) {
			if (($x === null) && ($y !== null)) {
				return Int32\Type::negative();
			}
			if (($x === null) && ($y === null)) {
				return Int32\Type::zero();
			}
			if (($x !== null) && ($y === null)) {
				return Int32\Type::one();
			}

			$__x = $x->unbox();
			$__y = $y->unbox();

			if ($__x < $__y) {
				return Int32\Type::negative();
			}
			else if ($__x == $__y) {
				return Int32\Type::zero();
			}
			else { // ($__x > $__y)
				return Int32\Type::one();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Double\Type $y                                    the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Double\Type $x, Double\Type $y) { // >=
			return Bool\Type::box(Double\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Double\Type $y                                    the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Double\Type $x, Double\Type $y) { // >
			return Bool\Type::box(Double\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Double\Type $y                                    the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Double\Type $x, Double\Type $y) { // <=
			return Bool\Type::box(Double\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Double\Type $y                                    the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Double\Type $x, Double\Type $y) { // <
			return Bool\Type::box(Double\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Double\Type $y                                    the right operand
		 * @return Double\Type                                      the maximum value
		 */
		public static function max(Double\Type $x, Double\Type $y) {
			return (Double\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the left operand
		 * @param Double\Type $y                                    the right operand
		 * @return Double\Type                                      the minimum value
		 */
		public static function min(Double\Type $x, Double\Type $y) {
			return (Double\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Validation

		/**
		 * This method returns whether the operand is a negative number.
		 *
		 * @access public
		 * @static
		 * @param Double\Type $x                                    the object to be evaluated
		 * @return Bool\Type                                        whether the operand is a negative
		 *                                                          number
		 */
		public static function isNegative(Double\Type $x) {
			return Bool\Type::box($x->unbox() < 0);
		}

		#endregion

	}

}