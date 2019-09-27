/*-------------------------------------
AUTHOR: IFAN
CODE-VERSION: 190219
-------------------------------------*/

/*jQuery v3.3.1*/
/*
*/

/*Less*/
// var less = {
//   env: "deployment",
//   async: false,
//   fileAsync: false,
//   poll: 1000,
//   functions: {},
//   dumpLineNumbers: "comments",
//   relativeUrls: false,
//   rootpath: ""
// };

// window.mobileAndTabletcheck = function() {
//   var check = false;
//   (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
//   console.log(check)
//   return check;
// };

var isMobile = {
  Android: function() {
    return navigator.userAgent.match(/Android/i);
  },
  BlackBerry: function() {
    return navigator.userAgent.match(/BlackBerry/i);
  },
  iOS: function() {
    return navigator.userAgent.match(/iPhone|iPad|iPod/i);
  },
  Opera: function() {
    return navigator.userAgent.match(/Opera Mini/i);
  },
  Windows: function() {
    return navigator.userAgent.match(/IEMobile/i);
  },
  any: function() {
    return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
  }
};


var LSSK = 'ioHybJBEFOSmNFFEPAMVA8979218uHH6dw6766868GGguwydgw'

var DATA = "Data"
var FUNC_NAME = "Functionname"
var FILE_NAME = "Filename"
var FILE_DIR = "Filedir"
var FILE_PATH = "Filepath"
var RES_STAT = 'RESPONSE_STATUS'

var style = ''

var SUCCESS = 'A1';
var FAILED = 'E1';
var NOT_FOUND = 'E2';
var NOT_EXIST = 'E3';
var PASS_INCORRECT = 'E4';
var USERNAME_EXIST = 'C1';
var EMAIL_EXIST = 'C2';

var FLORALWHITE = "#FFFAF0"
var CRIMSON = "#DC143C"
var SADDLEBROWN = "#8B4513"
var GOLDENROD = "#DAA520"
var PERU = "#CD853F"
var OLIVEDRAB = "#9ACD32" 
var YELLOW = "#FFFF00"
var CREAM = "#FFFCC9"
var DARKGOLDENROD = '#B8860B';
var SANDYBROWN = '#F4A460';
var GOLD = '#FFD700';


var TOP_HEIGHT = 0
var scrollPos = 0

// var PROJECT_NAME = ''



var L = new Lanterlite();
var F = new functions();
var genf = new functions();


$('body').addClass('theme_bgclr_main1')
if (sessionStorage.getItem(MD5("user")) != null)
	var login = true
else
	var login = false



// function Component () {
// 	this.header = header
// }

