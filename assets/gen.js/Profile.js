LGen.component.profile = new Profile()
LGen.component.profile.set()

function Profile () {
	this.name = 'profile'

	this.set = set
	function set () {
		var page = LGen.component.profile
		page.screen = LGen.String.to_elm(
			'<div class="profile" style="display: none;">'+
			'<div class="bground">'+
				'<div class="top_title title theme theme_font">'+'Lanterlite Account'+'</div>'+
				'<div class="child username">'+
					'<div class="title theme theme_font">'+'Username'+'</div>'+
					'<input class="std gold val theme_font" value="" placeholder="(4-15 characters.)" maxlength="15"/>'+
				'</div>'+
				'<div class="child fullname">'+
					'<div class="title theme theme_font">'+'Fullname'+'</div>'+
					'<input class="std gold val theme_font" value="" placeholder="(4-50 characters.)" maxlength="50"/>'+
				'</div>'+
				'<div class="child email" disabled>'+
					'<div class="title theme theme_font">'+'Email Address'+'</div>'+
					'<input class="std gold val theme_font" value="" disabled/>'+
				'</div>'+
				'<button class="std gold verify_btn theme theme_font theme_color bgclr1 hover1" style="display: none;">'+'Verify Email'+'</button>'+
				'<div class="child phonenum">'+
					'<div class="title theme theme_font">'+'Phone Number'+'</div>'+
					'<input class="std gold val theme_font" value=""/>'+
				'</div>'+
				'<div class="child address">'+
					'<div class="title theme theme_font">'+'Address'+'</div>'+
					'<input class="std gold val theme_font" value=""/>'+
				'</div>'+
				'<div class="child lang">'+
					'<div class="title theme theme_font">'+'Language'+'</div>'+
					'<div class="val">'+
					'<select class="select theme theme_font">'+
				    '<option value="id">Indonesia (Bahasa)</option>'+
				    '<option value="en">English</option>'+
					'</select>'+
					'</div>'+
				'</div>'+
				'<div class="child gender">'+
					'<div class="title theme theme_font">'+'Gender'+'</div>'+
					'<div class="val">'+
					'<select class="select theme theme_font">'+
				    '<option class="male" value="male">Male</option>'+
				    '<option class="female" value="female">Female</option>'+
					'</select>'+
					'</div>'+
				'</div>'+
				'<button class="std gold save_btn theme theme_font theme_color bgclr1 hover1">'+'Save'+'</button>'+
				'<button class="std gold back_btn theme theme_font theme_color bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.top_title')},
			{"elm":page.screen.querySelector('.username .title')},
			{"elm":page.screen.querySelector('.fullname .title')},
			{"elm":page.screen.querySelector('.address .title')},
			{"elm":page.screen.querySelector('.phonenum .title')},
			{"elm":page.screen.querySelector('.email .title')},
			{"elm":page.screen.querySelector('.gender .title')},
			{"elm":page.screen.querySelector('.lang .title')},
			{"elm":page.screen.querySelector('.verify_btn')},
			{"elm":page.screen.querySelector('.save_btn')},
			{"elm":page.screen.querySelector('.back_btn')},
			{"elm":page.screen.querySelector('.gender select option.male')},
			{"elm":page.screen.querySelector('.gender select option.female')},
		]
		LGen.Page.set_keys(page)
		page.set_event()
		LGen.Page.add(page)
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.profile

		LGen.Elm.Input.to_email(page.screen.querySelector('.email input'))
		LGen.Elm.Input.to_username(page.screen.querySelector('.username input'))
		LGen.Elm.Input.to_number(page.screen.querySelector('.phonenum input'))

		page.screen.querySelector('.back_btn').addEventListener('click', function() {
			LGen.Page.change(page.previous_page)
		})

		$(page.screen.querySelector('.lang select')).change(function(){ 
	    LGen.Page.update_lang($(this).val());
	    lprint($(this).val())
		});

		page.screen.querySelector('.verify_btn').addEventListener('click', function() {
			$(page.screen.querySelector('.verify_btn')).attr('disabled','true')
			var _obj = {
				"json": {"id": LGen.citizen.id},
				"func": '$citizen->resend_ver_email'
			}
			LGen.f.send_post(LGen.system.be_domain+'/citizen', _obj, function(obj){
				LGen.component.email_verification.previous_page = 'profile'
				LGen.Page.change('email_verification')
			})
		})

		page.screen.querySelector('.save_btn').addEventListener('click', function() {
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

			// if (!LGen.f.password_validated(page.screen.querySelector('.password input').value)) {
			// 	go = false
			// 	var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.lang,"title_case":false,"words":"Password is invalid." })
			// 	LGen.component.snackbar.open({'str':_str})
			// }

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

			if (go) {
	 			var _sel = page.screen.querySelector('.gender select')
				var _gender_val = _sel.options[_sel.selectedIndex].value;
				var _sel = page.screen.querySelector('.lang select')
				var _lang_val = _sel.options[_sel.selectedIndex].value;
				var asd = {'gate':'savior', 'limited': false, 'val': {
			    "id": LGen.citizen.id,
			    "fullname": page.screen.querySelector('.fullname input').value,
			    "username": page.screen.querySelector('.username input').value.toLowerCase(),
			    "email": page.screen.querySelector('.email input').value.toLowerCase(),
			    "phonenum": page.screen.querySelector('.phonenum input').value,
			    "address": page.screen.querySelector('.address input').value,
			    "lang": _lang_val,
			    "gender": _gender_val
				}, 'def':'citizens', 'bridge':[{'id':'citizens', 'puzzled': true}, {'id': LGen.citizen.id, 'puzzled': false}]}
				var _obj = {
					"json": asd,
					"func": '$citizen->update_profile'
				}
				LGen.f.send_post(LGen.system.be_domain+'/citizen', _obj, function(obj){
					lprint(obj)
					if (obj === 'username is exist') {
						var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.lang,"title_case":false,"words":'username is exist.' })
						LGen.component.snackbar.open({'str':_str})
					}
					else if (obj === 'email is exist') {
						var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.lang,"title_case":false,"words":'email is exist.' })
						LGen.component.snackbar.open({'str':_str})
					}
					else {
				    LGen.citizen.fullname = page.screen.querySelector('.fullname input').value,
				    LGen.citizen.username = page.screen.querySelector('.username input').value.toLowerCase(),
				    LGen.citizen.email = page.screen.querySelector('.email input').value.toLowerCase(),
				    LGen.citizen.phonenum = page.screen.querySelector('.phonenum input').value,
				    LGen.citizen.address = page.screen.querySelector('.address input').value,
				    LGen.citizen.lang = _lang_val,
				    LGen.citizen.gender = _gender_val

						LGen.Page.update_lang(LGen.citizen.lang)

						LGen.component.account.screen.querySelector('span').innerText = '@'+LGen.citizen.username
						var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.lang,"title_case":false,"words":'Profile saved successfully.' })
						LGen.component.snackbar.open({'str':_str})
					}
				})			
			}
		})
	}

	this.update = update
	function update() {
		var page = LGen.component.profile

		LGen.Page.Self.update_css(page)
		LGen.Page.Self.update_lang(page)
		LGen.Page.Self.update_font(page)
		LGen.Page.Self.update_color(page)

		$(page.screen.querySelector('.verify_btn')).removeAttr('disabled')

		if (LGen.citizen.gender !== '')
			$(page.screen.querySelector('.gender .val .select')).val(LGen.citizen.gender);
		else
			$(page.screen.querySelector('.gender .val .select')).val("male");

		if (LGen.citizen.lang !== '')
			$(page.screen.querySelector('.lang .val .select')).val(LGen.citizen.lang);
		else
			$(page.screen.querySelector('.lang .val .select')).val("en");

		if (!LGen.citizen.is_verified)
			$(page.screen.querySelector('.verify_btn')).fadeIn();
		else
			$(page.screen.querySelector('.verify_btn')).fadeOut(0);

		page.screen.querySelector('.username input').value = LGen.citizen.username
		page.screen.querySelector('.fullname input').value = LGen.citizen.fullname
		page.screen.querySelector('.email input').value = LGen.citizen.email
		page.screen.querySelector('.phonenum input').value = LGen.citizen.phonenum
		page.screen.querySelector('.address input').value = LGen.citizen.address
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.profile
		page.previous_page = ''
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.profile
		page.update()
	}
}