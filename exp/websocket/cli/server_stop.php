<?php

	// $asd = exec('php --version');
	// echo $asd;
	// return 0;

	$obj = read(__DIR__.'/pid.json');
	echo exec('kill -9 '.$obj['pid']);
	// echo exec('php test_asd.php');
	// echo exec('git --version');
	// echo exec('php server.php');

	function read($file_path) {
		if (file_exists($file_path)) { 
			$string = file_get_contents($file_path); 
			return json_decode($string, true); 
		} 
		else
			return LGen('GlobVar')->failed;
	}


?>