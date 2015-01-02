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

namespace Saber\Throwable\Unknown {

	use \Saber\Core;
	use \Saber\Data\Int32;
	use \Saber\Throwable;

	/**
	 * @group ExceptionTest
	 */
	final class ExceptionTest extends Core\TypeTest {

		#region Tests -> Inheritance

		/**
		 * This method tests the data type.
		 */
		public function testType() {
			//$this->markTestIncomplete();

			$p0 = new Throwable\Unknown\Exception(new Throwable\InvalidArgument\Exception('', array(), Int32\Type::zero()));

			$this->assertInstanceOf('\\Saber\\Throwable\\Runtime\\Exception', $p0);
			$this->assertInstanceOf('\\Saber\\Throwable\\Unknown\\Exception', $p0);
			$this->assertInstanceOf('\\RuntimeException', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Equality\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Comparable\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);
		}

		#endregion

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array(new Throwable\InvalidArgument\Exception('', array(), Int32\Type::zero())), array(0)),
				array(array(new Throwable\InvalidArgument\Exception('', array(), null)), array(0)),
				array(array(new Throwable\InvalidArgument\Exception('', array(), Int32\Type::one())), array(1)),
			);
			return $data;
		}

		/**
		 * This method tests the boxing of a value.
		 *
		 * @dataProvider dataBox
		 */
		public function testBox(array $provided, array $expected) {
			$p0 = Throwable\Unknown\Exception::box($provided[0]);

			$this->assertInstanceOf('\\Saber\\Throwable\\Unknown\\Exception', $p0);

			$p1 = $p0->__getCode();
			$e1 = $expected[0];

			$this->assertInternalType('integer', $p1);
			$this->assertSame($e1, $p1);
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
			$p0 = Throwable\Unknown\Exception::make(
				new Throwable\InvalidArgument\Exception($provided[0][0], $provided[0][1], $provided[0][2])
			)->compare(
				Throwable\Unknown\Exception::make(
					new Throwable\InvalidArgument\Exception($provided[1][0], $provided[1][1], $provided[1][2])
				)
			);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Trit\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is converted to a string.
		 *
		 * @return array
		 */
		public function dataToString() {
			$data = array(
				array(array(new Throwable\InvalidArgument\Exception('Message', array(), Int32\Type::zero())), array('Saber\\Throwable\\InvalidArgument\\Exception [ 0 ]: Message ~ ')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is converted to a string.
		 *
		 * @dataProvider dataToString
		 */
		public function testToString(array $provided, array $expected) {
			$p0 = Throwable\Unknown\Exception::make($provided[0], $provided[1], $provided[2])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertEquals($e0, substr($p0, 0, strlen($e0)));
		}

	}

}
