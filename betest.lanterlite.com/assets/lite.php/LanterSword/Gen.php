<?php if (!defined('BASEPATH')) exit('no direct script access allowed');



// function health_increase_temp($player_id) {
// // 	$player_status = json_read(dir.'players_status/'. $player_id)[DATA];
// 	$increasable = true;
// 	if ($player_status['battle_id'] != '' and $player_status['char_health']['current'] <= 0) {
// 		$increasable = false;
// 	}

// 	if ($increasable and !$player_status['is_health_increasing']) {
// 		while ($player_status['char_health']['current'] < $player_status['char_health']['max']) {
// 			$player_status = json_read(dir.'players_status/'. $player_id)[DATA];
// 			$player_status['is_health_increasing'] = true;

// 			/* if player not lose in duel or battle, increase. */
// 			if ($player_status['battle_id'] == '' or $player_status['duel_id'] == '') {
// 				if ($player_status['char_health']['current'] == 0) {
// 					$player_status = increase_health($player_status, 25);
// 					if ($player_status['char_health']['current'] >= $player_status['char_health']['max'])
// 						$player_status['is_health_increasing'] = false;
// 					json_save(dir, 'players_status/'.$player_id, $player_status, $minify=false);
// 				}
// 			}
// 			sleep(2);
// 		}
// 	}
// }


/* How to Use */
// $res = get_distance(get_difference($p2['x'], $p1['x']), get_difference($p2['y'], $p1['y']));
function get_distance($x, $y) {
	return sqrt(($x*$x)+($y*$y));
}

function get_difference ($a, $b) { 
	return abs($a - $b); 
}

function create_id($unique_code='asd') {
	$date = new DateTime();
	$id = md5($unique_code.$date->getTimestamp());
	return $id;
}

function health_increase($player_id) {
	$player_status = get_player($player_id);
	$increasable = true;
	// if ($player_status['battle_id'] != '' and $player_status['char_health']['current'] <= 0) {
	// 	$increasable = false;
	// }

	if ($player_status['battle_id'] != '' or $player_status['duel_id'] != '') {
		if ($player_status['char_health']['current'] <= 0) {
			$increasable = false;
		}
	}

	if ($increasable and !$player_status['is_health_increasing']) {
		while ($player_status['char_health']['current'] < $player_status['char_health']['max']) {
			$player_status = get_player($player_id);
			$player_status['is_health_increasing'] = true;

			if ($player_status['battle_id'] == '' or $player_status['duel_id'] == '') {
				if ($player_status['char_health']['current'] > 0) {
					$player_status = increase_health($player_status, 25);
					if ($player_status['char_health']['current'] >= $player_status['char_health']['max'])
						$player_status['is_health_increasing'] = false;
				}
			}
			set_player($player_id, 'is_health_increasing', $player_status['is_health_increasing']);
			// json_save(dir, 'players_status/'.$player_id, $player_status, $minify=false);
			sleep(2);
		}
	}
}

function stamina_changed($player_id) {
	write_log('sword', 'asd');
	$player_status = get_player($player_id);
	$increasable = true;

	/* if player is in battle and dead, dont increase */
	if ($player_status['battle_id'] != '' and $player_status['char_health']['current'] <= 0) {
		$increasable = false;
	}

	if ($increasable and !$player_status['stamina_changed']) {
		if ($player_status['char_stamina']['current'] > 0 and key_pressed($player_status['pressed_keys'], 'run')) {
			$player_status['stamina_changed'] = true;
			set_player($player_id, 'stamina_changed', $player_status['stamina_changed']);
			$player_status = decrease_stamina($player_status, 25);
			set_player($player_id, 'char_stamina', $player_status['char_stamina']);

			sleep(1);
			$player_status['stamina_changed'] = false;
			set_player($player_id, 'stamina_changed', $player_status['stamina_changed']);

			return 'decrease';
		}

		else if ($player_status['char_stamina']['current'] > 0 and is_defense_key_pressed($player_status)) {
			$player_status['stamina_changed'] = true;
			set_player($player_id, 'stamina_changed', $player_status['stamina_changed']);
			$player_status = decrease_stamina($player_status, 10);
			set_player($player_id, 'char_stamina', $player_status['char_stamina']);

			sleep(1);
			$player_status['stamina_changed'] = false;
			set_player($player_id, 'stamina_changed', $player_status['stamina_changed']);
			return 'decrease';
		}

		else if ($player_status['char_stamina']['current'] < $player_status['char_stamina']['max']) {
			$player_status['stamina_changed'] = true;
			set_player($player_id, 'stamina_changed', $player_status['stamina_changed']);

			$player_status = increase_stamina($player_status, 25);
			set_player($player_id, 'char_stamina', $player_status['char_stamina']);

			sleep(2);
			$player_status['stamina_changed'] = false;
			set_player($player_id, 'stamina_changed', $player_status['stamina_changed']);
			return 'increase';
		}
	}

}

function is_defense_key_pressed($char_data) {
	if (sizeof($char_data['pressed_keys']) == 1) {
		if ($char_data['pressed_keys'][0] == square_key)
			return true;
	}
	return false;
	// if (is_key_pressed($char_data['pressed_keys'], square_key)) {
	// 	if (!is_key_pressed($char_data['pressed_keys'], l1_key))
	// 		return true;
	// 	if (!is_key_pressed($char_data['pressed_keys'], l2_key))
	// 		return true;
	// 	if (!is_key_pressed($char_data['pressed_keys'], r1_key))
	// 		return true;
	// 	if (!is_key_pressed($char_data['pressed_keys'], r2_key))
	// 		return true;
	// 	return true;
	// }
	// return true;
}

