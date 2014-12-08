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

namespace Saber\Data\Float {

	use \Saber\Core;
	use \Saber\Data\Float;

	/**
	 * @group TypeTest
	 */
	final class TypeTest extends Core\TypeTest {

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array(1.0), array(1.0)),
				array(array(1), array(1.0)),
				array(array(null), array(0.0)),
				array(array(''), array(0.0)),
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

			$p0 = Float\Type::make($provided[0]);
			$e0 = new Float\Type($expected[0]);

			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Num\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Real\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Fractional\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Floating\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Float\\Type', $p0);
			$this->assertEquals($e0, $p0);
			$this->assertTrue($e0->__eq($p0));
			$this->assertTrue($e0->__id($p0));

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('float', $p1);
			$this->assertSame($e1, $p1);
		}

	}

}