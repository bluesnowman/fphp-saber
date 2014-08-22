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
 
namespace Saber\Control\Monad\Choice {

	use \Saber\Control;
	use \Saber\Core;
	use \Saber\Throwable;
 
	class Nil extends Control\Monad\Choice {

		public function end() {
			return false;
		}

		public function otherwise(callable $procedure) {
			throw new Throwable\UnimplementedMethod\Exception('Method :method has not been implemented.', array(':method' => __FUNCTION__));
		}

		public function unless(Core\Any $y, callable $procedure) {
			throw new Throwable\UnimplementedMethod\Exception('Method :method has not been implemented.', array(':method' => __FUNCTION__));
		}

		public function when(Core\Any $y, callable $procedure) {
			throw new Throwable\UnimplementedMethod\Exception('Method :method has not been implemented.', array(':method' => __FUNCTION__));
		}

	}
 
}