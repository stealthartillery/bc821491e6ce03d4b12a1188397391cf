LGen.component.update = new UpdateApp()
LGen.component.update.set()

function UpdateApp () {
	this.name = 'update'
	this.download_link = ''
	this.url_names = ['update']

	this.set = set
	function set () {
		var page = LGen.component.update
		page.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="lgen_page_update" style="display: none;">'+
			'<div class="bground">'+
				'<div class="current_version theme fp">'+'Current Version'+'</div>'+
				'<div class="child theme version1 fp">'+''+'</div>'+
				'<div class="new_version theme fttl">'+'New version'+'</div>'+
				'<div class="child theme fttl version2">'+''+'</div>'+
				'<button class="std gold download_btn theme fp bgclr1 hover1">'+'Download'+'</button>'+
				'<button class="std gold later_btn theme fp bgclr1 hover1">'+'Later'+'</button>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.bground .current_version')},
			{"elm":page.screen.querySelector('.bground .new_version')},
			{"elm":page.screen.querySelector('.bground .download_btn')},
			{"elm":page.screen.querySelector('.bground .later_btn')},
		]
		page.set_event()
		LGen.Page.init(page)
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.update
		LGen.set_button(page.screen.querySelector('.download_btn'))
		LGen.set_button_click(page.screen.querySelector('.download_btn'), function() {
			window.open(page.download_link, '_blank')
		})
		LGen.set_button(page.screen.querySelector('.later_btn'))
		LGen.set_button_click(page.screen.querySelector('.later_btn'), function() {
			LGen.Page.change('')
		})
	}

	this.update = update
	function update() {
		var page = LGen.component.update
		LGen.Page.Self.update(page)
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.update
		page.previous_page = ''
		setTimeout(function() {
			LGen.component.header.show(LGen.Page.speed)
		}, LGen.Page.speed)
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.update
		page.update()
		LGen.component.header.hide(0)
	}
}