/* ================================================================ */
var app = L.app.get(APP_ID)
if (app[RES_STAT] == NOT_EXIST) {
	// if (visitor.geo.countryName  == 'Indonesia')
	  app["LANG"] = 'id'
	// else
	//   app["LANG"] = 'en'
	L.app.set(APP_ID, app)
}

var LANG = app['LANG']

var URL = {}; var TXT = [];
URL['page'] = "page_item/default/"+LANG; 		 TXT.push('page');
URL['item'] = 'page_item/'+item_id+"/"+LANG; TXT.push('item');
URL['header'] = 'component/header/'+LANG; 	 TXT.push('header');
URL['sidebar'] = 'component/sidebar/'+LANG;  TXT.push('sidebar');
URL['footer'] = 'component/footer/'+LANG; 	 TXT.push('footer');
var KEYS = Object.keys(URL);

var count = 0
text_get(count)

function text_get(count) {
 	json_read_local(BASE_URL + 'assets/'+APP_CODENAME+'/lang/'+URL[KEYS[count]], function(obj) {
		TXT[KEYS[count]] = obj
		count += 1
		if (count < KEYS.length) {
			text_get(count)
		}
		else {
			ready_list.push(true)
			page_init()
		}
	})
}

function footer_init() {
	(function wait() {
    if ( page_ready ) {
    	// ready_list.push(true)
    } else {
      setTimeout( wait, 100 );
    }
	}) ();
}

function page_init() {
	(function wait() {
    if ( ready_tot == ready_list.length ) {
    	page_set()
    	header_set()
    	sidebar_set()
    	footer_set()
    	page_ready = true
    } else {
      setTimeout( wait, 100 );
    }
	}) ();
}


// (str_to_elm(icons['cart']).setAttribute('style', 'width: 24px; height: 24px; vertical-align: bottom;')).outerHTML
/* ================================================================ */
var img_active = ''
function move_img(e) {
	if( !e ) e = window.event;
	var imgs = document.querySelectorAll('.secondary img')
	for(var i=0 ; i<imgs.length; i++) {
		$(imgs[i]).removeClass('active')
	}
	$(e.target).addClass('active')
	img_active = e.target
	document.querySelector('.primary img').setAttribute('src', $(e.target).attr("src"))
}