// function is_running($char_data) {
// 	if (is_key_pressed($char_data['pressed_keys'], triangle_key)) {
// 		if (is_key_pressed($char_data['pressed_keys'], top_key))
// 			return true;
// 		else if (is_key_pressed($char_data['pressed_keys'], bottom_key))
// 			return true;
// 		else if (is_key_pressed($char_data['pressed_keys'], right_key))
// 			return true;
// 		else if (is_key_pressed($char_data['pressed_keys'], left_key))
// 			return true;
// 		return false;
// 	}
// 	return false;
// }

function decrease_health($player_status, $decreased_by) {
	$player_status['char_health']['current'] -= $decreased_by;
	if ($player_status['char_health']['current'] < 0)
		$player_status['char_health']['current'] = 0;
	return $player_status;
}

function decrease_stamina($player_status, $decreased_by) {
	$player_status['char_stamina']['current'] -= $decreased_by;
	if ($player_status['char_stamina']['current'] < 0)
		$player_status['char_stamina']['current'] = 0;
	return $player_status;
}

function increase_health($player_status, $increased_by) {
	$player_status['char_health']['current'] += $increased_by;
	if ($player_status['char_health']['current'] > $player_status['char_health']['max'])
		$player_status['char_health']['current'] = $player_status['char_health']['max'];
	return $player_status;
}

function increase_stamina($player_status, $increased_by) {
	$player_status['char_stamina']['current'] += $increased_by;
	if ($player_status['char_stamina']['current'] > $player_status['char_stamina']['max'])
		$player_status['char_stamina']['current'] = $player_status['char_stamina']['max'];
	return $player_status;
}

function change_map($map_id, &$player, $portal) {
	// printJson($player);

	/* remove player data in old map */
	$map = json_read(dir.'maps/'.$player['map_id'].'/players')[DATA];
	$map = arr_value_remove_by_value($map, $player['char_id']);
	json_save(dir.'maps/'.$player['map_id'],'/players', $map, $minify=false);

	/* replace old map id with new map id */
	$player['map_id'] = $map_id;

	/* add player data in new map */
	$map = json_read(dir.'maps/'.$player['map_id'].'/players')[DATA];
	if (!in_array($player['char_id'], $map)) {
		array_push($map, $player['char_id']);
		json_save(dir.'maps/'.$player['map_id'],'/players', $map, $minify=false);
	}


	$player['position'] = $portal['p_pos'];
	$player['rotation'] = $portal['p_rot'];
	$player['move_directions'] = [];

	set_player($player['char_id'], 'move_directions', $player['move_directions']);
	set_player($player['char_id'], 'position', $player['position']);
	set_player($player['char_id'], 'rotation', $player['rotation']);
	set_player($player['char_id'], 'map_id', $player['map_id']);
}

function get_player($player_id, $key='all') {

	if ($key == 'all') {
		$status = getFileNamesInsideDir(dir.'players/'.$player_id.'/')[DATA];
		$player = null;
		if ($status == null)
			$player = [];
		foreach ($status as $key => $value) {
			$pstat = json_read(dir.'players/'.$player_id.'/'.$value)[DATA];
			$player[$value] = $pstat;
		}
		return $player;
	}
	else {
		$pstat = json_read(dir.'players/'.$player_id.'/'.$key)[DATA];
		return $pstat;
	}
}

function get_npc($npc_id, $key='all') {

	if ($key == 'all') {
		$status = getFileNamesInsideDir(dir.'npcs/'.$npc_id.'/')[DATA];
		$npc = null;
		if ($status == null)
			$npc = [];
		foreach ($status as $key => $value) {
			$pstat = json_read(dir.'npcs/'.$npc_id.'/'.$value)[DATA];
			$npc[$value] = $pstat;
		}
		return $npc;
	}
	else {
		$pstat = json_read(dir.'npcs/'.$npc_id.'/'.$key)[DATA];
		return $pstat;
	}
}


function set_player($player_id, $key, $value) {
	if ($value !== null)
		json_save(dir.'players/'.$player_id.'/', $key, $value, $minify=false);
}

function handle_trading(&$client_char, $server_char) {
	if ($server_char['trade_id'] != '') {
		$trade = json_read(dir.'trades/'.$server_char['trade_id']);
		if ($trade[RES_STAT] == NOT_FOUND) {
			$server_char['trade_id'] = '';
			set_player($client_char['char_id'], 'trade_id', $server_char['trade_id']);
			$client_char['system_chat'] = 'Player has close the trade.';
		}
	}
}

function handle_map_change(&$client_char, $server_char) {
	if ($client_char['map_id'] != $server_char['map_id']) {
		set_player($client_char['char_id'], $server_char['map_id']);
		$client_char['map_changed'] = true;
	}
	else {
		if ($client_char['map_changed'])
			set_player($client_char['char_id'], $server_char['map_id']);
		$client_char['map_changed'] = false;
	}
}

function handle_duel(&$client_char, $server_char) {
	if ($server_char['duel_id'] != '') {
		$duel = json_read(dir.'duels/'.$server_char['duel_id']);
		if ($duel[RES_STAT] == NOT_FOUND) {
			$server_char['duel_id'] = '';
			set_player($client_char['char_id'], 'duel_id', $server_char['duel_id']);
			$client_char['system_chat'] = 'Duel is over.';
		}
	}
	$client_char['duel_id'] = $server_char['duel_id'];
}

function handle_battle(&$client_char, $server_char) {
	if ($server_char['battle_id'] != '') {
		$battle = json_read(dir.'battles/'.$server_char['battle_id']);
		if ($battle[RES_STAT] == NOT_FOUND) {
			$server_char['battle_id'] = '';
			set_player($client_char['char_id'], 'battle_id', $server_char['battle_id']);
			$client_char['system_chat'] = 'Battle is over.';
		}
	}
	$client_char['battle_id'] = $server_char['battle_id'];
}

