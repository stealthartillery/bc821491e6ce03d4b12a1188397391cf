LGen.component.create_account = new CreateAccount()
LGen.component.create_account.set()

function CreateAccount () {
	this.name = 'create_account'
	this.url_names = ['register']

	this.set = set
	function set () {
		var page = LGen.component.create_account

		page.see_password = new LGen.component.checkbox()
		$(page.see_password.screen).addClass('see_password')
		page.see_password.title('See Password.')

		page.agree_term = new LGen.component.checkbox()
		$(page.agree_term.screen).addClass('agree_term')
		page.agree_term.title('I agree with Lanterlite Account Privacy and Terms.')

		page.screen_footbar = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="_footbar n1 theme fp">'+
				'<button class="std gold back theme fp bgclr1 hover1">'+LGen.icon.theme('left')+'</button>'+
			'</div>'
		)

		page.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="create_account" style="display: none;">'+
			'<div class="bground">'+
			'<div class="content">'+
				'<div class="top_title title theme fttl">'+'Create Lanterlite Account'+'</div>'+
				'<div class="child username">'+
					'<span class="title theme fp">'+'Username'+'</span>'+
					'<span class="required_star">'+' *'+'</span>'+
					'<input class="std gold val theme fp" value="" placeholder="(4-15 characters.)" maxlength="15"/>'+
				'</div>'+
				'<div class="child fullname">'+
					'<span class="title theme fp">'+'Fullname'+'</span>'+
					'<span class="required_star">'+' *'+'</span>'+
					'<input class="std gold val theme fp" value="" placeholder="(4-50 characters.)" maxlength="50"/>'+
				'</div>'+
				'<form>'+
					'<div class="child email">'+
						'<span class="title theme fp">'+'Email Address'+'</span>'+
						'<span class="required_star">'+' *'+'</span>'+
						'<input class="std gold val theme fp" autocomplete="username" value=""/>'+
					'</div>'+
					'<div class="child password">'+
						'<span class="title theme fp">'+'Password'+'</span>'+
						'<span class="required_star">'+' *'+'</span>'+
						'<input type="password" class="std gold val theme fp" value="" autocomplete="current-password" placeholder="(7-15 chars: min. one number, capitalized letter, lowercase letter, and special char.)"/>'+
					'</div>'+
				'</form>'+
				page.see_password.screen.outerHTML+
				'<div class="child phonenum">'+
					'<span class="title theme fp">'+'Phone Number'+'</span>'+
					'<input class="std gold val theme fp" value=""/>'+
				'</div>'+
				'<div class="child address">'+
					'<span class="title theme fp">'+'Address'+'</span>'+
					'<input class="std gold val theme fp" value=""/>'+
				'</div>'+
				'<div class="child lang">'+
					'<span class="title theme fp">'+'Language'+'</span>'+
					'<div class="val">'+
					'<select class="select theme fp">'+
				    '<option value="id">Indonesia (Bahasa)</option>'+
				    '<option value="en">English</option>'+
					'</select>'+
					'</div>'+
				'</div>'+
				'<div class="child gender">'+
					'<span class="title theme fp">'+'Gender'+'</span>'+
					'<div class="val">'+
					'<select class="select theme fp">'+
				    '<option class="male" value="male">Male</option>'+
				    '<option class="female" value="female">Female</option>'+
					'</select>'+
					'</div>'+
				'</div>'+
				page.agree_term.screen.outerHTML+'<span> (</span>'+'<a class="read std dark theme fp">Read</a>'+'<span>)</span>'+
				'<button class="std gold create_btn theme fp bgclr1 hover1" disabled>'+'Create'+'</button>'+
				// '<button class="std gold back_btn theme fp bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'+
			'</div>'
		)

		page.agree_term.screen = page.screen.querySelector('.agree_term')
		page.see_password.screen = page.screen.querySelector('.see_password')

		page.lang_elms = [
			{"elm":page.screen.querySelector('.top_title')},
			{"elm":page.screen.querySelector('.bground .username .title')},
			{"elm":page.screen.querySelector('.bground .fullname .title')},
			{"elm":page.screen.querySelector('.bground .address .title')},
			{"elm":page.screen.querySelector('.bground .phonenum .title')},
			{"elm":page.screen.querySelector('.bground .email .title')},
			{"elm":page.screen.querySelector('.bground .password .title')},
			{"elm":page.screen.querySelector('.bground .gender .title')},
			{"elm":page.screen.querySelector('.bground .lang .title')},
			{"elm":page.screen.querySelector('.create_btn')},
			// {"elm":page.screen.querySelector('.back_btn')},
			{"elm":page.screen.querySelector('.gender select option.male')},
			{"elm":page.screen.querySelector('.gender select option.female')},
			{"elm":page.screen.querySelector('.username input')},
			{"elm":page.screen.querySelector('.password input')},
			{"elm":page.screen.querySelector('.read')},
			{"elm":page.agree_term.screen.querySelector('.title')},
			{"elm":page.see_password.screen.querySelector('.title')},
		]
		LGen.Page.init(page)
		page.set_event()
		LGen.component.header.hide_when_scroll2(page.screen.querySelector('.bground'))
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.create_account

		LGen.set_button(page.screen_footbar.querySelector('.back'))
		LGen.set_button_click(page.screen_footbar.querySelector('.back'), function() {
			LGen.Page.change(page.previous_page)
		})

		page.agree_term.click(function() {
			$(page.screen.querySelector('.create_btn')).removeAttr('disabled')
		}, function() {
			$(page.screen.querySelector('.create_btn')).attr("disabled","true");
		})

		page.see_password.click(function() {
			$(page.screen.querySelector('.password input')).removeAttr('type')
		}, function() {
			$(page.screen.querySelector('.password input')).attr("type","password");
		})

		$(page.screen.querySelector('.lang select')).change(function(){ 
			LGen.citizen.set_all({'val':{'lang':$(this).val()},'safe':'safe'})
	    // LGen.Page.update('lang',$(this).val());
	    // lprint($(this).val())
		});

		LGen.call({'c':'elm','f':'input'}).to_email(page.screen.querySelector('.email input'))
		LGen.call({'c':'elm','f':'input'}).to_username(page.screen.querySelector('.username input'))
		LGen.call({'c':'elm','f':'input'}).to_number(page.screen.querySelector('.phonenum input'))

		LGen.set_button(page.screen.querySelector('.read'))
		LGen.set_button_click(page.screen.querySelector('.read'), function() {
			LGen.Page.change_by_url('terms')
			// LGen.component.terms.previous_page = LGen.Page.current
			// LGen.Page.change('terms')
		})

		// LGen.set_button(page.screen.querySelector('.back_btn'))
		// LGen.set_button_click(page.screen.querySelector('.back_btn'), function() {
		// 	LGen.Page.change(page.previous_page)
		// })

		LGen.set_button(page.screen.querySelector('.create_btn'))
		LGen.set_button_click(page.screen.querySelector('.create_btn'), function() {
			$(page.screen.querySelector('.create_btn')).attr('disabled','true')
			var go = true	
			if (
				page.screen.querySelector('.fullname input').value === '' ||
				page.screen.querySelector('.username input').value === '' ||
				page.screen.querySelector('.email input').value === ''
			) {
				var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.get({'key':'lang','safe':'safe'}),"title_case":false,"words":"Fields with * cannot be empty." })
				LGen.component.snackbar.open({'str':_str})
				go = false
			}

			if (!LGen.call({'c':'gen','f':'email_validated'})(page.screen.querySelector('.email input').value)) {
				go = false
				var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.get({'key':'lang','safe':'safe'}),"title_case":false,"words":"Email is invalid." })
				LGen.component.snackbar.open({'str':_str})
			}

			if (!LGen.call({'c':'gen','f':'password_validated'})(page.screen.querySelector('.password input').value)) {
				go = false
				var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.get({'key':'lang','safe':'safe'}),"title_case":false,"words":"Password is invalid." })
				LGen.component.snackbar.open({'str':_str})
			}

			var _username = page.screen.querySelector('.username input').value
			if (!(4 <= _username.length && _username.length <= 15)) {
				go = false
				var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.get({'key':'lang','safe':'safe'}),"title_case":false,"words":"Username is invalid." })
				LGen.component.snackbar.open({'str':_str})
			}

			var _fullname = page.screen.querySelector('.fullname input').value
			if (!(4 <= _fullname.length && _fullname.length <= 50)) {
				go = false
				var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.get({'key':'lang','safe':'safe'}),"title_case":false,"words":"Fullname is invalid." })
				LGen.component.snackbar.open({'str':_str})
			}

			// var _fullname = page.screen.querySelector('.fullname input').value
			// if (4 <= _fullname.length && _fullname.length <= 15) {
			// 	go = false
			// 	var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.get({'key':'lang','safe':'safe'}),"title_case":false,"words":"Username is invalid." })
			// 	LGen.component.snackbar.open({'str':_str})
			// }

			if (go) {
				var _obj = {
					"json": {'val':{
				    "fullname": page.screen.querySelector('.fullname input').value,
				    "username": page.screen.querySelector('.username input').value.toLowerCase(),
				    "phonenum": page.screen.querySelector('.phonenum input').value,
				    "email": page.screen.querySelector('.email input').value.toLowerCase(),
				    "password": LGen.call({'c':'gen','f':'lhash'})(page.screen.querySelector('.password input').value),
				    "address": page.screen.querySelector('.address input').value,
				    "keep_signin": false,
				    "lang": LGen.call({'c':'elm','f':'select'}).get_selected_val(page.screen.querySelector('.lang select')),
				    "gender": LGen.call({'c':'elm','f':'select'}).get_selected_val(page.screen.querySelector('.gender select'))
					}, 'def':'citizens', 'bridge':[{'id':'citizens', 'puzzled': true}]},
					"func": '$citizen->signup'
				}
				LGen.call({'c':'req','f':'post'})(LGen.system.get({'safe':'safe'}).citizen_domain+'/gate', _obj, function(obj){
					// lprint(obj)
					if (obj === 'username is exist') {
						$(page.screen.querySelector('.create_btn')).removeAttr('disabled')
						var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.get({'key':'lang','safe':'safe'}),"title_case":false,"words":"username is exist." })
						LGen.component.snackbar.open({'str':_str})
					}
					else if (obj === 'email is exist') {
						$(page.screen.querySelector('.create_btn')).removeAttr('disabled')
						var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.get({'key':'lang','safe':'safe'}),"title_case":false,"words":"email is exist." })
						LGen.component.snackbar.open({'str':_str})
					}
					else {
						LGen.citizen.set_all({'val':obj,'safe':'safe'})
						LGen.component.account.screen.querySelector('span').innerText = '@'+LGen.citizen.get({'key':'username','safe':'safe'})
						LGen.component.email_verification.previous_page = 'page_home'
						LGen.Page.change('email_verification')
					}
				})			
			}
			else
				$(page.screen.querySelector('.create_btn')).removeAttr('disabled')

		})
	}

	this.update = update
	function update() {
		var page = LGen.component.create_account

		LGen.Page.Self.update(page)

		$(page.screen.querySelector('.create_btn')).removeAttr('disabled')

		if (LGen.citizen.get({'key':'gender','safe':'safe'}) !== '')
			$(page.screen.querySelector('.gender .val .select')).val(LGen.citizen.get({'key':'gender','safe':'safe'}));
		else
			$(page.screen.querySelector('.gender .val .select')).val("male");

		if (LGen.citizen.get({'key':'lang','safe':'safe'}) !== '')
			$(page.screen.querySelector('.lang .val .select')).val(LGen.citizen.get({'key':'lang','safe':'safe'}));
		else
			$(page.screen.querySelector('.lang .val .select')).val("en");
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.create_account
		page.previous_page = ''
		LGen.component.footbar.clear()
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.create_account
		page.update()
		LGen.component.footbar.add_plain(page.screen_footbar)
		LGen.component.footbar.show()
		LGen.component.header.show()
	}
}