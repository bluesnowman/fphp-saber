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

namespace Saber\Data\HashMap {

	use \Saber\Core;
	use \Saber\Data\HashMap;
	use \Saber\Data\Int32;
	use \Saber\Data\String;
	use \Saber\Data\Tuple;

	/**
	 * @group TypeTest
	 */
	final class TypeTest extends Core\TypeTest {

		#region Tests -> Inheritance

		/**
		 * This method tests the data type.
		 */
		public function testType() {
			//$this->markTestIncomplete();

			$p0 = new HashMap\Type();

			$this->assertInstanceOf('\\Saber\\Data\\HashMap\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Map\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Collection\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Equality\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Comparable\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Boxable\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);
		}

		#endregion

		#region Tests -> Initialization

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array(), array(0)),
				array(array(Tuple\Type::box2(String\Type::box('key0'), Int32\Type::zero())), array(1)),
				array(array(Tuple\Type::box2(String\Type::box('key0'), Int32\Type::zero()), Tuple\Type::box2(String\Type::box('key1'), Int32\Type::one())), array(2)),
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

			$p0 = HashMap\Type::box($provided);

			$this->assertInstanceOf('\\Saber\\Data\\HashMap\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('array', $p1);
			$this->assertCount($e1, $p1);
		}

		/**
		 * This method provides the data for testing the making of a value.
		 *
		 * @return array
		 */
		public function dataMake() {
			$data = array(
				array(array(), array(0)),
				array(array(Tuple\Type::box2(String\Type::box('key0'), Int32\Type::zero())), array(1)),
				array(array(Tuple\Type::box2(String\Type::box('key0'), Int32\Type::zero()), Tuple\Type::box2(String\Type::box('key1'), Int32\Type::one())), array(2)),
			);
			return $data;
		}

		/**
		 * This method tests the making of a value.
		 *
		 * @dataProvider dataMake
		 */
		public function testMake(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = HashMap\Type::make($provided);

			$this->assertInstanceOf('\\Saber\\Data\\HashMap\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('array', $p1);
			$this->assertCount($e1, $p1);
		}

		/**
		 * This method tests the creation of an empty list.
		 */
		public function testEmpty() {
			//$this->markTestIncomplete();

			$p0 = HashMap\Type::empty_();

			$this->assertInstanceOf('\\Saber\\Data\\HashMap\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = 0;

			$this->assertInternalType('array', $p1);
			$this->assertCount($e1, $p1);
		}

		#endregion

		#region Tests -> Interface

		/**
		 * This method provides the data for testing that a value is of a particular size.
		 *
		 * @return array
		 */
		public function dataSize() {
			$data = array(
				array(array(), array(0)),
				array(array(Tuple\Type::box2(String\Type::box('key0'), Int32\Type::zero())), array(1)),
				array(array(Tuple\Type::box2(String\Type::box('key0'), Int32\Type::zero()), Tuple\Type::box2(String\Type::box('key1'), Int32\Type::one())), array(2)),
			);
			return $data;
		}

		/**
		 * This method tests that a value is of a particular size.
		 *
		 * @dataProvider dataSize
		 */
		public function testSize(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = HashMap\Type::make($provided)->size();

			$this->assertInstanceOf('\\Saber\\Data\\Int32\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertSame($e1, $p1);
		}

		#endregion

	}

}