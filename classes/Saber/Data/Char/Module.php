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

	include_once(implode(DIRECTORY_SEPARATOR, array(dirname(__FILE__), '..', 'Ext', 'mbstring.php')));

	use \Saber\Control;
	use \Saber\Data;
	use \Saber\Throwable;

	/**
	 * @see http://www.haskell.org/ghc/docs/6.4.2/html/libraries/base/Data-Char.html
	 * @see http://php.net/manual/en/ref.ctype.php
	 * @see http://php.net/manual/en/regexp.reference.unicode.php
	 */
	class Module extends Data\Type implements Data\Type\Boxable {

		#region Constants

		/**
		 * This constant stores the string representing a UTF-8 encoding.
		 *
		 * @access public
		 * @const string
		 */
		const UTF_8_ENCODING = 'UTF-8';

		#endregion

		#region Methods -> Implementation

		/**
		 * This constructor initializes the class with the specified value.
		 *
		 * @access public
		 * @param char $value                                       the value to be assigned
		 */
		public function __construct($value) {
			$this->value = (string) $value;
		}

		/**
		 * This method returns the object as a string.
		 *
		 * @access public
		 * @return string                                           the object as a string
		 */
		public function __toString() {
			return $this->value;
		}

		/**
		 * This method returns the value contained within the boxed object.
		 *
		 * @access public
		 * @param integer $depth                                    how many levels to unbox
		 * @return mixed                                            the un-boxed value
		 */
		public function unbox($depth = 0) {
			return $this->value;
		}

		#endregion

		#region Methods -> Instantiation

		/**
		 * This method returns a value as a boxed object.  A value is typically a PHP typed
		 * primitive or object.  It is considered type-safe.
		 *
		 * @access public
		 * @static
		 * @param mixed $value                                      the value(s) to be boxed
		 * @return Data\Type                                        the boxed object
		 * @throws Throwable\InvalidArgument\Exception              indicates an invalid argument
		 */
		public static function box($value/*...*/) {
			if (is_string($value)) {
				if (func_num_args() > 1) {
					$encoding = func_get_arg(1);
					$value = mb_convert_encoding($value, Char\Type::UTF_8_ENCODING, $encoding);
				}
				$length = mb_strlen($value, Char\Type::UTF_8_ENCODING);
				if ($length != 1) {
					throw new Throwable\InvalidArgument\Exception('Unable to box value. Expected a character, but got "string" of length ":length".', array(':length' => $length));
				}
				return new Char\Type($value);
			}
			else if (!is_string($value) && is_numeric($value)) {
				return new Char\Type(chr((int) $value));
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
		 * @return Data\Type                                        the boxed object
		 */
		public static function create($value/*...*/) {
			return new Char\Type($value);
		}

		#endregion

		#region Methods -> Data Typing

		/**
		 * This method return the value as an Int32. Note: Using this method may result in
		 * lost of precision.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the object to be converted
		 * @return Int32\Type                                       the value as an Int32
		 */
		public static function toInt32(Char\Type $x) {
			return Int32\Type::create(ord($x->unbox()));
		}

		/**
		 * This method returns the value as a String.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the object to be converted
		 * @return String\Type                                      the value as a String
		 */
		public static function toString(Char\Type $x) {
			return String\Module::create($x->__toString());
		}

		#endregion

		#region Methods -> Equality

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Char\Type $x, Data\Type $y) { // ==
			$class = get_class($x);
			if ($y instanceof $class) {
				return Bool\Module::create($x->unbox() == $y->unbox());
			}
			return Bool\Module::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Char\Type $x, Data\Type $y) { // ===
			if (get_class($x) === get_class($y)) {
				return Bool\Module::create($x->unbox() === $y->unbox());
			}
			return Bool\Module::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Char\Type $x, Data\Type $y) { // !=
			return Bool\Module::not(Char\Module::eq($x, $y));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the left operand
		 * @param Data\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Char\Type $x, Data\Type $y) { // !==
			return Bool\Module::not(Char\Module::id($x, $y));
		}

		#endregion

		#region Methods -> Ordering

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the left operand
		 * @param Char\Type $y                                      the right operand
		 * @return Int32\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Char\Type $x, Char\Type $y) {
			$__x = $x->unbox();
			$__y = $y->unbox();

			if ($__x < $__y) {
				return Int32\Type::negative();
			}
			else if ($__x == $__y) {
				return Int32\Type::zero();
			}
			else { // ($__x > $__y)
				return Int32\Type::one();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the left operand
		 * @param Char\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Char\Type $x, Char\Type $y) { // >=
			return Bool\Module::create(Char\Module::compare($x, $y)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the left operand
		 * @param Char\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Char\Type $x, Char\Type $y) { // >
			return Bool\Module::create(Char\Module::compare($x, $y)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the left operand
		 * @param Char\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Char\Type $x, Char\Type $y) { // <=
			return Bool\Module::create(Char\Module::compare($x, $y)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the left operand
		 * @param Char\Type $y                                      the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Char\Type $x, Char\Type $y) { // <
			return Bool\Module::create(Char\Module::compare($x, $y)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the left operand
		 * @param Char\Type $y                                      the right operand
		 * @return Int32\Type                                       the maximum value
		 */
		public static function max(Char\Type $x, Char\Type $y) {
			return (Char\Module::compare($x, $y)->unbox() >= 0) ? $x : $y;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the left operand
		 * @param Char\Type $y                                      the right operand
		 * @return Int32\Type                                       the minimum value
		 */
		public static function min(Char\Type $x, Char\Type $y) {
			return (Char\Module::compare($x, $y)->unbox() <= 0) ? $x : $y;
		}

		#endregion

		#region Methods -> Other

		/**
		 * This method returns a choice block.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the object to be evaluated
		 * @return Control\Monad\Choice                             the choice monad
		 */
		public static function choice(Char\Type $x) {
			return Control\Monad::choice($x);
		}

		#endregion

		#region Methods -> Processing

		/**
		 * This method returns the corresponding lower case letter, if any.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the object to be converted
		 * @return Char\Type                                        the lower case letter
		 *
		 * @see http://php.net/manual/en/function.mb-strtolower.php
		 */
		public static function toLowerCase(Char\Type $x) {
			return Char\Module::create(mb_strtolower($x->unbox(), Char\Type::UTF_8_ENCODING));
		}

		/**
		 * This method returns the corresponding upper case letter, if any.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the object to be converted
		 * @return Char\Type                                        the upper case letter
		 *
		 * @see http://php.net/manual/en/function.mb-strtoupper.php
		 */
		public static function toUpperCase(Char\Type $x) {
			return Char\Module::create(mb_strtoupper($x->unbox(), Char\Type::UTF_8_ENCODING));
		}

		#endregion

		#region Methods -> Validation

		/**
		 * This method returns whether this character is an alphabetic character.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is an alphabetic
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-alpha.php
		 */
		public static function isAlpha(Char\Type $x) {
			return Bool\Module::create(ctype_alpha($x->unbox()));
		}

		/**
		 * This method returns whether this character is an alphanumeric character.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is an alphanumeric
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-alnum.php
		 */
		public static function isAlphaNum(Char\Type $x) {
			return Bool\Module::create(ctype_alnum($x->unbox()));
		}

		/**
		 * This method returns whether this character is an ASCII character.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is an ASCII
		 *                                                          character
		 */
		public static function isAscii(Char\Type $x) {
			return Bool\Module::create(preg_match('/^[\x20-\x7f]$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a control character.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is a control
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-cntrl.php
		 */
		public static function isControl(Char\Type $x) {
			return Bool\Module::create(ctype_cntrl($x->unbox()));
		}

		/**
		 * This method returns whether this character is a Cyrillic character.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is a Cyrillic
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isCyrillic(Char\Type $x) {
			return Bool\Module::create(preg_match('/^\p{Cyrillic}$/u', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a digit.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is a digit
		 *
		 * @see http://php.net/manual/en/function.ctype-digit.php
		 */
		public static function isDigit(Char\Type $x) {
			return Bool\Module::create(ctype_digit($x->unbox()));
		}

		/**
		 * This method returns whether this character is a hex-digit (i.e. '/^[0-9a-f]$/i').
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is a hex-digit
		 *
		 * @see http://php.net/manual/en/function.ctype-xdigit.php
		 */
		public static function isHexDigit(Char\Type $x) {
			return Bool\Module::create(ctype_xdigit($x->unbox()));
		}

		/**
		 * This method returns whether this character is an ISO 8859-1 (Latin-1) character.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is an Latin-1
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isLatin1(Char\Type $x) {
			return Bool\Module::create(preg_match('/^\p{Latin}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a lower case character.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is a lower case
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-lower.php
		 */
		public static function isLowerCase(Char\Type $x) {
			return Bool\Module::create(ctype_lower($x->unbox()));
		}

		/**
		 * This method returns whether this character is a number.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is a number
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isNumber(Char\Type $x) {
			return Bool\Module::create(preg_match('/^\p{N}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is an oct-digit.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is an oct-digit
		 */
		public static function isOctDigit(Char\Type $x) {
			return Bool\Module::create(preg_match('/^[0-7]$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a printable character.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is a printable
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-print.php
		 */
		public static function isPrintable(Char\Type $x) {
			return Bool\Module::create(ctype_print($x->unbox()));
		}

		/**
		 * This method returns whether this character is a punctuation character.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is a punctuation
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-punct.php
		 */
		public static function isPunctuation(Char\Type $x) {
			return Bool\Module::create(ctype_punct($x->unbox()));
		}

		/**
		 * This method returns whether this character is a separator character.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is a mark
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isSeparator(Char\Type $x) {
			return Bool\Module::create(preg_match('/^\p{Z}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is a space.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is a space
		 *
		 * @see http://php.net/manual/en/function.ctype-space.php
		 */
		public static function isSpace(Char\Type $x) {
			return Bool\Module::create(ctype_space($x->unbox()));
		}

		/**
		 * This method returns whether this character is a symbol.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is a symbol
		 *
		 * @see http://php.net/manual/en/regexp.reference.unicode.php
		 */
		public static function isSymbol(Char\Type $x) {
			return Bool\Module::create(preg_match('/^\p{S}$/', $x->unbox()));
		}

		/**
		 * This method returns whether this character is an upper case character.
		 *
		 * @access public
		 * @static
		 * @param Char\Type $x                                      the character to be evaluated
		 * @return Bool\Type                                        whether this is an upper case
		 *                                                          character
		 *
		 * @see http://php.net/manual/en/function.ctype-upper.php
		 */
		public static function isUpperCase(Char\Type $x) {
			return Bool\Module::create(ctype_upper($x->unbox()));
		}

		#endregion

	}

}