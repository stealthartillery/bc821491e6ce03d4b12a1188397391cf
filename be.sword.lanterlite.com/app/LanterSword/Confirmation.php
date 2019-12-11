<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Confirmation {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function delete($confirmation_id) {
		/* remove confirmation id from asking char */
		// $confirmation_data = LGen('JsonMan')->read(dir. 'confirmations/'.$confirmation_id);
		// set_player($confirmation_data['asked_by'], 'confirmation_id', '');

		/* delete confirmation file */
		$res = file_delete(dir. 'confirmations/'.$confirmation_id);
		$res = ($res);
		return $res;
	}

	public function get_data($confirmation_id) {
		$confirmation_data = LGen('JsonMan')->read(dir. 'confirmations/'.$confirmation_id);
		return ($confirmation_data);
	}
}
?>