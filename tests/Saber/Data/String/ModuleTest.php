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

namespace Saber\Data\String {

	use \Saber\Core;
	use \Saber\Data\Char;
	use \Saber\Data\Int32;
	use \Saber\Data\String;

	/**
	 * @group ModuleTest
	 */
	final class ModuleTest extends Core\TypeTest {

		/**
		 * This method provides the data for testing if all items pass the truthy test.
		 *
		 * @return array
		 */
		public function dataAll() {
			$data = array(
				array(array('', 's'), array(true)),
				array(array('s', 's'), array(true)),
				array(array('w', 's'), array(false)),
				array(array('sssss', 's'), array(true)),
				array(array('wssss', 's'), array(false)),
				array(array('sswss', 's'), array(false)),
				array(array('ssssw', 's'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests if all items pass the truthy test.
		 *
		 * @dataProvider dataAll
		 */
		public function testAll(array $provided, array $expected) {
			$this->markTestIncomplete();

			$x = String\Type::make($provided[0]);
			$y = Char\Type::make($provided[1]);

			$p0 = $x->all(function(Core\Any $x, Int32\Type $i) use ($y) {
				return $x->eq($y);
			});
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing if any items pass the truthy test.
		 *
		 * @return array
		 */
		public function dataAny() {
			$data = array(
				array(array('', 's'), array(false)),
				array(array('s', 's'), array(true)),
				array(array('w', 's'), array(false)),
				array(array('string', 's'), array(true)),
				array(array('string', 'i'), array(true)),
				array(array('string', 'g'), array(true)),
				array(array('string', 'x'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests if any items pass the truthy test.
		 *
		 * @dataProvider dataAny
		 */
		public function testAny(array $provided, array $expected) {
			$this->markTestIncomplete();

			$x = String\Type::make($provided[0]);
			$y = Char\Type::make($provided[1]);

			$p0 = $x->any(function(Core\Any $x, Int32\Type $i) use ($y) {
				return $x->eq($y);
			});
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is appended.
		 *
		 * @return array
		 */
		public function dataAppend() {
			$data = array(
				array(array('', 's'), array('s')),
				array(array('s', 's'), array('ss')),
				array(array('string', 's'), array('strings')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is appended.
		 *
		 * @dataProvider dataAppend
		 */
		public function testAppend(array $provided, array $expected) {
			$this->markTestIncomplete();

			$p0 = String\Type::make($provided[0])->append(Char\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\String\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
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
		public function testReverse(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = String\Type::make($provided[0])->reverse();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\String\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

	}

}