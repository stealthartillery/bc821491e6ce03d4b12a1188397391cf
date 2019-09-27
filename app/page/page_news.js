page_news = new NewsPage()
page_news.set()

function NewsPage () {
  this.name = "page_news"
	this.url_names = ['news']

  this.set = set
  function set() {
    var page = page_news
		page.screen = LGen.String.to_elm(
		'<div class="page_news">'+
			'<div class="banner">'+'</div>'+
			'<div class="poster">'+
			'<div class="section_title theme theme_font top_title2">'+'News'+'</div>'+
			'<div class="cc theme theme_font">'+''+'</div>'+
			'<div class="content2">'+'</div>'+
			// '<div class="bground_cbtm">'+
			// 	'<div class="cbtm theme theme_font">'+'Lanterlite Team'+'</div>'+
			// 	'<div class="cbtm theme theme_font">'+'2019'+'</div>'+
			// '</div>'+
			'</div>'+
		'</div>')
		page.screen.appendChild(LGen.component.footer.screen)
		page.lang_elms = [
			// {"elm":page.screen.querySelector('.bground_cbtm .cbtm')},
			{"elm":page.screen.querySelector('.section_title.top_title2')}
		]
    page.set_event()
    LGen.Page.set_keys(page)
		// page.load_content()
    LGen.Page.add(page)
  }

  this.set_event = set_event
  function set_event() {
    var page = page_news
  }

  this.update = update
  function update() {
    var page = page_news
    LGen.Page.Self.update_css(page)
    LGen.Page.Self.update_color(page)
    LGen.Page.Self.update_font(page)
    LGen.Page.Self.update_lang(page)
		LGen.component.footer.update()
  }

  this.load_content = load_content
  function load_content(update_lang = false) {
    var page = page_news

		var go = true
		if (page.lang_online === LGen.citizen.lang)
			go = false
		if (!update_lang)
			go = true
		if (go) {

			var _obj = {
				"func": "get_data",
				"json": {
					"dir": "assets/www.lanterlite.com/lang/page_news/description/"+LGen.citizen.lang+".lgd", 
					"type": "lgd"
				}
			}
			LGen.f.send_get('update.lanterlite.com/update/', _obj, function(obj) {
				LGen.translator.update({"elm":page.screen.querySelector('.cc'), "text":obj['text'] })
			})

			var _obj = {
				"func": "get_data",
				"json": {
					"dir": "assets/www.lanterlite.com/lang/page_news/news/"+LGen.citizen.lang+".lgd", 
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
			page.lang_online = LGen.citizen.lang
	  }
	}

  this.when_closed = when_closed
  function when_closed() {
    var page = page_news
		LGen.Page.clear_childs(page.screen.querySelector('.banner'))
		LGen.Page.clear_childs(page.screen.querySelector('.content2'))
  }

  this.when_opened = when_opened
  function when_opened() {
    var page = page_news
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
