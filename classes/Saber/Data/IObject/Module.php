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

namespace Saber\Data\IObject {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IBool;
	use \Saber\Data\IInt32;
	use \Saber\Data\IObject;
	use \Saber\Data\ITrit;

	final class Module extends Data\Module {

		#region Methods -> Basic Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param IObject\Type $x                                   the value to be evaluated
		 * @param IObject\Type $y                                   the default value
		 * @return IObject\Type                                     the result
		 */
		public static function nvl(IObject\Type $x = null, IObject\Type $y = null) : IObject\Type {
			return $x ?? $y ?? IObject\Type::box(null);
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IObject\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(IObject\Type $x, Core\Type $y) : IBool\Type { // ==
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
		 * @param IObject\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(IObject\Type $x, Core\Type $y) : IBool\Type { // ===
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
		 * @param IObject\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(IObject\Type $x, Core\Type $y) : IBool\Type { // !=
			return IBool\Module::not(IObject\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IObject\Type $x                                   the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(IObject\Type $x, Core\Type $y) : IBool\Type { // !==
			return IBool\Module::not(IObject\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param IObject\Type $x                                   the left operand
		 * @param IObject\Type $y                                   the right operand
		 * @return ITrit\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(IObject\Type $x, IObject\Type $y) : ITrit\Type {
			$__x = $x->unbox();
			$__y = $y->unbox();

			if ($__x < $__y) {
				return ITrit\Type::negative();
			}
			else if ($__x == $__y) {
				return ITrit\Type::zero();
			}
			else {
				return ITrit\Type::positive();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IObject\Type $x                                   the left operand
		 * @param IObject\Type $y                                   the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(IObject\Type $x, IObject\Type $y) : IBool\Type { // >=
			return IBool\Type::box(IObject\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IObject\Type $x                                   the left operand
		 * @param IObject\Type $y                                   the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(IObject\Type $x, IObject\Type $y) : IBool\Type { // >
			return IBool\Type::box(IObject\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IObject\Type $x                                   the left operand
		 * @param IObject\Type $y                                   the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(IObject\Type $x, IObject\Type $y) : IBool\Type { // <=
			return IBool\Type::box(IObject\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IObject\Type $x                                   the left operand
		 * @param IObject\Type $y                                   the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(IObject\Type $x, IObject\Type $y) : IBool\Type { // <
			return IBool\Type::box(IObject\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param IObject\Type $x                                   the left operand
		 * @param IObject\Type $y                                   the right operand
		 * @return IObject\Type                                     the maximum value
		 */
		public static function max(IObject\Type $x, IObject\Type $y) : IObject\Type {
			return (IObject\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param IObject\Type $x                                   the left operand
		 * @param IObject\Type $y                                   the right operand
		 * @return IObject\Type                                     the minimum value
		 */
		public static function min(IObject\Type $x, IObject\Type $y) : IObject\Type {
			return (IObject\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

	}

}