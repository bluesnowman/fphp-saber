<?php

/**
 * Copyright 2014 Blue Snowman
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

namespace Saber\Data\Object {

	use \Saber\Core;
	use \Saber\Data\Object;

	/**
	 * @group TypeTest
	 */
	final class TypeTest extends Core\Test {

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
		public function testBox($provided, $expected) {
			//$this->markTestIncomplete();

			$p0 = Object\Type::make($provided[0]);
			$e0 = new Object\Type($expected[0]);

			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Object\\Type', $p0);
			$this->assertEquals($e0, $p0);
			$this->assertTrue($e0->__eq($p0));

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			if (is_object($p1)) {
				$this->assertInstanceOf(get_class($e1), $p1);
			}
			else {
				$this->assertInternalType(strtolower(gettype($e1)), $p1);
			}

			$this->assertEquals($e1, $p1);
		}

		/**
		 * This method tests the ability to make a choice.
		 */
		public function testChoice() {
			//$this->markTestIncomplete();

			$x = Object\Type::make(null);

			$p0 = $x->choice();

			$this->assertInstanceOf('\\Saber\\Control\\Choice\\Type', $p0);

			$p1 = $x->choice()->when(Object\Type::make(null), function(Object\Type $x) {})->end()->unbox();

			$this->assertInternalType('boolean', $p1);
			$this->assertTrue($p1);

			$p2 = $x->choice()->when(Object\Type::make(1), function(Object\Type $x) {})->end()->unbox();

			$this->assertInternalType('boolean', $p2);
			$this->assertFalse($p2);
		}

		/**
		 * This method provides the data for testing the evaluation of one value compared to another.
		 *
		 * @return array
		 */
		public function dataCompare() {
			$data = array(
				array(array(1, null), array(1)),
				array(array(null, null), array(0)),
				array(array(null, 1), array(-1)),
				array(array(1, 1), array(0)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of one value compared to another.
		 *
		 * @dataProvider dataCompare
		 */
		public function testCompare($provided, $expected) {
			//$this->markTestIncomplete();

			$p0 = Object\Type::make($provided[0])->compare(Object\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Int32\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is converted to a string.
		 *
		 * @return array
		 */
		public function dataToString() {
			$data = array(
				array(array(null), array('null')),
				array(array(''), array('')),
				array(array(0), array('0')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is converted to a string.
		 *
		 * @dataProvider dataToString
		 */
		public function testToString($provided, $expected) {
			//$this->markTestIncomplete();

			$p0 = Object\Type::make($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

	}

}