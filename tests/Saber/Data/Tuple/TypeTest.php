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

namespace Saber\Data\Tuple {

	use \Saber\Core;
	use \Saber\Data\Int32;
	use \Saber\Data\Tuple;
	use \Saber\Data\Unit;

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

			$p0 = new Tuple\Type(array());

			$this->assertInstanceOf('\\Saber\\Data\\Tuple\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Collection\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Equality\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Comparable\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Boxable\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);
		}

		#endregion

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array(Unit\Type::instance(), Unit\Type::instance()), array(Unit\Type::instance(), Unit\Type::instance())),
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

			$p0 = Tuple\Type::box($provided[0], $provided[1]);

			$this->assertInstanceOf('\\Saber\\Data\\Tuple\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = count($expected);

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
				array(array(Unit\Type::instance(), Unit\Type::instance()), array(Unit\Type::instance(), Unit\Type::instance())),
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

			$p0 = Tuple\Type::make($provided);

			$this->assertInstanceOf('\\Saber\\Data\\Tuple\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = count($expected);

			$this->assertInternalType('array', $p1);
			$this->assertCount($e1, $p1);
		}

		#endregion

		#region Tests -> Interface

		/**
		 * This method tests that an item is accessible.
		 */
		public function testItems() {
			//$this->markTestIncomplete();

			$p0 = Tuple\Type::box(array(Int32\Type::zero(), Int32\Type::one(), Int32\Type::box(2)));

			$this->assertSame(0, $p0->item(Int32\Type::zero())->unbox());
			$this->assertSame(1, $p0->item(Int32\Type::one())->unbox());
			$this->assertSame(2, $p0->item(Int32\Type::box(2))->unbox());

			$this->assertSame(0, $p0->first()->unbox());
			$this->assertSame(1, $p0->second()->unbox());
		}

		/**
		 * This method provides the data for testing that a value is empty.
		 *
		 * @return array
		 */
		public function dataIsEmpty() {
			$data = array(
				array(array(), array(true)),
				array(array(Unit\Type::instance()), array(false)),
				array(array(Unit\Type::instance(), Unit\Type::instance(), Unit\Type::instance()), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests that a value is empty.
		 *
		 * @dataProvider dataIsEmpty
		 */
		public function testIsEmpty(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = Tuple\Type::box($provided)->isEmpty();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that the tuple is a pair.
		 *
		 * @return array
		 */
		public function dataIsPair() {
			$data = array(
				array(array(), array(false)),
				array(array(Unit\Type::instance()), array(false)),
				array(array(Unit\Type::instance(), Unit\Type::instance()), array(true)),
				array(array(Unit\Type::instance(), Unit\Type::instance(), Unit\Type::instance()), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests that the tuple is a pair.
		 *
		 * @dataProvider dataIsPair
		 */
		public function testIsPair(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = Tuple\Type::box($provided)->isPair();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is of a particular length.
		 *
		 * @return array
		 */
		public function dataLength() {
			$data = array(
				array(array(), array(0)),
				array(array(Unit\Type::instance()), array(1)),
				array(array(Unit\Type::instance(), Unit\Type::instance(), Unit\Type::instance()), array(3)),
			);
			return $data;
		}

		/**
		 * This method tests that a value is of a particular length.
		 *
		 * @dataProvider dataLength
		 */
		public function testLength(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = Tuple\Type::box($provided)->length();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Int32\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

	}

}