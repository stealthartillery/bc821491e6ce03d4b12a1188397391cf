<?php
	ini_set("log_errors", 1);
	ini_set("error_log", BASE_DIR.'storages/savior/'. 'savior.log');

	class CitizenGen {
		public function __construct() {
			set_time_limit ( 0 );
		}

		public function set_ship_id($cit_id) {
			$ship_id = LGen('F')->get_client_ip();
			$obj['bridge'] = array(
				0 => LGen('StringMan')->to_json('{"id":"ships","puzzled":true}'),
				1 => LGen('StringMan')->to_json('{"id":'.$ship_id.',"puzzled":true}')
			);
			$obj['gate'] = 'savior';
			$obj['def'] = 'ship';
			$obj['name'] = LGen('F')->gen_id($ship_id);
			$obj['val'] = LGen('ArrayMan')->to_json(array(
				'ship_id' => $ship_id, 
				'cit_id' => $cit_id
			));
			LGen('SaviorMan')->insert($obj);
		}

		public function get_ship_id($obj) {
			LGen('SaviorMan')->req_validator($obj);
			// $obj['bridge'] = [];
			$obj['bridge'] = array(
				0 => LGen('StringMan')->to_json('{"id":"ships","puzzled":true}'),
				1 => LGen('StringMan')->to_json('{"id":'.LGen('F')->get_client_ip().',"puzzled":true}')
			);
			$obj['namelist'] = ['client_ip', 'cit_id'];
			$obj['def'] = 'ships';
			// $obj['name'] = LGen('F')->get_client_ip();
			$result = LGen('SaviorMan')->read($obj);
			// if ($result === LGen('GlobVar')->not_found) {
			// 	$obj['bridge'] = array(
			// 		0 => LGen('StringMan')->to_json('{"id":"ships","puzzled":true}'),
			// 		1 => LGen('StringMan')->to_json('{"id":'.LGen('F')->get_client_ip().',"puzzled":true}')
			// 	);
			// 	$obj['name'] = LGen('F')->gen_id(LGen('F')->get_client_ip());
			// 	$obj['val'] = LGen('ArrayMan')->to_json(array(
			// 		'cit_id' => '', 
			// 	))
			// 	$this->insert($obj)
			// }
			// error_log(($result));
			return $result;
		}

		public function login($obj) {
			// error_log('json_encode($citizens)');
			LGen('SaviorMan')->req_validator($obj);

			array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			$_bridge = LGen('SaviorMan')->gen_bridge($obj['bridge']);
			$dir = BASE_DIR.'storages/'.$obj['gate'].'/'.$_bridge;

			$bridge = $obj['bridge'];
			$obj['namelist'] = ['email', 'password'];
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
				$citizen['email'] = base64_decode($citizen['email']);
				$citizen['password'] = base64_decode($citizen['password']);
				// error_log($citizen['email'] .' '. $email);
				if ($citizen['email'] === $email and $citizen['password'] === $password) {
					if ($keep_signin)
						LGen('SaviorMan')->set_ship_id($citizen['id']);
					$obj['namelist'] = ['theme_color', 'theme_font', 'email', 'lang', 'is_verified', 'id', 'fullname', 'username', 'gender', 'address', 'phonenum', 'silver', 'point'];
					$citizen = LGen('SaviorMan')->read($obj);
					$result['id'] = $citizen['id'];
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
				if (base64_decode($value['username']) === $val['username'])
					return 'username is exist';
				else if (base64_decode($value['email']) === $val['email'])
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
			error_log(json_encode($_obj));
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
			$res['is_verified'] = base64_decode($citizen['is_verified']);
			$res['verification_code'] = base64_decode($citizen['verification_code']);
			$res['email'] = base64_decode($citizen['email']);

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
			error_log(json_encode($res));
			if (!$res['is_verified'])
				$this->send_ver_email($res);
			return true;
		}

		public function update_profile($obj) {
			LGen('SaviorMan')->req_validator($obj);

			$val = $obj['val'];
			$obj['val'] = (($obj['val']));

			$_obj = $obj;
			$_obj['namelist'] = ['id', 'username', 'email', 'password'];
			$_obj['bridge'] = [];
			$_obj['val'] = '';
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id":"citizens", "puzzled":true}'));
			$citizens = LGen('SaviorMan')->get_all($_obj);
			foreach ($citizens as $key => $value) {
				if (!(base64_decode($value['id']) === $val['id'])) {
					if (base64_decode($value['username']) === $val['username'])
						return 'username is exist';
					else if (base64_decode($value['email']) === $val['email'])
						return 'email is exist';
				}
			}

			LGen('SaviorMan')->update($obj);
			// $result = $this->login($obj);
			return true;
		}


		public function verify_code($obj) {
			$obj['bridge'] = [];
			array_push($obj['bridge'], LGen('StringMan')->to_json('{"id":"citizens", "puzzled": true}'));
			array_push($obj['bridge'], LGen('StringMan')->to_json('{"id":"'.$obj['id'].'", "puzzled": false}'));
			$obj['def'] = 'citizens';
			$obj['namelist'] = ['verification_code','is_verified'];
			$obj['gate'] = 'savior';

			$val = LGen('SaviorMan')->read($obj);
			// error_log(base64_decode($val['verification_code']) . ' ' . $obj['verification_code']);
			if (base64_decode($val['verification_code']) === $obj['verification_code']) {
				$_obj = $obj;
				$_obj['val'] = LGen('StringMan')->to_json('{"is_verified":true}');
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

			// require_once('PHPMailer/PHPMailerAutoload.php');

			// use PHPMailer\PHPMailer\PHPMailer;
			// use PHPMailer\PHPMailer\Exception;

			require 'PHPMailer/src/Exception.php';
			require 'PHPMailer/src/PHPMailer.php';
			require 'PHPMailer/src/SMTP.php';
			
			$mail = new PHPMailer\PHPMailer\PHPMailer();
			// $mail = new PHPMailer(true);

			try {
				$mail->SMTPDebug = 2;
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
				$mail->AddReplyTo('admin@lanterlite.com', 'Lanterlite');

				$mail->isHTML(true);
				$mail->Subject = $subject;
				$mail->Body = $html;
		    $mail->AltBody = 'This email was recently entered to verify your email address. Verification Code: '.$vercode.'. You can use this code to verify that this email belongs to you. If this was not you, someone may have mistype their email address. Keep this code to yourself, and no other action is needed at this moment.';

				$mail->addCustomHeader('Organization: Lanterlite');
				$mail->addCustomHeader('MIME-Version: 1.0');
				$mail->addCustomHeader('Content-type: text/html; charset=iso-8859-1');
				$mail->addCustomHeader('X-Priority: 3');
				// $mail->addCustomHeader('From: admin@lanterlite.com');
				$mail->addCustomHeader('X-Mailer: PHP'. phpversion());
				// $mail->AddAddress('ifandhanip@gmail.com');

				$mail->send();
				return true;
			} catch (Exception $e) {
			  echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
				return false;
			}
		}
	}
?>