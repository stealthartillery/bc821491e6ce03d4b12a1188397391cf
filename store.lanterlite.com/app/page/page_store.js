page_store = new PageStore()
page_store.set()

function PageStore () {
	this.name = 'page_store'
	this.url_names = ['store']

	this.set = set
	function set () {
		var page = page_store
		page.screen = LGen.call({'c':'str','f':'to_elm'})(
			'<div class="page_store" style="display: none;">'+
			'<div class="bground">'+
				'<div class="top_title title theme fttl">'+'Store'+'</div>'+
				'<div class="child code_name">'+
					'<div class="title theme fp">'+'Code Name'+'</div>'+
					'<input class="std gold val theme fp" value="" placeholder="(4-15 characters.)" maxlength="15"/>'+
				'</div>'+
				'<div class="child name">'+
					'<div class="title theme fp">'+'Store Name'+'</div>'+
					'<input class="std gold val theme fp" value="" placeholder="(4-50 characters.)" maxlength="50"/>'+
				'</div>'+
				'<div class="child point" disabled>'+
					'<div class="title theme fp">'+'Store Point'+'</div>'+
					'<input class="std gold val theme fp" value="" disabled/>'+
				'</div>'+
				'<button class="std gold save_btn theme fp bgclr1 hover1">'+'Save'+'</button>'+
				'<button class="std gold back_btn theme fp bgclr1 hover1">'+'Back'+'</button>'+
				'<div class="top_title title products theme fttl">'+'Products'+'</div>'+
				'<button class="new_product_btn std gold theme fp">'+'New Product'+'</button>'+
				'<div class="product_list">'+'</div>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelectorAll('.top_title')[0]},
			{"elm":page.screen.querySelectorAll('.top_title')[1]},
		]
		// // LGen.Page.set_css(page.screen)
		LGen.Page.init(page)
		page.set_event()
	}

	this.set_event = set_event
	function set_event() {
		var page = page_store
		LGen.set_button(page.screen.querySelector('.new_product_btn'))
		LGen.set_button_click(page.screen.querySelector('.new_product_btn'), function(_this) {
			var _obj = {
				"json": {'store_id':'E26C4E7F9021'},
				"func": '$product->add'
			}
			LGen.call({'c':'req','f':'post'})('store.be.lanterlite.com/gate', _obj, function(obj){
				lprint(obj)
			})
		})

		LGen.set_button(page.screen.querySelector('.save_btn'))
		LGen.set_button_click(page.screen.querySelector('.save_btn'), function(_this) {
			var asd = {'gate':'store', 'val': {
		    "code_name": page.screen.querySelector('.code_name input').value,
		    "name": page.screen.querySelector('.name input').value
			}, 'def':'stores', 'bridge':[{'id':'stores', 'puzzled': true}, {'id': page.store_id, 'puzzled': false}]}
			var _obj = {
				"json": asd,
				"func": 'LGen("SaviorMan")->update'
			}
			LGen.call({'c':'req','f':'post'})('store.be.lanterlite.com/gate', _obj, function(obj){
			})
		})
	}

	this.get_products = get_products
	function get_products() {
		var page = page_store
		var _obj = {
			"func": "$store->get_products",
			"json": {
				"store_id" : page.store_id
			}
		}
		LGen.call({'c':'req','f':'get'})('store.be.lanterlite.com/gate', _obj, function(obj) {
			lprint(obj)
			for (var i=0; i<obj.length; i++){
				var asd = LGen.call({'c':'str','f':'to_elm'})(
					'<div class="product">'+
						'<div class="child en_name">'+
							'<div class="title theme fp">'+'Product Name (EN)'+'</div>'+
							'<input class="std gold val theme fp" value="'+atob(obj[i]['details']['en']['name'])+'" placeholder="(4-15 characters.)" maxlength="25"/>'+
						'</div>'+
						'<div class="child en_sh_desc">'+
							'<div class="title theme fp">'+'Short Desc (EN)'+'</div>'+
							'<input class="std gold val theme fp" value="'+atob(obj[i]['details']['en']['sh_desc'])+'" placeholder="(4-25 characters.)" maxlength="25"/>'+
						'</div>'+
						'<div class="child en_lg_desc">'+
							'<div class="title theme fp">'+'Long Desc (EN)'+'</div>'+
							'<input class="std gold val theme fp" value="'+atob(obj[i]['details']['en']['lg_desc'])+'" placeholder="(4-50 characters.)" maxlength="50"/>'+
						'</div>'+
						'<div class="child id_name">'+
							'<div class="title theme fp">'+'Product Name (ID)'+'</div>'+
							'<input class="std gold val theme fp" value="'+atob(obj[i]['details']['id']['name'])+'" placeholder="(4-15 characters.)" maxlength="25"/>'+
						'</div>'+
						'<div class="child id_sh_desc">'+
							'<div class="title theme fp">'+'Short Desc (ID)'+'</div>'+
							'<input class="std gold val theme fp" value="'+atob(obj[i]['details']['id']['sh_desc'])+'" placeholder="(4-25 characters.)" maxlength="25"/>'+
						'</div>'+
						'<div class="child id_lg_desc">'+
							'<div class="title theme fp">'+'Long Desc (ID)'+'</div>'+
							'<input class="std gold val theme fp" value="'+atob(obj[i]['details']['id']['lg_desc'])+'" placeholder="(4-50 characters.)" maxlength="50"/>'+
						'</div>'+
						'<div class="child price">'+
							'<div class="title theme fp">'+'Price'+'</div>'+
							'<input class="std gold val theme fp" value="'+atob(obj[i]['product']['price'])+'" placeholder="(Product price)" maxlength="50"/>'+
						'</div>'+
						// '<div class="detail_en">'+
						// 	'<div class="name">'+atob(obj[i]['details']['en']['name'])+'</div>'+
						// 	'<div class="sh_desc">'+atob(obj[i]['details']['en']['sh_desc'])+'</div>'+
						// 	'<div class="lg_desc">'+atob(obj[i]['details']['en']['lg_desc'])+'</div>'+
						// '</div>'+
						// '<div class="detail_id">'+
						// 	'<div class="name">'+atob(obj[i]['details']['id']['name'])+'</div>'+
						// 	'<div class="sh_desc">'+atob(obj[i]['details']['id']['sh_desc'])+'</div>'+
						// 	'<div class="lg_desc">'+atob(obj[i]['details']['id']['lg_desc'])+'</div>'+
						// '</div>'+
						// '<div class="price">'+atob(obj[i]['product']['price'])+'</div>'+
						'<div class="imgs">'+'</div>'+
					'</div>'
				)
				for (var j=0; j<5; j++) {
				// for (var j=0; j<obj[i]['imgs'].length; j++) {
					var img = LGen.call({'c':'str','f':'to_elm'})('<img class="prod_img">')
					img.src = LGen.system.get({'safe':'safe'}).fe_url + "image.lanterlite.com/storages/store/default_product.webp"
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
							LGen.call({'c':'req','f':'post'})('image.lanterlite.com/gate', _obj, function(obj) {
								lprint(obj)
								image_id = obj
								lprint(toto.src = LGen.system.get({'safe':'safe'}).fe_url+image_id)
							})
						}
					})

					if (obj[i]['imgs'].hasOwnProperty(j)) {
						var url = atob(obj[i]['imgs'][j]['url'])
						var id = atob(obj[i]['imgs'][j]['id'])
						img.src = url
						if (id === atob(obj[i]['product']['img']))
							$(asd).addClass('main')
					}
					asd.querySelector('.imgs').appendChild(img)
				}
				// // LGen.Page.set_css(asd)
				// // LGen.Page.Self.update_css(asd)
				page.screen.querySelector('.product_list').appendChild(asd)
			}

			// var code_name = atob(obj['code_name'])
			// var name = atob(obj['name'])
			// var point = atob(obj['point'])
			// page.screen.querySelector('.code_name input').value = code_name
			// page.screen.querySelector('.name input').value = name
			// page.screen.querySelector('.point input').value = point
			// page.get_products()
		})
	}

	this.get_id = get_id
	function get_id(callback) {
		var page = page_store
		var _obj = {
			"f": "$store->get_id",
			"o": {"cit_id":"36E781ECDAC7"}
		}
		LGen.call({'c':'req','f':'get'})('store.be.lanterlite.com/gate', _obj, function(obj) {
			lprint(obj)
			page.store_id = (atob(obj))
			callback(atob(obj))
		})
	}

	this.update = update
	function update() {
		var page = page_store
		LGen.Page.Self.update(page)
		page.get_id(function() {
			var _obj = {
				"func": "LGen('SaviorMan')->read",
				"json": {
					"namelist":["code_name", "point", "name", "cit_id"],
					"bridge":[
						{"id":"stores", "puzzled":true},
						{"id":page.store_id, "puzzled": false},
					],
					"def":"stores"
				}
			}
			LGen.call({'c':'req','f':'get'})('store.be.lanterlite.com/gate', _obj, function(obj) {
				lprint(obj)
				var code_name = atob(obj['code_name'])
				var name = atob(obj['name'])
				var point = atob(obj['point'])
				page.screen.querySelector('.code_name input').value = code_name
				page.screen.querySelector('.name input').value = name
				page.screen.querySelector('.point input').value = point
				page.get_products()
			})
		})
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = page_store
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = page_store
		page.update()
		setTimeout(function() {
			page.screen.querySelector('._footer').appendChild(LGen.component.footer.screen)
		}, LGen.Page.speed)
		LGen.component.header.show()
		LGen.component.footbar.hide()
	}
}
