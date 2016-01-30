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

namespace Saber\Data\IInteger {

	use \Saber\Core;
	use \Saber\Data\IInt32;
	use \Saber\Data\IInteger;
	use \Saber\Data\ITuple;

	/**
	 * @requires extension gmp
	 * @group ModuleTest
	 */
	final class ModuleTest extends Core\ModuleTest {

		#region Methods -> Arithmetic Operations

		/**
		 * This method provides the data for testing the "abs" method.
		 *
		 * @return array
		 */
		public function data_abs() {
			$data = array(
				array(array('1'), array('1')),
				array(array('0'), array('0')),
				array(array('-1'), array('1')),
			);
			return $data;
		}

		/**
		 * This method tests the "abs" method.
		 *
		 * @dataProvider data_abs
		 */
		public function test_abs(array $provided, array $expected) {
			$p0 = IInteger\Module::abs(IInteger\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "add" method.
		 *
		 * @return array
		 */
		public function data_add() {
			$data = array(
				array(array('1', '0'), array('1')),
				array(array('-1', '0'), array('-1')),
				array(array('-1', '1'), array('0')),
				array(array('0', '0'), array('0')),
				array(array('0', '-1'), array('-1')),
				array(array('1', '-1'), array('0')),
			);
			return $data;
		}

		/**
		 * This method tests the "add" method.
		 *
		 * @dataProvider data_add
		 */
		public function test_add(array $provided, array $expected) {
			$p0 = IInteger\Module::add(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "decrement" method.
		 *
		 * @return array
		 */
		public function data_decrement() {
			$data = array(
				array(array('2'), array('1')),
				array(array('1'), array('0')),
				array(array('0'), array('-1')),
				array(array('-1'), array('-2')),
			);
			return $data;
		}

		/**
		 * This method tests the "decrement" method.
		 *
		 * @dataProvider data_decrement
		 */
		public function test_decrement(array $provided, array $expected) {
			$p0 = IInteger\Module::decrement(IInteger\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "divide" method.
		 *
		 * @return array
		 */
		public function data_divide() {
			$data = array(
				array(array('10', '2'), array('5')),
				array(array('0', '2'), array('0')),
				array(array('-1', '2'), array('0')),
				array(array('-1', '1'), array('-1')),
				array(array('0', '-1'), array('0')),
				array(array('1', '-1'), array('-1')),
				array(array('-1', '-1'), array('1')),
				array(array('-10', '2'), array('-5')),
			);
			return $data;
		}

		/**
		 * This method tests the "divide" method.
		 *
		 * @dataProvider data_divide
		 */
		public function test_divide(array $provided, array $expected) {
			$this->markTestIncomplete();

			$p0 = IInteger\Module::divide(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "factorial" method.
		 *
		 * @return array
		 */
		public function data_factorial() {
			$data = array(
				array(array('0'), array('1')),
				array(array('1'), array('1')),
				array(array('2'), array('2')),
				array(array('3'), array('6')),
				array(array('4'), array('24')),
				array(array('5'), array('120')),
				array(array('6'), array('720')),
				array(array('7'), array('5040')),
				array(array('8'), array('40320')),
				array(array('9'), array('362880')),
			);
			return $data;
		}

		/**
		 * This method tests the "factorial" method.
		 *
		 * @dataProvider data_factorial
		 */
		public function test_factorial(array $provided, array $expected) {
			$p0 = IInteger\Module::factorial(IInteger\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "fibonacci" method.
		 *
		 * @return array
		 */
		public function data_fibonacci() {
			$data = array(
				array(array('0'), array('0')),
				array(array('1'), array('1')),
				array(array('2'), array('1')),
				array(array('3'), array('2')),
				array(array('4'), array('3')),
				array(array('5'), array('5')),
				array(array('6'), array('8')),
				array(array('7'), array('13')),
				array(array('8'), array('21')),
				array(array('9'), array('34')),
				array(array('10'), array('55')),
				array(array('11'), array('89')),
				array(array('12'), array('144')),
			);
			return $data;
		}

		/**
		 * This method tests the "fibonacci" method.
		 *
		 * @dataProvider data_fibonacci
		 */
		public function test_fibonacci(array $provided, array $expected) {
			$p0 = IInteger\Module::fibonacci(IInteger\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "gdc" method.
		 *
		 * @return array
		 */
		public function data_gcd() {
			$data = array(
				array(array('12', '8'), array('4')),
				array(array('54', '24'), array('6')),
			);
			return $data;
		}

		/**
		 * This method tests the "gcd" method.
		 *
		 * @dataProvider data_gcd
		 */
		public function test_gcd(array $provided, array $expected) {
			$p0 = IInteger\Module::gcd(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "increment" method.
		 *
		 * @return array
		 */
		public function data_increment() {
			$data = array(
				array(array('2'), array('3')),
				array(array('1'), array('2')),
				array(array('0'), array('1')),
				array(array('-1'), array('0')),
				array(array('-2'), array('-1')),
			);
			return $data;
		}

		/**
		 * This method tests the "increment" method.
		 *
		 * @dataProvider data_increment
		 */
		public function test_increment(array $provided, array $expected) {
			$p0 = IInteger\Module::increment(IInteger\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "modulo" method.
		 *
		 * @return array
		 */
		public function data_modulo() {
			$data = array(
				array(array('10', '2'), array('0')),
				array(array('-1', '2'), array('-1')),
				array(array('-1', '1'), array('0')),
				array(array('0', '-1'), array('0')),
				array(array('1', '-1'), array('0')),
				array(array('-1', '-1'), array('0')),
				array(array('-10', '2'), array('0')),
				array(array('10', '3'), array('1')),
				array(array('-10', '3'), array('-1')),
				array(array('-10', '-3'), array('-1')),
				array(array('10', '-3'), array('1')),
			);
			return $data;
		}

		/**
		 * This method tests the "modulo" method.
		 *
		 * @dataProvider data_modulo
		 */
		public function test_modulo(array $provided, array $expected) {
			$this->markTestIncomplete();

			$p0 = IInteger\Module::modulo(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "multiply" method.
		 *
		 * @return array
		 */
		public function data_multiply() {
			$data = array(
				array(array('3', '2'), array('6')),
				array(array('2', '2'), array('4')),
				array(array('1', '2'), array('2')),
				array(array('1', '1'), array('1')),
				array(array('0', '2'), array('0')),
				array(array('2', '0'), array('0')),
				array(array('2', '1'), array('2')),
				array(array('2', '2'), array('4')),
				array(array('2', '3'), array('6')),
				array(array('3', '-2'), array('-6')),
				array(array('2', '-2'), array('-4')),
				array(array('1', '-2'), array('-2')),
				array(array('1', '-1'), array('-1')),
				array(array('0', '-2'), array('0')),
				array(array('-2', '0'), array('0')),
				array(array('-1', '1'), array('-1')),
				array(array('-2', '1'), array('-2')),
				array(array('-2', '2'), array('-4')),
				array(array('-2', '3'), array('-6')),
				array(array('-3', '-2'), array('6')),
				array(array('-2', '-2'), array('4')),
				array(array('-1', '-2'), array('2')),
				array(array('-1', '-1'), array('1')),
				array(array('-2', '-1'), array('2')),
				array(array('-2', '-2'), array('4')),
				array(array('-2', '-3'), array('6')),
			);
			return $data;
		}

		/**
		 * This method tests the "multiply" method.
		 *
		 * @dataProvider data_multiply
		 */
		public function test_multiply(array $provided, array $expected) {
			$p0 = IInteger\Module::multiply(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "negate" method.
		 *
		 * @return array
		 */
		public function data_negate() {
			$data = array(
				array(array('2'), array('-2')),
				array(array('1'), array('-1')),
				array(array('0'), array('0')),
				array(array('-1'), array('1')),
				array(array('-2'), array('2')),
			);
			return $data;
		}

		/**
		 * This method tests the "negate" method.
		 *
		 * @dataProvider data_negate
		 */
		public function test_negate(array $provided, array $expected) {
			$p0 = IInteger\Module::negate(IInteger\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "pow" method.
		 *
		 * @return array
		 */
		public function data_pow() {
			$data = array(
				array(array('3', 2), array('9')),
				array(array('2', 2), array('4')),
				array(array('1', 2), array('1')),
				array(array('0', 2), array('0')),
				array(array('-1', 2), array('1')),
				array(array('-2', 2), array('4')),
				array(array('-3', 2), array('9')),
				array(array('3', 3), array('27')),
			);
			return $data;
		}

		/**
		 * This method tests the "pow" method.
		 *
		 * @dataProvider data_pow
		 */
		public function test_pow(array $provided, array $expected) {
			$p0 = IInteger\Module::pow(IInteger\Type::box($provided[0]), IInt32\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method tests the "random" method.
		 */
		public function test_random() {
			$p0 = IInteger\Module::random();
			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
		}

		/**
		 * This method provides the data for testing the "subtract" method.
		 *
		 * @return array
		 */
		public function data_subtract() {
			$data = array(
				array(array('2', '1'), array('1')),
				array(array('1', '1'), array('0')),
				array(array('1', '0'), array('1')),
				array(array('-1', '0'), array('-1')),
				array(array('-1', '1'), array('-2')),
				array(array('0', '-1'), array('1')),
				array(array('1', '-1'), array('2')),
			);
			return $data;
		}

		/**
		 * This method tests the "subtract" method.
		 *
		 * @dataProvider data_subtract
		 */
		public function test_subtract(array $provided, array $expected) {
			$p0 = IInteger\Module::subtract(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

		#region Methods -> Basic Operations

		/**
		 * This method provides the data for testing the "sequence" method.
		 *
		 * @return array
		 */
		public function data_sequence() {
			$data = array(
				array(array('0', '4'), array(array('0', '1', '2', '3', '4'))),
				array(array('1', '4'), array(array('1', '2', '3', '4'))),
				array(array('1', '5'), array(array('1', '2', '3', '4', '5'))),
				array(array('1', array('2', '9')), array(array('1', '3', '5', '7', '9'))),
			);
			return $data;
		}

		/**
		 * This method tests the "sequence" method.
		 *
		 * @dataProvider data_sequence
		 */
		public function test_sequence(array $provided, array $expected) {
			$this->markTestIncomplete();

			if (is_array($provided[1])) {
				$p0 = IInteger\Module::sequence(IInteger\Type::box($provided[0]), ITuple\Type::box(array_map(function(int $item) : IInteger\Type {
					return IInteger\Type::box($item);
				}, $provided[1])));
				$e0 = $expected[0];
			}
			else {
				$p0 = IInteger\Module::sequence(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
				$e0 = $expected[0];
			}
			$this->assertInstanceOf('\\Saber\\Data\\IArrayList\\Type', $p0);
			$this->assertEquals($e0, $p0->unbox(1));
		}

		/**
		 * This method provides the data for testing the "signum" method.
		 *
		 * @return array
		 */
		public function data_signum() {
			$data = array(
				array(array('1', '0'), array(1)),
				array(array('0', '0'), array(0)),
				array(array('-1', '0'), array(-1)),
			);
			return $data;
		}

		/**
		 * This method tests the "signum" method.
		 *
		 * @dataProvider data_signum
		 */
		public function test_signum(array $provided, array $expected) {
			$p0 = IInteger\Module::signum(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ITrit\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method tests the "nvl" method.
		 */
		public function test_nvl() {
			$x = IInteger\Type::one();
			$y = IInteger\Type::zero();

			$z = IInteger\Module::nvl($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $z);
			$this->assertSame('1', $z->unbox());

			$z = IInteger\Module::nvl(null, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $z);
			$this->assertSame('1', $z->unbox());

			$z = IInteger\Module::nvl(null, null);
			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $z);
			$this->assertSame('0', $z->unbox());
		}

		/**
		 * This method provides the data for testing the "toDouble" method.
		 *
		 * @return array
		 */
		public function data_toDouble() {
			$data = array(
				array(array('1'), array(1.0)),
				array(array('0'), array(0.0)),
				array(array('-1'), array(-1.0)),
			);
			return $data;
		}

		/**
		 * This method tests the "toDouble" method.
		 *
		 * @dataProvider data_toDouble
		 */
		public function test_toDouble(array $provided, array $expected) {
			$p0 = IInteger\Module::toDouble(IInteger\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IDouble\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "toFloat" method.
		 *
		 * @return array
		 */
		public function data_toFloat() {
			$data = array(
				array(array('1'), array(1.0)),
				array(array('0'), array(0.0)),
				array(array('-1'), array(-1.0)),
			);
			return $data;
		}

		/**
		 * This method tests the "toFloat" method.
		 *
		 * @dataProvider data_toFloat
		 */
		public function test_toFloat(array $provided, array $expected) {
			$p0 = IInteger\Module::toFloat(IInteger\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IFloat\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "toInt32" method.
		 *
		 * @return array
		 */
		public function data_toInt32() {
			$data = array(
				array(array('1'), array(1)),
				array(array('0'), array(0)),
				array(array('-1'), array(-1)),
			);
			return $data;
		}

		/**
		 * This method tests the "toInt32" method.
		 *
		 * @dataProvider data_toInt32
		 */
		public function test_toInt32(array $provided, array $expected) {
			$p0 = IInteger\Module::toInt32(IInteger\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "toInteger" method.
		 *
		 * @return array
		 */
		public function data_toInteger() {
			$data = array(
				array(array('1'), array('1')),
				array(array('0'), array('0')),
				array(array('-1'), array('-1')),
			);
			return $data;
		}

		/**
		 * This method tests the "toInteger" method.
		 *
		 * @dataProvider data_toInteger
		 */
		public function test_toInteger(array $provided, array $expected) {
			$p0 = IInteger\Module::toInteger(IInteger\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method provides the data for testing the "eq" method.
		 *
		 * @return array
		 */
		public function data_eq() {
			$data = array(
				array(array('2', '1'), array(false)),
				array(array('1', '1'), array(true)),
				array(array('1', '0'), array(false)),
				array(array('0', '0'), array(true)),
				array(array('-1', '0'), array(false)),
				array(array('-1', '1'), array(false)),
				array(array('-1', '-1'), array(true)),
				array(array('-1', '-2'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "eq" method.
		 *
		 * @dataProvider data_eq
		 */
		public function test_eq(array $provided, array $expected) {
			$p0 = IInteger\Module::eq(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "id" method.
		 *
		 * @return array
		 */
		public function data_id() {
			$data = array(
				array(array('2', '1'), array(false)),
				array(array('1', '1'), array(true)),
				array(array('1', '0'), array(false)),
				array(array('0', '0'), array(true)),
				array(array('-1', '0'), array(false)),
				array(array('-1', '1'), array(false)),
				array(array('-1', '-1'), array(true)),
				array(array('-1', '-2'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "id" method.
		 *
		 * @dataProvider data_id
		 */
		public function test_id(array $provided, array $expected) {
			$p0 = IInteger\Module::id(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "ne" method.
		 *
		 * @return array
		 */
		public function data_ne() {
			$data = array(
				array(array('2', '1'), array(true)),
				array(array('1', '1'), array(false)),
				array(array('1', '0'), array(true)),
				array(array('0', '0'), array(false)),
				array(array('-1', '0'), array(true)),
				array(array('-1', '1'), array(true)),
				array(array('-1', '-1'), array(false)),
				array(array('-1', '-2'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "ne" method.
		 *
		 * @dataProvider data_ne
		 */
		public function test_ne(array $provided, array $expected) {
			$p0 = IInteger\Module::ne(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "ni" method.
		 *
		 * @return array
		 */
		public function data_ni() {
			$data = array(
				array(array('2', '1'), array(true)),
				array(array('1', '1'), array(false)),
				array(array('1', '0'), array(true)),
				array(array('0', '0'), array(false)),
				array(array('-1', '0'), array(true)),
				array(array('-1', '1'), array(true)),
				array(array('-1', '-1'), array(false)),
				array(array('-1', '-2'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "ni" method.
		 *
		 * @dataProvider data_ni
		 */
		public function test_ni(array $provided, array $expected) {
			$p0 = IInteger\Module::ni(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method provides the data for testing the "compare" method.
		 *
		 * @return array
		 */
		public function data_compare() {
			$data = array(
				array(array('1', '0'), array(1)),
				array(array('1', '1'), array(0)),
				array(array('0', '1'), array(-1)),
			);
			return $data;
		}

		/**
		 * This method tests the "compare" method.
		 *
		 * @dataProvider data_compare
		 */
		public function test_compare(array $provided, array $expected) {
			$p0 = IInteger\Module::compare(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\ITrit\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "ge" method.
		 *
		 * @return array
		 */
		public function data_ge() {
			$data = array(
				array(array('1', '0'), array(true)),
				array(array('0', '0'), array(true)),
				array(array('-1', '0'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "ge" method.
		 *
		 * @dataProvider data_ge
		 */
		public function test_ge(array $provided, array $expected) {
			$p0 = IInteger\Module::ge(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "gt" method.
		 *
		 * @return array
		 */
		public function data_gt() {
			$data = array(
				array(array('1', '0'), array(true)),
				array(array('0', '0'), array(false)),
				array(array('-1', '0'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "gt" method.
		 *
		 * @dataProvider data_gt
		 */
		public function test_gt(array $provided, array $expected) {
			$p0 = IInteger\Module::gt(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "le" method.
		 *
		 * @return array
		 */
		public function data_le() {
			$data = array(
				array(array('1', '0'), array(false)),
				array(array('0', '0'), array(true)),
				array(array('-1', '0'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "le" method.
		 *
		 * @dataProvider data_le
		 */
		public function test_le(array $provided, array $expected) {
			$p0 = IInteger\Module::le(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "lt" method.
		 *
		 * @return array
		 */
		public function data_lt() {
			$data = array(
				array(array('1', '0'), array(false)),
				array(array('0', '0'), array(false)),
				array(array('-1', '0'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "lt" method.
		 *
		 * @dataProvider data_lt
		 */
		public function test_lt(array $provided, array $expected) {
			$p0 = IInteger\Module::lt(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "max" method.
		 *
		 * @return array
		 */
		public function data_max() {
			$data = array(
				array(array('1', '0'), array('1')),
				array(array('0', '0'), array('0')),
				array(array('-1', '0'), array('0')),
			);
			return $data;
		}

		/**
		 * This method tests the "max" method.
		 *
		 * @dataProvider data_max
		 */
		public function test_max(array $provided, array $expected) {
			$p0 = IInteger\Module::max(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "min" method.
		 *
		 * @return array
		 */
		public function data_min() {
			$data = array(
				array(array('1', '0'), array('0')),
				array(array('0', '0'), array('0')),
				array(array('-1', '0'), array('-1')),
			);
			return $data;
		}

		/**
		 * This method tests the "min" method.
		 *
		 * @dataProvider data_min
		 */
		public function test_min(array $provided, array $expected) {
			$p0 = IInteger\Module::min(IInteger\Type::box($provided[0]), IInteger\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

		#region Methods -> Evaluating Operations

		/**
		 * This method provides the data for testing the "isEven" method.
		 *
		 * @return array
		 */
		public function data_isEven() {
			$data = array(
				array(array('4'), array(true)),
				array(array('3'), array(false)),
				array(array('2'), array(true)),
				array(array('1'), array(false)),
				array(array('0'), array(true)),
				array(array('-1'), array(false)),
				array(array('-2'), array(true)),
				array(array('-3'), array(false)),
				array(array('-4'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "isEven" method.
		 *
		 * @dataProvider data_isEven
		 */
		public function test_isEven(array $provided, array $expected) {
			$this->markTestIncomplete();

			$p0 = IInteger\Module::isEven(IInteger\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isNegative" method.
		 *
		 * @return array
		 */
		public function data_isNegative() {
			$data = array(
				array(array('1'), array(false)),
				array(array('0'), array(false)),
				array(array('-1'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "isNegative" method.
		 *
		 * @dataProvider data_isNegative
		 */
		public function test_isNegative(array $provided, array $expected) {
			$p0 = IInteger\Module::isNegative(IInteger\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isOdd" method.
		 *
		 * @return array
		 */
		public function data_isOdd() {
			$data = array(
				array(array('4'), array(false)),
				array(array('3'), array(true)),
				array(array('2'), array(false)),
				array(array('1'), array(true)),
				array(array('0'), array(false)),
				array(array('-1'), array(true)),
				array(array('-2'), array(false)),
				array(array('-3'), array(true)),
				array(array('-4'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isOdd" method.
		 *
		 * @dataProvider data_isOdd
		 */
		public function test_isOdd(array $provided, array $expected) {
			$this->markTestIncomplete();

			$p0 = IInteger\Module::isOdd(IInteger\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

	}

}