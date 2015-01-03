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

namespace Saber\Data\Ratio {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\Fractional;
	use \Saber\Data\Int32;
	use \Saber\Data\Ratio;
	use \Saber\Data\String;
	use \Saber\Throwable;

	final class Type extends Data\Type implements Fractional\Type {

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
		protected static $module = '\\Saber\\Data\\Ratio\\Module';

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
		 * This method enforces that the specified class is covariant.
		 *
		 * @access public
		 * @static
		 * @param Ratio\Type $x                                     the class to be evaluated
		 * @return Ratio\Type                                       the class
		 */
		public static function covariant(Ratio\Type $x) {
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Ratio\Type                                       the boxed object
		 */
		public static function box($value/*...*/) {
			$values = (is_array($value)) ? $value : func_get_args();
			$values = array_map(function($value) {
				return ($value instanceof Int32\Type) ? $value : Int32\Type::box($value);
			}, $values);
			return new Ratio\Type($values[0], $values[1]);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Ratio\Type                                       the boxed object
		 */
		public static function make($value/*...*/) {
			$values = (is_array($value)) ? $value : func_get_args();
			$values = array_map(function($value) {
				return ($value instanceof Int32\Type) ? $value : Int32\Type::make($value);
			}, $values);

			$denominator = $values[1];

			$signum = Int32\Module::signum($denominator)->unbox();
			if ($signum == 0) {
				throw new Throwable\InvalidArgument\Exception('Unable to create ratio. Denominator must not be zero.');
			}

			$numerator = $values[0];

			if (Int32\Module::signum($numerator)->unbox() == 0) {
				return Ratio\Type::zero();
			}

			if ($signum < 0) {
				$numerator = Int32\Module::negate($numerator);
				$denominator = Int32\Module::negate($denominator);
			}

			$gcd = Int32\Module::gcd($numerator, $denominator);
			if (!Int32\Module::eq($gcd, Int32\Type::one())->unbox()) {
				$numerator = Int32\Module::divide($numerator, $gcd);
				$denominator = Int32\Module::divide($denominator, $gcd);
			}

			return new Ratio\Type($numerator, $denominator);
		}

		/**
		 * This method returns an object with a "-1" value.
		 *
		 * @access public
		 * @static
		 * @return Int32\Type                                       the object
		 */
		public static function negative() {
			if (!isset(static::$singletons[-1])) {
				static::$singletons[-1] = new Ratio\Type(Int32\Type::negative(), Int32\Type::one());
			}
			return static::$singletons[-1];
		}

		/**
		 * This method returns an object with a "1" value.
		 *
		 * @access public
		 * @static
		 * @return Int32\Type                                       the object
		 */
		public static function one() {
			if (!isset(static::$singletons[1])) {
				static::$singletons[1] = new Ratio\Type(Int32\Type::one(), Int32\Type::one());
			}
			return static::$singletons[1];
		}

		/**
		 * This method returns an object with a "0" value.
		 *
		 * @access public
		 * @static
		 * @return Int32\Type                                       the object
		 */
		public static function zero() {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new Ratio\Type(Int32\Type::zero(), Int32\Type::one());
			}
			return static::$singletons[0];
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
				if (!in_array($method, array('call', 'choice', 'unbox'))) {
					if (isset(static::$mixins[$method])) {
						array_unshift($args, $this);
						$result = call_user_func_array(static::$mixins[$method], $args);
						if ($result instanceof Core\Boxable\Type) {
							return $result->unbox();
						}
						return $result;
					}
					else if (method_exists(static::$module, $method)) {
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
				if (isset(static::$mixins[$method])) {
					array_unshift($args, $this);
					return call_user_func_array(static::$mixins[$method], $args);
				}
				else if (method_exists(static::$module, $method)) {
					array_unshift($args, $this);
					return call_user_func_array(array(static::$module, $method), $args);
				}
			}
			throw new Throwable\UnimplementedMethod\Exception('Unable to call method. No method ":method" exists in module ":module".', array(':module' => static::$module, ':method' => $method));
		}

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @final
		 * @param Int32\Type $numerator                             the numerator
		 * @param Int32\Type $denominator                           the denominator
		 */
		public final function __construct(Int32\Type $numerator, Int32\Type $denominator) {
			$this->value = array($numerator, $denominator);
		}

		/**
		 * This method returns the denominator.
		 *
		 * @access public
		 * @final
		 * @return Int32\Type                                       the denominator
		 */
		public final function __denominator() {
			return $this->denominator()->unbox();
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object's hash code
		 */
		public final function __hashCode() {
			return $this->__toString();
		}

		/**
		 * This method returns the numerator.
		 *
		 * @access public
		 * @final
		 * @return Int32\Type                                       the numerator
		 */
		public final function __numerator() {
			return $this->numerator()->unbox();
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object as a string
		 */
		public final function __toString() {
			return sprintf('%d / %d', $this->__numerator(), $this->__denominator());
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns the denominator.
		 *
		 * @access public
		 * @final
		 * @return Int32\Type                                       the denominator
		 */
		public final function denominator() {
			return $this->value[1];
		}

		/**
		 * This method returns the numerator.
		 *
		 * @access public
		 * @final
		 * @return Int32\Type                                       the numerator
		 */
		public final function numerator() {
			return $this->value[0];
		}

		/**
		 * This method returns the values contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param integer $depth                                    how many levels to unbox
		 * @return array                                            the un-boxed values
		 */
		public final function unbox($depth = 0) {
			if ($depth > 0) {
				return array($this->__numerator(), $this->__denominator());
			}
			return $this->value;
		}

		#endregion

	}

}