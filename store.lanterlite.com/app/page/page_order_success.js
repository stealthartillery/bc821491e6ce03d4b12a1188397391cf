page_order_success = new OrderSuccess()
page_order_success.set()

function OrderSuccess () {
	this.name = 'page_order_success'
	this.url_names = ['order_success']

	this.set = set
	function set () {
		var page = page_order_success
		page.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="page_order_success" style="display: none;">'+
			'<div class="bground">'+
				'<div class="title theme fttl">'+'Please complete the payment in order to get your order processed automatically.'+'</div>'+
				'<div class="title theme fttl">'+'Thankyou.'+'</div>'+
				'<button class="std gold home_btn theme fp bgclr1 hover1">'+'Home'+'</button>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelectorAll('.bground .title')[0]},
			{"elm":page.screen.querySelectorAll('.bground .title')[1]},
			{"elm":page.screen.querySelector('.bground .home_btn')},
		]
		page.set_event()
		LGen.Page.init(page)
	}

	this.set_event = set_event
	function set_event() {
		var page = page_order_success
		LGen.set_button(page.screen.querySelector('.home_btn'))
		LGen.set_button_click(page.screen.querySelector('.home_btn'), function(_this) {
			LGen.Page.change(page.previous_page)
		})
	}

	this.update = update
	function update() {
		var page = page_order_success
		LGen.Page.Self.update(page)
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = page_order_success
		page.previous_page = ''
		// setTimeout(function() {
		// 	LGen.component.header.show(LGen.Page.speed)
		// }, LGen.Page.speed)
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = page_order_success
		page.update()
		LGen.component.header.hide()
		LGen.component.footbar.hide()
	}
}