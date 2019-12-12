<?php 

class Trade {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function ask_for_trading($char_id, $asked_char_id) {

		$confirmation_id = create_id($char_id.$asked_char_id);
		$json = LGen('ArrayMan')->to_json(array(
			'confirmation_id' => $confirmation_id,
			'confirmation_type' => 'trading',
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

	public function confirm_ask($confirmation_id, $is_agreed) {

		$confirmation_data = LGen('JsonMan')->read(dir. 'confirmations/'.$confirmation_id);
		if ($is_agreed) {
			$info = $confirmation_data['asked_to'] . ' has accepted to trade.';
			set_player($confirmation_data['asked_by'], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $info))));
			// set_player($confirmation_data['asked_by'], 'system_chat', $info);
			$info = 'You have accepted to trade.';
			set_player($confirmation_data['asked_to'], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $info))));
			// set_player($confirmation_data['asked_to'], 'system_chat', $info);
		}
		else {
			$info = $confirmation_data['asked_to'] . ' has refused to trade.';
			set_player($confirmation_data['asked_by'], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $info))));
			// set_player($confirmation_data['asked_by'], 'system_chat', $info);
			$info = 'You have refused to trade.';
			set_player($confirmation_data['asked_to'], 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $info))));
			// set_player($confirmation_data['asked_to'], 'system_chat', $info);
		}

		file_delete(dir. 'confirmations/'.$confirmation_id);
		set_player($confirmation_data['asked_to'], 'confirmation_id', '');
		set_player($confirmation_data['asked_by'], 'confirmation_id', '');

		if ($is_agreed)
			$this->init($confirmation_data['asked_by'], $confirmation_data['asked_to']);

		return true;
	}

	public function get_data($player_id, $trade_id, $key='all') {
		$trade = LGen('JsonMan')->read(dir.'trades/' . $trade_id);
		if ($key === 'all') {
			error_log($player_id);
			$json = $trade[$player_id];
		}
		else {
			$json = $trade[$player_id][$key];
		}
		return ($json);
	}

	public function inventory_to_trade($slot_num, $player_id, $trade_id) {

		# get trade
		$trade = LGen('JsonMan')->read(dir.'trades/' . $trade_id);
		# get inventory
		$inventory = get_player($player_id, 'inventory');

		if ($inventory[$slot_num] == '') {
			return $slot_num;
		}

		$index = '';
		for ($i=0; $i<10; $i++) {
			if ($trade[$player_id]['table'][$i]['item'] === '') {
				if ($index === '')
					$index = $i;
			}
			else if ($trade[$player_id]['table'][$i]['slot_num'] == $slot_num) {
				return ($slot_num);
			}
		}

		# trade slot full
		if ($index === '') {
			return 'trade slot full';
		}

		# switch item between trade slot and inventory slot
		$trade[$player_id]['table'][$index]['item'] = $inventory[$slot_num];
		$trade[$player_id]['table'][$index]['slot_num'] = $slot_num;

		# save trade file
		LGen('JsonMan')->save(dir.'trades/', $trade_id, $trade, $minify=false);

		add_tasklist($trade['trade_member'][0], 'trade_get_data');
		add_tasklist($trade['trade_member'][1], 'trade_get_data');

		# return file
		return 1;
	}

	public function add_gold($trade_id, $player_id, $amount) {
		$trade = LGen('JsonMan')->read(dir.'trades/' . $trade_id);
		$trade[$player_id]['gold'] = $amount;
		LGen('JsonMan')->save(dir.'trades/', $trade_id, $trade, $minify=false);

		add_tasklist($trade['trade_member'][0], 'trade_get_data');
		add_tasklist($trade['trade_member'][1], 'trade_get_data');
		
		return true;
	}

	public function add_pearl($trade_id, $player_id, $amount) {
		$trade = LGen('JsonMan')->read(dir.'trades/' . $trade_id);
		$trade[$player_id]['pearl'] = $amount;
		LGen('JsonMan')->save(dir.'trades/', $trade_id, $trade, $minify=false);

		add_tasklist($trade['trade_member'][0], 'trade_get_data');
		add_tasklist($trade['trade_member'][1], 'trade_get_data');
		
		return true;
	}

	public function agree($player_id, $trade_id) {
		$trade = LGen('JsonMan')->read(dir.'trades/' . $trade_id);
		$trade[$player_id]['is_agree'] = true;
		LGen('JsonMan')->save(dir.'trades/', $trade_id, $trade, $minify=false);

		add_tasklist($trade['trade_member'][0], 'trade_get_data');
		add_tasklist($trade['trade_member'][1], 'trade_get_data');
		
		return true;
	}

	public function trade($player_id, $trade_id) {
		$trade = LGen('JsonMan')->read(dir.'trades/' . $trade_id);
		$trade[$player_id]['is_trade'] = true;
		LGen('JsonMan')->save(dir.'trades/', $trade_id, $trade, $minify=false);

		$m1 = $trade['trade_member'][0];
		$m2 = $trade['trade_member'][1];

		if ($trade[$m1]['is_trade'] !== $trade[$m2]['is_trade']) {
			add_tasklist($m1, 'trade_get_data');
			add_tasklist($m2, 'trade_get_data');
		}
		
		if ($trade[$m1]['is_trade'] && $trade[$m2]['is_trade']) {
			/* read inventories files */
			$inv1 = get_player($m1, 'inventory');
			$inv2 = get_player($m2, 'inventory');
			$gold1 = get_player($m1, 'gold');
			$gold2 = get_player($m2, 'gold');
			$pearl1 = get_player($m1, 'pearl');
			$pearl2 = get_player($m2, 'pearl');

			$inventory_class = new Inventory();
			/* check if member1 inventory is full */
			$slot_num1 = $inventory_class->get_avail_slot_num($inv1);
			if ($slot_num1 === '')
				return $m1 . ' inventory is full.';

			/* check if member2 inventory is full */
			$slot_num2 = $inventory_class->get_avail_slot_num($inv2);
			if ($slot_num2 === '')
				return $m2 . ' inventory is full.';

			// return (sizeof($trade[$m1]['table']));
			/* move gold and trade items from m1 to m2 */
			for ($i=0; $i<sizeof($trade[$m1]['table']); $i++) {
				if ($trade[$m1]['table'][$i]['item'] != '') {
					$slot_num2 = $inventory_class->get_avail_slot_num($inv2);
					$_slot_num = $trade[$m1]['table'][$i]['slot_num'];
					$inv2[$slot_num2] = $trade[$m1]['table'][$i]['item'];
					$inv1[$_slot_num] = "";
				}
			}
			$gold2 += $trade[$m1]['gold'];
			$gold1 -= $trade[$m1]['gold'];
			$pearl2 += $trade[$m1]['pearl'];
			$pearl1 -= $trade[$m1]['pearl'];

			/* move gold and trade items from m2 to m1 */
			// return ($trade[$m1][0]['item']);
			for ($i=0; $i<sizeof($trade[$m2]['table']); $i++) {
				if ($trade[$m2]['table'][$i]['item'] != '') {
					$slot_num1 = $inventory_class->get_avail_slot_num($inv1);
					$_slot_num = $trade[$m2]['table'][$i]['slot_num'];
					$inv1[$slot_num1] = $trade[$m2]['table'][$i]['item'];
					$inv2[$_slot_num] = "";
				}
			}
			$gold1 += $trade[$m2]['gold'];
			$gold2 -= $trade[$m2]['gold'];
			$pearl1 += $trade[$m2]['pearl'];
			$pearl2 -= $trade[$m2]['pearl'];

			set_player($m1, 'inventory', $inv1);
			set_player($m2, 'inventory', $inv2);
			set_player($m1, 'gold', $gold1);
			set_player($m2, 'gold', $gold2);
			set_player($m1, 'pearl', $pearl1);
			set_player($m2, 'pearl', $pearl2);

			set_player($m1, 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => 'Trade success.'))));
			// set_player($m1, 'system_chat', 'Trade success.');
			set_player($m2, 'system_chat', array(LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => 'Trade success.'))));
			// set_player($m2, 'system_chat', 'Trade success.');
			error_log('hehe');
			$this->delete($trade_id);

			return true;
		}

		LGen('JsonMan')->save(dir.'trades/', $trade_id, $trade, $minify=false);

		return true;
	}

	public function set_gold($player_id, $gold, $trade_id) {

		$trade = LGen('JsonMan')->read(dir.'trades/' . $trade_id);
		$inventory = get_player($player_id, 'inventory');

		if ($inventory['gold'] >= $gold) {
			$trade[$player_id]['gold'] = $gold;
		}
		else {
			return 'Insufficent Gold';
		}
		LGen('JsonMan')->save(dir.'trades/', $trade_id, $trade, $minify=false);

		return $this->result($trade, $inventory, $player_id);
	}

	public function delete($trade_id='') {
		if ($trade_id === '')
			return true;
		$res = file_delete(dir. 'trades/'.$trade_id);
		return true;
	}

	public function result($trade, $inventory, $player_id) {
		$json = $trade[$player_id];
		$json = $inventory;
		$json['trade'] = $trade;
		$json = ($json);
		return $json;
	}

	public function trade_to_inventory($slot_num, $player_id, $trade_id) {

		$trade = LGen('JsonMan')->read(dir.'trades/' . $trade_id); # get trade
		$inventory = get_player($player_id, 'inventory'); # get inventory

		if ($trade[$player_id]['table'][$slot_num] === '') { # trade slot empty
			return '...';
		}
		else {
			$trade[$player_id]['table'][$slot_num]['slot_num'] = '';
			$trade[$player_id]['table'][$slot_num]['item'] = '';
		}
		
		// return $trade[$player_id]['table'][$slot_num]['slot_num'];

		LGen('JsonMan')->save(dir.'trades/', $trade_id, $trade, $minify=false); # save trade

		add_tasklist($trade['trade_member'][0], 'trade_get_data');
		add_tasklist($trade['trade_member'][1], 'trade_get_data');

		return true;
	}

	public function init($p1_id, $p2_id) {

		/* init trade file. */
		$trade_id = create_id($p1_id.$p2_id);
		$_trade = LGen('JsonMan')->read(dir.'trades/default');
		$item['slot_num'] = '';
		$item['item'] = '';

		$trade['trade_id'] = $trade_id;
		$trade[$p1_id] = $_trade;
		$trade[$p2_id] = $_trade;
		for($i=0; $i<20; $i++) {
			array_push($trade[$p1_id]['table'], $item);
			array_push($trade[$p2_id]['table'], $item);
		}

		$trade['trade_member'] = [];
		array_push($trade['trade_member'], $p1_id);
		array_push($trade['trade_member'], $p2_id);

		LGen('JsonMan')->save(dir.'trades/', $trade_id, $trade, $minify=false);

		set_player($p1_id, 'trade_id', $trade_id);
		set_player($p2_id, 'trade_id', $trade_id);
	}
}

?>