function Lanterlite() {

	this.canvas = new Canvas()
	this.body = new body()
	this.page = new page()
	this.header = new header()
	this.sidebar = new sidebar()
	this.mtbutton = new mtbutton()
	this.snackbar = new snackbar()
	this.fcanvas = new fcanvas()
	this.toggle = new toggle()
	this.checkbox = new checkbox()
	this.fbutton = new fbutton()
	this.splash = new SplashScreen()
	this.loading = new loading()
	this.rslider = new rslider()
	this.rbutton = new rbutton()
	this.winmenubar = new winmenubar()

	this.app = new app()
	this.user = new user()
	this.theme = new theme()
	this.lang = new lang()

	this.head = new head()
	this.accordion = new accordion()

	/* ================================================
	accordion
	================================================ */
	function winmenubar() {
		this.set = set
		this.minimize_win = minimize_win
		this.minmax_win = minmax_win
		this.close_win = close_win

		function set(appname) {
			TOP_HEIGHT = 30;
			    var menu = '<div class="winmenubar title-bar">'+
	      '<div class="menu-button-container">'+
	        '<button style="background: url('+BASE_URL+'assets/lite.img/winmenubar/icon.ico'+') center center / 15px 15px no-repeat;" id="menu-button" class="menu-button" disabled/>'+
	      '</div>'+
	      '<div class="app-name-container">'+
	        '<p>'+appname+'</p>'+
	      '</div>'+
	      '<div class="window-controls-container">'+
	        '<button onclick="L.winmenubar.minimize_win()" style="-webkit-mask: url('+BASE_URL+'assets/lite.img/winmenubar/minimize.svg'+') center center / 20px 50px no-repeat;" id="minimize-button" class="minimize-button"/>'+
	        '<button onclick="L.winmenubar.minmax_win()" style="-webkit-mask: url('+BASE_URL+'assets/lite.img/winmenubar/minmax.svg'+') center center / 20px 50px no-repeat;" id="min-max-button" class="min-max-button"/>'+
	        '<button onclick="L.winmenubar.close_win()" style="-webkit-mask: url('+BASE_URL+'assets/lite.img/winmenubar/close.svg'+') center center / 20px 50px no-repeat;" id="close-button" class="close-button"/>'+
	        // '<button style="background: url('+BASE_URL+'assets/lite.img/winmenubar/minimize.svg'+') center center / 20px 50px no-repeat;" id="minimize-button" class="minimize-button"/>'+
	        // '<button style="background: url('+BASE_URL+'assets/lite.img/winmenubar/minmax.svg'+') center center / 20px 50px no-repeat;" id="min-max-button" class="min-max-button"/>'+
	        // '<button style="background: url('+BASE_URL+'assets/lite.img/winmenubar/close.svg'+') center center / 20px 50px no-repeat;" id="close-button" class="close-button"/>'+
	      '</div>'+
	    '</div>'
	    menu = LGen.StringMan.to_elm(menu)
	    // document.querySelector('.canvas').appendChild(menu)
	    L.canvas.ctable.add(menu, 'height: 30px;')
	    
		}

	    function minimize_win() {
	    	var remote = require('electron').remote
				remote.BrowserWindow.getFocusedWindow().minimize();
	    }
	    function minmax_win() {
	    	// var { BrowserWindow } = require('electron').remote

				// Or use `remote` from the renderer process.
				// var { BrowserWindow } = require('electron').remote

				// var win = new BrowserWindow({ width: 800, height: 600 })
				// win.setFullScreen(true)


	    	var remote = require('electron').remote
				// // remote.BrowserWindow.maximize();
				if (remote.getCurrentWindow().isFullScreen()) {
					remote.getCurrentWindow().setFullScreen(false)
				}
				else {
					remote.getCurrentWindow().setFullScreen(true)
				}
	   //  	var remote = require('electron').remote
				// $('#close-btn').on('click', e => {
				//     remote.getCurrentWindow().close()
				// })
	    }

	    function close_win() {
	    	var remote = require('electron').remote
		    remote.getCurrentWindow().close()
	    }
	}

	/* ================================================
	GENERAL
	================================================ */
	function head() {
		this.icon_set = icon_set
		this.title_set = title_set
		this.meta = new meta()

		function icon_set() {
		  var head = document.getElementsByTagName('head')[0];
		  var link = document.createElement('link');
		  link.rel = 'icon';
		  link.type = 'image/gif';
		  link.href = BASE_URL + './assets/lite.img/icon.gif';
		  head.appendChild(link);
		}

		function meta() {
			this.add_viewport = add_viewport
			this.add_desc = add_desc

			function add_viewport() {
				var meta1 = document.createElement('meta');
				meta1.httpEquiv = "X-UA-Compatible";
				meta1.content = "IE=edge";
				document.getElementsByTagName('head')[0].appendChild(meta1);

				var meta2 = document.createElement('meta');
				meta2.content = "width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no";
				meta2.name = "viewport";
				document.getElementsByTagName('head')[0].appendChild(meta2);
			}

			function add_desc(desc) {
				if (desc === undefined)
					desc = ''
				var meta = document.createElement('meta');
				meta.name = "description";
				meta.content = desc;
				document.getElementsByTagName('head')[0].appendChild(meta);
			}
		}

		function title_set(title) {
			if (title === undefined)
				title = ''
			var t = document.createElement('title');
			t.innerHTML = title;
			document.getElementsByTagName('head')[0].appendChild(t);
		}
	}

	/* ================================================
	LANGUAGE
	================================================ */
	function lang() {
		this.set = set

		function set(titles) {
			// if (L.sidebar.is_exist) {
			// 	L.sidebar.change_titles(titles['sidebar'])
			// }
		}

		function _set(url, lang) {
			var count = 0
			text_get(count)
			function text_get(count) {
			 	LGen.JsonMan.read_local(BASE_URL + 'storage/languages/'+URL[KEYS[count]], function(obj) {
					TXT[KEYS[count]] = obj
					SET[count]()
					count += 1
					if (count < KEYS.length) {
						text_get(count)
					}
				})
			}
		}
	}

	/* ================================================
	THEME
	================================================ */
	function theme() {
		this.set = set
		this.change = change
		// this.set2 = set2
		// this.change2 = change2

		function set2 (theme_id)  {
			// theme_id = theme_id.toLowerCase()
			// var preload = '<link class="theme" rel="preload" href="' + BASE_URL + './assets/lite.theme/'+ theme_id +'.js' +'" as="script">'
			// preload = LGen.StringMan.to_elm(preload)
			// var script = '<script src="../assets/lite.theme/day.js"></script>'
			// var script = '<script type="text/javascript" id="'+theme_id+'" src="' + BASE_URL + 'assets/lite.theme/'+ theme_id +'.js' +'">'
			// script = LGen.StringMan.to_elm(script)
	  //   // document.getElementsByTagName('head')[0].appendChild(preload);
	  //   document.getElementsByTagName('body')[0].appendChild(script);
			// script['filepath'] = BASE_URL + 'assets/lite.theme/'+ theme_id +'.js';
			// script['id'] = theme_id
			// script['class'] = theme_id
			var script = {'filepath' : BASE_URL + 'assets/lite.theme/'+ theme_id +'.js', 'id' : theme_id, 'class' : theme_id}
	    importScript2(script)
		}

		function change2 (theme_id)  {
			clear_all_content('script.theme')
			var script = {'filepath' : BASE_URL + 'assets/lite.theme/'+ theme_id +'.js', 'id' : theme_id, 'class' : theme_id}
	    importScript2(script)

			// theme_id = theme_id.toLowerCase()
			// var preload = '<link class="theme" rel="preload" href="' + BASE_URL + './assets/lite.theme/'+ theme_id +'.js' +'" as="script">'
			// preload = LGen.StringMan.to_elm(preload)
			// var script = '<script id="'+theme_id+'" class="theme" src="' + BASE_URL + './assets/lite.theme/'+ theme_id +'.js' +'">'
			// script = LGen.StringMan.to_elm(script)
	  //   var head = document.getElementsByTagName('head')[0];
	  //   // head.appendChild(preload);
	  //   head.appendChild(script);
		}

		function set(theme_id) {
			theme_id = theme_id.toLowerCase()
			var preload = '<link class="theme" rel="preload" href="' + BASE_URL + './assets/lite.theme/'+ theme_id +'.css' +'" as="style">'
			preload = LGen.StringMan.to_elm(preload)
			var link = '<link id="'+theme_id+'" class="theme" rel="stylesheet" type="text/css" href="' + BASE_URL + './assets/lite.theme/'+ theme_id +'.css' +'" media="all">'
			link = LGen.StringMan.to_elm(link)
			// var cssId = theme_id;
	  //   var head = document.getElementsByTagName('head')[0];
	  //   var link = document.createElement('link');
	  //   link.id = cssId;
	  //   link.setAttribute('class', 'theme');
	  //   link.rel = 'stylesheet';
	  //   link.type = 'text/css';
	  //   link.href = BASE_URL + './assets/lite.theme/'+ theme_id +'.css';
	  //   link.media = 'all';
	  //   head.appendChild(link);
	    var head = document.getElementsByTagName('head')[0];
	    head.appendChild(preload);
	    head.appendChild(link);
		}

		function change(theme_id) {
			clear_all_content('link.theme')
			theme_id = theme_id.toLowerCase()
			var preload = '<link class="theme" rel="preload" href="' + BASE_URL + './assets/lite.theme/'+ theme_id +'.css' +'" as="style">'
			preload = LGen.StringMan.to_elm(preload)
			var link = '<link id="'+theme_id+'" class="theme" rel="stylesheet" type="text/css" href="' + BASE_URL + './assets/lite.theme/'+ theme_id +'.css' +'" media="all">'
			link = LGen.StringMan.to_elm(link)
			// var cssId = theme_id;
	  //   var link = document.createElement('link');
	  //   link.id = cssId;
	  //   link.setAttribute('class', 'theme');
	  //   link.rel = 'stylesheet';
	  //   link.type = 'text/css';
	  //   link.href = BASE_URL + './assets/lite.theme/'+ theme_id +'.css';
	  //   link.media = 'all';
	    var head = document.getElementsByTagName('head')[0];
	    head.appendChild(preload);
	    head.appendChild(link);
		}
	}


	/* ================================================
	BODY PAGE
	================================================ */
	function page() {
		this.set = set
		this.add = add
		this.open = open

		function set (id) {
			var page = document.createElement('div')
			page.setAttribute('class', 'page ' + id)
			page.setAttribute('id', 'page')
			page.setAttribute('style', 'display: none;')

			var body = document.querySelector('#canvas #ctable tr td > #body')
			body.appendChild(page)
		}

		function add(id, elm) {
			var page = document.querySelector('#canvas #body #page.'+id)
			page.appendChild(elm)
		}	

		function open(id, callback) {
			if (callback === undefined)
				callback = function() {}
			var pages = document.querySelectorAll('#canvas #body #page')

			for (var i=0; i<pages.length; i++) {
				if (pages[i].className != 'page ' + id) {
					// pages[i].style.zIndex = 5
					$(pages[i]).fadeOut()
				}
				if (i==pages.length-1) {
					// document.querySelectorAll('#canvas #body #page.'+id)[0].style.zIndex = 6
					// pages[i].zIndex = 5
				  setTimeout(function(){ 
						$('#canvas #body #page.'+id).fadeIn()
						callback()
				  }, 200);
				}
			}
			// var page1 = document.querySelector()
			// $('#canvas #body #page.'+from_id).fadeOut()
			// $('#canvas #body #page.'+to_id).fadeIn()
		}	
	}


	/* ========================================
	USER
	======================================== */
	function app() {
		this.clear = clear
		this.get = get
		this.set = set
		
		function clear() {
			sessionStorage.clear();	
		}

		function set(id, app) {
			var data = JSON.stringify(app)
			data = btoa(data)
			sessionStorage.setItem(MD5(id), data);
		}

		function get(id) {
			var app = sessionStorage.getItem(MD5(id))
			if (app != null) {
			 	app = JSON.parse(atob(app))
				var data = app
				data[RES_STAT] = SUCCESS
				return data
			}
			else {
				var data = {}
				data[RES_STAT] = NOT_EXIST
				return data
			}
		}
	}

	function user() {
		this.get = get
		this.set = set

		function get() {
			return JSON.parse(atob(sessionStorage.getItem(MD5("user"))))
		}

		function set() {

		}
	}

}



	

	

/* ========================================

FUNCTIONS

======================================== */

function get_svg(name) {
// function get_svg(name, id, is_str) {
	// if (is_str === undefined)
	// 	is_str=false
	var def = $.Deferred()
	var svg = ''
	var file_path = BASE_URL + './assets/lite.icon/icons/' + name + '.svg'
	// read_svg(file_path, function() {
	read_svg(file_path, function(svg_str) {
		// if (!is_str) {
		// 	svg = LGen.StringMan.to_elm(svg_str)
		// 	svg.setAttribute('class', id)
		// 	def.resolve(svg)
		// }
		// else {
			def.resolve(svg_str)
		// }
		// return svg
		// def.promise(svg)
	})

	// def.resolve(svg)
	// console.log(svg)

	// return $.when(def).done(function(svg) {return svg;}).promise(svg);
	return def.promise();

	function read_svg(file_path, callback) {
		$.ajax({
	    type: "GET",
	    url: file_path,
	    // contentType: "image/svg+xml",
	    contentType: "application/json;",
	    dataType: "json",
	    success: function(obj) { callback(obj); },
	    error: function(e) { callback(e.responseText); }
		});  
	}
}

function copyToClipboard (str) {
  var el = document.createElement('textarea');
  el.value = str;
  el.setAttribute('dir', 'rtl');
  el.setAttribute('readonly', '');
  el.style.position = 'absolute';
  el.style.left = '-9999px';
  document.body.appendChild(el);
  el.select();
  document.execCommand('copy');
  document.body.removeChild(el);
}

// (function wait() {
// 	if (ayah<byword_arabic['verses'].length) {
// 		if (ayah == 0) {
// 			ayah_set(ayah)
// 			ayah++
// 			setTimeout( wait, 1 )
// 		}
// 		else if (is_exist('#body #surah .ayah.num' + temp)) {
// 			ayah_set(ayah)
// 			temp = ayah
// 			ayah++
// 			setTimeout( wait, 1 )
// 		}
// 	}
// })();


