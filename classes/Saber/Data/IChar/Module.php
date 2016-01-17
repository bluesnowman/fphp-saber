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

namespace Saber\Data\IChar {

	include_once(implode(DIRECTORY_SEPARATOR, array(dirname(__FILE__), '..', '..', 'Ext', 'mbstring.php')));

	use \Saber\Core;
	use \Saber\Data;
	use \Saber\Data\IBool;
	use \Saber\Data\IChar;
	use \Saber\Data\IInt32;
	use \Saber\Data\IString;
	use \Saber\Data\ITrit;

	/**
	 * @see http://www.haskell.org/ghc/docs/6.4.2/html/libraries/base/Data-IChar.html
	 * @see http://php.net/manual/en/ref.ctype.php
	 * @see http://php.net/manual/en/regexp.reference.unicode.php
	 */
	final class Module extends Data\Module {

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the value to be evaluated
		 * @param IChar\Type $y                                      the default value
		 * @return IChar\Type                                        the result
		 */
		public static function nvl(IChar\Type $x = null, IChar\Type $y = null) {
			return ($x !== null) ? $x : (($y !== null) ? $y : IChar\Type::box(chr(0)));
		}

		/**
		 * This method returns the value as an IInt32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the object to be converted
		 * @return IInt32\Type                                       the value as an IInt32
		 */
		public static function toInt32(IChar\Type $x) {
			return IInt32\Type::box(ord($x->unbox()));
		}

		/**
		 * This method returns the corresponding lower case letter, if any.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the object to be converted
		 * @return IChar\Type                                        the lower case letter
		 *
		 * @see http://php.net/manual/en/function.mb-strtolower.php
		 */
		public static function toLowerCase(IChar\Type $x) {
			return IChar\Type::box(mb_strtolower($x->unbox(), IChar\Type::UTF_8_ENCODING));
		}

