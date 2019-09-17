<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Equipment {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function init($player_id) {
		$equipment = [];
		for($i=0; $i<10; $i++) {
			array_push($equipment, '');
		}
		set_player($player_id, 'equipment', $equipment);
	}

	public function get_data($player_id) {
		$equipment = get_player($player_id, 'equipment');
		$equipment = ($equipment);
		return $equipment;
	}

	public function click_on_item($slot_num, $player_id) {
		$inventory = get_player($player_id, 'inventory');
		$equipment = get_player($player_id, 'equipment');

		if ($equipment[$slot_num] == '') {
			// $inventory = ($inventory);
			// return $inventory;
			return ($equipment);
		}

		$item_id = $equipment[$slot_num]['item_id'];
		$inventory_class = new Inventory();
		$avail_slot_num = $inventory_class->get_avail_slot_num($inventory);
		// echo $_slot_num;
		if ($avail_slot_num === '') {
			// $inventory = ($inventory);
			// return $inventory;
			return 'Inventory is full.';
		}

		$items = LGen('JsonMan')->read(dir.'items');
		$_item = $items[$item_id];

		$equipment[$slot_num] = '';
		$inventory[$avail_slot_num] = LGen('ArrayMan')->to_json(array(
			'item_id' => $item_id,
			'item_quantity' => 1
		));

		set_player($player_id, 'inventory', $inventory);
		set_player($player_id, 'equipment', $equipment);

		$appearence = get_player($player_id, 'appearence');
		$appearence[get_equipment_item_slot_num_by_item_type($_item['type'])['item_type']] = '';
		set_player($player_id, 'appearence', $appearence);

		return ($equipment);
	}

}