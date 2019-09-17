<?php 

class Friendlist {

	public function __construct() {
		set_time_limit ( 0 );
	}
	public function ask_to_be_friend($char_id, $asked_char_id) {
		$dir = BASE_DIR .'/storages/light/';

		$p1_fl = json_read($dir . 'friendlists/'. $char_id)[DATA];
		if (arr_value_exist($p1_fl['friendlist'], $asked_char_id)) {
			return $asked_char_id . ' is already exist in your friendlist.';
		}

		/* handle confirmation */
		$date = new DateTime();
		$confirmation_id = md5($char_id.$asked_char_id.$date->getTimestamp());
		$json = arr_to_json(array(
			'confirmation_id' => $confirmation_id,
			'confirmation_type' => 'friendlist',
			'asked_to' => $asked_char_id,
			'asked_by' => $char_id,
			'is_agreed' => ''
		));
		json_save($dir.'confirmations/', $confirmation_id, $json, $minify=false);

		/* handle asked char data	*/
		$asked_char_data = json_read($dir . 'players_status/'.$asked_char_id)[DATA];
		$asked_char_data['confirmation_id'] = $confirmation_id;
		json_save($dir.'players_status/', $asked_char_id, $asked_char_data, $minify=false);

		/* handle asking char data */
		$char_data = json_read($dir . 'players_status/'.$char_id)[DATA];
		$char_data['confirmation_id'] = $confirmation_id;
		json_save($dir.'players_status/', $char_id, $char_data, $minify=false);

		return true;
	}

	public function confirm_ask($confirmation_id, $is_agreed) {
		$dir = BASE_DIR .'/storages/light/';

		if ($is_agreed) {
			// handle confirmation file
			$confirmation_data = json_read($dir . 'confirmations/'.$confirmation_id)[DATA];
			$confirmation_data['is_agreed'] = true;
			json_save($dir.'confirmations/', $confirmation_id, $confirmation_data, $minify=false);

			// handle asked player status
			$asked_to_data = json_read($dir . 'players_status/'. $confirmation_data['asked_to'])[DATA];
			$asked_to_data['confirmation_id'] = '';
			json_save($dir.'players_status/', $asked_to_data['char_id'], $asked_to_data, $minify=false);

			$p1_fl = json_read($dir . 'friendlists/'. $confirmation_data['asked_to'])[DATA];
			$p2_fl = json_read($dir . 'friendlists/'. $confirmation_data['asked_by'])[DATA];

			if (!arr_value_exist($p1_fl['friendlist'], $confirmation_data['asked_by']))
				array_push($p1_fl['friendlist'], $confirmation_data['asked_by']);
			if (!arr_value_exist($p2_fl['friendlist'], $confirmation_data['asked_to']))
				array_push($p2_fl['friendlist'], $confirmation_data['asked_to']);

			json_save($dir.'friendlists/', $confirmation_data['asked_by'], $p2_fl, $minify=false);
			json_save($dir.'friendlists/', $confirmation_data['asked_to'], $p1_fl, $minify=false);
		}
		else {
			// handle confirmation file
			$confirmation_data = json_read($dir . 'confirmations/'.$confirmation_id)[DATA];
			$confirmation_data['is_agreed'] = false;
			json_save($dir.'confirmations/', $confirmation_id, $confirmation_data, $minify=false);

			// handle asked player status
			$asked_to_data = json_read($dir . 'players_status/'. $confirmation_data['asked_to'])[DATA];
			$asked_to_data['confirmation_id'] = '';
			json_save($dir.'players_status/', $asked_to_data['char_id'], $asked_to_data, $minify=false);
		}

		return $confirmation_data;
	}

	public function get_data($player_id, $slot_group_num) {
		$dir = BASE_DIR .'/storages/light/';
		$friendlist = json_read($dir . 'friendlists/'.$player_id)[DATA];
		$p1 = json_read($dir . 'players/'.$player_id)[DATA];
		$friendlist['online'] = [];

		$from = $slot_group_num*20;
		$to = $from+20;

		/* no user selected */
		// if (sizeof($friendlist['friendlist'] < $from) {
		// 	$result['online'] = [];
		// 	$result['friendlist'] = [];
		// 	return json_encode($result);
		// }
		$result['friendlist'] = [];
		$result['online'] = [];

		for ($i=$from; $i<$to; $i++) {
			if (arr_index_exist($friendlist['friendlist'], $i)) {
				$p2 = json_read($dir . 'players/'.$friendlist['friendlist'][$i])[DATA];
				
				array_push($result['friendlist'], $friendlist['friendlist'][$i]);
				// $start_date = strtotime($p1['active_date']); 
				// $end_date = strtotime('2019-07-04 18:20:20'); 
				// // $end_date = strtotime($p2['active_date']); 
				// $diff = ($end_date - $start_date);
				// // $diff = ($end_date - $start_date);
				// array_push($friendlist['online'], $diff->format('H:i:s'));

				// $time_end = $this->L->microtime_float();
				// $time = (string)($time_end - $time_start);
				// $time = substr($time, 0, 4);
			
				$start_date = ($p2['active_date']); 
				$end_date = ($p1['active_date']); 
				$time = ($end_date - $start_date);
				// $time = substr($time, 0, 4);
				if ($time < 1)
					$res = 'on';
				else
					$res = 'off';
				array_push($result['online'], $res);
			}
			else {
				array_push($result['friendlist'], "-");
				array_push($result['online'], 'none');
			}
		}
		return json_encode($result);
	}

}
?>