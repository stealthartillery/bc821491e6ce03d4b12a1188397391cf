// /* ================================================================ */
var app = L.app.get(APP_ID)
if (app[RES_STAT] == NOT_EXIST) {
  app["FSIZE_RSLIDER_AR"] = 11,
  app["FSIZE_RSLIDER_LAT"] = 11,
  app["FSIZE_DESC"] = 15,
  app["FSIZE_AR_DESC"] = 27,
  app["FSIZE_TITLE"] = 20,
  app["FSIZE_SUBTITLE"] = 15,
  app["THEME"] = 'day'
  app["LANG"] = 'id'
	L.app.set(APP_ID, app)
}

var LANG = app['LANG']

var URL = {}
URL['header'] = 'component/header/' + LANG
URL['page'] = LANG
URL['sidebar'] = 'component/sidebar/' + LANG
var KEYS = Object.keys(URL);

var TXT = []
TXT.push('header')
TXT.push('page')
TXT.push('sidebar')

var _page_set = function(){page_set()}
var _header_set = function(){header_set()}
var _sidebar_set = function(){sidebar_set()}

var SET = []
SET.push(_header_set)
SET.push(_page_set)
SET.push(_sidebar_set)

var count = 0
text_get(count)

function text_get(count) {
 	json_read_local(BASE_URL + 'assets/enlite/lang/'+URL[KEYS[count]], function(obj) {
		TXT[KEYS[count]] = obj
		SET[count]()
		count += 1
		if (count < KEYS.length) {
			text_get(count)
		}
	})
}

var RSLIDER_AR = 'rslider_ar'
var FSIZE_RSLIDER_AR = app["FSIZE_RSLIDER_AR"]

var RSLIDER_LAT = 'rslider_lat'
var FSIZE_RSLIDER_LAT = app["FSIZE_RSLIDER_LAT"]

var FSIZE_DESC = app["FSIZE_DESC"]
var FSIZE_AR_DESC = app["FSIZE_AR_DESC"]
var FSIZE_TITLE = app["FSIZE_TITLE"]
var FSIZE_SUBTITLE = app["FSIZE_SUBTITLE"]

var THEME = app["THEME"]


var is_search = false;
var page = 0;
var pageInt = parseInt(page)
var search_value = '';
var content_value = '';
var content_tot = '';
var time = '';

var TITLE_LIST = []
var TITLE_LIST_TOT = 9

L.theme.set(THEME)
L.canvas.set()
L.winmenubar.set(APP_NAME)
L.header.set()
L.loading.set()

L.snackbar.set()
L.head.icon_set()
L.head.meta.add_viewport()

L.fcanvas.set()
// L.fcanvas.close_logo()
// L.fcanvas.close_click(close_click)

L.mtbutton.set()
L.mtbutton.on()

var icons = {}
$.when( get_svg(name='coins', id='white', is_str=true) ).done(function(svg){ icons['coins'] = svg; });

L.body.set()

L.page.set('page_home')
L.page.set('page_search')
L.page.set('page_content')

var PAGE_HOME_ORDER = 0; var PAGE_SEARCH_ORDER = 1; var PAGE_CONTENT_ORDER = 2; 
var page_order = ['page_home', 'page_search', 'page_content']
var page_func_order = [
	function(){
		title_set()
		L.header.hide()
		cur_page = 'page_home'
		var inp_home_sbar = document.querySelector('div.home-search input.srcbar')
		inp_home_sbar.value = search_value
    // setTimeout( function(){title_set()}, 1000 );
	}, 
	function(){
		title_set()
		L.header.show()
		search_result_get()
    // setTimeout( function(){title_set()}, 1000 );
	}, 
	function(){
		title_set()
		content_get()
    // setTimeout( function(){title_set()}, 1000 );
	}
]
var cur_page = 'page_home'

function page_set() {
	init()
}

function title_set() {
	for (var i=0; i<TITLE_LIST.length; i++) {
		if (is_exist(TITLE_LIST[i]['query']))
			eval(TITLE_LIST[i]['eval'])
	}
}

function init() {
	(function wait() {
    if ( TITLE_LIST.length == TITLE_LIST_TOT ) {
			L.head.meta.add_desc(TXT["page"]["tag"]["meta"]["description"])
			L.head.title_set(TXT["page"]["tag"]["title"])

			var page_home = home_srcbar_create()
			var page_search = document.createElement('div')
			page_search.setAttribute('class', 'one lt-content lt-section')
			var page_content = document.createElement('div')
			page_content.setAttribute('class', 'two lt-content lt-section')

			L.page.add('page_home', page_home)
			L.page.add('page_search', page_search)
			L.page.add('page_content', page_content)

			// $('#bg_loader').fadeOut()

			L.page.open('page_home', page_func_order[PAGE_HOME_ORDER]())

			if (is_search) {
				L.page.open('page_search', page_func_order[PAGE_SEARCH_ORDER]())
				// L.page.open('page_search', function() {search_result_get()})
			}
    } else {
    	// getLang();
      setTimeout( wait, 500 );
    }
	}) ();
}

