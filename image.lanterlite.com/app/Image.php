<?php
	
	$image = new ImageGen();

	class ImageGen {
		public function __construct() {
			set_time_limit ( 0 );
		}

		public function add_image($obj) {
			$gate = $obj['gate'];
			$gate = explode('/', $gate);
			foreach ($gate as $g_key => $g_val) {
				$_name = [];
				$_name['id'] = $g_val;
				$gate[$g_key] = LGen('F')->gen_id($_name);
			}

			$gate = implode('/',$gate);
			$img = $obj['img'];
			$img = LGen('StringMan')->replace($img, ' ', '+');
			if (!LGen('StringMan')->is_val_exist($img, 'base64'))
				return '';
			if (array_key_exists('name', $obj))
				$name = $obj['name'];
			else
				$name = LGen('F')->gen_id();
			error_log($img);
			$img_dir = HOME_DIR.'storages/'.$gate.'/'.$name.'.webp';
			$img_url = 'image.lanterlite.com/storages/'.$gate.'/'.$name.'.webp';
	    // LGen('F')->force_file_put_contents($img_url, file_get_contents($obj['img']));
			$this->base64_to_jpeg($img, $img_dir);
			return $img_url;
		}
		// public function get_store_id($cit_id) {
		// 	$_obj['namelist'] = ['id', 'cit_id'];
		// 	$_obj['def'] = 'stores';
		// 	$_obj['gate'] = 'store';
		// 	$_obj['bridge'] = [];
		// 	array_push($_obj['bridge'], LGen('StringMan')->to_json('{"id":"stores", "puzzled":true}'));
		// 	$stores = LGen('SaviorMan')->get_all($_obj);
		// 	foreach ($stores as $key => $value) {
		// 		if (base64_decode($value['cit_id']) === $cit_id)
		// 			return $value['id'];
		// 	}
		// 	return LGen('GlobVar')->failed;
		// }

		function base64_to_jpeg($base64_string, $output_file) {

	    $data = explode( ',', $base64_string );
	    $bin = base64_decode($data[1]);

			$im = imageCreateFromString($bin);
			if (!$im) {
			  die('Base64 value is not a valid image');
			}

	    try {
        $isInFolder = preg_match("/^(.*)\/([^\/]+)$/", $output_file, $filepathMatches);
        if($isInFolder) {
          $folderName = $filepathMatches[1];
          $fileName = $filepathMatches[2];
          if (!is_dir($folderName)) {
            mkdir($folderName, 0777, true);
          }
        }
				imagewebp($im, $output_file, 100);
	    } catch (Exception $e) {
        echo "ERR: error writing '$message' to '$filepath', ". $e->getMessage();
	    }

	    return $output_file; 
		}
	}