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

namespace Saber\Math\Vector {

	use \Saber\Data;
	use \Saber\Data\Double;
	use \Saber\Data\Vector;

	final class Module extends Data\Module implements Vector\Module {

		/**
		 * This method returns the average of all elements in the list.
		 *
		 * @access public
		 * @static
		 * @param Vector\Type $xs                                   the vector to be processed
		 * @return Double\Type                                      the result
		 */
		public static function average(Vector\Type $xs) {
			if ($xs->__isEmpty()) {
				return Double\Type::zero();
			}
			return Double\Module::divide(static::sum($xs), $xs->length()->toDouble());
		}

		/**
		 * This method returns the product of all elements in the list.
		 *
		 * @access public
		 * @static
		 * @param Vector\Type $xs                                   the vector to be processed
		 * @return Double\Type                                      the result
		 */
		public static function product(Vector\Type $xs) {
			if ($xs->__isEmpty()) {
				return Double\Type::one();
			}
			return Double\Module::multiply($xs->head()->toDouble(), static::product($xs->tail()));
		}

		/**
		 * This method returns the sum of all elements in the list.
		 *
		 * @access public
		 * @static
		 * @param Vector\Type $xs                                   the vector to be processed
		 * @return Double\Type                                      the result
		 */
		public static function sum(Vector\Type $xs) {
			if ($xs->__isEmpty()) {
				return Double\Type::zero();
			}
			return Double\Module::add($xs->head()->toDouble(), static::sum($xs->tail()));
		}

	}

}