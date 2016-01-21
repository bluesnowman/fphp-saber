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

namespace Saber\Control {

	use \Saber\Control;
	use \Saber\Core;
	use \Saber\Data\IInt32;

	/**
	 * @group TypeTest
	 */
	final class TypeTest extends Core\TypeTest {

		/**
		 * This method tests a set of choices.
		 */
		public function testChoice() {
			//$this->markTestIncomplete();

			$p0 = IInt32\Type::make(0);
			$e0 = 0;

			$p1 = IInt32\Type::make(1);
			$e1 = 1;

			Control\Type::choice($p0)
				->when($p0, function(IInt32\Type $x) use($e0) {
					$this->assertSame($e0, $x->unbox());
				})
				->otherwise(function(IInt32\Type $x) use($e1) {
					$this->assertSame($e1, $x->unbox());
				})
			->end();
			Control\Type::choice($p0)
				->when($p1, function(IInt32\Type $x) use($e1) {
					$this->assertSame($e1, $x->unbox());
				})
				->when($p0, function(IInt32\Type $x) use($e0) {
					$this->assertSame($e0, $x->unbox());
				})
			->end();
			Control\Type::choice($p0)
				->when($p1, function(IInt32\Type $x) use($e1) {
					$this->assertSame($e1, $x->unbox());
				})
				->otherwise(function(IInt32\Type $x) use($e0) {
					$this->assertSame($e0, $x->unbox());
				})
			->end();
		}

	}

}