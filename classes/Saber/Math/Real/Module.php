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

namespace Saber\Math\IReal {

	use \Saber\Data;
	use \Saber\Data\IDouble;
	use \Saber\Data\IReal;

	final class Module extends Data\Module implements IReal\Module {

		/**
		 * This method returns the arc cosine of this object's value in radians.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function acos(IReal\Type $x) {
			return IDouble\Type::box(acos($x->unbox()));
		}

		/**
		 * This method returns the inverse hyperbolic cosine of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function acosh(IReal\Type $x) {
			return IDouble\Type::box(acosh($x->unbox()));
		}

		/**
		 * This method returns the arc sine of this object's value in radians.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function asin(IReal\Type $x) {
			return IDouble\Type::box(asin($x->unbox()));
		}

		/**
		 * This method returns the inverse hyperbolic sine of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function asinh(IReal\Type $x) {
			return IDouble\Type::box(asinh($x->unbox()));
		}

		/**
		 * This method returns the arc tangent of this object's value in radians.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function atan(IReal\Type $x) {
			return IDouble\Type::box(atan($x->unbox()));
		}

		/**
		 * This method returns theta after converting from cartesian coordinates (x, y)
		 * to polar coordinates (r, theta).
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $y                                      the left operand
		 * @param IReal\Type $x                                      the right operand
		 * @return IDouble\Type                                      the result
		 */
		public static function atan2(IReal\Type $y, IReal\Type $x) {
			return IDouble\Type::box(atan2($y->unbox(), $x->unbox()));
		}

		/**
		 * This method returns the inverse hyperbolic tangent of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function atanh(IReal\Type $x) {
			return IDouble\Type::box(atanh($x->unbox()));
		}

		/**
		 * This method returns the cosine of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function cos(IReal\Type $x) {
			return IDouble\Type::box(cos($x->unbox()));
		}

		/**
		 * This method returns the hyperbolic cosine of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function cosh(IReal\Type $x) {
			return IDouble\Type::box(cosh($x->unbox()));
		}

		/**
		 * This method returns "e" raised to the power of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function exp(IReal\Type $x) {
			return IDouble\Type::box(exp($x->unbox()));
		}

		/**
		 * This method returns "e" raised to the power of this object's value minus by one.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function expm1(IReal\Type $x) {
			return IDouble\Type::box(expm1($x->unbox()));
		}

		/**
		 * This method returns the length of the hypotenuse of a right-angle triangle.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the left operand
		 * @param IReal\Type $y                                      the right operand
		 * @return IDouble\Type                                      the result
		 */
		public static function hypot(IReal\Type $x, IReal\Type $y) {
			return IDouble\Type::box(hypot($x->unbox(), $y->unbox()));
		}

		/**
		 * This method returns the natural logarithm of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function log(IReal\Type $x) {
			return IDouble\Type::box(log($x->unbox()));
		}

		/**
		 * This method returns the base 10 logarithm of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function log10(IReal\Type $x) {
			return IDouble\Type::box(log10($x->unbox()));
		}

		/**
		 * This method returns the natural logarithm of this object's value plus one.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function log1p(IReal\Type $x) {
			return IDouble\Type::box(log1p($x->unbox()));
		}


		/**
		 * This method returns the sine of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function sin(IReal\Type $x) {
			return IDouble\Type::box(sin($x->unbox()));
		}

		/**
		 * This method returns the hyperbolic sine of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function sinh(IReal\Type $x) {
			return IDouble\Type::box(sinh($x->unbox()));
		}

		/**
		 * This method returns the square root of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function sqrt(IReal\Type $x) {
			return IDouble\Type::box(sqrt($x->unbox()));
		}

		/**
		 * This method returns the tangent of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function tan(IReal\Type $x) {
			return IDouble\Type::box(tan($x->unbox()));
		}

		/**
		 * This method returns the hyperbolic tangent of this object's value.
		 *
		 * @access public
		 * @static
		 * @param IReal\Type $x                                      the operand
		 * @return IDouble\Type                                      the result
		 */
		public static function tanh(IReal\Type $x) {
			return IDouble\Type::box(tanh($x->unbox()));
		}

	}

}