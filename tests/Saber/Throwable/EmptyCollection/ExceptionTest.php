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

namespace Saber\Throwable\EmptyCollection {

	use \Saber\Core;
	use \Saber\Data\Int32;
	use \Saber\Throwable;

	/**
	 * @group ExceptionTest
	 */
	class ExceptionTest extends Core\Test {

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array('', array(), Int32\Type::zero()), array('', array(), Int32\Type::zero())),
				array(array('', array(), null), array('', array(), Int32\Type::zero())),
			);
			return $data;
		}

		/**
		 * This method tests the boxing of a value.
		 *
		 * @dataProvider dataBox
		 */
		public function testBox(array $provided, array $expected) {
			$p0 = Throwable\EmptyCollection\Exception::make($provided[0], $provided[1], $provided[2]);
			$e0 = new Throwable\EmptyCollection\Exception($expected[0], $expected[1], $expected[2]);

			$this->assertInstanceOf('\\RuntimeException', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Throwable\\Runtime\\Exception', $p0);
			$this->assertInstanceOf('\\Saber\\Throwable\\EmptyCollection\\Exception', $p0);
			$this->assertEquals($e0, $p0);
			$this->assertTrue($e0->__eq($p0));

			$p2 = $p0->getCode();
			$e2 = $expected[2];

			$this->assertInternalType('integer', $p2);
			$this->assertSame($e2->unbox(), $p2);
		}

		/**
		 * This method provides the data for testing the evaluation of one value compared to another.
		 *
		 * @return array
		 */
		public function dataCompare() {
			$data = array(
				array(array(array('', array(), Int32\Type::zero()), array('', array(), Int32\Type::zero())), array(0)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of one value compared to another.
		 *
		 * @dataProvider dataCompare
		 */
		public function testCompare(array $provided, array $expected) {
			$p0 = Throwable\EmptyCollection\Exception::make($provided[0][0], $provided[0][1], $provided[0][2])->compare(Throwable\EmptyCollection\Exception::make($provided[1][0], $provided[1][1], $provided[1][2]));
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
				array(array('Message', array(), Int32\Type::zero()), array('Saber\\Throwable\\EmptyCollection\\Exception [ 0 ]: Message ~ ')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is converted to a string.
		 *
		 * @dataProvider dataToString
		 */
		public function testToString(array $provided, array $expected) {
			$p0 = Throwable\EmptyCollection\Exception::make($provided[0], $provided[1], $provided[2])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertEquals($e0, substr($p0, 0, strlen($e0)));
		}

	}

}