function content_get() {
	L.loading.open()
	if (is_exist('#body #page.page_search .result'))
		clear_content('#body #page.page_search .result')

	toTop()
	// $("#body #page.page_search").fadeOut()
	// $("#body #page.page_content").fadeIn()
	cur_page = 'page_content'

	if (is_exist('#body #page.page_content .content')) {
		clear_content('#body #page.page_content .content')
	}
	var canvas = document.querySelector('#body #page.page_content')
	var content = document.createElement('div')
	content.setAttribute('class', 'content')
	canvas.appendChild(content)
	$.ajax({
    type: "GET",
    url: BE_URL + "/enlite/?content=" + content_value,
    timeout: 10000,
    success: function(obj) { _callback(obj); },
    error: function(e) { try_again_later_set(); }
	});

	// $.get( BE_URL + "/enlite/?content=" + content_value, function( data ) {
	var _callback = function(data) {
		L.loading.close()
	  var obj = JSON.parse(data);
	  for (var i=0; i<obj['data'].length; i++) {

			var div_content = document.createElement('div')
			style = ''
			style += 'width: 90%;'
			style += "margin: 10px auto 10px auto;"
			div_content.setAttribute('style', style)
			var table = document.createElement('table')
			style = "padding: 5px 5px 5px 5px;"
			// style += 'background-color: white;'
			table.setAttribute('style', style)
			table.setAttribute('id', 'result')
			var td_title = document.createElement('td')

			if (obj['data'][i]['title'] != null) {
				span_title = document.createElement('span')
				style = 'font-size:' + FSIZE_TITLE + 'px;'
				span_title.setAttribute('style', style)
				span_title.setAttribute('class', 'latin theme_clr_contrastblue ff_general')
				span_title.setAttribute('id', obj['data'][i]['id'])
				span_title.innerHTML = obj['data'][i]['title']
				td_title.appendChild(span_title)
				
				style = 'padding: 10px 0px;'
				td_title.setAttribute('style', style)
				var tr_title = document.createElement('tr')
				tr_title.appendChild(td_title)
				table.appendChild(tr_title)
			}

			if (obj['data'][i]['subtitle_1'] != null) {
				var tr_shortdesc = document.createElement('tr')
				var td_shortdesc = document.createElement('td')
				style = ''
				style += 'padding: 10px 0px 10px 0px;'
				td_shortdesc.setAttribute('style', style)

				var span = document.createElement('span')
				style = 'font-size:' + FSIZE_SUBTITLE + 'px;'
				style += 'color: black;'
				style += 'background-color: gold;'
				style += 'border-radius: 7px;'
				style += 'margin: 0px 10px 0px 0px;'
				style += 'padding: 5px 10px 5px 10px;'
				span.setAttribute('style', style)
				span.setAttribute('class', 'latin ff_general')
				span.innerHTML = obj['data'][i]['subtitle_1']
				td_shortdesc.appendChild(span)

				if (obj['data'][i]['subtitle_2'] != null) {
					var span = document.createElement('span')
					style = 'font-size:' + FSIZE_SUBTITLE + 'px;'
					style += 'color: black;'
					style += 'background-color: gold;'
					style += 'border-radius: 7px;'
					style += 'margin: 5px 5px 5px 0px;'
					style += 'padding: 5px 10px 5px 10px;'
					span.setAttribute('style', style)
					span.setAttribute('class', 'latin ff_general')
					span.innerHTML = obj['data'][i]['subtitle_2']
					td_shortdesc.appendChild(span)
				}

				tr_shortdesc.appendChild(td_shortdesc)
				table.appendChild(tr_shortdesc)
			}

			if (obj['data'][i]['arabic_content'] != null) {
				var td_desc = document.createElement('td')
				style = 'font-size:' + FSIZE_AR_DESC + 'px;'
				style += 'line-height: '+ (FSIZE_AR_DESC+20) + 'px;'			
				style += 'text-align: justify;'			
				style += 'direction: rtl;'
				style += 'padding: 10px 0px;'
				td_desc.setAttribute('style', style)
				td_desc.setAttribute('class', 'arabic theme_clr_text1')
				td_desc.innerHTML = obj['data'][i]['arabic_content']

				var tr_desc = document.createElement('tr')
				tr_desc.appendChild(td_desc)
				table.appendChild(tr_desc)
			}

			if (obj['data'][i]['precontent'] != null) {
				var tr = document.createElement('tr')
				var td = document.createElement('td')
				var span = document.createElement('span')
				style = 'font-size:' + FSIZE_DESC + 'px;'
				span.setAttribute('style', style)
				span.setAttribute('class', 'latin theme_clr_contrastgrey ff_general')
				span.innerHTML = obj['data'][i]['precontent']
				td.appendChild(span)
				tr.appendChild(td)
				table.appendChild(tr)			
			}
	
			if (obj['data'][i]['content'] != null) {
				var td_desc = document.createElement('td')
				style = 'font-size:' + FSIZE_DESC + 'px;'
				style += 'line-height: '+ (FSIZE_DESC+10) + 'px;'			
				style += 'text-align: justify;'			
				style += 'padding: 10px 0px;'
				td_desc.setAttribute('style', style)
				td_desc.setAttribute('class', 'latin theme_clr_text1 ff_general')
				td_desc.innerHTML = obj['data'][i]['content']				

				var tr_desc = document.createElement('tr')
				tr_desc.appendChild(td_desc)
				table.appendChild(tr_desc)
			}


			if (obj['data'][i]['postcontent_1'] != null) {
				var tr = document.createElement('tr')
				var td = document.createElement('td')
				style = 'padding: 10px 0px 0px 0px;'			
				td.setAttribute('style', style)
				var span = document.createElement('span')
				style = 'font-size:' + FSIZE_DESC + 'px;'
				style += 'color: green;'
				span.setAttribute('style', style)
				span.setAttribute('class', 'latin ff_general')
				span.innerHTML = obj['data'][i]['postcontent_1']
				td.appendChild(span)

				if (obj['data'][i]['postcontent_2'] != null) {
					var span = document.createElement('span')
					style = 'font-size:' + FSIZE_DESC + 'px;'
					style += 'background-color: gold;'
					style += 'border-radius: 7px;'
					style += 'margin: 0px 0px 0px 10px;'
					style += 'padding: 5px 10px 5px 10px;'
					span.setAttribute('style', style)
					span.setAttribute('class', 'latin theme_clr_text1 ff_general')
					span.innerHTML = obj['data'][i]['postcontent_2']
					td.appendChild(span)
				}

				tr.appendChild(td)
				table.appendChild(tr)
			}


			if (obj['data'][i]['addition'] != null) {
				var tr = document.createElement('tr')
				var td = document.createElement('td')
				style = 'font-size:' + FSIZE_DESC + 'px;'
				td.setAttribute('class', 'latin ff_general')
				td.setAttribute('style', style)
				var notes = '-'
				if (obj['data'][i]['addition'] != '')
					notes = obj['data'][i]['addition']
				td.innerHTML = notes
				// td.appendChild(span)
				tr.appendChild(td)
				table.appendChild(tr)
			  // $( "#body  .content" ).html( data );
			}

			div_content.appendChild(table)
			content.appendChild(div_content)
	  }
	}
	// })
}

