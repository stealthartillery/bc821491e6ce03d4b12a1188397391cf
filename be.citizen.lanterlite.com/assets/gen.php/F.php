<?php

class F {

	function urlsafe_b64encode($string) {
	    $data = base64_encode($string);
	    $data = str_replace(array('+','/','='),array('-','_',''),$data);
	    return $data;
	}

	function urlsafe_b64decode($string) {
	    $data = str_replace(array('-','_'),array('+','/'),$string);
	    $mod4 = strlen($data) % 4;
	    if ($mod4) {
	        $data .= substr('====', $mod4);
	    }
	    return base64_decode($data);
	}

	function gen_id($obj=[]) {
		if (LGen('JsonMan')->is_key_exist($obj,'id')) 
			$id = $obj['id'];
		else
			$id = '';

		// $id = (new DateTime())->getTimestamp() . rand(100, 999);
		if ($id === '')
			$id = (microtime_float() . rand(1, 999999));
		$id = md5(md5(md5($id).'L').'G');
		$id = substr(md5($id), 0, 12);
		// echo $id . ' -1- ';
		// substr(md5($id, true), 0, 12);
		// echo $id . ' -2- ' . substr(md5($id), 0, 12) . ' -3- ';
		$id = strtoupper($id);
		// $id = remove_special_char($id);
		return $id;
	}

	function encrypt($obj) {
		return base64_encode(urlencode(json_encode($obj)));
	}

	function decrypt($str) {
		return LGen('StringMan')->to_json(urldecode(base64_decode($str)));
	}

	function force_file_put_contents ($filepath, $message){
    try {
      $isInFolder = preg_match("/^(.*)\/([^\/]+)$/", $filepath, $filepathMatches);
      if($isInFolder) {
        $folderName = $filepathMatches[1];
        $fileName = $filepathMatches[2];
        if (!is_dir($folderName)) {
          mkdir($folderName, 0777, true);
        }
      }
      file_put_contents($filepath, $message);
    } catch (Exception $e) {
      echo "ERR: error writing '$message' to '$filepath', ". $e->getMessage();
    }
	}

	function log($obj)
	{
		$filename = $obj['filename'];
		unset($obj['filename']);
		// $json['id'] = gen_id();
		$json = $obj;
		$log_msg = json_encode($json);
	  $log_dir = HOME_DIR.'storages/';
	  if (!file_exists($log_dir)) {
	      // create directory/folder uploads.
	      mkdir($log_dir.$filename, 0777, true);
	  }
	  $log_file_data = $log_dir.$filename;
	  // if you don't add `FILE_APPEND`, the file will be erased each time you add a log
	  file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND | LOCK_EX | LOCK_NB);
	}

	function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
	}

	// function get_client_ip_server() {
 //    $ipaddress = '';
 //    if ($_SERVER['HTTP_CLIENT_IP'])
 //        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
 //    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
 //        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
 //    else if($_SERVER['HTTP_X_FORWARDED'])
 //        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
 //    else if($_SERVER['HTTP_FORWARDED_FOR'])
 //        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
 //    else if($_SERVER['HTTP_FORWARDED'])
 //        $ipaddress = $_SERVER['HTTP_FORWARDED'];
 //    else if($_SERVER['REMOTE_ADDR'])
 //        $ipaddress = $_SERVER['REMOTE_ADDR'];
 //    else
 //        $ipaddress = 'UNKNOWN';
 
 //    return $ipaddress;
	// }
	
}