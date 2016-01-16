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

namespace Saber\Data\IObject {

	use \Saber\Core;
	use \Saber\Data\IObject;

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

			$p0 = new IObject\Type('test');

			$this->assertInstanceOf('\\Saber\\Data\\IObject\\Type', $p0);
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
				array(array(1), array(1)),
				array(array(null), array(null)),
				array(array(''), array('')),
				array(array(new \stdClass()), array(new \stdClass())),
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

			$p0 = IObject\Type::box($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\IObject\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			if (is_object($p1)) {
				$this->assertInstanceOf(get_class($e1), $p1);
				$this->assertEquals($e1, $p1);
			}
			else {
				$this->assertInternalType(strtolower(gettype($e1)), $p1);
				$this->assertSame($e1, $p1);
			}
		}

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataMake() {
			$data = array(
				array(array(1), array(1)),
				array(array(null), array(null)),
				array(array(''), array('')),
				array(array(new \stdClass()), array(new \stdClass())),
			);
			return $data;
		}

		/**
		 * This method tests the boxing of a value.
		 *
		 * @dataProvider dataMake
		 */
		public function testMake(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IObject\Type::make($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\IObject\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			if (is_object($p1)) {
				$this->assertInstanceOf(get_class($e1), $p1);
				$this->assertEquals($e1, $p1);
			}
			else {
				$this->assertInternalType(strtolower(gettype($e1)), $p1);
				$this->assertSame($e1, $p1);
			}
		}

		#endregion

		#region Tests -> Interface

		/**
		 * This method provides the data for testing that a value is converted to a string.
		 *
		 * @return array
		 */
		public function data2IString() {
			$data = array(
				array(array(1), array('1')),
				array(array(null), array('null')),
				array(array(''), array('')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is converted to a string.
		 *
		 * @dataProvider data2IString
		 */
		public function testToIString(array $provided, array $expected) {
			$p0 = IObject\Type::make($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

		#endregion

	}

}