
(new function () {
	this.name = 'lgen_page_content'
	this.repeated = true
	this.url_names = []
	this.content_paths = []

	this.set = set
	function set () {
		LGen.component.content = this
		var page = this
		page.screen_footbar = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="_footbar n1 theme fp">'+
				'<button class="std gold back theme fp bgclr1 hover1">'+LGen.icon.theme('left')+'</button>'+
			'</div>'
		)
		page.screen = LGen.call({'c':'str','f':'to_elm'})(
			'<div class="lgen_page_content theme fp" style="display: none;">'+
			'<div class="_bground">'+
				'<div class="bground">'+
					'<div class="child theme fp">'+
						// '<div class="content">'+'</div>'+
					'</div>'+
					// '<button class="std gold back_btn theme fp bgclr1 hover1">'+'Back'+'</button>'+
				'</div>'+
				'<div class="_footer">'+'</div>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			// {"elm": page.screen.querySelector('.bground .back_btn')}
		]

		page.set_event()
    LGen.Page.init(page)
		LGen.component.header.hide_when_scroll2(page.screen)
		// LGen.component.header.hide_when_scroll2(page.screen.querySelector('._bground'))
	}

	this.set_online = function () {
		var page = this
		var _obj = {
			"func": "get_data",
			"json": {
				"dir": "assets/content_list/"+LGen.app.get({'safe':'safe'}).codename+".lgd", 
				"type": "lgd"
			}
		}
		LGen.call({'c':'req','f':'get'})('update.lanterlite.com/gate', _obj, function(obj) {
			// lprint(obj)
			for(var i=0; i<obj.length; i++) {
				page.content_paths.push(obj[i]['content_path'])
				page.url_names.push(obj[i]['url_name'])
			}
		})
	}

	this.set_event = set_event
	function set_event() {
		var page = this

		LGen.call({'c':'gen','f':'read_file'})(LGen.system.get({'safe':'safe'}).base_url+'assets/gen_obj/content.lgen', function(obj) {
			// lprint(obj)
			for(var i=0; i<obj.length; i++) {
				page.content_paths.push(obj[i]['content_path'])
				page.url_names.push(obj[i]['url_name'])
			}
		})

		LGen.call({'c':'gen','f':'read_file'})(LGen.system.get({'safe':'safe'}).home_url+'app/lang/content.lgen', function(obj) {
		// LGen.call({'c':'req','f':'read_local'})(LGen.system.get({'safe':'safe'}).home_url+'app/lang/page/content/'+LGen.citizen.get({'key':'lang','safe':'safe'}), function(obj) {
			// lprint(obj)
			for(var i=0; i<obj.length; i++) {
				page.content_paths.push(obj[i]['content_path'])
				page.url_names.push(obj[i]['url_name'])
			}
		})

		LGen.set_button(page.screen_footbar.querySelector('.back'))
		LGen.set_button_click(page.screen_footbar.querySelector('.back'), function() {
			LGen.Page.change(page.previous_page)
		})
		// LGen.set_button(page.screen.querySelector('.back_btn'))
		// LGen.set_button_click(page.screen.querySelector('.back_btn'), function() {
		// 	LGen.Page.change(page.previous_page)
		// })
	}

	this.load_content = load_content
	function load_content(update_lang = false) {
		var page = this
		// lprint(page)
		// LGen.call({'c':'elm','f':'clear_childs'})(page.screen.querySelector('.lgen_page_content .child'))
		var _obj = {
			"func": "get_data",
			"json": {
				"dir": "assets/"+page.content_paths[page.url_name_index]+LGen.citizen.get({'key':'lang','safe':'safe'})+".lgd", 
				"type": "lgd"
			}
		}
		LGen.call({'c':'req','f':'get'})('update.lanterlite.com/gate', _obj, function(obj) {
			var asd = LGen.call({'c':'str','f':'to_elm'})(decodeURIComponent(obj))
			// lprint(asd)
			// LGen.Page.set_css(asd)
			// LGen.Page.Self.update_css(asd)
			$(asd).css({'opacity':0})
			// $(page.screen.querySelector('.lgen_page_content .child .content')).css({'opacity':0})
			setTimeout(function() {
				$(page.screen.querySelector('.lgen_page_content .child')).html(asd)
				setTimeout(function() {
					$(asd).css({'opacity':1})
				}, 50)
				// $(page.screen.querySelector('.lgen_page_content .child .content')).css({'opacity':1})
			}, LGen.Page.speed)
		})
	}

	this.update = update
	function update() {
		var page = this
		LGen.Page.Self.update(page)
	}

	this.when_closed = function (page) {
		LGen.Page.clear_childs(page.screen.querySelector('.lgen_page_content .child'))
		page.previous_page = ''
		LGen.component.footbar.clear()
	}

	this.when_opened = function (page) {
		// lprint(page)
		page.load_content()
		page.update()
		// setTimeout(function() {
		// 	page.screen.appendChild(LGen.component.footer.screen)
		// }, 250)
		// setTimeout(function() {
		// 	page.screen.querySelector('._footer').appendChild(LGen.component.footer.screen)
		// }, LGen.Page.speed)
		LGen.component.footbar.add_plain(page.screen_footbar)
		LGen.component.header.show()
		LGen.component.footbar.show()
	}
}).set()