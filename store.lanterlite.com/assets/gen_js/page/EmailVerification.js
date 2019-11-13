
LGen.component.email_verification = new function () {
	this.name = 'email_verification'

	this.set = set
	function set () {
		var page = LGen.component.email_verification
		page.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="email_verification theme fp" style="display: none;">'+
			'<div class="bground">'+
			'<div class="content">'+
				'<div class="title theme fttl">'+'Verify Email'+'</div>'+
				'<div class="child please_check theme fp">'+'please check your email and type the verification code here to verify your email.'+'</div>'+
				'<div class="child verification_code theme_color">'+'<input class="std gold">'+'</div>'+
				'<button class="std gold verify_btn theme fp bgclr1 hover1">'+'Confirm'+'</button>'+
				'<button class="std gold back_btn theme fp bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.bground .title')},
			{"elm":page.screen.querySelector('.bground .please_check')},
			{"elm":page.screen.querySelector('.bground .verify_btn')},
			{"elm":page.screen.querySelector('.bground .back_btn')}
		]
		page.set_event()
		LGen.Page.init(page)
		LGen.component.header.hide_when_scroll2(page.screen.querySelector('.bground'))
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.email_verification
		LGen.set_button(page.screen.querySelector('.back_btn'))
		LGen.set_button_click(page.screen.querySelector('.back_btn'), function() {
			LGen.Page.change(page.previous_page)
		})
		LGen.call({'c':'elm','f':'input'}).to_alphanum(page.screen.querySelector('.verification_code input'))

		LGen.set_button(page.screen.querySelector('.verify_btn'))
		LGen.set_button_click(page.screen.querySelector('.verify_btn'), function() {
			var _obj = {
				"json": {
					"id": LGen.citizen.get({'key':'id','safe':'safe'}),
					"verification_code": page.screen.querySelector('.verification_code input').value.toUpperCase()
				},
				"func": '$citizen->verify_code'
			}
			LGen.call({'c':'req','f':'post'})(LGen.system.get({'safe':'safe'}).be_domain+'/gate', _obj, function(obj){
				// lprint(obj)
				if (obj === true) {
					LGen.citizen.set_all({'val':{'is_verified': 1},'safe':'safe'})
					LGen.Page.change('page_home')
				}
				else {
					var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.get({'key':'lang','safe':'safe'}),"title_case":false,"words":"Verification code is incorrect." })
					LGen.component.snackbar.open({'str':_str})
				}
			})
		})
	}

	this.update = update
	function update() {
		var page = LGen.component.email_verification
		LGen.Page.Self.update(page)
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
		LGen.component.footbar.hide()
		LGen.component.header.show()
	}
}

LGen.component.email_verification.set()
