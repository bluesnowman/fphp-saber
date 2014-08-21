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

namespace Saber\Core {

	use \Saber\Core;
	use \Saber\Throwable;

	/**
	 * @see http://www.haskell.org/ghc/docs/6.4.2/html/libraries/base/Data-Char.html
	 * @see http://php.net/manual/en/ref.ctype.php
	 * @see http://php.net/manual/en/regexp.reference.unicode.php
	 */
	class Char implements Core\AnyVal {

		#region Traits

		use Core\AnyVal\Impl;

		#endregion

		#region Properties

		protected $encoding;

		#endregion

		#region Methods -> Boxing/Creation

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Core\Any                                         the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function box($value/*...*/) {
			$encoding = (func_num_args() > 1) ? func_get_arg(1) : 'UTF-8';
			if (is_string($value) && (mb_strlen($value, $encoding) == 1)) {
				return new static($value, $encoding);
			}
			else if (!is_string($value) && is_numeric($value)) {
				return new static(chr((int) $value), $encoding);
			}
			else {
				$type = gettype($value);
				if ($type == 'object') {
					$type = get_class($value);
				}
				throw new Throwable\InvalidArgument\Exception('Unable to box value. Expected a character, but got ":type".', array(':type' => $type));
			}
		}

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered "not" type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Core\Any                                         the boxed object
		 */
		public static function create($value/*...*/) {
			$encoding = (func_num_args() > 1) ? func_get_arg(1) : 'UTF-8';
			return new static($value, $encoding);
		}

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param char $value                                       the value to be assigned
		 * @param string $encoding                                  the character encoding to be used
		 */
		public function __construct($value, $encoding) {
			$this->value = (string) $value;
			$this->encoding = $encoding;
		}

		#endregion

		#region Methods -> Object Oriented -> Universal

		/**
		 * This method compares the specified object with the current object for order.
		 *
		 * @access public
		 * @param Core\Char $that                                   the object to be compared
		 * @return Core\Int32                                       whether the current object is less than,
		 *                                                          equal to, or greater than the specified
		 *                                                          object
		 */
		public function compareTo(Core\Char $that) {
			$x = $this->unbox();
			$y = $that->unbox();

			if ($x < $y) {
				return Core\Int32::negative();
			}
			else if ($x == $y) {
				return Core\Int32::zero();
			}
			else { // ($x > $y)
				return Core\Int32::one();
			}
		}

		/**
		 * This method returns whether this character is an alphabetic character.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is an alphabetic
		 *                                                          character
		 */
		public function isAlpha() {
			return Core\Bool::create(ctype_alpha($this->unbox()));
		}

		/**
		 * This method returns whether this character is an alphanumeric character.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is an alphanumeric
		 *                                                          character
		 */
		public function isAlphaNum() {
			return Core\Bool::create(ctype_alnum($this->unbox()));
		}

		/**
		 * This method returns whether this character is an ASCII character.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is an ASCII
		 *                                                          character
		 */
		public function isAscii() {
			return Core\Bool::create(preg_match('/^[\x20-\x7f]$/', $this->unbox()));
		}

		/**
		 * This method returns whether this character is a control character.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is a control
		 *                                                          character
		 */
		public function isControl() {
			return Core\Bool::create(ctype_cntrl($this->unbox()));
		}

		/**
		 * This method returns whether this character is a Cyrillic character.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is a Cyrillic
		 *                                                          character
		 */
		public function isCyrillic() {
			return Core\Bool::create(preg_match('/^\p{Cyrillic}$/u', $this->unbox()));
		}

		/**
		 * This method returns whether this character is a digit.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is a digit
		 */
		public function isDigit() {
			return Core\Bool::create(ctype_digit($this->unbox()));
		}

		/**
		 * This method returns whether this character is a hex-digit (i.e. '/^[0-9a-f]$/i').
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is a hex-digit
		 */
		public function isHexDigit() {
			return Core\Bool::create(ctype_xdigit($this->unbox()));
		}

		/**
		 * This method returns whether this character is an ISO 8859-1 (Latin-1) character.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is an Latin-1
		 *                                                          character
		 */
		public function isLatin1() {
			return Core\Bool::create(preg_match('/^\p{Latin}$/', $this->unbox()));
		}

		/**
		 * This method returns whether this character is a lower case character.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is a lower case
		 *                                                          character
		 */
		public function isLowerCase() {
			return Core\Bool::create(ctype_lower($this->unbox()));
		}

		/**
		 * This method returns whether this character is a number.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is a number
		 */
		public function isNumber() {
			return Core\Bool::create(preg_match('/^\p{N}$/', $this->unbox()));
		}

		/**
		 * This method returns whether this character is an oct-digit.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is an oct-digit
		 */
		public function isOctDigit() {
			return Core\Bool::create(preg_match('/^[0-7]$/', $this->unbox()));
		}

		/**
		 * This method returns whether this character is a printable character.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is a printable
		 *                                                          character
		 */
		public function isPrintable() {
			return Core\Bool::create(ctype_print($this->unbox()));
		}

		/**
		 * This method returns whether this character is a punctuation character.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is a punctuation
		 *                                                          character
		 */
		public function isPunctuation() {
			return Core\Bool::create(ctype_punct($this->unbox()));
		}

		/**
		 * This method returns whether this character is a separator character.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is a mark
		 */
		public function isSeparator() {
			return Core\Bool::create(preg_match('/^\p{Z}$/', $this->unbox()));
		}

		/**
		 * This method returns whether this character is a space.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is a space
		 */
		public function isSpace() {
			return Core\Bool::create(ctype_space($this->unbox()));
		}

		/**
		 * This method returns whether this character is a symbol.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is a symbol
		 */
		public function isSymbol() {
			return Core\Bool::create(preg_match('/^\p{S}$/', $this->unbox()));
		}

		/**
		 * This method returns whether this character is an upper case character.
		 *
		 * @access public
		 * @return Core\Bool                                        whether this is an upper case
		 *                                                          character
		 */
		public function isUpperCase() {
			return Core\Bool::create(ctype_upper($this->unbox()));
		}

		/**
		 * This method return the value as an integer. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @return Core\Int32                                       the value as an integer
		 */
		public function toInt32() {
			return Core\Int32::create(ord($this->unbox()));
		}

		/**
		 * This method returns the corresponding lower case letter, if any.
		 *
		 * @access public
		 * @return Core\Char                                        the lower case letter
		 */
		public function toLowerCase() {
			return Core\Char::create(mb_strtolower($this->unbox(), $this->encoding));
		}

		/**
		 * This method returns the corresponding upper case letter, if any.
		 *
		 * @access public
		 * @return Core\Char                                        the upper case letter
		 */
		public function toUpperCase() {
			return Core\Char::create(mb_strtoupper($this->unbox(), $this->encoding));
		}

		#endregion

	}

}