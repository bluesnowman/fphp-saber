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
	 * @group TypeTest
	 */
	final class TypeTest extends Core\Test {

		/**
		 * This method tests the data type.
		 */
		public function testType() {
			//$this->markTestIncomplete();

			$p0 = new String\Type('test');

			$this->assertInstanceOf('\\Saber\\Data\\String\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Vector\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Collection\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Equality\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Comparable\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Boxable\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);
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
		public function testBox(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = String\Type::box($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\String\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('string', $p1);
			$this->assertInternalType('string', $e1);
			$this->assertTrue(strlen($e1) == strlen($p1));
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method provides the data for testing the making of a value.
		 *
		 * @return array
		 */
		public function dataMake() {
			$data = array(
				array(array('string'), array('string')),
			);
			return $data;
		}

		/**
		 * This method tests the making of a value.
		 *
		 * @dataProvider dataMake
		 */
		public function testMake(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = String\Type::make($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\String\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('string', $p1);
			$this->assertInternalType('string', $e1);
			$this->assertTrue(strlen($e1) == strlen($p1));
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method tests the creation of an empty list.
		 */
		public function testEmpty() {
			//$this->markTestIncomplete();

			$p0 = String\Type::empty_();

			$this->assertInstanceOf('\\Saber\\Data\\String\\Type', $p0);

			$p1 = $p0->unbox();

			$this->assertInternalType('string', $p1);
			$this->assertTrue(0 == strlen($p1));
		}

		/**
		 * This method provides the data for testing that a value is repeated "n" times.
		 *
		 * @return array
		 */
		public function dataReplicate() {
			$data = array(
				array(array('s', 1), array('s')),
				array(array('s', 5), array('sssss')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is repeated "n" times.
		 *
		 * @dataProvider dataReplicate
		 */
		public function testReplicate(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = String\Type::replicate(Char\Type::make($provided[0]), Int32\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\String\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method tests that an element is accessible.
		 */
		public function testElements() {
			//$this->markTestIncomplete();

			$p0 = String\Type::box('012');

			$this->assertSame('0', $p0->element(Int32\Type::zero())->unbox());
			$this->assertSame('1', $p0->element(Int32\Type::one())->unbox());
			$this->assertSame('2', $p0->element(Int32\Type::box(2))->unbox());

			$this->assertSame('0', $p0->head()->unbox());

			$p1 = $p0->tail();

			$this->assertInstanceOf('\\Saber\\Data\\String\\Type', $p1);

			$p2 = $p1->unbox();

			$this->assertInternalType('string', $p2);
			$this->assertTrue(2 == strlen($p2));
			$this->assertSame('12', $p2);
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
		public function testIsEmpty(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = String\Type::make($provided[0])->isEmpty();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool\\Type', $p0);
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
		public function testLength(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = String\Type::make($provided[0])->length();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Int32\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

	}

}
