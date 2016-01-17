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

namespace Saber\Data\IHashSet {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IHashSet;
	use \Saber\Data\IInt32;
	use \Saber\Data\ISet;
	use \Saber\Data\IString;
	use \Saber\Data\ITrit;
	use \Saber\Data\ITuple;
	use \Saber\Data\IUnit;
	use \Saber\Throwable;

	final class Type extends Data\Type implements ISet\Type {

		#region Traits

		use Core\Dispatcher;

		#endregion

		#region Properties

		/**
		 * This variable stores the class path to this class' module.
		 *
		 * @access protected
		 * @static
		 * @var string
		 */
		protected static $module = '\\Saber\\Data\\IHashSet\\Module';

		/**
		 * This variable stores the size of the hash set.
		 *
		 * @access protected
		 * @static
		 * @var integer
		 */
		protected $size;

		#endregion

		#region Methods -> Initialization

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param array $xs                                         the value(s) to be boxed
		 * @return IHashSet\Type                                     the boxed object
		 */
		public static function box(array $xs) {
			return IHashSet\Type::make($xs);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed ...$xs                                      the value(s) to be boxed
		 * @return IHashSet\Type                                     the boxed object
		 */
		public static function box2(...$xs) {
			return IHashSet\Type::make($xs);
		}

		/**
		 * This method enforces that the specified class is a covariant.
		 *
		 * @access public
		 * @static
		 * @param IHashSet\Type $x                                   the class to be evaluated
		 * @return IHashSet\Type                                     the class
		 */
		public static function covariant(IHashSet\Type $x) {
			return $x;
		}
		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param array $xs                                         the value(s) to be boxed
		 * @return IHashSet\Type                                     the boxed object
		 */
		public static function make(array $xs) {
			$zs = new IHashSet\Type();
			foreach ($xs as $x) {
				$zs->putItem($x);
			}
			return $zs;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed ...$xs                                      the value(s) to be boxed
		 * @return IHashSet\Type                                     the boxed object
		 */
		public static function make2(...$xs) {
			return IHashSet\Type::make($xs);
		}

		/**
		 * This method returns an empty instance.
		 *
		 * @access public
		 * @static
		 * @return IHashSet\Type                                     an empty collection
		 */
		public static function empty_() {
			return new IHashSet\Type();
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method removes all entries from the hash set.
		 *
		 * @access public
		 * @final
		 * @return array                                            the hash set
		 */
		public final function __clear() {
			return $this->clear()->unbox();
		}

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @final
		 */
		public final function __construct() {
			$this->value = array();
		}

		/**
		 * This method returns the item associated with the specified key.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $item                                   the item to be found
		 * @return boolean                                          whether the item exists
		 */
		public final function __hasItem(Core\Type $item) {
			$hashCode = $item->__hashCode();
			if (array_key_exists($hashCode, $this->value)) {
				$bucket = $this->value[$hashCode];
				foreach ($bucket as $entry) {
					if ($entry->__eq($item)) {
						return true;
					}
				}
			}
			return false;
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @final
		 * @return boolean                                          whether the list is empty
		 */
		public final function __isEmpty() {
			return empty($this->value);
		}

		/**
		 * This method returns all of the items in the hash set.
		 *
		 * @access public
		 * @final
		 * @return array                                            all items in the hash set
		 */
		public final function __items() {
			$items = array();
			foreach ($this->value as $bucket) {
				foreach ($bucket as $entry) {
					$items[] = $entry;
				}
			}
			return $items;
		}

		/**
		 * This method puts the item into the hash set (if it doesn't already exist).
		 *
		 * @access public
		 * @final
		 * @param Core\Type $item                                   the item to be stored
		 * @return mixed                                            the hash set
		 */
		public final function __putItem(Core\Type $item) {
			return $this->putItem($item)->unbox();
		}

		/**
		 * This method returns the hash set with the item removed.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $item                                   the item to be removed
		 * @return array                                            the hash set
		 */
		public final function __removeItem(Core\Type $item) {
			return $this->removeItem($item)->unbox();
		}

		/**
		 * This method returns the size of this collection.
		 *
		 * @access public
		 * @final
		 * @return integer                                          the size of this collection
		 */
		public final function __size() {
			return count($this->__items());
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object as a string
		 */
		public final function __toString() {
			return (string) serialize($this->unbox());
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method removes all entries from the hash set.
		 *
		 * @access public
		 * @final
		 * @return IHashSet\Type                                     the hash set
		 */
		public final function clear() {
			$this->value = array();
			return $this;
		}

		/**
		 * This method returns the item associated with the specified key.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $item                                   the item to be found
		 * @return IBool\Type                                        whether the item exists
		 */
		public final function hasItem(Core\Type $item) {
			return IBool\Type::box($this->__hasItem($item));
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @final
		 * @return IBool\Type                                        whether the list is empty
		 */
		public final function isEmpty() {
			return IBool\Type::box($this->__isEmpty());
		}

		/**
		 * This method returns all of the items in the hash set.
		 *
		 * @access public
		 * @final
		 * @return IArrayList\Type                                   all items in the hash set
		 */
		public final function items() {
			return IArrayList\Type::box($this->__items());
		}

		/**
		 * This method puts the item into the hash set (if it doesn't already exist).
		 *
		 * @access public
		 * @final
		 * @param Core\Type $item                                   the item to be stored
		 * @return IHashSet\Type                                     the hash set
		 *
		 * @see http://stackoverflow.com/questions/4980757/how-do-hashtables-deal-with-collisions
		 */
		public final function putItem(Core\Type $item) {
			$hashCode = $item->__hashCode();
			if (array_key_exists($hashCode, $this->value)) {
				$bucket = $this->value[$hashCode];
				$type = $item->__typeOf();
				foreach ($bucket as $entry) {
					if ($type == $entry->__typeOf()) {
						return $this;
					}
				}
			}
			$this->value[$hashCode][] = $item;
			return $this;
		}

		/**
		 * This method returns the hash set with the item removed.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $item                                   the item to be removed
		 * @return IHashSet\Type                                     the hash set
		 */
		public final function removeItem(Core\Type $item) {
			$hashCode = $item->__hashCode();
			if (array_key_exists($hashCode, $this->value)) {
				$bucket = $this->value[$hashCode];
				$type = $item->__typeOf();
				$buffer = array();
				foreach ($bucket as $entry) {
					if ($type != $entry->__typeOf()) {
						$buffer[] = $entry;
					}
				}
				if (empty($buffer)) {
					unset($this->value[$hashCode]);
				}
				else {
					$this->value[$hashCode] = $buffer;
				}
			}
			return $this;
		}

		/**
		 * This method returns the size of this collection.
		 *
		 * @access public
		 * @final
		 * @return IInt32\Type                                       the size of this collection
		 */
		public final function size() {
			return IInt32\Type::box($this->__size());
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param integer $depth                                    how many levels to unbox
		 * @return array                                            the un-boxed value
		 */
		public final function unbox($depth = 0) {
			if ($depth > 1) {
				$buffer = array();
				foreach ($this->value as $hashCode => $bucket) {
					foreach ($bucket as $entry) {
						$buffer[$hashCode][] = ($entry instanceof Core\Boxable\Type)
							? $entry->unbox($depth - 1)
							: $entry;
					}
				}
				return $buffer;
			}
			return $this->value;
		}

		#endregion

	}

}