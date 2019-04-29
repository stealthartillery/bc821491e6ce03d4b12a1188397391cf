var LOCALHOST_DIR = 'E:/liteapps/'

if (APP_STATUS == 'dev') {
	var HOST = 'http://localhost/';
	var CORELITE_URL = 'http://localhost/app/www.lanterlite.com/'

	if (APP_PLATFORM == 'web') {
		var FE_URL = 'http://localhost/app/frontlite.lanterlite.com/';
		var FE_BASE_URL = 'http://localhost/';
		var BE_URL = 'http://localhost/app/be.lanterlite.com/';
		var HOME_URL = 'http://localhost/app/'+APP_DOMAIN+'/';
		var BASE_URL = 'http://localhost/';
		var HOME_DIR = LOCALHOST_DIR+'app/'+APP_DOMAIN+'/';
		var BASE_DIR = LOCALHOST_DIR;
		var CSS_URL = 'http://localhost/assets/'+APP_CODENAME+'/css/';
	}
	else if (APP_PLATFORM == 'mob') {
		var FE_URL = 'http://localhost/app/frontlite.lanterlite.com/';
		var FE_BASE_URL = 'http://localhost/';
		var BE_URL = 'http://localhost/app/be.lanterlite.com/';
		var HOME_URL = '';
		var BASE_URL = '';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var CSS_URL = 'assets/'+APP_CODENAME+'/css/';
	}
	else if (APP_PLATFORM == 'des') {
		var FE_URL = 'http://localhost/app/frontlite.lanterlite.com/';
		var FE_BASE_URL = 'http://localhost/app/frontlite.lanterlite.com/';
		var BE_URL = 'http://localhost/app/be.lanterlite.com/';
		var HOME_URL = '';
		var BASE_URL = '';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var CSS_URL = 'assets/'+APP_CODENAME+'/css/';
	}

	if (APP_TYPE == 'amp' && APP_PLATFORM != 'web') {
		var FE_URL = 'http://localhost/app/frontlite.lanterlite.com/';
		var FE_BASE_URL = 'http://localhost/';
		var BE_URL = 'http://localhost/app/be.lanterlite.com/';
		var HOME_URL = '';
		var BASE_URL = 'http://localhost/';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var CSS_URL = BASE_URL + 'assets/'+APP_CODENAME+'/css/';
	}
	else if (APP_TYPE == 'amp' && APP_PLATFORM == 'web') {
		var FE_URL = 'http://localhost/app/frontlite.lanterlite.com/';
		var FE_BASE_URL = 'http://localhost/';
		var BE_URL = 'http://localhost/app/be.lanterlite.com/';
		var HOME_URL = '';
		var BASE_URL = 'http://localhost/';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var CSS_URL = BASE_URL + 'assets/'+APP_CODENAME+'/css/';
	}
}
else if (APP_STATUS == 'dep') {
	var HOST = 'https://';
	var CORELITE_URL = 'https://www.lanterlite.com/'

	if (APP_PLATFORM == 'web') {
		var FE_URL = 'https://frontlite.lanterlite.com/';
		var FE_BASE_URL = 'https://frontlite.lanterlite.com/';
		var BE_URL = 'https://be.lanterlite.com/';
		var HOME_URL = 'https://'+APP_DOMAIN+'/';
		var BASE_URL = 'https://'+APP_DOMAIN+'/';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var CSS_URL = 'assets/'+APP_CODENAME+'/css/';
	}
	else if (APP_PLATFORM == 'mob') {
		var FE_URL = 'https://frontlite.lanterlite.com/';
		var FE_BASE_URL = 'https://frontlite.lanterlite.com/';
		var BE_URL = 'https://be.lanterlite.com/';
		var HOME_URL = '';
		var BASE_URL = '';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var CSS_URL = 'assets/'+APP_CODENAME+'/css/';
	}
	else if (APP_PLATFORM == 'des') {
		var FE_URL = 'https://frontlite.lanterlite.com/';
		var FE_BASE_URL = 'https://frontlite.lanterlite.com/';
		var BE_URL = 'https://be.lanterlite.com/';
		var HOME_URL = '';
		var BASE_URL = '';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var CSS_URL = 'assets/'+APP_CODENAME+'/css/';
	}

	if (APP_TYPE == 'amp' && APP_PLATFORM != 'web') {
		var FE_URL = 'http://localhost/app/frontlite.lanterlite.com/';
		var FE_BASE_URL = 'http://localhost/';
		var BE_URL = 'http://localhost/app/be.lanterlite.com/';
		var HOME_URL = '';
		var BASE_URL = '';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var CSS_URL = BASE_URL + 'assets/'+APP_CODENAME+'/css/';
	}
	else if (APP_TYPE == 'amp' && APP_PLATFORM == 'web') {
		var FE_URL = 'https://frontlite.lanterlite.com/';
		var FE_BASE_URL = 'https://frontlite.lanterlite.com/';
		var BE_URL = 'https://be.lanterlite.com/';
		var HOME_URL = 'https://'+APP_DOMAIN+'/';
		var BASE_URL = FE_BASE_URL;
		var HOME_DIR = '';
		var BASE_DIR = '';
		var CSS_URL = FE_URL+ 'assets/'+APP_CODENAME+'/css/';
	}
}


// switch(APP_TYPE) {
// 	case 'amp':
// 		var FE_URL = 'http://localhost/';
// 		// var FE_URL = 'https://frontlite.lanterlite.com/';
// 		var BE_URL = 'https://be.lanterlite.com/';
// 		var HOME_URL = FE_URL;
// 		var BASE_URL = FE_URL;
// 		var HOME_DIR = FE_URL;
// 		var BASE_DIR = FE_URL;
// 		var CSS_URL = FE_URL + 'assets/'+APP_CODENAME+'/css/';
// 		break;
// 	default:
// 		break;
// }
