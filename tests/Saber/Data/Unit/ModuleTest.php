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

namespace Saber\Data\Unit {

	use \Saber\Core;
	use \Saber\Data\Bool;
	use \Saber\Data\Unit;

	/**
	 * @group ModuleTest
	 */
	final class ModuleTest extends Core\TypeTest {

		/**
		 * This method tests the ability to make a choice.
		 */
		public function testChoice() {
			//$this->markTestIncomplete();

			$x = Unit\Type::instance();

			$p0 = $x->choice();

			$this->assertInstanceOf('\\Saber\\Control\\Choice\\Type', $p0);

			$p1 = $x->choice()->when(Unit\Type::instance(), function(Unit\Type $x) {})->end()->unbox();

			$this->assertInternalType('boolean', $p1);
			$this->assertTrue($p1);

			$p2 = $x->choice()->when(Bool\Type::true(), function(Unit\Type $x) {})->end()->unbox();

			$this->assertInternalType('boolean', $p2);
			$this->assertFalse($p2);
		}

		/**
		 * This method tests the evaluation of one value compared to another.
		 */
		public function testCompare() {
			//$this->markTestIncomplete();

			$p0 = Unit\Module::compare(Unit\Type::instance(), Unit\Type::instance());
			$e0 = 0;

			$this->assertInstanceOf('\\Saber\\Data\\Trit\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing equality.
		 *
		 * @return array
		 */
		public function dataEquality() {
			$data = array(
				array(array(Unit\Type::instance(), Unit\Type::instance()), array(true, true, false, false)),
				array(array(Unit\Type::instance(), Bool\Type::true()), array(false, false, true, true)),
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

			$p0 = Unit\Module::eq($provided[0], $provided[1]);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());

			$p1 = Unit\Module::id($provided[0], $provided[1]);
			$e1 = $expected[1];

			$this->assertInstanceOf('\\Saber\\Data\\Bool\\Type', $p1);
			$this->assertSame($e1, $p1->unbox());

			$p2 = Unit\Module::ne($provided[0], $provided[1]);
			$e2 = $expected[2];

			$this->assertInstanceOf('\\Saber\\Data\\Bool\\Type', $p2);
			$this->assertSame($e2, $p2->unbox());

			$p3 = Unit\Module::ni($provided[0], $provided[1]);
			$e3 = $expected[3];

			$this->assertInstanceOf('\\Saber\\Data\\Bool\\Type', $p3);
			$this->assertSame($e3, $p3->unbox());
		}

		/**
		 * This method provides the data for testing the substitution of null values.
		 *
		 * @return array
		 */
		public function dataNVL() {
			$data = array(
				array(array(Unit\Type::instance(), Unit\Type::instance()), array(Unit\Type::instance())),
				array(array(Unit\Type::instance(), null), array(Unit\Type::instance())),
				array(array(null, Unit\Type::instance()), array(Unit\Type::instance())),
				array(array(null, null), array(Unit\Type::instance())),
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

			$p0 = Unit\Module::nvl($provided[0], $provided[1]);
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Unit\\Type', $p0);
			$this->assertEquals($e0, $p0);
		}

		/**
		 * This method provides the data for testing that a value is converted to a string.
		 *
		 * @return array
		 */
		public function data2String() {
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
		 * @dataProvider data2String
		 */
		public function testToString(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = Unit\Type::instance($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

	}

}