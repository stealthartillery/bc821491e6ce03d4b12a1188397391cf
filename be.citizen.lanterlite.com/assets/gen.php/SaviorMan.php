<?php

	// ini_set("log_errors", 1);
	// ini_set("error_log", HOME_DIR.'storages/'. 'savior.log');

	class SaviorMan {
		public function __construct() {
			set_time_limit ( 0 );
		}

		public function req_validator(&$obj) {
			// error_log(json_encode($obj['val']));
			$obj['gate'] = ''; // app name.
			// if (!LGen('JsonMan')->is_key_exist($obj,'gate')) $obj['gate'] = ''; // app name.
			// if (!LGen('JsonMan')->is_key_exist($obj,'gate')) return 'You lost the Gate.'; // app name.
			if (!LGen('JsonMan')->is_key_exist($obj,'limited')) $obj['limited'] = false;  // limit total golds for a chamber.
			// error_log(json_encode($obj['val']));
			if (!LGen('JsonMan')->is_key_exist($obj,'val')) $obj['val'] = LGen('StringMan')->to_json('{}');// the gold.
			// if (!LGen('JsonMan')->is_key_exist($obj,'val')) $obj['val'] = ""; else $obj['val'] = LGen('StringMan')->to_json(base64_decode($obj['val']));// the gold.
			if (!LGen('JsonMan')->is_key_exist($obj,'bridge')) $obj['bridge'] = []; // way to the castle.
			if (!LGen('JsonMan')->is_key_exist($obj,'def')) $obj['def'] = ''; // default name.
			if (!LGen('JsonMan')->is_key_exist($obj,'single')) $obj['single'] = false; // want to set for a single gold.
			if (!LGen('JsonMan')->is_key_exist($obj,'total')) $obj['total'] = 0; // just total.
			if (!LGen('JsonMan')->is_key_exist($obj,'name')) $obj['name'] = ''; // gold name.
			if (!LGen('JsonMan')->is_key_exist($obj,'keep_name')) $obj['keep_name'] = false; // gold name.
			if (!LGen('JsonMan')->is_key_exist($obj,'namelist')) $obj['namelist'] = []; // list of gold name.
			if ($obj['limited']) $obj['limit'] = 1000; else $obj['limit'] = '';

			return $obj;
		}

		public function get_all($obj) {
			$res = $this->req_validator($obj);
			if (gettype($res) === 'string')
				return $res;
			$_bridge = $this->gen_bridge($obj['bridge']);
			$dir = HOME_DIR.'storages/'.$obj['gate'].'/'.$_bridge;

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
			$res = $this->req_validator($obj);
			if (gettype($res) === 'string')
				return $res;

			$_bridge = $this->gen_bridge($obj['bridge']);
			$dir = HOME_DIR.'storages/'.$obj['gate'].'/'.$_bridge;

			if (!$obj['keep_name']) {
				$obj['name'] = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$obj['name'].'"}'));
				if ($obj['name'] === '') {
					$filenames = getFileNamesInsideDir($dir);
					while (LGen('ArrayMan')->is_val_exist($filenames, $obj['name']).'.lgd') {
						$obj['name'] = LGen('F')->gen_id();
					}
				}
			}			
			// if ($obj['limit'] !== '') {
			// 	$this->update_dir_by_limit($dir, $obj['limit']);
			// }

			// return json_encode($obj['bridge']);
			if ($obj['def'] !== '') {
				$config_dir = HOME_DIR.'storages/'.$obj['gate'].'/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
				$default = LGen('JsonMan')->read($config_dir.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"default"}')));
				$default = $default[$obj['def']];

				if ($obj['single']) {
					foreach ($default as $key => $value) {
						if (LGen('JsonMan')->is_key_exist($obj['val'],$key))
							$default[$key] = $obj['val'][$key];
					}
					$obj['val'] = $default;
					LGen('JsonMan')->save($dir, $obj['name'].'.lgd', LGen('Black')->get($obj['val']), $minify=false);
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
							LGen('JsonMan')->save($_dir, $_filename.'.lgd', LGen('Black')->get($default[$key]), $minify=false);
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
					LGen('JsonMan')->save($dir, $obj['name'].'.lgd', LGen('Black')->get($obj['val']), $minify=false);
				}
			}

			return $obj['name'];
		}

		public function update($obj) {
			$res = $this->req_validator($obj);
			if (gettype($res) === 'string')
				return $res;

			$_bridge = $this->gen_bridge($obj['bridge']);
			$dir = HOME_DIR.'storages/'.$obj['gate'].'/'.$_bridge;

			// $obj['name'] = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$obj['val'].'"}'));

			// // key to encrypted 
			// foreach ($obj['val'] as $key => $value) {
			// 	$encripted_name = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$key.'"}'));
			// 	$obj['val'][$encripted_name] = $obj['val'][$key];
			// 	unset($obj['val'][$key]);
			// }

			$config_dir = HOME_DIR.'storages/'.$obj['gate'].'/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			error_log('$config_dir -> '.$config_dir);
			$default = LGen('JsonMan')->read($config_dir.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"default"}')));
			$default = $default[$obj['def']];

			// $filenames = getFileNamesInsideDir($dir);

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
				LGen('JsonMan')->save($dir, $filename.'.lgd', LGen('Black')->get($obj['val'][$key]), $minify=false);
			}

			// if (LGen('ArrayMan')->is_val_exist($filenames, $obj['name'].'.lgd')) {
			// 	if ($obj['def'] !== '') {
			// 		$config_dir = HOME_DIR.'storages/'.$obj['gate'].'/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			// 		$default = LGen('JsonMan')->read($config_dir.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"default"}')));
			// 		$default = $default[$obj['def']];
			// 		foreach ($default as $key => $value) {
			// 			if (LGen('JsonMan')->is_key_exist($obj['val'],$key))
			// 				$default[$key] = $obj['val'][$key];
			// 		}
			// 		$obj['val'] = $default;
			// 	}
			// 	LGen('JsonMan')->save($dir, $obj['name'].'.lgd', LGen('Black')->get($obj['val']), $minify=false);
			// 	return LGen('GlobVar')->success;
			// }
			// return LGen('GlobVar')->not_found;
		}

		public function delete_pack($obj) {
			$res = $this->req_validator($obj);
			if (gettype($res) === 'string')
				return $res;

			$_bridge = $this->gen_bridge($obj['bridge']);
			$dir = HOME_DIR.'storages/'.$obj['gate'].'/'.$_bridge;

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
			$res = $this->req_validator($obj);
			if (gettype($res) === 'string')
				return $res;

			$_bridge = $this->gen_bridge($obj['bridge']);
			$dir = HOME_DIR.'storages/'.$obj['gate'].'/'.$_bridge;
			$filenames = getFileNamesInsideDir($dir);
			// error_log(json_encode($filenames));
			if ($filenames === LGen('GlobVar')->not_found)
				return [];

			$config_dir = HOME_DIR.'storages/'.$obj['gate'].'/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			$default = LGen('JsonMan')->read($config_dir.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"default"}')));
			if (app_status === 'dep')
				$default = LGen('White')->get($default);
			$default = $default[$obj['def']];

			$data = LGen('StringMan')->to_json('{}');
			foreach ($obj['namelist'] as $key => $value) {
				$_val = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$value.'"}')).'.lgd';
				if (LGen('ArrayMan')->is_val_exist($filenames, $_val)) {
					$data[$value] = LGen('JsonMan')->read($dir.$_val);
					$data[$value] = LGen('White')->get($data[$value]);
				}
				else if (LGen('JsonMan')->is_key_exist($default, $value)) {
					// $_val = LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"'.$value.'"}'));
					// if (file_exists($dir.$_val)) {

					// }
					// else
					$data[$value] = $default[$value];
					// $data[$value] = base64_encode($default[$value]);
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

			// $text = 'This is the text to encrypt';

			// echo "This is the original text: $text\n\n";


			$str = base64_encode($val);
			$str = LGen('StringMan')->gen_rand(5).$str;

			// Encrypt using the public key
			// openssl_public_encrypt($str, $encrypted, $public_key);

			// $encrypted_hex = bin2hex($encrypted);

			return $str;
		}

		public function when_read_decrypt($val) {
			// $encrypted = hex2bin($val);
			// // Decrypt the data using the private key
			// openssl_private_decrypt($encrypted, $decrypted, $private_key);

			$str = substr($val, 5);
			return $str;
		}

		public function set_rand_config($obj) {
			$res = $this->req_validator($obj);
			if (gettype($res) === 'string')
				return $res;

			$config_dir = HOME_DIR.'storages/'.$obj['gate'].'/'.LGen('F')->gen_id(LGen('StringMan')->to_json('{"id":"config"}')).'/';
			for ($i=0; $i<$total; $i++) {
				for ($j=0; $j<rand(10,20); $j++) {
					$obj['val'][LGen('F')->gen_id()] = LGen('F')->gen_id();
				}
				LGen('JsonMan')->save($config_dir, LGen('F')->gen_id().'.lgd', $obj['val'], $minify=false);
			}
			return LGen('GlobVar')->success;
		}
	}

	$public_key = "-----BEGIN PUBLIC KEY-----
	MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEA0C8/7np8QCN3Tj6Y/Ftl
	TsU+gzlBbvID0YGPKnJ6XcQPNnd/aa5zwVAdsoTB5esDgWNCBHp3n2DMQSj/Ag47
	7u50bMsgWWsssEtwd4A+mTAc3OeFsxwWgppugDt/cooJXZdw5Oxndp1VU9zm7Dyz
	LGulXcgemU1G+no6BQAupCue17UfcIWhE6lociNP/ULIk7IcJzkNFcR4BKCxuOXb
	VtDCCSbEExJSm+pcyJmFB4kcMzJSQK6I3XwZwlimy7VUOywWeyDLlAM7r0oJ+LPv
	W57YLAUo4/kDBSxdWni7ZGxHNZZk7KqYGCtMQl0bFKkaBceEaN1/6/DpHtiSKwmL
	4dGqs9On5KFpIdHzN5KRLQPujGWS/TiDzF4kOeJnl98Ahc9EfzDNG+EQX0w8MMm4
	41RUhdr/RLfaHZx4W4Jw/6Di0d6z8B9YaaDy4XOqwNiA6kpNV+zjo4TKukFZc9lm
	wDgpuailnrv/XHgkrvAKo1XCXO4M5p5E2VJ6Uqe+1L2EA5Z8iNAzDKcqv+zbN41I
	+H1xUVanQ/lke7fwmsqZ5qMm7imoMlLZ8q6w1IMWgRHp8SvPDssWzIrAbZffjQB2
	ZUN+hEklvtOresRc5xS/FxQixZc/ORNQAIExUv1/H6ssCVYh4uafOnElEatViAcx
	FfZha+jxj1Oh1+2G9qOPG2UCAwEAAQ==
	-----END PUBLIC KEY-----";

	$private_key = "-----BEGIN PRIVATE KEY-----
	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
	doB6qhVry2J84xeixT1a/onofTimKg==
	-----END PRIVATE KEY-----";

?>