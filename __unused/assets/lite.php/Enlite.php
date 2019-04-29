<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

$E = new EnliteGen();

class EnliteGen {

	public function __construct() {
		if(!class_exists('lanterlite')) { include 'init.php'; }
		$this->L = new Lanterlite();
	}

	function content($content_id) {
		$id = $this->L->str_to_arr($content_id, ".");
		$dir = HOME_DIR .'/storages/enlite/';

		if ($id[0] == 'AQ') {
			$str = file_get_contents($dir .'/fix_alquran_v1.json');
			$json = json_decode($str, true);

			$asd_tot = [];
			foreach($json as $item) {
				$tot_match = 0;
				if($item['id'] == $content_id) {
					$asd['title'] = $item['surah'] . ' ('. $item['surah_no'] . ':' . $item['ayat_no'] . ')';
					$asd['subtitle_1'] = $item['source'];
					$asd['subtitle_2'] = $item['surah_no'] . ':' . $item['ayat_no'];
					$asd['content'] = $item['content'];
					$asd['arabic_content'] = $item['ar_content'];
					$asd['postcontent_1'] = $item['type'];
					array_push($asd_tot, $asd);
			  }
			}	
		}
		else {
			// $str = include $dir .'/newbm.json.php';
			$str = file_get_contents($dir .'/result.mto2.json');
			$json = json_decode($str, true);

			$asd_tot = [];
			foreach($json as $item) {
				$tot_match = 0;
				if($item['id'] == $content_id) {
			// foreach($json as $item => $value) {
					// $keys = array_keys($json[0]);
					// foreach ($keys as $key) {
					// 	$asd[$key] = $item[$key];
					// }
					// array_push($asd_tot, $asd);
					$asd['title'] = $item['chapter'];
					$asd['subtitle_1'] = $item['source'];
					$asd['subtitle_2'] = $item['hadith_no'];
					// $asd['precontent'] = $item['narrator'];
					$asd['content'] = $item['content'];
					$asd['arabic_content'] = $item['arabic'];
					// $asd['postcontent_1'] = $item['collector'];
					// $asd['postcontent_2'] = $item['degree'];
					// $asd['addition'] = $item['comment'];
					array_push($asd_tot, $asd);
			  }
			}	
		}

		if (!isset($asd)) {
			// $keys = array_keys($json);
			// foreach ($keys as $key) {
			// 	$asd[$key] = $item[$key];
			// }
			$asd['title'] = 'Content Not Found';
			$asd['subtitle'] = '';	
			$asd['desc'] = '';	
			array_push($asd_tot, $asd);
		}

		$result['data'] = $asd_tot;
		// array_push($result, $asd_tot);
		// echo $json;
		$result = json_encode($result, true);
		echo $result;
	}

	function getBookName($id) {
		if ($id == 'AQ')
			return "Al-Qur'an";
		else if ($id == 'BM')
			return "Bulughul Maram";
		else if ($id == 'SA')
			return "Syarah Arba'in An-Nawawi";
		else 
			return "undefined";
	}

	function correcting() {
		$user_keyword = $this->user_keyword;
		$user_keyword = $this->L->clean_string($user_keyword);
		$result_2 = $this->L->mysort3($user_keyword);

		$is_mistake = false;
		$correction = '';

		for ($i=0;$i<sizeof($result_2['words']); $i++) {
			array_push($this->arr_user_keywords, $result_2['words'][$i]);
			if ($result_2['scores'][$i] != 100) {
				$is_mistake = true;
				if ($i == sizeof($result_2['words'])-1)
					$correction = $correction . '<b><i>' . $result_2['words'][$i] . '</i></b>';
				else
					$correction = $correction . '<b><i>' . $result_2['words'][$i] . '</i></b>' . ' ';
			}
			else {
				if ($i == sizeof($result_2['words'])-1)
					$correction = $correction . $result_2['words'][$i];
				else
					$correction = $correction . $result_2['words'][$i] . ' ';			
			}

			if ($result_2['words'][$i] == '-') {
				$this->arr_user_keywords = null;
				$i = sizeof($result_2['words']);
			}
		}

		if ($this->arr_user_keywords != null) {
			$this->is_mistake = $is_mistake;
			$this->correction = $correction;						
		}
	}

