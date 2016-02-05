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

namespace Saber\Control\Event {

	use \Saber\Core;
	use \Saber\Data\IHashMap;
	use \Saber\Data\IInt32;
	use \Saber\Data\ILinkedList;
	use \Saber\Data\ITuple;

	class Module extends Core\Module {

		/**
		 * This method publishes the message to any subscribed listerners.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the left operand
		 * @param ITuple\Type $message                              a tuple containing the event key and
		 *                                                          value to be published
		 * @return IHashMap\Type                                    the map
		 */
		public static function publish(IHashMap\Type $xs, ITuple\Type $message) : IHashMap\Type {
			$k = $message->first();
			if ($xs->hasKey($k)) {
				ILinkedList\Module::each($xs->item($k), function(callable $y) use ($message) {
					$y($message->second());
				});
			}
			return $xs;
		}

		/**
		 * This method subscribes a listener.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the left operand
		 * @param ITuple\Type $entry                                a tuple containing the key and listener
		 * @return IHashMap\Type                                    the map
		 */
		public static function subscribe(IHashMap\Type $xs, ITuple\Type $entry) : IHashMap\Type {
			$k = $entry->first();
			$ys = ($xs->__hasKey($k)) ? $xs->item($k) : ILinkedList\Type::empty_();
			$ys = ILinkedList\Module::append($ys, $entry->second());
			$zs = IHashMap\Module::putEntry($xs, ITuple\Type::box2($k, $ys));
			return $zs;
		}

		/**
		 * This method unsubscribes a listener.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $xs                                 the left operand
		 * @param ITuple\Type $entry                                a tuple containing the key and listener
		 * @return IHashMap\Type                                    the map
		 */
		public static function unsubscribe(IHashMap\Type $xs, ITuple\Type $entry) : IHashMap\Type {
			$k = $entry->first();
			if ($xs->__hasKey($k)) {
				$ys = ILinkedList\Module::delete($xs->item($k), $entry->second());
				$zs = IHashMap\Module::putEntry($xs, ITuple\Type::box2($k, $ys));
				return $zs;
			}
			return $xs;
		}

	}

}