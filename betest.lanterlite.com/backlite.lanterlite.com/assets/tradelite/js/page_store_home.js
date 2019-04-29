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
URL['page'] = 'page_store/default/' + LANG
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
var FF_SIZE = 12;

var slideIndex = 0;
var is_ready = false;
setSlideTable();

function setSlideTable() {

	var slides = document.createElement('div')
	// slides.setAttribute('id', 'slide_image')
	slides.setAttribute('class', 'slideshow-container')

	var dots = document.createElement('div')
	dots.setAttribute('class', 'home-dots')

	var img = document.createElement('img')
	var style = ([
		// 'height:10px;',
		'width:100%;',
		// 'padding:10px;',
	]).join(' ')
	img.setAttribute('style', style)
	
	dimg = document.createElement('div')
	var style = ([
		'height:10px;',
		'width:10px;',
		// 'padding:10px;',
	]).join(' ')
	dimg.setAttribute('style', style)
	dimg.appendChild(img)

	var td = document.createElement('td')
	td.setAttribute("class","home_post_1 home-slide-image")
	td.setAttribute("id", "slide_image")
	// td.appendChild(dimg)
	td.appendChild(slides)
	td.appendChild(dots)


	var tr = document.createElement('tr')
	tr.appendChild(td)

	var tbl = document.createElement('table')
	tbl.appendChild(tr)

	hpost = document.createElement('div')
	hpost.setAttribute('id', 'home-post')
	hpost.appendChild(tbl)

	post2 = document.createElement('div')
	post2.setAttribute('id', 'post_2')

	var home = document.createElement('div')
	home.setAttribute('class', 'home-page')
	home.appendChild(hpost)
	home.appendChild(post2)

	var body = document.querySelector('#canvas #body')
	body.appendChild(home)
}

function setSlide() {
	var div_1 = document.createElement('div')
	div_1.setAttribute('class', 'mySlides fade')
	var div_2 = document.createElement('div')
	div_2.setAttribute('class', 'numbertext')

	var table = document.createElement('table')
	table.setAttribute('class', 'home_slide_table')
	var tr_1 = document.createElement('tr')
	var tr_2 = document.createElement('tr')
	var td_1 = document.createElement('td')
	td_1.setAttribute('class', 'col_1')
	var td_2 = document.createElement('td')
	td_2.setAttribute('class', 'col_2')
	var div_title = document.createElement('div')
	div_title.setAttribute('class', 'title_text')
	style = 'margin: 20% 20% 0% 20%;'
	style += 'color: cornsilk;'
  style += 'font-size: 5vw;'
  style += "margin: 20% 20% 0% 20%;"
  style += 'font-family: Crimson;'
  div_title.setAttribute('style', style)

	var div_subtitle = document.createElement('div')
	style = 'margin: 20% 20% 0% 20%;'
	style += 'color: cornsilk;'
  style += 'font-size: 3vw;'
  style += "margin: 0% 20% 20% 20%;"
  style += 'font-family: Crimson;'
  div_subtitle.setAttribute('style', style)
	div_subtitle.setAttribute('class', 'subtitle_text')

	var div_text = document.createElement('div')
	div_text.setAttribute('class', 'text')

	td_1.appendChild(div_title)
	td_2.appendChild(div_subtitle)
	tr_1.appendChild(td_1)
	tr_2.appendChild(td_2)
	table.appendChild(tr_1)
	table.appendChild(tr_2)
	div_1.appendChild(div_2)
	div_1.appendChild(table)
	div_1.appendChild(div_text)
	var div_slide = document.querySelector('.slideshow-container')
	div_slide.appendChild(div_1)
}

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex> slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }

  try {
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    document.getElementById('slide_image').style.background = "black url(" + FE_BASE_URL + 'assets/'+APP_CODENAME+'/img/' + TXT['page']['slide'][slideIndex-1]['img'] + ") no-repeat 50%"
    setTimeout(showSlides, 5000); // Change image every 2 seconds
  }
  catch(err) {}
}


