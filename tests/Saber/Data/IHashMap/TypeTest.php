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

namespace Saber\Data\IHashMap {

	use \Saber\Core;
	use \Saber\Data\IHashMap;
	use \Saber\Data\IInt32;
	use \Saber\Data\IString;
	use \Saber\Data\ITuple;
	use \Saber\Data\IUnit;

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

			$p0 = new IHashMap\Type();

			$this->assertInstanceOf('\\Saber\\Data\\IHashMap\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IMap\\Type', $p0);
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
				array(array(), array(0)),
				array(array(ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero())), array(1)),
				array(array(ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero()), ITuple\Type::box2(IString\Type::box('key1'), IInt32\Type::one())), array(2)),
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

			$p0 = IHashMap\Type::box($provided);

			$this->assertInstanceOf('\\Saber\\Data\\IHashMap\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

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

			$p0 = call_user_func_array(array('\\Saber\\Data\\IHashMap\\Type', 'box2'), $provided);

			$this->assertInstanceOf('\\Saber\\Data\\IHashMap\\Type', $p0);

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
		public function data_make() {
			$data = array(
				array(array(), array(0)),
				array(array(ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero())), array(1)),
				array(array(ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero()), ITuple\Type::box2(IString\Type::box('key1'), IInt32\Type::one())), array(2)),
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

			$p0 = IHashMap\Type::make($provided);

			$this->assertInstanceOf('\\Saber\\Data\\IHashMap\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

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

			$p0 = call_user_func_array(array('\\Saber\\Data\\IHashMap\\Type', 'make2'), $provided);

			$this->assertInstanceOf('\\Saber\\Data\\IHashMap\\Type', $p0);

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

			$p0 = IHashMap\Type::empty_();

			$this->assertInstanceOf('\\Saber\\Data\\IHashMap\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = 0;

			$this->assertInternalType('array', $p1);
			$this->assertCount($e1, $p1);
		}

		#endregion

		#region Tests -> Interface

		/**
		 * This method tests that all items are cleared from a list.
		 */
		public function testClear() {
			//$this->markTestIncomplete();

			$p0 = IHashMap\Type::make2(
				ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero()),
				ITuple\Type::box2(IString\Type::box('key1'), IInt32\Type::one()),
				ITuple\Type::box2(IString\Type::box('key2'), IInt32\Type::box(2))
			);

			$p1 = $p0->unbox();
			$this->assertCount(3, $p1);

			$p0 = $p0->clear();
			$p2 = $p0->unbox();
			$this->assertCount(0, $p2);
		}

		/**
		 * This method tests that the entries are retrievable.
		 */
		public function testEntries() {
			//$this->markTestIncomplete();

			$entries = array(
				ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero()),
				ITuple\Type::box2(IString\Type::box('key1'), IInt32\Type::one()),
				ITuple\Type::box2(IString\Type::box('key2'), IInt32\Type::box(2))
			);

			$p0 = IHashMap\Type::make($entries)->entries();

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $p0);

			$p1 = $p0->unbox();

			$this->assertInternalType('array', $p1);
			$this->assertCount(3, $p1);
		}

		/**
		 * This method provides the data for testing that an item exists in the collection.
		 *
		 * @return array
		 */
		public function dataHasKey() {
			$data = array(
				array(array(IString\Type::box('key0')), array(true)),
				array(array(IString\Type::box('key1')), array(true)),
				array(array(IString\Type::box('key2')), array(true)),
				array(array(IString\Type::box('key3')), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests that an item exists in the collection.
		 *
		 * @dataProvider dataHasKey
		 */
		public function testHasKey(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$entries = array(
				ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero()),
				ITuple\Type::box2(IString\Type::box('key1'), IInt32\Type::one()),
				ITuple\Type::box2(IString\Type::box('key2'), IInt32\Type::box(2))
			);

			$p0 = IHashMap\Type::make($entries)->hasKey($provided[0]);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is empty.
		 *
		 * @return array
		 */
		public function dataIsEmpty() {
			$data = array(
				array(array(), array(true)),
				array(array(ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero())), array(false)),
				array(array(ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero()), ITuple\Type::box2(IString\Type::box('key1'), IInt32\Type::one())), array(false)),
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

			$p0 = IHashMap\Type::make($provided)->isEmpty();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that an item exists in the collection.
		 *
		 * @return array
		 */
		public function dataItem() {
			$data = array(
				array(array(IString\Type::box('key0')), array(IInt32\Type::zero())),
				array(array(IString\Type::box('key1')), array(IInt32\Type::one())),
				array(array(IString\Type::box('key2')), array(IInt32\Type::box(2))),
				array(array(IString\Type::box('key3')), array(IUnit\Type::instance())),
			);
			return $data;
		}

		/**
		 * This method tests that an item exists in the collection.
		 *
		 * @dataProvider dataItem
		 */
		public function testItem(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$entries = array(
				ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero()),
				ITuple\Type::box2(IString\Type::box('key1'), IInt32\Type::one()),
				ITuple\Type::box2(IString\Type::box('key2'), IInt32\Type::box(2))
			);

			$p0 = IHashMap\Type::make($entries)->item($provided[0])->unbox();
			$e0 = $expected[0]->unbox();

			$this->assertSame($e0, $p0);
		}

		/**
		 * This method tests that the items are retrievable.
		 */
		public function testItems() {
			//$this->markTestIncomplete();

			$entries = array(
				ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero()),
				ITuple\Type::box2(IString\Type::box('key1'), IInt32\Type::one()),
				ITuple\Type::box2(IString\Type::box('key2'), IInt32\Type::box(2))
			);

			$p0 = IHashMap\Type::make($entries)->items();

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $p0);

			$p1 = $p0->unbox();

			$this->assertInternalType('array', $p1);
			$this->assertCount(3, $p1);
		}

		/**
		 * This method tests that the keys are retrievable.
		 */
		public function testKeys() {
			//$this->markTestIncomplete();

			$entries = array(
				ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero()),
				ITuple\Type::box2(IString\Type::box('key1'), IInt32\Type::one()),
				ITuple\Type::box2(IString\Type::box('key2'), IInt32\Type::box(2))
			);

			$p0 = IHashMap\Type::make($entries)->keys();

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $p0);

			$p1 = $p0->unbox();

			$this->assertInternalType('array', $p1);
			$this->assertCount(3, $p1);
		}

		/**
		 * This method provides the data for testing that an item is put in the collection.
		 *
		 * @return array
		 */
		public function dataPutEntry() {
			$data = array(
				array(array(ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero())), array(1)),
				array(array(ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero()), ITuple\Type::box2(IString\Type::box('key1'), IInt32\Type::one())), array(2)),
				array(array(ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero()), ITuple\Type::box2(IString\Type::box('key1'), IInt32\Type::one()), ITuple\Type::box2(IString\Type::box('key2'), IInt32\Type::one())), array(3)),
				array(array(ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero()), ITuple\Type::box2(IString\Type::box('key1'), IInt32\Type::one()), ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::one())), array(2)),
			);
			return $data;
		}

		/**
		 * This method tests that an item is put in the collection.
		 *
		 * @dataProvider dataPutEntry
		 */
		public function testPutEntry(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = new IHashMap\Type();

			foreach ($provided as $entry) {
				$p0->putEntry($entry->first(), $entry->second());
			}

			$p1 = $p0->size()->unbox();
			$e1 = $expected[0];

			$this->assertSame($e1, $p1);
		}

		/**
		 * This method provides the data for testing that an item is removed in the collection.
		 *
		 * @return array
		 */
		public function dataRemoveKey() {
			$data = array(
				array(array(IString\Type::box('key0')), array(2)),
				array(array(IString\Type::box('key0'), IString\Type::box('key1')), array(1)),
				array(array(IString\Type::box('key0'), IString\Type::box('key1'), IString\Type::box('key2')), array(0)),
				array(array(IString\Type::box('key0'), IString\Type::box('key1'), IString\Type::box('key0')), array(1)),
			);
			return $data;
		}

		/**
		 * This method tests that an item is removed in the collection.
		 *
		 * @dataProvider dataRemoveKey
		 */
		public function testRemoveKey(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$entries = array(
				ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero()),
				ITuple\Type::box2(IString\Type::box('key1'), IInt32\Type::one()),
				ITuple\Type::box2(IString\Type::box('key2'), IInt32\Type::box(2))
			);

			$p0 = IHashMap\Type::make($entries);

			foreach ($provided as $key) {
				$p0->removeKey($key);
			}

			$p1 = $p0->size()->unbox();
			$e1 = $expected[0];

			$this->assertSame($e1, $p1);
		}

		/**
		 * This method provides the data for testing that a value is of a particular size.
		 *
		 * @return array
		 */
		public function dataSize() {
			$data = array(
				array(array(), array(0)),
				array(array(ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero())), array(1)),
				array(array(ITuple\Type::box2(IString\Type::box('key0'), IInt32\Type::zero()), ITuple\Type::box2(IString\Type::box('key1'), IInt32\Type::one())), array(2)),
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

			$p0 = IHashMap\Type::make($provided)->size();

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertSame($e1, $p1);
		}

		#endregion

	}

}