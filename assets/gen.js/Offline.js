LGen.component.offline = new Offline()
LGen.component.offline.set()

function Offline () {
	this.name = 'offline'
	this.url_names = ['offline']

	this.set = set
	function set () {
		var page = LGen.component.offline
		page.screen = LGen.String.to_elm(
			'<div class="offline theme theme_font" style="display: none;">'+
			'<div class="bground">'+
				'<div class="title theme theme_font">'+'Offline?'+'</div>'+
				'<div class="child theme theme_font">'+''+'</div>'+
				'<button class="std gold home_btn theme theme_font ca01 bgclr1 hover1">'+'Home'+'</button>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.bground .title')},
			{"elm":page.screen.querySelector('.bground .home_btn')},
		]
		LGen.Page.set_keys(page)
		page.set_event()
		LGen.Page.add(page)
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.offline
		page.screen.querySelector('.home_btn').addEventListener('click', function() {
			LGen.Page.change(page.previous_page)
		})
	}

	this.update = update
	function update() {
		var page = LGen.component.offline
		LGen.Page.Self.update_css(page)
		LGen.Page.Self.update_font(page)
		LGen.Page.Self.update_color(page)
		LGen.Page.Self.update_lang(page)
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.offline
		page.previous_page = ''
		setTimeout(function() {
			LGen.component.header.show(LGen.Page.speed)
		}, LGen.Page.speed)
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.offline
		page.update()
		LGen.component.header.hide(0)
	}
}