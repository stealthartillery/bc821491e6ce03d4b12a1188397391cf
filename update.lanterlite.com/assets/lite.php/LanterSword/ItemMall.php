<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class ItemMall {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function init($player_id) {
		$item_mall = [];
		for($i=0; $i<25; $i++) {
			array_push($item_mall, '');
		}
		set_player($player_id, 'item_mall', $item_mall);
	}

	public function get_data($player_id) {
		$item_mall = get_player($player_id, 'item_mall');
		$item_mall = ($item_mall);
		return $item_mall;
	}

	public function click_on_item($slot_num, $player_id) {
		$inventory = get_player($player_id, 'inventory');
		$item_mall = get_player($player_id, 'item_mall');

		if ($item_mall[$slot_num] == '') {
			return ($item_mall);
		}

		$item_id = $item_mall[$slot_num]['item_id'];

		$inventory_class = new Inventory();
		$avail_slot_num = $inventory_class->get_avail_slot_num($inventory);
		if ($avail_slot_num === '') {
			return 'Inventory is full.';
		}

		$items = LGen('JsonMan')->read(dir.'items');
		$_item = $items[$item_id];

		$item_mall[$slot_num] = '';
		$inventory[$avail_slot_num] = LGen('ArrayMan')->to_json(array(
			'item_id' => $item_id,
			'item_quantity' => 1
		));

		set_player($player_id, 'inventory', $inventory);
		set_player($player_id, 'item_mall', $item_mall);

		return ($item_mall);
	}
}