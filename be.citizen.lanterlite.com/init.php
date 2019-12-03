<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$app = file_get_contents('app/app.lgen');
$app = json_decode($app, true);
error_log($app);
defined('app_status') OR define('app_status', $app['status']);
// echo json_encode(app_status);
// echo json_encode($app);
init($app);
function init($app) {
	if (app_status === 'dev') {
		defined('FE_URL') OR define('FE_URL', 'http://localhost/app/');
		defined('BASE_URL') OR define('BASE_URL', 'http://localhost/');
		defined('BASE_DIR') OR define('BASE_DIR', 'E:/liteapps/');
		defined('HOME_URL') OR define('HOME_URL', 'http://localhost/app/'.$app['be_domain'].'/');
		defined('HOME_DIR') OR define('HOME_DIR', 'E:/liteapps/app/'.$app['be_domain'].'/');
		ini_set("log_errors", 1);
		ini_set("error_log", HOME_DIR.'storages/'. 'gate.log');
	}
	else if (app_status === 'test') {
		defined('FE_URL') OR define('FE_URL', 'https://');
		defined('HOME_URL') OR define('HOME_URL', 'https://'.$app['be_domain'].'/');
		defined('BASE_URL') OR define('BASE_URL', 'https://'.$app['be_domain'].'/');
		defined('HOME_DIR') OR define('HOME_DIR', FCPATH);
		defined('BASE_DIR') OR define('BASE_DIR', FCPATH);
		ini_set("log_errors", 1);
		ini_set("error_log", HOME_DIR.'storages/'. 'gate.log');
	}
	else {
		defined('FE_URL') OR define('FE_URL', 'https://');
		defined('HOME_URL') OR define('HOME_URL', 'https://'.$app['be_domain'].'/');
		defined('BASE_URL') OR define('BASE_URL', 'https://'.$app['be_domain'].'/');
		defined('HOME_DIR') OR define('HOME_DIR', FCPATH);
		defined('BASE_DIR') OR define('BASE_DIR', FCPATH);
		error_reporting(0);
		ini_set('display_errors', 0);
	}
}