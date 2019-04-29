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
	function json_save($file_dir, $file_name, $json_obj) {
		if (!file_exists($file_dir))
			mkdir($file_dir, 0777, true); 		
		// file_put_contents(CUR_DIR . '/' . $file_dir . $file_name, $json_obj);
		// $i = 0;
		$file = fopen($file_dir . $file_name, 'w');
		fwrite($file, json_encode($json_obj, JSON_PRETTY_PRINT));
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

	function string_compare($str_a, $str_b) 
	{
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
		$this->kata_kerja_dasar = self::json_read(BASE_DIR . 'storages/enlite/words3.json')[DATA];
		$this->vokal = ['a', 'i', 'u', 'e', 'o'];
		$this->alfabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
		$this->konsonan = ['b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'];

		// $this->prefiks = ['menge', 'meng', 'meny', 'mem', 'men', 'me', 'ber', 'di', 'ter', 'pen', 'per', 'se', 'ke'];
		$this->prefiks = ['meng', 'meny', 'mem', 'men', 'me', 'ber', 'di', 'ter', 'pen', 'per', 'se', 'ke'];
		$this->infiks = ['el', 'em', 'er', 'e', 'in'];
		$this->sufiks = ['kan', 'an', 'i', 'annya', 'nya', 'lah'];
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
}

// class EnliteGen {
  
//   function __construct() {
// 		$this->L = new Lanterlite();
//   }

// 	function content($content_id) {
// 		$id = $this->L->str_to_arr($content_id, ".");
// 		$dir = BASE_DIR . 'storages/enlite/';

// 		if ($id[0] == 'AQ') {
// 			$str = file_get_contents($dir .'/fix_alquran_v1.json');
// 			$json = json_decode($str, true);

// 			$asd_tot = [];
// 			foreach($json as $item) {
// 				$tot_match = 0;
// 				if($item['id'] == $content_id) {
// 					$asd['title'] = $item['surah'] . ' ('. $item['surah_no'] . ':' . $item['ayat_no'] . ')';
// 					$asd['subtitle_1'] = $item['source'];
// 					$asd['subtitle_2'] = $item['surah_no'] . ':' . $item['ayat_no'];
// 					$asd['content'] = $item['content'];
// 					$asd['arabic_content'] = $item['ar_content'];
// 					$asd['postcontent_1'] = $item['type'];
// 					array_push($asd_tot, $asd);
// 			  }
// 			}	
// 		}
// 		else {
// 			// $str = include $dir .'/newbm.json.php';
// 			$str = file_get_contents($dir .'/newbm.json');
// 			$json = json_decode($str, true);

// 			$asd_tot = [];
// 			foreach($json as $item) {
// 				$tot_match = 0;
// 				if($item['id'] == $content_id) {
// 			// foreach($json as $item => $value) {
// 					// $keys = array_keys($json[0]);
// 					// foreach ($keys as $key) {
// 					// 	$asd[$key] = $item[$key];
// 					// }
// 					// array_push($asd_tot, $asd);
// 					$asd['title'] = $item['chapter'];
// 					$asd['subtitle_1'] = $item['source'];
// 					$asd['subtitle_2'] = $item['hadith_no'];
// 					// $asd['precontent'] = $item['narrator'];
// 					$asd['content'] = $item['content'];
// 					$asd['arabic_content'] = $item['arabic'];
// 					// $asd['postcontent_1'] = $item['collector'];
// 					// $asd['postcontent_2'] = $item['degree'];
// 					// $asd['addition'] = $item['comment'];
// 					array_push($asd_tot, $asd);
// 			  }
// 			}	
// 		}

// 		if (!isset($asd)) {
// 			// $keys = array_keys($json);
// 			// foreach ($keys as $key) {
// 			// 	$asd[$key] = $item[$key];
// 			// }
// 			$asd['title'] = 'Content Not Found';
// 			$asd['subtitle'] = '';	
// 			$asd['desc'] = '';	
// 			array_push($asd_tot, $asd);
// 		}

// 		$result['data'] = $asd_tot;
// 		// array_push($result, $asd_tot);
// 		// echo $json;
// 		$result = json_encode($result, true);
// 		echo $result;	
// 	}

// 	function getBookName($id) {
// 		if ($id == 'AQ')
// 			return "Al-Qur'an";
// 		else if ($id == 'BM')
// 			return "Bulughul Maram";
// 		else if ($id == 'SA')
// 			return "Syarah Arba'in An-Nawawi";
// 		else 
// 			return "undefined";
// 	}

// 	function correcting() {
// 		$user_keyword = $this->user_keyword;
// 		$user_keyword = $this->L->clean_string($user_keyword);
// 		$result_2 = $this->L->mysort3($user_keyword);

// 		$is_mistake = false;
// 		$correction = '';

// 		for ($i=0;$i<sizeof($result_2['words']); $i++) {
// 			array_push($this->arr_user_keywords, $result_2['words'][$i]);
// 			if ($result_2['scores'][$i] != 100) {
// 				$is_mistake = true;
// 				if ($i == sizeof($result_2['words'])-1)
// 					$correction = $correction . '<b><i>' . $result_2['words'][$i] . '</i></b>';
// 				else
// 					$correction = $correction . '<b><i>' . $result_2['words'][$i] . '</i></b>' . ' ';
// 			}
// 			else {
// 				if ($i == sizeof($result_2['words'])-1)
// 					$correction = $correction . $result_2['words'][$i];
// 				else
// 					$correction = $correction . $result_2['words'][$i] . ' ';			
// 			}

// 			if ($result_2['words'][$i] == '-') {
// 				$this->arr_user_keywords = null;
// 				$i = sizeof($result_2['words']);
// 			}
// 		}

// 		if ($this->arr_user_keywords != null) {
// 			$this->is_mistake = $is_mistake;
// 			$this->correction = $correction;						
// 		}
// 	}

// 	function priority_get($arr) {
// 		sort($arr);
// 		$score = 0;
// 		// $this->L->printJson($arr);
// 		for ($i=0; $i<sizeof($arr)-1; $i++) {
// 			$score = $score + ($arr[$i+1] - $arr[$i]);
// 		}
// 		if ($score != 0) {
// 			$score = 100/$score;
// 		}
// 		return $score;
// 	}

// 	function strpos_all($haystack, $needle) {
// 	    $offset = 0;
// 	    $allpos = array();
// 	    while (($pos = strpos($haystack, $needle, $offset)) !== FALSE) {
// 	        $offset   = $pos + 1;
// 	        $allpos[] = $pos;
// 	    }
// 	    return $allpos;
// 	}
// 	// print_r(strpos_all("aaa bbb aaa bbb aaa bbb", "aa"));
// 	// Output:
// 	// Array
// 	// (
// 	//     [0] => 0
// 	//     [1] => 1
// 	//     [2] => 8
// 	//     [3] => 9
// 	//     [4] => 16
// 	//     [5] => 17
// 	// )
// 	function search_from($db_file) {

// 		$data_tot = [];
// 		if ($this->arr_user_keywords != null) {

// 			// $json = include $db_file;
// 			// $json = $json[DATA];
// 			// $this->L->printJson($json);
// 			$json = $this->L->json_read($db_file)[DATA];
// 			$arr = $this->arr_user_keywords;
// 			$index = 0;
// 			foreach($json as $item) {
// 				$tot_match = 0;
// 				$pos = [];
// 				for ($i=0; $i<sizeof($arr); $i++) {
// 					$word = $arr[$i];
// 					$result = $this->L->str_cmp($item['content'], $word);
// 				  // $this->L->printJson($result);
// 				  if($result['is_same']) {
// 					  // $this->L->printJson($result);
// 					  // echo $item['body'] . ' ' . '<br>';
// 				  	$tot_match++;
// 					  // echo $tot_match;
// 				  	array_push($pos, $result['pos']);
// 				  }
// 				  if($tot_match == sizeof($arr)) {
// 						// $this->L->printJson($tot_match);
// 					  // $this->L->printJson($arr);
// 					  // echo $item['content'] . '<br>';
// 				  	$score = $this->priority_get($pos);
// 				  	$item2        = $this->title_content_make($item['content'], $arr);
// 						$data['id']    = $item['id'];
// 						$data['type']  = $this->type_make($item);
// 						$data['title'] = $item2['title'];
// 						$data['desc']  = $item2['content'];
// 						$data['priority']  = 10 + $score;
// 						array_push($this->arr_content, $data);
// 						// $this->L->printJson($item2);
// 				  	$i = sizeof($arr);
// 					}

// 				  // if($tot_match == sizeof($arr) or $tot_match/sizeof($arr) > 0.5) {
// 					 //  if ($this->content_index_start <= $index and $index <= $this->content_index_end) {
// 					 //  	$result        = $this->title_content_make($item['body'], $arr);
// 						// 	$data['id']    = $item['id'];
// 						// 	$data['type']  = $item['header'];
// 						// 	$data['title'] = $result['title'];
// 						// 	$data['desc']  = $result['content'];
// 						// 	array_push($this->arr_content, $data);
// 					 //  }
// 					 //  else {
// 						// 	$data['id']    = 'asd';
// 						// 	$data['type']  = 'asd';
// 						// 	$data['title'] = 'asd';
// 						// 	$data['desc']  = 'asd';
// 						// 	array_push($this->arr_content, $data);
// 					 //  }
// 				  // 	$index = $index+1;
// 				  // 	$i = sizeof($arr);
// 				  // }
// 				}

// 			  if ($tot_match != sizeof($arr) and $tot_match/sizeof($arr) > 0.5) {
// 			  	$item2        = $this->title_content_make($item['content'], $arr);
// 					$data['id']    = $item['id'];
// 					$data['type']  = $this->type_make($item);
// 					$data['title'] = $item2['title'];
// 					$data['desc']  = $item2['content'];
// 					$data['priority']  = 9;
// 					array_push($this->arr_content, $data);
// 				}
// 			}
// 		}
// 		return $data_tot;
// 	}

// 	function get_arr_json_item_by_id ($arr_json, $id) {
// 		foreach ($arr_json as $item) {
// 			if ($item['id'] == $id) {
// 				return $item;
// 			}
// 	 	}
// 	}

// 	// inverted index
// 	function search_from2() {

// 		$data_tot = [];
// 		if ($this->arr_user_keywords != null) {
// 			$arr_user_keywords = $this->arr_user_keywords;

// 			// $json = include $db_file;
// 			// $json = $json[DATA];
// 			// $this->L->printJson($json);
// 			// $json_2 = $this->L->json_read($db_file)[DATA];

// 			$dir = BASE_DIR . 'storages/enlite/result.invix.json';
// 			$json = $this->L->json_read($dir)[DATA];

// 			$arrjson_match = [];
// 			foreach ($arr_user_keywords as $_kkey => $_kval) {
// 				array_push($arrjson_match, self::get_json_from_arrjson_by_str($json, $value, 'word'));
// 			}

// 			$result2 = [];
// 			$exec = '$result2 = array_intersect(';
// 			foreach ($arrjson_match as $_mkey => $_mval) {
// 				if ($_mkey != sizeof($arrjson_match)-1) {
// 					$exec = $exec . '$arrjson_match['.$_mkey.']["index"],';
// 				}
// 				else {
// 					$exec = $exec . '$arrjson_match['.$_mkey.']["index"])';
// 				}
// 			}
// 			echo $exec;

// 			// for ($i=0; $i<sizeof($arrjson_match); $i++) {
// 			// 	$exec = $exec . '$arrjson_match['.$i.']["index"]'
// 			// 		$result2 = array_intersect($arrjson_match[$i]['index'], $arrjson_match[$i+1]['index']);
// 			// }			
// 			// foreach($json as $row) {
// 		  //    foreach($row as $key => $val) {
// 			// 		$word = $arr_user_keywords[$i];
// 			// 		$result = $this->L->str_cmp($key, $word);
// 			// 	  if($result['is_same']) {
// 			// 	  	$tot_match++;
// 			// 		  	array_push($pos, $result['pos']);
// 			// 	  }
// 			// 	}
// 			// }
// 		}
// 		return $data_tot;
// 	}

// 	function get_json_from_arrjson_by_str ($arrjson, $word, $key) {
// 		foreach($arrjson as $index => $json) {
// 			$str1 = $this->L->root_word($json[$key]);
// 			$str2 = $this->L->root_word($word);
// 			if ($this->L->str_cmp_case_insen($str1, $str2, 'full')) {
// 				return $json;
// 			}
// 			else if ($index == sizeof($arrjson)-1) {
// 				return null;
// 			}
// 		}
// 	}

// 	function search2($user_keyword, $page) {
// 		$this->user_keyword = $user_keyword;
// 		$this->arr_content = [];

// 		$this->content_index_start = $page*10;
// 		$this->content_index_end = ($page+1)*10-1;

// 		$this->arr_user_keywords = explode(" ", $user_keyword);
// 		$this->is_mistake = false;
// 		$this->correction = '';

// 		$this->L->word_activate();

// 		$this->search_from2();

// 		$time_start = $this->L->microtime_float();
// 		$paresedStr = $this->L->str_to_arr(strtolower($user_keyword), ":");
// 		if ($paresedStr[0] == "q") {
// 			$type = "quran";
// 			$newArrStr = $this->L->popFirstIndex($paresedStr);
// 			$user_keyword = $this->L->arr_to_str($newArrStr);
// 		}
// 		else if ($paresedStr[0] == "h"){
// 			$newArrStr = $this->L->popFirstIndex($paresedStr);
// 			$user_keyword = $this->L->arr_to_str($newArrStr);
// 			$type = "hadith";
// 		}
// 		else {
// 			$type = "all";
// 		}


// 		$dir = BASE_DIR . 'storages/enlite/';
// 		// $hadith_db = 'newbm.json.php';
// 		$hadith_db = 'newbm.json';
// 		// $quran_db = 'quran.json.php';
// 		$quran_db = 'fix_alquran_v1.json';
// 		// $quran_db = 'enlite_quran_fix.json';
// 		// $hadith_db = 'enlite_light_hadith.json';

// 		if ($type == "quran") {
// 			$this->search_from($dir.$quran_db);
// 		}
// 		else if ($type == "hadith") {
// 			$this->search_from($dir.$hadith_db);
// 		}
// 		else {
// 			$this->search_from($dir.$quran_db);
// 			$this->search_from($dir.$hadith_db);
// 		}

// 		self::correcting();
// 		if (sizeof($this->arr_content) == 0) {
// 			$asd['title'] = $user_keyword;
// 			$asd['type'] = $user_keyword;	
// 			$asd['desc'] = $user_keyword;	
// 			$result['status'] = 'NOT_FOUND';
// 			array_push($this->arr_content, $asd);
// 			$is_mistake = $this->is_mistake;
// 			if ($is_mistake)
// 				$correction = $this->correction;
// 			else
// 				$correction = 'no correction';
// 		}
// 		else {
// 			$is_mistake = $this->is_mistake;
// 			if ($is_mistake)
// 				$correction = $this->correction;
// 			else
// 				$correction = 'no correction';

// 			$result['status'] = 'FOUND';		
// 		}
// 		$sort_by = 'priority';
// 		$this->arr_content = $this->L->sort_json_arr($this->arr_content, $sort_by);
// 		// $this->L->printJson($this->arr_content);
		
// 		$cols_per_page = 10;
// 		$final_result = [];
// 		$page_tot = ceil(count($this->arr_content)/$cols_per_page);
// 		for ($i=0+($cols_per_page*$page); $i<$cols_per_page+($cols_per_page*$page); $i++) {
// 			if (isset($this->arr_content[$i]))
// 				array_push($final_result, $this->arr_content[$i]);
// 		}


// 		$time_end = $this->L->microtime_float();
// 		$time = (string)($time_end - $time_start);
// 		$time = substr($time, 0, 4);
		
// 		$result['data'] = $final_result;
// 		$result['page_tot'] = $page_tot;
// 		$result['is_mistake'] = $is_mistake;
// 		$result['correction'] = $correction;
// 		$result['time'] = $time;
// 		$result['content_tot'] = sizeof($this->arr_content);
// 		$result = json_encode($result, true);
// 		echo $result;
// 	}

// 	function type_make($item) {
// 		$type = '';
// 		if (isset($item['surah'])) {
// 			$type = $item['surah'] . ' (' . $item['surah_no'] . ':' . $item['ayat_no'] . ')' ;
// 		}
// 		else if (isset($item['hadith_no'])) {
// 			$type = $item['hadith_no'];
// 		}
// 		$result = $item['source'] . ', ' . $type;
// 		return $result;
// 	}

// 	function title_content_make($string, $word) {
// 		$arr = explode(" ",$string);

// 		if (sizeof($arr) != 0) {
// 			$index = 0;
// 			$is_found = false;
// 			for ($i=0; $i<sizeof($arr); $i++) {
// 				for ($j=0; $j<sizeof($word); $j++) {
// 					$root_word = $this->L->root_word($arr[$i]);
// 					if ($this->L->str_cmp_case_insen($root_word, $word[$j], 'part')) {
// 						$index = $i;
// 						$is_found = true;
// 						$i = sizeof($arr);
// 						$j = sizeof($word);
// 					}
// 				}
// 			}
// 			// echo $index . '<br>';
// 			// $this->L->printJson($arr);
// 			// $this->L->printJson($word);

// 			$str_after = [];
// 			$isEnd = false;
// 			for ($i=$index+1; $i<$index+20; $i++) {
// 				if (array_key_exists($i, $arr)) {
// 					$match = false;
// 					$_word = $this->L->root_word($arr[$i]);
// 					for ($j=0; $j<sizeof($word); $j++) {
// 						$_word2 = $this->L->root_word($word[$j]);
// 						if ($this->L->str_cmp_case_insen($_word, $_word2, 'part')) {
// 							array_push($str_after, '<b>' . $arr[$i] . '</b>');
// 							$match = true;
// 							$j = sizeof($word);
// 						}
// 					}
// 					if (!$match) {
// 						array_push($str_after, $arr[$i]);
// 					}
// 				}
// 				else {
// 					$i = $index+20;
// 					$isEnd = true;
// 				}
// 			}

// 			if (!$isEnd) {
// 				array_push($str_after, '...');
// 			}

// 			$isEnd = false;
// 			$str_before = [];
// 			for ($i=$index-1; $i>$index-20; $i--) {
// 				if (array_key_exists($i, $arr)) {
// 					$match = false;
// 					$_word = $this->L->root_word($arr[$i]);
// 					for ($j=0; $j<sizeof($word); $j++) {
// 						$_word2 = $this->L->root_word($word[$j]);
// 						if ($this->L->str_cmp_case_insen($_word, $_word2, 'part')) {
// 							array_unshift($str_before, '<b>' . $arr[$i] . '</b>');
// 							$match = true;
// 							$j = sizeof($word);
// 						}
// 					}
// 					if (!$match) {
// 						array_unshift($str_before, $arr[$i]);
// 					}
// 				}
// 				else {
// 					$i = $index-20;
// 					$isEnd = true;
// 				}
// 			}
// 			if (!$isEnd) {
// 				array_unshift($str_before, '...');
// 			}

// 			$title = $this->getArrayValueUntilIndex($str_after, 5);
// 			$title = $this->L->arr_to_str($title);

// 			$title2 = $this->getArrayValueUntilIndexBackward($str_before, 2);
// 			$title2 = $this->L->arr_to_str($title2);

// 			$str_before = $this->L->arr_to_str($str_before);
// 			$str_after = $this->L->arr_to_str($str_after);

// 			if ($is_found) {
// 				$result['content'] = $str_before . ' <b>' . $arr[$index] . '</b> ' . $str_after;
// 			}
// 			else {
// 				$result['content'] = $str_before . ' ' . $arr[$index] . ' ' . $str_after;				
// 			}
// 			// $result['title'] = ucfirst($arr[$index]) . ' ' . $title;
// 			if ($title2 != '') {
// 				$result['title'] = '... ' . $title2 . ' ' . $arr[$index] . ' ' . $title;
// 			}
// 			else {
// 				$result['title'] = ucfirst($arr[$index]) . ' ' . $title;
// 			}
// 			// echo $index . '<br>';
// 			// $this->L->printJson($result['content']);
// 			// $this->L->printJson($str_before);
// 			// echo $str_after . '<br>';
// 			// echo $result['content'] . '<br>';
// 		}
// 		else  {
// 			$result['title'] = '';
// 			$result['content'] = '';
// 		}

// 		return $result;
// 	}

// 	function getArrayValueUntilIndex($arr, $until_index) {
// 		$result = [];
// 		for ($i=0; $i<$until_index; $i++) {
// 			if (isset($arr[$i])) {
// 				$word = $arr[$i];
// 				$word = str_replace('<b>', '', $word);
// 				$word = str_replace('</b>', '', $word);
// 				array_push($result, $word);
// 			}
// 		}		
// 		if ($until_index < sizeof($arr))
// 			array_push($result, '...');
// 		return $result;
// 	}

// 	function getArrayValueUntilIndexBackward($arr, $until_index) {
// 		$result = [];
// 		for ($i=sizeof($arr)-1; $i>sizeof($arr)-1-$until_index; $i--) {
// 			if (isset($arr[$i])) {
// 				$word = $arr[$i];
// 				$word = str_replace('<b>', '', $word);
// 				$word = str_replace('</b>', '', $word);
// 				array_unshift($result, $word);
// 			}
// 		}	
// 		// if ($until_index < sizeof($arr))
// 		// 	array_unshift($result, '...');
// 		return $result;
// 	}
// }

class StateService
{
	protected  $stateDirectory;
 
	/**
	 * StateService constructor. Takes optional directory location otherwise current directory is used.
	 * @param string $stateDirectory
	 */
	public function __construct(/*string*/ $stateDirectory = __DIR__)
	{
		assert(func_num_args() <= 1);
		$this->stateDirectory = $stateDirectory;
	}
	/**
	 * Get the stored state variables from a file into an array.
	 * State variables are stored as a file in json format.
	 *
	 * @param string $name - optional name of state file, if not provided 'default' is used.
	 * @return array - Associative array of state variables
	 * @throws \Exception
	 */
	public function getState(/*string*/ $name = 'default') #:array
	{
		assert(func_num_args() <= 1);
		$state = [];
		$fullPath = $this->stateDirectory . '/' . ltrim(rtrim($name)) . '.json';
		if (file_exists($fullPath))
		{
			$state = json_decode(file_get_contents($fullPath), true);
			if (!isset($state))
			{
				throw new \Exception(json_last_error_msg() . ' at: ' . $fullPath);
			}
		}
		return $state;
	}
	/**
	 * Saves the passed in array as a json file.
	 * State variables are stored as a file in json format.
	 * @param string $name - optional name of state file, if none provided 'default' is used.
	 * @param array $data - Associative array of state variables to be saved.
	 * @return int - The number of bytes saved to the file.
	 */
	public function saveState(/*string*/ $name = 'default', array $data) #:int
	{
		assert(func_num_args() <= 2);
		$fullPath = $this->stateDirectory . '/' . ltrim(rtrim($name)) . '.json';
		return file_put_contents($fullPath, json_encode($data, JSON_PRETTY_PRINT));
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