
LGen.system = new System()

function System() {

	this.set = set
	function set() {
		if (LGen.app.status == 'dev') {
			this.host = 'http://localhost/';
			this.fe_url = this.host+'app/';
			this.be_url = this.host+'app/be.lanterlite.com/';
			// this.fe_url = 'https://';
			// this.be_url = 'https://betest.lanterlite.com/';
			this.change_url = '/app/'+LGen.app.domain;
			this.be_domain = 'be.lanterlite.com';
			this.base_url = "http://localhost/";
			this.home_url = "http://localhost/app/"+LGen.app.domain+"/";
			this.base_dir = '';
			this.home_dir = '';
			// this.CORELITE_URL = host+'www.lanterlite.com/'
			// this.FE_URL = host+'frontlite.lanterlite.com/';
			// this.FE_base_url = 'http://localhost/';

			if (LGen.app.platform == 'web') {
				this.base_dir = 'E:/liteapps/'
				this.home_dir = this.base_dir+'app/'+LGen.app.domain+'/';
			}
			else if (LGen.app.platform == 'mob') {
			}
			else if (LGen.app.platform == 'des') {
			}
		}

		else if (LGen.app.status == 'dep') {
			this.host = 'https://';
			this.home_url = "https://"+LGen.app.domain+"/";
			this.home_dir = '';
			this.base_dir = '';
			this.fe_url = 'https://';
			this.be_url = 'https://be.lanterlite.com/';
			this.change_url = '';
			this.be_domain = 'be.lanterlite.com';
			// this.FE_URL = host+'frontlite.lanterlite.com/';
			// this.FE_base_url = host+'frontlite.lanterlite.com/';
			// this.CORELITE_URL = host+'www.lanterlite.com/'
		}
	}
}
