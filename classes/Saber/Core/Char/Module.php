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

namespace Saber\Core\Char {

	use \Saber\Control;
	use \Saber\Core;

	/**
	 * @see http://php.net/manual/en/ref.ctype.php
	 * @see http://php.net/manual/en/regexp.reference.unicode.php
	 */
	class Module {

		#region Methods -> Data Typing

		/**
		 * This method casts the char value to an int32 value.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the object to be casted
		 * @return Core\Int32                                       an object representing the casted
		 *                                                          value
		 */
		public static function toInt32(Core\Char $x) {
			return Core\Int32::create(ord($x->unbox()));
		}

		/**
		 * This method converts the boolean value to a string value.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the object to be converted
		 * @return Core\String                                      an object representing the converted
		 *                                                          value
		 */
		public static function toString(Core\Char $x) {
			return Core\String::create($x->__toString());
		}

		/**
		 * This method returns the object's class type.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the object to be evaluated
		 * @return Core\String                                      the object's class type
		 */
		public static function typeOf(Core\Char $x) {
			return Core\String::create(get_class($x));
		}

		#endregion

		#region Methods -> Equality

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the left operand
		 * @param Core\Data $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Core\Char $x, Core\Data $y) { // ==
			if ($y instanceof Core\Char) {
				return Core\Bool::create($x->unbox() == $y->unbox());
			}
			return Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the left operand
		 * @param Core\Data $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Core\Char $x, Core\Data $y) { // ===
			if (get_class($x) === get_class($y)) {
				return Core\Bool::create($x->unbox() === $y->unbox());
			}
			return Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the left operand
		 * @param Core\Data $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Core\Char $x, Core\Data $y) { // !=
			return Core\Bool\Module::not(Core\Char\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the left operand
		 * @param Core\Data $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Core\Char $x, Core\Data $y) { // !==
			return Core\Bool\Module::not(Core\Char\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the left operand
		 * @param Core\Char $y                                      the right operand
		 * @return Core\Int32                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Core\Char $x, Core\Char $y) {
			$__x = $x->unbox();
			$__y = $y->unbox();

			if ($__x < $__y) {
				return Core\Int32::negative();
			}
			else if ($__x == $__y) {
				return Core\Int32::zero();
			}
			else { // ($__x > $__y)
				return Core\Int32::one();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the left operand
		 * @param Core\Char $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Core\Char $x, Core\Char $y) { // >=
			return (Core\Char\Module::compare($x, $y)->unbox() >= 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the left operand
		 * @param Core\Char $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Core\Char $x, Core\Char $y) { // >
			return (Core\Char\Module::compare($x, $y)->unbox() > 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the left operand
		 * @param Core\Char $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Core\Char $x, Core\Char $y) { // <=
			return (Core\Char\Module::compare($x, $y)->unbox() <= 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the left operand
		 * @param Core\Char $y                                      the right operand
		 * @return Core\Bool                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Core\Char $x, Core\Char $y) { // <
			return (Core\Char\Module::compare($x, $y)->unbox() < 0) ? Core\Bool::true() : Core\Bool::false();
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the left operand
		 * @param Core\Char $y                                      the right operand
		 * @return Core\Int32                                       the maximum value
		 */
		public static function max(Core\Char $x, Core\Char $y) {
			return (Core\Char\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the left operand
		 * @param Core\Char $y                                      the right operand
		 * @return Core\Int32                                       the minimum value
		 */
		public static function min(Core\Char $x, Core\Char $y) {
			return (Core\Char\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Other

		/**
		 * This method returns a choice block.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the object to be evaluated
		 * @return Control\Monad\Choice                             the choice monad
		 */
		public static function choice(Core\Char $x) {
			return Control\Monad::choice($x);
		}

		/**
		 * This method returns the object's hash code.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the object to be evaluated
		 * @return string                                           the object's hash code
		 */
		public static function hashCode(Core\Char $x) {
			return Core\String::create($x->__toString());
		}

		#endregion

		#region Methods -> Processing

		/**
		 * This method returns the corresponding lower case letter, if any.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the object to be converted
		 * @return Core\Char                                        the lower case letter
		 *
		 * @see http://php.net/manual/en/function.mb-strtolower.php
		 */
		public static function toLowerCase(Core\Char $x) {
			return Core\Char::create(mb_strtolower($x->unbox(), Core\Char::UTF_8_ENCODING));
		}

		/**
		 * This method returns the corresponding upper case letter, if any.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the object to be converted
		 * @return Core\Char                                        the upper case letter
		 *
		 * @see http://php.net/manual/en/function.mb-strtoupper.php
		 */
		public static function toUpperCase(Core\Char $x) {
			return Core\Char::create(mb_strtoupper($x->unbox(), Core\Char::UTF_8_ENCODING));
		}

		#endregion

		#region Methods -> Validation

		/**
		 * This method returns whether this character is an alphabetic character.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is an alphabetic
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-alpha.php
		 */
		public static function isAlpha(Core\Char $x) {
			return Core\Bool::create(ctype_alpha($x->unbox()));
		}

		/**
		 * This method returns whether this character is an alphanumeric character.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is an alphanumeric
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-alnum.php
		 */
		public static function isAlphaNum(Core\Char $x) {
			return Core\Bool::create(ctype_alnum($x->unbox()));
		}

		/**
		 * This method returns whether this character is an ASCII character.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is an ASCII
		 *                                                          character
		 */
		public static function isAscii(Core\Char $x) {
			return Core\Bool::create(preg_match('/^[\x20-\x7f]$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a control character.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is a control
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-cntrl.php
		 */
		public static function isControl(Core\Char $x) {
			return Core\Bool::create(ctype_cntrl($x->unbox()));
		}

		/**
		 * This method returns whether this character is a Cyrillic character.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is a Cyrillic
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isCyrillic(Core\Char $x) {
			return Core\Bool::create(preg_match('/^\p{Cyrillic}$/u', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a digit.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is a digit
		 *
		 * @see http://php.net/manual/en/function.ctype-digit.php
		 */
		public static function isDigit(Core\Char $x) {
			return Core\Bool::create(ctype_digit($x->unbox()));
		}

		/**
		 * This method returns whether this character is a hex-digit (i.e. '/^[0-9a-f]$/i').
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is a hex-digit
		 *
		 * @see http://php.net/manual/en/function.ctype-xdigit.php
		 */
		public static function isHexDigit(Core\Char $x) {
			return Core\Bool::create(ctype_xdigit($x->unbox()));
		}

		/**
		 * This method returns whether this character is an ISO 8859-1 (Latin-1) character.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is an Latin-1
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isLatin1(Core\Char $x) {
			return Core\Bool::create(preg_match('/^\p{Latin}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a lower case character.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is a lower case
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-lower.php
		 */
		public static function isLowerCase(Core\Char $x) {
			return Core\Bool::create(ctype_lower($x->unbox()));
		}

		/**
		 * This method returns whether this character is a number.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is a number
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isNumber(Core\Char $x) {
			return Core\Bool::create(preg_match('/^\p{N}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is an oct-digit.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is an oct-digit
		 */
		public static function isOctDigit(Core\Char $x) {
			return Core\Bool::create(preg_match('/^[0-7]$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a printable character.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is a printable
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-print.php
		 */
		public static function isPrintable(Core\Char $x) {
			return Core\Bool::create(ctype_print($x->unbox()));
		}

		/**
		 * This method returns whether this character is a punctuation character.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is a punctuation
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-punct.php
		 */
		public static function isPunctuation(Core\Char $x) {
			return Core\Bool::create(ctype_punct($x->unbox()));
		}

		/**
		 * This method returns whether this character is a separator character.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is a mark
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isSeparator(Core\Char $x) {
			return Core\Bool::create(preg_match('/^\p{Z}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a space.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is a space
		 *
		 * @see http://php.net/manual/en/function.ctype-space.php
		 */
		public static function isSpace(Core\Char $x) {
			return Core\Bool::create(ctype_space($x->unbox()));
		}

		/**
		 * This method returns whether this character is a symbol.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is a symbol
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isSymbol(Core\Char $x) {
			return Core\Bool::create(preg_match('/^\p{S}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is an upper case character.
		 *
		 * @access public
		 * @static
		 * @param Core\Char $x                                      the character to be evaluated
		 * @return Core\Bool                                        whether this is an upper case
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-upper.php
		 */
		public static function isUpperCase(Core\Char $x) {
			return Core\Bool::create(ctype_upper($x->unbox()));
		}

		#endregion

	}

}