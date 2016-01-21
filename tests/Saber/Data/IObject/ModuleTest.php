<?php

/**
 * Copyright 2014-2016 Blue Snowman
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

declare(strict_types = 1);

namespace Saber\Data\IObject {

	use \Saber\Core;
	use \Saber\Data\IObject;

	/**
	 * @group ModuleTest
	 */
	final class ModuleTest extends Core\ModuleTest {

		/**
		 * This method tests the ability to make a choice.
		 */
		public function testChoice() {
			//$this->markTestIncomplete();

			$x = IObject\Type::make(null);

			$p0 = $x->choice();

			$this->assertInstanceOf('\\Saber\\Control\\Choice\\Type', $p0);

			$p1 = $x->choice()->when(IObject\Type::make(null), function(IObject\Type $x) {})->end()->unbox();

			$this->assertInternalType('boolean', $p1);
			$this->assertTrue($p1);

			$p2 = $x->choice()->when(IObject\Type::make(1), function(IObject\Type $x) {})->end()->unbox();

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
		public function testCompare(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IObject\Type::make($provided[0])->compare(IObject\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is converted to a string.
		 *
		 * @return array
		 */
		public function data2String() {
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
		 * @dataProvider data2String
		 */
		public function testToString(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IObject\Type::make($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

	}

}