LGen.component.config =  new function () {
	this.name = 'config'
	this.url_names = ['config']

	this.set = set
	function set () {
		var page = LGen.component.config
		page.screen_footbar = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="_footbar n1 theme fp">'+
				'<button class="std gold back theme fp bgclr1 hover1">'+LGen.icon.theme('left')+'</button>'+
			'</div>'
		)
		page.screen = LGen.call({'c':'str','f':'to_elm'})(
			'<div class="page_config" style="display: none;">'+
			'<div class="bground">'+
			'<div class="_bground">'+
				'<div class="top_title title theme fttl">'+'Configuration'+'</div>'+
				// '<div class="child arabic_text">'+
				// 	'<div class="title theme fp">'+'Arabic'+'</div>'+
				// 	'<div class="val">'+
				// 	'<select class="select theme fp">'+
				//     '<option value="on">On</option>'+
				//     '<option value="off">Off</option>'+
				// 	'</select>'+
				// '</div>'+
				// '<div class="child transliteration_text">'+
				// 	'<div class="title theme fp">'+'Transliteration'+'</div>'+
				// 	'<div class="val">'+
				// 	'<select class="select theme fp">'+
				//     '<option value="on">On</option>'+
				//     '<option value="off">Off</option>'+
				// 	'</select>'+
				// '</div>'+
				// '<div class="child translation_text">'+
				// 	'<div class="title theme fp">'+'Translation'+'</div>'+
				// 	'<div class="val">'+
				// 	'<select class="select theme fp">'+
				//     '<option value="on">On</option>'+
				//     '<option value="off">Off</option>'+
				// 	'</select>'+
				// '</div>'+
				// '<div class="child verse_by_word">'+
				// 	'<div class="title theme fp">'+'Verse by Word'+'</div>'+
				// 	'<div class="val">'+
				// 	'<select class="select theme fp">'+
				//     '<option value="on">On</option>'+
				//     '<option value="off">Off</option>'+
				// 	'</select>'+
				// '</div>'+
				// '<button class="std gold back_btn theme fp bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'+
			'</div>'
		)
		LGen.Page.init(page)
		page.set_event()
		// var ttl = LGen.component.config.screen.querySelectorAll('.child .title')
		// for (var i=0; i<ttl.length; i++) {
		// 	page.lang_elms.push({"elm":ttl[i]})
		// }
		page.lang_elms = [
			{"elm":page.screen.querySelector('.top_title')},
		]
		LGen.component.header.hide_when_scroll2(page.screen)
	}

	this.set_event = set_event
	function set_event () {
		var page = LGen.component.config

		LGen.set_button(page.screen_footbar.querySelector('.back'))
		LGen.set_button_click(page.screen_footbar.querySelector('.back'), function() {
			if (page.previous_page === 'page_config')
				page.previous_page = 'page_home'
			LGen.Page.change(page.previous_page)
		})

		// LGen.set_button(page.screen.querySelector('.back_btn'))
		// LGen.set_button_click(page.screen.querySelector('.back_btn'), function() {
		// 	if (page.previous_page === 'page_config')
		// 		page.previous_page = 'page_home'
		// 	LGen.Page.change(page.previous_page)
		// })

		// $(page.screen.querySelector('.arabic_text select')).change(function(){
		// 	LGen.config.set({'val':{'arabic_text':$(this).val()},'safe':'safe'})
		// });

		// $(page.screen.querySelector('.transliteration_text select')).change(function(){
		// 	LGen.config.set({'val':{'transliteration_text':$(this).val()},'safe':'safe'})
		// });

		// $(page.screen.querySelector('.translation_text select')).change(function(){
		// 	LGen.config.set({'val':{'translation_text':$(this).val()},'safe':'safe'})
		// });

		// $(page.screen.querySelector('.verse_by_word select')).change(function(){
		// 	LGen.config.set({'val':{'verse_by_word':$(this).val()},'safe':'safe'})
		// });

		LGen.call({'c':'gen','f':'read_file'})(LGen.system.get({'safe':'safe'}).home_url + "app/app.config.lgen", function(obj) {
			var keys = Object.keys(obj)
			for (var i=0; i<keys.length; i++) {

				// lprint(LGen.citizen.get({'key':'lang','safe':'safe'}))
				// lprint(LGen.translator.get({"from_lang":"en","words":obj[keys[i]].ttl}))
				var select = LGen.call({'c':'str','f':'to_elm'})(
				'<div class="child">'+
					'<div class="title theme fp">'+
						obj[keys[i]].ttl+
						// LGen.translator.get({"from_lang":"en","words":obj[keys[i]].ttl})+
						// LGen.translator.get({"from_lang":"en","words":obj[keys[i]].ttl})+
					'</div>'+
					'<div class="val">'+
					'<select class="select theme fp" data-config="'+keys[i]+'">'+
				    // '<option value="on">On</option>'+
				    // '<option value="off">Off</option>'+
					'</select>'+
				'</div>')
				var _sel = select.querySelector('select')
				// lprint(obj)
				// lprint(obj[keys[i]])
				for (var j=0; j<obj[keys[i]].opt.length; j++) {
					_sel.appendChild(LGen.call({'c':'str','f':'to_elm'})('<option value="'+obj[keys[i]].opt[j]+'">'+
						LGen.call({'c':'str','f':'to_title_case'})(obj[keys[i]].opt[j])+
					'</option>'))
				}
				$(_sel).change(function(){
					// lprint($(this).attr('data-config'))
					// lprint($(this).attr('data-config'))
					// $(this).val()
					var _cnf = {}
					_cnf[$(this).attr('data-config')] = {
						'sel' : $(this).val()
					}
					// lprint(_cnf)
					LGen.config.set({'val':_cnf,'safe':'safe'})
				});
				page.screen.querySelector('._bground').appendChild(select)
				page.lang_elms.push({"elm":select.querySelector('.title')})
			}
		})

	}

	this.update = update
	function update() {
		var page = LGen.component.config

		LGen.Page.Self.update(page)
		var cnf = LGen.config.get({'safe':'safe'})
		var keys = Object.keys(cnf)
		for (var i=0; i<keys.length; i++) {
			// lprint(cnf[keys[i]].sel)
			$(page.screen.querySelector('[data-config="'+keys[i]+'"]')).val(cnf[keys[i]].sel);
		}
		// page.update_color_list()
		// $(page.screen.querySelector('.arabic_text .val .select')).val(LGen.config.get({'safe':'safe'}).arabic_text);
		// $(page.screen.querySelector('.transliteration_text .val .select')).val(LGen.config.get({'safe':'safe'}).transliteration_text);
		// $(page.screen.querySelector('.translation_text .val .select')).val(LGen.config.get({'safe':'safe'}).translation_text);
		// $(page.screen.querySelector('.verse_by_word .val .select')).val(LGen.config.get({'safe':'safe'}).verse_by_word);
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.config
		$(LGen.component.header.screen.querySelector('.h_option.img')).removeClass('active')
		LGen.component.footbar.clear()
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.config
		page.update()
		$(LGen.component.header.screen.querySelector('.h_option.img')).addClass('active')
		LGen.component.footbar.add_plain(page.screen_footbar)
		LGen.component.header.show()
		LGen.component.footbar.show()
	}
}