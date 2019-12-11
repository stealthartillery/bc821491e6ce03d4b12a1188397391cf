<?php if (!defined('BASEPATH')) exit('no direct script access allowed');
// <?php if (!defined('LKEY')) exit('no direct script access allowed');

class LanterSwordGenClass {

	public function __construct() {
		if(!class_exists('lanterlite')) { include 'init.php'; }
		// $this->L = new lanterlite();
		// set_time_limit ( 0 );

		// $this->speed = 2;
		// $this->walk_speed = 1;

		// $this->camera_direction_key = 1;
		// $this->rhand_key = 2;
		// $this->lhand_key = 3;
		// $this->total_item_limit = 25;

		// $this->male_base_atk = 60;
		// $this->male_base_def = 40;
		// $this->female_base_atk = 40;
		// $this->female_base_def = 60;

		// $this->atk_stamina = 20;
		// $this->def_stamina = 5;

		// $this->left_key = 65;
		// $this->top_key = 87;
		// $this->right_key = 68;
		// $this->bottom_key = 83;

		// $this->circle_key = 76;
		// $this->cross_key = 75;
		// $this->triangle_key = 73;
		// $this->square_key = 74;

		// $this->r1_key = 85;
		// $this->r2_key = 79;
		// $this->l1_key = 69;
		// $this->l2_key = 81;
	}
 
	private function is_speak_key_pressed($char_data) {
	  if ($this->L->arr_value_exist($char_data['pressed_keys'], $this->cross_key) && $this->L->arr_value_exist($char_data['pressed_keys'], $this->l1_key)) {
	  	return true;
	  }
	  else {
	  	return false;
	  }
	}

