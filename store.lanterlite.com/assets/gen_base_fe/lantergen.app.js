$.ajax({
  type: "GET",
  url: HOME_URL+'app/app.lgen',
  contentType: "application/json;",
  dataType: "json",
  success: function(obj) {
		if (!LGen.call({'c':'black','f':'check'})({'val':obj,'safe':'safe'}))
			obj = LGen.call({'c':'black','f':'get'})({'val':obj,'safe':'safe'})
		// lprint(obj)
		LGen.app.obj = obj
		// var keys = Object.keys(obj)
		// for (var i=0; i<keys.length; i++) {
		// 	LGen.app.get({'safe':'safe'})[keys[i]] = obj[keys[i]]
		// }
		LGen.system.set()
		load_component()
  },
  error: function(e) {  print(e); }
});  

function load_component() {
	// lprint(LGen)
	LGen.call({'c':'gen','f':'recursive_js_import'})([
		BASE_URL+'assets/gen_js/manager/StringMan.js',
		BASE_URL+'assets/gen_base_fe/lantergen.icon.js',
		BASE_URL+'assets/gen_js/page/SplashScreen.js'
	], 0, function() {
		function asdasd() {
		  setTimeout( function(){ 
				LGen.component.splash.open()
			  // setTimeout( function(){ 
					LGen.call({'c':'gen','f':'recursive_js_import'})([
						BASE_URL + 'assets/gen_js/ComponentLoader.js'
					], 0, function() { 
					})
					// asdasd()
			  // }, 500 );
		  }, 100 );
		}
		asdasd()
	})
}

function load_init() {
	LGen.call({'c':'gen','f':'recursive_js_import'})([
		BASE_URL + 'assets/gen_base_fe/lantergen.init.js'
	], 0, function() {
		LGen.start()
  	if (LGen.app.get({'safe':'safe'}).status === 'dep' && !LGen.hasOwnProperty('test')) {
  		// lprint = function() {}
  	}
	  // setTimeout( function(){
			$(document.body).css({'background-color':'white'})
			$(LGen.Page.screen).fadeIn(0)
		  // setTimeout( function(){
				// $(LGen.Page.screen).fadeIn(0)
		  // }, 1000 );
	  // }, 2500 );
	})
}

// function load_init_by_interval() {
//   setTimeout( function(){
// 		if (LGen.load_finished)
// 			load_init()
// 		else
// 			load_init_by_interval()
//   }, 500 );
// }