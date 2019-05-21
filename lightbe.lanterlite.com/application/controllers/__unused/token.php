<?php defined('BASEPATH') OR exit('no direct script access allowed');

class token {

	function requestToken($username) {
		$resp_data = [];
		$data = $this->getToken($username);
		if ($data[RES_STAT] == SUCCESS) {
			$resp_data['data'] = $data['data'];
			$resp_data[RES_STAT] = SUCCESS;
		}
		else if ($data[RES_STAT] == FAILED) {
			$new_token = $this->generateToken($username);
			$this->setToken($new_token, $username);
			$resp_data['data'] = $new_token;
			$resp_data[RES_STAT] = SUCCESS;
		}
		return $resp_data;
	}

	function printJson($json_obj) {
		echo json_encode($json_obj, JSON_PRETTY_PRINT);
	}

	function getJson($file_path) {
		set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
		    if (0 === error_reporting()) { return false; }
		    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
		});

		try {
			$string = file_get_contents($file_path);
			$data['data'] = json_decode($string, true);
			$data[RES_STAT] = SUCCESS;
		} catch (Exception $e) {
			$data[RES_STAT] = FAILED;
		}
		return $data;
	}

	function setJson($file_path, $json_obj){
		try {
			$fp = fopen($file_path, 'w');
			fwrite($fp, json_encode($json_obj));
			fclose($fp);
			echo 'asd2';
			return true;			
		}
		catch (Exception $e) {
			return false;
		}
	}

	function getToken($username) {
		$data = $this->getJson(FCPATH . '/storage/tokens/' . md5($username));
		return $data;
	}

	function setToken($token, $username) {
		$file_path = FCPATH . '/storage/tokens/' . md5($username);
		$json_obj['access_token'] = $token;
		try {
			$this->setJson($file_path, $json_obj);
			return true;			
		}
		catch (Exception $e) {
			return false;
		}
	}

	function generateToken($username) {
		$date = new DateTime();
		$token_date = $date->getTimestamp();
		$token = md5($username . $token_date);
		return $token;
	}

	function isTokenValid($access_token, $username) {
		$data = $this->getJson(FCPATH . '/storage/tokens/' . md5($username));
		if ($data[RES_STAT] == SUCCESS && 
			$access_token == $data['data']['access_token']) {
			return true;
		}
		else {
			return false;
		}
	}
}
?>