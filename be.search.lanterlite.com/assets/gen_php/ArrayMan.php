<?php 
	class ArrayMan {
		function to_str($arr, $parser=" ") {
			return implode($parser,$arr);
		}

		function to_json($arr) {
			return json_decode(json_encode($arr), true);
		}

		function intersect($arr1, $arr2) {
			return array_values(array_intersect($arr1, $arr2));
		}

		function is_index_exist($arr, $index) {
			return isset($arr[$index]);
		}

		function is_key_exist($arr, $index) {
			return isset($arr[$index]);
		}

		function is_val_exist($arr, $value) {
			return in_array($value, $arr);
		}

		function rmv_last_index(&$arr) {
			array_pop($arr);
			return $arr;
		}

		function rmv_first_index(&$arr) {
			array_shift($arr);
			return $arr;
		}

		function rmv_by_index(&$arr, $index) {
			unset($arr[$index]);
			$arr = array_values($arr);
			return $arr;
		}

		function rmv_by_val(&$arr, $val) {
			if (($key = array_search($val, $arr)) !== false) {
		    unset($arr[$key]);
		    $arr = array_values($arr);
			}
			return $arr;
		}

		function get_from_to($arr, $from, $to) {
			return array_slice($arr, $from, $to);
		}

		function get_index($arr, $val) {
			return array_search($val, $arr);
		}

		// function print($array) { 
		// 	echo "</br>"; for ($i=0; $i<count($array); $i++) echo "[" . $i . "] => " . $array[$i] . "</br>"; 
		// }
	}