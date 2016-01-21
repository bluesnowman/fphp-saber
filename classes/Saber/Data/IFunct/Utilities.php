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

namespace Saber\Data\IFunct {

	use \Saber\Core;
	use \Saber\Data;

	final class Utilities extends Data\Utilities {

		/**
		 * This method returns a function that will always return a reference to the specified
		 * object.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $object                                 the object to be wrapped
		 * @return callable                                         the wrapped value
		 */
		public static function constant(Core\Type $object) {
			return function() use ($object) {
				return $object;
			};
		}

		/**
		 * This method is used to curry a closure's arguments.
		 *
		 * @access public
		 * @static
		 * @param callable $closure                                 the closure to be called
		 * @return Core\Type                                        the result returned by the closure
		 */
		public static function curry(callable $closure/*, Core\Type... $args*/) : Core\Type {
			$args = func_get_args();
			$args = array_slice($args, 1);
			return function() use ($closure, $args) {
				return call_user_func_array($closure, array_merge($args, func_get_args()));
			};
		}

		/**
		 * This method returns the result of the specified closure after using memoization
		 * to help improve performance.
		 *
		 * @access public
		 * @static
		 * @param callable $closure                                 the closure to be called
		 * @return Core\Type                                        the result returned by the closure
		 */
		public static function memoize(callable $closure) : Core\Type {
			return function() use ($closure) {
				static $results = array();
				$args = func_get_args();
				$key = (string) serialize($args);
				if (!array_key_exists($key, $results)) {
					$results[$key] = call_user_func_array($closure, $args);
				}
				return $results[$key];
			};
		}

	}

}