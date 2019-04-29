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

var URL = {}
URL['page'] = 'page_store/' + page_id + "/" + LANG
URL['header'] = 'component/header/' + LANG
URL['sidebar'] = 'component/sidebar/' + LANG
URL['footer'] = 'component/footer/' + LANG
var KEYS = Object.keys(URL);

var TXT = []
TXT.push('page')
TXT.push('header')
TXT.push('sidebar')
TXT.push('footer')

var _page_set = function(){page_set()}
var _header_set = function(){header_set()}
var _sidebar_set = function(){sidebar_set()}
var _footer_set = function(){footer_set()}

var SET = []
SET.push(_page_set)
SET.push(_header_set)
SET.push(_sidebar_set)
SET.push(_footer_set)

var count = 0
text_get(count)

function text_get(count) {
 	json_read_local(BASE_URL + 'assets/'+APP_CODENAME+'/lang/'+URL[KEYS[count]], function(obj) {
		TXT[KEYS[count]] = obj
		SET[count]()
		count += 1
		if (count < KEYS.length) {
			text_get(count)
		}
	})
}
/* ================================================================ */
function page_set() {
	L.head.meta.add_desc(TXT['page']['tag']['meta']['description'])
	L.head.title_set(TXT['page']['tag']['title'])

	var page_item = document.createElement('div')
	page_item.setAttribute('class', 'page_item')
	page_item.setAttribute('id', 'page_item')
	L.body.add(page_item)

	var img = str_to_elm(
		'<div>'+
			'<div>'+
			'<table>'+
			'<tr>'+
			'<td class="img flexible">'+
				'<div>'+
					'<img class="std" src="http://localhost/assets/tradelite/img/page_store/stores/licensecard.png">'+
				'</div>'+
			'</td>'+
			'<td class="headinfo flexible">'+
				'<div style="height: 100%;" class="box_std">' + 
					'<div class="item_name">'+'Apple'+'</div>'+
					'<div class="item_shortdesc">'+'Think Different'+'</div>'+
					'<button class="std gold btn_buy">'+'Follow'+'</button>'+
					'<button class="std gold btn_wishlist">'+'Chat Penjual'+'</button>'+
				'</div>'+
			'</td>'+
			'</tr>'+
			'</table>'+
		'</div>'+
		'<div class="item_body">'+
			'<table>'+
			'<tr>'+
			'<td class="button flexible" colspan="2">'+
				'<div>'+
					'<button class="btn_detail active std gold" onclick="func_btn_detail()">'+'Produk'+'</button>'+
					'<button class="btn_review std gold" onclick="func_btn_review()">'+'Ulasan Toko'+'</button>'+
					'<button class="btn_discuss std gold" onclick="func_btn_discuss()">'+'Informasi Toko'+'</button>'+
				'</div>'+
			'</td>'+
			'</tr>'+
			'<tr>'+
			'<td class="content_left flexible">'+
				'<div class="box_std">'+
					'<div class="item_detail">'+page_1_create().outerHTML+'</div>'+
					'<div class="item_review" style="display: none;">'+'Feedback'+'</div>'+
					'<div class="item_discuss" style="display: none;">'+'Discussion'+'</div>'+
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
	// page_item.appendChild(page_1_create())
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
// 	L.header.blank_col.set()
// 	L.header.account.set()
// 	L.header.hide_when_scroll_on()
// 	var header_img = BASE_URL + "assets/lite.img/lanterlite.svg"
// 	L.header.logo.img(header_img)
// }