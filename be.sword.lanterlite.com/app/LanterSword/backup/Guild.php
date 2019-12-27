<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Guild {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function confirm_ask($confirmation_id, $is_agreed) {

		$confirmation_data = LGen('JsonMan')->read(dir. 'confirmations/'.$confirmation_id);
		if ($is_agreed) {
			/* add char id to guild */
			$guild = LGen('JsonMan')->read(dir. 'guilds/'.$confirmation_data['guild_id']);
			array_push($guild['member'], $confirmation_data['asked_to']);
			LGen('JsonMan')->save(dir.'guilds/', $confirmation_data['guild_id'], $guild, $minify=false);
			set_player($confirmation_data['asked_to'], 'char_guild', $confirmation_data['guild_id']);

			/* inform all guild members */
			$info = $confirmation_data['asked_to'] . ' has become guild member.';
			for($i=0; $i<sizeof($guild['member']); $i++) {
				// set_player($guild['member'][$i], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $info))));
				add_to_system_chat($guild['member'][$i], LGen('ArrayMan')->to_json(array(
					'type' => 'yellow','text' => $info
				)));
				// set_player($guild['member'][$i], 'system_chat', $info);
			}
		} 
		else {
			$info = $confirmation_data['asked_to'] . ' has rejected to join guild.';
				// set_player($confirmation_data['asked_by'], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $info))));
				add_to_system_chat($confirmation_data['asked_by'], LGen('ArrayMan')->to_json(array(
					'type' => 'yellow','text' => $info
				)));
			// set_player($confirmation_data['asked_by'], 'system_chat', $info);
			$info = 'You have rejected to join guild.';
				// set_player($guidconfirmation_data['asked_to'], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $info))));
				add_to_system_chat($confirmation_data['asked_to'], LGen('ArrayMan')->to_json(array(
					'type' => 'yellow','text' => $info
				)));
			// set_player($confirmation_data['asked_to'], 'system_chat', $info);
		}

		/* remove confirm id */
		set_player($confirmation_data['asked_to'], 'confirmation_id', '');
		set_player($confirmation_data['asked_by'], 'confirmation_id', '');
		file_delete(dir. 'confirmations/'.$confirmation_id);

		// add_tasklist($confirmation_data['asked_by'], 'confirmation_get_data');

		return $confirmation_data;
	}

	public function ask_to_join($char_id, $asked_char_id, $guild_id) {
		/* handle ask for guild confirmation */
		$confirmation_id = create_id($char_id.$asked_char_id);
		$json = LGen('ArrayMan')->to_json(array(
			'confirmation_id' => $confirmation_id,
			'confirmation_type' => 'guild_recruitment',
			'guild_id' => $guild_id,
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

	public function create_guild($char_id, $guild_id) {
		$gold = get_player($char_id, 'gold');
		if ($gold < 1000) {
			return 'Insufficient gold.';
		}

		if (LGen('JsonMan')->read(dir. 'guilds/'.$guild_id) === LGen('GlobVar')->failed) {
			$guild = LGen('JsonMan')->read(dir. 'guilds/default');
			$guild['guild_id'] = $guild_id;
			$guild['leader'] = $char_id;
			array_push($guild['member'], $char_id);

			// $pearl = get_player($char_id, 'pearl')-1;
			// set_player($char_id, 'pearl', $pearl);
			$gold = $gold-1000;
			set_player($char_id, 'gold', $gold);

			LGen('JsonMan')->save(dir. 'guilds/', $guild_id, $guild);
			set_player($char_id, 'char_guild', $guild_id);
			add_to_system_chat($char_id, LGen('ArrayMan')->to_json(array(
				'type' => 'green',
				'text' => $guild_id.' Guild created!'
			)));
			return 1;
		}
		else {
			return 'Guild name is unavailable';
		}
	
		// for($i=0; $i<sizeof($guild['member']); $i++) {
		// 	set_player($guild['member'][$i], 'char_guild', '');
		// 	// set_player($guild['member'][$i], 'system_chat', 'You are removed from Guild because Guild has been disbanded.');
		// 	set_player($guild['member'][$i], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => 'You are removed from Guild because Guild has been disbanded.'))));
		// }
		// file_delete(dir. 'guilds/'.$guild_id);
		// return true;
	}

	public function disband_guild($guild_id) {
		$guild = LGen('JsonMan')->read(dir. 'guilds/'.$guild_id);
		for($i=0; $i<sizeof($guild['member']); $i++) {
			set_player($guild['member'][$i], 'char_guild', '');
			// set_player($guild['member'][$i], 'system_chat', 'You are removed from Guild because Guild has been disbanded.');
			// set_player($guild['member'][$i], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => 'You are removed from Guild because Guild has been disbanded.'))));
			add_to_system_chat($guild['member'][$i], LGen('ArrayMan')->to_json(array(
				'type' => 'yellow',
				'text' => 'You are removed from Guild because Guild has been disbanded.'
			)));

		}
		file_delete(dir. 'guilds/'.$guild_id);
		return true;
	}

	public function leave_guild($guild_id, $player_id) {
		$guild = LGen('JsonMan')->read(dir. 'guilds/'.$guild_id);
		set_player($player_id, 'char_guild', '');
		$guild['member'] = LGen('ArrayMan')->rmv_by_val($guild['member'], $player_id);
		LGen('JsonMan')->save(dir.'guilds/', $guild_id, $guild, $minify=false);
		for($i=0; $i<sizeof($guild['member']); $i++) {
			add_tasklist($guild['member'][$i], 'guild_get_data');
			// set_player($guild['member'][$i], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $player_id.' left the guild.'))));
			add_to_system_chat($guild['member'][$i], LGen('ArrayMan')->to_json(array(
				'type' => 'yellow','text' => $player_id.' left the guild.'
			)));
			// set_player($guild['member'][$i], 'system_chat', $player_id.' left the guild.');
		}

		add_to_system_chat($player_id, LGen('ArrayMan')->to_json(array(
			'type' => 'yellow','text' => 'You left the guild.'
		)));
		return true;
	}

	public function remove_member($guild_id, $player_id) {
		$guild = LGen('JsonMan')->read(dir. 'guilds/'.$guild_id);
		set_player($player_id, 'char_guild', '');
		$guild['member'] = LGen('ArrayMan')->rmv_by_val($guild['member'], $player_id);
		LGen('JsonMan')->save(dir.'guilds/', $guild_id, $guild, $minify=false);
		for($i=0; $i<sizeof($guild['member']); $i++) {
			add_tasklist($guild['member'][$i], 'guild_get_data');
			// set_player($guild['member'][$i], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $player_id.' was removed from guild.'))));
			add_to_system_chat($guild['member'][$i], LGen('ArrayMan')->to_json(array(
				'type' => 'yellow','text' => $player_id.' was removed from guild.'
			)));
			// set_player($guild['member'][$i], 'system_chat', $player_id.' was removed from guild.');
		}
		add_to_system_chat($player_id, LGen('ArrayMan')->to_json(array(
			'type' => 'yellow','text' => 'You are removed from guild.'
		)));
		return true;
	}

	public function get_info($player_id) {
		$guild_id = get_player($player_id, 'char_guild');
		$guild = LGen('JsonMan')->read(dir. 'guilds/'.$guild_id);
		return $guild;
		// return json_encode($guild);
	}

	public function get_data($player_id, $slot_group_num) {
		$p1['char_guild'] = get_player($player_id, 'char_guild');
		$p1['active_date'] = get_player($player_id, 'active_date');
		$guild = LGen('JsonMan')->read(dir. 'guilds/'.$p1['char_guild']);

		$from = $slot_group_num*10;
		$to = $from+10;

		/* no user selected */
		// if (sizeof($guild['guild'] < $from) {
		// 	$result['online'] = [];
		// 	$result['guild'] = [];
		// 	return json_encode($result);
		// }

		$result['guild_id'] = $guild['guild_id'];
		$result['leader'] = $guild['leader'];
		$result['member'] = [];
		$result['online'] = [];

		for ($i=$from; $i<$to; $i++) {
			if (LGen('ArrayMan')->is_index_exist($guild['member'], $i)) {
				$p2['active_date'] = get_player($guild['member'][$i], 'active_date');
				
				array_push($result['member'], $guild['member'][$i]);
				// $start_date = strtotime($p1['active_date']); 
				// $end_date = strtotime('2019-07-04 18:20:20'); 
				// // $end_date = strtotime($p2['active_date']); 
				// $diff = ($end_date - $start_date);
				// // $diff = ($end_date - $start_date);
				// array_push($guild['online'], $diff->format('H:i:s'));

				// $time_end = $this->L->microtime_float();
				// $time = (string)($time_end - $time_start);
				// $time = substr($time, 0, 4);
			
				$start_date = ($p2['active_date']); 
				$end_date = ($p1['active_date']); 
				$time = ($end_date - $start_date);
				// $time = substr($time, 0, 4);
				if ($time < 1)
					$res = 'on';
				else
					$res = 'off';
				array_push($result['online'], $res);
			}
			else {
				array_push($result['member'], "-");
				array_push($result['online'], 'none');
			}
		}
		return $result;
	}
}

?>