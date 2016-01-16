<?php

/**
 * Copyright 2014-2015 Blue Snowman
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

namespace Saber\Throwable\Runtime\Exception {

	use \Saber\Core;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IInt32;
	use \Saber\Data\IString;
	use \Saber\Data\ITrit;
	use \Saber\Throwable;

	final class Module extends Core\Module {

		#region Methods -> Informational Operations

		/**
		 * This method returns the exception code.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the exception to be processed
		 * @return integer                                          the exception code
		 */
		public static function getCode(Throwable\Runtime\Exception $x) {
			return IInt32\Type::box($x->__getCode());
		}

		/**
		 * This method returns the source file's name.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the exception to be processed
		 * @return string                                           the source file's name
		 */
		public static function getFile(Throwable\Runtime\Exception $x) {
			return IString\Type::box($x->__getFile());
		}

		/**
		 * This method returns the line at which the exception was thrown.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the exception to be processed
		 * @return integer                                          the source line
		 */
		public static function getLine(Throwable\Runtime\Exception $x) {
			return IInt32\Type::box($x->__getLine());
		}

		/**
		 * This method returns the exception message.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the exception to be processed
		 * @return string                                           the exception message
		 */
		public static function getMessage(Throwable\Runtime\Exception $x) {
			return IString\Type::box($x->__getMessage());
		}

		/**
		 * This method returns any backtrace information.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the exception to be processed
		 * @return array                                            any backtrace information
		 */
		public static function getTrace(Throwable\Runtime\Exception $x) {
			return IArrayList\Type::box($x->__getTrace()); // TODO re-implement to use recursive make
		}

		/**
		 * This method returns the backtrace information as a string.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the exception to be processed
		 * @return string                                           the backtrace information
		 */
		public static function getTraceAsIString(Throwable\Runtime\Exception $x) {
			return IString\Type::box($x->__getTraceAsIString());
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Throwable\Runtime\Exception $x, Core\Type $y) { // ==
			$type = $x->__typeOf();
			if ($y !== null) {
				if ($y instanceof $type) {
					return IBool\Type::box($x->__getCode() === $y->__getCode());
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Throwable\Runtime\Exception $x, Core\Type $y) { // ===
			if ($y !== null) {
				if ($x->__typeOf() === $y->__typeOf()) {
					return IBool\Type::box($x->__hashCode() === $y->__hashCode());
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Throwable\Runtime\Exception $x, Core\Type $y) { // !=
			return IBool\Module::not(Throwable\Runtime\Exception\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Throwable\Runtime\Exception $x, Core\Type $y) { // !==
			return IBool\Module::not(Throwable\Runtime\Exception\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Throwable\Runtime\Exception $y                    the right operand
		 * @return ITrit\Type                                        the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Throwable\Runtime\Exception $x, Throwable\Runtime\Exception $y) {
			$x = $x->__getCode();
			$y = $y->__getCode();

			if ($x < $y) {
				return ITrit\Type::negative();
			}
			else if ($x == $y) {
				return ITrit\Type::zero();
			}
			else { // ($x > $y)
				return ITrit\Type::positive();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Throwable\Runtime\Exception $y                    the right operand
		 * @return IBool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Throwable\Runtime\Exception $x, Throwable\Runtime\Exception $y) { // >=
			return IBool\Type::box(Throwable\Runtime\Exception\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Throwable\Runtime\Exception $y                    the right operand
		 * @return IBool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Throwable\Runtime\Exception $x, Throwable\Runtime\Exception $y) { // >
			return IBool\Type::box(Throwable\Runtime\Exception\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Throwable\Runtime\Exception $y                    the right operand
		 * @return IBool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Throwable\Runtime\Exception $x, Throwable\Runtime\Exception $y) { // <=
			return IBool\Type::box(Throwable\Runtime\Exception\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Throwable\Runtime\Exception $y                    the right operand
		 * @return IBool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Throwable\Runtime\Exception $x, Throwable\Runtime\Exception $y) { // <
			return IBool\Type::box(Throwable\Runtime\Exception\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Throwable\Runtime\Exception $y                    the right operand
		 * @return Throwable\Runtime\Exception                      the maximum value
		 */
		public static function max(Throwable\Runtime\Exception $x, Throwable\Runtime\Exception $y) {
			return (Throwable\Runtime\Exception\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Throwable\Runtime\Exception $y                    the right operand
		 * @return Throwable\Runtime\Exception                      the minimum value
		 */
		public static function min(Throwable\Runtime\Exception $x, Throwable\Runtime\Exception $y) {
			return (Throwable\Runtime\Exception\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

	}

}