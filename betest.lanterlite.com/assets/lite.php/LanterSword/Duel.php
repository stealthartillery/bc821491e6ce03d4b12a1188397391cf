<?php 

class Duel {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function confirm_ask($confirmation_id, $is_agreed) {

		if ($is_agreed) {
			/* handle confirmation file */
			$confirmation_data = json_read(dir. 'confirmations/'.$confirmation_id)[DATA];
			$confirmation_data['is_agreed'] = true;
			json_save(dir.'confirmations/', $confirmation_id, $confirmation_data, $minify=false);

			/* handle asked player status */
			set_player($confirmation_data['asked_to'], 'confirmation_id', '');
		}
		else {
			/* handle confirmation file */
			$confirmation_data = json_read(dir. 'confirmations/'.$confirmation_id)[DATA];
			$confirmation_data['is_agreed'] = false;
			json_save(dir.'confirmations/', $confirmation_id, $confirmation_data, $minify=false);

			/* handle asked player status */
			set_player($confirmation_data['asked_to'], 'confirmation_id', '');
		}

		return $confirmation_data;
	}

	public function start($duel_id) {
		$duel = json_read(dir.'duels/' . $duel_id)[DATA];
		for ($i=3; $i>=0; $i--) {
			if ($i == 0)
				$duel['duel_start_time'] = 'Duel Start!';
			else
				$duel['duel_start_time'] = $i;
			json_save(dir.'duels/', $duel_id, $duel, $minify=false);
			sleep(1);
		}

		$duel['duel_start_time'] = '';
		$duel['is_start'] = true;
		json_save(dir.'duels/', $duel_id, $duel, $minify=false);

		$p1_id = $duel['duel_member'][0];
		$p2_id = $duel['duel_member'][1];
		$p1_enemies = get_player($p1_id, 'enemies');
		$p2_enemies = get_player($p2_id, 'enemies');

		if (!arr_value_exist($p1_enemies, $p2_id))
			array_push($p1_enemies, $p2_id);
		if (!arr_value_exist($p2_enemies, $p1_id))
			array_push($p2_enemies, $p1_id);
		set_player($p1_id, 'enemies', $p1_enemies);
		set_player($p2_id, 'enemies', $p2_enemies);

		/* duel start in 20 seconds */
		$duel_time = 20;
		for ($i=$duel_time; $i>=0; $i--) {
			$duel = json_read(dir.'duels/' . $duel_id)[DATA];
			$p1_char_health = get_player($p1_id, 'char_health');
			$p2_char_health = get_player($p2_id, 'char_health');

			if ($p1_char_health['current'] <= 0) // if player 1 lose.
				$duel['winner'] = $p2_id . ' has won the duel between ' .$p1_id.' and '.$p2_id .'.';
			else if ($p2_char_health['current'] <= 0) // if player 2 lose.
				$duel['winner'] = $p1_id . ' has won the duel between ' .$p1_id.' and '.$p2_id .'.';

			if ($duel['winner'] == '') { // if there is still no winner.
				if ($i == 0) // if time is up.
					$duel['winner'] = 'The duel was draw between ' .$p1_id.' and '.$p2_id .'.';
				$duel['duel_time'] = $i;
				json_save(dir.'duels/', $duel_id, $duel, $minify=false);
				sleep(1);
			}
			else { // if there is a winner.
				break;
			}
		}

		sleep(3);

		/* recover back player health after duel */
		$p1_char_health['current'] = $p1_char_health['max'];
		$p2_char_health['current'] = $p2_char_health['max'];

		set_player($p1_id, 'char_health', $p1_char_health);
		set_player($p2_id, 'char_health', $p2_char_health);

		/* recover back player stamina after duel */
		$p1_char_stamina = get_player($p1_id, 'char_stamina');
		$p1_char_stamina['current'] = $p1['char_stamina']['max'];
		$p2_char_stamina = get_player($p2_id, 'char_stamina');
		$p2_char_stamina['current'] = $p2['char_stamina']['max'];

		set_player($p1_id, 'char_stamina', $p1_char_stamina);
		set_player($p2_id, 'char_stamina', $p2_char_stamina);

		/* remove enemies from player */
		$p1_enemies = arr_value_remove_by_value($p1_enemies, $p2_id);
		$p2_enemies = arr_value_remove_by_value($p2_enemies, $p1_id);

		set_player($p1_id, 'enemies', $p1_enemies);
		set_player($p2_id, 'enemies', $p2_enemies);

		$this->delete_duel($duel_id);
	}

	public function get_duel($duel_id) {
		$duel = json_read(dir.'duels/' . $duel_id)[DATA];

		return json_encode($duel);
	}

	public function delete_duel($duel_id) {
		$res = file_delete(dir. 'duels/'.$duel_id);
	}

	public function init($p1_id, $p2_id) {

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

		json_save(dir.'duels/', $duel_id, $duel, $minify=false);

		set_player($p1_id, 'duel_id', $duel_id);
		set_player($p2_id, 'duel_id', $duel_id);
	}

	public function ask_to_duel($char_id, $asked_char_id) {

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
		json_save(dir.'confirmations/', $confirmation_id, $json, $minify=false);

		/* set confirmation id to asked char */
		set_player($asked_char_id, 'confirmation_id', $confirmation_id);

		/* set confirmation id to asking char */
		set_player($char_id, 'confirmation_id', $confirmation_id);

		return true;
	}

}
?>