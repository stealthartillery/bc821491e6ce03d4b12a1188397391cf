<?php if (!defined('BASEPATH')) exit('no direct script access allowed');



// function health_increase_temp($player_id) {
// 	$dir = BASE_DIR .'/storages/light/';
// 	$player_status = json_read($dir.'players_status/'. $player_id)[DATA];
// 	$increasable = true;
// 	if ($player_status['battle_id'] != '' and $player_status['char_health']['current'] <= 0) {
// 		$increasable = false;
// 	}

// 	if ($increasable and !$player_status['is_health_increasing']) {
// 		while ($player_status['char_health']['current'] < $player_status['char_health']['max']) {
// 			$player_status = json_read($dir.'players_status/'. $player_id)[DATA];
// 			$player_status['is_health_increasing'] = true;

// 			/* if player not lose in duel or battle, increase. */
// 			if ($player_status['battle_id'] == '' or $player_status['duel_id'] == '') {
// 				if ($player_status['char_health']['current'] == 0) {
// 					$player_status = increase_health($player_status, 25);
// 					if ($player_status['char_health']['current'] >= $player_status['char_health']['max'])
// 						$player_status['is_health_increasing'] = false;
// 					json_save($dir, 'players_status/'.$player_id, $player_status, $minify=false);
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

function health_increase($player_id) {
	$dir = BASE_DIR .'/storages/light/';
	$player_status = json_read($dir.'players_status/'. $player_id)[DATA];
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
			$player_status = json_read($dir.'players_status/'. $player_id)[DATA];
			$player_status['is_health_increasing'] = true;

			if ($player_status['battle_id'] == '' or $player_status['duel_id'] == '') {
				if ($player_status['char_health']['current'] > 0) {
					$player_status = increase_health($player_status, 25);
					if ($player_status['char_health']['current'] >= $player_status['char_health']['max'])
						$player_status['is_health_increasing'] = false;
				}
			}
			json_save($dir, 'players_status/'.$player_id, $player_status, $minify=false);
			sleep(2);
		}
	}
}