function setPageFooter(page_tot) {
	var div_content = document.createElement('div')
	style = ''
	style += 'width: 90%;'
	style += 'text-align: center;'
	style += "margin: 10px auto 15px auto;"
	div_content.setAttribute('style', style)
	var result = document.querySelector('#body .result')
	result.appendChild(div_content)

	div_content.appendChild(page_span)

	pageInt = parseInt(page)
	var tot_fpages = 6;
	var half_tot_fpages = Math.floor(tot_fpages/2)
	//// page number move to right
	if (pageInt%tot_fpages >= half_tot_fpages) {
		if (page_tot > pageInt+half_tot_fpages) {
			page_tot2 = pageInt+half_tot_fpages
			page_from = pageInt-half_tot_fpages
		}
		else if (page_tot <= pageInt+half_tot_fpages){
			page_tot2 = page_tot
			if (page_tot-tot_fpages >= 0)
				page_from = page_tot-tot_fpages
			else
				page_from = 0
		}
	}
	else if (pageInt%tot_fpages < half_tot_fpages) {
		if (pageInt-half_tot_fpages >= 0 && page_tot > pageInt+half_tot_fpages) {
			page_tot2 = pageInt+half_tot_fpages
			page_from = pageInt-half_tot_fpages
		}
		else if (pageInt-half_tot_fpages < 0 && page_tot < tot_fpages) {
			page_tot2 = page_tot
			page_from = 0			
		}
		else if (pageInt-half_tot_fpages < 0 && page_tot >= tot_fpages) {
			page_tot2 = tot_fpages
			page_from = 0			
		}
	}

	for (var i=page_from; i<=page_tot2; i++) {
		if (i != page_tot2) {
			var span = document.createElement('span')
			span.innerHTML = i+1
			span.setAttribute('id', i)
			style = "padding: 5px 5px 5px 5px;"
			style += "margin: 0px 5px 0px 5px;"
			style += "font-size: " + FSIZE_TITLE + 'px;'
			if (pageInt == i) {
				style += "color: darkgoldenrod;"
				style += "background-color: #1a1a1a;"
				style += "border-radius: 7px;"
				span.setAttribute('class', 'page_num latin theme_clr_contrastblue ff_general')
			}
			else if (pageInt != i) {
				style += "cursor: pointer;"
				span.addEventListener('click', function(e) {
					page = e.target.id
					L.page.open('page_search', page_func_order[PAGE_SEARCH_ORDER]())
					// L.page.open('page_search', function() {search_result_get()})
				})
				span.setAttribute('class', 'page_num hover latin theme_clr_contrastblue ff_general')
			}
			span.setAttribute('style', style)		
			div_content.appendChild(span)			
		}
		else if (page != page_tot-1){
			var div_content_next = document.createElement('div')
			style = ''
			style += 'width: 90%;'
			style += 'text-align: center;'
			style += "margin: 0px auto 15px auto;"
			div_content_next.setAttribute('style', style)
			div_content_next.appendChild(span_next)
			var result = document.querySelector('#body  .result')
			result.appendChild(div_content_next)
		}
	}
}

