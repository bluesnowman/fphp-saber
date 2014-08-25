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

namespace Saber\Data {

	use \Saber\Core;
	use \Saber\Data;

	/**
	 * @group AnyRef
	 */
	class StringTest extends Core\AnyTest {

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array('string'), array('string')),
			);
			return $data;
		}

		/**
		 * This method tests the boxing of a value.
		 *
		 * @dataProvider dataBox
		 */
		public function testBox($provided, $expected) {
			$p0 = Data\String::box($provided[0]);
			$e0 = new Data\String($expected[0]);

			$this->assertInstanceOf('\\Saber\\Core\\AnyRef', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\String', $p0);
			$this->assertEquals($e0, $p0);
			$this->assertTrue($e0->__equals($p0));

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('string', $p1);
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method provides the data for testing that a value is reversed.
		 *
		 * @return array
		 */
		public function dataReverse() {
			$data = array(
				array(array('string'), array('gnirts')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is reversed.
		 *
		 * @dataProvider dataReverse
		 */
		public function testReverse($provided, $expected) {
			$p0 = Data\String::box($provided[0])->reverse();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\String', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

	}

}
