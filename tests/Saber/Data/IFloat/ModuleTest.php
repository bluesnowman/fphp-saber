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

namespace Saber\Data\IFloat {

	use \Saber\Core;
	use \Saber\Data\IFloat;

	/**
	 * @group ModuleTest
	 */
	final class ModuleTest extends Core\ModuleTest {

		/**
		 * This method provides the data for testing the computation of a value's absolute value.
		 *
		 * @return array
		 */
		public function dataAbs() {
			$data = array(
				array(array(1.0), array(1.0)),
				array(array(1), array(1.0)),
				array(array(null), array(0.0)),
				array(array(''), array(0.0)),
				array(array(-1.0), array(1.0)),
			);
			return $data;
		}

		/**
		 * This method tests the computation of a value's absolute value.
		 *
		 * @dataProvider dataAbs
		 */
		public function testAbs(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IFloat\Type::make($provided[0])->abs();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IFloat\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of adding one value to another.
		 *
		 * @return array
		 */
		public function dataAdd() {
			$data = array(
				array(array(1.0, 0.0), array(1.0)),
				array(array(1.0, null), array(1.0)),
				array(array(1.0, ''), array(1.0)),
				array(array(-1.0, 0.0), array(-1.0)),
				array(array(-1.0, 1.0), array(0.0)),
				array(array(0.0, -1.0), array(-1.0)),
				array(array(1.0, -1.0), array(0.0)),
				array(array(null, -1.0), array(-1.0)),
				array(array('', -1.0), array(-1.0)),
			);
			return $data;
		}

		/**
		 * This method tests the computation of adding one value to another.
		 *
		 * @dataProvider dataAdd
		 */
		public function testAdd(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IFloat\Type::make($provided[0])->add(IFloat\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IFloat\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method tests the ability to make a choice.
		 */
		public function testChoice() {
			//$this->markTestIncomplete();

			$x = IFloat\Type::make(3.0);

			$p0 = $x->choice();

			$this->assertInstanceOf('\\Saber\\Control\\Choice\\Type', $p0);

			$p1 = $x->choice()->when(IFloat\Type::make(3.0), function(IFloat\Type $x) {})->end()->unbox();

			$this->assertInternalType('boolean', $p1);
			$this->assertTrue($p1);

			$p2 = $x->choice()->when(IFloat\Type::make(-3.0), function(IFloat\Type $x) {})->end()->unbox();

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
				array(array(1.0, 1.0), array(0)),
				array(array(1.0, 0.0), array(1)),
				array(array(1.0, null), array(1)),
				array(array(1.0, ''), array(1)),
				array(array(0.0, 1.0), array(-1)),
				array(array(null, 1.0), array(-1)),
				array(array('', 1.0), array(-1)),
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

			$p0 = IFloat\Type::make($provided[0])->compare(IFloat\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ITrit\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of decrementing a value.
		 *
		 * @return array
		 */
		public function dataDecrement() {
			$data = array(
				array(array(2.0), array(1.0)),
				array(array(1.0), array(0.0)),
				array(array(0.0), array(-1.0)),
				array(array(null), array(-1.0)),
				array(array(''), array(-1.0)),
				array(array(-1.0), array(-2.0)),
			);
			return $data;
		}

		/**
		 * This method tests the computation of decrementing a value.
		 *
		 * @dataProvider dataDecrement
		 */
		public function testDecrement(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IFloat\Type::make($provided[0])->decrement();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IFloat\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of dividing one value by another.
		 *
		 * @return array
		 */
		public function dataDivide() {
			$data = array(
				array(array(10.0, 2.0), array(5.0)),
				array(array(null, 2.0), array(0.0)),
				array(array('', 2.0), array(0.0)),
				array(array(-1.0, 2.0), array(-0.5)),
				array(array(-1.0, 1.0), array(-1.0)),
				array(array(0.0, -1.0), array(0.0)),
				array(array(1.0, -1.0), array(-1.0)),
				array(array(null, -1.0), array(0.0)),
				array(array('', -1.0), array(0.0)),
				array(array(-1.0, -1.0), array(1.0)),
				array(array(-10.0, 2.0), array(-5.0)),
			);
			return $data;
		}

		/**
		 * This method tests the computation of dividing one value by another.
		 *
		 * @dataProvider dataDivide
		 */
		public function testDivide(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IFloat\Type::make($provided[0])->divide(IFloat\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IFloat\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of incrementing a value.
		 *
		 * @return array
		 */
		public function dataIncrement() {
			$data = array(
				array(array(2.0), array(3.0)),
				array(array(1.0), array(2.0)),
				array(array(0.0), array(1.0)),
				array(array(null), array(1.0)),
				array(array(''), array(1.0)),
				array(array(-1.0), array(0.0)),
				array(array(-2.0), array(-1.0)),
			);
			return $data;
		}

		/**
		 * This method tests the computation of incrementing a value.
		 *
		 * @dataProvider dataIncrement
		 */
		public function testIncrement(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IFloat\Type::make($provided[0])->increment();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IFloat\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of finding the modulus of dividing
		 * one value by another.
		 *
		 * @return array
		 */
		public function dataModulo() {
			$data = array(
				array(array(10.0, 2.0), array(0.0)),
				array(array(null, 2.0), array(0.0)),
				array(array('', 2.0), array(0.0)),
				array(array(-1.0, 2.0), array(-1.0)),
				array(array(-1.0, 1.0), array(0.0)),
				array(array(0.0, -1.0), array(0.0)),
				array(array(1.0, -1.0), array(0.0)),
				array(array(null, -1.0), array(0.0)),
				array(array('', -1.0), array(0.0)),
				array(array(-1.0, -1.0), array(0.0)),
				array(array(-10.0, 2.0), array(0.0)),
				array(array(10.0, 3.0), array(1.0)),
				array(array(-10.0, 3.0), array(-1.0)),
				array(array(-10.0, -3.0), array(-1.0)),
				array(array(10.0, -3.0), array(1.0)),
			);
			return $data;
		}

		/**
		 * This method tests the computation of finding the modulus of dividing one value by another.
		 *
		 * @dataProvider dataModulo
		 */
		public function testModulo(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IFloat\Type::make($provided[0])->modulo(IFloat\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IFloat\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of multiplying one value to another.
		 *
		 * @return array
		 */
		public function dataMultiply() {
			$data = array(
				array(array(3.0, 2.0), array(6.0)),
				array(array(2.0, 2.0), array(4.0)),
				array(array(1.0, 2.0), array(2.0)),
				array(array(1.0, 1.0), array(1.0)),
				array(array(0.0, 2.0), array(0.0)),
				array(array(null, 2.0), array(0.0)),
				array(array('', 2.0), array(0.0)),
				array(array(2.0, ''), array(0.0)),
				array(array(2.0, null), array(0.0)),
				array(array(2.0, 0.0), array(0.0)),
				array(array(2.0, 1.0), array(2.0)),
				array(array(2.0, 2.0), array(4.0)),
				array(array(2.0, 3.0), array(6.0)),
				array(array(3.0, -2.0), array(-6.0)),
				array(array(2.0, -2.0), array(-4.0)),
				array(array(1.0, -2.0), array(-2.0)),
				array(array(1.0, -1.0), array(-1.0)),
				array(array(0.0, -2.0), array(0.0)),
				array(array(null, -2.0), array(0.0)),
				array(array('', -2.0), array(0.0)),
				array(array(-2.0, ''), array(0.0)),
				array(array(-2.0, null), array(0.0)),
				array(array(-2.0, 0.0), array(0.0)),
				array(array(-1.0, 1.0), array(-1.0)),
				array(array(-2.0, 1.0), array(-2.0)),
				array(array(-2.0, 2.0), array(-4.0)),
				array(array(-2.0, 3.0), array(-6.0)),
				array(array(-3.0, -2.0), array(6.0)),
				array(array(-2.0, -2.0), array(4.0)),
				array(array(-1.0, -2.0), array(2.0)),
				array(array(-1.0, -1.0), array(1.0)),
				array(array(-2.0, -1.0), array(2.0)),
				array(array(-2.0, -2.0), array(4.0)),
				array(array(-2.0, -3.0), array(6.0)),
			);
			return $data;
		}

		/**
		 * This method tests the computation of adding one value to another.
		 *
		 * @dataProvider dataMultiply
		 */
		public function testMultiply(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IFloat\Type::make($provided[0])->multiply(IFloat\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IFloat\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of negating a value.
		 *
		 * @return array
		 */
		public function dataNegate() {
			$data = array(
				array(array(2.0), array(-2.0)),
				array(array(1.0), array(-1.0)),
				array(array(0.0), array(0.0)),
				array(array(null), array(0.0)),
				array(array(''), array(0.0)),
				array(array(-1.0), array(1.0)),
				array(array(-2.0), array(2.0)),
			);
			return $data;
		}

		/**
		 * This method tests whether the data for testing the computation of negating a value.
		 *
		 * @dataProvider dataNegate
		 */
		public function testNegate(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IFloat\Type::make($provided[0])->negate();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IFloat\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of subtracting one value from another.
		 *
		 * @return array
		 */
		public function dataSubtract() {
			$data = array(
				array(array(2.0, 1.0), array(1.0)),
				array(array(1.0, 1.0), array(0.0)),
				array(array(1.0, 0.0), array(1.0)),
				array(array(1.0, null), array(1.0)),
				array(array(1.0, ''), array(1.0)),
				array(array(-1.0, 0.0), array(-1.0)),
				array(array(-1.0, 1.0), array(-2.0)),
				array(array(0.0, -1.0), array(1.0)),
				array(array(1.0, -1.0), array(2.0)),
				array(array(null, -1.0), array(1.0)),
				array(array('', -1.0), array(1.0)),
			);
			return $data;
		}

		/**
		 * This method tests the computation of subtracting one value from another.
		 *
		 * @dataProvider dataSubtract
		 */
		public function testSubtract(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IFloat\Type::make($provided[0])->subtract(IFloat\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IFloat\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is converted to a string.
		 *
		 * @return array
		 */
		public function data2String() {
			$data = array(
				array(array(1.0), array('1.000000')),
				array(array(0.0), array('0.000000')),
				array(array(null), array('0.000000')),
				array(array(''), array('0.000000')),
				array(array(-1.0), array('-1.000000')),
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

			$p0 = IFloat\Type::make($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

	}

}