function search_result_get() {
	L.loading.open()
	if (is_exist('#body #page.page_search .result'))
		clear_content('#body #page.page_search .result')

	// L.page.open('page_search')
	cur_page = 'page_search'
	toTop()
	document.querySelector('#header input.srcbar').value = search_value
	L.app.set(APP_ID, app)

	var content = document.createElement('div')
	content.setAttribute('class', 'result')

	var canvas = document.querySelector('#body #page.page_search')
	canvas.appendChild(content)
	$.ajax({
    type: "GET",
    url: BE_URL + "/enlite/?search=" + search_value + "&page=" + page,
    timeout: 10000,
    success: function(obj) { _callback(obj); },
    error: function(e) { try_again_later_set(); }
	});

	// $.get( BE_URL + "/enlite/?search=" + search_value + "&page=" + page, function( data ) {
		var _callback = function (data) {
		L.loading.close()
	  var obj = JSON.parse(data);
		if (!obj['is_mistake'])
			content.appendChild(search_result_header_create(obj))
		else 
			content.appendChild(search_result_header_create(obj))					
	  if (obj['status'] == 'NOT_FOUND') {
				var div_content = document.createElement('div')
				// div_content.setAttribute('class', 'content')
				style = ''
				style += 'width: 90%;'
				style += "margin: 10px auto 10px auto;"
				div_content.setAttribute('style', style)
				var table = document.createElement('table')
				style = "padding: 10px 5px 10px 5px;"
				// style += 'margin: 10px 0px 10px 0px;'
				table.setAttribute('style', style)
				div_content.appendChild(table)
				content.appendChild(div_content)

				var td_title = document.createElement('td')
				td_title.appendChild(span_there_is_no_search_result_for)
				var tr = document.createElement('tr')
				tr.appendChild(td_title)
				table.appendChild(tr)
	  }
	  else {
	 		for (var i=0; i<obj['data'].length; i++) {
				var div_content = document.createElement('div')
				// div_content.setAttribute('class', 'content')
				style = ''
				style += 'width: 90%;'
				style += "margin: 30px auto 30px auto;"
				div_content.setAttribute('style', style)

				var table = document.createElement('table')
				style = "padding: 10px 5px 10px 5px;"
				style += 'display: none;'
				table.setAttribute('id', 'src_res')
				// table.style.display = 'none'
				table.setAttribute('style', style)
				div_content.appendChild(table)
				content.appendChild(div_content)

				span_title = document.createElement('span')
				style = 'font-size:' + FSIZE_TITLE + 'px;'
				style += 'cursor: pointer;'
				span_title.setAttribute('style', style)
				span_title.setAttribute('id', obj['data'][i]['id'])
				span_title.setAttribute('class', 'hover latin theme_clr_contrastblue ff_general')
				span_title.addEventListener('click', function(e) {
					content_value = e.target.id
					L.page.open('page_content', page_func_order[PAGE_CONTENT_ORDER]())
					// L.page.open('page_content', function() {content_get()})
				})

				span_title.innerHTML = obj['data'][i]['title']

				var td_title = document.createElement('td')
				td_title.appendChild(span_title)
				var tr = document.createElement('tr')
				tr.appendChild(td_title)
				table.appendChild(tr)

				var td_shortdesc = document.createElement('td')
				style = 'font-size:' + FSIZE_SUBTITLE + 'px;'
				td_shortdesc.setAttribute('style', style)
				td_shortdesc.setAttribute('class', 'latin theme_clr_contrastgreen ff_general')
				td_shortdesc.innerHTML = obj['data'][i]['type']
				var tr = document.createElement('tr')
				tr.appendChild(td_shortdesc)
				table.appendChild(tr)

				var td_desc = document.createElement('td')
				style = 'font-size:' + FSIZE_DESC + 'px;'
				style += 'line-height: '+(FSIZE_DESC+5)+'px;'			
				td_desc.setAttribute('style', style)
				td_desc.setAttribute('class', 'latin theme_clr_contrastgrey ff_general')
				td_desc.setAttribute('id', "body")
				td_desc.innerHTML = obj['data'][i]['desc']

				var tr = document.createElement('tr')
				tr.appendChild(td_desc)
				table.appendChild(tr)

			  if (i == obj['data'].length-1) {
			  	var _tbl = document.querySelectorAll('#src_res')
		  		j=0
		  		fadetbl()
		  		function fadetbl () {
		  			$(_tbl[j]).fadeIn()

		  			if (j<_tbl.length) {
		  				j++
				  		setTimeout( fadetbl, 100 )
		  			}
					  else
					  	setPageFooter(obj['page_tot'])
			  	}
			  }
		  }
	  }
	}
	// });	
}

if(window.history && history.pushState){ // check for history api support
	window.addEventListener('load', function(){
		// create history states
		history.pushState(-1, null); // back state
		history.pushState(0, null); // main state
		history.pushState(1, null); // forward state
		history.go(-1); // start in main state
				
		this.addEventListener('popstate', function(event, state){
			// check history state and fire custom events
			if(state = event.state){
				if (state == -1) {
					if (L.sidebar.is_opened()) {
						L.sidebar.close()
					}
					else if (L.header.account.is_opened()) {
						L.header.account.close()
					}
					else if (L.fcanvas.is_opened()) {
						L.fcanvas.close()
					}
					else {
						var index = page_order.indexOf(cur_page)
						index--
						if (index >= 0) {
							L.page.open(page_order[index], page_func_order[index])	
						} 
						else {
						  window.history.back();
						}
					}
				}
				else if (state == 1) {
					var index = page_order.indexOf(cur_page)
					index++
					if (index < page_order.length) {
						L.page.open(page_order[index], page_func_order[index])	
					}
				}

				event = document.createEvent('Event');
				event.initEvent(state > 0 ? 'next' : 'previous', true, true);
				this.dispatchEvent(event);
				
				// reset state
				history.go(-state);
			}
		}, false);
	}, false);
}

function search_result_header_create(obj) {

	var div_content = document.createElement('div')
	style = ''
	style += 'padding: 10px 0px;'
	style += 'width: 90%;'
	style += "margin: 10px auto 10px auto;"
	div_content.setAttribute('style', style)

	var span_content_tot = document.createElement('span')
	span_content_tot.setAttribute('class', 'latin')

	var span_time = document.createElement('span')
	span_time.setAttribute('class', 'latin')

	div_search_time = document.createElement('div')
	style = 'font-size: '+parseInt(parseInt(FSIZE_SUBTITLE)+3)+'px;'
	div_search_time.setAttribute('style', style)
	div_search_time.setAttribute('class', 'theme_clr_text3 ff_general')
	div_search_time.appendChild(span_content_tot)
	div_search_time.appendChild(span_contents)
	div_search_time.appendChild(span_time)
	div_search_time.appendChild(span_seconds)

	span_content_tot.innerHTML = obj['content_tot']
	span_time.innerHTML = obj['time']

	var span_search_value = document.createElement('span')
	span_search_value.innerHTML = ": " + search_value

	div_search_result_for = document.createElement('div')
	style = 'font-size: '+parseInt(parseInt(FSIZE_SUBTITLE)+3)+'px;'
	style += 'padding: 10px 0px;'
	div_search_result_for.setAttribute('style', style)
	div_search_result_for.setAttribute('class', 'theme_clr_contrastgoldenrod ff_general')
	div_search_result_for.appendChild(span_search_result_for)
	div_search_result_for.appendChild(span_search_value)

	div_content.appendChild(div_search_time)
	div_content.appendChild(div_search_result_for)
	
	correction = document.createElement('span')
	style = 'font-size: '+parseInt(parseInt(FSIZE_SUBTITLE)+3)+'px;'
	style += 'padding: 10px 0px;'
	correction.setAttribute('style', style)
	correction.setAttribute('class', 'latin theme_clr_contrastblue ff_general')
	correction.innerHTML = obj['correction']
	correction.addEventListener('click', function() {
		search_value = clean_str(obj['correction'])
		L.page.open('page_search', page_func_order[PAGE_SEARCH_ORDER]())
		// L.page.open('page_search', function() {search_result_get()})
	})

	if (obj['is_mistake']) {
		div_content.appendChild(header_did_you_mean)
		div_content.appendChild(correction)
	}
	return div_content
}

