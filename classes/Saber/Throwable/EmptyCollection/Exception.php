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

namespace Saber\Throwable\EmptyCollection {

	use \Saber\Throwable;

	class Exception extends \RuntimeException implements Throwable\Runtime\Exception {

		#region Traits

		use Throwable\Runtime\Exception\Impl;

		#endregion

		#region Methods -> Initialization

		/**
		 * This constructor creates a new runtime exception.
		 *
		 * @access public
		 * @param string $message                                   the error message
		 * @param array $values                                     the value to be formatted
		 * @param integer $code                                     the exception code
		 */
		public function __construct($message = '', array $values = null, $code = 0) {
			parent::__construct(
				empty($values) ? (string) $message : strtr( (string) $message, $values),
				(int) $code
			);
			$this->code = (int) $code; // Known bug: http://bugs.php.net/39615
			$this->value = $values;
		}

		#endregion

	}

}
