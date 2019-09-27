var component = new Component()
component.load()

function Component() {
	this.load = load
	function load() {
		var js_list = [
			BASE_URL + 'assets/gen.js/manager/ArrayMan.js',
			BASE_URL + 'assets/gen.js/manager/ArrJsonMan.js',
			BASE_URL + 'assets/gen.js/manager/JsonMan.js',
			BASE_URL + 'assets/gen.js/manager/StringMan.js',
			BASE_URL + 'assets/gen.js/manager/NumMan.js',
			BASE_URL + 'assets/gen.js/manager/PropKeyMan.js',
			BASE_URL + 'assets/gen.js/manager/GlobVar.js',
			BASE_URL + 'assets/gen.js/manager/Page.js',
			BASE_URL + 'assets/gen.js/manager/Goldenrod.js',
			BASE_URL + 'assets/gen.js/manager/Translator.js',

			BASE_URL + 'assets/gen.js/Canvas.js',
			BASE_URL + 'assets/gen.js/CanvasBody.js',
			BASE_URL + 'assets/gen.js/FloatingButton.js',
			BASE_URL + 'assets/gen.js/FloatingCanvas.js',
			BASE_URL + 'assets/gen.js/RadioButton.js',
			BASE_URL + 'assets/gen.js/RangeSlider.js',
			BASE_URL + 'assets/gen.js/Accordion.js',
			BASE_URL + 'assets/gen.js/Toggle.js',
			BASE_URL + 'assets/gen.js/Snackbar.js',
			BASE_URL + 'assets/gen.js/Checkbox.js',
			BASE_URL + 'assets/gen.js/Select.js',
			BASE_URL + 'assets/gen.js/MoveTopButton.js',
			BASE_URL + 'assets/gen.js/Loading.js',
			BASE_URL + 'assets/gen.js/Theme.js',
			BASE_URL + 'assets/gen.js/Option.js',

			BASE_URL + 'assets/gen.js/Footer.js',

			BASE_URL + 'assets/gen.js/Sidebar.js',
			BASE_URL + 'assets/gen.js/Header.js',
			BASE_URL + 'assets/gen.js/Signin.js',
			BASE_URL + 'assets/gen.js/Account.js',
			BASE_URL + 'assets/gen.js/Profile.js',
			BASE_URL + 'assets/gen.js/Info.js',
			BASE_URL + 'assets/gen.js/NotifMessage.js',
			BASE_URL + 'assets/gen.js/Notif.js',
			BASE_URL + 'assets/gen.js/CreateAccount.js',
			BASE_URL + 'assets/gen.js/NotFound.js',
			BASE_URL + 'assets/gen.js/Offline.js',
			BASE_URL + 'assets/gen.js/Terms.js',
			BASE_URL + 'assets/gen.js/EmailVerification.js',


			BASE_URL + 'assets/gen.js/Scrollbar.js'

			// BASE_URL + 'lanterlite.gen.js',
		]
		LGen.func.recursive_js_import(js_list, 0, function() {
			// LGen.translator.set()

			console.log('ArrayMan')
			LGen.load_finished = true
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