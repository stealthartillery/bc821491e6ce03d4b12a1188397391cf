<?php if (!defined('BASEPATH')) exit('Site protected by Lanterlite Defender.');

/* v 1.0.2 */


function get_app() {
	$res = json_decode(file_get_contents(HOME_DIR."app/app.lgen"), true);
	return $res;
}

class Gate extends CI_Controller{

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		include BASE_DIR . 'assets/gen_base_be/lantergen.php';
		include HOME_DIR . 'app/lanterapp.php';
		$data = json_decode(file_get_contents("php://input"), true);
		if (isset($_POST[DATA]))
			$data = $_POST;

		if (isset($data))
			$asd = LGen('White')->get($data[DATA]);
		else if (isset($_GET["f"]))
			$asd = LGen('White')->get($_GET["f"]);
		else 
			exit();
		if (array_key_exists('f', $asd))
			$asd['func'] = $asd['f'];
		if (array_key_exists('o', $asd))
			$asd['json'] = $asd['o'];
		$func = urldecode($asd['func']);
		$json = $asd['json'];
		header("HTTP/1.1 200 OK");
		header('Content-type: text/plain');
		eval('$result = '.$func.'($json);');
		echo LGen('Black')->get($result);
		exit();
	}
}