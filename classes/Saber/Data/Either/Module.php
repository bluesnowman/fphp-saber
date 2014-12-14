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

namespace Saber\Data\Either {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Either;

	final class Module extends Data\Module {

		#region Methods -> Basic Operations

		/**
		 * This method returns the result of a fold reduction on the either.
		 *
		 * @access public
		 * @static
		 * @param Either\Type $xs                                   the left operand
		 * @param callable $left                                    the operator function to be used
		 * @param callable $right                                   the operator function to be used
		 * @return Core\Type                                        the result
		 */
		public static function fold(Either\Type $xs, callable $left, callable $right) {
			return ($xs->__isLeft()) ? $left($xs->projectLeft()->object()) : $right($xs->projectRight()->object());
		}

		/**
		 * This method returns the result of a reduction on the either.
		 *
		 * @access public
		 * @static
		 * @param Either\Type $xs                                   the operand
		 * @return Core\Type                                        the result
		 */
		public static function reduce(Either\Type $xs) {
			return ($xs->__isLeft()) ? $xs->projectLeft()->object() : $xs->projectRight()->object();
		}

		/**
		 * This method returns the swapped node.
		 *
		 * @access public
		 * @static
		 * @param Either\Type $x                                    the node to be swapped
		 * @return Either\Type                                      a tuple with the item swapped
		 */
		public static function swap(Either\Type $x) {
			$value = $x->unbox();
			return ($x->__isLeft()) ? Either\Type::right($value) : Either\Type::left($value);
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param Either\Type $x                                    the value to be evaluated
		 * @param Either\Type $y                                    the default value
		 * @return Either\Type                                      the result
		 */
		public static function nvl(Either\Type $x = null, Either\Type $y = null) {
			return ($x !== null) ? $x : (($y !== null) ? $y : Either\Type::left());
		}

		#endregion

	}

}