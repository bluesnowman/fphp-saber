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

namespace Saber\Data\IEither {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IEither;

	final class Module extends Data\Module {

		#region Methods -> Basic Operations

		/**
		 * This method returns the result of a fold reduction on the either.
		 *
		 * @access public
		 * @static
		 * @param IEither\Type $xs                                  the left operand
		 * @param callable $left                                    the operator function to be used
		 * @param callable $right                                   the operator function to be used
		 * @return Core\Type                                        the result
		 */
		public static function fold(IEither\Type $xs, callable $left, callable $right) : Core\Type {
			return ($xs->__isLeft()) ? $left($xs->projectLeft()->item()) : $right($xs->projectRight()->item());
		}

		/**
		 * This method returns the result of a reduction on the either.
		 *
		 * @access public
		 * @static
		 * @param IEither\Type $xs                                  the operand
		 * @return Core\Type                                        the result
		 */
		public static function reduce(IEither\Type $xs) : Core\Type {
			return ($xs->__isLeft()) ? $xs->projectLeft()->item() : $xs->projectRight()->item();
		}

		/**
		 * This method returns the swapped node.
		 *
		 * @access public
		 * @static
		 * @param IEither\Type $x                                   the node to be swapped
		 * @return IEither\Type                                     a tuple with the item swapped
		 */
		public static function swap(IEither\Type $x) : IEither\Type {
			$value = $x->unbox();
			return ($x->__isLeft()) ? IEither\Type::right($value) : IEither\Type::left($value);
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param IEither\Type $x                                   the value to be evaluated
		 * @param IEither\Type $y                                   the default value
		 * @return IEither\Type                                     the result
		 */
		public static function nvl(IEither\Type $x = null, IEither\Type $y = null) : IEither\Type {
			return $x ?? $y ?? IEither\Type::left();
		}

		#endregion

	}

}