function handle_confirmation($client_char, $server_char) {
	$client_char['confirmation'] = '';
	if ($server_char['confirmation_id'] != '') {
		$confirmation = json_read(dir.'confirmations/'.$server_char['confirmation_id']);
		if ($confirmation[RES_STAT] == NOT_FOUND) {
			$server_char['confirmation_id'] = '';
			set_player($client_char['char_id'], 'confirmation_id', $server_char['confirmation_id']);
			$client_char['confirmation'] = '';
		}
		else {
			$client_char['confirmation'] = $confirmation[DATA];
		}
	}
	$client_char['confirmation_id'] = $server_char['confirmation_id'];
	return $client_char;
}

function handle_moving(&$client_char, $server_char) {
	if ($client_char['char_health']['current'] > 0 and $client_char['char_stamina']['current'] > 100) {
		if (is_key_pressed($client_char['pressed_keys'], top_key))
			move_top($client_char);
		else if (is_key_pressed($client_char['pressed_keys'], bottom_key))
			move_bottom($client_char);
		else if (is_key_pressed($client_char['pressed_keys'], right_key))
			move_right($client_char);
		else if (is_key_pressed($client_char['pressed_keys'], left_key))
			move_left($client_char);
		else 
			$client_char['move_directions'] = [];
		set_player($client_char['char_id'], 'move_directions', $client_char['move_directions']);
	}
	else { // if player is dead or weak (when stamina is lower than 100)
		if (is_defense_key_pressed($client_char))
	  	$client_char['pressed_keys'] = arr_value_remove_by_value($client_char['pressed_keys'], square_key);
  	$client_char['pressed_keys'] = arr_value_remove_by_value($client_char['pressed_keys'], triangle_key);
  	$client_char['pressed_keys'] = arr_value_remove_by_value($client_char['pressed_keys'], top_key);
  	$client_char['pressed_keys'] = arr_value_remove_by_value($client_char['pressed_keys'], bottom_key);
  	$client_char['pressed_keys'] = arr_value_remove_by_value($client_char['pressed_keys'], left_key);
  	$client_char['pressed_keys'] = arr_value_remove_by_value($client_char['pressed_keys'], right_key);
		set_player($client_char['char_id'], 'pressed_keys', $client_char['pressed_keys']);
	}
}

function handle_camera_direction(&$client_char) {
	if (arr_value_exist($client_char['pressed_keys'], r1_key)) {
	  if (arr_value_exist($client_char['pressed_keys'], circle_key) ) {
		  if ($client_char['camera_direction'] == 'north')
		    $client_char['camera_direction'] = 'west';
		  else if ($client_char['camera_direction'] == 'west')
		    $client_char['camera_direction'] = 'south';
		  else if ($client_char['camera_direction'] == 'south')
		    $client_char['camera_direction'] = 'east';
		  else if ($client_char['camera_direction'] == 'east')
		    $client_char['camera_direction'] = 'north';
		  set_player($client_char['char_id'], 'camera_direction', $client_char['camera_direction']);
		}
	  else if (arr_value_exist($client_char['pressed_keys'], square_key) ) {
		  if ($client_char['camera_direction'] == 'north')
		    $client_char['camera_direction'] = 'east';
		  else if ($client_char['camera_direction'] == 'east')
		    $client_char['camera_direction'] = 'south';
		  else if ($client_char['camera_direction'] == 'south')
		    $client_char['camera_direction'] = 'west';
		  else if ($client_char['camera_direction'] == 'west')
		    $client_char['camera_direction'] = 'north';
		  set_player($client_char['char_id'], 'camera_direction', $client_char['camera_direction']);
		}
	}
}

function handle_camera_position(&$char_data, &$json) {
	if ($char_data['camera_direction'] == 'north') {
		$json['props']['camera_position']['x'] = 35;
		$json['props']['camera_position']['y'] = 30;
		$json['props']['camera_position']['z'] = 35;
	}
	else if ($char_data['camera_direction'] == 'south') {
		$json['props']['camera_position']['x'] = -35;
		$json['props']['camera_position']['y'] = 30;
		$json['props']['camera_position']['z'] = -35;
	}
	else if ($char_data['camera_direction'] == 'east') {
		$json['props']['camera_position']['x'] = -35;
		$json['props']['camera_position']['y'] = 30;
		$json['props']['camera_position']['z'] = 35;
	}
	else if ($char_data['camera_direction'] == 'west') {
		$json['props']['camera_position']['x'] = 35;
		$json['props']['camera_position']['y'] = 30;
		$json['props']['camera_position']['z'] = -35;
	}
}

function handle_attack($client_char, $server_char) {
	if ($client_char['char_current_action'] == 'attack' && $client_char['char_stamina']['current'] >= atk_stamina) {
		$server_char = decrease_stamina($server_char, atk_stamina);
		$client_char = decrease_stamina($client_char, atk_stamina);
		set_player($client_char['char_id'], 'char_stamina', $server_char['char_stamina']);
		
		if (sizeof($client_char['enemies']) > 0) { // if there is enemy
	  	$_client_char = $client_char;
	  	$_client_char['face_dir'] = get_face_dir($_client_char);
	  	if ($_client_char['face_dir'] == 'north')
	  		$_client_char['position']['z'] -= 4;
	  	else if ($_client_char['face_dir'] == 'south')
	  		$_client_char['position']['z'] += 4;
	  	else if ($_client_char['face_dir'] == 'east')
	  		$_client_char['position']['x'] += 4;
	  	else if ($_client_char['face_dir'] == 'west')
	  		$_client_char['position']['x'] -= 4;
			$_client_char['size'] = calculate_collision_size($_client_char);

	  	foreach ($client_char['enemies'] as $key => $value) {
				$_other_player = $json['chars'][$value];
				$_other_player['size'] = calculate_collision_size($_other_player);
		  	if (char_reached($_client_char, $_other_player)) {
		  		if ($_other_player['char_current_action'] != 'defense' && $_other_player['char_health']['current'] > 0) {
						$items = json_read(dir.'items')[DATA];
						$_status = get_player($value, 'char_health');
						if ($client_char['char_gender'] == 'male')
							$_status = decrease_health($_status, male_base_atk + $items[$client_char['appearence']['rhand']]['atk']);
						else if ($client_char['char_gender'] == 'female')
							$_status = decrease_health($_status, female_base_atk + $items[$client_char['appearence']['rhand']]['atk']);
						set_player($value, 'char_health', $_status['char_health']);
		  		}
		  		break;
		  	}
	  	}
		}
	}
	return $client_char;
}


