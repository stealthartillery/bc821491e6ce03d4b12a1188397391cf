<?php if (!defined('BASEPATH')) exit('no direct script access allowed');
// header("Access-Control-Allow-Methods: GET");
// header('Access-Control-Allow-Origin: http://localhost/lanterlite.com/register');



class User extends CI_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model(array('UserModel'));
	}

	public function index() {

	}
	
	public function requestAccess() {
		$data = json_decode(file_get_contents('php://input'), true);
		include 'token.php'; $Token = new token();

		$username = $data['user_username'];
		$resp = [];

		$data = $Token->getToken($username);
		if ($data[RESP_STATUS] == SUCCESS) {
			$resp['access_token'] = $data['data'];
			$resp[RESP_STATUS] = SUCCESS;
		} else {
			$resp[RESP_STATUS] = FAILED;
		}

		header('Content-Type: application/json');
		echo json_encode($resp);
	}


	public function getOne() {
	  $headers = $this->getallheaders();
	  $data = $headers['Data'];
	  $data = json_decode($data, true);

		// $data = json_decode(file_get_contents('php://input'), true);
		include 'token.php'; $Token = new token();

		// $data['data']['user_username'] = 'asd';
		// $data['access_token'] = '54462e94a372ce99fe2c387583f9be68';

		// if ($Token->isTokenValid($data['access_token'], $data['data']['user_username'])) {
			$resp = []; //// Response data.
			$query_res = $this->UserModel->getUserBy('user_username', $data['data']['user_username']);
			if ($query_res[RESP_STATUS] == SUCCESS) //// Username is exist.
			{ 
				$keys = array_keys($query_res);
				foreach($keys as $key) {
					if ($key != 'user_password') {
						if ($key == 'user_image')
							$resp['data'][$key] = $this->UserModel->getUserImage($query_res);
						else
							$resp['data'][$key] = $query_res[$key];
					}
				}
				// $resp['access_token'] = $data['access_token'];
				$resp[RESP_STATUS] = SUCCESS;
			}

			else if ($query_res[RESP_STATUS] == NOT_EXIST) { //// Username is not exist.
				$resp[RESP_STATUS] = NOT_EXIST;
			}

			header('Content-Type: application/json');
			echo json_encode($resp);
		// }
		// else {
		// 	$this->output->set_status_header('404');
		// }
	}

	public function json_response($message = null, $code = 200)
	{
	    // clear the old headers
	    header_remove();
	    // set the actual code
	    http_response_code($code);
	    // set the header to make sure cache is forced
	    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
	    // treat this as json
	    header('Content-Type: application/json');
	    $status = array(
	        200 => '200 OK',
	        400 => '400 Bad Request',
	        422 => 'Unprocessable Entity',
	        500 => '500 Internal Server Error'
	        );
	    // ok, validation error, or failure
	    header('Status: '.$status[$code]);
	    // return the encoded json
	    return json_encode(array(
	        'status' => $code < 300, // success or not?
	        'message' => $message
	        ));
	}

	// public function updateOne() {
	// 	include 'token.php'; $Token = new token();
	// 	$data = json_decode(file_get_contents('php://input'), true); //// Get data from frontend.

	// 	// $data['data']['user_litepoint'] = 1;
	// 	// $data['data']['user_username'] = 'Q';
	// 	// $data['access_token'] = '54462e94a372ce99fe2c387583f9be68';

	// 	if ($Token->isTokenValid($data['access_token'], $data['data']['user_username'])) {
	// 		$resp = [];
	// 		$user_new_data = [];
	// 		$keys = array_keys($data['data']);
	// 		foreach($keys as $key) {
	// 			if ($key != 'sec_key') {
	// 				if ($key == 'user_image') {
	// 					$date = new DateTime();
	// 					$image_name = $date->getTimestamp() . '.jpg';
	// 					$image_dir = FCPATH . "/users/" . md5($query_res["user_email"]);
	// 					$image_path = $image_dir . '/' .$image_name;
	// 					if (!file_exists($image_dir)) { //// Check if directory is not exist.
	// 					  mkdir($image_dir, 0777, true); //// Create directory.
	// 					}
	// 					file_put_contents($image_path, file_get_contents($data['user_image']["user_image"]));

	// 					$user_new_data['user_image'] = $image_name;
	// 					$resp['data']['user_image'] = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($image_path));
	// 				}
	// 				else if ($key != 'user_password') {
	// 					$user_new_data[$key] = $data['data'][$key];
	// 					$resp['data'][$key] = $data['data'][$key];
	// 				}
	// 			}
	// 		}

	// 		$user_old_data = $this->UserModel->getOne('user_username', $data['data']['user_username']);
	// 		$user_new_data['user_id'] = $user_old_data['user_id'];
	// 		$this->UserModel->updateOne($user_new_data);

	// 		$resp['data']['user_id'] = $user_new_data['user_id'];
	// 		$resp[RESP_STATUS] = SUCCESS;
	// 		header('Content-Type: application/json');
	// 		echo json_encode($resp);
	// 	}
	// 	else {
	// 		$this->output->set_status_header('404');
	// 	}
	// }

	public function signin() {
	  $headers = $this->getallheaders();
	  $data = $headers['Data'];
	  $data = json_decode($data, true);
	  
		// $data = json_decode(file_get_contents('php://input'), true);
		include 'token.php'; $Token = new token();

		// $data = $data['data'];
		$resp = []; //// Declare data for response.

		// $data['data']['user_email'] = 'asd@asd.com';
		// $data['data']['user_password'] = 'asd';
		
		$query_res = $this->UserModel->getUserBy('user_email', $data['data']['user_email']);
		if ($query_res[RESP_STATUS] == SUCCESS) //// Email is exist.
		{ 
			if ($query_res['user_password'] == $data['data']['user_password']) //// Password is correct.
			{ 
				$keys = array_keys($query_res);
				foreach($keys as $key) {
					if ($key != 'user_password') {
						if ($key == 'user_image')
							$resp['data'][$key] = $this->UserModel->getUserImage($query_res);
						else
							$resp['data'][$key] = $query_res[$key];
					}
				}
				$result = $Token->requestToken($query_res["user_username"]);
				// $resp['access_token'] = $result['data']['access_token'];
				// $resp['access_token'] = $Token->requestToken($query_res["user_username"])['data']['access_token'];
				$resp[RESP_STATUS] = SUCCESS;
			}
			else { //// Password is incorrect.
				$resp[RESP_STATUS] = PASS_INCORRECT;
			}
		}
		else if ($query_res[RESP_STATUS] == NOT_EXIST) { //// Email is not exist.
			$resp[RESP_STATUS] = NOT_EXIST;
		}

		header('Content-Type: application/json');
		echo json_encode($resp);
	}

	public function signup() {
	  $headers = $this->getallheaders();
		$resp[RESP_STATUS] = FAILED;
	  if (isset($headers['Data'])) {
		  $header_data = $headers['Data'];
		  $header_data = json_decode($header_data, true);
	 	  if ($header_data['LSSK'] == SEC_KEY) {
				$data = json_decode(file_get_contents('php://input'), true); //// Get data frpm frontend.
				include 'token.php'; $Token = new token();

				// $resp[RESP_STATUS] = SUCCESS;
				// header('Content-Type: application/json');
				// echo json_encode($resp);
				// $data['data']['user_id'] = 'asd';

				// $data['data']['user_password'] = 'asd';
				// $data['data']['user_email'] = 'asd@asd.com';
				// $data['data']['user_fullname'] = 'asd';
				// $data['data']['user_username'] = 'asd';
				// $data['data']['user_image'] = "data:image/jpeg;base64," . "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";

				// $data['data']['user_password'] = md5('7@nterlite');
				// $data['data']['user_email'] = 'ifandhanip@gmail.com';
				// $data['data']['user_fullname'] = 'Ifan Dhani';
				// $data['data']['user_username'] = 'ifandhanip';
				// $data['data']['user_image'] = $data['data']['user_image'];

				//// Check if email is exist.
				$query_res = $this->UserModel->getUserBy('user_email', $data['data']['user_email']);
				if ($query_res[RESP_STATUS] == NOT_EXIST) //// Email is not exist.
				{ 
					//// Check if username is exist.
					$query_res = $this->UserModel->getUserBy('user_username', $data['data']['user_username']);
					if ($query_res[RESP_STATUS] == NOT_EXIST) //// Username is not exist.
					{
						//// Assign user data to be saved into database.
						$params['user_fullname'] = $data['data']["user_fullname"];
						$params['user_username'] = $data['data']["user_username"];
						$params['user_email'] 	 = $data['data']["user_email"];
						$params['user_password'] = $data['data']["user_password"];
						$converted_img = $data['data']["user_image"];
						// $quality = 50;
						// $converted_img = $this->convertImage($data['data']["user_image"], $converted_img, $quality);

						$params['user_image']    = $converted_img;
						$params['user_litegold'] = 0;
						$params['user_litepoint'] = 0;
						$params['user_isverified'] = 0;

						//// Insert user data to database and get user ID.
						$user = $this->UserModel->insertOne($params);

						//// Assign response data.
						$resp['data']['user_id'] 			 = $user['user_id'];
						$resp['data']['user_fullname'] = $user["user_fullname"];
						$resp['data']['user_username'] = $user["user_username"];
						$resp['data']['user_email'] 	 = $user["user_email"];
						$resp['data']['user_image'] 	 = $user['user_image'];
						$resp['data']['user_litegold'] = 0;
						$resp['data']['user_litepoint'] = 0;
						$resp['data']['user_isverified'] = 0;

						// $resp['access_token'] = $Token->requestToken($user["user_username"])['access_token'];
						$this->sendVerEmail($user['user_email'], $user['user_fullname'], $user['user_id']);
						$resp[RESP_STATUS] = SUCCESS;
					}
					else if ($query_res[RESP_STATUS] == SUCCESS) { //// Username is exist.
						$resp[RESP_STATUS] = USERNAME_EXIST;
					}
				}
				else if ($query_res[RESP_STATUS] == SUCCESS) { //// Email is exist.
					$resp[RESP_STATUS] = EMAIL_EXIST;
				}

				header('Content-Type: application/json');
				echo json_encode($resp);
			}
			else {
				header('Content-Type: application/json');
				echo json_encode($resp);
			}
	  }
		else {
			header('Content-Type: application/json');
			echo json_encode($resp);			
		}
	
	}

	function verify_email($user_id = NULL, $vercode = NULL) {
		// $vercode = '77460b73c55020a031655d160248238d';
		// $username = 'aWZhbmRoYW5pcA';
		// $username = base64_decode($username . '==');
		// $username = base64_decode($username);
		$url = "<script>window.location = '" . FE_URL . "'</script>";
		$query_res = $this->UserModel->getUserBy('user_id', $user_id);
		if ($query_res[RESP_STATUS] == SUCCESS) {
			if ($query_res['user_isverified'] == 0) {
				if (md5($query_res['user_email']) == $vercode) {
					$new_user_data['user_isverified'] = 1;
					$new_user_data['user_id'] = $query_res['user_id'];
					$this->UserModel->updateUser($new_user_data);
				}
				echo $url;
			}
			else {
				echo $url;
			}
		}
		else {
			echo $url;
		}
	}

	public function resend_email_ver() {
	  $headers = $this->getallheaders();
	  if (isset($headers['Data'])) {
		  $header_data = $headers['Data'];
		  $header_data = json_decode($header_data, true);
	 	  if ($header_data['LSSK'] == SEC_KEY) {

				$data = json_decode(file_get_contents('php://input'), true); //// Get data from frontend.
				include 'token.php'; $Token = new token();

				$resp = [];
				// if ($Token->isTokenValid($data['access_token'], $data['data']['user_username'])) {
					$query_res = $this->UserModel->getUserBy('user_username', $data['data']['user_username']);
					if ($this->sendVerEmail($query_res['user_email'], $query_res['user_fullname'], $query_res['user_id'])) {
						$resp[RESP_STATUS] = SUCCESS;
					}
					else {
						$resp[RESP_STATUS] = FAILED;
					}
				// }
				// else { //// Email is not exist.
				// 	$resp[RESP_STATUS] = NOT_EXIST;
				// }
			}
			else { //// Email is not exist.
				$resp[RESP_STATUS] = FAILED;
			}
		}
		else { //// Email is not exist.
			$resp[RESP_STATUS] = FAILED;
		}

		header('Content-Type: application/json');
		echo json_encode($resp);
	}


	function sendVerEmail($user_email = NULL, $user_fullname = NULL, $user_id = NULL) {
		$vercode = md5($user_email);
		$ver_url = HOST . '/user/verify_email/' . $user_id . '/' . $vercode;
		// $ver_url = HOST . '/user/verify_email/' . base64_encode($user_username) . '/' . $vercode;
		// $ver_url = HOST . '/user/verify_email/' . substr_replace(base64_encode($user_username) ,"",-2) . '/' . $vercode;
		// $ver_url = 'http://192.168.1.5/be.lanterlite.com/user/verify_email/' . $user_username . '/' . $vercode;

		$subject = "Lanterlite Email Verification.";
		// $headers = "MIME-Version: 1.0" . "\r\n";
		// $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
		// $headers = "From: admin@lanterlite.com" . "\r\n";
		// $msg = "Verification ...";
		// $msg = wordwrap($msg, 70);
		// $ver_code = 123; 
		// $user_fullname = 'Ifan Dhani P.';

		$html = '<html>';
		$html .= '<head>';
		$html .= '<title>Ifan</title>';
		$html .= '</head>';

		$html .= '<body>';
		$html .= '<table>';
		$html .= 	'<tr>';
		$html .= 	'<td>';
		$html .= 		'
		This is an automatic response sent when registering an email address on Lanterlite to verify that the email is valid.
		To register this email address ' . $user_email . ' to "' . $user_fullname . '",
		please complete the email registration process by tapping the verification link below.
		<br><br>';
		$html .= 	'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td style="text-align:center;">';
		$html .= 		'<a href="' . $ver_url . '">';
		$html .= 		$ver_url;
		$html .= 		'</a>';
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 		'<br>
		By registering your email address, Lanterlite will try to improve your experiences when using our products.

		If you did not request email registration, please delete this email.
		You may have received this email in error because someone else entered your email address by mistake.
		Your email address will not be registered unless you enter the verification code above. <br><br>
		';
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= '</table>';
		$html .= '</body>';
		$html .= '</html>';

		// echo $html; //// Send email.

		require_once('PHPMailer/PHPMailerAutoload.php');

		try {
			$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = '465';
			$mail->isHTML();
			$mail->Username = 'web.lanterlite@gmail.com';
			$mail->Password = 'lite12345';
			// $mail->Password = '7@nterlitE';
			$mail->SetFrom('no-reply@lanterlte.com');
			$mail->Subject = $subject;
			$mail->Body = $html;
			$mail->AddAddress($user_email);
			// $mail->AddAddress('ifandhanip@gmail.com');

			$mail->send();
			return true;
		} catch (Exception $e) {
		  echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
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

}