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

namespace Saber\Data\IOption {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IBool;
	use \Saber\Data\ICollection;
	use \Saber\Data\IInt32;
	use \Saber\Data\IOption;
	use \Saber\Data\IString;
	use \Saber\Throwable;

	abstract class Type extends Data\Type implements ICollection\Type {

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
		protected static $module = '\\Saber\\Data\\IOption\\Module';

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
		 * @param IOption\Type $x                                    the class to be evaluated
		 * @return IOption\Type                                      the class
		 * @throw Throwable\InvalidArgument\Exception               indicated that the specified class
		 *                                                          is not a covariant
		 */
		public static function covariant(IOption\Type $x) {
			if (!($x instanceof static)) {
				throw new Throwable\InvalidArgument\Exception('Invalid class type.  Expected a class of type ":type1", but got ":type2".', array(':type1' => get_called_class(), ':type2' => get_class($x)));
			}
			return $x;
		}

		/**
		 * This method returns a "none" option.
		 *
		 * @access public
		 * @static
		 * @return IOption\None\Type                                 the "none" option
		 */
		public static function none() {
			if (!isset(static::$singletons[0])) {
				static::$singletons[0] = new IOption\None\Type();
			}
			return static::$singletons[0];
		}

		/**
		 * This method returns a "some" option.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $x                                      the item to be stored
		 * @return IOption\Some\Type                                 the "some" option
		 */
		public static function some(Core\Type $x) {
			return new IOption\Some\Type($x);
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object's hash code
		 */
		public final function __hashCode() : string {
			return spl_object_hash($this->item());
		}

		/**
		 * This method returns whether this instance is a "some" option.
		 *
		 * @access public
		 * @final
		 * @return boolean                                          whether this instance is a "some"
		 *                                                          option
		 */
		public final function __isDefined() {
			return ($this instanceof IOption\Some\Type);
		}

		/**
		 * This method returns the item stored within the option.
		 *
		 * @access public
		 * @final
		 * @return mixed                                            the stored item's value
		 */
		public final function __item() {
			return $this->item()->unbox();
		}

		/**
		 * This method returns the size of this option.
		 *
		 * @access public
		 * @final
		 * @return integer                                          the size of this option
		 */
		public final function __size() {
			return ($this->__isDefined()) ? 1 : 0;
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object as a string
		 */
		public final function __toString() {
			return (string) serialize($this->item());
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns whether this instance is a "some" option.
		 *
		 * @access public
		 * @final
		 * @return IBool\Type                                        whether this instance is a "some"
		 *                                                          option
		 */
		public final function isDefined() {
			return IBool\Type::box($this->__isDefined());
		}

		/**
		 * This method returns the item stored within the option.
		 *
		 * @access public
		 * @abstract
		 * @return Core\Type                                        the stored item
		 */
		public abstract function item();

		/**
		 * This method returns the size of this option.
		 *
		 * @access public
		 * @final
		 * @return IInt32\Type                                       the size of this option
		 */
		public final function size() {
			return IInt32\Type::box($this->__size());
		}

		#endregion

	}

}