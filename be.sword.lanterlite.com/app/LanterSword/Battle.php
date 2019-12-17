<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Battle {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function is_guild_lose($guild_id) {
		$total_died = 0;
		$guild = LGen('JsonMan')->read(dir.'guilds/' . $guild_id);
		for ($i=0; $i<sizeof($guild['member']); $i++) {
			$health_cur = get_player($guild['member'][$i], 'health_cur');
			if ($health_cur <= 0)
				$total_died += 1;
		}
		if ($total_died == sizeof($guild['member']))
			return true;
		else
			return false;
	}

	public function start($battle_id) {

		$battle = LGen('JsonMan')->read(dir.'battles/' . $battle_id);
		for ($i=3; $i>=0; $i--) {
			if ($i == 0)
				$battle['battle_start_time'] = 'Battle Start!';
			else
				$battle['battle_start_time'] = $i;
			LGen('JsonMan')->save(dir.'battles/', $battle_id, $battle, $minify=false);
			sleep(1);
		}

		$battle['battle_start_time'] = '';
		$battle['is_start'] = true;
		LGen('JsonMan')->save(dir.'battles/', $battle_id, $battle, $minify=false);

		$g1_id = $battle['battle_member'][0];
		$g2_id = $battle['battle_member'][1];
		$g1 = LGen('JsonMan')->read(dir.'guilds/' . $g1_id);
		$g2 = LGen('JsonMan')->read(dir.'guilds/' . $g2_id);

		/* assign enemies to all members on opposite guilds */
		for ($i=0; $i<sizeof($g1['member']); $i++) {
			$p_enemies = get_player($g1['member'][$i], 'enemies');
			for ($j=0; $j<sizeof($g2['member']); $j++) {
				if (!LGen('ArrayMan')->is_val_exist($p_enemies, $g2['member'][$j]))
					array_push($p_enemies, $g2['member'][$j]);
			}
			set_player($g1['member'][$i], 'enemies', $p_enemies);
		}

		for ($i=0; $i<sizeof($g2['member']); $i++) {
			$p_enemies = get_player($g2['member'][$i], 'enemies');
			for ($j=0; $j<sizeof($g1['member']); $j++) {
				if (!LGen('ArrayMan')->is_val_exist($p_enemies, $g1['member'][$j]))
					array_push($p_enemies, $g1['member'][$j]);
			}
			set_player($g2['member'][$i], 'enemies', $p_enemies);
		}

		for ($i=20; $i>=0; $i--) {
			$battle = LGen('JsonMan')->read(dir.'battles/' . $battle_id);
			if ($this->is_guild_lose($g1_id))
				$battle['winner'] = $g2_id;
			else if ($this->is_guild_lose($g2_id))
				$battle['winner'] = $g1_id;
			if ($battle['winner'] == '') {
				$battle['battle_time'] = $i;
				LGen('JsonMan')->save(dir.'battles/', $battle_id, $battle, $minify=false);
				sleep(1);
			}
			else {
				break;
			}
		}

		sleep(3);

		if ($battle['winner'] == '')
			$battle['winner'] = 'The battle was draw between ' .$g1_id.' and '.$g2_id .'.';
		else if ($battle['winner'] == $g1_id)
			$battle['winner'] = $g1_id . ' guild has won the battle between ' .$g1_id.' guild and '.$g2_id .' guild.';
		else if ($battle['winner'] == $g2_id)
			$battle['winner'] = $g2_id . ' guild has won the battle between ' .$g1_id.' guild and '.$g2_id .' guild.';

		/* announce the winner to all players in the map/ */
		$map = new Map();
		$map_players = $map->get_data(get_player($g1['leader'], 'map_id'), 'players', $encoded=false);
		for ($i=0; $i< sizeof($map_players); $i++) {
			set_player($map_players[$i], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $battle['winner']))));
			// set_player($map_players[$i], 'system_chat', $battle['winner']);
		}

		/* recover health to all guild members */
		for ($i=0;$i<sizeof($g1['member']); $i++) {
			$health_max = get_player($g1['member'][$i], 'health_max');
			$health_cur = get_player($g2['member'][$i], 'health_cur');
			$health_cur = $health_max; 

			$stamina_max = get_player($g1['member'][$i], 'stamina_max');
			$stamina_cur = get_player($g1['member'][$i], 'stamina_cur');
			$stamina_cur = $stamina_max; 

			set_player($g1['member'][$i], 'enemies', []);
			set_player($g1['member'][$i], 'health_cur', $health_cur);
			set_player($g1['member'][$i], 'stamina_cur', $stamina_cur);
		}

		/* recover stamina to all guild members */
		for ($i=0;$i<sizeof($g2['member']); $i++) {
			$health_max = get_player($g2['member'][$i], 'health_max');
			$health_cur = get_player($g2['member'][$i], 'health_cur');
			$health_cur = $health_max; 

			$stamina_max = get_player($g1['member'][$i], 'stamina_max');
			$stamina_cur = get_player($g1['member'][$i], 'stamina_cur');
			$stamina_cur = $stamina_max; 

			set_player($g2['member'][$i], 'enemies', []);
			set_player($g2['member'][$i], 'health_cur', $health_cur);
			set_player($g2['member'][$i], 'stamina_cur', $stamina_cur);
		}

		sleep(3);
		$this->delete_battle($battle_id);
	}

	public function delete_battle($duel_id) {
		$res = file_delete(dir. 'battles/'.$duel_id);
	}

	public function get_data($battle_id) {
		$battle = LGen('JsonMan')->read(dir.'battles/' . $battle_id);
		return ($battle);
	}

	public function init($g1_id, $g2_id) {

		/* init battle file. */
		$battle_id = create_id($g1_id.$g2_id);
		$battle['battle_id'] = $battle_id;
		$battle['is_start'] = false;
		$battle['battle_time'] = 60;
		$battle['battle_start_time'] = 3;
		$battle['winner'] = '';
		$battle['battle_member'] = [];

		array_push($battle['battle_member'], $g1_id);
		array_push($battle['battle_member'], $g2_id);

		LGen('JsonMan')->save(dir.'battles/', $battle_id, $battle, $minify=false);

		$g1 = LGen('JsonMan')->read(dir.'guilds/' . $g1_id);
		$g2 = LGen('JsonMan')->read(dir.'guilds/' . $g2_id);

		/* set battle id to all guild 1 member */
		for ($i=0;$i<sizeof($g1['member']); $i++) {
			set_player($g1['member'][$i], 'battle_id' , $battle_id);
		}

		/* set battle id to all guild 2 member */
		for ($i=0;$i<sizeof($g2['member']); $i++) {
			set_player($g2['member'][$i], 'battle_id' , $battle_id);
		}

		sleep(1);
		$this->start($battle_id);
	}

	public function ask_to_battle($char_id, $asked_char_id) {

		$asked_char_guild = get_player($asked_char_id, 'char_guild');
		$asking_char_guild = get_player($char_id, 'char_guild');

		$confirmation_id = create_id($char_id.$asked_char_id);
		$json = LGen('ArrayMan')->to_json(array(
			'confirmation_id' => $confirmation_id,
			'confirmation_type' => 'battle',
			'asked_to_guild' => $asked_char_guild,
			'asked_by_guild' => $asking_char_guild,
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


	public function confirm_ask($confirmation_id, $is_agreed) {

		$confirmation_data = LGen('JsonMan')->read(dir. 'confirmations/'.$confirmation_id);
		if ($is_agreed) {
			$info = $confirmation_data['asked_to_guild'] . ' guild has accepted to battle';
			set_player($confirmation_data['asked_by'], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $info))));
			// set_player($confirmation_data['asked_by'], 'system_chat', $info);
			$info = 'You have accepted to battle with '. $confirmation_data['asked_by_guild']. ' guild';
			set_player($confirmation_data['asked_to'], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $info))));
			// set_player($confirmation_data['asked_to'], 'system_chat', $info);
		}
		else {
			$info = $confirmation_data['asked_to_guild'] . ' guild has rejected to battle';
			set_player($confirmation_data['asked_by'], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $info))));
			// set_player($confirmation_data['asked_by'], 'system_chat', $info);
			$info = 'You have rejected to battle with '. $confirmation_data['asked_by_guild']. ' guild';
			set_player($confirmation_data['asked_to'], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $info))));
			// set_player($confirmation_data['asked_to'], 'system_chat', $info);
		}

		file_delete(dir. 'confirmations/'.$confirmation_id);
		set_player($confirmation_data['asked_to'], 'confirmation_id', '');
		set_player($confirmation_data['asked_by'], 'confirmation_id', '');

		if ($is_agreed)
			$this->init($confirmation_data['asked_by_guild'], $confirmation_data['asked_to_guild']);
		return true;
	}
}
?>