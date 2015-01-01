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

if (!extension_loaded('mbstring')) {

	if (!function_exists('mb_convert_encoding')) {
		function mb_convert_encoding($string, $to_encoding, $from_encoding = 'UTF-8') {
			if ($from_encoding != $to_encoding) {
				if (function_exists('iconv')) {
					return iconv($from_encoding, $to_encoding . '//IGNORE//TRANSLIT', $string);
				}
			}
			return $string;
		}
	}

	if (!function_exists('mb_strlen')) {
		function mb_strlen($string, $encoding = 'UTF-8') {
			return strlen($string);
		}
	}

	if (!function_exists('mb_strpos')) {
		function mb_strpos($haystack, $needle, $offset = 0, $encoding = 'UTF-8') {
			return strpos($haystack, $needle, $offset);
		}
	}

	if (!function_exists('mb_strtolower')) {
		function mb_strtolower($string, $encoding = 'UTF-8') {
			return strtolower($string);
		}
	}

	if (!function_exists('mb_strtoupper')) {
		function mb_strtoupper($string, $encoding = 'UTF-8') {
			return strtoupper($string);
		}
	}

	if (!function_exists('mb_substr')) {
		function mb_substr($string, $start, $length = null, $encoding = 'UTF-8') {
			if ($length === null) {
				$length = strlen($string) - $start;
			}
			return substr($string, $start, $length);
		}
	}

}
