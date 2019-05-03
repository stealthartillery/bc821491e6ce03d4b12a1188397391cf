<?php if (!defined('BASEPATH')) exit('no direct script access allowed');
if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
  header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

class User extends CI_Controller{

	public function __construct() {
		parent::__construct();
		include BASE_DIR . 'assets/backlite/php/ModelUser.php';
		$this->UserModel = new ModelUser();
		// $this->load->model(array('UserModel'));
		$this->L = new Lanterlite();
	}

	public function index() {
		$data = json_decode(file_get_contents("php://input"), true);
		if ($data !== null && $this->L->is_exist_json_key($data, "Data") and $this->L->is_exist_json_key($data, 'LSSK')) {
			// if (true) {
			if ($data['LSSK'] == LSSK) {
				// $this->L->printJson($data);
				echo eval($data[DATA]);
			}
			else {
				$this->output->set_status_header('404');
				$this->load->helper('url'); 
				$this->load->view('page_notfound'); 				
			}
		}
		else {
			$this->output->set_status_header('404');
			$this->load->helper('url'); 
			$this->load->view('page_notfound'); 
		}
	}
	
	// public function get_all() {
	// 	$resp = $this->UserModel->get_all();
	// 	header('Content-Type: application/json');
	// 	echo json_encode($resp);
	// }

	public function getCart() {
		if (isset($_GET['user_id'])){
			$user_id = $_GET['user_id'];
			$resp = $this->UserModel->get_cart($user_id);
			if ($resp[RES_STAT] !== SUCCESS) {
				$this->UserModel->set_cart($user_id, []);
				$resp[DATA] = [];
				$resp[RES_STAT] = SUCCESS;
			}
			header('Content-Type: application/json');
			echo json_encode($resp);
		}
	}

	public function getWishlist() {
		if (isset($_GET['user_id'])){
			$user_id = $_GET['user_id'];
			$resp = $this->UserModel->get_wishlist($user_id);
			if ($resp[RES_STAT] !== SUCCESS) {
				$this->UserModel->set_wishlist($user_id, []);
				$resp[DATA] = [];
				$resp[RES_STAT] = SUCCESS;
			}
			header('Content-Type: application/json');
			echo json_encode($resp);
		}
	}

	public function setCart() {
		$data = json_decode(file_get_contents("php://input"), true);
		if ($data !== null && $this->L->is_exist_json_key($data, "Data") and $this->L->is_exist_json_key($data, 'LSSK')) {
			$data = $data["Data"];
			$resp = $this->UserModel->set_cart($data['user_id'], $data['cart']);
			header('Content-Type: application/json');
			echo json_encode($resp);
		}
	}

	public function setWishlist() {
		$data = json_decode(file_get_contents("php://input"), true);
		if ($data !== null && $this->L->is_exist_json_key($data, "Data") and $this->L->is_exist_json_key($data, 'LSSK')) {
			$data = $data["Data"];
			$resp = $this->UserModel->set_wishlist($data['user_id'], $data['wishlist']);
			header('Content-Type: application/json');
			echo json_encode($resp);
		}
	}

	public function license_get() {
		if (isset($_GET['user_id']) && isset($_GET['user_lang'])) {
			$resp = $this->UserModel->get_license($_GET['user_id'], $_GET['user_lang'])[DATA];
		}
		else {
			$resp[RES_STAT] = FAILED;
		}

		header('Content-Type: application/json');
		echo json_encode($resp);
	}

	public function edit_one($new_user_data) {
		$resp[RES_STAT] = $this->UserModel->edit_one($new_user_data);
		header('Content-Type: application/json');
		echo json_encode($resp);
	}

	public function requestAccess() {
		$data = json_decode(file_get_contents('php://input'), true);
		include 'token.php'; $Token = new token();

		$username = $data['user_username'];
		$resp = [];

		$data = $Token->getToken($username);
		if ($data[RES_STAT] == SUCCESS) {
			$resp['access_token'] = $data[DATA];
			$resp[RES_STAT] = SUCCESS;
		} else {
			$resp[RES_STAT] = FAILED;
		}

		header('Content-Type: application/json');
		echo json_encode($resp);
	}

