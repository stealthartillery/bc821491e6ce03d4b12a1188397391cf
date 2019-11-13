var component = new Component()
component.load()

function Component() {

	this.get_fn = function (fn) {
		// var asd = this.status?LGen.call({'c':'black','f':'mini'})({'val':fn,'safe':'safe'}):fn
		// return asd;
		return fn
	}

	this.load = load
	function load() {
		var status = LGen.app.get({'safe':'safe'}).status
		this.status = status==='dep'? true : false
		
		var js_list = [
			BASE_URL+'assets/gen_base_fe/'+this.get_fn('lantergen.route')+'.js',
			BASE_URL+'assets/gen_base_fe/hammer.min.js',
			BASE_URL+'assets/gen_base_fe/driver.min.js',

			BASE_URL+'assets/gen_js/manager/'+this.get_fn('ArrayMan')+'.js',
			BASE_URL+'assets/gen_js/manager/'+this.get_fn('JsonMan')+'.js',
			BASE_URL+'assets/gen_js/manager/'+this.get_fn('ElementMan')+'.js',
			BASE_URL+'assets/gen_js/manager/'+this.get_fn('ReqMan')+'.js',
			BASE_URL+'assets/gen_js/manager/'+this.get_fn('DateMan')+'.js',
			BASE_URL+'assets/gen_js/manager/'+this.get_fn('NumMan')+'.js',
			BASE_URL+'assets/gen_js/manager/'+this.get_fn('Citizen')+'.js',
			BASE_URL+'assets/gen_js/manager/'+this.get_fn('Page')+'.js',
			BASE_URL+'assets/gen_js/manager/'+this.get_fn('Translator')+'.js',

			BASE_URL+'assets/gen_js/'+this.get_fn('Theme')+'.js',
			BASE_URL+'assets/gen_js/'+this.get_fn('Snackbar')+'.js',
			BASE_URL+'assets/gen_js/'+this.get_fn('Checkbox')+'.js',
			BASE_URL+'assets/gen_js/'+this.get_fn('Loading')+'.js',
			BASE_URL+'assets/gen_js/'+this.get_fn('Confirmation')+'.js',
			BASE_URL+'assets/gen_js/'+this.get_fn('Information')+'.js',
			BASE_URL+'assets/gen_js/'+this.get_fn('Image')+'.js',
			BASE_URL+'assets/gen_js/'+this.get_fn('croppie')+'.js',
			BASE_URL+'assets/gen_js/'+this.get_fn('Footer')+'.js',
			BASE_URL+'assets/gen_js/'+this.get_fn('Sidebar')+'.js',
			BASE_URL+'assets/gen_js/'+this.get_fn('Header')+'.js',
			BASE_URL+'assets/gen_js/'+this.get_fn('Footbar')+'.js',
			BASE_URL+'assets/gen_js/'+this.get_fn('Signin')+'.js',
			BASE_URL+'assets/gen_js/'+this.get_fn('Account')+'.js',

			BASE_URL+'assets/gen_js/page/'+this.get_fn('AppConfig')+'.js',
			BASE_URL+'assets/gen_js/page/'+this.get_fn('Content')+'.js',
			BASE_URL+'assets/gen_js/page/'+this.get_fn('Captcha')+'.js',
			BASE_URL+'assets/gen_js/page/'+this.get_fn('Option')+'.js',
			BASE_URL+'assets/gen_js/page/'+this.get_fn('Profile')+'.js',
			BASE_URL+'assets/gen_js/page/'+this.get_fn('UpdateApp')+'.js',
			BASE_URL+'assets/gen_js/page/'+this.get_fn('Info')+'.js',
			// BASE_URL+'assets/gen_js/page/'+this.get_fn('NotifMessage')+'.js',
			BASE_URL+'assets/gen_js/page/'+this.get_fn('Notif')+'.js',
			BASE_URL+'assets/gen_js/page/'+this.get_fn('CreateAccount')+'.js',
			BASE_URL+'assets/gen_js/page/'+this.get_fn('NotFound')+'.js',
			BASE_URL+'assets/gen_js/page/'+this.get_fn('Offline')+'.js',
			// BASE_URL+'assets/gen_js/page/'+this.get_fn('Terms')+'.js',
			BASE_URL+'assets/gen_js/page/'+this.get_fn('EmailVerification')+'.js'


			// BASE_URL+'lanterlite.gen_js',
		]
		LGen.call({'c':'gen','f':'recursive_js_import'})(js_list, 0, function() {
			if (LGen.app.get({'safe':'safe'}).status !== 'dep')
				LGen.call({'c':'gen','f':'recursive_js_import'})([BASE_URL+'assets/gen_js/Admin.js'], 0, function() {})
			// LGen.translator.set()
			load_init() 
			// LGen.load_finished = true
			// LGen.Goldenrod = new Goldenrod()

			// LGen.ArrayMan = new ArrayMan()
			// LGen.NumMan = new NumMan()
			// LGen.ArrJsonMan = new ArrJsonMan()
			// LGen.JsonMan = new JsonMan()
			// LGen.StringMan = new StringMan()
			// LGen.PropKeyMan = new PropKeyMan()

			// LGen.Array = new ArrayMan()
			// LGen.Num = new NumMan()
			// LGen.ArrJson = new ArrJsonMan()
			// LGen.Json = new JsonMan()
			// LGen.String = new StringMan()
			// LGen.PropKey = new PropKeyMan()

			// LGen.component = new Lanterlite()
			// LGen.component.account = new Account()
			// LGen.component.signin = new Signin()
			// LGen.component.profile = new Profile()
		})
	}
}