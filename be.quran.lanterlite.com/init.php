<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

defined('BASE_URL') OR define('BASE_URL', 'http://localhost/');
defined('HOME_URL') OR define('HOME_URL', 'http://localhost/app/be.quran.lanterlite.com/');
defined('BASE_DIR') OR define('BASE_DIR', 'E:/liteapps/');
defined('HOME_DIR') OR define('HOME_DIR', 'E:/liteapps/app/be.quran.lanterlite.com/');

defined('app_status') OR define('app_status', 'dev');

function init() {
	if (app_status === 'dev') {
		ini_set("log_errors", 1);
		ini_set("error_log", HOME_DIR.'storages/'. 'gate.log');
	}
	else {
		error_reporting(0);
		ini_set('display_errors', 0);
	}
}