// var wait = ms => new Promise((r, j)=>setTimeout(r, ms))
// function sleep(delay) {
//   var start = new Date().getTime();
//   while (new Date().getTime() < start + delay);
// }


//// Get user data from sessionStorage.
function getUserData(callback) {
  // if (checksessionStorage()) {
  // if (sessionStorage.getItem(PROJECT_NAME) != null) {
  //   var data = JSON.parse(sessionStorage.getItem('enlite'))
  //   callback(data)
  // }
  // else {
  //   var data = JSON.stringify({
  //   "is_search" : is_search,
  //   "search_value" : search_value,
  //   "lang" : lang
  // })
  //   sessionStorage.setItem('enlite', data)
  //   callback(JSON.parse(data))
  // }
}


function root_word(obj, callback) {
  var data = { "Data" : obj };
	$.ajax({
	    type: "POST",
	    url: BASE_URL + "lanterlite.gen.php",
	    data: JSON.stringify(data),
	    contentType: "application/json;",
	    dataType: "json",
      beforeSend: header_set,
      success: function(obj) { callback(obj); },
      error: function(e) { callback(e.responseText); }
	});  

  function header_set(xhr) { 
  	xhr.setRequestHeader(FUNC_NAME, 'root_word');
  }
}

function send_to_be(url, func, callback) {
  var data = {};
  data[DATA] = func
  data['LSSK'] = LSSK
	$.ajax({
    type: "POST",
    url: BE_URL + url,
    data: JSON.stringify(data),
    contentType: "application/json;",
    dataType: "json",
    success: function(obj) { console.log(obj); callback(obj); },
    error: function(e) { console.log(e.responseText); }
	});  
}


/* obj_req = {'method':'get', 'url':'https://lightbe.lanterlite.com/light/...', 'callback':function(obj){}} */
/* obj_req = {'method':'post', 'url':'http://localhost/app/lightbe.lanterlite.com/light/', 'callback':function(obj){console.log(obj)}, 'data':'$G->post_char_data("asd");'} */
function req_to_server(obj_req) {
	if (obj_req['method'] == 'get') {
		$.ajax({
	    type: "GET",
	    url: obj_req['url'],
	    contentType: "application/json;",
	    dataType: "json",
	    success: function(obj_res) { obj_req['callback'](obj_res); },
	    error: function(e) { obj_req['callback'](e.responseText); }
		});  
	}
	else if (obj_req['method'] == 'post') {
	  var data = {};
	  data[DATA] = obj_req['data']
	  data['LSSK'] = LSSK
		$.ajax({
	    type: "POST",
	    url: obj_req['url'],
	    data: JSON.stringify(data),
	    contentType: "application/json;",
	    dataType: "json",
	    success: function(obj) { obj_req['callback'](obj); },
	    error: function(e) { obj_req['callback'](e.responseText); }
		});  
	}
}

/* obj_req = {'method':'get', 'url':'tradelite/...', 'callback':'function(obj){}'} */
function req_to_backlite(obj_req) {
	console.log(obj_req['url'])
	if (obj_req['method'] == 'get') {
		$.ajax({
	    type: "GET",
	    url: BE_URL + obj_req['url'],
	    contentType: "application/json;",
	    dataType: "json",
	    success: function(obj_res) { obj_req['callback'](obj_res); },
	    error: function(e) { obj_req['callback'](e.responseText); }
		});  
	}
	else if (obj_req['method'] == 'post') {
	  var data = {};
	  data[DATA] = obj_req['data']
	  data['LSSK'] = LSSK
		$.ajax({
	    type: "POST",
	    url: BE_URL + obj_req['url'],
	    data: JSON.stringify(data),
	    contentType: "application/json;",
	    dataType: "json",
	    success: function(obj) { obj_req['callback'](obj); },
	    error: function(e) { obj_req['callback'](e.responseText); }
		});  
	}
}

function req_to_frontlite(url, func, callback) {
  var data = {};
  data[DATA] = func
  data['LSSK'] = LSSK
	$.ajax({
    type: "POST",
    url: FE_URL + url,
    data: JSON.stringify(data),
    contentType: "application/json;",
    dataType: "json",
    success: function(obj) { callback(obj); },
    error: function(e) { callback(e.responseText); }
	});  
}



function text_save(txt, file_path, callback) {
	//// obj can be json or array of json.
  var data = { "Data" : txt };
	$.ajax({
    type: "POST",
    url: BASE_URL + "lanterlite.gen.php",
    data: JSON.stringify(data),
    contentType: "application/json;",
    dataType: "json",
    beforeSend: header_set,
    success: function(obj) { callback(obj); },
    error: function(e) {}
    // error: function(e) { console.log(e.responseText); }
	});  

  function header_set(xhr) { 
  	xhr.setRequestHeader(FUNC_NAME, 'saveFileText');
  	xhr.setRequestHeader(FILE_PATH, file_path);
  }
}

function text_read(file_path, callback) {
	$.ajax({
    type: "GET",
    url: BASE_URL + "lanterlite.gen.php",
    contentType: "application/json;",
    dataType: "json",
    beforeSend: header_set,
    success: function(obj) { callback(obj); },
    // error: function(e) {}
    error: function(e) { callback(e.responseText); }
	});  

  function header_set(xhr) { 
  	xhr.setRequestHeader(FUNC_NAME, 'readFileText');
  	xhr.setRequestHeader(FILE_PATH, file_path);
  }
}

function getFileNamesInsideDir(file_dir, callback) {
	$.ajax({
    type: "GET",
    url: BASE_URL + "lanterlite.gen.php",
    contentType: "application/json;",
    dataType: "json",
    beforeSend: header_set,
    success: function(obj) { callback(obj); },
    // error: function(e) {}
    error: function(e) { callback(e.responseText); }
	});  

  function header_set(xhr) { 
  	xhr.setRequestHeader(FUNC_NAME, 'getFileNamesInsideDir');
  	xhr.setRequestHeader(FILE_DIR, file_dir);
  }
}

function writeToFile(file_path, msg) {
	$.getScript('lite.js/filesaver.min.js', function() {          
		var blob = new Blob([msg], {type: "text/plain;charset=utf-8"});
		saveAs(blob, file_path);
	});
}

// function js_to_php_json_str(json) {
// 	for(var i=)
// 	return
// }

function getMeta(metaName) {
  var metas = document.getElementsByTagName('meta');

  for (var i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === metaName) {
      return metas[i];
    }
  }

  return '';
}


function change_notif_to_backend(notif_index, notif_param, val, callback) {
  var json_upload = JSON.stringify({
    'Data':{
    	'user_username': JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['user_username'],
    	'notif_index': notif_index,
    	'notif_param': notif_param,
    	'val': val
    }
  });
  
 $(document).ready(function() {
    $.ajax({
      url: BE_URL + "user/changenotif",
      type: 'GET',
      dataType: 'json',
      beforeSend: header_set,
      success: function(obj) { callback(obj); },
	    error: function(e) { console.log(e.responseText); }
    });
  });

  function header_set(xhr) {
    xhr.setRequestHeader('Data', json_upload);
  }
}

function getUserFromBackend(callback) {
  var json_upload = JSON.stringify({
    // 'access_token': JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['access_token'],
    'Data':{
    	'user_username': JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['user_username']
    }
  });
  
 $(document).ready(function() {
    $.ajax({
      url: BE_URL + "user/getone",
      type: 'GET',
      dataType: 'json',
      beforeSend: header_set,
      success: function(obj) { callback(obj); },
	    error: function(e) {}
	    // error: function(e) { console.log(e.responseText); }
    });
  });

  function header_set(xhr) {
    xhr.setRequestHeader('Data', json_upload);
  }
}

function getNotifFromBackend(callback) {
  var json_upload = JSON.stringify({
    'Data':{
    	'user_username': JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['user_username']
    }
  });
  
 $(document).ready(function() {
    $.ajax({
      url: BE_URL + "user/getnotif",
      type: 'GET',
      dataType: 'json',
      beforeSend: header_set,
      success: function(obj) { callback(obj); },
	    error: function(e) { console.log(e.responseText); }
    });
  });

  function header_set(xhr) {
    xhr.setRequestHeader('Data', json_upload);
  }
}

