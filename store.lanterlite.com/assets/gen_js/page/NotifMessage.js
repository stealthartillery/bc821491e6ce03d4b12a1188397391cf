LGen.component.notif_msg = new NotifMessage()
LGen.component.notif_msg.set()

function NotifMessage () {
	this.name = 'notif_msg'

	this.set = set
	function set () {
		var page = LGen.component.notif_msg
		page.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="notif_msg" style="display: none;">'+
			'<div class="bground">'+
			'<div class="content_parent">'+
				'<div class="child">'+'</div>'+
				'<button class="std gold back_btn theme fp bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.bground .back_btn')}
		]
		page.set_event()
		LGen.Page.init(page)
		LGen.component.header.hide_when_scroll2(page.screen.querySelector('.bground'))
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.notif_msg
		LGen.set_button(page.screen.querySelector('.back_btn'))
		LGen.set_button_click(page.screen.querySelector('.back_btn'), function() {
			LGen.Page.change(page.previous_page)
		})
	}

	this.update = update
	function update() {
		var page = LGen.component.notif_msg
		LGen.Page.Self.update(page)
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
		LGen.component.footbar.hide()
		LGen.component.header.show()
	}
}