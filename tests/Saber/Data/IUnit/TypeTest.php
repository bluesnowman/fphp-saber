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

namespace Saber\Data\IUnit {

	use \Saber\Core;
	use \Saber\Data\IBool;
	use \Saber\Data\IUnit;

	/**
	 * @group TypeTest
	 */
	final class TypeTest extends Core\TypeTest {

		#region Tests -> Inheritance

		/**
		 * This method tests the data type.
		 */
		public function test_instanceOf() {
			//$this->markTestIncomplete();

			$p0 = new IUnit\Type();

			$this->assertInstanceOf('\\Saber\\Data\\IUnit\\Type', $p0);
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
		 * This method tests the initialization of a singleton, boxed value.
		 */
		public function test_singleton() {
			//$this->markTestIncomplete();

			$p0 = IUnit\Type::instance();

			$this->assertInstanceOf('\\Saber\\Data\\IUnit\\Type', $p0);

			$p1 = $p0->unbox();
			$e1 = null;

			$this->assertInternalType('null', $p1);
			$this->assertSame($e1, $p1);
			$this->assertNull($p1);
		}

		#endregion

		#region Tests -> Interface

		/**
		 * This method tests that an object has a unique hash code.
		 */
		public function test_hashCode() {
			$p0 = IUnit\Type::instance()->__hashCode();
			$e0 = 'null';

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

		/**
		 * This method tests that a value is converted to a string.
		 */
		public function test_toString() {
			$p0 = IUnit\Type::instance()->__toString();
			$e0 = 'null';

			$this->assertInternalType('string', $p0);
			$this->assertSame($e0, $p0);
		}

		#endregion

	}

}