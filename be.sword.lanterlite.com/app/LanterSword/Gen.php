<?php if (!defined('BASEPATH')) exit('no direct script access allowed');


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

function stamina_changed($player_id) {
	// write_log('sword', 'asd');
	$player_status = get_player($player_id);
	$increasable = true;

	/* if player is in battle and dead, dont increase */
	if ($player_status['battle_id'] != '' or $player_status['duel_id'] != '') {
		if ($player_status['stamina_cur'] <= 0) {
			$increasable = false;
		}
	}
		// set_player($player_id, 'system_chat', $increasable);

	if ($increasable and !$player_status['stamina_changed']) {
		if ($player_status['stamina_cur'] > 0 and key_pressed($player_status['pressed_keys'], 'run')) {
			$player_status['stamina_changed'] = 1;
			set_player($player_id, 'stamina_changed', $player_status['stamina_changed']);
			$player_status = decrease_stamina($player_status, 25);
			set_player($player_id, 'stamina_cur', $player_status['stamina_cur']);

			sleep(1);
			$player_status['stamina_changed'] = 0;
			set_player($player_id, 'stamina_changed', $player_status['stamina_changed']);

			return 'decrease';
		}

		else if ($player_status['stamina_cur'] > 0 and is_defense_key_pressed($player_status)) {
			$player_status['stamina_changed'] = 1;
			set_player($player_id, 'stamina_changed', $player_status['stamina_changed']);
			$player_status = decrease_stamina($player_status, 10);
			set_player($player_id, 'stamina_cur', $player_status['stamina_cur']);
			// set_player($player_id, 'char_stamina', $player_status['char_stamina']);

			sleep(1);
			$player_status['stamina_changed'] = 0;
			set_player($player_id, 'stamina_changed', $player_status['stamina_changed']);
			return 'decrease';
		}

		else if ($player_status['stamina_cur'] < $player_status['stamina_max']) {
			$player_status['stamina_changed'] = 1;
			set_player($player_id, 'stamina_changed', $player_status['stamina_changed']);

			$player_status = increase_stamina($player_status, 25);
			set_player($player_id, 'stamina_cur', $player_status['stamina_cur']);

			sleep(2);
			$player_status['stamina_changed'] = 0;
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

function decrease_status(&$status, $decreased_by) {
	$status['current'] -= $decreased_by;
	if ($status['current'] < 0)
		$status['current'] = 0;
}

function increase_status(&$status, $increased_by) {
	$status['current'] += $increased_by;
	if ($status['current'] > $status['max'])
		$status['current'] = $status['max'];
}

function decrease_health($player_status, $decreased_by) {
	$player_status['health_cur'] -= $decreased_by;
	if ($player_status['health_cur'] < 0)
		$player_status['health_cur'] = 0;
	return $player_status;
}

function decrease_stamina($player_status, $decreased_by) {
	$player_status['stamina_cur'] -= $decreased_by;
	if ($player_status['stamina_cur'] < 0)
		$player_status['stamina_cur'] = 0;
	return $player_status;
}

function increase_health($player_status, $increased_by) {
	$player_status['health_cur'] += $increased_by;
	if ($player_status['health_cur'] > $player_status['health_max'])
		$player_status['health_cur'] = $player_status['health_max'];
	return $player_status;
}

function increase_stamina($player_status, $increased_by) {
	$player_status['stamina_cur'] += $increased_by;
	if ($player_status['stamina_cur'] > $player_status['stamina_max'])
		$player_status['stamina_cur'] = $player_status['stamina_max'];
	return $player_status;
}

function change_map($map_id, &$player, $portal) {
	// printJson($player);

	/* remove player data in old map */
	$map = LGen('JsonMan')->read(dir.'maps/'.$player['map_id'].'/players');
	LGen('ArrayMan')->rmv_by_val($map, $player['char_id']);
	LGen('JsonMan')->save(dir.'maps/'.$player['map_id'],'/players', $map, $minify=false);

	/* replace old map id with new map id */
	$player['map_id'] = $map_id;

	/* add player data in new map */
	$map = LGen('JsonMan')->read(dir.'maps/'.$player['map_id'].'/players');
	if (!in_array($player['char_id'], $map)) {
		array_push($map, $player['char_id']);
		LGen('JsonMan')->save(dir.'maps/'.$player['map_id'],'/players', $map, $minify=false);
	}


	$player['position'] = $portal['p_pos'];
	$player['rotation'] = $portal['p_rot'];
	$player['move_directions'] = [];

	set_player($player['char_id'], 'move_directions', $player['move_directions']);
	set_player($player['char_id'], 'position', $player['position']);
	set_player($player['char_id'], 'rotation', $player['rotation']);
	set_player($player['char_id'], 'map_id', $player['map_id']);
}

function add_tasklist($player_id, $task) {
	$tasklist = get_player($player_id, 'tasklist');
	array_push($tasklist, $task);
	set_player($player_id, 'tasklist', $tasklist);
}

function asd2($user_id) {
	return '($pstat)';
}

function get_char_by_user_id($user_id) {
	$pstat = LGen('JsonMan')->read(dir.'citizen_chars/'.$user_id);
	// return '($pstat)';
	// return ($pstat);
	return $pstat;
}

function set_char_by_user_id($user_id, $char_id, $char_gender) {
	if ($user_id === '' && $char_id === '') {
		return 'Failed to create char.';
	}

	$forbidden_name = LGen('JsonMan')->read(dir.'settings/forbidden_names');
	if (LGen('ArrayMan')->is_val_exist($forbidden_name, LGen('StringMan')->to_lower($char_id)))
		return 'Char Name is unavailable.';
	// foreach ($forbidden_name as $key => $value) {
	// 	if (LGen('StringMan')->to_upper($value) === LGen('StringMan')->to_upper($char_id)) {
	// 		return 'Char Name is unavailable.';
	// 	}
	// }

	$char_name = get_player($char_id);
	if ($char_name !== LGen('GlobVar')->not_found)
		return 'Char Name is unavailable.';

	// return LGen('ArrayMan')->print($forbidden_name);
	LGen('JsonMan')->save(dir.'citizen_chars/', $user_id, $char_id, $minify=false);
	$def_stat = get_player('__default__');
	$def_stat['char_id'] = $char_id;
	$def_stat['char_name'] = LGen('StringMan')->to_upper($user_id[0]);
	$def_stat['char_gender'] = $char_gender;
	if ($char_gender === 'male') {
		$def_stat['appearence']['headskin'] = 'HS01';
		$def_stat['appearence']['hair'] = 'HA00';
	}
	else {
		$def_stat['appearence']['headskin'] = 'HS00';
		$def_stat['appearence']['hair'] = 'HA50';

	}

	foreach ($def_stat as $key => $value) {
		set_player($char_id, $key, $value);
	}

	$map = LGen('JsonMan')->read(dir.'maps/'.$def_stat['map_id'].'/players');
	array_push($map, $def_stat['char_id']);
	LGen('JsonMan')->save(dir.'maps/'.$def_stat['map_id'],'/players', $map, $minify=false);

	return 1;
}

function get_char_all($obj) {
	$char_id = $obj['val']['char_id'];

	$char = [];

	$_obj = [];
	$_obj['namelist'] = 'all';
	$_obj['def'] = '@chars';
	$_obj['bridge'] = [];
	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chars", "puzzled":true}'));
	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$char_id.'", "puzzled":false}'));
	$base_bridge = $_obj['bridge'];
	$char = LGen('SaviorMan2')->read($_obj);
	$char['position'] = [];
	$char['position']['x'] = $char['pos_x'];
	$char['position']['y'] = $char['pos_y'];
	$char['position']['z'] = $char['pos_z'];

	$char['rotation'] = [];
	$char['rotation']['x'] = $char['rot_x'];
	$char['rotation']['y'] = $char['rot_y'];
	$char['rotation']['z'] = $char['rot_z'];
	// $_obj['bridge'] = $base_bridge;
	// $_obj['def'] = '@chars/appearence';
	// $_obj['namelist'] = ["headskin", "hair", "eyes", "rhand", "lhand", "suit", "gloves", "shoes", "head", "glasses", "mask", "back", "top"];
	// array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "appearence", "puzzled":true}'));
	// $char['appearence'] = LGen('SaviorMan2')->read($_obj);

	// $_obj['bridge'] = $base_bridge;
	// $_obj['def'] = '@chars/equipment';
	// $_obj['namelist'] = ["rhand", "lhand", "suit", "gloves", "shoes", "head", "glasses", "mask", "back", "top"];
	// array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "appearence", "puzzled":true}'));
	// $char['equipment'] = LGen('SaviorMan2')->read($_obj);

	return $char;			
}


function get_player($player_id, $key='all') {
	if ($key == 'all') {
		// $status = getFileNamesInsideDir(dir.'players/'.$player_id.'/');
		// if ($status === LGen('GlobVar')->not_found)
		// 	return $status;
		// $player = null;
		// if ($status == null)
		// 	$player = [];
		// foreach ($status as $key => $value) {
		// 	$pstat = LGen('JsonMan')->read(dir.'players/'.$player_id.'/'.$value);
		// 	$player[$value] = $pstat;
		// }
		$obj = [];
		$obj['val'] = [];
		$obj['val']['char_id'] = $player_id;
		$player = get_char_all($obj);
		return $player;
	}
	else {
		$_obj = [];
		$_obj['namelist'] = [];
		if (gettype($key) === 'array')
			$_obj['namelist'] = $key;
		else
			array_push($_obj['namelist'], $key);
		$_obj['def'] = '@chars';
		$_obj['bridge'] = [];
		array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chars", "puzzled":true}'));
		array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$player_id.'", "puzzled":false}'));

		if ($key === 'position') {
			$_obj['namelist'] = ['pos_x','pos_y','pos_z'];
			$_pos = LGen('SaviorMan2')->read($_obj)[$key];
			$pstat = [];
			$pstat['x'] = $_pos['x'];
			$pstat['y'] = $_pos['y'];
			$pstat['z'] = $_pos['z'];
		}
		else if ($key === 'rotation') {
			$_obj['namelist'] = ['rot_x','rot_y','rot_z'];
			$_rot = LGen('SaviorMan2')->read($_obj)[$key];
			$pstat = [];
			$pstat['x'] = $_rot['x'];
			$pstat['y'] = $_rot['y'];
			$pstat['z'] = $_rot['z'];
		}
		else {
			$pstat = LGen('SaviorMan2')->read($_obj)[$key];
		}

		// $pstat = LGen('JsonMan')->read(dir.'players/'.$player_id.'/'.$key);
		return $pstat;
	}
	error_log($pstat);
}

