<?php defined('BASEPATH') OR exit('no direct script access allowed');

class Language extends CI_Controller {

	public function index() {
	  $headers = $this->getallheaders();
	  $data = $headers['Data'];
	  $data = json_decode($data, true);

		// $data = json_decode(file_get_contents('php://input'), true);
		// if ($data['sec_key'] == SEC_KEY) {
			// $data['data']['lang'] = 'en';
			$file_path = FCPATH . '/storage/languages/' . $data['data']['lang'];
			
			$resp_data = $this->getJson($file_path);

		
			header('Content-Type: application/json');
			// $httpStatusCode = 521;
			// $httpStatusMsg  = 'Web server is down';
			// $phpSapiName    = substr(php_sapi_name(), 0, 3);
			// if ($phpSapiName == 'cgi' || $phpSapiName == 'fpm') {
			//     header('Status: '.$httpStatusCode.' '.$httpStatusMsg);
			// } else {
			//     $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';
			//     header($protocol.' '.$httpStatusCode.' '.$httpStatusMsg);
			// }
			echo json_encode($resp_data);
		// }
		// else {
		// 	$this->output->set_status_header('404');
		// }
	}

	function getJson($file_path) {
		set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
		    if (0 === error_reporting()) { return false; }
		    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
		});

		try {
			$string = file_get_contents($file_path);
			$data['data'] = json_decode($string, true);
			$data[RESP_STATUS] = SUCCESS;
		} catch (Exception $e) {
			$data[RESP_STATUS] = FAILED;
			echo $e;
		}
		return $data;
	}

	function setJson($file_path, $json_obj){
		try {
			$fp = fopen($file_path, 'w');
			fwrite($fp, json_encode($json_obj));
			fclose($fp);
			return true;			
		}
		catch (Exception $e) {
			return false;
		}
	}

	function getallheaders() 
  { 
     $headers = []; 
     foreach ($_SERVER as $name => $value) 
     { 
        if (substr($name, 0, 5) == 'HTTP_') 
        { 
           $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; 
        } 
     } 
     return $headers; 
  }
}
?>