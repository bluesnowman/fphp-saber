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

namespace Saber\Data\IArrayList {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IArrayList;
	use \Saber\Data\IBool;
	use \Saber\Data\IInt32;
	use \Saber\Data\IString;
	use \Saber\Data\IVector;
	use \Saber\Throwable;

	final class Type extends Data\Type implements IVector\Type {

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
		protected static $module = '\\Saber\\Data\\IArrayList\\Module';

		/**
		 * This variable stores references to commonly used singletons.
		 *
		 * @access protected
		 * @static
		 * @var array
		 */
		protected static $singletons = array();

		#endregion

		#region Methods -> Initialization

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param array $xs                                         the value(s) to be boxed
		 * @return IArrayList\Type                                  the boxed object
		 */
		public static function box(array $xs) : IArrayList\Type {
			return new IArrayList\Type($xs);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed ...$xs                                      the value(s) to be boxed
		 * @return IArrayList\Type                                  the boxed object
		 */
		public static function box2(...$xs) : IArrayList\Type {
			return IArrayList\Type::box($xs);
		}

		/**
		 * This method enforces that the specified class is a covariant.
		 *
		 * @access public
		 * @static
		 * @param IArrayList\Type $x                                the class to be evaluated
		 * @return IArrayList\Type                                  the class
		 */
		public static function covariant(IArrayList\Type $x) : IArrayList\Type {
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param array $xs                                         the value(s) to be boxed
		 * @return IArrayList\Type                                  the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function make(array $xs) : IArrayList\Type {
			foreach ($xs as $x) {
				if (!(is_object($x) && ($x instanceof Core\Type))) {
					$type = gettype($x);
					if ($type == 'object') {
						$type = get_class($x);
					}
					throw new Throwable\InvalidArgument\Exception('Unable to create array list. Expected a boxed value, but got ":type".', array(':type' => $type));
				}
			}
			return new IArrayList\Type($xs);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed ...$xs                                      the value(s) to be boxed
		 * @return IArrayList\Type                                  the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function make2(...$xs) : IArrayList\Type {
			return IArrayList\Type::make($xs);
		}

		/**
		 * This method returns an empty instance.
		 *
		 * @access public
		 * @static
		 * @return IArrayList\Type                                  an empty array list
		 */
		public static function empty_() : IArrayList\Type {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new IArrayList\Type(array());
			}
			return static::$singletons[0];
		}

		/**
		 * This method creates a list of "n" length with every item set to the given object.
		 *
		 * @access public
		 * @param Core\Type $x                                      the object to be replicated
		 * @param IInt32\Type $n                                    the number of times to replicate
		 * @return IArrayList\Type                                  the collection
		 */
		public static function replicate(Core\Type $x, IInt32\Type $n) : IArrayList\Type {
			$buffer = array();

			for ($i = $n->unbox() - 1; $i >= 0; $i--) {
				$buffer[] = $x;
			}

			return IArrayList\Type::box($buffer);
		}

		#endregion

		#region Methods -> Native Oriented

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
		 * This method returns the head object in this list.
		 *
		 * @access public
		 * @final
		 * @return mixed                                            the head object in this list
		 */
		public final function __head() {
			return $this->head()->unbox();
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @final
		 * @return bool                                             whether the list is empty
		 */
		public final function __isEmpty() : bool {
			return empty($this->value);
		}

		/**
		 * This method returns the item at the specified index.
		 *
		 * @access public
		 * @final
		 * @param IInt32\Type $i                                    the index of the item
		 * @return mixed                                            the item at the specified index
		 */
		public final function __item(IInt32\Type $i) {
			return $this->item($i)->unbox();
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @final
		 * @return int                                              the length of this array list
		 */
		public final function __length() : int {
			return count($this->value);
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

		/**
		 * This method returns the tail of this list.
		 *
		 * @access public
		 * @final
		 * @return array                                            the tail of this list
		 */
		public final function __tail() {
			return array_slice($this->value, 1);
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the head object in this list.
		 *
		 * @access public
		 * @final
		 * @return mixed                                            the head object in this list
		 */
		public final function head() {
			return $this->value[0];
		}

		/**
		 * This method (aka "null") returns whether this list is empty.
		 *
		 * @access public
		 * @final
		 * @return IBool\Type                                       whether the list is empty
		 */
		public final function isEmpty() : IBool\Type {
			return IBool\Type::box($this->__isEmpty());
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @final
		 * @return IInt32\Type                                      the length of this array list
		 */
		public final function length() : IInt32\Type {
			return IInt32\Type::box($this->__length());
		}

		/**
		 * This method returns the item at the specified index.
		 *
		 * @access public
		 * @final
		 * @param IInt32\Type $i                                    the index of the item
		 * @return mixed                                            the item at the specified index
		 */
		public final function item(IInt32\Type $i) {
			return $this->value[$i->unbox()];
		}

		/**
		 * This method returns the tail of this list.
		 *
		 * @access public
		 * @final
		 * @return IArrayList\Type                                  the tail of this list
		 */
		public final function tail() {
			return new IArrayList\Type($this->__tail());
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