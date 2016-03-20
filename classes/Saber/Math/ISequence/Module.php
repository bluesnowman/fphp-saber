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

namespace Saber\Math\ISeq {

	use \Saber\Data;
	use \Saber\Data\IDouble;
	use \Saber\Data\INumber;
	use \Saber\Data\ISeq;

	final class Module extends Data\Module implements ISeq\Module {

		/**
		 * This method returns the average of all items in the list.
		 *
		 * @access public
		 * @static
		 * @param ISeq\Type $xs                                     the sequence to be processed
		 * @return IDouble\Type                                     the result
		 */
		public static function average(ISeq\Type $xs) : IDouble\Type {
			return ($xs->__isEmpty())
				? IDouble\Type::zero()
				: IDouble\Module::divide(static::sum($xs), $xs->length()->toDouble());
		}

		/**
		 * This method returns the product of all items in the list.
		 *
		 * @access public
		 * @static
		 * @param ISeq\Type $xs                                     the sequence to be processed
		 * @return IDouble\Type                                     the result
		 */
		public static function product(ISeq\Type $xs) : IDouble\Type {
			return $xs->foldLeft(function(IDouble\Type $c, INumber\Type $x) {
				return IDouble\Module::multiply($c, $x->toDouble());
			}, IDouble\Type::one());
		}

		/**
		 * This method returns the sum of all items in the list.
		 *
		 * @access public
		 * @static
		 * @param ISeq\Type $xs                                     the sequence to be processed
		 * @return IDouble\Type                                     the result
		 */
		public static function sum(ISeq\Type $xs) : IDouble\Type {
			return $xs->foldLeft(function(IDouble\Type $c, INumber\Type $x) {
				return IDouble\Module::add($c, $x->toDouble());
			}, IDouble\Type::zero());
		}

	}

}