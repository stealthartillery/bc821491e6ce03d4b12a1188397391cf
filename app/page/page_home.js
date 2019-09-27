page_home = new PageHome()
page_home.set()

function PageHome () {
	this.name = 'page_home'
	this.url_names = ['']

	this.set = set
	function set () {
		var page = page_home

		page.screen = LGen.String.to_elm(
		'<div class="page_home">'+
			'<div class="banner">'+'</div>'+
			'<div class="poster">'+
			'<div class="section_title theme theme_font top_title2">'+'News'+'</div>'+
			'<div class="content2">'+'</div>'+
			'<div class="bottom_title2">'+
				'<a class="std theme theme_font" data-tooltip="See All News">See All News</a>'+
			'</div>'+
			'<div class="section_title theme theme_font top_title3">'+'Product'+'</div>'+
			'<div class="content3">'+'</div>'+
			'<div class="bottom_title3">'+
				'<a class="std theme theme_font" data-tooltip="See All Products">See All Products</a>'+
			'</div>'+
			'</div>'+
		'</div>')
		page.lang_elms = [
			{"elm":page.screen.querySelector('.section_title.top_title2')},
			{"elm":page.screen.querySelector('.section_title.top_title3')},
			{"elm":page.screen.querySelector('.bottom_title2 a'), "type":"data-tooltip"},
			{"elm":page.screen.querySelector('.bottom_title3 a'), "type":"data-tooltip"},
			{"elm":page.screen.querySelector('.bottom_title2 a')},
			{"elm":page.screen.querySelector('.bottom_title3 a')}
		]
		LGen.Page.set_keys(page)
		page.set_event()
		LGen.Page.add(page)
	}

	this.set_event = set_event
	function set_event() {
		var page = page_home
		page.screen.querySelector('.bottom_title2 a').addEventListener('click', function() {
			LGen.Page.change('page_news')
		})
		page.screen.querySelector('.bottom_title3 a').addEventListener('click', function() {
			LGen.Page.change('page_product')
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
		LGen.Page.Self.update_css(page)
		LGen.Page.Self.update_lang(page)
		LGen.Page.Self.update_color(page)
		LGen.Page.Self.update_font(page)
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
		if (page.lang_online === LGen.citizen.lang)
			go = false
		if (!update_lang)
			go = true
		if (go) {
			var _obj = {
				"func": "get_data",
				"json": {
					"dir": "assets/www.lanterlite.com/lang/page_home/banners/"+LGen.citizen.lang+".lgd", 
					"type": "lgd"
				}
			}
			LGen.f.send_get('update.lanterlite.com/update/', _obj, function(obj) {
				for (var i=0; i< obj.length; i++) {
					if (!update_lang) {
						var asd = LGen.String.to_elm(
							'<div class="bground" style="display: none;">'+
								'<img src="'+LGen.system.fe_url+'update.lanterlite.com/'+obj[i]['img']+'"/>'+
								'<div class="title sliding_text theme theme_font">'+obj[i]['title']+'</div>'+
								'<div class="subtitle sliding_text theme theme_font">'+obj[i]['sub']+'</div>'+
							'</div>'
						)
						page.screen.querySelector('.banner').appendChild(asd)
					}
					else {
						page.screen.querySelectorAll('.banner img')[i].src = LGen.system.fe_url+'update.lanterlite.com/'+obj[i]['img']
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
					"dir": "assets/www.lanterlite.com/lang/page_home/news/"+LGen.citizen.lang+".lgd", 
					"type": "lgd"
				}
			}
			LGen.f.send_get('update.lanterlite.com/update/', _obj, function(obj) {
				for (var i=0; i< obj.length; i++) {
					if (!update_lang) {
						var asd = LGen.String.to_elm(
							'<div class="bground">'+
								'<img class="img2" src="'+LGen.system.fe_url+'update.lanterlite.com/'+obj[i]['img']+'"/>'+
								'<div class="date2 theme theme_font">'+obj[i]['date']+'</div>'+
								'<div class="title2 theme theme_font">'+obj[i]['title']+'</div>'+
								'<div class="subtitle2 theme theme_font">'+obj[i]['sub']+'</div>'+
								'<a class="std link2 theme theme_font" data-tooltip="'+obj[i]['title']+'">'+obj[i]['link']['title']+'</a>'+
							'</div>'
						)
    				LGen.Page.Self.update_css(asd)
						asd.querySelector('.link2').addEventListener('click', LGen.f.create(obj[i]['link']['func']))
						page.screen.querySelector('.content2').appendChild(asd)
					}
					else {
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .date2')[i], "text":obj[i]['date'] })
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .title2')[i], "text":obj[i]['title'] })
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .subtitle2')[i], "text":obj[i]['sub'] })
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .link2')[i], "text":obj[i]['link']['title'] })
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .link2')[i], "type":"data-tooltip", "text":obj[i]['title'] })

						page.screen.querySelectorAll('.content2 .img2')[i].src = LGen.system.fe_url+'update.lanterlite.com/'+obj[i]['img']
					}
				}
			})
			var _obj = {
				"func": "get_data",
				"json": {
					"dir": "assets/www.lanterlite.com/lang/page_home/products/"+LGen.citizen.lang+".lgd", 
					"type": "lgd"
				}
			}
			LGen.f.send_get('update.lanterlite.com/update/', _obj, function(obj) {
				for (var i=0; i< obj.length; i++) {
					if (!update_lang) {
						var asd = LGen.String.to_elm(
							'<div class="bground">'+
								'<img class="img3" src="'+LGen.system.fe_url+'update.lanterlite.com/'+obj[i]['img']+'"/>'+
								'<div class="title3 theme theme_font">'+obj[i]['title']+'</div>'+
								'<div class="subtitle3 theme theme_font">'+obj[i]['sub']+'</div>'+
								'<a class="std link3 theme theme_font" data-tooltip="'+obj[i]['title']+'">'+obj[i]['link']['title']+'</a>'+
							'</div>'
						)
    				LGen.Page.Self.update_css(asd)
						asd.querySelector('.link3').addEventListener('click', LGen.f.create(obj[i]['link']['func']))
						page.screen.querySelector('.content3').appendChild(asd)
					}
					else {
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content3 .title3')[i], "text":obj[i]['title'] })
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content3 .subtitle3')[i], "text":obj[i]['sub'] })
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content3 .link3')[i], "text":obj[i]['link']['title'] })
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content3 .link3')[i], "type":"data-tooltip", "text":obj[i]['title'] })

						page.screen.querySelectorAll('.content3 .img3')[i].src = LGen.system.fe_url+'update.lanterlite.com/'+obj[i]['img']
					}
				}
			})
			page.lang_online = LGen.citizen.lang
		}
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = page_home
    LGen.Page.clear_banner_interval(page)
		LGen.Page.clear_childs(page.screen.querySelector('.banner'))
		LGen.Page.clear_childs(page.screen.querySelector('.content2'))
		LGen.Page.clear_childs(page.screen.querySelector('.content3'))
	}

	this.when_opened = when_opened
	function when_opened() {
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
			page.screen.appendChild(LGen.component.footer.screen)
		}, 250)
	}
}