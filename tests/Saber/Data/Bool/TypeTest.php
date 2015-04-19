<?php

/**
 * Copyright 2014-2015 Blue Snowman
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

namespace Saber\Data\Bool {

	use \Saber\Core;
	use \Saber\Data\Bool;

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

			$p0 = new Bool\Type(false);

			$this->assertInstanceOf('\\Saber\\Data\\Bool\\Type', $p0);
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
				array(array(true), array(true)),
				array(array(1), array(true)),
				array(array('true'), array(true)),
				array(array(false), array(false)),
				array(array(0), array(false)),
				array(array(null), array(false)),
				array(array(''), array(false)),
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

			$p0 = Bool\Type::box($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\Bool\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('boolean', $p1);
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method provides the data for testing the making of a value.
		 *
		 * @return array
		 */
		public function dataMake() {
			$data = array(
				array(array(true), array(true)),
				array(array(1), array(true)),
				array(array('true'), array(true)),
				array(array(false), array(false)),
				array(array(0), array(false)),
				array(array(null), array(false)),
				array(array(''), array(false)),
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

			$p0 = Bool\Type::make($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\Bool\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('boolean', $p1);
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method tests the initialization of a singleton, boxed value.
		 */
		public function testSingletons() {
			//$this->markTestIncomplete();

			$p0 = Bool\Type::true();
			$e0 = Bool\Type::true();

			$this->assertInstanceOf('\\Saber\\Data\\Bool\\Type', $p0);
			$this->assertSame($e0->__hashCode(), $p0->__hashCode());

			$p1 = $p0->unbox();
			$e1 = true;

			$this->assertInternalType('boolean', $p1);
			$this->assertSame($e1, $p1);

			$p2 = Bool\Type::false();
			$e2 = Bool\Type::false();

			$this->assertInstanceOf('\\Saber\\Data\\Bool\\Type', $p2);
			$this->assertSame($e2->__hashCode(), $p2->__hashCode());

			$p3 = $p2->unbox();
			$e3 = false;

			$this->assertInternalType('boolean', $p3);
			$this->assertSame($e3, $p3);
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
				array(array(true), array('true')),
				array(array(false), array('false')),
			);
			return $data;
		}

		/**
		 * This method tests that an object has a unique hash code.
		 *
		 * @dataProvider dataHashCode
		 */
		public function testHashCode(array $provided, array $expected) {
			$p0 = Bool\Type::make($provided[0])->__hashCode();
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
				array(array(true), array('true')),
				array(array(false), array('false')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is converted to a string.
		 *
		 * @dataProvider data2String
		 */
		public function testToString(array $provided, array $expected) {
			$p0 = Bool\Type::make($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

		#endregion

	}

}
