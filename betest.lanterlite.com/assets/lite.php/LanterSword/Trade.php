<?php 

class Trade {

	public function __construct() {
		set_time_limit ( 0 );
	}

	public function ask_for_trading($char_id, $asked_char_id, $guild_id) {

		/* handle ask for trading confirmation */
		$date = new DateTime();
		$confirmation_id = md5($char_id.$asked_char_id.$date->getTimestamp());
		$json = arr_to_json(array(
			'confirmation_id' => $confirmation_id,
			'confirmation_type' => 'trading',
			'asked_to' => $asked_char_id,
			'asked_by' => $char_id,
			'is_agreed' => ''
		));
		json_save(dir.'confirmations/', $confirmation_id, $json, $minify=false);

		/* handle asked char data	*/
		set_player($asked_char_id, 'confirmation_id', $confirmation_id);

		/* handle asking char data */
		set_player($char_id, 'confirmation_id', $confirmation_id);

		return true;
	}

	public function confirm_ask($confirmation_id, $is_agreed) {

		if ($is_agreed) {
			/* handle confirmation file */
			$confirmation_data = json_read(dir. 'confirmations/'.$confirmation_id)[DATA];
			$confirmation_data['is_agreed'] = true;
			json_save(dir.'confirmations/', $confirmation_id, $confirmation_data, $minify=false);

			/* handle asked player status */
			set_player($confirmation_data['asked_to'], 'confirmation_id', '');
		}
		else {
			/* handle confirmation file */
			$confirmation_data = json_read(dir. 'confirmations/'.$confirmation_id)[DATA];
			$confirmation_data['is_agreed'] = false;
			json_save(dir.'confirmations/', $confirmation_id, $confirmation_data, $minify=false);

			/* handle asked player status */
			set_player($confirmation_data['asked_to'], 'confirmation_id', '');
		}

		return $confirmation_data;
	}

	public function get_trade($player_id, $trade_id, $slot_group_num) {
		$trade = json_read(dir.'trades/' . $trade_id)[DATA];
		$inventory = get_player($player_id, 'inventory');

		$json['table_left'] = $trade[$player_id]['table_left'];
		$json['table_right'] = $inventory['table_right'];

		return $this->result($trade, $inventory, $player_id);
	}

	public function inventory_to_trade($slot_num, $player_id, $trade_id) {

		# get trade
		$trade = json_read(dir.'trades/' . $trade_id)[DATA];
		# get inventory
		$inventory = json_read(dir.'inventories/' . $player_id)[DATA];

		if ($inventory['table_right'][$slot_num]['item'] == '') {
			return $this->result($trade, $inventory, $player_id);
		}

		$index = '';
		for ($i=0; $i<5; $i++) {
			if ($trade[$player_id]['table_left'][$i]['item'] === '') {
				if ($index === '')
					$index = $i;
			}
			else if ($trade[$player_id]['table_left'][$i]['slot_num'] == $slot_num) {
				return 'Item is Exist';
			}
		}

		# trade slot full
		if ($index === '') {
			return 'trade slot full';
		}

		# switch item between trade slot and inventory slot
		$trade[$player_id]['table_left'][$index] = $inventory['table_right'][$slot_num];
		$trade[$player_id]['table_left'][$index]['index'] = $slot_num%25;

		# save trade file
		json_save(dir.'trades/', $trade_id, $trade, $minify=false);

		# return file
		return $this->result($trade, $inventory, $player_id);
	}

	public function agree($player_id, $trade_id) {
		$trade = json_read(dir.'trades/' . $trade_id)[DATA];
		$trade[$player_id]['is_agree'] = true;
		json_save(dir.'trades/', $trade_id, $trade, $minify=false);
		
		return true;
	}

