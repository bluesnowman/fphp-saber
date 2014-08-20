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

namespace Saber\Core {

	use \Saber\Core;

	/**
	 * @group AnyVal
	 */
	class NothingTest extends Core\AnyTest {

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array(1), array(null)),
				array(array(null), array(null)),
				array(array(''), array(null)),
			);
			return $data;
		}

		/**
		 * This method tests the boxing of a value.
		 *
		 * @dataProvider dataBox
		 */
		public function testBox($provided, $expected) {
			$p0 = Core\Nothing::box($provided[0]);
			$e0 = new Core\Nothing($expected[0]);

			$this->assertInstanceOf('\\Saber\\Core\\AnyVal', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Nothing', $p0);
			$this->assertEquals($e0, $p0);
			$this->assertTrue($e0->__equals($p0));
			$this->assertTrue($e0->__identical($p0));

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('null', $p1);
			$this->assertSame($e1, $p1);
			$this->assertNull($p1);
		}

		/**
		 * This method provides the data for testing the evaluation of one value compared to another.
		 *
		 * @return array
		 */
		public function dataCompareTo() {
			$data = array(
				array(array(1, null), array(0)),
				array(array(null, null), array(0)),
				array(array(null, 1), array(0)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of one value compared to another.
		 *
		 * @dataProvider dataCompareTo
		 */
		public function testCompareTo($provided, $expected) {
			$p0 = Core\Nothing::box($provided[0])->compareTo(Core\Nothing::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Core\\Int32', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is converted to a string.
		 *
		 * @return array
		 */
		public function dataToString() {
			$data = array(
				array(array(null), array('nothing')),
				array(array(''), array('nothing')),
				array(array(0), array('nothing')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is converted to a string.
		 *
		 * @dataProvider dataToString
		 */
		public function testToString($provided, $expected) {
			$p0 = Core\Nothing::box($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

	}

}