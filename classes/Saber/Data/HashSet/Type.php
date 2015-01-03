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

namespace Saber\Data\HashSet {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\ArrayList;
	use \Saber\Data\Bool;
	use \Saber\Data\HashSet;
	use \Saber\Data\Int32;
	use \Saber\Data\Set;
	use \Saber\Data\String;
	use \Saber\Data\Trit;
	use \Saber\Data\Tuple;
	use \Saber\Data\Unit;
	use \Saber\Throwable;

	final class Type extends Data\Type implements Core\Boxable\Type, Set\Type {

		#region Properties

		/**
		 * This variable stores any mixins that can be used to extends this data type.
		 *
		 * @access protected
		 * @static
		 * @var array
		 */
		protected static $mixins = array();

		/**
		 * This variable stores the class path to this class' module.
		 *
		 * @access protected
		 * @static
		 * @var string
		 */
		protected static $module = '\\Saber\\Data\\HashSet\\Module';

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
		 * This method enforces that the specified class is covariant.
		 *
		 * @access public
		 * @static
		 * @param HashSet\Type $x                                   the class to be evaluated
		 * @return HashSet\Type                                     the class
		 */
		public static function covariant(HashSet\Type $x) {
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return HashSet\Type                                     the boxed object
		 */
		public static function box($value/*...*/) {
			$items = (is_array($value)) ? $value : func_get_args();
			return new HashSet\Type($items);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return HashSet\Type                                     the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function make($value/*...*/) {
			$items = (is_array($value)) ? $value : func_get_args();
			$xs = new HashSet\Type();
			foreach ($items as $item) {
				$xs->putItem($item);
			}
			return $xs;
		}

		/**
		 * This method returns an empty instance.
		 *
		 * @access public
		 * @static
		 * @return HashSet\Type                                     an empty collection
		 */
		public static function empty_() {
			return new HashSet\Type();
		}

		#endregion

		#region Methods -> Extensible

		/**
		 * This method allows for the class to be extend with custom utility functions.
		 *
		 * @access public
		 * @static
		 * @param String\Type $name                                 the name of the mixin
		 * @param callable $closure                                 the custom utility function
		 */
		public static function mixin(String\Type $name, callable $closure) {
			static::$mixins[$name->unbox()] = $closure;
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
		 * @param array $value                                      the value to be assigned
		 */
		public final function __construct(array $value = array()) {
			$this->value = $value;
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
				$type = $item->__typeOf();
				foreach ($bucket as $entry) {
					if ($type == $entry->__typeOf()) {
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
		 * @return HashSet\Type                                     the hash set
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
		 * @return Bool\Type                                        whether the item exists
		 */
		public final function hasItem(Core\Type $item) {
			return Bool\Type::box($this->__hasItem($item));
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
		 * This method returns all of the items in the hash set.
		 *
		 * @access public
		 * @final
		 * @return ArrayList\Type                                   all items in the hash set
		 */
		public final function items() {
			return ArrayList\Type::box($this->__items());
		}

		/**
		 * This method puts the item into the hash set (if it doesn't already exist).
		 *
		 * @access public
		 * @final
		 * @param Core\Type $item                                   the item to be stored
		 * @return HashSet\Type                                     the hash set
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
		 * @return HashSet\Type                                     the hash set
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
		 * @return Int32\Type                                       the size of this collection
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