function stamina_changed($player_id) {
	$dir = BASE_DIR .'/storages/light/';
	$player_status = json_read($dir.'players_status/'.$player_id)[DATA];
	$increasable = true;
	if ($player_status['battle_id'] != '' and $player_status['char_stamina']['current'] <= 0) {
		$increasable = false;
	}

	if ($increasable and !$player_status['stamina_changed']) {
		$player = json_read($dir.'players/'.$player_id)[DATA];
		if ($player_status['char_stamina']['current'] > 0 and is_running($player)) {
			$player_status['stamina_changed'] = true;
			json_save($dir, 'players_status/'.$player_id, $player_status, $minify=false);
			$player_status = decrease_stamina($player_status, 25);
			json_save($dir, 'players_status/'.$player_id, $player_status, $minify=false);
			sleep(1);
			$player_status = json_read($dir.'players_status/'.$player_id)[DATA];
			$player_status['stamina_changed'] = false;
			json_save($dir, 'players_status/'.$player_id, $player_status, $minify=false);
			return 'decrease';
		}

		else if ($player_status['char_stamina']['current'] > 0 and is_defense_key_pressed($player)) {
			$player_status['stamina_changed'] = true;
			json_save($dir, 'players_status/'.$player_id, $player_status, $minify=false);
			// $player_status['char_stamina']['current'] -= 10;
			$player_status = decrease_stamina($player_status, 10);
			// if ($player_status['char_stamina']['current'] <= 0 or !is_defense_key_pressed($player)) {
			// 	$player_status['char_stamina']['current'] = 0;
			// }
			json_save($dir, 'players_status/'.$player_id, $player_status, $minify=false);
			sleep(1);
			$player_status = json_read($dir.'players_status/'.$player_id)[DATA];
			$player_status['stamina_changed'] = false;
			json_save($dir, 'players_status/'.$player_id, $player_status, $minify=false);
			return 'decrease';
		}

		else if ($player_status['char_stamina']['current'] < $player_status['char_stamina']['max']) {
			$player_status['stamina_changed'] = true;
			json_save($dir, 'players_status/'.$player_id, $player_status, $minify=false);
			$player_status = increase_stamina($player_status, 25);
			json_save($dir, 'players_status/'.$player_id, $player_status, $minify=false);
			sleep(2);
			$player_status = json_read($dir.'players_status/'.$player_id)[DATA];
			$player_status['stamina_changed'] = false;
			json_save($dir, 'players_status/'.$player_id, $player_status, $minify=false);
			return 'increase';
		}

		// if ( ($player_status['char_stamina']['current'] <= 0 or !is_running($player)) and
		// 		 ($player_status['char_stamina']['current'] >= $player_status['char_stamina']['max'])) {
		// 	$player_status = json_read($dir.'players_status/'.$player_id)[DATA];
		// 	$player_status['stamina_changed'] = false;
		// 	json_save($dir, 'players_status/'.$player_id, $player_status, $minify=false);
		// 	sleep(2);
		// }

	}

	// if (!$player_status['stamina_changed']) {

	// 	$player = json_read($dir.'players/'.$player_id)[DATA];
	// 	if ($player_status['char_stamina']['current'] > 0 and is_running($player)) {
	// 		$player_status['char_stamina']['current'] -= 25;
	// 		$player_status['stamina_changed'] = true;
	// 		json_save($dir, 'players_status/'.$player_id, $player_status, $minify=false);
	// 		sleep(2);
	// 	}

	// 	while ($player_status['char_stamina']['current'] < $player_status['char_stamina']['max']) {
	// 		$player_status = json_read($dir.'players_status/'.$player_id)[DATA];
	// 		$player_status['stamina_changed'] = true;
	// 		$player_status['char_stamina']['current'] += 25;
	// 		if ($player_status['char_stamina']['current'] >= $player_status['char_stamina']['max']) {
	// 			$player_status['char_stamina']['current'] = $player_status['char_stamina']['max'];
	// 			$player_status['stamina_changed'] = false;
	// 		}
	// 		json_save($dir, 'players_status/'.$player_id, $player_status, $minify=false);
	// 		sleep(2);
	// 	}
	// }
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

function is_running($char_data) {
	if (is_key_pressed($char_data['pressed_keys'], triangle_key)) {
		if (is_key_pressed($char_data['pressed_keys'], top_key))
			return true;
		else if (is_key_pressed($char_data['pressed_keys'], bottom_key))
			return true;
		else if (is_key_pressed($char_data['pressed_keys'], right_key))
			return true;
		else if (is_key_pressed($char_data['pressed_keys'], left_key))
			return true;
		return false;
	}
	return false;
}

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

function check_interval() {
	$dir = BASE_DIR .'/storages/light/';
	$test = json_read($dir.'test')[DATA];
	if ($test['is_active'] == false) {
		$test['is_active'] = true;
		for ($i=0; $i<10; $i++) {
			$test['interval'] += 1;
			json_save($dir, 'test', $test, $minify=false);
			sleep(1);
		}
		$test['is_active'] = false;
		json_save($dir, 'test', $test, $minify=false);
	}
}

function post_char_data($char_data) {
	$dir = BASE_DIR .'/storages/light/';

	$char_data['system_chat'] = '';

	// increase health and stamina every iteration
	$player_status = json_read($dir.'players_status/'.$char_data['char_id'])[DATA];
	// health_increase($char_data['char_id']);
	// stamina_increase($char_data['char_id']);
	// if ($player_status['char_health']['current'] < $player_status['char_health']['max'] || $player_status['char_stamina']['current'] < $player_status['char_stamina']['max']) {
		// if ($player_status['char_health']['current'] < $player_status['char_health']['max'])
		// 	$player_status['char_health']['current'] += 1;
		// if ($player_status['char_stamina']['current'] < $player_status['char_stamina']['max'])
		// 	$player_status['char_stamina']['current'] += 1;
		// json_save($dir.'players_status/', $char_data['char_id'], $player_status, $minify=false);
	// }

	$char_data['char_health'] = $player_status['char_health'];
	$char_data['char_stamina'] = $player_status['char_stamina'];
	$char_data['char_guild'] = $player_status['char_guild'];
	$char_data['enemies'] = $player_status['enemies'];

	/* handle trading activity */
	if ($player_status['trade_id'] != '') {
		$trade = json_read($dir.'trades/'.$player_status['trade_id']);
		if ($trade[RES_STAT] == NOT_FOUND) {
			$player_status['trade_id'] = '';
			json_save($dir.'players_status/', $char_data['char_id'], $player_status, $minify=false);
			$char_data['system_chat'] = 'Player has close the trade.';
		}
	}
	$char_data['trade_id'] = $player_status['trade_id'];

	/* handle duel activity */
	if ($player_status['duel_id'] != '') {
		$duel = json_read($dir.'duels/'.$player_status['duel_id']);
		if ($duel[RES_STAT] == NOT_FOUND) {
			$player_status['duel_id'] = '';
			json_save($dir.'players_status/', $char_data['char_id'], $player_status, $minify=false);
			$char_data['system_chat'] = 'Duel is over.';
		}
	}
	$char_data['duel_id'] = $player_status['duel_id'];

	/* handle battle activity */
	if ($player_status['battle_id'] != '') {
		$battle = json_read($dir.'battles/'.$player_status['battle_id']);
		if ($battle[RES_STAT] == NOT_FOUND) {
			$player_status['battle_id'] = '';
			json_save($dir.'players_status/', $char_data['char_id'], $player_status, $minify=false);
			$char_data['system_chat'] = 'Battle is over.';
		}
	}
	$char_data['battle_id'] = $player_status['battle_id'];

	/* handle confirming activity */
	$char_data['confirmation'] = '';
	if ($player_status['confirmation_id'] != '') {
		$confirmation = json_read($dir.'confirmations/'.$player_status['confirmation_id']);
		if ($confirmation[RES_STAT] == NOT_FOUND) {
			$player_status['confirmation_id'] = '';
			json_save($dir.'players_status/', $char_data['char_id'], $player_status, $minify=false);
			$char_data['confirmation'] = '';
		}
		else {
			$char_data['confirmation'] = $confirmation[DATA];
		}
	}
	$char_data['confirmation_id'] = $player_status['confirmation_id'];

	$inventory = json_read($dir.'inventories/'.$char_data['char_id'])[DATA];
	$char_data['gold'] = $inventory['gold'];

	/* rotation, position, camera_direction */
	$str = json_read($dir.'players/'.$char_data['char_id'])[DATA];
	$char_data['rotation']['x'] = $str['rotation']['x'];
	$char_data['rotation']['y'] = $str['rotation']['y'];
	$char_data['rotation']['z'] = $str['rotation']['z'];
	$char_data['position']['x'] = $str['position']['x'];
	$char_data['position']['y'] = $str['position']['y'];
	$char_data['position']['z'] = $str['position']['z'];
	$char_data['camera_direction'] = $str['camera_direction'];

	// handle moving char
	if ($char_data['char_health']['current'] > 0 and $char_data['char_stamina']['current'] > 100) {
		if (is_key_pressed($char_data['pressed_keys'], top_key))
			$char_data = move_top($char_data);
		else if (is_key_pressed($char_data['pressed_keys'], bottom_key))
			$char_data = move_bottom($char_data);
		else if (is_key_pressed($char_data['pressed_keys'], right_key))
			$char_data = move_right($char_data);
		else if (is_key_pressed($char_data['pressed_keys'], left_key))
			$char_data = move_left($char_data);
		else 
			$char_data['move_directions'] = [];
	}
	else {
		if (is_defense_key_pressed($char_data))
	  	$char_data['pressed_keys'] = arr_value_remove_by_value($char_data['pressed_keys'], square_key);
  	$char_data['pressed_keys'] = arr_value_remove_by_value($char_data['pressed_keys'], triangle_key);
  	$char_data['pressed_keys'] = arr_value_remove_by_value($char_data['pressed_keys'], top_key);
  	$char_data['pressed_keys'] = arr_value_remove_by_value($char_data['pressed_keys'], bottom_key);
  	$char_data['pressed_keys'] = arr_value_remove_by_value($char_data['pressed_keys'], left_key);
  	$char_data['pressed_keys'] = arr_value_remove_by_value($char_data['pressed_keys'], right_key);
	}

	// handle camera direction
	if (arr_value_exist($char_data['pressed_keys'], r1_key)) {
	  if (arr_value_exist($char_data['pressed_keys'], circle_key) ) {
		  if ($char_data['camera_direction'] == 'north')
		    $char_data['camera_direction'] = 'west';
		  else if ($char_data['camera_direction'] == 'west')
		    $char_data['camera_direction'] = 'south';
		  else if ($char_data['camera_direction'] == 'south')
		    $char_data['camera_direction'] = 'east';
		  else if ($char_data['camera_direction'] == 'east')
		    $char_data['camera_direction'] = 'north';
		}
	  else if (arr_value_exist($char_data['pressed_keys'], square_key) ) {
		  if ($char_data['camera_direction'] == 'north')
		    $char_data['camera_direction'] = 'east';
		  else if ($char_data['camera_direction'] == 'east')
		    $char_data['camera_direction'] = 'south';
		  else if ($char_data['camera_direction'] == 'south')
		    $char_data['camera_direction'] = 'west';
		  else if ($char_data['camera_direction'] == 'west')
		    $char_data['camera_direction'] = 'north';
		}
	}

	// handle camera position
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

	// get list of chars (players)
	// $char_names = getFileNamesInsideDir($dir.'places/'.$char_data['place_id'].'/')[DATA];
	$char_names = json_read($dir.'maps/'.$char_data['map_id'].'/players')[DATA];
	foreach ($char_names as $key => $value) {
		// if ($value == $char_data['char_id']) {
		// 	$_json = $char_data;
		// 	$_appearence = json_read($dir.'appearences/'.$value)[DATA];
		// 	$json['chars'][$value] = $_json;
		// 	$json['chars'][$value]['appearence'] = $_appearence;
		// 	$json['chars'][$value]['size'] = calculate_collision_size($_json);
		// }
		// else {
			$_json = json_read($dir.'players/'.$value)[DATA];
			$_appearence = json_read($dir.'appearences/'.$value)[DATA];
			$json['chars'][$value] = $_json;
			$json['chars'][$value]['appearence'] = $_appearence;
			$json['chars'][$value]['size'] = calculate_collision_size($_json);
// $res = get_distance(get_difference($p2['x'], $p1['x']), get_difference($p2['y'], $p1['y']));
			$json['chars'][$value]['distance'] = get_distance(get_difference($json['chars'][$value]['position']['x'], $char_data['position']['x']), get_difference($json['chars'][$value]['position']['z'], $char_data['position']['z']));
		// }
	}

	// handle attack action
	if ($char_data['char_current_action'] == 'attack' && 
			$char_data['char_stamina']['current'] >= atk_stamina) {
		// decreased player stamina
		$_status = json_read($dir.'players_status/'.$value)[DATA];
		$player_status = decrease_stamina($player_status, atk_stamina);
		json_save($dir.'players_status/', $char_data['char_id'], $player_status, $minify=false);
		// if there is enemy
		if (sizeof($char_data['enemies']) > 0) {
	  	$_char_data = $char_data;
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

	  	foreach ($char_data['enemies'] as $key => $value) {
				$_other_player = $json['chars'][$value];
				$_other_player['size'] = calculate_collision_size($_other_player);
		  	if (check_speak_to_npc($_char_data, $_other_player)) {
		  		if ($_other_player['char_current_action'] != 'defense' && $_other_player['char_health']['current'] > 0) {
						$items = json_read($dir.'items')[DATA];
						$_status = json_read($dir.'players_status/'.$value)[DATA];
						if ($char_data['char_gender'] == 'male')
							$_status = decrease_health($_status, male_base_atk + $items[$char_data['appearence']['rhand']]['atk']);
						else if ($char_data['char_gender'] == 'female')
							$_status = decrease_health($_status, female_base_atk + $items[$char_data['appearence']['rhand']]['atk']);
						json_save($dir.'players_status/', $value, $_status, $minify=false);
		  		}
		  		break;
		  	}
	  	}
		}
	}

	// check collision with other chars
	$char_data['size'] = calculate_collision_size($char_data);
	foreach ($json['chars'] as $key => $char) {
		if ($key !== $char_data['char_id']) {
			$is_collision = check_collision($json['chars'][$key], $char_data);
			if ($is_collision) {
				$char_data['position'] = $str['position'];
				$json['chars'][$char_data['char_id']]['position'] = $str['position'];
				break;
			}
		}
	}

	// check collision with properties
	$buildings = json_read($dir.'maps/'.$char_data['map_id'].'/buildings')[DATA];
	foreach ($buildings as $key => $value) {
		$is_colladed_building = check_collision_building($char_data, $value);
		if ($is_colladed_building) {
			$char_data['position'] = $str['position'];
			$json['chars'][$char_data['char_id']]['position'] = $str['position'];
			break;
		}
	}

	// check collision with npcs
	$npcs = json_read($dir.'maps/'.$char_data['map_id'].'/npcs')[DATA];
	foreach ($npcs as $key => $value) {
		$_npc = json_read($dir.'npcs/'.$value)[DATA];
		$_npc['size'] = calculate_collision_size($_npc);
		$is_colladed_npc = check_collision($char_data, $_npc);
		if ($is_colladed_npc) {
			$char_data['position'] = $str['position'];
			$json['chars'][$char_data['char_id']]['position'] = $str['position'];
			break;
		}
	}


	// // check collision with properties
	// $buildings = getFileNamesInsideDir($dir.'places/'.$char_data['place_id'].'_building/')[DATA];
	// foreach ($buildings as $key => $value) {
	// 	$_building = json_read($dir.'places/'.$char_data['place_id'].'_building/'.$value)[DATA];
	// 	$is_colladed_building = check_collision_building($char_data, $_building);
	// 	if ($is_colladed_building) {
	// 		$char_data['position'] = $str['position'];
	// 		$json['chars'][$char_data['char_id']]['position'] = $str['position'];
	// 		break;
	// 	}
	// }

	// // check collision with npcs
	// $npcs = getFileNamesInsideDir($dir.'places/'.$char_data['place_id'].'_npc/')[DATA];
	// foreach ($npcs as $key => $value) {
	// 	$_npc = json_read($dir.'places/'.$char_data['place_id'].'_npc/'.$value)[DATA];
	// 	$_npc['size'] = calculate_collision_size($_npc);
	// 	$is_colladed_npc = check_collision($char_data, $_npc);
	// 	if ($is_colladed_npc) {
	// 		$char_data['position'] = $str['position'];
	// 		$json['chars'][$char_data['char_id']]['position'] = $str['position'];
	// 		break;
	// 	}
	// }


	// handle speak with npc
	$json['props']['speak_to'] = '';
  if (is_speak_key_pressed($char_data)) {
  	$_char_data = $char_data;
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
			$_npc = json_read($dir.'npcs/'.$value)[DATA];
			$_npc['size'] = calculate_collision_size($_npc);
	  	if (check_speak_to_npc($_char_data, $_npc)) {
				$json['props']['speak_to'] = $_npc['char_id'];
	  		break;
	  	}
  	}
	}

	// handle poke to player
	$json['props']['poke_to_player'] = '';
  if (is_speak_key_pressed($char_data)) {
  	$_char_data = $char_data;
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
	  	if (check_speak_to_npc($_char_data, $_other_player)) {
				$json['props']['poke_to_player'] = $_other_player['char_id'];
	  		break;
	  	}
  	}
	}

	/* set last time play */
	// $date = new DateTime();
	// $char_data["active_date"] = date("y:m:d h:i:s");
	$char_data["active_date"] = microtime_float();

	// handle save char status
	$_appearence = json_read($dir.'appearences/'.$char_data['char_id'])[DATA];
	$char_data['appearence'] = $_appearence;

	$json['chars'][$char_data['char_id']] = $char_data;
	$json['chars'][$char_data['char_id']]['distance'] = 0;
	unset($char_data["size"]);
	if ($char_data != $str && $char_data['position']['x'] != null) {
		// json_save($dir.'places/'.$char_data["place_id"].'/', $char_data["char_id"], $char_data, $minify=false);
		json_save($dir.'players/', $char_data["char_id"], $char_data, $minify=false);
	}
	// $player_status = json_read($dir.'players_status/'.$char_data['char_id'])[DATA];
	// $json['chars'][$char_data['char_id']]['is_stamina_running_decreased'] = $player_status['is_stamina_running_decreased'];

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
	// printJson($char_data['size']['x']);
	// printJson($building_data['position']['x']-$building_data['collision_size']['x']);
	foreach ($char_data['size']['x'] as $xkey => $xvalue) {
		// printJson($building_data['position']['x']-$building_data['collision_size']['x']);
		// printJson($xvalue);
		if ($xvalue >= $building_data['position']['x']-$building_data['collision_size']['x'] && $xvalue <= $building_data['position']['x']+$building_data['collision_size']['x']) {
			foreach ($char_data['size']['z'] as $zkey => $zvalue) {
				if ($zvalue >= $building_data['position']['z']-$building_data['collision_size']['z'] && $zvalue <= $building_data['position']['z']+$building_data['collision_size']['z']) {
					return true;
				}
			}
		}
	}

	return false;

	// if ($char_data['size']['x'] >= $building_data['position']['x']-$building_data['collision_size']['x'] && 
	// 		$char_data['size']['x'] <= $building_data['position']['x']+$building_data['collision_size']['x'] &&
	// 		$char_data['size']['z'] >= $building_data['position']['z']-$building_data['collision_size']['z'] && 
	// 		$char_data['size']['z'] <= $building_data['position']['z']+$building_data['collision_size']['z'])
	// 	return true;
	// else
	// 	return false;
}

