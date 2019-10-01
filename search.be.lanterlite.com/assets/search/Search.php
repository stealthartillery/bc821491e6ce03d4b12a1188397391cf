<?php
	// ini_set("log_errors", 1);
	// ini_set("error_log", BASE_DIR.'storages/search/'. 'search.log');

	class SearchGen {
		public function __construct() {
			set_time_limit ( 0 );
		}

		function adada() {
			return 'qwe';
		}

		function content($obj) {
			$content_id = $obj['content_id'];
			$id = LGen('StringMan')->to_arr($content_id, ".");
			$dir = BASE_DIR .'/storages/search/';

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
				// $str = file_get_contents($dir .'/result.mto2.json');
				// $json = json_decode($str, true);

				$index = $content_id;
				$src_id = substr($index, 0, 2);
				$json_2 = LGen('JsonMan')->read($dir.'sources/'.$src_id.'/'.$index);
				error_log($dir.'sources/'.$src_id.'/'.$index);
				// $asd_tot = [];

				$asd['title'] = $json_2['chapter'];
				$asd['subtitle_1'] = $json_2['source'];
				$asd['subtitle_2'] = $json_2['hadith_no'];
				// $asd['precontent'] = $item['narrator'];
				$asd['content'] = $json_2['content'];
				$asd['arabic_content'] = $json_2['arabic'];
				// $asd['postcontent_1'] = $item['collector'];
				// $asd['postcontent_2'] = $item['degree'];
				// $asd['addition'] = $item['comment'];
				// array_push($asd_tot, $asd);

			}

			if (!isset($asd)) {
				// $keys = array_keys($json);
				// foreach ($keys as $key) {
				// 	$asd[$key] = $item[$key];
				// }
				$asd['title'] = 'Content Not Found';
				$asd['subtitle'] = '';	
				$asd['desc'] = '';	
				// array_push($asd_tot, $asd);
			}

			// $result = $asd_tot;
			// array_push($result, $asd_tot);
			// echo $json;
			$result = json_encode($asd, true);
			return $result;
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
			$user_keyword = LGen('StringMan')->clean($user_keyword);
			$result_2 = mysort3($user_keyword);

			$is_mistake = false;
			$correction = '';

			for ($i=0;$i<sizeof($result_2['words']); $i++) {
				array_push($this->arr_user_keywords, $result_2['words'][$i]);
				if ($result_2['scores'][$i] != 100) {
					$is_mistake = true;
					if ($i == sizeof($result_2['words'])-1)
						$correction = $correction . $result_2['words'][$i];
					else
						$correction = $correction . $result_2['words'][$i] . ' ';
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
				// $json = $json;
				// $this->L->printJson($json);
				// $json_2 = LGen('JsonMan')->read($db_file);

				$dir = BASE_DIR .'/storages/search/';
				// $json = LGen('JsonMan')->read($dir.'result.invix.json');
				// $arrjson_match = [];
				// foreach ($arr_user_keywords as $_kkey => $_kval) {
				// 	$_res = self::get_json_from_arrjson_by_str($json, $_kval, 'word');
				// 	if ($_res != null)
				// 		array_push($arrjson_match, $_res);
				// }
				$arrjson_match = [];
				foreach ($arr_user_keywords as $_kkey => $_kval) {
					$_kval = $this->root_word($_kval);
					error_log($dir.'words/'.$_kval);
					$val = LGen('JsonMan')->read($dir.'words/'.$_kval);
					if ($val !== LGen('GlobVar')->failed) {
						array_push($arrjson_match, $val);
					}
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
					error_log(json_encode($arrjson_match));
					$arr_match = $arrjson_match[0]['index'];
				}
				else {
					$arr_match = [];
				}
		
				error_log(json_encode(end($arr_match)));
				$this->content_tot = sizeof($arr_match);
				$scores = [];

				foreach ($arr_match as $_mkey => $_mval) {
					$src_id = substr($_mval, 0, 2);
					// echo $dir.'/'.$src_id.'/'.$_mval;
					$json_2 = LGen('JsonMan')->read($dir.'/'.'sources/'.$src_id.'/'.$_mval);
				
					$pos = [];
					foreach ($arr_user_keywords as $_kkey => $_kval) {
						$_result = LGen('StringMan')->string_compare($json_2['content'], $_kval);
						if($_result['is_same']) {
					  	array_push($pos, $_result['pos']);
					  }
					  if($_kkey == sizeof($arr_user_keywords)-1) {
					  	$score = $this->priority_get($pos);
					  	$_obj['score'] = 10 + $score;
					  	$_obj['index'] = $json_2['id'];
					  	array_push($scores, $_obj);
						}
					}
				}
				$sort_by = 'score';
				// $this->L->printJson($scores);
				$this->scores = LGen('ArrJsonMan')->sort($scores, $sort_by);
				// $this->L->printJson($this->content_index_start);
				// $this->L->printJson($this->content_index_end);
				// $this->L->printJson($this->scores);
				foreach ($this->scores as $_skey => $_sval) {
					if ($this->content_index_start <= $_skey && $_skey <= $this->content_index_end) {
						$index = $_sval['index'];
						$src_id = substr($index, 0, 2);
						// $this->L->printJson($this->scores);
						// echo $dir.'/'.$src_id.'/'.$index . '<br>';
						$json_2 = LGen('JsonMan')->read($dir.'/'.'sources/'.$src_id.'/'.$index);
						// $this->L->printJson($json_2[$index]['content']);
				  	$item2 = $this->title_content_make($json_2['content'], $arr_user_keywords);
						$data['id'] = $json_2['id'];
						$data['type'] = $this->type_make($json_2);
						// $data['title'] = $item2['title'];
						if (isset($json_2['chapter']))
							$data['title'] = $json_2['chapter'].' | '.$json_2['source'];
						else
							$data['title'] = $json_2['surah'].' | '.$json_2['source'];

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
			$str2 = $this->root_word($word);
			foreach($arrjson as $_okey => $_oval) {
				// $this->L->printJson($_oval);
				// $this->L->printJson($word);
				// $str1 = $this->root_word($_oval[$key]);
				$str1 = $_oval[$key];
				if (LGen('StringMan')->cmp_case_insen($str1, $str2, 'full')) {
					return $_oval;
				}
				else if ($_okey == sizeof($arrjson)-1) {
					return null;
				}
			}
		}

		function word_activate() {
			$this->kata_kerja_dasar = LGen('JsonMan')->read(BASE_DIR . 'storages/search/words4.json');
			// $this->kata_kerja_dasar = [];
			$this->vokal = ['a', 'i', 'u', 'e', 'o'];
			$this->alfabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
			$this->konsonan = ['b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'];

			// $this->prefiks = ['menge', 'meng', 'meny', 'mem', 'men', 'me', 'ber', 'di', 'ter', 'pen', 'per', 'se', 'ke'];
			$this->prefiks = ['meng', 'meny', 'mem', 'men', 'me', 'ber', 'di', 'ter', 'pen', 'per', 'se', 'ke'];
			$this->infiks = ['el', 'em', 'er', 'e', 'in'];
			$this->sufiks = ['kan', 'an', 'i', 'annya', 'nya', 'lah', 'ku', 'mu'];
		}

		function root_word($str) {
			$str = strtolower($str);
			// $this->kata_kerja_dasar = $this->kata_kerja_dasar;


			// $this->kata_kerja_dasar = ['makan', 'tanding', 'masuk'];

			$result = $str;
			$result2 = '?';
			$used_prefix = '';
			
			// echo substr($str, -3); 
			// echo str_cmp_case_insen(substr($str, -3), 'nya');
			// echo substr($str, 0, strlen($str)-3);
			// if (str_cmp_case_insen(substr($result, -3), 'nya')) {
			// 	$result = substr($result, 0, strlen($result)-3);
			// }

			if (in_array($result, $this->kata_kerja_dasar)) {
				return $result;
			}

			// echo 'atas '. $result . '<br>';
			for ($i=0; $i<sizeof($this->sufiks); $i++) {
				if ($this->sufiks[$i] == substr($result, -strlen($this->sufiks[$i]))) {
					$result = substr($result, 0, -strlen($this->sufiks[$i]));
					$i=sizeof($this->sufiks);
				}
			}
			for ($i=0; $i<sizeof($this->prefiks); $i++) {
				if ($this->prefiks[$i] == substr($result, 0, strlen($this->prefiks[$i]))) {
					$result = substr($result, strlen($this->prefiks[$i]));
					$used_prefix = $this->prefiks[$i];
					$i=sizeof($this->prefiks);
				}
			}

			if ($used_prefix == 'men' && in_array($result[0], $this->vokal)) {
				$result = 't' . $result;
			}
			else if ($used_prefix == 'meny') {
				$result = 's' . $result;		
			}
			else if ($used_prefix == 'meng') {
				$result = 'k' . $result;		
			}
			else if ($used_prefix == 'mem' && in_array($result[0], $this->vokal)) {
				if (in_array('m' . $result, $this->kata_kerja_dasar))
					$result = 'm' . $result;
				else if (in_array('p' . $result, $this->kata_kerja_dasar))
					$result = 'p' . $result;
			}

			// echo $result . ' . ' ;
			if (in_array($result, $this->kata_kerja_dasar)) {
				return $result;
			}

			if (!in_array($result, $this->kata_kerja_dasar)) {
				$result = $str;
			}

			// echo 'bawah '. $result . '<br>';
			return $result;
		}


		function search2($obj) {
			$log = LGen('StringMan')->to_json('{}');
			$log['ip'] = LGen('F')->get_client_ip();
			$log['keywords'] = $obj['user_keyword'];
			$log['page'] = $obj['page'];
			$log['date'] = gmdate("Y/m/d H:i:s T");
			$log['filename'] = 'search/citizen.search.log';
			LGen('F')->log($log);

			$user_keyword = $obj['user_keyword'];
			$page = $obj['page'];
			$this->user_keyword = $user_keyword;
			$this->arr_content = [];

			$this->content_index_start = $page*10;
			$this->content_index_end = ($page+1)*10-1;

			$this->arr_user_keywords = explode(" ", $user_keyword);
			$this->is_mistake = false;
			$this->correction = '';
			$this->content_tot = 0;

			$this->word_activate();


			$time_start = microtime_float();
			

			$paresedStr = LGen('StringMan')->to_arr(strtolower($user_keyword), ":");
			if ($paresedStr[0] == "q") {
				$type = "quran";
				$newArrStr = LGen('ArrayMan')->rmv_first_index($paresedStr);
				$user_keyword = LGen('ArrayMan')->to_str($newArrStr);
			}
			else if ($paresedStr[0] == "h"){
				$newArrStr = LGen('ArrayMan')->rmv_first_index($paresedStr);
				$user_keyword = LGen('ArrayMan')->to_str($newArrStr);
				$type = "hadith";
			}
			else {
				$type = "all";
			}

			$this->search_from2();

			// $dir = BASE_DIR .'/storages/search/';
			// // $hadith_db = 'newbm.json.php';
			// $hadith_db = 'newbm.json';
			// // $quran_db = 'quran.json.php';
			// $quran_db = 'fix_alquran_v1.json';
			// // $quran_db = 'search_quran_fix.json';
			// // $hadith_db = 'search_light_hadith.json';

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
				$this->arr_content = [];
				// $asd['title'] = $user_keyword;
				// $asd['type'] = $user_keyword;	
				// $asd['desc'] = $user_keyword;	
				$result['status'] = 'NOT_FOUND';
				// array_push($this->arr_content, $asd);
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
			$this->arr_content = LGen('ArrJsonMan')->sort($this->arr_content, $sort_by);
			// $this->L->printJson($this->arr_content);
			
			$cols_per_page = 10;
			$final_result = [];
			$page_tot = ceil($this->content_tot/$cols_per_page);
			// for ($i=0+($cols_per_page*$page); $i<$cols_per_page+($cols_per_page*$page); $i++) {
			// 	if (isset($this->arr_content[$i]))
			// 		array_push($final_result, $this->arr_content[$i]);
			// }


			$time_end = microtime_float();
			$time = (string)($time_end - $time_start);
			$time = substr($time, 0, 4);
			
			$result['data'] = $this->arr_content;
			$result['keywords'] = $user_keyword;
			$result['page_num'] = (int)$page;
			$result['page_tot'] = $page_tot;
			$result['is_mistake'] = $is_mistake;
			$result['correction'] = $correction;
			$result['time'] = $time;
			$result['content_tot'] = $this->content_tot;
			$result = json_encode($result, true);
			return $result;
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

		function plain_word_bold($word) {
			$clean = $word;
			$first = null;
			if (strcmp(substr($clean, 0, 1), '(') == 0) {
				$first = '(';
				$clean = substr($clean, 1, strlen($clean)-1);
			}

			$last = null;
			$arrback = [];
			array_push($arrback, array('sign' => '),', 'total' => 2));
			array_push($arrback, array('sign' => ').', 'total' => 2));
			array_push($arrback, array('sign' => ')', 'total' => 1));
			array_push($arrback, array('sign' => '.', 'total' => 1));
			array_push($arrback, array('sign' => ',', 'total' => 1));
			array_push($arrback, array('sign' => ';', 'total' => 1));

			foreach ($arrback as $key => $value) {
				if (strcmp(substr($clean, -$value['total']), $value['sign']) == 0) {
					$last = $value['sign'];
					$clean = substr($clean, 0, strlen($clean)-$value['total']);
					break;
				}
			}

			if ($first != null && $last != null){
				$clean = $first.'<b>'.$clean.'</b>'.$last;
			}
			else if ($first != null) {
				$clean = $first.'<b>'.$clean.'</b>';	
			}
			else if ($last != null) {
				$clean = '<b>'.$clean.'</b>'.$last;	
			}
			else {
				$clean = '<b>'.$clean.'</b>';
			}

			return $clean;
		}

		function title_content_make($prgph, $word) {
			$arr_prgph = explode(" ", $prgph);

			for ($i=0; $i<sizeof($word); $i++) {
				$word[$i] = $this->root_word($word[$i]);
			}

			for ($i=0; $i<sizeof($arr_prgph); $i++) {
				for ($j=0; $j<sizeof($word); $j++) {
					$this->root_word = $this->root_word($arr_prgph[$i]);
					if (LGen('StringMan')->cmp_case_insen($this->root_word, $word[$j], 'part')) {
						$arr_prgph[$i] = $this->plain_word_bold($arr_prgph[$i]);
						$index = $i;
					}
				}
			}

			// $title2 = $this->arrstr_from_index_to_index_backward_get($arr_prgph, sizeof($arr_prgph), $index);
			$title2 = $this->arrstr_from_index_to_index_forward_get($arr_prgph, $index-20, $index+20);
			if ($arr_prgph[0] != $title2[0]) {
				array_unshift($title2, '...');
			}
			if ($arr_prgph[sizeof($arr_prgph)-1] != $title2[sizeof($title2)-1]) {
				array_push($title2, '...');
			}
			// $title2 = $this->getArrayValueUntilIndex($arr_prgph, $index);
			$title2 = LGen('ArrayMan')->to_str($title2);

			$result['title'] = '';
			$result['content'] = $title2;
			// $result['content'] = LGen('ArrayMan')->to_str($arr_prgph);
			return $result;
		}

		function arrstr_from_index_to_index_backward_get($arrstr, $from_index, $to_index) {
			$arrstr_res = [];
			for ($i=$to_index; $i<$from_index; $i++) {
				if (LGen('ArrayMan')->is_index_exist($arrstr, $i)) {
					array_push($arrstr_res, $arrstr[$i]);
				}
			}
			return $arrstr_res;
		}
		
		function arrstr_from_index_to_index_forward_get($arrstr, $from_index, $to_index) {
			$arrstr_res = [];
			for ($i=$from_index; $i<$to_index; $i++) {
				if (LGen('ArrayMan')->is_index_exist($arrstr, $i)) {
					array_push($arrstr_res, $arrstr[$i]);
				}
			}
			return $arrstr_res;
		}

		function title_content_make2($prgph, $word) {
			$arr_prgph = explode(" ", $prgph);

			for ($i=0; $i<sizeof($word); $i++) {
				$word[$i] = $this->root_word($word[$i]);
			}

			if (sizeof($arr_prgph) != 0) {
				$index = 0;
				$is_found = false;
				for ($i=0; $i<sizeof($arr_prgph); $i++) {
					for ($j=0; $j<sizeof($word); $j++) {
						$this->root_word = $this->root_word($arr_prgph[$i]);
						// echo $this->root_word . '<br>';
						if (LGen('StringMan')->cmp_case_insen($this->root_word, $word[$j], 'part')) {
							$index = $i;
							$is_found = true;
							$i = sizeof($arr_prgph);
							$j = sizeof($word);
						}
					}
				}
				// echo $index . '<br>';
				// $this->L->printJson($arr_prgph);
				// $this->L->printJson($word);

				$str_after = [];
				$isEnd = false;
				// $this->L->printJson($string);
				for ($i=$index+1; $i<$index+20; $i++) {
					if (array_key_exists($i, $arr_prgph)) {
						$match = false;
						$_word = $this->root_word($arr_prgph[$i]);

						for ($j=0; $j<sizeof($word); $j++) {
							$_word2 = $this->root_word($word[$j]);
							// echo '$_word2 ' . $_word2 .'<br>';
							// echo '$_word ' . $_word .'<br>';
							if (LGen('StringMan')->cmp_case_insen($_word, $_word2, 'part')) {
								array_push($str_after, '<b>' . $arr_prgph[$i] . '</b>');
								$match = true;
								$j = sizeof($word);
							}
						}
						if (!$match) {
							array_push($str_after, $arr_prgph[$i]);
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
					if (array_key_exists($i, $arr_prgph)) {
						$match = false;
						$_word = $this->root_word($arr_prgph[$i]);
						for ($j=0; $j<sizeof($word); $j++) {
							$_word2 = $this->root_word($word[$j]);
							// echo '$_word2 ' . $_word2 .'<br>';
							// echo '$_word ' . $_word .'<br>';
							if (LGen('StringMan')->cmp_case_insen($_word, $_word2, 'part')) {
								array_unshift($str_before, '<b>' . $arr_prgph[$i] . '</b>');
								$match = true;
								$j = sizeof($word);
							}
						}
						if (!$match) {
							array_unshift($str_before, $arr_prgph[$i]);
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
				$title = LGen('ArrayMan')->to_str($title);

				$title2 = $this->getArrayValueUntilIndexBackward($str_before, 2);
				$title2 = LGen('ArrayMan')->to_str($title2);

				$str_before = LGen('ArrayMan')->to_str($str_before);
				$str_after = LGen('ArrayMan')->to_str($str_after);

				// $this->L->printJson($str_before);
				// $this->L->printJson($str_after);
				if ($is_found) {
					$result['content'] = $str_before . ' <b>' . $arr_prgph[$index] . '</b> ' . $str_after;
				}
				else {
					$result['content'] = $str_before . ' ' . $arr_prgph[$index] . ' ' . $str_after;				
				}
				// $result['title'] = ucfirst($arr_prgph[$index]) . ' ' . $title;
				if ($title2 != '') {
					$result['title'] = '... ' . $title2 . ' ' . $arr_prgph[$index] . ' ' . $title;
				}
				else {
					$result['title'] = ucfirst($arr_prgph[$index]) . ' ' . $title;
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