<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Confirmation {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function delete($confirmation_id) {
		$dir = BASE_DIR .'/storages/light/';
		/* handle asking player status */
		$confirmation_data = json_read($dir . 'confirmations/'.$confirmation_id)[DATA];
		$asked_by_data = json_read($dir . 'players_status/'. $confirmation_data['asked_by'])[DATA];
		$asked_by_data['confirmation_id'] = '';

		json_save($dir.'players_status/', $asked_by_data['char_id'], $asked_by_data, $minify=false);
		/* handle asking player status */
		$res = file_delete($dir . 'confirmations/'.$confirmation_id);
		$res = json_encode($res);
		return $res;
	}

	public function check($confirmation_id) {
		$dir = BASE_DIR .'/storages/light/';
		// handle asking player status
		$confirmation_data = json_read($dir . 'confirmations/'.$confirmation_id)[DATA];
		$confirmation_data = json_encode($confirmation_data);
		return $confirmation_data;
	}

}
?>