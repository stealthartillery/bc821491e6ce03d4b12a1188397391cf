LGen.Page = new Page()

function Page () {
	this.first_load = true
	this.speed = 250
	this.current = ''
	this.names = {}
	this.when_opened = {}
	this.when_closed = {}
	this.screen = LGen.String.to_elm('<div class="canvas" style="display: none;"></div>')
	document.body.appendChild(this.screen)

	this.clear_childs = clear_childs
	function clear_childs(page) {
		setTimeout(function() {
			LGen.Elm.clear_childs(page)
		}, LGen.Page.speed)
	}

	this.set_keys = set_keys
	function set_keys(page) {
		if (!page.hasOwnProperty('previous_page'))
			page.previous_page = ''
		if (!page.hasOwnProperty('lang'))
			page.lang = 'en'
		if (!page.hasOwnProperty('lang_online'))
			page.lang_online = 'en'
		if (!page.hasOwnProperty('theme_font'))
			page.theme_font = 'fa01'
		if (!page.hasOwnProperty('theme_color'))
			page.theme_color = 'ca01'
		if (!page.hasOwnProperty('url_names'))
			page.url_names = []
		if (!page.hasOwnProperty('url_name_index'))
			page.url_name_index = 0
	}

	this.add = add
	function add(page) {
		LGen.Page.names[page.name] = page
		$(LGen.Page.names[page.name].screen).css({"display":"none"})
		this.screen.appendChild(LGen.Page.names[page.name].screen)
	}

	this.open_new_tab = open_new_tab
	function open_new_tab(url) {
		window.open(LGen.system.host+url)
	}

	this.change_url = change_url
	function change_url(new_url="") {
		if (new_url !== null)
			window.history.pushState('', null, LGen.system.change_url+'/'+new_url);
			// window.history.pushState({}, null, LGen.system.change_url+'/'+new_url);
			// window.history.replaceState("", "", LGen.system.change_url+'/'+new_url);
	}

  this.clear_banner_interval = clear_banner_interval
  function clear_banner_interval(page) {
		var length = page.move_banner_intervals.length
		for (var i=0; i<length;i++) {
			clearInterval(page.move_banner_intervals.shift())	
		}
  }

	this.lang = 'en'
	this.update_lang = update_lang
	function update_lang (lang='id') {

		var go = true
		if (LGen.citizen.lang === lang)
			go = false
		if (go) {
			LGen.citizen.lang = lang
			var _obj = []
			if (LGen.Page.current !== '')
				_obj.push(LGen.Page.names[LGen.Page.current])
			if (LGen.component.hasOwnProperty('signin'))
				_obj.push(LGen.component.signin)
			if (LGen.component.hasOwnProperty('account'))
				_obj.push(LGen.component.account)
			if (LGen.component.hasOwnProperty('sidebar'))
				_obj.push(LGen.component.sidebar)
			if (LGen.component.hasOwnProperty('header'))
				_obj.push(LGen.component.header)
			if (LGen.component.hasOwnProperty('footer'))
				_obj.push(LGen.component.footer)
			for (var i=0; i<_obj.length; i++) {
				LGen.Page.Self.update_lang(_obj[i])
			}
			if (LGen.citizen.id !== '')
				LGen.citizen.update_savior({'namelist':['lang']})
		}

	}

	this.theme_color = 'ca01'
	this.update_color = update_color
	function update_color (new_theme='ca01') {
		var go = true
		if (LGen.citizen.theme_color === new_theme)
			go = false
		if (go) {
			LGen.citizen.theme_color = new_theme
			var _obj = []
			if (LGen.Page.current !== '')
				_obj.push(LGen.Page.names[LGen.Page.current])
			if (LGen.component.hasOwnProperty('signin'))
				_obj.push(LGen.component.signin)
			if (LGen.component.hasOwnProperty('account'))
				_obj.push(LGen.component.account)
			if (LGen.component.hasOwnProperty('sidebar'))
				_obj.push(LGen.component.sidebar)
			if (LGen.component.hasOwnProperty('header'))
				_obj.push(LGen.component.header)
			if (LGen.component.hasOwnProperty('footer'))
				_obj.push(LGen.component.footer)
			for (var i=0; i<_obj.length; i++) {
				// _obj['elm'] = _screen[i]
				LGen.Page.Self.update_color(_obj[i])
				// LGen.Theme.Color.update_self(_obj)
			}
			LGen.citizen.theme_color = new_theme
			if (LGen.citizen.id !== '')
				LGen.citizen.update_savior({'namelist':['theme_color']})
		}
	}

	this.theme_font = 'fa01'
	this.update_font = update_font
	function update_font (new_theme='fa01') {
		var go = true
		if (LGen.citizen.theme_font === new_theme)
			go = false
		if (go) {
			// var _obj = {
			// 	"old_theme":LGen.citizen.theme_font,
			// 	"new_theme":new_theme
			// }
			LGen.citizen.theme_font = new_theme
			var _obj = []
			if (LGen.Page.current !== '')
				_obj.push(LGen.Page.names[LGen.Page.current])
			if (LGen.component.hasOwnProperty('signin'))
				_obj.push(LGen.component.signin)
			if (LGen.component.hasOwnProperty('account'))
				_obj.push(LGen.component.account)
			if (LGen.component.hasOwnProperty('sidebar'))
				_obj.push(LGen.component.sidebar)
			if (LGen.component.hasOwnProperty('header'))
				_obj.push(LGen.component.header)
			if (LGen.component.hasOwnProperty('footer'))
				_obj.push(LGen.component.footer)
			for (var i=0; i<_obj.length; i++) {
				// _obj['elm'] = _obj[i]
				LGen.Page.Self.update_font(_obj[i])
				// LGen.Theme.Font.update_self(_obj)
			}
			LGen.citizen.theme_font = new_theme
			if (LGen.citizen.id !== '')
				LGen.citizen.update_savior({'namelist':['theme_font']})
		}
	}

	this.change_by_url = change_by_url
	function change_by_url(page_url) {
		LGen.Page.change_url(page_url)
		route()
	}

	this.change = change
	function change(page_name='page_home') {
		if (LGen.Page.first_load) {
			lprint('fwfwfwfijwnfijwnfijwnfijwn')
			LGen.Page.history_handle()
			LGen.Page.first_load = false
		}
		if (page_name === '')
			page_name = 'page_home'
		var go = true
		if (LGen.Page.current === page_name && page_name !== 'page_content')
			go = false

		if (go) {
			if (LGen.Page.current !== '') {
				// $(LGen.Page.names[LGen.Page.current].screen).slideUp(250)
				$(LGen.Page.names[LGen.Page.current].screen).fadeOut(LGen.Page.speed)
				// $(LGen.Page.names[LGen.Page.current].screen).fadeOut()
				if (LGen.Page.when_closed[LGen.Page.current] !== null) {
					LGen.Page.when_closed[LGen.Page.current] = LGen.Page.names[LGen.Page.current].when_closed
				}
				LGen.Page.when_closed[LGen.Page.current]()
			}
			LGen.Page.current = page_name
			
			if (LGen.Page.when_opened[page_name] !== null) {
				LGen.Page.when_opened[page_name] = LGen.Page.names[page_name].when_opened
			}
			LGen.Page.when_opened[page_name]()
			// LGen.f.to_top(250)
			// $(LGen.Page.names[page_name].screen).slideDown(250)
			setTimeout(function() {
				if (LGen.Page.current === page_name) {
					$(LGen.Page.names[page_name].screen).slideDown(LGen.Page.speed)
					// LGen.f.to_top(250)
					if (LGen.Page.names[page_name].url_names.length > 0)
						LGen.Page.change_url(LGen.Page.names[page_name].url_names[LGen.Page.names[page_name].url_name_index])
				}
			}, LGen.Page.speed)

			// $(LGen.Page.names[page_name].screen).fadeIn()
			// setTimeout(function() {
			// 	$(LGen.Page.names[page_name].screen).fadeIn()
			// }, 500)			
		}
	}

	this.change_history = change_history
	function change_history (event, keep=true) {
		if (keep) {
			if (event.state === -1)
				history.go(1);
			if (event.state === 0)
				history.go(1);
			// lprint('keep_opened')
		}
		if (!keep) {
			LGen.Page.keep_opened = false
			history.back(); history.back();
			// lprint('close')
		}
	}

	this.keep_opened = true
	this.history_handle = history_handle
	function history_handle() {
		history.pushState(-1, null); // back state
		history.pushState(0, null); // main state
		history.pushState(1, null); // forward state

		window.addEventListener('popstate', function(event, state){
			// check history state and fire custom events
			if (event.state === '')
				history.go(-1);
			if (event.state === null)
				history.go(-1);
			if (LGen.Page.keep_opened && event.state === 0)
				history.go(1);
			if(state = event.state){

				if (LGen.component.sidebar.opened()) { LGen.component.sidebar.close(); LGen.Page.change_history(event) }
				else if (LGen.component.signin.opened()) { LGen.component.signin.close(); LGen.Page.change_history(event) }
				else if (LGen.component.account.opened()) { LGen.component.account.close(); LGen.Page.change_history(event) }

				else if (LGen.Page.current === 'profile') { LGen.Page.change(LGen.component.profile.previous_page); LGen.Page.change_history(event) }
				else if (LGen.Page.current === 'info') { LGen.Page.change(LGen.component.info.previous_page); LGen.Page.change_history(event) }
				else if (LGen.Page.current === 'terms') { LGen.Page.change(LGen.component.terms.previous_page); LGen.Page.change_history(event) }
				else if (LGen.Page.current === 'notif') { LGen.Page.change(LGen.component.notif.previous_page); LGen.Page.change_history(event) }
				else if (LGen.Page.current === 'notif_msg') { LGen.Page.change(LGen.component.notif_msg.previous_page); LGen.Page.change_history(event) }
				else if (LGen.Page.current === 'create_account') { LGen.Page.change(LGen.component.create_account.previous_page); LGen.Page.change_history(event) }
				else if (LGen.Page.current === 'email_verification') { LGen.Page.change(LGen.component.email_verification.previous_page); LGen.Page.change_history(event) }
				else if (LGen.Page.current === 'option') { LGen.Page.change(LGen.component.option.previous_page); LGen.Page.change_history(event) }
				else if (LGen.Page.current !== 'page_home') { LGen.Page.change('page_home'); LGen.Page.change_history(event) }
				else if (LGen.Page.current === 'page_home') { LGen.Page.change_history(event, false) }

				event = document.createEvent('Event');
				event.initEvent(state > 0 ? 'next' : 'previous', true, true);
				this.dispatchEvent(event);

			}
		}, false);
	}


	/* done: used for pages and compos */
	this.Self = new Self()
	function Self() {
		this.update_css = update_css
		function update_css(page) {
			var _page
			if (page.hasOwnProperty('screen'))
				_page = page.screen
			else
				_page = page
			LGen.Theme.Color.set(_page)
			LGen.Theme.Font.set(_page)
			LGen.Theme.Color.set(_page.querySelectorAll('.theme_color'))
			LGen.Theme.Font.set(_page.querySelectorAll('.theme_font'))
		}

		this.update_color = update_color
		function update_color(page) {
			lprint(page)
			var go = true
			if (page.theme_color === LGen.citizen.theme_color)
				go = false
			if (go) {
				LGen.Theme.Color.update_self({
					"elm": page.screen,
					"old_theme": page.theme_color,
					"new_theme": LGen.citizen.theme_color
				})
				page.theme_color = LGen.citizen.theme_color
			}
		}

		this.update_font = update_font
		function update_font(page) {
			var go = true
			if (page.theme_font === LGen.citizen.theme_font)
				go = false
			if (go) {
				LGen.Theme.Font.update_self({
					"elm": page.screen,
					"old_theme": page.theme_font,
					"new_theme": LGen.citizen.theme_font
				})
				page.theme_font = LGen.citizen.theme_font
			}
		}

		this.update_lang = update_lang
		function update_lang (page) {
			var go = true
			if (page.lang === LGen.citizen.lang)
				go = false
			if (go) {
				var _obj = {}
				_obj['from_lang'] = page.lang
				_obj['lang'] = LGen.citizen.lang
				if (page.hasOwnProperty('load_content')) {
					lprint('asd')
					page.load_content(1)
				}
				for (var i=0; i<page.lang_elms.length; i++) {
					_obj['elm'] = page.lang_elms[i].elm
					if (page.lang_elms[i].hasOwnProperty('type'))
						_obj['type'] = page.lang_elms[i].type
					else
						_obj['type'] = ''
					LGen.translator.update(_obj)
				}
				page.lang = LGen.citizen.lang
			}
		}
	}
}