<?php
	class JsonMan {
		function is_key_exist($json, $key) {
			return array_key_exists ($key, $json);
			// return property_exists( $json, $key ); 
		}

		// function print($json) { 
		// 	echo "<pre>" . json_encode($json, JSON_PRETTY_PRINT) . "</pre>"; 
		// }

		function get_keys($json) { 
			return  array_keys($json);
		}

		function rmv_by_key(&$json, $key) {
			unset($json[$key]);
			return $json;
		}

		function is_json($var) {
			if (!is_string($var))
				$var = json_encode($var);
			$var = json_decode($var);
			if (gettype($var) === 'object')
				return true;
			return false;

			// return is_string($var) && is_array(json_decode($var)) ? true : false;
			// return is_string($var) && is_array(json_decode($var, true)) ? true : false;
			// json_decode($var);
			// return (json_last_error() == JSON_ERROR_NONE);
		}
		function to_obj(&$json) {
			return (object)$json;
		}

		function to_str($json) {
			return json_encode($json);
		}

		function save_json_php ($file_path, $data) {
			$cacheFile = $file_path . '.php';
		  file_put_contents($cacheFile, "<?php\n return ".var_export($data, true).";");
		}

		function save($file_dir, $file_name, $json_obj, $minify=false) {
			if ($json_obj === null)
				return 'obj is null.';
			$dir = rtrim($file_dir,'/');
			// echo $dir;
			if (substr($file_dir, -1) == '/') // returns "s" 
				$dir = rtrim($file_dir,'/');
			else
				$dir = $file_dir;
			if (!file_exists($dir))
				mkdir($dir, 0777, true);
			// file_put_contents(CUR_DIR . '/' . $file_dir . $file_name, $json_obj);
			// $i = 0;
			$file = fopen($file_dir . $file_name, 'w');
			if ($minify) {
				$str = json_encode($json_obj);
			}
			else {
				$str = json_encode($json_obj, JSON_PRETTY_PRINT);
				$str = str_replace("    ","  ",$str);
			}
			fwrite($file, $str);
			// foreach ($gemList as $gem)
			// {
			//     fwrite($file, $gem->getAttribute('id') . '\n');
			//     $gemIDs[$i] = $gem->getAttribute('id');
			//     $i++;
			// }
			fclose($file);
		}

		function read($file_path) { 
			if (file_exists($file_path)) { 
				$string = file_get_contents($file_path); 
				return json_decode($string, true); 
			} 
			else
				return LGen('GlobVar')->failed;
		}

		function read_php($file_path) { 
			if (file_exists($file_path)) { 
				return include $file_path; 
			} 
			else
				return LGen('GlobVar')->failed;
		}

		function save_php($file_dir, $file_name, $json_obj) {
			$dir = rtrim($file_dir,'/');
			// echo $dir;
			if (substr($file_dir, -1) == '/') // returns "s" 
				$dir = rtrim($file_dir,'/');
			else
				$dir = $file_dir;
			if (!file_exists($dir))
				mkdir($dir, 0777, true);
			// file_put_contents(CUR_DIR . '/' . $file_dir . $file_name, $json_obj);
			// $i = 0;
			$file = fopen($file_dir . $file_name, 'w');
			$str = "<?php if (!class_exists('Goldenrod')) exit('PHP Warning: failed to open stream: No such file or directory.'); return ".var_export($json_obj, true).";";
			fwrite($file, $str);
			// foreach ($gemList as $gem)
			// {
			//     fwrite($file, $gem->getAttribute('id') . '\n');
			//     $gemIDs[$i] = $gem->getAttribute('id');
			//     $i++;
			// }
			fclose($file);
		}


	}
?>