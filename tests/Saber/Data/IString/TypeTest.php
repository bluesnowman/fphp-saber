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

namespace Saber\Data\IString {

	use \Saber\Core;
	use \Saber\Data\IChar;
	use \Saber\Data\IInt32;
	use \Saber\Data\IString;

	/**
	 * @group TypeTest
	 */
	final class TypeTest extends Core\TypeTest {

		#region Tests -> Inheritance

		/**
		 * This method tests the data type.
		 */
		public function test_instanceOf() {
			//$this->markTestIncomplete();

			$p0 = new IString\Type('test');

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IVector\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\ICollection\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Equality\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Comparable\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Boxable\\Type', $p0);
			$this->assertInstanceOf('\\JsonSerializable', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);
		}

		#endregion

		#region Tests -> Initialization

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function data_box() {
			$data = array(
				array(array('string'), array('string')),
			);
			return $data;
		}

		/**
		 * This method tests the boxing of a value.
		 *
		 * @dataProvider data_box
		 */
		public function test_box(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IString\Type::box($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('string', $p1);
			$this->assertInternalType('string', $e1);
			$this->assertTrue(strlen($e1) == strlen($p1));
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method provides the data for testing the making of a value.
		 *
		 * @return array
		 */
		public function data_make() {
			$data = array(
				array(array('string'), array('string')),
			);
			return $data;
		}

		/**
		 * This method tests the making of a value.
		 *
		 * @dataProvider data_make
		 */
		public function test_make(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IString\Type::make($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('string', $p1);
			$this->assertInternalType('string', $e1);
			$this->assertTrue(strlen($e1) == strlen($p1));
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method tests the creation of an empty list.
		 */
		public function testEmpty() {
			//$this->markTestIncomplete();

			$p0 = IString\Type::empty_();

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p0);

			$p1 = $p0->unbox();

			$this->assertInternalType('string', $p1);
			$this->assertTrue(0 == strlen($p1));
		}

		/**
		 * This method provides the data for testing that a value is repeated "n" times.
		 *
		 * @return array
		 */
		public function dataReplicate() {
			$data = array(
				array(array('s', 1), array('s')),
				array(array('s', 5), array('sssss')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is repeated "n" times.
		 *
		 * @dataProvider dataReplicate
		 */
		public function testReplicate(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IString\Type::replicate(IChar\Type::make($provided[0]), IInt32\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

		#region Tests -> Interface

		/**
		 * This method tests that an item is accessible.
		 */
		public function testItems() {
			//$this->markTestIncomplete();

			$p0 = IString\Type::box('012');

			$this->assertSame('0', $p0->item(IInt32\Type::zero())->unbox());
			$this->assertSame('1', $p0->item(IInt32\Type::one())->unbox());
			$this->assertSame('2', $p0->item(IInt32\Type::box(2))->unbox());

			$this->assertSame('0', $p0->head()->unbox());

			$p1 = $p0->tail();

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p1);

			$p2 = $p1->unbox();

			$this->assertInternalType('string', $p2);
			$this->assertTrue(2 == strlen($p2));
			$this->assertSame('12', $p2);
		}

		/**
		 * This method provides the data for testing that a value is empty.
		 *
		 * @return array
		 */
		public function dataIsEmpty() {
			$data = array(
				array(array(''), array(true)),
				array(array('s'), array(false)),
				array(array('string'), array(false)),
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

			$p0 = IString\Type::make($provided[0])->isEmpty();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is of a particular length.
		 *
		 * @return array
		 */
		public function dataLength() {
			$data = array(
				array(array(''), array(0)),
				array(array('s'), array(1)),
				array(array('string'), array(6)),
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

			$p0 = IString\Type::make($provided[0])->length();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

	}

}
