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

namespace Saber\Throwable\Runtime {

	use \Saber\Core;

	interface Exception extends Core\Type {

		#region Methods -> Native Oriented

		/**
		 * This method returns the exception code.
		 *
		 * @access public
		 * @return integer                                          the exception code
		 */
		public function __getCode();

		/**
		 * This method returns the source file's name.
		 *
		 * @access public
		 * @return string                                           the source file's name
		 */
		public function __getFile();

		/**
		 * This method returns the line at which the exception was thrown.
		 *
		 * @access public
		 * @return integer                                          the source line
		 */
		public function __getLine();

		/**
		 * This method returns the exception message.
		 *
		 * @access public
		 * @return string                                           the exception message
		 */
		public function __getMessage();

		/**
		 * This method returns any backtrace information.
		 *
		 * @access public
		 * @return array                                            any backtrace information
		 */
		public function __getTrace();

		/**
		 * This method returns the backtrace information as a string.
		 *
		 * @access public
		 * @return string                                           the backtrace information
		 */
		public function __getTraceAsString();

		#endregion

	}

}