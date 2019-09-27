LGen.component.email_verification = new EmailVerification()
LGen.component.email_verification.set()

function EmailVerification () {
	this.name = 'email_verification'

	this.set = set
	function set () {
		var page = LGen.component.email_verification
		page.screen = LGen.String.to_elm(
			'<div class="email_verification theme theme_font" style="display: none;">'+
			'<div class="bground">'+
				'<div class="title theme theme_font">'+'Verify Email'+'</div>'+
				'<div class="child please_check theme theme_font">'+'please check your email and type the verification code here to verify your email.'+'</div>'+
				'<div class="child verification_code theme_color">'+'<input class="std gold">'+'</div>'+
				'<button class="std gold verify_btn theme theme_font theme_color bgclr1 hover1">'+'Confirm'+'</button>'+
				'<button class="std gold back_btn theme theme_font theme_color bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.bground .title')},
			{"elm":page.screen.querySelector('.bground .please_check')},
			{"elm":page.screen.querySelector('.bground .verify_btn')},
			{"elm":page.screen.querySelector('.bground .back_btn')}
		]
		LGen.Page.set_keys(page)
		page.set_event()
		LGen.Page.add(page)
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.email_verification
		page.screen.querySelector('.back_btn').addEventListener('click', function() {
			LGen.Page.change(page.previous_page)
		})
		LGen.Elm.input.to_alphanum(page.screen.querySelector('.verification_code input'))
		page.screen.querySelector('.verify_btn').addEventListener('click', function() {
			var _obj = {
				"json": {
					"id": LGen.citizen.id,
					"verification_code": page.screen.querySelector('.verification_code input').value.toUpperCase()
				},
				"func": '$citizen->verify_code'
			}
			LGen.f.send_post(LGen.system.be_domain+'/citizen', _obj, function(obj){
				lprint(obj)
				if (obj === true) {
					LGen.citizen.is_verified = true
					LGen.Page.change('page_home')
				}
				else {
					var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.lang,"title_case":false,"words":"Verification code is incorrect." })
					LGen.component.snackbar.open({'str':_str})
				}
			})
		})
	}

	this.update = update
	function update() {
		var page = LGen.component.email_verification
		LGen.Page.Self.update_css(page)
		LGen.Page.Self.update_font(page)
		LGen.Page.Self.update_color(page)
		LGen.Page.Self.update_lang(page)
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.email_verification
		LGen.Page.clear_childs(page.screen.querySelector('.email_verification .child'))
		page.previous_page = ''
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.email_verification
		page.update()
	}
}