function page_set() {
	L.head.meta.add_desc(TXT['item']['tag']['meta']['description'])
	L.head.title_set(TXT['item']['tag']['title'])

	var icon_cart = str_to_elm(icons['cart'])
	$(icon_cart).css({'margin-right':'5px', 'width': '24px', 'height': '24px'})
	$(icon_cart).addClass('yellow')
	var icon_heart = str_to_elm(icons['heart'])
	$(icon_heart).css({'margin-right':'5px', 'width': '24px', 'height': '24px'})
	$(icon_heart).addClass('yellow')

	var page_item = document.createElement('div')
	page_item.setAttribute('class', 'page_item')
	page_item.setAttribute('id', 'page_item')
	L.body.add(page_item)

	var img = str_to_elm(
		'<div>'+
			'<div class="item_head">'+
			'<table>'+
			'<tr>'+
			'<td class="img flexible">'+
				'<div class="primary">'+
					'<img class="std" src="http://localhost/assets/tradelite/img/page_item/'+TXT['item']['item_detail']['id']+'/img1.png">'+
				'</div>'+
				'<div class="secondary">'+
					'<img class="std active" onclick="move_img()" src="http://localhost/assets/tradelite/img/page_item/'+TXT['item']['item_detail']['id']+'/img1.png">'+
					'<img class="std" onclick="move_img()" src="http://localhost/assets/tradelite/img/page_item/'+TXT['item']['item_detail']['id']+'/banner_goods.png">'+
					'<img class="std" onclick="move_img()" src="http://localhost/assets/tradelite/img/page_item/'+TXT['item']['item_detail']['id']+'/banner_transfer.png">'+
					'<img class="std" onclick="move_img()" src="http://localhost/assets/tradelite/img/page_item/'+TXT['item']['item_detail']['id']+'/banner_goods.png">'+
					'<img class="std" onclick="move_img()" src="http://localhost/assets/tradelite/img/page_item/'+TXT['item']['item_detail']['id']+'/banner_transfer.png">'+
				'</div>'+
			'</td>'+
			'<td class="headinfo flexible">'+
				'<div style="height: 100%;" class="box_std">' + 
					'<div class="item_name">'+TXT['item']['item_detail']['title']+'</div>'+
					'<div class="item_seller">'+TXT['page']['word']['by']+' '+'<a class="std" href="">'+TXT['item']['item_detail']['store']+'</a>'+'</div>'+
					'<div class="item_condition">'+TXT['page']['word']['condition']+' '+TXT['item']['item_detail']['condition']+'</div>'+
					'<div class="item_price">'+(TXT['item']['price_id'] === 'id'? 'Rp. '+int_to_idr(TXT['item']['item_detail']['price']) : '$'+int_to_idr(TXT['item']['item_detail']['price']))+'</div>'+
					'<div class="item_shortdesc">'+TXT['item']['item_detail']['shortdesc']+'</div>'+
					'<div class="item_button">'+
						'<button onclick="buy_click()" class="std gold btn_buy">'+TXT['page']['word']['buy']+'</button>'+
						'<button onclick="wishlist_click()" class="std gold btn_wishlist" style="vertical-align: bottom;">'+icon_heart.outerHTML+'</button>'+
						// '<button class="std gold btn_wishlist">'+'❤'+'</button>'+
						// '<button class="std gold btn_wishlist">'+TXT['page']['word']['wishlist']+'</button>'+
						'<button onclick="cart_click()" class="std gold btn_cart" style="vertical-align: bottom;">'+icon_cart.outerHTML+'</button>'+
						// '<button class="std gold btn_cart">'+TXT['page']['word']['add_to_cart']+'</button>'+
					'</div>'+
				'</div>'+
			'</td>'+
			// '<td class="item_sellerinfo flexible">'+
			// 	'<div class="box_std">' + 
			// 		'<div class="seller_img">'+'<img class="std" src="http://localhost/assets/tradelite/img/page_item/'+TXT['item']['item_detail']['id']+'/apple-logo.jpg">'+'</div>'+
			// 		'<div class="seller_name">'+'<a class="std" href="">Apple</a>'+'</div>'+
			// 	'</div>'+
			// '</td>'+
			'<tr>'+
				'<td colspan="2" class="content flexible">'+
					'<div class="box_std">'+
						'<div class="item_shortdesc_2">'+TXT['item']['item_detail']['shortdesc']+'</div>'+
					'</div>'+
				'</td>'+
			'</tr>'+
			'</tr>'+
			'</table>'+
		'</div>'+
		'<div class="item_body">'+
			'<table>'+
			'<tr>'+
			'<td class="button flexible" colspan="2">'+
				'<div>'+
					'<button class="btn_detail active std gold" onclick="func_btn_detail()">'+TXT['page']['word']['detail']+'</button>'+
					'<button class="btn_review std gold" onclick="func_btn_review()">'+TXT['page']['word']['review']+'</button>'+
					'<button class="btn_discuss std gold" onclick="func_btn_discuss()">'+TXT['page']['word']['discuss']+'</button>'+
				'</div>'+
			'</td>'+
			'</tr>'+
			'<tr>'+
			'<td class="content flexible">'+
				'<div class="box_std" style="box-sizing: border-box;">'+
					'<div class="item_detail">'+item_detail_get().outerHTML+'</div>'+
					'<div class="item_review" style="display: none;">'+item_review_get().outerHTML+'</div>'+
					'<div class="item_discuss" style="display: none;">'+item_discuss_get().outerHTML+'</div>'+
				'</div>'+
			'</td>'+
			// '<td class="content_right flexible">'+
			// 	'<div class="box_std">'+
			// 	'</div>'+
			// '</td>'+
			'</tr>'+
			'</table>'+
		'</div>'+
		'</div>')
	page_item.appendChild(img)
}

