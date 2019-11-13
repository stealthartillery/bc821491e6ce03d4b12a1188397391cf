LGen.Theme = new Theme()

function Theme() {

	this.new_change_clr = function (new_theme) {
		var theme = document.querySelector('.lthmclr')
		if (theme === null) {
			theme = LGen.call({'c':'str', 'f':'to_elm'})('<style class="lthmclr">'+'</style>')
			document.head.appendChild(theme)
		}
		LGen.call({'c':'gen','f':'read_file'})(LGen.system.get({'safe':'safe'}).base_url + "assets/gen_css/lthmclr/"+new_theme+".css", function(obj) {
			theme.innerHTML = obj
    }, 'text')
	}

	this.new_change_fs = function (new_theme) {
		var theme = document.querySelector('.lthmfs')
		if (theme === null) {
			theme = LGen.call({'c':'str', 'f':'to_elm'})('<style class="lthmfs">'+'</style>')
			document.head.appendChild(theme)
		}
		LGen.call({'c':'gen','f':'read_file'})(LGen.system.get({'safe':'safe'}).base_url + "assets/gen_css/lthmfs/"+new_theme+".css", function(obj) {
			theme.innerHTML = obj
    }, 'text')
	}

	this.new_change_ft = function (new_theme) {
		var theme = document.querySelector('.lthmft')
		if (theme === null) {
			theme = LGen.call({'c':'str', 'f':'to_elm'})('<style class="lthmft">'+'</style>')
			document.head.appendChild(theme)
		}
		LGen.call({'c':'gen','f':'read_file'})(LGen.system.get({'safe':'safe'}).base_url + "assets/gen_css/lthmft/"+new_theme+".css", function(obj) {
			theme.innerHTML = obj
    }, 'text')
	}

	this.get_name_by_type = get_name_by_type
	function get_name_by_type(theme_type) {
		var _name = ''
		if (theme_type === 'theme_color')
			_name = 'Color Theme'
		else if (theme_type === 'theme_font')
			_name = 'Font Theme'
		else if (theme_type === 'fsize')
			_name = 'Font Size'
		else if (theme_type === 'full')
			_name = 'Full'
		return _name
	}

	this.Color = new Color()
	function Color(new_theme) {
		this.id = 'ca01' 

		this.update = update
		function update (new_theme) {
			// var go = true
			// if (LGen.citizen.get({'key':'theme_color','safe':'safe'}) === new_theme)
			// 	go = false
			// if (go) {
			// 	LGen.citizen.set_all({'val':{'theme_color':new_theme},'safe':'safe'})
				var _obj = {
					"old_theme fp":this.id, 
					"new_theme fp":LGen.citizen.get({'key':'theme_color','safe':'safe'})
				}
				var _screen = [
					LGen.component.header.screen,
					LGen.component.footbar.screen,
					LGen.component.signin.screen,
					LGen.component.account.screen,
					LGen.component.sidebar.screen,
					LGen.component.footer.screen
				]
				for (var i=0; i<_screen.length; i++) {
					_obj['elm'] = _screen[i]
					LGen.Theme.Color.update_self(_obj)
				}
				this.id = LGen.citizen.get({'key':'theme_color','safe':'safe'})
				// LGen.citizen.update_savior({'namelist':['theme_color']})
			// }
		}

		this.set = set
		function set(elms) {
			if (elms && elms.nodeType === Node.ELEMENT_NODE) {
				if ($(elms).hasClass('theme_color')) {
					$(elms).removeClass('theme_color').addClass(LGen.citizen.get({'key':'theme_color','safe':'safe'}))
					if (!$(elms).hasClass('theme'))
						$(elms).addClass('theme')
				}
			}
			else {
				for (var j=0; j<elms.length; j++) {
					if ($(elms[j]).hasClass('theme_color')) {
						$(elms[j]).removeClass('theme_color').addClass(LGen.citizen.get({'key':'theme_color','safe':'safe'}))
						if (!$(elms[j]).hasClass('theme'))
							$(elms[j]).addClass('theme')
					}
				}
			}
		}

		/* completed */
		this.update_self = update_self
		function update_self (obj) {
			/* ['elm', 'new_theme', 'old_theme'] */
			if (obj['old_theme'] !== obj['new_theme']) {
				if ($(obj['elm']).hasClass(obj['old_theme']))
					$(obj['elm']).removeClass(obj['old_theme']).addClass(obj['new_theme'])

				var elms = obj['elm'].querySelectorAll('.theme.'+obj['old_theme'])
				for (var i=0; i<elms.length; i++) {
					$(elms[i]).removeClass(obj['old_theme']).addClass(obj['new_theme'])
				}
			}
		}
	}

	this.Font = new Font()
	function Font(new_theme) {
		this.id = 'fa01' 
		this.update = update
		function update (new_theme) {
			// LGen.citizen.theme_color = new_theme
			LGen.citizen.set_all({'val':{'theme_font':new_theme},'safe':'safe'})
			var _obj = {
				"old_theme fp":this.id,
				"new_theme fp":LGen.citizen.get({'key':'theme_font','safe':'safe'})
			}
			var _screen = [
				LGen.component.header.screen,
				LGen.component.footbar.screen,
				LGen.component.signin.screen,
				LGen.component.account.screen,
				LGen.component.sidebar.screen,
				LGen.component.footer.screen
			]

			for (var i=0; i<_screen.length; i++) {
				_obj['elm'] = _screen[i]
				LGen.Theme.Font.update_self(_obj)
			}

			this.id = LGen.citizen.get({'key':'theme_font','safe':'safe'})
			// LGen.citizen.update_savior({'namelist':['theme_font']})

			// var elms = document.querySelectorAll('.theme.'+LGen.Theme.Font.id)
			// for (var i=0; i<elms.length; i++) {
			// 	LGen.Theme.Font.process(elms[i], LGen.Theme.Font.id, new_theme)
			// }
			// LGen.Theme.Font.id = new_theme
			// LGen.citizen.theme_font = new_theme
		}

		this.process = process
		function process(elm, old_theme, new_theme) {
			// lprint(elm)
			$(elm).addClass('color_transparent')
			// $(elm).css({'font-weight':'bold'})
			setTimeout(function() {
				$(elm).removeClass('color_transparent').removeClass(old_theme).addClass(new_theme)
				// $(elm).css({'font-weight':'200'})
			}, 250)
		}

		this.update_self = update_self
		function update_self (obj) {
			if (obj['old_theme'] !== obj['new_theme']) {
				if ($(obj['elm']).hasClass(obj['old_theme']))
					$(obj['elm']).removeClass(obj['old_theme']).addClass(obj['new_theme'])

				var elms = obj['elm'].querySelectorAll('.theme.'+obj['old_theme'])
				for (var i=0; i<elms.length; i++) {
					this.process(elms[i], obj['old_theme'], obj['new_theme'])
					// $(elms[i]).removeClass(obj['old_theme']).addClass(obj['new_theme'])
				}
			}
		}

		this.set = set
		function set(elms) {
			if (elms && elms.nodeType === Node.ELEMENT_NODE) {
				if ($(elms).hasClass('theme_font')) {
					$(elms).removeClass('theme_font').addClass(LGen.citizen.get({'key':'theme_font','safe':'safe'}))
					if (!$(elms).hasClass('theme'))
						$(elms).addClass('theme')
				}
			}
			else {
				for (var j=0; j<elms.length; j++) {
					if ($(elms[j]).hasClass('theme_font')) {
						$(elms[j]).removeClass('theme_font').addClass(LGen.citizen.get({'key':'theme_font','safe':'safe'}))
						if (!$(elms[j]).hasClass('theme'))
							$(elms[j]).addClass('theme')
					}
				}
			}
		}
	}

	this.FontSize = new FontSize()
	function FontSize(new_theme) {
		this.id = 'fs01' 

		this.update = update
		function update (new_theme) {
			// var go = true
			// if (LGen.citizen.get({'key':'fsize','val':new_theme,'safe':'safe'}) === new_theme)
			// 	go = false
			// if (go) {
			// 	LGen.citizen.set_all({'val':{'fsize':new_theme},'safe':'safe'})
				var _obj = {
					"old_theme fp":this.id, 
					"new_theme fp":LGen.citizen.get({'key':'fsize','safe':'safe'})
				}
				var _screen = [
					LGen.component.header.screen,
					LGen.component.footbar.screen,
					LGen.component.signin.screen,
					LGen.component.account.screen,
					LGen.component.sidebar.screen,
					LGen.component.footer.screen
				]
				for (var i=0; i<_screen.length; i++) {
					_obj['elm'] = _screen[i]
					LGen.Theme.FontSize.update_self(_obj)
				}
				this.id = LGen.citizen.get({'key':'fsize','safe':'safe'})
				// LGen.citizen.update_savior({'namelist':['fsize']})
			// }
		}

		this.set = set
		function set(elms) {
			if (elms && elms.nodeType === Node.ELEMENT_NODE) {
				if ($(elms).hasClass('fsize')) {
					$(elms).removeClass('fsize').addClass(LGen.citizen.get({'key':'fsize','safe':'safe'}))
					if (!$(elms).hasClass('theme'))
						$(elms).addClass('theme')
				}
			}
			else {
				for (var j=0; j<elms.length; j++) {
					if ($(elms[j]).hasClass('fsize')) {
						$(elms[j]).removeClass('fsize').addClass(LGen.citizen.get({'key':'fsize','safe':'safe'}))
						if (!$(elms[j]).hasClass('theme'))
							$(elms[j]).addClass('theme')
					}
				}
			}
		}

		/* completed */
		this.update_self = update_self
		function update_self (obj) {
			/* ['elm', 'new_theme', 'old_theme'] */
			if (obj['old_theme'] !== obj['new_theme']) {
				if ($(obj['elm']).hasClass(obj['old_theme']))
					$(obj['elm']).removeClass(obj['old_theme']).addClass(obj['new_theme'])

				var elms = obj['elm'].querySelectorAll('.theme.'+obj['old_theme'])
				for (var i=0; i<elms.length; i++) {
					$(elms[i]).removeClass(obj['old_theme']).addClass(obj['new_theme'])
				}
			}
		}
	}
}

