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

namespace Saber\Data\Tuple {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Bool;
	use \Saber\Data\Collection;
	use \Saber\Data\Int32;
	use \Saber\Data\Tuple;
	use \Saber\Throwable;

	final class Type extends Data\Type implements Core\Boxable\Type, Collection\Type {

		#region Properties

		/**
		 * This variable stores the class path to this class' module.
		 *
		 * @access protected
		 * @static
		 * @var string
		 */
		protected static $module = '\\Saber\\Data\\Tuple\\Module';

		#endregion

		#region Methods -> Initialization

		/**
		 * This method enforces that the specified class is covariant.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $x                                      the class to be evaluated
		 * @return Tuple\Type                                       the class
		 * @throw Throwable\InvalidArgument\Exception               indicated that the specified class
		 *                                                          is not a covariant
		 */
		public static function covariant(Core\Type $x) {
			if (!($x instanceof static)) {
				throw new Throwable\InvalidArgument\Exception('Invalid class type.  Expected a class of type ":type1", but got ":type2".', array(':type1' => get_called_class(), ':type2' => get_class($x)));
			}
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Tuple\Type                                       the boxed object
		 */
		public static function box($value/*...*/) {
			$xs = (is_array($value)) ? $value : func_get_args();
			return new Tuple\Type($xs);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Tuple\Type                                       the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function make($value/*...*/) {
			$xs = (is_array($value)) ? $value : func_get_args();
			$count = count($xs);
			if ($count < 2) {
				throw new Throwable\InvalidArgument\Exception('Unable to box value(s). Tuple must have at least 2 objects, but got ":count".', array(':count' => $count));
			}
			foreach ($xs as $x) {
				if (!(($x === null) || (is_object($x) && ($x instanceof Core\Type)))) {
					$type = gettype($x);
					if ($type == 'object') {
						$type = get_class($x);
					}
					throw new Throwable\InvalidArgument\Exception('Unable to box value(s). Expected a boxed object, but got ":type".', array(':type' => $type));
				}
			}
			return new Tuple\Type($xs);
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
		 * @return boolean                                          whether the list is empty
		 */
		public final function __isEmpty() {
			return empty($this->value);
		}

		/**
		 * This method evaluates whether the tuple is a pair.
		 *
		 * @access public
		 * @final
		 * @return boolean                                          whether the tuple is a pair
		 */
		public final function __isPair() {
			return ($this->__length() == 2);
		}

		/**
		 * This method returns the item at the specified index.
		 *
		 * @access public
		 * @final
		 * @param Int32\Type $i                                     the index of the item
		 * @return mixed                                            the item at the specified index
		 */
		public final function __item(Int32\Type $i) {
			return $this->item($i)->unbox();
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @final
		 * @return integer                                          the length of this array list
		 */
		public final function __length() {
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
			return (string) serialize($this->unbox());
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the first item in the tuple.
		 *
		 * @access public
		 * @final
		 * @return mixed                                            the first item in the tuple
		 */
		public final function first() {
			return $this->value[0];
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
		 * This method evaluates whether the tuple is a pair.
		 *
		 * @access public
		 * @final
		 * @return Bool\Type                                        whether the tuple is a pair
		 */
		public final function isPair() {
			return Bool\Type::box($this->__isPair());
		}

		/**
		 * This method returns the item at the specified index.
		 *
		 * @access public
		 * @final
		 * @param Int32\Type $i                                     the index of the item
		 * @return Core\Type                                        the item at the specified index
		 */
		public final function item(Int32\Type $i) {
			return $this->value[$i->unbox()];
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @final
		 * @return Int32\Type                                       the length of this array list
		 */
		public final function length() {
			return Int32\Type::box($this->__length());
		}

		/**
		 * This method returns the second item in the tuple.
		 *
		 * @access public
		 * @final
		 * @return mixed                                            the second item in the tuple
		 */
		public final function second() {
			return $this->value[1];
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