function get_player2($player_id, $key='all') {

	if ($key == 'all') {
		$status = getFileNamesInsideDir(dir.'players/'.$player_id.'/');
		if ($status === LGen('GlobVar')->not_found)
			return $status;
		$player = null;
		if ($status == null)
			$player = [];
		foreach ($status as $key => $value) {
			$pstat = LGen('JsonMan')->read(dir.'players/'.$player_id.'/'.$value);
			$player[$value] = $pstat;
		}
		return $player;
	}
	else {
		$pstat = LGen('JsonMan')->read(dir.'players/'.$player_id.'/'.$key);
		return $pstat;
	}
	error_log($pstat);
}

function get_npc($npc_id, $key='all') {

	if ($key == 'all') {
		$status = getFileNamesInsideDir(dir.'npcs/'.$npc_id.'/');
		$npc = null;
		if ($status == null)
			$npc = [];
		foreach ($status as $key => $value) {
			$pstat = LGen('JsonMan')->read(dir.'npcs/'.$npc_id.'/'.$value);
			$npc[$value] = $pstat;
		}
		return $npc;
	}
	else {
		$pstat = LGen('JsonMan')->read(dir.'npcs/'.$npc_id.'/'.$key);
		return $pstat;
	}
}


function set_player($player_id, $key, $value) {
	if ($value === null)
		return 0;
	$_obj = [];
	$_obj['val'] = [];
	$_obj['val'][$key] = $value;
	$_obj['def'] = '@chars';
	$_obj['is_bw'] = 0;
	$_obj['bridge'] = [];
	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chars", "puzzled":true}'));
	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$player_id.'", "puzzled":false}'));

	if ($key === 'position') {
		$_obj['val'] = [];
		$_obj['val']['pos_x'] = $value['x'];
		$_obj['val']['pos_y'] = $value['y'];
		$_obj['val']['pos_z'] = $value['z'];
	}

	LGen('SaviorMan2')->update($_obj);
}

