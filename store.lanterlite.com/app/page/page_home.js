page_home = new PageHome()
page_home.set()

function PageHome () {
	this.name = 'page_home'
	this.url_names = ['']
	this.self_show = true

	this.set = set
	function set () {
		var page = page_home

		page.screen_footbar = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="_footbar n2 theme fp">'+
				'<button class="std gold buy_lsilver theme fp bgclr1 hover1">'+'Buy L. Silver'+'</button>'+
				'<button class="std gold exc_lpoint theme fp bgclr1 hover1">'+'Xch. L. Point'+'</button>'+
			'</div>'
		)

		page.screen = LGen.call({'c':'str','f':'to_elm'})(
		'<div class="page_home">'+
			'<div class="_bground">'+
			'<div class="banner theme">'+'</div>'+
			'<div class="poster">'+
			'<div class="section_title theme fttl top_title2">'+'Licenses'+'</div>'+
			'<div class="content2 theme">'+'</div>'+
			// '<div class="bottom_title2">'+
			// 	'<a class="std theme fp" data-tooltip="See All News">See All Licenses</a>'+
			// '</div>'+
			'<div class="section_title theme fttl top_title3">'+'Storefront'+'</div>'+
			'<div class="content3 theme">'+'</div>'+
			// '<div class="bottom_title3">'+
			// 	'<a class="std theme fp" data-tooltip="See All Products">See All Products</a>'+
			// '</div>'+
			'</div>'+
			'<div class="_footer">'+'</div>'+
			'</div>'+
		'</div>')
		page.lang_elms = [
			{"elm":page.screen_footbar.querySelector('.exc_lpoint')},
			{"elm":page.screen_footbar.querySelector('.buy_lsilver')},
			{"elm":page.screen.querySelector('.section_title.top_title2')},
			{"elm":page.screen.querySelector('.section_title.top_title3')},
			// {"elm":page.screen.querySelector('.bottom_title2 a'), "type":"data-tooltip"},
			// {"elm":page.screen.querySelector('.bottom_title3 a'), "type":"data-tooltip"},
			// {"elm":page.screen.querySelector('.bottom_title2 a')},
			// {"elm":page.screen.querySelector('.bottom_title3 a')}
		]
		LGen.Page.init(page)
		page.set_event()
		LGen.component.header.hide_when_scroll2(page.screen)
	}

	this.set_event = set_event
	function set_event() {
		var page = page_home
		LGen.set_button(page.screen_footbar.querySelector('.buy_lsilver'))
		LGen.set_button_click(page.screen_footbar.querySelector('.buy_lsilver'), function() {
			LGen.Page.change_by_url('silver')
		})
		LGen.set_button(page.screen_footbar.querySelector('.exc_lpoint'))
		LGen.set_button_click(page.screen_footbar.querySelector('.exc_lpoint'), function() {
			LGen.Page.change_by_url('silver')
		})
	}

	this.move_banner_intervals = []
	this.move_banner = move_banner
	function move_banner() {
		var page = page_home
		page.move_banner_intervals.push(setInterval(
			function() {
				var banner_total = page.screen.querySelectorAll('.banner .bground').length
				// lprint(banner_total)
				$(page.screen.querySelectorAll('.banner .bground')[page.current_banner]).fadeOut(0)
				page.current_banner += 1
				if (page.current_banner >= banner_total)
					page.current_banner = 0
				$(page.screen.querySelectorAll('.banner .bground')[page.current_banner]).fadeIn(250)
			}
		,7000))
	}

	this.update = update
	function update() {
		var page = page_home
		lprint(page.screen)
		LGen.Page.Self.update(page)
		LGen.component.footer.update()

		// lprint('first_update', first_update)
		// if (first_update)
		// 	page.load_content()
		// else
		// 	page.load_content(true)
	}

	this.load_content = load_content
	function load_content(update_lang = false) {
		var page = page_home
		var go = true
		if (page.lang_online === LGen.citizen.get({'key':'lang','safe':'safe'}))
			go = false
		if (!update_lang)
			go = true
		if (go) {
			var _obj = {
				"func": "get_data",
				"json": {
					"dir": "assets/store.lanterlite.com/lang/page_home/banners/"+LGen.citizen.get({'key':'lang','safe':'safe'})+".lgd", 
					"type": "lgd"
				}
			}
			LGen.call({'c':'req','f':'get'})('update.lanterlite.com/gate', _obj, function(obj) {
				for (var i=0; i< obj.length; i++) {
					if (!update_lang) {
						var asd = LGen.call({'c':'str','f':'to_elm'})(
							'<div class="bground" style="display: none;">'+
								'<img src="'+LGen.system.get({'safe':'safe'}).fe_url+'update.lanterlite.com/'+obj[i]['img']+'"/>'+
								'<div class="title sliding_text theme">'+obj[i]['title']+'</div>'+
								'<div class="subtitle sliding_text theme">'+obj[i]['sub']+'</div>'+
							'</div>'
						)
						page.screen.querySelector('.banner').appendChild(asd)
					}
					else {
						page.screen.querySelectorAll('.banner img')[i].src = LGen.system.get({'safe':'safe'}).fe_url+'update.lanterlite.com/'+obj[i]['img']
						LGen.translator.update({"elm":page.screen.querySelectorAll('.banner .title')[i], "text":obj[i]['title'] })
						LGen.translator.update({"elm":page.screen.querySelectorAll('.banner .subtitle')[i], "text":obj[i]['sub'] })
					}
				}

				if (!update_lang) {
					if (page.screen.querySelectorAll('.banner .bground').length >0 )
						$(page.screen.querySelectorAll('.banner .bground')[0]).fadeIn(0)
					page.current_banner = 0
					page.move_banner()
				}
			})
			var _obj = {
				"func": "get_data",
				"json": {
					"dir": "assets/store.lanterlite.com/lang/page_home/licenses/"+LGen.citizen.get({'key':'lang','safe':'safe'})+".lgd", 
					"type": "lgd"
				}
			}
			lprint(LGen.citizen.get({'key':'lang','safe':'safe'}))
			LGen.call({'c':'req','f':'get'})('update.lanterlite.com/gate', _obj, function(obj) {
				lprint(obj)
				for (var i=0; i< obj.length; i++) {
					if (!update_lang) {
						var _obj = {
							"json": {
								// "namelist":["name","sh_desc"],
								"gate":"store",
								"val":{
									"lang":LGen.citizen.get({'key':'lang','safe':'safe'}),
									"prod_id":obj[i]
								},
								// "bridge":[{"id":"products", "puzzled": true}, {"id":obj[i], "puzzled": false}, {"id":"detail", "puzzled": true}, {"id":LGen.citizen.get({'key':'lang','safe':'safe'}), "puzzled": true}],
								// "def":"products/detail"
							},
							"func": "$store->home_content"
						}
						lprint(_obj)
						LGen.call({'c':'req','f':'get'})('be.store.lanterlite.com/gate', _obj, function(item) {
							lprint(item)
							var name = (item['name'])
							var sh_desc = (item['sh_desc'])
							lprint(item['img'])
							var img = (item['img']['url'])

							var asd = LGen.call({'c':'str','f':'to_elm'})(
								'<div class="bground theme hover2">'+
									'<img class="img2" src="'+LGen.system.get({'safe':'safe'}).fe_url+'image.lanterlite.com/'+img+'"/>'+
									// '<div class="date2 theme fp">'+obj[i]['date']+'</div>'+
									'<div class="title2 theme fsttl">'+name+'</div>'+
									'<div class="subtitle2 theme fp">'+sh_desc+'</div>'+
									'<a class="std link2 theme fp" data-tooltip="'+name+'">Detail</a>'+
								'</div>'
							)
	    				// // LGen.Page.set_css(asd)
	    				// // LGen.Page.Self.update_css(asd)
							LGen.set_button(asd)
							LGen.set_button_click(asd, LGen.call({'c':'gen','f':'create'})("LGen.Page.change_by_url('item/"+item['id']+"')"))
							page.screen.querySelector('.content2').appendChild(asd)

						})
					}
					else {
						// // LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .date2')[i], "text":obj[i]['date'] })
						// LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .title2')[i], "text":obj[i]['title'] })
						// LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .subtitle2')[i], "text":obj[i]['sub'] })
						// LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .link2')[i], "text":obj[i]['link']['title'] })
						// LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .link2')[i], "type":"data-tooltip", "text":obj[i]['title'] })

						// page.screen.querySelectorAll('.content2 .img2')[i].src = LGen.system.get({'safe':'safe'}).fe_url+'update.lanterlite.com/'+obj[i]['img']
					}
				}
			})

			var _obj = {
				"func": "get_data",
				"json": {
					"dir": "assets/store.lanterlite.com/lang/page_home/storefront/"+LGen.citizen.get({'key':'lang','safe':'safe'})+".lgd", 
					"type": "lgd"
				}
			}
			LGen.call({'c':'req','f':'get'})('update.lanterlite.com/gate', _obj, function(obj) {
				lprint(obj)
				for (var i=0; i< obj.length; i++) {
					if (!update_lang) {
						var _obj = {
							"json": {
								// "namelist":["name","sh_desc"],
								"gate":"store",
								"val":{
									"lang":LGen.citizen.get({'key':'lang','safe':'safe'}),
									"prod_id":obj[i]
								},
								// "bridge":[{"id":"products", "puzzled": true}, {"id":obj[i], "puzzled": false}, {"id":"detail", "puzzled": true}, {"id":LGen.citizen.get({'key':'lang','safe':'safe'}), "puzzled": true}],
								// "def":"products/detail"
							},
							"func": "$store->home_content"
						}
						lprint(_obj)
						LGen.call({'c':'req','f':'get'})('be.store.lanterlite.com/gate', _obj, function(item) {
							lprint(item)
							var name = (item['name'])
							var sh_desc = (item['sh_desc'])
							lprint(item['img'])
							var img = (item['img']['url'])

							var asd = LGen.call({'c':'str','f':'to_elm'})(
								'<div class="bground theme hover2">'+
									'<img class="img3" src="'+LGen.system.get({'safe':'safe'}).fe_url+'image.lanterlite.com/'+img+'"/>'+
									// '<div class="date2 theme fp">'+obj[i]['date']+'</div>'+
									'<div class="title3 theme fsttl">'+name+'</div>'+
									'<div class="subtitle3 theme fp">'+sh_desc+'</div>'+
									'<a class="std link3 theme fp" data-tooltip="'+name+'">Detail</a>'+
								'</div>'
							)
	    				// // LGen.Page.set_css(asd)
	    				// // LGen.Page.Self.update_css(asd)
							LGen.set_button(asd)
							LGen.set_button_click(asd, LGen.call({'c':'gen','f':'create'})("LGen.Page.change_by_url('item/"+item['id']+"')"))
							page.screen.querySelector('.content3').appendChild(asd)

						})
					}
					else {
						// // LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .date2')[i], "text":obj[i]['date'] })
						// LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .title2')[i], "text":obj[i]['title'] })
						// LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .subtitle2')[i], "text":obj[i]['sub'] })
						// LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .link2')[i], "text":obj[i]['link']['title'] })
						// LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .link2')[i], "type":"data-tooltip", "text":obj[i]['title'] })

						// page.screen.querySelectorAll('.content2 .img2')[i].src = LGen.system.get({'safe':'safe'}).fe_url+'update.lanterlite.com/'+obj[i]['img']
					}
				}
				setTimeout(function() {
					$(page.screen).css({'opacity':1})
				}, LGen.Page.speed)
			})
			page.lang_online = LGen.citizen.get({'key':'lang','safe':'safe'})
		}
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = page_home
    LGen.Page.clear_banner_interval(page)
		LGen.Page.clear_childs(page.screen.querySelector('.banner'))
		LGen.Page.clear_childs(page.screen.querySelector('.content2'))
		LGen.Page.clear_childs(page.screen.querySelector('.content3'))
		LGen.component.footbar.clear()
	}

	this.when_opened = function () {
		var page = page_home
		if (true) {
		// if (!page.hasOwnProperty('first_update')) {
			page.first_update = true
			page.load_content()
	    page.update()
		}
		else {
	    page.update()
		}
		setTimeout(function() {
			page.screen.querySelector('._footer').appendChild(LGen.component.footer.screen)
			$(LGen.component.footer.screen).show()
		}, LGen.Page.speed)
		 // opacity footer
		LGen.component.footbar.add_plain(page.screen_footbar)
		LGen.component.header.show()
		LGen.component.footbar.show()
	}
}