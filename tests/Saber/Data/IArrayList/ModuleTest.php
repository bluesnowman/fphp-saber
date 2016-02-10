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

namespace Saber\Data\IArrayList {

	use \Saber\Core;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IInt32;
	use \Saber\Data\ILinkedList;

	/**
	 * @group ModuleTest
	 */
	final class ModuleTest extends Core\ModuleTest {

		#region Methods -> Basic Operations

		/**
		 * This method provides the data for testing the "all" method.
		 *
		 * @return array
		 */
		public function data_all() {
			$predicate = function(Core\Boxable\Type $x, IInt32\Type $i) : IBool\Type {
				return IBool\Type::box($x->unbox() < 5);
			};
			$data = array(
				array(array(array(), $predicate), array(true)),
				array(array(array(1), $predicate), array(true)),
				array(array(array(1, 2), $predicate), array(true)),
				array(array(array(1, 2, 3), $predicate), array(true)),
				array(array(array(1, 5, 3), $predicate), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "all" method.
		 *
		 * @dataProvider data_all
		 */
		public function test_all(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = $provided[1];

			$r0 = IArrayList\Module::all($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $r0);
			$this->assertSame($e0, $r0->unbox());
		}

		/**
		 * This method provides the data for testing the "any" method.
		 *
		 * @return array
		 */
		public function data_any() {
			$predicate = function(Core\Boxable\Type $x, IInt32\Type $i) : IBool\Type {
				return IBool\Type::box($x->unbox() == 2);
			};
			$data = array(
				array(array(array(), $predicate), array(false)),
				array(array(array(1), $predicate), array(false)),
				array(array(array(1, 2), $predicate), array(true)),
				array(array(array(1, 2, 3), $predicate), array(true)),
				array(array(array(1, 5, 3), $predicate), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "any" method.
		 *
		 * @dataProvider data_any
		 */
		public function test_any(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = $provided[1];

			$r0 = IArrayList\Module::any($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $r0);
			$this->assertSame($e0, $r0->unbox());
		}

		/**
		 * This method provides the data for testing the "append" method.
		 *
		 * @return array
		 */
		public function data_append() {
			$data = array(
				array(array(array(), 9), array(array(9))),
				array(array(array(1), 9), array(array(1, 9))),
				array(array(array(1, 2), 9), array(array(1, 2, 9))),
			);
			return $data;
		}

		/**
		 * This method tests the "append" method.
		 *
		 * @dataProvider data_append
		 */
		public function test_append(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = IInt32\Type::box($provided[1]);

			$r0 = IArrayList\Module::append($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $r0);
			$this->assertSame($e0, $r0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "concat" method.
		 *
		 * @return array
		 */
		public function data_concat() {
			$data = array(
				array(array(array(), array(9, 0)), array(array(9, 0))),
				array(array(array(1), array(9, 0)), array(array(1, 9, 0))),
				array(array(array(1, 2), array(9, 0)), array(array(1, 2, 9, 0))),
			);
			return $data;
		}

		/**
		 * This method tests the "concat" method.
		 *
		 * @dataProvider data_concat
		 */
		public function test_concat(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = IArrayList\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type');

			$r0 = IArrayList\Module::concat($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $r0);
			$this->assertSame($e0, $r0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "contains" method.
		 *
		 * @return array
		 */
		public function data_contains() {
			$data = array(
				array(array(array(), 2), array(false)),
				array(array(array(1), 2), array(false)),
				array(array(array(1, 2), 2), array(true)),
				array(array(array(1, 2, 3), 2), array(true)),
				array(array(array(1, 5, 3), 2), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "contains" method.
		 *
		 * @dataProvider data_contains
		 */
		public function test_contains(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = IInt32\Type::box($provided[1]);

			$r0 = IArrayList\Module::contains($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $r0);
			$this->assertSame($e0, $r0->unbox());
		}

		/**
		 * This method provides the data for testing the "delete" method.
		 *
		 * @return array
		 */
		public function data_delete() {
			$data = array(
				array(array(array(), 9), array(array())),
				array(array(array(1), 9), array(array(1))),
				array(array(array(1, 2), 9), array(array(1, 2))),
				array(array(array(1, 2, 9), 9), array(array(1, 2))),
				array(array(array(1, 9, 2), 9), array(array(1, 2))),
				array(array(array(9, 1, 2), 9), array(array(1, 2))),
				array(array(array(9, 1, 2, 9), 9), array(array(1, 2, 9))),
			);
			return $data;
		}

		/**
		 * This method tests the "delete" method.
		 *
		 * @dataProvider data_delete
		 */
		public function test_delete(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = IInt32\Type::box($provided[1]);

			$r0 = IArrayList\Module::delete($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $r0);
			$this->assertSame($e0, $r0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "iterator" method.
		 *
		 * @return array
		 */
		public function data_iterator() {
			$data = array(
				array(array(array()), array(array())),
				array(array(array(1)), array(array(1))),
				array(array(array(1, 2)), array(array(1, 2))),
				array(array(array(1, 2, 3)), array(array(1, 2, 3))),
			);
			return $data;
		}

		/**
		 * This method tests the "iterator" method.
		 *
		 * @dataProvider data_iterator
		 */
		public function test_iterator(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $p0);
			$this->assertCount(count($e0), $p0->unbox());

			$p1 = IArrayList\Module::iterator($p0);
			$e1 = 0;

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Iterator', $p1);

			foreach ($p1 as $i => $item) {
				$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $i);
				$this->assertSame($e1, $i->unbox());
				$this->assertInstanceOf('\\Saber\\Core\\Type', $item);
				$this->assertSame($e0[$e1], $item->unbox());
				$e1++;
			}
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method tests the "nvl" method.
		 */
		public function test_nvl() {
			$x = IArrayList\Type::make(array(1, 2, 3), '\\Saber\\Data\\IInt32\\Type');
			$y = IArrayList\Type::empty_();

			$z = IArrayList\Module::nvl($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $z);
			$this->assertSame(array(1, 2, 3), $z->unbox(1));

			$z = IArrayList\Module::nvl(null, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $z);
			$this->assertSame(array(1, 2, 3), $z->unbox(1));

			$z = IArrayList\Module::nvl(null, null);
			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $z);
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
			$p0 = IArrayList\Module::toArrayList(IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'));
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
			$p0 = ILinkedList\Module::toLinkedList(ILinkedList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertSame($e0, $p0->unbox(1));
		}

		#endregion

		#region Methods -> Equality Operations

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
			$p0 = IArrayList\Module::compare(
				IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				IArrayList\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
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
			$p0 = IArrayList\Module::ge(
				IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				IArrayList\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
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
			$p0 = IArrayList\Module::gt(
				IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				IArrayList\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
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
			$p0 = IArrayList\Module::le(
				IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				IArrayList\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
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
			$p0 = IArrayList\Module::lt(
				IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				IArrayList\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
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
			$p0 = IArrayList\Module::max(
				IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				IArrayList\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
			);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $p0);
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
			$p0 = IArrayList\Module::min(
				IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type'),
				IArrayList\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type')
			);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $p0);
			$this->assertSame($e0, $p0->unbox(1));
		}

		#endregion

		#region Methods -> Logical Operations

		/**
		 * This method provides the data for testing the "and" method.
		 *
		 * @return array
		 */
		public function data_and() {
			$data = array(
				array(array(array()), array(true)),
				array(array(array(true)), array(true)),
				array(array(array(false)), array(false)),
				array(array(array(true, false)), array(false)),
				array(array(array(true, false, true)), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "and" method.
		 *
		 * @dataProvider data_and
		 */
		public function test_and(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IBool\\Type');

			$r0 = IArrayList\Module::and_($p0);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $r0);
			$this->assertSame($e0, $r0->unbox());
		}

		/**
		 * This method provides the data for testing the "or" method.
		 *
		 * @return array
		 */
		public function data_or() {
			$data = array(
				array(array(array()), array(false)),
				array(array(array(true)), array(true)),
				array(array(array(false)), array(false)),
				array(array(array(true, false)), array(true)),
				array(array(array(true, false, true)), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "or" method.
		 *
		 * @dataProvider data_or
		 */
		public function test_or(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IBool\\Type');

			$r0 = IArrayList\Module::or_($p0);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $r0);
			$this->assertSame($e0, $r0->unbox());
		}

		#endregion

	}

}