function set_player2($player_id, $key, $value) {
	if ($value !== null)
		LGen('JsonMan')->save(dir.'players/'.$player_id.'/', $key, $value, $minify=false);
}

function handle_trading(&$client_char, $server_char) {
	if ($server_char['trade_id'] != '') {
		$trade = LGen('JsonMan')->read(dir.'trades/'.$server_char['trade_id']);
		if ($trade === LGen('GlobVar')->failed) {
			$server_char['trade_id'] = '';
			set_player($client_char['char_id'], 'trade_id', $server_char['trade_id']);
			// $client_char['system_chat'] = 'Trade ended.';
		}
	}
	$client_char['trade_id'] = $server_char['trade_id'];
}

function handle_map_change(&$client_char, $server_char) {
	if ($client_char['map_id'] != $server_char['map_id']) {
		set_player($client_char['char_id'], $server_char['map_id']);
		$client_char['map_changed'] = 1;
	}
	else {
		if ($client_char['map_changed'])
			set_player($client_char['char_id'], $server_char['map_id']);
		$client_char['map_changed'] = 0;
	}
}

function handle_duel(&$client_char, $server_char) {
	if ($server_char['duel_id'] != '') {
		$duel = LGen('JsonMan')->read(dir.'duels/'.$server_char['duel_id']);
		if ($duel === LGen('GlobVar')->failed) {
			$server_char['duel_id'] = '';
			set_player($client_char['char_id'], 'duel_id', $server_char['duel_id']);
			// $client_char['system_chat'] = 'Duel is over.';
		}
	}
	$client_char['duel_id'] = $server_char['duel_id'];
}

