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

namespace Saber\Data\ILinkedList {

	use \Saber\Core;
	use \Saber\Data\IInt32;
	use \Saber\Data\ILinkedList;

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

			$p0 = new ILinkedList\Nil\Type();

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
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
				array(array(IInt32\Type::zero(), IInt32\Type::one()), array(IInt32\Type::zero(), IInt32\Type::one())),
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

			$p0 = ILinkedList\Type::box($provided);

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = count($expected);

			$this->assertInternalType('array', $p1);
			$this->assertCount($e1, $p1);
		}

		/**
		 * This method tests the boxing of a value.
		 *
		 * @dataProvider data_box
		 */
		public function test_box2(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = call_user_func_array(array('\\Saber\\Data\\ILinkedList\\Type', 'box2'), $provided);

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);

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
		public function data_make() {
			$data = array(
				array(array(IInt32\Type::zero(), IInt32\Type::one()), array(IInt32\Type::zero(), IInt32\Type::one())),
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

			$p0 = ILinkedList\Type::make($provided);

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = count($expected);

			$this->assertInternalType('array', $p1);
			$this->assertCount($e1, $p1);
		}

		/**
		 * This method tests the making of a value.
		 *
		 * @dataProvider data_make
		 */
		public function test_make2(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = call_user_func_array(array('\\Saber\\Data\\ILinkedList\\Type', 'make2'), $provided);

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = count($expected);

			$this->assertInternalType('array', $p1);
			$this->assertCount($e1, $p1);
		}

		/**
		 * This method tests the creation of an empty list.
		 */
		public function testEmpty() {
			//$this->markTestIncomplete();

			$p0 = ILinkedList\Type::empty_();

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);

			$p1 = $p0->unbox();

			$this->assertInternalType('array', $p1);
			$this->assertCount(0, $p1);
		}

		/**
		 * This method provides the data for testing that a value is repeated "n" times.
		 *
		 * @return array
		 */
		public function dataReplicate() {
			$data = array(
				array(array(IInt32\Type::zero(), 1), array(IInt32\Type::zero())),
				array(array(IInt32\Type::zero(), 5), array(IInt32\Type::zero(), IInt32\Type::zero(), IInt32\Type::zero(), IInt32\Type::zero(), IInt32\Type::zero())),
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

			$p0 = ILinkedList\Type::replicate($provided[0], IInt32\Type::make($provided[1]));

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);

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

			$p0 = ILinkedList\Type::box(array(IInt32\Type::zero(), IInt32\Type::one(), IInt32\Type::box(2)));

			$this->assertSame(0, $p0->item(IInt32\Type::zero())->unbox());
			$this->assertSame(1, $p0->item(IInt32\Type::one())->unbox());
			$this->assertSame(2, $p0->item(IInt32\Type::box(2))->unbox());

			$this->assertSame(0, $p0->head()->unbox());

			$p1 = $p0->tail();

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p1);

			$p2 = $p1->unbox();

			$this->assertInternalType('array', $p2);
			$this->assertCount(2, $p2);

			$this->assertSame(1, $p2[0]->unbox());
			$this->assertSame(2, $p2[1]->unbox());
		}

		/**
		 * This method provides the data for testing that a value is empty.
		 *
		 * @return array
		 */
		public function dataIsEmpty() {
			$data = array(
				array(array(), array(true)),
				array(array(IInt32\Type::zero()), array(false)),
				array(array(IInt32\Type::zero(), IInt32\Type::zero(), IInt32\Type::zero()), array(false)),
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

			$p0 = ILinkedList\Type::box($provided)->isEmpty();
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
				array(array(), array(0)),
				array(array(IInt32\Type::zero()), array(1)),
				array(array(IInt32\Type::zero(), IInt32\Type::zero(), IInt32\Type::zero()), array(3)),
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

			$p0 = ILinkedList\Type::box($provided)->length();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

	}

}