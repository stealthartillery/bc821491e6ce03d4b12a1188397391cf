<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

defined('BASE_URL') OR define('BASE_URL', 'https://update.lanterlite.com/');
defined('HOME_URL') OR define('HOME_URL', 'https://update.lanterlite.com/');
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
// defined('BASEPATH') OR exit('No direct script access allowed');

// defined('BASE_URL') OR define('BASE_URL', 'https://update.lanterlite.com/');
// defined('HOME_URL') OR define('HOME_URL', 'https://update.lanterlite.com/');
// defined('BASE_DIR') OR define('BASE_DIR', FCPATH);
// defined('HOME_DIR') OR define('HOME_DIR', FCPATH);

// defined('HOST') OR define('HOST', 'https://update.lanterlite.com/');
// defined('FE_URL') OR define('FE_URL', 'https://www.lanterlite.com/');
// defined('FE_BASE_URL') OR define('FE_BASE_URL', 'https://update.lanterlite.com/');
// defined('SEC_KEY') OR define('SEC_KEY', 'IUEYAFC9832C3N98YHDNS98DSYHFNE9239282C39R83CN98SWD');
// defined('CUR_DIR') OR define('CUR_DIR', getcwd());
// error_reporting(0);
// ini_set('display_errors', 0);

// // include BASE_DIR .'lanterlite.gen.php';

?>