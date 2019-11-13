LGen.component.sidebar = new sidebar()
// LGen.component.sidebar.set()

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
		LGen.Page.Self.update(compo)
		if (!compo.hasOwnProperty('screen'))
			return 0;
		$(compo.screen.querySelector('.child.active1')).removeClass('active1')
		var url_name = window.location.pathname.split('/')
		url_name = url_name[url_name.length-1]
		for (var i=0; i<compo.page_names.length; i++) {
			if (compo.page_names[i] === url_name) {
				$(compo.screen.querySelector('#col'+i)).addClass('active1')
			}
		}
		// LGen.Page.Self.update_css(compo)
		if (!$(compo.screen).hasClass('opened')) {
			$(compo.screen).addClass('opened')
			$(compo.bg).fadeIn(250)
			LGen.call({'c':'gen','f':'disable_canvas_scroll'})();
		}
	}

	this.close = close
	function close() {
		var compo = LGen.component.sidebar
		if ($(compo.screen).hasClass('opened')) {
			$(compo.screen).removeClass('opened')
			$(compo.bg).fadeOut(250)
			// $(compo.screen.querySelector('.child.active1')).removeClass('active1')
			LGen.call({'c':'gen','f':'enable_canvas_scroll'})();
		}
	}

	this.update = update
	function update(first_update=true) {
		var compo = LGen.component.sidebar


		if (first_update) {
			var urls = [
				{'name': 'sidebar', 'url':HOME_URL + 'app/lang/sidebar.lgen'}
			]

			LGen.lang.text_get(urls, 0, function() {
				if (LGen.call({'c':'black','f':'check'})({'val':LGen.lang.text['sidebar'],'safe':'safe'}))
					var obj = LGen.call({'c':'white','f':'get'})({'val':LGen.lang.text['sidebar'],'safe':'safe'})
				else
					var obj = LGen.lang.text['sidebar']
				for (var i=0; i< obj.length; i++) {
					compo.add({'id':'col'+i, 'icon':obj[i]['icon'], 'name':obj[i]['name'], 'callback':LGen.call({'c':'gen','f':'create'})(obj[i]['func']) })
					if (!LGen.call({'c':'arr','f':'is_val_exist'})(compo.page_names, obj[i]['page_name']))
						compo.page_names.push(obj[i]['page_name'])
				}
				// LGen.Page.set_css(compo.screen)
				// LGen.Page.Self.update_css(compo.screen)
			})
		}
		// else {
		// 	compo.screen.querySelector('#col'+i+' span').innerText = LGen.lang.text['sidebar'][i]['name']
		// }
	}

	this.add = add
	function add(obj={}) {
		var compo = LGen.component.sidebar
		var _component = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div id="'+obj.id+'" class="child theme hover1">'+
					LGen.icon.theme(obj.icon, 1)+
					'<span>'+obj.name+'</span>'+
			'</div>'
		)
		// LGen.Page.set_css(_component)
		// LGen.Page.Self.update_css(_component)
		compo.lang_elms.push({"elm":_component.querySelector('#'+obj.id+' span')})
		LGen.set_button(_component)
		LGen.set_button_click(_component, function(_this) {
			// $(compo.screen.querySelector('.child.active1')).removeClass('active1')
			// $(this).addClass('active1')
			compo.close()
			obj.callback(_this) 
		})
		compo.screen.appendChild(_component);
	}

	this.set = set
	function set() {
		var compo = LGen.component.sidebar
		compo.screen = LGen.call({'c':'str', 'f':'to_elm'})('<div class="sidebar theme fp bgclr1">'+'</div>')
		compo.bg = LGen.call({'c':'str', 'f':'to_elm'})('<div class="bg dark">'+'</div>')
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

