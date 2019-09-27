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

		page.screen = LGen.String.to_elm(
			'<div class="create_account" style="display: none;">'+
			'<div class="bground">'+
				'<div class="top_title title theme_font">'+'Create Lanterlite Account'+'</div>'+
				'<div class="child username">'+
					'<span class="title theme theme_font">'+'Username'+'</span>'+
					'<span class="required_star">'+' *'+'</span>'+
					'<input class="std gold val theme_font" value="" placeholder="(4-15 characters.)" maxlength="15"/>'+
				'</div>'+
				'<div class="child fullname">'+
					'<span class="title theme theme_font">'+'Fullname'+'</span>'+
					'<span class="required_star">'+' *'+'</span>'+
					'<input class="std gold val theme_font" value="" placeholder="(4-50 characters.)" maxlength="50"/>'+
				'</div>'+
				'<div class="child email">'+
					'<span class="title theme theme_font">'+'Email Address'+'</span>'+
					'<span class="required_star">'+' *'+'</span>'+
					'<input class="std gold val theme_font" value=""/>'+
				'</div>'+
				'<div class="child password">'+
					'<span class="title theme theme_font">'+'Password'+'</span>'+
					'<span class="required_star">'+' *'+'</span>'+
					'<input type="password" class="std gold val theme_font" value="" placeholder="(7-15 chars: min. one number, capitalized letter, lowercase letter, and special char.)"/>'+
				'</div>'+
				page.see_password.screen.outerHTML+
				'<div class="child phonenum">'+
					'<span class="title theme theme_font">'+'Phone Number'+'</span>'+
					'<input class="std gold val theme_font" value=""/>'+
				'</div>'+
				'<div class="child address">'+
					'<span class="title theme theme_font">'+'Address'+'</span>'+
					'<input class="std gold val theme_font" value=""/>'+
				'</div>'+
				'<div class="child lang">'+
					'<span class="title theme theme_font">'+'Language'+'</span>'+
					'<div class="val">'+
					'<select class="select theme theme_font">'+
				    '<option value="id">Indonesia (Bahasa)</option>'+
				    '<option value="en">English</option>'+
					'</select>'+
					'</div>'+
				'</div>'+
				'<div class="child gender">'+
					'<span class="title theme theme_font">'+'Gender'+'</span>'+
					'<div class="val">'+
					'<select class="select theme theme_font">'+
				    '<option class="male" value="male">Male</option>'+
				    '<option class="female" value="female">Female</option>'+
					'</select>'+
					'</div>'+
				'</div>'+
				page.agree_term.screen.outerHTML+'<span> (</span>'+'<a class="read std dark theme theme_font">Read</a>'+'<span>)</span>'+
				'<button class="std gold create_btn theme theme_font theme_color bgclr1 hover1" disabled>'+'Create'+'</button>'+
				'<button class="std gold back_btn theme theme_font theme_color bgclr1 hover1">'+'Back'+'</button>'+
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
			{"elm":page.screen.querySelector('.back_btn')},
			{"elm":page.screen.querySelector('.gender select option.male')},
			{"elm":page.screen.querySelector('.gender select option.female')},
			{"elm":page.screen.querySelector('.username input')},
			{"elm":page.screen.querySelector('.password input')},
			{"elm":page.screen.querySelector('.read')},
			{"elm":page.agree_term.screen.querySelector('.title')},
			{"elm":page.see_password.screen.querySelector('.title')},
		]
		LGen.Page.set_keys(page)
		page.set_event()
		LGen.Page.add(page)
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.create_account

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
	    LGen.Page.update_lang($(this).val());
	    lprint($(this).val())
		});

		LGen.Elm.Input.to_email(page.screen.querySelector('.email input'))
		LGen.Elm.Input.to_username(page.screen.querySelector('.username input'))
		LGen.Elm.Input.to_number(page.screen.querySelector('.phonenum input'))

		page.screen.querySelector('.read').addEventListener('click', function() {
			LGen.component.terms.previous_page = LGen.Page.current
			LGen.Page.change('terms')
		})

		page.screen.querySelector('.back_btn').addEventListener('click', function() {
			LGen.Page.change(page.previous_page)
		})

		page.screen.querySelector('.create_btn').addEventListener('click', function() {
			$(page.screen.querySelector('.create_btn')).attr('disabled','true')
			var go = true	
			if (
				page.screen.querySelector('.fullname input').value === '' ||
				page.screen.querySelector('.username input').value === '' ||
				page.screen.querySelector('.email input').value === ''
			) {
				var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.lang,"title_case":false,"words":"Fields with * cannot be empty." })
				LGen.component.snackbar.open({'str':_str})
				go = false
			}

			if (!LGen.f.email_validated(page.screen.querySelector('.email input').value)) {
				go = false
				var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.lang,"title_case":false,"words":"Email is invalid." })
				LGen.component.snackbar.open({'str':_str})
			}

			if (!LGen.f.password_validated(page.screen.querySelector('.password input').value)) {
				go = false
				var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.lang,"title_case":false,"words":"Password is invalid." })
				LGen.component.snackbar.open({'str':_str})
			}

			var _username = page.screen.querySelector('.username input').value
			if (!(4 <= _username.length && _username.length <= 15)) {
				go = false
				var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.lang,"title_case":false,"words":"Username is invalid." })
				LGen.component.snackbar.open({'str':_str})
			}

			var _fullname = page.screen.querySelector('.fullname input').value
			if (!(4 <= _fullname.length && _fullname.length <= 50)) {
				go = false
				var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.lang,"title_case":false,"words":"Fullname is invalid." })
				LGen.component.snackbar.open({'str':_str})
			}

			// var _fullname = page.screen.querySelector('.fullname input').value
			// if (4 <= _fullname.length && _fullname.length <= 15) {
			// 	go = false
			// 	var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.lang,"title_case":false,"words":"Username is invalid." })
			// 	LGen.component.snackbar.open({'str':_str})
			// }

			if (go) {
				var _obj = {
					"json": {'gate':'savior', 'limited': false, 'val':{
				    "fullname": page.screen.querySelector('.fullname input').value,
				    "username": page.screen.querySelector('.username input').value.toLowerCase(),
				    "phonenum": page.screen.querySelector('.phonenum input').value,
				    "email": page.screen.querySelector('.email input').value.toLowerCase(),
				    "password": LGen.f.lhash(page.screen.querySelector('.password input').value),
				    "address": page.screen.querySelector('.address input').value,
				    "keep_signin": false,
				    "lang": LGen.Select.get_selected_val(page.screen.querySelector('.lang select')),
				    "gender": LGen.Select.get_selected_val(page.screen.querySelector('.gender select'))
					}, 'def':'citizens', 'bridge':[{'id':'citizens', 'puzzled': true}]},
					"func": '$citizen->signup'
				}
				LGen.f.send_post(LGen.system.be_domain+'/citizen', _obj, function(obj){
					lprint(obj)
					if (obj === 'username is exist') {
						$(page.screen.querySelector('.create_btn')).removeAttr('disabled')
						var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.lang,"title_case":false,"words":"username is exist." })
						LGen.component.snackbar.open({'str':_str})
					}
					else if (obj === 'email is exist') {
						$(page.screen.querySelector('.create_btn')).removeAttr('disabled')
						var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.lang,"title_case":false,"words":"email is exist." })
						LGen.component.snackbar.open({'str':_str})
					}
					else {
						LGen.citizen.set(obj)
						LGen.component.account.screen.querySelector('span').innerText = '@'+LGen.citizen.username
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

		LGen.Page.Self.update_css(page)
		LGen.Page.Self.update_color(page)
		LGen.Page.Self.update_font(page)
		LGen.Page.Self.update_lang(page)

		$(page.screen.querySelector('.create_btn')).removeAttr('disabled')

		if (LGen.citizen.gender !== '')
			$(page.screen.querySelector('.gender .val .select')).val(LGen.citizen.gender);
		else
			$(page.screen.querySelector('.gender .val .select')).val("male");

		if (LGen.citizen.lang !== '')
			$(page.screen.querySelector('.lang .val .select')).val(LGen.citizen.lang);
		else
			$(page.screen.querySelector('.lang .val .select')).val("en");
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.create_account
		page.previous_page = ''
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.create_account
		page.update()
	}
}