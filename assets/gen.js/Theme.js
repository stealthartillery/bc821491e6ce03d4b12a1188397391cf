LGen.Theme = new Theme()

function Theme() {
	this.get_name_by_type = get_name_by_type
	function get_name_by_type(theme_type) {
		var _name = ''
		if (theme_type === 'theme_color')
			_name = 'Color Theme'
		else if (theme_type === 'theme_font')
			_name = 'Font Theme'
		return _name
	}

	this.Color = new Color()
	function Color(new_theme) {
		this.id = 'ca01' 

		this.update = update
		function update (new_theme) {
			var go = true
			if (LGen.citizen.theme_color === new_theme)
				go = false
			if (go) {
				LGen.citizen.theme_color = new_theme
				var _obj = {"old_theme":this.id, "new_theme":LGen.citizen.theme_color}
				var _screen = [
					LGen.component.signin.screen,
					LGen.component.account.screen,
					LGen.component.sidebar.screen,
					LGen.component.footer.screen
				]
				for (var i=0; i<_screen.length; i++) {
					_obj['elm'] = _screen[i]
					LGen.Theme.Color.update_self(_obj)
				}
				this.id = LGen.citizen.theme_color
				LGen.citizen.update_savior({'namelist':['theme_color']})
			}
		}

		this.set = set
		function set(elms) {
			if (elms && elms.nodeType === Node.ELEMENT_NODE) {
				$(elms).removeClass('theme_color').addClass(LGen.citizen.theme_color)
				if (!$(elms).hasClass('theme'))
					$(elms).addClass('theme')
			}
			else {
				for (var j=0; j<elms.length; j++) {
					$(elms[j]).removeClass('theme_color').addClass(LGen.citizen.theme_color)
					if (!$(elms[j]).hasClass('theme'))
						$(elms[j]).addClass('theme')
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
			LGen.citizen.theme_color = new_theme
			var _obj = {
				"old_theme":this.id,
				"new_theme":LGen.citizen.theme_color
			}
			var _screen = [
				LGen.component.signin.screen,
				LGen.component.account.screen,
				LGen.component.sidebar.screen,
				LGen.component.footer.screen
			]

			for (var i=0; i<_screen.length; i++) {
				_obj['elm'] = _screen[i]
				LGen.Theme.Font.update_self(_obj)
			}

			this.id = LGen.citizen.theme_color
			LGen.citizen.update_savior({'namelist':['theme_color']})

			// var elms = document.querySelectorAll('.theme.'+LGen.Theme.Font.id)
			// for (var i=0; i<elms.length; i++) {
			// 	LGen.Theme.Font.process(elms[i], LGen.Theme.Font.id, new_theme)
			// }
			// LGen.Theme.Font.id = new_theme
			// LGen.citizen.theme_font = new_theme
		}

		this.process = process
		function process(elm, old_theme, new_theme) {
			lprint(elm)
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
				$(elms).removeClass('theme_font').addClass(LGen.citizen.theme_font)
				if (!$(elms).hasClass('theme'))
					$(elms).addClass('theme')
			}
			else {
				for (var j=0; j<elms.length; j++) {
					$(elms[j]).removeClass('theme_font').addClass(LGen.citizen.theme_font)
					if (!$(elms[j]).hasClass('theme'))
						$(elms[j]).addClass('theme')
				}
			}
		}
	}
}

