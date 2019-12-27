<?php 
	class AccessKey {
		function gen() {
			$salt = rand(1, 100);
			$date = new DateTime();
			$access_key = $date->getTimestamp() . $salt;
			$token = md5($access_key);
			$token = substr($token, 0, 4);
			return $token;
		}
	}