function item_review_get() {
	if (TXT['item']['item_review'] !== null) {
		function create_table() {
			return str_to_elm(
				'<table>'+
				'<tr>'+
					'<td class="flexible" style="width: 50%; vertical-align: top;">'+'</td>'+
					'<td class="flexible" style="width: 50%; vertical-align: top;">'+'</td>'+
				'</tr>'+
				'</table>'
			)
		}
		var table = create_table()

		var div1 = document.createElement('div')
		div1.setAttribute('style', 'text-align: left;')

		var count = 0
		
		$.each(TXT['item']['item_review'], function(key, value){
			if (count == 0) {
				table = create_table()

				div = document.createElement('div')
				div.setAttribute('style', 'text-align: left;')
				table.childNodes[0].childNodes[0].childNodes[0].appendChild(div)
				div1.appendChild(table)
				count = count + 1
			}
			else {
				count = 0
				div = document.createElement('div')
				div.setAttribute('style', 'text-align: left;')
				console.log(table)
				table.childNodes[0].childNodes[0].childNodes[1].appendChild(div)
			}
			var div_head = str_to_elm(
				'<table style="width: fit-content;">'+
				'<tr>'+
					'<td style="width: 30px; padding: 0px 0px;">'+'<img class="std" src='+value["img"]+'>'+'</td>'+
					'<td style="padding: 0px 10px;">'+value['username']+'</td>'+
				'</tr>'+
				'</table>'
			)
			var _date = str_to_elm('<div style="font-size: small; font-family: sans-serif; color: green;">'+value['date']+'</div>')
			var _comment = str_to_elm('<div style="font-size: medium; font-family: sans-serif; color: black; padding: 10px 0px;">"'+value['comment']+'"</div>')

			var _rate = str_to_elm('<div class="rating">'+'</div>')
			console.log(value['rate'])
			for (var i=0; i<5; i++) {
				if (i<value['rate'])
					_rate.appendChild(str_to_elm('<span>★</span>'))
				else
					_rate.appendChild(str_to_elm('<span>☆</span>'))
			}
			var _head = document.createElement('div')
			_head.appendChild(div_head)

			var _body = document.createElement('div')
			_body.appendChild(_rate)
			_body.appendChild(_date)

			var _foot = document.createElement('div')
			_foot.appendChild(_comment)

			div.appendChild(_head)
			div.appendChild(_body)
			div.appendChild(_foot)
		});
		return div1
	}
	else {
		return str_to_elm("<span>("+TXT['page']['word']["no_review"]+")</span>")
	}
}

