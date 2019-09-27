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

		function to_arr($string, $parser=' ') {
			return explode($parser,$string);
		}

		function to_upper($string) {
			return strtoupper($string);
		}

		function to_lower($string) {
			return strtolower($string);
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

		function clean($string) { 
			$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		  $str = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		  return preg_replace('/-/', ' ', $str); // Removes special chars.

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
	}