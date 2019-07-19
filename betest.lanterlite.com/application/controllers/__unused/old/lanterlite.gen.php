<?php 

/*-------------------------------------
AUTHOR: IFAN
CODE-VERSION: 040219
-------------------------------------*/

define("CUR_DIR", getcwd());

define("RES_STAT", "RESPONSE_STATUS");
define("FILE_PATH", "FILE_PATH");
define("LSSK", "ioHybJBEFOSmNFFEPAMVA8979218uHH6dw6766868GGguwydgw");

define("DATA", "Data");
define("FUNC_NAME", "Functionname");
define("FILE_DIR", "Filedir");
define("FILE_NAME", "Filename");

define("SUCCESS", "A1");
define("FAILED", "E1");
define("NOT_FOUND", "E2");
define('NOT_EXIST', 'E3');
define('PASS_INCORRECT',	'E4');
define('USERNAME_EXIST', 'C1');
define('EMAIL_EXIST', 'C2');

$L = new Lanterlite();

$headers = $L->_getallheaders();
$data = json_decode(file_get_contents("php://input"), true);
if (isset($data)) {
	if (isset($headers[FUNC_NAME])) {
		if ($headers[FUNC_NAME] == 'saveJson') {
			header('Content-Type: application/json');
			echo json_encode($L->saveJson($headers[FILE_DIR], $headers[FILE_NAME], $data[DATA]));
			// echo json_encode(saveJson($headers[FILE_DIR], $headers[FILE_NAME], json_encode($data[DATA], true)));
		}
	}
}
else if (isset($headers[FUNC_NAME])) {
	if ($headers[FUNC_NAME] == 'readJson') {
		header('Content-Type: application/json');
		echo json_encode($L->readJson($headers[FILE_DIR] . $headers[FILE_NAME]));
	}
	else if ($headers[FUNC_NAME] == 'getFileNamesInsideDir') {
		header('Content-Type: application/json');
		echo json_encode($L->getFileNamesInsideDir($headers[FILE_DIR]));
	}
}

class Lanterlite {

	function getFileNamesInsideDir($dir) {
		$dir    = CUR_DIR . '/' . $dir;
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
	function saveJson ($file_dir, $file_name, $json_obj) {
		if (!file_exists(CUR_DIR . '/' . $file_dir))
			mkdir($file_dir, 0777, true); 		
		// file_put_contents(CUR_DIR . '/' . $file_dir . $file_name, $json_obj);
		// $i = 0;
		$file = fopen(CUR_DIR . '/' . $file_dir . $file_name, 'w');
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
	function readJson ($file_path) { if (file_exists($file_path)) { $string = file_get_contents($file_path); $data[DATA] = json_decode($string, true); $data[RES_STAT] = SUCCESS; } else { $data[RES_STAT] = NOT_FOUND; } return $data; } 

	/* RETURN: NONE */
	function setErrorLog ($file_path) { ini_set("log_errors", 1); ini_set("error_log", $file_path);}
	/* RETURN: NONE */
	function saveErrorLog ($error_msg) { error_log($error_msg); }

	/* RETURN: NONE */
	function printJson ($json) { echo "<pre>" . json_encode($json, JSON_PRETTY_PRINT) . "</pre>"; }
	/* RETURN: NONE */
	function printArray ($array) { echo "</br>"; for ($i=0; $i<count($array); $i++) echo "[" . $i . "] => " . $array[$i] . "</br>"; }

	/* RETURN: TRUE or FALSE */
	function isValidStr($string) { if ($string != NULL && is_string($string)) { return true; } else { return false; } }

	/* RETURN: TRUE or FALSE */
	function isValidInt($int) { if ($int != NULL && is_int($int)) { return true; } else { return false; } }


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

	function StrCmpCaseInsen($string1, $string2, $type='part') {
		if ($type == 'full') {
			return (strtolower($string1) == strtolower($string2));
		}
		else if ($type == 'part') {
			return (strpos(strtolower($string1), strtolower($string2)) !== false);
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
		$arr_str = StringToArray($string, ' ');

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

		// $total = 0;

		// $arr_str = StringToArray($string, ' ');

		$arr_str = self::readJson(CUR_DIR . '/words.json');
		$arr_str = $arr_str[DATA];

		$arr_inp = self::StringToArray(strtolower($userInput), ' ');
		$scores = [];
		$words = [];

		for ($j=0; $j<sizeof($arr_inp); $j++) {
			array_push($scores, 0);
			array_push($words, '-');
		}
		for ($i=0; $i<sizeof($arr_str); $i++) {
			for ($j=0; $j<sizeof($arr_inp); $j++) {

			  similar_text($arr_inp[$j], $arr_str[$i], $percentA);
			  if ($percentA > 50 && $percentA > $scores[$j]) {
			  	$scores[$j] = $percentA;
			  	$words[$j] = $arr_str[$i];
			  }
			}
		}

		$result['scores'] = $scores;
		$result['words'] = $words;
		return $result;
	}

	function clean_string($string) { 
		$search  = array('<br>', '</br>', '<i>', '</i>');
		$replace = array('', '', '', '');
		return str_replace($search, $replace, $string);
		// return preg_replace('/<br>+/', '', $string); 
	}
	function is_key_exist($json, $string) { return property_exists( $json, $string ); }
	function StringToArray($string, $parser) {return explode($parser,$string);}
	function ArrayToString($arr) {return implode(" ",$arr);}

	function mysort2($userInput, $string){

		// $total = 0;

		$arr_str = self::StringToArray($string, ' ');
		$arr_inp = self::StringToArray($userInput, ' ');
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

				// if (StrCmpCaseInsen($arr_str[$i], $userInput, 'part'))
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
}

/*-------------------------------------
###### ###### ##  ## ###### ##  ##
  ##   ##  ## ## ##  ##     ### ##
  ##   ##  ## #####  ###### ######
  ##   ##  ## ## ##  ##     ## ###
  ##   ###### ##  ## ###### ##  ##
-------------------------------------*/
class Token {

	const TOKEN_DIR = "/storage/tokens/";
	const ACC_TOKEN = "access_token";

	function requestToken($username) {
		$token = self::getToken($username);
		if ($token[RES_STAT] == SUCCESS) {
			$data[DATA] = $token[DATA];
			$data[RES_STAT] = SUCCESS;
		}
		else {
			$new_token = self::generateToken($username);
			self::setToken($new_token, $username);
			$data[DATA] = $new_token;
			$data[RES_STAT] = SUCCESS;
		}
		return $data;
	}

	function getToken($username) {
		$data = readJson(self::TOKEN_DIR . md5($username));
		return $data;
	}

	function setToken($token, $username) {
		$file_path = self::TOKEN_DIR . md5($username);
		$json_obj[self::ACC_TOKEN] = $token;
		$stat = saveJson($file_path, $json_obj);

		if ($stat == SUCCESS)
			return SUCCESS;
		else
			return NOT_FOUND;			
	}

	function generateToken($username) {
		if (isValidStr($username)) {
			$date = new DateTime();
			$token_date = $date->getTimestamp();
			$token = md5($username . $token_date);
			$data[DATA] = $token;
			$data[RES_STAT] = SUCCESS;
		}
		else 
			$data[RES_STAT] = FAILED;
		return $data;
	}

	function isValidToken($access_token, $username) {
		$data = readJson(self::TOKEN_DIR . md5($username));
		if ($data[RES_STAT] == SUCCESS && 
			$access_token == $data[DATA][self::ACC_TOKEN]) {
			return true;
		}
		else {
			return false;
		}
	}
}

?>