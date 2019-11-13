LGen.component.profile = new Profile()
LGen.component.profile.set()

function Profile () {
	this.name = 'profile'

	this.set = set
	function set () {
		var page = LGen.component.profile

		page.screen_footbar = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="_footbar n1 theme fp">'+
				'<button class="std gold back theme fp bgclr1 hover1">'+LGen.icon.theme('left')+'</button>'+
			'</div>'
		)

		page.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="profile theme fp" style="display: none;">'+
			'<div class="bground">'+
			'<div class="content">'+
				'<div class="top_title title theme fttl">'+'Lanterlite Account'+'</div>'+
				'<div class="child username">'+
					'<div class="title theme fp">'+'Username'+'</div>'+
					'<input class="std gold val theme fp" value="" placeholder="(4-15 characters.)" maxlength="15"/>'+
				'</div>'+
				'<div class="child fullname">'+
					'<div class="title theme fp">'+'Fullname'+'</div>'+
					'<input class="std gold val theme fp" value="" placeholder="(4-50 characters.)" maxlength="50"/>'+
				'</div>'+
				'<div class="child email" disabled>'+
					'<div class="title theme fp">'+'Email Address'+'</div>'+
					'<input class="std gold val theme fp" value="" disabled/>'+
				'</div>'+
				'<button class="std gold verify_btn theme fp bgclr1 hover1">'+'Verify Email'+'</button>'+
				'<div class="child phonenum">'+
					'<div class="title theme fp">'+'Phone Number'+'</div>'+
					'<input class="std gold val theme fp" value=""/>'+
				'</div>'+
				'<div class="child address">'+
					'<div class="title theme fp">'+'Address'+'</div>'+
					'<input class="std gold val theme fp" value=""/>'+
				'</div>'+
				'<div class="child lang">'+
					'<div class="title theme fp">'+'Language'+'</div>'+
					'<div class="val">'+
					'<select class="select theme fp">'+
				    '<option value="id">Indonesia (Bahasa)</option>'+
				    '<option value="en">English</option>'+
					'</select>'+
					'</div>'+
				'</div>'+
				'<div class="child gender">'+
					'<div class="title theme fp">'+'Gender'+'</div>'+
					'<div class="val">'+
					'<select class="select theme fp">'+
				    '<option class="male" value="male">Male</option>'+
				    '<option class="female" value="female">Female</option>'+
					'</select>'+
					'</div>'+
				'</div>'+
				'<button class="std gold save_btn theme fp bgclr1 hover1">'+'Save'+'</button>'+
				// '<button class="std gold back_btn theme fp bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
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
			// {"elm":page.screen.querySelector('.back_btn')},
			{"elm":page.screen.querySelector('.gender select option.male')},
			{"elm":page.screen.querySelector('.gender select option.female')},
		]
		page.set_event()
		LGen.Page.init(page)
		LGen.component.header.hide_when_scroll2(page.screen.querySelector('.bground'))
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.profile

		LGen.call({'c':'elm','f':'input'}).to_email(page.screen.querySelector('.email input'))
		LGen.call({'c':'elm','f':'input'}).to_username(page.screen.querySelector('.username input'))
		LGen.call({'c':'elm','f':'input'}).to_number(page.screen.querySelector('.phonenum input'))
	
		LGen.set_button(page.screen_footbar.querySelector('.back'))
		LGen.set_button_click(page.screen_footbar.querySelector('.back'), function() {
			LGen.Page.change(page.previous_page)
		})

		// LGen.set_button(page.screen.querySelector('.back_btn'))
		// LGen.set_button_click(page.screen.querySelector('.back_btn'), function() {
		// 	LGen.Page.change(page.previous_page)
		// })

		$(page.screen.querySelector('.lang select')).change(function(){ 
			LGen.citizen.set_all({'val':{'lang':$(this).val()},'safe':'safe'})
	    // LGen.Page.update('lang',$(this).val());
	    // lprint($(this).val())
		});

		LGen.set_button(page.screen.querySelector('.verify_btn'))
		LGen.set_button_click(page.screen.querySelector('.verify_btn'), function() {
			$(page.screen.querySelector('.verify_btn')).attr('disabled','true')
			var _obj = {
				"json": {"id": LGen.citizen.get({'key':'id','safe':'safe'})},
				"func": '$citizen->resend_ver_email'
			}
			LGen.call({'c':'req','f':'post'})(LGen.system.get({'safe':'safe'}).be_domain+'/gate', _obj, function(obj){
				LGen.component.email_verification.previous_page = 'profile'
				LGen.Page.change('email_verification')
			})
		})

		LGen.set_button(page.screen.querySelector('.save_btn'))
		LGen.set_button_click(page.screen.querySelector('.save_btn'), function() {
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

			// if (!LGen.call({'c':'gen','f':'password_validated'})(page.screen.querySelector('.password input').value)) {
			// 	go = false
			// 	var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.get({'key':'lang','safe':'safe'}),"title_case":false,"words":"Password is invalid." })
			// 	LGen.component.snackbar.open({'str':_str})
			// }

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

			if (go) {
	 			var _sel = page.screen.querySelector('.gender select')
				var _gender_val = _sel.options[_sel.selectedIndex].value;
				var _sel = page.screen.querySelector('.lang select')
				var _lang_val = _sel.options[_sel.selectedIndex].value;
				var asd = {'val': {
			    "id": LGen.citizen.get({'key':'id','safe':'safe'}),
			    "fullname": page.screen.querySelector('.fullname input').value,
			    "username": page.screen.querySelector('.username input').value.toLowerCase(),
			    "email": page.screen.querySelector('.email input').value.toLowerCase(),
			    "phonenum": page.screen.querySelector('.phonenum input').value,
			    "address": page.screen.querySelector('.address input').value,
			    "lang": _lang_val,
			    "gender": _gender_val
				}, 'def':'citizens', 'bridge':[{'id':'citizens', 'puzzled': true}, {'id': LGen.citizen.get({'key':'id','safe':'safe'}), 'puzzled': false}]}
				var _obj = {
					"json": asd,
					"func": '$citizen->update_profile'
				}
				LGen.call({'c':'req','f':'post'})(LGen.system.get({'safe':'safe'}).be_domain+'/gate', _obj, function(obj){
					// lprint(obj)
					if (obj === 'username is exist') {
						var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.get({'key':'lang','safe':'safe'}),"title_case":false,"words":'username is exist.' })
						LGen.component.snackbar.open({'str':_str})
					}
					else if (obj === 'email is exist') {
						var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.get({'key':'lang','safe':'safe'}),"title_case":false,"words":'email is exist.' })
						LGen.component.snackbar.open({'str':_str})
					}
					else {
						var obj = []
				    obj['fullname'] = page.screen.querySelector('.fullname input').value,
				    obj['username'] = page.screen.querySelector('.username input').value.toLowerCase(),
				    obj['email'] = page.screen.querySelector('.email input').value.toLowerCase(),
				    obj['phonenum'] = page.screen.querySelector('.phonenum input').value,
				    obj['address'] = page.screen.querySelector('.address input').value,
				    obj['lang'] = _lang_val,
				    obj['gender'] = _gender_val
				    LGen.citizen.set_all({'val':obj,'safe':'safe'})
						var _str = LGen.translator.get({"from_lang":"en","lang":LGen.citizen.get({'key':'lang','safe':'safe'}),"title_case":false,"words":'Profile saved successfully.' })
						LGen.component.snackbar.open({'str':_str})
					}
				})			
			}
		})
	}

	this.update = update
	function update() {
		var page = LGen.component.profile

		LGen.Page.Self.update(page)

		$(page.screen.querySelector('.verify_btn')).removeAttr('disabled')

		if (LGen.citizen.get({'key':'gender','safe':'safe'}) !== '')
			$(page.screen.querySelector('.gender .val .select')).val(LGen.citizen.get({'key':'gender','safe':'safe'}));
		else
			$(page.screen.querySelector('.gender .val .select')).val("male");

		if (LGen.citizen.get({'key':'lang','safe':'safe'}) !== '')
			$(page.screen.querySelector('.lang .val .select')).val(LGen.citizen.get({'key':'lang','safe':'safe'}));
		else
			$(page.screen.querySelector('.lang .val .select')).val("en");

		if (!LGen.citizen.get({'key':'is_verified','safe':'safe'}))
			$(page.screen.querySelector('.verify_btn')).fadeIn();
		else
			$(page.screen.querySelector('.verify_btn')).fadeOut(0);

		page.screen.querySelector('.username input').value = LGen.citizen.get({'key':'username','safe':'safe'})
		page.screen.querySelector('.fullname input').value = LGen.citizen.get({'key':'fullname','safe':'safe'})
		page.screen.querySelector('.email input').value = LGen.citizen.get({'key':'email','safe':'safe'})
		page.screen.querySelector('.phonenum input').value = LGen.citizen.get({'key':'phonenum','safe':'safe'})
		page.screen.querySelector('.address input').value = LGen.citizen.get({'key':'address','safe':'safe'})
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.profile
		page.previous_page = ''
		LGen.component.footbar.clear()
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.profile
		page.update()
		LGen.component.footbar.add_plain(page.screen_footbar)
		LGen.component.footbar.show()
		LGen.component.header.show()
	}
}