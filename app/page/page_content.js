page_content = new PageContent()
page_content.set()

function PageContent () {
	this.name = 'page_content'
	this.url_names = []
	this.content_paths = []

	this.set = set
	function set () {
		var page = page_content
		page.screen = LGen.String.to_elm(
			'<div class="page_content theme theme_font" style="display: none;">'+
			'<div class="bground">'+
				'<div class="child">'+
					'<div class="content">'+'</div>'+
				'</div>'+
				// '<button class="std gold back_btn theme theme_font theme_color bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			// {"elm": page.screen.querySelector('.bground .back_btn')}
		]

		var _obj = {
			"func": "get_data",
			"json": {
				"dir": "assets/www.lanterlite.com/lang/page_content/contents.lgd", 
				"type": "lgd"
			}
		}
		LGen.f.send_get('update.lanterlite.com/update/', _obj, function(obj) {
			lprint(obj)
			for(var i=0; i<obj.length; i++) {
				page.content_paths.push(obj[i]['content_path'])
				page.url_names.push(obj[i]['url_name'])
			}
		})

		LGen.Page.set_keys(page)
		page.set_event()
		LGen.Page.add(page)
	}


	this.set_event = set_event
	function set_event() {
		var page = page_content
		// page.screen.querySelector('.back_btn').addEventListener('click', function() {
		// 	LGen.Page.change(page.previous_page)
		// })
	}

	this.load_content = load_content
	function load_content(update_lang = false) {
		var page = page_content
		// LGen.Elm.clear_childs(page.screen.querySelector('.page_content .child'))
		var _obj = {
			"func": "get_data",
			"json": {
				"dir": "assets/www.lanterlite.com/lang/"+page.content_paths[page.url_name_index]+LGen.citizen.lang+".lgd", 
				"type": "lgd"
			}
		}
		LGen.f.send_get('update.lanterlite.com/update/', _obj, function(obj) {
			var asd = LGen.String.to_elm(decodeURIComponent(obj))
			LGen.Page.Self.update_css(asd)
			$(asd).css({'opacity':0})
			$(page.screen.querySelector('.page_content .child .content')).css({'opacity':0})
			setTimeout(function() {
				$(page.screen.querySelector('.page_content .child')).html(asd)
				setTimeout(function() {
					$(asd).css({'opacity':1})
				}, 50)
				// $(page.screen.querySelector('.page_content .child .content')).css({'opacity':1})
			}, LGen.Page.speed)
		})
	}

	this.update = update
	function update() {
		var page = page_content
		LGen.Page.Self.update_css(page)
		LGen.Page.Self.update_font(page)
		LGen.Page.Self.update_color(page)
		LGen.Page.Self.update_lang(page)


		// var _obj = {
		// 	"func": "get_data",
		// 	"json": {
		// 		"dir": "assets/www.lanterlite.com/lang/"+page.content_paths[page.url_name_index]+LGen.citizen.lang+".lgd", 
		// 		"type": "lgd"
		// 	}
		// }
		// LGen.f.send_get('update.lanterlite.com/update/', _obj, function(obj) {
		// 	page.screen.querySelector('.page_content .child').appendChild(LGen.String.to_elm(decodeURIComponent(obj)))
		// })
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = page_content
		LGen.Page.clear_childs(page.screen.querySelector('.page_content .child'))
		page.previous_page = ''
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = page_content

		page.load_content()
		page.update()
		setTimeout(function() {
			page.screen.appendChild(LGen.component.footer.screen)
		}, 250)
	}
}