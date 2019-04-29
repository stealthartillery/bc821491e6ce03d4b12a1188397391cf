<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// $BASE_URL = 'http://localhost/';
// $HOME_URL = 'http://localhost/app/';
// $BASE_DIR = 'E:/liteapps/';
// $HOME_DIR = 'E:/liteapps/app/be.lanterlite.com/';

$BASE_URL = 'https://frontlite.lanterlite.com/';
$HOME_URL = 'https://frontlite.lanterlite.com/';
$BASE_DIR = FCPATH;
$HOME_DIR = FCPATH;

$APP_DOMAIN = 'frontlite.lanterlite.com';

defined('BASE_URL') OR define('BASE_URL', $BASE_URL);
defined('HOME_URL') OR define('HOME_URL', $HOME_URL.$APP_DOMAIN.'/');
defined('BASE_DIR') OR define('BASE_DIR', $BASE_DIR);
defined('HOME_DIR') OR define('HOME_DIR', $HOME_DIR);

defined('HOST') OR define('HOST', $HOME_URL.$APP_DOMAIN.'/');
defined('FE_URL') OR define('FE_URL', $HOME_URL.$APP_DOMAIN.'/');
defined('SEC_KEY') OR define('SEC_KEY', 'IUEYAFC9832C3N98YHDNS98DSYHFNE9239282C39R83CN98SWD');
defined('CUR_DIR') OR define('CUR_DIR', getcwd());
// error_reporting(0);
// ini_set('display_errors', 0);

include BASE_DIR .'lanterlite.gen.php';

?>