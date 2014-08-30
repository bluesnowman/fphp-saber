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

namespace Saber\Data\Char {

	use \Saber\Data;

	/**
	 * @see http://php.net/manual/en/ref.ctype.php
	 * @see http://php.net/manual/en/regexp.reference.unicode.php
	 */
	class Module {

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the left operand
		 * @param Data\Char $y                                      the right operand
		 * @return Data\Int32                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Data\Char $x, Data\Char $y) {
			$__x = $x->unbox();
			$__y = $y->unbox();

			if ($__x < $__y) {
				return Data\Int32::negative();
			}
			else if ($__x == $__y) {
				return Data\Int32::zero();
			}
			else { // ($__x > $__y)
				return Data\Int32::one();
			}
		}

		/**
		 * This method returns whether this character is an alphabetic character.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is an alphabetic
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-alpha.php
		 */
		public static function isAlpha(Data\Char $x) {
			return Data\Bool::create(ctype_alpha($x->unbox()));
		}

		/**
		 * This method returns whether this character is an alphanumeric character.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is an alphanumeric
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-alnum.php
		 */
		public static function isAlphaNum(Data\Char $x) {
			return Data\Bool::create(ctype_alnum($x->unbox()));
		}

		/**
		 * This method returns whether this character is an ASCII character.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is an ASCII
		 *                                                          character
		 */
		public static function isAscii(Data\Char $x) {
			return Data\Bool::create(preg_match('/^[\x20-\x7f]$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a control character.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is a control
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-cntrl.php
		 */
		public static function isControl(Data\Char $x) {
			return Data\Bool::create(ctype_cntrl($x->unbox()));
		}

		/**
		 * This method returns whether this character is a Cyrillic character.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is a Cyrillic
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isCyrillic(Data\Char $x) {
			return Data\Bool::create(preg_match('/^\p{Cyrillic}$/u', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a digit.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is a digit
		 *
		 * @see http://php.net/manual/en/function.ctype-digit.php
		 */
		public static function isDigit(Data\Char $x) {
			return Data\Bool::create(ctype_digit($x->unbox()));
		}

		/**
		 * This method returns whether this character is a hex-digit (i.e. '/^[0-9a-f]$/i').
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is a hex-digit
		 *
		 * @see http://php.net/manual/en/function.ctype-xdigit.php
		 */
		public static function isHexDigit(Data\Char $x) {
			return Data\Bool::create(ctype_xdigit($x->unbox()));
		}

		/**
		 * This method returns whether this character is an ISO 8859-1 (Latin-1) character.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is an Latin-1
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isLatin1(Data\Char $x) {
			return Data\Bool::create(preg_match('/^\p{Latin}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a lower case character.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is a lower case
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-lower.php
		 */
		public static function isLowerCase(Data\Char $x) {
			return Data\Bool::create(ctype_lower($x->unbox()));
		}

		/**
		 * This method returns whether this character is a number.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is a number
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isNumber(Data\Char $x) {
			return Data\Bool::create(preg_match('/^\p{N}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is an oct-digit.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is an oct-digit
		 */
		public static function isOctDigit(Data\Char $x) {
			return Data\Bool::create(preg_match('/^[0-7]$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a printable character.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is a printable
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-print.php
		 */
		public static function isPrintable(Data\Char $x) {
			return Data\Bool::create(ctype_print($x->unbox()));
		}

		/**
		 * This method returns whether this character is a punctuation character.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is a punctuation
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-punct.php
		 */
		public static function isPunctuation(Data\Char $x) {
			return Data\Bool::create(ctype_punct($x->unbox()));
		}

		/**
		 * This method returns whether this character is a separator character.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is a mark
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isSeparator(Data\Char $x) {
			return Data\Bool::create(preg_match('/^\p{Z}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a space.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is a space
		 *
		 * @see http://php.net/manual/en/function.ctype-space.php
		 */
		public static function isSpace(Data\Char $x) {
			return Data\Bool::create(ctype_space($x->unbox()));
		}

		/**
		 * This method returns whether this character is a symbol.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is a symbol
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isSymbol(Data\Char $x) {
			return Data\Bool::create(preg_match('/^\p{S}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is an upper case character.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the character to be evaluated
		 * @return Data\Bool                                        whether this is an upper case
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-upper.php
		 */
		public static function isUpperCase(Data\Char $x) {
			return Data\Bool::create(ctype_upper($x->unbox()));
		}

		/**
		 * This method casts the char value to an int32 value.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the object to be casted
		 * @return Data\Int32                                       an object representing the casted
		 *                                                          value
		 */
		public static function toInt32(Data\Char $x) {
			return Data\Int32::create(ord($x->unbox()));
		}

		/**
		 * This method returns the corresponding lower case letter, if any.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the object to be converted
		 * @return Data\Char                                        the lower case letter
		 *
		 * @see http://php.net/manual/en/function.mb-strtolower.php
		 */
		public static function toLowerCase(Data\Char $x) {
			return Data\Char::create(mb_strtolower($x->unbox(), Data\Char::UTF_8_ENCODING));
		}

		/**
		 * This method returns the corresponding upper case letter, if any.
		 *
		 * @access public
		 * @static
		 * @param Data\Char $x                                      the object to be converted
		 * @return Data\Char                                        the upper case letter
		 *
		 * @see http://php.net/manual/en/function.mb-strtoupper.php
		 */
		public static function toUpperCase(Data\Char $x) {
			return Data\Char::create(mb_strtoupper($x->unbox(), Data\Char::UTF_8_ENCODING));
		}

	}

}