		/**
		 * This method returns the corresponding upper case letter, if any.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the object to be converted
		 * @return IChar\Type                                        the upper case letter
		 *
		 * @see http://php.net/manual/en/function.mb-strtoupper.php
		 */
		public static function toUpperCase(IChar\Type $x) {
			return IChar\Type::box(mb_strtoupper($x->unbox(), IChar\Type::UTF_8_ENCODING));
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(IChar\Type $x, Core\Type $y) { // ==
			$type = $x->__typeOf();
			if ($y !== null) {
				if ($y instanceof $type) {
					return IBool\Type::box($x->unbox() == $y->unbox());
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(IChar\Type $x, Core\Type $y) { // ===
			if ($y !== null) {
				if ($x->__typeOf() === $y->__typeOf()) {
					return IBool\Type::box($x->unbox() === $y->unbox());
				}
			}
			return IBool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(IChar\Type $x, Core\Type $y) { // !=
			return IBool\Module::not(IChar\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the left operand
		 * @param Core\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(IChar\Type $x, Core\Type $y) { // !==
			return IBool\Module::not(IChar\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the left operand
		 * @param IChar\Type $y                                      the right operand
		 * @return ITrit\Type                                        the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(IChar\Type $x, IChar\Type $y) {
			return ITrit\Type::box($x->unbox() <=> $y->unbox());
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the left operand
		 * @param IChar\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(IChar\Type $x, IChar\Type $y) { // >=
			return IBool\Type::box(IChar\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the left operand
		 * @param IChar\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(IChar\Type $x, IChar\Type $y) { // >
			return IBool\Type::box(IChar\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the left operand
		 * @param IChar\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(IChar\Type $x, IChar\Type $y) { // <=
			return IBool\Type::box(IChar\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the left operand
		 * @param IChar\Type $y                                      the right operand
		 * @return IBool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(IChar\Type $x, IChar\Type $y) { // <
			return IBool\Type::box(IChar\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the left operand
		 * @param IChar\Type $y                                      the right operand
		 * @return IChar\Type                                        the maximum value
		 */
		public static function max(IChar\Type $x, IChar\Type $y) {
			return (IChar\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the left operand
		 * @param IChar\Type $y                                      the right operand
		 * @return IChar\Type                                        the minimum value
		 */
		public static function min(IChar\Type $x, IChar\Type $y) {
			return (IChar\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Evaluating Operations

		/**
		 * This method returns whether this character is an alphabetic character.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is an alphabetic
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-alpha.php
		 */
		public static function isAlpha(IChar\Type $x) {
			return IBool\Type::box(ctype_alpha($x->unbox()));
		}

		/**
		 * This method returns whether this character is an alphanumeric character.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is an alphanumeric
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-alnum.php
		 */
		public static function isAlphaNum(IChar\Type $x) {
			return IBool\Type::box(ctype_alnum($x->unbox()));
		}

		/**
		 * This method returns whether this character is an ASCII character.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is an ASCII
		 *                                                          character
		 */
		public static function isAscii(IChar\Type $x) {
			return IBool\Type::box(preg_match('/^[\x20-\x7f]$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a control character.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is a control
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-cntrl.php
		 */
		public static function isControl(IChar\Type $x) {
			return IBool\Type::box(ctype_cntrl($x->unbox()));
		}

		/**
		 * This method returns whether this character is a Cyrillic character.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is a Cyrillic
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isCyrillic(IChar\Type $x) {
			return IBool\Type::box(preg_match('/^\p{Cyrillic}$/u', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a digit.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is a digit
		 *
		 * @see http://php.net/manual/en/function.ctype-digit.php
		 */
		public static function isDigit(IChar\Type $x) {
			return IBool\Type::box(ctype_digit($x->unbox()));
		}

		/**
		 * This method returns whether this character is a hex-digit (i.e. '/^[0-9a-f]$/i').
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is a hex-digit
		 *
		 * @see http://php.net/manual/en/function.ctype-xdigit.php
		 */
		public static function isHexDigit(IChar\Type $x) {
			return IBool\Type::box(ctype_xdigit($x->unbox()));
		}

		/**
		 * This method returns whether this character is an ISO 8859-1 (Latin-1) character.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is an Latin-1
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isLatin1(IChar\Type $x) {
			return IBool\Type::box(preg_match('/^\p{Latin}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a lower case character.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is a lower case
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-lower.php
		 */
		public static function isLowerCase(IChar\Type $x) {
			return IBool\Type::box(ctype_lower($x->unbox()));
		}

		/**
		 * This method returns whether this character is a number.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is a number
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isNumber(IChar\Type $x) {
			return IBool\Type::box(preg_match('/^\p{N}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is an oct-digit.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is an oct-digit
		 */
		public static function isOctDigit(IChar\Type $x) {
			return IBool\Type::box(preg_match('/^[0-7]$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a printable character.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is a printable
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-print.php
		 */
		public static function isPrintable(IChar\Type $x) {
			return IBool\Type::box(ctype_print($x->unbox()));
		}

		/**
		 * This method returns whether this character is a punctuation character.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is a punctuation
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-punct.php
		 */
		public static function isPunctuation(IChar\Type $x) {
			return IBool\Type::box(ctype_punct($x->unbox()));
		}

		/**
		 * This method returns whether this character is a separator character.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is a mark
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isSeparator(IChar\Type $x) {
			return IBool\Type::box(preg_match('/^\p{Z}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a space.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is a space
		 *
		 * @see http://php.net/manual/en/function.ctype-space.php
		 */
		public static function isSpace(IChar\Type $x) {
			return IBool\Type::box(ctype_space($x->unbox()));
		}

		/**
		 * This method returns whether this character is a symbol.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is a symbol
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isSymbol(IChar\Type $x) {
			return IBool\Type::box(preg_match('/^\p{S}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is an upper case character.
		 *
		 * @access public
		 * @static
		 * @param IChar\Type $x                                      the character to be evaluated
		 * @return IBool\Type                                        whether this is an upper case
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-upper.php
		 */
		public static function isUpperCase(IChar\Type $x) {
			return IBool\Type::box(ctype_upper($x->unbox()));
		}

		#endregion

	}

}