function page_set() {
	L.head.meta.add_desc(TXT['page']['tag']['meta']['description'])
	L.head.title_set(TXT['page']['tag']['title'])

	for(var i=0; i<TXT['page']['slide'].length; i++) {
		setSlide()
		setDots()
		document.getElementsByClassName('title_text')[i].innerHTML = TXT['page']['slide'][i]['title']
		document.getElementsByClassName('subtitle_text')[i].innerHTML = TXT['page']['slide'][i]['sub']
	}

	for (var i=0; i<TXT['page']['post'].length; i++) {
		post_title_set(TXT['page']['post'][i]['title'])

		var list = document.createElement('table')
		list.setAttribute('id', 'content')
		var tr = document.createElement('tr')
		list.appendChild(tr)
		var div_post = document.querySelector('#post_2')
		for (var j=0; j<TXT['page']['post'][i]['content'].length; j++) {
			var content = content_create(TXT['page']['post'][i]['content'][j])
			var div = document.createElement('div')
			var style = "width: 100%;"
			div.setAttribute('style', style)
			div.appendChild(content)
			
			var td = document.createElement('td')
			var style = ([
				'vertical-align: top;',
				'width:50%;',
				'padding:10px;',
			]).join(' ')
			td.setAttribute('style', style)
			td.setAttribute('class', 'full')
			td.appendChild(div)
			
			tr.appendChild(td)

			if(j%2==1) {
				div_post.appendChild(list)
				var list = document.createElement('table')
				list.setAttribute('id', 'content')
				var tr = document.createElement('tr')
				list.appendChild(tr)
			}
			else if (j==TXT['page']['post'][i]['content'].length-1){
			// else if (j==(keys_2.length-1)/4) {
				var td = document.createElement('td')
				var style = ([
					'vertical-align: top;',
					'width:50%;',
					'padding:10px;',
				]).join(' ')
				td.setAttribute('style', style)
				td.setAttribute('class', 'full')
				tr.appendChild(td)
				div_post.appendChild(list)				
			}
		}		
	}
	showSlides();

	is_ready = true;

	function createButton(text, click_url) {
		var btn = document.createElement('button')
		btn.setAttribute('class', 'brown-btn')
		btn.onclick = function () {
			if ((click_url.search("register") != -1) && login)
				showSnackBar('You have already created an account!')
			else 
				window.open(click_url,"_self");
		}
		// btn.onclick = function () {window.open(click_url, '_blank');}
		btn.innerHTML = text
		return btn
	}

	function post_title_set(title) {
		var tbl = document.createElement('table')
		var div_post = document.querySelector('#post_2')
		div_post.appendChild(tbl)

		var td_1 = document.createElement('td')
		td_1.setAttribute('style', 'color: black; font-size: 24px; font-family: Crimson; vertical-align: bottom; height: 50px; text-align: center; padding: 10px 0px 0px 0px;')
		td_1.innerHTML = '<b>' + title + '</b>'

		var img = document.createElement('img')
		img.setAttribute('class', 'line')
		img.setAttribute('src', BASE_URL + 'assets/'+APP_CODENAME+'/img/line.svg')
		var style = ''
		style += "width: 100px;"
		img.setAttribute('style', style)
		
		var td_2 = document.createElement('td')
		var style = "text-align: center;" 
		style += "padding: 0px 10px 10px 10px;"
		td_2.setAttribute('style', style)
		td_2.appendChild(img)

		var tr_1 = document.createElement('tr')
		tr_1.appendChild(td_1)
		tbl.appendChild(tr_1)

		var tr_2 = document.createElement('tr')
		tr_2.appendChild(td_2)
		tbl.appendChild(tr_2)
	}
	
	function setDots() {
		var span = document.createElement('span')
		span.setAttribute('class', 'dot')
		var div_slide = document.querySelector('.home-dots')
		div_slide.appendChild(span)
	}

	function content_create(obj) {

		var img = document.createElement('img')
		img.setAttribute('src', BASE_URL + 'assets/'+APP_CODENAME+'/img/' + obj["img"])
		var style = ([
			'display: block;',
    	'width: 97.5%;',
	    'border-radius: 5px;',
	    'border: 5px solid darkgoldenrod;',
		]).join(' ')
    img.setAttribute('style', style)
		var div = document.createElement('div')
		var style = ([
			'text-align: center;',
			'width: 100%;',
		]).join(' ')
		div.setAttribute('style', style)
		div.appendChild(img)
		var td_1 = document.createElement('td')
		td_1.appendChild(div)
		var tr_1 = document.createElement('tr')
		tr_1.appendChild(td_1)

		var div_1 = document.createElement('div')
		div_1.innerHTML = "<b>" + obj["title"] + "</b>"
		var style = ""
		style += "font-size: 24px;"
		// style += 'margin-bottom: 15px;'
    style += "text-align: left;"
  	style += "font-family: Crimson;"
  	style += "color: black;"
  	div_1.setAttribute('style', style)

		var div_date = document.createElement('div')
		div_date.innerHTML = obj["date"]
		var style = ""
		style += 'font-size: 16px;'
		style += 'font-weight: 600;'
		style += 'color: green;'
    style += "text-align: left;"
  	style += "font-family: Crimson;"
  	div_date.setAttribute('style', style)

		var div_2 = document.createElement('div')
		var style = ''
		style += 'font-size: 16px;'
		style += 'color: #5f6368;'
    style += "text-align: left;"
    style += "line-height: " + parseInt(FF_SIZE+10)  + "px;"
		style += 'font-family: Roboto;'
		div_2.setAttribute('style', style)
		div_2.innerHTML = obj["sub"]

		var tr_btn = document.createElement('tr')
		var td_btn = document.createElement('td')
		var style = 'text-align: left;'
		style += 'width: 1%;'
		td_btn.setAttribute('style', style)
		var a = document.createElement('a')
		if (APP_TYPE == 'amp')
			a.addEventListener('click', function() { ampxweb_switch_page(obj['link']['url']) })
		else
			a.href = HOME_URL + obj['link']['url']
		a.innerHTML = obj['link']['title']
		a = anchor_set(a)
		// td_btn.appendChild(a)
		// tr_btn.appendChild(td_btn)
		// var btn = createButton(obj["btn_" + j], obj["link_" + j])
		// td_btn.appendChild(btn)
		// tr_btn.appendChild(td_btn)

		var td_2 = document.createElement('td')
		var style = "padding: 10px 10px 10px 10px;"
		style += 'text-align: left;'
		td_2.setAttribute('style', style)
		td_2.appendChild(div_1)
		td_2.appendChild(div_date)
		td_2.appendChild(div_2)
		td_2.appendChild(a)

		var tr_2 = document.createElement('tr')
		tr_2.appendChild(td_2)			

		var tbl = document.createElement('table')
		tbl.appendChild(tr_1)
		tbl.appendChild(tr_2)
		// tbl.appendChild(tr_btn)
		return tbl
	}
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
	L.header.srcbar.set()
	// L.header.blank_col.set()
	L.header.account.set()
	L.header.hide_when_scroll_on()
	var header_img = BASE_URL + "assets/tradelite/img/tradelite.svg"
	L.header.logo.img(header_img)
}
