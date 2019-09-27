
$.ajax({
  type: "GET",
  url: HOME_URL+'app/app.lgen',
  contentType: "application/json;",
  dataType: "json",
  success: function(obj) {
		LGen.app = {}
		var keys = Object.keys(obj)
		for (var i=0; i<keys.length; i++) {
			LGen.app[keys[i]] = obj[keys[i]]
		}
		LGen.system.set()
		load_component()
  },
  error: function(e) {  print(e); }
});  

function load_component() {
	LGen.f.recursive_js_import([
		BASE_URL + 'assets/gen.base.fe/lanterlite.icon.js',
		BASE_URL + 'assets/gen.js/SplashScreen.js'
	], 0, function() {
		
		splash = new SplashScreen()
		splash.set()
	  setTimeout( function(){ splash.open() }, 100 );

		LGen.f.recursive_js_import([
			BASE_URL + 'assets/gen.js/ComponentLoader.js'
		], 0, function() { 
			load_init_by_interval() 
		})
	})
}

function load_init() {
	LGen.func.recursive_js_import([
		HOME_URL + 'app/init.js'
	], 0, function() {
		LGen.start()
  	if (LGen.app.status === 'dep') {
  		lprint = function() {}
  	}
	  setTimeout( function(){
			splash.close()
			$(LGen.Page.screen).slideDown(250)
		  // setTimeout( function(){
				// $(LGen.Page.screen).fadeIn(0)
		  // }, 1000 );
	  }, 2500 );
	})
}

function load_init_by_interval() {
  setTimeout( function(){
	if (LGen.load_finished) {
		load_init()
	}
	else
		load_init_by_interval()
  }, 500 );
}