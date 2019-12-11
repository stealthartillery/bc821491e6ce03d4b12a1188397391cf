<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

class Speak {
	public function __construct() {
		set_time_limit ( 0 );
	}

	public function is_correct_answer($quest, $answer) {
		$answer = strtolower($answer);
		$answer = str_replace('\'', '', $answer);
		for ($i=0; $i<sizeof($quest['answer']); $i++) {
			$answer2 = strtolower($quest['answer'][$i]);
			$answer2 = str_replace('\'', '', $answer2);
			if ($answer === $answer2)
				return true;
		}
		return false;
	}

	// public function get_data($npc_id, $key) {
	// 	$speak = get_npc($npc_id, 'speak');
	// 	$json = ($speak);
	// 	return $json;
	// }

	public function get_data($player_id, $npc_id) {
		$speak = get_npc($npc_id, 'speak');
		$reply['text'] = $speak['text'][get_player($player_id, 'lang')];
		$reply['type'] = $speak['type'];

		$json = ($reply);
		return $json;
	}


	public function get_ongoing_quest($player_id, $player_quest, $npc_quest) {
		foreach ($player_quest['ongoing'] as $key => $value) {
			if (LGen('ArrayMan')->is_val_exist($npc_quest['asked_by'], $value)) { // player ask the same npc twice.
				$ongoing_quest = $this->get_quest_by_id($value);
				$reply['id'] = $ongoing_quest['id'];
				$reply['text'] = $ongoing_quest['asked_by'][get_player($player_id, 'lang')];
				$reply['type'] = $ongoing_quest['type'];
				return $reply;
			}
			else if (LGen('ArrayMan')->is_val_exist($npc_quest['asked_to'], $value)) {
				$ongoing_quest = $this->get_quest_by_id($value);

				if (sizeof($ongoing_quest['require_item']) !== 0) {
					$inventory = new Inventory();
					$item_exist = 'ok';
					for ($i=0; $i<sizeof($ongoing_quest['require_item']); $i++) {
						$is_exist = $inventory->item_exist($player_id, $ongoing_quest['require_item'][$i]['item_id'], $ongoing_quest['require_item'][$i]['item_quantity']);
						if ($is_exist !== 'ok')
							return $is_exist;
					}

					if ($item_exist === 'ok') {
						$everything_ok = true;
						if (sizeof($ongoing_quest['reward_item']) !== 0) {
							$slot_available = true;
							$inventory = new Inventory();
							$items = LGen('JsonMan')->read(dir.'items');
							$quantity = 0;
							for ($i=0; $i<sizeof($ongoing_quest['quest_item']); $i++) {
								if ($items[$ongoing_quest['quest_item'][$i]['item_id']]['is_quantable_item']) {
									$quantity += $ongoing_quest['quest_item'][$i]['item_quantity'];
								}
								else
									$quantity += 1;
							}
							$slot_available = $inventory->slot_available($player_id, $quantity);
							if (!$slot_available) {
								$everything_ok = false;
								include dir.'lang/server/'.get_player($player_id, 'lang').'.php';
								// error_log(CANT_GET_REWARD_INVENTORY_IS_FULL);
								add_to_system_chat($player_id, LGen('ArrayMan')->to_json(array('type' => 'red','text' => CANT_GET_REWARD_INVENTORY_IS_FULL)));
							}
						}
						if ($everything_ok) {
							for ($i=0; $i<sizeof($ongoing_quest['require_item']); $i++) {
								$result = $inventory->remove_item($player_id, $ongoing_quest['require_item'][$i]['item_id'], $ongoing_quest['require_item'][$i]['item_quantity']);
							}
							$this->clear_quest($player_id, $ongoing_quest['id']);
							$this->set_reward($ongoing_quest['id'], $player_id);
						}
					}
				}

				$reply['id'] = $ongoing_quest['id'];
				$reply['text'] = $ongoing_quest['asked_to'][get_player($player_id, 'lang')];
				$reply['type'] = $ongoing_quest['type'];
				return $reply;
			}
		}
		return null;
	}

	public function get_quest_by_id($quest_id) {
		$quest = LGen('JsonMan')->read(dir.'quests/'.$quest_id);
		return $quest;
	}