	function diff($v1, $v2) {
	    return ($v1-$v2) < 0 ? (-1)*($v1-$v2) : ($v1-$v2);
	}

	function priority_get($arr) {
		sort($arr);
		$score = 0;
		// $this->L->printJson($arr);
		for ($i=0; $i<sizeof($arr)-1; $i++) {
			$score = $score + self::diff($arr[$i+1], $arr[$i]);
		}
		if ($score != 0) {
			$score = 100/$score;
		}
		// $this->L->printJson($score);

		// $arr_match = array_values($arr_match);
		return $score;
	}

	function strpos_all($haystack, $needle) {
	    $offset = 0;
	    $allpos = array();
	    while (($pos = strpos($haystack, $needle, $offset)) !== FALSE) {
	        $offset   = $pos + 1;
	        $allpos[] = $pos;
	    }
	    return $allpos;
	}
	// print_r(strpos_all("aaa bbb aaa bbb aaa bbb", "aa"));
	// Output:
	// Array
	// (
	//     [0] => 0
	//     [1] => 1
	//     [2] => 8
	//     [3] => 9
	//     [4] => 16
	//     [5] => 17
	// )

	// function search_from($db_file) {

	// 	$data_tot = [];
	// 	if ($this->arr_user_keywords != null) {

	// 		// $json = include $db_file;
	// 		// $json = $json[DATA];
	// 		// $this->L->printJson($json);
	// 		$json = $this->L->json_read($db_file)[DATA];
	// 		$arr = $this->arr_user_keywords;
	// 		$index = 0;
	// 		foreach($json as $item) {
	// 			$tot_match = 0;
	// 			$pos = [];
	// 			for ($i=0; $i<sizeof($arr); $i++) {
	// 				$word = $arr[$i];
	// 				$result = $this->L->str_cmp($item['content'], $word);
	// 			  // $this->L->printJson($result);
	// 			  if($result['is_same']) {
	// 				  // $this->L->printJson($result);
	// 				  // echo $item['body'] . ' ' . '<br>';
	// 			  	$tot_match++;
	// 				  // echo $tot_match;
	// 			  	array_push($pos, $result['pos']);
	// 			  }
	// 			  if($tot_match == sizeof($arr)) {
	// 					// $this->L->printJson($tot_match);
	// 				  // $this->L->printJson($arr);
	// 				  // echo $item['content'] . '<br>';
	// 			  	$score = $this->priority_get($pos);
	// 			  	$item2        = $this->title_content_make($item['content'], $arr);
	// 					$data['id']    = $item['id'];
	// 					$data['type']  = $this->type_make($item);
	// 					$data['title'] = $item2['title'];
	// 					$data['desc']  = $item2['content'];
	// 					$data['priority']  = 10 + $score;
	// 					array_push($this->arr_content, $data);
	// 					// $this->L->printJson($item2);
	// 			  	$i = sizeof($arr);
	// 				}

	// 			  // if($tot_match == sizeof($arr) or $tot_match/sizeof($arr) > 0.5) {
	// 				 //  if ($this->content_index_start <= $index and $index <= $this->content_index_end) {
	// 				 //  	$result        = $this->title_content_make($item['body'], $arr);
	// 					// 	$data['id']    = $item['id'];
	// 					// 	$data['type']  = $item['header'];
	// 					// 	$data['title'] = $result['title'];
	// 					// 	$data['desc']  = $result['content'];
	// 					// 	array_push($this->arr_content, $data);
	// 				 //  }
	// 				 //  else {
	// 					// 	$data['id']    = 'asd';
	// 					// 	$data['type']  = 'asd';
	// 					// 	$data['title'] = 'asd';
	// 					// 	$data['desc']  = 'asd';
	// 					// 	array_push($this->arr_content, $data);
	// 				 //  }
	// 			  // 	$index = $index+1;
	// 			  // 	$i = sizeof($arr);
	// 			  // }
	// 			}

	// 		  if ($tot_match != sizeof($arr) and $tot_match/sizeof($arr) > 0.5) {
	// 		  	$item2        = $this->title_content_make($item['content'], $arr);
	// 				$data['id']    = $item['id'];
	// 				$data['type']  = $this->type_make($item);
	// 				$data['title'] = $item2['title'];
	// 				$data['desc']  = $item2['content'];
	// 				$data['priority']  = 9;
	// 				array_push($this->arr_content, $data);
	// 			}
	// 		}
	// 	}
	// 	return $data_tot;
	// }

