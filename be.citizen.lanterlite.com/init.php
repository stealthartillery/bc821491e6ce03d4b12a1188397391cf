<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

defined('BASE_URL') OR define('BASE_URL', 'https://be.citizen.lanterlite.com/');
defined('HOME_URL') OR define('HOME_URL', 'https://be.citizen.lanterlite.com/');
defined('BASE_DIR') OR define('BASE_DIR', FCPATH);
defined('HOME_DIR') OR define('HOME_DIR', FCPATH);

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