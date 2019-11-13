page_about = new AboutPage()
page_about.set()

function AboutPage () {
  this.name = "page_about"
	this.url_names = ['about']
	this.self_show = true

  this.set = set
  function set() {
    var page = page_about
		page.screen_footbar = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="_footbar n1 theme fp">'+
				'<button class="std gold back theme fp bgclr1 hover1">'+LGen.icon.theme('left')+'</button>'+
			'</div>'
		)
		page.screen = LGen.call({'c':'str','f':'to_elm'})(
		'<div class="page_about">'+
		'<div class="_bground">'+
			'<div class="banner">'+'</div>'+
			'<div class="poster">'+
				'<div class="section_title theme fttl top_title2">'+'About Us'+'</div>'+
				'<div class="cc theme fp">'+''+'</div>'+
				'<div class="content2">'+'</div>'+
			'</div>'+
			'<div class="_footer">'+'</div>'+
		'</div>'+
		'</div>')
		page.screen.appendChild(LGen.component.footer.screen)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.section_title.top_title2')}
		]
    page.set_event()
    LGen.Page.init(page)
		LGen.component.header.hide_when_scroll2(page.screen)
  }

  this.set_event = set_event
  function set_event() {
    var page = page_about
		LGen.set_button_click(page.screen_footbar.querySelector('.back'), function() {
			LGen.Page.change(page.previous_page)
		})
  }

	this.move_banner_intervals = []
	this.move_banner = move_banner
	function move_banner() {
    var page = page_about
		page.move_banner_interval = setInterval(
			function() {
				var banner_total = page.screen.querySelectorAll('.banner .bground').length
				// lprint(banner_total)
				$(page.screen.querySelectorAll('.banner .bground')[page.current_banner]).fadeOut(0)
				page.current_banner += 1
				if (page.current_banner >= banner_total)
					page.current_banner = 0
				$(page.screen.querySelectorAll('.banner .bground')[page.current_banner]).fadeIn(250)
			}
		,7000)
	}

  this.update = update
  function update() {
    var page = page_about
    LGen.Page.Self.update(page)
		LGen.component.footer.update()
  }

  this.load_content = load_content
  function load_content(update_lang = false) {
    var page = page_about

		var go = true
		if (page.lang_online === LGen.citizen.get({'key':'lang','safe':'safe'}))
			go = false
		if (!update_lang)
			go = true
		if (go) {
			// lprint('ASDASDSDA')
			var _obj = {
				"func": "get_data",
				"json": {
					"dir": "assets/www.lanterlite.com/lang/page_about/banners/"+LGen.citizen.get({'key':'lang','safe':'safe'})+".lgd", 
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
    				// LGen.Page.Self.update_css(asd)
						page.screen.querySelector('.banner').appendChild(asd)
					}
					else {
						page.screen.querySelectorAll('.banner img')[i].src = LGen.system.get({'safe':'safe'}).fe_url+'update.lanterlite.com/'+obj[i]['img']
						LGen.translator.update({"elm":page.screen.querySelectorAll('.banner .title')[i], "text":obj[i]['title'] })
						LGen.translator.update({"elm":page.screen.querySelectorAll('.banner .subtitle')[i], "text":obj[i]['sub'] })
					}
				}
				// // LGen.Page.set_css(page.screen.querySelector('.banner'))
				// // LGen.Page.Self.update_css(page.screen.querySelector('.banner'))

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
					"dir": "assets/www.lanterlite.com/lang/page_about/abouts/description/"+LGen.citizen.get({'key':'lang','safe':'safe'})+".lgd", 
					"type": "lgd"
				}
			}
			LGen.call({'c':'req','f':'get'})('update.lanterlite.com/gate', _obj, function(obj) {
				LGen.translator.update({"elm":page.screen.querySelector('.cc'), "text":obj['text'] })
			})

			var _obj = {
				"func": "get_data",
				"json": {
					"dir": "assets/www.lanterlite.com/lang/page_about/abouts/"+LGen.citizen.get({'key':'lang','safe':'safe'})+".lgd", 
					"type": "lgd"
				}
			}
			LGen.call({'c':'req','f':'get'})('update.lanterlite.com/gate', _obj, function(obj) {
				for (var i=0; i< obj.length; i++) {
					if (!update_lang) {
						var asd = LGen.call({'c':'str','f':'to_elm'})(
							'<div class="bground theme hover2">'+
								'<img class="img2" src="'+LGen.system.get({'safe':'safe'}).fe_url+'update.lanterlite.com/'+obj[i]['img']+'"/>'+
								'<div class="title2 theme fp">'+obj[i]['title']+'</div>'+
								'<div class="subtitle2 theme fp">'+obj[i]['sub']+'</div>'+
								'<a class="std link2 theme fp" data-tooltip="'+obj[i]['title']+'">'+obj[i]['link']['title']+'</a>'+
							'</div>'
						)
						LGen.set_button(asd)
						LGen.set_button_click(asd, LGen.call({'c':'gen','f':'create'})(obj[i]['link']['func']))
						page.screen.querySelector('.content2').appendChild(asd)
					}
					else {
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .title2')[i], "text":obj[i]['title'] })
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .subtitle2')[i], "text":obj[i]['sub'] })
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .link2')[i], "text":obj[i]['link']['title'] })
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .link2')[i], "type":"data-tooltip", "text":obj[i]['title'] })

						page.screen.querySelectorAll('.content2 .img2')[i].src = LGen.system.get({'safe':'safe'}).fe_url+'update.lanterlite.com/'+obj[i]['img']
					}
				}
				// // LGen.Page.set_css(page.screen.querySelector('.content2'))
				// // LGen.Page.Self.update_css(page.screen.querySelector('.content2'))
				// lprint('')
				setTimeout(function() {
					$(page.screen).css({'opacity':1})
				}, LGen.Page.speed)
			})
			page.lang_online = LGen.citizen.get({'key':'lang','safe':'safe'})
	  }
	}

  this.when_closed = when_closed
  function when_closed() {
    var page = page_about
    LGen.Page.clear_banner_interval(page)
		LGen.Page.clear_childs(page.screen.querySelector('.banner'))
		LGen.Page.clear_childs(page.screen.querySelector('.content2'))
		LGen.component.footbar.clear()
  }

  this.when_opened = when_opened
  function when_opened() {
    var page = page_about
		// if (!page.hasOwnProperty('first_update')) {
		if (true) {
			page.first_update = true
			page.load_content()
	    page.update()
		}
		else {
	    page.update()
		}
		// setTimeout(function() {
		// 	page.screen.appendChild(LGen.component.footer.screen)
		// }, 250)
		setTimeout(function() {
			page.screen.querySelector('._footer').appendChild(LGen.component.footer.screen)
		}, LGen.Page.speed)
		LGen.component.footbar.add_plain(page.screen_footbar)
		LGen.component.header.show()
		LGen.component.footbar.show()
  }
}
