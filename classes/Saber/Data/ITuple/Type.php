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

namespace Saber\Data\ITuple {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IBool;
	use \Saber\Data\ICollection;
	use \Saber\Data\IInt32;
	use \Saber\Data\IString;
	use \Saber\Data\ITuple;
	use \Saber\Throwable;

	final class Type extends Data\Type implements ICollection\Type {

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
		protected static $module = '\\Saber\\Data\\ITuple\\Module';

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
		 * @return ITuple\Type                                      the boxed object
		 */
		public static function box(array $xs) : ITuple\Type {
			return new ITuple\Type($xs);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed ...$xs                                      the value(s) to be boxed
		 * @return ITuple\Type                                      the boxed object
		 */
		public static function box2(...$xs) : ITuple\Type {
			return ITuple\Type::box($xs);
		}

		/**
		 * This method enforces that the specified class is a covariant.
		 *
		 * @access public
		 * @static
		 * @param ITuple\Type $x                                    the class to be evaluated
		 * @return ITuple\Type                                      the class
		 */
		public static function covariant(ITuple\Type $x) : ITuple\Type {
			return $x;
		}

		/**
		 * This method returns an empty instance.
		 *
		 * @access public
		 * @static
		 * @return ITuple\Type                                      an empty array list
		 */
		public static function empty_() : ITuple\Type {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new ITuple\Type(array());
			}
			return static::$singletons[0];
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * array.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param array $xs                                         the value(s) to be boxed
		 * @param string $type                                      the data type to be used to box
		 *                                                          PHP typed primitives or objects
		 * @return ITuple\Type                                      the boxed object
		 */
		public static function make(array $xs, string $type = '\\Saber\\Data\\IObject\\Type') : ITuple\Type {
			return new ITuple\Type(array_map(function($x) use ($type) {
				if (is_object($x) && ($x instanceof Core\Type)) {
					return $x;
				}
				return $type::make($x, $type);
			}, $xs));
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * array.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed ...$xs                                      the value(s) to be boxed
		 * @return ITuple\Type                                      the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function make2(...$xs) : ITuple\Type {
			return ITuple\Type::make($xs);
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
		 * This method returns the first item in the tuple.
		 *
		 * @access public
		 * @final
		 * @return mixed                                            the first item in the tuple
		 */
		public final function __first() {
			return $this->first()->unbox();
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
		 * This method evaluates whether the tuple is a pair.
		 *
		 * @access public
		 * @final
		 * @return bool                                             whether the tuple is a pair
		 */
		public final function __isPair() : bool {
			return ($this->__length() == 2);
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
		 * This method returns the second item in the tuple.
		 *
		 * @access public
		 * @final
		 * @return mixed                                            the second item in the tuple
		 */
		public final function __second() {
			return $this->second()->unbox();
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object as a string
		 */
		public final function __toString() {
			return json_encode($this->unbox());
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the first item in the tuple.
		 *
		 * @access public
		 * @final
		 * @return Core\Type                                        the first item in the tuple
		 */
		public final function first() : Core\Type {
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
		 * This method evaluates whether the tuple is a pair.
		 *
		 * @access public
		 * @final
		 * @return IBool\Type                                       whether the tuple is a pair
		 */
		public final function isPair() : IBool\Type {
			return IBool\Type::box($this->__isPair());
		}

		/**
		 * This method returns the item at the specified index.
		 *
		 * @access public
		 * @final
		 * @param IInt32\Type $i                                    the index of the item
		 * @return Core\Type                                        the item at the specified index
		 */
		public final function item(IInt32\Type $i) : Core\Type {
			return $this->value[$i->unbox()];
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
		 * This method returns the second item in the tuple.
		 *
		 * @access public
		 * @final
		 * @return Core\Type                                        the second item in the tuple
		 */
		public final function second() : Core\Type {
			return $this->value[1];
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