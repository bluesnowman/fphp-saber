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

namespace Saber\Data\IInteger {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IDouble;
	use \Saber\Data\IFloat;
	use \Saber\Data\IInt32;
	use \Saber\Data\IInteger;
	use \Saber\Data\IIntegral;
	use \Saber\Data\IString;
	use \Saber\Data\ITrit;
	use \Saber\Data\ITuple;

	/**
	 * @see http://php.net/manual/en/ref.gmp.php
	 * @see http://verysimple.com/2013/11/05/compile-php-extensions-for-mamp/
	 * @see http://coder1.com/articles/how-to-install-php-gmp-mac-osx-1037
	 */
	final class Module extends Data\Module implements IIntegral\Module {

		#region Methods -> Arithmetic Operations

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the operand
		 * @return IInteger\Type                                    the result
		 */
		public static function abs(IInteger\Type $x) : IInteger\Type {
			return IInteger\Type::box(gmp_strval(gmp_abs($x->unbox())));
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param IInteger\Type $y                                  the right operand
		 * @return IInteger\Type                                    the result
		 */
		public static function add(IInteger\Type $x, IInteger\Type $y) : IInteger\Type {
			return IInteger\Type::box(gmp_strval(gmp_add($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the operand
		 * @return IInteger\Type                                    the result
		 */
		public static function decrement(IInteger\Type $x) : IInteger\Type {
			return IInteger\Module::subtract($x, IInteger\Type::one());
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param IInteger\Type $y                                  the right operand
		 * @return IInteger\Type                                    the result
		 */
		public static function divide(IInteger\Type $x, IInteger\Type $y) : IInteger\Type {
			return IInteger\Type::box(gmp_strval(gmp_div_q($x->unbox(), $y->unbox())));
		}

		/**
		 * This method computes the nth factorial number.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $n                                  the operand
		 * @return IInteger\Type                                    the result
		 */
		public static function factorial(IInteger\Type $n) : IInteger\Type {
			return (IInteger\Module::eq($n, IInteger\Type::zero())->unbox())
				? IInteger\Type::one()
				: IInteger\Module::multiply($n, IInteger\Module::factorial(IInteger\Module::decrement($n)));
		}

		/**
		 * This method computes the nth fibonacci number.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $n                                  the operand
		 * @return IInteger\Type                                    the result
		 */
		public static function fibonacci(IInteger\Type $n) : IInteger\Type {
			return (IInteger\Module::le($n, IInteger\Type::one())->unbox())
				? $n
				: IInteger\Module::add(IInteger\Module::fibonacci(IInteger\Module::decrement($n)), IInteger\Module::fibonacci(IInteger\Module::subtract($n, IInteger\Type::box(2))));
		}

		/**
		 * This method returns the greatest common divisor.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param IInteger\Type $y                                  the right operand
		 * @return IInteger\Type                                    the result
		 */
		public static function gcd(IInteger\Type $x, IInteger\Type $y) : IInteger\Type {
			return IInteger\Type::box(gmp_strval(gmp_gcd($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the operand
		 * @return IInteger\Type                                    the result
		 */
		public static function increment(IInteger\Type $x) : IInteger\Type {
			return IInteger\Module::add($x, IInteger\Type::one());
		}

		/**
		 * This method returns the result of finding the modulus of the specified value against this
		 * object's value.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param IInteger\Type $y                                  the right operand
		 * @return IInteger\Type                                    the result
		 */
		public static function modulo(IInteger\Type $x, IInteger\Type $y) : IInteger\Type {
			return IInteger\Type::box(gmp_strval(gmp_div_r($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param IInteger\Type $y                                  the right operand
		 * @return IInteger\Type                                    the result
		 */
		public static function multiply(IInteger\Type $x, IInteger\Type $y) : IInteger\Type {
			return IInteger\Type::box(gmp_strval(gmp_mul($x->unbox(), $y->unbox())));
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the operand
		 * @return IInteger\Type                                    the result
		 */
		public static function negate(IInteger\Type $x) : IInteger\Type {
			return IInteger\Type::box(gmp_strval(gmp_neg($x->unbox())));
		}

		/**
		 * This method returns the number raised to the power of the specified exponent.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the operand
		 * @param IInt32\Type $exponent                             the exponent to be raised by
		 * @return IInteger\Type                                    the result
		 */
		public static function pow(IInteger\Type $x, IInt32\Type $exponent) : IInteger\Type {
			return IInteger\Type::box(gmp_strval(gmp_pow($x->unbox(), $exponent->unbox())));
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param IInteger\Type $y                                  the right operand
		 * @return IInteger\Type                                    the result
		 */
		public static function subtract(IInteger\Type $x, IInteger\Type $y) : IInteger\Type {
			return IInteger\Type::box(gmp_strval(gmp_sub($x->unbox(), $y->unbox())));
		}

		#endregion

		#region Methods -> Basic Operations

		/**
		 * This method returns a list of all numbers for the specified sequence.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  where to start
		 * @param Core\Type $y                                      either an integer representing
		 *                                                          the end of the sequence or a
		 *                                                          tuple describing the sequence
		 * @return IArrayList\Type                                  an empty array list
		 */
		public static function sequence(IInteger\Type $x, Core\Type $y) : IArrayList\Type {
			$buffer = array();

			if ($y instanceof ITuple\Type) {
				$s = IInteger\Module::subtract($y->first(), $x);
				$n = $y->second();
			}
			else { // ($y instanceof IInteger\Type)
				$s = IInteger\Type::one();
				$n = $y;
			}

			if (IInteger\Module::isNegative($s)->unbox()) {
				for ($i = $x; IInteger\Module::ge($i, $n)->unbox(); $i = IInteger\Module::add($i, $s)) {
					$buffer[] = $i;
				}
			}
			else {
				for ($i = $x; IInteger\Module::le($i, $n)->unbox(); $i = IInteger\Module::add($i, $s)) {
					$buffer[] = $i;
				}
			}

			return IArrayList\Type::box($buffer);
		}

		/**
		 * This method returns -1, 0 or 1 when the value is negative, zero, or positive.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the number to be evaluated
		 * @return ITrit\Type                                       the result
		 */
		public static function signum(IInteger\Type $x) : ITrit\Type {
			return ITrit\Type::make($x->unbox());
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the value to be evaluated
		 * @param IInteger\Type $y                                  the default value
		 * @return IInteger\Type                                    the result
		 */
		public static function nvl(IInteger\Type $x = null, IInteger\Type $y = null) : IInteger\Type {
			return ($x !== null) ? $x : (($y !== null) ? $y : IInteger\Type::zero());
		}

		/**
		 * This method returns the value as a IDouble. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the object to be converted
		 * @return IDouble\Type                                     the value as a IDouble
		 */
		public static function toDouble(IInteger\Type $x) : IDouble\Type {
			return IDouble\Type::make($x->unbox());
		}

		/**
		 * This method returns the value as a IFloat. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the object to be converted
		 * @return IFloat\Type                                      the value as a IFloat
		 */
		public static function toFloat(IInteger\Type $x) : IFloat\Type {
			return IFloat\Type::make($x->unbox());
		}

		/**
		 * This method returns the value as an IInt32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the object to be converted
		 * @return IInt32\Type                                      the value as an IInt32
		 */
		public static function toInt32(IInteger\Type $x) : IInt32\Type {
			return IInt32\Type::make($x->unbox());
		}

		/**
		 * This method returns the value as an IInteger. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the object to be converted
		 * @return IInteger\Type                                    the value as an IInteger
		 */
		public static function toInteger(IInteger\Type $x) : IInteger\Type {
			return $x;
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(IInteger\Type $x, Core\Type $y) : IBool\Type { // ==
			$type = $x->__typeOf();
			if ($y !== null) {
				if ($y instanceof $type) {
					return IBool\Type::box($x->unbox() == $y->unbox());
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(IInteger\Type $x, Core\Type $y) : IBool\Type { // ===
			if ($y !== null) {
				if ($x->__typeOf() === $y->__typeOf()) {
					return IBool\Type::box($x->unbox() === $y->unbox());
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(IInteger\Type $x, Core\Type $y) : IBool\Type { // !=
			return IBool\Module::not(IInteger\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(IInteger\Type $x, Core\Type $y) : IBool\Type { // !==
			return IBool\Module::not(IInteger\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param IInteger\Type $y                                  the right operand
		 * @return ITrit\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(IInteger\Type $x, IInteger\Type $y) : ITrit\Type {
			return ITrit\Type::make(gmp_cmp($x->unbox(), $y->unbox()));
		}

		#endregion

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param IInteger\Type $y                                  the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(IInteger\Type $x, IInteger\Type $y) : IBool\Type { // >=
			return IBool\Type::box(IInteger\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param IInteger\Type $y                                  the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(IInteger\Type $x, IInteger\Type $y) : IBool\Type { // >
			return IBool\Type::box(IInteger\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param IInteger\Type $y                                  the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(IInteger\Type $x, IInteger\Type $y) : IBool\Type { // <=
			return IBool\Type::box(IInteger\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param IInteger\Type $y                                  the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(IInteger\Type $x, IInteger\Type $y) : IBool\Type { // <
			return IBool\Type::box(IInteger\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param IInteger\Type $y                                  the right operand
		 * @return IInteger\Type                                    the maximum value
		 */
		public static function max(IInteger\Type $x, IInteger\Type $y) : IInteger\Type {
			return (IInteger\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the left operand
		 * @param IInteger\Type $y                                  the right operand
		 * @return IInteger\Type                                    the minimum value
		 */
		public static function min(IInteger\Type $x, IInteger\Type $y) : IInteger\Type {
			return (IInteger\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Evaluating Operations

		/**
		 * This method evaluates whether the operand is an even number.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the object to be evaluated
		 * @return IBool\Type                                       whether the operand is an even
		 *                                                          number
		 */
		public static function isEven(IInteger\Type $x) : IBool\Type {
			return IBool\Type::box(gmp_strval(gmp_div_r($x->unbox(), '2')) == '0');
		}

		/**
		 * This method returns whether the operand is a negative number.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the object to be evaluated
		 * @return IBool\Type                                       whether the operand is a negative
		 *                                                          number
		 */
		public static function isNegative(IInteger\Type $x) : IBool\Type {
			return IBool\Type::box(gmp_sign($x->unbox()) == -1);
		}

		/**
		 * This method evaluates whether the operand is an odd number.
		 *
		 * @access public
		 * @static
		 * @param IInteger\Type $x                                  the object to be evaluated
		 * @return IBool\Type                                       whether the operand is an odd
		 *                                                          number
		 */
		public static function isOdd(IInteger\Type $x) : IBool\Type {
			return IBool\Type::box(gmp_strval(gmp_div_r($x->unbox(), '2')) != '0');
		}

		#endregion

	}

}