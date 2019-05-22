<?php 
define("RES_STAT", "RESPONSE_STATUS");
define("LSSK", "ioHybJBEFOSmNFFEPAMVA8979218uHH6dw6766868GGguwydgw");

define("DATA", "Data");
define("FUNC_NAME", "Functionname");
define("FILE_DIR", "Filedir");
define("FILE_NAME", "Filename");
define("FILE_PATH", "Filepath");

define("SUCCESS", "A1");
define("FAILED", "E1");
define("NOT_FOUND", "E2");
define('NOT_EXIST', 'E3');
define('PASS_INCORRECT', 'E4');
define('USERNAME_EXIST', 'C1');
define('EMAIL_EXIST', 'C2');

$L = new Lanterlite();
// $L->word_activate();

$headers = $L->_getallheaders();
$data = json_decode(file_get_contents("php://input"), true);
if (isset($data)) {
	if (isset($headers[FUNC_NAME])) {
		if ($headers[FUNC_NAME] == 'json_save') {
			header('Content-Type: application/json');
			echo json_encode($L->json_save($headers[FILE_DIR], $headers[FILE_NAME], $data[DATA]));
		}
		else if ($headers[FUNC_NAME] == 'json_to_php') {
			header('Content-Type: application/json');
			echo json_encode($L->json_to_php($headers[FILE_DIR], $data[DATA]));
		}
		else if ($headers[FUNC_NAME] == 'root_word') {
			// echo $data[DATA];
			header('Content-Type: application/json');
			echo $L->root_word($data[DATA]);
		}		else if ($headers[FUNC_NAME] == 'saveFileText') {
			header('Content-Type: application/json');
			echo json_encode($L->saveFileText($data[DATA], $headers[FILE_PATH]));
		}
	}
}
else if (isset($headers[FUNC_NAME])) {
	if ($headers[FUNC_NAME] == 'json_read') {
		header('Content-Type: application/json');
		echo json_encode($L->json_read($headers[FILE_DIR] . $headers[FILE_NAME]));
	}
	else if ($headers[FUNC_NAME] == 'getFileNamesInsideDir') {
		header('Content-Type: application/json');
		echo json_encode($L->getFileNamesInsideDir($headers[FILE_DIR]));
	}	else if ($headers[FUNC_NAME] == 'readFileText') {
		header('Content-Type: application/json');
		echo json_encode($L->readFileText($headers[FILE_PATH]));
	}
}


class Lanterlite {

	function test() {
		echo 'Lanterlite Work Perfectly!';
	}

	function getFileNamesInsideDir($dir) {
		// $dir    = CUR_DIR . '/' . $dir;
		if(file_exists($dir)) {
			$data[DATA] = scandir($dir);	
			array_shift($data[DATA]);
			array_shift($data[DATA]);
			$data[RES_STAT] = SUCCESS;		
		}
		else {
			$data[RES_STAT] = NOT_FOUND;
		}
		
		return $data;
	}
	  // ... proceed to declare your function

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


	/* RETURN: RES_STAT->SUCCESS */
	function json_save($file_dir, $file_name, $json_obj, $minify=false) {
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
		return SUCCESS;
	}

	/* RETURN: RES_STAT->SUCCESS + DATA or RES_STAT->NOT_FOUND */
	function json_read($file_path) { 
		if (file_exists($file_path)) { 
			$string = file_get_contents($file_path); 
			$data[DATA] = json_decode($string, true); 
			$data[RES_STAT] = SUCCESS; 
		} 
		else { 
			$data[RES_STAT] = NOT_FOUND; 
		} 
		return $data; 
	}

	function get_arr_index($arr, $val) {
		return array_search($val, $arr);
	}

	/* RETURN: NONE */
	function setErrorLog($file_path) { ini_set("log_errors", 1); ini_set("error_log", $file_path);}
	/* RETURN: NONE */
	function saveErrorLog($error_msg) { error_log($error_msg); }

	function console_log( $data ){
		echo '<script type=\'text/javascript\'>';
		echo 'console.log('. json_encode( $data ) .')';
		echo '</script>';
	}

	/* RETURN: NONE */
	function printJson($json) { 
		echo "<pre>" . json_encode($json, JSON_PRETTY_PRINT) . "</pre>"; 
	}
	/* RETURN: NONE */
	function printArray($array) { echo "</br>"; for ($i=0; $i<count($array); $i++) echo "[" . $i . "] => " . $array[$i] . "</br>"; }

	/* RETURN: TRUE or FALSE */
	function isValidStr($string) { if ($string != NULL && is_string($string)) { return true; } else { return false; } }

	/* RETURN: TRUE or FALSE */
	function isValidInt($int) { if ($int != NULL && is_int($int)) { return true; } else { return false; } }

	function is_exist_json_key($json, $key) {
		return array_key_exists ($key, $json);
	}