	public function get_quest_asked_by_npc($player_id, $player_quest, $npc_quest) {
		include dir.'lang/server/'.get_player($player_id, 'lang').'.php';
		foreach ($npc_quest['asked_by'] as $key => $value) {
			if (!LGen('ArrayMan')->is_val_exist($player_quest['done'], $value) // the quest haven't done by the player
				and !LGen('ArrayMan')->is_val_exist($player_quest['fail'], $value)) { // the quest haven't failed by the player
				$char_level = get_player($player_id, 'char_level');
				$new_quest = $this->get_quest_by_id($value);

				if ($char_level < $new_quest['level_limit'])
					return YOU_HAVE_TO_REACH_AT_LEAST_LEVEL.' '. $new_quest['level_limit']. ' '.TO_TAKE_THIS_QUEST;

				$everything_ok = true;
				if (sizeof($new_quest['quest_item']) !== 0) {
					$inventory = new Inventory();
					$items = LGen('JsonMan')->read(dir.'items');
					$quantity = 0;
					for ($i=0; $i<sizeof($new_quest['quest_item']); $i++) {
						if ($items[$new_quest['quest_item'][$i]['item_id']]['is_quantable_item']) {
							$quantity += $new_quest['quest_item'][$i]['item_quantity'];
						}
						else
							$quantity += 1;
					}
					$slot_available = $inventory->slot_available($player_id, $quantity);
					error_log('a' .  $player_id . ' b' .  $slot_available);
						// return 'asd '.  $slot_available;
					if (!$slot_available)
						return INVENTORY_IS_FULL;

					for ($i=0; $i<sizeof($new_quest['quest_item']); $i++) {
						$inventory->add_item($player_id, $new_quest['quest_item'][$i]['item_id'], $new_quest['quest_item'][$i]['item_quantity']);
					}
				}

				$p_quest = get_player($player_id, 'quest');
				array_push($p_quest['ongoing'], $value);
				set_player($player_id, 'quest', $p_quest);
				return $new_quest;
			}
		}

		return THERE_IS_NO_AVAILABLE_QUEST;
	}

	public function get_quest($player_id, $npc_id) {
		$player_quest = get_player($player_id, 'quest');
		$npc_quest = get_npc($npc_id, 'quest');

		$ongoing_quest = $this->get_ongoing_quest($player_id, $player_quest, $npc_quest);
		if ($ongoing_quest === null) { // player dont have ongoing quest with this npc
			$new_quest = $this->get_quest_asked_by_npc($player_id, $player_quest, $npc_quest);
			if (gettype($new_quest) === 'string')
				return $new_quest;
			else {
				$reply['id'] = $new_quest['id'];
				$reply['text'] = $new_quest['asked_by'][get_player($player_id, 'lang')];
				$reply['type'] = $new_quest['type'];
				return ($reply);
			}
		}
		else {
			$reply = $ongoing_quest;
			return ($reply);
		}

	}

	public function get_quest2($player_id, $npc_id) {
		$q_info = get_player($player_id, 'quest');
		$q_list = LGen('JsonMan')->read(dir.'quests/'.'quest_list');

		// echo sizeof($q_list[$npc_id]) != 0;
		// echo ;
		if (sizeof($q_list[$npc_id]) != 0 and $q_info[$npc_id] < sizeof($q_list[$npc_id])) {
			$json = LGen('JsonMan')->read(dir.'quests/'. $q_list[$npc_id][$q_info[$npc_id]]);
		} 
		else {
			$json = LGen('JsonMan')->read(dir.'quests/'. $npc_id.'/default');
		}

		$json = ($json);
		return $json;
	}

	public function clear_quest($player_id, $quest_id) {
		$p_quest = get_player($player_id, 'quest');
		LGen('ArrayMan')->rmv_by_val($p_quest['ongoing'], $quest_id);
		array_push($p_quest['done'], $quest_id);
		set_player($player_id, 'quest', $p_quest);
	}
	
	public function fail_quest($player_id, $quest_id) {
		$p_quest = get_player($player_id, 'quest');
		LGen('ArrayMan')->rmv_by_val($p_quest['ongoing'], $quest_id);
		array_push($p_quest['fail'], $quest_id);
		set_player($player_id, 'quest', $p_quest);
	}

