<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

$D = new DataliteGen();

class DataliteGen {

	public function __construct() {
		if(!class_exists('lanterlite')) { include 'init.php'; }
		$this->L = new Lanterlite();
	}

	public function index() {
		$data = json_decode(file_get_contents("php://input"), true);
		if (isset($data)) {
			echo eval($data[DATA]);
		}
	}

	public function invix($src_dir, $des_dir) {
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

	public function mto($src_dir, $des_dir) {
		$final_obj = [];
		$files = $this->L->getFileNamesInsideDir($src_dir)[DATA];
		foreach ($files as $key => $value) {
			$file_path = $src_dir . $value;
			$content = $this->L->json_read($file_path)[DATA];
			if (!in_array($content, $final_obj)) {
				$content['index'] = sizeof($final_obj);
				// $content['id'] = $content['hadith_no'];
				$content['id'] = $content['id'];
				array_push($final_obj, $content);
			}
		}
		$this->L->json_save($des_dir, 'result.mto.json', $final_obj);
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