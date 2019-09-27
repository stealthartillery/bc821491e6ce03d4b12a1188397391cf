LGen.component.signin = new Signin()
LGen.component.signin.set()

function Signin () {

	this.set = set
	function set () {
		var compo = LGen.component.signin

		compo.see_password = new LGen.component.checkbox()
		$(compo.see_password.screen).addClass('see_password')
		compo.see_password.title('See Password.')

		compo.keep_signin = new LGen.component.checkbox()
		$(compo.keep_signin.screen).addClass('keep_signin')
		compo.keep_signin.title('Keep Signed In.')

		compo.screen = LGen.String.to_elm(
			'<div class="signin theme theme_font theme_color bgclr2">'+
				'<input class="std gold email theme theme_font" placeholder="email"/>'+
				'<input class="std gold password theme theme_font" type="password" placeholder="password"/>'+
				compo.see_password.screen.outerHTML+
				'<button class="std gold signin_btn theme theme_font theme_color bgclr1 hover1">'+'Sign in'+'</button>'+
				'<button class="std gold create_btn theme theme_font theme_color bgclr1 hover1">'+'Create'+'</button>'+
				compo.keep_signin.screen.outerHTML+
			'</div>'
		)
		compo.see_password.screen = compo.screen.querySelector('.see_password')
		compo.keep_signin.screen = compo.screen.querySelector('.keep_signin')

		compo.lang_elms = [
			{"elm":compo.screen.querySelector('.email'), "type":"placeholder"},
			{"elm":compo.screen.querySelector('.password'), "type":"placeholder"},
			{"elm":compo.screen.querySelector('.signin_btn')},
			{"elm":compo.screen.querySelector('.create_btn')},
			{"elm":compo.screen.querySelector('.see_password .title')},
			{"elm":compo.screen.querySelector('.keep_signin .title')},
		]

		compo.bg = LGen.String.to_elm('<div class="bg dark">'+'</div>')

		LGen.Page.screen.appendChild(compo.screen)
		LGen.Page.screen.appendChild(compo.bg)

		LGen.Page.set_keys(compo)
		compo.update()
		compo.set_event()
	}

	this.set_event = set_event
	function set_event() {
		var compo = LGen.component.signin

		compo.screen.querySelector('.email').addEventListener('keydown', function(e) {
	    var keypressed = e.which
	    if (keypressed === 13)
	    	$(compo.screen.querySelector('.password')).focus()
		})

		compo.screen.querySelector('.password').addEventListener('keydown', function(e) {
	    var keypressed = e.which
	    if (keypressed === 13)
	    	$(compo.screen.querySelector('.signin_btn')).click()
		})

		compo.keep_signin.click()
		compo.see_password.click(function() {
			$(compo.screen.querySelector('.password')).removeAttr('type')
		}, function() {
			$(compo.screen.querySelector('.password')).attr("type","password");
		})

		compo.bg.addEventListener('click', function() {
			if (!$(compo.screen).hasClass('opened'))
				compo.open()
			else
				compo.close()
		})

		compo.screen.querySelector('.create_btn').addEventListener('click', function() {
			LGen.component.create_account.previous_page = LGen.Page.current;
			compo.close()
			LGen.Page.change('create_account')
		})
		
		compo.screen.querySelector('.signin_btn').addEventListener('click', function() {
			var go = true
			if (compo.screen.querySelector('.email').value === '') {
				go = false
				var _str = LGen.translator.get({
					"from_lang":"en",
					"lang":LGen.citizen.lang,
					"title_case":false,"words":"Email is Empty."
				})
				LGen.component.snackbar.open({'str':_str})
			}

			if (!LGen.f.email_validated(compo.screen.querySelector('.email').value)) {
				go = false
				var _str = LGen.translator.get({
					"from_lang":"en",
					"lang":LGen.citizen.lang,
					"title_case":false,"words":"Email is invalid."
				})
				LGen.component.snackbar.open({'str':_str})
			}

			if (compo.screen.querySelector('.password').value === '') {
				go = false
				var _str = LGen.translator.get({
					"from_lang":"en",
					"lang":LGen.citizen.lang,
					"title_case":false,"words":"Password is Empty."
				})
				LGen.component.snackbar.open({'str':_str})
			}

			if (go) {
				var _obj = {
					"json": {'gate':'savior', 'val':{
				    "keep_signin": compo.keep_signin.checked(),
				    "email": compo.screen.querySelector('.email').value.toLowerCase(),
				    "password": LGen.f.lhash(compo.screen.querySelector('.password').value)
					}},
					"func": "$citizen->login"
				}
				LGen.f.send_post(LGen.system.be_domain+'/citizen', _obj, function(obj){
					if (obj === 'wrong email or password') {
						var _str = LGen.translator.get({
							"from_lang":"en",
							"lang":LGen.citizen.lang,
							"title_case":false,
							"words":"Sign in failed. Please check again your email and password."
						})
						LGen.component.snackbar.open({'str':_str})
					}
					else if (obj === 'account is unregistered') {
						var _str = LGen.translator.get({
							"from_lang":"en",
							"lang":LGen.citizen.lang,
							"title_case":false,
							"words":"account is unregistered."
						})
						LGen.component.snackbar.open({'str':_str})
					}
					else {
						LGen.citizen.set(obj)
						compo.close()
					}
				})
			}
		})
	}

	this.update = update
	function update () {
		var compo = LGen.component.signin
		LGen.Page.Self.update_css(compo)
		LGen.Page.Self.update_lang(compo)
		LGen.Page.Self.update_font(compo)
		LGen.Page.Self.update_color(compo)
	}

	this.opened = opened
	function opened() {
		var compo = LGen.component.signin
		return $(compo.screen).hasClass('opened')
	}

	this.open = open
	function open() {
		var compo = LGen.component.signin
		if (!$(compo.screen).hasClass("opened")) {
			$(compo.screen).fadeIn(0)
			$(compo.screen).addClass("opened")
			$(compo.bg).fadeIn(250)
			disable_canvas_scroll();
		}
	}

	this.close = close
	function close() {
		var compo = LGen.component.signin
    compo.screen.querySelector('.email').value = ''
    compo.screen.querySelector('.password').value = ''
		if ($(compo.screen).hasClass("opened")) {
			$(compo.screen).fadeOut(0)
			$(compo.screen).removeClass("opened")
			$(compo.bg).fadeOut(250)
			enable_canvas_scroll();
		}
	}
}