<?php
	ini_set("log_errors", 1);
	ini_set("error_log", BASE_DIR.'storages/savior/'. 'savior.log');

	class SaviorMan {
		public function __construct() {
			set_time_limit ( 0 );
		}

		public function req_validator(&$obj) {
			// error_log(json_encode($obj['val']));
			if (!LGen('JsonMan')->is_key_exist($obj,'gate')) return 'You lost the Gate.'; // app name.
			if (!LGen('JsonMan')->is_key_exist($obj,'limited')) $obj['limited'] = false;  // limit total golds for a chamber.
			// error_log(json_encode($obj['val']));
			if (!LGen('JsonMan')->is_key_exist($obj,'val')) $obj['val'] = "";// the gold.
			// if (!LGen('JsonMan')->is_key_exist($obj,'val')) $obj['val'] = ""; else $obj['val'] = LGen('StringMan')->to_json(base64_decode($obj['val']));// the gold.
			if (!LGen('JsonMan')->is_key_exist($obj,'bridge')) $obj['bridge'] = []; // way to the castle.
			if (!LGen('JsonMan')->is_key_exist($obj,'def')) $obj['def'] = ''; // default name.
			if (!LGen('JsonMan')->is_key_exist($obj,'single')) $obj['single'] = false; // want to set for a single gold.
			if (!LGen('JsonMan')->is_key_exist($obj,'total')) $obj['total'] = 0; // just total.
			if (!LGen('JsonMan')->is_key_exist($obj,'name')) $obj['name'] = ''; // gold name.
			if (!LGen('JsonMan')->is_key_exist($obj,'namelist')) $obj['namelist'] = []; // list of gold name.
			if ($obj['limited']) $obj['limit'] = 1000; else $obj['limit'] = '';

			return $obj;
		}

		public function get_all($obj) {
			$this->req_validator($obj);
			$_bridge = $this->gen_bridge($obj['bridge']);
			$dir = BASE_DIR.'storages/'.$obj['gate'].'/'.$_bridge;

			$bridge = $obj['bridge'];

			$citizens = getFileNamesInsideDir($dir);
			$result = [];
			if ($citizens === LGen('GlobVar')->not_found)
				return $result;
			// error_log(json_encode($obj['val']));
			foreach ($citizens as $key => $value) {
				$obj['bridge'] = $bridge;
				array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$value.'", "puzzled":false}'));
				$citizen = $this->read($obj);
				array_push($result, $citizen);
			}
			return $result;
		}

		public function insert($obj) {
			$this->req_validator($obj);

			$_bridge = $this->gen_bridge($obj['bridge']);
			$dir = BASE_DIR.'storages/'.$obj['gate'].'/'.$_bridge;
			
			$obj['name'] = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$obj['name'].'"}'));
			if ($obj['name'] === '') {
				$filenames = getFileNamesInsideDir($dir);
				while (LGen('ArrayMan')->is_val_exist($filenames, $obj['name']).'.lgd') {
					$obj['name'] = LGen('F')->gen_id();
				}
			}
			error_log($obj['name']);
			error_log($dir);
			// if ($obj['limit'] !== '') {
			// 	$this->update_dir_by_limit($dir, $obj['limit']);
			// }

			// return json_encode($obj['bridge']);
			if ($obj['def'] !== '') {
				$config_dir = BASE_DIR.'storages/'.$obj['gate'].'/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
				$default = LGen('JsonMan')->read($config_dir.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"default"}')));
				$default = $default[$obj['def']];

				if ($obj['single']) {
					foreach ($default as $key => $value) {
						if (LGen('JsonMan')->is_key_exist($obj['val'],$key))
							$default[$key] = $obj['val'][$key];
					}
					$obj['val'] = $default;
					error_log(json_encode($obj['val']));
					LGen('JsonMan')->save($dir, $obj['name'].'.lgd', $this->when_save_encrypt($obj['val']), $minify=false);
				}
				else {
					foreach ($default as $key => $value) {
						if (LGen('JsonMan')->is_key_exist($obj['val'],$key))
							$default[$key] = $obj['val'][$key];

						if ($key === 'id')
							$default[$key] = $obj['name'];

						if ($key === 'created_date') {
							if (LGen('JsonMan')->is_key_exist($obj['val'], $key)) {
								if ($obj['val'][$key] === '')
									$default[$key] = gmdate("Y/m/d H:i:s T");
							}
							else {
								$default[$key] = gmdate("Y/m/d H:i:s T");
							}
						}

						$_dir = $dir . $obj['name'] . '/';
						if ($value !== 'dir') {
							$_filename = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$key.'"}'));
							LGen('JsonMan')->save($_dir, $_filename.'.lgd', $this->when_save_encrypt($default[$key]), $minify=false);
						}
						else {
							$_filename = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$key.'"}'));
							mkdir($_dir.$_filename, 0777, true);
						}
					}
				}
			}
			else {
				if ($obj['single']) {
					LGen('JsonMan')->save($dir, $obj['name'].'.lgd', $this->when_save_encrypt($obj['val']), $minify=false);
				}
			}

			return $obj['name'];
		}

		public function update($obj) {
			$this->req_validator($obj);

			$_bridge = $this->gen_bridge($obj['bridge']);
			$dir = BASE_DIR.'storages/'.$obj['gate'].'/'.$_bridge;

			// $obj['name'] = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$obj['val'].'"}'));

			// // key to encrypted 
			// foreach ($obj['val'] as $key => $value) {
			// 	$encripted_name = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$key.'"}'));
			// 	$obj['val'][$encripted_name] = $obj['val'][$key];
			// 	unset($obj['val'][$key]);
			// }

			$config_dir = BASE_DIR.'storages/'.$obj['gate'].'/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			$default = LGen('JsonMan')->read($config_dir.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"default"}')));
			$default = $default[$obj['def']];

			$filenames = getFileNamesInsideDir($dir);

			$data_to_save = [];
			foreach ($default as $key1 => $val1) {
				foreach ($obj['val'] as $key2 => $val2) {
					if ($key1 === $key2) {
						$data_to_save[$key1] = $val2;
					}
				}
			}

			foreach ($data_to_save as $key => $value) {
				$filename = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$key.'"}'));
				LGen('JsonMan')->save($dir, $filename.'.lgd', $this->when_save_encrypt($obj['val'][$key]), $minify=false);
			}

			// if (LGen('ArrayMan')->is_val_exist($filenames, $obj['name'].'.lgd')) {
			// 	if ($obj['def'] !== '') {
			// 		$config_dir = BASE_DIR.'storages/'.$obj['gate'].'/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			// 		$default = LGen('JsonMan')->read($config_dir.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"default"}')));
			// 		$default = $default[$obj['def']];
			// 		foreach ($default as $key => $value) {
			// 			if (LGen('JsonMan')->is_key_exist($obj['val'],$key))
			// 				$default[$key] = $obj['val'][$key];
			// 		}
			// 		$obj['val'] = $default;
			// 	}
			// 	LGen('JsonMan')->save($dir, $obj['name'].'.lgd', $this->when_save_encrypt($obj['val']), $minify=false);
			// 	return LGen('GlobVar')->success;
			// }
			// return LGen('GlobVar')->not_found;
		}

		public function delete_pack($obj) {
			$this->req_validator($obj);

			$_bridge = $this->gen_bridge($obj['bridge']);
			$dir = BASE_DIR.'storages/'.$obj['gate'].'/'.$_bridge;

			$filenames = getFileNamesInsideDir($dir);
			if (LGen('ArrayMan')->is_val_exist($filenames, $obj['name'])) {
				dir_delete($dir.$obj['name']);
				return LGen('GlobVar')->success;
			}
			return LGen('GlobVar')->not_found;
		}

		public function read_all_by_limit($obj) {
		}

		public function read($obj) {
			$this->req_validator($obj);

			$_bridge = $this->gen_bridge($obj['bridge']);
			$dir = BASE_DIR.'storages/'.$obj['gate'].'/'.$_bridge;
			$filenames = getFileNamesInsideDir($dir);
			error_log($dir);
			// error_log(json_encode($filenames));
			if ($filenames === LGen('GlobVar')->not_found)
				return [];

			$config_dir = BASE_DIR.'storages/'.$obj['gate'].'/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			$default = LGen('JsonMan')->read($config_dir.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"default"}')));
			$default = $default[$obj['def']];

			$data = LGen('StringMan')->to_json('{}');
			foreach ($obj['namelist'] as $key => $value) {
				$_val = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$value.'"}')).'.lgd';
				if (LGen('ArrayMan')->is_val_exist($filenames, $_val)) {
					$data[$value] = LGen('JsonMan')->read($dir.$_val);
					$data[$value] = $this->when_read_decrypt($data[$value]);
				}
				else if (LGen('JsonMan')->is_key_exist($default, $value)) {
					// $_val = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$value.'"}'));
					// if (file_exists($dir.$_val)) {

					// }
					// else
					$data[$value] = base64_encode($default[$value]);
				}
			}
			return $data;
		}

		public function id($obj) {
			return LGen('F')->gen_id($obj, false);
		}

		public function gen_bridge($bridge) {
			$_bridge = '';
			foreach ($bridge as $key => $value) {
				if ($value['puzzled'])
					$_bridge = $_bridge . LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$value['id'].'"}')) . '/';
				else
					$_bridge = $_bridge . $value['id'] . '/';
			}
			return $_bridge;
		}

		public function update_dir_by_limit(&$dir, $limit) {
			$inc = 1;
			$_dir = $dir.'/'.$inc;
			if (!file_exists($_dir))
				mkdir($_dir, 0777, true);
			$filenames = getFileNamesInsideDir($_dir);
			while (sizeof($filenames) >= $limit) {
				$inc += 1;
				$_dir = $dir.'/'.$inc;
				if (!file_exists($_dir))
					mkdir($_dir, 0777, true);
				$filenames = getFileNamesInsideDir($_dir);
			}
			$dir = $_dir . '/';
			return $dir;
		}

		public function when_save_encrypt($val) {
			$str = base64_encode($val);
			$str = LGen('StringMan')->gen_rand(5).$str;
			return $str;
		}

		public function when_read_decrypt($val) {
			$str = substr($val, 5);
			return $str;
		}

		public function set_rand_config($obj) {
			$this->req_validator($obj);

			$config_dir = BASE_DIR.'storages/'.$obj['gate'].'/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			for ($i=0; $i<$total; $i++) {
				for ($j=0; $j<rand(10,20); $j++) {
					$obj['val'][LGen('F')->gen_id()] = LGen('F')->gen_id();
				}
				LGen('JsonMan')->save($config_dir, LGen('F')->gen_id().'.lgd', $obj['val'], $minify=false);
			}
			return LGen('GlobVar')->success;
		}
	}
?>