	function get_arr_json_item_by_id ($arr_json, $id) {
		foreach ($arr_json as $item) {
			if ($item['id'] == $id) {
				return $item;
			}
	 	}
	}

	// inverted index
	function search_from2() {

		if ($this->arr_user_keywords != null) {
			$arr_user_keywords = $this->arr_user_keywords;

			// $json = include $db_file;
			// $json = $json[DATA];
			// $this->L->printJson($json);
			// $json_2 = $this->L->json_read($db_file)[DATA];

			$dir = HOME_DIR .'/storages/enlite/';
			$json = $this->L->json_read($dir.'result.invix.json')[DATA];
			$json_2 = $this->L->json_read($dir.'result.mto2.json')[DATA];
			// $this->L->printJson($json);
			// $this->L->printJson($dir);
			// $this->L->printJson($this->L->json_read($dir.'result.invix.json'));
			$arrjson_match = [];
			foreach ($arr_user_keywords as $_kkey => $_kval) {
				$_res = self::get_json_from_arrjson_by_str($json, $_kval, 'word');
				if ($_res != null)
					array_push($arrjson_match, $_res);
			}

			$arr_match = [];

			// $this->L->printJson($arrjson_match);
			if (sizeof($arrjson_match) > 1) {
				$exec = '$arr_match = array_intersect(';
				foreach ($arrjson_match as $_mkey => $_mval) {
					if ($_mkey != sizeof($arrjson_match)-1) {
						$exec = $exec . '$arrjson_match['.$_mkey.']["index"],';
					}
					else {
						$exec = $exec . '$arrjson_match['.$_mkey.']["index"]);';
						eval($exec);
					}
				}
				$arr_match = array_values($arr_match);
			}
			else if (sizeof($arrjson_match) == 1) {
				$arr_match = $arrjson_match[0]['index'];
			}
			else {
				$arr_match = [];
			}
	
			$this->content_tot = sizeof($arr_match);
			// $this->L->printJson($arr_match);
			$scores = [];

			foreach ($arr_match as $_mkey => $_mval) {
				$pos = [];
				foreach ($arr_user_keywords as $_kkey => $_kval) {
					$_result = $this->L->str_cmp($json_2[$_mval]['content'], $_kval);
					if($_result['is_same']) {
				  	array_push($pos, $_result['pos']);
				  }
				  if($_kkey == sizeof($arr_user_keywords)-1) {
				  	$score = $this->priority_get($pos);
				  	$_obj['score'] = 10 + $score;
				  	$_obj['index'] = $json_2[$_mval]['index'];
				  	array_push($scores, $_obj);
					}
				}
			}
			$sort_by = 'score';
			// $this->L->printJson($scores);
			$this->scores = $this->L->sort_json_arr($scores, $sort_by);
			// $this->L->printJson($this->content_index_start);
			// $this->L->printJson($this->content_index_end);
			// $this->L->printJson($this->scores);
			foreach ($this->scores as $_skey => $_sval) {
				if ($this->content_index_start <= $_skey && $_skey <= $this->content_index_end) {
					$index = $_sval['index'];
					// $this->L->printJson($json_2[$index]['content']);
			  	$item2 = $this->title_content_make($json_2[$index]['content'], $arr_user_keywords);
					$data['id'] = $json_2[$index]['id'];
					$data['type'] = $this->type_make($json_2[$index]);
					$data['title'] = $item2['title'];
					$data['desc'] = $item2['content'];
					$data['priority'] = $_sval['score'];
					array_push($this->arr_content, $data);
				}
				else if (!($_skey <= $this->content_index_end))
					break;
			}
			// $this->L->printJson($this->arr_content);


		}
	}

	function get_json_from_arrjson_by_str ($arrjson, $word, $key) {
		$str2 = $this->L->root_word($word);
		foreach($arrjson as $_okey => $_oval) {
			// $this->L->printJson($_oval);
			// $this->L->printJson($word);
			// $str1 = $this->L->root_word($_oval[$key]);
			$str1 = $_oval[$key];
			if ($this->L->str_cmp_case_insen($str1, $str2, 'full')) {
				return $_oval;
			}
			else if ($_okey == sizeof($arrjson)-1) {
				return null;
			}
		}
	}

