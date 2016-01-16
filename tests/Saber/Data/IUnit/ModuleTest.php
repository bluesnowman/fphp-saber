<?php

/**
 * Copyright 2014-2015 Blue Snowman
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

namespace Saber\Data\IUnit {

	use \Saber\Core;
	use \Saber\Data\IBool;
	use \Saber\Data\IUnit;

	/**
	 * @group ModuleTest
	 */
	final class ModuleTest extends Core\TypeTest {

		/**
		 * This method tests the ability to make a choice.
		 */
		public function testChoice() {
			//$this->markTestIncomplete();

			$x = IUnit\Type::instance();

			$p0 = $x->choice();

			$this->assertInstanceOf('\\Saber\\Control\\Choice\\Type', $p0);

			$p1 = $x->choice()->when(IUnit\Type::instance(), function(IUnit\Type $x) {})->end()->unbox();

			$this->assertInternalType('boolean', $p1);
			$this->assertTrue($p1);

			$p2 = $x->choice()->when(IBool\Type::true(), function(IUnit\Type $x) {})->end()->unbox();

			$this->assertInternalType('boolean', $p2);
			$this->assertFalse($p2);
		}

		/**
		 * This method tests the evaluation of one value compared to another.
		 */
		public function testCompare() {
			//$this->markTestIncomplete();

			$p0 = IUnit\Module::compare(IUnit\Type::instance(), IUnit\Type::instance());
			$e0 = 0;

			$this->assertInstanceOf('\\Saber\\Data\\ITrit\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing equality.
		 *
		 * @return array
		 */
		public function dataEquality() {
			$data = array(
				array(array(IUnit\Type::instance(), IUnit\Type::instance()), array(true, true, false, false)),
				array(array(IUnit\Type::instance(), IBool\Type::true()), array(false, false, true, true)),
			);
			return $data;
		}

		/**
		 * This method tests equality.
		 *
		 * @dataProvider dataEquality
		 */
		public function testEquality(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IUnit\Module::eq($provided[0], $provided[1]);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());

			$p1 = IUnit\Module::id($provided[0], $provided[1]);
			$e1 = $expected[1];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p1);
			$this->assertSame($e1, $p1->unbox());

			$p2 = IUnit\Module::ne($provided[0], $provided[1]);
			$e2 = $expected[2];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p2);
			$this->assertSame($e2, $p2->unbox());

			$p3 = IUnit\Module::ni($provided[0], $provided[1]);
			$e3 = $expected[3];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p3);
			$this->assertSame($e3, $p3->unbox());
		}

		/**
		 * This method provides the data for testing the substitution of null values.
		 *
		 * @return array
		 */
		public function dataNVL() {
			$data = array(
				array(array(IUnit\Type::instance(), IUnit\Type::instance()), array(IUnit\Type::instance())),
				array(array(IUnit\Type::instance(), null), array(IUnit\Type::instance())),
				array(array(null, IUnit\Type::instance()), array(IUnit\Type::instance())),
				array(array(null, null), array(IUnit\Type::instance())),
			);
			return $data;
		}

		/**
		 * This method tests the substitution of null values.
		 *
		 * @dataProvider dataNVL
		 */
		public function testNVL(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IUnit\Module::nvl($provided[0], $provided[1]);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IUnit\\Type', $p0);
			$this->assertEquals($e0, $p0);
		}

		/**
		 * This method provides the data for testing that a value is converted to a string.
		 *
		 * @return array
		 */
		public function data2IString() {
			$data = array(
				array(array(null), array('null')),
				array(array(''), array('null')),
				array(array(0), array('null')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is converted to a string.
		 *
		 * @dataProvider data2IString
		 */
		public function testToIString(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IUnit\Type::instance($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

	}

}