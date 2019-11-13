
LGen.system = new System()

function System() {

	this.obj = {}
	this.get = get
	function get(obj) {
		if (!HOME_URL.includes('localhost') && !LGen.hasOwnProperty('test')) {
			if (this.get.caller === null) return false
			var keys = Object.keys(obj);
			if (!keys.indexOf('safe') === -1) return false;
			else if (obj['safe'] !== 'safe')  return false;
		}
		return LGen.call({'c':'white','f':'get'})({'val':LGen.system.obj,'safe':'safe'})
	}

	this.set = set
	function set() {
		this.obj.be_domain = 'be.citizen.lanterlite.com';
		this.obj.citizen_domain = 'be.citizen.lanterlite.com';
		this.obj.store_domain = 'store.be.citizen.lanterlite.com';
		this.obj.search_domain = 'be.search.lanterlite.com';

		if (LGen.app.get({'safe':'safe'}).status === 'dev') {
			this.obj.host = 'http://localhost/';
			this.obj.fe_url = this.obj.host+'app/';
			this.obj.be_url = this.obj.host+'app/be.citizen.lanterlite.com/';
			// this.obj.fe_url = 'https://';
			// this.obj.be_url = 'https://betest.lanterlite.com/';
			this.obj.change_url = '/app/'+LGen.app.get({'safe':'safe'}).domain;
			this.obj.base_url = "http://localhost/";
			this.obj.home_url = "http://localhost/app/"+LGen.app.get({'safe':'safe'}).domain+"/";
			this.obj.base_dir = '';
			this.obj.home_dir = '';
			// this.obj.CORELITE_URL = host+'www.lanterlite.com/'
			// this.obj.FE_URL = host+'frontlite.lanterlite.com/';
			// this.obj.FE_base_url = 'http://localhost/';

			if (LGen.app.get({'safe':'safe'}).platform == 'web') {
				this.obj.base_dir = 'E:/liteapps/'
				this.obj.home_dir = this.obj.base_dir+'app/'+LGen.app.get({'safe':'safe'}).domain+'/';
			}
			else if (LGen.app.get({'safe':'safe'}).platform == 'mob') {
			}
			else if (LGen.app.get({'safe':'safe'}).platform == 'des') {
			}
		}
		else if (LGen.app.get({'safe':'safe'}).status === 'server_test') {
			this.obj.host = 'http://localhost/';
			this.obj.fe_url = 'https://';
			this.obj.be_url = 'https://be.citizen.lanterlite.com/';
			// this.obj.fe_url = 'https://';
			// this.obj.be_url = 'https://betest.lanterlite.com/';
			this.obj.change_url = '/app/'+LGen.app.get({'safe':'safe'}).domain;
			this.obj.base_url = "http://localhost/";
			this.obj.home_url = "http://localhost/app/"+LGen.app.get({'safe':'safe'}).domain+"/";
			this.obj.base_dir = '';
			this.obj.home_dir = '';
			// this.obj.CORELITE_URL = host+'www.lanterlite.com/'
			// this.obj.FE_URL = host+'frontlite.lanterlite.com/';
			// this.obj.FE_base_url = 'http://localhost/';

			if (LGen.app.get({'safe':'safe'}).platform == 'web') {
				this.obj.base_dir = 'E:/liteapps/'
				this.obj.home_dir = this.obj.base_dir+'app/'+LGen.app.get({'safe':'safe'}).domain+'/';
			}
			else if (LGen.app.get({'safe':'safe'}).platform == 'mob') {
			}
			else if (LGen.app.get({'safe':'safe'}).platform == 'des') {
			}
		}
		else if (LGen.app.get({'safe':'safe'}).status === 'dep') {
			this.obj.host = 'https://';
			this.obj.home_url = "https://"+LGen.app.get({'safe':'safe'}).domain+"/";
			this.obj.base_url = "";
			this.obj.home_dir = '';
			this.obj.base_dir = '';
			this.obj.fe_url = 'https://';
			this.obj.be_url = 'https://be.citizen.lanterlite.com/';
			this.obj.change_url = '';
			// this.obj.FE_URL = host+'frontlite.lanterlite.com/';
			// this.obj.FE_base_url = host+'frontlite.lanterlite.com/';
			// this.obj.CORELITE_URL = host+'www.lanterlite.com/'
			if (LGen.app.get({'safe':'safe'}).platform === 'mob') {
				this.obj.home_url = "";
				this.obj.base_url = "";
			}
			else if (LGen.app.get({'safe':'safe'}).platform === 'des') {
				this.obj.home_url = "";
				this.obj.base_url = "";
			}
		}
		else if (LGen.app.get({'safe':'safe'}).status === 'client_test') {
			this.obj.host = 'https://';
			this.obj.home_url = "https://"+LGen.app.get({'safe':'safe'}).domain+"/";
			this.obj.base_url = "";
			this.obj.home_dir = '';
			this.obj.base_dir = '';
			this.obj.fe_url = 'https://';
			this.obj.be_url = 'https://be.citizen.lanterlite.com/';
			this.obj.change_url = '';
			// this.obj.FE_URL = host+'frontlite.lanterlite.com/';
			// this.obj.FE_base_url = host+'frontlite.lanterlite.com/';
			// this.obj.CORELITE_URL = host+'www.lanterlite.com/'
			if (LGen.app.get({'safe':'safe'}).platform === 'mob') {
				this.obj.home_url = "";
				this.obj.base_url = "";
			}
			else if (LGen.app.get({'safe':'safe'}).platform === 'des') {
				this.obj.home_url = "";
				this.obj.base_url = "";
			}
		}
		this.obj = LGen.call({'c':'black','f':'get'})({'val':this.obj,'safe':'safe'})
	}
}
