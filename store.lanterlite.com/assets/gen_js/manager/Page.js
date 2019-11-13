LGen.Page = new function () {
	this.def_color = 'ca01'
	this.def_font = 'fa01'
	this.def_fsize = 'fs01'
	this.def_lang = 'en'

	this.ready = false
	this.first_load = true
	this.speed = 250
	this.current = ''
	this.names = {}
	this.when_opened = {}
	this.when_closed = {}
	this.screen = LGen.call({'c':'str', 'f':'to_elm'})('<div class="canvas" style="display: none;"></div>')
	document.body.appendChild(this.screen)

	this.set_scrollbar = function (screen) {
		$(screen).mCustomScrollbar({
        scrollButtons:{
          enable:true
        }
    });
	}

	this.clear_childs = clear_childs
	function clear_childs(page, show_end=true) {
		$(page).css({'opacity': 0})
		setTimeout(function() {
			LGen.call({'c':'elm','f':'clear_childs'})(page)
			if (show_end)
				$(page).css({'opacity': 1})
		}, LGen.Page.speed)
	}

	this.set_css = set_css
	function set_css(page) {
		// if (page.hasOwnProperty('screen'))
		// 	var _page = page.screen
		// else
		// 	var _page = page

		// if ($(_page).hasClass('theme'))
		// 	$(_page).removeClass('theme').addClass('theme fsize theme_font theme_color')
		// var elms = _page.querySelectorAll('.theme')
		// for (var i=0; i<elms.length; i++) {
		// 	if ($(elms[i]).hasClass('theme'))
		// 		$(elms[i]).removeClass('theme').addClass('theme fsize theme_font theme_color')
		// }
	}

	this.init = init
	function init(page) {
		if (page.hasOwnProperty('screen'))
			$(page.screen).css({'opacity':0})
		else
			$(page).css({'opacity':0})

		// // LGen.Page.set_css(page)
		LGen.Page.set_keys(page)
		LGen.Page.add(page)
		if(!$(page.screen).hasClass('theme'))
			$(page.screen).addClass('theme')

		if (page.hasOwnProperty('screen_footbar')) {
			if(!$(page.screen_footbar).hasClass('theme'))
				$(page.screen_footbar).addClass('theme')
		}
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
		if (!page.hasOwnProperty('fsize'))
			page.fsize = 'fs01'
		if (!page.hasOwnProperty('self_show'))
			page.self_show = false
		if (!page.hasOwnProperty('lang_elms'))
			page.lang_elms = []
		if (!page.hasOwnProperty('url_names'))
			page.url_names = []
		if (!page.hasOwnProperty('url_name_index'))
			page.url_name_index = 0
		if (!page.hasOwnProperty('repeated'))
			page.repeated = false
		if (!page.hasOwnProperty('intro')) {
			page.intro = function(){
				LGen.component.snackbar.open({'str':LGen.translator.get(
					{"from_lang":"en", "words":"This page does not have any guidance."}
				), 'nolimit':false})
			}
		}
		if (!page.hasOwnProperty('check_intro')) {
			page.check_intro = function() {
				var _intro = LGen.intro.get({'safe':'safe'})[page.name]
				if (_intro === 0) {
					_intro = 1
					page.intro()
					var _asd = {}
					_asd[page.name] = _intro
					LGen.intro.set({'val':_asd,'safe':'safe'})
				}
			}
		}
	}

	this.add = add
	function add(page) {
		var compo = LGen.Page
		if (!compo.names.hasOwnProperty(page.name)) {
			LGen.Page.names[page.name] = page
			$(LGen.Page.names[page.name].screen).css({"display":"none"})
			compo.screen.appendChild(LGen.Page.names[page.name].screen)
		}
	}

	this.open_new_tab = open_new_tab
	function open_new_tab(url) {
		window.open(LGen.system.get({'safe':'safe'}).host+url)
	}

	this.change_url = change_url
	function change_url(new_url="") {
		if (new_url !== null)
			window.history.pushState('', null, LGen.system.get({'safe':'safe'}).change_url+'/'+new_url);
			// window.history.pushState({}, null, LGen.system.get({'safe':'safe'}).change_url+'/'+new_url);
			// window.history.replaceState("", "", LGen.system.get({'safe':'safe'}).change_url+'/'+new_url);
	}

  this.clear_banner_interval = clear_banner_interval
  function clear_banner_interval(page) {
		var length = page.move_banner_intervals.length
		for (var i=0; i<length;i++) {
			clearInterval(page.move_banner_intervals.shift())	
		}
  }

	this.update = update
	function update(key='all') {
		// if (LGen.citizen.get({'key':key,'safe':'safe'}) === val) return 0;

		// var asd = {}
		// asd[key] = val
		// LGen.citizen.set_all({'val':asd,'safe':'safe'})
		// lprint(LGen.citizen.get({'key':key,'safe':'safe'}))
		var _obj = []
		if (LGen.Page.current !== '')
			_obj.push(LGen.Page.names[LGen.Page.current])
		if (LGen.component.hasOwnProperty('signin'))
			_obj.push(LGen.component.signin)
		if (LGen.component.hasOwnProperty('account'))
			_obj.push(LGen.component.account)
		if (LGen.component.sidebar.hasOwnProperty('screen'))
			_obj.push(LGen.component.sidebar)
		if (LGen.component.hasOwnProperty('header'))
			_obj.push(LGen.component.header)
		if (LGen.component.hasOwnProperty('footbar'))
			_obj.push(LGen.component.footbar)
		if (LGen.component.footer.hasOwnProperty('screen'))
			_obj.push(LGen.component.footer)
		for (var i=0; i<_obj.length; i++) {
			if (key === 'theme_color' || key === 'all')
				LGen.Page.Self.update_color(_obj[i])
			if (key === 'theme_font' || key === 'all')
				LGen.Page.Self.update_font(_obj[i])
			if (key === 'fsize' || key === 'all')
				LGen.Page.Self.update_fsize(_obj[i])
			if (key === 'lang' || key === 'all')
				LGen.Page.Self.update_lang(_obj[i])
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
			LGen.Page.history_handle()
			LGen.Page.first_load = false
		}
		if (page_name === '')
			page_name = 'page_home'
		var page_previous = LGen.Page.current
		var go = true
		if (LGen.Page.current === page_name && !LGen.Page.names[LGen.Page.current].repeated)
			go = false

		if (go) {
			if (LGen.Page.current !== '') {
				// $(LGen.Page.names[LGen.Page.current].screen).slideUp(250)
				if (page_name !== page_previous) {
					var _page_screen = LGen.Page.names[LGen.Page.current].screen
					$(_page_screen).css({'opacity':0})
					setTimeout(function() {
						$(_page_screen).css({'display':'none'})
					}, LGen.Page.speed)
				}
				// $(LGen.Page.names[LGen.Page.current].screen).fadeOut()
				if (LGen.Page.when_closed[LGen.Page.current] !== null) {
					LGen.Page.when_closed[LGen.Page.current] = LGen.Page.names[LGen.Page.current].when_closed
				}
				LGen.Page.when_closed[LGen.Page.current](LGen.Page.names[LGen.Page.current])
			}
			LGen.Page.current = page_name
			
			if (LGen.Page.when_opened[page_name] !== null) {
				LGen.Page.when_opened[page_name] = LGen.Page.names[page_name].when_opened
			}

			if (page_previous === LGen.Page.current)
				var time = LGen.Page.speed
			else
				var time = 0
			// lprint('time', time)
			setTimeout(function() {
				// LGen.Page.when_opened[page_name](LGen.Page.names[page_name])
			}, time)
			// LGen.call({'c':'gen','f':'to_top'})(250)
			// $(LGen.Page.names[page_name].screen).slideDown(250)
			setTimeout(function() {
				LGen.Page.when_opened[page_name](LGen.Page.names[page_name])
				if (LGen.Page.current === page_name) {
					if (LGen.Page.current !== page_previous) {
						$(LGen.Page.names[page_name].screen).css({'display':'block'})
						if (!LGen.Page.names[page_name].self_show) {
							setTimeout(function() {
								$(LGen.Page.names[page_name].screen).css({'opacity':1})
							}, LGen.Page.speed)
						}
					}
					// LGen.call({'c':'gen','f':'to_top'})(250)
					if (LGen.Page.names[page_name].url_names.length > 0)
						LGen.Page.change_url(LGen.Page.names[page_name].url_names[LGen.Page.names[page_name].url_name_index])
				}
			}, LGen.Page.speed+time)

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
				// else if (LGen.Page.names[LGen.Page.current].previous_page === 'end') { LGen.Page.change_history(event, false) }
				else if (LGen.Page.current !== 'page_home') { LGen.Page.change(LGen.Page.names[LGen.Page.current].previous_page); LGen.Page.change_history(event) }
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
		this.update = update
		function update(page) {
			// LGen.Page.Self.update_css(page)
			// LGen.Page.Self.update_font(page)
			// LGen.Page.Self.update_color(page)
			// LGen.Page.Self.update_fsize(page)
			LGen.Page.Self.update_lang(page)

			if (page.hasOwnProperty('screen_footbar')) {
				var _page = page.screen_footbar
				// LGen.Page.Self.update_css(_page)
				// LGen.Page.Self.update_font(_page)
				// LGen.Page.Self.update_color(_page)
				// LGen.Page.Self.update_fsize(_page)
			}
		}

		this.update_css = update_css
		function update_css(page) {
			if (page.hasOwnProperty('screen'))
				var _page = page.screen
			else
				var _page = page
			LGen.Theme.Color.set(_page)
			LGen.Theme.Font.set(_page)
			LGen.Theme.FontSize.set(_page)
			LGen.Theme.Color.set(_page.querySelectorAll('.theme_color'))
			LGen.Theme.Font.set(_page.querySelectorAll('.theme_font'))
			LGen.Theme.FontSize.set(_page.querySelectorAll('.fsize'))
		}

		this.update_color = update_color
		function update_color(page) {
			// lprint(page)
			var go = true
			if (page.theme_color === LGen.citizen.get({'key':'theme_color','safe':'safe'}))
				go = false
			if (go) {
				LGen.Theme.Color.update_self({
					"elm": page.screen,
					"old_theme fp": page.theme_color,
					"new_theme fp": LGen.citizen.get({'key':'theme_color','safe':'safe'})
				})
				if (page.hasOwnProperty('screen_footbar')) {
					LGen.Theme.Color.update_self({
						"elm": page.screen_footbar,
						"old_theme fp": page.theme_color,
						"new_theme fp": LGen.citizen.get({'key':'theme_color','safe':'safe'})
					})
				}
				page.theme_color = LGen.citizen.get({'key':'theme_color','safe':'safe'})
			}
		}

		this.update_font = update_font
		function update_font(page) {
			var go = true
			if (page.theme_font === LGen.citizen.get({'key':'theme_font','safe':'safe'}))
				go = false
			if (go) {
				LGen.Theme.Font.update_self({
					"elm": page.screen,
					"old_theme fp": page.theme_font,
					"new_theme fp": LGen.citizen.get({'key':'theme_font','safe':'safe'})
				})
				if (page.hasOwnProperty('screen_footbar')) {
					LGen.Theme.Font.update_self({
						"elm": page.screen_footbar,
						"old_theme fp": page.theme_font,
						"new_theme fp": LGen.citizen.get({'key':'theme_font','safe':'safe'})
					})
				}
				page.theme_font = LGen.citizen.get({'key':'theme_font','safe':'safe'})
			}
		}

		this.update_fsize = update_fsize
		function update_fsize(page) {
			var go = true
			if (page.fsize === LGen.citizen.get({'key':'fsize','safe':'safe'}))
				go = false
			if (go) {
				LGen.Theme.FontSize.update_self({
					"elm": page.screen,
					"old_theme fp": page.fsize,
					"new_theme fp": LGen.citizen.get({'key':'fsize','safe':'safe'})
				})
				if (page.hasOwnProperty('screen_footbar')) {
					LGen.Theme.FontSize.update_self({
						"elm": page.screen_footbar,
						"old_theme fp": page.fsize,
						"new_theme fp": LGen.citizen.get({'key':'fsize','safe':'safe'})
					})
				}
				page.fsize = LGen.citizen.get({'key':'fsize','safe':'safe'})
			}
		}

		this.update_lang = update_lang
		function update_lang (page) {
			var go = true
			if (page.lang === LGen.citizen.get({'key':'lang','safe':'safe'}))
				go = false
			if (go) {
				var _obj = {}
				_obj['from_lang'] = page.lang
				_obj['lang'] = LGen.citizen.get({'key':'lang','safe':'safe'})
				if (page.hasOwnProperty('update_lang'))
					page.update_lang()
				// if (page.hasOwnProperty('load_content')) {
				// 	page.load_content(1)
				// }
				for (var i=0; i<page.lang_elms.length; i++) {
					_obj['elm'] = page.lang_elms[i].elm
					if (page.lang_elms[i].hasOwnProperty('type'))
						_obj['type'] = page.lang_elms[i].type
					else
						_obj['type'] = ''
					LGen.translator.update(_obj)
				}
				page.lang = LGen.citizen.get({'key':'lang','safe':'safe'})
			}
		}
	}
}