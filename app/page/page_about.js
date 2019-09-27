page_about = new AboutPage()
page_about.set()

function AboutPage () {
  this.name = "page_about"
	this.url_names = ['about']

  this.set = set
  function set() {
    var page = page_about
		page.screen = LGen.String.to_elm(
		'<div class="page_about">'+
			'<div class="banner">'+'</div>'+
			'<div class="poster">'+
			'<div class="section_title theme theme_font top_title2">'+'About Us'+'</div>'+
			'<div class="cc theme theme_font">'+''+'</div>'+
			'<div class="content2">'+'</div>'+
			'</div>'+
		'</div>')
		page.screen.appendChild(LGen.component.footer.screen)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.section_title.top_title2')}
		]
    page.set_event()
    LGen.Page.set_keys(page)
		// page.load_content()
    LGen.Page.add(page)
  }

  this.set_event = set_event
  function set_event() {
    var page = page_about
  }

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
    LGen.Page.Self.update_css(page)
    LGen.Page.Self.update_color(page)
    LGen.Page.Self.update_font(page)
    LGen.Page.Self.update_lang(page)
		LGen.component.footer.update()
  }

  this.load_content = load_content
  function load_content(update_lang = false) {
    var page = page_about

		var go = true
		if (page.lang_online === LGen.citizen.lang)
			go = false
		if (!update_lang)
			go = true
		if (go) {
			var _obj = {
				"func": "get_data",
				"json": {
					"dir": "assets/www.lanterlite.com/lang/page_about/banners/"+LGen.citizen.lang+".lgd", 
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
    				LGen.Page.Self.update_css(asd)
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
				}
			})

			var _obj = {
				"func": "get_data",
				"json": {
					"dir": "assets/www.lanterlite.com/lang/page_about/abouts/description/"+LGen.citizen.lang+".lgd", 
					"type": "lgd"
				}
			}
			LGen.f.send_get('update.lanterlite.com/update/', _obj, function(obj) {
				LGen.translator.update({"elm":page.screen.querySelector('.cc'), "text":obj['text'] })
			})

			var _obj = {
				"func": "get_data",
				"json": {
					"dir": "assets/www.lanterlite.com/lang/page_about/abouts/"+LGen.citizen.lang+".lgd", 
					"type": "lgd"
				}
			}
			LGen.f.send_get('update.lanterlite.com/update/', _obj, function(obj) {
				for (var i=0; i< obj.length; i++) {
					if (!update_lang) {
						var asd = LGen.String.to_elm(
							'<div class="bground">'+
								'<img class="img2" src="'+LGen.system.fe_url+'update.lanterlite.com/'+obj[i]['img']+'"/>'+
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
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .title2')[i], "text":obj[i]['title'] })
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .subtitle2')[i], "text":obj[i]['sub'] })
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .link2')[i], "text":obj[i]['link']['title'] })
						LGen.translator.update({"elm":page.screen.querySelectorAll('.content2 .link2')[i], "type":"data-tooltip", "text":obj[i]['title'] })

						page.screen.querySelectorAll('.content2 .img2')[i].src = LGen.system.fe_url+'update.lanterlite.com/'+obj[i]['img']
					}
				}
			})
			page.lang_online = LGen.citizen.lang
	  }
	}

  this.when_closed = when_closed
  function when_closed() {
    var page = page_about
		clearInterval(page.move_banner_interval)
		// LGen.Page.clear_childs(page.screen.querySelector('.banner'))
		// LGen.Page.clear_childs(page.screen.querySelector('.content2'))
  }

  this.when_opened = when_opened
  function when_opened() {
    var page = page_about
		if (!page.hasOwnProperty('first_update')) {
			page.first_update = true
			page.load_content()
	    page.update()
		}
		else {
	    page.update()
		}
		page.move_banner()
		setTimeout(function() {
			page.screen.appendChild(LGen.component.footer.screen)
		}, 250)
  }
}
