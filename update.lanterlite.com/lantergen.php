<?php 
	/**

generate 4 char key
LGen.access_key
access_key dir
save static ip
get data if static ip match
	 * 
	 */
	// $LGen = new LanterGen();
	define("RES_STAT", "RESPONSE_STATUS");
	define("DATA", "Data");

	include 'assets/gen.php/AccessKey.php';
	include 'assets/gen.php/GlobVar.php';
	include 'assets/gen.php/StringMan.php';
	include 'assets/gen.php/ArrayMan.php';
	include 'assets/gen.php/ArrJsonMan.php';
	include 'assets/gen.php/SaviorMan.php';
	include 'assets/gen.php/F.php';
	include 'assets/gen.php/JsonMan.php';
	include 'assets/gen.php/LogMan.php';
	include 'assets/gen.php/PropKeyMan.php';

	// echo LGen('GlobVar')->success;
	// echo LGen('GlobVar')->failed;
	// echo LGen('GlobVar')->success;
	// echo LGen('GlobVar')->success;

	function LGen($class) {
		// if (!json_key_exist($GLOBALS, $class))
		// if (!property_exists( $GLOBALS, $class ))
		if (!array_key_exists( $class, $GLOBALS ))
			eval('$GLOBALS["'.$class.'"] = new '.$class.'();');
		return $GLOBALS[$class];
	}

	function getFileNamesInsideDir($dir) {
		// $dir    = CUR_DIR . '/' . $dir;
		if(file_exists($dir)) {
			$data = scandir($dir);	
			array_shift($data);
			array_shift($data);
		}
		else {
			$data = LGen('GlobVar')->not_found;
		}
		
		return $data;
	}
	  // ... proceed to declare your function
	function print_puzzle($key) {
		echo $key . ' ' . md5($key) . PHP_EOL;
	}

	function cors() {

	  // Allow from any origin
	  if (isset($_SERVER['HTTP_ORIGIN'])) {
	      // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
	      // you want to allow, and if so:
	      header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	      header('Access-Control-Allow-Credentials: true');
	      header('Access-Control-Max-Age: 86400');    // cache for 1 day
	  }

	  // Access-Control headers are received during OPTIONS requests
	  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

	      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
	          // may also be using PUT, PATCH, HEAD etc
	          header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

	      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
	          header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

	      exit(0);
	  }
	  // echo "You have CORS!";
	}

	function tryCatch() {
		try {
	    $error = 'Always throw this error';
	    throw new Exception($error);

	    // Code following an exception is not executed.
	    echo 'Never executed';

		} catch (Exception $e) {
	    $error = 'Caught exception: ' .  $e->getMessage() . "\n";
			saveErrorLog($error);
		}

		// Continue execution
		echo 'Hello World';	
	}

	function _getallheaders() {
		$headers = []; 
		foreach ($_SERVER as $name => $value) { 
		  if (substr($name, 0, 5) == 'HTTP_') { 
		     $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; 
		  } 
		} 
		return $headers; 
	}


	function file_delete($file_path) { 
		if (file_exists($file_path)) { 
			unlink($file_path) or die("Couldn't delete file");
		} 
	}

	function dir_delete($dirPath) {
    if (! is_dir($dirPath)) {
      throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
      $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
      if (is_dir($file)) {
        dir_delete($file);
      } else {
        unlink($file);
      }
    }
    rmdir($dirPath);
	}
	function console_log( $data ){
		echo '<script type=\'text/javascript\'>';
		echo 'console.log('. json_encode( $data ) .')';
		echo '</script>';
	}

	/*get php file directory */
	// function hash($str) {
	//   $hash1 = md5($str);
	//   $hash2 = md5($str.$hash1);
	//   $hash3 = md5($hash1.$hash2);
	//   return $hash3;
	// }

	/*get php file directory */
	function get_file_dir() {
	    global $argv;
	    $dir = dirname(getcwd() . '/' . $argv[0]);
	    $curDir = getcwd();
	    chdir($dir);
	    $dir = getcwd();
	    chdir($curDir);
	    return $dir;
	}

	/* get terminal directory */
	function get_working_dir(){
	  return getcwd();
	}


	/* RETURN: TRUE or FALSE */

	/* RETURN: TRUE or FALSE */
	function isValidInt($int) { 
		if ($int != NULL && is_int($int)) { 
			return true; 
		} 
		else { 
			return false; 
		} 
	}



	function obj_to_json($obj) {
		return get_object_vars($obj);;
	}

	function sortByScore($data) {
		usort($data, function($a, $b) { //Sort the array using a user defined function
		    return $a->score > $b->score ? -1 : 1; //Compare the scores
		});
		return $data;
	}




	function sortByScore2($data, $index) {

		// printJson($data);
		// printJson($data[0]);
		// echo $data[0]['scores'][0];
		usort($data, function($a, $b) use ($index) { //Sort the array using a user defined function
		    return $a['scores'][$index] > $b['scores'][$index] ? -1 : 1; //Compare the scores
		});
		return $data;
	}

	function mysort($userInput, $list){

		// $userInput = 'Bradd';

		// $list = array('Bob Britney dsa', 'Brad Britney asd', 'Britney poj Brad');

		usort($list, function ($a, $b) use ($userInput) {
		    similar_text($userInput, $a['content'], $percentA);
		    similar_text($userInput, $b['content'], $percentB);

		    return $percentA === $percentB ? 0 : ($percentA > $percentB ? -1 : 1);
		});

		return $list;
	}


	function battleOfSimilarity($userInput, $string) {
		$arr_str = str_to_arr($string, ' ');

		for ($i=0; $i<sizeof($arr_str); $i++) {
		  echo $userInput, ' ', $arr_str[$i];
		  echo '<br>';
		  similar_text($userInput, $arr_str[$i], $percentA);
		  echo "[similar_text] ",$percentA;
		  echo '<br>';
		  $percentA = string_compare($userInput, $arr_str[$i]);
		  echo "[string_compare] ",$percentA;
		  echo '<br>';
		  echo "[levenshtein] ",levenshtein($userInput, $arr_str[$i]);
		  echo '<br>';
		  echo '<br>';
		}	
	}

	function mysort3($userInput){

		$arr_str = json_read(BASE_DIR . 'storages/enlite/words.json')[DATA];

		$arr_inp = str_to_arr(strtolower($userInput), ' ');
		$scores = [];
		$corrected_words = [];

		for ($j=0; $j<sizeof($arr_inp); $j++) {
			array_push($scores, 0);
			array_push($corrected_words, '-');
		}
		for ($i=0; $i<sizeof($arr_str); $i++) {
			for ($j=0; $j<sizeof($arr_inp); $j++) {

			  similar_text($arr_inp[$j], $arr_str[$i], $percentA);
			  if ($percentA > 50 && $percentA > $scores[$j]) {
			  	$scores[$j] = $percentA;
			  	$corrected_words[$j] = $arr_str[$i];						
			  }
			}
		}

		$result['scores'] = $scores;
		$result['words'] = $corrected_words;
		// printJson($result);
		return $result;
	}


	function new_in_array($arr, $val) {
		for ($i=0; $i<sizeof($arr); $i++) {
			if (str_cmp_case_insen($arr[$i], $val, 'part')) {
				return true;
				$i = sizeof($arr);
			}
		}
	}




	function mysort2($userInput, $string) {

		// $total = 0;

		$arr_str = str_to_arr($string, ' ');
		$arr_inp = str_to_arr($userInput, ' ');
		$scores = [];
		$words = [];

		for ($j=0; $j<sizeof($arr_inp); $j++) {
			array_push($scores, 0);
			array_push($words, $arr_inp[$j]);
		}
		// printJson($scores);
		// printJson($words);
		for ($i=0; $i<sizeof($arr_str); $i++) {
			for ($j=0; $j<sizeof($arr_inp); $j++) {

			  similar_text($arr_inp[$j], $arr_str[$i], $percentA);
			  if ($percentA > 50 && $percentA > $scores[$j]) {
			  	$scores[$j] = $percentA;
			  	$words[$j] = $arr_str[$i];
			  }

				// if (str_cmp_case_insen($arr_str[$i], $userInput, 'part'))
				// 	$total++;
			}
		}

		// printJson($scores);
		// printJson($words);

		$result['scores'] = $scores;
		$result['words'] = $words;
		return $result;
	  // similar_text($userInput, $string, $percentA);
		// usort($list, function ($a, $b) use ($userInput) {
		//     similar_text($userInput, $a['content'], $percentA);
		//     similar_text($userInput, $b['content'], $percentB);

		//     return $percentA === $percentB ? 0 : ($percentA > $percentB ? -1 : 1);
		// });

		// return $percentA;
	}

	function word_activate() {
		$this->kata_kerja_dasar = json_read(BASE_DIR . 'storages/enlite/words4.json')[DATA];
		// $this->kata_kerja_dasar = [];
		$this->vokal = ['a', 'i', 'u', 'e', 'o'];
		$this->alfabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
		$this->konsonan = ['b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'];

		// $this->prefiks = ['menge', 'meng', 'meny', 'mem', 'men', 'me', 'ber', 'di', 'ter', 'pen', 'per', 'se', 'ke'];
		$this->prefiks = ['meng', 'meny', 'mem', 'men', 'me', 'ber', 'di', 'ter', 'pen', 'per', 'se', 'ke'];
		$this->infiks = ['el', 'em', 'er', 'e', 'in'];
		$this->sufiks = ['kan', 'an', 'i', 'annya', 'nya', 'lah', 'ku', 'mu'];
	}

	function root_word($str) {
		$str = strtolower($str);
		// $this->kata_kerja_dasar = $this->kata_kerja_dasar;


		// $this->kata_kerja_dasar = ['makan', 'tanding', 'masuk'];

		$result = $str;
		$result2 = '?';
		$used_prefix = '';
		
		// echo substr($str, -3); 
		// echo str_cmp_case_insen(substr($str, -3), 'nya');
		// echo substr($str, 0, strlen($str)-3);
		// if (str_cmp_case_insen(substr($result, -3), 'nya')) {
		// 	$result = substr($result, 0, strlen($result)-3);
		// }

		if (in_array($result, $this->kata_kerja_dasar)) {
			return $result;
		}

		// echo 'atas '. $result . '<br>';
		for ($i=0; $i<sizeof($this->sufiks); $i++) {
			if ($this->sufiks[$i] == substr($result, -strlen($this->sufiks[$i]))) {
				$result = substr($result, 0, -strlen($this->sufiks[$i]));
				$i=sizeof($this->sufiks);
			}
		}
		for ($i=0; $i<sizeof($this->prefiks); $i++) {
			if ($this->prefiks[$i] == substr($result, 0, strlen($this->prefiks[$i]))) {
				$result = substr($result, strlen($this->prefiks[$i]));
				$used_prefix = $this->prefiks[$i];
				$i=sizeof($this->prefiks);
			}
		}

		if ($used_prefix == 'men' && in_array($result[0], $this->vokal)) {
			$result = 't' . $result;
		}
		else if ($used_prefix == 'meny') {
			$result = 's' . $result;		
		}
		else if ($used_prefix == 'meng') {
			$result = 'k' . $result;		
		}
		else if ($used_prefix == 'mem' && in_array($result[0], $this->vokal)) {
			if (in_array('m' . $result, $this->kata_kerja_dasar))
				$result = 'm' . $result;
			else if (in_array('p' . $result, $this->kata_kerja_dasar))
				$result = 'p' . $result;
		}

		// echo $result . ' . ' ;
		if (in_array($result, $this->kata_kerja_dasar)) {
			return $result;
		}

		if (!in_array($result, $this->kata_kerja_dasar)) {
			$result = $str;
		}

		// echo 'bawah '. $result . '<br>';
		return $result;
	}

	function microtime_float() {
	  list($usec, $sec) = explode(" ", microtime());
	  return ((float)$usec + (float)$sec);
	}


	/*-------------------------------------
	###### ###### ##  ## ###### ##  ##
	  ##   ##  ## ## ##  ##     ### ##
	  ##   ##  ## #####  ###### ######
	  ##   ##  ## ## ##  ##     ## ###
	  ##   ###### ##  ## ###### ##  ##
	-------------------------------------*/
	// class Token {

	// 	const TOKEN_DIR = "/storage/tokens/";
	// 	const ACC_TOKEN = "access_token";

	// 	function requestToken($username) {
	// 		$token = self::getToken($username);
	// 		if ($token[RES_STAT] == SUCCESS) {
	// 			$data[DATA] = $token[DATA];
	// 			$data[RES_STAT] = SUCCESS;
	// 		}
	// 		else {
	// 			$new_token = self::generateToken($username);
	// 			self::setToken($new_token, $username);
	// 			$data[DATA] = $new_token;
	// 			$data[RES_STAT] = SUCCESS;
	// 		}
	// 		return $data;
	// 	}

	// 	function getToken($username) {
	// 		$data = json_read(self::TOKEN_DIR . md5($username));
	// 		return $data;
	// 	}

	// 	function setToken($token, $username) {
	// 		$file_path = self::TOKEN_DIR . md5($username);
	// 		$json_obj[self::ACC_TOKEN] = $token;
	// 		$stat = json_save($file_path, $json_obj);

	// 		if ($stat == SUCCESS)
	// 			return SUCCESS;
	// 		else
	// 			return NOT_FOUND;			
	// 	}

	// 	function generateToken($username) {
	// 		if (isValidStr($username)) {
	// 			$date = new DateTime();
	// 			$token_date = $date->getTimestamp();
	// 			$token = md5($username . $token_date);
	// 			$data[DATA] = $token;
	// 			$data[RES_STAT] = SUCCESS;
	// 		}
	// 		else 
	// 			$data[RES_STAT] = FAILED;
	// 		return $data;
	// 	}

	// 	function isValidToken($access_token, $username) {
	// 		$data = json_read(self::TOKEN_DIR . md5($username));
	// 		if ($data[RES_STAT] == SUCCESS && 
	// 			$access_token == $data[DATA][self::ACC_TOKEN]) {
	// 			return true;
	// 		}
	// 		else {
	// 			return false;
	// 		}
	// 	}
	// }



	function html_get($url) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		$content = curl_exec($ch);
		curl_close($ch);
		return html_entity_decode($content);
	}	



	function tototo() {
		echo 'tototoaa';
	}

	function js($func_str) {
		echo '<script type=\'text/javascript\'>' . $func_str . '</script>';
	}





?>