function handle_battle(&$client_char, $server_char) {
	if ($server_char['battle_id'] != '') {
		$battle = LGen('JsonMan')->read(dir.'battles/'.$server_char['battle_id']);
		if ($battle === LGen('GlobVar')->failed) {
			$server_char['battle_id'] = '';
			set_player($client_char['char_id'], 'battle_id', $server_char['battle_id']);
			// $client_char['system_chat'] = 'Battle is over.';
		}
	}
	$client_char['battle_id'] = $server_char['battle_id'];
}

function handle_confirmation(&$client_char, $server_char) {
	$client_char['confirmation'] = '';
	if ($server_char['confirmation_id'] != '') {
		$confirmation = LGen('JsonMan')->read(dir.'confirmations/'.$server_char['confirmation_id']);
		if ($confirmation === LGen('GlobVar')->failed) {
			$server_char['confirmation_id'] = '';
			set_player($client_char['char_id'], 'confirmation_id', $server_char['confirmation_id']);
			$client_char['confirmation'] = '';
		}
		else {
			// $client_char['confirmation'] = $confirmation;
		}
	}
	$client_char['confirmation_id'] = $server_char['confirmation_id'];
}

function handle_moving(&$client_char, $server_char) {
	if ($client_char['health_cur'] > 0 and $client_char['stamina_cur'] > 100) {
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
	  	LGen('ArrayMan')->rmv_by_val($client_char['pressed_keys'], square_key);
  	LGen('ArrayMan')->rmv_by_val($client_char['pressed_keys'], triangle_key);
  	LGen('ArrayMan')->rmv_by_val($client_char['pressed_keys'], top_key);
  	LGen('ArrayMan')->rmv_by_val($client_char['pressed_keys'], bottom_key);
  	LGen('ArrayMan')->rmv_by_val($client_char['pressed_keys'], left_key);
  	LGen('ArrayMan')->rmv_by_val($client_char['pressed_keys'], right_key);
		set_player($client_char['char_id'], 'pressed_keys', $client_char['pressed_keys']);
	}
}