function item_discuss_get() {
	if (TXT['item']['item_discuss'] !== null) {
		var table = create_table()

		var div1 = document.createElement('div')
		div1.setAttribute('style', 'text-align: left;')
		var inp = str_to_elm(
			'<div>'+
				'<input class="std" placeholder="'+TXT['page']['word']["ask_here"]+'" style="margin: 0px 0px 10px 0px;">'+
				'<div style="text-align: right;">'+
					'<button onclick="post_ask_click()" class="std gold" style="height: 30px; margin: 0px;">Post</btn>'+
				'</div'+
			'</div>'
		)
		div1.appendChild(inp)

		var count = 0
		
		$.each(TXT['item']['item_discuss'], function(key, value){
			if (count == 0) {
				table = create_table()

				div = document.createElement('div')
				div.setAttribute('style', 'text-align: left;')
				table.childNodes[0].childNodes[0].childNodes[0].appendChild(div)
				div1.appendChild(table)
				count = count + 1
			}
			else {
				count = 0
				div = document.createElement('div')
				div.setAttribute('style', 'text-align: left;')
				console.log(table)
				table.childNodes[0].childNodes[0].childNodes[1].appendChild(div)
			}

			var div_head = str_to_elm(
				'<div>'+
				'<table style="width: fit-content;">'+
				'<tr>'+
					'<td style="width: 30px; padding: 0px 0px;">'+'<img class="std" src='+value["img"]+'>'+'</td>'+
					'<td style="padding: 0px 10px;">'+value['username']+'</td>'+
				'</tr>'+
				'</table>'+
				'</div>'
			)
			var _date = str_to_elm(
				'<div>'+
					'<div style="padding: 10px 0px; font-size: small; font-family: sans-serif; color: green;">'+value['date']+'</div>'+
				'</div>'
			)
			var _comment = str_to_elm(
				'<div style="font-size: medium; font-family: sans-serif; color: black;">"'+value['comment']+'"</div>'
			)
			var _answer_btn = str_to_elm(
				'<div style="font-size: medium; font-family: sans-serif; padding: 10px 0px;">'+
					'<a onclick="answer_open_close()" class="std" >'+TXT['page']['word']["answer"]+' ('+value['answer'].length+')'+'</a>'+
				'</div>'
			)

			var _answer = str_to_elm('<div class="answer" style="display: none;">'+'</div>')
			_answer_btn.appendChild(_answer)

			$.each(value['answer'], function(key, value){
				var _head2 = str_to_elm(
					'<div>'+
						'<table style="width: fit-content;">'+
						'<tr>'+
							'<td style="width: 30px; padding: 0px 0px;">'+'<img class="std" src='+value["img"]+'>'+'</td>'+
							'<td style="padding: 0px 10px;">'+value['username']+'</td>'+
						'</tr>'+
						'</table>'+
					'</div>'
				)
				var _date2 = str_to_elm(
					'<div>'+
						'<div style="padding: 10px 0px; font-size: small; font-family: sans-serif; color: green;">'+value['date']+'</div>'+
					'</div>'
				)
				var _comment2 = str_to_elm(
					'<div>'+
						'<div style="font-size: medium; font-family: sans-serif; color: black;">"'+value['comment']+'"</div>'+
					'</div>'
				)

				var div2 = str_to_elm(
					'<div style="padding: 10px 10px 10px 25px;">'+
						_head2.outerHTML+
						_date2.outerHTML+
						_comment2.outerHTML+
					'</div>'
				)

				_answer.appendChild(div2)
			})

			var _inp = str_to_elm(
				'<div>'+
					'<input id="'+key+'" class="std" placeholder="'+TXT['page']['word']["answer_here"]+'" style="margin: 10px 0px;">'+
					'<div style="text-align: right;">'+
						'<button onclick="post_answer_click()" class="std gold" style="height: 30px; margin: 0px;">Post</btn>'+
					'</div>'+
				'</div>'
			)
			_answer.appendChild(_inp)

			var _foot = str_to_elm(
				'<div>'+
					_comment.outerHTML+
					_answer_btn.outerHTML+
				'</div>'
			)

			div.appendChild(div_head)
			div.appendChild(_date)
			div.appendChild(_foot)
		});

		return div1

		function create_table() {
			return str_to_elm(
				'<table>'+
				'<tr>'+
					'<td class="flexible" style="width: 50%; vertical-align: top;">'+'</td>'+
					'<td class="flexible" style="width: 50%; vertical-align: top;">'+'</td>'+
				'</tr>'+
				'</table>'
			)
		}
	}
	else {
		return str_to_elm("<span>("+TXT['page']['word']["no_review"]+")</span>")
	}
}

function buy_click(e) {
	if (login) {
	}
	else {
		L.header.open()
		L.header.account.open()
		L.snackbar.open(TXT['page']['word']["you_must_login_to_continue"])
	}
}

