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

namespace Saber\Data\LinkedList {

	use \Saber\Core;
	use \Saber\Data\Bool;
	use \Saber\Data\Collection;
	use \Saber\Data\Int32;
	use \Saber\Data\LinkedList;
	use \Saber\Throwable;

	abstract class Type extends Collection\Type implements Core\Boxable\Type {

		#region Methods -> Initialization

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Core\Type                                        the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function make($value/*...*/) {
			if (is_array($value)) {
				$zs = LinkedList\Type::nil();
				for ($i = count($value) - 1; $i >= 0; $i--) {
					$zs = LinkedList\Module::prepend($zs, $value[$i]);
				}
				return $zs;
			}
			else {
				$type = gettype($value);
				if ($type == 'object') {
					$type = get_class($value);
				}
				throw new Throwable\InvalidArgument\Exception('Unable to box value. Expected an array, but got ":type".', array(':type' => $type));
			}
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return LinkedList\Type                                  the boxed object
		 */
		public static function box($value/*...*/) {
			$zs = LinkedList\Type::nil();
			for ($i = count($value) - 1; $i >= 0; $i--) {
				$zs = LinkedList\Module::prepend($zs, $value[$i]);
			}
			return $zs;
		}

		/**
		 * This method returns a "cons" object for a collection.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $head                                   the head to be used
		 * @param LinkedList\Type $tail                             the tail to be used
		 * @return LinkedList\Cons\Type                             the "cons" object
		 */
		public static function cons(Core\Type $head, LinkedList\Type $tail) {
			return new LinkedList\Cons\Type($head, $tail);
		}

		/**
		 * This method returns a "nil" object for a collection.
		 *
		 * @access public
		 * @static
		 * @return LinkedList\Nil\Type                              the "nil" object
		 */
		public static function nil() {
			return new LinkedList\Nil\Type();
		}

		/**
		 * This method creates a list of "n" length with every element set to the given object.
		 *
		 * @access public
		 * @static
		 * @param Int32\Type $n                                     the number of times to replicate
		 * @param Core\Type $y                                      the object to be replicated
		 * @return LinkedList\Type                                  the collection
		 */
		public static function replicate(Int32\Type $n, Core\Type $y) {
			if ($n->unbox() <= 0) {
				return LinkedList\Type::nil();
			}
			return LinkedList\Type::cons($y, LinkedList\Type::replicate(Int32\Module::decrement($n), $y));
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
			$module = '\\Saber\\Data\\LinkedList\\Module';
			if (preg_match('/^__[a-z_][a-z0-9_]*$/i', $method)) {
				$method = substr($method, 2);
				if (!in_array($method, array('call', 'choice', 'iterator', 'unbox'))) {
					if (method_exists($module, $method)) {
						array_unshift($args, $this);
						$result = call_user_func_array(array($module, $method), $args);
						if ($result instanceof Core\Boxable\Type) {
							return $result->unbox();
						}
						return $result;
					}
				}
			}
			else {
				if (method_exists($module, $method)) {
					array_unshift($args, $this);
					$result = call_user_func_array(array($module, $method), $args);
					return $result;
				}
			}
			throw new Throwable\UnimplementedMethod\Exception('Unable to call method. No method ":method" exists in module ":module".', array(':module' => $module, ':method' => $method));
		}

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @final
		 * @param Int32\Type $i                                     the index of the element
		 * @return mixed                                            the element at the specified index
		 */
		public final function __element(Int32\Type $i) {
			return $this->element($i)->unbox();
		}

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
		 * @return boolean                                          whether the linked list is empty
		 */
		public final function __isEmpty() {
			return ($this->value instanceof LinkedList\Nil\Type);
		}

		/**
		 * This method returns the length of this linked list.
		 *
		 * @access public
		 * @final
		 * @return integer                                          the length of this linked list
		 */
		public final function __length() {
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
		public final function __tail() {
			return $this->tail()->unbox();
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @final
		 * @param Int32\Type $i                                     the index of the element
		 * @return mixed                                            the element at the specified index
		 */
		public final function element(Int32\Type $i) {
			$j = Int32\Type::zero();

			for ($zs = $this; ! $zs->__isEmpty(); $zs = $zs->tail()) {
				if (Int32\Module::eq($i, $j)->unbox()) {
					return $zs->head();
				}
				$j = Int32\Module::increment($j);
			}

			throw new Throwable\OutOfBounds\Exception('Unable to return element at index :index.', array(':index' => $i->unbox()));
		}

		/**
		 * This method returns the head object in this linked list.
		 *
		 * @access public
		 * @abstract
		 * @return mixed                                            the head object in this linked list
		 */
		public abstract function head();

		/**
		 * This method (aka "null") returns whether this linked list is empty.
		 *
		 * @access public
		 * @final
		 * @return Bool\Type                                        whether the linked list is empty
		 */
		public final function isEmpty() {
			return Bool\Type::box($this->__isEmpty());
		}

		/**
		 * This method returns the length of this linked list.
		 *
		 * @access public
		 * @final
		 * @return Int32\Type                                       the length of this linked list
		 */
		public final function length() {
			$c = Int32\Type::zero();
			for ($zs = $this; ! $zs->__isEmpty(); $zs = $zs->tail()) {
				$c = Int32\Module::increment($c);
			}
			return $c;
		}

		/**
		 * This method returns the tail of this linked list.
		 *
		 * @access public
		 * @abstract
		 * @return LinkedList\Type                                  the tail of this linked list
		 */
		public abstract function tail();

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @abstract
		 * @param integer $depth                                    how many levels to unbox
		 * @return array                                            the un-boxed value
		 */
		public abstract function unbox($depth = 0);

		#endregion

	}

}