function MD5(string) {
  function RotateLeft(lValue, iShiftBits) {
    return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
  }

  function AddUnsigned(lX,lY) {
    var lX4,lY4,lX8,lY8,lResult;
    lX8 = (lX & 0x80000000);
    lY8 = (lY & 0x80000000);
    lX4 = (lX & 0x40000000);
    lY4 = (lY & 0x40000000);
    lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
    if (lX4 & lY4) {
      return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
    }
    if (lX4 | lY4) {
      if (lResult & 0x40000000) {
      return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
    } else {
        return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
      }
    } else {
      return (lResult ^ lX8 ^ lY8);
    }
  }

  function F(x,y,z) { return (x & y) | ((~x) & z); }
  function G(x,y,z) { return (x & z) | (y & (~z)); }
  function H(x,y,z) { return (x ^ y ^ z); }
  function I(x,y,z) { return (y ^ (x | (~z))); }

  function FF(a,b,c,d,x,s,ac) {
    a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
    return AddUnsigned(RotateLeft(a, s), b);
  };

  function GG(a,b,c,d,x,s,ac) {
    a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
    return AddUnsigned(RotateLeft(a, s), b);
  };

  function HH(a,b,c,d,x,s,ac) {
    a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
    return AddUnsigned(RotateLeft(a, s), b);
  };

  function II(a,b,c,d,x,s,ac) {
    a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
    return AddUnsigned(RotateLeft(a, s), b);
  };

  function ConvertToWordArray(string) {
    var lWordCount;
    var lMessageLength = string.length;
    var lNumberOfWords_temp1=lMessageLength + 8;
    var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
    var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
    var lWordArray=Array(lNumberOfWords-1);
    var lBytePosition = 0;
    var lByteCount = 0;
    while ( lByteCount < lMessageLength ) {
      lWordCount = (lByteCount-(lByteCount % 4))/4;
      lBytePosition = (lByteCount % 4)*8;
      lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
      lByteCount++;
    }
    lWordCount = (lByteCount-(lByteCount % 4))/4;
    lBytePosition = (lByteCount % 4)*8;
    lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
    lWordArray[lNumberOfWords-2] = lMessageLength<<3;
    lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
    return lWordArray;
  };

  function WordToHex(lValue) {
    var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
    for (lCount = 0;lCount<=3;lCount++) {
      lByte = (lValue>>>(lCount*8)) & 255;
      WordToHexValue_temp = "0" + lByte.toString(16);
      WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
    }
    return WordToHexValue;
  };

  function Utf8Encode(string) {
    string = string.replace(/\r\n/g,"\n");
    var utftext = "";

    for (var n = 0; n < string.length; n++) {
      var c = string.charCodeAt(n);

      if (c < 128) {
        utftext += String.fromCharCode(c);
      }
      else if((c > 127) && (c < 2048)) {
        utftext += String.fromCharCode((c >> 6) | 192);
        utftext += String.fromCharCode((c & 63) | 128);
      }
      else {
        utftext += String.fromCharCode((c >> 12) | 224);
        utftext += String.fromCharCode(((c >> 6) & 63) | 128);
        utftext += String.fromCharCode((c & 63) | 128);
      }
    }
    return utftext;
  };

  var x=Array();
  var k,AA,BB,CC,DD,a,b,c,d;
  var S11=7, S12=12, S13=17, S14=22;
  var S21=5, S22=9 , S23=14, S24=20;
  var S31=4, S32=11, S33=16, S34=23;
  var S41=6, S42=10, S43=15, S44=21;

  string = Utf8Encode(string);
  x = ConvertToWordArray(string);
  a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;

  for (k=0;k<x.length;k+=16) {
    AA=a; BB=b; CC=c; DD=d;
    a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
    d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
    c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
    b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
    a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
    d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
    c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
    b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
    a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
    d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
    c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
    b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
    a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
    d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
    c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
    b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
    a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
    d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
    c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
    b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
    a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
    d=GG(d,a,b,c,x[k+10],S22,0x2441453);
    c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
    b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
    a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
    d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
    c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
    b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
    a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
    d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
    c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
    b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
    a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
    d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
    c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
    b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
    a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
    d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
    c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
    b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
    a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
    d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
    c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
    b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
    a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
    d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
    c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
    b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
    a=II(a,b,c,d,x[k+0], S41,0xF4292244);
    d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
    c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
    b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
    a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
    d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
    c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
    b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
    a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
    d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
    c=II(c,d,a,b,x[k+6], S43,0xA3014314);
    b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
    a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
    d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
    c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
    b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
    a=AddUnsigned(a,AA);
    b=AddUnsigned(b,BB);
    c=AddUnsigned(c,CC);
    d=AddUnsigned(d,DD);
	}

  var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);

  return temp.toLowerCase();
}

function append_first(parent, new_child) {
	parent.insertBefore(new_child, parent.firstChild);
}


function change_page_by_url_ext(url) {
	if (APP_PLATFORM == 'des') {
		var shell = require('electron').shell
		shell.openExternal(url)
	}
	else {
		window.open(url)
	}
}

function change_page_by_url(url) {
	if (APP_TYPE == 'amp' && APP_PLATFORM != 'web') {
		ampxweb_switch_page(url)
	}
	else {
		// ampxweb_switch_page(url)
		window.location.href = url
	}
}
// function loop_delay2()

function loop_delay(i, callback) {
	var done = 1
	myloop()
	function myloop() {
		setTimeout(function() {
			if (done == 1) {
				done = 0
				done = callback(i)
				i++;
				myloop()
			}
			else if (done == 0)
				myloop()

		}, 0)
	}
}

function import_jsmod(filepath) {
	var imported = document.createElement('script');
	imported.src = filepath;
	imported.type = 'module';
	document.head.appendChild(imported);
}

function importScript(filepath) {
	var imported = document.createElement('script');
	imported.src = filepath;
	imported.id = 'asd';
	imported.className = 'asd';
	document.head.appendChild(imported);
}

function importScript2(obj) {
	var script = document.createElement('script');
	if (obj['filepath'] !== null)
		script.src = obj['filepath'];
	if (obj['id'] !== null)
		script.id = obj['id'];
	if (obj['class'] !== null)
		script.className = obj['class'];
	document.head.appendChild(script);
}





function is_exist(query) {
	if ($(query).length > 0)
	  return true
	else
		return false
}




function disable_canvas_scroll() {
	document.querySelector("html").style.overflow = "hidden";
}

function logout() {
	sessionStorage.removeItem(MD5('user'));
	location.reload();
}

function enable_canvas_scroll() {
	document.querySelector("html").style.overflow = "auto";
}

function toTop() {
	$(document).ready(function() {
    // $("html, body").animate({ scrollTop: 0 }, 0);
    $(".canvas > .ctable > tr > td > .body").animate({ scrollTop: 0 }, "slow");
    // $("html, body").animate({ scrollTop: 0 }, "slow");
	});	
}

function signInFromBackend(email, password, callback) {
  var json_upload = {}
	json_upload[DATA] = {
    'user_email': email, 
    'user_password': password		
	}
 	$(document).ready(function() {
    $.ajax({
      url: BE_URL + "user/signin",
      type: 'GET',
      dataType: 'json',
      beforeSend: header_set,
      timeout: 10000,
      success: function(obj) { callback(obj); },
	    // error: function(e) {}
	    error: function(e) { 
	    	console.log(e)
				L.loading.close()
				L.snackbar.open("Sorry, We couldn't load the content. Please check Your connection or try again later.")
	    }
	    // error: function(e) { callback(e.responseText); }
    });
  });

  function header_set(xhr) {
    xhr.setRequestHeader('Data', JSON.stringify(json_upload));
  }
}


function try_again_later_set() {
	L.loading.close()
	L.snackbar.open("Sorry, We couldn't load the content. Please check Your connection or try again later.")
	// var try_again_later = document.createElement('div')
	// try_again_later.innerHTML = "Sorry, We couldn't load the content. Please check Your connection or try again later."

	// var content = document.createElement('div')
	// content.setAttribute('class', 'result')

	// var canvas = document.querySelector('#body #page.page_search')
	// canvas.appendChild(content)
}
function signIn() {
	var email = document.getElementById('email').value.toLowerCase();
	var password = MD5(document.getElementById('password').value);
	if (email == "") {
		L.snackbar.open(TXT['header']['word']['email_empty'])
	}
	else if (password == "") {
		L.snackbar.open(TXT['header']['word']['pass_empty'])
	}
  else if (validateEmail(email) == false) {
		L.snackbar.open(TXT['header']['word']['email_invalid'])
  }
	else {
		L.loading.open();
		signInFromBackend(email, password, function (obj) {
			if (obj[RES_STAT] == SUCCESS) {
				L.loading.close()
				var user = JSON.stringify(obj[DATA])
				// var user = JSON.stringify({
				// 	// 'access_token' : obj.access_token,
				// 	'user_username' : obj[DATA].user_username,
				// 	'user_id' : obj[DATA].user_id,
				// 	'user_image' : obj[DATA].user_image,
				// 	'user_litepoint' : obj[DATA].user_litepoint,
				// 	'user_litegold' : obj[DATA].user_litegold,
				// 	'user_isverified' : obj[DATA].user_isverified
				// })
				sessionStorage.setItem(MD5("user"), btoa(user));

				getNotifFromBackend(function(notif) {

				})

				location.reload();
			}
			else if (obj[RES_STAT] == PASS_INCORRECT){
				L.loading.close()
				L.snackbar.open(TXT['header']['word']['email_pass_incorrect'])
				document.querySelector('#account #signin_btn').disabled = false
			}
			else if (obj[RES_STAT] == NOT_EXIST){
				L.loading.close()
				L.snackbar.open(TXT['header']['word']['email_unregistered'])
				document.querySelector('#account #signin_btn').disabled = false
			}	
		})
	}
	return false;
}

