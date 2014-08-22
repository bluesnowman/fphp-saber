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
	use \Saber\Data;

	/**
	 * @group AnyCtrl
	 */
	class MonadTest extends Core\AnyTest {

		/**
		 * This method provides the data for testing the evaluation of one value "AND" another.
		 *
		 * @return array
		 */
		public function dataChoice() {
			$data = array(
				array(array(1), array(1)),
			);
			return $data;
		}

		/**
		 * This method tests a set of choice.
		 *
		 * @dataProvider dataChoice
		 */
		public function testChoice($provided, $expected) {
			$p0 = Data\Int32::box($provided[0]);
			$e0 = $expected[0];

			Control\Monad::choice($p0)
				->when(Data\Int32::box(1), function(Data\Int32 $x) use ($e0) {
					$this->assertSame($e0, $x->unbox());
				})
			->end();
			Control\Monad::choice($p0)
				->when(Data\Int32::box(2), function(Data\Int32 $x) use ($e0) {
					$this->assertSame($e0, $x->unbox());
				})
				->when(Data\Int32::box(1), function(Data\Int32 $x) use ($e0) {
					$this->assertSame($e0, $x->unbox());
				})
			->end();
			Control\Monad::choice($p0)
				->when(Data\Int32::box(2), function(Data\Int32 $x) use ($e0) {
					$this->assertSame($e0, $x->unbox());
				})
				->otherwise(function(Data\Int32 $x) use ($e0) {
					$this->assertSame($e0, $x->unbox());
				})
			->end();
		}

	}

}