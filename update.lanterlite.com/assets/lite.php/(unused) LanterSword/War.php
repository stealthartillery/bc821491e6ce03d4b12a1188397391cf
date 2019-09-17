<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

Class War {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function start($war_id) {
		$dir = BASE_DIR .'/storages/light/';
		$war = json_read($dir .'wars/' . $war_id)[DATA];
		for ($i=3; $i>=0; $i--) {
			if ($i == 0)
				$war['war_start_time'] = 'War Start!';
			else
				$war['war_start_time'] = $i;
			json_save($dir.'wars/', $war_id, $war, $minify=false);
			sleep(1);
		}

		$war['war_start_time'] = '';
		$war['is_start'] = true;
		json_save($dir.'wars/', $war_id, $war, $minify=false);

		$g1_id = $war['war_member'][0];
		$g2_id = $war['war_member'][1];
		$g1 = json_read($dir .'players_status/' . $g1_id)[DATA];
		$g2 = json_read($dir .'players_status/' . $g2_id)[DATA];

		// $p1_health = $p1['char_health'];
		// $p1_stamina = $p1['char_stamina'];

		// $p2_health = $p2['char_health'];
		// $p2_stamina = $p2['char_stamina'];

		for ($i=0;$i<sizeof($g1['member']); $i++) {
			$p = json_read($dir .'players_status/' . $g1['member'][$i])[DATA];
			for ($j=0;$j<sizeof($g2['member']); $j++) {
				array_push($p['enemies'], $g2['member'][$j]);
			}
			json_save($dir.'players_status/', $g1['member'][$i], $p, $minify=false);
		}

		for ($i=0;$i<sizeof($g2['member']); $i++) {
			$p = json_read($dir .'players_status/' . $g2['member'][$i])[DATA];
			for ($j=0;$j<sizeof($g1['member']); $j++) {
				array_push($p['enemies'], $g1['member'][$j]);
			}
			json_save($dir.'players_status/', $g2['member'][$i], $p, $minify=false);
		}

		// $p_id = $g1['leader'];
		// $p = json_read($dir .'players_status/' . $p_id)[DATA];
		// $p['war_id'] = $war_id;
		// json_save($dir.'players_status/', $p_id, $p, $minify=false);

		for ($i=0;$i<sizeof($g2['member']); $i++) {
			$p_id = $g2['member'][$i];
			$p = json_read($dir .'players_status/' . $p_id)[DATA];
			$p['war_id'] = $war_id;
			json_save($dir.'players_status/', $p_id, $p, $minify=false);
		}
		// $p_id = $g2['leader'];
		// $p = json_read($dir .'players_status/' . $p_id)[DATA];
		// $p['war_id'] = $war_id;
		// json_save($dir.'players_status/', $p_id, $p, $minify=false);


		// if (!arr_value_exist($p1['enemies'], $p2_id))
		// 	array_push($p1['enemies'], $p2_id);
		// if (!arr_value_exist($p2['enemies'], $p1_id))
		// 	array_push($p2['enemies'], $p1_id);
		// json_save($dir.'players_status/', $p1_id, $p1, $minify=false);
		// json_save($dir.'players_status/', $p2_id, $p2, $minify=false);

		for ($i=20; $i>=0; $i--) {
			$war = json_read($dir .'wars/' . $war_id)[DATA];
			// $p1 = json_read($dir .'players_status/' . $p1_id)[DATA];
			// $p2 = json_read($dir .'players_status/' . $p2_id)[DATA];
			// if ($p1['char_health']['current'] <= 0)
			// 	$war['winner'] = $p2_id . ' has won the war between ' .$p1_id.' and '.$p2_id .'.';
			// else if ($p2['char_health']['current'] <= 0) 
			// 	$war['winner'] = $p1_id . ' has won the war between ' .$p1_id.' and '.$p2_id .'.';
			if ($war['winner'] == '') {
				$war['war_time'] = $i;
				json_save($dir.'wars/', $war_id, $war, $minify=false);
				sleep(1);
			}
			else {
				break;
			}
		}

		if ($war['winner'] == '')
			$war['winner'] = 'The war was draw between ' .$p1_id.' and '.$p2_id .'.';
		json_save($dir.'wars/', $war_id, $war, $minify=false);

		// $p1['char_health'] = $p1_health;
		// $p1['char_stamina'] = $p1_stamina;
		// $p2['char_health'] = $p2_health;
		// $p2['char_stamina'] = $p2_stamina;

		// $p1['enemies'] = arr_value_remove_by_value($p1['enemies'], $p2_id);
		// $p2['enemies'] = arr_value_remove_by_value($p2['enemies'], $p1_id);

		// json_save($dir.'players_status/', $p1_id, $p1, $minify=false);
		// json_save($dir.'players_status/', $p2_id, $p2, $minify=false);

		for ($i=0;$i<sizeof($g1['member']); $i++) {
			$p = json_read($dir .'players_status/' . $g1['member'][$i])[DATA];
			$p['enemies'] = [];
			json_save($dir.'players_status/', $g1['member'][$i], $p, $minify=false);
		}

		for ($i=0;$i<sizeof($g2['member']); $i++) {
			$p = json_read($dir .'players_status/' . $g2['member'][$i])[DATA];
			$p['enemies'] = [];
			json_save($dir.'players_status/', $g2['member'][$i], $p, $minify=false);
		}

		sleep(3);
		$this->delete_war($war_id);
	}

	public function get_data($war_id) {
		$dir = BASE_DIR .'/storages/light/';
		$war = json_read($dir .'wars/' . $war_id)[DATA];

		return json_encode($war);
	}

	public function init($g1_id, $g2_id) {
		$dir = BASE_DIR .'/storages/light/';
		$g1 = json_read($dir .'guilds/' . $g1_id)[DATA];
		$g2 = json_read($dir .'guilds/' . $g2_id)[DATA];

		/* init war file. */
		$date = new DateTime();
		$war_id = md5($g1_id.$g2_id.$date->getTimestamp());

		$war['war_id'] = $war_id;
		$war['is_start'] = false;
		$war['war_time'] = 60;
		$war['war_start_time'] = 3;
		$war['winner'] = '';
		$war['war_member'] = [];
		array_push($war['war_member'], $g1_id);
		array_push($war['war_member'], $g2_id);

		json_save($dir.'wars/', $war_id, $war, $minify=false);

		for ($i=0;$i<sizeof($g1['member']); $i++) {
			$p_id = $g1['member'][$i];
			$p = json_read($dir .'players_status/' . $p_id)[DATA];
			$p['war_id'] = $war_id;
			json_save($dir.'players_status/', $p_id, $p, $minify=false);
		}

		for ($i=0;$i<sizeof($g2['member']); $i++) {
			$p_id = $g2['member'][$i];
			$p = json_read($dir .'players_status/' . $p_id)[DATA];
			$p['war_id'] = $war_id;
			json_save($dir.'players_status/', $p_id, $p, $minify=false);
		}
	}

	public function ask_to_war($char_id, $asked_char_id) {
		$dir = BASE_DIR .'/storages/light/';

		$asked_char_data = json_read($dir . 'players_status/'.$asked_char_id)[DATA];
		$char_data = json_read($dir . 'players_status/'.$char_id)[DATA];

		/* handle ask for guild confirmation */
		$date = new DateTime();
		$confirmation_id = md5($char_id.$asked_char_id.$date->getTimestamp());
		$json = arr_to_json(array(
			'confirmation_id' => $confirmation_id,
			'confirmation_type' => 'war',
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