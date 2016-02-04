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

namespace Saber\Data\ITuple {

	use \Saber\Core;
	use \Saber\Data\IInt32;
	use \Saber\Data\ITuple;

	/**
	 * @group ModuleTest
	 */
	final class ModuleTest extends Core\ModuleTest {

		#region Methods -> Basic Operations

		/**
		 * This method provides the data for testing the "first" method.
		 *
		 * @return array
		 */
		public function data_first() {
			$data = array(
				array(array(array(1)), array(1)),
				array(array(array(1, 2)), array(1)),
				array(array(array(1, 2, 3)), array(1)),
			);
			return $data;
		}

		/**
		 * This method tests the "first" method.
		 *
		 * @dataProvider data_first
		 */
		public function test_first(array $provided, array $expected) {
			$p0 = ITuple\Type::make($provided[0]);
			$e0 = $expected[0];

			$this->assertSame($e0, $p0->first()->unbox());
		}

		/**
		 * This method provides the data for testing the "item" method.
		 *
		 * @return array
		 */
		public function data_item() {
			$data = array(
				array(array(array()), array(array())),
				array(array(array(1)), array(array(1))),
				array(array(array(1, 2)), array(array(1, 2))),
				array(array(array(1, 2, 3)), array(array(1, 2, 3))),
			);
			return $data;
		}