function handle_poke_to_player(&$client_char, $json) {
  if (is_speak_key_pressed($client_char)) {
  	$_char_data = $client_char;
  	$_char_data['face_dir'] = get_face_dir($_char_data);
  	if ($_char_data['face_dir'] == 'north')
  		$_char_data['position']['z'] -= 4;
  	else if ($_char_data['face_dir'] == 'south')
  		$_char_data['position']['z'] += 4;
  	else if ($_char_data['face_dir'] == 'east')
  		$_char_data['position']['x'] += 4;
  	else if ($_char_data['face_dir'] == 'west')
  		$_char_data['position']['x'] -= 4;

		$_char_data['size'] = calculate_collision_size($_char_data);

  	foreach ($json['chars'] as $key => $value) {
			$_other_player = $value;
			$_other_player['size'] = calculate_collision_size($_other_player);
	  	if (char_reached($_char_data, $_other_player)) {
				return $_other_player['char_id'];
	  	}
  	}
	}
	return '';
}

function handle_speak_to_npc(&$client_char, $npcs) {
	// handle speak with npc
  if (is_speak_key_pressed($client_char)) {
  	$_char_data = $client_char;
  	$_char_data['face_dir'] = get_face_dir($_char_data);
  	if ($_char_data['face_dir'] == 'north')
  		$_char_data['position']['z'] -= 4;
  	else if ($_char_data['face_dir'] == 'south')
  		$_char_data['position']['z'] += 4;
  	else if ($_char_data['face_dir'] == 'east')
  		$_char_data['position']['x'] += 4;
  	else if ($_char_data['face_dir'] == 'west')
  		$_char_data['position']['x'] -= 4;

		$_char_data['size'] = calculate_collision_size($_char_data);
  	foreach ($npcs as $key => $value) {
			$value['size'] = calculate_collision_size($value);
	  	if (char_reached($_char_data, $value)) {
				return $value['char_id'];
	  	}
  	}
	}
	return '';
}

function handle_collision_with_npcs(&$client_char, $server_char, $npcs) {
	foreach ($npcs as $key => $value) {
		$is_colladed_npc = check_collision($client_char, $value);
		if ($is_colladed_npc) {
			$client_char['position'] = $server_char['position'];
			set_player($client_char['char_id'], 'position', $client_char['position']);
			break;
		}
	}
}

function handle_collision_with_properties(&$client_char, $server_char) {
	$buildings = get_property_data($client_char['map_id'], false);
	foreach ($buildings as $key => $value) {
		$is_colladed_building = check_collision_building($client_char, $value);
		if ($is_colladed_building) {
			if ($value['prop'] === "portal") {
				change_map($value['to'], $client_char, $value);
				break;
			}
			else {
				$client_char['position'] = $server_char['position'];
				set_player($client_char['char_id'], 'position', $client_char['position']);
				break;
			}
		}
	}
}

function handle_collision_with_players(&$client_char, &$server_char, $json) {
	$client_char['size'] = calculate_collision_size($client_char);
	foreach ($json['chars'] as $key => $char) {
		if ($key !== $client_char['char_id']) {
			$is_collision = check_collision($json['chars'][$key], $client_char);
			if ($is_collision) {
				$client_char['position'] = $server_char['position'];
				set_player($client_char['char_id'], 'position', $client_char['position']);
				break;
			}
		}
	}
}

function post_char_data($char_data) {

	$player_status = get_player($char_data['char_id']);

	/* init json (response) */
	$json['props'] = [];
	$json['chars'] = [];

	/* init char data from server */
	$char_data['system_chat'] = '';
	$char_data['char_health'] = $player_status['char_health'];
	$char_data['char_stamina'] = $player_status['char_stamina'];
	$char_data['char_guild'] = $player_status['char_guild'];
	$char_data['enemies'] = $player_status['enemies'];
	$char_data['gold'] = $player_status['gold'];
	$char_data['rotation'] = $player_status['rotation'];
	$char_data['position'] = $player_status['position'];
	$char_data['camera_direction'] = $player_status['camera_direction'];
	$char_data['appearence'] = $player_status['appearence'];
	$char_data['active_date'] = microtime_float();

	set_player($char_data['char_id'], 'pressed_keys', $char_data['pressed_keys']);

	handle_map_change($char_data, $player_status);
	handle_trading($char_data, $player_status);
	handle_duel($char_data, $player_status);
	handle_battle($char_data, $player_status);
	handle_moving($char_data, $player_status);
	handle_camera_direction($char_data);
	handle_camera_position($char_data, $json);

	/* Get all chars in current map. */
	$char_names = json_read(dir.'maps/'.$char_data['map_id'].'/players')[DATA];
	foreach ($char_names as $key => $value) {
		$_player = get_player($value);
		$_appearence = $_player['appearence'];
		$json['chars'][$value] = $_player;
		$json['chars'][$value]['appearence'] = $_appearence;
		$json['chars'][$value]['size'] = calculate_collision_size($_player);
		$json['chars'][$value]['distance'] = get_distance(get_difference($json['chars'][$value]['position']['x'], $char_data['position']['x']), get_difference($json['chars'][$value]['position']['z'], $char_data['position']['z']));
	}

	$char_data = handle_attack($char_data, $player_status);

	$npcs = get_npc_data($char_data['map_id'], false);
	handle_collision_with_players($char_data, $player_status, $json);
	handle_collision_with_properties($char_data, $player_status);
	handle_collision_with_npcs($char_data, $player_status, $npcs);

	$json['props']['speak_to'] = handle_speak_to_npc($char_data, $npcs);
	$json['props']['poke_to_player'] = handle_poke_to_player($char_data, $json);
	$json['chars'][$char_data['char_id']] = $char_data;
	$json['chars'][$char_data['char_id']]['distance'] = 0;
	unset($char_data["size"]);

	// handle date and sun position
	$json['props']['sun_position']['x'] = 0;
	$json['props']['sun_position']['y'] = 20;
	$json['props']['sun_position']['z'] = 10;
	$json['props']['datetime']['year'] = 1;
	$json['props']['datetime']['month'] = 1;
	$json['props']['datetime']['day'] = 1;
	$json['props']['datetime']['hour'] = 1;
	$json['props']['datetime']['minute'] = 1;
	$json['props']['datetime']['second'] = 1;

	// error_log($json);
	// error_log($json['chars'][$char_data['char_id']]['char_id']);

	$json = json_encode($json);
	return $json;
}

