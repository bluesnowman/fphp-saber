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

namespace Saber\Data\IBool {

	use \Saber\Core;
	use \Saber\Data\IBool;

	/**
	 * @group ModuleTest
	 */
	final class ModuleTest extends Core\ModuleTest {

		/**
		 * This method provides the data for testing the evaluation of one value "AND" another.
		 *
		 * @return array
		 */
		public function dataAND() {
			$data = array(
				array(array(true, true), array(true)),
				array(array(true, false), array(false)),
				array(array(true, null), array(false)),
				array(array(true, ''), array(false)),
				array(array(false, true), array(false)),
				array(array(null, true), array(false)),
				array(array('', true), array(false)),
				array(array(false, false), array(false)),
				array(array(null, null), array(false)),
				array(array('', ''), array(false)),
				array(array(null, ''), array(false)),
				array(array('', null), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of one value "AND" another.
		 *
		 * @dataProvider dataAND
		 */
		public function testAND(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IBool\Module::and_(IBool\Type::make($provided[0]), IBool\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method tests the ability to make a choice.
		 */
		public function testChoice() {
			//$this->markTestIncomplete();

			$x = IBool\Type::true();

			$p0 = $x->choice();

			$this->assertInstanceOf('\\Saber\\Control\\Choice\\Type', $p0);

			$p1 = $x->choice()->when(IBool\Type::true(), function(IBool\Type $x) {})->end()->unbox();

			$this->assertInternalType('boolean', $p1);
			$this->assertTrue($p1);

			$p2 = $x->choice()->when(IBool\Type::false(), function(IBool\Type $x) {})->end()->unbox();

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
				array(array(true, true), array(0)),
				array(array(true, false), array(1)),
				array(array(true, null), array(1)),
				array(array(true, ''), array(1)),
				array(array(false, true), array(-1)),
				array(array(null, true), array(-1)),
				array(array('', true), array(-1)),
				array(array(false, false), array(0)),
				array(array(null, null), array(0)),
				array(array('', ''), array(0)),
				array(array(null, ''), array(0)),
				array(array('', null), array(0)),
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

			$p0 = IBool\Module::compare(IBool\Type::make($provided[0]), IBool\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ITrit\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of one value "OR" another.
		 *
		 * @return array
		 */
		public function dataOR() {
			$data = array(
				array(array(true, true), array(true)),
				array(array(true, false), array(true)),
				array(array(true, null), array(true)),
				array(array(true, ''), array(true)),
				array(array(false, true), array(true)),
				array(array(null, true), array(true)),
				array(array('', true), array(true)),
				array(array(false, false), array(false)),
				array(array(null, null), array(false)),
				array(array('', ''), array(false)),
				array(array(null, ''), array(false)),
				array(array('', null), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of one value "OR" another.
		 *
		 * @dataProvider dataOR
		 */
		public function testOR(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IBool\Module::or_(IBool\Type::make($provided[0]), IBool\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of one value "NAND" another.
		 *
		 * @return array
		 */
		public function dataNAND() {
			$data = array(
				array(array(true, true), array(false)),
				array(array(true, false), array(true)),
				array(array(true, null), array(true)),
				array(array(true, ''), array(true)),
				array(array(false, true), array(true)),
				array(array(null, true), array(true)),
				array(array('', true), array(true)),
				array(array(false, false), array(true)),
				array(array(null, null), array(true)),
				array(array('', ''), array(true)),
				array(array(null, ''), array(true)),
				array(array('', null), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of one value "NAND" another.
		 *
		 * @dataProvider dataNAND
		 */
		public function testNAND(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IBool\Module::nand(IBool\Type::make($provided[0]), IBool\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of one value "NOR" another.
		 *
		 * @return array
		 */
		public function dataNOR() {
			$data = array(
				array(array(true, true), array(false)),
				array(array(true, false), array(false)),
				array(array(true, null), array(false)),
				array(array(true, ''), array(false)),
				array(array(false, true), array(false)),
				array(array(null, true), array(false)),
				array(array('', true), array(false)),
				array(array(false, false), array(true)),
				array(array(null, null), array(true)),
				array(array('', ''), array(true)),
				array(array(null, ''), array(true)),
				array(array('', null), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of one value "NOR" another.
		 *
		 * @dataProvider dataNOR
		 */
		public function testNOR(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IBool\Module::nor(IBool\Type::make($provided[0]), IBool\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of the negation of one value.
		 *
		 * @return array
		 */
		public function dataNOT() {
			$data = array(
				array(array(true), array(false)),
				array(array(1), array(false)),
				array(array('true'), array(false)),
				array(array(false), array(true)),
				array(array(0), array(true)),
				array(array(null), array(true)),
				array(array(''), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of the negation of one value.
		 *
		 * @dataProvider dataNOT
		 */
		public function testNOT(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IBool\Module::not(IBool\Type::make($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is casted to an int(32).
		 *
		 * @return array
		 */
		public function dataToIInt32() {
			$data = array(
				array(array(true), array(1)),
				array(array(1), array(1)),
				array(array('true'), array(1)),
				array(array(false), array(0)),
				array(array(0), array(0)),
				array(array(null), array(0)),
				array(array(''), array(0)),
			);
			return $data;
		}

		/**
		 * This method tests that a value is casted to an int(32).
		 *
		 * @dataProvider dataToIInt32
		 */
		public function testToIInt32(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IBool\Module::toInt32(IBool\Type::make($provided[0]));
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
				array(array(true), array('true')),
				array(array(1), array('true')),
				array(array('true'), array('true')),
				array(array(false), array('false')),
				array(array(0), array('false')),
				array(array(null), array('false')),
				array(array(''), array('false')),
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

			$p0 = IBool\Type::make($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

		/**
		 * This method provides the data for testing the evaluation of one value "XOR" another.
		 *
		 * @return array
		 */
		public function dataXOR() {
			$data = array(
				array(array(true, true), array(false)),
				array(array(true, false), array(true)),
				array(array(true, null), array(true)),
				array(array(true, ''), array(true)),
				array(array(false, true), array(true)),
				array(array(null, true), array(true)),
				array(array('', true), array(true)),
				array(array(false, false), array(false)),
				array(array(null, null), array(false)),
				array(array('', ''), array(false)),
				array(array(null, ''), array(false)),
				array(array('', null), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of one value "XOR" another.
		 *
		 * @dataProvider dataXOR
		 */
		public function testXOR(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IBool\Module::xor_(IBool\Type::make($provided[0]), IBool\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

	}

}