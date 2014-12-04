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

namespace Saber\Throwable\Runtime\Exception {

	use \Saber\Core;
	use \Saber\Data\Bool;
	use \Saber\Data\Int32;
	use \Saber\Throwable;

	final class Module extends Core\Module {

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Throwable\Runtime\Exception $x, Core\Type $y) { // ==
			$type = $x->__typeOf();
			if ($y !== null) {
				if ($y instanceof $type) {
					return Bool\Type::box($x->getCode() === $x->getCode());
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Throwable\Runtime\Exception $x, Core\Type $y) { // ===
			if ($y !== null) {
				if ($x->__typeOf() === $y->__typeOf()) {
					return Bool\Type::box($x->__hashCode() === $y->__hashCode());
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Throwable\Runtime\Exception $x, Core\Type $y) { // !=
			return Bool\Module::not(Throwable\Runtime\Exception\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Throwable\Runtime\Exception $x, Core\Type $y) { // !==
			return Bool\Module::not(Throwable\Runtime\Exception\Module::id($x, $y));
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
		 * @return Int32\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Throwable\Runtime\Exception $x, Throwable\Runtime\Exception $y) {
			if (($x === null) && ($y !== null)) {
				return Int32\Type::negative();
			}
			if (($x === null) && ($y === null)) {
				return Int32\Type::zero();
			}
			if (($x !== null) && ($y === null)) {
				return Int32\Type::one();
			}

			$x = $x->getCode();
			$y = $y->getCode();

			if ($x < $y) {
				return Int32\Type::negative();
			}
			else if ($x == $y) {
				return Int32\Type::zero();
			}
			else { // ($x > $y)
				return Int32\Type::one();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Throwable\Runtime\Exception $y                    the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Throwable\Runtime\Exception $x, Throwable\Runtime\Exception $y) { // >=
			return Bool\Type::box(Throwable\Runtime\Exception\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Throwable\Runtime\Exception $y                    the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Throwable\Runtime\Exception $x, Throwable\Runtime\Exception $y) { // >
			return Bool\Type::box(Throwable\Runtime\Exception\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Throwable\Runtime\Exception $y                    the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Throwable\Runtime\Exception $x, Throwable\Runtime\Exception $y) { // <=
			return Bool\Type::box(Throwable\Runtime\Exception\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Throwable\Runtime\Exception $x                    the left operand
		 * @param Throwable\Runtime\Exception $y                    the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Throwable\Runtime\Exception $x, Throwable\Runtime\Exception $y) { // <
			return Bool\Type::box(Throwable\Runtime\Exception\Module::compare($x, $y)->unbox() < 0);
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