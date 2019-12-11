<?php

class Black {
	function step1 ($str) {
		$str = LGen('JsonMan')->to_str($str);
		$str = urlencode($str);
		return $str;
	}

	function step2 ($str) {
		return base64_encode($str);
	}

	function step3 ($str) {
    $data = str_replace(array('+','/','='),array('-','_',''),$str);
    return $data;
	}

	function step4 ($str) {
		$str = LGen('StringMan')->gen_rand(5).$str;
		$back = substr($str, -5);
		$front = substr($str, 0, -5);
		return $front.LGen('StringMan')->gen_rand(7).$back;
	}

	function step5a($str) {
		$_d = "DRJ42ulf7ShBjzwq9gEra1FYNtWOM6bdQXTepVvPmLiUCG0x3k8AoK5cyIHZsn";
		$arr_d = str_split($_d);
		$arr_str = str_split($str);
		$str2 = '';
		for ($i=0; $i<sizeof($arr_str); $i++) {
			if (!LGen('ArrayMan')->is_val_exist($arr_d, $arr_str[$i]))
				$str2 .= $arr_str[$i];
			else
				$str2 .= array_key_exists((strpos($_d, $arr_str[$i])+1), $arr_d)? $arr_d[(strpos($_d, $arr_str[$i])+1)] : $arr_d[(strpos($_d, $arr_str[$i])+1-sizeof($arr_d))];
		}
		return $str2;
	}

	function step5 ($str) {
		// $_d = str_split('abcdef');
		$_d = "QakDy61n5vBXsgjw9zLmJKcPuSIdMZqtfUWbhp4eR73HNlCT082VoAGiOrFYxE";
		// $arr_d = str_split($_d);
		$arr_str = str_split($str);

		$num = rand(0,9);
		for ($i=0; $i<$num; $i++) {
			$_d = LGen('Black')->step5a($_d);
		}
		$arr_d = str_split($_d);

		$str2 = '';
		for ($i=0; $i<sizeof($arr_str); $i++) {
			// $index = _d.indexOf(str[i])-i
			// if (index<0)
			// 	index = _d.length-(Math.abs(_d.indexOf(str[i])-i)%_d.length)
			// $str2 .= ;
			if (!LGen('ArrayMan')->is_val_exist($arr_d, $str[$i]))
				$str2 .= $str[$i];
			else
				$str2 .= array_key_exists((strpos($_d, $arr_str[$i])+1), $arr_d)? $arr_d[(strpos($_d, $arr_str[$i])+1)] : $arr_d[(strpos($_d, $arr_str[$i])+1-sizeof($arr_d))];
		}
		$str2 = LGen('StringMan')->add_val_by_index($str2, $num, 3);
		$str2 = 'LTS'.$str2;
		return $str2;
	}

	function check($str) {
		if (!is_string($str))
			return false;
		$arr_str = str_split($str);
		if (sizeof($arr_str)<15)
			return false;
		if (!(int)$arr_str[6])
			return false;
		if (substr($str, 0, 3) !== "LTS")
			return false;
		return true;
	}

	function get($str) {
		// return $this->step4($this->step3($this->step2($this->step1($str))));
		return $this->step5($this->step4($this->step3($this->step2($this->step1($str)))));
	}
}
