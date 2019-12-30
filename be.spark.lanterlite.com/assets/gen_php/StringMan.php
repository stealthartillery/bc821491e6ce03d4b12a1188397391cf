<?php 
class StringMan {

	function gen_rand($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
		    $randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function to_json($str) {
		return json_decode($str, true);
	}

	function to_arr($string, $parser=' ', $num_of_split=null) {
		if ($parser === '')
			return str_split($str);
		if ($num_of_split !== null)
			return explode($parser,$string,$num_of_split);
		else
			return explode($parser,$string);
	}

	function to_int($string) {
		return (int) preg_replace('/[^0-9]/', '', $string);
	}

	function to_upper($string) {
		return strtoupper($string);
	}

	function to_lower($string) {
		return strtolower($string);
	}

	function add_val_by_index($str, $substr, $pos) {
		return substr_replace( $str, $substr, $pos, 0 ); ;
	}

	function rmv_val_by_index($str, $pos) {
		$arr_str = str_split($str);
		$str1 = substr($str,0,$pos);
		$str2 = substr($str,$pos+1,sizeof($arr_str));
		return $str1.$str2;
		// return substr_replace( $str, $substr, $pos, 0 ); ;
	}

	function replace($string, $string1, $string2) {
		$string = str_replace($string1, $string2, $string);
		return $string;
	}

	function is_val_exist($str, $substr) {
		if(preg_match("/{$substr}/i", $str))
		    return true;
		else
			return false;
		if (strpos($str, $substr) == false) { 
	    return false; 
		} 
		else { 
	    return true; 
		} 
	}

	function get_size($content) {
		if (!is_string($content))
			$content = json_encode($content);

		$count=0;
		$order = array("\r\n", "\n", "\r", "chr(13)",  "\t", "\0", "\x0B");
		$content = str_replace($order, "12", $content);
		for ($index = 0; $index < strlen($content); $index ++){
		    $byte = ord($content[$index]);
		    if ($byte <= 127) { $count++; }
		    else if ($byte >= 194 && $byte <= 223) { $count=$count+2; }
		    else if ($byte >= 224 && $byte <= 239) { $count=$count+3; }
		    else if ($byte >= 240 && $byte <= 244) { $count=$count+4; }
		}
		return $count;
	}

	function rmv_first($string) {
		return substr($string, 1); 
	}

	function rmv_last($string) {
		return substr($string, 0, -1); 
	}

	function clean2($string) { 
		$string = preg_replace('/[^A-Za-z0-9\ ]/', '', $string);
		$string = trim($string);
		$string = preg_replace('/\s+/', ' ', $string);;
		// error_log($string);
	  return $string;
	}

	function clean($string) { 
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		$string = str_replace('.', '-', $string); // Replaces all spaces with hyphens.
		$string = str_replace(',', '-', $string); // Replaces all spaces with hyphens.
		$string = str_replace('/', '-', $string); // Replaces all spaces with hyphens.
	  $str = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	  $str = preg_replace('/-/', ' ', $str); // all strip to space.
	  $str = str_replace('  ', ' ', $str); // all double space to space.
	  return $str;
		// $search = [];
		// $replace = [];
		// array_push($search, '<br>'); array_push($replace, "");
		// array_push($search, '</br>'); array_push($replace, "");
		// array_push($search, '<i>'); array_push($replace, "");
		// array_push($search, '</i>'); array_push($replace, "");
		// array_push($search, '.'); array_push($replace, "");
		// array_push($search, ','); array_push($replace, "");
		// array_push($search, ':'); array_push($replace, "");
		// array_push($search, ';'); array_push($replace, "");
		// array_push($search, ']'); array_push($replace, "");
		// array_push($search, '['); array_push($replace, "");
		// array_push($search, '}'); array_push($replace, "");
		// array_push($search, '{'); array_push($replace, "");
		// array_push($search, ''); array_push($replace, "");
		// array_push($search, ''); array_push($replace, "");
		// array_push($search, ''); array_push($replace, "");
		// $search = array('<br>', '</br>', '<i>', '</i>', ',', '.', '(', ')', '"', '\'');
		// $replace = array('', '', '', '', '', '', '', '', '', '');
		// return str_replace($search, $replace, $string);
		// return preg_replace('/<br>+/', '', $string); 
	}


	function get_substr($str, $val) {
		$pos = strpos(strtolower($str), strtolower($val));
		if ($pos === false)
			return null;
		$i = $pos;
		$first_pos = null;
		while ($i >= 0 and $str[$i] != ' ') {
			$first_pos = $i;
	    $i--;
		}

		$i = $pos;
		$last_pos = null;
		while ($i < strlen($str) and $str[$i] != ' ') {
			$last_pos = $i;
	    $i++;
		}

		$result['string'] = substr($str, $first_pos, $last_pos-$first_pos+1);
		$result['pos'] = $pos;
		return $result;

		// $result['string'] = null;
		// $result['pos'] = null;
		// $arr = explode(" ", $str);
		// for ($i=0; $i<sizeof($arr); $i++) {
		// 	if (str_cmp_case_insen(root_word($arr[$i]), $val, 'full')) {
		// 		$result['string'] = $arr[$i];
		// 		$result['pos'] = $i;
		// 		return $result;
		// 	}
		// }
		// return $result;
	}

	function cmp_case_insen($str1, $str2, $type='part') {
		$str1 = strtolower($str1);
		$str2 = strtolower($str2);

		if ($type == 'full') {
			return ($str1 == $str2);
		}
		else if ($type == 'part') {
			return (preg_match('/'.$str2.'/',$str1));
			// return (strpos(strtolower($str1), strtolower($str2)) !== false);
		}
	}

	function cmp($str1, $str2) {
		$str2_root = root_word($str2); // menunai to tunai
		$changed_prefix = 0;

		$luruh = ['t', 'p', 'k', 's'];
		if (in_array($str2_root[0], $luruh)) {
			$first_char = substr($str2_root, 0, 1);
			$str2_root = substr($str2_root, 1); // tunai to unai
			$changed_prefix = 1;
		}
		
		$result = get_string($str1, $str2_root); // to get menunai by unai
		$result['string'] =	clean_string($result['string']);
		$str = $result['string'];
		$_str2 = $str2_root;
		if ($str != null) {
			$str1_root = root_word($str);
			if ($changed_prefix) {
				$str2_root = $first_char . $str2_root;
			}

			if (str_cmp_case_insen($str1_root, $str2_root, 'full')) {
				$result['is_same'] = true;
				return $result;
			}
		}
		$result['is_same'] = false;
		return $result;
	}

	function cmp2($str1, $str2) {
		$str2_root = root_word($str2); // menunai to tunai
		$changed_prefix = 0;

		$luruh = ['t', 'p', 'k', 's'];
		if (in_array($str2_root[0], $luruh)) {
			$first_char = substr($str2_root, 0, 1);
			$str2_root = substr($str2_root, 1); // tunai to unai
			$changed_prefix = 1;
		}
		
		$result = get_string($str1, $str2_root); // to get menunai by unai
		$result['string'] =	clean_string($result['string']);
		$str = $result['string'];
		$_str2 = $str2_root;
		if ($str != null) {
			$str1_root = root_word($str);
			if ($changed_prefix) {
				$str2_root = $first_char . $str2_root;
			}

			if (str_cmp_case_insen($str1_root, $str2_root, 'full')) {
				$result['is_same'] = true;
				return $result;
			}
		}
		$result['is_same'] = false;
		return $result;
	}

	function string_compare($str_a, $str_b) {
	  $length = strlen($str_a);
	  $length_b = strlen($str_b);

	  $i = 0;
	  $segmentcount = 0;
	  $segmentsinfo = array();
	  $segment = '';
	  while ($i < $length) 
	  {
	      $char = substr($str_a, $i, 1);
	      if (strpos($str_b, $char) !== FALSE) 
	      {               
	          $segment = $segment.$char;
	          if (strpos($str_b, $segment) !== FALSE) 
	          {
	              $segmentpos_a = $i - strlen($segment) + 1;
	              $segmentpos_b = strpos($str_b, $segment);
	              $positiondiff = abs($segmentpos_a - $segmentpos_b);
	              $posfactor = ($length - $positiondiff) / $length_b; // <-- ?
	              $lengthfactor = strlen($segment)/$length;
	              $segmentsinfo[$segmentcount] = array( 'segment' => $segment, 'score' => ($posfactor * $lengthfactor));
	          } 
	          else 
	          {
	              $segment = '';
	              $i--;
	              $segmentcount++;
	          } 
	      } 
	      else 
	      {
	          $segment = '';
	          $segmentcount++;
	      }
	      $i++;
	  }   

	  // PHP 5.3 lambda in array_map      
	  $totalscore = array_sum(array_map(function($v) { return $v['score'];  }, $segmentsinfo));
	  return $totalscore;     
	}

	function is_valid($string) { 
		if ($string != NULL && is_string($string))
		 return true; 
		else 
			return false; 
	}

	function get_substr_between($string, $from_substr, $to_substr){
    $string = ' ' . $string;
    $ini = strpos($string, $from_substr);
    if ($ini == 0) return '';
    $ini += strlen($from_substr);
    $len = strpos($string, $to_substr, $ini) - $ini;
    return substr($string, $ini, $len);
	}

	function read($file_path) {
		$myfile = fopen($file_path, "r") or die("Unable to open file!");
		$txt = fread($myfile,filesize($file_path));
		fclose($myfile);
		return $txt;
	}

	function save($txt, $file_path) {
		$myfile = fopen($file_path, "w") or die("Unable to open file!");
		fwrite($myfile, $txt);
		fclose($myfile);
		return LGen('GlobVar')->success;
	}

	function get_wordman() {
		$wordman = [];
		$wordman['kata_kerja_dasar'] = LGen('JsonMan')->read(HOME_DIR . 'storages/words3.json');
		// $wordman['kata_kerja_dasar'] = [];
		$wordman['vokal'] = ['a', 'i', 'u', 'e', 'o'];
		$wordman['alfabet'] = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
		$wordman['konsonan'] = ['b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'];

		// $prefiks = ['menge', 'meng', 'meny', 'mem', 'men', 'me', 'ber', 'di', 'ter', 'pen', 'per', 'se', 'ke'];
		$wordman['prefiks'] = [
			'memper','member','mener','mempel','mempe','meng','menge','meny','menye','mem','men','me',
			'berke','ber','be','bel','berpen','berpeng','berpenge','berse',
			'ku','kuper','kupel','kupe',
			'te','ter','se','seke','ke','keber','kepe','kepem','kepeng','keper',
			'di','diber','diper','dipel','dipe','dike','dimeng',
			'pe','pen','peny','pem','pember','peng','penge','per'];

		$wordman['infiks'] = ['el', 'em', 'er', 'e', 'in'];
		$wordman['sufiks'] = [
			'kan','kanlah','kanku','kankulah','kannya','kannyalah','kanmu','kanmulah',
			'an','anlah','anku','ankulah','annya','annyalah','anmu','anmulah',
			'i','iku','imu','inya','nya',
			'lah','ilah','kulah','mulah','nyalah',
			'kah','ikah','kukah','mukah','nyakah',
			'ku','mu','pun'];
		return $wordman;
	}

	function rw_change_first_letter($used_prefix, $result, $wordman, $result_arr) {
		if ($result === '')
			return $result_arr;

		if ($used_prefix == 'men' && in_array($result[0], $wordman['vokal'])) {
			array_push($result_arr, 't' . $result);
		}
		else if ($used_prefix == 'berpen' && in_array($result[0], $wordman['vokal'])) {
			array_push($result_arr, 't' . $result);
		}
		else if ($used_prefix == 'pen' && in_array($result[0], $wordman['vokal'])) {
			array_push($result_arr, 't' . $result);
		}
		else if ($used_prefix == 'peny' && in_array($result[0], $wordman['vokal'])) {
			array_push($result_arr, 's' . $result);
		}
		else if ($used_prefix == 'meny' && in_array($result[0], $wordman['vokal'])) {
			array_push($result_arr, 's' . $result);
		}
		else if ($used_prefix == 'meng' && in_array($result[0], $wordman['vokal'])) {
			array_push($result_arr, $result);
			array_push($result_arr, 'k' . $result);
		}
		else if ($used_prefix == 'peng' && in_array($result[0], $wordman['vokal'])) {
			array_push($result_arr, $result);
			array_push($result_arr, 'k' . $result);
		}
		else if ($used_prefix == 'berpeng' && in_array($result[0], $wordman['vokal'])) {
			array_push($result_arr, $result);
			array_push($result_arr, 'k' . $result);
		}
		else if ($used_prefix == 'kepem' && in_array($result[0], $wordman['vokal'])) {
			array_push($result_arr, 'p' . $result);
		}
		else if ($used_prefix == 'pem' && in_array($result[0], $wordman['vokal'])) {
			array_push($result_arr, 'p' . $result);
		}
		else if ($used_prefix == 'mem' && in_array($result[0], $wordman['vokal'])) {
			array_push($result_arr, 'p' . $result);
		}
		else {
			array_push($result_arr, $result);
		}
		return $result_arr;
	}

	function root_word($wordman, $str) {
		$str = strtolower($str);
		// $wordman['kata_kerja_dasar = $wordman['kata_kerja_dasar;


		// $wordman['kata_kerja_dasar = ['makan', 'tanding', 'masuk'];

		$result = $str;
		$result2 = '?';
		$used_prefix = '';
		
		// echo substr($str, -3); 
		// echo str_cmp_case_insen(substr($str, -3), 'nya');
		// echo substr($str, 0, strlen($str)-3);
		// if (str_cmp_case_insen(substr($result, -3), 'nya')) {
		// 	$result = substr($result, 0, strlen($result)-3);
		// }

		if (in_array($result, $wordman['kata_kerja_dasar'])) {
			return $result;
		}

		// echo 'atas '. $result . '<br>';

		// for ($i=0; $i<sizeof($wordman['sufiks']); $i++) {
		// 	if ($wordman['sufiks'][$i] == substr($result, -strlen($wordman['sufiks'][$i]))) {
		// 		$result = substr($result, 0, -strlen($wordman['sufiks'][$i]));
		// 		$i=sizeof($wordman['sufiks']);
		// 	}
		// }

		// for ($i=0; $i<sizeof($wordman['prefiks']); $i++) {
		// 	if ($wordman['prefiks'][$i] == substr($result, 0, strlen($wordman['prefiks'][$i]))) {
		// 		$result = substr($result, strlen($wordman['prefiks'][$i]));
		// 		$used_prefix = $wordman['prefiks'][$i];
		// 		$i=sizeof($wordman['prefiks']);
		// 	}
		// }

		$result_arr_prefiks = [$str];
		for ($i=0; $i<sizeof($wordman['prefiks']); $i++) {
			if ($wordman['prefiks'][$i] == substr($result, 0, strlen($wordman['prefiks'][$i]))) {
				$_result1 = substr($result, strlen($wordman['prefiks'][$i]));
				// if (in_array($_result1, $wordman['kata_kerja_dasar']))
				// 	return $_result1;
				$used_prefix = $wordman['prefiks'][$i];
				$_result_arr_prefiks = [];
				$_result_arr_prefiks = $this->rw_change_first_letter($used_prefix, $_result1, $wordman, $_result_arr_prefiks);
				// echo json_encode($_result_arr_prefiks);
				foreach ($_result_arr_prefiks as $b_key => $b_val) {
					if (in_array($b_val, $wordman['kata_kerja_dasar']))
						return $b_val;
					array_push($result_arr_prefiks, $b_val);
				}
				// if ($_result1 !== $_result2) {
				// 	if (in_array($_result2, $wordman['kata_kerja_dasar']))
				// 		return $_result2;
				// 	array_push($result_arr_prefiks, $_result2);
				// }
				// if (!in_array($_result1, $result_arr_prefiks))
				// 	array_push($result_arr_prefiks, $_result1);
			}
		}
		// echo json_encode($result_arr_prefiks);

		// for ($i=0; $i<sizeof($result_arr_prefiks); $i++) {
		// 	if (in_array($result_arr_prefiks[$i], $wordman['kata_kerja_dasar'])) {
		// 		return $result_arr_prefiks[$i];
		// 	}
		// 	else {
		// 		$result = $this->rw_change_first_letter($arr_used_prefiks[$i], $result_arr_prefiks[$i], $wordman);
		// 		if (in_array($result, $wordman['kata_kerja_dasar'])) {
		// 			return $result;
		// 		}
		// 	}
		// }

		// echo $result;
	

		// $result_arr_sufiks = [];
		for ($j=0; $j<sizeof($wordman['sufiks']); $j++) {
			
			for ($i=0; $i<sizeof($result_arr_prefiks); $i++) {

				if ($wordman['sufiks'][$j] === substr($result_arr_prefiks[$i], -strlen($wordman['sufiks'][$j]))) {
				// echo $wordman['sufiks'][$j] . ' ' . substr($result_arr_prefiks[$i], -strlen($wordman['sufiks'][$j])) . ', ' ;
					// array_push($result_arr_sufiks, substr($result_arr_prefiks[$i], 0, -strlen($wordman['sufiks'][$j])));
					$final_word = substr($result_arr_prefiks[$i], 0, -strlen($wordman['sufiks'][$j]));
					// echo PHP_EOL;
					// echo '$final_word '. $final_word;
					// echo PHP_EOL;
					if (in_array($final_word, $wordman['kata_kerja_dasar'])) {
						return $final_word;
					}
				}
			}
		}
		// echo json_encode($result_arr_prefiks);

		// foreach ($result_arr_sufiks as $key => $value) {
		// 	if (in_array($value, $wordman['kata_kerja_dasar'])) {
		// 		// echo json_encode($wordman['kata_kerja_dasar']);
		// 		return $value;
		// 	}
		// }


		// for ($i=0; $i<sizeof($result_arr_prefiks); $i++) {
		// 	if (in_array($result_arr_prefiks[$i], $wordman['kata_kerja_dasar'])) {
		// 		return $result_arr_prefiks[$i];
		// 	}
		// 	else {
		// 		$result = $this->rw_change_first_letter($arr_used_prefiks[$i], $result_arr_prefiks[$i], $wordman);
		// 		if (in_array($result, $wordman['kata_kerja_dasar'])) {
		// 			return $result;
		// 		}
		// 	}
		// }


		$result = $str;
		// // echo $result . ' . ' ;
		// if (in_array($result, $wordman['kata_kerja_dasar'])) {
		// 	// echo json_encode($wordman['kata_kerja_dasar']);
		// 	return $result;
		// }

		// if (!in_array($result, $wordman['kata_kerja_dasar'])) {
		// 	$result = $str;
		// }

		// echo 'bawah '. $result . '<br>';
		return $result;
	}


}