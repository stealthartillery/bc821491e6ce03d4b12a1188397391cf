<?php defined('BASEPATH') OR exit('no direct script access allowed');

class signin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(array('user_model'));
	}

	public function index() {
		$data = json_decode(file_get_contents('php://input'), true);

		if ($data['sec_key'] == SEC_KEY) {
			$this->load->library('general');
		
			//// Declare data for response.
			$resp_data[RESP_STATUS] = SUCCESS;

			//// Check if email is exist.
			$query_res = $this->user_model->getOne('user_email', $data['user_email']);
			if ($query_res[RESP_STATUS] == SUCCESS) { //// Email is exist.

				if ($query_res['user_password'] == $data['user_password']) { //// Password is correct.
					$resp_data['user_username'] = $query_res['user_username'];
					$resp_data['user_email'] = $query_res['user_email'];
					$resp_data['user_fullname'] = $query_res['user_fullname'];
					$resp_data['user_image'] = HOST . "/uploads/" . $query_res["user_username"] . "/" . $query_res['user_image'];
					$resp_data['user_litegold'] = $query_res['user_litegold'];
					$resp_data['user_litepoint'] = $query_res['user_litepoint'];
				}

				else { //// Password is incorrect.
					$resp_data[RESP_STATUS] = PASS_INCORRECT;
				}
			}
			else if ($query_res[RESP_STATUS] == NOT_EXIST) { //// Email is mpt exist.
				$resp_data[RESP_STATUS] = NOT_EXIST;
			}

			header('Content-Type: application/json');
			echo json_encode($resp_data);
		}
		else {
			$this->output->set_status_header('404');
		}
	}

	public function getOneUser() {
		$data = json_decode(file_get_contents('php://input'), true);

		if ($data['sec_key'] == SEC_KEY) {
			$this->load->library('general');
		
			//// Declare data for response.
			$resp_data = [];

			//// Check if username is exist.
			$query_res = $this->user_model->getOne('user_username', base64_decode($data['user_username']));
			if ($query_res[RESP_STATUS] == SUCCESS) { //// Username is exist.

				$resp_data['user_username'] = $query_res['user_username'];
				$resp_data['user_email'] = $query_res['user_email'];
				$resp_data['user_fullname'] = $query_res['user_fullname'];
				$resp_data['user_image'] = HOST . "/uploads/" . $query_res["user_username"] . "/" . $query_res['user_image'];
				$resp_data['user_litegold'] = $query_res['user_litegold'];
				$resp_data['user_litepoint'] = $query_res['user_litepoint'];
				$resp_data[RESP_STATUS] = SUCCESS;
			}

			else if ($query_res[RESP_STATUS] == NOT_EXIST) { //// Username is mpt exist.
				$resp_data[RESP_STATUS] = NOT_EXIST;
			}

			header('Content-Type: application/json');
			echo json_encode($resp_data);
		}
		else {
			$this->output->set_status_header('404');
		}
	}

	public function updateUser() {
		$data = json_decode(file_get_contents('php://input'), true);

		if ($data['sec_key'] == SEC_KEY) {
			$this->load->library('general');
		
			//// Declare data for response.
			$resp_data = [];
			
			//// Check if username is exist.
			$query_res = $this->user_model->getOne('user_username', base64_decode($data['user_username']));
			if ($query_res[RESP_STATUS] == SUCCESS) { //// Username is exist.

				$resp_data['user_username'] = $query_res['user_username'];
				$resp_data['user_email'] = $query_res['user_email'];
				$resp_data['user_fullname'] = $query_res['user_fullname'];
				$resp_data['user_image'] = $query_res['user_image'];
				$resp_data['user_litegold'] = $query_res['user_litegold'];
				$resp_data['user_litepoint'] = $query_res['user_litepoint'];
				$resp_data[RESP_STATUS] = SUCCESS;
			}

			else if ($query_res[RESP_STATUS] == NOT_EXIST) { //// Username is mpt exist.
				$resp_data[RESP_STATUS] = NOT_EXIST;
			}

			header('Content-Type: application/json');
			echo json_encode($resp_data);
		}
	}

}
?>