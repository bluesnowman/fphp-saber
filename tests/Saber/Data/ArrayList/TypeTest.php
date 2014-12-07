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

namespace Saber\Data\ArrayList {

	use \Saber\Core;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Int32;

	/**
	 * @group TypeTest
	 */
	final class TypeTest extends Core\Test {

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array(Int32\Type::zero(), Int32\Type::one()), array(Int32\Type::zero(), Int32\Type::one())),
			);
			return $data;
		}

		/**
		 * This method tests the boxing of a value.
		 *
		 * @dataProvider dataBox
		 */
		public function testBox(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = ArrayList\Type::box($provided);
			$e0 = new ArrayList\Type($expected);

			$this->assertInstanceOf('\\Saber\\Data\\ArrayList\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Vector\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Collection\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $e0->unbox();

			$this->assertInternalType('array', $p1);
			$this->assertInternalType('array', $e1);
			$this->assertCount(count($e1), $p1);
		}

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataMake() {
			$data = array(
				array(array(Int32\Type::zero(), Int32\Type::one()), array(Int32\Type::zero(), Int32\Type::one())),
			);
			return $data;
		}

		/**
		 * This method tests the boxing of a value.
		 *
		 * @dataProvider dataMake
		 */
		public function testMake(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = ArrayList\Type::make($provided);
			$e0 = new ArrayList\Type($expected);

			$this->assertInstanceOf('\\Saber\\Data\\ArrayList\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Vector\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Collection\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $e0->unbox();

			$this->assertInternalType('array', $p1);
			$this->assertInternalType('array', $e1);
			$this->assertCount(count($e1), $p1);
		}

		/**
		 * This method tests the creation of an empty list.
		 */
		public function testEmpty() {
			//$this->markTestIncomplete();

			$p0 = ArrayList\Type::empty_();

			$this->assertInstanceOf('\\Saber\\Data\\ArrayList\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Vector\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Collection\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);

			$p1 = $p0->unbox();

			$this->assertInternalType('array', $p1);
			$this->assertCount(0, $p1);
		}

	}

}