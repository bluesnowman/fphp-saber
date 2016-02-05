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

namespace Saber\Throwable\Unknown {

	use \Saber\Core;
	use \Saber\Data\IInt32;
	use \Saber\Throwable;

	class Exception extends \RuntimeException implements Throwable\Runtime\Exception, Core\Comparable\Type, Core\Equality\Type {

		#region Traits

		use Throwable\Runtime\Exception\Impl;

		#endregion

		#region Properties

		/**
		 * This variable stores a reference to the exception actually
		 * being thrown.
		 *
		 * @access protected
		 * @var \Exception
		 */
		protected $exception;

		#endregion

		#region Methods -> Initialization

		/**
		 * This constructor creates a new runtime exception.
		 *
		 * @access public
		 * @param \Exception $e                                     the exception being boxed
		 */
		public function __construct(\Exception $e) {
			parent::__construct($e->getMessage(), $e->getCode());
			$this->exception = $e;
		}

		#endregion

		#region Methods -> Native Oriented

		/**
		 * This method returns the exception code.
		 *
		 * @access public
		 * @final
		 * @return integer                                          the exception code
		 */
		public final function __getCode() {
			return $this->exception->getCode();
		}

		/**
		 * This method returns the source file's name.
		 *
		 * @access public
		 * @final
		 * @return string                                           the source file's name
		 */
		public final function __getFile() {
			return $this->exception->getFile();
		}

		/**
		 * This method returns the line at which the exception was thrown.
		 *
		 * @access public
		 * @final
		 * @return integer                                          the source line
		 */
		public final function __getLine() {
			return $this->exception->getLine();
		}

		/**
		 * This method returns the exception message.
		 *
		 * @access public
		 * @final
		 * @return string                                           the exception message
		 */
		public final function __getMessage() {
			return $this->exception->getMessage();
		}

		/**
		 * This method returns any backtrace information.
		 *
		 * @access public
		 * @final
		 * @return array                                            any backtrace information
		 */
		public final function __getTrace() {
			return $this->exception->getTrace();
		}

		/**
		 * This method returns the backtrace information as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           the backtrace information
		 */
		public final function __getTraceAsString() {
			return $this->exception->getTraceAsString();
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object's hash code
		 */
		public final function __hashCode() : string {
			return spl_object_hash($this->exception);
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object as a string
		 */
		public final function __toString() {
			return sprintf(
				'%s [ %s ]: %s ~ %s [ %d ]',
				$this->__typeOf(),
				$this->exception->getCode(),
				strip_tags($this->exception->getMessage()),
				$this->exception->getFile(),
				$this->exception->getLine()
			);
		}

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @final
		 * @return string                                           the object's class type
		 */
		public final function __typeOf() : string {
			return get_class($this->exception);
		}

		#endregion

	}

}