function check_collision($main_char_data, $other_char_data) {
	// $_main_char_data['size']['x'] = $main_char_data['size']['x'];
	// foreach ($_main_char_data['size']['x'] as $key => $value)
	// 	$_main_char_data['size']['x'][$key] += 1;

	// $x = array_intersect($_main_char_data['size']['x'], $other_char_data['size']['x']);

	// if (sizeof($x) == 0) {
	// 	$_main_char_data['size']['x'] = $main_char_data['size']['x'];
	// 	foreach ($_main_char_data['size']['x'] as $key => $value)
	// 		$_main_char_data['size']['x'][$key] -= 1;
	// 	$x = array_intersect($_main_char_data['size']['x'], $other_char_data['size']['x']);
	// }

	// $z = array_intersect($_main_char_data['size']['z'], $other_char_data['size']['z']);
	// if (sizeof($z) == 0)
	// 	$z = array_intersect($_main_char_data['size']['z'], $other_char_data['size']['z']);

	$x = array_intersect($main_char_data['size']['x'], $other_char_data['size']['x']);
	$z = array_intersect($main_char_data['size']['z'], $other_char_data['size']['z']);



	// printJson($main_char_data['size']);
	// printJson($other_char_data['size']);
	if (sizeof($x) != 0 && sizeof($z) != 0)
		return true;
	else
		return false;
}

