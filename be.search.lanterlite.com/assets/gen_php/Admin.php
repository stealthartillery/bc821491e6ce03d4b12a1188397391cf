<?php
	class Admin {
		function add_license($obj) {
			$_obj = [];
			$_obj['gate'] = 'savior';
			$_obj['def'] = 'licenses';
			$_obj['val'] = [];
			$_obj['val']['type'] = $obj['val']['type'];
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['val']['id'].'", "puzzled":false}'));
			// $_bridge = $this->gen_bridge($_obj['bridge']);
			// $dir = BASE_DIR.'storages/'.$_obj['gate'].'/'.$_bridge;
			LGen('SaviorMan')->insert($obj);
		}

		function verify_email($obj) {
			$_obj = [];
			$_obj['gate'] = 'savior';
			$_obj['def'] = 'citizens';
			$_obj['val'] = [];
			$_obj['val']['is_verified'] = $obj['val']['type'];
			$_obj['bridge'] = [];
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "citizens", "puzzled":true}'));
			array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$obj['val']['id'].'", "puzzled":false}'));
			// $_bridge = $this->gen_bridge($_obj['bridge']);
			// $dir = BASE_DIR.'storages/'.$_obj['gate'].'/'.$_bridge;
			LGen('SaviorMan')->insert($obj);
		}
	}
?>