<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class NewUser extends CI_Controller {


	public function __construct() {
		parent::__construct();
	}

	public function index($search=NULL, $page=NULL) {
		header('Content-Type: application/json');
		// echo json_encode($resp);
		echo $search . $page;
		// include HOME_DIR . 'assets/lite.php/Enlite.php';
		// if (isset($_GET["search"]) && isset($_GET['page'])){
		// 	$E->search2($_GET["search"], $_GET['page']);
		// }
		// else if(isset( $_GET["content"])) {
		// 	$E->content($_GET["content"]);
		// }
	}
}