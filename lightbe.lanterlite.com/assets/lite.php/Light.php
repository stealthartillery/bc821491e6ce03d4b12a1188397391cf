<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

$G = new LightGen();

class LightGen {

	public function __construct() {
		if(!class_exists('lanterlite')) { include 'init.php'; }
		$this->L = new Lanterlite();
		set_time_limit ( 0 );
		$this->speed = 0.5;
		$this->left_key = 37;
		$this->top_key = 38;
		$this->right_key = 39;
		$this->bottom_key = 40;
		$this->run_key = 82;

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

			if ($this->is_key_pressed($char_data["map"], $this->top_key))
				$char_data = $this->move_top($char_data);
			else if ($this->is_key_pressed($char_data["map"], $this->bottom_key))
				$char_data = $this->move_bottom($char_data);
			else if ($this->is_key_pressed($char_data["map"], $this->right_key))
				$char_data = $this->move_right($char_data);
			else if ($this->is_key_pressed($char_data["map"], $this->left_key))
				$char_data = $this->move_left($char_data);
			// else if ($this->is_key_pressed(obj.map, bottom_key))
			// 	move_bottom(obj.map, obj.char_id)
			// else if ($this->is_key_pressed(obj.map, right_key))
			// 	move_right(obj.map, obj.char_id)
			// else if ($this->is_key_pressed(obj.map, left_key))
			// 	move_left(obj.map, obj.char_id)

		
		  // if ($this->is_key_pressed(_map, run_key)) {
				// change_animation(players_actions[_char_id], 'run', run_motion_speed)
		  // 	_speed = speed
		  // }
		  // else {
				// change_animation(players_actions[_char_id], 'walk', walk_motion_speed)
		  // 	_speed = speed/2
		  // }


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

	private function move_top($char_data) {
		if ($this->is_key_pressed($char_data["map"], $this->run_key)) {
	  	$_speed = $this->speed;
		}
	  else {
	  	$_speed = $this->speed/2;
	  }

	  if ($this->is_key_pressed($char_data["map"], $this->right_key)) {
      $angle = (45) * (pi()/180); // Convert to radians
      $_speed = sin($angle)*$_speed;
      $char_data['rotation']['y'] = pi() * 3/4;
      $char_data['position']['x'] += $_speed;
      $char_data['position']['z'] -= $_speed;
	  }
	  else if ($this->is_key_pressed($char_data["map"], $this->left_key)) {
      $angle = (45) * (pi()/180); // Convert to radians
      $_speed = sin($angle)*$_speed;
      $char_data['rotation']['y'] = pi() * 5/4;
      $char_data['position']['x'] -= $_speed;
      $char_data['position']['z'] -= $_speed;
	  }
	  else if ($this->is_key_pressed($char_data["map"], $this->bottom_key))  {
      $char_data['rotation']['y'] = pi() * 1;
	  }
	  else {
      $char_data['rotation']['y'] = pi() * 1;
      // $char_data['position']['z'] -= 10;
      $char_data['position']['z'] -= $_speed;
      // echo 'asd';
	  }
	  return $char_data;
	}
	
	private function move_bottom($char_data) {
		if ($this->is_key_pressed($char_data["map"], $this->run_key)) {
	  	$_speed = $this->speed;
		}
	  else {
	  	$_speed = $this->speed/2;
	  }

	  if ($this->is_key_pressed($char_data["map"], $this->right_key)) {
      $angle = (45) * (pi()/180); // Convert to radians
      $_speed = sin($angle)*$_speed;
      $char_data['rotation']['y'] = pi() * 1/4;
      $char_data['position']['x'] += $_speed;
      $char_data['position']['z'] += $_speed;
	  }
	  else if ($this->is_key_pressed($char_data["map"], $this->left_key)) {
      $angle = (45) * (pi()/180); // Convert to radians
      $_speed = sin($angle)*$_speed;
      $char_data['rotation']['y'] = pi() * 7/4;
      $char_data['position']['x'] -= $_speed;
      $char_data['position']['z'] += $_speed;
	  }
	  else if ($this->is_key_pressed($char_data["map"], $this->top_key))  {
      $char_data['rotation']['y'] = pi() * 0;
	  }
	  else {
      $char_data['rotation']['y'] = pi() * 0;
      // $char_data['position']['z'] -= 10;
      $char_data['position']['z'] += $_speed;
      // echo 'asd';
	  }
	  return $char_data;
	}
	
	private function move_right($char_data) {
		if ($this->is_key_pressed($char_data["map"], $this->run_key)) {
	  	$_speed = $this->speed;
		}
	  else {
	  	$_speed = $this->speed/2;
	  }

	  if (!$this->is_key_pressed($char_data["map"], $this->top_key) && !$this->is_key_pressed($char_data["map"], $this->bottom_key) && !$this->is_key_pressed($char_data["map"], $this->left_key)) {
      $char_data['rotation']['y'] = pi() * 1/2;
      $char_data['position']['x'] += $_speed;
	  }
	  return $char_data;
	}
	
	private function move_left($char_data) {
		if ($this->is_key_pressed($char_data["map"], $this->run_key)) {
	  	$_speed = $this->speed;
		}
	  else {
	  	$_speed = $this->speed/2;
	  }

	  if (!$this->is_key_pressed($char_data["map"], $this->top_key) && !$this->is_key_pressed($char_data["map"], $this->bottom_key) && !$this->is_key_pressed($char_data["map"], $this->right_key)) {
      $char_data['rotation']['y'] = pi() * 3/2;
      $char_data['position']['x'] -= $_speed;
	  }
	  return $char_data;
	}
	
	private function is_key_pressed($map, $key) {
		if ($this->L->arr_value_exist($map, $key))
			return true;
		else
			return false;
	}

	public function get_char_data($char_id) {
		$dir = BASE_DIR .'/storages/light/';

		$str = file_get_contents($dir .'players/' . $char_id);
		$json = json_decode($str, true);
		// $this->post_char_data($json);
		$json = json_encode($json);

		return $json;
	}
}

?>