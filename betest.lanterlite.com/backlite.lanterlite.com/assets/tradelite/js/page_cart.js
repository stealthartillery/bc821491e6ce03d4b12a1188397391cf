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

var URL = {}; var TXT = []; var SET = []; 
URL['page'] = 'page_cart/'+LANG; 						 TXT.push('page');		 SET.push(function(){init()})
URL['header'] = 'component/header/'+LANG; 	 TXT.push('header'); 	 SET.push(function(){header_set()})
URL['sidebar'] = 'component/sidebar/'+LANG;  TXT.push('sidebar');  SET.push(function(){sidebar_set()})
URL['footer'] = 'component/footer/'+LANG; 	 TXT.push('footer');   SET.push(function(){footer_set()})
var KEYS = Object.keys(URL);


var count = 0
text_get(count)

function text_get(count) {
 	json_read_local(FE_BASE_URL + 'assets/'+APP_CODENAME+'/lang/'+URL[KEYS[count]], function(obj) {
		TXT[KEYS[count]] = obj
		SET[count]()
		count += 1
		if (count < KEYS.length) {
			text_get(count)
		}
	})
}
/* ================================================================ */

var ready_list = [];
var ready_tot = 1;

function init() {
	(function wait() {
    // if ( ready_tot == ready_list.length ) {
    if ( true ) {
    	page_set()
    } else {
      setTimeout( wait, 500 );
    }
	}) ();
}

function page_set() {
	var post2 = document.createElement('div')
	post2.setAttribute('id', 'post_2')

	var home = document.createElement('div')
	home.setAttribute('class', 'home-page')
	home.appendChild(post2)

	var body = document.querySelector('#canvas #body')
	body.appendChild(home)

	L.head.meta.add_desc(TXT['page']['tag']['meta']['description'])
	L.head.title_set(TXT['page']['tag']['title'])
  $(document).ready(function() {
    $.ajax({
      url: BE_URL + "user/getcart/?user_id="+JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['user_id'],
      type: 'GET',
      dataType: 'json',
      success: function(obj) { page_set_2(obj[DATA][DATA]); },
	    error: function(e) { page_set_2(obj[DATA][DATA]);}
	    // error: function(e) { console.log(e.responseText); }
    });
  });

 	function page_set_2(obj) {
 		console.log(obj)
		var PAGE_TXT = {
			"title" : "Cart",
			"content" : []
		}

		var count = 0
 		for (var i=0; i<obj.length; i++) {
 			_obj = obj
	 		console.log(obj)
 		 	json_read_local(FE_BASE_URL + 'assets/'+APP_CODENAME+'/lang/page_item/'+obj[i]['item_id']+'/'+LANG, function(obj2) {
 		 		count++
 		 		console.log(obj2)
 		 		var content = {
 		 			"title" : obj2['item_detail']['title'],
 		 			"sub1" : "Rp. " + int_to_idr(obj2['item_detail']['price']),
 		 			"sub2" : "by "+ obj2['item_detail']['store'],
 		 			"img" : "page_item/"+obj2['item_detail']['id']+"/img1.png",
 		 			"link" : [
 		 				{ "title" : "Detail Barang", "url": "item/licensecard" },
 		 				{ "title" : "Detail Barang", "url": "item/licensecard" }
	 				]
 		 		}
 		 		PAGE_TXT['content'].push(content)
 		 		console.log(i)
 		 		console.log(_obj.length)
 		 		if (count == _obj.length) {
					post2.appendChild(page_1_create(PAGE_TXT))
 		 		}
			})
 		}
  // setTimeout(function () {
  // 	console.log(PAGE_TXT)
		// post2.appendChild(page_1_create(PAGE_TXT))
  // }, 1000);

 	}
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
// 	var header_img = BASE_URL + "assets/"+APP_CODENAME+"/img/tradelite.svg"
// 	L.header.logo.img(header_img)
// }
