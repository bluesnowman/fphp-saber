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

namespace Saber\Data\Funct {

	use \Saber\Core;
	use \Saber\Data\Funct;
	use \Saber\Data\Int32;

	/**
	 * @group UtilitiesTest
	 */
	final class UtilitiesTest extends Core\UtilitiesTest {

		/**
		 * This method tests the creation of a constant function that wraps an object.
		 */
		public function testConstant() {
			$constant = Funct\Utilities::constant(Int32\Type::zero());
			$this->assertInternalType('callable', $constant);
			$this->assertSame(Int32\Type::zero(), $constant());
		}

	}

}