<?php

	class SaviorMan2 {
		public function __construct() {
			set_time_limit ( 0 );
		}

		public function req_validator(&$obj) {
			$obj['gate'] = ''; // app name.
			// if (!LGen('JsonMan')->is_key_exist($obj,'gate')) $obj['gate'] = ''; // app name.
			// if (!LGen('JsonMan')->is_key_exist($obj,'gate')) return 'You lost the Gate.'; // app name.
			if (!LGen('JsonMan')->is_key_exist($obj,'branched')) $obj['branched'] = false;  // branch total golds for a chamber.
			// error_log(json_encode($obj['val']));
			if (!LGen('JsonMan')->is_key_exist($obj,'val')) $obj['val'] = LGen('StringMan')->to_json('{}');// the gold.
			// if (!LGen('JsonMan')->is_key_exist($obj,'val')) $obj['val'] = ""; else $obj['val'] = LGen('StringMan')->to_json(base64_decode($obj['val']));// the gold.
			if (!LGen('JsonMan')->is_key_exist($obj,'bridge')) $obj['bridge'] = []; // way to the castle.
			if (!LGen('JsonMan')->is_key_exist($obj,'note')) $obj['note'] = ''; // way to the castle.

			if (!LGen('JsonMan')->is_key_exist($obj,'def')) return 'Failed.'; // default name.
			if (!LGen('JsonMan')->is_key_exist($obj,'single')) $obj['single'] = false; // want to set for a single gold.
			if (!LGen('JsonMan')->is_key_exist($obj,'total')) $obj['total'] = 0; // just total.
			if (!LGen('JsonMan')->is_key_exist($obj,'name')) $obj['name'] = ''; // gold name.
			if (!LGen('JsonMan')->is_key_exist($obj,'keep_name')) $obj['keep_name'] = false; // gold name.
			if (!LGen('JsonMan')->is_key_exist($obj,'keep_key')) $obj['keep_key'] = false; // gold name.
			if (!LGen('JsonMan')->is_key_exist($obj,'namelist')) $obj['namelist'] = []; // list of gold name.
			if ($obj['branched']) $obj['branch'] = 1000; else $obj['branch'] = '';

			if (!LGen('JsonMan')->is_key_exist($obj,'is_bw')) $obj['is_bw'] = true; // list of gold name.
			return $obj;
		}

		/* fixed */
		public function get_all($obj) {
			$res = $this->req_validator($obj);
			if (gettype($res) === 'string')
				return $res;

			$dir = $this->get_dir($obj);

			$result = [];
			$citizens = getFileNamesInsideDir($dir);
			if ($citizens === LGen('GlobVar')->not_found)
				return $result;

			$bridge = $obj['bridge'];
			foreach ($citizens as $key => $value) {
				$obj['bridge'] = $bridge;
				array_push($obj['bridge'], LGen('StringMan')->to_json('{"id": "'.$value.'", "puzzled":false}'));
				$citizen = $this->read($obj);
				array_push($result, $citizen);
			}
			return $result;
		}

		/* fixed */
		public function insert($obj) {
			$res = $this->req_validator($obj);
			if (gettype($res) === 'string')
				return $res;

			if ($obj['keep_name'] && $obj['name'] === '')
				return 'Failed.';

			$dir = $this->get_dir($obj);

			/* create id */
			if (!$obj['keep_name']) {
				$obj['name'] = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$obj['name'].'"}'));
				if ($obj['name'] === '') {
					$filenames = getFileNamesInsideDir($dir);
					while (LGen('ArrayMan')->is_val_exist($filenames, $obj['name']).'.lgd') {
						$obj['name'] = LGen('F')->gen_id();
					}
				}
			}

			$config_dir = HOME_DIR.'storages/'.$obj['gate'].'/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}'));
			$filenames = getFileNamesInsideDir($config_dir.'/'.$obj['def'].'/');
			if ($filenames === LGen('GlobVar')->not_found)
				return LGen('GlobVar')->not_found;

			$default = [];
			$keys = array_keys($obj['val']);
			foreach ($filenames as $fn_key => $value) {
				if (!LGen('StringMan')->is_val_exist($value, '.lgd'))
					continue;
				$key = str_replace('.lgd', '', $value);
				// return $key;

				if (LGen('JsonMan')->is_key_exist($obj['val'],$key))
					$default[$key] = $obj['val'][$key];
				else
					$default[$key] = $this->get_def($obj, $value);

				// if ($key === 'char_name')
				// 	return $obj;

				if ($key === 'id')
					$default[$key] = $obj['name'];

				if ($key === 'created_date' && $default[$key] === '')
					$default[$key] = gmdate("Y/m/d H:i:s T");

				$_dir = $dir . $obj['name'] . '/';
				if ($obj['keep_key'])
					$_filename = $key;
				else
					$_filename = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$key.'"}'));
				if ($obj['is_bw'])
					$final_data = LGen('Black')->get($default[$key]);
				else
					$final_data = $default[$key];
				LGen('JsonMan')->save($_dir, $_filename.'.lgd', $final_data, $minify=false);
			}

			if ($obj['note'] === 'return full')
				return $default;
			else
				return $obj['name'];
		}

		/* fixed */
		public function get_def_list($obj) {
			$config_dir = HOME_DIR.'storages/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			// $config_dir = HOME_DIR.'storages/'.$obj['gate'].'/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			$defs = getFileNamesInsideDir($config_dir.$obj['def'].'/');
			$defs2 = [];
			foreach ($defs as $key => $value) {
				if (LGen('StringMan')->is_val_exist($value, '.lgd'))
					array_push($defs2, str_replace('.lgd', '', $value));
			}
			return $defs2;
		}

		/* fixed */
		public function get_dir($obj) {
			return HOME_DIR.'storages/'.$obj['gate'].'/'.$this->gen_bridge($obj['bridge']);
		}

		/* fixed */
		public function get_def($obj, $value) {
			$config_dir = HOME_DIR.'storages/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			// $config_dir = HOME_DIR.'storages/'.$obj['gate'].'/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			return LGen('JsonMan')->read($config_dir.$obj['def'].'/'.$value);
		}

		/* fixed */
		public function update($obj) {
			$res = $this->req_validator($obj);
			if (gettype($res) === 'string')
				return $res;

			$dir = $this->get_dir($obj);

			$default = [];
			foreach ($obj['val'] as $key => $value) {
				$_def = $this->get_def($obj, $key.'.lgd');
				if ($value === null)
					continue;
				if ($_def === LGen('GlobVar')->failed)
					continue;

				$default[$key] = $value;
				if ($value === '__def__')
					$default[$key] = $_def;

				if ($obj['keep_key'])
					$filename = $key;
				else
					$filename = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$key.'"}'));
				if ($obj['is_bw'])
					$final_data = LGen('Black')->get($default[$key]);
				else
					$final_data = $default[$key];
				LGen('JsonMan')->save($dir, $filename.'.lgd', $final_data, $minify=false);
			}

			return 1;
		}

		/* fixed */
		public function delete($obj) { return $this->delete_pack($obj); }
		public function delete_pack($obj) {
			$res = $this->req_validator($obj);
			if (gettype($res) === 'string')
				return $res;

			$dir = $this->get_dir($obj);

			$filenames = getFileNamesInsideDir($dir);
			if (LGen('ArrayMan')->is_val_exist($filenames, $obj['name'])) {
				dir_delete($dir.$obj['name']);
				return LGen('GlobVar')->success;
			}
			return LGen('GlobVar')->not_found;
		}

		/* fixed */
		public function read($obj) {
			$res = $this->req_validator($obj);
			if (gettype($res) === 'string')
				return $res;

			$dir = $this->get_dir($obj);

			$filenames = getFileNamesInsideDir($dir);
			if ($filenames === LGen('GlobVar')->not_found)
				$filenames = [];

			$data = [];
			if ($obj['namelist'] === 'all') {
				$config_dir = HOME_DIR.'storages/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
				$_keys = getFileNamesInsideDir($config_dir.$obj['def'].'/');
				$obj['namelist'] = [];
				for ($i=0; $i<sizeof($_keys); $i++) {
					if (LGen('StringMan')->is_val_exist($_keys[$i], '.lgd'))
						array_push($obj['namelist'], str_replace('.lgd', '', $_keys[$i]));
				}
			}

			foreach ($obj['namelist'] as $key => $value) {
				if ($obj['keep_key'])
					$_val = $value.'.lgd';
				else
					$_val = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$value.'"}')).'.lgd';
				if (LGen('ArrayMan')->is_val_exist($filenames, $_val)) {
					$_data = LGen('JsonMan')->read($dir.$_val);
					if (LGen('Black')->check($_data))
						$_data = LGen('White')->get($_data);
					$data[$value] = $_data;
				}
				else {
					$_def = $this->get_def($obj, $value.'.lgd');
					if ($_def === LGen('GlobVar')->failed)
						continue;
					$data[$value] = $_def;
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
	}
?>