		/**
		 * This method tests the "item" method.
		 *
		 * @dataProvider data_item
		 */
		public function test_item(array $provided, array $expected) {
			$p0 = ITuple\Type::make($provided[0]);
			$e0 = $expected[0];

			foreach ($e0 as $i => $e) {
				$this->assertSame($e, $p0->item(IInt32\Type::box($i))->unbox());
			}
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
			$p0 = ITuple\Module::length(ITuple\Type::make($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "second" method.
		 *
		 * @return array
		 */
		public function data_second() {
			$data = array(
				array(array(array(1, 2)), array(2)),
				array(array(array(1, 2, 3)), array(2)),
			);
			return $data;
		}

		/**
		 * This method tests the "second" method.
		 *
		 * @dataProvider data_second
		 */
		public function test_second(array $provided, array $expected) {
			$p0 = ITuple\Type::make($provided[0]);
			$e0 = $expected[0];

			$this->assertSame($e0, $p0->second()->unbox());
		}

		/**
		 * This method provides the data for testing the "swap" method.
		 *
		 * @return array
		 */
		public function data_swap() {
			$data = array(
				array(array(array(1, 2)), array(array(2, 1))),
			);
			return $data;
		}

		/**
		 * This method tests the "swap" method.
		 *
		 * @dataProvider data_swap
		 */
		public function test_swap(array $provided, array $expected) {
			$p0 = ITuple\Module::swap(ITuple\Type::make($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ITuple\\Type', $p0);
			$this->assertSame($e0, $p0->unbox(1));
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method tests the "nvl" method.
		 */
		public function test_nvl() {
			$x = ITuple\Type::make(array(1));
			$y = ITuple\Type::make(array(1, 2));

			$z = ITuple\Module::nvl($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\ITuple\\Type', $z);
			$this->assertSame(array(1), $z->unbox(1));

			$z = ITuple\Module::nvl(null, $x);
			$this->assertInstanceOf('\\Saber\\Data\\ITuple\\Type', $z);
			$this->assertSame(array(1), $z->unbox(1));

			$z = ITuple\Module::nvl(null, null);
			$this->assertInstanceOf('\\Saber\\Data\\ITuple\\Type', $z);
			$this->assertSame(array(), $z->unbox(1));
		}

		/**
		 * This method provides the data for testing the "toArrayList" method.
		 *
		 * @return array
		 */
		public function data_toArrayList() {
			$data = array(
				array(array(array()), array(array())),
				array(array(array(1)), array(array(1))),
				array(array(array(1, 2)), array(array(1, 2))),
				array(array(array(1, 2, 3)), array(array(1, 2, 3))),
			);
			return $data;
		}

		/**
		 * This method tests the "toArrayList" method.
		 *
		 * @dataProvider data_toArrayList
		 */
		public function test_toArrayList(array $provided, array $expected) {
			$p0 = ITuple\Module::toArrayList(ITuple\Type::make($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $p0);
			$this->assertSame($e0, $p0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "toLinkedList" method.
		 *
		 * @return array
		 */
		public function data_toLinkedList() {
			$data = array(
				array(array(array()), array(array())),
				array(array(array(1)), array(array(1))),
				array(array(array(1, 2)), array(array(1, 2))),
				array(array(array(1, 2, 3)), array(array(1, 2, 3))),
			);
			return $data;
		}

		/**
		 * This method tests the "toLinkedList" method.
		 *
		 * @dataProvider data_toLinkedList
		 */
		public function test_toLinkedList(array $provided, array $expected) {
			$p0 = ITuple\Module::toLinkedList(ITuple\Type::make($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertSame($e0, $p0->unbox(1));
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method provides the data for testing the "eq" method.
		 *
		 * @return array
		 */
		public function data_eq() {
			$data = array(
				array(array(array(), array()), array(true)),
				array(array(array(1, 2), array(1, 2)), array(true)),
				array(array(array(1, 2), array(1, 2, 3)), array(false)),
				array(array(array(1, 2), array(3, 4)), array(false)),
				array(array(array(1, 2), array(2, 1)), array(false)),
				array(array(array(1, 2, 3), array(1, 2)), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "eq" method.
		 *
		 * @dataProvider data_eq
		 */
		public function test_eq(array $provided, array $expected) {
			$p0 = ITuple\Module::eq(
				ITuple\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				ITuple\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
			);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "id" method.
		 *
		 * @return array
		 */
		public function data_id() {
			$data = array(
				array(array(array(), array()), array(true)),
				array(array(array(1, 2), array(1, 2)), array(true)),
				array(array(array(1, 2), array(1, 2, 3)), array(false)),
				array(array(array(1, 2), array(3, 4)), array(false)),
				array(array(array(1, 2), array(2, 1)), array(false)),
				array(array(array(1, 2, 3), array(1, 2)), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "id" method.
		 *
		 * @dataProvider data_id
		 */
		public function test_id(array $provided, array $expected) {
			$p0 = ITuple\Module::id(
				ITuple\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				ITuple\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
			);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "ne" method.
		 *
		 * @return array
		 */
		public function data_ne() {
			$data = array(
				array(array(array(), array()), array(false)),
				array(array(array(1, 2), array(1, 2)), array(false)),
				array(array(array(1, 2), array(1, 2, 3)), array(true)),
				array(array(array(1, 2), array(3, 4)), array(true)),
				array(array(array(1, 2), array(2, 1)), array(true)),
				array(array(array(1, 2, 3), array(1, 2)), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "ne" method.
		 *
		 * @dataProvider data_ne
		 */
		public function test_ne(array $provided, array $expected) {
			$p0 = ITuple\Module::ne(
				ITuple\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				ITuple\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
			);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "ni" method.
		 *
		 * @return array
		 */
		public function data_ni() {
			$data = array(
				array(array(array(), array()), array(false)),
				array(array(array(1, 2), array(1, 2)), array(false)),
				array(array(array(1, 2), array(1, 2, 3)), array(true)),
				array(array(array(1, 2), array(3, 4)), array(true)),
				array(array(array(1, 2), array(2, 1)), array(true)),
				array(array(array(1, 2, 3), array(1, 2)), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "ni" method.
		 *
		 * @dataProvider data_ni
		 */
		public function test_ni(array $provided, array $expected) {
			$p0 = ITuple\Module::ni(
				ITuple\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				ITuple\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
			);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method provides the data for testing the "compare" method.
		 *
		 * @return array
		 */
		public function data_compare() {
			$data = array(
				array(array(array(), array()), array(0)),
				array(array(array(1, 2), array(1, 2)), array(0)),
				array(array(array(1, 2), array(3, 4)), array(-1)),
				array(array(array(1, 2), array(2, 1)), array(-1)),
				array(array(array(2, 1), array(1, 2)), array(1)),
			);
			return $data;
		}

		/**
		 * This method tests the "compare" method.
		 *
		 * @dataProvider data_compare
		 */
		public function test_compare(array $provided, array $expected) {
			$p0 = ITuple\Module::compare(
				ITuple\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				ITuple\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
			);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ITrit\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "ge" method.
		 *
		 * @return array
		 */
		public function data_ge() {
			$data = array(
				array(array(array(), array()), array(true)),
				array(array(array(1, 2), array(1, 2)), array(true)),
				array(array(array(1, 2), array(3, 4)), array(false)),
				array(array(array(1, 2), array(2, 1)), array(false)),
				array(array(array(2, 1), array(1, 2)), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "ge" method.
		 *
		 * @dataProvider data_ge
		 */
		public function test_ge(array $provided, array $expected) {
			$p0 = ITuple\Module::ge(
				ITuple\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				ITuple\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
			);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "gt" method.
		 *
		 * @return array
		 */
		public function data_gt() {
			$data = array(
				array(array(array(), array()), array(false)),
				array(array(array(1, 2), array(1, 2)), array(false)),
				array(array(array(1, 2), array(3, 4)), array(false)),
				array(array(array(1, 2), array(2, 1)), array(false)),
				array(array(array(2, 1), array(1, 2)), array(true)),
				array(array(array(3, 4), array(1, 2)), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "gt" method.
		 *
		 * @dataProvider data_gt
		 */
		public function test_gt(array $provided, array $expected) {
			$p0 = ITuple\Module::gt(
				ITuple\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				ITuple\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
			);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "le" method.
		 *
		 * @return array
		 */
		public function data_le() {
			$data = array(
				array(array(array(), array()), array(true)),
				array(array(array(1, 2), array(1, 2)), array(true)),
				array(array(array(1, 2), array(3, 4)), array(true)),
				array(array(array(1, 2), array(2, 1)), array(true)),
				array(array(array(2, 1), array(1, 2)), array(false)),
				array(array(array(3, 4), array(1, 2)), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "le" method.
		 *
		 * @dataProvider data_le
		 */
		public function test_le(array $provided, array $expected) {
			$p0 = ITuple\Module::le(
				ITuple\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				ITuple\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
			);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "lt" method.
		 *
		 * @return array
		 */
		public function data_lt() {
			$data = array(
				array(array(array(), array()), array(false)),
				array(array(array(1, 2), array(1, 2)), array(false)),
				array(array(array(1, 2), array(3, 4)), array(true)),
				array(array(array(1, 2), array(2, 1)), array(true)),
				array(array(array(2, 1), array(1, 2)), array(false)),
				array(array(array(3, 4), array(1, 2)), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "lt" method.
		 *
		 * @dataProvider data_lt
		 */
		public function test_lt(array $provided, array $expected) {
			$p0 = ITuple\Module::lt(
				ITuple\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				ITuple\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
			);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "max" method.
		 *
		 * @return array
		 */
		public function data_max() {
			$data = array(
				array(array(array(), array()), array(array())),
				array(array(array(1, 2), array(1, 2)), array(array(1, 2))),
				array(array(array(1, 2), array(3, 4)), array(array(3, 4))),
				array(array(array(1, 2), array(2, 1)), array(array(2, 1))),
				array(array(array(2, 1), array(1, 2)), array(array(2, 1))),
				array(array(array(3, 4), array(1, 2)), array(array(3, 4))),
			);
			return $data;
		}

		/**
		 * This method tests the "max" method.
		 *
		 * @dataProvider data_max
		 */
		public function test_max(array $provided, array $expected) {
			$p0 = ITuple\Module::max(
				ITuple\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				ITuple\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
			);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ITuple\\Type', $p0);
			$this->assertSame($e0, $p0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "min" method.
		 *
		 * @return array
		 */
		public function data_min() {
			$data = array(
				array(array(array(), array()), array(array())),
				array(array(array(1, 2), array(1, 2)), array(array(1, 2))),
				array(array(array(1, 2), array(3, 4)), array(array(1, 2))),
				array(array(array(1, 2), array(2, 1)), array(array(1, 2))),
				array(array(array(2, 1), array(1, 2)), array(array(1, 2))),
				array(array(array(3, 4), array(1, 2)), array(array(1, 2))),
			);
			return $data;
		}

		/**
		 * This method tests the "min" method.
		 *
		 * @dataProvider data_min
		 */
		public function test_min(array $provided, array $expected) {
			$p0 = ITuple\Module::min(
				ITuple\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				ITuple\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
			);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ITuple\\Type', $p0);
			$this->assertSame($e0, $p0->unbox(1));
		}

		#endregion

		#region Methods -> Evaluating Operations

		/**
		 * This method provides the data for testing the "isPair" method.
		 *
		 * @return array
		 */
		public function data_isPair() {
			$data = array(
				array(array(array()), array(false)),
				array(array(array(1)), array(false)),
				array(array(array(1, 2)), array(true)),
				array(array(array(1, 2, 3)), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isPair" method.
		 *
		 * @dataProvider data_isPair
		 */
		public function test_isPair(array $provided, array $expected) {
			$p0 = ITuple\Module::isPair(ITuple\Type::make($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

	}

}