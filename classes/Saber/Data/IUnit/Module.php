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

namespace Saber\Data\IUnit {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IBool;
	use \Saber\Data\IInt32;
	use \Saber\Data\ITrit;
	use \Saber\Data\IUnit;

	final class Module extends Data\Module {

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param IUnit\Type $x                                     the value to be evaluated
		 * @param IUnit\Type $y                                     the default value
		 * @return IUnit\Type                                       the result
		 */
		public static function nvl(IUnit\Type $x = null, IUnit\Type $y = null) : IUnit\Type {
			return ($x !== null) ? $x : (($y !== null) ? $y : IUnit\Type::instance());
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IUnit\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(IUnit\Type $x, Core\Type $y) : IBool\Type { // ==
			$type = ($x === null) ? '\\Saber\\Data\\IUnit\\Type' : $x->__typeOf();
			return IBool\Type::box(($y === null) || ($y instanceof $type));
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IUnit\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(IUnit\Type $x, Core\Type $y) : IBool\Type { // ===
			$type = ($x === null) ? '\\Saber\\Data\\IUnit\\Type' : $x->__typeOf();
			return IBool\Type::box(($y === null) || ($type === $y->__typeOf()));
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IUnit\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(IUnit\Type $x, Core\Type $y) : IBool\Type { // !=
			return IBool\Module::not(IUnit\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IUnit\Type $x                                     the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                       whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(IUnit\Type $x, Core\Type $y) : IBool\Type { // !==
			return IBool\Module::not(IUnit\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param IUnit\Type $x                                     the left operand
		 * @param IUnit\Type $y                                     the right operand
		 * @return ITrit\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(IUnit\Type $x, IUnit\Type $y) : ITrit\Type {
			if (IUnit\Module::eq($x, $y)->unbox()) {
				return ITrit\Type::zero();
			}
			return ITrit\Type::make(strcmp($x->__typeOf(), $y->__typeOf()));
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IUnit\Type $x                                     the left operand
		 * @param IUnit\Type $y                                     the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(IUnit\Type $x, IUnit\Type $y) : IBool\Type { // >=
			return IBool\Type::box(IUnit\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IUnit\Type $x                                     the left operand
		 * @param IUnit\Type $y                                     the right operand
		 * @return IBool\Type                                       whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(IUnit\Type $x, IUnit\Type $y) : IBool\Type { // >
			return IBool\Type::box(IUnit\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IUnit\Type $x                                     the left operand
		 * @param IUnit\Type $y                                     the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(IUnit\Type $x, IUnit\Type $y) : IBool\Type { // <=
			return IBool\Type::box(IUnit\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IUnit\Type $x                                     the left operand
		 * @param IUnit\Type $y                                     the right operand
		 * @return IBool\Type                                       whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(IUnit\Type $x, IUnit\Type $y) : IBool\Type { // <
			return IBool\Type::box(IUnit\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param IUnit\Type $x                                     the left operand
		 * @param IUnit\Type $y                                     the right operand
		 * @return IUnit\Type                                       the maximum value
		 */
		public static function max(IUnit\Type $x, IUnit\Type $y) : IUnit\Type {
			return (IUnit\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param IUnit\Type $x                                     the left operand
		 * @param IUnit\Type $y                                     the right operand
		 * @return IUnit\Type                                       the minimum value
		 */
		public static function min(IUnit\Type $x, IUnit\Type $y) : IUnit\Type {
			return (IUnit\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

	}

}