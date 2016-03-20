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
	use \Saber\Data\IObject;

	/**
	 * @group TypeTest
	 */
	final class TypeTest extends Core\TypeTest {

		#region Tests -> Inheritance

		/**
		 * This method tests the "instanceOf" property.
		 */
		public function test_instanceOf() {
			$p0 = new ILinkedList\Nil\Type();

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\ISeq\\Type', $p0);
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
		 * This method provides the data for testing the "box" method.
		 *
		 * @return array
		 */
		public function data_box() {
			$data = array(
				array(array(array(1, 2)), array(array(1, 2))),
			);
			return $data;
		}

		/**
		 * This method tests the "box" method.
		 *
		 * @dataProvider data_box
		 */
		public function test_box(array $provided, array $expected) {
			$p0 = ILinkedList\Type::box(array_map(function($item) {
				return IObject\Type::box($item);
			}, $provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertSame($e0, $p0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "box2" method.
		 *
		 * @return array
		 */
		public function data_box2() {
			$data = array(
				array(array(array(1, 2)), array(array(1, 2))),
			);
			return $data;
		}

		/**
		 * This method tests the "box2" method.
		 *
		 * @dataProvider data_box2
		 */
		public function test_box2(array $provided, array $expected) {
			$p0 = call_user_func_array(array('\\Saber\\Data\\ILinkedList\\Type', 'box2'), array_map(function($item) {
				return IObject\Type::box($item);
			}, $provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertSame($e0, $p0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "covariant" method.
		 *
		 * @return array
		 */
		public function data_covariant() {
			$data = array(
				array(array(array(1, 2)), array(array(1, 2))),
			);
			return $data;
		}

		/**
		 * This method tests the "covariant" method.
		 *
		 * @dataProvider data_covariant
		 */
		public function test_covariant(array $provided, array $expected) {
			$p0 = ILinkedList\Type::covariant(ILinkedList\Type::make($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertSame($e0, $p0->unbox(1));
		}

		/**
		 * This method tests the "empty" method.
		 */
		public function test_empty() {
			$p0 = ILinkedList\Type::empty_();

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertCount(0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "make" method.
		 *
		 * @return array
		 */
		public function data_make() {
			$data = array(
				array(array(array(1, 2)), array(array(1, 2))),
			);
			return $data;
		}

		/**
		 * This method tests the "make" method.
		 *
		 * @dataProvider data_make
		 */
		public function test_make(array $provided, array $expected) {
			$p0 = ILinkedList\Type::make($provided[0]);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertSame($e0, $p0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "make2" method.
		 *
		 * @return array
		 */
		public function data_make2() {
			$data = array(
				array(array(array(1, 2)), array(array(1, 2))),
			);
			return $data;
		}

		/**
		 * This method tests the "make2" method.
		 *
		 * @dataProvider data_make2
		 */
		public function test_make2(array $provided, array $expected) {
			$p0 = call_user_func_array(array('\\Saber\\Data\\ILinkedList\\Type', 'make2'), array_map(function($item) {
				return IObject\Type::box($item);
			}, $provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertSame($e0, $p0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "replicate" method.
		 *
		 * @return array
		 */
		public function data_replicate() {
			$data = array(
				array(array(123, 1), array(array(123))),
				array(array(123, 5), array(array(123, 123, 123, 123, 123))),
			);
			return $data;
		}

		/**
		 * This method tests the "replicate" method.
		 *
		 * @dataProvider data_replicate
		 */
		public function test_replicate(array $provided, array $expected) {
			$p0 = ILinkedList\Type::replicate(IObject\Type::box($provided[0]), IInt32\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertSame($e0, $p0->unbox(1));
		}

		#endregion

		#region Tests -> Interface

		/**
		 * This method provides the data for testing the "hashCode" method.
		 *
		 * @return array
		 */
		public function data_hashCode() {
			$data = array(
				array(array(array(1, 2))),
			);
			return $data;
		}

		/**
		 * This method tests the "hashCode" method.
		 *
		 * @dataProvider data_hashCode
		 */
		public function test_hashCode(array $provided) {
			$p0 = ILinkedList\Type::make($provided[0])->hashCode();

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p0);
			$this->assertRegExp('/^[0-9a-f]{32}$/', $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isEmpty" method.
		 *
		 * @return array
		 */
		public function data_isEmpty() {
			$data = array(
				array(array(array()), array(true)),
				array(array(array(1)), array(false)),
				array(array(array(1, 2)), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isEmpty" method.
		 *
		 * @dataProvider data_isEmpty
		 */
		public function test_isEmpty(array $provided, array $expected) {
			$p0 = ILinkedList\Type::make($provided[0])->isEmpty();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method tests the "item" related methods.
		 */
		public function test_items() {
			$p0 = ILinkedList\Type::box2(IInt32\Type::zero(), IInt32\Type::one(), IInt32\Type::box(2));

			$this->assertSame(0, $p0->item(IInt32\Type::zero())->unbox());
			$this->assertSame(1, $p0->item(IInt32\Type::one())->unbox());
			$this->assertSame(2, $p0->item(IInt32\Type::box(2))->unbox());

			$this->assertSame(0, $p0->head()->unbox());

			$p1 = $p0->tail();

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p1);
			$this->assertSame(array(1, 2), $p1->unbox(1));
		}

		/**
		 * This method provides the data for testing the "length" method.
		 *
		 * @return array
		 */
		public function data_length() {
			$data = array(
				array(array(array()), array(0)),
				array(array(array(1)), array(1)),
				array(array(array(1, 2)), array(2)),
				array(array(array(1, 2, 3)), array(3)),
			);
			return $data;
		}

		/**
		 * This method tests the "length" method.
		 *
		 * @dataProvider data_length
		 */
		public function test_length(array $provided, array $expected) {
			$p0 = ILinkedList\Type::make($provided[0])->length();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "toString" method.
		 *
		 * @return array
		 */
		public function data_toString() {
			$data = array(
				array(array(array()), array('[]')),
				array(array(array(1)), array('[1]')),
				array(array(array(1, 2)), array('[1,2]')),
				array(array(array(1, 2, 3)), array('[1,2,3]')),
			);
			return $data;
		}

		/**
		 * This method tests the "toString" method.
		 *
		 * @dataProvider data_toString
		 */
		public function test_toString(array $provided, array $expected) {
			$this->markTestIncomplete();

			$p0 = ILinkedList\Type::make($provided[0])->toString();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

	}

}