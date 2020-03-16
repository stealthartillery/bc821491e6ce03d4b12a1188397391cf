<?php

	// $title = "PHP WebSocket";
	// $pid = getmypid(); // you can use this to see your process title in ps

	// if (!cli_set_process_title($title)) {
	//   echo "Unable to set process title for PID $pid...\n";
	//   exit(1);
	// } else {
	//   echo "The process title '$title' for PID $pid has been set for your process!\n";
	//   $obj = [];
	//   $obj['pid'] = $pid;
	//   save_obj(__DIR__.'/', 'pid.json', $obj);
	//   // sleep(5);
	// }


  $obj = [];
  $obj['pid'] = 'asd';
  save_obj(__DIR__.'/', 'pid.json', $obj);


	// echo exec('php --version');
	// echo exec('php test_asd.php');
	// echo exec('git --version');
	// echo exec('php server.php');

	// function read($file_path) { 
	// 	if (file_exists($file_path)) { 
	// 		$string = file_get_contents($file_path); 
	// 		return json_decode($string, true); 
	// 	} 
	// 	else
	// 		return LGen('GlobVar')->failed;
	// }



	function save_obj($file_dir, $file_name, $json_obj, $minify=false) {
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
?>