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

namespace Saber\Math\Real {

	use \Saber\Core;
	use \Saber\Data\Double;
	use \Saber\Data\Real;

	class Module extends Core\Module {

		/**
		 * This method returns the arc cosine of this object's value in radians.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function acos(Real\Type $x) {
			return Double\Type::box(acos($x->unbox()));
		}

		/**
		 * This method returns the inverse hyperbolic cosine of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function acosh(Real\Type $x) {
			return Double\Type::box(acosh($x->unbox()));
		}

		/**
		 * This method returns the arc sine of this object's value in radians.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function asin(Real\Type $x) {
			return Double\Type::box(asin($x->unbox()));
		}

		/**
		 * This method returns the inverse hyperbolic sine of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function asinh(Real\Type $x) {
			return Double\Type::box(asinh($x->unbox()));
		}

		/**
		 * This method returns the arc tangent of this object's value in radians.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function atan(Real\Type $x) {
			return Double\Type::box(atan($x->unbox()));
		}

		/**
		 * This method returns theta after converting from cartesian coordinates (x, y)
		 * to polar coordinates (r, theta).
		 *
		 * @access public
		 * @static
		 * @param Real\Type $y                                      the left operand
		 * @param Real\Type $x                                      the right operand
		 * @return Double\Type                                      the result
		 */
		public static function atan2(Real\Type $y, Real\Type $x) {
			return Double\Type::box(atan2($y->unbox(), $x->unbox()));
		}

		/**
		 * This method returns the inverse hyperbolic tangent of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function atanh(Real\Type $x) {
			return Double\Type::box(atanh($x->unbox()));
		}

		/**
		 * This method returns the cosine of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function cos(Real\Type $x) {
			return Double\Type::box(cos($x->unbox()));
		}

		/**
		 * This method returns the hyperbolic cosine of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function cosh(Real\Type $x) {
			return Double\Type::box(cosh($x->unbox()));
		}

		/**
		 * This method returns "e" raised to the power of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function exp(Real\Type $x) {
			return Double\Type::box(exp($x->unbox()));
		}

		/**
		 * This method returns "e" raised to the power of this object's value minus by one.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function expm1(Real\Type $x) {
			return Double\Type::box(expm1($x->unbox()));
		}

		/**
		 * This method returns the length of the hypotenuse of a right-angle triangle.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the left operand
		 * @param Real\Type $y                                      the right operand
		 * @return Double\Type                                      the result
		 */
		public static function hypot(Real\Type $x, Real\Type $y) {
			return Double\Type::box(hypot($x->unbox(), $y->unbox()));
		}

		/**
		 * This method returns the natural logarithm of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function log(Real\Type $x) {
			return Double\Type::box(log($x->unbox()));
		}

		/**
		 * This method returns the base 10 logarithm of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function log10(Real\Type $x) {
			return Double\Type::box(log10($x->unbox()));
		}

		/**
		 * This method returns the natural logarithm of this object's value plus one.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function log1p(Real\Type $x) {
			return Double\Type::box(log1p($x->unbox()));
		}


		/**
		 * This method returns the sine of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function sin(Real\Type $x) {
			return Double\Type::box(sin($x->unbox()));
		}

		/**
		 * This method returns the hyperbolic sine of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function sinh(Real\Type $x) {
			return Double\Type::box(sinh($x->unbox()));
		}

		/**
		 * This method returns the square root of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function sqrt(Real\Type $x) {
			return Double\Type::box(sqrt($x->unbox()));
		}

		/**
		 * This method returns the tangent of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function tan(Real\Type $x) {
			return Double\Type::box(tan($x->unbox()));
		}

		/**
		 * This method returns the hyperbolic tangent of this object's value.
		 *
		 * @access public
		 * @static
		 * @param Real\Type $x                                      the operand
		 * @return Double\Type                                      the result
		 */
		public static function tanh(Real\Type $x) {
			return Double\Type::box(tanh($x->unbox()));
		}

	}

}