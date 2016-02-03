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

namespace Saber\Data\IInt32 {

	use \Saber\Core;
	use \Saber\Data\IInt32;

	/**
	 * @group TypeTest
	 */
	final class TypeTest extends Core\TypeTest {

		#region Tests -> Inheritance

		/**
		 * This method tests the "instanceOf" property.
		 */
		public function test_instanceOf() {
			$p0 = new IInt32\Type(0);

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IIntegral\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IReal\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\INumber\\Type', $p0);
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
				array(array(1), array(1)),
				array(array(0), array(0)),
				array(array(-1), array(-1)),
			);
			return $data;
		}

		/**
		 * This method tests the "box" method.
		 *
		 * @dataProvider data_box
		 */
		public function test_box(array $provided, array $expected) {
			$p0 = IInt32\Type::box($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('integer', $p1);
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method provides the data for testing the "covariant" method.
		 *
		 * @return array
		 */
		public function data_covariant() {
			$data = array(
				array(array(1), array(1)),
				array(array(0), array(0)),
				array(array(-1), array(-1)),
			);
			return $data;
		}

		/**
		 * This method tests the "covariant" method.
		 *
		 * @dataProvider data_covariant
		 */
		public function test_covariant(array $provided, array $expected) {
			$p0 = IInt32\Type::covariant(IInt32\Type::box($provided[0]));

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('integer', $p1);
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method provides the data for testing the "make" method.
		 *
		 * @return array
		 */
		public function data_make() {
			$data = array(
				array(array(-1), array(-1)),
				array(array(0), array(0)),
				array(array(null), array(0)),
				array(array(''), array(0)),
				array(array(1), array(1)),
			);
			return $data;
		}

		/**
		 * This method tests the "make" method.
		 *
		 * @dataProvider data_make
		 */
		public function test_make(array $provided, array $expected) {
			$p0 = IInt32\Type::make($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('integer', $p1);
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method tests the "singletons" methods.
		 */
		public function test_singletons() {
			$p0 = IInt32\Type::negative();
			$e0 = IInt32\Type::negative();

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertSame($e0->__hashCode(), $p0->__hashCode());

			$p1 = $p0->unbox();
			$e1 = -1;

			$this->assertInternalType('integer', $p1);
			$this->assertSame($e1, $p1);

			$p2 = IInt32\Type::zero();
			$e2 = IInt32\Type::zero();

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p2);
			$this->assertSame($e2->__hashCode(), $p2->__hashCode());

			$p3 = $p2->unbox();
			$e3 = 0;

			$this->assertInternalType('integer', $p3);
			$this->assertSame($e3, $p3);

			$p4 = IInt32\Type::one();
			$e4 = IInt32\Type::one();

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p4);
			$this->assertSame($e4->__hashCode(), $p4->__hashCode());

			$p5 = $p4->unbox();
			$e5 = 1;

			$this->assertInternalType('integer', $p5);
			$this->assertSame($e5, $p5);
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
				array(array(-1), array('-1')),
				array(array(0), array('0')),
				array(array(1), array('1')),
			);
			return $data;
		}

		/**
		 * This method tests the "hashCode" method.
		 *
		 * @dataProvider data_hashCode
		 */
		public function test_hashCode(array $provided, array $expected) {
			$p0 = IInt32\Type::box($provided[0])->hashCode();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "toString" method.
		 *
		 * @return array
		 */
		public function data_toString() {
			$data = array(
				array(array(-1), array('-1')),
				array(array(0), array('0')),
				array(array(1), array('1')),
			);
			return $data;
		}

		/**
		 * This method tests the "toString" method.
		 *
		 * @dataProvider data_toString
		 */
		public function test_toString(array $provided, array $expected) {
			$p0 = IInt32\Type::box($provided[0])->toString();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

	}

}