function check_speak_to_npc($main_char_data, $other_char_data) {
	// $_main_char_data['size']['x'] = $main_char_data['size']['x'];
	// foreach ($_main_char_data['size']['x'] as $key => $value)
	// 	$_main_char_data['size']['x'][$key] += 1;

	// $x = array_intersect($_main_char_data['size']['x'], $other_char_data['size']['x']);

	// if (sizeof($x) == 0) {
	// 	$_main_char_data['size']['x'] = $main_char_data['size']['x'];
	// 	foreach ($_main_char_data['size']['x'] as $key => $value)
	// 		$_main_char_data['size']['x'][$key] -= 1;
	// 	$x = array_intersect($_main_char_data['size']['x'], $other_char_data['size']['x']);
	// }

	// $z = array_intersect($_main_char_data['size']['z'], $other_char_data['size']['z']);
	// if (sizeof($z) == 0)
	// 	$z = array_intersect($_main_char_data['size']['z'], $other_char_data['size']['z']);

	$x = array_intersect($main_char_data['size']['x'], $other_char_data['size']['x']);
	$z = array_intersect($main_char_data['size']['z'], $other_char_data['size']['z']);



	// printJson($main_char_data['size']);
	// printJson($other_char_data['size']);
	if (sizeof($x) != 0 && sizeof($z) != 0)
		return true;
	else
		return false;
}

