<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model{

	// protected $table = 'User';

    public function __construct()
    {
        parent::__construct();
        $this->L = new Lanterlite();
    }

	// public function insertOne($data) {
	// 	$fields = array(
	// 		'user_username' => $data['user_username'],
	// 		'user_email' => $data['user_email'],
	// 		'user_password' => $data['user_password'],
	// 		'user_fullname' => $data['user_fullname'],
	// 		'user_image' => $data['user_image'],
	// 		'user_litegold' => $data['user_litegold'],
	// 		'user_litepoint' => $data['user_litepoint'],
	// 		'user_isverified' => $data['user_isverified'],
	// 		'created_date' => date('Y-m=d H:i:s')
	// 	);

	// 	//// Insert data into table
	// 	// $this->db->insert($this->table, $fields);
	// 		$resp = [];
	// 		$user_new_data = [];
	// 		$keys = array_keys($data[DATA]);
	// 		foreach($keys as $key) {
	// 			if ($key != 'sec_key') {
	// 				if ($key == 'user_image') {
	// 					$date = new DateTime();
	// 					$image_name = $date->getTimestamp() . '.jpg';
	// 					$image_dir = FCPATH . '/uploads/' . md5($data[DATA]['user_username']);
	// 					$image_path = $image_dir . '/' .$image_name;
	// 					if (!file_exists($image_dir)) { //// Check if directory is not exist.
	// 					    mkdir($image_dir, 0777, true); //// Create directory.
	// 					}
	// 					file_put_contents($image_path, file_get_contents($data['user_image']["user_image"]));

	// 					$user_new_data['user_image'] = $image_name;
	// 					$resp[DATA]['user_image'] = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($image_path));
	// 				}
	// 				else if ($key != 'user_password') {
	// 					$user_new_data[$key] = $data[DATA][$key];
	// 					$resp[DATA][$key] = $data[DATA][$key];
	// 				}
	// 			}
	// 		}

	// }

	public function editOne($new_user_data) {
		$user_id = md5($new_user_data['user_email']);
		$user_dir = HOME_DIR . '/storages/backlite/users/' . $user_id . '/user.json';
		$json_string = file_get_contents($user_dir);
		$user_data = json_decode($json_string, true);

		$keys = array_keys($new_user_data);
		foreach ($keys as $key) {
		  $user_data[$key] = $new_user_data[$key];
		}

		$new_json_string = json_encode($user_data);
		file_put_contents($user_dir, $new_json_string);
	}

	public function insertOne($user) {
		$date = new DateTime();
		$timestamp = $date->getTimestamp() . '.user';
		$user['user_id'] = md5($timestamp);

		$user_dir = HOME_DIR . '/storages/backlite/users/' . $user['user_id'];
		if (!file_exists($user_dir)) { //// Check if directory is not exist.
		    mkdir($user_dir, 0777, true); //// Create directory.
		}

		$user_image = $user['user_image'];

		// if (isset($user_image)) {
			//// Save profile image.
			$date = new DateTime();
			$image_name = 'profile_' . $date->getTimestamp() . '.jpg';
			$image_dir = HOME_DIR . '/storages/backlite/users/' . $user['user_id'] . '/img';
			$image_path = $image_dir . '/' .$image_name;
			if (!file_exists($image_dir)) {
		    mkdir($image_dir, 0777, true);
			}
			file_put_contents($image_path, file_get_contents($user_image));

			$notif_dir = HOME_DIR . '/storages/backlite/users/' . $user['user_id'] . '/notif';
			if (!file_exists($notif_dir)) {
		    mkdir($notif_dir, 0777, true);
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

			$notif_en['date'] = $msg_date;
			$notif_en['msg'] = "Your Lanterlite account has been created. Please save your account information securely.";
			$notif_en['link'] = "";
			$notif_en['has_checked'] = false;
			$notif_en['has_read'] = false;

			$notif = [];
			array_push($notif, $notif_id);
			$this->L->json_save($notif_dir, '/notif_id.json', $notif);
			$notif = [];
			array_push($notif, $notif_en);
			$this->L->json_save($notif_dir, '/notif_en.json', $notif);
			// $new_image = '';
			// $this->convertImage($image_path, $new_image, 70);
		// }

		$user['user_image'] = $image_name;
		// $new_json_string = json_encode($user);
		$this->L->json_save($user_dir, '/user.json', $user);

		//// Save user id inside emails dir.
		// $user_dir = HOME_DIR . '/storages/backlite/emails/' . $user['user_email'];
		// $user_id = $user['user_id'];
		// file_put_contents($user_dir . '.file', $user_id);
		$user['user_image'] = HOME_URL . '/storages/backlite/users/' . $user['user_id'] . '/img/' . $image_name;
		return $user;
	}

	public function updateUser($user) {
		$user_dir = HOME_DIR . '/storages/backlite/users/' . $user['user_id'];
		if (!file_exists($user_dir)) { //// Check if directory is not exist.
	    mkdir($user_dir, 0777, true); //// Create directory.
		}
		if (isset($user['user_image'])) {
			$user_image = $user['user_image'];

			//// Save profile image.
			$date = new DateTime();
			$image_name = 'profile_' . $date->getTimestamp() . '.jpg';
			$image_dir = HOME_DIR . '/storages/backlite/users/' . $user['user_id'] . '/img';
			$image_path = $image_dir . '/' .$image_name;
			if (!file_exists($image_dir)) { //// Check if directory is not exist.
		    mkdir($image_dir, 0777, true); //// Create directory.
			}
			file_put_contents($image_path, file_get_contents($user_image));
			$user['user_image'] = $image_name;
		}

		$user_new = $this->getUserBy('user_id', $user['user_id']);
		foreach ($user as $key => $value) {
			$user_new[$key] = $user[$key];
		}

		$new_json_string = json_encode($user_new);
		file_put_contents($user_dir . '/user.json', $new_json_string);
		$resp[DATA] = $user_new;
		$resp[RES_STAT] = SUCCESS;
		return $resp;
	}

	function convertImage($originalImage, $outputImage, $quality)
	{
	    // jpg, png, gif or bmp?
	    $exploded = explode('.',$originalImage);
	    $ext = $exploded[count($exploded) - 1]; 

	    if (preg_match('/jpg|jpeg/i',$ext))
	        $imageTmp=imagecreatefromjpeg($originalImage);
	    else if (preg_match('/png/i',$ext))
	        $imageTmp=imagecreatefrompng($originalImage);
	    else if (preg_match('/gif/i',$ext))
	        $imageTmp=imagecreatefromgif($originalImage);
	    else if (preg_match('/bmp/i',$ext))
	        $imageTmp=imagecreatefrombmp($originalImage);
	    else
	        return 0;

	    // quality is a value from 0 (worst) to 100 (best)
	    imagejpeg($imageTmp, $outputImage, $quality);
	    imagedestroy($imageTmp);

	    return $outputImage;
	}

	public function getUserImage($user) {
		//// Get profile image.
		$image_dir = HOME_DIR . '/storages/backlite/users/' . $user['user_id'] . '/img';
		$image_path = $image_dir . '/' . $user['user_image'];
		$image = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($image_path));

		$image = HOME_URL . '/storages/backlite/users/' . $user['user_id'] . '/img/' . $user['user_image'];
		return $image;
	}

	public function notif_change($notif_index, $notif_param, $notif_val, $user_id,  $user_lang) {
		$user_dir = HOME_DIR . '/storages/backlite/users/' . $user_id . '/notif/notif_'.$user_lang.'.json';
		$json_string = file_get_contents($user_dir);
		$notif_data = json_decode($json_string, true);
		$notif_data[$notif_index][$notif_param] = $notif_val;

		$dir = HOME_DIR . '/storages/backlite/users/' . $user_id . '/notif/';
		$filename = 'notif_'.$user_lang.'.json';
		$this->L->json_save($dir, $filename, $notif_data);

		$resp[DATA] = $notif_data;
		$resp[RES_STAT] = SUCCESS;
		return $resp;		
	}

	public function notif_get($user_id,  $user_lang) {
		$user_dir = HOME_DIR . '/storages/backlite/users/' . $user_id . '/notif/notif_'.$user_lang.'.json';

		$json_string = file_get_contents($user_dir);
		$notif_data = json_decode($json_string, true);
		$resp[DATA] = $notif_data;

		$resp[RES_STAT] = SUCCESS;
		return $resp;		
	}

	public function getUserBy($user_attribute, $user_value) {
		$files = scandir(HOME_DIR . '/storages/backlite/users/');
		$resp[RES_STAT] = NOT_EXIST;
		foreach ($files as $index => $value) {
			if ($value != '.' && $value != '..') {
				$user_dir = HOME_DIR . '/storages/backlite/users/' . $value . '/user.json';

				$json_string = file_get_contents($user_dir);
				$user_data = json_decode($json_string, true);
				if ($user_data[$user_attribute] == $user_value) {
					$resp = $user_data;

					// //// Get profile image.
					// $image_dir = HOME_DIR . '/storages/backlite/users/' . $user_data['user_id'] . '/img';
					// $image_path = $image_dir . '/' . $user_data['user_image'];
					// $resp['user_image'] = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($image_path));

					$resp[RES_STAT] = SUCCESS;
					break;
				}
			}
		}
		return $resp;
	}

	public function getOne($user) {
		if (isset($user['user_id'])) {
			$user_dir = HOME_DIR . '/storages/backlite/users/' . $user['user_id'] . '/user.json';
		}

		//// Check if User is exist.
		if (file_exists ( $user_dir )) {
			$json_string = file_get_contents($user_dir);
			$user_data = json_decode($json_string, true);
			$resp = $user_data;
			$resp[RES_STAT] = SUCCESS;			
		}
		else {
			$resp[RES_STAT] = NOT_EXIST;						
		}
		return $resp;
	}

	// public function getOne($db_field, $req_field) {
	// 	$sql = "SELECT * FROM user WHERE " . $db_field . " = '" . $req_field . "';";
	// 	$resp = [];
	// 	$query = $this->db->query($sql);
	// 	if ($query->result_array()) {
	// 		foreach ($query->result_array() as $row) {
	// 			$resp['user_id'] = $row['user_id'];
	// 			$resp['user_fullname'] = $row['user_fullname'];
	// 			$resp['user_username'] = $row['user_username'];
	// 			$resp['user_email'] = $row['user_email'];
	// 			$resp['user_password'] = $row['user_password'];
	// 			$resp['user_image'] = $row['user_image'];
	// 			$resp['user_litegold'] = $row['user_litegold'];
	// 			$resp['user_litepoint'] = $row['user_litepoint'];
	// 			$resp['user_isverified'] = $row['user_isverified'];
	// 		}
	// 		$resp[RES_STAT] = SUCCESS;
	// 	}
	// 	else {
	// 		$resp[RES_STAT] = NOT_EXIST;
	// 	}
	// 	return $resp;
	// }

	// public function updateOne($data) {
	//   $this->db->where('user_id', $data['user_id']);
	//   $new_data = [];
	// 	$keys = array_keys($data);
	// 	foreach($keys as $key) {$new_data[$key] = $data[$key];}
	//     $this->db->update($this->table, $new_data);
 //    return true;
	// }
}