function validateEmail(mail)	{
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
		return true
	}
	return false
}

function number_input_create () {
	var inp = LGen.StringMan.to_elm(
	'<div class="number-input" style="border:none;">' +
	  '<button onclick="this.parentNode.querySelector(\'input[type=number]\').stepDown()" class="std gold"></button>' +
	  '<input class="quantity std" min="1" name="quantity" style="width: auto; text-align: center;" value="1" type="number">' +
	  '<button onclick="this.parentNode.querySelector(\'input[type=number]\').stepUp()" class="std gold plus"></button>' +
	'</div>'
	)
	return inp
}

function is_input_focus(input) {
	return $(input).is(':focus');
}

function random_from_to(min, max) {
	return Math.floor(Math.random()*(max-min+1)+min);
}

// send_post('echo $duel->start("'+char_info_json['duel_id']+'");', function(obj) {console.log(obj)})
function send_post(data, func) {
	if (func == undefined) func = function() {}
	req_to_server({
		'method':'post',
		'url':be_url, 
		'callback':function(obj) {
			func(obj)
		},
		'data': data
	})
}

// function send_post2(data, func, err_func) {
// 	if (func == undefined) func = function(obj) {}
// 	if (err_func == undefined) err_func = function(obj) {console.log(data, obj[RES_STAT] }
// 	req_to_server({
// 		'method':'post',
// 		'url':be_url, 
// 		'callback':function(obj) {
// 			if (obj[RES_STAT == SUCCESS])
// 				func(obj)
// 		},
// 		'data': data
// 	})
// }

// send_get('echo $duel->get_duel("'+char_id+'", "'+char_info_json['duel_id']+'");', function(obj) {console.log(obj)})
function send_get(url, func) {
	if (func == undefined) func = function() {}
	req_to_server({
		'method':'get', 
		'url':be_url+'?f='+encodeURI(url), 
		'callback':function(obj) {
			func(obj)
		}
	})
}

function functions() {
	this.arr = new arr()
	this.amp = new amp()
	this.create_input_posnum = create_input_posnum
	this.set_input_posnum = set_input_posnum

	/* set input for positive number only*/
	function set_input_posnum(input) {
		input_filter_set(input, function(value) { return /^\d*$/.test(value); })
		input.addEventListener("keypress", function (evt) {
	    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
	      evt.preventDefault();
	    }
	    input.value = parseInt(input.value, 10);
		});
		return input
	}

	/* create input for positive number only*/
	function create_input_posnum() {
		var input = LGen.StringMan.to_elm('<input value=0 type="number" min=0></input>')
		input_filter_set(input, function(value) { return /^\d*$/.test(value); })
		input.addEventListener("keypress", function (evt) {
	    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
	      evt.preventDefault();
	    }
		});
		return input
	}

	function amp() {
		this.create_page = create_page
		
		function create_page(css) {
			if (css === undefined) css = false
			$.when(
			  $.getScript( FE_BASE_URL + 'assets/'+APP_CODENAME+'/js/'+PAGE_CODENAME+'.js' ),
			  $.Deferred(function( deferred ){$( deferred.resolve );})
			).done(function(){
				if (css) {
					$.when(
						$('<link/>', {rel: 'stylesheet', type: 'text/css', href: CSS_URL+PAGE_CODENAME+'.css'}).appendTo('head'),
					  $.Deferred(function( deferred ){$( deferred.resolve );})
					).done(function(){});
				}
			});
		}
	}

	function arr() {
		this.del_first_index = del_first_index
		this.del_last_index = del_last_index
		
		function del_first_index(arr) {
			arr.shift();
		}

		function del_last_index(arr) {
			arr.pop();
		}
	}
}

function createMgmtRow(id, obj, callback) {
	if (id%2 == 1) {
		var color = 'black';
		var bgcolor = 'goldenrod';
	}
	else if (id%2 == 0) {
		var color = 'goldenrod';
		var bgcolor = 'black';
	}
	else if (id == 'new') {
		var color = 'black';
		var bgcolor = 'green';
	}	

	td_title = document.createElement('td')
	td_title.innerHTML = obj['title']
	style = 'text-align: center;'
	style += 'padding: 10px;'
	td_title.setAttribute('style', style)

	td_value = document.createElement('td')
	td_value.innerHTML = obj['value']
	style = 'text-align: center;'
	style += 'padding: 10px;'
	td_value.setAttribute('style', style)

	tr = document.createElement('tr')
	tr.appendChild(td_title)
	tr.appendChild(td_value)
	tr.addEventListener('click', function(e) {
		open()
		callback(e.target.parentNode.parentNode.id)
	})

	var tbl = document.createElement('table')
	tbl.appendChild(tr)
	style = 'color: ' + color + ';'
	style += 'border-radius: 7px;'
	style += 'margin-bottom: 10px;'
	style += 'max-width: 200px;'
	style += 'min-width: 100px;'
	style += 'background-color: '+bgcolor+';'
	tbl.setAttribute('id', obj['value'])
	tbl.setAttribute('style', style)


	// var div2 = document.createElement('div')
	// div2.setAttribute('id', id)
	// style = 'width: 100%;'
	// style += 'position: absolute%;'
	// div2.setAttribute('style', style)

	// var div1 = document.createElement('div')
	// div1.appendChild(tbl)
	// div1.appendChild(div2)
	return tbl;
}

function tableToJson(query) {
	 var table = document.querySelector(query)
	 var json = {}
	 for (var i=0; i<table.childNodes.length; i++) {
	 	json[table.childNodes[i].childNodes[0].innerHTML] = table.childNodes[i].childNodes[1].childNodes[0].value 
	 }
	 return json;
}

var makeJsonFromTable=function(query) {
    var tbl=$(query)
	var tblhead=$(tbl).find('thead')
	var tblbody=$(tbl).find('tbody')
	var tblbodyCount=$(tbl).find('tbody>tr').length;
	var header=[];
	var JObjectArray=[];
	$.each($(tblhead).find('tr>th'),function(i,j){
        header.push($(j).text())
	})
	$.each($(tblbody).find('tr'),function(key,value)
	{
	   var jObject={};
	   for(var x=0 ; x < header.length;x++)
	   {
		 jObject[header[x]]=$(this).find('td').eq(x).text()
	   }
	   JObjectArray.push(jObject)
	
	});
	var jsonObject={};
	jsonObject["count"]=tblbodyCount
	jsonObject["value"]=JObjectArray;
	return jsonObject;
}

function anchor_set_temp(a) {
	var new_anc = document.createElement('a')
	var str = str_to_list(a.innerHTML)
	for (var i=0; i<str.length; i++) {
		var span = document.createElement('span')
		span.innerHTML = str[i]
		new_anc.appendChild(span)
	}
	new_anc.setAttribute('href', a.href)
	new_anc.setAttribute('class', 'style hover-shadow hover-color')
	return new_anc
}

function anchor_set(a) {
	a.setAttribute('class', 'std third after')
	return a
}



function flipTable(query) {
  $(query).each(function() {
      var $this = $(this);
      var newrows = [];
      $this.find("tr").each(function(){
          var i = 0;
          $(this).find("td").each(function(){
              i++;
              if(newrows[i] === undefined) { newrows[i] = $("<tr></tr>"); }
              newrows[i].append($(this));
          });
      });
      $this.find("tr").remove();
      $.each(newrows, function(){
          $this.append(this);
      });
  });
}