	public function changeNotif() {
	  $headers = $this->getallheaders();
	  $data = $headers[DATA];
	  $data = json_decode($data, true);

		$resp = [];
		$query_res = $this->UserModel->user_get_by('user_username', $data[DATA]['user_username']);
		if ($query_res[RES_STAT] == SUCCESS) {
			if ($data[DATA]['notif_index'] == 'all') {
				$notif_data = $this->UserModel->notif_get($query_res['user_id'], $query_res['user_lang']);
				foreach ($notif_data[DATA] as $key => $value) {
					$this->UserModel->notif_change($key, $data[DATA]['notif_param'], $data[DATA]['val'], $query_res['user_id'], $query_res['user_lang']);
				}
			}
			else {
				$notif_data = $this->UserModel->notif_change($data[DATA]['notif_index'], $data[DATA]['notif_param'], $data[DATA]['val'], $query_res['user_id'], $query_res['user_lang']);
			}
			$resp[RES_STAT] = SUCCESS;
		}
		else if ($query_res[RES_STAT] == NOT_EXIST) {
			$resp[RES_STAT] = NOT_EXIST;
		}

		header('Content-Type: application/json');
		echo json_encode($resp);
	}

	public function notifupdate($username=NULL) {
		$username = $_GET["username"];
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');

		$notif_count = 0;
		$query_res = $this->UserModel->user_get_by('user_username', $username);
		if ($query_res[RES_STAT] == SUCCESS) { 
			$notif_data = $this->UserModel->notif_get($query_res['user_id'], $query_res['user_lang']);
			foreach ($notif_data[DATA] as $key => $value) {
				if (!$value['has_checked']) {
					$notif_count += 1;
				}
			}
		}

		$notif_count = json_encode($notif_count);
		echo "data: {$notif_count}\n\n";
		flush();
	}

	public function getNotif() {
	  $headers = $this->getallheaders();
	  $data = $headers[DATA];
	  $data = json_decode($data, true);

		$resp = [];
		$query_res = $this->UserModel->user_get_by('user_username', $data[DATA]['user_username']);
		if ($query_res[RES_STAT] == SUCCESS) { 
			$notif_data = $this->UserModel->notif_get($query_res['user_id'], $query_res['user_lang']);
			$resp = $notif_data;
		}
		else if ($query_res[RES_STAT] == NOT_EXIST) { //// Username is not exist.
			$resp[RES_STAT] = NOT_EXIST;
		}

		header('Content-Type: application/json');
		echo json_encode($resp);
	}