function is_speak_key_pressed($char_data) {
  if (arr_value_exist($char_data['pressed_keys'], cross_key) && arr_value_exist($char_data['pressed_keys'], r2_key)) {
  	return true;
  }
  else {
  	return false;
  }
}

function get_face_dir($char_data) {
  if ($char_data['rotation']['y'] == pi() * 4/4)
		return 'north';
  else if ($char_data['rotation']['y'] == pi() * 0/4)
		return 'south';
  else if ($char_data['rotation']['y'] == pi() * 2/4)
		return 'east';
  else if ($char_data['rotation']['y'] == pi() * 6/4)
		return 'west';
	else 
		return 'asd';
}

function check_collision_building($char_data, $building_data) {
	if ($building_data['collision_size']['x'] !== '' and $building_data['collision_size']['z'] !== '') {
		foreach ($char_data['size']['x'] as $xkey => $xvalue) {
			if ($xvalue >= $building_data['position']['x']-$building_data['collision_size']['x'] && $xvalue <= $building_data['position']['x']+$building_data['collision_size']['x']) {
				foreach ($char_data['size']['z'] as $zkey => $zvalue) {
					if ($zvalue >= $building_data['position']['z']-$building_data['collision_size']['z'] && $zvalue <= $building_data['position']['z']+$building_data['collision_size']['z']) {
						return true;
					}
				}
			}
		}
	}
	
	return false;
}


function char_reached($main_char_data, $other_char_data) {
	$x = array_intersect($main_char_data['size']['x'], $other_char_data['size']['x']);
	$z = array_intersect($main_char_data['size']['z'], $other_char_data['size']['z']);

	if (sizeof($x) != 0 && sizeof($z) != 0)
		return true;
	else
		return false;
}

function calculate_collision_size2($char_data) {
	$width = 3;
	$_width = ($width-1)/2;
	$height = 3;
	$_height = ($height-1)/2;
	$pos_list['x'] = [];
	$pos_list['z'] = [];
	
	$val = ceil($char_data['position']['x']);
	array_push($pos_list['x'], $val);
	$val = ceil($char_data['position']['z']);
	array_push($pos_list['z'], $val);
	for ($i=0; $i<$_width; $i++) {
		$val = floor($char_data['position']['x'] - ($i+1)) + 0.5;
		array_push($pos_list['x'], $val);
	}
	for ($i=0; $i<$_width; $i++) {
		$val = ceil($char_data['position']['x'] + ($i+1)) - 0.5;
		array_push($pos_list['x'], $val);
	}
	for ($i=0; $i<$_height; $i++) {
		$val = floor($char_data['position']['z'] - ($i+1)) + 0.5;
		array_push($pos_list['z'], $val);
	}
	for ($i=0; $i<$_height; $i++) {
		$val = ceil($char_data['position']['z'] + ($i+1)) - 0.5;
		array_push($pos_list['z'], $val);
	}

	return $pos_list;
}

function get_circled_num($n) {
	$whole = floor($n);
	if ($n-$whole >= 0.75)
		return $whole+1;
	else if ($n-$whole >= 0.5)
		return $whole+0.5;
	else if ($n-$whole >= 0.25)
		return $whole+0.5;
	else if ($n-$whole >= 0)
		return $whole+0;
}


function check_collision($main_char_data, $other_char_data) {
	// printJson($main_char_data['size']);
	// printJson($other_char_data['position']);
	foreach ($main_char_data['size']['x'] as $xkey => $xvalue) {
		if ($xvalue >= $other_char_data['position']['x']-1 && $xvalue <= $other_char_data['position']['x']+1) {
			foreach ($main_char_data['size']['z'] as $zkey => $zvalue) {
				if ($zvalue >= $other_char_data['position']['z']-1 && $zvalue <= $other_char_data['position']['z']+1) {
					// echo 'true';
					return true;
				}
			}
		}
	}

	// echo 'false';
	return false;


	// $x = array_intersect($main_char_data['size']['x'], $other_char_data['size']['x']);
	// $z = array_intersect($main_char_data['size']['z'], $other_char_data['size']['z']);

	// if (sizeof($x) != 0 && sizeof($z) != 0)
	// 	return true;
	// else
	// 	return false;
}
function calculate_collision_size($char_data) {

	$pos_list['x'] = [];
	$pos_list['z'] = [];
	
	// $base_x = get_circled_num($char_data['position']['x']);
	$base_x = $char_data['position']['x'];
	array_push($pos_list['x'], $base_x);
	$base_z = $char_data['position']['z'];
	// $base_z = get_circled_num($char_data['position']['z']);
	array_push($pos_list['z'], $base_z);

	$width = 3;
	$_width = ($width-1)/2;
	for ($i=0; $i<$_width; $i++) {
		$val = $base_x+(($i+1));
		array_push($pos_list['x'], $val);
	}
	for ($i=0; $i<$_width; $i++) {
		$val = $base_x-(($i+1));
		array_push($pos_list['x'], $val);
	}

	$height = 3;
	$_height = ($height-1)/2;
	for ($i=0; $i<$_height; $i++) {
		$val = $base_z+(($i+1));
		array_push($pos_list['z'], $val);
	}
	for ($i=0; $i<$_height; $i++) {
		$val = $base_z-(($i+1));
		array_push($pos_list['z'], $val);
	}

	return $pos_list;
}

