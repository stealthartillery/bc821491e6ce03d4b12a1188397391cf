<?php defined('BASEPATH') OR exit('no direct script access allowed');

class Language extends CI_Controller {

	public function index() {
		// include FCPATH . 'init.php';
		$v = stripslashes($_GET["data"]);
		// $v = json_decode(stripslashes($_GET["data"]));
		// encode the PHP variable to JSON and send it back on client-side
		// echo '<script>var asd = 2';
		// echo '</script>';
		// $this->gen->console_log('$v');
		// echo '$v';
		// $v = json_decode(stripslashes($_GET["data"]));
		// $this->get->console_log($v);
	  // $headers = $this->getallheaders();
	  $headers[DATA] = $v;
	  if (isset($headers[DATA])) {
	  	$this->lang_get($headers);
	  }
	  else {
			$this->output->set_status_header('404');
	  }
		// echo json_encode($v);  
	}

	function lang_get($headers) {
	  $data = $headers[DATA];
	  $data = json_decode($data, true);
		$file_path = BASE_DIR . 'assets/corelite/lang/' . $data[DATA]['lang'];
		// $file_path = FCPATH . '/storage/languages/' . $data[DATA]['lang'];
		$resp_data = $this->getJson($file_path);
		$resp_data['asd'] = $data[DATA]['lang'];
		header('Content-Type: application/json');
		echo json_encode($resp_data);
	}

	function getJson($file_path) {
		set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
		    if (0 === error_reporting()) { return false; }
		    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
		});

		try {
			$string = file_get_contents($file_path);
			$data[DATA] = json_decode($string, true);
			$data[RES_STAT] = SUCCESS;
		} catch (Exception $e) {
			$data[RES_STAT] = FAILED;
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

  function unused_func() {
  	function getLangFromBackend() {
		  $headers = $this->getallheaders();
		  if (isset($headers[DATA])) {
		  	$this->lang_get($headers);
		  }
		  else {
				$this->output->set_status_header('404');
		  }
  	}
  }
}
?>