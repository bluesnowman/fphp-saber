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

namespace Saber\Data\IObject {

	use \Saber\Core;
	use \Saber\Data\IObject;

	/**
	 * @group TypeTest
	 */
	final class TypeTest extends Core\TypeTest {

		#region Tests -> Inheritance

		/**
		 * This method tests the "instanceOf" property.
		 */
		public function test_instanceOf() {
			$p0 = new IObject\Type('test');

			$this->assertInstanceOf('\\Saber\\Data\\IObject\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Equality\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Comparable\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Boxable\\Type', $p0);
			$this->assertInstanceOf('\\JsonSerializable', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);
		}

		#endregion

		#region Tests -> Initialization

		/**
		 * This method provides the data for testing the "box" method.
		 *
		 * @return array
		 */
		public function data_box() {
			$data = array(
				array(array(1), array(1)),
				array(array(null), array(null)),
				array(array(''), array('')),
				array(array(new \stdClass()), array(new \stdClass())),
			);
			return $data;
		}

		/**
		 * This method tests the "box" method.
		 *
		 * @dataProvider data_box
		 */
		public function test_box(array $provided, array $expected) {
			$p0 = IObject\Type::box($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\IObject\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			if (is_object($p1)) {
				$this->assertInstanceOf(get_class($e1), $p1);
				$this->assertEquals($e1, $p1);
			}
			else {
				$this->assertInternalType(strtolower(gettype($e1)), $p1);
				$this->assertSame($e1, $p1);
			}
		}

		/**
		 * This method provides the data for testing the "covariant" method.
		 *
		 * @return array
		 */
		public function data_covariant() {
			$data = array(
				array(array(1), array(1)),
				array(array(null), array(null)),
				array(array(''), array('')),
				array(array(new \stdClass()), array(new \stdClass())),
			);
			return $data;
		}

		/**
		 * This method tests the "covariant" method.
		 *
		 * @dataProvider data_covariant
		 */
		public function test_covariant(array $provided, array $expected) {
			$p0 = IObject\Type::covariant(IObject\Type::box($provided[0]));

			$this->assertInstanceOf('\\Saber\\Data\\IObject\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			if (is_object($p1)) {
				$this->assertInstanceOf(get_class($e1), $p1);
				$this->assertEquals($e1, $p1);
			}
			else {
				$this->assertInternalType(strtolower(gettype($e1)), $p1);
				$this->assertSame($e1, $p1);
			}
		}

		/**
		 * This method provides the data for testing the "make" method.
		 *
		 * @return array
		 */
		public function data_make() {
			$data = array(
				array(array(1), array(1)),
				array(array(null), array(null)),
				array(array(''), array('')),
				array(array(new \stdClass()), array(new \stdClass())),
			);
			return $data;
		}

		/**
		 * This method tests the "make" method.
		 *
		 * @dataProvider data_make
		 */
		public function test_make(array $provided, array $expected) {
			$p0 = IObject\Type::make($provided[0]);

			$this->assertInstanceOf('\\Saber\\Data\\IObject\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = $expected[0];

			if (is_object($p1)) {
				$this->assertInstanceOf(get_class($e1), $p1);
				$this->assertEquals($e1, $p1);
			}
			else {
				$this->assertInternalType(strtolower(gettype($e1)), $p1);
				$this->assertSame($e1, $p1);
			}
		}

		#endregion

		#region Tests -> Interface

		/**
		 * This method provides the data for testing the "hashCode" method.
		 *
		 * @return array
		 */
		public function data_hashCode() {
			$data = array(
				array(array(1)),
				array(array(null)),
				array(array('')),
			);
			return $data;
		}

		/**
		 * This method tests the "hashCode" method.
		 *
		 * @dataProvider data_hashCode
		 */
		public function test_hashCode(array $provided) {
			$p0 = IObject\Type::box($provided[0])->__hashCode();

			$this->assertInternalType('string', $p0);
			$this->assertRegExp('/^[0-9a-f]{32}$/', $p0);
		}

		/**
		 * This method provides the data for testing the "toString" method.
		 *
		 * @return array
		 */
		public function data_toString() {
			$data = array(
				array(array(1), array('1')),
				array(array(null), array('null')),
				array(array(''), array('')),
			);
			return $data;
		}

		/**
		 * This method tests the "toString" method.
		 *
		 * @dataProvider data_toString
		 */
		public function test_toString(array $provided, array $expected) {
			$p0 = IObject\Type::make($provided[0])->__toString();
			$e0 = $expected[0];

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

		#endregion

	}

}