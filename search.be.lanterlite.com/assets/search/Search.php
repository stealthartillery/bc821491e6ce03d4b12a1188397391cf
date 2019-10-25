<?php
	// ini_set("log_errors", 1);
	// ini_set("error_log", BASE_DIR.'storages/search/'. 'search.log');
	
	// function mysort3($userInput){

	// 	$arr_str = LGen('JsonMan')->read(BASE_DIR . 'storages/search/words.json');

	// 	$arr_inp = LGen('StringMan')->to_arr(strtolower($userInput), ' ');
	// 	$scores = [];
	// 	$corrected_words = [];

	// 	for ($j=0; $j<sizeof($arr_inp); $j++) {
	// 		array_push($scores, 0);
	// 		array_push($corrected_words, '-');
	// 	}
	// 	for ($i=0; $i<sizeof($arr_str); $i++) {
	// 		for ($j=0; $j<sizeof($arr_inp); $j++) {

	// 		  similar_text($arr_inp[$j], $arr_str[$i], $percentA);
	// 		  if ($percentA > 50 && $percentA > $scores[$j]) {
	// 		  	$scores[$j] = $percentA;
	// 		  	$corrected_words[$j] = $arr_str[$i];						
	// 		  }
	// 		}
	// 	}

	// 	$result['scores'] = $scores;
	// 	$result['words'] = $corrected_words;
	// 	// printJson($result);
	// 	return $result;
	// }


		function mysort3($userInput){

			$arr_str = LGen('JsonMan')->read(BASE_DIR . 'storages/search/words.json');

			$arr_inp = LGen('StringMan')->to_arr(strtolower($userInput), ' ');
			$scores = [];
			$corrected_words = [];

			for ($j=0; $j<sizeof($arr_inp); $j++) {
				array_push($scores, 0);
				array_push($corrected_words, '-');
			}

			for ($i=0; $i<sizeof($arr_str); $i++) {
				for ($j=0; $j<sizeof($arr_inp); $j++) {

				  similar_text($arr_inp[$j], $arr_str[$i], $percentA);
				  if ($percentA > 50 && $percentA > $scores[$j]) {
				  	$scores[$j] = $percentA;
				  	$corrected_words[$j] = $arr_str[$i];						
				  }
				}
			}

			$result['scores'] = $scores;
			$result['words'] = $corrected_words;
			// printJson($result);
			return $result;
		}		

		function correcting($user_keyword, $arr_user_keywords) {
			$user_keyword = LGen('StringMan')->clean($user_keyword);
			$result_2 = mysort3($user_keyword);

			$is_mistake = false;
			$correction = '';
			$need_correction = true;

			for ($i=0;$i<sizeof($result_2['words']); $i++) {
				if ($result_2['scores'][$i] == 100) {
					$need_correction = false;
					break;
				}
			}

			if ($need_correction) {
				for ($i=0;$i<sizeof($result_2['words']); $i++) {
					if (!in_array($result_2['words'][$i], $arr_user_keywords))
						array_push($arr_user_keywords, $result_2['words'][$i]);
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
						$arr_user_keywords = null;
						$i = sizeof($result_2['words']);
					}
				}
			}

			// $obj
			// if ($arr_user_keywords != null) {
			if ($correction === '')
				$correction = 'no correction';
			$obj = [];
			$obj['is_mistake'] = $is_mistake;
			$obj['correction'] = $correction;						
			// }
			return $obj;
		}

		function type_make($item) {
			$title = '';
			if (isset($item['ch_ttl']))
				$title = $title . $item['ch_ttl'] . ' ';

			if (isset($item['ch_no']))
				$title = $title . '('.$item['ch_no'] . ')'. ' : ';
			else
				$title = $title . ': ';

			if (isset($item['hadith_no'])) {
				$title = $title . $item['hadith_no'];
			}
			
			return $title;
		}

		function diff($v1, $v2) {
	    return ($v1-$v2) < 0 ? (-1)*($v1-$v2) : ($v1-$v2);
		}

		function title_content_make($prgph, $word, $wordman) {
			$arr_prgph = explode(" ", $prgph);

			// for ($i=0; $i<sizeof($word); $i++) {
			// 	$word[$i] = LGen('StringMan')->root_word($wordman, $word[$i]);
			// }

			$_index = [];
			for ($j=0; $j<sizeof($word); $j++) {
				$_index[$word[$j]] = [];
				for ($i=0; $i<sizeof($arr_prgph); $i++) {
					$root_word = $arr_prgph[$i];
					// $root_word = LGen('StringMan')->root_word($wordman, $arr_prgph[$i]);
					if (LGen('StringMan')->cmp_case_insen($root_word, $word[$j], 'part')) {
						array_push($_index[$word[$j]], $i);
						$arr_prgph[$i] = plain_word_bold($arr_prgph[$i]);
						$index = $i;
					}
				}
			}

			// JADIIN SATU AJA
			$ikeys = LGen('JsonMan')->get_keys($_index);
			if ($ikeys>1) {
				// $index = 0;
				$lowest_diff = 100;

				for ($k=0; $k<sizeof($_index[$ikeys[0]]); $k++) {
					for ($i=1; $i<sizeof($ikeys); $i++) {
						for ($j=0; $j<sizeof($_index[$ikeys[$i]]); $j++) {
							// if (array_key_exists($j+1, $_index[$ikeys[$i]])) {
								// error_log($_index[$ikeys[$i]][$j] . ' - '. $_index[$ikeys[0]][$k]);
								$_diff = diff($_index[$ikeys[$i]][$j], $_index[$ikeys[0]][$k]);
								if ($_diff < $lowest_diff) {
									$index = $_index[$ikeys[$i]][$j];
									$lowest_diff = $_diff;
								}
							// }
						}
					}
				}
			}

			// error_log(json_encode($_index));
			// if ()
			// 	abs($var1 - $var2);
			// $title2 = $this->arrstr_from_index_to_index_backward_get($arr_prgph, sizeof($arr_prgph), $index);
			$title2 = arrstr_from_index_to_index_forward_get($arr_prgph, $index-20, $index+20);
			if ($arr_prgph[0] != $title2[0]) {
				array_unshift($title2, '...');
			}
			if ($arr_prgph[sizeof($arr_prgph)-1] != $title2[sizeof($title2)-1]) {
				array_push($title2, '...');
			}
			// $title2 = $this->getArrayValueUntilIndex($arr_prgph, $index);
			$title2 = LGen('ArrayMan')->to_str($title2);

			$result['content'] = $title2;
			// $result['content'] = LGen('ArrayMan')->to_str($arr_prgph);
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

		function arrstr_from_index_to_index_forward_get($arrstr, $from_index, $to_index) {
			$arrstr_res = [];
			for ($i=$from_index; $i<$to_index; $i++) {
				if (LGen('ArrayMan')->is_index_exist($arrstr, $i)) {
					array_push($arrstr_res, $arrstr[$i]);
				}
			}
			return $arrstr_res;
		}
	

	function remove_duplicates($arr) {
		return array_diff($arr, array_diff_assoc($arr, array_unique($arr)));
		// return array_unique($array);
	}

	function has_dupes($array) {
	   // streamline per @Felix
	   return count($array) !== count(array_unique($array));
	}

	// function has_dupes2($array) {
	//    $dupe_array = array();
	//    foreach ($array as $val) {
	//        if (++$dupe_array[$val] > 1) {
	//            return true;
	//        }
	//    }
	//    return false;
	// }

	class SearchGen {
		public function __construct() {
			set_time_limit ( 0 );
		}

		function adada() {
			return 'qwe';
		}

		function search2($obj) {
			$user_keyword = $obj['user_keyword'];
			$page = $obj['page'];

			$log = LGen('StringMan')->to_json('{}');
			$log['ip'] = LGen('F')->get_client_ip();
			$log['keywords'] = $user_keyword;
			$log['page'] = $page;
			$log['date'] = gmdate("Y/m/d H:i:s T");
			$log['filename'] = 'search/citizen.search.log';
			LGen('F')->log($log);

			$time_start = microtime_float();
			$dir = BASE_DIR .'/storages/search/';
			$dir_to_dbs = $dir.'sources/final/';

			$cache_filenames = getFileNamesInsideDir($dir.'cache/');
			$wordman = LGen('StringMan')->get_wordman();
			// echo json_encode($cache_filenames); return 0;

			$db_dirnames = getFileNamesInsideDir($dir_to_dbs);
			$arr_user_keywords = LGen('StringMan')->to_arr($user_keyword, ' ');
			$arr_user_root_keywords = [];
			foreach ($arr_user_keywords as $key => $value) {
				array_push($arr_user_root_keywords, LGen('StringMan')->root_word($wordman, $value));
			}

			$break = false;
			$typo = LGen('JsonMan')->read($dir.'typo.words.json');
			// echo sizeof($typo);
			for ($i=0; $i<sizeof($arr_user_keywords); $i++) {
				$root_word = $arr_user_root_keywords[$i];
				for ($j=0; $j<sizeof($typo); $j++) {
					for ($l=0; $l<sizeof($typo[$j]); $l++) {
						if ($typo[$j][$l] === $root_word) {
							// echo json_encode($typo[$j][0]); return 0;
							if (!in_array($typo[$j][0], $arr_user_keywords)) {
								array_push($arr_user_keywords, $typo[$j][0]);
								array_push($arr_user_root_keywords, $typo[$j][0]);
							}
							// for ($k=0; $k<sizeof($typo[$j]); $k++) {
							// 	if (!in_array($typo[$j][$k], $arr_user_keywords))
							// 		array_push($arr_user_keywords, $typo[$j][$k]);
							// }
							$break = true;
							break;
						}
					}
					if ($break)
						break;
				}
			}

			$break = false;
			$synonym = LGen('JsonMan')->read($dir.'synonym.words.json');
			for ($i=0; $i<sizeof($arr_user_keywords); $i++) {
				$root_word = $arr_user_root_keywords[$i];
				for ($j=0; $j<sizeof($synonym); $j++) {
					for ($l=0; $l<sizeof($synonym[$j]); $l++) {
						if ($synonym[$j][$l] === $root_word) {
							// array_push($arr_user_keywords, $synonym[$j][0]);
							for ($k=0; $k<sizeof($synonym[$j]); $k++) {
								if (!in_array($synonym[$j][$k], $arr_user_keywords)) {
									array_push($arr_user_keywords, $synonym[$j][$k]);
									array_push($arr_user_root_keywords, $synonym[$j][$k]);
								}
							}
							$break = true;
							break;
						}
					}
					if ($break)
						break;
				}
			}

			if (in_array($user_keyword, $cache_filenames)) {
				$__obj = LGen('JsonMan')->read($dir.'cache/'.$user_keyword);
				$final_result = $__obj['final_result'];
				// $arr_user_keywords = $arr_user_keywords;
				goto final_result_phase;
			}


			// echo json_encode($arr_user_keywords); return 0;

			$all_words = [];
			// error_log(json_encode($arr_user_root_keywords));
			foreach ($arr_user_root_keywords as $key => $value) {
				$all_words[$value] = [];
				foreach ($db_dirnames as $db_key => $db_value) {
					$res = LGen('JsonMan')->read($dir_to_dbs.$db_value.'/id/words/'.$value);
					if ($res !== LGen('GlobVar')->failed) {
						$_ids = LGen('JsonMan')->get_keys($res);
						foreach ($_ids as $id_key => $id_value) {
							$all_words[$value][$id_value] = $res[$id_value]; // $all_words = {"mad":{"aq.11.84":1,"msm.11.95":1,"sb.28.22":1,"sd.28.23":1}}
						}
					}
				}
			}

			$ids = [];
			$_keys2 = [];
			foreach ($all_words as $key => $value) {
				$ids[$key] = LGen('JsonMan')->get_keys($all_words[$key]); // $ids = {"mad":["aq.11.84","sb.23.4","msm.23.4"]}
				array_push($_keys2, $key); // $_keys2 = ["mad"]
			}
			// json_encode($ids)
			// $_keys2 = LGen('JsonMan')->get_keys($ids);

			// error_log(json_encode($all_words));

			$res = $ids[$_keys2[0]]; // res = ["aq.11.84","sb.23.4","msm.23.4"]
			$res_intersect = [];
			for ($i=1; $i<sizeof($_keys2); $i++) {
				$res = LGen('ArrayMan')->intersect($ids[$_keys2[$i]], $res);
			}
			// res contains only intersected array (ex. ["aq.11.84","sb.23.4"])


			// error_log(json_encode($all_words)); return 0;
			$res = remove_duplicates($res);
			$res_intersect = $res;

			// get array of scores
			$arr_scores = [];
			for ($i=0; $i<sizeof($res_intersect); $i++) {
				$arr_scores[$res_intersect[$i]] = 0;
				for ($j=0; $j<sizeof($_keys2); $j++) {
					$arr_scores[$res_intersect[$i]] += $all_words[$_keys2[$j]][$res_intersect[$i]];
				}
			}
			
			$final_result = [];
			for ($k=0; $k<sizeof($res); $k++) {
				$__res = [];
				$__res['id'] = $res[$k];
				$score = $arr_scores[$res[$k]];
				$__res['score'] = (in_array($res[$k], $res_intersect))? $score+100 : $score;
				array_push($final_result, $__res);
			}

			$time_end = microtime_float();
			$time = (string)($time_end - $time_start);
			$time = substr($time, 0, 4);
			error_log($time);

			$final_result = LGen('ArrJsonMan')->sort($final_result, 'score');
			// echo json_encode($final_result); return 0;
			// echo json_encode($final_result);
			// return 0;

			// $cache_filenames = getFileNamesInsideDir($dir.'cache');
			if (!in_array($user_keyword, $cache_filenames)) {
				$__obj = [];
				$__obj['final_result'] = $final_result;
				$__obj['arr_user_keywords'] = $arr_user_keywords;
				LGen('JsonMan')->save($dir.'/cache/',$user_keyword, $__obj, $minify=false);
			}

			final_result_phase:

			$final_obj = [];

			$content_index_start = $page*10;
			$content_index_end = ($page+1)*10;
			// echo json_encode($final_result[8]['id']); return 0;

			for ($i=$content_index_start; $i<$content_index_end; $i++) {
				// echo $i . ' ' .  sizeof($final_result);
				// echo PHP_EOL;
				if ($i<sizeof($final_result)) {
					$db_value = explode('.', $final_result[$i]['id'])[0];
					$filename = $final_result[$i]['id'].'.json';
					// echo json_encode($final_result[$i]);
					// echo PHP_EOL;
					$obj = LGen('JsonMan')->read($dir_to_dbs.$db_value.'/id/'.$filename);
					$obj['_id'] = $final_result[$i]['id'];
					array_push($final_obj, $obj);
				}
			}


			// echo json_encode($final_result);
			// $data['desc'] = $item2['content'];
			$title = [];
			$title['aq'] = 'Al-Qur\'an';
			$title['sb'] = 'Shahih Bukhari';
			$title['sm'] = 'Shahih Muslim';
			$title['rs'] = 'Riyadhus Shalihin';
			$title['an'] = 'Arba\'in Nawawi';
			$title['bm'] = 'Bulughul Maram';
			$title['sd'] = 'Silsilah Dhaifah';
			$title['msm'] = 'Mukhtasar Shahih Muslim';

			$data = [];
			for ($i=0; $i<sizeof($final_obj); $i++) {
				$_title = LGen('StringMan')->to_arr($final_obj[$i]['_id'], '.');
				$_data = [];
				$_data['id'] = $final_obj[$i]['_id'];
				$_data['type'] = type_make($final_obj[$i]);
				// $_data['desc'] = 'asd';
				$_data['desc'] = title_content_make($final_obj[$i]['id'], $arr_user_root_keywords, $wordman)['content'];
				$_data['title'] = $title[$_title[0]] . ' | '.$final_obj[$i]['ch_ttl'];
				array_push($data, $_data);
			}

			$time_end = microtime_float();
			$time = (string)($time_end - $time_start);
			$time = substr($time, 0, 4);
			error_log($time);

			// echo json_encode($data[0]);

			$cols_per_page = 10;
			$page_tot = ceil(sizeof($final_result)/$cols_per_page);

			$time_end = microtime_float();
			$time = (string)($time_end - $time_start);
			$time = substr($time, 0, 4);

			$correction = correcting($user_keyword, $arr_user_keywords);

			$result = [];
			$result['data'] = $data;
			$result['keywords'] = $user_keyword;
			$result['page_num'] = (int)$page;
			$result['page_tot'] = $page_tot;
			$result['is_mistake'] = $correction['is_mistake'];
			$result['correction'] = $correction['correction'];
			$result['time'] = $time;
			$result['content_tot'] = sizeof($final_result);
			$result = json_encode($result, true);
			// echo json_encode($result);
			return $result;

		}

		function content($obj) {
			$content_id = $obj['content_id'];
			$id = LGen('StringMan')->to_arr($content_id, ".");
			$dir = BASE_DIR .'/storages/search/';

			// $str = include $dir .'/newbm.json.php';
			// $str = file_get_contents($dir .'/result.mto2.json');
			// $json = json_decode($str, true);

			$src_id = $id[0];
			$json_ar = LGen('JsonMan')->read($dir.'sources/final/'.$src_id.'/ar/'.$content_id.'.json');
			$json_id = LGen('JsonMan')->read($dir.'sources/final/'.$src_id.'/id/'.$content_id.'.json');
			// error_log($dir.'sources/'.$src_id.'/'.$index);
			// $asd_tot = [];


			$title = [];
			$title['aq'] = 'Al-Qur\'an';
			$title['sb'] = 'Shahih Bukhari';
			$title['sm'] = 'Shahih Muslim';
			$title['rs'] = 'Riyadhus Shalihin';
			$title['an'] = 'Arba\'in Nawawi';
			$title['bm'] = 'Bulughul Maram';
			$title['sd'] = 'Silsilah Dhaifah';
			$title['msm'] = 'Mukhtasar Shahih Muslim';

			$asd['title'] = (array_key_exists('ch_ttl', $json_id))? $json_id['ch_ttl'] : $title[$id[0]];
			$asd['subtitle_1'] = $title[$id[0]];
			$asd['subtitle_2'] = (array_key_exists('hadith_no', $json_id))? $json_id['hadith_no'] : '';
			// $asd['precontent'] = $item['narrator'];
			$asd['content'] = (array_key_exists('id', $json_id))? $json_id['id'] : '';
			// error_log($json_ar['ar']);
			$asd['arabic_content'] = (array_key_exists('ar', $json_ar))? $json_ar['ar'] : '';;
			// $asd['postcontent_1'] = $item['collector'];
			// $asd['postcontent_2'] = $item['degree'];
			// $asd['addition'] = $item['comment'];
			// array_push($asd_tot, $asd);

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

	}
?>