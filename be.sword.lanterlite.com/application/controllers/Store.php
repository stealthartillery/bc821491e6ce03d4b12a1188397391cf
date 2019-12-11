<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

ini_set("log_errors", 1);
ini_set("error_log", HOME_DIR.'storages/'. 'be.log');

class Store extends CI_Controller{

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		include BASE_DIR . 'lantergen.php';
		include HOME_DIR . 'app/lanterapp.php';
		$data = json_decode(file_get_contents("php://input"), true);

		if (isset($_POST[DATA]))
			$data = $_POST;

		if (isset($data)) {
			$asd = LGen('F')->decrypt($data[DATA]);
			$func = urldecode($asd['func']);
			$json = $asd['json'];
			eval('$result = '.$func.'($json);');
			echo LGen('F')->encrypt($result);

			// $fefe = (base64_decode($data[DATA]));
			// eval('$asd = '.$fefe.';');
			// echo base64_encode(json_encode($asd));
		}
		else if (isset($_GET["f"])) {
			// error_log($_GET["f"]);
			$asd = LGen('F')->decrypt($_GET["f"]);
			$func = urldecode($asd['func']);
			// error_log(json_decode($asd));
			// error_log('$result = '.$asd['func'].'($json);');
			$json = $asd['json'];
			eval('$result = '.$func.'($json);');
			echo LGen('F')->encrypt($result);

			// $fefe = (base64_decode($_GET["f"]));
			// eval('$asd = '.$fefe.';');
			// echo base64_encode(json_encode($asd));
		}
	}
}