function move_north(&$char_data, $_speed) {
  $char_data['position']['z'] -= $_speed;
  $char_data['position']['z'] = floor($char_data['position']['z']);
  set_player($char_data['char_id'], 'position', $char_data['position']);
}

function move_south(&$char_data, $_speed) {
  $char_data['position']['z'] += $_speed;
  $char_data['position']['z'] = floor($char_data['position']['z']);
  set_player($char_data['char_id'], 'position', $char_data['position']);
}

function move_east(&$char_data, $_speed) {
  $char_data['position']['x'] += $_speed;
  $char_data['position']['x'] = floor($char_data['position']['x']);
  set_player($char_data['char_id'], 'position', $char_data['position']);
}

function move_west(&$char_data, $_speed) {
  $char_data['position']['x'] -= $_speed;
  $char_data['position']['x'] = floor($char_data['position']['x']);
  set_player($char_data['char_id'], 'position', $char_data['position']);
}

function face_to(&$char_data, $direction) {
	if ($direction == 'north')
    $char_data['rotation']['y'] = pi() * 4/4;
	else if ($direction == 'north_east')
    $char_data['rotation']['y'] = pi() * 3/4;
	else if ($direction == 'north_west')
    $char_data['rotation']['y'] = pi() * 5/4;
	else if ($direction == 'south')
    $char_data['rotation']['y'] = pi() * 0/4;
	else if ($direction == 'south_east')
    $char_data['rotation']['y'] = pi() * 1/4;
	else if ($direction == 'south_west')
    $char_data['rotation']['y'] = pi() * 7/4;
	else if ($direction == 'east')
    $char_data['rotation']['y'] = pi() * 2/4;
	else if ($direction == 'west')
    $char_data['rotation']['y'] = pi() * 6/4;
  $rot['x'] = 0;
  $rot['y'] = $char_data['rotation']['y'];
  $rot['z'] = 0;
  $char_data['rotation'] = $rot;
  set_player($char_data['char_id'], 'rotation', $rot);
}

function move_top(&$char_data) {
	if (is_key_pressed($char_data['pressed_keys'], triangle_key)) {
  	$_speed = speed;
	}
  else {
  	$_speed = walk_speed;
  }

  $char_data['move_directions'] = [];
  if (is_key_pressed($char_data['pressed_keys'], bottom_key))  {
    $char_data['rotation']['y'] = pi() * 4/4;
  }
  else {
    if ($char_data["camera_direction"] == 'north') {
    	move_north($char_data, $_speed);
    	face_to($char_data, 'north');
    	array_push($char_data['move_directions'], 'north');
    }
    else if ($char_data["camera_direction"] == 'south') {
    	move_south($char_data, $_speed);
    	face_to($char_data, 'south');
    	array_push($char_data['move_directions'], 'south');
    }
    else if ($char_data["camera_direction"] == 'east') {
    	move_east($char_data, $_speed);
    	face_to($char_data, 'east');
    	array_push($char_data['move_directions'], 'east');
    }
    else if ($char_data["camera_direction"] == 'west') {
    	move_west($char_data, $_speed);
    	face_to($char_data, 'west');
    	array_push($char_data['move_directions'], 'west');
    }
  }
}

function move_bottom(&$char_data) {
	if (is_key_pressed($char_data['pressed_keys'], triangle_key)) {
  	$_speed = speed;
	}
  else {
  	$_speed = walk_speed;
  }

  $char_data['move_directions'] = [];
  if ($char_data["camera_direction"] == 'north') {
  	move_south($char_data, $_speed);
  	face_to($char_data, 'south');
  	array_push($char_data['move_directions'], 'south');
  }
  else if ($char_data["camera_direction"] == 'south') {
  	move_north($char_data, $_speed);
  	face_to($char_data, 'north');
  	array_push($char_data['move_directions'], 'north');
  }
  else if ($char_data["camera_direction"] == 'east') {
  	move_west($char_data, $_speed);
  	face_to($char_data, 'west');
  	array_push($char_data['move_directions'], 'west');
  }
  else if ($char_data["camera_direction"] == 'west') {
  	move_east($char_data, $_speed);
  	face_to($char_data, 'east');
  	array_push($char_data['move_directions'], 'east');
  }
}

