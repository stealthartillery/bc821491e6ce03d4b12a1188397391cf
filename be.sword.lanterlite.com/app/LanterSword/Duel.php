<?php 

class Duel {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function asd() {
		// set_player('IfanDhani', 'system_chat', '$map_players[0]');
		// set_player($p2_id, 'system_chat', '$map_players[0]');

		// $map = new Map();
		// $map_players = $map->get_data(get_player('IfanDhani', 'map_id'), 'players', $encoded=false);
		// return $map_players[0];
	}

	public function confirm_ask($confirmation_id, $is_agreed) {

		$confirmation_data = LGen('JsonMan')->read(dir. 'confirmations/'.$confirmation_id);
		if ($is_agreed) {
			$info = $confirmation_data['asked_to'] . ' has accepted to duel';
			set_player($confirmation_data['asked_by'], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $info))));
			// set_player($confirmation_data['asked_by'], 'system_chat', $info);
			$info = 'You have accepted to duel';
			set_player($confirmation_data['asked_to'], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $info))));
			// set_player($confirmation_data['asked_to'], 'system_chat', $info);
		}
		else {
			$info = $confirmation_data['asked_to'] . ' has rejected to duel';
			set_player($confirmation_data['asked_by'], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $info))));
			// set_player($confirmation_data['asked_by'], 'system_chat', $info);
			$info = 'You have rejected to duel';
			set_player($confirmation_data['asked_to'], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $info))));
			// set_player($confirmation_data['asked_to'], 'system_chat', $info);
		}

		file_delete(dir. 'confirmations/'.$confirmation_id);
		set_player($confirmation_data['asked_to'], 'confirmation_id', '');
		set_player($confirmation_data['asked_by'], 'confirmation_id', '');

		if ($is_agreed)
			$this->init($confirmation_data['asked_by'], $confirmation_data['asked_to']);
		return true;
	}

	public function start($duel_id) {
		$duel = LGen('JsonMan')->read(dir.'duels/' . $duel_id);
		for ($i=3; $i>=0; $i--) {
			if ($i == 0)
				$duel['duel_start_time'] = 'Duel Start!';
			else
				$duel['duel_start_time'] = $i;
			LGen('JsonMan')->save(dir.'duels/', $duel_id, $duel, $minify=false);
			sleep(1);
		}

		$duel['duel_start_time'] = '';
		$duel['is_start'] = true;
		LGen('JsonMan')->save(dir.'duels/', $duel_id, $duel, $minify=false);

		$p1_id = $duel['duel_member'][0];
		$p2_id = $duel['duel_member'][1];
		$p1_enemies = get_player($p1_id, 'enemies');
		$p2_enemies = get_player($p2_id, 'enemies');

		if (!LGen('ArrayMan')->is_val_exist($p1_enemies, $p2_id))
			array_push($p1_enemies, $p2_id);
		if (!LGen('ArrayMan')->is_val_exist($p2_enemies, $p1_id))
			array_push($p2_enemies, $p1_id);
		set_player($p1_id, 'enemies', $p1_enemies);
		set_player($p2_id, 'enemies', $p2_enemies);

		/* duel start in 20 seconds */
		$duel_time = 20;
		for ($i=$duel_time; $i>=0; $i--) {

			$duel = LGen('JsonMan')->read(dir.'duels/' . $duel_id);
			$p1_char_health_cur = get_player($p1_id, 'health_cur');
			$p2_char_health_cur = get_player($p2_id, 'health_cur');

			if ($p1_char_health_cur <= 0) {// if player 1 lose.
				$duel['winner'] = $p2_id . ' has won the duel between ' .$p1_id.' and '.$p2_id .'.';
			}
			else if ($p2_char_health_cur <= 0) { // if player 2 lose.
				$duel['winner'] = $p1_id . ' has won the duel between ' .$p1_id.' and '.$p2_id .'.';
			}
			if ($duel['winner'] == '') { // if there is still no winner.
				if ($i == 0) // if time is up.
					$duel['winner'] = 'The duel was draw between ' .$p1_id.' and '.$p2_id .'.';
				$duel['duel_time'] = $i;
				LGen('JsonMan')->save(dir.'duels/', $duel_id, $duel, $minify=false);
				sleep(1);
			}
			else { // if there is a winner.
				break;
			}
		}

		sleep(3);

		/* announce the winner to all players in the map/ */
		$map = new Map();
		$map_players = $map->get_data(get_player($p1_id, 'map_id'), 'players', $encoded=false);
		for ($i=0; $i< sizeof($map_players); $i++) {
			set_player($map_players[$i], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $duel['winner']))));
			// set_player($map_players[$i], 'system_chat', $duel['winner']);
		}

		/* recover back player health after duel */
		$p1_char_health_max = get_player($p1_id, 'health_max');
		$p2_char_health_max = get_player($p2_id, 'health_max');
		$p1_char_health_cur = $p1_char_health_max;
		$p2_char_health_cur = $p2_char_health_max;

		set_player($p1_id, 'health_cur', $p1_char_health_cur);
		set_player($p2_id, 'health_cur', $p2_char_health_cur);

		/* recover back player stamina after duel */
		$p1_char_stamina_cur = get_player($p1_id, 'stamina_cur');
		$p1_char_stamina_max = get_player($p1_id, 'stamina_max');
		$p1_char_stamina_cur = $p1_char_stamina_max;

		$p2_char_stamina_cur = get_player($p2_id, 'stamina_cur');
		$p2_char_stamina_max = get_player($p2_id, 'stamina_max');
		$p2_char_stamina_cur = $p2_char_stamina_max;

		set_player($p1_id, 'stamina_cur', $p1_char_stamina_cur);
		set_player($p2_id, 'stamina_cur', $p2_char_stamina_cur);

		/* remove enemies from player */
		$p1_enemies = LGen('ArrayMan')->rmv_by_val($p1_enemies, $p2_id);
		$p2_enemies = LGen('ArrayMan')->rmv_by_val($p2_enemies, $p1_id);

		set_player($p1_id, 'enemies', $p1_enemies);
		set_player($p2_id, 'enemies', $p2_enemies);

		$this->delete_duel($duel_id);
	}

	public function get_data($duel_id) {
		$duel = LGen('JsonMan')->read(dir.'duels/' . $duel_id);
		return ($duel);
	}

	public function delete_duel($duel_id) {
		$res = file_delete(dir. 'duels/'.$duel_id);
	}

	public function init($p1_id, $p2_id) {

		error_log('asd1');
		/* init duel file. */
		$duel_id = create_id($p1_id.$p2_id);
		$duel['duel_id'] = $duel_id;
		$duel['is_start'] = false;
		$duel['duel_time'] = 60;
		$duel['duel_start_time'] = 3;
		$duel['winner'] = '';
		$duel['duel_member'] = [];

		array_push($duel['duel_member'], $p1_id);
		array_push($duel['duel_member'], $p2_id);

		LGen('JsonMan')->save(dir.'duels/', $duel_id, $duel, $minify=false);

		set_player($p1_id, 'duel_id', $duel_id);
		set_player($p2_id, 'duel_id', $duel_id);

		sleep(1);
		error_log('asd2');
		$this->start($duel_id);
	}

	public function ask_to_duel($char_id, $asked_char_id) {

		$confirmation_id = create_id($char_id.$asked_char_id);
		$json = LGen('ArrayMan')->to_json(array(
			'confirmation_id' => $confirmation_id,
			'confirmation_type' => 'duel',
			'asked_to' => $asked_char_id,
			'asked_by' => $char_id,
			'is_agreed' => ''
		));
		LGen('JsonMan')->save(dir.'confirmations/', $confirmation_id, $json, $minify=false);

		set_player($asked_char_id, 'confirmation_id', $confirmation_id);
		set_player($char_id, 'confirmation_id', $confirmation_id);

		add_tasklist($asked_char_id, 'confirmation_get_data');
		add_tasklist($char_id, 'confirmation_get_data');

		return true;
	}

}
?>