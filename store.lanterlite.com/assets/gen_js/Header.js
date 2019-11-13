LGen.component.header = new header()
LGen.component.header.set()

function header() {
	this.keep_closed = false

	this.set = set
	function set() {
		var compo = LGen.component.header
		compo.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div id="header" class="header theme fp bgclr1">'+
			'<div class="h_top theme"></div>'+
			'<div class="h_bottom theme"></div>'+
			// '<div id="header" class="header opened theme_font theme_color bgclr1">'+
			// '<div id="header" class="header opened ">'+
			'</div>'
		)
		compo.lang_elms = []
		LGen.Page.set_keys(compo)
		LGen.Page.screen.appendChild(compo.screen)
		compo.update()
	}

	this.show_hide_bottom = function (elm) {
		var compo = LGen.component.header
		if (parseInt($(LGen.component.header.screen.querySelector('.h_bottom')).css('opacity')) === 0)
			$(LGen.component.header.screen.querySelector('.h_bottom')).css({'opacity':1})
		else
			$(LGen.component.header.screen.querySelector('.h_bottom')).css({'opacity':0})
	}

	this.set_bottom = function (elm) {
		var compo = LGen.component.header
		compo.clear_bottom()
		compo.screen.querySelector('.h_bottom').appendChild(elm)
	}

	this.clear_bottom = function (elm) {
		var compo = LGen.component.header
		LGen.call({'c':'elm','f':'clear_childs'})(compo.screen.querySelector('.h_bottom'))
	}

	this.update = update
	function update() {
		var compo = LGen.component.header

		LGen.Page.Self.update(compo)
		// LGen.Page.Self.update_color(compo)
		// LGen.Page.Self.update_font(compo)
		// LGen.Page.Self.update(compo)
		if (compo.srcbar.hasOwnProperty('screen'))
			compo.srcbar.update()
	}

	this.open = open
	function open() {
		var compo = LGen.component.header
		if (!compo.keep_closed && !$(compo.screen).hasClass("opened")) {
				// lprint('open')
			$(compo.screen).addClass("opened")
		}
	}

	this.close = close
	function close() {
		var compo = LGen.component.header
		if ($(compo.screen).hasClass("opened"))
			$(compo.screen).removeClass("opened")
	}

	this.hide = hide
	function hide(speed) {
		var compo = LGen.component.header
		compo.close()
		compo.keep_closed = true
		// $(compo.screen).fadeOut(speed)
	}

	this.show = show
	function show(speed) {
		var compo = LGen.component.header
		compo.keep_closed = false
		compo.open()
	}

	this.add = function (obj) {
		var compo = LGen.component.header
		var logo = LGen.call({'c':'str', 'f':'to_elm'})(LGen.icon.obj[obj.icon])
		$(logo).addClass('img '+obj.id)

		var _screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="add '+obj.id+'">'+
			// '<div class="add">'+
				logo.outerHTML+
			'</div>'
		)
		_screen.querySelector('.img').addEventListener('click', function() {
			obj.func()
		})
		// var logo = compo.querySelector('.add .'+obj.id)
		compo.screen.querySelector('.h_top').appendChild(_screen)
	}

	this.logo = new logo()
	function logo() {

		this.set = set
		function set() {
			var compo = LGen.component.header
			compo.logo.screen = LGen.call({'c':'str', 'f':'to_elm'})(
				'<div class="theme logo">'+
					LGen.app.get({'safe':'safe'}).fullname+
					// '<img src="'+HOME_URL + "app/app.webp"+'"/>'+
				'</div>'
			)
			LGen.set_button_click(compo.logo.screen, function() {
				LGen.component.sidebar.open()
				// compo.logo.screen.addEventListener('click', function() {LGen.component.sidebar.open()})
			})
			compo.screen.querySelector('.h_top').appendChild(compo.logo.screen)
		}

		this.hide = hide
		function hide() {
			var compo = LGen.component.header
			$(compo.logo.screen).fadeOut()
		}

		this.show = show
		function show() {
			var compo = LGen.component.header
			$(compo.logo.screen).fadeIn()
		}

	}

	this.menu = new menu()
	function menu() {
		this.set = set

		function set() {
			var compo = LGen.component.header
			compo.menu.screen = LGen.call({'c':'str', 'f':'to_elm'})(
				'<div class="menu">'+
					'<img src="'+BASE_URL + 'assets/gen_base_fe/sidebar.svg'+'"/>'+
				'</div>'
			)
			compo.menu.screen.addEventListener('click', function() {LGen.component.sidebar.open()})
			compo.screen.appendChild(compo.menu.screen)
		}
	}

	this.srcbar = new srcbar()
	function srcbar() {
		this.set = set

		function set() {
			var compo = LGen.component.header
			compo.srcbar.screen =  LGen.call({'c':'str', 'f':'to_elm'})(
				'<div class="srcbar">'+
					'<input value="" placeholder="" class="theme point2 color2"/>'+
					'<img class="icon" src="'+BASE_URL + 'assets/gen_base_fe/src.svg'+'"/>'+
				'</div>'
			)
			LGen.Page.set_keys(compo.srcbar)
			compo.screen.appendChild(compo.srcbar.screen)
			compo.srcbar.update()
		}

		this.update = update
		function update() {
			var compo = LGen.component.header

			// LGen.Page.Self.update_css(compo.srcbar)
			LGen.Page.Self.update_color(compo.srcbar)
			LGen.Page.Self.update_font(compo.srcbar)
		}
	}

	this.acc = new acc()
	function acc() {
		this.set = set
		this.login_times = 0

		function set () {
			var compo = LGen.component.header
			var elm = LGen.call({'c':'str', 'f':'to_elm'})(LGen.icon.obj.user)
			$(elm).addClass('img')
			compo.acc.screen = LGen.call({'c':'str', 'f':'to_elm'})(
				'<div class="acc">'+
					elm.outerHTML+
					// '<img/>'+
				'</div>'
			)
			// lprint(LGen.citizen.get({'key':'id','safe':'safe'}) !== '')

			// this.screen.querySelector('img').src = src= BASE_URL + 'assets/gen_base_fe/user.svg'
			if (LGen.citizen.get({'key':'id','safe':'safe'}) !== '')
				$(compo.acc.screen.querySelector('.img')).addClass('active')
			else
				$(compo.acc.screen.querySelector('.img')).removeClass('active')

			compo.acc.screen.querySelector('.img').addEventListener('click', function() {
				if (LGen.citizen.get({'key':'id','safe':'safe'}) !== '')
					LGen.component.account.open()
				else {
					var _str = {
						"from_lang":"en",
						"lang":LGen.citizen.get({'key':'lang','safe':'safe'}),
						"words":"You have reached login attempt limit."
					}
					if (compo.acc.login_times < 3)
						LGen.component.signin.open()
					else {
						LGen.component.captcha.when_solved = function() {
							LGen.component.header.acc.login_times = 0;
						}
						LGen.component.captcha.previous_page = LGen.Page.current
						LGen.Page.change('captcha')
					}
					// else if (LGen.app.get({'safe':'safe'}).platform === 'mob') {
					// 	_str['words'] = 'Please restart app to login.'
					// 	LGen.component.snackbar.open({'str':LGen.translator.get(_str)})
					// }
					// else if (LGen.app.get({'safe':'safe'}).platform === 'des') {
					// 	_str['words'] = 'Please restart app to login.'
					// 	LGen.component.snackbar.open({'str':LGen.translator.get(_str)})
					// }
					// else if (LGen.app.get({'safe':'safe'}).platform === 'web') {
					// 	_str['words'] = 'Please refresh page to login.'
					// 	LGen.component.snackbar.open({'str':LGen.translator.get(_str)})
					// }
				}
			})
			compo.screen.querySelector('.h_top').appendChild(compo.acc.screen)
		}
	}

	// this.scrollPos = 0;
	this.hide_when_scroll2 = hide_when_scroll2
	function hide_when_scroll2(screen) {
		var compo = LGen.component.header
		var compo_footbar = LGen.component.footbar
		// if (false) {
		if (LGen.app.get({'safe':'safe'}).platform !== 'mob') {
			$(screen).mCustomScrollbar({
				// autoHideScrollbar:true,
				// autoExpandScrollbar:true,
				// advanced: {
				// 	updateOnContentResize : true
				// },
				theme:"minimal-dark",
				// theme:"dark-thin",
		    callbacks:{
	        whileScrolling:function(){
						if (this.scrollPos === undefined)
							this.scrollPos = this.mcs.top
						if ((this.scrollPos - this.mcs.top) > 50) {
					    compo.close()
					    compo_footbar.close()
							this.scrollPos = this.mcs.top
						}
						else if ((this.scrollPos - this.mcs.top) < -50) {
					    compo.open()
					    compo_footbar.open()
							this.scrollPos = this.mcs.top
						}
	        	// lprint(this.mcs.top)
	        }
		    }
			});
		}
		else {
			screen.addEventListener("scroll", function() {
				// lprint($(this).scrollTop())
				// lprint('this.scrollPos', this.scrollPos)
				// lprint('$(this).scrollTop())', $(this).scrollTop())
				if (this.scrollPos === undefined)
					this.scrollPos = $(this).scrollTop()
				if ((this.scrollPos - $(this).scrollTop()) > 50) {
			    compo.open()
			    compo_footbar.open()
					this.scrollPos = $(this).scrollTop()
				}
				else if ((this.scrollPos - $(this).scrollTop()) < -50) {
					// lprint('close')
			    compo.close()
			    compo_footbar.close()
					this.scrollPos = $(this).scrollTop()
				}
			});
		}
	}

	this.hide_when_scroll = hide_when_scroll
	function hide_when_scroll(screen) {
		var compo = LGen.component.header
		var compo_footbar = LGen.component.footbar
		screen.addEventListener("scroll", function() {
			// lprint($(this).scrollTop())
			// lprint('this.scrollPos', this.scrollPos)
			// lprint('$(this).scrollTop())', $(this).scrollTop())
			if (this.scrollPos === undefined)
				this.scrollPos = $(this).scrollTop()
			if ((this.scrollPos - $(this).scrollTop()) > 50) {
		    compo.open()
		    compo_footbar.open()
				this.scrollPos = $(this).scrollTop()
			}
			else if ((this.scrollPos - $(this).scrollTop()) < -50) {
				// lprint('close')
		    compo.close()
		    compo_footbar.close()
				this.scrollPos = $(this).scrollTop()
			}
		});

		// $(screen).scroll(function() {
		// 	// lprint('this.scrollPos', this.scrollPos)
		// 	// lprint('$(this).scrollTop())', $(this).scrollTop())
		// 	if (this.scrollPos === undefined)
		// 		this.scrollPos = $(this).scrollTop()
		// 	if ((this.scrollPos - $(this).scrollTop()) > 50) {
		//     compo.open()
		//     compo_footbar.open()
		// 		this.scrollPos = $(this).scrollTop()
		// 	}
		// 	else if ((this.scrollPos - $(this).scrollTop()) < -50) {
		// 		// lprint('close')
		//     compo.close()
		//     compo_footbar.close()
		// 		this.scrollPos = $(this).scrollTop()
		// 	}
		// });
	}

	this.hide_when_scroll_on = hide_when_scroll_on
	function hide_when_scroll_on() {
		var compo = LGen.component.header
		var compo_footbar = LGen.component.footbar
		if (LGen.call({'c':'gen','f':'is_mobile'})()) {
			$(window).scroll(function() {
					// lprint('asda')
				// lprint('this.scrollPos', this.scrollPos)
				// lprint('$(this).scrollTop())', $(this).scrollTop())
				if (this.scrollPos === undefined)
					this.scrollPos = $(this).scrollTop()
				if ((this.scrollPos - $(this).scrollTop()) > 50) {
					// lprint('open')
			    compo.open()
			    compo_footbar.open()
					this.scrollPos = $(this).scrollTop()
				}
				else if ((this.scrollPos - $(this).scrollTop()) < -50) {
					// lprint('close')
			    compo.close()
			    compo_footbar.close()
					this.scrollPos = $(this).scrollTop()
				}
			});
		}
		else {
			$(document.querySelector('.ss-content')).scroll(function() {
				// lprint('this.scrollPos', this.scrollPos)
				// lprint('$(this).scrollTop())', $(this).scrollTop())
				if (this.scrollPos === undefined)
					this.scrollPos = $(this).scrollTop()
				if ((this.scrollPos - $(this).scrollTop()) > 50) {
			    compo.open()
			    compo_footbar.open()
					this.scrollPos = $(this).scrollTop()
				}
				else if ((this.scrollPos - $(this).scrollTop()) < -50) {
			    compo.close()
			    compo_footbar.close()
					this.scrollPos = $(this).scrollTop()
				}
			});
		}
	}
}
