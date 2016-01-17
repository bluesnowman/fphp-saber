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

namespace Saber\Data\IChar {

	use \Saber\Core;
	use \Saber\Data\IChar;

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

			$p0 = new IChar\Type('a');

			$this->assertInstanceOf('\\Saber\\Data\\IChar\\Type', $p0);
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
				array(array('a'), array('a')),
				array(array("\n"), array("\n")),
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

			$p0 = IChar\Type::box($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\IChar\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('string', $p1);
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method provides the data for testing the making of a value.
		 *
		 * @return array
		 */
		public function dataMake() {
			$data = array(
				array(array('a'), array('a')),
				array(array("\n"), array("\n")),
				array(array(97), array('a')),
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

			$p0 = IChar\Type::make($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\IChar\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('string', $p1);
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method tests the initialization of a singleton, boxed value.
		 */
		public function testSingletons() {
			//$this->markTestIncomplete();

			$p0 = IChar\Type::cr();
			$e0 = IChar\Type::cr();

			$this->assertInstanceOf('\\Saber\\Data\\IChar\\Type', $p0);
			$this->assertSame($e0->__hashCode(), $p0->__hashCode());

			$p1 = $p0->unbox();
			$e1 = "\r";

			$this->assertInternalType('string', $p1);
			$this->assertSame($e1, $p1);

			$p2 = IChar\Type::lf();
			$e2 = IChar\Type::lf();

			$this->assertInstanceOf('\\Saber\\Data\\IChar\\Type', $p2);
			$this->assertSame($e2->__hashCode(), $p2->__hashCode());

			$p3 = $p2->unbox();
			$e3 = "\n";

			$this->assertInternalType('string', $p3);
			$this->assertSame($e3, $p3);

			$p4 = IChar\Type::space();
			$e4 = IChar\Type::space();

			$this->assertInstanceOf('\\Saber\\Data\\IChar\\Type', $p4);
			$this->assertSame($e4->__hashCode(), $p4->__hashCode());

			$p5 = $p4->unbox();
			$e5 = ' ';

			$this->assertInternalType('string', $p5);
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
				array(array('a'), array('a')),
				array(array("\n"), array("\n")),
				array(array(97), array('a')),
			);
			return $data;
		}

		/**
		 * This method tests that an object has a unique hash code.
		 *
		 * @dataProvider dataHashCode
		 */
		public function testHashCode(array $provided, array $expected) {
			$p0 = IChar\Type::make($provided[0])->__hashCode();
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
				array(array('a'), array('a')),
				array(array("\n"), array("\n")),
				array(array(97), array('a')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is converted to a string.
		 *
		 * @dataProvider data2String
		 */
		public function testToString(array $provided, array $expected) {
			$p0 = IChar\Type::make($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

		#endregion

	}

}