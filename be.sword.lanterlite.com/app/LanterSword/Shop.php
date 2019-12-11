<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Shop {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function get_data($npc_id) {
		$shop = get_npc($npc_id, 'trade');
		return ($shop);
	}


	public function sell_item($slot_num, $player_id) {
		$inventory = get_player($player_id, 'inventory');

		if ($inventory[$slot_num] == '') {
			return ($inventory);
		}

		$gold = get_player($player_id, 'gold');
		$pearl = get_player($player_id, 'pearl');

		$items = LGen('JsonMan')->read(dir.'items');
		$item_id = $inventory[$slot_num]['item_id'];
		$gold += ceil($items[$item_id]['price_gold']/2);
		$pearl += ceil($items[$item_id]['price_pearl']/2);

		$inventory[$slot_num] = "";
		set_player($player_id, 'inventory', $inventory);
		set_player($player_id, 'gold', $gold);
		set_player($player_id, 'pearl', $pearl);

		return ($inventory);
	}

	public function buy_item($slot_num, $player_id, $npc_id) {


		$gold = get_player($player_id, 'gold');
		$pearl = get_player($player_id, 'pearl');
		$inventory = get_player($player_id, 'inventory');
		$shop = get_npc($npc_id, 'trade');

		if ($shop[$slot_num] == '') {
			return ($shop);
		}

		$item_id = $shop[$slot_num]['item_id'];
		$items = LGen('JsonMan')->read(dir.'items');

		if ($gold - ($items[$item_id]['price_gold'] + $shop[$slot_num]['price_gold']) < 0)
			return 'Insufficent gold.';
		if ($pearl - ($items[$item_id]['price_pearl'] + $shop[$slot_num]['price_pearl']) < 0)
			return 'Insufficent pearl.';

		$inventory_class = new Inventory();
		$avail_slot_num = $inventory_class->get_avail_slot_num($inventory);
		if ($avail_slot_num === '') {
			return 'Inventory is full.';
		}

		$inventory[$avail_slot_num] = LGen('ArrayMan')->to_json(array(
			'item_id' => $item_id,
			'item_quantity' => 1
		));

		$gold = $gold - ($items[$item_id]['price_gold'] + $shop[$slot_num]['price_gold']);
		$pearl = $pearl - ($items[$item_id]['price_pearl'] + $shop[$slot_num]['price_pearl']);
		// error_log(' c ' . $pearl . ' a ' . $items[$item_id]['price_pearl'] . ' b ' . $shop[$slot_num]['price_pearl']);
		set_player($player_id, 'inventory', $inventory);
		set_player($player_id, 'gold', $gold);
		set_player($player_id, 'pearl', $pearl);

		return ($shop);
	}

}