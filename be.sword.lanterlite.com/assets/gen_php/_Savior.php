<?php
	class SaviorMan {
		public function __construct() {
			set_time_limit ( 0 );
		}

		public function asd() {
			return 'asd';
		}

		public function id($obj) {
			return gen_id($obj, false);
		}

		public function gen_bridge($bridge) {
			$_bridge = '';
			foreach ($bridge as $key => $value) {
				if ($value['puzzled'])
					$_bridge = $_bridge . gen_id(str_to_json('{"id":"'.$value['id'].'"}')) . '/';
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

		public function set_rand_config($obj) {
			$this->req_validator($obj);

			$config_dir = BASE_DIR.'storages/'.$obj['gate'].'/'.gen_id(str_to_json('{"id":"config"}')).'/';
			for ($i=0; $i<$total; $i++) {
				for ($j=0; $j<rand(10,20); $j++) {
					$obj['val'][gen_id()] = gen_id();
				}
				LGen('JsonMan')->save($config_dir, gen_id().'.lgd', $obj['val'], $minify=false);
			}
			return LGen('GlobVar')->success;
		}

		public function req_validator(&$obj) {
			if (!LGen('JsonMan')->is_key_exist($obj,'gate')) return 'You lost the Gate.'; // app name.
			if (!LGen('JsonMan')->is_key_exist($obj,'limited')) $obj['limited'] = false;  // limit total golds for a chamber.
			if (!LGen('JsonMan')->is_key_exist($obj,'val')) $obj['val'] = ""; else $obj['val'] = str_to_json(base64_decode($obj['val']));// the gold.
			if (!LGen('JsonMan')->is_key_exist($obj,'bridge')) $obj['bridge'] = []; // way to the castle.
			if (!LGen('JsonMan')->is_key_exist($obj,'def')) $obj['def'] = ''; // default name.
			if (!LGen('JsonMan')->is_key_exist($obj,'single')) $obj['single'] = false; // want to set for a single gold.
			if (!LGen('JsonMan')->is_key_exist($obj,'total')) $obj['total'] = 0; // just total.
			if (!LGen('JsonMan')->is_key_exist($obj,'name')) $obj['name'] = ''; // gold name.
			if (!LGen('JsonMan')->is_key_exist($obj,'namelist')) $obj['namelist'] = []; // list of gold name.
			if ($obj['limited']) $obj['limit'] = 1000; else $obj['limit'] = '';

			return $obj;
		}

		public function insert($obj) {
			$this->req_validator($obj);

			// echo $obj['val'];
			// return 0;

			$_bridge = $this->gen_bridge($obj['bridge']);
			$dir = BASE_DIR.'storages/'.$obj['gate'].'/'.$_bridge;
			
			$obj['name'] = gen_id(str_to_json('{"id":"'.$obj['name'].'"}'));
			if ($obj['name'] === '') {
				$filenames = getFileNamesInsideDir($dir);
				while (LGen('ArrayMan')->is_val_exist($filenames, $obj['name']).'.lgd') {
					$obj['name'] = gen_id();
				}
			}

			if ($obj['limit'] !== '') {
				$this->update_dir_by_limit($dir, $obj['limit']);
			}

			// return json_encode($obj['bridge']);
			if ($obj['def'] !== '') {
				$config_dir = BASE_DIR.'storages/'.$obj['gate'].'/'.gen_id(str_to_json('{"id":"config"}')).'/';
				$default = LGen('JsonMan')->read($config_dir.gen_id(str_to_json('{"id":"default"}')));
				$default = $default[$obj['def']];

				if ($obj['single']) {
					foreach ($default as $key => $value) {
						if (LGen('JsonMan')->is_key_exist($obj['val'],$key))
							$default[$key] = $obj['val'][$key];
					}
					$obj['val'] = $default;
					LGen('JsonMan')->save($dir, $obj['name'].'.lgd', $obj['val'], $minify=false);
				}
				else {
					foreach ($default as $key => $value) {
						if (LGen('JsonMan')->is_key_exist($obj['val'],$key))
							$default[$key] = $obj['val'][$key];

						if ($key === 'id')
							$default[$key] = $obj['name'];
						if ($key === 'date')
							$default[$key] = gmdate("Y/m/d H:i:s T");

						$_dir = $dir . $obj['name'] . '/';
						if ($value !== 'dir') {
							$_filename = gen_id(str_to_json('{"id":"'.$key.'"}'));
							LGen('JsonMan')->save($_dir, $_filename.'.lgd', $default[$key], $minify=false);
						}
						else {
							$_filename = gen_id(str_to_json('{"id":"'.$key.'"}'));
							mkdir($_dir.$_filename, 0777, true);
						}
					}
				}
			}
			else {
				if ($obj['single']) {
					LGen('JsonMan')->save($dir, $obj['name'].'.lgd', $obj['val'], $minify=false);
				}
			}

			return $obj['name'];
		}

		public function update($obj) {
			$this->req_validator($obj);

			$_bridge = $this->gen_bridge($obj['bridge']);
			$dir = BASE_DIR.'storages/'.$obj['gate'].'/'.$_bridge;

			$obj['name'] = gen_id(str_to_json('{"id":"'.$obj['name'].'"}'));
			$filenames = getFileNamesInsideDir($dir);
			if (LGen('ArrayMan')->is_val_exist($filenames, $obj['name'].'.lgd')) {
				if ($obj['def'] !== '') {
					$config_dir = BASE_DIR.'storages/'.$obj['gate'].'/'.gen_id(str_to_json('{"id":"config"}')).'/';
					$default = LGen('JsonMan')->read($config_dir.gen_id(str_to_json('{"id":"default"}')));
					$default = $default[$obj['def']];
					foreach ($default as $key => $value) {
						if (LGen('JsonMan')->is_key_exist($obj['val'],$key))
							$default[$key] = $obj['val'][$key];
					}
					$obj['val'] = $default;
				}
				LGen('JsonMan')->save($dir, $obj['name'].'.lgd', $obj['val'], $minify=false);
				return LGen('GlobVar')->success;
			}
			return LGen('GlobVar')->not_found;
		}

		public function delete($obj) {
			$this->req_validator($obj);

			$_bridge = $this->gen_bridge($obj['bridge']);
			$dir = BASE_DIR.'storages/'.$obj['gate'].'/'.$_bridge;

			$filenames = getFileNamesInsideDir($dir);
			if (LGen('ArrayMan')->is_val_exist($filenames, $obj['name'].'.lgd')) {
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
			$data = str_to_json('{}');

			// echo '$filenames ' . json_encode($filenames);
			foreach ($obj['namelist'] as $key => $value) {
				$_val = gen_id(str_to_json('{"id":"'.$value.'"}')).'.lgd';
				if (LGen('ArrayMan')->is_val_exist($filenames, $_val)) {
					$data[$value] = LGen('JsonMan')->read($dir.$_val);
				}
			}
			return $data;
		}
	}
?>