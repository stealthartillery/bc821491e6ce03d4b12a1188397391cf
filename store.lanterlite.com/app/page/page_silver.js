page_silver = new PageSilver()
page_silver.set()

function PageSilver () {
	this.name = 'page_silver'
	this.url_names = ['silver']

	this.set = set
	function set () {
		var page = page_silver
		page.screen = LGen.call({'c':'str','f':'to_elm'})(
			'<div class="page_silver theme fp" style="display: none;">'+
			'<div class="bground">'+
				'<div class="top_title title fsize fttl theme fp">'+'Lanter Silver'+'</div>'+
				'<div class="product">'+
					'<div class="status">'+
						'<div class="name theme fp"></div>'+
						'<div class="desc theme fp"></div>'+
						'<div class="seller theme fp"></div>'+
					'</div>'+
				'</div>'+
				'<div class="full_desc">'+
					'<div class="title theme fp">'+'Description'+'</div>'+
					'<div class="content theme fp">'+'</div>'+
				'</div>'+
				'<div class="purchase">'+
					'<div class="title theme fp">Purchase</div>'+
					'<table>'+
					'<tr>'+
						'<td class="left_tbl theme fp">'+'Quantity'+'</td>'+'<td>:</td>'+
						'<td class="mid_tbl">'+'<span class="quantity theme fp">1</span>'+'</td>'+
						'<td>'+
							'<button class="std gold minus theme fp bgclr1 hover1">-</button>'+
							'<button class="std gold plus theme fp bgclr1 hover1">+</button>'+
							'<button class="std gold increment theme fp bgclr1 hover1">1x</button>'+
						'</td>'+
					'</tr>'+
					'<tr>'+
						'<td class="left_tbl theme fp">'+'Price'+'</td>'+'<td>:</td>'+
						'<td class="mid_tbl"><span class="price rupiah theme fp"></span></td>'+
						'<td>'+'<span class="rupiah_title theme fp">Rupiah (IDR)</span>'+'</td>'+
					'</tr>'+
					'<tr>'+
						'<td class="left_tbl theme fp">'+'Price'+'</td>'+'<td>:</td>'+
						'<td class="mid_tbl"><span class="price dollar theme fp"></span></td>'+
						'<td>'+'<span class="dollar_title theme fp">Dollar (US)</span>'+'</td>'+
					'</tr>'+
					// '<tr>'+
					// 	'<td class="left_tbl">'+'Item for'+'</td>'+'<td>:</td>'+'<td>'+'<input class="item_for" placeholder="Lanterlite Account Username" value="ifandhanip"/>'+'</td>'+
					// '</tr>'+
					'</table>'+
					'<button class="std gold buy_btn theme fp bgclr1 hover1">Buy</button>'+
					'<button class="std gold back_btn theme fp bgclr1 hover1">'+'Back'+'</button>'+
				'</div>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm": page.screen.querySelector('.top_title')},
			{"elm": page.screen.querySelector('.full_desc .title')},
			{"elm": page.screen.querySelector('.purchase .title')},
			{"elm": page.screen.querySelector('.dollar_title')},
			{"elm": page.screen.querySelector('.rupiah_title')},
			{"elm": page.screen.querySelector('.buy_btn')},
			{"elm": page.screen.querySelector('.back_btn')},
			{"elm": page.screen.querySelectorAll('.left_tbl')[0]},
			{"elm": page.screen.querySelectorAll('.left_tbl')[1]},
			{"elm": page.screen.querySelectorAll('.left_tbl')[2]}
		]

		LGen.Page.init(page)
		page.set_event()
	}

	this.set_event = set_event
	function set_event() {
		var page = page_silver
		LGen.set_button(page.screen.querySelector('.buy_btn'))
		LGen.set_button_click(page.screen.querySelector('.buy_btn'), function(_this) {
			if (LGen.citizen.get({'key':'id','safe':'safe'}) === '') {
				LGen.component.header.open()
				LGen.component.signin.open()
				LGen.component.snackbar.open({'str':'Please sign in to continue'})
			}
			else if (!LGen.citizen.get({'key':'is_verified','safe':'safe'})) {
				LGen.component.snackbar.open({'str':'Please verify your email to continue'})
			}
			else {
				var qt = page.screen.querySelector('.quantity').innerText
				var name = page.screen.querySelector('.name').innerText
				var price = page.screen.querySelector('.price').innerText
				var you_will_buy = LGen.translator.get({'words':'You will buy', 'lang':LGen.citizen.get({'key':'lang','safe':'safe'})})
				var _for = LGen.translator.get({'words':'for', 'lang':LGen.citizen.get({'key':'lang','safe':'safe'})})
				var _continue = LGen.translator.get({'words':'Continue', 'lang':LGen.citizen.get({'key':'lang','safe':'safe'})})
				LGen.component.confirmation.open({
					'str': you_will_buy+' '+qt+ ' '+name+' '+_for+' '+price+' Lanter Silver. '+_continue+'?',
					'yes': function() {
						lprint('buy!')
					}
				})
			}
		})
		LGen.set_button(page.screen.querySelector('.back_btn'))
		LGen.set_button_click(page.screen.querySelector('.back_btn'), function(_this) {
			LGen.Page.change(page.previous_page)
		})
		LGen.set_button(page.screen.querySelector('.increment'))
		LGen.set_button_click(page.screen.querySelector('.increment'), function(_this) {
			var qt = parseInt(page.screen.querySelector('.increment').innerText)
			qt = qt+1
			if (qt > 10)
				qt = 1
			page.screen.querySelector('.increment').innerText = qt+'x';
		})
		LGen.set_button(page.screen.querySelector('.plus'))
		LGen.set_button_click(page.screen.querySelector('.plus'), function(_this) {
			var qt = parseInt(page.screen.querySelector('.purchase .quantity').innerText)
			var inc = parseInt(page.screen.querySelector('.increment').innerText)
			qt = qt+(1*inc)
			LGen.translator.update({"elm":page.screen.querySelector('.purchase .quantity'), "text":qt })
			LGen.translator.update({"elm":page.screen.querySelector('.purchase .price.rupiah'), "text":qt*page.item['price']['id'] })
			LGen.translator.update({"elm":page.screen.querySelector('.purchase .price.dollar'), "text":qt*page.item['price']['us'] })
		})
		LGen.set_button(page.screen.querySelector('.minus'))
		LGen.set_button_click(page.screen.querySelector('.minus'), function(_this) {
			var qt = parseInt(page.screen.querySelector('.purchase .quantity').innerText)
			var inc = parseInt(page.screen.querySelector('.increment').innerText)
			qt = qt-(1*inc)
			if (qt > 1) {
				LGen.translator.update({"elm":page.screen.querySelector('.purchase .quantity'), "text":qt })
				LGen.translator.update({"elm":page.screen.querySelector('.purchase .price.rupiah'), "text":qt*page.item['price']['id'] })
				LGen.translator.update({"elm":page.screen.querySelector('.purchase .price.dollar'), "text":qt*page.item['price']['us'] })
			}
		})
	}

	this.load_content = load_content
	function load_content(update_lang = false) {
		var page = page_silver
		// LGen.call({'c':'elm','f':'clear_childs'})(page.screen.querySelector('.page_silver .child'))
		var _obj = {
			"func": "get_data",
			"json": {
				"dir": "assets/store.lanterlite.com/lang/page_silver/"+LGen.citizen.get({'key':'lang','safe':'safe'})+".lgd",
				"type": "lgd"
			}
		}
		LGen.call({'c':'req','f':'get'})('update.lanterlite.com/gate', _obj, function(obj) {
			page.item = obj
			LGen.translator.update({"elm":page.screen.querySelector('.product .name'), "text":obj['name'] })
			LGen.translator.update({"elm":page.screen.querySelector('.product .desc'), "text":obj['desc'] })
			LGen.translator.update({"elm":page.screen.querySelector('.product .seller'), "text":obj['seller'] })
			LGen.translator.update({"elm":page.screen.querySelector('.purchase .price.rupiah'), "text":obj['price']['id']*parseInt(page.screen.querySelector('.purchase .quantity').innerText) })
			LGen.translator.update({"elm":page.screen.querySelector('.purchase .price.dollar'), "text":obj['price']['us']*parseInt(page.screen.querySelector('.purchase .quantity').innerText) })
			LGen.translator.update({"elm":page.screen.querySelector('.full_desc .content'), "text":obj['full_desc'] })
		})
	}

	this.update = update
	function update() {
		var page = page_silver
		LGen.Page.Self.update(page)
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = page_silver
		page.screen.querySelector('.quantity').innerText = '1'
		page.screen.querySelector('.increment').innerText = '1x'
		page.previous_page = ''
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = page_silver

		page.load_content()
		page.update()
		// setTimeout(function() {
		// 	page.screen.appendChild(LGen.component.footer.screen)
		// }, 250)
	}
}