//// Save app data to sessionStorage.
// function L.app.set(APP_ID, app) {
//   var data = JSON.stringify({
//     "is_search" : is_search,
//     "search_value" : search_value,
//     "lang" : lang
//   })
//   sessionStorage.setItem('enlite', data)
// }

// function checksessionStorage() {
// 	if (
// 		sessionStorage.getItem('enlite')['is_search'] != null &&
// 		sessionStorage.getItem('enlite')['search_value'] != null &&
// 		sessionStorage.getItem('enlite')['lang'] != null
// 	) {
// 		return true
// 	}
// 	else
// 		return false
// }

function getJson(url, callback) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         callback(JSON.parse(xhttp.responseText));
      }
  };
  xhttp.open("GET", url, true);
  xhttp.send();
}

function functSubmitHome() {
	var inp_home_sbar = document.querySelector('div.home-search input.srcbar')
	if (inp_home_sbar.value != '') {
		is_search = true;
		page = 0;
		search_value = inp_home_sbar.value
		L.app.set(APP_ID, app)
		L.page.open('page_search', page_func_order[PAGE_SEARCH_ORDER]())
		// L.page.open('page_search', function() {search_result_get()})
	}

  return false;
}

function functSubmitHeader() {
	var inp_header_sbar = document.querySelector('#header input.srcbar')
	if (inp_header_sbar.value != '') {
		is_search = true;
		page = 0;
		search_value = inp_header_sbar.value
		L.app.set(APP_ID, app)
		L.page.open('page_search', page_func_order[PAGE_SEARCH_ORDER]())
		// L.page.open('page_search', function() {search_result_get()})
	}
  return false;
}

function home_srcbar_create() {
	var title = document.createElement('div')
	title.setAttribute('class', 'title')
	$(title).css({
		'background': 'url(' + BASE_URL + 'assets/enlite/img/enlite.svg) no-repeat 5px 5px',
	  'background-size': '150px 50px',
	  'background-position': 'center'
	})

	var srcbar = srcbar_create()
	srcbar.setAttribute("onsubmit", "return functSubmitHome()")

	var div_hs = document.createElement('div')
	div_hs.setAttribute('class', 'home-search')
	style = "position: fixed;"
  style += "z-index: 10;"
  style += "top: 0;"
  style += "left: 0;"
  style += "height: 100%;"
  style += "width: 100%;"
  style += "background-color: #1a1a1a;"
  style += "display: flex;"
  style += "flex-flow: column nowrap;"
  style += "justify-content: center;"
  style += "align-items: center;"
  style += "box-sizing: border-box;"
	div_hs.setAttribute('style', style)

	div_hs.appendChild(title)
	div_hs.appendChild(srcbar)

	return div_hs

	function srcbar_create(on_submit) {
		var src_icon = document.createElement('img')
		src_icon.src = BASE_URL + 'assets/lite.img/src.svg'
		src_icon.setAttribute('class', 'icon')
		src_icon.setAttribute('id', 'icon')
		$(src_icon).css({
			"height": "30px"
		})
		src_icon.addEventListener('click', function() {
			functSubmitHome()
			// var value = document.querySelector('.home-search input.srcbar').value
			// on_submit(value)
		})

		var td_sb_inp = document.createElement('td')
		$(td_sb_inp).css({'width': '100%'})

		var td_sb_btn = document.createElement('td')
		style = "display: inline-flex;"
		style += "padding: 5px;"
		td_sb_btn.setAttribute('style', style)

		var tr_sb = document.createElement('tr')
		style = "width: 100%;"
		tr_sb.setAttribute('style', style)
		tr_sb.appendChild(td_sb_inp)
		tr_sb.appendChild(td_sb_btn)

		td_sb_inp.appendChild(header_search_here)
		td_sb_btn.appendChild(src_icon)

		var tbl_sb = document.createElement('table')
		$(tbl_sb).css({
			"background-color": "white",
			"border-radius": "7px",
	    'min-width': '100px',
	    'width': '100%',
	    'max-width': '500px',
		})
		tbl_sb.appendChild(tr_sb)

		var form_sb = document.createElement('form')
		style = "position: relative;"
		style += "text-align: left;"
		style += "margin: 10px;"
		form_sb.setAttribute("style", style)
		form_sb.setAttribute("onsubmit", "return functSubmitHeader()")
		form_sb.appendChild(tbl_sb)

		return form_sb
	}
}

function showSplashScreen() {
	// var svg = document.createElement("svg")
	// svg.setAttribute("class", "loader")
	// svg.setAttribute("xmlns", "http://www.w3.org/2000/svg")
	// svg.setAttribute("viewBox", "0 0 46 33")
	// style = "background-image: url('./assets/img/logo_cream.svg');"
	// style += "background-position: center center;"
	// style += "background-size: 100%;"
	// style += "background-repeat: no-repeat;"
	// svg.setAttribute("style", style)
	// var g = document.createElement('g')
	// g.setAttribute("stroke-width", "1")
	// g.setAttribute("fill", "none")
	// g.setAttribute("fill-rule", "evenodd")
	// svg.appendChild(g)
	// var div_loader = document.getElementById("loader")
	// loader.appendChild(svg)

  // Show splash screen for 2 seconds while waiting the app prepare the content.
  setTimeout(function(){
    document.getElementById('bg_loader').style.display = 'none';
  }, 2000);
}

