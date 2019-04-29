<?php defined('BASEPATH') OR exit('No direct script access allowed');

class user_model extends CI_Model{

	protected $table = 'User';

	function __contract() {
		parent::__contract();
	}

	public function insertOne($data) {
		$fields = array(
			'user_username' => $data['user_username'],
			'user_email' => $data['user_email'],
			'user_password' => $data['user_password'],
			'user_fullname' => $data['user_fullname'],
			'user_image' => $data['user_image'],
			'user_litegold' => $data['user_litegold'],
			'user_litepoint' => $data['user_litepoint'],
			'created_date' => date('Y-m=d H:i:s')
		);

		//// Insert data into table
		$this->db->insert($this->table, $fields);
	}

	public function getOne($db_field, $req_field) {
		$this->load->library('general');
		$sql = "SELECT * FROM user WHERE " . $db_field . " = '" . $req_field . "';";
		$resp_data = [];
		$query = $this->db->query($sql);
		if ($query->result_array()) {
			foreach ($query->result_array() as $row) {
				$resp_data['user_id'] = $row['user_id'];
				$resp_data['user_fullname'] = $row['user_fullname'];
				$resp_data['user_username'] = $row['user_username'];
				$resp_data['user_email'] = $row['user_email'];
				$resp_data['user_password'] = $row['user_password'];
				$resp_data['user_image'] = $row['user_image'];
				$resp_data['user_litegold'] = $row['user_litegold'];
				$resp_data['user_litepoint'] = $row['user_litepoint'];
			}
			$resp_data[RESP_STATUS] = SUCCESS;
		}
		else {
			$resp_data[RESP_STATUS] = NOT_EXIST;
		}

		return $resp_data;
	}

	public function updateOne($data) {
	    $this->db->where('user_id', $data['user_id']);
	    $new_data = [];
		$keys = array_keys($data);
		foreach($keys as $key) {$new_data[$key] = $data[$key];}
	    $this->db->update($this->table, $new_data);
	    return true;
	}
}