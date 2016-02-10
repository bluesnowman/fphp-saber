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
	 * @group ModuleTest
	 */
	final class ModuleTest extends Core\ModuleTest {

		#region Methods -> Conversion Operations

		/**
		 * This method tests the "nvl" method.
		 */
		public function test_nvl() {
			$x = IUnit\Type::instance();
			$y = IUnit\Type::instance();

			$z = IUnit\Module::nvl($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IUnit\\Type', $z);

			$z = IUnit\Module::nvl(null, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IUnit\\Type', $z);

			$z = IUnit\Module::nvl(null, null);
			$this->assertInstanceOf('\\Saber\\Data\\IUnit\\Type', $z);
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method tests the "eq" method.
		 */
		public function test_eq() {
			$p0 = IUnit\Module::eq(IUnit\Type::instance(), IUnit\Type::instance());
			$e0 = true;

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method tests the "id" method.
		 */
		public function test_id() {
			$p0 = IUnit\Module::id(IUnit\Type::instance(), IUnit\Type::instance());
			$e0 = true;

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method tests the "ne" method.
		 */
		public function test_ne() {
			$p0 = IUnit\Module::ne(IUnit\Type::instance(), IUnit\Type::instance());
			$e0 = false;

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method tests the "ni" method.
		 */
		public function test_ni() {
			$p0 = IUnit\Module::ni(IUnit\Type::instance(), IUnit\Type::instance());
			$e0 = false;

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method tests the "compare" method.
		 */
		public function test_compare() {
			$p0 = IUnit\Module::compare(IUnit\Type::instance(), IUnit\Type::instance());
			$e0 = 0;

			$this->assertInstanceOf('\\Saber\\Data\\ITrit\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method tests the "ge" method.
		 */
		public function test_ge() {
			$p0 = IUnit\Module::ge(IUnit\Type::instance(), IUnit\Type::instance());
			$e0 = true;

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method tests the "gt" method.
		 */
		public function test_gt() {
			$p0 = IUnit\Module::gt(IUnit\Type::instance(), IUnit\Type::instance());
			$e0 = false;

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method tests the "le" method.
		 */
		public function test_le() {
			$p0 = IUnit\Module::le(IUnit\Type::instance(), IUnit\Type::instance());
			$e0 = true;

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method tests the "lt" method.
		 */
		public function test_lt() {
			$p0 = IUnit\Module::lt(IUnit\Type::instance(), IUnit\Type::instance());
			$e0 = false;

			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $p0);
			$this->assertSame($e0, $p0->unbox());
		}

		/**
		 * This method tests the "max" method.
		 */
		public function test_max() {
			$p0 = IUnit\Module::max(IUnit\Type::instance(), IUnit\Type::instance());

			$this->assertInstanceOf('\\Saber\\Data\\IUnit\\Type', $p0);
			$this->assertNull($p0->unbox());
		}

		/**
		 * This method tests the "min" method.
		 */
		public function test_min() {
			$p0 = IUnit\Module::min(IUnit\Type::instance(), IUnit\Type::instance());

			$this->assertInstanceOf('\\Saber\\Data\\IUnit\\Type', $p0);
			$this->assertNull($p0->unbox());
		}

		#endregion

	}

}