function calculate_collision_size($char_data) {
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
		$val = floor($char_data['position']['x'] - ($i+1));
		array_push($pos_list['x'], $val);
	}
	for ($i=0; $i<$_width; $i++) {
		$val = ceil($char_data['position']['x'] + ($i+1));
		array_push($pos_list['x'], $val);
	}
	for ($i=0; $i<$_height; $i++) {
		$val = floor($char_data['position']['z'] - ($i+1));
		array_push($pos_list['z'], $val);
	}
	for ($i=0; $i<$_height; $i++) {
		$val = ceil($char_data['position']['z'] + ($i+1));
		array_push($pos_list['z'], $val);
	}

	return $pos_list;
}

function move_north($char_data, $_speed) {
  // $char_data['rotation']['y'] = pi() * 1;
  $char_data['position']['z'] -= $_speed;
  return $char_data;
}

function move_south($char_data, $_speed) {
  // $char_data['rotation']['y'] = pi() * 1;
  $char_data['position']['z'] += $_speed;
  return $char_data;
}

function move_east($char_data, $_speed) {
  // $char_data['rotation']['y'] = pi() * 1;
  $char_data['position']['x'] += $_speed;
  return $char_data;
}

function move_west($char_data, $_speed) {
  // $char_data['rotation']['y'] = pi() * 1;
  $char_data['position']['x'] -= $_speed;
  return $char_data;
}

function face_to($char_data, $direction) {
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
  return $char_data;
}

function move_top($char_data) {
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
    	$char_data = move_north($char_data, $_speed);
    	$char_data = face_to($char_data, 'north');
    	array_push($char_data['move_directions'], 'north');
    }
    else if ($char_data["camera_direction"] == 'south') {
    	$char_data = move_south($char_data, $_speed);
    	$char_data = face_to($char_data, 'south');
    	array_push($char_data['move_directions'], 'south');
    }
    else if ($char_data["camera_direction"] == 'east') {
    	$char_data = move_east($char_data, $_speed);
    	$char_data = face_to($char_data, 'east');
    	array_push($char_data['move_directions'], 'east');
    }
    else if ($char_data["camera_direction"] == 'west') {
    	$char_data = move_west($char_data, $_speed);
    	$char_data = face_to($char_data, 'west');
    	array_push($char_data['move_directions'], 'west');
    }
  }
  return $char_data;
}

function move_bottom($char_data) {
	if (is_key_pressed($char_data['pressed_keys'], triangle_key)) {
	// if (is_key_pressed($char_data['pressed_keys'], triangle_key)) {
  	$_speed = speed;
	}
  else {
  	
  	$_speed = walk_speed;
  }

  $char_data['move_directions'] = [];
  if ($char_data["camera_direction"] == 'north') {
  	$char_data = move_south($char_data, $_speed);
  	$char_data = face_to($char_data, 'south');
  	array_push($char_data['move_directions'], 'south');
  }
  else if ($char_data["camera_direction"] == 'south') {
  	$char_data = move_north($char_data, $_speed);
  	$char_data = face_to($char_data, 'north');
  	array_push($char_data['move_directions'], 'north');
  }
  else if ($char_data["camera_direction"] == 'east') {
  	$char_data = move_west($char_data, $_speed);
  	$char_data = face_to($char_data, 'west');
  	array_push($char_data['move_directions'], 'west');
  }
  else if ($char_data["camera_direction"] == 'west') {
  	$char_data = move_east($char_data, $_speed);
  	$char_data = face_to($char_data, 'east');
  	array_push($char_data['move_directions'], 'east');
  }
  return $char_data;
}

