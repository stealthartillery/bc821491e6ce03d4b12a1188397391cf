<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Inventory {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function get_data($player_id, $num) {
		$inventory = get_player($player_id, 'inventory');
		// $from = $num*25;
		// $to = $from+25;
		// $table_right = get_arr_from_to($inventory, $from, $to);
		// $inventory = $table_right;
		
		$inventory = $inventory;
		return $inventory;
	}

	public function init($player_id) {
		$inventory = [];
		for($i=0; $i<50; $i++) {
			array_push($inventory, '');
		}
		set_player($player_id, 'inventory', $inventory);
	}




	public function drop_item($slot_num, $player_id) {
		$inventory = get_player($player_id, 'inventory');
		if ($inventory[$slot_num] == '') {
			return $inventory;
		}
		$inventory[$slot_num] = "";
		set_player($player_id, 'inventory', $inventory);
		return ($inventory);
	}

	public function use_item($slot_position, $index, $slot_num, $player_id) {
		$inventory = get_player($player_id, 'inventory');
		$equipment = get_player($player_id, 'equipment');

		if ($inventory[$slot_num] == '') {
			return $inventory;
		}

		$items = LGen('JsonMan')->read(dir.'items');

		$item_id = $inventory[$slot_num]['item_id'];
		$index = $slot_num;

		$_item = $items[$item_id];

		if ($items[$item_id]['is_quantable_item']) {
			$inventory[$slot_num]['item_quantity'] -= 1;
			if ($inventory[$slot_num]['item_quantity'] <= 0) {
				$inventory[$slot_num] = '';
			}
			set_player($player_id, 'inventory', $inventory);
			if ($item_id === 'QI01')
				return 'open_salon';
		}
		else if ($items[$item_id]['type'] !== 'quest') {

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

			$equipment_slot_num = get_equipment_item_slot_num_by_item_type($_item['type'])['slot_num'];

			if ($equipment[$equipment_slot_num] == '') { # if there is no item in the left then remove the item in the right
				$inventory[$index] = '';
			}
			else { # if there is item in the left then replace the item in the right with item in the left
				$inventory[$index]['item_id'] = $equipment[$equipment_slot_num]['item_id'];
				$equipment[$equipment_slot_num] = '';
			}

			$equipment[$equipment_slot_num] = LGen('ArrayMan')->to_json(array( # add the item in the left
				'item_id' => $item_id
			));

			// $appearence = LGen('JsonMan')->read(dir.'appearences/'.$player_id);
			$appearence[get_equipment_item_slot_num_by_item_type($_item['type'])['item_type']] = $item_id;
			set_player($player_id, 'appearence', $appearence);
			set_player($player_id, 'equipment', $equipment);
			set_player($player_id, 'inventory', $inventory);
		}
	}

	public function slot_available($player_id, $item_qty) {
		$inventory = get_player($player_id, 'inventory');
		$slot_num = $this->get_avail_slot_num($inventory);
		error_log('$slot_num ' . $slot_num);
		if ($slot_num !== '' and (total_item_limit - $slot_num) >= $item_qty)
			return true;
		else
			return false;
	}
	
	public function slot_available2($player_id, $item_id, $item_qty) {
		$inventory = get_player($player_id, 'inventory');
		$items = LGen('JsonMan')->read(dir.'items');
		if ($items[$item_id]['is_quantable_item']) { // if item is quantable
			$slot_num = $this->get_avail_slot_num($inventory);
			if ($slot_num != '')
				return true;
			else
				return false;
		}
		else {
			$slot_num = $this->get_avail_slot_num($inventory);
			if ($slot_num != '' and (total_item_limit - $slot_num) >= $item_qty)
				return true;
			else
				return false;
		}
	}

	public function item_exist($player_id, $item_id, $item_qty) {
		$inventory = get_player($player_id, 'inventory');
		$items = LGen('JsonMan')->read(dir.'items');
		if ($items[$item_id]['is_quantable_item']) { // if item is quantable
			for ($i=0; $i<sizeof($inventory); $i++) {
				if ($inventory[$i] !== '' and $inventory[$i]['item_id'] == $item_id) {
					if ($inventory[$i]['item_quantity'] >= $item_qty)
						return 'ok';
					else
						return 'Insufficient quantity of ' . $items[$item_id]['name'];
				}
			}
			return 'You don\'t have ' . $items[$item_id]['name'] . ' in your inventory.';
		}
		else {
			$count = 0;
			for ($i=0; $i<sizeof($inventory); $i++) {
				if ($inventory[$i] !== '' and $inventory[$i]['item_id'] == $item_id)  {
					error_log($inventory[$i]['item_id']);
					$count += 1;
				}
				if ($count >= $item_qty)
					break;
			}
			if ($count >= $item_qty)
				return 'ok';
			else if ($count > 0)
				return 'Insufficient quantity of ' . $items[$item_id]['name'];
			else
				return 'You don\'t have ' . $items[$item_id]['name'] . ' in your inventory.';
		}
	}

	public function remove_item($player_id, $item_id, $item_qty) {
		$inventory = get_player($player_id, 'inventory');
		$items = LGen('JsonMan')->read(dir.'items');

		// for quantable item
		if ($items[$item_id]['is_quantable_item']) { // if item is quantable
			for ($i=0; $i< sizeof($inventory); $i++) {
				if ($inventory[$i] !== '' and $inventory[$i]['item_id'] == $item_id) {
					if ($inventory[$i]['item_quantity'] >= $item_qty) { // if item quantity is capable
						$inventory[$i]['item_quantity'] -= $item_qty;
						set_player($player_id, 'inventory', $inventory);
						return 'success';
					}
					else {
						return 'Insufficient quantity of ' . $items[$item_id]['name'];
					}
				}
			}
		}

		// for inquantable item
		$tot_item = 0;
		$item_index = [];
		for ($i=0; $i< sizeof($inventory); $i++) {
			if ($inventory[$i] !== '' and $inventory[$i]['item_id'] == $item_id) {
				$tot_item += 1;
				array_push($item_index, $i);
			}
		}

		if ($tot_item >= $item_qty) { // if item quantity is capable
			for ($i=0; $i<$item_qty; $i++) {
				$inventory[$item_index[$i]] = '';
				set_player($player_id, 'inventory', $inventory);
			}
			// echo '$tot_item ' . $tot_item;
			return 'success';
		}
		else if ($tot_item > 0) {
			return 'Insufficient quantity of ' . $items[$item_id]['name'];
		}

		return 'You don\'t have ' . $items[$item_id]['name'] . ' in your inventory.';
	}

	public function add_item($player_id, $item_id, $item_qty) {
		$inventory = get_player($player_id, 'inventory');
		$slot_num = $this->get_avail_slot_num($inventory);
		$items = LGen('JsonMan')->read(dir.'items');

		if ($slot_num !== '' and $items[$item_id]['is_quantable_item']) { // if there is available slot and item is quantable
			for ($i=0; $i<sizeof($inventory); $i++) {
				if ($inventory[$i]['item_id'] == $item_id) {
					$inventory[$i]['item_quantity'] += $item_qty;
					break;
				}
			}
			set_player($player_id, 'inventory', $inventory);
			return true;
		}
		else if ($slot_num !== '') {
			$inventory[$slot_num] = LGen('ArrayMan')->to_json(array(
				'item_id' => $item_id,
				'item_quantity' => $item_qty
			));
			set_player($player_id, 'inventory', $inventory);
			return true;
		}
		return false;
	}

	function get_avail_slot_num($inventory) {
		for ($i=0; $i<total_item_limit; $i++) {
			// error_log($inventory[$i]['item_id']);
			if ($inventory[$i] == '') {
				// echo $i;
				return $i;
			}
		}
		return '';
	}

}


function get_equipment_item_slot_num_by_item_type($item_type) {
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




?>