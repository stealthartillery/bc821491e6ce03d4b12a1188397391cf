<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Confirmation {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function delete($confirmation_id) {
		/* remove confirmation id from asking char */
		// $confirmation_data = json_read(dir. 'confirmations/'.$confirmation_id)[DATA];
		// set_player($confirmation_data['asked_by'], 'confirmation_id', '');

		/* delete confirmation file */
		$res = file_delete(dir. 'confirmations/'.$confirmation_id);
		$res = json_encode($res);
		return $res;
	}

	public function check($confirmation_id) {
		// handle asking player status
		$confirmation_data = json_read(dir. 'confirmations/'.$confirmation_id)[DATA];
		$confirmation_data = json_encode($confirmation_data);
		return $confirmation_data;
	}

}
?>