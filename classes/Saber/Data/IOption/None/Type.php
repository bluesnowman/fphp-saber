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

namespace Saber\Data\IOption\None {

	use \Saber\Core;
	use \Saber\Data\IOption;
	use \Saber\Throwable;

	final class Type extends IOption\Type {

		#region Methods -> Object Oriented

		/**
		 * This method returns the item stored within the option.
		 *
		 * @access public
		 * @final
		 * @return Core\Type                                        the stored item
		 * @throws Throwable\UnimplementedMethod\Exception          indicates that this method cannot
		 *                                                          be called
		 */
		public final function item() : Core\Type {
			throw new Throwable\UnimplementedMethod\Exception('Method :method has not been implemented.', array(':method' => __FUNCTION__));
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param int $depth                                        how many levels to unbox
		 * @return mixed                                            the un-boxed value
		 * @throws Throwable\UnimplementedMethod\Exception          indicates that this method cannot
		 *                                                          be called
		 */
		public final function unbox(int $depth = 0) {
			throw new Throwable\UnimplementedMethod\Exception('Method :method has not been implemented.', array(':method' => __FUNCTION__));
		}

		#endregion

	}

}