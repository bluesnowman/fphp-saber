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

namespace Saber\Data\IDouble {

	include_once(implode(DIRECTORY_SEPARATOR, array(dirname(__FILE__), '..', '..', 'Ext', 'mtrand.php')));

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IDouble;
	use \Saber\Data\IFloat;
	use \Saber\Data\IFloating;
	use \Saber\Data\IInt32;
	use \Saber\Data\IInteger;
	use \Saber\Data\IReal;
	use \Saber\Data\IString;
	use \Saber\Data\ITrit;
	use \Saber\Data\ITuple;

	final class Module extends Data\Module implements IFloating\Module, IReal\Module {

		#region Methods -> Arithmetic Operations

		/**
		 * This method returns the absolute value of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the operand
		 * @return IDouble\Type                                     the result
		 */
		public static function abs(IDouble\Type $x) : IDouble\Type {
			return IDouble\Type::box(abs($x->unbox()));
		}

		/**
		 * This method returns the result of adding the specified value to this object's value.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the left operand
		 * @param IDouble\Type $y                                   the right operand
		 * @return IDouble\Type                                     the result
		 */
		public static function add(IDouble\Type $x, IDouble\Type $y) : IDouble\Type {
			return IDouble\Type::box($x->unbox() + $y->unbox());
		}

		/**
		 * This method returns the ceiling of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the operand
		 * @return IDouble\Type                                     the result
		 */
		public static function ceil(IDouble\Type $x) : IDouble\Type {
			return IDouble\Type::box(ceil($x->unbox()));
		}

		/**
		 * This method returns the result of decrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the operand
		 * @return IDouble\Type                                     the result
		 */
		public static function decrement(IDouble\Type $x) : IDouble\Type {
			return IDouble\Module::subtract($x, IDouble\Type::one());
		}

		/**
		 * This method returns the result of dividing the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the left operand
		 * @param IDouble\Type $y                                   the right operand
		 * @return IDouble\Type                                     the result
		 */
		public static function divide(IDouble\Type $x, IDouble\Type $y) : IDouble\Type {
			return IDouble\Type::box($x->unbox() / $y->unbox());
		}

		/**
		 * This method returns the floor of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the operand
		 * @return IDouble\Type                                     the result
		 */
		public static function floor(IDouble\Type $x) : IDouble\Type {
			return IDouble\Type::box(floor($x->unbox()));
		}

		/**
		 * This method returns the result of incrementing this object's value.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the operand
		 * @return IDouble\Type                                     the result
		 */
		public static function increment(IDouble\Type $x) : IDouble\Type {
			return IDouble\Module::add($x, IDouble\Type::one());
		}

		/**
		 * This method returns the result of finding the modulus of the specified value against this
		 * object's value.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the left operand
		 * @param IDouble\Type $y                                   the right operand
		 * @return IDouble\Type                                     the result
		 */
		public static function modulo(IDouble\Type $x, IDouble\Type $y) : IDouble\Type {
			return IDouble\Type::box(fmod($x->unbox(), $y->unbox()));
		}

		/**
		 * This method returns the result of multiplying the specified value against this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the left operand
		 * @param IDouble\Type $y                                   the right operand
		 * @return IDouble\Type                                     the result
		 */
		public static function multiply(IDouble\Type $x, IDouble\Type $y) : IDouble\Type {
			return IDouble\Type::box($x->unbox() * $y->unbox());
		}

		/**
		 * This method returns the result of negating this object's value.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the operand
		 * @return IDouble\Type                                     the result
		 */
		public static function negate(IDouble\Type $x) : IDouble\Type {
			return IDouble\Type::box($x->unbox() * -1.0);
		}

		/**
		 * This method returns the number raised to the power of the specified exponent.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the operand
		 * @param IInt32\Type $exponent                             the exponent to be raised by
		 * @return IDouble\Type                                     the result
		 */
		public static function pow(IDouble\Type $x, IInt32\Type $exponent) : IDouble\Type {
			return IDouble\Type::box(pow($x->unbox(), $exponent->unbox()));
		}

		/**
		 * This method returns the result of rounding this object's value.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the operand
		 * @param IInt32\Type $precision                            the precision to use when rounding
		 * @return IDouble\Type                                     the result
		 */
		public static function round(IDouble\Type $x, IInt32\Type $precision = null) : IDouble\Type {
			return IDouble\Type::box(round($x->unbox(), IInt32\Module::nvl($precision)->unbox()));
		}

		/**
		 * This method returns the result of subtracting the specified value from this object's
		 * value.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the left operand
		 * @param IDouble\Type $y                                   the right operand
		 * @return IDouble\Type                                     the result
		 */
		public static function subtract(IDouble\Type $x, IDouble\Type $y) : IDouble\Type {
			return IDouble\Type::box($x->unbox() - $y->unbox());
		}

		#endregion

		#region Methods -> Basic Operations

