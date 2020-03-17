<?php

$title = "PHP WebSocket";
$pid = getmypid(); // you can use this to see your process title in ps
echo "The process title '$title' for PID $pid has been set for your process!\n";
$obj = [];
$obj['pid'] = $pid;
save(__DIR__.'/', 'pid.json', $obj);

// if (!cli_set_process_title($title)) {
//   echo "Unable to set process title for PID $pid...\n";
//   exit(1);
// } else {
//   echo "The process title '$title' for PID $pid has been set for your process!\n";
//   $obj = [];
//   $obj['pid'] = $pid;
//   save(__DIR__.'/', 'pid.json', $obj);
//   // sleep(5);
// }

require __DIR__ . '/../src/Connection.php';
require __DIR__ . '/../src/Socket.php';
require __DIR__ . '/../src/Server.php';

require __DIR__ . '/../src/Application/ApplicationInterface.php';
require __DIR__ . '/../src/Application/Application.php';
require __DIR__ . '/../src/Application/DemoApplication.php';
require __DIR__ . '/../src/Application/StatusApplication.php';

$server = new \Bloatless\WebSocket\Server('153.92.8.208', 8000);

// server settings:
$server->setMaxClients(100);
$server->setCheckOrigin(false);
$server->setAllowedOrigin('foo.lh');
$server->setMaxConnectionsPerIp(100);
$server->setMaxRequestsPerMinute(2000);

// Hint: Status application should not be removed as it displays usefull server informations:
$server->registerApplication('status', \Bloatless\WebSocket\Application\StatusApplication::getInstance());
$server->registerApplication('demo', \Bloatless\WebSocket\Application\DemoApplication::getInstance());

$server->run();


function save($file_dir, $file_name, $json_obj, $minify=false) {
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