	function search2($user_keyword, $page) {
		$this->user_keyword = $user_keyword;
		$this->arr_content = [];

		$this->content_index_start = $page*10;
		$this->content_index_end = ($page+1)*10-1;

		$this->arr_user_keywords = explode(" ", $user_keyword);
		$this->is_mistake = false;
		$this->correction = '';
		$this->content_tot = 0;

		$this->L->word_activate();


		$time_start = $this->L->microtime_float();
		

		$paresedStr = $this->L->str_to_arr(strtolower($user_keyword), ":");
		if ($paresedStr[0] == "q") {
			$type = "quran";
			$newArrStr = $this->L->popFirstIndex($paresedStr);
			$user_keyword = $this->L->arr_to_str($newArrStr);
		}
		else if ($paresedStr[0] == "h"){
			$newArrStr = $this->L->popFirstIndex($paresedStr);
			$user_keyword = $this->L->arr_to_str($newArrStr);
			$type = "hadith";
		}
		else {
			$type = "all";
		}

		$this->search_from2();

		// $dir = HOME_DIR .'/storages/enlite/';
		// // $hadith_db = 'newbm.json.php';
		// $hadith_db = 'newbm.json';
		// // $quran_db = 'quran.json.php';
		// $quran_db = 'fix_alquran_v1.json';
		// // $quran_db = 'enlite_quran_fix.json';
		// // $hadith_db = 'enlite_light_hadith.json';

		// if ($type == "quran") {
		// 	$this->search_from($dir.$quran_db);
		// }
		// else if ($type == "hadith") {
		// 	$this->search_from($dir.$hadith_db);
		// }
		// else {
		// 	$this->search_from($dir.$quran_db);
		// 	$this->search_from($dir.$hadith_db);
		// }

		self::correcting();
		if (sizeof($this->arr_content) == 0) {
			$asd['title'] = $user_keyword;
			$asd['type'] = $user_keyword;	
			$asd['desc'] = $user_keyword;	
			$result['status'] = 'NOT_FOUND';
			array_push($this->arr_content, $asd);
			$is_mistake = $this->is_mistake;
			if ($is_mistake)
				$correction = $this->correction;
			else
				$correction = 'no correction';
		}
		else {
			$is_mistake = $this->is_mistake;
			if ($is_mistake)
				$correction = $this->correction;
			else
				$correction = 'no correction';

			$result['status'] = 'FOUND';		
		}
		$sort_by = 'priority';
		$this->arr_content = $this->L->sort_json_arr($this->arr_content, $sort_by);
		// $this->L->printJson($this->arr_content);
		
		$cols_per_page = 10;
		$final_result = [];
		$page_tot = ceil($this->content_tot/$cols_per_page);
		// for ($i=0+($cols_per_page*$page); $i<$cols_per_page+($cols_per_page*$page); $i++) {
		// 	if (isset($this->arr_content[$i]))
		// 		array_push($final_result, $this->arr_content[$i]);
		// }


		$time_end = $this->L->microtime_float();
		$time = (string)($time_end - $time_start);
		$time = substr($time, 0, 4);
		
		$result['data'] = $this->arr_content;
		$result['page_tot'] = $page_tot;
		$result['is_mistake'] = $is_mistake;
		$result['correction'] = $correction;
		$result['time'] = $time;
		$result['content_tot'] = $this->content_tot;
		$result = json_encode($result, true);
		echo $result;
	}

	function type_make($item) {
		$type = '';
		if (isset($item['surah'])) {
			$type = $item['surah'] . ' (' . $item['surah_no'] . ':' . $item['ayat_no'] . ')' ;
		}
		else if (isset($item['hadith_no'])) {
			$type = $item['hadith_no'];
		}
		$result = $item['source'] . ', ' . $type;
		return $result;
	}

