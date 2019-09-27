LGen.component.sidebar = new sidebar()
LGen.component.sidebar.set()

function sidebar() {
	this.page_names = [];

	this.opened = opened
	function opened() {
		var compo = LGen.component.sidebar
		return $(compo.screen).hasClass('opened')
	}

	this.open = open
	function open() {
		var compo = LGen.component.sidebar
		$(compo.screen.querySelector('.child.active1')).removeClass('active1')
		for (var i=0; i<compo.page_names.length; i++) {
			if (compo.page_names[i] === LGen.Page.current) {
				$(compo.screen.querySelector('#col'+i)).addClass('active1')
			}
		}
		LGen.Page.Self.update_css(compo)
		if (!$(compo.screen).hasClass('opened')) {
			$(compo.screen).addClass('opened')
			$(compo.bg).fadeIn(250)
			disable_canvas_scroll();
		}
	}

	this.close = close
	function close() {
		var compo = LGen.component.sidebar
		if ($(compo.screen).hasClass('opened')) {
			$(compo.screen).removeClass('opened')
			$(compo.bg).fadeOut(250)
			// $(compo.screen.querySelector('.child.active1')).removeClass('active1')
			enable_canvas_scroll();
		}
	}

	this.update = update
	function update(first_update=true) {
		var compo = LGen.component.sidebar

		LGen.Page.Self.update_css(compo)
		LGen.Page.Self.update_color(compo)
		LGen.Page.Self.update_font(compo)
		LGen.Page.Self.update_lang(compo)

		if (first_update) {
			var urls = [
				{'name': 'sidebar', 'url':HOME_URL + 'app/lang/component/sidebar/'+LGen.citizen.lang+'.lgen'}
			]

			LGen.lang.text_get(urls, 0, function() {
				lprint(first_update)
				for (var i=0; i< LGen.lang.text['sidebar'].length; i++) {
					compo.add({'id':'col'+i, 'icon':LGen.lang.text['sidebar'][i]['icon'], 'name':LGen.lang.text['sidebar'][i]['name'], 'callback':LGen.f.create(LGen.lang.text['sidebar'][i]['func']) })
					if (!LGen.Array.is_val_exist(compo.page_names, LGen.lang.text['sidebar'][i]['page_name']))
						compo.page_names.push(LGen.lang.text['sidebar'][i]['page_name'])
				}
			})
		}
		// else {
		// 	compo.screen.querySelector('#col'+i+' span').innerText = LGen.lang.text['sidebar'][i]['name']
		// }
	}

	this.add = add
	function add(obj={}) {
		var compo = LGen.component.sidebar
		var _component = LGen.String.to_elm(
			'<div id="'+obj.id+'" class="child theme theme_color hover1">'+
					I.obj[obj.icon]+
					'<span>'+obj.name+'</span>'+
			'</div>'
		)
		compo.lang_elms.push({"elm":_component.querySelector('#'+obj.id+' span')})
		_component.addEventListener('click', function() {
			// $(compo.screen.querySelector('.child.active1')).removeClass('active1')
			// $(this).addClass('active1')
			compo.close()
			obj.callback(this) 
		})
		compo.screen.appendChild(_component);
	}

	this.set = set
	function set() {
		var compo = LGen.component.sidebar
		compo.screen = LGen.String.to_elm('<div class="sidebar theme theme_font theme_color bgclr1">'+'</div>')
		compo.bg = LGen.String.to_elm('<div class="bg dark">'+'</div>')
		compo.lang_elms = []

		LGen.Page.set_keys(compo)
		LGen.Page.screen.appendChild(compo.screen)
		LGen.Page.screen.appendChild(compo.bg)
		compo.set_event()
		compo.update(1)
	}

	this.set_event = set_event
	function set_event() {
		var compo = LGen.component.sidebar
		compo.bg.addEventListener('click', function() {
			if (!$(compo.screen).hasClass('opened'))
				compo.open()
			else
				compo.close()
		})
	}
}