	function arr_index_exist($arr, $index) {
		return isset($arr[$index]);
	}

	function arr_value_exist($arr, $value) {
		return in_array($value, $arr);
	}

	function obj_to_json($obj) {
		return get_object_vars($obj);;
	}

	function json_to_php ($file_path, $data) {
		$cacheFile = $file_path . '.php';
    file_put_contents($cacheFile, "<?php\n return ".var_export($data, true).";");
		return $data[RES_STAT] = SUCCESS;
	}

	function sortByScore($data) {
		usort($data, function($a, $b) { //Sort the array using a user defined function
		    return $a->score > $b->score ? -1 : 1; //Compare the scores
		});
		return $data;
	}

	function readFileText($file_path) {
		if(file_exists($file_path)) {
			$myfile = fopen($file_path, "r") or die("Unable to open file!");
			$data[DATA] = fread($myfile,filesize($file_path));
			fclose($myfile);
			// $data[DATA] = readfile($file_path);
			$data[RES_STAT] = SUCCESS;
		}
		else {
			$data[RES_STAT] = NOT_FOUND;				
		}
		return $data;
	}

	function saveFileText($txt, $file_path) {
		$myfile = fopen($file_path, "w") or die("Unable to open file!");
		fwrite($myfile, $txt);
		fclose($myfile);
		$data[RES_STAT] = SUCCESS;
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

	function str_cmp_case_insen($str1, $str2, $type='part') {
		$str1 = strtolower($str1);
		$str2 = strtolower($str2);

		if ($type == 'full') {
			return ($str1 == $str2);
		}
		else if ($type == 'part') {
			return (preg_match('/'.$str2.'/',$str1));
			// return (strpos(strtolower($str1), strtolower($str2)) !== false);
		}
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

	function string_compare($str_a, $str_b) {
	  $length = strlen($str_a);
	  $length_b = strlen($str_b);

	  $i = 0;
	  $segmentcount = 0;
	  $segmentsinfo = array();
	  $segment = '';
	  while ($i < $length) 
	  {
	      $char = substr($str_a, $i, 1);
	      if (strpos($str_b, $char) !== FALSE) 
	      {               
	          $segment = $segment.$char;
	          if (strpos($str_b, $segment) !== FALSE) 
	          {
	              $segmentpos_a = $i - strlen($segment) + 1;
	              $segmentpos_b = strpos($str_b, $segment);
	              $positiondiff = abs($segmentpos_a - $segmentpos_b);
	              $posfactor = ($length - $positiondiff) / $length_b; // <-- ?
	              $lengthfactor = strlen($segment)/$length;
	              $segmentsinfo[$segmentcount] = array( 'segment' => $segment, 'score' => ($posfactor * $lengthfactor));
	          } 
	          else 
	          {
	              $segment = '';
	              $i--;
	              $segmentcount++;
	          } 
	      } 
	      else 
	      {
	          $segment = '';
	          $segmentcount++;
	      }
	      $i++;
	  }   

	  // PHP 5.3 lambda in array_map      
	  $totalscore = array_sum(array_map(function($v) { return $v['score'];  }, $segmentsinfo));
	  return $totalscore;     
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

		$arr_str = self::json_read(BASE_DIR . 'storages/enlite/words.json')[DATA];

		$arr_inp = self::str_to_arr(strtolower($userInput), ' ');
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
		// self::printJson($result);
		return $result;
	}

	function clean_string($string) { 
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	  $str = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	  return preg_replace('/-/', ' ', $str); // Removes special chars.

		// $search = [];
		// $replace = [];
		// array_push($search, '<br>'); array_push($replace, "");
		// array_push($search, '</br>'); array_push($replace, "");
		// array_push($search, '<i>'); array_push($replace, "");
		// array_push($search, '</i>'); array_push($replace, "");
		// array_push($search, '.'); array_push($replace, "");
		// array_push($search, ','); array_push($replace, "");
		// array_push($search, ':'); array_push($replace, "");
		// array_push($search, ';'); array_push($replace, "");
		// array_push($search, ']'); array_push($replace, "");
		// array_push($search, '['); array_push($replace, "");
		// array_push($search, '}'); array_push($replace, "");
		// array_push($search, '{'); array_push($replace, "");
		// array_push($search, ''); array_push($replace, "");
		// array_push($search, ''); array_push($replace, "");
		// array_push($search, ''); array_push($replace, "");
		// $search = array('<br>', '</br>', '<i>', '</i>', ',', '.', '(', ')', '"', '\'');
		// $replace = array('', '', '', '', '', '', '', '', '', '');
		// return str_replace($search, $replace, $string);
		// return preg_replace('/<br>+/', '', $string); 
	}

	function is_key_exist($json, $string) { 
		return property_exists( $json, $string ); 
	}
	
	function str_to_arr($string, $parser) {
		return explode($parser,$string);
	}
	
	function arr_to_str($arr) {
		return implode(" ",$arr);
	}

	function popFirstIndex($arr) {
		array_shift($arr);
		return $arr;
	}

	function new_in_array($arr, $val) {
		for ($i=0; $i<sizeof($arr); $i++) {
			if (self::str_cmp_case_insen($arr[$i], $val, 'part')) {
				return true;
				$i = sizeof($arr);
			}
		}
	}

	function get_string($str, $val) {
		$pos = strpos(strtolower($str), strtolower($val));
		if ($pos === false)
			return null;
		$i = $pos;
		$first_pos = null;
		while ($i >= 0 and $str[$i] != ' ') {
			$first_pos = $i;
	    $i--;
		}

		$i = $pos;
		$last_pos = null;
		while ($i < strlen($str) and $str[$i] != ' ') {
			$last_pos = $i;
	    $i++;
		}

		$result['string'] = substr($str, $first_pos, $last_pos-$first_pos+1);
		$result['pos'] = $pos;
		return $result;

		// $result['string'] = null;
		// $result['pos'] = null;
		// $arr = explode(" ", $str);
		// for ($i=0; $i<sizeof($arr); $i++) {
		// 	if (self::str_cmp_case_insen(self::root_word($arr[$i]), $val, 'full')) {
		// 		$result['string'] = $arr[$i];
		// 		$result['pos'] = $i;
		// 		return $result;
		// 	}
		// }
		// return $result;
	}

	function str_cmp($str1, $str2) {
		$str2_root = self::root_word($str2); // menunai to tunai
		$changed_prefix = 0;

		$luruh = ['t', 'p', 'k', 's'];
		if (in_array($str2_root[0], $luruh)) {
			$first_char = substr($str2_root, 0, 1);
			$str2_root = substr($str2_root, 1); // tunai to unai
			$changed_prefix = 1;
		}
		
		$result = self::get_string($str1, $str2_root); // to get menunai by unai
		$result['string'] =	self::clean_string($result['string']);
		$str = $result['string'];
		$_str2 = $str2_root;
		if ($str != null) {
			$str1_root = self::root_word($str);
			if ($changed_prefix) {
				$str2_root = $first_char . $str2_root;
			}

			if (self::str_cmp_case_insen($str1_root, $str2_root, 'full')) {
				$result['is_same'] = true;
				return $result;
			}
		}
		$result['is_same'] = false;
		return $result;
	}

	function str_cmp2($str1, $str2) {
		$str2_root = self::root_word($str2); // menunai to tunai
		$changed_prefix = 0;

		$luruh = ['t', 'p', 'k', 's'];
		if (in_array($str2_root[0], $luruh)) {
			$first_char = substr($str2_root, 0, 1);
			$str2_root = substr($str2_root, 1); // tunai to unai
			$changed_prefix = 1;
		}
		
		$result = self::get_string($str1, $str2_root); // to get menunai by unai
		$result['string'] =	self::clean_string($result['string']);
		$str = $result['string'];
		$_str2 = $str2_root;
		if ($str != null) {
			$str1_root = self::root_word($str);
			if ($changed_prefix) {
				$str2_root = $first_char . $str2_root;
			}

			if (self::str_cmp_case_insen($str1_root, $str2_root, 'full')) {
				$result['is_same'] = true;
				return $result;
			}
		}
		$result['is_same'] = false;
		return $result;
	}


	function mysort2($userInput, $string) {

		// $total = 0;

		$arr_str = self::str_to_arr($string, ' ');
		$arr_inp = self::str_to_arr($userInput, ' ');
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
		$this->kata_kerja_dasar = self::json_read(BASE_DIR . 'storages/enlite/words4.json')[DATA];
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
		// echo self::str_cmp_case_insen(substr($str, -3), 'nya');
		// echo substr($str, 0, strlen($str)-3);
		// if (self::str_cmp_case_insen(substr($result, -3), 'nya')) {
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

	function sort_json_arr ($arr, $sort_by) {
		usort($arr, function($item1, $item2) use ($sort_by) {
	    return $item1[$sort_by] > $item2[$sort_by] ? -1 : 1;;
		});
		return $arr;
	}

	function arr_json_update_one($array, $json, $unique_prop, $unique_prop_value) {
		foreach($array as $a){
	    if($a[$unique_prop] == $unique_prop_value){
        $a = $json;
        break;
	    }
		}
		return $array;
	}
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



function js($func_str) {
	echo '<script type=\'text/javascript\'>' . $func_str . '</script>';
}


function text_read($file_path) {
	$myfile = fopen($file_path, "r") or die("Unable to open file!");
	$txt = fread($myfile,filesize($file_path));
	fclose($myfile);
	return $txt;
}

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

?>