function move_right($char_data) {
	if (is_key_pressed($char_data['pressed_keys'], triangle_key)) {
	// if (is_key_pressed($char_data['pressed_keys'], triangle_key)) {
  	$_speed = speed;
	}
  else {
  	$_speed = walk_speed;
  }

  if (!is_key_pressed($char_data['pressed_keys'], top_key) && !is_key_pressed($char_data['pressed_keys'], bottom_key) && !is_key_pressed($char_data['pressed_keys'], left_key)) {
    if ($char_data["camera_direction"] == 'north') {
    	$char_data = move_east($char_data, $_speed);
    	$char_data = face_to($char_data, 'east');
    	array_push($char_data['move_directions'], 'east');
    }
    else if ($char_data["camera_direction"] == 'south') {
    	$char_data = move_west($char_data, $_speed);
    	$char_data = face_to($char_data, 'west');
    	array_push($char_data['move_directions'], 'west');
    }
    else if ($char_data["camera_direction"] == 'east') {
    	$char_data = move_south($char_data, $_speed);
    	$char_data = face_to($char_data, 'south');
    	array_push($char_data['move_directions'], 'south');
    }
    else if ($char_data["camera_direction"] == 'west') {
    	$char_data = move_north($char_data, $_speed);
    	$char_data = face_to($char_data, 'north');
    	array_push($char_data['move_directions'], 'north');
    }
  }
  return $char_data;
}

function move_left($char_data) {
	if (is_key_pressed($char_data['pressed_keys'], triangle_key)) {
	// if (is_key_pressed($char_data['pressed_keys'], triangle_key)) {
  	$_speed = speed;
	}
  else {
  	$_speed = walk_speed;
  }

  if (!is_key_pressed($char_data['pressed_keys'], top_key) && !is_key_pressed($char_data['pressed_keys'], bottom_key) && !is_key_pressed($char_data['pressed_keys'], right_key)) {
    if ($char_data["camera_direction"] == 'north') {
    	$char_data = move_west($char_data, $_speed);
    	$char_data = face_to($char_data, 'west');
    	array_push($char_data['move_directions'], 'west');
    }
    else if ($char_data["camera_direction"] == 'south') {
    	$char_data = move_east($char_data, $_speed);
    	$char_data = face_to($char_data, 'east');
    	array_push($char_data['move_directions'], 'east');
    }
    else if ($char_data["camera_direction"] == 'east') {
    	$char_data = move_north($char_data, $_speed);
    	$char_data = face_to($char_data, 'north');
    	array_push($char_data['move_directions'], 'north');
    }
    else if ($char_data["camera_direction"] == 'west') {
    	$char_data = move_south($char_data, $_speed);
    	$char_data = face_to($char_data, 'south');
    	array_push($char_data['move_directions'], 'south');
    }
  }
  return $char_data;
}

function is_key_pressed($map, $key) {
	if (arr_value_exist($map, $key))
		return true;
	else
		return false;
}

function get_char_data($char_id) {
	$dir = BASE_DIR .'/storages/light/';
	$json = json_read($dir .'players/' . $char_id)[DATA];

	$player_status = json_read($dir .'players_status/' . $char_id)[DATA];
	$default = json_read($dir .'players_status/default')[DATA];
	foreach ($default as $key => $value) {
		$player_status[$key] = $value;
	}
	foreach ($player_status as $key => $value) {
		$json[$key] = $value;
	}
	json_save($dir.'players_status/', $char_id, $player_status, $minify=false);
	json_save($dir.'players/', $char_id, $json, $minify=false);

	$json = json_encode($json);
	return $json;
}

function get_item_data() {
	$dir = BASE_DIR .'/storages/light/items';
	$json = json_read($dir)[DATA];
	$json = json_encode($json);
	return $json;
}

// function get_inventory($char_id) {
// 	$dir = BASE_DIR .'/storages/light/';
// 	$json = json_read($dir .'inventories/' . $char_id)[DATA];
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
  // $slot_num["0"] = "lhand";
  // $slot_num["1"] = "rhand";
  // $slot_num["2"] = "suit";
  // $slot_num["3"] = "gloves";
  // $slot_num["4"] = "shoes";
  // $slot_num["5"] = "head";
  // $slot_num["6"] = "glasses";
  // $slot_num["7"] = "mask";
  // $slot_num["8"] = "back";
  // $slot_num["9"] = "top";
  // return $slot_num;
}


// function post_use_item($slot_position, $slot_num, $player_id) {

// 	$dir = BASE_DIR .'/storages/light/';
// 	$inventory = json_read($dir .'inventories/' . $player_id)[DATA];
// 	if ($slot_position == 'table_right') {
// 		$items = json_read($dir.'items')[DATA];

// 		$item_id = '';
// 		$index = 0;
// 		for ($i=0; $i<sizeof($inventory['table_right']); $i++) {
// 			if ($inventory['table_right'][$i]['slot_num'] == $slot_num) {
// 				$item_id = $inventory['table_right'][$i]['item_id'];
// 				$index = $i;
// 				break;
// 			}
// 		}

// 		if ($item_id == '') {
// 			$inventory = json_encode($inventory);
// 			return $inventory;
// 		}

// 		$_item = $items[$item_id];

// 		if ($items[$item_id]['is_quantable_item']) {

// 		}
// 		else {
// 			$_item_slot_num = get_left_item_slot_num_by_item_type($_item['type'])['slot_num'];

// 			$left_item_id = '';
// 			$left_index = 0;
// 			for ($i=0; $i<sizeof($inventory['table_left']); $i++) { # get index of the item in inventory and id of the item.
// 				if ($inventory['table_left'][$i]['slot_num'] == $_item_slot_num) {
// 					$left_item_id = $inventory['table_left'][$i]['item_id'];
// 					$left_index = $i;
// 					break;
// 				}
// 			}

// 			if ($left_item_id == '') { # if there is no item in the left then remove the item in the right
// 				$inventory['table_right'] = arr_value_remove_by_index($inventory['table_right'], $index);
// 			}
// 			else { # if there is item in the left then replace the item in the right with item in the left
// 				$inventory['table_right'][$index]['item_id'] = $left_item_id;
// 				$inventory['table_left'] = arr_value_remove_by_index($inventory['table_left'], $left_index);
// 			}

