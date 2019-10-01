<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Enlite extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index($search=NULL, $page=NULL) {
		include BASE_DIR . 'search/Search.php';
		if (isset($_GET["search"]) && isset($_GET['page'])){
			$E->search2($_GET["search"], $_GET['page']);
		}
		else if(isset( $_GET["content"])) {
			$E->content($_GET["content"]);
		}
	}
}