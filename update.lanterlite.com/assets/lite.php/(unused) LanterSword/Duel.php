<?php 

class Duel {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function confirm_ask($confirmation_id, $is_agreed) {
		$dir = BASE_DIR .'/storages/light/';

		if ($is_agreed) {
			// handle confirmation file
			$confirmation_data = json_read($dir . 'confirmations/'.$confirmation_id)[DATA];
			$confirmation_data['is_agreed'] = true;
			json_save($dir.'confirmations/', $confirmation_id, $confirmation_data, $minify=false);

			// handle asked player status
			$asked_to_data = json_read($dir . 'players_status/'. $confirmation_data['asked_to'])[DATA];
			$asked_to_data['confirmation_id'] = '';
			json_save($dir.'players_status/', $asked_to_data['char_id'], $asked_to_data, $minify=false);
		}
		else {
			// handle confirmation file
			$confirmation_data = json_read($dir . 'confirmations/'.$confirmation_id)[DATA];
			$confirmation_data['is_agreed'] = false;
			json_save($dir.'confirmations/', $confirmation_id, $confirmation_data, $minify=false);

			// handle asked player status
			$asked_to_data = json_read($dir . 'players_status/'. $confirmation_data['asked_to'])[DATA];
			$asked_to_data['confirmation_id'] = '';
			json_save($dir.'players_status/', $asked_to_data['char_id'], $asked_to_data, $minify=false);
		}

		return $confirmation_data;
	}

	public function start($duel_id) {
		$dir = BASE_DIR .'/storages/light/';
		$duel = json_read($dir .'duels/' . $duel_id)[DATA];
		for ($i=3; $i>=0; $i--) {
			if ($i == 0)
				$duel['duel_start_time'] = 'Duel Start!';
			else
				$duel['duel_start_time'] = $i;
			json_save($dir.'duels/', $duel_id, $duel, $minify=false);
			sleep(1);
		}

		$duel['duel_start_time'] = '';
		$duel['is_start'] = true;
		json_save($dir.'duels/', $duel_id, $duel, $minify=false);

		$p1_id = $duel['duel_member'][0];
		$p2_id = $duel['duel_member'][1];
		$p1 = json_read($dir .'players_status/' . $p1_id)[DATA];
		$p2 = json_read($dir .'players_status/' . $p2_id)[DATA];

		if (!arr_value_exist($p1['enemies'], $p2_id))
			array_push($p1['enemies'], $p2_id);
		if (!arr_value_exist($p2['enemies'], $p1_id))
			array_push($p2['enemies'], $p1_id);
		json_save($dir.'players_status/', $p1_id, $p1, $minify=false);
		json_save($dir.'players_status/', $p2_id, $p2, $minify=false);

		for ($i=20; $i>=0; $i--) {
			$duel = json_read($dir .'duels/' . $duel_id)[DATA];
			$p1 = json_read($dir .'players_status/' . $p1_id)[DATA];
			$p2 = json_read($dir .'players_status/' . $p2_id)[DATA];
			if ($p1['char_health']['current'] <= 0)
				$duel['winner'] = $p2_id . ' has won the duel between ' .$p1_id.' and '.$p2_id .'.';
			else if ($p2['char_health']['current'] <= 0) 
				$duel['winner'] = $p1_id . ' has won the duel between ' .$p1_id.' and '.$p2_id .'.';
			if ($duel['winner'] == '') {
				$duel['duel_time'] = $i;
				json_save($dir.'duels/', $duel_id, $duel, $minify=false);
				sleep(1);
			}
			else {
				break;
			}
		}

		if ($duel['winner'] == '')
			$duel['winner'] = 'The duel was draw between ' .$p1_id.' and '.$p2_id .'.';
		json_save($dir.'duels/', $duel_id, $duel, $minify=false);

		sleep(3);
		$p1['char_health']['current'] = $p1['char_health']['max'];
		$p1['char_stamina']['current'] = $p1['char_stamina']['max'];
		$p2['char_health']['current'] = $p2['char_health']['max'];
		$p2['char_stamina']['current'] = $p2['char_stamina']['max'];

		$p1['enemies'] = arr_value_remove_by_value($p1['enemies'], $p2_id);
		$p2['enemies'] = arr_value_remove_by_value($p2['enemies'], $p1_id);
		json_save($dir.'players_status/', $p1_id, $p1, $minify=false);
		json_save($dir.'players_status/', $p2_id, $p2, $minify=false);

		// sleep(3);
		$this->delete_duel($duel_id);
	}

	public function get_duel($duel_id) {
		$dir = BASE_DIR .'/storages/light/';
		$duel = json_read($dir .'duels/' . $duel_id)[DATA];

		return json_encode($duel);
	}

	public function delete_duel($duel_id) {
		$dir = BASE_DIR .'/storages/light/';
		$res = file_delete($dir . 'duels/'.$duel_id);
	}

	public function init($p1_id, $p2_id) {
		$dir = BASE_DIR .'/storages/light/';
		$p1 = json_read($dir .'players_status/' . $p1_id)[DATA];
		$p2 = json_read($dir .'players_status/' . $p2_id)[DATA];

		/* init duel file. */
		$date = new DateTime();
		$duel_id = md5($p1_id.$p2_id.$date->getTimestamp());

		$duel['duel_id'] = $duel_id;
		$duel['is_start'] = false;
		$duel['duel_time'] = 60;
		$duel['duel_start_time'] = 3;
		$duel['winner'] = '';
		$duel['duel_member'] = [];
		array_push($duel['duel_member'], $p1_id);
		array_push($duel['duel_member'], $p2_id);

		json_save($dir.'duels/', $duel_id, $duel, $minify=false);

		$p1['duel_id'] = $duel_id;
		$p2['duel_id'] = $duel_id;
		json_save($dir.'players_status/', $p1_id, $p1, $minify=false);
		json_save($dir.'players_status/', $p2_id, $p2, $minify=false);
	}

	public function ask_to_duel($char_id, $asked_char_id) {
		$dir = BASE_DIR .'/storages/light/';

		/* handle ask for duel confirmation */
		$date = new DateTime();
		$confirmation_id = md5($char_id.$asked_char_id.$date->getTimestamp());
		$json = arr_to_json(array(
			'confirmation_id' => $confirmation_id,
			'confirmation_type' => 'duel',
			'asked_to' => $asked_char_id,
			'asked_by' => $char_id,
			'is_agreed' => ''
		));
		json_save($dir.'confirmations/', $confirmation_id, $json, $minify=false);

		/* handle asked char data	*/
		$asked_char_data = json_read($dir . 'players_status/'.$asked_char_id)[DATA];
		$asked_char_data['confirmation_id'] = $confirmation_id;
		json_save($dir.'players_status/', $asked_char_id, $asked_char_data, $minify=false);

		/* handle asking char data */
		$char_data = json_read($dir . 'players_status/'.$char_id)[DATA];
		$char_data['confirmation_id'] = $confirmation_id;
		json_save($dir.'players_status/', $char_id, $char_data, $minify=false);

		return true;
	}

}
?>