function func_opt() {
	L.sidebar.close()

	var rslider1 = L.rslider.create(RSLIDER_AR)
	L.fcanvas.title(TXT["page"]["word"]["option"])
	L.fcanvas.add(rslider1)
	L.rslider.title(RSLIDER_AR, TXT["page"]["word"]["arabic_size"])
	L.rslider.val(RSLIDER_AR, FSIZE_RSLIDER_AR)
	L.rslider.min(RSLIDER_AR, 11)
	L.rslider.max(RSLIDER_AR, 15)
	L.rslider.move(RSLIDER_AR, function(val) {
		val = val*3
		FSIZE_AR_DESC = parseInt(FSIZE_AR_DESC) + parseInt(val-FSIZE_RSLIDER_AR*3);
  	FSIZE_RSLIDER_AR = val/3
  	if (is_exist('.content #result')) {
	  	var elm = document.querySelectorAll('.content #result')
			elm[0].childNodes[2].childNodes[0].style.fontSize = FSIZE_AR_DESC + 'px'	
			elm[0].childNodes[2].childNodes[0].style.lineHeight = parseInt(FSIZE_AR_DESC+20) + 'px'
  	}
	})

	var rslider2 = L.rslider.create(RSLIDER_LAT)
	L.fcanvas.add(rslider2)
	L.rslider.title(RSLIDER_LAT, TXT["page"]["word"]["latin_size"])
	L.rslider.val(RSLIDER_LAT, FSIZE_RSLIDER_LAT)
	L.rslider.min(RSLIDER_LAT, 11)
	L.rslider.max(RSLIDER_LAT, 15)
	L.rslider.move(RSLIDER_LAT, function(val) {
		val = val*3
		FSIZE_TITLE = parseInt(FSIZE_TITLE) + parseInt(val-FSIZE_RSLIDER_LAT*3);
		FSIZE_SUBTITLE = parseInt(FSIZE_SUBTITLE) + parseInt(val-FSIZE_RSLIDER_LAT*3);
		FSIZE_DESC = parseInt(FSIZE_DESC) + parseInt(val-FSIZE_RSLIDER_LAT*3);
  	FSIZE_RSLIDER_LAT = val/3

  	if (is_exist('#body .result')) {
	  	var sr = document.querySelector('#body .result')
	  	sr.childNodes[0].childNodes[0].style.fontSize = FSIZE_SUBTITLE + 'px'
	  	sr.childNodes[0].childNodes[1].style.fontSize = FSIZE_SUBTITLE + 'px'
	  	if (sr.childNodes[0].childNodes[2] != null)
		  	sr.childNodes[0].childNodes[2].style.fontSize = FSIZE_SUBTITLE + 'px'
		  span_there_is_no_search_result_for.style.fontSize = FSIZE_TITLE + 'px'
	  }

  	if (is_exist('#src_res')) {
	  	var elm = document.querySelectorAll('#src_res')
	  	for (var i=0; i<elm.length; i++) {
  			elm[i].childNodes[0].childNodes[0].childNodes[0].style.fontSize = FSIZE_TITLE + 'px'
  			elm[i].childNodes[1].childNodes[0].style.fontSize = FSIZE_SUBTITLE + 'px'
  			elm[i].childNodes[2].childNodes[0].style.fontSize = FSIZE_DESC + 'px'
  			elm[i].childNodes[0].childNodes[0].childNodes[0].style.lineHeight = parseInt(FSIZE_TITLE+5) + 'px'
  			elm[i].childNodes[1].childNodes[0].style.lineHeight = parseInt(FSIZE_SUBTITLE+5) + 'px'
  			elm[i].childNodes[2].childNodes[0].style.lineHeight = parseInt(FSIZE_DESC+5) + 'px'
	  	}

	  	page_span.style.fontSize = FSIZE_TITLE + 'px'
	  	span_next.style.fontSize = FSIZE_TITLE + 'px'

	  	var page_num = document.querySelectorAll('.page_num')
	  	for (var j=0; j<page_num.length; j++) {
	  		page_num[j].style.fontSize = FSIZE_TITLE + 'px'
	  	}
  	}
  	
  	else if (is_exist('.content #result')) {
	  	var elm = document.querySelectorAll('.content #result')
			elm[0].childNodes[0].childNodes[0].childNodes[0].style.fontSize = FSIZE_TITLE + 'px'
			elm[0].childNodes[1].childNodes[0].childNodes[0].style.fontSize = FSIZE_SUBTITLE + 'px'
			elm[0].childNodes[1].childNodes[0].childNodes[1].style.fontSize = FSIZE_SUBTITLE + 'px'
			elm[0].childNodes[1].childNodes[0].childNodes[0].style.fontSize = FSIZE_SUBTITLE + 'px'
			elm[0].childNodes[3].childNodes[0].style.fontSize = FSIZE_DESC + 'px'
			elm[0].childNodes[4].childNodes[0].childNodes[0].style.fontSize = FSIZE_DESC + 'px'
			
			elm[0].childNodes[0].childNodes[0].childNodes[0].style.lineHeight = parseInt(FSIZE_TITLE+10) + 'px'
			elm[0].childNodes[1].childNodes[0].childNodes[0].style.lineHeight = parseInt(FSIZE_SUBTITLE+10) + 'px'
			elm[0].childNodes[1].childNodes[0].childNodes[0].style.lineHeight = parseInt(FSIZE_SUBTITLE+10) + 'px'
			elm[0].childNodes[3].childNodes[0].style.lineHeight = parseInt(FSIZE_DESC+10) + 'px'
			elm[0].childNodes[4].childNodes[0].childNodes[0].style.lineHeight = parseInt(FSIZE_DESC+10) + 'px'

	  	var sr = document.querySelector('#body .content')
	  	sr.childNodes[0].childNodes[0].style.fontSize = FSIZE_SUBTITLE + 'px'
  	}		
	})

	var obj = {}
	obj['id'] = 'rbtn_lang1'
	obj['group'] = 'lang_rgroup'
	obj['is_checked'] = app['LANG']=='id'? true:false
	obj['is_disabled'] = false
	obj['title'] = 'Bahasa'
	var rbutton1 = L.rbutton.create(obj)
	L.rbutton.change(rbutton1, function() {
		change_lang('id')
	})

	var obj = {}
	obj['id'] = 'rbtn_lang2'
	obj['group'] = 'lang_rgroup'
	obj['is_checked'] = app['LANG']=='en'? true:false
	obj['is_disabled'] = false
	obj['title'] = 'English'
	var rbutton2 = L.rbutton.create(obj)
	L.rbutton.change(rbutton2, function() {
		change_lang('en')
	})

	var td_title = document.createElement('td')
	style = 'font-family: Calibri;'
  style += 'width: 100px;'
	td_title.setAttribute('style', style)
	td_title.setAttribute('class', 'theme_clr_text1')
	td_title.appendChild(span_lang)

	var td_body = document.createElement('td')
	td_body.appendChild(rbutton1)
	td_body.appendChild(rbutton2)

	var tr = document.createElement('tr')
	tr.appendChild(td_title)
	tr.appendChild(td_body)

	var tbl_lang = document.createElement('table')
	tbl_lang.appendChild(tr)
	L.fcanvas.add(tbl_lang)

	L.fcanvas.open()

	function change_lang(lang) {

		app['LANG'] = lang
		L.app.set(APP_ID, app)
		LANG = app['LANG']

		URL['page'] = LANG
		URL['header'] = 'component/header/' + LANG
		URL['sidebar'] = 'component/sidebar/' + LANG

		var count = 0
		text_get(count)

		function text_get(count) {
		 	json_read_local(BASE_URL + 'assets/enlite/lang/'+URL[KEYS[count]], function(obj) {
				TXT[KEYS[count]] = obj
				count += 1
				if (count < KEYS.length) {
					text_get(count)
				}
				else {
					title_set()
					L.rslider.title(RSLIDER_LAT, TXT["page"]["word"]["latin_size"])
					L.rslider.title(RSLIDER_AR, TXT["page"]["word"]["arabic_size"])
					// document.querySelector('#rslider_ar #size').innerHTML = TXT["page"]["word"]["size"]
					// document.querySelector('#rslider_lat #size').innerHTML = TXT["page"]["word"]["size"]
					L.sidebar.change_titles(TXT['sidebar']['sidebar'])
					L.fcanvas.title(TXT["page"]["word"]["option"])
				}
			})
		}
	}
}

