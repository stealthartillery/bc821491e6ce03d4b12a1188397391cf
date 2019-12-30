<?php
	
	$spark = new SparkGen();
	define('MAX_TOT_MSGS', 10);
	define('MAX_TOT_POSTS', 10);

	function pack_ans($text='', $action='') {
		$res = [];
		$res['text'] = $text;
		$res['action'] = $action;
		return $res;
	}

	class SparkGen {
		public function __construct() {
			set_time_limit ( 0 );
		}

		public function get_answer($obj) {
			$keyword = $obj['val']['text'];
			$lang=$obj['val']['lang'];
			$keyword = LGen('StringMan')->clean2($keyword);
			$keyword = strtolower($keyword);
			$keywords = LGen('StringMan')->to_arr($keyword, ' ');
			$keywords_list2d = [];
			$corrections = LGen('JsonMan')->read(HOME_DIR.'assets/correction.json');
			// error_log(json_encode($corrections));
			foreach ($keywords as $kw_key => $kw_val) {
			  foreach ($corrections as $c_key => $c_val) {
			    $index = LGen('ArrayMan')->get_index($c_val, $kw_val);
			    if ($index >= 0) {
			    	// error_log($index);
			      $keywords[$kw_key] = $c_key;
			    }
			  }
			}

			// error_log(json_encode($keywords));

			$actions = [];
			$meanings = LGen('JsonMan')->read(HOME_DIR.'assets/meaning.json');
			foreach ($keywords as $kw_key => $kw_val) {
			  foreach ($meanings as $m_key => $m_val) {
			    $index = LGen('ArrayMan')->get_index($m_val['keywords'], $kw_val);
			    if ($index >= 0) {
			    	// error_log(json_encode($m_val['keywords']));
				    if (!LGen('JsonMan')->is_key_exist($actions, $m_key))
				    	$actions[$m_key] = 0;
				    $actions[$m_key] += 1;
				    if ($actions[$m_key] === sizeof($m_val['keywords'])) {
				    	error_log(json_encode($m_val['keywords']));
				    	eval('$res = $this->'.$m_val['action'].';');
				    	return $res;
				    }
			      // $keywords[$kw_key] = $m_val['keywords'];
			    }
			  }
			}
			return pack_ans('hello');
		}


		public function get_bot_name() {return pack_ans('Spark. :)');}
		public function get_bot_desc() {return pack_ans("Saya objek artifisial yang dibuat untuk menjadi teman mu. :)");}
		public function get_current_date() {return pack_ans(gmdate("Y/m/d H:i:s T"), 'date_to_fulldate');}
		public function get_current_day() {return pack_ans(gmdate("Y/m/d H:i:s T"), 'date_to_day');}
	}