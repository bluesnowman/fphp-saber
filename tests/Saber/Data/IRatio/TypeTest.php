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

namespace Saber\Data\IRatio {

	use \Saber\Core;
	use \Saber\Data\IInt32;
	use \Saber\Data\IRatio;

	/**
	 * @group TypeTest
	 */
	final class TypeTest extends Core\TypeTest {

		#region Tests -> Inheritance

		/**
		 * This method tests the data type.
		 */
		public function testType() {
			//$this->markTestIncomplete();

			$p0 = new IRatio\Type(IInt32\Type::one(), IInt32\Type::box(2));

			$this->assertInstanceOf('\\Saber\\Data\\IRatio\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IFractional\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\INumber\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Equality\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Comparable\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Boxable\\Type', $p0);
			$this->assertInstanceOf('\\JsonSerializable', $p0);
			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);
		}

		#endregion

		/**
		 * This method provides the data for testing the boxing of a boxed value.
		 *
		 * @return array
		 */
		public function dataBox() {
			$data = array(
				array(array(IInt32\Type::one(), IInt32\Type::one()), array(IInt32\Type::one(), IInt32\Type::one())),
				array(array(1, 1), array(IInt32\Type::one(), IInt32\Type::one())),
				array(array(0, 1), array(IInt32\Type::zero(), IInt32\Type::one())),
				array(array(-1, 1), array(IInt32\Type::negative(), IInt32\Type::one())),
			);
			return $data;
		}

		/**
		 * This method tests the boxing of a boxed value.
		 *
		 * @dataProvider dataBox
		 */
		public function testBox(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IRatio\Type::box($provided[0], $provided[1]);
			$e0 = $expected;

			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IFractional\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IRatio\\Type', $p0);

			$pN = $p0->numerator();
			$pD = $p0->denominator();

			$eN = $e0[0]->unbox();
			$eD = $e0[1]->unbox();

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $pN);
			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $pD);
			$this->assertSame($eN, $pN->unbox());
			$this->assertSame($eD, $pD->unbox());

			$p1 = $p0->unbox();

			$this->assertInternalType('array', $p1);
			$this->assertTrue(count($p1) == 2);
			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p1[0]);
			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p1[1]);
			$this->assertSame($eN, $p1[0]->unbox());
			$this->assertSame($eD, $p1[1]->unbox());

			$p2 = $p0->unbox(1);

			$this->assertInternalType('array', $p2);
			$this->assertTrue(count($p2) == 2);
			$this->assertInternalType('integer', $p2[0]);
			$this->assertInternalType('integer', $p2[1]);
			$this->assertSame($eN, $p2[0]);
			$this->assertSame($eD, $p2[1]);
		}

		/**
		 * This method provides the data for testing the making of a boxed value.
		 *
		 * @return array
		 */
		public function dataMake() {
			$data = array(
				array(array(IInt32\Type::one(), IInt32\Type::one()), array(IInt32\Type::one(), IInt32\Type::one())),
				array(array(1, 1), array(IInt32\Type::one(), IInt32\Type::one())),
				array(array(0, 1), array(IInt32\Type::zero(), IInt32\Type::one())),
				array(array(-1, 1), array(IInt32\Type::negative(), IInt32\Type::one())),
				array(array(1, -1), array(IInt32\Type::negative(), IInt32\Type::one())),
			);
			return $data;
		}

		/**
		 * This method tests the making of a boxed value.
		 *
		 * @dataProvider dataMake
		 */
		public function testMake(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = IRatio\Type::make($provided[0], $provided[1]);
			$e0 = $expected;

			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IFractional\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IRatio\\Type', $p0);

			$pN = $p0->numerator();
			$pD = $p0->denominator();

			$eN = $e0[0]->unbox();
			$eD = $e0[1]->unbox();

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $pN);
			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $pD);
			$this->assertSame($eN, $pN->unbox());
			$this->assertSame($eD, $pD->unbox());

			$p1 = $p0->unbox();

			$this->assertInternalType('array', $p1);
			$this->assertTrue(count($p1) == 2);
			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p1[0]);
			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p1[1]);
			$this->assertSame($eN, $p1[0]->unbox());
			$this->assertSame($eD, $p1[1]->unbox());

			$p2 = $p0->unbox(1);

			$this->assertInternalType('array', $p2);
			$this->assertTrue(count($p2) == 2);
			$this->assertInternalType('integer', $p2[0]);
			$this->assertInternalType('integer', $p2[1]);
			$this->assertSame($eN, $p2[0]);
			$this->assertSame($eD, $p2[1]);
		}

		/**
		 * This method provides the data for testing the making of a boxed value.
		 *
		 * @return array
		 */
		public function dataSingleton() {
			$data = array(
				array(array(IRatio\Type::one()), array(IInt32\Type::one(), IInt32\Type::one())),
				array(array(IRatio\Type::zero()), array(IInt32\Type::zero(), IInt32\Type::one())),
				array(array(IRatio\Type::negative()), array(IInt32\Type::negative(), IInt32\Type::one())),
			);
			return $data;
		}

		/**
		 * This method tests the initialization of a singleton, boxed value.
		 *
		 * @dataProvider dataSingleton
		 */
		public function testSingleton(array $provided, array $expected) {
			//$this->markTestIncomplete();

			$p0 = $provided[0];
			$e0 = $expected;

			$this->assertInstanceOf('\\Saber\\Core\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\INumber\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IFractional\\Type', $p0);
			$this->assertInstanceOf('\\Saber\\Data\\IRatio\\Type', $p0);

			$pN = $p0->numerator();
			$pD = $p0->denominator();

			$eN = $e0[0]->unbox();
			$eD = $e0[1]->unbox();

			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $pN);
			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $pD);
			$this->assertSame($eN, $pN->unbox());
			$this->assertSame($eD, $pD->unbox());

			$p1 = $p0->unbox();

			$this->assertInternalType('array', $p1);
			$this->assertTrue(count($p1) == 2);
			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p1[0]);
			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $p1[1]);
			$this->assertSame($eN, $p1[0]->unbox());
			$this->assertSame($eD, $p1[1]->unbox());

			$p2 = $p0->unbox(1);

			$this->assertInternalType('array', $p2);
			$this->assertTrue(count($p2) == 2);
			$this->assertInternalType('integer', $p2[0]);
			$this->assertInternalType('integer', $p2[1]);
			$this->assertSame($eN, $p2[0]);
			$this->assertSame($eD, $p2[1]);
		}

	}

}