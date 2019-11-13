LGen.component.splash = new SplashScreen()
LGen.component.splash.set()

/* ========================================
SPLASH SCREEN
======================================== */
function SplashScreen() {
	this.set = set
	function set() {
		this.screen = LGen.call({'c':'str', 'f':'to_elm'})('<div class="splash theme_bgclr_main1 hide" id="splash">'+
		// this.screen = LGen.call({'c':'str', 'f':'to_elm'})('<div class="splash theme_bgclr_main1" style="display: none;" id="splash">'+
		'</div>')
		// var logo = '<div id="bg_loader"> <div id="loader"> <svg class="loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 46 33"> <g stroke-width="1" fill="none" fill-rule="evenodd"> </g> </svg> </div> </div>'

		// if (LGen.app.get({'safe':'safe'}).platform !== 'mob') {
			var asd = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div>'+
				LGen.icon.obj.lanterlite+
				// '<div class="logo" style="background: url(' + LGen.system.get({'safe':'safe'}).base_url + 'assets/lite.img/goldenrod.svg) center center / 100% 100% no-repeat; width: 50px; height: 50px; margin-right: 5px; display: inline-block; vertical-align: middle;" >'+'</div>'+
				'<div class="text">'+LGen.app.get({'safe':'safe'}).name+'</div>'+
			'</div>'
			)
			this.screen.appendChild(asd)
		// }
		$('body').append(this.screen)

		// logo = LGen.call({'c':'str', 'f':'to_elm'})(logo)
		// this.screen = logo
		// logo.childNodes[1].childNodes[1].style = "background-image: url('" + BASE_URL + "assets/lite.img/goldenrod.svg');"
		// document.querySelector('.canvas').appendChild(logo)
	}

	// this.init = init
	// function init(callback) {
	// 	if (callback === undefined) callback = function(){}
	// 	var css_list = [
	// 		LGen.stat.css_dir + 'SplashScreen.css'
	// 	]
	// 	LGen.call({'c':'gen','f':'recursive_css_import'})(css_list, 0, function() {
	// 		callback()
	// 	})
	// }

	this.open = open
	function open() {
		// console.log('open')
		// $(this.screen).slideDown(250)
		// if (LGen.app.get({'safe':'safe'}).platform === 'mob')
		$(LGen.component.splash.screen).addClass('show').removeClass('hide')
		// $(this.screen).fadeIn()
		// $(this.screen)
  //   .css("display", "flex")
  //   .hide()
  //   .fadeIn();
	}

	this.close = close
	function close() {
	  setTimeout( function(){
			$(LGen.component.splash.screen).addClass('hide').removeClass('show')
		}, 500)
		// $(this.screen).slideUp(250)
		// $(this.screen).fadeOut()
	}
}

