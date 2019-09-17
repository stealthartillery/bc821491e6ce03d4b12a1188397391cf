<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

// {
//   1 "user_fullname": "Abdurrahman Rizal Firdaus",
//   2 "user_username": "rizal",
//   3 "user_email": "rabdurrahmanfirdaus@gmail.com",
//   4 "user_password": "adc8177baf65eb8d329eb6426d5ac345",
//   5 "user_image": "profile_1549796819.jpg",
//   6 "user_litegold": 0,
//   7 "user_litepoint": 0,
//   8 "user_isverified": 0,
//   9 "user_id": "2bfc62abfb6d26b3ae5299926eabd1c6",
//   10 "user_lang": "id",
//   11 "user_created_date": "2019-02-10 : 18:06:06"
//   12 "notif_en"
//   13 "notif_id"
//   14 "license"
// }

class Citizen {
	public function __construct() {
		set_time_limit ( 0 );
	}

	function get($citizen_id, $key='all') {
		if ($key == 'all') {
			$status = getFileNamesInsideDir(dir.'Citizens/'.$citizen_id.'/');
			$citizen = null;
			if ($status == null)
				$citizen = [];
			foreach ($status as $key => $value) {
				$pstat = LGen('JsonMan')->read_php(dir.'Citizens/'.$citizen_id.'/'.$value);
				$citizen[$value] = $pstat;
			}
			return $citizen;
		}
		else {
			$attr = $key;
			$key = md5($key).'.php';
			$pstat = LGen('JsonMan')->read_php(dir.'Citizens/'.$citizen_id.'/'.$key);
			if ($pstat === LGen('GlobVar')->failed) {
				$default = LGen('JsonMan')->read_php(dir.'Citizens/'.md5('default').'/'.$key);
				$this->set($citizen_id, $attr, $default);
				$pstat = LGen('JsonMan')->read_php(dir.'Citizens/'.$citizen_id.'/'.$key);
				// echo ' '.$default;
			}
			return $pstat;
		}
	}

	function set($citizen_id, $key, $value, $puzzled=true) {
		if ($value !== null) {
			if ($puzzled) {
				$key = md5($key);
				$key = $key.'.php';
			}
			LGen('JsonMan')->save_php(dir.'Citizens/'.$citizen_id.'/', $key, $value);
		}
	}

	function remove($user_id) {
		rename(dir . 'Citizens/' . $user_id, dir . 'RemovedCitizens/' . $user_id);
	}

	function remove_permanent($user_id) {
		dir_delete(dir . 'Citizens/' . $user_id);
	}

	function login($user) {
		$user_email = '';
		$user_password = '';
		$user_id = '';
		$filenames = getFileNamesInsideDir(dir.'Citizens/');
		foreach ($filenames as $key => $value) {
			$user_email = $this->get($value, 'user_email');
			if ($user['user_email'] === $user_email) {
				// return $user_email;
				$user_password = $this->get($value, 'user_password');
				$user_id = $value;
				break;
			}
			else {
				$user_email = '';
			}
		}

		if ($user_email === '')
			return LGen('GlobVar')->failed;
		else if ($user['user_password'] !== $user_password) 
			return LGen('GlobVar')->failed;
		return $user_id;
	}

	function list($key) {
		if ($key === 'secret') {
			$citizens = [];
			$filenames = getFileNamesInsideDir(dir.'Citizens/');
			foreach ($filenames as $key => $value) {
				$citizens[$value] = $this->get($value, 'user_fullname');
			}
			return json_encode($citizens);
		}
	}

	function new($user) {
		$date = new DateTime();
		$timestamp = $date->getTimestamp() . rand(1, 100);
		$user['user_id'] = md5($timestamp);

		$user_dir = dir . 'Citizens/' . $user['user_id'];
		if (!file_exists($user_dir)) { //// Check if directory is not exist.
	    mkdir($user_dir, 0777, true); //// Create directory.
		}
		else {
			return 'Account unavailable.';
		}

		$jsDate = $user['user_created_date'];
		$jsDateTS = strtotime($jsDate);
		if ($jsDateTS !== false) {
		 $user['user_created_date'] = date('Y-m-d : H:i:s', $jsDateTS );
		 $msg_date = date('Y-m-d', $jsDateTS );				
		}
		else {
		 $user['user_created_date'] = date('Y-m-d : H:i:s');
		 $msg_date = date('Y-m-d', $jsDateTS );
		}

		$notif_id['date'] = $msg_date;
		$notif_id['msg'] = "Akun Lanterlite anda telah dibuat. Mohon agar menyimpan informasi akun anda dengan aman.";
		$notif_id['link'] = "";
		$notif_id['has_checked'] = false;
		$notif_id['has_read'] = false;

		$arr_notif_id = [];
		array_push($arr_notif_id, $notif_id);

		$notif_en['date'] = $msg_date;
		$notif_en['msg'] = "Your Lanterlite account has been created. Please save your account information securely.";
		$notif_en['link'] = "";
		$notif_en['has_checked'] = false;
		$notif_en['has_read'] = false;

		$arr_notif_en = [];
		array_push($arr_notif_en, $notif_en);

		$default = $this->get(md5('default'));
		foreach ($user as $key => $value) {
			if (LGen('JsonMan')->is_key_exist($default, md5($key).'.php')) {
				$default[md5($key).'.php'] = $user[$key];
			}
		}
		foreach ($default as $key => $value) {
			$this->set($user['user_id'], $key, $value, $puzzled=false);
		}

		$this->set($user['user_id'], 'notif_id', $arr_notif_id);
		$this->set($user['user_id'], 'notif_en', $arr_notif_en);

		return 1;
	}

}
?>