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
		 * This method provides the data for testing if all elements pass the truthy test.
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
		 * This method tests if all elements pass the truthy test.
		 *
		 * @dataProvider dataAll
		 */
		public function testAll($provided, $expected) {
			$x = String\Module::box($provided[0]);
			$y = Char\Module::box($provided[1]);

			$p0 = $x->all(function(Core\Any $x, Int32\Type $i) use ($y) {
				return $x->equals($y);
			});
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing if any elements pass the truthy test.
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
		 * This method tests if any elements pass the truthy test.
		 *
		 * @dataProvider dataAny
		 */
		public function testAny($provided, $expected) {
			$x = String\Module::box($provided[0]);
			$y = Char\Module::box($provided[1]);

			$p0 = $x->any(function(Core\Any $x, Int32\Type $i) use ($y) {
				return $x->equals($y);
			});
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
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
		public function testAppend($provided, $expected) {
			$p0 = String\Module::box($provided[0])->append(Char\Module::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\String', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

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
			$p0 = String\Module::box($provided[0]);
			$e0 = new String\Type($expected[0]);

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
		 * This method provides the data for testing that a value is empty.
		 *
		 * @return array
		 */
		public function dataIsEmpty() {
			$data = array(
				array(array(''), array(true)),
				array(array('s'), array(false)),
				array(array('string'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests that a value is empty.
		 *
		 * @dataProvider dataIsEmpty
		 */
		public function testIsEmpty($provided, $expected) {
			$p0 = String\Module::box($provided[0])->isEmpty();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is of a particular length.
		 *
		 * @return array
		 */
		public function dataLength() {
			$data = array(
				array(array(''), array(0)),
				array(array('s'), array(1)),
				array(array('string'), array(6)),
			);
			return $data;
		}

		/**
		 * This method tests that a value is of a particular length.
		 *
		 * @dataProvider dataLength
		 */
		public function testLength($provided, $expected) {
			$p0 = String\Module::box($provided[0])->length();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Int32', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is repeated "n" times.
		 *
		 * @return array
		 */
		public function dataReplicate() {
			$data = array(
				array(array(1, 's'), array('s')),
				array(array(5, 's'), array('sssss')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is repeated "n" times.
		 *
		 * @dataProvider dataReplicate
		 */
		public function testReplicate($provided, $expected) {
			$p0 = String\Module::replicate(Int32\Module::box($provided[0]), Char\Module::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\String', $p0);
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
		public function testReverse($provided, $expected) {
			$p0 = String\Module::box($provided[0])->reverse();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\String', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

	}

}
