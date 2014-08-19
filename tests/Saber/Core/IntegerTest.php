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
	 * @requires extension gmp
	 * @group AnyVal
	 */
	class IntegerTest extends Core\AnyTest {

		/**
		 * This method provides the data for testing the computation of adding one value to another.
		 *
		 * @return array
		 */
		public function dataAdd() {
			$data = array(
				array(array(1, 0), array(1)),
				//array(array(1, null), array(1)),
				//array(array(1, ''), array(1)),
				//array(array(-1, 0), array(-1)),
				//array(array(-1, 1), array(0)),
				//array(array(0, -1), array(-1)),
				//array(array(1, -1), array(0)),
				//array(array(null, -1), array(-1)),
				//array(array('', -1), array(-1)),
			);
			return $data;
		}

		/**
		 * This method tests the computation of adding one value to another.
		 *
		 * @dataProvider dataAdd
		 */
		public function testAdd($provided, $expected) {
			$p0 = Core\Integer::box($provided[0])->add(Core\Integer::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Core\\Integer', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

	}

}