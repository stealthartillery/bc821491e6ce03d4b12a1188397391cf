<?php
	class F {
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
?>