LGen.component.not_found = new NotFound()
LGen.component.not_found.set()

function NotFound () {
	this.name = 'not_found'
	this.url_names = ['404']

	this.set = set
	function set () {
		var page = LGen.component.not_found
		page.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="not_found theme fp" style="display: none;">'+
			'<div class="bground">'+
				'<div class="title theme fttl">'+'Blank'+'</div>'+
				'<div class="child theme fttl">'+'404'+'</div>'+
				'<button class="std gold home_btn theme fp bgclr1 hover1">'+'Home'+'</button>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.bground .title')},
			{"elm":page.screen.querySelector('.bground .home_btn')},
		]
		page.set_event()
		LGen.Page.init(page)
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.not_found
		LGen.set_button(page.screen.querySelector('.home_btn'))
		LGen.set_button_click(page.screen.querySelector('.home_btn'), function() {
			LGen.Page.change(page.previous_page)
		})
	}

	this.update = update
	function update() {
		var page = LGen.component.not_found
		LGen.Page.Self.update(page)
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.not_found
		page.previous_page = ''
		setTimeout(function() {
			LGen.component.header.show(LGen.Page.speed)
			LGen.component.footbar.show(LGen.Page.speed)
		}, LGen.Page.speed)
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.not_found
		page.update()
		LGen.component.header.hide()
		LGen.component.footbar.hide()
	}
}