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

namespace Saber\Data\IOption {

	use \Saber\Core;
	use \Saber\Data\IInt32;
	use \Saber\Data\IOption;

	/**
	 * @group TypeTest
	 */
	final class TypeTest extends Core\TypeTest {

		#region Tests -> Inheritance

		/**
		 * This method tests the "instanceOf" property.
		 */
		public function test_instanceOf() {
			$p0 = IOption\Type::some(IInt32\Type::zero());

			$this->assertInstanceOf('\\Saber\\Data\\IOption\\Some\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IOption\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\ICollection\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Equality\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Comparable\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Boxable\\Type', $p0);
			$this->assertInstanceOf('\\JsonSerializable', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);

			$p1 = new IOption\None\Type();

			$this->assertInstanceOf('\\Saber\\Data\\IOption\\None\\Type', $p1);
			$this->assertInstanceOf('\\Saber\\Data\\IOption\\Type', $p1);
			$this->assertInstanceOf('\\Saber\\Data\\ICollection\\Type', $p1);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p1);
			$this->assertInstanceOf('\\Saber\\Core\\Equality\\Type', $p1);
			$this->assertInstanceOf('\\Saber\\Core\\Comparable\\Type', $p1);
			$this->assertInstanceOf('\\Saber\\Core\\Boxable\\Type', $p1);
			$this->assertInstanceOf('\\JsonSerializable', $p1);
			$this->assertInstanceOf('\\Saber\\Core\\Type', $p1);
		}

		#endregion

		#region Tests -> Initialization

		/**
		 * This method tests the "covariant" method.
		 */
		public function test_covariant() {
			$p0 = IOption\Type::covariant(IOption\Type::some(IInt32\Type::zero()));
			$this->assertInstanceOf('\\Saber\\Data\\IOption\\Type', $p0);

			$p1 = IOption\Type::covariant(IOption\Type::none());
			$this->assertInstanceOf('\\Saber\\Data\\IOption\\Type', $p1);
		}

		/**
		 * This method tests the "none" method.
		 */
		public function test_none() {
			$p0 = IOption\Type::none();
			$e0 = IOption\Type::none();

			$this->assertInstanceOf('\\Saber\\Data\\IOption\\Type', $p0);
			$this->assertSame($e0->__hashCode(), $p0->__hashCode());
		}

		/**
		 * This method tests the "some" method.
		 */
		public function test_some() {
			$p0 = IOption\Type::some(IInt32\Type::zero());
			$e0 = IOption\Type::some(IInt32\Type::one());

			$this->assertInstanceOf('\\Saber\\Data\\IOption\\Type', $p0);
			$this->assertNotSame($e0->__hashCode(), $p0->__hashCode());
		}

		#endregion

		#region Tests -> Interface

		/**
		 * This method tests the "hashCode" method.
		 */
		public function test_hashCode() {
			$p0 = IOption\Type::some(IInt32\Type::zero())->hashCode();

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p0);
			$this->assertRegExp('/^[0-9a-f]{32}$/', $p0->unbox());

			$p1 = IOption\Type::none()->hashCode();

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p1);
			$this->assertRegExp('/^[0-9a-f]{32}$/', $p1->unbox());
		}

		/**
		 * This method tests the "isDefined" method.
		 */
		public function test_isDefined() {
			$p0 = IOption\Type::some(IInt32\Type::zero())->isDefined();
			$e0 = true;

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());

			$p0 = IOption\Type::none()->isDefined();
			$e0 = false;

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method tests the "item" related methods.
		 */
		public function test_item() {
			$p0 = IOption\Type::some(IInt32\Type::zero())->item();
			$e0 = 0;

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method tests the "size" method.
		 */
		public function test_size() {
			$p0 = IOption\Type::some(IInt32\Type::zero())->size();
			$e0 = 1;

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());

			$p1 = IOption\Type::none()->size();
			$e1 = 0;

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p1);
			$this->assertSame($e1, $p1->unbox());
		}

		/**
		 * This method provides the data for testing the "toString" method.
		 *
		 * @return array
		 */
		public function data_toString() {
			$data = array(
				array(array(0), array('0')),
				array(array(1), array('1')),
			);
			return $data;
		}

		/**
		 * This method tests the "toString" method.
		 *
		 * @dataProvider data_toString
		 */
		public function test_toString(array $provided, array $expected) {
			$p0 = IOption\Type::some(IInt32\Type::box($provided[0]))->toString();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

	}

}