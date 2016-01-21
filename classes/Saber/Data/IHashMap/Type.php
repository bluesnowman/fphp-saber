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

namespace Saber\Data\IHashMap {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IHashMap;
	use \Saber\Data\IInt32;
	use \Saber\Data\IMap;
	use \Saber\Data\IString;
	use \Saber\Data\ITrit;
	use \Saber\Data\ITuple;
	use \Saber\Data\IUnit;
	use \Saber\Throwable;

	final class Type extends Data\Type implements IMap\Type {

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
		protected static $module = '\\Saber\\Data\\IHashMap\\Module';

		/**
		 * This variable stores the size of the collection.
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
		 * @param array $xss                                        the value(s) to be boxed
		 * @return IHashMap\Type                                     the boxed object
		 */
		public static function box(array $xss) { // an array of tuples
			return IHashMap\Type::make($xss);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed ...$xss                                     the value(s) to be boxed
		 * @return IHashMap\Type                                     the boxed object
		 */
		public static function box2(...$xss) { // an array of tuples
			return IHashMap\Type::make($xss);
		}

		/**
		 * This method enforces that the specified class is a covariant.
		 *
		 * @access public
		 * @static
		 * @param IHashMap\Type $x                                   the class to be evaluated
		 * @return IHashMap\Type                                     the class
		 */
		public static function covariant(IHashMap\Type $x) {
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param array $xss                                        the value(s) to be boxed
		 * @return IHashMap\Type                                     the boxed object
		 */
		public static function make(array $xss) { // an array of tuples
			$zs = new IHashMap\Type();
			foreach ($xss as $xs) {
				$zs->putEntry($xs->first(), $xs->second());
			}
			return $zs;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed ...$xss                                     the value(s) to be boxed
		 * @return IHashMap\Type                                     the boxed object
		 */
		public static function make2(...$xss) { // an array of tuples
			return IHashMap\Type::make($xss);
		}

		/**
		 * This method returns an empty instance.
		 *
		 * @access public
		 * @static
		 * @return IHashMap\Type                                     an empty collection
		 */
		public static function empty_() {
			return new IHashMap\Type();
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method removes all entries from the collection.
		 *
		 * @access public
		 * @final
		 * @return array                                            the collection
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
		 * This method returns all key/value pairs in the collection.
		 *
		 * @access public
		 * @final
		 * @return array                                            all key/value pairs in the
		 *                                                          collection
		 */
		public final function __entries() {
			return $this->unbox();
		}

		/**
		 * This method returns whether the specified key exists.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $key                                    the key to be found
		 * @return boolean                                          whether the key exists
		 */
		public final function __hasKey(Core\Type $key) {
			$hashCode = $key->__hashCode();
			if (array_key_exists($hashCode, $this->value)) {
				$bucket = $this->value[$hashCode];
				foreach ($bucket as $entry) {
					if ($entry->first()->__eq($key)) {
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
		 * This method returns the item associated with the specified key.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $key                                    the key to be fetched
		 * @return mixed                                            the item associated with the
		 *                                                          specified key
		 */
		public final function __item(Core\Type $key) {
			return $this->item($key)->unbox();
		}

		/**
		 * This method returns all of the items in the collection.
		 *
		 * @access public
		 * @final
		 * @return array                                            all items in the collection
		 */
		public final function __items() {
			$items = array();
			foreach ($this->value as $bucket) {
				foreach ($bucket as $entry) {
					$items[] = $entry->second();
				}
			}
			return $items;
		}

		/**
		 * This method returns all of the keys in the collection.
		 *
		 * @access public
		 * @final
		 * @return array                                            all keys in the collection
		 */
		public final function __keys() {
			$keys = array();
			foreach ($this->value as $bucket) {
				foreach ($bucket as $entry) {
					$keys[] = $entry->first();
				}
			}
			return $keys;
		}

		/**
		 * This method adds the item with the specified key to the collection (if it doesn't
		 * already exist).
		 *
		 * @access public
		 * @final
		 * @param Core\Type $key                                    the key to associate with
		 *                                                          the item
		 * @param Core\Type $item                                   the item to be stored
		 * @return mixed                                            the hash map
		 */
		public final function __putEntry(Core\Type $key, Core\Type $item) {
			return $this->putEntry($key, $item)->unbox();
		}

		/**
		 * This method returns an item after removing it from the collection.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $key                                    the key associated with the
		 *                                                          item to be removed
		 * @return mixed                                            the item removed
		 */
		public final function __removeKey(Core\Type $key) {
			return $this->removeKey($key)->unbox();
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
		 * This method removes all entries from the collection.
		 *
		 * @access public
		 * @final
		 * @return IHashMap\Type                                     the collection
		 */
		public final function clear() {
			$this->value = array();
			return $this;
		}

		/**
		 * This method returns all key/value pairs in the collection.
		 *
		 * @access public
		 * @final
		 * @return IArrayList\Type                                   all key/value pairs in the
		 *                                                          collection
		 */
		public final function entries() {
			return IArrayList\Type::box($this->__entries());
		}

		/**
		 * This method returns whether the specified key exists.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $key                                    the key to be found
		 * @return IBool\Type                                        whether the key exists
		 */
		public final function hasKey(Core\Type $key) {
			return IBool\Type::box($this->__hasKey($key));
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
		 * This method returns the item associated with the specified key.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $key                                    the key to be fetched
		 * @return Core\Type                                        the item associated with the
		 *                                                          specified key
		 */
		public final function item(Core\Type $key) {
			$hashCode = $key->__hashCode();
			if (array_key_exists($hashCode, $this->value)) {
				$bucket = $this->value[$hashCode];
				foreach ($bucket as $entry) {
					if ($entry->first()->__eq($key)) {
						return $entry->second();
					}
				}
			}
			return IUnit\Type::instance();
		}

		/**
		 * This method returns all of the items in the collection.
		 *
		 * @access public
		 * @final
		 * @return IArrayList\Type                                   all items in the collection
		 */
		public final function items() {
			return IArrayList\Type::box($this->__items());
		}

		/**
		 * This method returns all of the keys in the collection.
		 *
		 * @access public
		 * @final
		 * @return IArrayList\Type                                   all keys in the collection
		 */
		public final function keys() {
			return IArrayList\Type::box($this->__keys());
		}

		/**
		 * This method adds the item with the specified key to the collection (if it doesn't
		 * already exist).
		 *
		 * @access public
		 * @final
		 * @param Core\Type $key                                    the key to associate with
		 *                                                          the item
		 * @param Core\Type $item                                   the item to be stored
		 * @return IHashMap\Type                                     the hash map
		 *
		 * @see http://stackoverflow.com/questions/4980757/how-do-hashtables-deal-with-collisions
		 */
		public final function putEntry(Core\Type $key, Core\Type $item) {
			$hashCode = $key->__hashCode();
			if (array_key_exists($hashCode, $this->value)) {
				$bucket = $this->value[$hashCode];
				foreach ($bucket as $entry) {
					if ($entry->first()->__eq($key)) {
						return $this;
					}
				}
			}
			$this->value[$hashCode][] = ITuple\Type::box2($key, $item);
			return $this;
		}

		/**
		 * This method returns an item after removing it from the collection.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $key                                    the key associated with the
		 *                                                          item to be removed
		 * @return Core\Type                                        the item removed
		 */
		public final function removeKey(Core\Type $key) {
			$hashCode = $key->__hashCode();
			$item = IUnit\Type::instance();
			if (array_key_exists($hashCode, $this->value)) {
				$bucket = $this->value[$hashCode];
				$buffer = array();
				foreach ($bucket as $entry) {
					if ($entry->first()->__ne($key)) {
						$buffer[] = $entry;
					}
					else{
						$item = $entry->second();
					}
				}
				if (empty($buffer)) {
					unset($this->value[$hashCode]);
				}
				else {
					$this->value[$hashCode] = $buffer;
				}
			}
			return $item;
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
		 * @param int $depth                                        how many levels to unbox
		 * @return array                                            the un-boxed value
		 */
		public final function unbox(int $depth = 0) {
			$buffer = array();
			foreach ($this->value as $bucket) {
				foreach ($bucket as $entry) {
					$buffer[] = ($depth > 0)
						? $entry->unbox($depth - 1)
						: $entry;
				}
			}
			return $buffer;
		}

		#endregion

	}

}