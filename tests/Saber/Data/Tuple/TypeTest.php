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

namespace Saber\Data\Tuple {

	use \Saber\Core;
	use \Saber\Data\Tuple;
	use \Saber\Data\Unit;

	/**
	 * @group TypeTest
	 */
	class TypeTest extends Core\Test {

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array(Unit\Type::instance(), Unit\Type::instance()), array(Unit\Type::instance(), Unit\Type::instance())),
				array(array(null, null), array(null, null)),
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

			$p0 = Tuple\Type::make($provided[0], $provided[1]);
			$e0 = new Tuple\Type($expected);

			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Tuple\\Type', $p0);
			$this->assertEquals($e0, $p0);
			$this->assertTrue($e0->__eq($p0));
			$this->assertTrue($e0->__id($p0));

			$p1 = $p0->first();
			$e1 = $expected[0];

			$this->assertSame($e1, $p1);

			$p2 = $p0->second();
			$e2 = $expected[1];

			$this->assertSame($e2, $p2);
		}

	}

}