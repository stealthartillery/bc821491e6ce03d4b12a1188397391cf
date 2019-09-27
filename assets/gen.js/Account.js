LGen.component.account = new Account()
LGen.component.account.set()

function Account () {
	this.set = set
	function set () {
		var page = LGen.component.account
		page.screen = LGen.String.to_elm(
			'<div class="account theme '+LGen.citizen.theme_color+' bgclr1">'+
				'<div class="username">'+'<span class="theme '+LGen.citizen.theme_font+' '+LGen.citizen.theme_color+' color2">'+'@'+LGen.citizen.username+'</span>'+'</div>'+
				'<button class="std gold profile_btn theme '+LGen.citizen.theme_font+' '+LGen.citizen.theme_color+' bgclr1 hover1">'+I.obj['account']+'<span>'+'Profile'+'</span>'+'</button>'+
				'<button class="std gold information_btn theme '+LGen.citizen.theme_font+' '+LGen.citizen.theme_color+' bgclr1 hover1">'+I.obj['quote']+'<span>'+'Information'+'</span>'+'</button>'+
				'<button class="std gold notification_btn theme '+LGen.citizen.theme_font+' '+LGen.citizen.theme_color+' bgclr1 hover1">'+I.obj['bell']+'<span>'+'Help'+'</span>'+'</button>'+
				'<button class="std gold option_btn theme '+LGen.citizen.theme_font+' '+LGen.citizen.theme_color+' bgclr1 hover1">'+I.obj['option']+'<span>'+'Option'+'</span>'+'</button>'+
				'<button class="std gold signout_btn theme '+LGen.citizen.theme_font+' '+LGen.citizen.theme_color+' bgclr1 hover1">'+I.obj['exit']+'<span>'+'Sign Out'+'</span>'+'</button>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.account .option_btn span')},
			{"elm":page.screen.querySelector('.account .notification_btn span')},
			{"elm":page.screen.querySelector('.account .information_btn span')},
			{"elm":page.screen.querySelector('.account .signout_btn span')},
			{"elm":page.screen.querySelector('.account .profile_btn span')},
		]
		page.bg = LGen.String.to_elm('<div class="bg dark">'+'</div>')

		LGen.Page.set_keys(page)
		page.set_event()

		LGen.Page.screen.appendChild(page.screen)
		LGen.Page.screen.appendChild(page.bg)
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.account
		page.screen.querySelector('.option_btn').addEventListener('click', function() {
			LGen.component.option.previous_page = LGen.Page.current;
			page.close()
			LGen.Page.change('option')
		})
		page.screen.querySelector('.notification_btn').addEventListener('click', function() {
			LGen.component.notif.previous_page = LGen.Page.current;
			page.close()
			LGen.Page.change('notif')
		})
		page.screen.querySelector('.profile_btn').addEventListener('click', function() {
			LGen.component.profile.previous_page = LGen.Page.current;
			page.close()
			LGen.Page.change('profile')
		})
		page.screen.querySelector('.information_btn').addEventListener('click', function() {
			LGen.component.info.previous_page = LGen.Page.current;
			page.close()
			LGen.Page.change('info')
		})
		page.screen.querySelector('.signout_btn').addEventListener('click', function() {
			var _cit_keys = Object.keys(LGen.citizen)
			// for (var i=0; i<_cit_keys.length; i++)
			// 	LGen.citizen[_cit_keys[i]] = ''
			LGen.citizen.set_default()
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
				"json": {},
				"func": "$citizen->logout"
			}
			LGen.f.send_post(LGen.system.be_domain+'/citizen', _obj, function(obj){
				lprint(obj)
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
		if (!$(page.screen).hasClass("opened")) {
			$(page.screen).fadeIn(0)
			$(page.screen).addClass("opened")
			$(page.bg).fadeIn(250)
			disable_canvas_scroll();
		}
	}

	this.close = close
	function close() {
		var page = LGen.component.account
		if ($(page.screen).hasClass("opened")) {
			$(page.screen).fadeOut(0)
			$(page.screen).removeClass("opened")
			$(page.bg).fadeOut(250)
			enable_canvas_scroll();
		}
	}
}