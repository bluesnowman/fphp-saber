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

namespace Saber\Data\IBool {

	use \Saber\Core;
	use \Saber\Data\IBool;

	/**
	 * @group ModuleTest
	 */
	final class ModuleTest extends Core\ModuleTest {

		#region Methods -> Conversion Operations

		/**
		 * This method tests the "nvl" method.
		 */
		public function test_nvl() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::nvl($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::nvl(null, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::nvl(null, null);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());
		}

		/**
		 * This method tests the "toDouble" method.
		 */
		public function test_toDouble() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::toDouble($x);
			$this->assertInstanceOf('\\Saber\\Data\\IDouble\\Type', $z);
			$this->assertSame(1.0, $z->unbox());

			$z = IBool\Module::toDouble($y);
			$this->assertInstanceOf('\\Saber\\Data\\IDouble\\Type', $z);
			$this->assertSame(0.0, $z->unbox());
		}

		/**
		 * This method tests the "toFloat" method.
		 */
		public function test_toFloat() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::toFloat($x);
			$this->assertInstanceOf('\\Saber\\Data\\IFloat\\Type', $z);
			$this->assertSame(1.0, $z->unbox());

			$z = IBool\Module::toFloat($y);
			$this->assertInstanceOf('\\Saber\\Data\\IFloat\\Type', $z);
			$this->assertSame(0.0, $z->unbox());
		}

		/**
		 * This method tests the "toInt32" method.
		 */
		public function test_toInt32() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::toInt32($x);
			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $z);
			$this->assertSame(1, $z->unbox());

			$z = IBool\Module::toInt32($y);
			$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $z);
			$this->assertSame(0, $z->unbox());
		}

		/**
		 * This method tests the "toInteger" method.
		 */
		public function test_toInteger() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::toInteger($x);
			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $z);
			$this->assertSame('1', $z->unbox());

			$z = IBool\Module::toInteger($y);
			$this->assertInstanceOf('\\Saber\\Data\\IInteger\\Type', $z);
			$this->assertSame('0', $z->unbox());
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method tests the "eq" method.
		 */
		public function test_eq() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::eq($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::eq($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());
		}

		/**
		 * This method tests the "id" method.
		 */
		public function test_id() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::id($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::id($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());
		}

		/**
		 * This method tests the "ne" method.
		 */
		public function test_ne() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::ne($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::ne($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());
		}

		/**
		 * This method tests the "ni" method.
		 */
		public function test_ni() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::ni($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::ni($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method tests the "compare" method.
		 */
		public function test_compare() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::compare($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\ITrit\\Type', $z);
			$this->assertSame(1, $z->unbox());

			$z = IBool\Module::compare($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\ITrit\\Type', $z);
			$this->assertSame(0, $z->unbox());

			$z = IBool\Module::compare($y, $x);
			$this->assertInstanceOf('\\Saber\\Data\\ITrit\\Type', $z);
			$this->assertSame(-1, $z->unbox());
		}

		/**
		 * This method tests the "ge" method.
		 */
		public function test_ge() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::ge($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::ge($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::ge($y, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());
		}

		/**
		 * This method tests the "gt" method.
		 */
		public function test_gt() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::gt($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::gt($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::gt($y, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());
		}

		/**
		 * This method tests the "le" method.
		 */
		public function test_le() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::le($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::le($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::le($y, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());
		}

		/**
		 * This method tests the "lt" method.
		 */
		public function test_lt() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::lt($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::lt($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::lt($y, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());
		}

		/**
		 * This method tests the "max" method.
		 */
		public function test_max() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::max($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::max($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::max($y, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());
		}

		/**
		 * This method tests the "min" method.
		 */
		public function test_min() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::min($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::min($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::min($y, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());
		}

		#endregion

		#region Methods -> Logical Operations

		/**
		 * This method tests the "and_" method.
		 */
		public function test_and_() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::and_($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::and_($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::and_($y, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::and_($y, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());
		}

		/**
		 * This method tests the "impl" method.
		 */
		public function test_impl() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::impl($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::impl($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::impl($y, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::impl($y, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());
		}

		/**
		 * This method tests the "nand" method.
		 */
		public function test_nand() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::nand($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::nand($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::nand($y, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::nand($y, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());
		}

		/**
		 * This method tests the "nor" method.
		 */
		public function test_nor() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::nor($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::nor($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::nor($y, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::nor($y, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());
		}

		/**
		 * This method tests the "not" method.
		 */
		public function test_not() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::not($x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::not($y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());
		}

		/**
		 * This method tests the "or_" method.
		 */
		public function test_or_() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::or_($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::or_($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::or_($y, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::or_($y, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());
		}

		/**
		 * This method tests the "xnor" method.
		 */
		public function test_xnor() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::xnor($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::xnor($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::xnor($y, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::xnor($y, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());
		}

		/**
		 * This method tests the "xor_" method.
		 */
		public function test_xor_() {
			$x = IBool\Type::true();
			$y = IBool\Type::false();

			$z = IBool\Module::xor_($x, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::xor_($x, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());

			$z = IBool\Module::xor_($y, $x);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(true, $z->unbox());

			$z = IBool\Module::xor_($y, $y);
			$this->assertInstanceOf('\\Saber\\Data\\IBool\\Type', $z);
			$this->assertSame(false, $z->unbox());
		}

		#endregion

	}

}