function cart_click(e) {
	if (login) {
		var obj_req = {
			"method" : "get",
			"url" : "user/getcart/?user_id="+JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['user_id'],
			"callback": function(obj) {
				var count = 0
				$.each(obj[DATA][DATA], function(key, value) {
					count++
					if (value['item_id'] == TXT['item']['item_detail']['id']) {
						L.snackbar.open(TXT['page']['word']['item_exist'])
					}
					else if (count == obj[DATA][DATA].length) {
						var new_obj = { "item_id" : TXT['item']['item_detail']['id']}
						obj[DATA][DATA].push(new_obj)
						var data = {
							"user_id":JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['user_id'],
							"cart":obj[DATA][DATA]
						}
						var obj_req2 = {
							"method" : "post",
							"data" : data,
							"url" : "user/setcart",
							"callback": function(obj) {
								L.snackbar.open(TXT['page']['word']['item_added'])
							}
						}; req_to_backlite(obj_req2)
					}
				})
			}
		}
		req_to_backlite(obj_req)
	}
	else {
		L.header.open()
		L.header.account.open()
		L.snackbar.open(TXT['page']['word']["you_must_login_to_continue"])
	}
}

function wishlist_click(e) {
	if (login) {
		var obj_req = {
			"method" : "get",
			"url" : "user/getwishlist/?user_id="+JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['user_id'],
			"callback": function(obj) {
				var count = 0
				$.each(obj[DATA][DATA], function(key, value) {
					count++
					if (value['item_id'] == TXT['item']['item_detail']['id']) {
						L.snackbar.open(TXT['page']['word']['item_exist'])
					}
					else if (count == obj[DATA][DATA].length) {
						console.log('item not exist')
						var new_obj = { "item_id" : TXT['item']['item_detail']['id']}
						obj[DATA][DATA].push(new_obj)
						var data = {
							"user_id":JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['user_id'],
							"wishlist":obj[DATA][DATA]
						}
						var obj_req2 = {
							"method" : "post",
							"data" : data,
							"url" : "user/setwishlist",
							"callback": function(obj) {
								L.snackbar.open(TXT['page']['word']['item_added'])
							}
						}; req_to_backlite(obj_req2)
					}
				})
			}
		}
		req_to_backlite(obj_req)
	}
	else {
		L.header.open()
		L.header.account.open()
		L.snackbar.open(TXT['page']['word']["you_must_login_to_continue"])
	}

}

function post_ask_click(e) {
	if (login) {
		if( !e ) e = window.event;

		var _question = e.target.parentNode.parentNode.childNodes[0]
		// console.log(e.target.parentNode.parentNode)
		var question = {
			"comment" : _question.value,
			"answer" : [],
			"date" : date_get_str(),
			"img" : JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['user_image'],
			"username" : JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['user_username']
		}
		// console.log(question)
		TXT['item']['item_discuss'].push(question)
		var obj = JSON.stringify(TXT['item'])
		var data = '$G->set_item($item_id='+'"'+TXT['item']['item_detail']['id']+'"'+',$lang_id='+'"id"'+',$json_obj="'+btoa(obj)+'");'
		req_to_frontlite('tradelite', data, function(obj) {
			var item_discuss = document.querySelector('.item_discuss')
			clear_self(item_discuss.childNodes[0])
			item_discuss.appendChild(item_discuss_get())
			console.log(obj)
		})
	}
	else {
		L.header.open()
		L.header.account.open()
		L.snackbar.open(TXT['page']['word']["you_must_login_to_continue"])
	}
}

function post_answer_click(e) {
	if (login) {
		if( !e ) e = window.event;

		var _answer = e.target.parentNode.parentNode.childNodes[0]
		var answer = {
			"comment" : _answer.value,
			"date" : date_get_str(),
			"img" : JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['user_image'],
			"username" : JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['user_username']
		}

		TXT['item']['item_discuss'][parseInt(_answer.id)]['answer'].push(answer)
		var obj = JSON.stringify(TXT['item'])
		var data = '$G->set_item($item_id='+'"'+TXT['item']['item_detail']['id']+'"'+',$lang_id='+'"id"'+',$json_obj="'+btoa(obj)+'");'
		req_to_frontlite('tradelite', data, function(obj) {
			var item_discuss = document.querySelector('.item_discuss')
			clear_self(item_discuss.childNodes[0])
			item_discuss.appendChild(item_discuss_get())
			console.log(obj)
		})
	}
	else {
		L.header.open()
		L.header.account.open()
		L.snackbar.open(TXT['page']['word']["you_must_login_to_continue"])
	}
}

