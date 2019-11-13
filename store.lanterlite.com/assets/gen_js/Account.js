LGen.component.account = new Account()
LGen.component.account.set()

function Account () {
	this.set = set
	function set () {
		var compo = LGen.component.account
		compo.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="account theme bgclr1">'+
				'<div class="username">'+'<span class="theme fp color2">'+'@'+LGen.citizen.get({'key':'username','safe':'safe'})+'</span>'+'</div>'+
				'<button class="std gold profile_btn theme fp bgclr1 hover1">'+LGen.icon.theme('account')+'<span>'+'Profile'+'</span>'+'</button>'+
				'<button class="std gold refresh_btn theme fp bgclr1 hover1">'+LGen.icon.theme('refresh')+'<span>'+'Refresh'+'</span>'+'</button>'+
				'<button class="std gold information_btn theme fp bgclr1 hover1">'+LGen.icon.theme('quote')+'<span>'+'Information'+'</span>'+'</button>'+
				'<button class="std gold notification_btn theme fp bgclr1 hover1">'+LGen.icon.theme('bell')+'<span>'+'Help'+'</span>'+'</button>'+
				'<button class="std gold option_btn theme fp bgclr1 hover1">'+LGen.icon.theme('option')+'<span>'+'Option'+'</span>'+'</button>'+
				'<button class="std gold signout_btn theme fp bgclr1 hover1">'+LGen.icon.theme('exit')+'<span>'+'Sign Out'+'</span>'+'</button>'+
			'</div>'
		)
		compo.lang_elms = [
			{"elm":compo.screen.querySelector('.account .refresh_btn span')},
			{"elm":compo.screen.querySelector('.account .option_btn span')},
			{"elm":compo.screen.querySelector('.account .notification_btn span')},
			{"elm":compo.screen.querySelector('.account .information_btn span')},
			{"elm":compo.screen.querySelector('.account .signout_btn span')},
			{"elm":compo.screen.querySelector('.account .profile_btn span')},
		]
		compo.bg = LGen.call({'c':'str', 'f':'to_elm'})('<div class="bg dark">'+'</div>')

		LGen.Page.init(compo)
		$(compo.screen).css({'opacity':0})
		compo.set_event()

		LGen.Page.screen.appendChild(compo.screen)
		LGen.Page.screen.appendChild(compo.bg)
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.account
		LGen.set_button(page.screen.querySelector('.refresh_btn'))
		LGen.set_button_click(page.screen.querySelector('.refresh_btn'), function(_this) {
			var _obj = {
				"json": {
					'val':{'id':LGen.citizen.get({'key':'id','safe':'safe'})}
				},
				"func": '$citizen->read'
			}
			LGen.call({'c':'req','f':'get'})(LGen.system.get({'safe':'safe'}).citizen_domain+'/gate', _obj, function(obj){
				// lprint(obj)
				var str = LGen.translator.get({"from_lang":"en","words":"Account has refreshed." })
				LGen.component.snackbar.open({'str':str})
				LGen.citizen.set_all({'val':obj,'safe':'safe'})
				// page.screen.querySelector('.point input').value = LGen.citizen.get({'key':'point','safe':'safe'})
				// page.screen.querySelector('.silver input').value = LGen.citizen.get({'key':'silver','safe':'safe'})
			})
		})
		LGen.set_button(page.screen.querySelector('.option_btn'))
		LGen.set_button_click(page.screen.querySelector('.option_btn'), function(_this) {
			LGen.component.option.previous_page = LGen.Page.current;
			page.close()
			LGen.Page.change('option')
		})
		LGen.set_button(page.screen.querySelector('.notification_btn'))
		LGen.set_button_click(page.screen.querySelector('.notification_btn'), function(_this) {
			LGen.component.notif.previous_page = LGen.Page.current;
			page.close()
			LGen.Page.change('notif')
		})
		LGen.set_button(page.screen.querySelector('.profile_btn'))
		LGen.set_button_click(page.screen.querySelector('.profile_btn'), function(_this) {
			LGen.component.profile.previous_page = LGen.Page.current;
			page.close()
			LGen.Page.change('profile')
		})
		LGen.set_button(page.screen.querySelector('.information_btn'))
		LGen.set_button_click(page.screen.querySelector('.information_btn'), function(_this) {
			LGen.component.info.previous_page = LGen.Page.current;
			page.close()
			LGen.Page.change('info')
		})
		LGen.set_button(page.screen.querySelector('.signout_btn'))
		LGen.set_button_click(page.screen.querySelector('.signout_btn'), function(_this) {
			var _cit_keys = Object.keys(LGen.citizen)
			// for (var i=0; i<_cit_keys.length; i++)
			// 	LGen.citizen[_cit_keys[i]] = ''
			if (
				LGen.Page.current === 'email_verification' ||
				LGen.Page.current === 'option' ||
				LGen.Page.current === 'profile' ||
				LGen.Page.current === 'info' || 
				LGen.Page.current === 'notif' || 
				LGen.Page.current === 'notif_msg'
				)
				LGen.Page.change('page_home')
			page.close()

			var _obj = {
				"json": {'val': {}},
				"func": "$citizen->logout"
			}
			if (LGen.app.get({'safe':'safe'}).platform === 'mob')
				_obj.json.val.ship_id = device.uuid
			LGen.call({'c':'req','f':'post'})(LGen.system.get({'safe':'safe'}).citizen_domain+'/gate', _obj, function(obj){
				LGen.citizen.set_default()
				// LGen.Page.Self.update(LGen.component.header)
				// LGen.Page.Self.update(LGen.Page.names[LGen.Page.current])
				// lprint(obj)
			})
			// LGen.component.header.acc.screen.querySelector('img').src = BASE_URL + 'assets/lite.img/user.svg'
		})

		page.bg.addEventListener('click', function() {
			if (!$(page.screen).hasClass('opened'))
				page.open()
			else
				page.close()
		})
	}

	this.opened = opened
	function opened() {
		var page = LGen.component.account
		return $(page.screen).hasClass('opened')
	}

	this.open = open
	function open() {
		var page = LGen.component.account
		LGen.Page.Self.update(page)
		if (!$(page.screen).hasClass("opened")) {
			// $(page.screen).css("display", "flex").hide().fadeIn();
			$(page.screen).fadeIn(0);
			$(page.screen).css({'opacity':1})
			$(page.screen).addClass("opened")
			$(page.bg).fadeIn(250)
			LGen.call({'c':'gen','f':'disable_canvas_scroll'})();
		}
	}

	this.close = close
	function close() {
		var page = LGen.component.account
		if ($(page.screen).hasClass("opened")) {
			$(page.screen).css({'opacity':0})
			setTimeout(function(){$(page.screen).fadeOut(0)}, LGen.Page.speed)
			$(page.screen).removeClass("opened")
			$(page.bg).fadeOut(250)
			LGen.call({'c':'gen','f':'enable_canvas_scroll'})();
		}
	}
}