function applyTblToJsonStr(query) {
  var div = document.createElement('div')
  // var div = document.querySelector('div.apply')
  // div.style.display = ''
  // displayComponent('.canvas', 'none')
  // clear_content('div.apply div.content')

  // var tbl = document.createElement('table')
  // var td_close = document.createElement('td')
  // var btn = document.createElement('button')
  // var style = 'position: fixed;'
  // style += 'top: 0;'
  // style += 'right: 0;'
  // style += 'width: 100px;'
  // style += 'height: 50px;'
  // style += 'background-color: #0f0f0f;'
  // btn.setAttribute('style', style)
  // btn.addEventListener('click', function() {
  //   clear_content('div.apply table')
  //   displayComponent('.canvas', '')
  //   displayComponent('div.apply', 'none')
  // })
  // td_close.appendChild(btn)
  // var tr_close = document.createElement('tr')
  // tr_close.appendChild(td_close)
  // tbl.appendChild(tr_close)

  var td_content = document.createElement('td')
  var str = '<pre>[</pre>'
  var tables = document.querySelector(query)
  for (var i=0; i<tables.childNodes.length; i++) {
  // for (var i=0; i<obj.length; i++) {
    str += '<pre>  {</pre>'
    for (var j=0;j<tables.childNodes[i].childNodes.length; j++) {
      str += '<pre>'
      str += '    "' + strToJsonStr(tables.childNodes[i].childNodes[j].childNodes[0].innerHTML) + '"' + ": "
      if (j!=tables.childNodes[i].childNodes.length-1)
        str += '"' + strToJsonStr(tables.childNodes[i].childNodes[j].childNodes[1].childNodes[0].value) + '",'
      else
        str += '"' + strToJsonStr(tables.childNodes[i].childNodes[j].childNodes[1].childNodes[0].value) + '"'
      str += '</pre>'
    }
    if (i!=tables.childNodes.length-1)
      str += '<pre>  },</pre>'
    else
      str += '<pre>  }</pre>'
  }
  str += '<pre>]</pre>'
  var txt_str = document.createTextNode(str)
  var p = document.createElement('span')
  p.innerHTML = str
  // p.setAttribute('white-space', 'pre-line;')
  // td_content.appendChild(p)
  // var tr_content = document.createElement('tr')
  // tr_content.appendChild(td_content)
  // tbl.appendChild(tr_content)
  var div_content = document.createElement('div')
  div_content.setAttribute('class', 'content')
  div_content.appendChild(p)
  div_content.appendChild(tbl)
  // div_content.appendChild(btn)
  div.appendChild(div_content)
  return div
}



function createMgmtTbl(obj, save) {
  // var tbl_con = document.createElement('table');

	// var nav_num = document.querySelector('.nav_num');
	// var div_num = document.createElement('div');
	// for (var i=0; i<obj['tot_page']; i++) {
	//   if (cur_page == i)
	//     div_num.appendChild(createNum(i, i+1, 'blue'))
	//   else
	//     div_num.appendChild(createNum(i, i+1, 'black'))
	// }
	// nav_num.appendChild(div_num)

	// for (var i=0; i<obj.length; i++) {
	  var table = document.createElement('table');
	  table.setAttribute('border', '1px solid black');
	  var style = 'margin: 0px 0px 20px 0px;'
	  table.setAttribute('style', style);
	  var keys = Object.keys(obj);
	  for (var j=0; j<keys.length; j++) {
	    // if (i==0)
	    //   titles.push(keys[j])
	    table.appendChild(createRowForMgmtTbl('first', keys[j], obj[keys[j]]))
	  }
	  // tbl_con.appendChild(table)
	// }
	var div_save = document.createElement('div')
	div_save.innerHTML = 'save'
	div_save.addEventListener('click', function() {
		// flipTable('#mgmt table')
		// var obj = makeJsonFromTable('#mgmt table')
		var obj = tableToJson('#mgmt table')
		var id = document.querySelector('#id')
		id = id.childNodes[0].value
		json_save(save['file_dir'], id + '.json', obj, function(obj) {
			// console.log(obj)
		})
		// close()

		var cv1 = document.querySelector('.canvas1')
		var exist = false
		var tot_nodes = cv1.childNodes.length
		for (var i=0; i<tot_nodes; i++) {
			if (cv1.childNodes[i].id == id + '.json') {
				// var tbl = document.querySelector('table#'+id+'.json')
				// cv1.childNodes[i].className = cv1.childNodes[i].className + 'saved'
				cv1.childNodes[i].style.backgroundColor = 'green'
				cv1.childNodes[i].style.color = 'black'
				i = cv1.childNodes.length
			}
			else if (i == cv1.childNodes.length-1) {
				var _obj = {}
				_obj['title'] = 'ID'
				_obj['value'] = id + '.json'

				var tbl = document.querySelector('#mgmt table')
				var tr = createMgmtRow('new', _obj, function (id) {
					var dir = 'hadith2/enlite_db/each_hadith/BM/'
					json_read(dir, id, function(obj2){
						var save = {'file_dir':dir, 'file_name':id + '.json'}
						var div = createMgmtTbl(obj2[DATA], save)
						var canvas = document.querySelector('#fcanvas #body')
						canvas.appendChild(div)
					})
				})

				var canvas = document.querySelector('div.canvas1')
				canvas.insertBefore(tr, canvas.firstChild);				
			}
		}
	})

	var div = document.createElement('div')
	div.appendChild(table)
	div.appendChild(div_save)
	div.setAttribute('id', "mgmt")

	return div
	// canvas.appendChild(table);

	function createRowForMgmtTbl(id_color, title, value) {
		var color = 'first';
		if (id_color%2 == 1) {
			color = 'second';
		}
	  var tr = document.createElement('tr');
	  var td_title = document.createElement('td');
	  td_title.setAttribute('class', color + ' left');
	  // td_title.setAttribute('id', 'content');
	  var txt_title = document.createTextNode(title);
	  var txt_value = document.createTextNode(value);       

	  var inp_title = document.createElement('textarea')
	  inp_title.setAttribute('type', 'text')
	  inp_title.setAttribute('class', 'title left')
	  inp_title.value = title


	  var inp_value = document.createElement('textarea')
	  var style = 'overflow: hidden;'
	  inp_value.setAttribute('class', 'value right')
	  inp_value.setAttribute('style', style)
	  // inp_value.setAttribute('type', 'text')
	  inp_value.value = value
	  inp_value.addEventListener('keydown', autosize)

	  td_title.innerHTML = title
	 	style = ''
	 	style += 'width: 130px;'
	  td_title.setAttribute('style', style)

	  var td_value = document.createElement('td');
	  td_value.setAttribute('class', color + ' right');
	  td_value.setAttribute('id', title);
	  td_value.appendChild(inp_value)
	  // td_title.appendChild(txt_title)
	  // td_value.appendChild(txt_value)

	  tr.appendChild(td_title)
	  tr.appendChild(td_value)
	  return tr;
	}
	function autosize(){
	  var el = this;
	  setTimeout(function(){
	    el.style.cssText = 'height:auto; padding:0';
	    // for box-sizing other than "content-box" use:
	    // el.style.cssText = '-moz-box-sizing:content-box';
	    el.style.cssText = 'height:' + el.scrollHeight + 'px';
	  },0);
	}
}

function getLangFromBackend(lang, callback) {
	var xhr = new XMLHttpRequest();
	var url = FE_URL + "language?data=" + encodeURIComponent(JSON.stringify({'Data':{'lang': lang}}));
	xhr.open("GET", url, true);
	xhr.setRequestHeader("Content-Type", "application/json");
	xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var json = JSON.parse(xhr.responseText);
      callback(json);
    }
	};
	xhr.send();

  // var json_upload = JSON.stringify({
  //   'Data':{
  //   	'lang': lang
  //   }
  // });
  // console.log(lang)
  //   $(document).ready(function() {
  //     $.ajax({
  //       url: HOME_URL + "language",
  //       type: 'GET',
  //       dataType: 'json',
  //       beforeSend: header_set,
  //       success: function(obj) { callback(obj); },
  //       // error: function(e) {}
  //       error: function(e) { console.log(e); },
  //     });
  //   });

  //   function header_set(xhr) {
  //     xhr.setRequestHeader('Data', JSON.stringify({'Data':{'lang': lang}}));
  //     // xhr.setRequestHeader('Data', json_upload);
  //   }
}

function date_get_str() {
  var date = new Date();
  var str = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + " " +  date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
  return str;
}