	public function post_quest_answer($answer, $quest_id, $player_id) {
		$quest = $this->get_quest_by_id($quest_id);
		// echo $answer. ' '. $quest_id. ' '. $player_id;
		// printJson($quest);
		$reply = [];
		if ($answer == 'not_answer') {
			$reply['id'] = $quest['id'];
			$reply['text'] = $quest['not_answer'][get_player($player_id, 'lang')];
			$reply['type'] = 'not_answer';
		}
		else if ($this->is_correct_answer($quest, $answer)) {
			$slot_available = true;
			if (sizeof($quest['reward_item']) !== 0) {
				$inventory = new Inventory();
				$items = LGen('JsonMan')->read(dir.'items');
				$quantity = 0;
				for ($i=0; $i<sizeof($quest['quest_item']); $i++) {
					if ($items[$quest['quest_item'][$i]['item_id']]['is_quantable_item'])
						$quantity += $quest['quest_item'][$i]['item_quantity'];
					else
						$quantity += 1;
				}
				$slot_available = $inventory->slot_available($player_id, $quantity);
			}

			if ($slot_available) {
				$this->set_reward($quest_id, $player_id);
				$this->clear_quest($player_id, $quest_id);
			}
			else {
				add_to_system_chat($player_id, LGen('ArrayMan')->to_json(array('type' => 'red','text' => 'Inventory is full.')));
			}

			$reply['id'] = $quest['id'];
			$reply['text'] = $quest['right_answer'][get_player($player_id, 'lang')];
			$reply['type'] = 'right_answer';
		}
		else {
			if (!$quest['is_false_tolerant']) {
				$this->fail_quest($player_id, $quest_id);

				$reply['info'] = LGen('ArrayMan')->to_json(array(
					'type' => 'red',
					'text' => "Quest failed! You can no longer take this quest."
				));
			}

			$reply['id'] = $quest['id'];
			$reply['text'] = $quest['wrong_answer'][get_player($player_id, 'lang')];
			$reply['type'] = 'wrong_answer';
		}
		return ($reply);

		// $reply = ($reply);
		// return $reply;
	}


	public function set_reward($quest_id, $player_id) {
		$system_chat = [];
		$quest = $this->get_quest_by_id($quest_id);
		$items = LGen('JsonMan')->read(dir.'items');
		include dir.'lang/server/'.get_player($player_id, 'lang').'.php';
		array_push($system_chat, LGen('ArrayMan')->to_json(array('type' => 'green', 'text' => QUEST_CLEARED)));

		$everything_ok = true;

		if (sizeof($quest['reward_item']) !== 0) { // there is reward items
			$inventory = new Inventory();
			// printJson($quest['reward_item']);

			for ($i=0; $i<sizeof($quest['reward_item']); $i++) {
				$everything_ok = $inventory->add_item($player_id, $quest['reward_item'][$i]['item_id'], $quest['reward_item'][$i]['item_quantity']);
				if ($everything_ok) {
					$chat = YOU_HAVE_EARNED. " ".$quest['reward_item'][$i]['item_quantity'] .' '. $items[$quest['reward_item'][$i]['item_id']]['name'] . " ".AS_REWARD;
					array_push($system_chat, LGen('ArrayMan')->to_json(array('type' => 'green','text' => $chat)));
					// add_to_system_chat($player_id, LGen('ArrayMan')->to_json(array('type' => 'green', 'text' => $chat)));
				}
				else {
					array_push($system_chat, LGen('ArrayMan')->to_json(array('type' => 'green', 'text' => CANT_GET_REWARD_INVENTORY_IS_FULL)));
					// add_to_system_chat($player_id, LGen('ArrayMan')->to_json(array('type' => 'green', 'text' => CANT_GET_REWARD_INVENTORY_IS_FULL)));
				}
			}
		}

		if ($everything_ok) {
			$char_exp = get_player($player_id, 'char_exp');
			$char_exp['current'] += $quest['reward_exp'];
			set_player($player_id, 'char_exp', $char_exp);

			$char_gold = get_player($player_id, 'gold');
			$char_gold += $quest['reward_gold'];
			set_player($player_id, 'gold', $char_gold);
			
			if ($quest['reward_exp'] > 0) {
				$chat = YOU_HAVE_EARNED.' ' . $quest['reward_exp'].' exp '. AS_REWARD;
				array_push($system_chat, LGen('ArrayMan')->to_json(array('type' => 'green','text' => $chat)));
				// add_to_system_chat($player_id, LGen('ArrayMan')->to_json(array('type' => 'green','text' => $chat)));
				// array_push($info, LGen('ArrayMan')->to_json(array('type' => 'green','text' => $chat)));
			}
			if ($quest['reward_gold'] > 0){
				$chat = YOU_HAVE_EARNED.' ' . $quest['reward_gold'].' golds '. AS_REWARD;
				array_push($system_chat, LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $chat)));
				// add_to_system_chat($player_id, LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $chat)));
				// array_push($info, LGen('ArrayMan')->to_json(array('type' => 'yellow','text' => $chat)));
			}
			if ($quest['reward_pearl'] > 0) {
				$chat = YOU_HAVE_EARNED.' ' . $quest['reward_pearl'].' pearls '. AS_REWARD;
				array_push($system_chat, LGen('ArrayMan')->to_json(array('type' => 'blue','text' => $chat)));
				// add_to_system_chat($player_id, LGen('ArrayMan')->to_json(array('type' => 'blue','text' => $chat)));
			}
		}
		add_to_system_chat($player_id, $system_chat);
	}




}
?>