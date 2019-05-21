<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

$G = new LightGen();

class LightGen {

	public function __construct() {
		if(!class_exists('lanterlite')) { include 'init.php'; }
		$this->L = new Lanterlite();
		set_time_limit ( 0 );
	}
 
	public function index() {
		$data = json_decode(file_get_contents("php://input"), true);
		if (isset($data)) {
			echo eval($data[DATA]);
		}
	}

	public function post_char_data($char_data) {
		// include 'Mutex.class.php';
		$dir = BASE_DIR .'/storages/light/';
		// http://localhost/app/enigma.lanterlite.com/three2/
		// $str = $this->L->json_read($dir.'places/'.$place_id)[DATA];
		// $str = file_get_contents($dir.'places/'.$place_id);
		// $mutex = new Mutex('test');
		// $mutex->lock();
		// $file = fopen($dir .'places/' . 'place_1',"w+");

		// exclusive lock
		// if (flock($file,LOCK_EX))
	 //  {
			// $str = file_get_contents($dir.'places/'.$char_data['place_id']);
			// $json = json_decode($str, true);
			// $json[$char_data["char_id"]] = $char_data;
			// echo json_encode($char_data);
			$this->L->json_save($dir.'places/'.$char_data["place_id"].'/', $char_data["char_id"], $char_data, $minify=false);
			$this->L->json_save($dir.'players/', $char_data["char_id"], $char_data, $minify=false);

			$filenames = $this->L->getFileNamesInsideDir($dir.'places/'.$char_data['place_id'].'/')[DATA];
			// echo $dir.'places/'.$char_data['place_id'].'/'.$char_data['char_id'];
			// $arrjson = [];
			foreach ($filenames as $key => $value) {
				// $json[$value] = $value;
				// $arrjson[$value] = $value;
				// array_push($arrjson, $value);
				// $_json = file_get_contents($dir.'places/'.$char_data['place_id'].'/'.$value);
				$_json = $this->L->json_read($dir.'places/'.$char_data['place_id'].'/'.$value)[DATA];

				// $_json = json_decode($_json, true);
				$json[$value] = $_json;
			}
		  // fwrite($file,"Write something");
		  // release lock
		//   flock($file,LOCK_UN);
	 //  }
		// else
	 //  {
		//   echo "Error locking file!";
	 //  }

		// fclose($file);
		// 	$str = file_get_contents($dir .'places/' . 'place_1');
		// 	// // echo $dir.'places/'.$place_id;
		// 	$json = json_decode($str, true);
		// 	$json[$char_data["char_id"]] = $char_data;
		// 	$this->L->json_save($dir.'places/', $place_id, $json, $minify=false);
		// 	$this->L->json_save($dir.'players/', $char_data["char_id"], $char_data, $minify=false);
		// $mutex->unlock();

		$json = json_encode($json);
		return $json;
	}

	public function get_char_data($char_id) {
		$dir = BASE_DIR .'/storages/light/';

		$str = file_get_contents($dir .'players/' . $char_id);
		$json = json_decode($str, true);
		$json = json_encode($json);
		return $json;
	}
}

?>