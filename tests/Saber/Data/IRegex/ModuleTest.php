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

namespace Saber\Data\IRegex {

	use \Saber\Core;
	use \Saber\Data\IInt32;
	use \Saber\Data\IObject;
	use \Saber\Data\IRegex;
	use \Saber\Data\IString;
	use \Saber\Data\ITuple;

	/**
	 * @group ModuleTest
	 */
	final class ModuleTest extends Core\ModuleTest {

		#region Methods -> Basic Operations

		/**
		 * This method provides the data for testing the "match" method.
		 *
		 * @return array
		 */
		public function data_match() {
			$data = array(
				array(array('/^.+$/', 'test'), array(true)),
				array(array('/^[a-z]+$/', '12345'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "match" method.
		 *
		 * @dataProvider data_match
		 */
		public function test_match(array $provided, array $expected) {
			$p0 = IRegex\Module::match(IRegex\Type::box($provided[0]), IObject\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "replace" method.
		 *
		 * @return array
		 */
		public function data_replace() {
			$data = array(
				array(array('/b/', array('t', 'boy')), array('toy')),
				array(array('/b/', array('t', 'coy')), array('coy')),
				array(array('/b/', array('t', 'toy')), array('toy')),
			);
			return $data;
		}

		/**
		 * This method tests the "replace" method.
		 *
		 * @dataProvider data_replace
		 */
		public function test_replace(array $provided, array $expected) {
			$p0 = IRegex\Module::replace(IRegex\Type::box($provided[0]), ITuple\Type::box(array_map(function(string $item) : IString\Type {
				return IString\Type::box($item);
			}, $provided[1])));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "split" method.
		 *
		 * @return array
		 */
		public function data_split() {
			$data = array(
				array(array('/,/', 'boy,coy,toy'), array(array('boy', 'coy', 'toy'))),
				array(array('/,/', 'boy|coy|toy'), array(array('boy|coy|toy'))),
				array(array('/,/', array('boy,coy,toy', 2)), array(array('boy', 'coy,toy'))),
			);
			return $data;
		}

		/**
		 * This method tests the "split" method.
		 *
		 * @dataProvider data_split
		 */
		public function test_split(array $provided, array $expected) {
			if (is_array($provided[1])) {
				$p0 = IRegex\Module::split(IRegex\Type::box($provided[0]), ITuple\Type::box2(IString\Type::box($provided[1][0]), IInt32\Type::box($provided[1][1])));
			}
			else {
				$p0 = IRegex\Module::split(IRegex\Type::box($provided[0]), IString\Type::box($provided[1]));
			}
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $p0);
			$this->assertSame($e0, $p0->unbox(1));
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method tests the "nvl" method.
		 */
		public function test_nvl() {
			$x = IRegex\Type::box('/^.*$/');
			$y = IRegex\Type::box('/^[a-z]?$/');

			$z = IRegex\Module::nvl($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IRegex\\Type', $z);
			$this->assertSame('/^.*$/', $z->unbox());

			$z = IRegex\Module::nvl(null, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IRegex\\Type', $z);
			$this->assertSame('/^.*$/', $z->unbox());

			$z = IRegex\Module::nvl(null, null);
			$this->assertInstanceOf('\\Saber\\Data\\IRegex\\Type', $z);
			$this->assertSame('/^.*$/', $z->unbox());
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
				array(array('/^.*$/', '/^.*$/'), array(true)),
				array(array('/^.*$/', '/^[a-z]?$/'), array(false)),
				array(array('/^[a-z]?$/', '/^.*$/'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "eq" method.
		 *
		 * @dataProvider data_eq
		 */
		public function test_eq(array $provided, array $expected) {
			$p0 = IRegex\Module::eq(IRegex\Type::box($provided[0]), IRegex\Type::box($provided[1]));
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
				array(array('/^.*$/', '/^.*$/'), array(true)),
				array(array('/^.*$/', '/^[a-z]?$/'), array(false)),
				array(array('/^[a-z]?$/', '/^.*$/'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "id" method.
		 *
		 * @dataProvider data_id
		 */
		public function test_id(array $provided, array $expected) {
			$p0 = IRegex\Module::id(IRegex\Type::box($provided[0]), IRegex\Type::box($provided[1]));
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
				array(array('/^.*$/', '/^.*$/'), array(false)),
				array(array('/^.*$/', '/^[a-z]?$/'), array(true)),
				array(array('/^[a-z]?$/', '/^.*$/'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "ne" method.
		 *
		 * @dataProvider data_ne
		 */
		public function test_ne(array $provided, array $expected) {
			$p0 = IRegex\Module::ne(IRegex\Type::box($provided[0]), IRegex\Type::box($provided[1]));
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
				array(array('/^.*$/', '/^.*$/'), array(false)),
				array(array('/^.*$/', '/^[a-z]?$/'), array(true)),
				array(array('/^[a-z]?$/', '/^.*$/'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "ni" method.
		 *
		 * @dataProvider data_ni
		 */
		public function test_ni(array $provided, array $expected) {
			$p0 = IRegex\Module::ni(IRegex\Type::box($provided[0]), IRegex\Type::box($provided[1]));
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
				array(array('/^.*$/', '/^[a-z]?$/'), array(-1)),
				array(array('/^.*$/', '/^.*$/'), array(0)),
				array(array('/^[a-z]?$/', '/^.*$/'), array(1)),
			);
			return $data;
		}

		/**
		 * This method tests the "compare" method.
		 *
		 * @dataProvider data_compare
		 */
		public function test_compare(array $provided, array $expected) {
			$p0 = IRegex\Module::compare(IRegex\Type::box($provided[0]), IRegex\Type::box($provided[1]));
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
				array(array('/^.*$/', '/^[a-z]?$/'), array(false)),
				array(array('/^.*$/', '/^.*$/'), array(true)),
				array(array('/^[a-z]?$/', '/^.*$/'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "ge" method.
		 *
		 * @dataProvider data_ge
		 */
		public function test_ge(array $provided, array $expected) {
			$p0 = IRegex\Module::ge(IRegex\Type::box($provided[0]), IRegex\Type::box($provided[1]));
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
				array(array('/^.*$/', '/^[a-z]?$/'), array(false)),
				array(array('/^.*$/', '/^.*$/'), array(false)),
				array(array('/^[a-z]?$/', '/^.*$/'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "gt" method.
		 *
		 * @dataProvider data_gt
		 */
		public function test_gt(array $provided, array $expected) {
			$p0 = IRegex\Module::gt(IRegex\Type::box($provided[0]), IRegex\Type::box($provided[1]));
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
				array(array('/^.*$/', '/^[a-z]?$/'), array(true)),
				array(array('/^.*$/', '/^.*$/'), array(true)),
				array(array('/^[a-z]?$/', '/^.*$/'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "le" method.
		 *
		 * @dataProvider data_le
		 */
		public function test_le(array $provided, array $expected) {
			$p0 = IRegex\Module::le(IRegex\Type::box($provided[0]), IRegex\Type::box($provided[1]));
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
				array(array('/^.*$/', '/^[a-z]?$/'), array(true)),
				array(array('/^.*$/', '/^.*$/'), array(false)),
				array(array('/^[a-z]?$/', '/^.*$/'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "lt" method.
		 *
		 * @dataProvider data_lt
		 */
		public function test_lt(array $provided, array $expected) {
			$p0 = IRegex\Module::lt(IRegex\Type::box($provided[0]), IRegex\Type::box($provided[1]));
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
				array(array('/^.*$/', '/^[a-z]?$/'), array('/^[a-z]?$/')),
				array(array('/^.*$/', '/^.*$/'), array('/^.*$/')),
				array(array('/^[a-z]?$/', '/^.*$/'), array('/^[a-z]?$/')),
			);
			return $data;
		}

		/**
		 * This method tests the "max" method.
		 *
		 * @dataProvider data_max
		 */
		public function test_max(array $provided, array $expected) {
			$p0 = IRegex\Module::max(IRegex\Type::box($provided[0]), IRegex\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IRegex\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "min" method.
		 *
		 * @return array
		 */
		public function data_min() {
			$data = array(
				array(array('/^.*$/', '/^[a-z]?$/'), array('/^.*$/')),
				array(array('/^.*$/', '/^.*$/'), array('/^.*$/')),
				array(array('/^[a-z]?$/', '/^.*$/'), array('/^.*$/')),
			);
			return $data;
		}

		/**
		 * This method tests the "min" method.
		 *
		 * @dataProvider data_min
		 */
		public function test_min(array $provided, array $expected) {
			$p0 = IRegex\Module::min(IRegex\Type::box($provided[0]), IRegex\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IRegex\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

	}

}