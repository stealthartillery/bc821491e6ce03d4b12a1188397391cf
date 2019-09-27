LGen.component.notif_msg = new NotifMessage()
LGen.component.notif_msg.set()

function NotifMessage () {
	this.name = 'notif_msg'

	this.set = set
	function set () {
		var page = LGen.component.notif_msg
		page.screen = LGen.String.to_elm(
			'<div class="notif_msg theme theme_font" style="display: none;">'+
			'<div class="bground">'+
				'<div class="child">'+'</div>'+
				'<button class="std gold back_btn theme theme_font theme_color bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.bground .back_btn')}
		]
		LGen.Page.set_keys(page)
		page.set_event()
		LGen.Page.add(page)
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.notif_msg
		page.screen.querySelector('.back_btn').addEventListener('click', function() {
			LGen.Page.change(page.previous_page)
		})
	}

	this.update = update
	function update() {
		var page = LGen.component.notif_msg
		LGen.Page.Self.update_css(page)
		LGen.Page.Self.update_font(page)
		LGen.Page.Self.update_color(page)
		LGen.Page.Self.update_lang(page)
	}

	this.add = add
	function add(_elm) {
		var page = LGen.component.notif_msg
		page.screen.querySelector('.notif_msg .child').appendChild(_elm)
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.notif_msg
		LGen.Page.clear_childs(page.screen.querySelector('.notif_msg .child'))
		page.previous_page = ''
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.notif_msg
		page.update()
	}
}