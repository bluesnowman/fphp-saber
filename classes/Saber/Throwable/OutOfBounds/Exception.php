<?php

/**
 * Copyright 2014-2015 Blue Snowman
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

namespace Saber\Throwable\OutOfBounds {

	use \Saber\Core;
	use \Saber\Data\Int32;
	use \Saber\Throwable;

	class Exception extends \OutOfBoundsException implements Throwable\Runtime\Exception, Core\Comparable\Type, Core\Equality\Type {

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
		 * @param Int32\Type $code                                  the exception code
		 */
		public function __construct($message = '', array $values = null, Int32\Type $code = null) {
			parent::__construct(
				empty($values) ? (string) $message : strtr( (string) $message, $values),
				Int32\Module::nvl($code)->unbox()
			);
		}

		#endregion

	}

}