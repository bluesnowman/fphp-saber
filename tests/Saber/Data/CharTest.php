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

namespace Saber\Data {

	use \Saber\Core;
	use \Saber\Data;

	/**
	 * @group AnyVal
	 */
	class CharTest extends Core\AnyTest {

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array('a'), array('a')),
				array(array("\n"), array("\n")),
				array(array(97), array('a')),
			);
			return $data;
		}

		/**
		 * This method tests the boxing of a value.
		 *
		 * @dataProvider dataBox
		 */
		public function testBox($provided, $expected) {
			$p0 = Data\Char::box($provided[0]);
			$e0 = new Data\Char($expected[0], 'UTF-8');

			$this->assertInstanceOf('\\Saber\\Core\\AnyVal', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Char', $p0);
			$this->assertEquals($e0, $p0);
			$this->assertTrue($e0->__equals($p0));
			$this->assertTrue($e0->__identical($p0));

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			$this->assertInternalType('string', $p1);
			$this->assertSame($e1, $p1);
		}

		/**
		 * This method tests the ability to make a choice.
		 */
		public function testChoice() {
			$x = Data\Char::box('m');

			$p0 = $x->choice();

			$this->assertInstanceOf('\\Saber\\Control\\Monad\\Choice', $p0);

			$p1 = $x->choice()->when(Data\Char::box('m'), function(Data\Char $x) {})->end()->unbox();

			$this->assertInternalType('boolean', $p1);
			$this->assertTrue($p1);

			$p2 = $x->choice()->when(Data\Char::box('z'), function(Data\Char $x) {})->end()->unbox();

			$this->assertInternalType('boolean', $p2);
			$this->assertFalse($p2);
		}

		/**
		 * This method provides the data for testing the evaluation of one value compared to another.
		 *
		 * @return array
		 */
		public function dataCompareTo() {
			$data = array(
				array(array('a', 'b'), array(-1)),
				array(array('b', 'b'), array(0)),
				array(array('c', 'b'), array(1)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of one value compared to another.
		 *
		 * @dataProvider dataCompareTo
		 */
		public function testCompareTo($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->compareTo(Data\Char::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Int32', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is an alpha character.
		 *
		 * @return array
		 */
		public function dataIsAlpha() {
			$data = array(
				array(array('a'), array(true)),
				array(array('z'), array(true)),
				array(array('A'), array(true)),
				array(array('Z'), array(true)),
				array(array('0'), array(false)),
				array(array(0), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is an alpha character.
		 *
		 * @dataProvider dataIsAlpha
		 */
		public function testIsAlpha($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isAlpha();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is an alphanumeric character.
		 *
		 * @return array
		 */
		public function dataIsAlphaNum() {
			$data = array(
				array(array('a'), array(true)),
				array(array('z'), array(true)),
				array(array('A'), array(true)),
				array(array('Z'), array(true)),
				array(array('0'), array(true)),
				array(array('9'), array(true)),
				array(array(0), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is an alphanumeric character.
		 *
		 * @dataProvider dataIsAlphaNum
		 */
		public function testIsAlphaNum($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isAlphaNum();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is an ascii character.
		 *
		 * @return array
		 */
		public function dataIsAscii() {
			$data = array(
				array(array('a'), array(true)),
				array(array('z'), array(true)),
				array(array('A'), array(true)),
				array(array('Z'), array(true)),
				array(array('0'), array(true)),
				array(array('9'), array(true)),
				array(array(0), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is an ascii character.
		 *
		 * @dataProvider dataIsAscii
		 */
		public function testIsAscii($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isAscii();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is a control character.
		 *
		 * @return array
		 */
		public function dataIsControl() {
			$data = array(
				array(array(0), array(true)),
				array(array("\n"), array(true)),
				array(array('a'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is a control character.
		 *
		 * @dataProvider dataIsControl
		 */
		public function testIsControl($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isControl();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is a Cyrillic character.
		 *
		 * @return array
		 */
		public function dataIsCyrillic() {
			$data = array(
				array(array('Д'), array(true)),
				array(array(0), array(false)),
				array(array("\n"), array(false)),
				array(array('a'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is a Cyrillic character.
		 *
		 * @dataProvider dataIsCyrillic
		 */
		public function testIsCyrillic($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isCyrillic();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is a digit.
		 *
		 * @return array
		 */
		public function dataIsDigit() {
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
				array(array(0), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is a digit.
		 *
		 * @dataProvider dataIsDigit
		 */
		public function testIsHexadecimal($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isDigit();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is a hex-digit.
		 *
		 * @return array
		 */
		public function dataIsHexDigit() {
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
				array(array(0), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is a hex-digit.
		 *
		 * @dataProvider dataIsHexDigit
		 */
		public function testIsHexDigit($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isHexDigit();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is an ISO 8859-1 (Latin-1) character.
		 *
		 * @return array
		 */
		public function dataIsLatin1() {
			$data = array(
				array(array('0'), array(false)),
				array(array('9'), array(false)),
				array(array(0), array(false)),
				array(array("\n"), array(false)),
				array(array('a'), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is an ISO 8859-1 (Latin-1) character.
		 *
		 * @dataProvider dataIsLatin1
		 */
		public function testIsLatin1($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isLatin1();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is a lowercase character.
		 *
		 * @return array
		 */
		public function dataIsLowerCase() {
			$data = array(
				array(array('a'), array(true)),
				array(array('z'), array(true)),
				array(array('A'), array(false)),
				array(array('Z'), array(false)),
				array(array('0'), array(false)),
				array(array('9'), array(false)),
				array(array(0), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is a lowercase character.
		 *
		 * @dataProvider dataIsLowerCase
		 */
		public function testIsLowerCase($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isLowerCase();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is a number.
		 *
		 * @return array
		 */
		public function dataIsNumber() {
			$data = array(
				array(array('0'), array(true)),
				array(array('9'), array(true)),
				array(array(0), array(false)),
				array(array("\n"), array(false)),
				array(array('a'), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is a number.
		 *
		 * @dataProvider dataIsNumber
		 */
		public function testIsNumber($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isNumber();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is an oct-digit.
		 *
		 * @return array
		 */
		public function dataIsOctDigit() {
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
				array(array(0), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is an oct-digit.
		 *
		 * @dataProvider dataIsOctDigit
		 */
		public function testIsOctDigit($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isOctDigit();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is a printable character.
		 *
		 * @return array
		 */
		public function dataIsPrintable() {
			$data = array(
				array(array('a'), array(true)),
				array(array(0), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is a printable character.
		 *
		 * @dataProvider dataIsPrintable
		 */
		public function testIsPrintable($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isPrintable();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is a punctuation character.
		 *
		 * @return array
		 */
		public function dataIsPunctuation() {
			$data = array(
				array(array('.'), array(true)),
				array(array('a'), array(false)),
				array(array(0), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is a punctuation character.
		 *
		 * @dataProvider dataIsPunctuation
		 */
		public function testIsPunctuation($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isPunctuation();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is a separator character.
		 *
		 * @return array
		 */
		public function dataIsSeparator() {
			$data = array(
				array(array(' '), array(true)),
				array(array('a'), array(false)),
				array(array(0), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is a separator character.
		 *
		 * @dataProvider dataIsSeparator
		 */
		public function testIsSeparator($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isSeparator();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is a space.
		 *
		 * @return array
		 */
		public function dataIsSpace() {
			$data = array(
				array(array(' '), array(true)),
				array(array('a'), array(false)),
				array(array(0), array(false)),
				array(array("\n"), array(true)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is a space.
		 *
		 * @dataProvider dataIsSpace
		 */
		public function testIsSpace($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isSpace();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is a symbol.
		 *
		 * @return array
		 */
		public function dataIsSymbol() {
			$data = array(
				array(array('$'), array(true)),
				array(array('+'), array(true)),
				array(array('a'), array(false)),
				array(array(0), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is a symbol.
		 *
		 * @dataProvider dataIsSymbol
		 */
		public function testIsSymbol($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isSymbol();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the evaluation of whether a value is an uppercase character.
		 *
		 * @return array
		 */
		public function dataIsUpperCase() {
			$data = array(
				array(array('a'), array(false)),
				array(array('z'), array(false)),
				array(array('A'), array(true)),
				array(array('Z'), array(true)),
				array(array('0'), array(false)),
				array(array('9'), array(false)),
				array(array(0), array(false)),
				array(array("\n"), array(false)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of whether a value is an uppercase character.
		 *
		 * @dataProvider dataIsUpperCase
		 */
		public function testIsUpperCase($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->isUpperCase();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Bool', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the ability to show a value.
		 *
		 * @return array
		 */
		public function dataShow() {
			$data = array(
				array(array('m'), array('m')),
			);
			return $data;
		}

		/**
		 * This method tests the ability to show a value.
		 *
		 * @dataProvider dataShow
		 */
		public function testShow($provided, $expected) {
			$p0 = Data\Char::box($provided[0]);
			$e0 = $expected[0];

			$this->expectOutputString($e0);
			$p1 = $p0->show();

			$this->assertInstanceOf('\\Saber\\Data\\Char', $p1);
		}

		/**
		 * This method provides the data for testing that a value is casted to an int(32).
		 *
		 * @return array
		 */
		public function dataToInt32() {
			$data = array(
				array(array('a'), array(97)),
				array(array(97), array(97)),
			);
			return $data;
		}

		/**
		 * This method tests that a value is casted to an int(32).
		 *
		 * @dataProvider dataToInt32
		 */
		public function testToInt32($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->toInt32();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Int32', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is converted to a lowercase character.
		 *
		 * @return array
		 */
		public function dataToLowerCase() {
			$data = array(
				array(array('a'), array('a')),
				array(array('A'), array('a')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is converted to a lowercase character.
		 *
		 * @dataProvider dataToLowerCase
		 */
		public function testToLowerCase($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->toLowerCase();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Char', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing that a value is converted to a string.
		 *
		 * @return array
		 */
		public function dataToString() {
			$data = array(
				array(array('a'), array('a')),
				array(array("\n"), array("\n")),
				array(array(97), array('a')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is converted to a string.
		 *
		 * @dataProvider dataToString
		 */
		public function testToString($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

		/**
		 * This method provides the data for testing that a value is converted to an uppercase character.
		 *
		 * @return array
		 */
		public function dataToUpperCase() {
			$data = array(
				array(array('a'), array('A')),
				array(array('A'), array('A')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is converted to an uppercase character.
		 *
		 * @dataProvider dataToUpperCase
		 */
		public function testToUpperCase($provided, $expected) {
			$p0 = Data\Char::box($provided[0])->toUpperCase();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Char', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

	}

}