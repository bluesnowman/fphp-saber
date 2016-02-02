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

namespace Saber\Data\ITrit {

	use \Saber\Core;
	use \Saber\Data\ITrit;

	/**
	 * @group ModuleTest
	 */
	final class ModuleTest extends Core\ModuleTest {

		#region Methods -> Conversion Operations

		/**
		 * This method tests the "nvl" method.
		 */
		public function test_nvl() {
			$x = ITrit\Type::positive();
			$y = ITrit\Type::zero();

			$z = ITrit\Module::nvl($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\ITrit\\Type', $z);
			$this->assertSame(1, $z->unbox());

			$z = ITrit\Module::nvl(null, $x);
			$this->assertInstanceOf('\\Saber\\Data\\ITrit\\Type', $z);
			$this->assertSame(1, $z->unbox());

			$z = ITrit\Module::nvl(null, null);
			$this->assertInstanceOf('\\Saber\\Data\\ITrit\\Type', $z);
			$this->assertSame(0, $z->unbox());
		}

		/**
		 * This method provides the data for testing the "toBool" method.
		 *
		 * @return array
		 */
		public function data_toBool() {
			$data = array(
				array(array(1), array(true)),
				array(array(0), array(false)),
				array(array(-1), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "toBool" method.
		 *
		 * @dataProvider data_toBool
		 */
		public function test_toBool(array $provided, array $expected) {
			$p0 = ITrit\Module::toBool(ITrit\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "toDouble" method.
		 *
		 * @return array
		 */
		public function data_toDouble() {
			$data = array(
				array(array(1), array(1.0)),
				array(array(0), array(0.0)),
				array(array(-1), array(-1.0)),
			);
			return $data;
		}

		/**
		 * This method tests the "toDouble" method.
		 *
		 * @dataProvider data_toDouble
		 */
		public function test_toDouble(array $provided, array $expected) {
			$p0 = ITrit\Module::toDouble(ITrit\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IDouble\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "toFloat" method.
		 *
		 * @return array
		 */
		public function data_toFloat() {
			$data = array(
				array(array(1), array(1.0)),
				array(array(0), array(0.0)),
				array(array(-1), array(-1.0)),
			);
			return $data;
		}

		/**
		 * This method tests the "toFloat" method.
		 *
		 * @dataProvider data_toFloat
		 */
		public function test_toFloat(array $provided, array $expected) {
			$p0 = ITrit\Module::toFloat(ITrit\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IFloat\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "toInt32" method.
		 *
		 * @return array
		 */
		public function data_toInt32() {
			$data = array(
				array(array(1), array(1)),
				array(array(0), array(0)),
				array(array(-1), array(-1)),
			);
			return $data;
		}

		/**
		 * This method tests the "toInt32" method.
		 *
		 * @dataProvider data_toInt32
		 */
		public function test_toInt32(array $provided, array $expected) {
			$p0 = ITrit\Module::toInt32(ITrit\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "toInteger" method.
		 *
		 * @return array
		 */
		public function data_toInteger() {
			$data = array(
				array(array(1), array('1')),
				array(array(0), array('0')),
				array(array(-1), array('-1')),
			);
			return $data;
		}

		/**
		 * This method tests the "toInteger" method.
		 *
		 * @dataProvider data_toInteger
		 */
		public function test_toInteger(array $provided, array $expected) {
			$p0 = ITrit\Module::toInteger(ITrit\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
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
				array(array(1, 1), array(true)),
				array(array(1, 0), array(false)),
				array(array(0, 0), array(true)),
				array(array(-1, 0), array(false)),
				array(array(-1, 1), array(false)),
				array(array(-1, -1), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "eq" method.
		 *
		 * @dataProvider data_eq
		 */
		public function test_eq(array $provided, array $expected) {
			$p0 = ITrit\Module::eq(ITrit\Type::box($provided[0]), ITrit\Type::box($provided[1]));
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
				array(array(1, 1), array(true)),
				array(array(1, 0), array(false)),
				array(array(0, 0), array(true)),
				array(array(-1, 0), array(false)),
				array(array(-1, 1), array(false)),
				array(array(-1, -1), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "id" method.
		 *
		 * @dataProvider data_id
		 */
		public function test_id(array $provided, array $expected) {
			$p0 = ITrit\Module::id(ITrit\Type::box($provided[0]), ITrit\Type::box($provided[1]));
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
				array(array(1, 1), array(false)),
				array(array(1, 0), array(true)),
				array(array(0, 0), array(false)),
				array(array(-1, 0), array(true)),
				array(array(-1, 1), array(true)),
				array(array(-1, -1), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "ne" method.
		 *
		 * @dataProvider data_ne
		 */
		public function test_ne(array $provided, array $expected) {
			$p0 = ITrit\Module::ne(ITrit\Type::box($provided[0]), ITrit\Type::box($provided[1]));
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
				array(array(1, 1), array(false)),
				array(array(1, 0), array(true)),
				array(array(0, 0), array(false)),
				array(array(-1, 0), array(true)),
				array(array(-1, 1), array(true)),
				array(array(-1, -1), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "ni" method.
		 *
		 * @dataProvider data_ni
		 */
		public function test_ni(array $provided, array $expected) {
			$p0 = ITrit\Module::ni(ITrit\Type::box($provided[0]), ITrit\Type::box($provided[1]));
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
				array(array(1, 1), array(0)),
				array(array(1, 0), array(1)),
				array(array(0, 1), array(-1)),
			);
			return $data;
		}

		/**
		 * This method tests the "compare" method.
		 *
		 * @dataProvider data_compare
		 */
		public function test_compare(array $provided, array $expected) {
			$p0 = ITrit\Module::compare(ITrit\Type::box($provided[0]), ITrit\Type::box($provided[1]));
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
				array(array(1, 0), array(true)),
				array(array(0, 0), array(true)),
				array(array(-1, 0), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "ge" method.
		 *
		 * @dataProvider data_ge
		 */
		public function test_ge(array $provided, array $expected) {
			$p0 = ITrit\Module::ge(ITrit\Type::box($provided[0]), ITrit\Type::box($provided[1]));
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
				array(array(1, 0), array(true)),
				array(array(0, 0), array(false)),
				array(array(-1, 0), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "gt" method.
		 *
		 * @dataProvider data_gt
		 */
		public function test_gt(array $provided, array $expected) {
			$p0 = ITrit\Module::gt(ITrit\Type::box($provided[0]), ITrit\Type::box($provided[1]));
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
				array(array(1, 0), array(false)),
				array(array(0, 0), array(true)),
				array(array(-1, 0), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "le" method.
		 *
		 * @dataProvider data_le
		 */
		public function test_le(array $provided, array $expected) {
			$p0 = ITrit\Module::le(ITrit\Type::box($provided[0]), ITrit\Type::box($provided[1]));
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
				array(array(1, 0), array(false)),
				array(array(0, 0), array(false)),
				array(array(-1, 0), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "lt" method.
		 *
		 * @dataProvider data_lt
		 */
		public function test_lt(array $provided, array $expected) {
			$p0 = ITrit\Module::lt(ITrit\Type::box($provided[0]), ITrit\Type::box($provided[1]));
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
				array(array(1, 0), array(1)),
				array(array(0, 0), array(0)),
				array(array(-1, 0), array(0)),
			);
			return $data;
		}

		/**
		 * This method tests the "max" method.
		 *
		 * @dataProvider data_max
		 */
		public function test_max(array $provided, array $expected) {
			$p0 = ITrit\Module::max(ITrit\Type::box($provided[0]), ITrit\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ITrit\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "min" method.
		 *
		 * @return array
		 */
		public function data_min() {
			$data = array(
				array(array(1, 0), array(0)),
				array(array(0, 0), array(0)),
				array(array(-1, 0), array(-1)),
			);
			return $data;
		}

		/**
		 * This method tests the "min" method.
		 *
		 * @dataProvider data_min
		 */
		public function test_min(array $provided, array $expected) {
			$p0 = ITrit\Module::min(ITrit\Type::box($provided[0]), ITrit\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ITrit\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

	}

}