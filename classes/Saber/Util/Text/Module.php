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

namespace Saber\Util\Text {

	use \Saber\Data;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Int32;
	use \Saber\Data\String;
	use \Saber\Data\Vector;
	use \Saber\Util\Text;
	use \Saber\Util\Text\Regex;

	final class Module extends Data\Module {

		#region Methods -> Basic Operations

		/**
		 * This method returns an array list of substrings that were delimited by the specified
		 * delimiter.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the delimiter
		 * @param String\Type $ys                                   the string to be exploded
		 * @return ArrayList\Type                                   the array list of substrings
		 */
		public static function explode(String\Type $xs, String\Type $ys) {
			$zs = explode($xs->unbox(), $ys->unbox());
			return ArrayList\Type::box(array_map(function($z) {
				return String\Type::box($z);
			}, $zs));
		}

		/**
		 * This method returns a string representing the vector of substring delimited by the
		 * specified string.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the delimiter
		 * @param Vector\Type $ys                                   the vector of substrings
		 * @return String\Type                                      the string
		 */
		public static function implode(String\Type $xs, Vector\Type $ys) {
			$zs = array_map(function(String\Type $y) {
				return $y->unbox();
			}, $ys->unbox());
			return String\Type::box(implode($xs->unbox(), $zs));
		}

		/**
		 * This method returns an array list of substrings that were delimited by an EOL
		 * character.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @return ArrayList\Type                                   an array list of substrings
		 */
		public static function lines(String\Type $xs) {
			return Regex\Module::split(Regex\Type::box('/\R+/'), $xs);
		}

		/**
		 * This method returns a string representing the vector of substring delimited by the
		 * "line feed" character.
		 *
		 * @access public
		 * @static
		 * @param Vector\Type $xs                                   the vector of substrings
		 * @return String\Type                                      the string
		 */
		public static function unlines(Vector\Type $xs) {
			return Text\Module::implode(String\Type::box("\n"), $xs);
		}

		/**
		 * This method returns a string representing the vector of substring delimited by the
		 * "space" character.
		 *
		 * @access public
		 * @static
		 * @param Vector\Type $xs                                   the vector of substrings
		 * @return String\Type                                      the string
		 */
		public static function unwords(Vector\Type $xs) {
			return Text\Module::implode(String\Type::box(' '), $xs);
		}

		/**
		 * This method returns an array list of substrings that were delimited by a whitespace
		 * character.
		 *
		 * @access public
		 * @static
		 * @param String\Type $xs                                   the left operand
		 * @return ArrayList\Type                                   an array list of substrings
		 */
		public static function words(String\Type $xs) {
			return Regex\Module::split(Regex\Type::box('/\s+/'), $xs);
		}

		#endregion

	}

}