<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

$D = new DataliteGen();

class DataliteGen {

	public function __construct() {
		if(!class_exists('lanterlite')) { include 'init.php'; }
		$this->L = new Lanterlite();
		set_time_limit ( 0 );
	}

	public function index() {
		$data = json_decode(file_get_contents("php://input"), true);
		if (isset($data)) {
			echo eval($data[DATA]);
		}
	}

	public function invix_old1($src_dir, $des_dir) {
		set_time_limit ( 0 );
		$this->L->word_activate();
		$final_obj = [];
		$words = [];
		// $this->L->printJson($content);
		$files = $this->L->getFileNamesInsideDir($src_dir)[DATA];
		foreach ($files as $key => $value) {
			$file_path = $src_dir . $value;
			$content = $this->L->json_read($file_path)[DATA];
			foreach ($content as $_ckey => $_cval) {
				$str = $this->L->clean_string($_cval['content']);
				$str = $this->L->str_to_arr($str, " ");

				foreach ($str as $_skey => $_sval) {
					if ($_sval != "") {
						// $root_word = $_sval;
						$root_word = $this->L->root_word($_sval);
						if (!in_array($root_word, $words)) {

							// $obj = {};
							$_obj['index'] = [];
							$_obj['word'] = $root_word;
							// array_push($_obj['index'], $_ckey);
							// array_push($_obj['index'], $_cval['index']);
							array_push($_obj['index'], $_cval['id']);
							array_push($final_obj, $_obj);
							array_push($words, $root_word);
						}
						else {
							$index = $this->L->get_arr_index($words,$root_word);
							// if (!in_array($_ckey, $final_obj[$index]['index'])) {
							// 	array_push($final_obj[$index]['index'], $_ckey);
							// }
							if (!in_array($_cval['id'], $final_obj[$index]['index'])) {
								array_push($final_obj[$index]['index'], $_cval['id']);
							}
						}
					}
				}
			}
		}
		// $this->L->printJson($final_obj);
		$this->L->json_save($des_dir, 'result.invix.json', $final_obj, $minify=true);
		echo SUCCESS;
	}

	public function invix($src_dir, $des_dir) {
		set_time_limit ( 0 );
		$this->L->word_activate();
		$final_obj = [];
		$words = [];
		// $this->L->printJson($content);
		$files = $this->L->getFileNamesInsideDir($src_dir)[DATA];
		foreach ($files as $key => $value) {
			$file_path = $src_dir . $value;
			$content = $this->L->json_read($file_path)[DATA];
			foreach ($content as $_ckey => $_cval) {
				$str = $this->L->clean_string($_cval['content']);
				$str = $this->L->str_to_arr($str, " ");

				foreach ($str as $_skey => $_sval) {
					if ($_sval != "") {
						$root_word = $this->L->root_word($_sval);

						$data = $this->L->json_read($src_dir.$root_word);
						if ($data[RES_STAT] == NOT_FOUND) {
							$_obj['index'] = [];
							array_push($_obj['index'], $_cval['id']);
							$this->L->json_save($des_dir, $root_word, $_obj);
						}
						else {
							// $index = $this->L->get_arr_index($words,$root_word);
							// if (!in_array($_ckey, $final_obj[$index]['index'])) {
							// 	array_push($final_obj[$index]['index'], $_ckey);
							// }
							$_obj = $data[DATA];
							if (!in_array($_cval['id'], $_obj['index'])) {
								array_push($_obj['index'], $_cval['id']);
								$this->L->json_save($des_dir, $root_word, $_obj);
							}
						}
					}
				}
			}
		}
		// $this->L->printJson($final_obj);
		// $this->L->json_save($des_dir, 'result.invix.json', $final_obj, $minify=true);
		echo SUCCESS;
	}

	public function invix2($src_dir, $des_dir) {
		$this->L->word_activate();

		$file_path = $des_dir . 'result.invix.json';
		$final_obj = $this->L->json_read($file_path)[DATA];
		$words = [];
		// $this->L->printJson($content);
		$files = $this->L->getFileNamesInsideDir($src_dir)[DATA];
		foreach ($files as $key => $value) {
			$file_path = $src_dir . $value;
			$content = $this->L->json_read($file_path)[DATA];
			foreach ($content as $_ckey => $_cval) {
				$str = $this->L->clean_string($_cval['content']);
				$str = $this->L->str_to_arr($str, " ");

				foreach ($str as $_skey => $_sval) {
					if ($_sval != "") {
						// $root_word = $_sval;
						$root_word = $this->L->root_word($_sval);
						if (!in_array($root_word, $words)) {

							// $obj = {};
							$_obj['index'] = [];
							$_obj['word'] = $root_word;
							array_push($_obj['index'], $_cval['index']);
							array_push($final_obj, $_obj);
							array_push($words, $root_word);
						}
						else {
							$index = $this->L->get_arr_index($words,$root_word);
							if (!in_array($_ckey, $final_obj[$index]['index'])) {
								array_push($final_obj[$index]['index'], $_ckey);
							}
						}
					}
				}
			}
		}
		// $this->L->printJson($final_obj);
		$this->L->json_save($des_dir, 'result.invix.json', $final_obj);
		echo SUCCESS;
	}