function signUpFromBackend(data, callback) {
  var json_upload = JSON.stringify({ //// Assign JSON data to send.
  		'Data': {
	      'user_fullname' : data['user_fullname'], 
	      'user_username' : data['user_username'], 
	      'user_email' : data['user_email'],
	      'user_password' : data['user_password'],
	      'user_image' : data['user_image'],
	      'user_lang' : 'id',
	      'user_created_date' : date_get_str()
	    }
  });

	$.ajax({
	    type: "POST",
	    url: BE_URL + "user/signup",
	    // The key needs to match your method's input parameter (case-sensitive).
	    data: json_upload,
	    contentType: "application/json; charset=utf-8",
	    dataType: "json",
      beforeSend: header_set,
      success: function(obj) { callback(obj); },
      // error: function(e) {}
      error: function(e) { callback(e.responseText); }
	});  

  function header_set(xhr) {
    xhr.setRequestHeader('Data', JSON.stringify({'LSSK' : LSSK}));
  }
}

function resendVerEmail(callback) {
  var json_upload = JSON.stringify({ //// Assign JSON data to send.
		// 'access_token': JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['access_token'],
		'Data': {
      'user_username' : JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['user_username']
    }
  });

	$.ajax({
	    type: "POST",
      url: BE_URL + "user/resend_email_ver",
	    data: json_upload,
	    contentType: "application/json; charset=utf-8",
	    dataType: "json",
      beforeSend: header_set,
      success: function(obj) { callback(obj); },
      error: function(e) { callback(e.responseText); }
	});  

  function header_set(xhr) {
    xhr.setRequestHeader('Data', JSON.stringify({'LSSK' : LSSK}));
  }  
}

function setSplashScreen() {
	var svg = document.createElement("svg")
	svg.setAttribute("class", "loader")
	svg.setAttribute("xmlns", "http://www.w3.org/2000/svg")
	svg.setAttribute("viewBox", "0 0 46 33")
	style = "background-image: url('./img/logo_cream.svg');"
	style += "background-position: center center;"
	style += "background-size: 100%;"
	style += "background-repeat: no-repeat;"
	svg.setAttribute("style", style)
	var g = document.createElement('g')
	g.setAttribute("stroke-width", "1")
	g.setAttribute("fill", "none")
	g.setAttribute("fill-rule", "evenodd")
	svg.appendChild(g)
	var div_loader = document.getElementById("loader")
	loader.appendChild(svg)	
}

//// Remove element from html.
function clear_content(query) {
  var content = document.querySelector(query);
  if (content != null)
    content.parentNode.removeChild(content);    
}

//// Remove element from html.
function clear_self(obj) {
	try {
	  obj.parentNode.removeChild(obj)
	}
	catch(err) {
	}
}

//// Remove element from html.
function clear_all_content(query) {
	var content = document.querySelectorAll(query)
  if (content != null) {
  	for(var i=0; i<content.length; i++) {
	    content[i].parentNode.removeChild(content[i]);    

		}	
  }
}

function clear_all_childs(obj) {
	for(var i=0; i<obj.childNodes.length; i++) {
    console.log('asd23')
    clear_self(obj.childNodes[0]);
    console.log('asd')
	}
}






function footer_set() {
	var lf = createLanguageFooter()
	var pf = createProductFooter()
	var ff = createFollowUsFooter()
	var af = createCompanyFooter()

	var td_1 = document.createElement('td')
	td_1.appendChild(lf)
	var td_2 = document.createElement('td')
	td_2.appendChild(pf)
	var td_3 = document.createElement('td')
	td_3.appendChild(ff)
	var td_4 = document.createElement('td')
	td_4.appendChild(af)

	var tr = document.createElement('tr')
	tr.appendChild(td_1)
	tr.appendChild(td_2)
	tr.appendChild(td_3)
	tr.appendChild(td_4)

	var tbl = document.createElement('table')
	tbl.appendChild(tr)

	var footer = document.createElement('div')
	footer.setAttribute('class', 'footer')
	var div = document.createElement('div')
	div.appendChild(tbl)
	var cr = createCopyright()
	div.appendChild(cr)
	footer.appendChild(div)

	var body = document.querySelector('#canvas #body')
	body.appendChild(footer)

	function createLanguageFooter() {
		var a_e = document.createElement('a')
		a_e.innerHTML = "English"
		a_e.addEventListener('click', function() {
		  app["LANG"] = 'en'
			L.app.set(APP_ID, app)
			location.reload();
		})

		var a_b = document.createElement('a')
		a_b.innerHTML = "Bahasa"
		a_b.addEventListener('click', function() {
		  app["LANG"] = 'id'
			L.app.set(APP_ID, app)
			location.reload();
		})

		var td_t = document.createElement('td')
		td_t.setAttribute('class', 'fields')
		td_t.innerHTML = TXT['footer']['footer']['language']
		var tr_t = document.createElement('tr')
		tr_t.appendChild(td_t)

		var td_e = document.createElement('td')
		td_e.appendChild(a_e)
		var tr_e = document.createElement('tr')
		tr_e.appendChild(td_e)

		var td_b = document.createElement('td')
		td_b.appendChild(a_b)
		var tr_b = document.createElement('tr')
		tr_b.appendChild(td_b)

		var tbl = document.createElement('table')
		tbl.appendChild(tr_t)
		tbl.appendChild(tr_e)
		tbl.appendChild(tr_b)
		return tbl
	}

	function createFollowUsFooter() {
		var td_t = document.createElement('td')
		td_t.setAttribute('class', 'fields')
		td_t.innerHTML = TXT['footer']['footer']['follow_us']
		var tr_t = document.createElement('tr')
		tr_t.appendChild(td_t)

		var a_f = document.createElement('a')
		a_f.innerHTML = "Facebook"
		a_f.href = "https://facebook.com/lanterlite"
		a_f.target = "_blank"

		var td_f = document.createElement('td')
		td_f.appendChild(a_f)
		var tr_f = document.createElement('tr')
		tr_f.appendChild(td_f)

		var a_i = document.createElement('a')
		a_i.innerHTML = "Instagram"
		a_i.href = "https://instagram.com/lanterlite"
		a_i.target = "_blank"

		var td_i = document.createElement('td')
		td_i.appendChild(a_i)
		var tr_i = document.createElement('tr')
		tr_i.appendChild(td_i)

		var a_t = document.createElement('a')
		a_t.innerHTML = "Twitter"
		a_t.href = "https://twitter.com/lanterlite"
		a_t.target = "_blank"

		var td_tw = document.createElement('td')
		td_tw.appendChild(a_t)
		var tr_tw = document.createElement('tr')
		tr_tw.appendChild(td_tw)

		var a_p = document.createElement('a')
		a_p.innerHTML = "Pinterest"
		a_p.href = "https://pinterest.com/lanterlite"
		a_p.target = "_blank"

		var td_p = document.createElement('td')
		td_p.appendChild(a_p)
		var tr_p = document.createElement('tr')
		tr_p.appendChild(td_p)

		var tbl = document.createElement('table')
		tbl.appendChild(tr_t)
		tbl.appendChild(tr_f)
		tbl.appendChild(tr_i)
		tbl.appendChild(td_tw)
		tbl.appendChild(tr_p)

		return tbl
	}

	function createProductFooter() {
		var td_t = document.createElement('td')
		td_t.setAttribute('class', 'fields')
		td_t.innerHTML = TXT['footer']['footer']['product']
		var tr_t = document.createElement('tr')
		tr_t.appendChild(td_t)

		var a_1 = document.createElement('a')
		a_1.innerHTML = "Enlite"
		a_1.href = "https://play.google.com/store/apps/details?id=com.lanterlite.enlite"
		a_1.target = "_blank"

		var td_1 = document.createElement('td')
		td_1.appendChild(a_1)
		var tr_1 = document.createElement('tr')
		tr_1.appendChild(td_1)

		var a_2 = document.createElement('a')
		a_2.innerHTML = "Qulite"
		a_2.href = "https://play.google.com/store/apps/details?id=com.lanterlite.quranic"
		a_2.target = "_blank"

		var td_2 = document.createElement('td')
		td_2.appendChild(a_2)
		var tr_2 = document.createElement('tr')
		tr_2.appendChild(td_2)


		var tbl = document.createElement('table')
		tbl.appendChild(tr_t)
		tbl.appendChild(tr_1)
		tbl.appendChild(tr_2)

		return tbl
	}

	function createCompanyFooter() {
		var elm = '<table>'+
				'<tr>'+'<td class="fields">'+TXT['footer']['footer']['company']['title']+'</td>'+'</tr>'+
				'<tr>'+'<td>'+'<a onclick="change_page_by_url(\''+CORELITE_URL+'about\')">'+TXT['footer']['footer']['company']['about']+'</a>'+'</td>'+'</tr>'+
				'<tr>'+'<td>'+'<a onclick="change_page_by_url(\''+CORELITE_URL+'team\')">'+TXT['footer']['footer']['company']['team']+'</a>'+'</td>'+'</tr>'+
			'</table>'

		var tbl = LGen.StringMan.to_elm(elm)
		// var td_t = document.createElement('td')
		// td_t.setAttribute('class', 'fields')
		// td_t.innerHTML = TXT['footer']['footer']['company']['title']

		// var tr_t = document.createElement('tr')
		// tr_t.appendChild(td_t)

		// var a_1 = document.createElement('a')
		// a_1.innerHTML = TXT['footer']['footer']['company']['about']
		// a_1.href = HOME_URL + 'about'

		// var td_1 = document.createElement('td')
		// td_1.appendChild(a_1)
		// var tr_1 = document.createElement('tr')
		// tr_1.appendChild(td_1)

		// var tbl = document.createElement('table')
		// tbl.appendChild(tr_t)
		// tbl.appendChild(tr_1)

		return tbl
	}

	function createCopyright() {
		var label = document.createElement('label')
		label.innerHTML = "&#169 Lanterlite 2019"
		label.setAttribute('class', 'footer-copyright')
		return label
	}
}

