<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Inventory {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function get_inventory_data($player_id, $num) {
		$inventory = get_player($player_id, 'inventory');
		// $from = $num*25;
		// $to = $from+25;
		// $table_right = get_arr_from_to($inventory['table_right'], $from, $to);
		// $inventory['table_right'] = $table_right;
		
		$inventory = json_encode($inventory);
		return $inventory;
	}

	public function init_inventory($player_id) {
		$table_right = [];
		for($i=0; $i<50; $i++) {
			$item['slot_num'] = $i;
			$item['item'] = '';
			array_push($table_right, $item);
		}
		$table_left = [];
		for($i=0; $i<10; $i++) {
			$item['slot_num'] = $i;
			$item['item'] = '';
			array_push($table_left, $item);
		}
		$inventory['table_right'] = $table_right;
		$inventory['table_left'] = $table_left;
		json_save(dir.'inventories/', $player_id, $inventory, $minify=false);

		$inventory = json_encode($inventory);
		return $inventory;
	}




	public function use_item($slot_position, $index, $slot_num, $player_id) {
		$inventory = get_player($player_id, 'inventory');
		if ($slot_position == 'table_right') {

			if ($inventory['table_right'][$slot_num]['item'] == '') {
				$inventory = json_encode($inventory);
				return $inventory;
			}

			$items = json_read(dir.'items')[DATA];

			$item_id = $inventory['table_right'][$slot_num]['item']['item_id'];
			$index = $slot_num;

			$_item = $items[$item_id];

			if ($items[$item_id]['is_quantable_item']) {

			}
			else {

				$appearence = get_player($player_id, 'appearence');
				if ($_item['type'] == 'shield') {
					$rhand_item = $appearence['rhand'];
					if ($rhand_item != '') {
						if ($items[$rhand_item]['type'] == 'weapon_2hand') {
							return 'You cannot wear shield when wearing 2 handed weapon.';
						}
					}
				}

				if ($_item['type'] == 'weapon_2hand') {
					$lhand_item = $appearence['lhand'];
					if ($lhand_item != '') {
						if ($items[$lhand_item]['type'] != '') {
							return 'You cannot wear 2 handed weapon when wearing something in your left hand.';
						}
					}
				}

				$left_index = get_left_item_slot_num_by_item_type($_item['type'])['slot_num'];

				if ($inventory['table_left'][$left_index]['item'] == '') { # if there is no item in the left then remove the item in the right
					$inventory['table_right'][$index]['item'] = '';
				}
				else { # if there is item in the left then replace the item in the right with item in the left
					$inventory['table_right'][$index]['item']['item_id'] = $inventory['table_left'][$left_index]['item']['item_id'];
					$inventory['table_left'][$left_index]['item'] = '';
				}

				$inventory['table_left'][$left_index]['item'] = arr_to_json(array( # add the item in the left
					'item_id' => $item_id
				));

				// $appearence = json_read(dir.'appearences/'.$player_id)[DATA];
				$appearence[get_left_item_slot_num_by_item_type($_item['type'])['item_type']] = $item_id;
				set_player($player_id, 'appearence', $appearence);
			}
		
			set_player($player_id, 'inventory', $inventory);

		}
		else if ($slot_position == 'table_left') {

			if ($inventory['table_left'][$index]['item'] == '') {
				$inventory = json_encode($inventory);
				return $inventory;
				// return 'item_id == ""';
			}

			$item_id = $inventory['table_left'][$index]['item']['item_id'];

			$_slot_num = get_avail_slot_num($inventory);
			// echo $_slot_num;
			if ($_slot_num === '') {
				// $inventory = json_encode($inventory);
				// return $inventory;
				return '_slot_num === ""';
			}

			$items = json_read(dir.'items')[DATA];
			$_item = $items[$item_id];

			$inventory['table_left'][$index]['item'] = '';
			$inventory['table_right'][$_slot_num]['item'] = arr_to_json(array(
				'item_id' => $item_id,
				'item_quantity' => 1
			));

			set_player($player_id, 'inventory', $inventory);

			$appearence = get_player($player_id, 'appearence');
			$appearence[get_left_item_slot_num_by_item_type($_item['type'])['item_type']] = '';
			set_player($player_id, 'appearence', $appearence);
		}

		$inventory = json_encode($inventory);
		return $inventory;
	}
}

function get_left_item_slot_num_by_item_type($item_type) {
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

function get_avail_slot_num($inventory) {
	for ($i=0; $i<total_item_limit; $i++) {
		if ($inventory['table_right'][$i]['item'] == '') {
			// echo $i;
			return $i;
		}
	}
	return '';
}



?>