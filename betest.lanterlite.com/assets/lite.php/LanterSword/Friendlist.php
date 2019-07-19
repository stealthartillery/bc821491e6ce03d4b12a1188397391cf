<?php 

class Friendlist {

	public function __construct() {
		set_time_limit ( 0 );
	}
	public function ask_to_be_friend($char_id, $asked_char_id) {

		$p1_fl = get_player($char_id, 'friendlist');
		if (arr_value_exist($p1_fl, $asked_char_id)) {
			return $asked_char_id . ' is already exist in your friendlist.';
		}

		/* handle confirmation */
		$confirmation_id = create_id($char_id.$asked_char_id);
		$json = arr_to_json(array(
			'confirmation_id' => $confirmation_id,
			'confirmation_type' => 'friendlist',
			'asked_to' => $asked_char_id,
			'asked_by' => $char_id,
			'is_agreed' => ''
		));
		json_save(dir.'confirmations/', $confirmation_id, $json, $minify=false);

		/* set confirmation id to asked char */
		set_player($asked_char_id, 'confirmation_id', $confirmation_id);

		/* set confirmation id to asking char */
		set_player($char_id, 'confirmation_id', $confirmation_id);

		return true;
	}

	public function confirm_ask($confirmation_id, $is_agreed) {

		if ($is_agreed) {
			/* handle confirmation file */
			$confirmation_data = json_read(dir. 'confirmations/'.$confirmation_id)[DATA];
			$confirmation_data['is_agreed'] = true;
			json_save(dir.'confirmations/', $confirmation_id, $confirmation_data, $minify=false);

			/* remove confirmation id from asked char */
			set_player($confirmation_data['asked_to'], 'confirmation_id', '');

			$p1_fl = get_player($confirmation_data['asked_to'], 'friendlist');
			$p2_fl = get_player($confirmation_data['asked_by'], 'friendlist');

			if (!arr_value_exist($p1_fl, $confirmation_data['asked_by']))
				array_push($p1_fl, $confirmation_data['asked_by']);
			if (!arr_value_exist($p2_fl, $confirmation_data['asked_to']))
				array_push($p2_fl, $confirmation_data['asked_to']);

			set_player($confirmation_data['asked_by'], 'friendlist', $p2_fl);
			set_player($confirmation_data['asked_to'], 'friendlist', $p1_fl);
		}
		else {
			/* handle confirmation file */
			$confirmation_data = json_read(dir. 'confirmations/'.$confirmation_id)[DATA];
			$confirmation_data['is_agreed'] = false;
			json_save(dir.'confirmations/', $confirmation_id, $confirmation_data, $minify=false);

			/* remove confirmation id from asked char */
			set_player($confirmation_data['asked_to'], 'confirmation_id', '');
		}

		return $confirmation_data;
	}

	public function get_data($player_id, $slot_group_num) {
		$p1_fl = get_player($player_id, 'friendlist');
		$p1_active_date = get_player($player_id, 'active_date');

		$from = $slot_group_num*20;
		$to = $from+20;

		/* no user selected */
		// if (sizeof($p1_fl < $from) {
		// 	$result['online'] = [];
		// 	$result['friendlist'] = [];
		// 	return json_encode($result);
		// }
		$result['friendlist'] = [];
		$result['online'] = [];

		for ($i=$from; $i<$to; $i++) {
			if (arr_index_exist($p1_fl, $i)) {
				
				array_push($result['friendlist'], $p1_fl[$i]);
				// $start_date = strtotime($p1['active_date']); 
				// $end_date = strtotime('2019-07-04 18:20:20'); 
				// // $end_date = strtotime($p2['active_date']); 
				// $diff = ($end_date - $start_date);
				// // $diff = ($end_date - $start_date);
				// array_push($friendlist['online'], $diff->format('H:i:s'));

				// $time_end = $this->L->microtime_float();
				// $time = (string)($time_end - $time_start);
				// $time = substr($time, 0, 4);
			
				$p2_active_date = get_player($p1_fl[$i], 'active_date');
				$start_date = ($p2_active_date); 
				$end_date = ($p1_active_date); 
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