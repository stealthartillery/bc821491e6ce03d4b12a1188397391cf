<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Image extends CI_Controller{

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		include BASE_DIR . 'lantergen.php';
		include BASE_DIR . 'assets/image/Image.php';
		$image = new ImageGen();
		$data = json_decode(file_get_contents("php://input"), true);
		if (isset($_POST[DATA]))
			$data = $_POST;
		if (isset($data)) {
			$asd = LGen('F')->decrypt($data[DATA]);
			$func = urldecode($asd['func']);
			$json = $asd['json'];
			eval('$result = '.$func.'($json);');
			echo LGen('F')->encrypt($result);
		}
		else if (isset($_GET["f"])) {
			$asd = LGen('F')->decrypt($_GET["f"]);
			$func = urldecode($asd['func']);
			$json = $asd['json'];
			eval('$result = '.$func.'($json);');
			echo LGen('F')->encrypt($result);
		}
	}
}