function func_theme() {
	L.sidebar.close()
	var rbtn = [
		{'id': 'radio-1', 'title':'Day', 'is_checked': true, 'is_disabled': false},
		{'id': 'radio-2', 'title':'Night', 'is_checked': false, 'is_disabled': false},
		{'id': 'radio-3', 'title':'Sunset', 'is_checked': false, 'is_disabled': true},
		{'id': 'radio-4', 'title':'Earth', 'is_checked': false, 'is_disabled': true},
		{'id': 'radio-5', 'title':'Sky', 'is_checked': false, 'is_disabled': true},
		{'id': 'radio-6', 'title':'Galaxy', 'is_checked': false, 'is_disabled': true},
		{'id': 'radio-7', 'title':'Forest', 'is_checked': false, 'is_disabled': true}
	]
	for (var i=0;i<rbtn.length; i++) {
		rbtn[i]['is_checked'] = app["THEME"] == rbtn[i]['title'].toLowerCase()? true : false
	}

	var arr = [
    {'title':'Day', 'create':L.rbutton.create(rbtn[0]), 'disabled':true, 'litegold':'0', 'litepoint':'0', 'url': BASE_URL + 'assets/lite.img/theme/day.webp', 'func' : 'L.theme.change("day")'},
    {'title':'Night', 'create':L.rbutton.create(rbtn[1]), 'disabled':false, 'litegold':'1', 'litepoint':'100', 'url': BASE_URL + 'assets/lite.img/theme/night.webp', 'func' : 'L.theme.change("night")'},
    {'title':'Sunset', 'create':L.rbutton.create(rbtn[2]), 'disabled':false, 'litegold':'1', 'litepoint':'100', 'url': BASE_URL + 'assets/lite.img/theme/sunset.webp', 'func' : 'L.theme.change("sunset")'},
    {'title':'Earth', 'create':L.rbutton.create(rbtn[3]), 'disabled':false, 'litegold':'1', 'litepoint':'100', 'url': BASE_URL + 'assets/lite.img/theme/earth.webp', 'func' : 'L.theme.change("earth")'},
    {'title':'Sky', 'create':L.rbutton.create(rbtn[4]), 'disabled':false, 'litegold':'1', 'litepoint':'100', 'url': BASE_URL + 'assets/lite.img/theme/sky.webp', 'func' : 'L.theme.change("sky")'},
    {'title':'Galaxy', 'create':L.rbutton.create(rbtn[5]), 'disabled':false, 'litegold':'1', 'litepoint':'100', 'url': BASE_URL + 'assets/lite.img/theme/galaxy.webp', 'func' : 'L.theme.change("galaxy")'},
    {'title':'Forest', 'create':L.rbutton.create(rbtn[6]), 'disabled':false, 'litegold':'1', 'litepoint':'100', 'url': BASE_URL + 'assets/lite.img/theme/forest.webp', 'func' : 'L.theme.change("forest")'}
	]

	var div = document.createElement('div')
	div.setAttribute('class', 'theme')
	var i = document.createElement('i')
	i.setAttribute('class', 'fas fa-band-aid"')
	div.appendChild(i)
	for (var i=0; i<arr.length; i++) {
		var td_title = document.createElement('td')
		var obj = arr[i]['create']
		td_title.appendChild(obj)
	
		var func = func_create(arr[i]['func'], arr[i]['title'])
		L.rbutton.change(obj, func)

		function func_create(link, title) {
			return function() { 
				eval(link)
				app["THEME"] = title.toLowerCase()
				L.app.set(APP_ID, app)
			}
		}

		var td_display = document.createElement('td')
		var img = document.createElement('img')
		img.src = arr[i]['url']
		td_display.setAttribute('class', 'display')
		td_display.appendChild(img)

		var tr_title = document.createElement('tr')
		tr_title.appendChild(td_title)

		var tr_display = document.createElement('tr')
		tr_display.appendChild(td_display)

		var tbl_theme = document.createElement('table')
		tbl_theme.appendChild(tr_title)
		tbl_theme.appendChild(tr_display)

		var td_main = document.createElement('td')
		td_main.appendChild(tbl_theme)

		var tr_main = document.createElement('tr')
		tr_main.appendChild(td_main)

		var tbl_main = document.createElement('table')
		tbl_main.appendChild(tr_main)

		div.appendChild(tbl_main)
	}	
	

	L.fcanvas.add(div)
	L.fcanvas.title(TXT["page"]["word"]["theme"])
	L.fcanvas.open(is_large=true)
}

