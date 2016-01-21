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

namespace Saber\Data\IEither {

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IBool;
	use \Saber\Data\ICollection;
	use \Saber\Data\IEither;
	use \Saber\Data\IString;
	use \Saber\Data\IUnit;
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
		protected static $module = '\\Saber\\Data\\IEither\\Module';

		#endregion

		#region Methods -> Initialization

		/**
		 * This method enforces that the specified class is a covariant.
		 *
		 * @access public
		 * @static
		 * @param IEither\Type $x                                   the class to be evaluated
		 * @return IEither\Type                                     the class
		 * @throw Throwable\InvalidArgument\Exception               indicated that the specified class
		 *                                                          is not a covariant
		 */
		public static function covariant(IEither\Type $x) : IEither\Type {
			if (!($x instanceof static)) {
				throw new Throwable\InvalidArgument\Exception('Invalid class type.  Expected a class of type ":type1", but got ":type2".', array(':type1' => get_called_class(), ':type2' => get_class($x)));
			}
			return $x;
		}

		/**
		 * This method returns a left node containing the specified value.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $x                                      the object to be boxed
		 * @return IEither\Left\Type                                a left node
		 */
		public static function left(Core\Type $x = null) : IEither\Left\Type {
			if ($x === null) {
				$x = IUnit\Type::instance();
			}
			return new IEither\Left\Type($x);
		}

		/**
		 * This method returns a right node containing the specified value.
		 *
		 * @access public
		 * @static
		 * @param Core\Type $x                                      the object to be boxed
		 * @return IEither\Right\Type                               a right node
		 */
		public static function right(Core\Type $x = null) : IEither\Right\Type {
			if ($x === null) {
				$x = IUnit\Type::instance();
			}
			return new IEither\Right\Type($x);
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This constructor initializes the class with the specified object.
		 *
		 * @access public
		 * @final
		 * @param Core\Type $x                                      the object to be boxed
		 */
		public final function __construct(Core\Type $x) {
			$this->value = $x;
		}

		/**
		 * This method returns whether the node is a Left\Type.
		 *
		 * @access public
		 * @final
		 * @return bool                                             whether the node is a Left\Type
		 */
		public final function __isLeft() : bool {
			return ($this instanceof IEither\Left\Type);
		}

		/**
		 * This method returns whether the node is a Right\Type.
		 *
		 * @access public
		 * @final
		 * @return bool                                             whether the node is a Right\Type
		 */
		public final function __isRight() : bool {
			return ($this instanceof IEither\Right\Type);
		}

		/**
		 * This method returns the item stored within the either.
		 *
		 * @access public
		 * @final
		 * @return mixed                                            the stored item's value
		 */
		public final function __item() {
			return $this->item()->unbox();
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object as a string
		 */
		public final function __toString() {
			return (string) serialize($this->value);
		}

		#endregion

		#region Methods -> Object Oriented

		/**
		 * This method returns whether the node is a Left\Type.
		 *
		 * @access public
		 * @final
		 * @return IBool\Type                                       whether the node is a Left\Type
		 */
		public final function isLeft() : IBool\Type {
			return IBool\Type::box($this->__isLeft());
		}

		/**
		 * This method returns whether the node is a Right\Type.
		 *
		 * @access public
		 * @final
		 * @return IBool\Type                                       whether the node is a Right\Type
		 */
		public final function isRight() : IBool\Type {
			return IBool\Type::box($this->__isRight());
		}

		/**
		 * This method returns the item stored within the either.
		 *
		 * @access public
		 * @final
		 * @return Core\Type                                        the stored item
		 */
		public final function item() : Core\Type {
			return $this->value;
		}

		/**
		 * This method returns a left projection of this either.
		 *
		 * @access public
		 * @final
		 * @return IEither\Left\Projection                          a left projection
		 */
		public final function projectLeft() : IEither\Left\Projection {
			return new IEither\Left\Projection($this);
		}

		/**
		 * This method returns a right projection of this either.
		 *
		 * @access public
		 * @final
		 * @return IEither\Right\Projection                         a right projection
		 */
		public final function projectRight() : IEither\Right\Projection {
			return new IEither\Right\Projection($this);
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @final
		 * @param int $depth                                        how many levels to unbox
		 * @return mixed                                            the un-boxed value
		 */
		public final function unbox(int $depth = 0) {
			if ($depth > 0) {
				if ($this->value instanceof Core\Boxable\Type) {
					$this->value->unbox($depth - 1);
				}
			}
			return $this->value;
		}

		#endregion

	}

}