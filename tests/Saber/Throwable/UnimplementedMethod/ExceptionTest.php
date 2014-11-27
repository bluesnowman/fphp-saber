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

namespace Saber\Throwable\UnimplementedMethod {

	use \Saber\Core;
	use \Saber\Throwable;

	/**
	 * @group AnyErr
	 */
	class ExceptionTest extends Core\Test {

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array('', array(), 0), array('', array(), 0)),
			);
			return $data;
		}

		/**
		 * This method tests the boxing of a value.
		 *
		 * @dataProvider dataBox
		 */
		public function testBox($provided, $expected) {
			$p0 = Throwable\UnimplementedMethod\Exception::make($provided[0], $provided[1], $provided[2]);
			$e0 = new Throwable\UnimplementedMethod\Exception($expected[0], $expected[1], $expected[2]);

			$this->assertInstanceOf('\\Saber\\Core\\AnyErr', $p0);
			$this->assertInstanceOf('\\Saber\\Throwable\\UnimplementedMethod\\Exception', $p0);
			$this->assertEquals($e0, $p0);
			$this->assertTrue($e0->__equals($p0));

			$p1 = $p0->unbox();
			$e1 = $expected[1];

			$this->assertInternalType('array', $p1);
			$this->assertEmpty(array_diff($p1, $e1));

			$p2 = $p0->getCode();
			$e2 = $expected[2];

			$this->assertInternalType('integer', $p2);
			$this->assertSame($e2, $p2);
		}

		/**
		 * This method provides the data for testing the evaluation of one value compared to another.
		 *
		 * @return array
		 */
		public function dataCompareTo() {
			$data = array(
				array(array(array('', array(), 0), array('', array(), 0)), array(0)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of one value compared to another.
		 *
		 * @dataProvider dataCompareTo
		 */
		public function testCompareTo($provided, $expected) {
			$p0 = Throwable\UnimplementedMethod\Exception::make($provided[0][0], $provided[0][1], $provided[0][2])->compareTo(Throwable\UnimplementedMethod\Exception::make($provided[1][0], $provided[1][1], $provided[1][2]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Int32', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is converted to a string.
		 *
		 * @return array
		 */
		public function dataToString() {
			$data = array(
				array(array('Message', array(), 0), array('Saber\\Throwable\\UnimplementedMethod\\Exception [ 0 ]: Message ~ ')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is converted to a string.
		 *
		 * @dataProvider dataToString
		 */
		public function testToString($provided, $expected) {
			$p0 = Throwable\UnimplementedMethod\Exception::make($provided[0], $provided[1], $provided[2])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertEquals($e0, substr($p0, 0, strlen($e0)));
		}

	}

}
