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