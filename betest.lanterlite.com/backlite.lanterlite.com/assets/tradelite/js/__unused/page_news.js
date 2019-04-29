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
URL['page'] = 'page_news/' + news_id + "/" + LANG
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

	var page_news = document.createElement('div')
	page_news.setAttribute('class', 'page_news')
	page_news.setAttribute('id', 'page_news')
	L.body.add(page_news)
	for(var i=0; i<TXT['page']['post'].length; i++) {
	  var keys = Object.keys(TXT['page']['post'][i]);
	  if (keys == 'title') {
	  	var txt = document.createElement('h1')
	  	txt.innerHTML = TXT['page']['post'][i][keys]
		  page_news.appendChild(txt)
	  }
	  else if (keys == 'sub') {
	  	var txt = document.createElement('h2')
	  	txt.setAttribute('class', 'sub')
	  	txt.innerHTML = TXT['page']['post'][i][keys]		  	
		  page_news.appendChild(txt)
	  }
	  else if (keys == 'img') {
	  	var img = document.createElement('img')
	  	$(img).css({"width": "100%"})
	  	img.setAttribute("class", "std")
	  	img.src = BASE_URL + "assets/corelite/img/" + TXT['page']['post'][i][keys]
		  page_news.appendChild(img)
	  }
	  else if (keys == 'link') {
	  	var a = str_to_elm(TXT['page']['post'][i][keys])
	  	a.setAttribute('class', 'std third after')
	  	a.setAttribute('target', '_blank')
	  	// new_anc = anchor_set(a)
		  page_news.appendChild(a)
	  }
	  else if (keys == 'elm') {
	  	var elm = str_to_elm(TXT['page']['post'][i][keys])
		  page_news.appendChild(elm)
	  }
	  else if (keys == 'span') {
	  	var elm = document.createElement('span')
	  	elm.innerHTML = TXT['page']['post'][i][keys]
		  page_news.appendChild(elm)
	  }
	  else if (keys == 'p') {
	  	var elm = document.createElement('span')
	  	elm.setAttribute('class', 'p')
	  	elm.innerHTML = TXT['page']['post'][i][keys]
		  page_news.appendChild(elm)
	  }
	  else if (keys == 'author') {
	  	var elm = document.createElement('span')
	  	elm.innerHTML = TXT['page']['post'][i][keys]
	  	elm.setAttribute('style', 'color: cornflowerblue; font-weight: 600;')
		  page_news.appendChild(elm)
	  }
	  else if (keys == 'date') {
	  	var elm = document.createElement('span')
	  	elm.innerHTML = TXT['page']['post'][i][keys]
	  	elm.setAttribute('style', 'color: darkgreen; font-weight: 600;')
		  page_news.appendChild(elm)
	  }
	};
}

function sidebar_set() {
	L.sidebar.set()

	var sidebar_img = BASE_URL + "assets/lite.img/lanterlite+logo.svg"
	L.sidebar.img(sidebar_img)
	function func_create(link) {
		return function() { change_page_by_url(HOME_URL + link) }		
	}
	for (var i=0; i<TXT['sidebar']['sidebar'].length; i++) {
		var func = func_create(TXT['sidebar']['sidebar'][i]['link'])
		L.sidebar.add({'id': 'sb' + i, 'title': TXT['sidebar']['sidebar'][i]['title'], 'callback': func })
	}
}

function header_set() {
	L.header.set()
	L.header.menu.set()
	var menu_logo = BASE_URL + "assets/lite.img/sidebar.svg"
	L.header.menu.img(menu_logo)
	L.header.logo.set()
	L.header.blank_col.set()
	L.header.account.set()
	L.header.hide_when_scroll_on()
	var header_img = BASE_URL + "assets/lite.img/lanterlite.svg"
	L.header.logo.img(header_img)
}