function answer_open_close(e) {
	if( !e ) e = window.event;
	var _answer = e.target.parentNode.childNodes[1]
	if (_answer.style.display == 'none')
		$(_answer).fadeIn()
	else 
		$(_answer).fadeOut()
}

function item_detail_get() {
	var table = document.createElement('table')
	table.setAttribute('style', 'text-align: left; width: fit-content;')
	$.each(TXT['item']['item_detail'], function(key, value){
		if (key !== 'shortdesc' && key !== 'price' && key !== 'id') {
			var td_title = document.createElement('td')
			var title = TXT['page']['word'][key]
			td_title.innerHTML = title

			var td_colon = document.createElement('td')
			td_colon.innerHTML = ":"

			var td_value = document.createElement('td')
			td_value.innerHTML = value

			var tr = document.createElement('tr')
			tr.appendChild(td_title)
			tr.appendChild(td_colon)
			tr.appendChild(td_value)
			table.appendChild(tr)
		}
	});
	return table
}

function func_btn_detail(e) {
	if( !e ) e = window.event;
	$(e.target).removeClass('active')

	$('.item_body .btn_detail').removeClass('active').addClass('active')
	$('.item_body .btn_review').removeClass('active')
	$('.item_body .btn_discuss').removeClass('active')

	$('.item_body .item_review').fadeOut(function() {
		$('.item_body .item_discuss').fadeOut(function() {
			$('.item_body .item_detail').fadeIn()
		})
	})
}

function func_btn_review(e) {
	if( !e ) e = window.event;
	$(e.target).removeClass('active')
	$('.item_body .btn_detail').removeClass('active')
	$('.item_body .btn_discuss').removeClass('active')
	$('.item_body .btn_review').removeClass('active').addClass('active')
	$('.item_body .item_detail').fadeOut(function() {
		$('.item_body .item_discuss').fadeOut(function() {
			$('.item_body .item_review').fadeIn()
		})
	})
}

function func_btn_discuss(e) {
	if( !e ) e = window.event;
	$(e.target).removeClass('active')
	$('.item_body .btn_review').removeClass('active')
	$('.item_body .btn_detail').removeClass('active')
	$('.item_body .btn_discuss').removeClass('active').addClass('active')
	$('.item_body .item_review').fadeOut(function() {
		$('.item_body .item_detail').fadeOut(function() {
			$('.item_body .item_discuss').fadeIn()
		})
	})
}

// function sidebar_set() {
// 	L.sidebar.set()

// 	var sidebar_img = BASE_URL + "assets/lite.img/lanterlite+logo.svg"
// 	L.sidebar.img(sidebar_img)
// 	function func_create(link) {
// 		return function() { change_page_by_url(HOME_URL + link) }		
// 	}
// 	for (var i=0; i<TXT['sidebar']['sidebar'].length; i++) {
// 		var func = func_create(TXT['sidebar']['sidebar'][i]['link'])
// 		L.sidebar.add({'id': 'sb' + i, 'title': TXT['sidebar']['sidebar'][i]['title'], 'callback': func })
// 	}
// }

// function header_set() {
// 	L.header.set()
// 	L.header.menu.set()
// 	var menu_logo = BASE_URL + "assets/lite.img/sidebar.svg"
// 	L.header.menu.img(menu_logo)
// 	L.header.logo.set()
// 	L.header.srcbar.set()
// 	L.header.blank_col.set()
// 	var obj = [
// 		{
// 			'title' : 'Keranjang',
// 			'func' : function () {}
// 		},
// 		{
// 			'title' : 'Wishlist',
// 			'func' : function () {}
// 		}
// 	]
// 	L.header.account.set(obj)
// 	L.header.hide_when_scroll_on()
// 	var header_img = BASE_URL + "assets/"+APP_CODENAME+"/img/tradelite.svg"
// 	L.header.logo.img(header_img)
// }