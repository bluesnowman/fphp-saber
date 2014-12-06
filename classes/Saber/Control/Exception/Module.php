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
 
namespace Saber\Control\Exception {

	use \Saber\Control;
	use \Saber\Data\Int32;
	use \Saber\Data\Either;
	use \Saber\Data\Unit;
	use \Saber\Throwable;

	final class Module extends Control\Module {

		/**
		 * This method returns a Left\Type when an exception is encountered or a Right\Type
		 * when try-block has executed successfully.
		 *
		 * @public
		 * @static
		 * @param callable $tryblock                                the try-block to be processed
		 * @return Either\Type                                      either a Left\Type or a Right\Type
		 */
		public static function try_(callable $tryblock) {
			try {
				return Either\Type::right($tryblock());
			}
			catch (Throwable\Runtime\Exception $re) {
				return Either\Type::left($re);
			}
			catch (\Exception $ue) {
				return Either\Type::left(new Throwable\Unknown\Exception($ue));
			}
		}

		/**
		 * This method throws the specified exception, but will wrap "unknown" exceptions
		 * for consistent handling.
		 *
		 * @access public
		 * @static
		 * @param \Exception $e                                     the exception to be thrown
		 * @throws Throwable\Runtime\Exception                      the thrown exception
		 */
		public static function raise(\Exception $e) {
			if ($e instanceof Throwable\Runtime\Exception) {
				throw $e;
			}
			else {
				throw new Throwable\Unknown\Exception($e);
			}
		}

	}

}