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

namespace Saber\Data\Double {

	use \Saber\Core;
	use \Saber\Data\Double;

	/**
	 * @group TypeTest
	 */
	final class TypeTest extends Core\Test {

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
		public function testAbs($provided, $expected) {
			//$this->markTestIncomplete();

			$p0 = Double\Type::make($provided[0])->abs();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Double\\Type', $p0);
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
		public function testAdd($provided, $expected) {
			//$this->markTestIncomplete();

			$p0 = Double\Type::make($provided[0])->add(Double\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Double\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array(1.0), array(1.0)),
				array(array(1), array(1.0)),
				array(array(null), array(0.0)),
				array(array(''), array(0.0)),
			);
			return $data;
		}

		/**
		 * This method tests the boxing of a value.
		 *
		 * @dataProvider dataBox
		 */
		public function testBox($provided, $expected) {
			//$this->markTestIncomplete();

			$p0 = Double\Type::make($provided[0]);
			$e0 = new Double\Type($expected[0]);

			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Floating\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Double\\Type', $p0);
			$this->assertEquals($e0, $p0);
			$this->assertTrue($e0->__eq($p0));
			$this->assertTrue($e0->__id($p0));

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('float', $p1);
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method tests the ability to make a choice.
		 */
		public function testChoice() {
			//$this->markTestIncomplete();

			$x = Double\Type::make(3.0);

			$p0 = $x->choice();

			$this->assertInstanceOf('\\Saber\\Control\\Choice\\Type', $p0);

			$p1 = $x->choice()->when(Double\Type::make(3.0), function(Double\Type $x) {})->end()->unbox();

			$this->assertInternalType('boolean', $p1);
			$this->assertTrue($p1);

			$p2 = $x->choice()->when(Double\Type::make(-3.0), function(Double\Type $x) {})->end()->unbox();

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
		public function testCompare($provided, $expected) {
			//$this->markTestIncomplete();

			$p0 = Double\Type::make($provided[0])->compare(Double\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Int32\\Type', $p0);
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
		public function testDecrement($provided, $expected) {
			//$this->markTestIncomplete();

			$p0 = Double\Type::make($provided[0])->decrement();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Double\\Type', $p0);
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
		public function testDivide($provided, $expected) {
			//$this->markTestIncomplete();

			$p0 = Double\Type::make($provided[0])->divide(Double\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Double\\Type', $p0);
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
		public function testIncrement($provided, $expected) {
			//$this->markTestIncomplete();

			$p0 = Double\Type::make($provided[0])->increment();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Double\\Type', $p0);
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
		public function testModulo($provided, $expected) {
			//$this->markTestIncomplete();

			$p0 = Double\Type::make($provided[0])->modulo(Double\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Double\\Type', $p0);
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
		public function testMultiply($provided, $expected) {
			//$this->markTestIncomplete();

			$p0 = Double\Type::make($provided[0])->multiply(Double\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Double\\Type', $p0);
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
		public function testNegate($provided, $expected) {
			//$this->markTestIncomplete();

			$p0 = Double\Type::make($provided[0])->negate();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Double\\Type', $p0);
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
		public function testSubtract($provided, $expected) {
			//$this->markTestIncomplete();

			$p0 = Double\Type::make($provided[0])->subtract(Double\Type::make($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Double\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is converted to a string.
		 *
		 * @return array
		 */
		public function dataToString() {
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
		 * @dataProvider dataToString
		 */
		public function testToString($provided, $expected) {
			//$this->markTestIncomplete();

			$p0 = Double\Type::make($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

	}

}