<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Quest {
	public function __construct() {
		set_time_limit ( 0 );
	}

	public function is_correct_answer($quest, $answer) {
		return arr_value_exist($quest['answer'], $answer);
	}

	public function get_speak($player_id, $npc_id) {
		$speak = get_npc($npc_id, 'speak');
		$json = json_encode($speak);
		return $json;
	}

	public function get_quest($player_id, $npc_id) {
		$q_info = get_player($player_id, 'quest');
		$q_list = json_read(dir.'quests/'.'quest_list')[DATA];

		// echo sizeof($q_list[$npc_id]) != 0;
		// echo ;
		if (sizeof($q_list[$npc_id]) != 0 and $q_info[$npc_id] < sizeof($q_list[$npc_id])) {
			$json = json_read(dir.'quests/'. $q_list[$npc_id][$q_info[$npc_id]])[DATA];
		} 
		else {
			$json = json_read(dir.'quests/'. $npc_id.'/default')[DATA];
		}

		$json = json_encode($json);
		return $json;
	}

	public function post_quest_answer($answer, $quest_id, $player_id) {
		$quest = json_read(dir.'quests/'. $quest_id)[DATA];
		$reply = [];
		if ($answer == 'not_answer') {
			return true;
		}
		else if ($this->is_correct_answer($quest, $answer)) {
			return true;
		}
		else {
			return false;
		}

		// $reply = json_encode($reply);
		// return $reply;
	}

	public function post_quest_answer2($answer, $npc_id, $player_id) {
		$quest = json_read(dir.'quests/'. $npc_id)[DATA];

		$player_quest = get_player($player_id, 'quest');

		if (arr_value_exist($quest['quest'][$player_quest[$npc_id]]['answer'], $answer)) {
			$reward_item_id = $quest['quest'][$player_quest[$npc_id]]['reward_item'];

			if ($reward_item_id !== '') {
				$items = json_read(dir.'items')[DATA];

				$inventory = get_player($player_id, 'inventory');

				if ($items[$reward_item_id]['is_quantable_item']) {
					for ($i=0; $i<sizeof($inventory['table_right']); $i++) {
						if ($inventory['table_right'][$i]['item_id'] == $reward_item_id) {
							$inventory['table_right'][$i]['item_quantity'] += $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity'];
							$is_exist = true;
							break;
						}
					}
					$json['info'] = arr_to_json(array(
						'type' => 'green',
						'text' => "Anda mendapatkan ". $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity'] ." item " . $items[$reward_item_id]['name']
					));
					$json['type'] = 'reply';
					$json['talk'] = $quest['quest'][$player_quest[$npc_id]]['right_answer'];

					set_player($player_id, 'inventory', $inventory);
					// json_save(dir.'inventories/', $player_id, $inventory, $minify=false);
				}
				else if (sizeof($inventory['table_right']) < total_item_limit) {
					$slot_num = get_avail_slot_num($inventory);
					array_push($inventory['table_right'], arr_to_json(array(
						'slot_num' => $slot_num,
						'item_id' => $reward_item_id,
						'item_quantity' => $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity']
					)));

					set_player($player_id, 'inventory', $inventory);
					// json_save(dir.'inventories/', $player_id, $inventory, $minify=false);

					$json['info'] = arr_to_json(array(
						'type' => 'green',
						'text' => "Anda mendapatkan ". $quest['quest'][$player_quest[$npc_id]]['reward_item_quantity'] ." item " . $items[$reward_item_id]['name']
					));
					$json['type'] = 'reply';
					$json['talk'] = $quest['quest'][$player_quest[$npc_id]]['right_answer'];
				}
				else {
					$_reply = [];
		      array_push($_reply,  arr_to_json(array("type"=>"xchoice", "text"=>"Aku tidak bisa memberikan barang karena inventorimu penuh.")));

					$json['info'] = arr_to_json(array(
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



}
?>