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

namespace Saber\Data\IEither {

	use \Saber\Core;
	use \Saber\Data\IEither;
	use \Saber\Data\IInt32;

	/**
	 * @group TypeTest
	 */
	final class TypeTest extends Core\TypeTest {

		#region Tests -> Inheritance

		/**
		 * This method tests the "instanceOf" property.
		 */
		public function test_instanceOf() {
			$p0 = IEither\Type::left(IInt32\Type::zero());

			$this->assertInstanceOf('\\Saber\\Data\\IEither\\Left\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IEither\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\ICollection\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Equality\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Comparable\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Boxable\\Type', $p0);
			$this->assertInstanceOf('\\JsonSerializable', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);

			$p1 = IEither\Type::right(IInt32\Type::zero());

			$this->assertInstanceOf('\\Saber\\Data\\IEither\\Right\\Type', $p1);
			$this->assertInstanceOf('\\Saber\\Data\\IEither\\Type', $p1);
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
			$p0 = IEither\Type::covariant(IEither\Type::left(IInt32\Type::zero()));
			$this->assertInstanceOf('\\Saber\\Data\\IEither\\Left\\Type', $p0);

			$p1 = IEither\Type::covariant(IEither\Type::right(IInt32\Type::zero()));
			$this->assertInstanceOf('\\Saber\\Data\\IEither\\Right\\Type', $p1);
		}

		/**
		 * This method tests the "left" method.
		 */
		public function test_left() {
			$p0 = IEither\Type::left(IInt32\Type::zero());
			$e0 = IEither\Type::left(IInt32\Type::one());

			$this->assertInstanceOf('\\Saber\\Data\\IEither\\Left\\Type', $p0);
			$this->assertNotSame($e0->__hashCode(), $p0->__hashCode());
		}

		/**
		 * This method tests the "right" method.
		 */
		public function test_right() {
			$p0 = IEither\Type::right(IInt32\Type::zero());
			$e0 = IEither\Type::right(IInt32\Type::one());

			$this->assertInstanceOf('\\Saber\\Data\\IEither\\Right\\Type', $p0);
			$this->assertNotSame($e0->__hashCode(), $p0->__hashCode());
		}

		#endregion

		#region Tests -> Interface

		/**
		 * This method tests the "hashCode" method.
		 */
		public function test_hashCode() {
			$p0 = IEither\Type::left(IInt32\Type::zero())->hashCode();

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p0);
			$this->assertRegExp('/^[0-9a-f]{32}$/', $p0->unbox());

			$p1 = IEither\Type::right(IInt32\Type::zero())->hashCode();

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p1);
			$this->assertRegExp('/^[0-9a-f]{32}$/', $p1->unbox());
		}

		/**
		 * This method tests the "isLeft" method.
		 */
		public function test_isLeft() {
			$p0 = IEither\Type::left(IInt32\Type::zero())->isLeft();
			$e0 = true;

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());

			$p1 = IEither\Type::right(IInt32\Type::zero())->isLeft();
			$e1 = false;

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p1);
			$this->assertSame($e1, $p1->unbox());
		}

		/**
		 * This method tests the "isRight" method.
		 */
		public function test_isRight() {
			$p0 = IEither\Type::left(IInt32\Type::zero())->isRight();
			$e0 = false;

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());

			$p1 = IEither\Type::right(IInt32\Type::zero())->isRight();
			$e1 = true;

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p1);
			$this->assertSame($e1, $p1->unbox());
		}

		/**
		 * This method tests the "item" related methods.
		 */
		public function test_item() {
			$p0 = IEither\Type::left(IInt32\Type::zero())->item();
			$e0 = 0;

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());

			$p1 = IEither\Type::right(IInt32\Type::zero())->item();
			$e1 = 0;

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p1);
			$this->assertSame($e1, $p1->unbox());
		}

		/**
		 * This method tests the "projectLeft" method.
		 */
		public function test_projectLeft() {
			$p0 = IEither\Type::left(IInt32\Type::zero())->projectLeft();
			$this->assertInstanceOf('\\Saber\\Data\\IEither\\Left\\Projection', $p0);


			$p1 = IEither\Type::right(IInt32\Type::zero())->projectLeft();
			$this->assertInstanceOf('\\Saber\\Data\\IEither\\Left\\Projection', $p1);
		}

		/**
		 * This method tests the "projectRight" method.
		 */
		public function test_projectRight() {
			$p0 = IEither\Type::left(IInt32\Type::zero())->projectRight();
			$this->assertInstanceOf('\\Saber\\Data\\IEither\\Right\\Projection', $p0);


			$p1 = IEither\Type::right(IInt32\Type::zero())->projectRight();
			$this->assertInstanceOf('\\Saber\\Data\\IEither\\Right\\Projection', $p1);
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
			$p0 = IEither\Type::left(IInt32\Type::box($provided[0]))->toString();
			$e0 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());

			$p1 = IEither\Type::right(IInt32\Type::box($provided[0]))->toString();
			$e1 = $expected[0];

			$this->assertInstanceOf('\\Saber\\Data\\IString\\Type', $p1);
			$this->assertSame($e1, $p1->unbox());
		}

		#endregion

	}

}