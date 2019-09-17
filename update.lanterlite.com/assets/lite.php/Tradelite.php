<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

$G = new TradeliteGen();

class TradeliteGen {

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

	public function get_store_list() {
		$dir = BASE_DIR . 'storages/tradelite/store_list/';
		$result = $this->L->getFileNamesInsideDir($dir);
		$result = json_encode($result, true);
		echo $result;
	}

	public function get_store($store_id, $lang_id) {
		$file_path = BASE_DIR . 'storages/tradelite/store_list/'.$store_id.'/'.$lang_id;
		$result = $this->L->json_read($file_path);

		$dir = BASE_DIR . 'storages/tradelite/store_list/'.$store_id.'/img/';
		$result[DATA]['img'] = $this->L->getFileNamesInsideDir($dir)[DATA];

		foreach ($result[DATA]['img'] as $key => $value) {
			$result[DATA]['img'][$key] = BASE_URL . 'storages/tradelite/store_list/'.$store_id.'/img/'.$value;
		}

		$result = json_encode($result, true);
		echo $result;
	}

	public function get_item_list() {
		$dir = BASE_DIR . 'storages/tradelite/item_list/';
		$result = $this->L->getFileNamesInsideDir($dir);
		$result = json_encode($result, true);
		echo $result;
	}

	public function get_item($item_id, $lang_id) {
		$file_path = BASE_DIR . 'storages/tradelite/item_list/'.$item_id.'/'.$lang_id;
		$result = $this->L->json_read($file_path);

		$dir = BASE_DIR . 'storages/tradelite/item_list/'.$item_id.'/img/';
		$result[DATA]['img'] = $this->L->getFileNamesInsideDir($dir)[DATA];

		foreach ($result[DATA]['img'] as $key => $value) {
			$result[DATA]['img'][$key] = BASE_URL . 'storages/tradelite/item_list/'.$item_id.'/img/'.$value;
		}

		$result = json_encode($result, true);
		echo $result;
	}

	public function set_item($item_id, $lang_id, $json_obj) {
		$json_obj = base64_decode($json_obj);
		$json_obj = json_decode($json_obj);
		// echo $item_id;
		// echo $lang_id;
		// $this->L->printJson($json_obj);
		$file_dir = BASE_DIR . 'storages/tradelite/item_list/'.$item_id.'/';
		// echo $file_dir;
		$result = $this->L->json_save($file_dir, $lang_id, $json_obj);
		$result = json_encode($result, true);
		echo $result;
	}
}

?>