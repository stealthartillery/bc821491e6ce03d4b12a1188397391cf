<?php
	class LogMan {
		function write($filedir, $txt) {
			//Something to write to txt log
			$log = $txt.PHP_EOL;
			// $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
			//         "Attempt: ".($result[0]['success']=='1'?'Success':'Failed').PHP_EOL.
			//         "User: ".$username.PHP_EOL.
			//         "-------------------------".PHP_EOL;
			//Save string to log, use FILE_APPEND to append.
			$dir = BASE_DIR.'storages/'.$filedir.'/log/';
			$filename = ''.date("j.n.Y").'.log';
			if (!file_exists($dir))
				mkdir($dir, 0777, true);
			file_put_contents($dir.$filename, $log, FILE_APPEND);
		}

		function setErrorLog($file_path) { 
			ini_set("log_errors", 1); 
			ini_set("error_log", $file_path);
		}

		function saveErrorLog($error_msg) { 
			error_log($error_msg); 
		}


	}
?>