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
			$p0 = ILinkedList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = $provided[1];

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertInternalType('callable', $p1);

			$r0 = ILinkedList\Module::all($p0, $p1);
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
			$p0 = ILinkedList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = $provided[1];

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertInternalType('callable', $p1);

			$r0 = ILinkedList\Module::any($p0, $p1);
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
			$p0 = ILinkedList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = IInt32\Type::box($provided[1]);

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p1);

			$r0 = ILinkedList\Module::append($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $r0);
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
			$p0 = ILinkedList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = ILinkedList\Type::make($provided[1], '\\Saber\\Data\\IInt32\\Type');

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p1);

			$r0 = ILinkedList\Module::concat($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $r0);
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
			$p0 = ILinkedList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = IInt32\Type::box($provided[1]);

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p1);

			$r0 = ILinkedList\Module::contains($p0, $p1);
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
			$p0 = ILinkedList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = IInt32\Type::box($provided[1]);

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p1);

			$r0 = ILinkedList\Module::delete($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $r0);
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
			$p0 = ILinkedList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Type', $p0);
			$this->assertCount(count($e0), $p0->unbox());

			$p1 = ILinkedList\Module::iterator($p0);
			$e1 = 0;

			$this->assertInstanceOf('\\Saber\\Data\\ILinkedList\\Iterator', $p1);

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

		#endregion

		#region Methods -> Equality Operations

		#endregion

		#region Methods -> Ordering Operations

		#endregion

		#region Methods -> Logical Operations

		#endregion

	}

}