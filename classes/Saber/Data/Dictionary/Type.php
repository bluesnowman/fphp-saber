<?php

/**
 * Copyright 2014 Blue Snowman
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

namespace Saber\Data\Dictionary {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Bool;
	use \Saber\Data\Dictionary;
	use \Saber\Data\Int32;
	use \Saber\Data\Map;
	use \Saber\Data\Tuple;
	use \Saber\Data\Unit;
	use \Saber\Throwable;

	final class Type extends Data\Type implements Core\Boxable\Type, Map\Type {

		#region Properties

		/**
		 * This variable stores the class path to this class' module.
		 *
		 * @access protected
		 * @static
		 * @var string
		 */
		protected static $module = '\\Saber\\Data\\Dictionary\\Module';

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
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Dictionary\Type                                  the boxed object
		 */
		public static function box($value/*...*/) {
			$xs = (is_array($value)) ? $value : func_get_args();
			return new Dictionary\Type($xs);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Dictionary\Type                                  the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function make($value/*...*/) {
			$xs = (is_array($value)) ? $value : func_get_args();
			foreach ($xs as $x) {
				if (!(is_object($x) && ($x instanceof Core\Type))) {
					$type = gettype($x);
					if ($type == 'object') {
						$type = get_class($x);
					}
					throw new Throwable\InvalidArgument\Exception('Unable to create dictionary. Expected a boxed value, but got ":type".', array(':type' => $type));
				}
			}
			return new Dictionary\Type($xs);
		}

		/**
		 * This method returns an empty instance.
		 *
		 * @access public
		 * @static
		 * @return Dictionary\Type                                  an empty dictionary
		 */
		public static function empty_() {
			return new Dictionary\Type(array());
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method is called when a method is not defined and will attempt to remap
		 * the call.  Particularly, this method provides a shortcut means of unboxing a method's
		 * result when the method name is preceded by a double-underscore.
		 *
		 * @access public
		 * @final
		 * @param string $method                                    the method being called
		 * @param array $args                                       the arguments associated with the call
		 * @return mixed                                            the un-boxed value
		 * @throws Throwable\UnimplementedMethod\Exception          indicates that the class has not
		 *                                                          implemented the called method
		 */
		public final function __call($method, $args) {
			if (preg_match('/^__[a-z_][a-z0-9_]*$/i', $method)) {
				$method = substr($method, 2);
				if (!in_array($method, array('call', 'choice', 'iterator', 'unbox'))) {
					if (method_exists(static::$module, $method)) {
						array_unshift($args, $this);
						$result = call_user_func_array(array(static::$module, $method), $args);
						if ($result instanceof Core\Boxable\Type) {
							return $result->unbox();
						}
						return $result;
					}
				}
			}
			else {
				if (method_exists(static::$module, $method)) {
					array_unshift($args, $this);
					$result = call_user_func_array(array(static::$module, $method), $args);
					return $result;
				}
			}
			throw new Throwable\UnimplementedMethod\Exception('Unable to call method. No method ":method" exists in module ":module".', array(':module' => static::$module, ':method' => $method));
		}

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @final
		 * @param array $value                                      the value to be assigned
		 */
		public final function __construct(array $value) {
			$this->value = $value;
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
			$entries = array();
			foreach ($this->value as $bucket) {
				foreach ($bucket as $entry) {
					$entries[] = $entry;
				}
			}
			return $entries;
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
				$type = $key->__typeOf();
				foreach ($bucket as $entry) {
					$second = $entry->second();
					if ($type == $second->__typeOf()) {
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
		 * @return mixed                                            the collection
		 */
		public final function __put(Core\Type $key, Core\Type $item) {
			return $this->put($key, $item)->unbox();
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
		public final function __remove(Core\Type $key) {
			return $this->remove($key)->unbox();
		}

		/**
		 * This method returns the size of this dictionary.
		 *
		 * @access public
		 * @final
		 * @return integer                                          the size of this dictionary
		 */
		public final function __size() {
			return count($this->__keys());
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
		 * This method returns all key/value pairs in the collection.
		 *
		 * @access public
		 * @final
		 * @return ArrayList\Type                                   all key/value pairs in the
		 *                                                          collection
		 */
		public final function entries() {
			return ArrayList\Type::box($this->__entries());
		}

		/**
		 * This method returns whether the specified key exists.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $key                                    the key to be found
		 * @return Bool\Type                                        whether the key exists
		 */
		public final function hasKey(Core\Type $key) {
			return Bool\Type::box($this->__hasKey($key));
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @final
		 * @return Bool\Type                                        whether the list is empty
		 */
		public final function isEmpty() {
			return Bool\Type::box($this->__isEmpty());
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
				$type = $key->__typeOf();
				foreach ($bucket as $entry) {
					$second = $entry->second();
					if ($type == $second->__typeOf()) {
						return $second;
					}
				}
			}
			return Unit\Type::instance();
		}

		/**
		 * This method returns all of the items in the collection.
		 *
		 * @access public
		 * @final
		 * @return ArrayList\Type                                   all items in the collection
		 */
		public final function items() {
			return ArrayList\Type::box($this->__items());
		}

		/**
		 * This method returns all of the keys in the collection.
		 *
		 * @access public
		 * @final
		 * @return ArrayList\Type                                   all keys in the collection
		 */
		public final function keys() {
			return ArrayList\Type::box($this->__keys());
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
		 * @return Core\Type                                        the collection
		 *
		 * @see http://stackoverflow.com/questions/4980757/how-do-hashtables-deal-with-collisions
		 */
		public final function put(Core\Type $key, Core\Type $item) {
			$hashCode = $key->__hashCode();
			if (array_key_exists($hashCode, $this->value)) {
				$bucket = $this->value[$hashCode];
				$type = $key->__typeOf();
				foreach ($bucket as $entry) {
					$second = $entry->second();
					if ($type == $second->__typeOf()) {
						return $this;
					}
				}
			}
			$this->value[$hashCode][] = Tuple\Type::box($key, $item);
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
		public final function remove(Core\Type $key) {
			$hashCode = $key->__hashCode();
			$item = Unit\Type::instance();
			if (array_key_exists($hashCode, $this->value)) {
				$bucket = $this->value[$hashCode];
				$type = $key->__typeOf();
				$buffer = array();
				foreach ($bucket as $entry) {
					$second = $entry->second();
					if ($type != $second->__typeOf()) {
						$buffer[] = $entry;
					}
					else{
						$item = $second;
					}
				}
				$this->value[$hashCode] = $buffer;
			}
			return $item;
		}

		/**
		 * This method returns the size of this dictionary.
		 *
		 * @access public
		 * @final
		 * @return Int32\Type                                       the size of this dictionary
		 */
		public final function size() {
			return Int32\Type::box($this->__size());
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
			if ($depth > 0) {
				$buffer = array();
				foreach ($this->value as $item) {
					$buffer[] = ($item instanceof Core\Boxable\Type)
						? $item->unbox($depth - 1)
						: $item;
				}
				return $buffer;
			}
			return $this->value;
		}

		#endregion

	}

}