	function title_content_make($string, $word) {
		$arr = explode(" ",$string);

		if (sizeof($arr) != 0) {
			$index = 0;
			$is_found = false;
			for ($i=0; $i<sizeof($arr); $i++) {
				for ($j=0; $j<sizeof($word); $j++) {
					$root_word = $this->L->root_word($arr[$i]);
					if ($this->L->str_cmp_case_insen($root_word, $word[$j], 'part')) {
						$index = $i;
						$is_found = true;
						$i = sizeof($arr);
						$j = sizeof($word);
					}
				}
			}
			// echo $index . '<br>';
			// $this->L->printJson($arr);
			// $this->L->printJson($word);

			$str_after = [];
			$isEnd = false;
			// $this->L->printJson($string);
			for ($i=$index+1; $i<$index+20; $i++) {
				if (array_key_exists($i, $arr)) {
					$match = false;
					$_word = $this->L->root_word($arr[$i]);

					for ($j=0; $j<sizeof($word); $j++) {
						$_word2 = $this->L->root_word($word[$j]);
						if ($this->L->str_cmp_case_insen($_word, $_word2, 'part')) {
							array_push($str_after, '<b>' . $arr[$i] . '</b>');
							$match = true;
							$j = sizeof($word);
						}
					}
					if (!$match) {
						array_push($str_after, $arr[$i]);
					}
				}
				else {
					$i = $index+20;
					$isEnd = true;
				}
			}

			if (!$isEnd) {
				array_push($str_after, '...');
			}

			$isEnd = false;
			$str_before = [];
			for ($i=$index-1; $i>$index-20; $i--) {
				if (array_key_exists($i, $arr)) {
					$match = false;
					$_word = $this->L->root_word($arr[$i]);
					for ($j=0; $j<sizeof($word); $j++) {
						$_word2 = $this->L->root_word($word[$j]);
						if ($this->L->str_cmp_case_insen($_word, $_word2, 'part')) {
							array_unshift($str_before, '<b>' . $arr[$i] . '</b>');
							$match = true;
							$j = sizeof($word);
						}
					}
					if (!$match) {
						array_unshift($str_before, $arr[$i]);
					}
				}
				else {
					$i = $index-20;
					$isEnd = true;
				}
			}
			if (!$isEnd) {
				array_unshift($str_before, '...');
			}

			$title = $this->getArrayValueUntilIndex($str_after, 5);
			$title = $this->L->arr_to_str($title);

			$title2 = $this->getArrayValueUntilIndexBackward($str_before, 2);
			$title2 = $this->L->arr_to_str($title2);

			$str_before = $this->L->arr_to_str($str_before);
			$str_after = $this->L->arr_to_str($str_after);

			// $this->L->printJson($str_before);
			// $this->L->printJson($str_after);
			if ($is_found) {
				$result['content'] = $str_before . ' <b>' . $arr[$index] . '</b> ' . $str_after;
			}
			else {
				$result['content'] = $str_before . ' ' . $arr[$index] . ' ' . $str_after;				
			}
			// $result['title'] = ucfirst($arr[$index]) . ' ' . $title;
			if ($title2 != '') {
				$result['title'] = '... ' . $title2 . ' ' . $arr[$index] . ' ' . $title;
			}
			else {
				$result['title'] = ucfirst($arr[$index]) . ' ' . $title;
			}
			// echo $index . '<br>';
			// $this->L->printJson($result['content']);
			// $this->L->printJson($str_before);
			// echo $str_after . '<br>';
			// echo $result['content'] . '<br>';
		}
		else  {
			$result['title'] = '';
			$result['content'] = '';
		}

		return $result;
	}

	function getArrayValueUntilIndex($arr, $until_index) {
		$result = [];
		for ($i=0; $i<$until_index; $i++) {
			if (isset($arr[$i])) {
				$word = $arr[$i];
				$word = str_replace('<b>', '', $word);
				$word = str_replace('</b>', '', $word);
				array_push($result, $word);
			}
		}		
		if ($until_index < sizeof($arr))
			array_push($result, '...');
		return $result;
	}

	function getArrayValueUntilIndexBackward($arr, $until_index) {
		$result = [];
		for ($i=sizeof($arr)-1; $i>sizeof($arr)-1-$until_index; $i--) {
			if (isset($arr[$i])) {
				$word = $arr[$i];
				$word = str_replace('<b>', '', $word);
				$word = str_replace('</b>', '', $word);
				array_unshift($result, $word);
			}
		}	
		// if ($until_index < sizeof($arr))
		// 	array_unshift($result, '...');
		return $result;
	}
}

?>