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

		compo.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="signin theme bgclr2">'+
			  '<form>'+
					'<input class="std gold email theme fp" autocomplete="username" placeholder="email"/>'+
					'<input class="std gold password theme fp" autocomplete="current-password" type="password" placeholder="password"/>'+
			  '</form>'+
				compo.see_password.screen.outerHTML+
				'<button class="std gold signin_btn theme fp bgclr1 hover1">'+'Sign in'+'</button>'+
				'<button class="std gold create_btn theme fp bgclr1 hover1">'+'Create'+'</button>'+
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

		compo.bg = LGen.call({'c':'str', 'f':'to_elm'})('<div class="bg dark">'+'</div>')

		LGen.Page.screen.appendChild(compo.screen)
		LGen.Page.screen.appendChild(compo.bg)

		LGen.Page.init(compo)
		$(compo.screen).css({'opacity':0})
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

		LGen.set_button(compo.screen.querySelector('.create_btn'))
		LGen.set_button_click(compo.screen.querySelector('.create_btn'), function() {
			LGen.component.create_account.previous_page = LGen.Page.current;
			compo.close()
			LGen.Page.change('create_account')
		})
		
		LGen.set_button(compo.screen.querySelector('.signin_btn'))
		LGen.set_button_click(compo.screen.querySelector('.signin_btn'), function() {
			var go = true

			if (LGen.component.header.acc.login_times >= 3) {
				go = false
				compo.close()
				LGen.call({'c':'elm','f':'clear_childs'})(compo.screen)
				var _str = LGen.translator.get({
					"from_lang":"en",
					"lang":LGen.citizen.get({'key':'lang','safe':'safe'}),
					"title_case":false,
					"words":"You have reached login attempt limit."
				})
				LGen.component.snackbar.open({'str':_str})
			}

			if (compo.screen.querySelector('.email').value === '') {
				go = false
				var _str = LGen.translator.get({
					"from_lang":"en",
					"lang":LGen.citizen.get({'key':'lang','safe':'safe'}),
					"title_case":false,"words":"Email is Empty."
				})
				LGen.component.snackbar.open({'str':_str})
			}

			if (!LGen.call({'c':'gen','f':'email_validated'})(compo.screen.querySelector('.email').value)) {
				go = false
				var _str = LGen.translator.get({
					"from_lang":"en",
					"lang":LGen.citizen.get({'key':'lang','safe':'safe'}),
					"title_case":false,"words":"Email is invalid."
				})
				LGen.component.snackbar.open({'str':_str})
			}

			if (compo.screen.querySelector('.password').value === '') {
				go = false
				var _str = LGen.translator.get({
					"from_lang":"en",
					"lang":LGen.citizen.get({'key':'lang','safe':'safe'}),
					"title_case":false,"words":"Password is Empty."
				})
				LGen.component.snackbar.open({'str':_str})
			}

			if (go) {
				var _obj = {
					"json": {'val':{
				    "keep_signin": compo.keep_signin.checked(),
				    "email": compo.screen.querySelector('.email').value.toLowerCase(),
				    "password": LGen.call({'c':'gen','f':'lhash'})(compo.screen.querySelector('.password').value)
					}},
					"func": "$citizen->login"
				}
				lprint(_obj)
				if (LGen.app.get({'safe':'safe'}).platform === 'mob') {
					_obj.json.val.ship_id = device.uuid	
				}
				LGen.call({'c':'req','f':'post'})(LGen.system.get({'safe':'safe'}).citizen_domain+'/gate', _obj, function(obj){
					if (obj === 'wrong email or password') {
						LGen.component.header.acc.login_times += 1
					}

					if (LGen.component.header.acc.login_times >= 3) {
						compo.close()
						LGen.component.captcha.when_solved = function() {
							LGen.component.header.acc.login_times = 0;
						}
						LGen.component.captcha.previous_page = LGen.Page.current
						LGen.Page.change('captcha')
						// LGen.call({'c':'elm','f':'clear_childs'})(compo.screen)
						var _str = LGen.translator.get({
							"from_lang":"en",
							"lang":LGen.citizen.get({'key':'lang','safe':'safe'}),
							"title_case":false,
							"words":"You have reached login attempt limit."
						})
						LGen.component.snackbar.open({'str':_str})
					}
					else if (obj === 'wrong email or password') {
						var _str = LGen.translator.get({
							"from_lang":"en",
							"lang":LGen.citizen.get({'key':'lang','safe':'safe'}),
							"title_case":false,
							"words":"Sign in failed. Please check again your email and password."
						})
						LGen.component.snackbar.open({'str':_str})
					}
					else if (obj === 'account is unregistered') {
						var _str = LGen.translator.get({
							"from_lang":"en",
							"lang":LGen.citizen.get({'key':'lang','safe':'safe'}),
							"title_case":false,
							"words":"account is unregistered."
						})
						LGen.component.snackbar.open({'str':_str})
					}
					else {
						if (compo.keep_signin.checked())
							LGen.storage.setItem('citizen', obj)
						// lprint(obj)
						LGen.citizen.set_all({'val':obj,'safe':'safe'})
						// LGen.Page.Self.update(LGen.component.header)
						// LGen.Page.Self.update(LGen.Page.names[LGen.Page.current])
						compo.close()
					}
				})
			}
		})
	}

	this.update = update
	function update() {
		var compo = LGen.component.signin
		LGen.Page.Self.update(compo)
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
			$(compo.screen).css({'opacity':1})
			$(compo.screen).addClass("opened")
			$(compo.bg).fadeIn(250)
			LGen.call({'c':'gen','f':'disable_canvas_scroll'})();
			function f() {
				compo.screen.querySelector('.email').focus()
		    if( !$(compo.screen.querySelector('.email')).is(':focus') )
	        setTimeout( f, 500 );
			}
			f();

		}
	}

	this.close = close
	function close() {
		var compo = LGen.component.signin
    compo.screen.querySelector('.email').value = ''
    compo.screen.querySelector('.password').value = ''
		if ($(compo.screen).hasClass("opened")) {
			$(compo.screen).fadeOut(0)
			$(compo.screen).css({'opacity':0})
			$(compo.screen).removeClass("opened")
			$(compo.bg).fadeOut(250)
			LGen.call({'c':'gen','f':'enable_canvas_scroll'})();
		}
	}
}