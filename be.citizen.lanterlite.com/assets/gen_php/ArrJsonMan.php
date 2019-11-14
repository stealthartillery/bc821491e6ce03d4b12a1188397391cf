<?php
	class ArrJsonMan{

		function sort($arr, $sort_by) {
			usort($arr, function($item1, $item2) use ($sort_by) {
		    return $item1[$sort_by] > $item2[$sort_by] ? -1 : 1;;
			});
			return $arr;
		}

		function update_one($array, $json, $unique_prop, $unique_prop_value) {
			foreach($array as $a){
		    if($a[$unique_prop] == $unique_prop_value){
		      $a = $json;
		      break;
		    }
			}
			return $array;
		}

	}
?>