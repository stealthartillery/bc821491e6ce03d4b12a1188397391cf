<?php if (!defined('BASEPATH')) exit('no direct script access allowed');
// header("Access-Control-Allow-Methods: GET");
// header('Access-Control-Allow-Origin: http://localhost/lanterlite.com/register');


class signup extends CI_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model(array('user_model'));
	}

	public function index() {

		//// Get data frpm frontend.
		$data = json_decode(file_get_contents('php://input'), true);
		if ($data['sec_key'] == SEC_KEY) {
			$this->load->library('general');
		
			//// Declare data for response.
			$resp_data = [];

			//// Check if email is exist.
			$query_res = $this->user_model->getOne('user_email', $data['user_email']);
			if ($query_res[RESP_STATUS] == NOT_EXIST) { //// Email is not exist.
				
				//// Check if username is exist.
				$query_res = $this->user_model->getOne('user_username', $data['user_username']);
				if ($query_res[RESP_STATUS] == NOT_EXIST) { //// Hsername is not exist.

					//// Save profile image.
					$date = new DateTime();
					$image_name = $date->getTimestamp() . '.jpg';
					$image_dir = FCPATH . '/uploads/' . md5($data['user_username']);
					$image_path = $image_dir . '/' .$image_name;
					$url = $data["user_image"];
					if (!file_exists($image_dir)) { //// Check if directory is not exist.
					    mkdir($image_dir, 0777, true); //// Create directory.
					}
					file_put_contents($image_path, file_get_contents($url));

					//// Save account data.
					$params['user_fullname'] = $data["user_fullname"];
					$params['user_username'] = $data["user_username"];
					$params['user_email'] = $data["user_email"];
					$params['user_password'] = $data["user_password"];
					$params['user_image'] = $image_name;
					$params['user_litegold'] = 0;
					$params['user_litepoint'] = 0;
					$this->user_model->insertOne($params);

					//// Prepare response data.
					$resp_data['user_fullname'] = $data["user_fullname"];
					$resp_data['user_username'] = $data["user_username"];
					$resp_data['user_email'] = $data["user_email"];
					$resp_data['user_password'] = $data["user_password"];
					// $resp_data['user_image'] = $image_name;
					$resp_data['user_image'] = HOST . "/uploads/" . md5($data["user_username"]) . "/" . $image_name;
					$resp_data['user_litegold'] = 0;
					$resp_data['user_litepoint'] = 0;
					$resp_data[RESP_STATUS] = SUCCESS;

				}
				else if ($query_res[RESP_STATUS] == SUCCESS) { //// Hsername is exist.
					$resp_data[RESP_STATUS] = USERNAME_EXIST;
				}
			}
			else if ($query_res[RESP_STATUS] == SUCCESS) { //// Email is exist.
				$resp_data[RESP_STATUS] = EMAIL_EXIST;
			}

			header('Content-Type: application/json');
			echo json_encode($resp_data);
		}
		else {
			$this->output->set_status_header('404');
		}
	}
}
