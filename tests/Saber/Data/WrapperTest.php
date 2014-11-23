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
	 * @group AnyRef
	 */
	class WrapperTest extends Core\AnyTest {

		/**
		 * This method provides the data for testing the boxing of a value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array(1), array(1)),
				array(array(null), array(null)),
				array(array(''), array('')),
				array(array(new \stdClass()), array(new \stdClass())),
			);
			return $data;
		}

		/**
		 * This method tests the boxing of a value.
		 *
		 * @dataProvider dataBox
		 */
		public function testBox($provided, $expected) {
			$p0 = Object\Type::box($provided[0]);
			$e0 = new Data\Object($expected[0]);

			$this->assertInstanceOf('\\Saber\\Core\\AnyRef', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Wrapper', $p0);
			$this->assertEquals($e0, $p0);
			$this->assertTrue($e0->__equals($p0));

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			if (is_object($p1)) {
				$this->assertInstanceOf(get_class($e1), $p1);
			}
			else {
				$this->assertInternalType(strtolower(gettype($e1)), $p1);
			}

			$this->assertEquals($e1, $p1);
		}

		/**
		 * This method tests the ability to make a choice.
		 */
		public function testChoice() {
			$x = Object\Type::box(null);

			$p0 = $x->choice();

			$this->assertInstanceOf('\\Saber\\Control\\Monad\\Choice', $p0);

			$p1 = $x->choice()->when(Object\Type::box(null), function(Object\Type $x) {})->end()->unbox();

			$this->assertInternalType('boolean', $p1);
			$this->assertTrue($p1);

			$p2 = $x->choice()->when(Object\Type::box(1), function(Object\Type $x) {})->end()->unbox();

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
				array(array(1, null), array(0)),
				array(array(null, null), array(0)),
				array(array(null, 1), array(0)),
			);
			return $data;
		}

		/**
		 * This method tests the evaluation of one value compared to another.
		 *
		 * @dataProvider dataCompareTo
		 */
		public function testCompareTo($provided, $expected) {
			$p0 = Object\Type::box($provided[0])->compareTo(Object\Type::box($provided[1]));
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\Int32', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method provides the data for testing the ability to show a value.
		 *
		 * @return array
		 */
		public function dataShow() {
			$data = array(
				array(array(null), array('N;')),
				array(array(''), array('s:0:"";')),
				array(array(0), array('i:0;')),
				array(array(array()), array('a:0:{}')),
			);
			return $data;
		}

		/**
		 * This method tests the ability to show a value.
		 *
		 * @dataProvider dataShow
		 */
		public function testShow($provided, $expected) {
			$p0 = Object\Type::box($provided[0]);
			$e0 = $expected[0];

			$this->expectOutputString($e0);
			$p1 = $p0->show();

			$this->assertInstanceOf('\\Saber\\Data\\Wrapper', $p1);
		}

		/**
		 * This method provides the data for testing that a value is converted to a string.
		 *
		 * @return array
		 */
		public function dataToString() {
			$data = array(
				array(array(null), array('N;')),
				array(array(''), array('s:0:"";')),
				array(array(0), array('i:0;')),
				array(array(array()), array('a:0:{}')),
			);
			return $data;
		}

		/**
		 * This method tests that a value is converted to a string.
		 *
		 * @dataProvider dataToString
		 */
		public function testToString($provided, $expected) {
			$p0 = Object\Type::box($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

	}

}