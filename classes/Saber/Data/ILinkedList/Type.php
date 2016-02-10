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

namespace Saber\Data\ILinkedList {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IBool;
	use \Saber\Data\IInt32;
	use \Saber\Data\ILinkedList;
	use \Saber\Data\IString;
	use \Saber\Data\ISequence;
	use \Saber\Throwable;

	abstract class Type extends Data\Type implements ISequence\Type {

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
		protected static $module = '\\Saber\\Data\\ILinkedList\\Module';

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
		 * @return ILinkedList\Type                                 the boxed object
		 */
		public static function box(array $xs) : ILinkedList\Type {
			$zs = ILinkedList\Type::nil();
			for ($i = count($xs) - 1; $i >= 0; $i--) {
				$zs = ILinkedList\Type::cons($xs[$i], $zs);
			}
			return $zs;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed ...$xs                                      the value(s) to be boxed
		 * @return ILinkedList\Type                                 the boxed object
		 */
		public static function box2(...$xs) : ILinkedList\Type {
			return ILinkedList\Type::box($xs);
		}

		/**
		 * This method enforces that the specified class is a covariant.
		 *
		 * @access public
		 * @static
		 * @param ILinkedList\Type $x                               the class to be evaluated
		 * @return ILinkedList\Type                                 the class
		 * @throw Throwable\InvalidArgument\Exception               indicated that the specified class
		 *                                                          is not a covariant
		 */
		public static function covariant(ILinkedList\Type $x) : ILinkedList\Type {
			if (!($x instanceof static)) {
				throw new Throwable\InvalidArgument\Exception('Invalid class type.  Expected a class of type ":type1", but got ":type2".', array(':type1' => get_called_class(), ':type2' => get_class($x)));
			}
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param array $xs                                         the value(s) to be boxed
		 * @param string $type                                      the data type to be used to box
		 *                                                          PHP typed primitives or objects
		 * @return ILinkedList\Type                                 the boxed object
		 */
		public static function make(array $xs, string $type = '\\Saber\\Data\\IObject\\Type') : ILinkedList\Type {
			$zs = ILinkedList\Type::nil();
			for ($i = count($xs) - 1; $i >= 0; $i--) {
				$z = $xs[$i];
				if (!(is_object($z) && ($z instanceof Core\Type))) {
					$z = $type::make($z);
				}
				$zs = ILinkedList\Type::cons($z, $zs);
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
		 * @return ILinkedList\Type                                 the boxed object
		 */
		public static function make2(...$xs) : ILinkedList\Type {
			return ILinkedList\Type::make($xs);
		}

		/**
		 * This method returns a "cons" object for a collection.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $head                                   the head to be used
		 * @param ILinkedList\Type $tail                            the tail to be used
		 * @return ILinkedList\Cons\Type                            the "cons" object
		 */
		public static function cons(Core\Type $head, ILinkedList\Type $tail = null) : ILinkedList\Cons\Type {
			if ($tail !== null) {
				return new ILinkedList\Cons\Type($head, $tail);
			}
			return new ILinkedList\Cons\Type($head, ILinkedList\Type::nil());
		}

		/**
		 * This method returns a "nil" object for a collection.
		 *
		 * @access public
		 * @static
		 * @return ILinkedList\Nil\Type                             the "nil" object
		 */
		public static function nil() : ILinkedList\Nil\Type {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new ILinkedList\Nil\Type();
			}
			return static::$singletons[0];
		}

		/**
		 * This method returns an empty instance.
		 *
		 * @access public
		 * @static
		 * @return ILinkedList\Nil\Type                             the "nil" object
		 */
		public static function empty_() : ILinkedList\Nil\Type {
			return ILinkedList\Type::nil();
		}

		/**
		 * This method creates a list of "n" length with every item set to the given object.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $x                                      the object to be replicated
		 * @param IInt32\Type $n                                    the number of times to replicate
		 * @return ILinkedList\Type                                 the collection
		 */
		public static function replicate(Core\Type $x, IInt32\Type $n) : ILinkedList\Type {
			if ($n->unbox() <= 0) {
				return ILinkedList\Type::nil();
			}
			return ILinkedList\Type::cons($x, ILinkedList\Type::replicate($x, IInt32\Module::decrement($n)));
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method returns the head object in this linked list.
		 *
		 * @access public
		 * @final
		 * @return mixed                                            the head object in this linked list
		 */
		public final function __head() {
			return $this->head()->unbox();
		}

		/**
		 * This method (aka "null") returns whether this linked list is empty.
		 *
		 * @access public
		 * @final
		 * @return bool                                             whether the linked list is empty
		 */
		public final function __isEmpty() : bool {
			return ($this instanceof ILinkedList\Nil\Type);
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
		 * This method returns the length of this linked list.
		 *
		 * @access public
		 * @final
		 * @return int                                              the length of this linked list
		 */
		public final function __length() : int {
			return $this->length()->unbox();
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
		 * This method returns the tail of this linked list.
		 *
		 * @access public
		 * @final
		 * @return array                                            the tail of this linked list
		 */
		public final function __tail() : array {
			return $this->tail()->unbox();
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the head object in this linked list.
		 *
		 * @access public
		 * @abstract
		 * @return Core\Type                                        the head object in this linked list
		 */
		public abstract function head() : Core\Type;

		/**
		 * This method (aka "null") returns whether this linked list is empty.
		 *
		 * @access public
		 * @final
		 * @return IBool\Type                                       whether the linked list is empty
		 */
		public final function isEmpty() : IBool\Type {
			return IBool\Type::box($this->__isEmpty());
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
			$j = IInt32\Type::zero();

			for ($zs = $this; ! $zs->__isEmpty(); $zs = $zs->tail()) {
				if (IInt32\Module::eq($i, $j)->unbox()) {
					return $zs->head();
				}
				$j = IInt32\Module::increment($j);
			}

			throw new Throwable\OutOfBounds\Exception('Unable to return item at index :index.', array(':index' => $i->unbox()));
		}

		/**
		 * This method returns the length of this linked list.
		 *
		 * @access public
		 * @final
		 * @return IInt32\Type                                      the length of this linked list
		 */
		public final function length() : IInt32\Type {
			$c = IInt32\Type::zero();
			for ($zs = $this; ! $zs->__isEmpty(); $zs = $zs->tail()) {
				$c = IInt32\Module::increment($c);
			}
			return $c;
		}

		/**
		 * This method returns the tail of this linked list.
		 *
		 * @access public
		 * @abstract
		 * @return ILinkedList\Type                                 the tail of this linked list
		 */
		public abstract function tail() : ILinkedList\Type;

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @abstract
		 * @param int $depth                                        how many levels to unbox
		 * @return array                                            the un-boxed value
		 */
		public abstract function unbox(int $depth = 0);

		#endregion

	}

}