	public function getOne() {
	  $headers = $this->getallheaders();
	  $data = $headers[DATA];
	  $data = json_decode($data, true);

		// $data = json_decode(file_get_contents('php://input'), true);
		include 'token.php'; $Token = new token();

		// $data[DATA]['user_username'] = 'asd';
		// $data['access_token'] = '54462e94a372ce99fe2c387583f9be68';

		// if ($Token->isTokenValid($data['access_token'], $data[DATA]['user_username'])) {
			$resp = [];
			$query_res = $this->UserModel->user_get_by('user_username', $data[DATA]['user_username']);
			if ($query_res[RES_STAT] == SUCCESS) //// Username is exist.
			{ 
				$keys = array_keys($query_res);
				foreach($keys as $key) {
					if ($key != 'user_password') {
						if ($key == 'user_image')
							$resp[DATA][$key] = $this->UserModel->user_img_get($query_res);
						else
							$resp[DATA][$key] = $query_res[$key];
					}
				}
				// $resp['access_token'] = $data['access_token'];
				$resp[RES_STAT] = SUCCESS;
			}
			else if ($query_res[RES_STAT] == NOT_EXIST) { //// Username is not exist.
				$resp[RES_STAT] = NOT_EXIST;
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

	public function signin() {
	  $headers = $this->getallheaders();
	  if (isset($headers[DATA])) { $this->signin_process($headers);}
	  else { $this->load->helper('url'); $this->load->view('page_notfound.php'); }
	}

	public function signup() {
	  $headers = $this->getallheaders();
	  if (isset($headers[DATA])) { $this->signup_process($headers);}
	  else { $this->load->helper('url'); $this->load->view('page_notfound.php'); }
	}

	function verify_email($user_id = NULL, $vercode = NULL) {
		// $vercode = '77460b73c55020a031655d160248238d';
		// $username = 'aWZhbmRoYW5pcA';
		// $username = base64_decode($username . '==');
		// $username = base64_decode($username);
		$url = "<script>window.location = '" . FE_URL . "'</script>";
		$query_res = $this->UserModel->user_get_by('user_id', $user_id);
		if ($query_res[RES_STAT] == SUCCESS) {
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
	  if (isset($headers[DATA])) {
		  $header_data = $headers[DATA];
		  $header_data = json_decode($header_data, true);
	 	  if ($header_data['LSSK'] == SEC_KEY) {

				$data = json_decode(file_get_contents('php://input'), true); //// Get data from frontend.
				include 'token.php'; $Token = new token();

				$resp = [];
				// if ($Token->isTokenValid($data['access_token'], $data[DATA]['user_username'])) {
					$query_res = $this->UserModel->user_get_by('user_username', $data[DATA]['user_username']);
					if ($this->sendVerEmail($query_res['user_email'], $query_res['user_fullname'], $query_res['user_id'])) {
						$resp[RES_STAT] = SUCCESS;
					}
					else {
						$resp[RES_STAT] = FAILED;
					}
				// }
				// else { //// Email is not exist.
				// 	$resp[RES_STAT] = NOT_EXIST;
				// }
			}
			else { //// Email is not exist.
				$resp[RES_STAT] = FAILED;
			}
		}
		else { //// Email is not exist.
			$resp[RES_STAT] = FAILED;
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

		$html = '<html>'.
		'<head>'.
		'<title>Ifan</title>'.
		'</head>'.
		'<body>'.
		'<table>'.
			'<tr>'.
			'<td>'.
				'This is an automatic response sent when registering an email address on Lanterlite to verify that the email is valid. To register this email address ' . $user_email . ' to "' . $user_fullname . '", please complete the email registration process by tapping the verification link below.<br><br>'.
			'</td>'.
			'</tr>'.
			'<tr>'.
				'<td style="text-align:center;">'.
				'<a href="' . $ver_url . '">'.$ver_url.
				'</a>'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td>'.
					'<br>By registering your email address, Lanterlite will try to improve your experiences when using our products. If you did not request email registration, please delete this email. You may have received this email in error because someone else entered your email address by mistake. Your email address will not be registered unless you enter the verification code above. <br><br>'.
				'</td>'.
			'</tr>'.
		'</table>'.
		'</body>'.
		'</html>';

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
	
	function getallheaders() { 
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

	function convertImage($originalImage, $outputImage, $quality) {
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

	private function signin_process($headers) {
	  $data = $headers[DATA];
	  $data = json_decode($data, true);
	  
		// $data = json_decode(file_get_contents('php://input'), true);
		include 'token.php'; $Token = new token();

		// $data = $data[DATA];
		$resp = []; //// Declare data for response.

		// $data[DATA]['user_email'] = 'asd@asd.com';
		// $data[DATA]['user_password'] = 'asd';
		
		$query_res = $this->UserModel->user_get_by('user_email', $data[DATA]['user_email']);
		if ($query_res[RES_STAT] == SUCCESS) { 
			if ($query_res['user_password'] == $data[DATA]['user_password']) { 
				$keys = array_keys($query_res);
				foreach($keys as $key) {
					if ($key != 'user_password') {
						if ($key == 'user_image')
							$resp[DATA][$key] = $this->UserModel->user_img_get($query_res);
						else
							$resp[DATA][$key] = $query_res[$key];
					}
				}

				$resp[DATA]['user_license'] = $this->UserModel->get_license($query_res['user_id'], $query_res['user_lang'])[DATA];
				$resp[RES_STAT] = SUCCESS;
			}
			else {
				$resp[RES_STAT] = PASS_INCORRECT;
			}
		}
		else if ($query_res[RES_STAT] == NOT_EXIST) {
			$resp[RES_STAT] = NOT_EXIST;
		}

		header('Content-Type: application/json');
		echo json_encode($resp);
	}

	private function signup_process($headers) {
		$resp[RES_STAT] = FAILED;
	  $header_data = $headers[DATA];
	  $header_data = json_decode($header_data, true);
 	  // if ($header_data['LSSK'] == SEC_KEY) {
			$data = json_decode(file_get_contents('php://input'), true); //// Get data frpm frontend.
			include 'token.php'; $Token = new token();
			// $resp[RES_STAT] = SUCCESS;
			// header('Content-Type: application/json');
			// echo json_encode($resp);
			// $data[DATA]['user_id'] = 'asd';

			// $data[DATA]['user_password'] = 'asd';
			// $data[DATA]['user_email'] = 'asd@asd.com';
			// $data[DATA]['user_fullname'] = 'asd';
			// $data[DATA]['user_username'] = 'asd';

			// $data[DATA]['user_password'] = md5('7@nterlite');
			// $data[DATA]['user_email'] = 'ifandhanip@gmail.com';
			// $data[DATA]['user_fullname'] = 'Ifan Dhani';
			// $data[DATA]['user_username'] = 'ifandhanip';
			// $data[DATA]['user_image'] = $data[DATA]['user_image'];

			//// Check if email is exist.
			$query_res = $this->UserModel->user_get_by('user_email', $data[DATA]['user_email']);
			if ($query_res[RES_STAT] == NOT_EXIST) //// Email is not exist.
			{ 
				//// Check if username is exist.
				$query_res = $this->UserModel->user_get_by('user_username', $data[DATA]['user_username']);
				if ($query_res[RES_STAT] == NOT_EXIST) //// Username is not exist.
				{
					//// Assign user data to be saved into database.
					$params['user_fullname'] = $data[DATA]["user_fullname"];
					$params['user_username'] = $data[DATA]["user_username"];
					$params['user_email'] 	 = $data[DATA]["user_email"];
					$params['user_password'] = $data[DATA]["user_password"];
					$params['user_lang']     = $data[DATA]["user_lang"];
					$params['user_created_date'] = $data[DATA]["user_created_date"];
					$converted_img = "data:image/png;base64,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";
					// $converted_img = $data[DATA]["user_image"];
					// $quality = 50;
					// $converted_img = $this->convertImage($data[DATA]["user_image"], $converted_img, $quality);

					$params['user_image']    = $converted_img;
					$params['user_litegold'] = 0;
					$params['user_litepoint'] = 0;
					$params['user_isverified'] = 0;

					//// Insert user data to database and get user ID.
					$user = $this->UserModel->insert_one($params);

					//// Assign response data.
					$resp[DATA]['user_id'] 			 = $user['user_id'];
					$resp[DATA]['user_fullname'] = $user["user_fullname"];
					$resp[DATA]['user_username'] = $user["user_username"];
					$resp[DATA]['user_email'] 	 = $user["user_email"];
					$resp[DATA]['user_image'] 	 = $user['user_image'];
					$resp[DATA]['user_lang'] 	   = $user['user_lang'];
					$resp[DATA]['user_created_date'] = $user['user_created_date'];
					$resp[DATA]['user_litegold'] = 0;
					$resp[DATA]['user_litepoint'] = 0;
					$resp[DATA]['user_isverified'] = 0;

					// $resp['access_token'] = $Token->requestToken($user["user_username"])['access_token'];
					$this->sendVerEmail($user['user_email'], $user['user_fullname'], $user['user_id']);
					$resp[RES_STAT] = SUCCESS;
				}
				else if ($query_res[RES_STAT] == SUCCESS) { //// Username is exist.
					$resp[RES_STAT] = USERNAME_EXIST;
				}
			}
			else if ($query_res[RES_STAT] == SUCCESS) { //// Email is exist.
				$resp[RES_STAT] = EMAIL_EXIST;
			}

			header('Content-Type: application/json');
			echo json_encode($resp);
		// }
		// else {
		// 	header('Content-Type: application/json');
		// 	echo json_encode($resp);
		// }
  }
}