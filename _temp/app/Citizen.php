<?php
	
	$citizen = new CitizenGen();

	class CitizenGen {
		public function __construct() {
			set_time_limit ( 0 );
		}

		public function logout($obj) {
			$this->unset_ship_id($obj);
		}

		public function get_def($obj) {
			$config_dir = HOME_DIR.'storages/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			$default = LGen('JsonMan')->read($config_dir.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"default"}')));
			return $default;
		}

		public function unset_ship_id($obj) {
			if (!LGen('JsonMan')->is_key_exist($obj['val'], 'ship_id'))
				return [];
			$ship_id = $obj['val']['ship_id'];
			// $ship_id = LGen('UserInfo')->get_ip();
			$_obj = [];
			$_obj['gate'] = 'savior';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "ships", "puzzled":true}'));
			// array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$ship_id.'", "puzzled":true}'));
			$_obj['name'] = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$ship_id.'"}'));
			// $_obj['def'] = 'citizens';
			// $_obj['namelist'] = ['theme_color', 'theme_font', 'email', 'lang', 'is_verified', 'id', 'fullname', 'username', 'gender', 'address', 'phonenum', 'silver', 'point'];

			$result = LGen('SaviorMan')->delete_pack($_obj);
			// error_log(json_encode($result));
			return $result;
		}

		public function set_ship_id($cit) {
			$cit_id = $cit['cit_id'];
			$ship_id = $cit['ship_id'];
			// $ship_id = LGen('UserInfo')->get_ip();
			$obj['bridge'] = array(
				0 => LGen('StringMan')->to_json('{"id":"ships","puzzled":true}')
				// 1 => LGen('StringMan')->to_json('{"id":"'.$ship_id.'","puzzled":true}')
			);
			$obj['gate'] = 'savior';
			$obj['def'] = 'ships';
			// error_log($ship_id);
			// error_log(LGen('F')->get_client_ip_server());
			// error_log(LGen('UserInfo')->get_ip());
			// error_log(LGen('UserInfo')->get_device());
			// error_log(LGen('UserInfo')->get_os());
			// error_log(LGen('UserInfo')->get_browser());
			// $obj['name'] = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$ship_id.'"}'));
			$obj['name'] = $ship_id;
			// error_log($obj['name'] . ' ' . 'name');
			$obj['val'] = LGen('ArrayMan')->to_json(array(
				'ship_id' => $ship_id, 
				'cit_id' => $cit_id
			));
			LGen('SaviorMan')->insert($obj);
			// return $ship_id;
		}

		public function get_ship_id($obj) {
			LGen('SaviorMan')->req_validator($obj);
			// $obj['bridge'] = [];
			if (!LGen('JsonMan')->is_key_exist($obj['val'], 'ship_id'))
				return [];

			$obj['bridge'] = array(
				0 => LGen('StringMan')->to_json('{"id":"ships","puzzled":true}'),
				1 => LGen('StringMan')->to_json('{"id":"'.$obj['val']['ship_id'].'","puzzled":true}')
				// 1 => LGen('StringMan')->to_json('{"id":"'.LGen('UserInfo')->get_ip().'","puzzled":true}')
			);
			$obj['namelist'] = ['client_ip', 'cit_id'];
			$obj['def'] = 'ships';
			// $obj['name'] = LGen('UserInfo')->get_ip();
			$result = LGen('SaviorMan')->read($obj);
			// error_log(json_encode($result));
			$_result = [];
			if (sizeof($result)>0) {
				$result['cit_id'] = ($result['cit_id']);
				// error_log(json_encode($result));
				$_obj = [];
				$_obj['gate'] = 'savior';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$result['cit_id'].'", "puzzled":false}'));
				$_obj['def'] = 'citizens';
				$_obj['namelist'] = ['img','is_banned', 'created_date', 'verification_code', 'fsize', 'theme_color', 'theme_font', 'email', 'lang', 'is_verified', 'id', 'fullname', 'username', 'gender', 'address', 'phonenum', 'silver', 'point'];

				$citizen = LGen('SaviorMan')->read($_obj);
				if ($citizen['is_banned'])
					return 'account is banned';
				$_result['id'] = $citizen['id'];
				$_result['img'] = $citizen['img'];
				$_result['is_verified'] = $citizen['is_verified'];
				$_result['lang'] = $citizen['lang'];
				$_result['fullname'] = $citizen['fullname'];
				$_result['email'] = $citizen['email'];
				$_result['username'] = $citizen['username'];
				$_result['gender'] = $citizen['gender'];
				$_result['address'] = $citizen['address'];
				$_result['phonenum'] = $citizen['phonenum'];
				$_result['silver'] = $citizen['silver'];
				$_result['point'] = $citizen['point'];
				$_result['theme_font'] = $citizen['theme_font'];
				$_result['theme_color'] = $citizen['theme_color'];
				$_result['fsize'] = $citizen['fsize'];
				$_result['created_date'] = $citizen['created_date'];
				$_result['verification_code'] = $citizen['verification_code'];

				$_obj['namelist'] = ['id', 'type', 'created_date'];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "licenses", "puzzled":true}'));
				$licenses = LGen('SaviorMan')->get_all($_obj);
				$_result['licenses'] = $licenses;
			}
			// error_log('$result ' . json_encode($result));
			// if ($result === LGen('GlobVar')->not_found) {
			// 	$obj['bridge'] = array(
			// 		0 => LGen('StringMan')->to_json('{"id":"ships","puzzled":true}'),
			// 		1 => LGen('StringMan')->to_json('{"id":'.LGen('UserInfo')->get_ip().',"puzzled":true}')
			// 	);
			// 	$obj['name'] = LGen('F')->gen_id(LGen('UserInfo')->get_ip());
			// 	$obj['val'] = LGen('ArrayMan')->to_json(array(
			// 		'cit_id' => '', 
			// 	))
			// 	$this->insert($obj)
			// }
			// error_log(($result));
			return $_result;
		}

		public function login($obj) {
			// error_log('json_encode($citizens)');
			LGen('SaviorMan')->req_validator($obj);
			array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			$_bridge = LGen('SaviorMan')->gen_bridge($obj['bridge']);
			$dir = HOME_DIR.'storages/'.$obj['gate'].'/'.$_bridge;
			// error_log($dir);

			$bridge = $obj['bridge'];
			$obj['namelist'] = ['id','email', 'password'];
			$obj['def'] = 'citizens';
			$email = $obj['val']['email'];
			$password = $obj['val']['password'];
			$keep_signin = $obj['val']['keep_signin'];
			// $obj['val'] = json_encode($obj['val']);
			// $obj['val'] = base64_encode($obj['val']);
			// $val = $obj['val']; // keep value encrypted for savior->read purpose.

			// check citizens
			$citizens = getFileNamesInsideDir($dir);
			if ($citizens === LGen('GlobVar')->not_found)
				return LGen('GlobVar')->not_found;
			// error_log(json_encode($citizens));
			foreach ($citizens as $key => $value) {
				$obj['bridge'] = $bridge;
				array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$value.'", "puzzled":false}'));
				// $obj['val'] = $val; // keep value encrypted for savior->read purpose.
				$citizen = LGen('SaviorMan')->read($obj);
				if (!LGen('JsonMan')->is_key_exist($citizen, 'email'))
					continue;
				// 	return $citizen;
				// error_log(json_encode($citizen) .' '. $email);
				$citizen['id'] = ($citizen['id']);
				$citizen['email'] = ($citizen['email']);
				$citizen['password'] = ($citizen['password']);
				// error_log(json_encode($citizen));
				// error_log($citizen['email'] .' '. $email);
				if ($citizen['email'] === $email and $citizen['password'] === $password) {
					// return $citizen;
					// $ship_id = '';
					if ($keep_signin && LGen('JsonMan')->is_key_exist($obj['val'], 'ship_id')) {
						$ship = [];
						$ship['cit_id'] = $citizen['id'];
						$ship['ship_id'] = $obj['val']['ship_id'];
						$this->set_ship_id($ship);
					}
					$obj['namelist'] = ['img','is_banned', 'verification_code', 'created_date', 'fsize', 'theme_color', 'theme_font', 'email', 'lang', 'is_verified', 'id', 'fullname', 'username', 'gender', 'address', 'phonenum', 'silver', 'point'];
					$citizen = LGen('SaviorMan')->read($obj);
					if ($citizen['is_banned'])
						return 'account is banned';
					// $result['ship_id'] = $ship_id;
					$result['id'] = $citizen['id'];
					$result['img'] = $citizen['img'];
					$result['is_verified'] = $citizen['is_verified'];
					$result['lang'] = $citizen['lang'];
					$result['fullname'] = $citizen['fullname'];
					$result['email'] = $citizen['email'];
					$result['username'] = $citizen['username'];
					$result['gender'] = $citizen['gender'];
					$result['address'] = $citizen['address'];
					$result['phonenum'] = $citizen['phonenum'];
					$result['silver'] = $citizen['silver'];
					$result['point'] = $citizen['point'];
					$result['theme_font'] = $citizen['theme_font'];
					$result['theme_color'] = $citizen['theme_color'];
					$result['fsize'] = $citizen['fsize'];
					$result['verification_code'] = $citizen['verification_code'];
					$result['created_date'] = $citizen['created_date'];
				
					$obj['namelist'] = ['id', 'type', 'created_date'];
					array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "licenses", "puzzled":true}'));
					$licenses = LGen('SaviorMan')->get_all($obj);
					$result['licenses'] = $licenses;
					return $result;
				}
				else if ($citizen['email'] === $email and $citizen['password'] !== $password)
					return 'wrong email or password';
			}
			return 'account is unregistered';
		}

		public function read($obj) {
			// error_log('json_encode($citizens)');
			LGen('SaviorMan')->req_validator($obj);

			$obj['def'] = 'citizens';
			array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['val']['id'].'", "puzzled":false}'));
			$_bridge = LGen('SaviorMan')->gen_bridge($obj['bridge']);
			$dir = HOME_DIR.'storages/'.$obj['gate'].'/'.$_bridge;

			$obj['namelist'] = ['img','is_banned','verification_code', 'created_date', 'fsize', 'theme_color', 'theme_font', 'email', 'lang', 'is_verified', 'id', 'fullname', 'username', 'gender', 'address', 'phonenum', 'silver', 'point'];
			$citizen = LGen('SaviorMan')->read($obj);
			if ($citizen['is_banned'])
				return 'account is banned';

			$result['id'] = $citizen['id'];
			$result['img'] = $citizen['img'];
			$result['is_verified'] = $citizen['is_verified'];
			$result['lang'] = $citizen['lang'];
			$result['fullname'] = $citizen['fullname'];
			$result['email'] = $citizen['email'];
			$result['username'] = $citizen['username'];
			$result['gender'] = $citizen['gender'];
			$result['address'] = $citizen['address'];
			$result['phonenum'] = $citizen['phonenum'];
			$result['silver'] = $citizen['silver'];
			$result['point'] = $citizen['point'];
			$result['theme_font'] = $citizen['theme_font'];
			$result['theme_color'] = $citizen['theme_color'];
			$result['fsize'] = $citizen['fsize'];
			$result['verification_code'] = $citizen['verification_code'];
			$result['created_date'] = $citizen['created_date'];
		
			$obj['namelist'] = ['id', 'type', 'created_date'];
			$obj['def'] = 'citizens/licenses';
			array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "licenses", "puzzled":true}'));
			$licenses = LGen('SaviorMan')->get_all($obj);
			$result['licenses'] = $licenses;
			return $result;

			// // error_log($dir);

			// $bridge = $obj['bridge'];
			// $obj['namelist'] = ['id','email', 'password'];
			// $obj['def'] = 'citizens';
			// $email = $obj['val']['email'];
			// $password = $obj['val']['password'];
			// $keep_signin = $obj['val']['keep_signin'];
			// // $obj['val'] = json_encode($obj['val']);
			// // $obj['val'] = base64_encode($obj['val']);
			// // $val = $obj['val']; // keep value encrypted for savior->read purpose.

			// // check citizens
			// $citizens = getFileNamesInsideDir($dir);
			// if ($citizens === LGen('GlobVar')->not_found)
			// 	return LGen('GlobVar')->not_found;
			// // error_log(json_encode($citizens));
			// foreach ($citizens as $key => $value) {
			// 	$obj['bridge'] = $bridge;
			// 	array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$value.'", "puzzled":false}'));
			// 	// $obj['val'] = $val; // keep value encrypted for savior->read purpose.
			// 	$citizen = LGen('SaviorMan')->read($obj);
			// 	$citizen['id'] = ($citizen['id']);
			// 	$citizen['email'] = ($citizen['email']);
			// 	$citizen['password'] = ($citizen['password']);
			// 	// error_log(json_encode($citizen));
			// 	error_log($citizen['email'] .' '. $email);
			// 	if ($citizen['email'] === $email and $citizen['password'] === $password) {
			// 		// $ship_id = '';
			// 		if ($keep_signin && LGen('JsonMan')->is_key_exist($obj['val'], 'ship_id')) {
			// 			$ship = [];
			// 			$ship['cit_id'] = $citizen['id'];
			// 			$ship['ship_id'] = $obj['val']['ship_id'];
			// 			$this->set_ship_id($ship);
			// 		}
			// 		$obj['namelist'] = ['verification_code', 'created_date', 'fsize', 'theme_color', 'theme_font', 'email', 'lang', 'is_verified', 'id', 'fullname', 'username', 'gender', 'address', 'phonenum', 'silver', 'point'];
			// 		$citizen = LGen('SaviorMan')->read($obj);
			// 		// $result['ship_id'] = $ship_id;
			// 		$result['id'] = $citizen['id'];
			// 		$result['is_verified'] = $citizen['is_verified'];
			// 		$result['lang'] = $citizen['lang'];
			// 		$result['fullname'] = $citizen['fullname'];
			// 		$result['email'] = $citizen['email'];
			// 		$result['username'] = $citizen['username'];
			// 		$result['gender'] = $citizen['gender'];
			// 		$result['address'] = $citizen['address'];
			// 		$result['phonenum'] = $citizen['phonenum'];
			// 		$result['silver'] = $citizen['silver'];
			// 		$result['point'] = $citizen['point'];
			// 		$result['theme_font'] = $citizen['theme_font'];
			// 		$result['theme_color'] = $citizen['theme_color'];
			// 		$result['fsize'] = $citizen['fsize'];
			// 		$result['verification_code'] = $citizen['verification_code'];
			// 		$result['created_date'] = $citizen['created_date'];
				
			// 		$obj['namelist'] = ['id', 'type', 'created_date'];
			// 		array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "licenses", "puzzled":true}'));
			// 		$licenses = LGen('SaviorMan')->get_all($obj);
			// 		$result['licenses'] = $licenses;
			// 		return $result;
			// 	}
			// 	else if ($citizen['email'] === $email and $citizen['password'] !== $password)
			// 		return 'wrong email or password';
			// }
			// return 'account is unregistered';
		}

		public function signup($obj) {
			LGen('SaviorMan')->req_validator($obj);

			$val = $obj['val'];
			// $obj['val'] = (($obj['val']));

			$_obj = $obj;
			$_obj['namelist'] = ['username', 'email'];
			$_obj['bridge'] = [];
			$_obj['val'] = '';
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id":"citizens", "puzzled":true}'));
			$citizens = LGen('SaviorMan')->get_all($_obj);
			// error_log($val);
			foreach ($citizens as $key => $value) {
				// error_log($value['username'] . ' ' . $val['username']);
				if (($value['username']) === $val['username'])
					return 'username is exist';
				else if (($value['email']) === $val['email'])
					return 'email is exist';
			}
			$ver_code = strtoupper(LGen('StringMan')->gen_rand(7));
			$obj['val']['verification_code'] = $ver_code;
			$id = LGen('SaviorMan')->insert($obj);
			$_obj = [];
			$_obj['verification_code'] = $obj['val']['verification_code'];
			$_obj['fullname'] = $obj['val']['fullname'];
			$_obj['id'] = $id;
			$_obj['email'] = $obj['val']['email'];
			// error_log(json_encode($_obj));
			$this->send_ver_email($_obj);

			$obj['bridge'] = [];
			$result = $this->login($obj);
			return $result;
		}

		public function resend_ver_email($obj) {
			$_obj = LGen('StringMan')->to_json('{}');
			$_obj['namelist'] = ['email', 'verification_code', 'is_verified'];
			$_obj['gate'] = 'savior';
			$_obj['def'] = 'citizens';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id":"citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id":"'.$obj['id'].'", "puzzled":false}'));
			$citizen = LGen('SaviorMan')->read($_obj);
			$res = LGen('StringMan')->to_json('{}');
			$res['is_verified'] = ($citizen['is_verified']);
			$res['verification_code'] = ($citizen['verification_code']);
			$res['email'] = ($citizen['email']);

			if ($res['verification_code'] === '') {
				$res['verification_code'] = strtoupper(LGen('StringMan')->gen_rand(7));
				$_save = $_obj;
				// $_save['single'] = true;
				$_save['val'] = [];
				$_save['namelist'] = '';
				$_save['val']['verification_code'] = $res['verification_code'];
				// error_log('json_decode($_save)');
				// error_log(json_encode($_obj));
				LGen('SaviorMan')->update($_save);
			}
			// error_log(json_encode($res));
			if (!$res['is_verified'])
				$this->send_ver_email($res);
			return true;
		}

		public function update_profile($obj) {
			LGen('SaviorMan')->req_validator($obj);
			error_log('message');
			$val = $obj['val'];
			$obj['val'] = (($obj['val']));

			if (LGen('JsonMan')->is_key_exist($obj['val'], 'username') || LGen('JsonMan')->is_key_exist($obj['val'], 'email')) {
				$_obj = $obj;
				$_obj['namelist'] = ['id', 'username', 'email', 'password'];
				$_obj['bridge'] = [];
				$_obj['val'] = '';
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id":"citizens", "puzzled":true}'));
				$citizens = LGen('SaviorMan')->get_all($_obj);
				foreach ($citizens as $key => $value) {
					error_log(json_encode($value));
					if (!(($value['id']) === $val['id'])) {
						if (LGen('JsonMan')->is_key_exist($obj['val'], 'username')) {
							if (($value['username']) === $val['username'])
								return 'username is exist';
						}
						if (LGen('JsonMan')->is_key_exist($obj['val'], 'email')) {
							if (($value['email']) === $val['email'])
								return 'email is exist';
						}
					}
				}
			}
			$asd = ((LGen('JsonMan')->is_key_exist($obj['val'], 'img') && LGen('StringMan')->is_val_exist($obj['val']['img'], 'base64'))?'asda':'qwea');
			if (LGen('JsonMan')->is_key_exist($obj['val'], 'img') && LGen('StringMan')->is_val_exist($obj['val']['img'], 'base64')) {
				/* upload image */
				$_obj = [];
				$_obj['gate'] = 'citizens/'.$obj['val']['id'];
				$_obj['img'] = $obj['val']['img'];
	
				$final_obj = [];
				$final_obj['json'] = $_obj;
				$final_obj['func'] = '$image->add_image';
				$obj['val']['img'] = LGen('ReqMan')->send_post($final_obj, 'image.lanterlite.com');
			}
			else
				unset($obj['val']['img']);
			LGen('SaviorMan')->update($obj);
			// $result = $this->login($obj);
			return $obj['val'];
		}


		public function verify_code($obj) {
			$obj['bridge'] = [];
			array_push($obj['bridge'], LGen('StringMan')->to_json('{"id":"citizens", "puzzled": true}'));
			array_push($obj['bridge'], LGen('StringMan')->to_json('{"id":"'.$obj['id'].'", "puzzled": false}'));
			$obj['def'] = 'citizens';
			$obj['namelist'] = ['verification_code','is_verified'];
			$obj['gate'] = 'savior';

			$val = LGen('SaviorMan')->read($obj);
			// error_log(($val['verification_code']) . ' ' . $obj['verification_code']);
			if (($val['verification_code']) === $obj['verification_code']) {
				$_obj = $obj;
				$_obj['val'] = LGen('StringMan')->to_json('{"is_verified":1}');
				LGen('SaviorMan')->update($_obj);
				return true;
			}
			else {
				return false;
			}
		}

		// public function send_verification_email() {
		//   $headers = $this->getallheaders();
		//   if (isset($headers[DATA])) {
		// 	  $header_data = $headers[DATA];
		// 	  $header_data = json_decode($header_data, true);
		//  	  if ($header_data['LSSK'] == SEC_KEY) {

		// 			$data = json_decode(file_get_contents('php://input'), true); //// Get data from frontend.
		// 			include 'token.php'; $Token = new token();

		// 			$resp = [];
		// 			// if ($Token->isTokenValid($data['access_token'], $data[DATA]['user_username'])) {
		// 				$query_res = $this->UserModel->user_get_by('user_username', $data[DATA]['user_username']);
		// 				if ($this->sendVerEmail($query_res['user_email'], $query_res['user_fullname'], $query_res['user_id'])) {
		// 					$resp[RES_STAT] = SUCCESS;
		// 				}
		// 				else {
		// 					$resp[RES_STAT] = FAILED;
		// 				}
		// 			// }
		// 			// else { //// Email is not exist.
		// 			// 	$resp[RES_STAT] = NOT_EXIST;
		// 			// }
		// 		}
		// 		else { //// Email is not exist.
		// 			$resp[RES_STAT] = FAILED;
		// 		}
		// 	}
		// 	else { //// Email is not exist.
		// 		$resp[RES_STAT] = FAILED;
		// 	}

		// 	header('Content-Type: application/json');
		// 	echo json_encode($resp);
		// }

		public function send_ver_email($obj) {
			// $user_email = 'sweetcheesepie@gmail.com';
			$user_email = $obj['email'];
			// $user_id = $obj['id'];
			// $user_fullname = $obj['fullname'];
			$vercode = $obj['verification_code'];
			$subject = "Lanterlite Verification Code";

			$html = '<div> <div style="padding: 10px;"> <div style="max-width: 500px; background-color: white; color: #1a1a1a; margin: auto; padding: 10px; border: 1px solid silver; border-radius: 5px; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; box-shadow: 0px 0px 4px gold;"><img style="margin: 10px; width: 150px;" onclick="window.open(\'https://www.lanterlite.com\');" src="http://update.lanterlite.com/assets/gen.img/lanterlite-gold.png" /> <div style="margin: 10px;">This email was recently entered to verify your email address.</div> <div style="margin: 10px;">You can use this code to verify that this email belongs to you.</div> <div style="margin: 20px; text-align: center;"> <div style="font-size: 25px; font-weight: bold;">'.$vercode.'</div> </div> <div style="margin: 10px;">If this was not you, someone may have mistype their email address. Keep this code to yourself, and no other action is needed at this moment.</div> <div style="margin: 10px;">The Lanterlite Team</div> </div> <div style="color: dimgrey; text-align: center; font-size: 12px; margin: 20px 0px;"> <div>&copy; 2019 Lanterlite</div> <div>Sadang Serang St. Palem II #4, Bandung, Indonesia, 40134</div> <div><a href="https://www.lanterlite.com" target="_blank" style="text-decoration: none; color: grey; cursor: pointer;">www.lanterlite.com</a></div> </div> </div> </div>';

		 //  $headers .= "Organization: Lanterlite\r\n";
		 //  $headers .= "MIME-Version: 1.0\r\n";
		 //  $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		 //  $headers .= "X-Priority: 3\r\n";
		 //  $headers .= "X-Mailer: PHP". phpversion() ."\r\n"

			// mail($user_email,$subject,$html,$headers);
			// return true;


			// use PHPMailer\PHPMailer\PHPMailer;
			// use PHPMailer\PHPMailer\Exception;

			// require 'PHPMailer/src/Exception.php';
			// require 'PHPMailer/src/PHPMailer.php';
			// require 'PHPMailer/src/SMTP.php';
			
			// $mail = new PHPMailer\PHPMailer\PHPMailer();

			require_once('PHPMailer/PHPMailerAutoload.php');
			$mail = new PHPMailer(true);

			try {
				// $mail->SMTPDebug = 2;
				$mail->isSMTP();
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->Host = 'mail.lanterlite.com';
				$mail->Port = '465';
				// $mail->Port = '465';
				$mail->Username = 'admin@lanterlite.com';
				$mail->Password = 'lite12345';

				$mail->SetFrom('admin@lanterlite.com', 'Lanterlite');
				$mail->AddAddress($user_email);
				// $mail->AddReplyTo('admin@lanterlite.com', 'Lanterlite');

				$mail->isHTML(true);
				$mail->Subject = $subject;
				// $mail->Body = 'This email was recently entered to verify your email address.';
				$mail->Body = $html;
		    $mail->AltBody = 'This email was recently entered to verify your email address. Verification Code: '.$vercode.'. You can use this code to verify that this email belongs to you. If this was not you, someone may have mistype their email address. Keep this code to yourself, and no other action is needed at this moment.';

				// $mail->addCustomHeader('Organization: Lanterlite');
				// $mail->addCustomHeader('MIME-Version: 1.0');
				// $mail->addCustomHeader('Content-type: text/html; charset=iso-8859-1');
				// $mail->addCustomHeader('X-Priority: 3');
				// // $mail->addCustomHeader('From: admin@lanterlite.com');
				// $mail->addCustomHeader('X-Mailer: PHP'. phpversion());
				// // $mail->AddAddress('ifandhanip@gmail.com');

				$mail->send();
				return true;
			} catch (Exception $e) {
			  echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
				return false;
			}
		}
	}
?>