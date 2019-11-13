page_item = new PageItem()
page_item.set()

function PageItem () {
	this.name = 'page_item'
	this.url_names = []
	this.content_paths = []
	this.repeated = true
	this.txid = ''

	this.set = set
	function set () {
		var page = page_item
		page.screen_footbar = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="_footbar n1 theme fp">'+
				'<button class="std gold back theme fp bgclr1 hover1">'+LGen.icon.theme('left')+'</button>'+
			'</div>'
		)
		page.screen = LGen.call({'c':'str','f':'to_elm'})(
			'<div class="page_item" style="display: none;">'+
			'<div class="bground">'+
				'<div class="_bground">'+
					'<div class="top_title title theme fttl">'+'Item'+'</div>'+
					'<div class="product_img">'+
						'<img>'+
						'<div class="imgs">'+
						'</div>'+
					'</div>'+
					'<div class="product">'+
					// '<img>'+
						'<div class="status">'+
							'<div class="id" display="none"></div>'+
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
							'<td class="left_tbl theme fp">'+'Quantity'+'</td>'+'<td class="colon">:</td>'+
							'<td class="mid_tbl">'+'<span class="quantity theme fp">1</span>'+'</td>'+
							'<td>'+
								'<button class="std gold minus theme fp bgclr1 hover1">-</button>'+
								'<button class="std gold plus theme fp bgclr1 hover1">+</button>'+
								'<button class="std gold increment theme fp bgclr1 hover1">1x</button>'+
							'</td>'+
						'</tr>'+
						'<tr>'+
							'<td class="left_tbl theme fp">'+'Price'+'</td>'+'<td class="colon">:</td>'+
							'<td class="mid_tbl"><span class="price theme fp">10</span></td>'+
							'<td class="">'+
								'<select class="currency select theme fp">'+
								'</select>'+
							'</td>'+
						'</tr>'+
						'<tr id="tr_medium">'+
							'<td class="left_tbl theme fp">'+'Medium'+'</td>'+'<td class="colon">:</td>'+
							'<td class="" colspan=2>'+
								'<select class="medium select theme fp">'+
								'</select>'+
							'</td>'+
						'</tr>'+
						'<tr>'+
							'<td class="left_tbl theme fp">'+'Note'+'</td>'+'<td class="colon">:</td>'+
							'<td class="" colspan=2>'+
								'<textarea class="std note theme fp">'+'</textarea>'+
							'</td>'+
						'</tr>'+
						'<tr>'+
							'<td class="left_tbl theme fp">'+'Info'+'</td>'+'<td class="colon">:</td>'+
							'<td class="" colspan=2>'+
								'<div class="info theme fp">'+'</div>'+
							'</td>'+
						'</tr>'+
						// '<tr>'+
						// 	'<td class="left_tbl">'+'Item for'+'</td>'+'<td class="colon">:</td>'+'<td>'+'<input class="item_for" placeholder="Lanterlite Account Username" value="ifandhanip"/>'+'</td>'+
						// '</tr>'+
						'</table>'+
						'<button class="std gold buy_btn theme fp bgclr1 hover1">Buy</button>'+
						'<button class="std gold copy_btn theme fp bgclr1 hover1">Copy</button>'+
						// '<button class="std gold back_btn theme fp bgclr1 hover1">'+'Back'+'</button>'+
					'</div>'+
				'</div>'+
				'<div class="_footer">'+'</div>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm": page.screen.querySelector('.top_title')},
			{"elm": page.screen.querySelector('.full_desc .title')},
			{"elm": page.screen.querySelector('.purchase .title')},
			{"elm": page.screen.querySelector('.buy_btn')},
			{"elm": page.screen.querySelector('.copy_btn')},
			// {"elm": page.screen.querySelector('.back_btn')},
			{"elm": page.screen.querySelectorAll('.left_tbl')[0]},
			{"elm": page.screen.querySelectorAll('.left_tbl')[1]},
			{"elm": page.screen.querySelectorAll('.left_tbl')[2]},
			{"elm": page.screen.querySelectorAll('.left_tbl')[3]},
			{"elm": page.screen.querySelectorAll('.left_tbl')[4]},
			{"elm": page.screen.querySelector('.purchase .title')}
		]

		var _obj = {
			"func": "get_data",
			"json": {
				"dir": "assets/store.lanterlite.com/lang/page_item/items.lgd", 
				"type": "lgd"
			}
		}
		LGen.call({'c':'req','f':'get'})('update.lanterlite.com/gate', _obj, function(obj) {
			for(var i=0; i<obj.length; i++) {
				page.content_paths.push(obj[i]['content_path'])
				page.url_names.push(obj[i]['url_name'])
			}
		})

		LGen.Page.init(page)
		page.set_event()
		LGen.component.header.hide_when_scroll2(page.screen)
	}

	this.set_event = set_event
	function set_event() {
		var page = page_item
		$(page.screen.querySelector('#tr_medium')).fadeOut(0)
		$(page.screen.querySelector('select.medium')).change(function(){
			page.medium = $(this).val()
			if (page.medium === 'bni_syariah')
				page.screen.querySelector('div.info').innerText = 'Rekening: 0797266815,' + 'Nama: IFAN DHANI PRASOJO, ' + 'Note: '+page.txid +', ' + 'Nominal: ' + page.screen.querySelector('.price').innerText
			else
				page.screen.querySelector('div.info').innerText = ''
			// LGen.citizen.set_all({'val':{'lang':$(this).val()},'safe':'safe'})
		});
		$(page.screen.querySelector('select.currency')).change(function(){
			var qt = parseInt(page.screen.querySelector('.purchase .quantity').innerText)
			LGen.translator.update({"elm":page.screen.querySelector('.purchase .price'), "text":parseFloat(parseFloat(qt*(page.item[$(this).val()])).toFixed(2)) })
			page.currency = $(this).val()
			LGen.call({'c':'elm','f':'clear_childs'})(page.screen.querySelector('select.medium'))
			if (page.currency === 'price_idr') {
				page.screen.querySelector('select.medium').appendChild(LGen.call({'c':'str', 'f':'to_elm'})('<option value="bni_syariah">BNI Syariah</option>'))
				page.medium = 'bni_syariah'
			}
			else
				page.medium = ''
		});

		LGen.set_button(page.screen_footbar.querySelector('.back'))
		LGen.set_button_click(page.screen_footbar.querySelector('.back'), function() {
			LGen.Page.change(page.previous_page)
		})
		
		$(page.screen.querySelector('.copy_btn')).fadeOut(0)
		LGen.set_button(page.screen.querySelector('.copy_btn'))
		LGen.set_button_click(page.screen.querySelector('.copy_btn'), function() {
			LGen.call({'c':'str','f':'copy'})(page_item.screen.querySelector('.info').innerText)
			LGen.component.snackbar.open({'str':'Copied.'})
		})

		LGen.set_button(page.screen.querySelector('.buy_btn'))
		LGen.set_button_click(page.screen.querySelector('.buy_btn'), function(_this) {
			if (LGen.citizen.get({'key':'id','safe':'safe'}) === '') {
				LGen.component.header.open()
				LGen.component.signin.open()
				LGen.component.snackbar.open({'str':'Please sign in to continue.'})
			}
			else if (!LGen.citizen.get({'key':'is_verified','safe':'safe'})) {
				LGen.component.snackbar.open({'str':'Please verify your email to continue.'})
			}
			else if (false) {
				var url = 'payments/ipm/?gateway=ipaymu&action=new_trans&'+
				'item_id='+page.item['id']+
				'&quantity='+parseInt(page.screen.querySelector('.quantity').innerText)+
				'&price_total='+parseInt(TXT['item']['item_detail']['price'])*parseInt(quantity)+
				'&price_per_item='+parseInt(TXT['item']['item_detail']['price'])+
				'&currency='+TXT['item']['item_detail']['currency_id']+
				'&category_id='+TXT['item']['item_detail']['category_id']+
				'&store_id='+TXT['item']['item_detail']['store_id']+
				'&user_id='+JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['user_id']+
				'&prod_name='+str_to_url(TXT['item']['item_detail']['title'])+
				'&message='+str_to_url(message)+
				'&prod_info='+str_to_url(TXT['item']['item_detail']['shortdesc'])
				payment_url = ''
				req_to_backlite({'method':'get', 'url':url, 'callback': function(obj) {
					payment_url = obj['url']

					var item_detail = str_to_elm(
						'<div class="item_detail">'+item_payment_get().outerHTML+'</div>'
					)

					document.querySelector('#payment').appendChild(item_detail)

					$('.payment').fadeIn()
				}})
			}
			else {
				var qt = page.screen.querySelector('.quantity').innerText
				var name = page.screen.querySelector('.name').innerText
				var price = page.screen.querySelector('.price').innerText
				var you_will_buy = LGen.translator.get({'from_lang':'en','words':'You will buy'})
				var _for = LGen.translator.get({'from_lang':'en','words':'for'})
				var _continue = LGen.translator.get({'from_lang':'en','words':'Continue'})
				// lprint(you_will_buy+' '+qt+ ' '+name+' '+_for+' '+price+' Lanter Silver. '+_continue+'?')
				// return 0;
				if (page.currency === 'price')
					var cur = 'Lanter Silver.'
				else if (page.currency === 'price_idr')
					var cur = 'Rupiah.'
				else if (page.currency === 'price_usd')
					var cur = 'Dollar.'
				else if (page.currency === 'price_point')
					var cur = 'Lanter Point.'
				LGen.component.confirmation.open({
					'str': you_will_buy+' '+qt+ ' '+name+' '+_for+' '+price+' '+cur+' '+_continue+'?',
					'yes': function() {
						var _obj = {
							"json": {
								"cit_id": LGen.citizen.get({'key':'id','safe':'safe'}), 
								"qty":page.screen.querySelector('.purchase .quantity').innerText,
								"txid":page.txid,
								"cur":page.currency,
								"item_name":name,
								"item_sh_desc":page.item['lg_desc'],
								"med":page.medium,
								"item_id": page.item['id']
							},
							"func": '$store->buy_item'
						}
						lprint(_obj)
						LGen.call({'c':'req','f':'post'})('be.store.lanterlite.com/gate', _obj, function(obj){
							lprint(obj)
							if (obj === 'insufficient silver')
								LGen.component.information.open(LGen.translator.get({'from_lang':'en','words':'Insufficient Lanter Silver.'}))
							else if (obj === 'insufficient point')
								LGen.component.information.open(LGen.translator.get({'from_lang':'en','words':'Insufficient Lanter Point.'}))
							else if (obj[LGen.stat.stat] === 'ready to transfer') {
								window.location.href = obj[LGen.stat.data]['url']
								// window.open(obj[LGen.stat.data]['url'])
								// LGen.component.information.open(LGen.translator.get({'from_lang':'en','words':'Please complete the order using info below.'}))
								// $(page.screen.querySelector('.buy_btn')).fadeOut(0)
								// $(page.screen.querySelector('.copy_btn')).fadeIn(0)
								// page.set_info()
							}
							else if (obj[LGen.stat.stat] === LGen.stat.success) {
								LGen.citizen.set_all({'val':obj[LGen.stat.data],'safe':'safe'})
								LGen.component.information.open(LGen.translator.get({'from_lang':'en','words':'Item purchased successfully.'}))
							}
							// LGen.component.email_verification.previous_page = 'profile'
							// LGen.Page.change('email_verification')
						})
						lprint('buy!')
					}
				})
			}
		})
		// LGen.set_button(page.screen.querySelector('.back_btn'))
		// LGen.set_button_click(page.screen.querySelector('.back_btn'), function(_this) {
		// 	LGen.Page.change(page.previous_page)
		// })
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
			qt = qt+(1*inc*parseInt(page.item.multiple))
			LGen.translator.update({"elm":page.screen.querySelector('.purchase .quantity'), "text":qt })
			LGen.translator.update({"elm":page.screen.querySelector('.purchase .price'), "text":parseFloat(parseFloat(qt*page.item[page.currency]).toFixed(2)) })
		})
		LGen.set_button(page.screen.querySelector('.minus'))
		LGen.set_button_click(page.screen.querySelector('.minus'), function(_this) {
			var qt = parseInt(page.screen.querySelector('.purchase .quantity').innerText)
			var inc = parseInt(page.screen.querySelector('.increment').innerText)
			qt = qt-(1*inc*parseInt(page.item.multiple))
			if (qt > 0) {
				LGen.translator.update({"elm":page.screen.querySelector('.purchase .quantity'), "text":qt })
				lprint(parseFloat(parseFloat(page.item[page.currency]).toFixed(2)))
				LGen.translator.update({"elm":page.screen.querySelector('.purchase .price'), "text":parseFloat(parseFloat(qt*page.item[page.currency]).toFixed(2)) })
			}
		})
	}

	this.set_info = function() {
		var page = page_item
		if (page.medium === 'bni_syariah') {
			setTimeout(function() {
				LGen.translator.update({"elm":page.screen.querySelector('div.info'), "text": LGen.call({'c':'str', 'f':'to_elm'})(
				'<div theme fp>'+
					'<div>Rekening: 0797266815</div>'+
					'<div>Nama: IFAN DHANI PRASOJO</div>'+
					'<div>Berita: '+page.txid+'</div>'+
					'<div>Nominal: '+page.screen.querySelector('.price').innerText+'</div>'+
				'</div>').outerHTML, 'type':'innerHTML'})
				// page.screen.querySelector('div.info').appendChild(LGen.call({'c':'str', 'f':'to_elm'})(
				// '<div theme fp>'+
				// 	'<div>Rekening: 0797266815</div>'+
				// 	'<div>Nama: IFAN DHANI PRASOJO</div>'+
				// 	'<div>Berita: L'+page.txid+'</div>'+
				// 	'<div>Nominal: '+page.screen.querySelector('.price').innerText+'</div>'+
				// '</div>'))
			}, LGen.Page.speed)
		}
		else
			page.screen.querySelector('div.info').innerText = '-'
	}

	this.load_content = load_content
	function load_content(update_lang = false) {
		var page = page_item
		// LGen.call({'c':'elm','f':'clear_childs'})(page.screen.querySelector('.page_item .child'))
		// var _obj = {
		// 	"func": "get_data",
		// 	"json": {
		// 		"dir": "assets/store.lanterlite.com/lang/"+page.content_paths[page.url_name_index]+LGen.citizen.get({'key':'lang','safe':'safe'})+".lgd",
		// 		"type": "lgd"
		// 	}
		// }
		// LGen.call({'c':'req','f':'get'})('update.lanterlite.com/gate', _obj, function(obj) {
			// lprint(page.content_paths[page.url_name_index]+LGen.citizen.get({'key':'lang','safe':'safe'}))
			// return 0;
		var _obj = {
			"json": {
				// "namelist":["name","sh_desc"],
				"gate":"store",
				"val":{
					"lang":LGen.citizen.get({'key':'lang','safe':'safe'}),
					"page":"page_item",
					"prod_id":page.content_paths[page.url_name_index]
				},
			},
			"func": "$store->home_content"
		}
		LGen.call({'c':'req','f':'get'})('be.store.lanterlite.com/gate', _obj, function(obj) {
			lprint(obj)
			// return 0;
			page.item = obj
			// page.screen.querySelector('.product .id').innerText = obj['id']
			LGen.translator.update({"elm":page.screen.querySelector('.product .name'), "text":obj['name'] })
			LGen.translator.update({"elm":page.screen.querySelector('.product .desc'), "text":obj['sh_desc'] })
			LGen.translator.update({"elm":page.screen.querySelector('.product .seller'), "text":obj['store_name'] })
			LGen.translator.update({"elm":page.screen.querySelector('.full_desc .content'), "text":obj['lg_desc'] })

			if (!update_lang) {
				page.screen.querySelector('.product_img img').src = LGen.system.get({'safe':'safe'}).fe_url+'image.lanterlite.com/'+obj['img']['url']
				LGen.call({'c':'elm','f':'clear_childs'})(page.screen.querySelector('.product_img .imgs'))
				for (var i=0; i<obj.imgs.length; i++) {
					var asd = LGen.call({'c':'str','f':'to_elm'})(
						'<img class="theme fp" src="'+LGen.system.get({'safe':'safe'}).fe_url+'image.lanterlite.com/'+obj['imgs'][i]['url']+'">'
					)
					if (i == 0)
						 $(asd).addClass('active')
					LGen.set_button(asd)
					LGen.set_button_click(asd, function(_this) {
						page.screen.querySelector('.product_img img').src = _this.src
						$(page.screen.querySelector('.product_img .imgs img.active')).removeClass('active')
						$(_this).addClass('active')
					})
					page.screen.querySelector('.product_img .imgs').appendChild(asd)
				}
				lprint(obj)

				if ((obj['price']) !== '0')
					page.screen.querySelector('select.currency').appendChild(LGen.call({'c':'str', 'f':'to_elm'})('<option class="price_silver" value="price">Lanter Silver</option>'))
				if ((obj['price_point']) !== '0')
					page.screen.querySelector('select.currency').appendChild(LGen.call({'c':'str', 'f':'to_elm'})('<option class="price_point" value="price_point">Lanter Point</option>'))
				if ((obj['price_idr']) !== '0') {
					page.currency = 'price_idr'
					page.screen.querySelector('select.currency').appendChild(LGen.call({'c':'str', 'f':'to_elm'})('<option class="price_idr" value="price_idr">Rupiah (IDR)</option>'))
				}
				if ((obj['price_usd']) !== '0') {
					page.currency = 'price_usd'
					page.screen.querySelector('select.currency').appendChild(LGen.call({'c':'str', 'f':'to_elm'})('<option class="price_usd" value="price_usd">USD</option>'))
				}

				if ((obj['price_point']) !== '0')
					page.currency = 'price_point'
				if ((obj['price']) !== '0')
					page.currency = 'price'
				$(page.screen.querySelector('select.currency')).val(page.currency)
				page.screen.querySelector('.purchase .quantity').innerText = parseInt(page.item.multiple)
				LGen.translator.update({"elm":page.screen.querySelector('.purchase .price'), "text":obj[page.currency]*parseInt(page.screen.querySelector('.purchase .quantity').innerText) })
			}


			// var asd = LGen.call({'c':'str','f':'to_elm'})(decodeURIComponent(obj))
			// // LGen.Page.Self.update_css(asd)
			// $(asd).css({'opacity':0})
			// $(page.screen.querySelector('.page_item .child .content')).css({'opacity':0})
			// setTimeout(function() {
			// 	$(page.screen.querySelector('.page_item .child')).html(asd)
			// 	setTimeout(function() {
			// 		$(asd).css({'opacity':1})
			// 	}, 50)
			// 	// $(page.screen.querySelector('.page_item .child .content')).css({'opacity':1})
			// }, LGen.Page.speed)
		})
	}

	this.update = update
	function update() {
		var page = page_item
		LGen.Page.Self.update(page)
		LGen.component.footer.update()
		var txid = LGen.call({'c':'str','f':'rand'})(10).toUpperCase()
		page.txid = 'L'+txid

		// var _obj = {
		// 	"json": {},
		// 	"func": 'LGen("F")->gen_id'
		// }
		// LGen.call({'c':'req','f':'post'})(LGen.system.get({'safe':'safe'}).citizen_domain+'/gate', _obj, function(obj){
		// 	page.txid = obj
		// })
	}

	this.update_lang = function () {
		var page = page_item
		page.load_content(1)
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = page_item
		page.screen.querySelector('.quantity').innerText = '1'
		page.screen.querySelector('.increment').innerText = '1x'
		page.previous_page = ''
		LGen.Page.clear_childs(document.querySelector('select.currency'))
		LGen.component.footbar.clear()
	}

	this.when_opened = function () {
	// 	lprint('==================')
	// }
	// this.when_opened2 = function () {
		var page = page_item
		page.screen.querySelector('div.info').innerText = '-'

		$(page.screen.querySelector('.copy_btn')).fadeOut(0)
		$(page.screen.querySelector('.buy_btn')).fadeIn(0)

		page.load_content()
		page.update()
		setTimeout(function() {
			page.screen.querySelector('._footer').appendChild(LGen.component.footer.screen)
			$(LGen.component.footer.screen).show()
		}, LGen.Page.speed)
		LGen.component.footbar.add_plain(page.screen_footbar)
		LGen.component.header.show()
		LGen.component.footbar.show()
	}
}