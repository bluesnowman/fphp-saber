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
		 * This method tests the data type.
		 */
		public function testType() {
			//$this->markTestIncomplete();

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
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array(0), array(0)),
				array(array(1), array(1)),
			);
			return $data;
		}

		/**
		 * This method tests the boxing of a value.
		 *
		 * @dataProvider dataBox
		 */
		public function testBox(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IInt32\Type::box($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('integer', $p1);
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method provides the data for testing the making of a value.
		 *
		 * @return array
		 */
		public function dataMake() {
			$data = array(
				array(array(1), array(1)),
				array(array(null), array(0)),
				array(array(''), array(0)),
			);
			return $data;
		}

		/**
		 * This method tests the making of a value.
		 *
		 * @dataProvider dataMake
		 */
		public function testMake(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IInt32\Type::make($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('integer', $p1);
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method tests the initialization of a singleton, boxed value.
		 */
		public function testSingletons() {
			//$this->markTestIncomplete();

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
		 * This method provides the data for testing that an object has a unique hash code.
		 *
		 * @return array
		 */
		public function dataHashCode() {
			$data = array(
				array(array(-1), array('-1')),
				array(array(0), array('0')),
				array(array(1), array('1')),
			);
			return $data;
		}

		/**
		 * This method tests that an object has a unique hash code.
		 *
		 * @dataProvider dataHashCode
		 */
		public function testHashCode(array $provided, array $expected) {
			$p0 = IInt32\Type::make($provided[0])->__hashCode();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

		/**
		 * This method provides the data for testing that a value is converted to a string.
		 *
		 * @return array
		 */
		public function data2String() {
			$data = array(
				array(array(-1), array('-1')),
				array(array(0), array('0')),
				array(array(1), array('1')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is converted to a string.
		 *
		 * @dataProvider data2String
		 */
		public function testToString(array $provided, array $expected) {
			$p0 = IInt32\Type::make($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

		#endregion

	}

}