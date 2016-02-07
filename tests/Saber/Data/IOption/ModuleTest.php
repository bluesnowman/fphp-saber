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
	 * @group ModuleTest
	 */
	final class ModuleTest extends Core\ModuleTest {

		#region Methods -> Basic Operations

		/**
		 * This method tests the "iterator" method.
		 */
		public function test_iterator() {
			$p0 = IOption\Type::some(IInt32\Type::zero());
			$e0 = array(0);

			$this->assertInstanceOf('\\Saber\\Data\\IOption\\Some\\Type', $p0);
			$this->assertSame(count($e0), $p0->__size());

			$p1 = IOption\Module::iterator($p0);
			$e1 = 0;

			$this->assertInstanceOf('\\Saber\\Data\\IOption\\Iterator', $p1);

			foreach ($p1 as $i => $item) {
				$this->assertInstanceOf('\\Saber\\Data\\IInt32\\Type', $i);
				$this->assertSame($e1, $i->unbox());
				$this->assertInstanceOf('\\Saber\\Core\\Type', $item);
				$this->assertSame($e0[$e1], $item->unbox());
				$e1++;
			}
		}

		#endregion

		#region Methods -> Conversion Operations

		#endregion

		#region Methods -> Equality Operations

		#endregion

		#region Methods -> Ordering Operations

		#endregion

	}

}