function ampxweb_switch_page(url) {
	var done = true
	while (done) {
		if (url.search(/\/\//i) >= 0) {
			url = url.replace(/\/\//gi, '\/');
		}
		else {
			done = false
			dirs = str_split(url, '/')

			var start_index = dirs.indexOf(APP_DOMAIN)
			for (var i=0; i<start_index+1; i++) {
				F.arr.del_first_index(dirs)
			}

			try {
				clear_self(L.body.elm.parentNode.parentNode)
				clear_self(L.header.elm.parentNode.parentNode)
			}
			catch(err) {}
			// clear_self(L.canvas.ctable.elm)
			// L.canvas.ctable.set()
			// if (APP_PLATFORM == 'des')
			// 	L.winmenubar.set(APP_NAME)
			L.body.set()
			route()
		}
	}
}

function ampweb_switch_page(url) {
	dirs = str_split(url, '/')
	var start_index = dirs.indexOf(APP_DOMAIN)

	for (var i=0; i<start_index+1; i++) {
		F.arr.del_first_index(dirs)
	}

	if (url.match(/\/\//g).length > 1) {
		var done = true
	}
	else {
		var done = false
		route()
	}

	while (done) {
		if (url.search(/\/\//i) >= 0) {
			url = url.replace(/\/\//gi, '\/');
		}
		else {
			done = false
			dirs = str_split(url, '/')
			var start_index = dirs.indexOf(APP_DOMAIN)

			for (var i=0; i<start_index+1; i++) {
				F.arr.del_first_index(dirs)
			}
			url = arr_to_str(dirs, '/')
			window.location.href = HOME_URL + url
		}
	}
}


// function str_same_word_tot(str, word) {
// 	return (str.match(/,/g) || []).length
// }

function array_create(arr, val) {
	if (!is_exist_array_value.call(arr, val)) {
		arr.push(val)
	}
	return arr;
}

function title_gen_create(title) {
	var tbl = document.createElement('table')

	var td_1 = document.createElement('td')
	td_1.setAttribute('style', 'color: black; font-size: 24px; font-family: Crimson; vertical-align: bottom; text-align: center; padding: 10px 0px 0px 0px;')
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

	return tbl
}

function page_1_create(PAGE_TXT) {
	var div_post = document.createElement('div')
	div_post.setAttribute('id', 'post_2')
		// post_title_set(PAGE_TXT['title'])

		var list = document.createElement('table')
		list.setAttribute('id', 'content')
		var tr = document.createElement('tr')
		list.appendChild(tr)

		for (var j=0; j<PAGE_TXT['content'].length; j++) {
			var content = content_create(PAGE_TXT['content'][j])
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
			else if (j==PAGE_TXT['content'].length-1){
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
	return div_post

	function post_title_set(title) {
		var tbl = document.createElement('table')
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

	function content_create(obj) {

		var img = document.createElement('img')
		// img.setAttribute('src', FE_BASE_URL + 'assets/'+APP_CODENAME+'/img/' + obj["img"])
		img.setAttribute('src', obj["img"])
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
  	div_1.setAttribute('style', 'font-size: 24px; text-align: left; font-family: Crimson; line-height: 24px; color: black; font-weight: 400; letter-spacing: normal; text-align: left; overflow: hidden; margin: 0px 0px 5px 0px;')

		var div_date = document.createElement('div')
		div_date.innerHTML = obj["sub1"]
  	div_date.setAttribute('style', "font-size: 16px; font-weight: 600; color: green; text-align: left; font-family: sans-serif;")

		var div_2 = document.createElement('div')
		div_2.setAttribute('style', 'font-size: 16px; margin: 3px 0px; color: #5f6368; text-align: left; line-height: 16px; font-family: calibri;')
		div_2.innerHTML = obj["sub2"]

		var td_2 = document.createElement('td')
		var style = "padding: 10px 10px 10px 10px;"
		style += 'text-align: left;'
		td_2.setAttribute('style', style)
		td_2.appendChild(div_1)
		td_2.appendChild(div_date)
		td_2.appendChild(div_2)

		if (obj['link'] != '') {
			var count = 0
			for (var i=0; i<obj['link'].length; i++) {
				var div = LGen.StringMan.to_elm('<div>'+
					'</div>'
				)

				function func_create(link) {
					return function() { change_page_by_url(link) }
				}

				var a = LGen.StringMan.to_elm('<a target="_blank">'+obj['link'][i]['title']+'</a>')
				if (APP_TYPE == 'amp')
					a.addEventListener('click', func_create(obj['link'][i]['url']))
				else
					a.href = HOME_URL + obj['link']['url']
				// var a = document.createElement('a')
				// a.href = obj['link'][i]['url']
				// a.innerHTML = obj['link'][i]['title']
				a = anchor_set(a)
				div.appendChild(a)
				td_2.appendChild(div)
				count += 1
			}
		}

		var tr_2 = document.createElement('tr')
		tr_2.appendChild(td_2)			

		var tbl = document.createElement('table')
		tbl.appendChild(tr_1)
		tbl.appendChild(tr_2)
		return tbl
	}
}


function check_tx_id () {
	$.ajax({
    url: "http://localhost/app/be.lanterlite.com/payment/?gateway_id=ipaymu&action=trans&trans_id=369481",
    type: 'GET',
    dataType: 'json',
    success: function(obj) { obj = JSON.parse(obj); console.log(obj); },
    // error: function(e) {}
    error: function(e) { console.log(e.responseText); },
  });
}

function unused_func() {
	function getLangFromBackend(lang, callback) {
	  var json_upload = JSON.stringify({
	    'Data':{
	    	'lang': lang
	    }
	  });
	    $(document).ready(function() {
	      $.ajax({
	        url: HOME_URL + "language",
	        type: 'GET',
	        dataType: 'json',
	        beforeSend: header_set,
	        success: function(obj) { callback(obj); },
	        // error: function(e) {}
	        error: function(e) { callback(e.responseText); },
	      });
	    });

	    function header_set(xhr) {
	      xhr.setRequestHeader('Data', json_upload);
	    }
	}
	function HowToUseJsonREADLOCAL() {
	 	LGen.JsonMan.read_local(BE_URL + '/storage/languages/page_news/'+news_id+'/id', function(obj) {
			// console.log(LGen.StringMan.to_elm(obj))
			obj = obj[DATA];
		})
	}
}
	
function pending_function() {
	function get_license_from_backend() {
		req_to_backlite({
			'method':'get', 
			'url':'user/license_get/?user_id=f7718beb9db5b6d6b2afaabbe604e21e&user_lang=id', 
			'callback':function(obj){console.log(obj)}
		})
	}
}

/* How to use
	// Restrict input to digits and '.' by using a regular expression filter.
	input_filter_set(document.getElementById("myTextBox"), function(value) {
	  return /^\d*\.?\d*$/.test(value);
	});

	Integer values (both positive and negative): /^-?\d*$/.test(value)
	Integer values (positive only): /^\d*$/.test(value)
	Integer values (positive and up to a particular limit): /^\d*$/.test(value) && (value === "" || parseInt(value) <= 500)
	Floating point values (allowing both . and , as decimal separator): /^-?\d*[.,]?\d*$/.test(value)
	Currency values (i.e. at most two decimal places): /^-?\d*[.,]?\d{0,2}$/.test(value)
	Hexadecimal values: /^[0-9a-f]*$/i.test(value)
*/

// Restricts input for the given textbox to the given inputFilter.
function input_filter_set(textbox, inputFilter) {
  ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
    textbox.addEventListener(event, function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      }
    });
  });
}

