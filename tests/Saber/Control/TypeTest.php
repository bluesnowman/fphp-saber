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

namespace Saber\Control {

	use \Saber\Control;
	use \Saber\Core;
	use \Saber\Data\Int32;

	/**
	 * @group TypeTest
	 */
	final class TypeTest extends Core\Test {

		/**
		 * This method tests a set of choices.
		 */
		public function testChoice() {
			//$this->markTestIncomplete();

			$p0 = Int32\Type::make(0);
			$e0 = 0;

			$p1 = Int32\Type::make(1);
			$e1 = 1;

			Control\Type::choice($p0)
				->when($p0, function(Int32\Type $x) use($e0) {
					$this->assertSame($e0, $x->unbox());
				})
				->otherwise(function(Int32\Type $x) use($e1) {
					$this->assertSame($e1, $x->unbox());
				})
			->end();
			Control\Type::choice($p0)
				->when($p1, function(Int32\Type $x) use($e1) {
					$this->assertSame($e1, $x->unbox());
				})
				->when($p0, function(Int32\Type $x) use($e0) {
					$this->assertSame($e0, $x->unbox());
				})
			->end();
			Control\Type::choice($p0)
				->when($p1, function(Int32\Type $x) use($e1) {
					$this->assertSame($e1, $x->unbox());
				})
				->otherwise(function(Int32\Type $x) use($e0) {
					$this->assertSame($e0, $x->unbox());
				})
			->end();
		}

	}

}