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

namespace Saber\Data\Integer {

	use \Saber\Core;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Bool;
	use \Saber\Data\Int32;
	use \Saber\Data\Integer;
	use \Saber\Data\Integral;
	use \Saber\Data\String;
	use \Saber\Data\Tuple;

	/**
	 * @see http://php.net/manual/en/ref.gmp.php
	 * @see http://verysimple.com/2013/11/05/compile-php-extensions-for-mamp/
	 * @see http://coder1.com/articles/how-to-install-php-gmp-mac-osx-1037
	 */
	class Module extends Integral\Module {

		#region Methods -> Arithmetic

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the operand
		 * @return Integer\Type                                     the result
		 */
		public static function abs(Integer\Type $x) {
			return Integer\Type::box(gmp_strval(gmp_abs($x->unbox())));
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the result
		 */
		public static function add(Integer\Type $x, Integer\Type $y) {
			return Integer\Type::box(gmp_strval(gmp_add($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the operand
		 * @return Integer\Type                                     the result
		 */
		public static function decrement(Integer\Type $x) {
			return Integer\Module::subtract($x, Integer\Type::one());
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the result
		 */
		public static function divide(Integer\Type $x, Integer\Type $y) {
			return Integer\Type::box(gmp_strval(gmp_div_q($x->unbox(), $y->unbox())));
		}

		/**
		 * This method computes the factorial of an integer.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $n                                   the operand
		 * @return Integer\Type                                     the result
		 */
		public static function factorial(Integer\Type $n) {
			return (Integer\Module::eq($n, Integer\Type::zero())->unbox())
				? Integer\Type::one()
				: Integer\Module::multiply($n, Integer\Module::factorial(Integer\Module::decrement($n)));
		}

		/**
		 * This method returns the greatest common divisor.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the result
		 */
		public static function gcd(Integer\Type $x, Integer\Type $y) {
			return Integer\Type::box(gmp_strval(gmp_gcd($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the operand
		 * @return Integer\Type                                     the result
		 */
		public static function increment(Integer\Type $x) {
			return Integer\Module::add($x, Integer\Type::one());
		}

		/**
		 * This method returns the result of finding the modulus of the specified value against this
		 * object's value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the result
		 */
		public static function modulo(Integer\Type $x, Integer\Type $y) {
			return Integer\Type::box(gmp_strval(gmp_div_r($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the result
		 */
		public static function multiply(Integer\Type $x, Integer\Type $y) {
			return Integer\Type::box(gmp_strval(gmp_mul($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the operand
		 * @return Integer\Type                                     the result
		 */
		public static function negate(Integer\Type $x) {
			return Integer\Type::box(gmp_strval(gmp_neg($x->unbox())));
		}

		/**
		 * This method returns a list of all numbers for the specified sequence.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   where to start
		 * @param Core\Type $y                                      either an integer representing
		 *                                                          the end of the sequence or a
		 *                                                          tuple describing the sequence
		 * @return ArrayList\Type                                   an empty array list
		 */
		public static function sequence(Integer\Type $x, Core\Type $y) {
			$buffer = array();

			if ($y instanceof Tuple\Type) {
				$s = Integer\Module::subtract($y->first(), $x);
				$n = $y->second();
			}
			else { // ($y instanceof Integer\Type)
				$s = Integer\Type::one();
				$n = $y;
			}

			if (Integer\Module::isNegative($s)->unbox()) {
				for ($i = $x; Integer\Module::ge($i, $n)->unbox(); $i = Integer\Module::add($i, $s)) {
					$buffer[] = $i;
				}
			}
			else {
				for ($i = $x; Integer\Module::le($i, $n)->unbox(); $i = Integer\Module::add($i, $s)) {
					$buffer[] = $i;
				}
			}

			return ArrayList\Type::box($buffer);
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the result
		 */
		public static function subtract(Integer\Type $x, Integer\Type $y) {
			return Integer\Type::box(gmp_strval(gmp_sub($x->unbox(), $y->unbox())));
		}

		#endregion

		#region Methods -> Equality

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Integer\Type $x, Core\Type $y) { // ==
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
		 * @param Integer\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Integer\Type $x, Core\Type $y) { // ===
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
		 * @param Integer\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Integer\Type $x, Core\Type $y) { // !=
			return Bool\Module::not(Integer\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Integer\Type $x, Core\Type $y) { // !==
			return Bool\Module::not(Integer\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Integer\Type $x, Integer\Type $y) {
			if (($x === null) && ($y !== null)) {
				return Int32\Type::negative();
			}
			if (($x === null) && ($y === null)) {
				return Int32\Type::zero();
			}
			if (($x !== null) && ($y === null)) {
				return Int32\Type::one();
			}

			return Int32\Type::box(gmp_cmp($x->unbox(), $y->unbox()));
		}

		#endregion

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Integer\Type $x, Integer\Type $y) { // >=
			return Bool\Type::box(Integer\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Integer\Type $x, Integer\Type $y) { // >
			return Bool\Type::box(Integer\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Integer\Type $x, Integer\Type $y) { // <=
			return Bool\Type::box(Integer\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Integer\Type $x, Integer\Type $y) { // <
			return Bool\Type::box(Integer\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the maximum value
		 */
		public static function max(Integer\Type $x, Integer\Type $y) {
			return (Integer\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the left operand
		 * @param Integer\Type $y                                   the right operand
		 * @return Integer\Type                                     the minimum value
		 */
		public static function min(Integer\Type $x, Integer\Type $y) {
			return (Integer\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Validation

		/**
		 * This method evaluates whether the operand is an even number.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the object to be evaluated
		 * @return Bool\Type                                        whether the operand is an even
		 *                                                          number
		 */
		public static function isEven(Integer\Type $x) {
			return Bool\Type::box(gmp_strval(gmp_div_r($x->unbox(), '2')) == '0');
		}

		/**
		 * This method evaluates whether the operand is an odd number.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the object to be evaluated
		 * @return Bool\Type                                        whether the operand is an odd
		 *                                                          number
		 */
		public static function isOdd(Integer\Type $x) {
			return Bool\Type::box(gmp_strval(gmp_div_r($x->unbox(), '2')) != '0');
		}

		/**
		 * This method returns whether the operand is a negative number.
		 *
		 * @access public
		 * @static
		 * @param Integer\Type $x                                   the object to be evaluated
		 * @return Bool\Type                                        whether the operand is a negative
		 *                                                          number
		 */
		public static function isNegative(Integer\Type $x) {
			return Bool\Type::box(gmp_sign($x->unbox()) == -1);
		}

		#endregion

	}

}