function sidebar_set () {
	L.sidebar.set()
	var logo_click = function() {
		L.sidebar.close()
		L.page.open('page_home', page_func_order[PAGE_HOME_ORDER]())
	}
	L.sidebar.img_click(logo_click)

	var sidebar_img = BASE_URL + "assets/enlite/img/enlite.svg"
	L.sidebar.img(sidebar_img)
	function func_create(link) {
		return function() { eval(link) }
	}
	for (var i=0; i<TXT['sidebar']['sidebar'].length; i++) {
		var func = func_create(TXT['sidebar']['sidebar'][i]['link'])
		L.sidebar.add({'id': 'sb' + i, 'title': TXT['sidebar']['sidebar'][i]['title'], 'callback': func })
	}
}

function header_set() {
	L.header.menu.set()
	var menu_logo = BASE_URL + "assets/lite.img/sidebar.svg"
	L.header.menu.img(menu_logo)
	L.header.logo.set()
	var on_submit = function (value) {}
	L.header.srcbar.set(on_submit)
	L.header.blank_col.set()
	L.header.account.set()
	L.header.hide_when_scroll_on()
	var logo_click = function() {
		L.page.open('page_home', page_func_order[PAGE_HOME_ORDER]())
	}
	L.header.logo.click(logo_click)
	var header_img = BASE_URL + "assets/enlite/img/enlite.svg"
	L.header.logo.img(header_img)
}


var span_there_is_no_search_result_for = document.createElement('span')
style = 'font-size:' + FSIZE_TITLE + 'px;'
span_there_is_no_search_result_for.setAttribute('style', style)
span_there_is_no_search_result_for.setAttribute('class', 'latin theme_clr_contrastblue ff_general')
TITLE_LIST.push({'query': 'body', 'eval':'span_there_is_no_search_result_for.innerHTML = TXT["page"]["word"]["there_is_no_search_result_for"] + " \'" + search_value + "\'. " + TXT["page"]["word"]["please_make_sure"]'})

var page_span = document.createElement('span')
style = ""
style += "padding: 5px 5px 5px 5px;"
style += "font-size: " + FSIZE_TITLE + 'px;'
page_span.setAttribute('style', style)
page_span.setAttribute('class', "latin theme_clr_contrastgoldenrod ff_general")
TITLE_LIST.push({'query': 'body', 'eval':'page_span.innerHTML = TXT["page"]["word"]["page"] + ": "'})

var span_next = document.createElement('span')
span_next.setAttribute('id', "1")
span_next.setAttribute('class', 'hover latin')
style = ""
style += "padding: 5px 5px 5px 5px;"
style += "font-size: " + FSIZE_TITLE + 'px;'
style += "cursor: pointer;"
span_next.setAttribute('style', style)					
span_next.setAttribute('class', 'theme_clr_contrastblue ff_general')					
span_next.addEventListener('click', function(e) {
	page = pageInt + 1
	L.page.open('page_search', page_func_order[PAGE_SEARCH_ORDER]())
	// L.page.open('page_search', function() {search_result_get()})
})
TITLE_LIST.push({'query': 'body', 'eval':'span_next.innerHTML = TXT["page"]["word"]["next"]'})

var span_contents = document.createElement('span')
span_contents.setAttribute('class', 'latin')
TITLE_LIST.push({'query': 'body', 'eval':'span_contents.innerHTML = " " + TXT["page"]["word"]["contents"] + " ("'})

var span_seconds = document.createElement('span')
span_seconds.setAttribute('class', 'latin')
TITLE_LIST.push({'query': 'body', 'eval':'span_seconds.innerHTML = " " + TXT["page"]["word"]["seconds"] + ")"'})

var span_search_result_for = document.createElement('span')
span_search_result_for.setAttribute('class', 'latin')
TITLE_LIST.push({'query': 'body', 'eval':'span_search_result_for.innerHTML = TXT["page"]["word"]["search_result_for"]'})

var header_did_you_mean = document.createElement('span')
style = 'font-size: '+parseInt(parseInt(FSIZE_SUBTITLE)+3)+'px;'
style += 'padding: 10px 0px;'
header_did_you_mean.setAttribute('style', style)
header_did_you_mean.setAttribute('class', 'latin theme_clr_contrastred ff_general')
TITLE_LIST.push({'query': 'body', 'eval':'header_did_you_mean.innerHTML = TXT["page"]["word"]["did_you_mean"] + ": "'})

var header_search_here = document.createElement('input')
header_search_here.setAttribute('class', 'srcbar xoutline')
header_search_here.setAttribute('id', 'srcbar')
header_search_here.setAttribute('value', '')
style = ""
style += "font-size: 25px;"
style += "padding:4px 4px 4px 10px;"
style += "color: black;"
style += "border: none;"
style += "border-radius: 7px;"
style += "width: 100%;"
header_search_here.setAttribute("style", style)
TITLE_LIST.push({'query': 'body', 'eval':'header_search_here.setAttribute("placeholder", TXT["page"]["word"]["search_here"])'})

var span_lang = document.createElement('span')
TITLE_LIST.push({'query': 'body', 'eval':'span_lang.innerHTML = TXT["page"]["word"]["language"]'})
