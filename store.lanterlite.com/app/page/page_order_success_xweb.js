page_order_success_xweb = new OrderSuccessXWeb()
page_order_success_xweb.set()

function OrderSuccessXWeb () {
	this.name = 'page_order_success_xweb'
	this.url_names = ['order_success']

	this.set = set
	function set () {
		var page = page_order_success_xweb
		page.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="page_order_success_xweb" style="display: none;">'+
			'<div class="bground">'+
				'<div class="title theme fttl">'+'Please complete the payment in order to get your order processed automatically.'+'</div>'+
				'<div class="title theme fttl">'+'Thankyou.'+'</div>'+
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
		var page = page_order_success_xweb
		LGen.set_button(page.screen.querySelector('.home_btn'))
		LGen.set_button_click(page.screen.querySelector('.home_btn'), function(_this) {
			// if (typeof window.parent != "undefined"){
			// 	var someIframe = window.parent.document.getElementById('ch_iframe');
			// 	lprint(someIframe)
			// 	someIframe.parentNode.removeChild(window.parent.document.getElementById('ch_iframe'));
			// }
			LGen.Page.change(page.previous_page)
		})
	}

	this.update = update
	function update() {
		var page = page_order_success_xweb
		LGen.Page.Self.update(page)
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = page_order_success_xweb
		page.previous_page = ''
		// setTimeout(function() {
		// 	LGen.component.header.show(LGen.Page.speed)
		// }, LGen.Page.speed)
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = page_order_success_xweb
		page.update()
		LGen.component.header.hide()
		LGen.component.footbar.hide()
	}
}