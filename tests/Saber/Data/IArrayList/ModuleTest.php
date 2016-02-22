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
		 * This method provides the data for testing the "break" method.
		 *
		 * @return array
		 */
		public function data_break() {
			$predicate = function(Core\Boxable\Type $x, IInt32\Type $i) : IBool\Type {
				return IBool\Type::box($x->unbox() > 2);
			};
			$data = array(
				array(array(array(), $predicate), array(array(), array())),
				array(array(array(1), $predicate), array(array(1), array())),
				array(array(array(1, 2), $predicate), array(array(1, 2), array())),
				array(array(array(1, 2, 3), $predicate), array(array(1, 2), array(3))),
				array(array(array(1, 2, 3, 4), $predicate), array(array(1, 2), array(3, 4))),
				array(array(array(1, 3, 2, 4), $predicate), array(array(1), array(3, 2, 4))),
				array(array(array(3, 1, 4, 2), $predicate), array(array(), array(3, 1, 4, 2))),
			);
			return $data;
		}

		/**
		 * This method tests the "break" method.
		 *
		 * @dataProvider data_break
		 */
		public function test_break(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = $provided[1];

			$e0 = $expected[0];
			$e1 = $expected[1];

			$r0 = IArrayList\Module::break_($p0, $p1);

			$this->assertInstanceOf('\\Saber\\Data\\ITuple\\Type', $r0);

			$v0 = $r0->first();
			$v1 = $r0->second();

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $v0);
			$this->assertSame($e0, $v0->unbox(1));

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $v1);
			$this->assertSame($e1, $v1->unbox(1));
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
		 * This method provides the data for testing the "drop" method.
		 *
		 * @return array
		 */
		public function data_drop() {
			$data = array(
				array(array(array(), 2), array(array())),
				array(array(array(1), 2), array(array())),
				array(array(array(1, 2), 2), array(array())),
				array(array(array(1, 2, 3), 2), array(array(3))),
			);
			return $data;
		}

		/**
		 * This method tests the "drop" method.
		 *
		 * @dataProvider data_drop
		 */
		public function test_drop(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = IInt32\Type::box($provided[1]);

			$r0 = IArrayList\Module::drop($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $r0);
			$this->assertSame($e0, $r0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "dropWhile" method.
		 *
		 * @return array
		 */
		public function data_dropWhile() {
			$predicate = function(Core\Boxable\Type $x, IInt32\Type $i) : IBool\Type {
				return IBool\Type::box($x->unbox() <= 2);
			};
			$data = array(
				array(array(array(), $predicate), array(array())),
				array(array(array(1), $predicate), array(array())),
				array(array(array(1, 2), $predicate), array(array())),
				array(array(array(1, 2, 3), $predicate), array(array(3))),
				array(array(array(2, 3, 1), $predicate), array(array(3, 1))),
			);
			return $data;
		}

		/**
		 * This method tests the "dropWhile" method.
		 *
		 * @dataProvider data_dropWhile
		 */
		public function test_dropWhile(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = $provided[1];

			$r0 = IArrayList\Module::dropWhile($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $r0);
			$this->assertSame($e0, $r0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "dropWhileEnd" method.
		 *
		 * @return array
		 */
		public function data_dropWhileEnd() {
			$predicate = function(Core\Boxable\Type $x, IInt32\Type $i) : IBool\Type {
				return IBool\Type::box($x->unbox() > 2);
			};
			$data = array(
				array(array(array(), $predicate), array(array())),
				array(array(array(1), $predicate), array(array())),
				array(array(array(1, 2), $predicate), array(array())),
				array(array(array(1, 2, 3), $predicate), array(array(3))),
				array(array(array(2, 3, 1), $predicate), array(array(3, 1))),
			);
			return $data;
		}

		/**
		 * This method tests the "dropWhileEnd" method.
		 *
		 * @dataProvider data_dropWhileEnd
		 */
		public function test_dropWhileEnd(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = $provided[1];

			$r0 = IArrayList\Module::dropWhileEnd($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $r0);
			$this->assertSame($e0, $r0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "each" method.
		 *
		 * @return array
		 */
		public function data_each() {
			$data = array(
				array(array(array()), array(array())),
				array(array(array(1)), array(array(1))),
				array(array(array(1, 2)), array(array(1, 2))),
				array(array(array(1, 2, 3)), array(array(1, 2, 3))),
			);
			return $data;
		}

		/**
		 * This method tests the "each" method.
		 *
		 * @dataProvider data_each
		 */
		public function test_each(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');

			$e0 = $expected[0];
			$e1 = 0;

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $p0);
			$this->assertCount(count($e0), $p0->unbox());

			$p1 = IArrayList\Module::each($p0, function($x, $i) use($e0, &$e1) {
				$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $i);
				$this->assertSame($e1, $i->unbox());
				$this->assertInstanceOf('\\Saber\\Core\\Type', $x);
				$this->assertSame($e0[$e1], $x->unbox());
				$e1++;
			});
			$this->assertCount($e1, $e0);

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $p1);
			$this->assertSame($e0, $p1->unbox(1));
		}

		/**
		 * This method provides the data for testing the "filter" method.
		 *
		 * @return array
		 */
		public function data_filter() {
			$predicate = function(Core\Boxable\Type $x, IInt32\Type $i) : IBool\Type {
				return IBool\Type::box(($x->unbox() % 2) != 0);
			};
			$data = array(
				array(array(array(), $predicate), array(array())),
				array(array(array(1), $predicate), array(array(1))),
				array(array(array(1, 2), $predicate), array(array(1))),
				array(array(array(1, 2, 3), $predicate), array(array(1, 3))),
				array(array(array(1, 2, 3, 4), $predicate), array(array(1, 3))),
			);
			return $data;
		}

		/**
		 * This method tests the "filter" method.
		 *
		 * @dataProvider data_filter
		 */
		public function test_filter(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = $provided[1];

			$r0 = IArrayList\Module::filter($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $r0);
			$this->assertSame($e0, $r0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "find" method.
		 *
		 * @return array
		 */
		public function data_find() {
			$predicate = function(Core\Boxable\Type $x, IInt32\Type $i) : IBool\Type {
				return IBool\Type::box($x->unbox() == 2);
			};
			$data = array(
				array(array(array(), $predicate), array('\\Saber\\Data\\IOption\\None\\Type')),
				array(array(array(1), $predicate), array('\\Saber\\Data\\IOption\\None\\Type')),
				array(array(array(1, 2), $predicate), array('\\Saber\\Data\\IOption\\Some\\Type')),
				array(array(array(1, 2, 3), $predicate), array('\\Saber\\Data\\IOption\\Some\\Type')),
				array(array(array(1, 5, 3), $predicate), array('\\Saber\\Data\\IOption\\None\\Type')),
			);
			return $data;
		}

		/**
		 * This method tests the "find" method.
		 *
		 * @dataProvider data_find
		 */
		public function test_find(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = $provided[1];

			$r0 = IArrayList\Module::find($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf($e0, $r0);
		}

		/**
		 * This method provides the data for testing the "foldLeft" method.
		 *
		 * @return array
		 */
		public function data_foldLeft() {
			$predicate = function(IInt32\Type $c, IInt32\Type $x) : IInt32\Type {
				return IInt32\Module::add($c, $x);
			};
			$data = array(
				array(array(array(), $predicate), array(0)),
				array(array(array(1), $predicate), array(1)),
				array(array(array(1, 2), $predicate), array(3)),
				array(array(array(1, 2, 3), $predicate), array(6)),
				array(array(array(1, 2, 3, 4), $predicate), array(10)),
			);
			return $data;
		}

		/**
		 * This method tests the "foldLeft" method.
		 *
		 * @dataProvider data_foldLeft
		 */
		public function test_foldLeft(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = $provided[1];

			$r0 = IArrayList\Module::foldLeft($p0, $p1, IInt32\Type::zero());
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $r0);
			$this->assertSame($e0, $r0->unbox());
		}

		/**
		 * This method provides the data for testing the "foldRight" method.
		 *
		 * @return array
		 */
		public function data_foldRight() {
			$predicate = function(IInt32\Type $c, IInt32\Type $x) : IInt32\Type {
				return IInt32\Module::add($c, $x);
			};
			$data = array(
				array(array(array(), $predicate), array(0)),
				array(array(array(1), $predicate), array(1)),
				array(array(array(1, 2), $predicate), array(3)),
				array(array(array(1, 2, 3), $predicate), array(6)),
				array(array(array(1, 2, 3, 4), $predicate), array(10)),
			);
			return $data;
		}

		/**
		 * This method tests the "foldRight" method.
		 *
		 * @dataProvider data_foldRight
		 */
		public function test_foldRight(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = $provided[1];

			$r0 = IArrayList\Module::foldRight($p0, $p1, IInt32\Type::zero());
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $r0);
			$this->assertSame($e0, $r0->unbox());
		}

		/**
		 * This method provides the data for testing the "head" method.
		 *
		 * @return array
		 */
		public function data_head() {
			$data = array(
				array(array(array(1)), array(1)),
				array(array(array(1, 2)), array(1)),
			);
			return $data;
		}

		/**
		 * This method tests the "head" method.
		 *
		 * @dataProvider data_head
		 */
		public function test_head(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');

			$r0 = IArrayList\Module::head($p0);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $r0);
			$this->assertSame($e0, $r0->unbox());
		}

		/**
		 * This method provides the data for testing the "headOption" method.
		 *
		 * @return array
		 */
		public function data_headOption() {
			$data = array(
				array(array(array()), array(null)),
				array(array(array(1)), array(1)),
				array(array(array(1, 2)), array(1)),
			);
			return $data;
		}

		/**
		 * This method tests the "headOption" method.
		 *
		 * @dataProvider data_headOption
		 */
		public function test_headOption(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');

			$r0 = IArrayList\Module::headOption($p0);
			$e0 = $expected[0];

			if ($e0 !== null) {
				$this->assertInstanceOf('\\Saber\\Data\\IOption\\Some\\Type', $r0);
				$v0 = $r0->unbox();

				$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $v0);
				$this->assertSame($e0, $v0->unbox());
			}
			else {
				$this->assertInstanceOf('\\Saber\\Data\\IOption\\None\\Type', $r0);
			}
		}

		/**
		 * This method provides the data for testing the "indexOf" method.
		 *
		 * @return array
		 */
		public function data_indexOf() {
			$data = array(
				array(array(array(), 2), array(-1)),
				array(array(array(1), 2), array(-1)),
				array(array(array(1, 2), 2), array(1)),
				array(array(array(1, 2, 3), 2), array(1)),
				array(array(array(1, 2, 3, 1, 2, 3), 2), array(1)),
			);
			return $data;
		}

		/**
		 * This method tests the "indexOf" method.
		 *
		 * @dataProvider data_indexOf
		 */
		public function test_indexOf(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = IInt32\Type::box($provided[1]);

			$r0 = IArrayList\Module::indexOf($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $r0);
			$this->assertSame($e0, $r0->unbox());
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
			$p0 = IArrayList\Type::make($provided[0]);

			$r0 = IArrayList\Module::isEmpty($p0);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $r0);
			$this->assertSame($e0, $r0->unbox());
		}

		/**
		 * This method provides the data for testing the "item" method.
		 *
		 * @return array
		 */
		public function data_item() {
			$data = array(
				array(array(array(1), 0), array(1)),
				array(array(array(1, 2), 0), array(1)),
				array(array(array(1, 2), 1), array(2)),
				array(array(array(1, 2, 3), 1), array(2)),
				array(array(array(1, 2, 3), 2), array(3)),
			);
			return $data;
		}

		/**
		 * This method tests the "item" method.
		 *
		 * @dataProvider data_item
		 */
		public function test_item(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = IInt32\Type::box($provided[1]);

			$r0 = IArrayList\Module::item($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $r0);
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

		/**
		 * This method provides the data for testing the "last" method.
		 *
		 * @return array
		 */
		public function data_last() {
			$data = array(
				array(array(array(1)), array(1)),
				array(array(array(1, 2)), array(2)),
			);
			return $data;
		}

		/**
		 * This method tests the "last" method.
		 *
		 * @dataProvider data_last
		 */
		public function test_last(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');

			$r0 = IArrayList\Module::last($p0);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $r0);
			$this->assertSame($e0, $r0->unbox());
		}

		/**
		 * This method provides the data for testing the "lastOption" method.
		 *
		 * @return array
		 */
		public function data_lastOption() {
			$data = array(
				array(array(array()), array(null)),
				array(array(array(1)), array(1)),
				array(array(array(1, 2)), array(2)),
			);
			return $data;
		}

		/**
		 * This method tests the "lastOption" method.
		 *
		 * @dataProvider data_lastOption
		 */
		public function test_lastOption(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');

			$r0 = IArrayList\Module::lastOption($p0);
			$e0 = $expected[0];

			if ($e0 !== null) {
				$this->assertInstanceOf('\\Saber\\Data\\IOption\\Some\\Type', $r0);
				$v0 = $r0->unbox();

				$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $v0);
				$this->assertSame($e0, $v0->unbox());
			}
			else {
				$this->assertInstanceOf('\\Saber\\Data\\IOption\\None\\Type', $r0);
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
			);
			return $data;
		}

		/**
		 * This method tests the "length" method.
		 *
		 * @dataProvider data_length
		 */
		public function test_length(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');

			$r0 = IArrayList\Module::length($p0);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $r0);
			$this->assertSame($e0, $r0->unbox());
		}

		/**
		 * This method provides the data for testing the "prepend" method.
		 *
		 * @return array
		 */
		public function data_prepend() {
			$data = array(
				array(array(array(), 9), array(array(9))),
				array(array(array(1), 9), array(array(9, 1))),
				array(array(array(1, 2), 9), array(array(9, 1, 2))),
			);
			return $data;
		}

		/**
		 * This method tests the "prepend" method.
		 *
		 * @dataProvider data_prepend
		 */
		public function test_prepend(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = IInt32\Type::box($provided[1]);

			$r0 = IArrayList\Module::prepend($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $r0);
			$this->assertSame($e0, $r0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "reverse" method.
		 *
		 * @return array
		 */
		public function data_reverse() {
			$data = array(
				array(array(array()), array(array())),
				array(array(array(1)), array(array(1))),
				array(array(array(1, 2)), array(array(2, 1))),
				array(array(array(1, 2, 3)), array(array(3, 2, 1))),
			);
			return $data;
		}

		/**
		 * This method tests the "reverse" method.
		 *
		 * @dataProvider data_reverse
		 */
		public function test_reverse(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');

			$r0 = IArrayList\Module::reverse($p0);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $r0);
			$this->assertSame($e0, $r0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "span" method.
		 *
		 * @return array
		 */
		public function data_span() {
			$predicate = function(Core\Boxable\Type $x, IInt32\Type $i) : IBool\Type {
				return IBool\Type::box($x->unbox() < 3);
			};
			$data = array(
				array(array(array(), $predicate), array(array(), array())),
				array(array(array(1), $predicate), array(array(1), array())),
				array(array(array(1, 2), $predicate), array(array(1, 2), array())),
				array(array(array(1, 2, 3), $predicate), array(array(1, 2), array(3))),
				array(array(array(1, 2, 3, 4), $predicate), array(array(1, 2), array(3, 4))),
				array(array(array(1, 3, 2, 4), $predicate), array(array(1), array(3, 2, 4))),
				array(array(array(3, 1, 4, 2), $predicate), array(array(), array(3, 1, 4, 2))),
			);
			return $data;
		}

		/**
		 * This method tests the "span" method.
		 *
		 * @dataProvider data_span
		 */
		public function test_span(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = $provided[1];

			$e0 = $expected[0];
			$e1 = $expected[1];

			$r0 = IArrayList\Module::span($p0, $p1);

			$this->assertInstanceOf('\\Saber\\Data\\ITuple\\Type', $r0);

			$v0 = $r0->first();
			$v1 = $r0->second();

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $v0);
			$this->assertSame($e0, $v0->unbox(1));

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $v1);
			$this->assertSame($e1, $v1->unbox(1));
		}

		/**
		 * This method provides the data for testing the "take" method.
		 *
		 * @return array
		 */
		public function data_take() {
			$data = array(
				array(array(array(), 2), array(array())),
				array(array(array(1), 2), array(array(1))),
				array(array(array(1, 2), 2), array(array(1, 2))),
				array(array(array(1, 2, 3), 2), array(array(1, 2))),
			);
			return $data;
		}

		/**
		 * This method tests the "take" method.
		 *
		 * @dataProvider data_take
		 */
		public function test_take(array $provided, array $expected) {
			$p0 = IArrayList\Type::make($provided[0], '\\Saber\\Data\\IInt32\\Type');
			$p1 = IInt32\Type::box($provided[1]);

			$r0 = IArrayList\Module::take($p0, $p1);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $r0);
			$this->assertSame($e0, $r0->unbox(1));
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