	private function get_face_dir($char_data) {
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

	private function check_collision_building($char_data, $building_data) {
		foreach ($char_data['size']['x'] as $xkey => $xvalue) {
			if ($xvalue >= $building_data['position']['x']-$building_data['collision_size']['x'] && $xvalue <= $building_data['position']['x']+$building_data['collision_size']['x']) {
				foreach ($char_data['size']['z'] as $zkey => $zvalue) {
					if ($zvalue >= $building_data['position']['z']-$building_data['collision_size']['z'] && $zvalue <= $building_data['position']['z']+$building_data['collision_size']['z']) {
						return true;
					}
				}
			}
		}
		return false;
	}

	private function check_collision($main_char_data, $other_char_data) {
		$x = array_intersect($main_char_data['size']['x'], $other_char_data['size']['x']);
		$z = array_intersect($main_char_data['size']['z'], $other_char_data['size']['z']);
		if (sizeof($x) != 0 && sizeof($z) != 0)
			return true;
		else
			return false;
	}

	private function check_speak_to_npc($main_char_data, $other_char_data) {
		$x = array_intersect($main_char_data['size']['x'], $other_char_data['size']['x']);
		$z = array_intersect($main_char_data['size']['z'], $other_char_data['size']['z']);

		if (sizeof($x) != 0 && sizeof($z) != 0)
			return true;
		else
			return false;
	}

	private function calculate_collision_size($char_data) {
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

	private function move_north($char_data, $_speed) {
    $char_data['position']['z'] -= $_speed;
    return $char_data;
	}

	private function move_south($char_data, $_speed) {
    $char_data['position']['z'] += $_speed;
    return $char_data;
	}

	private function move_east($char_data, $_speed) {
    $char_data['position']['x'] += $_speed;
    return $char_data;
	}

	private function move_west($char_data, $_speed) {
    $char_data['position']['x'] -= $_speed;
    return $char_data;
	}

	private function face_to($char_data, $direction) {
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

	private function move_top($char_data) {
		if ($this->is_key_pressed($char_data['pressed_keys'], $this->triangle_key)) {
	  	$_speed = $this->speed;
		}
	  else {
	  	$_speed = $this->walk_speed;
	  }

	  $char_data['move_directions'] = [];
	  if ($this->is_key_pressed($char_data['pressed_keys'], $this->bottom_key))  {
      $char_data['rotation']['y'] = pi() * 4/4;
	  }
	  else {
      if ($char_data["camera_direction"] == 'north') {
      	$char_data = $this->move_north($char_data, $_speed);
      	$char_data = $this->face_to($char_data, 'north');
      	array_push($char_data['move_directions'], 'north');
      }
      else if ($char_data["camera_direction"] == 'south') {
      	$char_data = $this->move_south($char_data, $_speed);
      	$char_data = $this->face_to($char_data, 'south');
      	array_push($char_data['move_directions'], 'south');
      }
      else if ($char_data["camera_direction"] == 'east') {
      	$char_data = $this->move_east($char_data, $_speed);
      	$char_data = $this->face_to($char_data, 'east');
      	array_push($char_data['move_directions'], 'east');
      }
      else if ($char_data["camera_direction"] == 'west') {
      	$char_data = $this->move_west($char_data, $_speed);
      	$char_data = $this->face_to($char_data, 'west');
      	array_push($char_data['move_directions'], 'west');
      }
	  }
	  return $char_data;
	}
	
	private function move_bottom($char_data) {
		if ($this->is_key_pressed($char_data['pressed_keys'], $this->triangle_key)) {
	  	$_speed = $this->speed;
		}
	  else {
	  	$_speed = $this->walk_speed;
	  }

	  $char_data['move_directions'] = [];
    if ($char_data["camera_direction"] == 'north') {
    	$char_data = $this->move_south($char_data, $_speed);
    	$char_data = $this->face_to($char_data, 'south');
    	array_push($char_data['move_directions'], 'south');
    }
    else if ($char_data["camera_direction"] == 'south') {
    	$char_data = $this->move_north($char_data, $_speed);
    	$char_data = $this->face_to($char_data, 'north');
    	array_push($char_data['move_directions'], 'north');
    }
    else if ($char_data["camera_direction"] == 'east') {
    	$char_data = $this->move_west($char_data, $_speed);
    	$char_data = $this->face_to($char_data, 'west');
    	array_push($char_data['move_directions'], 'west');
    }
    else if ($char_data["camera_direction"] == 'west') {
    	$char_data = $this->move_east($char_data, $_speed);
    	$char_data = $this->face_to($char_data, 'east');
    	array_push($char_data['move_directions'], 'east');
    }
	  return $char_data;
	}
	
	private function move_right($char_data) {
		if ($this->is_key_pressed($char_data['pressed_keys'], $this->triangle_key)) {
	  	$_speed = $this->speed;
		}
	  else {
	  	$_speed = $this->walk_speed;
	  }

	  if (!$this->is_key_pressed($char_data['pressed_keys'], $this->top_key) && !$this->is_key_pressed($char_data['pressed_keys'], $this->bottom_key) && !$this->is_key_pressed($char_data['pressed_keys'], $this->left_key)) {
      if ($char_data["camera_direction"] == 'north') {
      	$char_data = $this->move_east($char_data, $_speed);
      	$char_data = $this->face_to($char_data, 'east');
      	array_push($char_data['move_directions'], 'east');
      }
      else if ($char_data["camera_direction"] == 'south') {
      	$char_data = $this->move_west($char_data, $_speed);
      	$char_data = $this->face_to($char_data, 'west');
      	array_push($char_data['move_directions'], 'west');
      }
      else if ($char_data["camera_direction"] == 'east') {
      	$char_data = $this->move_south($char_data, $_speed);
      	$char_data = $this->face_to($char_data, 'south');
      	array_push($char_data['move_directions'], 'south');
      }
      else if ($char_data["camera_direction"] == 'west') {
      	$char_data = $this->move_north($char_data, $_speed);
      	$char_data = $this->face_to($char_data, 'north');
      	array_push($char_data['move_directions'], 'north');
      }
	  }
	  return $char_data;
	}
	
	private function move_left($char_data) {
		if ($this->is_key_pressed($char_data['pressed_keys'], $this->triangle_key)) {
	  	$_speed = $this->speed;
		}
	  else {
	  	$_speed = $this->walk_speed;
	  }

	  if (!$this->is_key_pressed($char_data['pressed_keys'], $this->top_key) && !$this->is_key_pressed($char_data['pressed_keys'], $this->bottom_key) && !$this->is_key_pressed($char_data['pressed_keys'], $this->right_key)) {
      if ($char_data["camera_direction"] == 'north') {
      	$char_data = $this->move_west($char_data, $_speed);
      	$char_data = $this->face_to($char_data, 'west');
      	array_push($char_data['move_directions'], 'west');
      }
      else if ($char_data["camera_direction"] == 'south') {
      	$char_data = $this->move_east($char_data, $_speed);
      	$char_data = $this->face_to($char_data, 'east');
      	array_push($char_data['move_directions'], 'east');
      }
      else if ($char_data["camera_direction"] == 'east') {
      	$char_data = $this->move_north($char_data, $_speed);
      	$char_data = $this->face_to($char_data, 'north');
      	array_push($char_data['move_directions'], 'north');
      }
      else if ($char_data["camera_direction"] == 'west') {
      	$char_data = $this->move_south($char_data, $_speed);
      	$char_data = $this->face_to($char_data, 'south');
      	array_push($char_data['move_directions'], 'south');
      }
	  }
	  return $char_data;
	}
	
	private function is_key_pressed($map, $key) {
		if ($this->L->arr_value_exist($map, $key))
			return true;
		else
			return false;
	}

	public function get_char_data($char_id) {
		$dir = BASE_DIR .'/storages/light/';
		$json = $this->L->json_read($dir .'players/' . $char_id)[DATA];
		$json = json_encode($json);
		return $json;
	}

	public function get_item_data() {
		$dir = BASE_DIR .'/storages/light/items';
		$json = $this->L->json_read($dir)[DATA];
		$json = json_encode($json);
		return $json;
	}

	public function get_inventory($char_id) {
		$dir = BASE_DIR .'/storages/light/';
		$json = $this->L->json_read($dir .'inventories/' . $char_id)[DATA];
		$json = json_encode($json);
		return $json;
	}

	public function get_item_type_by_slot_num($slot_num) {
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

	public function get_left_item_slot_num_by_item_type($item_type) {
    // $slot_num["lhand"] = "0";
    // $slot_num["rhand"] = "1";
    // $slot_num["suit"] = "2";
    // $slot_num["gloves"] = "3";
    // $slot_num["shoes"] = "4";
    // $slot_num["head"] = "5";
    // $slot_num["glasses"] = "6";
    // $slot_num["mask"] = "7";
    // $slot_num["back"] = "8";
    // $slot_num["top"] = "9";
    if ($item_type == 'weapon_1hand' or $item_type == 'weapon_2hand') 
	    return array('slot_num'=>'0', 'item_type'=>'rhand'); // rhand
    else if ($item_type == 'shield')
	    return array('slot_num'=>'1', 'item_type'=>'lhand'); // lhand
    else if ($item_type == 'suit')
	    return array('slot_num'=>'2', 'item_type'=>'suit'); // 
    else if ($item_type == 'gloves')
	    return array('slot_num'=>'3', 'item_type'=>'gloves'); // 
    else if ($item_type == 'shoes')
	    return array('slot_num'=>'4', 'item_type'=>'shoes'); // 
    else if ($item_type == 'head')
	    return array('slot_num'=>'5', 'item_type'=>'head'); // 
    else if ($item_type == 'glasses')
	    return array('slot_num'=>'6', 'item_type'=>'glasses'); // 
    else if ($item_type == 'mask')
	    return array('slot_num'=>'7', 'item_type'=>'mask'); // 
    else if ($item_type == 'back')
	    return array('slot_num'=>'8', 'item_type'=>'back'); // 
    else if ($item_type == 'top')
	    return array('slot_num'=>'9', 'item_type'=>'top'); // 
	}

	public function post_use_item($slot_position, $slot_num, $player_id) {

		$dir = BASE_DIR .'/storages/light/';
		$inventory = $this->L->json_read($dir .'inventories/' . $player_id)[DATA];
		if ($slot_position == 'invent_right') {
			$items = $this->L->json_read($dir.'items')[DATA];

			$item_id = '';
			$index = 0;
			for ($i=0; $i<sizeof($inventory['invent_right']); $i++) {
				if ($inventory['invent_right'][$i]['slot_num'] == $slot_num) {
					$item_id = $inventory['invent_right'][$i]['item_id'];
					$index = $i;
					break;
				}
			}

			if ($item_id == '') {
				$inventory = json_encode($inventory);
				return $inventory;
			}

			$_item = $items[$item_id];

			if ($items[$item_id]['is_quantable_item']) {

			}
			else {
				$_item_slot_num = $this->get_left_item_slot_num_by_item_type($_item['type'])['slot_num'];

				$left_item_id = '';
				$left_index = 0;
				for ($i=0; $i<sizeof($inventory['invent_left']); $i++) { # get index of the item in inventory and id of the item.
					if ($inventory['invent_left'][$i]['slot_num'] == $_item_slot_num) {
						$left_item_id = $inventory['invent_left'][$i]['item_id'];
						$left_index = $i;
						break;
					}
				}

				if ($left_item_id == '') { # if there is no item in the left then remove the item in the right
					$inventory['invent_right'] = $this->L->arr_value_remove_by_index($inventory['invent_right'], $index);
				}
				else { # if there is item in the left then replace the item in the right with item in the left
					$inventory['invent_right'][$index]['item_id'] = $left_item_id;
					$inventory['invent_left'] = $this->L->arr_value_remove_by_index($inventory['invent_left'], $left_index);
				}

				array_push($inventory['invent_left'], $this->L->arr_to_json(array( # add the item in the left
					'slot_num' => $_item_slot_num,
					'item_id' => $item_id
				)));

				$appearence = $this->L->json_read($dir.'appearences/'.$player_id)[DATA];
				$appearence[$this->get_left_item_slot_num_by_item_type($_item['type'])['item_type']] = $item_id;
				$this->L->json_save($dir.'appearences/', $player_id, $appearence, $minify=false);
			}
		
			$this->L->json_save($dir.'inventories/', $player_id, $inventory, $minify=false);

		}
		else if ($slot_position == 'invent_left') {
			$item_id = '';
			$index = 0;
			for ($i=0; $i<sizeof($inventory['invent_left']); $i++) {
				if ($inventory['invent_left'][$i]['slot_num'] == $slot_num) {
					$item_id = $inventory['invent_left'][$i]['item_id'];
					$index = $i;
					break;
				}
			}
			if ($item_id == '') {
				$inventory = json_encode($inventory);
				return $inventory;
			}
			if (sizeof($inventory['invent_right']) >= $this->total_item_limit) {
				$inventory = json_encode($inventory);
				return $inventory;
			}

			$items = $this->L->json_read($dir.'items')[DATA];
			$_item = $items[$item_id];

			$inventory['invent_left'] = $this->L->arr_value_remove_by_index($inventory['invent_left'], $index);
			$slot_num = $this->get_avail_slot_num($inventory);

			array_push($inventory['invent_right'], $this->L->arr_to_json(array(
				'slot_num' => $slot_num,
				'item_id' => $item_id,
				'item_quantity' => 1
			)));

			$this->L->json_save($dir.'inventories/', $player_id, $inventory, $minify=false);

			$appearence = $this->L->json_read($dir.'appearences/'.$player_id)[DATA];
			$appearence[$this->get_left_item_slot_num_by_item_type($_item['type'])['item_type']] = '';
			$this->L->json_save($dir.'appearences/', $player_id, $appearence, $minify=false);
		}

		$inventory = json_encode($inventory);
		return $inventory;
	}

	public function get_npc_data($place_id) {
		$dir = BASE_DIR .'/storages/light/places/';
		$filenames = $this->L->getFileNamesInsideDir($dir . $place_id.'_'.'npc/')[DATA];

		foreach ($filenames as $key => $value) {
			$_json = $this->L->json_read($dir . $place_id.'_'.'npc/'.$value)[DATA];
			$json[$value] = $_json;
		}

		$json = json_encode($json);
		return $json;
	}

	public function get_quest($player_id, $npc_id) {
		$dir = BASE_DIR .'/storages/light/quests/';
		$quest = $this->L->json_read($dir . $npc_id)[DATA];

		$dir = BASE_DIR .'/storages/light/quests/players/';
		$player_quest = $this->L->json_read($dir . $player_id)[DATA];
		// $this->L->printJson($player_quest);
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

	private function get_avail_slot_num($inventory) {
		$is_exist = false;
		if (!$is_exist) {
			$slot_num_list = [];
			for ($i=0; $i<sizeof($inventory['invent_right']); $i++) {
				array_push($slot_num_list, $inventory['invent_right'][$i]['slot_num']);
			}

			$slot_num = 0;
			$slot_exist = true;
			while ($slot_exist) {
				if ($this->L->arr_value_exist($slot_num_list, $slot_num)) {
					$slot_num += 1;
				}
				else {
					$slot_exist = false;
				}
			}
			return $slot_num;
		}
	}

	public function post_quest_answer($answer, $npc_id, $player_id) {
		$dir = BASE_DIR .'/storages/light/quests/';
		$quest = $this->L->json_read($dir . $npc_id)[DATA];

		$dir = BASE_DIR .'/storages/light/quests/players/';
		$player_quest = $this->L->json_read($dir . $player_id)[DATA];

		if ($this->L->arr_value_exist($quest['quest'][$player_quest[$npc_id]]['answer'], $answer)) {
			$reward_item_id = $quest['quest'][$player_quest[$npc_id]]['reward_item'];

			if ($reward_item_id !== '') {
				$dir = BASE_DIR .'/storages/light/items';
				$items = $this->L->json_read($dir)[DATA];

				$dir = BASE_DIR .'/storages/light/inventories/';
				$inventory = $this->L->json_read($dir . $player_id)[DATA];

				if ($items[$reward_item_id]['is_quantable_item']) {
					for ($i=0; $i<sizeof($inventory['invent_right']); $i++) {
						if ($inventory['invent_right'][$i]['item_id'] == $reward_item_id) {
							$inventory['invent_right'][$i]['item_quantity'] += $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity'];
							$is_exist = true;
							break;
						}
					}
					$json['info'] = $this->L->arr_to_json(array(
						'type' => 'green',
						'text' => "Anda mendapatkan ". $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity'] ." item " . $items[$reward_item_id]['name']
					));
					$json['type'] = 'reply';
					$json['talk'] = $quest['quest'][$player_quest[$npc_id]]['right_answer'];

					$dir = BASE_DIR .'/storages/light/inventories/';
					$this->L->json_save($dir, $player_id, $inventory, $minify=false);
				}
				else if (sizeof($inventory['invent_right']) < $this->total_item_limit) {
					$slot_num = $this->get_avail_slot_num($inventory);
					array_push($inventory['invent_right'], $this->L->arr_to_json(array(
						'slot_num' => $slot_num,
						'item_id' => $reward_item_id,
						'item_quantity' => $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity']
					)));

					$dir = BASE_DIR .'/storages/light/inventories/';
					$this->L->json_save($dir, $player_id, $inventory, $minify=false);

					$json['info'] = $this->L->arr_to_json(array(
						'type' => 'green',
						'text' => "Anda mendapatkan ". $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity'] ." item " . $items[$reward_item_id]['name']
					));
					$json['type'] = 'reply';
					$json['talk'] = $quest['quest'][$player_quest[$npc_id]]['right_answer'];
				}
				else {
					$_reply = [];
		      array_push($_reply,  $this->L->arr_to_json(array("type"=>"xchoice", "text"=>"Aku tidak bisa memberikan barang karena inventorimu penuh.")));

					$json['info'] = $this->L->arr_to_json(array(
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

	public function get_building_data($place_id) {
		$dir = BASE_DIR .'/storages/light/places/';
		$filenames = $this->L->getFileNamesInsideDir($dir . $place_id.'_'.'building/')[DATA];
		foreach ($filenames as $key => $value) {
			$_json = $this->L->json_read($dir . $place_id.'_'.'building/'.$value)[DATA];
			$json[$value] = $_json;
		} $json = json_encode($json);
		return $json;
	}

	public function post_ask_to_join_guild($char_id, $asked_char_id, $guild_id) {
		$dir = BASE_DIR .'/storages/light/';
		// handle ask for guild confirmation
		$date = new DateTime();
		$confirmation_id = md5($char_id.$asked_char_id.$date->getTimestamp());
		$json = $this->L->arr_to_json(array(
			'confirmation_id' => $confirmation_id,
			'confirmation_type' => 'guild_recruitment',
			'guild_id' => $guild_id,
			'asked_to' => $asked_char_id,
			'asked_by' => $char_id,
			'is_agreed' => null
		));
		$this->L->json_save($dir.'confirmations/', $confirmation_id, $json, $minify=false);

		// handle asked char data		
		$asked_char_data = $this->L->json_read($dir . 'players_status/'.$asked_char_id)[DATA];
		$asked_char_data['confirmation_id'] = $confirmation_id;
		$this->L->json_save($dir.'players_status/', $asked_char_id, $asked_char_data, $minify=false);

		// handle asking char data		
		$char_data = $this->L->json_read($dir . 'players_status/'.$char_id)[DATA];
		$char_data['confirmation_id'] = $confirmation_id;
		$this->L->json_save($dir.'players_status/', $char_id, $char_data, $minify=false);

		return true;
	}

	public function post_confirm_guild($confirmation_id, $is_agreed) {
		$dir = BASE_DIR .'/storages/light/';

		if ($is_agreed) {
			// handle confirmation file
			$confirmation_data = $this->L->json_read($dir . 'confirmations/'.$confirmation_id)[DATA];
			$confirmation_data['is_agreed'] = true;
			$this->L->json_save($dir.'confirmations/', $confirmation_id, $confirmation_data, $minify=false);

			// handle asked player status
			$asked_to_data = $this->L->json_read($dir . 'players_status/'. $confirmation_data['asked_to'])[DATA];
			$asked_to_data['char_guild'] = $confirmation_data['guild_id'];
			$asked_to_data['confirmation_id'] = null;
			$this->L->json_save($dir.'players_status/', $asked_to_data['char_id'], $asked_to_data, $minify=false);

			// handle guild status
			$guild = $this->L->json_read($dir . 'guilds/'.$asked_to_data['char_guild'])[DATA];
			array_push($guild['member'], $asked_to_data['char_id']);
			$this->L->json_save($dir.'guilds/', $asked_to_data['char_guild'], $guild, $minify=false);
		} else {
			// handle confirmation file
			$confirmation_data = $this->L->json_read($dir . 'confirmations/'.$confirmation_id)[DATA];
			$confirmation_data['is_agreed'] = false;
			$this->L->json_save($dir.'confirmations/', $confirmation_id, $confirmation_data, $minify=false);

			// handle asked player status
			$asked_to_data = $this->L->json_read($dir . 'players_status/'. $confirmation_data['asked_to'])[DATA];
			$asked_to_data['confirmation_id'] = null;
			$this->L->json_save($dir.'players_status/', $asked_to_data['char_id'], $asked_to_data, $minify=false);
		}
	
		return $confirmation_data;
	}

	public function post_confirm_delete($confirmation_id) {
		$dir = BASE_DIR .'/storages/light/';
		// handle asking player status
		$confirmation_data = $this->L->json_read($dir . 'confirmations/'.$confirmation_id)[DATA];
		$asked_by_data = $this->L->json_read($dir . 'players_status/'. $confirmation_data['asked_by'])[DATA];
		$asked_by_data['confirmation_id'] = null;

		$this->L->json_save($dir.'players_status/', $asked_by_data['char_id'], $asked_by_data, $minify=false);
		// handle asking player status
		$res = $this->L->file_delete($dir . 'confirmations/'.$confirmation_id);
		$res = json_encode($res);
		return $res;
	}

	public function post_confirm_check($confirmation_id) {
		$dir = BASE_DIR .'/storages/light/';
		// handle asking player status
		$confirmation_data = $this->L->json_read($dir . 'confirmations/'.$confirmation_id)[DATA];
		$confirmation_data = json_encode($confirmation_data);
		return $confirmation_data;
	}

	public function post_ask_for_trading($char_id, $asked_char_id, $guild_id) {
		$dir = BASE_DIR .'/storages/light/';
		// handle ask for trading confirmation
		$date = new DateTime();
		$confirmation_id = md5($char_id.$asked_char_id.$date->getTimestamp());
		$json = $this->L->arr_to_json(array(
			'confirmation_id' => $confirmation_id,
			'confirmation_type' => 'trading',
			'asked_to' => $asked_char_id,
			'asked_by' => $char_id,
			'is_agreed' => null
		));
		$this->L->json_save($dir.'confirmations/', $confirmation_id, $json, $minify=false);

		// handle asked char data		
		$asked_char_data = $this->L->json_read($dir . 'players_status/'.$asked_char_id)[DATA];
		$asked_char_data['confirmation_id'] = $confirmation_id;
		$this->L->json_save($dir.'players_status/', $asked_char_id, $asked_char_data, $minify=false);

		// handle asking char data		
		$char_data = $this->L->json_read($dir . 'players_status/'.$char_id)[DATA];
		$char_data['confirmation_id'] = $confirmation_id;
		$this->L->json_save($dir.'players_status/', $char_id, $char_data, $minify=false);

		return true;
	}

	public function post_confirm_trade($confirmation_id, $is_agreed) {
		$dir = BASE_DIR .'/storages/light/';

		if ($is_agreed) {
			// handle confirmation file
			$confirmation_data = $this->L->json_read($dir . 'confirmations/'.$confirmation_id)[DATA];
			$confirmation_data['is_agreed'] = true;
			$this->L->json_save($dir.'confirmations/', $confirmation_id, $confirmation_data, $minify=false);

			// handle asked player status
			$asked_to_data = $this->L->json_read($dir . 'players_status/'. $confirmation_data['asked_to'])[DATA];
			$asked_to_data['confirmation_id'] = null;
			$this->L->json_save($dir.'players_status/', $asked_to_data['char_id'], $asked_to_data, $minify=false);

			// handle guild status
			$guild = $this->L->json_read($dir . 'guilds/'.$asked_to_data['char_guild'])[DATA];
			array_push($guild['member'], $asked_to_data['char_id']);
			$this->L->json_save($dir.'guilds/', $asked_to_data['char_guild'], $guild, $minify=false);
		} else {
			// handle confirmation file
			$confirmation_data = $this->L->json_read($dir . 'confirmations/'.$confirmation_id)[DATA];
			$confirmation_data['is_agreed'] = false;
			$this->L->json_save($dir.'confirmations/', $confirmation_id, $confirmation_data, $minify=false);

			// handle asked player status
			$asked_to_data = $this->L->json_read($dir . 'players_status/'. $confirmation_data['asked_to'])[DATA];
			$asked_to_data['confirmation_id'] = null;
			$this->L->json_save($dir.'players_status/', $asked_to_data['char_id'], $asked_to_data, $minify=false);
		}
	
		return $confirmation_data;
	}


}

?>