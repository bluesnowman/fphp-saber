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

namespace Saber\Core {

	use \Saber\Core;

	/**
	 * @group AnyVal
	 */
	class Int32Test extends Core\AnyTest {

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
		public function testAbs($provided, $expected) {
			$p0 = Core\Int32::box($provided[0])->abs();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Core\\Int32', $p0);
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
		public function testAdd($provided, $expected) {
			$p0 = Core\Int32::box($provided[0])->add(Core\Int32::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Core\\Int32', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array(1), array(1)),
				array(array(null), array(0)),
				array(array(''), array(0)),
			);
			return $data;
		}

		/**
		 * This method tests the boxing of a value.
		 *
		 * @dataProvider dataBox
		 */
		public function testBox($provided, $expected) {
			$p0 = Core\Int32::box($provided[0]);
			$e0 = new Core\Int32($expected[0]);

			$this->assertInstanceOf('\\Saber\\Core\\AnyVal', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Int32', $p0);
			$this->assertEquals($e0, $p0);
			$this->assertTrue($e0->__equals($p0));
			$this->assertTrue($e0->__identical($p0));

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('integer', $p1);
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method provides the data for testing the evaluation of one value compared to another.
		 *
		 * @return array
		 */
		public function dataCompareTo() {
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
		 * @dataProvider dataCompareTo
		 */
		public function testCompareTo($provided, $expected) {
			$p0 = Core\Int32::box($provided[0])->compareTo(Core\Int32::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Core\\Int32', $p0);
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
		public function testDecrement($provided, $expected) {
			$p0 = Core\Int32::box($provided[0])->decrement();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Core\\Int32', $p0);
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
		public function testDivide($provided, $expected) {
			$p0 = Core\Int32::box($provided[0])->divide(Core\Int32::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Core\\Int32', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing whether a value is an even number.
		 *
		 * @return array
		 */
		public function dataEven() {
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
		 * @dataProvider dataEven
		 */
		public function testEven($provided, $expected) {
			$p0 = Core\Int32::box($provided[0])->even();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Core\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
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
		public function testGCD($provided, $expected) {
			$p0 = Core\Int32::box($provided[0])->gcd(Core\Int32::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Core\\Int32', $p0);
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
		public function testIncrement($provided, $expected) {
			$p0 = Core\Int32::box($provided[0])->increment();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Core\\Int32', $p0);
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
		public function testModulo($provided, $expected) {
			$p0 = Core\Int32::box($provided[0])->modulo(Core\Int32::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Core\\Int32', $p0);
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
		public function testMultiply($provided, $expected) {
			$p0 = Core\Int32::box($provided[0])->multiply(Core\Int32::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Core\\Int32', $p0);
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
		 * This method tests whether a value is an odd number.
		 *
		 * @dataProvider dataNegate
		 */
		public function testNegate($provided, $expected) {
			$p0 = Core\Int32::box($provided[0])->negate();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Core\\Int32', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing whether a value is an odd number.
		 *
		 * @return array
		 */
		public function dataOdd() {
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
		 * @dataProvider dataOdd
		 */
		public function testOdd($provided, $expected) {
			$p0 = Core\Int32::box($provided[0])->odd();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Core\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
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
		public function testSubtract($provided, $expected) {
			$p0 = Core\Int32::box($provided[0])->subtract(Core\Int32::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Core\\Int32', $p0);
			$this->assertEquals($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is converted to a string.
		 *
		 * @return array
		 */
		public function dataToString() {
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
		 * @dataProvider dataToString
		 */
		public function testToString($provided, $expected) {
			$p0 = Core\Int32::box($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

	}

}