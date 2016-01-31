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

namespace Saber\Data\IChar {

	use \Saber\Core;
	use \Saber\Data\IChar;

	/**
	 * @group ModuleTest
	 */
	final class ModuleTest extends Core\ModuleTest {

		#region Methods -> Conversion Operations

		/**
		 * This method tests the "nvl" method.
		 */
		public function test_nvl() {
			$x = IChar\Type::box('x');
			$y = IChar\Type::box('y');

			$z = IChar\Module::nvl($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IChar\\Type', $z);
			$this->assertSame('x', $z->unbox());

			$z = IChar\Module::nvl(null, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IChar\\Type', $z);
			$this->assertSame('x', $z->unbox());

			$z = IChar\Module::nvl(null, null);
			$this->assertInstanceOf('\\Saber\\Data\\IChar\\Type', $z);
			$this->assertSame(chr(0), $z->unbox());
		}

		/**
		 * This method provides the data for testing the "toInt32" method.
		 *
		 * @return array
		 */
		public function data_toInt32() {
			$data = array(
				array(array('a'), array(97)),
			);
			return $data;
		}

		/**
		 * This method tests the "toInt32" method.
		 *
		 * @dataProvider data_toInt32
		 */
		public function test_toInt32(array $provided, array $expected) {
			$p0 = IChar\Module::toInt32(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "toLowerCase" method.
		 *
		 * @return array
		 */
		public function data_toLowerCase() {
			$data = array(
				array(array('a'), array('a')),
				array(array('A'), array('a')),
			);
			return $data;
		}

		/**
		 * This method tests the "toLowerCase" method.
		 *
		 * @dataProvider data_toLowerCase
		 */
		public function test_toLowerCase(array $provided, array $expected) {
			$p0 = IChar\Module::toLowerCase(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IChar\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "toUpperCase" method.
		 *
		 * @return array
		 */
		public function data_toUpperCase() {
			$data = array(
				array(array('a'), array('A')),
				array(array('A'), array('A')),
			);
			return $data;
		}

		/**
		 * This method tests the "toUpperCase" method.
		 *
		 * @dataProvider data_toUpperCase
		 */
		public function test_toUpperCase(array $provided, array $expected) {
			$p0 = IChar\Module::toUpperCase(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IChar\\Type', $p0);
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
				array(array('a', 'b'), array(false)),
				array(array('b', 'b'), array(true)),
				array(array('c', 'b'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "eq" method.
		 *
		 * @dataProvider data_eq
		 */
		public function test_eq(array $provided, array $expected) {
			$p0 = IChar\Module::eq(IChar\Type::box($provided[0]), IChar\Type::box($provided[1]));
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
				array(array('a', 'b'), array(false)),
				array(array('b', 'b'), array(true)),
				array(array('c', 'b'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "id" method.
		 *
		 * @dataProvider data_id
		 */
		public function test_id(array $provided, array $expected) {
			$p0 = IChar\Module::id(IChar\Type::box($provided[0]), IChar\Type::box($provided[1]));
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
				array(array('a', 'b'), array(true)),
				array(array('b', 'b'), array(false)),
				array(array('c', 'b'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "ne" method.
		 *
		 * @dataProvider data_ne
		 */
		public function test_ne(array $provided, array $expected) {
			$p0 = IChar\Module::ne(IChar\Type::box($provided[0]), IChar\Type::box($provided[1]));
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
				array(array('a', 'b'), array(true)),
				array(array('b', 'b'), array(false)),
				array(array('c', 'b'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "ni" method.
		 *
		 * @dataProvider data_ni
		 */
		public function test_ni(array $provided, array $expected) {
			$p0 = IChar\Module::ni(IChar\Type::box($provided[0]), IChar\Type::box($provided[1]));
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
				array(array('a', 'b'), array(-1)),
				array(array('b', 'b'), array(0)),
				array(array('c', 'b'), array(1)),
			);
			return $data;
		}

		/**
		 * This method tests the "compare" method.
		 *
		 * @dataProvider data_compare
		 */
		public function test_compare(array $provided, array $expected) {
			$p0 = IChar\Module::compare(IChar\Type::box($provided[0]), IChar\Type::box($provided[1]));
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
				array(array('a', 'b'), array(false)),
				array(array('b', 'b'), array(true)),
				array(array('c', 'b'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "ge" method.
		 *
		 * @dataProvider data_ge
		 */
		public function test_ge(array $provided, array $expected) {
			$p0 = IChar\Module::ge(IChar\Type::box($provided[0]), IChar\Type::box($provided[1]));
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
				array(array('a', 'b'), array(false)),
				array(array('b', 'b'), array(false)),
				array(array('c', 'b'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "gt" method.
		 *
		 * @dataProvider data_gt
		 */
		public function test_gt(array $provided, array $expected) {
			$p0 = IChar\Module::gt(IChar\Type::box($provided[0]), IChar\Type::box($provided[1]));
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
				array(array('a', 'b'), array(true)),
				array(array('b', 'b'), array(true)),
				array(array('c', 'b'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "le" method.
		 *
		 * @dataProvider data_le
		 */
		public function test_le(array $provided, array $expected) {
			$p0 = IChar\Module::le(IChar\Type::box($provided[0]), IChar\Type::box($provided[1]));
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
				array(array('a', 'b'), array(true)),
				array(array('b', 'b'), array(false)),
				array(array('c', 'b'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "lt" method.
		 *
		 * @dataProvider data_lt
		 */
		public function test_lt(array $provided, array $expected) {
			$p0 = IChar\Module::lt(IChar\Type::box($provided[0]), IChar\Type::box($provided[1]));
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
				array(array('a', 'b'), array('b')),
				array(array('b', 'b'), array('b')),
				array(array('c', 'b'), array('c')),
			);
			return $data;
		}

		/**
		 * This method tests the "max" method.
		 *
		 * @dataProvider data_max
		 */
		public function test_max(array $provided, array $expected) {
			$p0 = IChar\Module::max(IChar\Type::box($provided[0]), IChar\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IChar\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "min" method.
		 *
		 * @return array
		 */
		public function data_min() {
			$data = array(
				array(array('a', 'b'), array('a')),
				array(array('b', 'b'), array('b')),
				array(array('c', 'b'), array('b')),
			);
			return $data;
		}

		/**
		 * This method tests the "min" method.
		 *
		 * @dataProvider data_min
		 */
		public function test_min(array $provided, array $expected) {
			$p0 = IChar\Module::min(IChar\Type::box($provided[0]), IChar\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IChar\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

		#region Methods -> Evaluating Operations

		/**
		 * This method provides the data for testing the "isAlpha" method.
		 *
		 * @return array
		 */
		public function data_isAlpha() {
			$data = array(
				array(array('a'), array(true)),
				array(array('z'), array(true)),
				array(array('A'), array(true)),
				array(array('Z'), array(true)),
				array(array('0'), array(false)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isAlpha" method.
		 *
		 * @dataProvider data_isAlpha
		 */
		public function test_isAlpha(array $provided, array $expected) {
			$p0 = IChar\Module::isAlpha(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isAlphaNum" method.
		 *
		 * @return array
		 */
		public function data_isAlphaNum() {
			$data = array(
				array(array('a'), array(true)),
				array(array('z'), array(true)),
				array(array('A'), array(true)),
				array(array('Z'), array(true)),
				array(array('0'), array(true)),
				array(array('9'), array(true)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isAlphaNum" method.
		 *
		 * @dataProvider data_isAlphaNum
		 */
		public function test_isAlphaNum(array $provided, array $expected) {
			$p0 = IChar\Module::isAlphaNum(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isAscii" method.
		 *
		 * @return array
		 */
		public function data_isAscii() {
			$data = array(
				array(array('a'), array(true)),
				array(array('z'), array(true)),
				array(array('A'), array(true)),
				array(array('Z'), array(true)),
				array(array('0'), array(true)),
				array(array('9'), array(true)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isAscii" method.
		 *
		 * @dataProvider data_isAscii
		 */
		public function test_isAscii(array $provided, array $expected) {
			$p0 = IChar\Module::isAscii(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isControl" method.
		 *
		 * @return array
		 */
		public function data_isControl() {
			$data = array(
				array(array(chr(0)), array(true)),
				array(array("\n"), array(true)),
				array(array('a'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isControl" method.
		 *
		 * @dataProvider data_isControl
		 */
		public function test_isControl(array $provided, array $expected) {
			$p0 = IChar\Module::isControl(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isCyrillic" method.
		 *
		 * @return array
		 */
		public function data_isCyrillic() {
			$data = array(
				array(array('Д'), array(true)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(false)),
				array(array('a'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isCyrillic" method.
		 *
		 * @dataProvider data_isCyrillic
		 */
		public function test_isCyrillic(array $provided, array $expected) {
			$p0 = IChar\Module::isCyrillic(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isDigit" method.
		 *
		 * @return array
		 */
		public function data_isDigit() {
			$data = array(
				array(array('0'), array(true)),
				array(array('1'), array(true)),
				array(array('2'), array(true)),
				array(array('3'), array(true)),
				array(array('4'), array(true)),
				array(array('5'), array(true)),
				array(array('6'), array(true)),
				array(array('7'), array(true)),
				array(array('8'), array(true)),
				array(array('9'), array(true)),
				array(array('a'), array(false)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isDigit" method.
		 *
		 * @dataProvider data_isDigit
		 */
		public function test_isDigit(array $provided, array $expected) {
			$p0 = IChar\Module::isDigit(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isHexDigit" method.
		 *
		 * @return array
		 */
		public function data_isHexDigit() {
			$data = array(
				array(array('0'), array(true)),
				array(array('1'), array(true)),
				array(array('2'), array(true)),
				array(array('3'), array(true)),
				array(array('4'), array(true)),
				array(array('5'), array(true)),
				array(array('6'), array(true)),
				array(array('7'), array(true)),
				array(array('8'), array(true)),
				array(array('9'), array(true)),
				array(array('A'), array(true)),
				array(array('B'), array(true)),
				array(array('C'), array(true)),
				array(array('D'), array(true)),
				array(array('E'), array(true)),
				array(array('F'), array(true)),
				array(array('a'), array(true)),
				array(array('b'), array(true)),
				array(array('c'), array(true)),
				array(array('d'), array(true)),
				array(array('e'), array(true)),
				array(array('f'), array(true)),
				array(array('Z'), array(false)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isHexDigit" method.
		 *
		 * @dataProvider data_isHexDigit
		 */
		public function test_isHexDigit(array $provided, array $expected) {
			$p0 = IChar\Module::isHexDigit(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isLatin1" method.
		 *
		 * @return array
		 */
		public function data_isLatin1() {
			$data = array(
				array(array('0'), array(false)),
				array(array('9'), array(false)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(false)),
				array(array('a'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "isLatin1" method.
		 *
		 * @dataProvider data_isLatin1
		 */
		public function test_isLatin1(array $provided, array $expected) {
			$p0 = IChar\Module::isLatin1(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isLowerCase" method.
		 *
		 * @return array
		 */
		public function data_isLowerCase() {
			$data = array(
				array(array('a'), array(true)),
				array(array('z'), array(true)),
				array(array('A'), array(false)),
				array(array('Z'), array(false)),
				array(array('0'), array(false)),
				array(array('9'), array(false)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isLowerCase" method.
		 *
		 * @dataProvider data_isLowerCase
		 */
		public function test_isLowerCase(array $provided, array $expected) {
			$p0 = IChar\Module::isLowerCase(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isNumber" method.
		 *
		 * @return array
		 */
		public function data_isNumber() {
			$data = array(
				array(array('0'), array(true)),
				array(array('9'), array(true)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(false)),
				array(array('a'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isNumber" method.
		 *
		 * @dataProvider data_isNumber
		 */
		public function test_isNumber(array $provided, array $expected) {
			$p0 = IChar\Module::isNumber(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isOctDigit" method.
		 *
		 * @return array
		 */
		public function data_isOctDigit() {
			$data = array(
				array(array('0'), array(true)),
				array(array('1'), array(true)),
				array(array('2'), array(true)),
				array(array('3'), array(true)),
				array(array('4'), array(true)),
				array(array('5'), array(true)),
				array(array('6'), array(true)),
				array(array('7'), array(true)),
				array(array('8'), array(false)),
				array(array('a'), array(false)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isOctDigit" method.
		 *
		 * @dataProvider data_isOctDigit
		 */
		public function test_isOctDigit(array $provided, array $expected) {
			$p0 = IChar\Module::isOctDigit(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isPrintable" method.
		 *
		 * @return array
		 */
		public function data_isPrintable() {
			$data = array(
				array(array('a'), array(true)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isPrintable" method.
		 *
		 * @dataProvider data_isPrintable
		 */
		public function test_isPrintable(array $provided, array $expected) {
			$p0 = IChar\Module::isPrintable(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isPunctuation" method.
		 *
		 * @return array
		 */
		public function data_isPunctuation() {
			$data = array(
				array(array('.'), array(true)),
				array(array('a'), array(false)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isPunctuation" method.
		 *
		 * @dataProvider data_isPunctuation
		 */
		public function test_isPunctuation(array $provided, array $expected) {
			$p0 = IChar\Module::isPunctuation(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isSeparator" method.
		 *
		 * @return array
		 */
		public function data_isSeparator() {
			$data = array(
				array(array(' '), array(true)),
				array(array('a'), array(false)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isSeparator" method.
		 *
		 * @dataProvider data_isSeparator
		 */
		public function test_isSeparator(array $provided, array $expected) {
			$p0 = IChar\Module::isSeparator(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isSpace" method.
		 *
		 * @return array
		 */
		public function data_isSpace() {
			$data = array(
				array(array(' '), array(true)),
				array(array('a'), array(false)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the "isSpace" method.
		 *
		 * @dataProvider data_isSpace
		 */
		public function test_isSpace(array $provided, array $expected) {
			$p0 = IChar\Module::isSpace(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isSymbol" method.
		 *
		 * @return array
		 */
		public function data_isSymbol() {
			$data = array(
				array(array('$'), array(true)),
				array(array('+'), array(true)),
				array(array('a'), array(false)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isSymbol" method.
		 *
		 * @dataProvider data_isSymbol
		 */
		public function test_isSymbol(array $provided, array $expected) {
			$p0 = IChar\Module::isSymbol(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the "isUpperCase" method.
		 *
		 * @return array
		 */
		public function data_isUpperCase() {
			$data = array(
				array(array('a'), array(false)),
				array(array('z'), array(false)),
				array(array('A'), array(true)),
				array(array('Z'), array(true)),
				array(array('0'), array(false)),
				array(array('9'), array(false)),
				array(array(chr(0)), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the "isUpperCase" method.
		 *
		 * @dataProvider data_isUpperCase
		 */
		public function test_isUpperCase(array $provided, array $expected) {
			$p0 = IChar\Module::isUpperCase(IChar\Type::box($provided[0]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

	}

}