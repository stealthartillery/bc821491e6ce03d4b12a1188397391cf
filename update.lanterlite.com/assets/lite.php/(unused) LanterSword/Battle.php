<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

Class Battle {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function start($battle_id) {
		$dir = BASE_DIR .'/storages/light/';

		$battle = json_read($dir .'battles/' . $battle_id)[DATA];
		for ($i=3; $i>=0; $i--) {
			if ($i == 0)
				$battle['battle_start_time'] = 'Battle Start!';
			else
				$battle['battle_start_time'] = $i;
			json_save($dir.'battles/', $battle_id, $battle, $minify=false);
			sleep(1);
		}

		$battle['battle_start_time'] = '';
		$battle['is_start'] = true;
		json_save($dir.'battles/', $battle_id, $battle, $minify=false);

		$g1_id = $battle['battle_member'][0];
		$g2_id = $battle['battle_member'][1];
		$g1 = json_read($dir .'guilds/' . $g1_id)[DATA];
		$g2 = json_read($dir .'guilds/' . $g2_id)[DATA];

		for ($i=0; $i<sizeof($g1['member']); $i++) {
			$p = json_read($dir .'players_status/' . $g1['member'][$i])[DATA];
			for ($j=0; $j<sizeof($g2['member']); $j++) {
				if (!arr_value_exist($p['enemies'], $g2['member'][$j]))
					array_push($p['enemies'], $g2['member'][$j]);
			}
			json_save($dir.'players_status/', $g1['member'][$i], $p, $minify=false);
		}

		for ($i=0;$i<sizeof($g2['member']); $i++) {
			$p = json_read($dir .'players_status/' . $g2['member'][$i])[DATA];
			for ($j=0;$j<sizeof($g1['member']); $j++) {
				if (!arr_value_exist($p['enemies'], $g1['member'][$j]))
					array_push($p['enemies'], $g1['member'][$j]);
			}
			json_save($dir.'players_status/', $g2['member'][$i], $p, $minify=false);
		}

		for ($i=0;$i<sizeof($g2['member']); $i++) {
			$p_id = $g2['member'][$i];
			$p = json_read($dir .'players_status/' . $p_id)[DATA];
			$p['battle_id'] = $battle_id;
			json_save($dir.'players_status/', $p_id, $p, $minify=false);
		}

		for ($i=20; $i>=0; $i--) {
			$battle = json_read($dir .'battles/' . $battle_id)[DATA];
			if ($battle['winner'] == '') {
				$battle['battle_time'] = $i;
				json_save($dir.'battles/', $battle_id, $battle, $minify=false);
				sleep(1);
			}
			else {
				break;
			}
		}

		if ($battle['winner'] == '')
			$battle['winner'] = 'The battle was draw between ' .$g1_id.' and '.$g2_id .'.';
		json_save($dir.'battles/', $battle_id, $battle, $minify=false);

		for ($i=0;$i<sizeof($g1['member']); $i++) {
			$p = json_read($dir .'players_status/' . $g1['member'][$i])[DATA];
			$p['enemies'] = [];
			$p['char_health']['current'] = $p['char_health']['max'];
			$p['char_stamina']['current'] = $p['char_stamina']['max'];
			json_save($dir.'players_status/', $g1['member'][$i], $p, $minify=false);
		}

		for ($i=0;$i<sizeof($g2['member']); $i++) {
			$p = json_read($dir .'players_status/' . $g2['member'][$i])[DATA];
			$p['enemies'] = [];
			$p['char_health']['current'] = $p['char_health']['max'];
			$p['char_stamina']['current'] = $p['char_stamina']['max'];
			json_save($dir.'players_status/', $g2['member'][$i], $p, $minify=false);
		}

		sleep(3);
		$this->delete_battle($battle_id);
	}

	public function delete_battle($duel_id) {
		$dir = BASE_DIR .'/storages/light/';
		$res = file_delete($dir . 'battles/'.$duel_id);
	}

	public function get_data($battle_id) {
		$dir = BASE_DIR .'/storages/light/';
		$battle = json_read($dir .'battles/' . $battle_id)[DATA];

		return json_encode($battle);
	}

	public function init($g1_id, $g2_id) {
		$dir = BASE_DIR .'/storages/light/';
		$g1 = json_read($dir .'guilds/' . $g1_id)[DATA];
		$g2 = json_read($dir .'guilds/' . $g2_id)[DATA];

		/* init battle file. */
		$date = new DateTime();
		$battle_id = md5($g1_id.$g2_id.$date->getTimestamp());

		$battle['battle_id'] = $battle_id;
		$battle['is_start'] = false;
		$battle['battle_time'] = 60;
		$battle['battle_start_time'] = 3;
		$battle['winner'] = '';
		$battle['battle_member'] = [];
		array_push($battle['battle_member'], $g1_id);
		array_push($battle['battle_member'], $g2_id);

		json_save($dir.'battles/', $battle_id, $battle, $minify=false);

		for ($i=0;$i<sizeof($g1['member']); $i++) {
			$p_id = $g1['member'][$i];
			$p = json_read($dir .'players_status/' . $p_id)[DATA];
			$p['battle_id'] = $battle_id;
			json_save($dir.'players_status/', $p_id, $p, $minify=false);
		}

		for ($i=0;$i<sizeof($g2['member']); $i++) {
			$p_id = $g2['member'][$i];
			$p = json_read($dir .'players_status/' . $p_id)[DATA];
			$p['battle_id'] = $battle_id;
			json_save($dir.'players_status/', $p_id, $p, $minify=false);
		}
		sleep(1);
		$this->start($battle_id);
	}

	public function ask_to_battle($char_id, $asked_char_id) {
		$dir = BASE_DIR .'/storages/light/';

		$asked_char_data = json_read($dir . 'players_status/'.$asked_char_id)[DATA];
		$char_data = json_read($dir . 'players_status/'.$char_id)[DATA];

		/* handle ask for guild confirmation */
		$date = new DateTime();
		$confirmation_id = md5($char_id.$asked_char_id.$date->getTimestamp());
		$json = arr_to_json(array(
			'confirmation_id' => $confirmation_id,
			'confirmation_type' => 'battle',
			'asked_to_guild' => $asked_char_data['char_guild'],
			'asked_by_guild' => $char_data['char_guild'],
			'asked_to' => $asked_char_id,
			'asked_by' => $char_id,
			'is_agreed' => ''
		));
		json_save($dir.'confirmations/', $confirmation_id, $json, $minify=false);

		/* handle asked char data	*/
		$asked_char_data['confirmation_id'] = $confirmation_id;
		json_save($dir.'players_status/', $asked_char_id, $asked_char_data, $minify=false);

		/* handle asking char data */
		$char_data['confirmation_id'] = $confirmation_id;
		json_save($dir.'players_status/', $char_id, $char_data, $minify=false);

		return true;
	}


	public function confirm_ask($confirmation_id, $is_agreed) {
		$dir = BASE_DIR .'/storages/light/';

		if ($is_agreed) {
			/* handle confirmation file */
			$confirmation_data = json_read($dir . 'confirmations/'.$confirmation_id)[DATA];
			$confirmation_data['is_agreed'] = true;
			json_save($dir.'confirmations/', $confirmation_id, $confirmation_data, $minify=false);

			/* handle asked player status */
			$asked_to_data = json_read($dir . 'players_status/'. $confirmation_data['asked_to'])[DATA];
			$asked_to_data['confirmation_id'] = '';
			json_save($dir.'players_status/', $asked_to_data['char_id'], $asked_to_data, $minify=false);
		} 
		else {
			/* handle confirmation file */
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

}
?>