<?php
	
	$sword = new SwordGen();

	class SwordGen {
		public function __construct() {
			set_time_limit ( 0 );
		}
		public function get_def($obj) {
			$config_dir = HOME_DIR.'storages/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			$default = LGen('JsonMan')->read($config_dir.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"default"}')));
			return $default;
		}

		public function get_chars($obj) {
			$cit_id = $obj['val']['id'];
			$cit_lang = $obj['val']['lang'];

			$_obj = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = '@citizens/@chars';
			$_obj['keep_key'] = true;
			$_obj['is_bw'] = 0;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chars", "puzzled":false}'));
			$cits = LGen('SaviorMan2')->get_all($_obj);

			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['lang'] = $cit_lang;
			$_obj['def'] = '@chars';
			$_obj['keep_key'] = true;
			$_obj['is_bw'] = 0;
			foreach ($cits as $key => $value) {
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chars", "puzzled":false}'));
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$value['id'].'", "puzzled":false}'));
				LGen('SaviorMan2')->update($_obj);
			}

			return $cits;
		}

		public function check_acc($obj) {
			$cit_id = $obj['val']['id'];

			$_obj = [];
			$_obj['namelist'] = ['id'];
			$_obj['def'] = '@citizens';
			$_obj['is_bw'] = 0;
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			$cits = LGen('SaviorMan2')->read($_obj);
			if (sizeof($cits) === 0) {
				$_obj = [];
				$_obj['val'] = [];
				$_obj['val']['id'] = $cit_id;
				$_obj['keep_key'] = true;
				$_obj['keep_name'] = true;
				$_obj['is_bw'] = 0;
				$_obj['name'] = $cit_id;
				$_obj['def'] = '@citizens';
				$_obj['bridge'] = [];
				array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":false}'));
				$cits = LGen('SaviorMan2')->insert($_obj);
			}
			return $cits;
		}

		public function add_char($obj) {
			$cit_id = $obj['val']['cit_id'];


			$char_id = $obj['val']['username'];
			$gender = $obj['val']['gender'];
			$hair_style = $obj['val']['hair_style'];
			$hair_color = $obj['val']['hair_color'];
			$hair = 'HA'.$hair_style.$hair_color;
			$headskin = 'HS0'.$obj['val']['headskin'];

			if (in_array(strtolower($char_id), ['allah', 'muhammad', 'ahmad', 'rasulullah', 'nabi', 'prophet'])) {
				return 'Username is not allowed.';
			}

			$appearence = [];
			$appearence['headskin'] = $headskin;
			$appearence['hair'] = $hair;
			$appearence['eyes'] = "";
			$appearence['rhand'] = "";
			$appearence['lhand'] = "";
			$appearence['suit'] = "";
			$appearence['gloves'] = "";
			$appearence['shoes'] = "";
			$appearence['head'] = "";
			$appearence['glasses'] = "";
			$appearence['mask'] = "";
			$appearence['back'] = "";
			$appearence['top'] = "";

			/* check char_id char */
			$_obj = [];
			$_obj['namelist'] = ['char_id'];
			$_obj['is_bw'] = 0;
			$_obj['def'] = '@chars';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chars", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$char_id.'", "puzzled":false}'));
			$char = LGen('SaviorMan2')->read($_obj);
			error_log(json_encode($char));

			if (sizeof($char) !== 0) {
				return 'Username is exist';
			}

			/* add new char */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['appearence'] = $appearence;
			$_obj['val']['char_gender'] = $gender;
			$_obj['val']['char_id'] = $char_id;

			$_obj['name'] = $char_id;
			$_obj['keep_key'] = true;
			$_obj['keep_name'] = true;
			$_obj['is_bw'] = 0;
			$_obj['def'] = '@chars';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chars", "puzzled":false}'));
			$_char_id = LGen('SaviorMan2')->insert($_obj);

			/* add char to @citizens/@chars */
			$_obj = [];
			$_obj['val'] = [];
			$_obj['val']['id'] = $char_id;

			$_obj['name'] = $char_id;
			$_obj['keep_key'] = true;
			$_obj['keep_name'] = true;
			$_obj['is_bw'] = 0;
			$_obj['def'] = '@citizens/@chars';
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$cit_id.'", "puzzled":false}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "chars", "puzzled":false}'));
			LGen('SaviorMan2')->insert($_obj);

			return 1;
		}
	}