	public function trade($player_id, $trade_id) {
		$trade = json_read(dir.'trades/' . $trade_id)[DATA];
		$trade[$player_id]['is_trade'] = true;
		json_save(dir.'trades/', $trade_id, $trade, $minify=false);

		$m1 = $trade['trade_member'][0];
		$m2 = $trade['trade_member'][1];
		
		if ($trade[$m1]['is_trade'] && $trade[$m2]['is_trade']) {
			/* read inventories files */
			$inv1 = get_player($m1, 'inventory');
			$inv2 = get_player($m2, 'inventory');

			/* check if member1 inventory is full */
			$slot_num1 = get_avail_slot_num($inv1);
			if ($slot_num1 === '')
				return $m1 . ' inventory is full.';

			/* check if member2 inventory is full */
			$slot_num2 = get_avail_slot_num($inv2);
			if ($slot_num2 === '')
				return $m2 . ' inventory is full.';

			/* move gold and trade items from m1 to m2 */
			for ($i=0; $i<sizeof($trade[$m1]['table_left']); $i++) {
				if ($trade[$m1]['table_left'][$i]['item'] != '') {
					$slot_num2 = get_avail_slot_num($inv2);
					$_slot_num = $trade[$m1]['table_left'][$i]['slot_num'];
					$inv2['table_right'][$slot_num2]['item'] = $trade[$m1]['table_left'][$i]['item'];
					$inv1['table_right'][$_slot_num]['item'] = "";
				}
			}
			$inv2['gold'] += $trade[$m1]['gold'];
			$inv1['gold'] -= $trade[$m1]['gold'];

			/* move gold and trade items from m2 to m1 */
			for ($i=0; $i<sizeof($trade[$m2]['table_left']); $i++) {
				if ($trade[$m2]['table_left'][$i]['item'] != '') {
					$slot_num1 = get_avail_slot_num($inv1);
					$_slot_num = $trade[$m2]['table_left'][$i]['slot_num'];
					$inv1['table_right'][$slot_num1]['item'] = $trade[$m2]['table_left'][$i]['item'];
					$inv2['table_right'][$_slot_num]['item'] = "";
				}
			}
			$inv1['gold'] += $trade[$m2]['gold'];
			$inv2['gold'] -= $trade[$m2]['gold'];

			set_player($m1, 'inventory', $inv1);
			set_player($m2, 'inventory', $inv2);
			$this->delete_trade($trade_id);

			return true;
		}

		json_save(dir.'trades/', $trade_id, $trade, $minify=false);

		return true;
	}

	public function set_gold($player_id, $gold, $trade_id) {

		$trade = json_read(dir.'trades/' . $trade_id)[DATA];
		$inventory = get_player($player_id, 'inventory');

		if ($inventory['gold'] >= $gold) {
			$trade[$player_id]['gold'] = $gold;
		}
		else {
			return 'Insufficent Gold';
		}
		json_save(dir.'trades/', $trade_id, $trade, $minify=false);

		return $this->result($trade, $inventory, $player_id);
	}

	public function delete_trade($trade_id) {
		$res = file_delete(dir. 'trades/'.$trade_id);
		return true;
	}

	public function result($trade, $inventory, $player_id) {
		$json['table_left'] = $trade[$player_id]['table_left'];
		$json['table_right'] = $inventory['table_right'];
		$json['trade'] = $trade;
		$json = json_encode($json);
		return $json;
	}

	public function trade_to_inventory($slot_num, $player_id, $trade_id) {

		# get trade
		$trade = json_read(dir.'trades/' . $trade_id)[DATA];
		# get inventory
		$inventory = get_player($player_id, 'inventory');

		# trade slot empty
		if ($trade[$player_id]['table_left'][$slot_num]['item'] === '') {
			return $this->result($trade, $inventory, $player_id);
		}
		else {
			$trade[$player_id]['table_left'][$slot_num]['item'] = '';
		}

		# save trade
		json_save(dir.'trades/', $trade_id, $trade, $minify=false);

		# return file
		return $this->result($trade, $inventory, $player_id);
	}

	public function init($p1_id, $p2_id) {

		/* init trade file. */
		$trade_id = create_id($p1_id.$p2_id);
		$_trade = json_read(dir.'trades/default')[DATA];
		$trade['trade_id'] = $trade_id;
		$trade[$p1_id] = $_trade['p1'];
		$trade[$p2_id] = $_trade['p2'];
		$trade['trade_member'] = [];
		array_push($trade['trade_member'], $p1_id);
		array_push($trade['trade_member'], $p2_id);

		json_save(dir.'trades/', $trade_id, $trade, $minify=false);

		set_player($p1_id, 'trade_id', $trade_id);
		set_player($p2_id, 'trade_id', $trade_id);
	}
}

?>