function handle_camera_direction(&$client_char) {
	if (LGen('ArrayMan')->is_val_exist($client_char['pressed_keys'], r1_key)) {
	  if (LGen('ArrayMan')->is_val_exist($client_char['pressed_keys'], circle_key) ) {
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
	  else if (LGen('ArrayMan')->is_val_exist($client_char['pressed_keys'], square_key) ) {
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

function handle_attack($client_char, $server_char, $json) {
	if ($client_char['char_current_action'] == 'attack' && $client_char['stamina_cur'] >= atk_stamina) {
		$server_char = decrease_stamina($server_char, atk_stamina);
		$client_char = decrease_stamina($client_char, atk_stamina);
		set_player($client_char['char_id'], 'stamina_cur', $server_char['stamina_cur']);
		
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
		  		if ($_other_player['char_current_action'] != 'defense' && $_other_player['health_cur'] > 0) {
						$_items = LGen('JsonMan')->read(dir.'items');
						$_status['char_health'] = get_player($value, 'char_health');
						if ($client_char['char_gender'] == 'male')
							decrease_status($_status['char_health'], male_base_atk + $_items[$client_char['appearence']['rhand']]['atk']);
							// $_status = decrease_health($_status, male_base_atk + $_items[$client_char['appearence']['rhand']]['atk']);
						else if ($client_char['char_gender'] == 'female')
							decrease_status($_status['char_health'], female_base_atk + $_items[$client_char['appearence']['rhand']]['atk']);
							// $_status = decrease_health($_status, female_base_atk + $_items[$client_char['appearence']['rhand']]['atk']);
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

function add_to_system_chat($player_id, $obj=[]) {
	$system_chat = get_player($player_id, 'system_chat');
	if ($system_chat === '')
		$system_chat = [];
	if (LGen('JsonMan')->is_json($obj)) {
		array_push($system_chat, $obj); 
	}
	else if (is_array($obj)) {
		foreach ($obj as $key => $value) {
			array_push($system_chat, $value); 
		}
	}
	set_player($player_id, 'system_chat', $system_chat);
}

function check_level_up($player_id) {
	$exp_cur = get_player($player_id, 'exp_cur');
	$exp_max = get_player($player_id, 'exp_max');
	if ($exp_cur >= $exp_max) {
		$exp_cur = $exp_cur - $exp_max;
		$char_level = get_player($player_id, 'char_level');
		$char_level += 1;
		set_player($player_id, 'exp_cur' , $exp_cur);
		set_player($player_id, 'char_level' , $char_level);
		include dir.'lang/server/'.get_player($player_id, 'lang').'.php';
		add_to_system_chat($player_id, LGen('ArrayMan')->to_json(array('type' => 'blue','text' => YOU_HAVE_REACHED_LEVEL . ' ' . $char_level . '.')));
	}
}

function post_char_data($char_data) {
	// echo ($char_data);
	// echo findKb(($char_data));
	// echo findKb(($char_data));
	$player_status = get_player($char_data['char_id']);

	/* init json (response) */
	$json['props'] = [];
	$json['chars'] = [];

	check_level_up($char_data['char_id']);

	/* init char data from server */
	$char_data['system_chat'] = $player_status['system_chat'];
	$char_data['health_cur'] = $player_status['health_cur'];
	$char_data['health_max'] = $player_status['health_max'];
	$char_data['stamina_cur'] = $player_status['stamina_cur'];
	$char_data['stamina_max'] = $player_status['stamina_max'];
	$char_data['is_banned'] = $player_status['is_banned'];
	$char_data['exp_cur'] = $player_status['exp_cur'];
	$char_data['exp_max'] = $player_status['exp_max'];
	$char_data['char_level'] = $player_status['char_level'];
	$char_data['char_name'] = $player_status['char_name'];
	$char_data['char_guild'] = $player_status['char_guild'];
	$char_data['enemies'] = $player_status['enemies'];
	$char_data['gold'] = $player_status['gold'];
	// $char_data['duel_id'] = $player_status['duel_id'];
	// $char_data['battle_id'] = $player_status['battle_id'];
	$char_data['char_guild'] = $player_status['char_guild'];
	$char_data['rotation'] = $player_status['rotation'];
	$char_data['position'] = $player_status['position'];
	$char_data['camera_direction'] = $player_status['camera_direction'];
	$char_data['appearence'] = $player_status['appearence'];
	$char_data['tasklist'] = $player_status['tasklist'];

	$char_data['active_date'] = microtime_float();
	set_player($char_data['char_id'], 'active_date', $char_data['active_date']);

	// if ($player_status['tasklist'] != '')
	set_player($char_data['char_id'], 'chat', $char_data['chat']);

	// if (sizeof($char_data['tasklist']) !== 0)
	// 	set_player($char_data['char_id'], 'tasklist', []);
	set_player($char_data['char_id'], 'pressed_keys', $char_data['pressed_keys']);

	handle_map_change($char_data, $player_status);
	handle_trading($char_data, $player_status);
	handle_confirmation($char_data, $player_status);
	handle_duel($char_data, $player_status);
	handle_battle($char_data, $player_status);
	handle_moving($char_data, $player_status);
	handle_camera_direction($char_data);
	handle_camera_position($char_data, $json);

	/* Get all chars in current map. */
	$char_names = LGen('JsonMan')->read(dir.'maps/'.$char_data['map_id'].'/players');
	if (!LGen('ArrayMan')->is_val_exist($char_names, $char_data['char_id'])) {
		array_push($char_names, $char_data['char_id']);
		LGen('JsonMan')->save(dir.'maps/'.$char_data['map_id'].'/', 'players', $char_names);
	}

	foreach ($char_names as $key => $value) {
		$p2_active_date = get_player($value, 'active_date');
		if ($p2_active_date === LGen('GlobVar')->failed) {
			LGen('ArrayMan')->rmv_by_val($char_names, $value);
			LGen('JsonMan')->save(dir.'maps/'.$char_data['map_id'].'/', 'players', $char_names);
		}
		else {
			$start_date = ($p2_active_date); 
			$end_date = ($char_data['active_date']); 
			$time = ($end_date - $start_date);
			if ($time >= 1) {
				LGen('ArrayMan')->rmv_by_val($char_names, $value);
				LGen('JsonMan')->save(dir.'maps/'.$char_data['map_id'].'/', 'players', $char_names);
			}
		}
	}

	foreach ($char_names as $key => $value) {

		$_player = get_player($value);
		$_appearence = $_player['appearence'];
		$json['chars'][$value] = $_player;
		unset($json['chars'][$value]['quest']);
		unset($json['chars'][$value]['active_date']);
		unset($json['chars'][$value]['inventory']);
		unset($json['chars'][$value]['item_mall']);
		unset($json['chars'][$value]['camera_direction']);
		unset($json['chars'][$value]['camera_position']);
		unset($json['chars'][$value]['is_health_increasing']);
		unset($json['chars'][$value]['stamina_changed']);


		// $json['chars'][$value]['chat'] = $_appearence;
		$json['chars'][$value]['appearence'] = $_appearence;
		$json['chars'][$value]['size'] = calculate_collision_size($_player);
		$json['chars'][$value]['distance'] = get_distance(get_difference($json['chars'][$value]['position']['x'], $char_data['position']['x']), get_difference($json['chars'][$value]['position']['z'], $char_data['position']['z']));
	}

	$char_data = handle_attack($char_data, $player_status, $json);

	$npcs = get_npc_data($char_data['map_id'], false);
	handle_collision_with_players($char_data, $player_status, $json);
	handle_collision_with_properties($char_data, $player_status);
	handle_collision_with_npcs($char_data, $player_status, $npcs);

	$json['props']['speak_to'] = handle_speak_to_npc($char_data, $npcs);
	$json['props']['poke_to_player'] = handle_poke_to_player($char_data, $json);
	$json['chars'][$char_data['char_id']] = $char_data;
	unset($json['chars'][$char_data['char_id']]['item_mall']);
	unset($json['chars'][$char_data['char_id']]['quest']);
	unset($json['chars'][$char_data['char_id']]['active_date']);
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

	// findKb($json);
	// echo ' - ';
	// $json['chars'][$char_data['char_id']] = json_rmv_key($json['chars'][$char_data['char_id']], "inventory");
	// unset($json['chars'][$char_data['char_id']]['inventory']);

	// $config = LGen('JsonMan')->read(BASE_DIR.'storages/config');
	// if ($config['propkey']) {
	// 	$propkey = LGen('JsonMan')->read(BASE_DIR.'storages/propkey');
	// 	LGen('PropKeyMan')->obj_prop_to_key($propkey, $json);
	// }
	
	// echo findKb($json);
	// $json = ($json);
	return $json;
}

function is_speak_key_pressed($char_data) {
  if (LGen('ArrayMan')->is_val_exist($char_data['pressed_keys'], cross_key) && LGen('ArrayMan')->is_val_exist($char_data['pressed_keys'], r2_key)) {
  	return true;
  }
  else {
  	return false;
  }
}

function get_face_dir($char_data) {
  // if ($char_data['rotation']['y'] == pi() * 4/4)
  if ($char_data['rotation']['y'] == 3.14)
		return 'north';
  // else if ($char_data['rotation']['y'] == pi() * 0/4)
  else if ($char_data['rotation']['y'] == 0)
		return 'south';
  // else if ($char_data['rotation']['y'] == pi() * 2/4)
  else if ($char_data['rotation']['y'] == 1.57)
		return 'east';
  // else if ($char_data['rotation']['y'] == pi() * 6/4)
  else if ($char_data['rotation']['y'] == 4.71)
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
    $char_data['rotation']['y'] = 3.14;
    // $char_data['rotation']['y'] = pi() * 4/4;
	else if ($direction == 'north_east')
    $char_data['rotation']['y'] = pi() * 3/4;
	else if ($direction == 'north_west')
    $char_data['rotation']['y'] = pi() * 5/4;
	else if ($direction == 'south')
    $char_data['rotation']['y'] = 0;
    // $char_data['rotation']['y'] = pi() * 0/4;
	else if ($direction == 'south_east')
    $char_data['rotation']['y'] = pi() * 1/4;
	else if ($direction == 'south_west')
    $char_data['rotation']['y'] = pi() * 7/4;
	else if ($direction == 'east')
    $char_data['rotation']['y'] = 1.57;
    // $char_data['rotation']['y'] = pi() * 2/4;
	else if ($direction == 'west')
    $char_data['rotation']['y'] = 4.71;
    // $char_data['rotation']['y'] = pi() * 6/4;
  $char_data['rotation']['y'] = round($char_data['rotation']['y'], 2);
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
	if (LGen('ArrayMan')->is_val_exist($map, $key))
		return true;
	else
		return false;
}

function get_map_name($map_id, $encoded=true) {
	$map_list = LGen('JsonMan')->read(dir.'maps/list');
	$map_name = $map_list[$map_id];
	// if ($encoded)
	// 	$map_name = ($map_name);
	return $map_name;
}


function get_char_data($char_id, $encoded=true) {
	$char_data = get_player($char_id);
	$default_data = LGen('JsonMan')->read(dir.'/players/default');
	foreach ($default_data as $key => $value) {
		$char_data[$key] = $value;
		set_player($char_id, $key, $value);
	}

	// if ($encoded)
	// 	$char_data = ($char_data);
	return $char_data;
}

function get_item_data() {
	// echo speed;
	$json = LGen('JsonMan')->read(dir.'items');
	// $json = ($json);
	return $json;
}

function get_head_data() {
	$hair_female = LGen('JsonMan')->read(dir.'others/hair_female');
	$hair_male = LGen('JsonMan')->read(dir.'others/hair_male');
	$headskin = LGen('JsonMan')->read(dir.'others/headskin');

	$json['hair']['female'] = $hair_female;
	$json['hair']['male'] = $hair_male;
	$json['headskin'] = $headskin;
	
	// return ($json);
	return $json;
}

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
	// $json = ($npc);
	return $npc;
}

function get_npc_data($map_id, $encoded=true) {
	$npc_names = LGen('JsonMan')->read(dir. 'maps/' .$map_id.'/'.'npcs');
	$json = [];
	foreach ($npc_names as $key => $npc_name) {
		// $_json = LGen('JsonMan')->read(dir.'npcs/'.$npc_name);
		$_json = get_npc($npc_name, 'all');
		$json[$npc_name] = $_json;
	}

	// if ($encoded)
	// 	$json = ($json);
	return $json;
}



function get_quest2($player_id, $npc_id) {
	$quest = LGen('JsonMan')->read(dir.'quests/'. $npc_id);

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
	
	// $json = ($json);
	return $json;
}



function get_property_data($map_id, $encoded=true) {
	$properties = LGen('JsonMan')->read(dir.'maps/'. $map_id.'/'.'properties');
	$default = LGen('JsonMan')->read(dir.'maps/default_keys');
	$result = [];
	$id = 0;
	foreach ($properties as $propkey => $propval) {
		// if (LGen('JsonMan')->read(dir.'maps/properties/'.$propval['prop']) === LGen('GlobVar')->failed)
		// 	printJson(dir.'maps/properties/'.$propval['prop']);
		$prop = LGen('JsonMan')->read(dir.'maps/properties/'.$propval['prop']);
		// printJson($prop);
		// break;
		$prop['building_id'] = $id;
		foreach ($default as $defkey => $defval) {
			if (!LGen('JsonMan')->is_key_exist($prop, $defkey)) {
				$prop[$defkey] = $defval;
			}
		}
		// if ($propval['prop'] == 'flowerwall') {
		// 	printJson(LGen('JsonMan')->read(dir.'maps/properties/'.$propval['prop']));
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
					$prop['rotation'] = LGen('ArrayMan')->to_json(array("x"=>0,"y"=>3.14,"z"=>0));
				}
				else if ($subpropval == 'south') {
					$prop['rotation'] = LGen('ArrayMan')->to_json(array("x"=>0,"y"=>0,"z"=>0));
				}
				else if ($subpropval == 'east') {
					$temp_x = $prop['collision_size']['x'];
					$prop['collision_size']['x'] = $prop['collision_size']['z'];
					$prop['collision_size']['z'] = $temp_x;
					$prop['rotation'] = LGen('ArrayMan')->to_json(array("x"=>0,"y"=>1.57,"z"=>0));
				}
				else if ($subpropval == 'west') {
					$temp_x = $prop['collision_size']['x'];
					$prop['collision_size']['x'] = $prop['collision_size']['z'];
					$prop['collision_size']['z'] = $temp_x;
					$prop['rotation'] = LGen('ArrayMan')->to_json(array("x"=>0,"y"=>4.71,"z"=>0));
				}
			}
			else
				$prop[$subpropkey] = $subpropval;
		}

		if ($prop['prop'] == 'portal') {
			if ($prop['position']['x'] == 0 and $prop['position']['z'] == 112) {
				$prop['p_rot'] = LGen('ArrayMan')->to_json(array("x"=>0,"y"=>0,"z"=>0));
				$prop['p_pos'] = LGen('ArrayMan')->to_json(array("x"=>0,"y"=>0,"z"=>-105));
			}
			else if ($prop['position']['x'] == 0 and $prop['position']['z'] == -112) {
				$prop['p_rot'] = LGen('ArrayMan')->to_json(array("x"=>0,"y"=>3.14,"z"=>0));
				$prop['p_pos'] = LGen('ArrayMan')->to_json(array("x"=>0,"y"=>0,"z"=>105));
			}
			else if ($prop['position']['x'] == 112 and $prop['position']['z'] == 0) {
				$prop['p_rot'] = LGen('ArrayMan')->to_json(array("x"=>0,"y"=>1.57,"z"=>0));
				$prop['p_pos'] = LGen('ArrayMan')->to_json(array("x"=>-105,"y"=>0,"z"=>0));
			}
			else if ($prop['position']['x'] == -112 and $prop['position']['z'] == 0) {
				$prop['p_rot'] = LGen('ArrayMan')->to_json(array("x"=>0,"y"=>4.71,"z"=>0));
				$prop['p_pos'] = LGen('ArrayMan')->to_json(array("x"=>105,"y"=>0,"z"=>0));
			}
		}
		array_push($result, $prop);
	}

	// if ($encoded)
	// 	return ($result);
	// else
		// return $result;
	return $result;
	// return ($properties);
}

?>