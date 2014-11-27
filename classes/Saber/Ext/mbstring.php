<?php

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
