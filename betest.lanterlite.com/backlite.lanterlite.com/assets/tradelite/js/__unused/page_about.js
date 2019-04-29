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
URL['page'] = 'page_about/' + LANG
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

init()

function init() {
	var slide = document.createElement('div')
	slide.setAttribute('class', 'slideshow-container')

	var dots = document.createElement('div')
	dots.setAttribute('class', 'about-dots')

	var td1 = document.createElement('td')
	td1.setAttribute('class', 'col-1 about-slide-image')
	td1.setAttribute('id', 'slide_image')
	td1.appendChild(slide)
	td1.appendChild(dots)

	var tr1 = document.createElement('tr')
	tr1.appendChild(td1)

	var italic = document.createElement('i')
	var subtitle = document.createElement('div')
	subtitle.setAttribute('id', 'about_subtitle_desc')
	subtitle.setAttribute('class', 'col-text')
	italic.appendChild(subtitle)

	var title = document.createElement('div')
	title.setAttribute('id', 'about_title_desc')
	title.setAttribute('class', 'col-text')

	var td2 = document.createElement('td')
	td2.setAttribute('class', 'col-2')
	td2.appendChild(italic)
	td2.appendChild(title)

	var tr2 = document.createElement('tr')
	tr2.appendChild(td2)

	var table = document.createElement('table')
	table.appendChild(tr1)
	table.appendChild(tr2)

	var home = document.createElement('div')
	home.setAttribute('class', 'home-post')
	home.appendChild(table)

	var post2 = document.createElement('div')
	post2.setAttribute('id', 'post_2')

	var about = document.createElement('div')
	about.setAttribute('class', 'about-page')
	about.appendChild(home)
	about.appendChild(post2)

	var body = document.querySelector('#canvas #body')
	body.appendChild(about)
}

// (function wait() {
//   if (sessionStorage.getItem(MD5("lang")) != null) {
// 		page_set()
// 	} else {
//     setTimeout( wait, 500 );
//   }
// }) ();

function setSlide() {
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

	var td_1 = document.createElement('td')
	td_1.setAttribute('class', 'col_1')
	td_1.appendChild(div_title)

	var td_2 = document.createElement('td')
	td_2.setAttribute('class', 'col_2')
	td_2.appendChild(div_subtitle)

	var tr_1 = document.createElement('tr')
	tr_1.appendChild(td_1)

	var tr_2 = document.createElement('tr')
	tr_2.appendChild(td_2)

	var table = document.createElement('table')
	table.setAttribute('class', 'about_slide_table')
	table.appendChild(tr_1)
	table.appendChild(tr_2)

	var div_2 = document.createElement('div')
	div_2.setAttribute('class', 'numbertext')

	var div_1 = document.createElement('div')
	div_1.setAttribute('class', 'mySlides fade')
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
    document.getElementById('slide_image').style.background = "black url(" + FE_BASE_URL + 'assets/corelite/img/' + TXT['page']['slide']['content'][slideIndex-1]['img'] + ") no-repeat 50%"
    setTimeout(showSlides, 5000); // Change image every 2 seconds
  }
  catch(err) {}
}

function page_set() {
	L.head.meta.add_desc(TXT['page']['tag']['meta']['description'])
	L.head.title_set(TXT['page']['tag']['title'])

	for(var i=0; i<TXT['page']['slide']['content'].length; i++) {
		setSlide()
		setDots()
		document.getElementsByClassName('title_text')[i].innerHTML = TXT['page']['slide']['content'][i]['title']
		document.getElementsByClassName('subtitle_text')[i].innerHTML = TXT['page']['slide']['content'][i]['sub']
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
	is_ready = true

	function post_title_set(title) {
		var tbl = document.createElement('table')
		var div_post = document.querySelector('#post_2')
		div_post.appendChild(tbl)

		var td_1 = document.createElement('td')
		td_1.setAttribute('style', 'color: black; font-size: 24px; font-family: Crimson; vertical-align: bottom; height: 50px; text-align: center; padding: 10px 0px 0px 0px;')
		td_1.innerHTML = '<b>' + title + '</b>'

		var img = document.createElement('img')
		img.setAttribute('class', 'line')
		img.setAttribute('src', BASE_URL + 'assets/corelite/img/line.svg')
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
		var div_slide = document.querySelector('.about-dots')
		div_slide.appendChild(span)
	}

	function content_create(obj) {

		var img = document.createElement('img')
		img.setAttribute('src', BASE_URL + 'assets/corelite/img/' + obj["img"])
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
		style += 'color: green;'
    style += "text-align: left;"
  	style += "font-family: Roboto;"
  	div_date.setAttribute('style', style)

		var div_2 = document.createElement('div')
		var style = ''
		style += 'font-size: 16px;'
		style += 'color: grey;'
    style += "text-align: left;"
    style += "line-height: " + parseInt(FF_SIZE+10)  + "px;"
		style += 'font-family: Roboto;'
		div_2.setAttribute('style', style)
		div_2.innerHTML = obj["sub"]

		var td_2 = document.createElement('td')
		var style = "padding: 10px 10px 10px 10px;"
		style += 'text-align: left;'
		td_2.setAttribute('style', style)
		td_2.appendChild(div_1)
		// td_2.appendChild(div_date)
		td_2.appendChild(div_2)

		if (obj['link'] != '') {
			var tr_btn = document.createElement('tr')
			var td_btn = document.createElement('td')
			var style = 'text-align: left;'
			style += 'width: 1%;'
			td_btn.setAttribute('style', style)
			var a = document.createElement('a')
			a.href = obj['link']['url']
			a.innerHTML = obj['link']['title']
			a = anchor_set(a)
			td_2.appendChild(a)
		}

		var tr_2 = document.createElement('tr')
		tr_2.appendChild(td_2)			

		var tbl = document.createElement('table')
		tbl.appendChild(tr_1)
		tbl.appendChild(tr_2)
		// tbl.appendChild(tr_btn)
		return tbl
	}

	var pt = document.getElementById('about_title_desc')
	var style = ([
		'padding:10px;',
		'font-size: 25px;',
	]).join(' ')
	pt.setAttribute('style', style)	
	pt.innerHTML = TXT['page']['slide']['title']
	
	var pst = document.getElementById('about_subtitle_desc')
	var style = ([
		'padding:10px;',
		'font-size: 33px;',
	]).join(' ')
	pst.setAttribute('style', style)	
	pst.innerHTML = TXT['page']['slide']['sub']
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