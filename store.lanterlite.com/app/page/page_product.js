page_product = new PageProduct()
page_product.set()

function PageProduct () {
	this.name = 'page_product'
	this.url_names = ['product']
	this.product = []

	this.set = set
	function set () {
		var page = page_product
		page.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="page_product" style="display: none;">'+
			'<div class="bground">'+
				'<div class="top_title title all_theme fttl">'+'Product'+'</div>'+
				'<div class="child name">'+
					'<div class="title all_theme fp">'+'Product Name'+'</div>'+
					'<input class="std gold val all_theme fp" value="'+'" placeholder="(4-15 characters.)" maxlength="25"/>'+
				'</div>'+
				'<div class="child sh_desc">'+
					'<div class="title all_theme fp">'+'Short Desc'+'</div>'+
					'<input class="std gold val all_theme fp" value="'+'" placeholder="(4-25 characters.)" maxlength="25"/>'+
				'</div>'+
				'<div class="child lg_desc">'+
					'<div class="title all_theme fp">'+'Long Desc'+'</div>'+
					'<input class="std gold val all_theme fp" value="'+'" placeholder="(4-50 characters.)" maxlength="50"/>'+
				'</div>'+
				'<div class="child price">'+
					'<div class="title all_theme fp">'+'Price'+'</div>'+
					'<input class="std gold val all_theme fp" value="'+'" placeholder="(Product price)" maxlength="50"/>'+
				'</div>'+
				'<div class="imgs">'+'</div>'+
				'<button class="std gold save_btn all_theme fp bgclr1 hover1">'+'Save'+'</button>'+
				'<button class="std gold back_btn all_theme fp bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelectorAll('.top_title')[0]},
		]
		// // LGen.Page.set_css(page.screen)
		LGen.Page.init(page)
		page.set_event()
	}

	this.set_event = set_event
	function set_event() {
		var page = page_product
		LGen.set_button(page.screen.querySelector('.save_btn'))
		LGen.set_button_click(page.screen.querySelector('.save_btn'), function(_this) {
			// var asd = {'gate':'store', 'val': {
		 //    "code_name": page.screen.querySelector('.code_name input').value,
		 //    "name": page.screen.querySelector('.name input').value
			// }, 'def':'stores', 'bridge':[{'id':'stores', 'puzzled': true}, {'id': page.store_id, 'puzzled': false}]}
			// var _obj = {
			// 	"json": asd,
			// 	"func": 'LGen("SaviorMan")->update'
			// }
			// LGen.call({'c':'req','f':'post'})('store.be.lanterlite.com/store', _obj, function(obj){
			// })
		})
	}

	this.get_prod = get_prod
	function get_prod(callback) {
		var page = page_product
		var _obj = {
			"func": "$product->get",
			"json": {"prod_id":page.prod_id, "lang":LGen.citizen.get({'key':'lang','safe':'safe'})}
		}
		LGen.call({'c':'req','f':'get'})('store.be.lanterlite.com/gate/', _obj, function(obj) {
			page.store_id = (atob(obj))
			callback(atob(obj))
		})
	}

	this.update = update
	function update() {
		var page = page_product
		LGen.Page.Self.update(page)
		page.get_prod(function() {
			lprint(obj)
			var img_url = atob(obj['product']['img']['url'])
			var name = atob(obj['product']['detail']['name'])
			var sh_desc = atob(obj['product']['detail']['sh_desc'])
			var lg_desc = atob(obj['product']['detail']['lg_desc'])
			var price = atob(obj['product']['price'])

			page.screen.querySelector('.code_name input').value = code_name
			page.screen.querySelector('.sh_desc input').value = sh_desc
			page.screen.querySelector('.lg_desc input').value = lg_desc
			page.screen.querySelector('.price input').value = price

			for (var j=0; j<5; j++) {
				var img = LGen.call({'c':'str', 'f':'to_elm'})('<img class="prod_img">')
				// img.src = LGen.system.get({'safe':'safe'}).fe_url + "image.lanterlite.com/storages/image/store/default_product.webp"
				var btn = LGen.component.image.create()
				// $(btn).css({'display': 'none'})
				$(img).css({'cursor': 'pointer'})
				LGen.set_button(img)
				LGen.set_button_click(img, function(_this) {
					LGen.component.image.open()
					var toto = _this
					LGen.component.image.callback = function(img) {
						var _obj = {
							"func": "$image->add_image",
							"json": {
								"gate":"store",
								"img":img
							}
						}
						LGen.call({'c':'req','f':'post'})('image.lanterlite.com/image/', _obj, function(obj) {
							lprint(obj)
							image_id = obj
							lprint(toto.src = LGen.system.get({'safe':'safe'}).fe_url+image_id)
						})
					}
				})

				var url = atob(obj[i]['imgs'][j]['url'])
				var id = atob(obj[i]['imgs'][j]['id'])
				img.src = url
				if (id === atob(obj[i]['product']['img']))
					$(asd).addClass('main')
				asd.querySelector('.imgs').appendChild(img)
			}
		})
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = page_product
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = page_product
		page.update()
	}
}