// 			array_push($inventory['table_left'], arr_to_json(array( # add the item in the left
// 				'slot_num' => $_item_slot_num,
// 				'item_id' => $item_id
// 			)));

// 			$appearence = json_read($dir.'appearences/'.$player_id)[DATA];
// 			$appearence[get_left_item_slot_num_by_item_type($_item['type'])['item_type']] = $item_id;
// 			json_save($dir.'appearences/', $player_id, $appearence, $minify=false);
// 		}
	
// 		json_save($dir.'inventories/', $player_id, $inventory, $minify=false);

// 	}
// 	else if ($slot_position == 'table_left') {
// 		$item_id = '';
// 		$index = 0;
// 		for ($i=0; $i<sizeof($inventory['table_left']); $i++) {
// 			if ($inventory['table_left'][$i]['slot_num'] == $slot_num) {
// 				$item_id = $inventory['table_left'][$i]['item_id'];
// 				$index = $i;
// 				break;
// 			}
// 		}
// 		if ($item_id == '') {
// 			$inventory = json_encode($inventory);
// 			return $inventory;
// 		}
// 		if (sizeof($inventory['table_right']) >= total_item_limit) {
// 			$inventory = json_encode($inventory);
// 			return $inventory;
// 		}

// 		$items = json_read($dir.'items')[DATA];
// 		$_item = $items[$item_id];

// 		$inventory['table_left'] = arr_value_remove_by_index($inventory['table_left'], $index);
// 		$slot_num = get_avail_slot_num($inventory);

// 		array_push($inventory['table_right'], arr_to_json(array(
// 			'slot_num' => $slot_num,
// 			'item_id' => $item_id,
// 			'item_quantity' => 1
// 		)));

// 		json_save($dir.'inventories/', $player_id, $inventory, $minify=false);

// 		$appearence = json_read($dir.'appearences/'.$player_id)[DATA];
// 		$appearence[get_left_item_slot_num_by_item_type($_item['type'])['item_type']] = '';
// 		json_save($dir.'appearences/', $player_id, $appearence, $minify=false);
// 	}

// 	$inventory = json_encode($inventory);
// 	return $inventory;
// }

function get_npc_data($place_id) {
	$dir = BASE_DIR .'/storages/light/places/';
	$filenames = getFileNamesInsideDir($dir . $place_id.'_'.'npc/')[DATA];

	foreach ($filenames as $key => $value) {
		$_json = json_read($dir . $place_id.'_'.'npc/'.$value)[DATA];
		$json[$value] = $_json;
	}

	$json = json_encode($json);
	return $json;
}

