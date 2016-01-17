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

namespace Saber\Data\IRatio {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IFractional;
	use \Saber\Data\IInt32;
	use \Saber\Data\IRatio;
	use \Saber\Data\IString;
	use \Saber\Throwable;

	final class Type extends Data\Type implements IFractional\Type {

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
		protected static $module = '\\Saber\\Data\\IRatio\\Module';

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
		 * This method enforces that the specified class is a covariant.
		 *
		 * @access public
		 * @static
		 * @param IRatio\Type $x                                     the class to be evaluated
		 * @return IRatio\Type                                       the class
		 */
		public static function covariant(IRatio\Type $x) {
			return $x;
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return IRatio\Type                                       the boxed object
		 */
		public static function box($value/*...*/) {
			$values = (is_array($value)) ? $value : func_get_args();
			$values = array_map(function($value) {
				return ($value instanceof IInt32\Type) ? $value : IInt32\Type::box($value);
			}, $values);
			return new IRatio\Type($values[0], $values[1]);
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return IRatio\Type                                       the boxed object
		 */
		public static function make($value/*...*/) {
			$values = (is_array($value)) ? $value : func_get_args();
			$values = array_map(function($value) {
				return ($value instanceof IInt32\Type) ? $value : IInt32\Type::make($value);
			}, $values);

			$denominator = $values[1];

			$signum = IInt32\Module::signum($denominator)->unbox();
			if ($signum == 0) {
				throw new Throwable\InvalidArgument\Exception('Unable to create ratio. Denominator must not be zero.');
			}

			$numerator = $values[0];

			if (IInt32\Module::signum($numerator)->unbox() == 0) {
				return IRatio\Type::zero();
			}

			if ($signum < 0) {
				$numerator = IInt32\Module::negate($numerator);
				$denominator = IInt32\Module::negate($denominator);
			}

			$gcd = IInt32\Module::gcd($numerator, $denominator);
			if (!IInt32\Module::eq($gcd, IInt32\Type::one())->unbox()) {
				$numerator = IInt32\Module::divide($numerator, $gcd);
				$denominator = IInt32\Module::divide($denominator, $gcd);
			}

			return new IRatio\Type($numerator, $denominator);
		}

		/**
		 * This method returns an object with a "-1" value.
		 *
		 * @access public
		 * @static
		 * @return IInt32\Type                                       the object
		 */
		public static function negative() {
			if (!isset(static::$singletons[-1])) {
				static::$singletons[-1] = new IRatio\Type(IInt32\Type::negative(), IInt32\Type::one());
			}
			return static::$singletons[-1];
		}

		/**
		 * This method returns an object with a "1" value.
		 *
		 * @access public
		 * @static
		 * @return IInt32\Type                                       the object
		 */
		public static function one() {
			if (!isset(static::$singletons[1])) {
				static::$singletons[1] = new IRatio\Type(IInt32\Type::one(), IInt32\Type::one());
			}
			return static::$singletons[1];
		}

		/**
		 * This method returns an object with a "0" value.
		 *
		 * @access public
		 * @static
		 * @return IInt32\Type                                       the object
		 */
		public static function zero() {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new IRatio\Type(IInt32\Type::zero(), IInt32\Type::one());
			}
			return static::$singletons[0];
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @final
		 * @param IInt32\Type $numerator                             the numerator
		 * @param IInt32\Type $denominator                           the denominator
		 */
		public final function __construct(IInt32\Type $numerator, IInt32\Type $denominator) {
			$this->value = array($numerator, $denominator);
		}

		/**
		 * This method returns the denominator.
		 *
		 * @access public
		 * @final
		 * @return IInt32\Type                                       the denominator
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
		 * @return IInt32\Type                                       the numerator
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
		 * @return IInt32\Type                                       the denominator
		 */
		public final function denominator() {
			return $this->value[1];
		}

		/**
		 * This method returns the numerator.
		 *
		 * @access public
		 * @final
		 * @return IInt32\Type                                       the numerator
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