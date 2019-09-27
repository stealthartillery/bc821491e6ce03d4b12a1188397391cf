LGen.component.header = new header()
LGen.component.header.set()

function header() {

	this.set = set
	function set() {
		var compo = LGen.component.header
		compo.screen = LGen.String.to_elm(
			'<div id="header" class="header opened theme theme_font theme_color bgclr1">'+
			'</div>'
		)
		compo.lang_elms = []
		LGen.Page.set_keys(compo)
		LGen.Page.screen.appendChild(compo.screen)
		compo.update()
	}

	this.update = update
	function update() {
		var compo = LGen.component.header

		LGen.Page.Self.update_css(compo)
		LGen.Page.Self.update_color(compo)
		LGen.Page.Self.update_font(compo)
		if (compo.srcbar.hasOwnProperty('screen'))
			compo.srcbar.update()
	}

	this.open = open
	function open() {
		var compo = LGen.component.header
		if (!$(compo.screen).hasClass("opened"))
			$(compo.screen).addClass("opened")
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
		$(compo.screen).fadeOut(speed)
	}

	this.show = show
	function show(speed) {
		var compo = LGen.component.header
		$(compo.screen).slideDown(speed)
	}

	this.logo = new logo()
	function logo() {

		this.set = set
		function set() {
			var compo = LGen.component.header
			compo.logo.screen = LGen.String.to_elm(
				'<div class="logo">'+
					'<img src="'+HOME_URL + "app/app.webp"+'"/>'+
				'</div>'
			)
			compo.screen.appendChild(compo.logo.screen)
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
			compo.menu.screen = LGen.String.to_elm(
				'<div class="menu">'+
					'<img src="'+BASE_URL + 'assets/gen.base.fe/sidebar.svg'+'"/>'+
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
			compo.srcbar.screen =  LGen.String.to_elm(
				'<div class="srcbar">'+
					'<input value="" placeholder="" class="theme theme_font theme_color point2 color2"/>'+
					'<img class="icon" src="'+BASE_URL + 'assets/gen.base.fe/src.svg'+'"/>'+
				'</div>'
			)
			LGen.Page.set_keys(compo.srcbar)
			compo.screen.appendChild(compo.srcbar.screen)
			compo.srcbar.update()
		}

		this.update = update
		function update() {
			var compo = LGen.component.header

			LGen.Page.Self.update_css(compo.srcbar)
			LGen.Page.Self.update_color(compo.srcbar)
			LGen.Page.Self.update_font(compo.srcbar)
		}
	}

	this.acc = new acc()
	function acc() {
		this.set = set

		function set () {
			var compo = LGen.component.header
			var elm = LGen.String.to_elm(I.obj.user)
			$(elm).addClass('img')
			compo.acc.screen = LGen.String.to_elm(
				'<div class="acc">'+
					elm.outerHTML+
					// '<img/>'+
				'</div>'
			)
			lprint(LGen.citizen.id !== '')

			// this.screen.querySelector('img').src = src= BASE_URL + 'assets/gen.base.fe/user.svg'
			if (LGen.citizen.id !== '')
				$(compo.acc.screen.querySelector('.img')).addClass('active')
			else
				$(compo.acc.screen.querySelector('.img')).removeClass('active')

			compo.acc.screen.querySelector('.img').addEventListener('click', function() {
				if (LGen.citizen.id !== '')
					LGen.component.account.open()
				else 
					LGen.component.signin.open()
			})
			compo.screen.appendChild(compo.acc.screen)
		}
	}

	// this.scrollPos = 0;
	this.hide_when_scroll_on = hide_when_scroll_on
	function hide_when_scroll_on() {
		var compo = LGen.component.header
		if (LGen.f.is_mobile()) {
			$(window).scroll(function() {
				// lprint('this.scrollPos', this.scrollPos)
				// lprint('$(this).scrollTop())', $(this).scrollTop())
				if (this.scrollPos === undefined)
					this.scrollPos = $(this).scrollTop()
				if ((this.scrollPos - $(this).scrollTop()) > 50) {
			    compo.open()
					this.scrollPos = $(this).scrollTop()
				}
				else if ((this.scrollPos - $(this).scrollTop()) < -50) {
			    compo.close()
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
					this.scrollPos = $(this).scrollTop()
				}
				else if ((this.scrollPos - $(this).scrollTop()) < -50) {
			    compo.close()
					this.scrollPos = $(this).scrollTop()
				}
			});
		}
	}
}
