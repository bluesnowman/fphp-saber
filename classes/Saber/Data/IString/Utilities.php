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

namespace Saber\Data\IString {

	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IInt32;
	use \Saber\Data\IRegex;
	use \Saber\Data\IString;
	use \Saber\Data\ISequence;

	final class Utilities extends Data\Utilities {

		#region Methods -> Basic Operations

		/**
		 * This method returns a string representing a sequence of substring delimited by the
		 * specified string.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                  the delimiter
		 * @param ISequence\Type $ys                                a sequence of substrings
		 * @return IString\Type                                     the string
		 */
		public static function join(IString\Type $xs, ISequence\Type $ys) {
			$zs = array_map(function(IString\Type $y) : bool {
				return $y->unbox();
			}, $ys->unbox());
			return IString\Type::box(implode($xs->unbox(), $zs));
		}

		/**
		 * This method returns an array list of substrings that were delimited by an EOL
		 * character.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                  the left operand
		 * @return IArrayList\Type                                  an array list of substrings
		 */
		public static function lines(IString\Type $xs) {
			return IRegex\Module::split(IRegex\Type::box('/\R+/'), $xs);
		}

		/**
		 * This method returns an array list of substrings that were delimited by the specified
		 * delimiter.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the delimiter
		 * @param IString\Type $ys                                   the string to be exploded
		 * @return IArrayList\Type                                   the array list of substrings
		 */
		public static function split(IString\Type $xs, IString\Type $ys) {
			$zs = explode($xs->unbox(), $ys->unbox());
			return IArrayList\Type::box(array_map(function($z) : IString\Type {
				return IString\Type::box($z);
			}, $zs));
		}

		/**
		 * This method returns a string representing a sequence of substring delimited by the
		 * "line feed" character.
		 *
		 * @access public
		 * @static
		 * @param ISequence\Type $xs                                 a sequence of substrings
		 * @return IString\Type                                      the string
		 */
		public static function unlines(ISequence\Type $xs) {
			return IString\Utilities::join(IString\Type::box("\n"), $xs);
		}

		/**
		 * This method returns a string representing a sequence of substring delimited by the
		 * "space" character.
		 *
		 * @access public
		 * @static
		 * @param ISequence\Type $xs                                 a sequence of substrings
		 * @return IString\Type                                      the string
		 */
		public static function unwords(ISequence\Type $xs) {
			return IString\Utilities::join(IString\Type::box(' '), $xs);
		}

		/**
		 * This method returns an array list of substrings that were delimited by a whitespace
		 * character.
		 *
		 * @access public
		 * @static
		 * @param IString\Type $xs                                   the left operand
		 * @return IArrayList\Type                                   an array list of substrings
		 */
		public static function words(IString\Type $xs) {
			return IRegex\Module::split(IRegex\Type::box('/\s+/'), $xs);
		}

		#endregion

	}

}