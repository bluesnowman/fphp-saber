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

namespace Saber\Data\IInt32 {

	use \Saber\Core;
	use \Saber\Data\IInt32;

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
				array(array(1), array(1)),
				array(array(null), array(0)),
				array(array(''), array(0)),
				array(array(-1), array(1)),
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

			$p0 = IInt32\Type::make($provided[0])->abs();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of adding one value to another.
		 *
		 * @return array
		 */
		public function dataAdd() {
			$data = array(
				array(array(1, 0), array(1)),
				array(array(1, null), array(1)),
				array(array(1, ''), array(1)),
				array(array(-1, 0), array(-1)),
				array(array(-1, 1), array(0)),
				array(array(0, -1), array(-1)),
				array(array(1, -1), array(0)),
				array(array(null, -1), array(-1)),
				array(array('', -1), array(-1)),
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

			$p0 = IInt32\Type::make($provided[0])->add(IInt32\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method tests the ability to make a choice.
		 */
		public function testChoice() {
			//$this->markTestIncomplete();

			$x = IInt32\Type::make(3);

			$p0 = $x->choice();

			$this->assertInstanceOf('\\Saber\\Control\\Choice\\Type', $p0);

			$p1 = $x->choice()->when(IInt32\Type::make(3), function(IInt32\Type $x) {})->end()->unbox();

			$this->assertInternalType('boolean', $p1);
			$this->assertTrue($p1);

			$p2 = $x->choice()->when(IInt32\Type::make(-3), function(IInt32\Type $x) {})->end()->unbox();

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
				array(array(1, 1), array(0)),
				array(array(1, 0), array(1)),
				array(array(1, null), array(1)),
				array(array(1, ''), array(1)),
				array(array(0, 1), array(-1)),
				array(array(null, 1), array(-1)),
				array(array('', 1), array(-1)),
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

			$p0 = IInt32\Type::make($provided[0])->compare(IInt32\Type::make($provided[1]));
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
				array(array(2), array(1)),
				array(array(1), array(0)),
				array(array(0), array(-1)),
				array(array(null), array(-1)),
				array(array(''), array(-1)),
				array(array(-1), array(-2)),
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

			$p0 = IInt32\Type::make($provided[0])->decrement();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of dividing one value by another.
		 *
		 * @return array
		 */
		public function dataDivide() {
			$data = array(
				array(array(10, 2), array(5)),
				array(array(null, 2), array(0)),
				array(array('', 2), array(0)),
				array(array(-1, 2), array(0)),
				array(array(-1, 1), array(-1)),
				array(array(0, -1), array(0)),
				array(array(1, -1), array(-1)),
				array(array(null, -1), array(0)),
				array(array('', -1), array(0)),
				array(array(-1, -1), array(1)),
				array(array(-10, 2), array(-5)),
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

			$p0 = IInt32\Type::make($provided[0])->divide(IInt32\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of finding the greatest common divisor between
		 * one value and another.
		 *
		 * @return array
		 */
		public function dataGCD() {
			$data = array(
				array(array(12, 8), array(4)),
			);
			return $data;
		}

		/**
		 * This method tests the computation of finding the greatest common divisor between one value and another.
		 *
		 * @dataProvider dataGCD
		 */
		public function testGCD(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IInt32\Type::make($provided[0])->gcd(IInt32\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of incrementing a value.
		 *
		 * @return array
		 */
		public function dataIncrement() {
			$data = array(
				array(array(2), array(3)),
				array(array(1), array(2)),
				array(array(0), array(1)),
				array(array(null), array(1)),
				array(array(''), array(1)),
				array(array(-1), array(0)),
				array(array(-2), array(-1)),
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

			$p0 = IInt32\Type::make($provided[0])->increment();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing whether a value is an even number.
		 *
		 * @return array
		 */
		public function dataIsEven() {
			$data = array(
				array(array(4), array(true)),
				array(array(3), array(false)),
				array(array(2), array(true)),
				array(array(1), array(false)),
				array(array(0), array(true)),
				array(array(null), array(true)),
				array(array(''), array(true)),
				array(array(-1), array(false)),
				array(array(-2), array(true)),
				array(array(-3), array(false)),
				array(array(-4), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests whether a value is an even number.
		 *
		 * @dataProvider dataIsEven
		 */
		public function testIsEven(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IInt32\Type::make($provided[0])->isEven();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing whether a value is an odd number.
		 *
		 * @return array
		 */
		public function dataIsOdd() {
			$data = array(
				array(array(4), array(false)),
				array(array(3), array(true)),
				array(array(2), array(false)),
				array(array(1), array(true)),
				array(array(0), array(false)),
				array(array(null), array(false)),
				array(array(''), array(false)),
				array(array(-1), array(true)),
				array(array(-2), array(false)),
				array(array(-3), array(true)),
				array(array(-4), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests whether a value is an odd number.
		 *
		 * @dataProvider dataIsOdd
		 */
		public function testIsOdd(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IInt32\Type::make($provided[0])->isOdd();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of finding the modulus of dividing
		 * one value by another.
		 *
		 * @return array
		 */
		public function dataModulo() {
			$data = array(
				array(array(10, 2), array(0)),
				array(array(null, 2), array(0)),
				array(array('', 2), array(0)),
				array(array(-1, 2), array(-1)),
				array(array(-1, 1), array(0)),
				array(array(0, -1), array(0)),
				array(array(1, -1), array(0)),
				array(array(null, -1), array(0)),
				array(array('', -1), array(0)),
				array(array(-1, -1), array(0)),
				array(array(-10, 2), array(0)),
				array(array(10, 3), array(1)),
				array(array(-10, 3), array(-1)),
				array(array(-10, -3), array(-1)),
				array(array(10, -3), array(1)),
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

			$p0 = IInt32\Type::make($provided[0])->modulo(IInt32\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of multiplying one value to another.
		 *
		 * @return array
		 */
		public function dataMultiply() {
			$data = array(
				array(array(3, 2), array(6)),
				array(array(2, 2), array(4)),
				array(array(1, 2), array(2)),
				array(array(1, 1), array(1)),
				array(array(0, 2), array(0)),
				array(array(null, 2), array(0)),
				array(array('', 2), array(0)),
				array(array(2, ''), array(0)),
				array(array(2, null), array(0)),
				array(array(2, 0), array(0)),
				array(array(2, 1), array(2)),
				array(array(2, 2), array(4)),
				array(array(2, 3), array(6)),
				array(array(3, -2), array(-6)),
				array(array(2, -2), array(-4)),
				array(array(1, -2), array(-2)),
				array(array(1, -1), array(-1)),
				array(array(0, -2), array(0)),
				array(array(null, -2), array(0)),
				array(array('', -2), array(0)),
				array(array(-2, ''), array(0)),
				array(array(-2, null), array(0)),
				array(array(-2, 0), array(0)),
				array(array(-1, 1), array(-1)),
				array(array(-2, 1), array(-2)),
				array(array(-2, 2), array(-4)),
				array(array(-2, 3), array(-6)),
				array(array(-3, -2), array(6)),
				array(array(-2, -2), array(4)),
				array(array(-1, -2), array(2)),
				array(array(-1, -1), array(1)),
				array(array(-2, -1), array(2)),
				array(array(-2, -2), array(4)),
				array(array(-2, -3), array(6)),
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

			$p0 = IInt32\Type::make($provided[0])->multiply(IInt32\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of negating a value.
		 *
		 * @return array
		 */
		public function dataNegate() {
			$data = array(
				array(array(2), array(-2)),
				array(array(1), array(-1)),
				array(array(0), array(0)),
				array(array(null), array(0)),
				array(array(''), array(0)),
				array(array(-1), array(1)),
				array(array(-2), array(2)),
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

			$p0 = IInt32\Type::make($provided[0])->negate();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the computation of subtracting one value from another.
		 *
		 * @return array
		 */
		public function dataSubtract() {
			$data = array(
				array(array(2, 1), array(1)),
				array(array(1, 1), array(0)),
				array(array(1, 0), array(1)),
				array(array(1, null), array(1)),
				array(array(1, ''), array(1)),
				array(array(-1, 0), array(-1)),
				array(array(-1, 1), array(-2)),
				array(array(0, -1), array(1)),
				array(array(1, -1), array(2)),
				array(array(null, -1), array(1)),
				array(array('', -1), array(1)),
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

			$p0 = IInt32\Type::make($provided[0])->subtract(IInt32\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is converted to a string.
		 *
		 * @return array
		 */
		public function data2IString() {
			$data = array(
				array(array(1), array('1')),
				array(array(0), array('0')),
				array(array(null), array('0')),
				array(array(''), array('0')),
				array(array(-1), array('-1')),
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

			$p0 = IInt32\Type::make($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

	}

}