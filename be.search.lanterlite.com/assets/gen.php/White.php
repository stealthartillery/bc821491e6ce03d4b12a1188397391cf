<?php

class White {
	function step1 ($str) {
		$str = urldecode($str);
		// echo PHP_EOL;
		// echo $str;
		$str = LGen('StringMan')->to_json($str);
		return $str;
	}

	function step2 ($str) {
		// echo PHP_EOL;
		// echo base64_decode($str);
		return base64_decode($str);
	}

	function step3 ($str) {
    $data = str_replace(array('-','_'),array('+','/'),$str);
    $mod4 = strlen($data) % 4;
    if ($mod4)
      $data .= substr('====', $mod4);
    // return base64_decode($data);
		// echo PHP_EOL;
		// echo $data;
    return $data;
	}

	function step4 ($str) {
		$back = substr($str, -5);
		// echo PHP_EOL;
		// echo $back;
		$front = substr($str, 0, -12);
		$str2 = $front.$back;
		$str2 = substr($str2, 5);
		// echo PHP_EOL;
		// echo $str2;
		return $str2;
	}

	function step5 ($str) {
		// $_d = str_split('abcdef');
		$_d = "QakDy61n5vBXsgjw9zLmJKcPuSIdMZqtfUWbhp4eR73HNlCT082VoAGiOrFYxE";
		// $arr_d = str_split($_d);
		$arr_str = str_split($str);
		$num = (int)$arr_str[3];
		$str = LGen('StringMan')->rmv_val_by_index($str, 3);
		$arr_str = str_split($str);
		// echo $num;
		// echo PHP_EOL;
		// echo $str;
		for ($i=0; $i<$num; $i++) {
			$_d = LGen('Black')->step5a($_d);
		}
		$arr_d = str_split($_d);
		$str2 = '';
		for ($i=0; $i<sizeof($arr_str); $i++) {
			// $index = strpos($_d, $arr_str[$i])-$i;
			// if ($index<0)
			// 	$index = sizeof($arr_d)-(strpos($_d, $arr_str[$i])-$i%sizeof($arr_d));
			// $str2 .= $arr_d[$index];
			if (!LGen('ArrayMan')->is_val_exist($arr_d, $arr_str[$i]))
				$str2 .= $arr_str[$i];
			else
				$str2 .= array_key_exists((strpos($_d, $arr_str[$i])-1), $arr_d)? $arr_d[(strpos($_d, $arr_str[$i])-1)] : $arr_d[(strpos($_d, $arr_str[$i])-1+sizeof($arr_d))];
		}
		// echo $str2;
		return $str2;
	}

	function get($str) {
		// return $this->step2($this->step3($this->step4($this->step5($str))));
		return $this->step1($this->step2($this->step3($this->step4($this->step5($str)))));
	}
}