	public function changable_mto_func($content) {
		// $asd = preg_split('/ /', $content['id'], 2);
		// $this->L->printJson($asd);
		list($_id, $_content) = preg_split('/ /', $content['id'], 2);
		$hadith = preg_split('/\//', $_id, 2);
		$hadith[1] = str_replace('.','',$hadith[1]);
		$content['id'] = 'SB.' . $hadith[1];
		$content['hadith_no'] = 'Hadith No. ' . $hadith[1];
		$content['source'] = 'Shahih Bukhari';
		$content['content'] = $_content;
		$content['chapter'] = $content['bab'];
		unset($content['bab']);
		$content['arabic'] = $content['ar'];
		unset($content['ar']);
		return $content;
	}

	public function mto($src_dir, $des_dir) {
		$final_obj = [];
		$files = $this->L->getFileNamesInsideDir($src_dir)[DATA];
		foreach ($files as $key => $value) {
			$file_path = $src_dir . $value;
			$content = $this->L->json_read($file_path)[DATA];
			if (!in_array($content, $final_obj)) {
				$content = $this->changable_mto_func($content);
				$content['index'] = sizeof($final_obj);
				// $content['id'] = $content['hadith_no'];
				// $content['id'] = $content['id'];
				array_push($final_obj, $content);
			}
		}
		$this->L->json_save($des_dir, 'result.mto.json', $final_obj);
		echo SUCCESS;
	}

	public function index_chg($src_dir, $des_dir) {
		$final_obj = [];
		$files = $this->L->getFileNamesInsideDir($src_dir)[DATA];
		foreach ($files as $_fkey => $_fval) {
			$file_path = $src_dir . $_fval;
			$content = $this->L->json_read($file_path)[DATA];
			foreach ($content as $_ckey => $_cval) {
				if (!in_array($_cval, $final_obj)) {
					$_cval['index'] = sizeof($final_obj) + 14683;
					array_push($final_obj, $_cval);
				}
			}
		}
		$this->L->json_save($des_dir, 'index.new.json', $final_obj);
		echo SUCCESS;
	}

	public function all_to_words($src_dir, $des_dir) {
		$words = [];
		$files = $this->L->getFileNamesInsideDir($src_dir)[DATA];
		foreach ($files as $_fkey => $_fval) {
			$file_path = $src_dir . $_fval;
			$content = $this->L->json_read($file_path)[DATA];
			foreach ($content as $_ckey => $_cval) {
				$dirt_text = $this->L->clean_string($_cval['content']);
				$clean_text = preg_split('/ /', $dirt_text);
				foreach ($clean_text as $_tkey => $_tval) {
					if (!in_array($_tval, $words)) {
						array_push($words, $_tval);
					}
				}
			}
		}
		$this->L->json_save($des_dir, 'words3.json', $words);
		echo SUCCESS;
	}

	public function otm($src_dir, $des_dir) {
		$words = [];
		$files = $this->L->getFileNamesInsideDir($src_dir)[DATA];
		foreach ($files as $_fkey => $_fval) {
			$file_path = $src_dir . $_fval;
			$content = $this->L->json_read($file_path)[DATA];
			foreach ($content as $_ckey => $_cval) {
				$this->L->json_save($des_dir, $_cval['word'], $_cval);
			}
		}
		echo SUCCESS;
	}

	public function mto2($src_dir, $des_dir) {
		$final_obj = [];
		$files = $this->L->getFileNamesInsideDir($src_dir)[DATA];
		foreach ($files as $_fkey => $_fval) {
			$file_path = $src_dir . $_fval;
			$content = $this->L->json_read($file_path)[DATA];
			foreach ($content as $_ckey => $_cval) {
				if (!in_array($_cval, $final_obj)) {
					$_cval['index'] = sizeof($final_obj);
					// $_cval['id'] = $_cval['hadith_no'];
					array_push($final_obj, $_cval);
				}

			}
		}
		$this->L->json_save($des_dir, 'result.mto2.json', $final_obj);
		echo SUCCESS;
	}
}

?>