function key_pressed($pressed_keys, $action) {
	if ($action == 'jump')
		return (sizeof($pressed_keys) == 1 && is_key_pressed($pressed_keys, cross_key) || 
			is_key_pressed($pressed_keys, cross_key) && is_key_pressed($pressed_keys, triangle_key) ||
			is_key_pressed($pressed_keys, cross_key) && is_key_pressed($pressed_keys, top_key) ||
			is_key_pressed($pressed_keys, cross_key) && is_key_pressed($pressed_keys, bottom_key) ||
			is_key_pressed($pressed_keys, cross_key) && is_key_pressed($pressed_keys, left_key) ||
			is_key_pressed($pressed_keys, cross_key) && is_key_pressed($pressed_keys, right_key)
		);
	else if ($action == 'attack')
		return (sizeof($pressed_keys) == 1 && is_key_pressed($pressed_keys, circle_key));
	else if ($action == 'defense')
		return (sizeof($pressed_keys) == 1 && is_key_pressed($pressed_keys, square_key));
	else if ($action == 'friendlist')
		return (sizeof($pressed_keys) == 2 && is_key_pressed($pressed_keys, l1_key) && is_key_pressed($pressed_keys, cross_key));
	else if ($action == 'guild')
		return (sizeof($pressed_keys) == 2 && is_key_pressed($pressed_keys, l1_key) && is_key_pressed($pressed_keys, square_key));
	else if ($action == 'inventory')
		return (sizeof($pressed_keys) == 2 && is_key_pressed($pressed_keys, l1_key) && is_key_pressed($pressed_keys, triangle_key));
	else if ($action == 'map')
		return (sizeof($pressed_keys) == 2 && is_key_pressed($pressed_keys, l1_key) && is_key_pressed($pressed_keys, circle_key));
	else if ($action == 'zoomin')
		return (sizeof($pressed_keys) == 2 && is_key_pressed($pressed_keys, r1_key) && is_key_pressed($pressed_keys, cross_key));
	else if ($action == 'zoomout')
		return (sizeof($pressed_keys) == 2 && is_key_pressed($pressed_keys, r1_key) && is_key_pressed($pressed_keys, triangle_key));
	else if ($action == 'camera_right')
		return (sizeof($pressed_keys) == 2 && is_key_pressed($pressed_keys, r1_key) && is_key_pressed($pressed_keys, circle_key));
	else if ($action == 'camera_left')
		return (sizeof($pressed_keys) == 2 && is_key_pressed($pressed_keys, r1_key) && is_key_pressed($pressed_keys, square_key));
	else if ($action == 'poke')
		return (sizeof($pressed_keys) == 2 && is_key_pressed($pressed_keys, r2_key) && is_key_pressed($pressed_keys, cross_key));
	else if ($action == 'move')
		return (
			is_key_pressed($pressed_keys, top_key) || is_key_pressed($pressed_keys, right_key) ||
			is_key_pressed($pressed_keys, bottom_key) || is_key_pressed($pressed_keys, left_key)
		);
	else if ($action == 'run')
		return (is_key_pressed($pressed_keys, triangle_key) && key_pressed($pressed_keys, 'move'));
	else 
		return false;
}

function move_right(&$char_data) {
	if (is_key_pressed($char_data['pressed_keys'], triangle_key)) {
  	$_speed = speed;
	}
  else {
  	$_speed = walk_speed;
  }

  if (!is_key_pressed($char_data['pressed_keys'], top_key) && !is_key_pressed($char_data['pressed_keys'], bottom_key) && !is_key_pressed($char_data['pressed_keys'], left_key)) {
    if ($char_data["camera_direction"] == 'north') {
    	move_east($char_data, $_speed);
    	face_to($char_data, 'east');
    	array_push($char_data['move_directions'], 'east');
    }
    else if ($char_data["camera_direction"] == 'south') {
    	move_west($char_data, $_speed);
    	face_to($char_data, 'west');
    	array_push($char_data['move_directions'], 'west');
    }
    else if ($char_data["camera_direction"] == 'east') {
    	move_south($char_data, $_speed);
    	face_to($char_data, 'south');
    	array_push($char_data['move_directions'], 'south');
    }
    else if ($char_data["camera_direction"] == 'west') {
    	move_north($char_data, $_speed);
    	face_to($char_data, 'north');
    	array_push($char_data['move_directions'], 'north');
    }
  }
}

function move_left(&$char_data) {
	if (is_key_pressed($char_data['pressed_keys'], triangle_key)) {
  	$_speed = speed;
	}
  else {
  	$_speed = walk_speed;
  }

  if (!is_key_pressed($char_data['pressed_keys'], top_key) && !is_key_pressed($char_data['pressed_keys'], bottom_key) && !is_key_pressed($char_data['pressed_keys'], right_key)) {
    if ($char_data["camera_direction"] == 'north') {
    	move_west($char_data, $_speed);
    	face_to($char_data, 'west');
    	array_push($char_data['move_directions'], 'west');
    }
    else if ($char_data["camera_direction"] == 'south') {
    	move_east($char_data, $_speed);
    	face_to($char_data, 'east');
    	array_push($char_data['move_directions'], 'east');
    }
    else if ($char_data["camera_direction"] == 'east') {
    	move_north($char_data, $_speed);
    	face_to($char_data, 'north');
    	array_push($char_data['move_directions'], 'north');
    }
    else if ($char_data["camera_direction"] == 'west') {
    	move_south($char_data, $_speed);
    	face_to($char_data, 'south');
    	array_push($char_data['move_directions'], 'south');
    }
  }
}

function is_key_pressed($map, $key) {
	if (arr_value_exist($map, $key))
		return true;
	else
		return false;
}

function get_map_name($map_id, $encoded=true) {
	$map_list = json_read(dir.'maps/list')[DATA];
	$map_name = $map_list[$map_id];
	if ($encoded)
		$map_name = json_encode($map_name);
	return $map_name;
}

function get_char_data($char_id, $encoded=true) {
	$char_data = get_player($char_id);
	// $default_data = get_player('default');
	// foreach ($default_data as $key => $value) {
	// 	$char_data[$key] = $value;
	// 	set_player($char_id, $key, $value);
	// }

	if ($encoded)
		$char_data = json_encode($char_data);
	return $char_data;
}

function get_item_data() {
	$json = json_read(dir.'items')[DATA];
	$json = json_encode($json);
	return $json;
}

// function get_inventory($char_id) {
// // 	$json = json_read(dir.'inventories/' . $char_id)[DATA];
// 	$json = json_encode($json);
// 	return $json;
// }