function get_quest($player_id, $npc_id) {
	$dir = BASE_DIR .'/storages/light/quests/';
	$quest = json_read($dir . $npc_id)[DATA];

	$dir = BASE_DIR .'/storages/light/quests/players/';
	$player_quest = json_read($dir . $player_id)[DATA];
	// printJson($player_quest);
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


function post_quest_answer($answer, $npc_id, $player_id) {
	$dir = BASE_DIR .'/storages/light/quests/';
	$quest = json_read($dir . $npc_id)[DATA];

	$dir = BASE_DIR .'/storages/light/quests/players/';
	$player_quest = json_read($dir . $player_id)[DATA];

	if (arr_value_exist($quest['quest'][$player_quest[$npc_id]]['answer'], $answer)) {
		$reward_item_id = $quest['quest'][$player_quest[$npc_id]]['reward_item'];

		if ($reward_item_id !== '') {
			$dir = BASE_DIR .'/storages/light/items';
			$items = json_read($dir)[DATA];

			$dir = BASE_DIR .'/storages/light/inventories/';
			$inventory = json_read($dir . $player_id)[DATA];

			if ($items[$reward_item_id]['is_quantable_item']) {
				for ($i=0; $i<sizeof($inventory['table_right']); $i++) {
					if ($inventory['table_right'][$i]['item_id'] == $reward_item_id) {
						$inventory['table_right'][$i]['item_quantity'] += $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity'];
						$is_exist = true;
						break;
					}
				}
				$json['info'] = arr_to_json(array(
					'type' => 'green',
					'text' => "Anda mendapatkan ". $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity'] ." item " . $items[$reward_item_id]['name']
				));
				$json['type'] = 'reply';
				$json['talk'] = $quest['quest'][$player_quest[$npc_id]]['right_answer'];

				$dir = BASE_DIR .'/storages/light/inventories/';
				json_save($dir, $player_id, $inventory, $minify=false);
			}
			else if (sizeof($inventory['table_right']) < total_item_limit) {
				$slot_num = get_avail_slot_num($inventory);
				array_push($inventory['table_right'], arr_to_json(array(
					'slot_num' => $slot_num,
					'item_id' => $reward_item_id,
					'item_quantity' => $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity']
				)));

				$dir = BASE_DIR .'/storages/light/inventories/';
				json_save($dir, $player_id, $inventory, $minify=false);

				$json['info'] = arr_to_json(array(
					'type' => 'green',
					'text' => "Anda mendapatkan ". $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity'] ." item " . $items[$reward_item_id]['name']
				));
				$json['type'] = 'reply';
				$json['talk'] = $quest['quest'][$player_quest[$npc_id]]['right_answer'];
			}
			else {
				$_reply = [];
	      array_push($_reply,  arr_to_json(array("type"=>"xchoice", "text"=>"Aku tidak bisa memberikan barang karena inventorimu penuh.")));

				$json['info'] = arr_to_json(array(
					'type' => 'red',
					'text' => 'Inventorimu penuh.'
				));
				$json['type'] = 'reply';
				$json['talk'] = $_reply;
			}
		}
	}
	else if ($answer == 'not_answer') {
		$json['type'] = 'reply';
		$json['talk'] = $quest['quest'][$player_quest[$npc_id]]['not_answer'];
	}
	else {
		$json['type'] = 'reply';
		$json['talk'] = $quest['quest'][$player_quest[$npc_id]]['wrong_answer'];
	}

	$json = json_encode($json);
	return $json;
}

function post_quest_answer2($answer, $npc_id, $player_id) {
	$dir = BASE_DIR .'/storages/light/quests/';
	$quest = json_read($dir . $npc_id)[DATA];

	$dir = BASE_DIR .'/storages/light/quests/players/';
	$player_quest = json_read($dir . $player_id)[DATA];

	if (arr_value_exist($quest['quest'][$player_quest[$npc_id]]['answer'], $answer)) {
		$reward_item_id = $quest['quest'][$player_quest[$npc_id]]['reward_item'];

		if ($reward_item_id !== '') {
			$dir = BASE_DIR .'/storages/light/items';
			$items = json_read($dir)[DATA];

			$dir = BASE_DIR .'/storages/light/inventories/';
			$inventory = json_read($dir . $player_id)[DATA];

			if ($items[$reward_item_id]['is_quantable_item']) {
				for ($i=0; $i<sizeof($inventory); $i++) {
					if ($inventory[$i]['item_id'] == $reward_item_id) {
						$inventory[$i]['item_quantity'] += $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity'];
						$is_exist = true;
						break;
					}
				}
				$json['info'] = arr_to_json(array(
					'type' => 'green',
					'text' => "Anda mendapatkan ". $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity'] ." item " . $items[$reward_item_id]['name']
				));
				$json['type'] = 'reply';
				$json['talk'] = $quest['quest'][$player_quest[$npc_id]]['right_answer'];

				$dir = BASE_DIR .'/storages/light/storages/';
				json_save($dir, $player_id, $inventory, $minify=false);
			}
			else if (sizeof($inventory) < total_item_limit) {
				
				$is_exist = false;
				// else {
				// 		$storage[$reward_item_id] = arr_to_json(array('quantity' => $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity']));
				// }
				if (!$is_exist) {
					$slot_num_list = [];
					for ($i=0; $i<sizeof($inventory); $i++) {
						array_push($slot_num_list, $inventory[$i]['slot_num']);
					}

					$slot_num = 0;
					$slot_exist = true;
					while ($slot_exist) {
						if (arr_value_exist($slot_num_list, $slot_num)) {
							$slot_num += 1;
						}
						else {
							$slot_exist = false;
						}
					}
					array_push($inventory, arr_to_json(array(
						'slot_num' => $slot_num,
						'item_id' => $reward_item_id,
						'item_quantity' => $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity']
					)));
				}

				$dir = BASE_DIR .'/storages/light/storages/';
				json_save($dir, $player_id, $inventory, $minify=false);

				$json['info'] = arr_to_json(array(
					'type' => 'green',
					'text' => "Anda mendapatkan ". $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity'] ." item " . $items[$reward_item_id]['name']
				));
				$json['type'] = 'reply';
				$json['talk'] = $quest['quest'][$player_quest[$npc_id]]['right_answer'];
			}
			else {
				$_reply = [];
	      array_push($_reply,  arr_to_json(array("type"=>"xchoice", "text"=>"Aku tidak bisa memberikan barang karena inventorimu penuh.")));

				$json['info'] = arr_to_json(array(
					'type' => 'red',
					'text' => 'Inventorimu penuh.'
				));
				$json['type'] = 'reply';
				$json['talk'] = $_reply;
			}
		}
	}
	else if ($answer == 'not_answer') {
		$json['type'] = 'reply';
		$json['talk'] = $quest['quest'][$player_quest[$npc_id]]['not_answer'];
	}
	else {
		$json['type'] = 'reply';
		$json['talk'] = $quest['quest'][$player_quest[$npc_id]]['wrong_answer'];
	}

	$json = json_encode($json);
	return $json;
}

function get_building_data($place_id) {
	$dir = BASE_DIR .'/storages/light/places/';
	$filenames = getFileNamesInsideDir($dir . $place_id.'_'.'building/')[DATA];
	foreach ($filenames as $key => $value) {
		$_json = json_read($dir . $place_id.'_'.'building/'.$value)[DATA];
		$json[$value] = $_json;
	} $json = json_encode($json);
	return $json;
}

// function post_ask_to_join_guild($char_id, $asked_char_id, $guild_id) {
// 	$dir = BASE_DIR .'/storages/light/';
// 	// handle ask for guild confirmation
// 	$date = new DateTime();
// 	$confirmation_id = md5($char_id.$asked_char_id.$date->getTimestamp());
// 	$json = arr_to_json(array(
// 		'confirmation_id' => $confirmation_id,
// 		'confirmation_type' => 'guild_recruitment',
// 		'guild_id' => $guild_id,
// 		'asked_to' => $asked_char_id,
// 		'asked_by' => $char_id,
// 		'is_agreed' => ''
// 	));
// 	json_save($dir.'confirmations/', $confirmation_id, $json, $minify=false);

// 	// handle asked char data		
// 	$asked_char_data = json_read($dir . 'players_status/'.$asked_char_id)[DATA];
// 	$asked_char_data['confirmation_id'] = $confirmation_id;
// 	json_save($dir.'players_status/', $asked_char_id, $asked_char_data, $minify=false);

// 	// handle asking char data		
// 	$char_data = json_read($dir . 'players_status/'.$char_id)[DATA];
// 	$char_data['confirmation_id'] = $confirmation_id;
// 	json_save($dir.'players_status/', $char_id, $char_data, $minify=false);

// 	return true;
// }


?>