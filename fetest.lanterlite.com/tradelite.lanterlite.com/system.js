var LOCALHOST_DIR = 'E:/liteapps/'

if (APP_STATUS == 'dev') {
	var HOST = 'http://localhost/app/';
	var CORELITE_URL = HOST+'www.lanterlite.com/'

	if (APP_PLATFORM == 'web') {
		var FE_URL = HOST+'frontlite.lanterlite.com/';
		var FE_BASE_URL = 'http://localhost/';
		var BE_URL = 'https://betest.lanterlite.com/backlite.lanterlite.com/';
		var HOME_URL = HOST+APP_DOMAIN+'/';
		var BASE_URL = 'http://localhost/';
		var HOME_DIR = LOCALHOST_DIR+'app/'+APP_DOMAIN+'/';
		var BASE_DIR = LOCALHOST_DIR;
		var GEN_URL = BASE_URL;
		var CSS_URL = 'http://localhost/assets/'+APP_CODENAME+'/css/';
	}
	else if (APP_PLATFORM == 'mob') {
		var FE_URL = HOST+'frontlite.lanterlite.com/';
		var FE_BASE_URL = 'http://localhost/';
		var BE_URL = 'https://betest.lanterlite.com/backlite.lanterlite.com/';
		var HOME_URL = '';
		var BASE_URL = '';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var GEN_URL = BASE_URL;
		var CSS_URL = 'assets/'+APP_CODENAME+'/css/';
	}
	else if (APP_PLATFORM == 'des') {
		var FE_URL = HOST+'frontlite.lanterlite.com/';
		var FE_BASE_URL = HOST+'frontlite.lanterlite.com/';
		var BE_URL = 'https://betest.lanterlite.com/backlite.lanterlite.com/';
		var HOME_URL = '';
		var BASE_URL = '';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var GEN_URL = BASE_URL;
		var CSS_URL = 'assets/'+APP_CODENAME+'/css/';
	}

	if (APP_TYPE == 'amp' && APP_PLATFORM != 'web') {
		var FE_URL = HOST+'frontlite.lanterlite.com/';
		var FE_BASE_URL = 'http://localhost/';
		var BE_URL = 'https://betest.lanterlite.com/backlite.lanterlite.com/';
		var HOME_URL = '';
		var BASE_URL = 'http://localhost/';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var GEN_URL = BASE_URL;
		var CSS_URL = BASE_URL + 'assets/'+APP_CODENAME+'/css/';
	}
	else if (APP_TYPE == 'amp' && APP_PLATFORM == 'web') {
		var FE_URL = HOST+'frontlite.lanterlite.com/';
		var FE_BASE_URL = 'http://localhost/';
		var BE_URL = 'https://betest.lanterlite.com/backlite.lanterlite.com/';
		var HOME_URL = HOST+APP_DOMAIN+'/';
		var BASE_URL = 'http://localhost/';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var GEN_URL = BASE_URL;
		var CSS_URL = BASE_URL + 'assets/'+APP_CODENAME+'/css/';
	}
}
else if (APP_STATUS == 'dep') {
	var HOST = 'https://';
	var CORELITE_URL = HOST+'www.lanterlite.com/'

	if (APP_PLATFORM == 'web') {
		var FE_URL = HOST+'frontlite.lanterlite.com/';
		var FE_BASE_URL = HOST+'frontlite.lanterlite.com/';
		var BE_URL = 'https://betest.lanterlite.com/backlite.lanterlite.com/';
		var HOME_URL = HOST+'fetest.lanterlite.com/'+APP_DOMAIN+'/';
		var BASE_URL = HOST+'fetest.lanterlite.com/'+APP_DOMAIN+'/';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var GEN_URL = BASE_URL;
		var CSS_URL = 'assets/'+APP_CODENAME+'/css/';
	}
	else if (APP_PLATFORM == 'mob') {
		var FE_URL = HOST+'frontlite.lanterlite.com/';
		var FE_BASE_URL = HOST+'frontlite.lanterlite.com/';
		var BE_URL = 'https://betest.lanterlite.com/backlite.lanterlite.com/';
		var HOME_URL = '';
		var BASE_URL = '';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var GEN_URL = BASE_URL;
		var CSS_URL = 'assets/'+APP_CODENAME+'/css/';
	}
	else if (APP_PLATFORM == 'des') {
		var FE_URL = HOST+'frontlite.lanterlite.com/';
		var FE_BASE_URL = HOST+'frontlite.lanterlite.com/';
		var BE_URL = 'https://betest.lanterlite.com/backlite.lanterlite.com/';
		var HOME_URL = '';
		var BASE_URL = '';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var GEN_URL = BASE_URL;
		var CSS_URL = 'assets/'+APP_CODENAME+'/css/';
	}

	if (APP_TYPE == 'amp' && APP_PLATFORM != 'web') {
		var FE_URL = HOST+'frontlite.lanterlite.com/';
		var FE_BASE_URL = HOST+'frontlite.lanterlite.com/';
		var BE_URL = 'https://betest.lanterlite.com/backlite.lanterlite.com/';
		var HOME_URL = '';
		var BASE_URL = '';
		var HOME_DIR = '';
		var BASE_DIR = '';
		var GEN_URL = BASE_URL;
		var CSS_URL = BASE_URL + 'assets/'+APP_CODENAME+'/css/';
	}
	else if (APP_TYPE == 'amp' && APP_PLATFORM == 'web') {
		var FE_URL = HOST+'frontlite.lanterlite.com/';
		var FE_BASE_URL = HOST+'frontlite.lanterlite.com/';
		var BE_URL = 'https://betest.lanterlite.com/backlite.lanterlite.com/';
		var HOME_URL = HOST+'fetest.lanterlite.com/'+APP_DOMAIN+'/';
		var BASE_URL = FE_BASE_URL;
		var HOME_DIR = '';
		var BASE_DIR = '';
		var GEN_URL = BASE_URL+'assets/'+APP_CODENAME+'/';
		var CSS_URL = FE_URL+ 'assets/'+APP_CODENAME+'/css/';
	}
}