		/**
		 * This method returns a list of all numbers for the specified sequence.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   where to start
		 * @param Core\Type $y                                      either an integer representing
		 *                                                          the end of the sequence or a
		 *                                                          tuple describing the sequence
		 * @return IArrayList\Type                                  an empty array list
		 */
		public static function sequence(IDouble\Type $x, Core\Type $y) : IArrayList\Type {
			$buffer = array();

			if ($y instanceof ITuple\Type) {
				$s = IDouble\Module::subtract($y->first(), $x);
				$n = $y->second();
			}
			else { // ($y instanceof IDouble\Type)
				$s = IDouble\Type::one();
				$n = $y;
			}

			if (IDouble\Module::isNegative($s)->unbox()) {
				for ($i = $x; IDouble\Module::ge($i, $n)->unbox(); $i = IDouble\Module::add($i, $s)) {
					$buffer[] = $i;
				}
			}
			else {
				for ($i = $x; IDouble\Module::le($i, $n)->unbox(); $i = IDouble\Module::add($i, $s)) {
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
		 * @param IDouble\Type $x                                   the number to be evaluated
		 * @return ITrit\Type                                       the result
		 */
		public static function signum(IDouble\Type $x) : ITrit\Type {
			return IDouble\Module::compare($x, IDouble\Type::zero());
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the value to be evaluated
		 * @param IDouble\Type $y                                   the default value
		 * @return IDouble\Type                                     the result
		 */
		public static function nvl(IDouble\Type $x = null, IDouble\Type $y = null) : IDouble\Type {
			return ($x !== null) ? $x : (($y !== null) ? $y : IDouble\Type::zero());
		}

		/**
		 * This method returns the value in degrees.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the object to be converted
		 * @return IDouble\Type                                     the value as a IDouble
		 */
		public static function toDegrees(IDouble\Type $x) : IDouble\Type {
			return IDouble\Type::box(deg2rad($x->unbox()));
		}

		/**
		 * This method returns the value as a IDouble. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the object to be converted
		 * @return IDouble\Type                                     the value as a IDouble
		 */
		public static function toDouble(IDouble\Type $x) : IDouble\Type {
			return $x;
		}

		/**
		 * This method returns the value as a IFloat. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the object to be converted
		 * @return IFloat\Type                                      the value as a IFloat
		 */
		public static function toFloat(IDouble\Type $x) : IFloat\Type {
			return IFloat\Type::make($x->unbox());
		}

		/**
		 * This method returns the value as an IInt32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the object to be converted
		 * @return IInt32\Type                                      the value as an IInt32
		 */
		public static function toInt32(IDouble\Type $x) : IInt32\Type {
			return IInt32\Type::make($x->unbox());
		}

		/**
		 * This method returns the value as an IInteger. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the object to be converted
		 * @return IInteger\Type                                    the value as an IInteger
		 */
		public static function toInteger(IDouble\Type $x) : IInteger\Type {
			return IInteger\Type::make($x->unbox());
		}

		/**
		 * This method returns the value in radians.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the object to be converted
		 * @return IDouble\Type                                     the value as a IDouble
		 */
		public static function toRadian(IDouble\Type $x) : IDouble\Type {
			return IDouble\Type::box(rad2deg($x->unbox()));
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(IDouble\Type $x, Core\Type $y) : IBool\Type { // ==
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
		 * @param IDouble\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(IDouble\Type $x, Core\Type $y) : IBool\Type { // ===
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
		 * @param IDouble\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(IDouble\Type $x, Core\Type $y) : IBool\Type { // !=
			return IBool\Module::not(IDouble\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(IDouble\Type $x, Core\Type $y) : IBool\Type { // !==
			return IBool\Module::not(IDouble\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the left operand
		 * @param IDouble\Type $y                                   the right operand
		 * @return ITrit\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(IDouble\Type $x, IDouble\Type $y) : ITrit\Type {
			return ITrit\Type::box($x->unbox() <=> $y->unbox());
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the left operand
		 * @param IDouble\Type $y                                   the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(IDouble\Type $x, IDouble\Type $y) : IBool\Type { // >=
			return IBool\Type::box(IDouble\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the left operand
		 * @param IDouble\Type $y                                   the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(IDouble\Type $x, IDouble\Type $y) : IBool\Type { // >
			return IBool\Type::box(IDouble\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the left operand
		 * @param IDouble\Type $y                                   the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(IDouble\Type $x, IDouble\Type $y) : IBool\Type { // <=
			return IBool\Type::box(IDouble\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the left operand
		 * @param IDouble\Type $y                                   the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(IDouble\Type $x, IDouble\Type $y) : IBool\Type { // <
			return IBool\Type::box(IDouble\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the left operand
		 * @param IDouble\Type $y                                   the right operand
		 * @return IDouble\Type                                     the maximum value
		 */
		public static function max(IDouble\Type $x, IDouble\Type $y) : IDouble\Type {
			return (IDouble\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the left operand
		 * @param IDouble\Type $y                                   the right operand
		 * @return IDouble\Type                                     the minimum value
		 */
		public static function min(IDouble\Type $x, IDouble\Type $y) : IDouble\Type {
			return (IDouble\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Evaluating Operations

		/**
		 * This method returns whether the operand is a negative number.
		 *
		 * @access public
		 * @static
		 * @param IDouble\Type $x                                   the object to be evaluated
		 * @return IBool\Type                                       whether the operand is a negative
		 *                                                          number
		 */
		public static function isNegative(IDouble\Type $x) : IBool\Type {
			return IBool\Type::box($x->unbox() < 0.0);
		}

		#endregion

	}

}