function get_item_type_by_slot_num($slot_num) {
	if ($slot_num == 0) {
		return "rhand";
	}
	else if ($slot_num == 1) {
		return "rhand";
	}
	else if ($slot_num == 2) {
		return "suit";
	}
	else if ($slot_num == 3) {
		return "gloves";
	}
	else if ($slot_num == 4) {
		return "shoes";
	}
	else if ($slot_num == 5) {
		return "head";
	}
	else if ($slot_num == 6) {
		return "glasses";
	}
	else if ($slot_num == 7) {
		return "mask";
	}
	else if ($slot_num == 8) {
		return "back";
	}
	else if ($slot_num == 9) {
		return "top";
	}
}

function get_buysell_items($npc_id) {
	$npc = get_npc($npc_id, 'buysell_items');
	$json = json_encode($npc);
	return $json;
}

function get_npc_data($map_id, $encoded=true) {
	$npc_names = json_read(dir. 'maps/' .$map_id.'/'.'npcs')[DATA];
	$json = [];
	foreach ($npc_names as $key => $npc_name) {
		// $_json = json_read(dir.'npcs/'.$npc_name)[DATA];
		$_json = get_npc($npc_name, 'all');
		$json[$npc_name] = $_json;
	}

	if ($encoded)
		$json = json_encode($json);
	return $json;
}



function get_quest2($player_id, $npc_id) {
	$quest = json_read(dir.'quests/'. $npc_id)[DATA];

	$player_quest = get_player($player_id, 'quest');
	// printJson($player_quest);
	$json = [];
	if ($player_quest[$npc_id] <= sizeof($quest['quest'])) {
		$json['type'] = $quest['quest'][$player_quest[$npc_id]]['type'];
		$json['talk'] = $quest['quest'][$player_quest[$npc_id]]['question'];
	}
	else {
		$json['type'] = 'default';
		$json['talk'] = $quest['default'];
	}
	
	$json = json_encode($json);
	return $json;
}



function get_property_data($map_id, $encoded=true) {
	$properties = json_read(dir.'maps/'. $map_id.'/'.'properties')[DATA];
	$default = json_read(dir.'maps/default_keys')[DATA];
	$result = [];
	$id = 0;
	foreach ($properties as $propkey => $propval) {
		// if (json_read(dir.'maps/properties/'.$propval['prop'])[RES_STAT] == NOT_FOUND)
		// 	printJson(dir.'maps/properties/'.$propval['prop']);
		$prop = json_read(dir.'maps/properties/'.$propval['prop'])[DATA];
		// printJson($prop);
		// break;
		$prop['building_id'] = $id;
		foreach ($default as $defkey => $defval) {
			if (!is_exist_json_key($prop, $defkey)) {
				$prop[$defkey] = $defval;
			}
		}
		// if ($propval['prop'] == 'flowerwall') {
		// 	printJson(json_read(dir.'maps/properties/'.$propval['prop']));
		// 	printJson($prop);
		// 	break;
		// }

		$id += 1;
		foreach ($propval as $subpropkey => $subpropval) {
			if ($subpropkey == 'size') {
				$prop['collision_size']['x'] = ceil($subpropval*$prop['collision_size']['x']/ $prop['size']);
				$prop['collision_size']['z'] = ceil($subpropval*$prop['collision_size']['z']/ $prop['size']);
				$prop['size'] = $subpropval;
			}
			else if ($subpropkey == 'facedir') {
				if ($subpropval == 'north') {
					$prop['rotation'] = arr_to_json(array("x"=>0,"y"=>3.14,"z"=>0));
				}
				else if ($subpropval == 'south') {
					$prop['rotation'] = arr_to_json(array("x"=>0,"y"=>0,"z"=>0));
				}
				else if ($subpropval == 'east') {
					$temp_x = $prop['collision_size']['x'];
					$prop['collision_size']['x'] = $prop['collision_size']['z'];
					$prop['collision_size']['z'] = $temp_x;
					$prop['rotation'] = arr_to_json(array("x"=>0,"y"=>1.57,"z"=>0));
				}
				else if ($subpropval == 'west') {
					$temp_x = $prop['collision_size']['x'];
					$prop['collision_size']['x'] = $prop['collision_size']['z'];
					$prop['collision_size']['z'] = $temp_x;
					$prop['rotation'] = arr_to_json(array("x"=>0,"y"=>4.71,"z"=>0));
				}
			}
			else
				$prop[$subpropkey] = $subpropval;
		}

		if ($prop['prop'] == 'portal') {
			if ($prop['position']['x'] == 0 and $prop['position']['z'] == 112) {
				$prop['p_rot'] = arr_to_json(array("x"=>0,"y"=>0,"z"=>0));
				$prop['p_pos'] = arr_to_json(array("x"=>0,"y"=>0,"z"=>-105));
			}
			else if ($prop['position']['x'] == 0 and $prop['position']['z'] == -112) {
				$prop['p_rot'] = arr_to_json(array("x"=>0,"y"=>3.14,"z"=>0));
				$prop['p_pos'] = arr_to_json(array("x"=>0,"y"=>0,"z"=>105));
			}
			else if ($prop['position']['x'] == 112 and $prop['position']['z'] == 0) {
				$prop['p_rot'] = arr_to_json(array("x"=>0,"y"=>1.57,"z"=>0));
				$prop['p_pos'] = arr_to_json(array("x"=>-105,"y"=>0,"z"=>0));
			}
			else if ($prop['position']['x'] == -112 and $prop['position']['z'] == 0) {
				$prop['p_rot'] = arr_to_json(array("x"=>0,"y"=>4.71,"z"=>0));
				$prop['p_pos'] = arr_to_json(array("x"=>105,"y"=>0,"z"=>0));
			}
		}
		array_push($result, $prop);
	}

	if ($encoded)
		return json_encode($result);
	else
		return $result;
	// return json_encode($properties);
}

?>