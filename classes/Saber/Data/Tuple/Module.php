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

namespace Saber\Data\Tuple {

	use \Saber\Core;
	use \Saber\Data\Bool;
	use \Saber\Data\Collection;
	use \Saber\Data\Int32;
	use \Saber\Data\Tuple;

	class Module extends Collection\Module {

		#region Methods -> Basic Operations

		/**
		 * This method returns the element at the specified index.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @param Int32\Type $i                                     the index of the element
		 * @return mixed                                            the element at the specified index
		 */
		public static function element(Tuple\Type $xs, Int32\Type $i) {
			return $xs->element($i);
		}

		/**
		 * This method returns the first element in the tuple.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @return mixed                                            the first element in the tuple
		 */
		public static function first(Tuple\Type $xs) {
			return $xs->first();
		}

		/**
		 * This method returns the length of this array list.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @return Int32\Type                                       the length of this array list
		 */
		public static function length(Tuple\Type $xs) {
			return $xs->length();
		}

		/**
		 * This method returns the second element in the tuple.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @return mixed                                            the second element in the tuple
		 */
		public static function second(Tuple\Type $xs) {
			return $xs->second();
		}

		/**
		 * This method returns a tuple with the elements swapped.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @return Tuple\Type                                       a tuple with the element swapped
		 */
		public static function swap(Tuple\Type $xs) {
			return Tuple\Type::box($xs->second(), $xs->first());
		}

		#endregion

		#region Methods -> Conversion Operations

		/**
		 * This method returns the latter value should the former value evaluates
		 * to null.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                     the value to be evaluated
		 * @param Tuple\Type $ys                                     the default value
		 * @return Tuple\Type                                        the result
		 */
		public static function nvl(Tuple\Type $xs = null, Tuple\Type $ys = null) {
			return ($xs !== null) ? $xs : (($ys !== null) ? $ys : Tuple\Type::box(null, null));
		}

		#endregion

		#region Methods -> Equality Operations

		/**
		 * This method evaluates whether the left operand is equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is equal
		 *                                                          to the right operand
		 */
		public static function eq(Tuple\Type $xs, Core\Type $ys) { // ==
			$type = $xs->__typeOf();
			if ($ys !== null) {
				if ($ys instanceof $type) {
					return Int32\Module::eq(Tuple\Module::compare($xs, $ys), Int32\Type::zero());
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is identical
		 *                                                          to the right operand
		 */
		public static function id(Tuple\Type $xs, Core\Type $ys) { // ===
			if ($ys !== null) {
				if ($xs->__typeOf() === $ys->__typeOf()) {
					return Int32\Module::id(Tuple\Module::compare($xs, $ys), Int32\Type::zero());
				}
			}
			return Bool\Type::false();
		}

		/**
		 * This method evaluates whether the left operand is NOT equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT equal
		 *                                                          to the right operand
		 */
		public static function ne(Tuple\Type $xs, Core\Type $ys) { // !=
			return Bool\Module::not(Tuple\Module::eq($xs, $ys));
		}

		/**
		 * This method evaluates whether the left operand is NOT identical to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @param Core\Type $ys                                     the right operand
		 * @return Bool\Type                                        whether the left operand is NOT identical
		 *                                                          to the right operand
		 */
		public static function ni(Tuple\Type $xs, Core\Type $ys) { // !==
			return Bool\Module::not(Tuple\Module::id($xs, $ys));
		}

		#endregion

		#region Methods -> Ordering Operations

		/**
		 * This method compares the operands for order.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @param Tuple\Type $ys                                    the right operand
		 * @return Int32\Type                                       the order as to whether the left
		 *                                                          operand is less than, equals to,
		 *                                                          or greater than the right operand
		 */
		public static function compare(Tuple\Type $xs, Tuple\Type $ys) {
			if (($xs === null) && ($ys !== null)) {
				return Int32\Type::negative();
			}
			if (($xs === null) && ($ys === null)) {
				return Int32\Type::zero();
			}
			if (($xs !== null) && ($ys === null)) {
				return Int32\Type::one();
			}

			$length = Int32\Module::min($xs->length(), $ys->length());

			for ($i = Int32\Type::zero(); Int32\Module::lt($i, $length)->unbox(); $i = Int32\Module::increment($i)) {
				$x = $xs->element($i);
				$y = $ys->element($i);

				if (($x === null) && ($y !== null)) {
					return Int32\Type::negative();
				}
				else if (($x !== null) && ($y === null)) {
					return Int32\Type::one();
				}
				else if (($x !== null) && ($y !== null)) {
					$r = call_user_func_array(array($x, 'compare'), array($x, $y));
					if ($r->unbox() != 0) {
						return $r;
					}
				}
			}

			$x_length = $xs->__length();
			$y_length = $ys->__length();

			if ($x_length < $y_length) {
				return Int32\Type::negative();
			}
			else if ($x_length == $y_length) {
				return Int32\Type::zero();
			}
			else { // ($x_length > $y_length)
				return Int32\Type::one();
			}
		}

		/**
		 * This method evaluates whether the left operand is greater than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @param Tuple\Type $ys                                    the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than or equal to the right operand
		 */
		public static function ge(Tuple\Type $xs, Tuple\Type $ys) { // >=
			return Bool\Type::box(Tuple\Module::compare($xs, $ys)->unbox() >= 0);
		}

		/**
		 * This method evaluates whether the left operand is greater than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @param Tuple\Type $ys                                    the right operand
		 * @return Bool\Type                                        whether the left operand is greater
		 *                                                          than the right operand
		 */
		public static function gt(Tuple\Type $xs, Tuple\Type $ys) { // >
			return Bool\Type::box(Tuple\Module::compare($xs, $ys)->unbox() > 0);
		}

		/**
		 * This method evaluates whether the left operand is less than or equal to the right operand.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @param Tuple\Type $ys                                    the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          or equal to the right operand
		 */
		public static function le(Tuple\Type $xs, Tuple\Type $ys) { // <=
			return Bool\Type::box(Tuple\Module::compare($xs, $ys)->unbox() <= 0);
		}

		/**
		 * This method evaluates whether the left operand is less than the right operand.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @param Tuple\Type $ys                                    the right operand
		 * @return Bool\Type                                        whether the left operand is less than
		 *                                                          the right operand
		 */
		public static function lt(Tuple\Type $xs, Tuple\Type $ys) { // <
			return Bool\Type::box(Tuple\Module::compare($xs, $ys)->unbox() < 0);
		}

		/**
		 * This method returns the numerically highest value.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @param Tuple\Type $ys                                    the right operand
		 * @return Int32\Type                                       the maximum value
		 */
		public static function max(Tuple\Type $xs, Tuple\Type $ys) {
			return (Tuple\Module::compare($xs, $ys)->unbox() >= 0) ? $xs : $ys;
		}

		/**
		 * This method returns the numerically lowest value.
		 *
		 * @access public
		 * @static
		 * @param Tuple\Type $xs                                    the left operand
		 * @param Tuple\Type $ys                                    the right operand
		 * @return Int32\Type                                       the minimum value
		 */
		public static function min(Tuple\Type $xs, Tuple\Type $ys) {
			return (Tuple\Module::compare($xs, $ys)->unbox() <= 0) ? $xs : $ys;
		}

		#endregion

	}

}