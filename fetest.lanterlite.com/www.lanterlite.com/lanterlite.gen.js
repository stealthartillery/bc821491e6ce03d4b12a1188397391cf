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



var L = new lanterlite();
var F = new functions();


$('body').addClass('theme_bgclr_main1')
if (sessionStorage.getItem(MD5("user")) != null)
	var login = true
else
	var login = false


function lanterlite() {
	this.canvas = new canvas()
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
	this.splash = new splash()
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
	ACCORDION
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
	        '<button style="background: url('+BASE_URL+'assets/lite.img/winmenubar/icon.ico'+') center center / 25px 25px no-repeat;" id="menu-button" class="menu-button" disabled/>'+
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
	    menu = str_to_elm(menu)
	    // document.querySelector('.canvas').appendChild(menu)
	    L.canvas.ctable.add(menu, 'height: 30px;')
	    
		}

    function minimize_win() {
    	const remote = require('electron').remote
			remote.BrowserWindow.getFocusedWindow().minimize();
    }
    function minmax_win() {
    	// var { BrowserWindow } = require('electron').remote

			// Or use `remote` from the renderer process.
			// const { BrowserWindow } = require('electron').remote

			// var win = new BrowserWindow({ width: 800, height: 600 })
			// win.setFullScreen(true)


    	const remote = require('electron').remote
			// // remote.BrowserWindow.maximize();
			if (remote.getCurrentWindow().isFullScreen()) {
				remote.getCurrentWindow().setFullScreen(false)
			}
			else {
				remote.getCurrentWindow().setFullScreen(true)
			}
   //  	const remote = require('electron').remote
			// $('#close-btn').on('click', e => {
			//     remote.getCurrentWindow().close()
			// })
    }

    function close_win() {
    	const remote = require('electron').remote
	    remote.getCurrentWindow().close()
    }
	}

	function accordion() {
		this.create = create
		this.activate = activate
		this.add = add

		function activate() {
			 $(document).ready(function(){
			     $('.accordion-section-title').click(function(e){
			         var currentAttrvalue = $(this).attr('href');
			         if($(e.target).is('.active')){
			             $(this).removeClass('active');
			             $('.accordion-section-content:visible').slideUp(300);
			         } else {
			             $('.accordion-section-title').removeClass('active').filter(this).addClass('active');
			             $('.accordion-section-content').slideUp(300).filter(currentAttrvalue).slideDown(300);
			         }
			     });
			 });
		}

		function add(accordion, obj) {
			// var accordion = document.querySelector('.accordion.'+id+' .accorfion-section')
			var title = str_to_elm('<a class="accordion-section-title" href="#accordion-'+obj['content_id']+'">'+obj['title']+'</a>')
			var elm = str_to_elm('<div id="accordion-'+obj['content_id']+'" class="accordion-section-content"></div>')
			elm.appendChild(obj['elm'])
			title.addEventListener('click', function(evt) {
				evt.preventDefault(); //prevents hash from being append to the url
			})
			accordion.childNodes[0].appendChild(title)
			accordion.childNodes[0].appendChild(elm)
			return accordion
		}

		function create(id) {
			var accordion = str_to_elm('<div class="accordion '+id+'"></div>')
			var section = str_to_elm('<div class="accorfion-section"></div>')
			accordion.appendChild(section)
			return accordion
			 // <div class="accordion">
    //     <div class="accorfion-section">
    //         <a class="accordion-section-title" href="#accordion-1">Accordion section #1</a>
    //         <div id="accordion-1" class="accordion-section-content">
    //             <p>This is first accordion section</p>
    //         </div>
    //         <a class="accordion-section-title" href="#accordion-2">Accordion section #2</a>
    //         <div id="accordion-2" class="accordion-section-content">
    //             <p> this is second accordian section</p>
    //         </div>
    //         <a class="accordion-section-title" href="#accordion-3">Accordion section #3</a>
    //         <div id="accordion-3" class="accordion-section-content">
    //             <p> this is third accordian section</p>
    //         </div>
    //     </div>
    // </div>
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
			 	json_read_local(BASE_URL + 'storage/languages/'+URL[KEYS[count]], function(obj) {
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
			// preload = str_to_elm(preload)
			// var script = '<script src="../assets/lite.theme/day.js"></script>'
			// var script = '<script type="text/javascript" id="'+theme_id+'" src="' + BASE_URL + 'assets/lite.theme/'+ theme_id +'.js' +'">'
			// script = str_to_elm(script)
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
			// preload = str_to_elm(preload)
			// var script = '<script id="'+theme_id+'" class="theme" src="' + BASE_URL + './assets/lite.theme/'+ theme_id +'.js' +'">'
			// script = str_to_elm(script)
	  //   var head = document.getElementsByTagName('head')[0];
	  //   // head.appendChild(preload);
	  //   head.appendChild(script);
		}

		function set(theme_id) {
			theme_id = theme_id.toLowerCase()
			var preload = '<link class="theme" rel="preload" href="' + BASE_URL + './assets/lite.theme/'+ theme_id +'.css' +'" as="style">'
			preload = str_to_elm(preload)
			var link = '<link id="'+theme_id+'" class="theme" rel="stylesheet" type="text/css" href="' + BASE_URL + './assets/lite.theme/'+ theme_id +'.css' +'" media="all">'
			link = str_to_elm(link)
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
			preload = str_to_elm(preload)
			var link = '<link id="'+theme_id+'" class="theme" rel="stylesheet" type="text/css" href="' + BASE_URL + './assets/lite.theme/'+ theme_id +'.css' +'" media="all">'
			link = str_to_elm(link)
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
	CANVAS
	================================================ */
	function canvas() {
		this.set = set
		this.add = add
		this.elm = ''
		this.ctable = new ctable()

		function ctable() {
			this.add = add
			this.set = set
			this.clear = clear
			this.elm = ''

			function add (elm, style) {
				if (style === undefined)
					style = ''

				var tbl = '<table>'+
					'<tr>'+
					'<td>'+
					'</td>'+
					'</tr>'+
				'</table>'
				tbl = str_to_elm(tbl)
				tbl.childNodes[0].childNodes[0].childNodes[0].setAttribute('style', style)
				tbl.childNodes[0].childNodes[0].childNodes[0].appendChild(elm)
				L.canvas.ctable.elm.appendChild(tbl.childNodes[0].childNodes[0])
			}

			function set() {
				var ctable = '<div class="ctable" id="ctable" cellpadding=0 cellspacing=0></div>'
				ctable = str_to_elm(ctable)
				L.canvas.ctable.elm = ctable
				L.canvas.elm.appendChild(ctable)
			}

			function clear() {
				clear_all_childs(L.canvas.ctable.elm)
			}
		}

		function set() {
			var canvas = '<div class="canvas theme_clr_main1" id="canvas" cellpadding=0 cellspacing=0></div>'
			canvas = str_to_elm(canvas)
			L.canvas.elm = canvas

			var body = document.querySelector('body')
			body.appendChild(canvas)
			L.canvas.ctable.set()
		}

		function add (elm, style) {
			if (style === undefined)
				style = ''

			var tbl = '<table>'+
				'<tr>'+
				'<td>'+
				'</td>'+
				'</tr>'+
			'</table>'
			tbl = str_to_elm(tbl)
			tbl.childNodes[0].childNodes[0].childNodes[0].setAttribute('style', style)
			tbl.childNodes[0].childNodes[0].childNodes[0].appendChild(elm)
			L.canvas.elm.childNodes[0].appendChild(tbl.childNodes[0].childNodes[0])
		}
	}
	
	/* ================================================
	CANVAS BODY
	================================================ */
	function body() {
		this.set = set
		this.add = add
		this.clear = clear
		this.elm = ''

		function clear() {
			clear_self(L.body.elm.childNodes[0])
		}

		function set() {
			var cbody = document.createElement('div')
			cbody.setAttribute('class', 'body')
			cbody.setAttribute('id', 'body')
		  $(cbody).css({'height': 'calc(100vh - '+(51+TOP_HEIGHT).toString()+'px)'})

			// var body = document.querySelector('#canvas')
			// body.appendChild(cbody)
			L.canvas.ctable.add(cbody)
			this.elm = cbody
		}

		function add(elm) {
			L.body.elm.appendChild(elm)
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

	/* ================================================
	CANVAS HEADER
	================================================ */
	function header() {
		this.set = set
		this.hide = hide
		this.show = show
		this.hide_when_scroll_on = hide_when_scroll_on
		this.menu = new menu()
		this.logo = new logo()
		this.srcbar = new srcbar()
		this.account = new account()
		this.blank_col = new blank_col()
		this.elm = ''

		function hide() {
			$(L.header.elm).fadeOut()
		}

		function show() {
			$(L.header.elm).fadeIn()
		}

		function set() {
			var tr = document.createElement('tr')

			var div = document.createElement('table')
			div.appendChild(tr)

			var header = document.createElement('div')
			header.setAttribute('class', 'header')
			header.setAttribute('id', 'header')
			header.appendChild(div)
			$(header).css({'top': TOP_HEIGHT.toString()+'px'})
			L.header.elm = header

			// var canvas = document.querySelector('#canvas')
			// canvas.appendChild(header)	
			L.canvas.ctable.add(header)
		}

		function logo() {
			this.set = set
			this.img = img
			this.click = click

			function set() {

				var img = document.createElement('img')
				img.setAttribute('id', 'logo')
				img.setAttribute('class', 'logo')
				$(img).css({"height": "33px"})
				// img.src = img_path

				var div = document.createElement('div')
				$(div).css({"line-height": "0px"})
				div.appendChild(img)

				var td = document.createElement('td')
				td.setAttribute('id', 'logo_bg')
				td.setAttribute('class', 'logo_bg')
				td.appendChild(div)
			  document.querySelectorAll('.canvas .header table tr')[0].appendChild(td)
			  L.header.logo.click()
			}

			function img(src) {
				if (src === undefined)
					src = BASE_URL + "assets/lite.img/lanterlite-new.png"
				document.querySelector('#header #logo').src = src
			}

			function click(func) {
				if (func === undefined)
					func = function() {change_page_by_url(HOME_URL)}
				var elm = document.querySelector('#header #logo_bg')
				elm.addEventListener('click', func)
			}
		}
	
		function menu() {
			this.set = set
			this.img = img

			function set() {
				var menu = menu_create()
				var td = document.createElement('td')
				td.appendChild(menu)
			  document.querySelectorAll('.canvas .header table tr')[0].appendChild(td)
			  // document.querySelectorAll('.canvas .header table tr')[0].appendChild(td)
			}

			function img (src) {
				if (src === undefined) 
					src = BASE_URL + "assets/lite.img/sidebar.svg"
				var logo = document.querySelector('#header #menu img')
				logo.src = src
			}

			function menu_create() {
				var logo = document.createElement('img')
			  style = 'width:25px;'
			  style += 'margin:10px 10px;'
			  logo.setAttribute('style', style)

				var div = document.createElement('div')
			  style = 'display:inline-block;'
			  style += 'float:left;'
			  div.setAttribute('style', style)
			  div.setAttribute('class', 'menu')
			  div.setAttribute('id', 'menu')
				div.appendChild(logo)
				div.addEventListener('click', function() {
					var sidebar = document.querySelector('.sidebar')
					if (sidebar.className == 'sidebar') {
						sidebar.className = 'sidebar open'
						document.querySelector('div.bg.dark').style.display = ''
						document.querySelector("html").style.overflow = "hidden";
					}
					else {
						sidebar.className = 'sidebar'
						document.querySelector('div.bg.dark').style.display = 'none'
						document.querySelector("html").style.overflow = "auto";
					}
				})

				return div;
			}
		}
	
		function srcbar() {
			this.set = set

			function set(on_submit) {
			  document.querySelectorAll('.canvas .header table tr')[0].appendChild(srcbar_create(on_submit))

				function srcbar_create(on_submit) {
					var inp_sbar = document.createElement('input')
					inp_sbar.setAttribute('class', 'srcbar ff_general')
					// inp_sbar.setAttribute('id', 'srcbar')
					inp_sbar.setAttribute('value', '')
					inp_sbar.setAttribute('placeholder', 'Search Here')
					style = ""
					style += "padding:4px 4px 4px 10px;"
					style += "color: black;"
					style += "border: none;"
					style += "border-radius: 7px;"
					style += "width: 100%;"
					inp_sbar.setAttribute("style", style)

					var src_icon = document.createElement('img')
					src_icon.src = BASE_URL + './assets/lite.img/src.svg'
					src_icon.setAttribute('class', 'icon')
					src_icon.setAttribute('id', 'icon')
					$(src_icon).css({
						"height": "20px"
					})
					src_icon.addEventListener('click', function() {
						var value = document.querySelector('#header input.srcbar').value
						on_submit(value)
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

					td_sb_inp.appendChild(inp_sbar)
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
					form_sb.setAttribute("style", style)
					form_sb.setAttribute("onsubmit", "return functSubmitHeader()")
					form_sb.appendChild(tbl_sb)

					var td = document.createElement('td')
					$(td).css({
						"width": "100%",
						"padding": "0px 10px",
					})
					td.appendChild(form_sb)
					return td
				}
			}
		}

		function account() {
			this.set = set
			this.is_opened = is_opened
			this.open = open
			this.close = close
			this.notif_activate = notif_activate

			function notif_activate() {
				if(typeof(EventSource) !== "undefined") {
				  var source = new EventSource(BE_URL + "user/notifupdate/?username="+JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['user_username']);
				  // var source = new EventSource(BASE_URL+"exp/asd8/demo_sse.php");
				  source.onmessage = function(event) {
					  notif = JSON.parse(event.data);
				  	if (notif !=0) {
				  		document.querySelector('#acc_notif').innerHTML = notif
				  		$('#acc_notif').removeClass('transparent')
				  		document.querySelector('.title.notif').innerHTML = TXT['header']['word']['notification'] + ' (' +  notif + ')'
				  	}
				  	else {
				  		document.querySelector('#acc_notif').innerHTML = ''
				  		$('#acc_notif').addClass('transparent')
				  		document.querySelector('.title.notif').innerHTML = TXT['header']['word']['notification']
				  	}
				    // document.getElementById("result").innerHTML += event.data + "<br>";
				  };
				} else {
			  	console.log('>.<') // Sorry, your browser does not support server-sent events...
				  // document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
				}

			}
			// this.has_login = new has_login()

			// function has_login() {
			// 	this.open = open
			// 	this.close = close
			// 	this.set = set

			// 	function open() {
			// 		var sidebar = document.querySelector('div.asidebar')
			// 		sidebar.className = 'asidebar open'
			// 		document.querySelector('div.bg.acc').style.display = ''
			// 		disable_canvas_scroll();
			// 	}

			// 	function close() {
			// 		var sidebar = document.querySelector('div.asidebar')
			// 		sidebar.className = 'asidebar'
			// 		document.querySelector('div.bg.acc').style.display = 'none'
			// 		enable_canvas_scroll();
			// 	}

			// 	function set() {
			// 		var header = document.createElement('div')
			// 		header.setAttribute('class', 'header')
			// 		header.setAttribute('id', 'header')

			// 		var tbl = document.createElement('table')
			// 		tbl.setAttribute('class', 'body')
			// 		tbl.setAttribute('id', 'body')

			// 		var sidebar = document.createElement('div')
			// 		sidebar.appendChild(header)
			// 		sidebar.appendChild(tbl)
			// 		sidebar.setAttribute('class', 'asidebar')
			// 		sidebar.setAttribute('id', 'asidebar')

			// 		var bg = document.createElement('div')
			// 		bg.setAttribute('class', 'bg acc')
			// 		// style = "background-color: black;"
			// 		style = "opacity: 0.5;"
			// 		style += "display: none;"
			// 		bg.setAttribute('style',style)
			// 		bg.addEventListener('click', function() {
			// 			var sidebar = document.querySelector('div.asidebar')
			// 			if (sidebar.className == 'asidebar') {
			// 				L.header.account.has_login.open()
			// 				// sidebar.className = 'sidebar open'
			// 				// document.querySelector('div.bg.dark').style.display = ''
			// 				// document.querySelector("html").style.overflow = "hidden";
			// 			}
			// 			else {
			// 				L.header.account.has_login.close()
			// 				// sidebar.className = 'sidebar'
			// 				// document.querySelector('div.bg.dark').style.display = 'none'
			// 				// document.querySelector("html").style.overflow = "auto";
			// 			}
			// 		})

			// 		var canvas = document.querySelector('#canvas #header')
			// 		canvas.appendChild(sidebar)
			// 		canvas.appendChild(bg)
			// 	}
			// }

			function is_opened() {
				var dropdown = document.querySelector('div.dropdown')
				if (dropdown.className == 'dropdown open')
					return true
				else
					return false
			}

			function open() {
				var dd = document.querySelector('.dropdown')
				document.querySelector('div.bg.acc').style.display = ''
				dd.className = 'dropdown open'
				$('.dropdown-content').fadeIn(150)
			}

			function close() {
				var dd = document.querySelector('.dropdown')
				document.querySelector('div.bg.acc').style.display = 'none'
				dd.className = 'dropdown'
				$('.dropdown-content').fadeOut(150)
			}

			function set() {

				if (login) {
					var acc = account_create()
					L.header.account.notif_activate()
				}
				else 
					var acc = account_loginform_create()
				var td = document.createElement('td')
				$(td).css({
					// "width": "100%", 
					"text-align":"right"
				})

				var bg = document.createElement('div')
				bg.setAttribute('class', 'bg acc')
				// style = "background-color: black;"
				style = "opacity: 0.5;"
				style += "display: none;"
				bg.setAttribute('style',style)
				bg.addEventListener('click', function() {
					var sidebar = document.querySelector('div.dropdown')
					if (sidebar.className == 'dropdown') {
						L.header.account.open()
					}
					else {
						L.header.account.close()
					}
				})

				td.appendChild(acc)
			  document.querySelectorAll('.canvas .header table tr')[0].appendChild(td)
				document.querySelector('#canvas #header').appendChild(bg)
	
				function account_create() {
					// var page = JSON.parse(atob(sessionStorage.getItem(MD5('lang'))))
					var user = JSON.parse(atob(sessionStorage.getItem(MD5("user"))))

					// var div_stat1 = document.createElement('div')
					// div_stat1.setAttribute('class', 'verifyemail_status')
					// if (JSON.parse(atob(sessionStorage.getItem(MD5("user"))))["user_isverified"] == 0) {
					// 	// div_stat1.innerHTML = '&#10006 Not Verified';
					// 	var ver = document.createElement('button')
					// 	style = 'margin: 0px 0px 0px 5px;'
					// 	style += 'padding: 10px;'
					// 	ver.setAttribute('style', style)
					// 	ver.setAttribute('class', 'brown-btn')
					// 	ver.innerHTML = 'Verify'
					// 	ver.addEventListener('click', function (e) {		
					// 		e.target.disabled = true;
					// 		L.loading.open()
					// 		resendVerEmail(function(obj) {
					// 			L.snackbar.open('Verification email has sent to your email.')
					// 			L.loading.close()
					// 		})
					// 	})

					// 	var div = document.createElement('div')
					// 	div.style.display = 'inline-block'
					// 	div.innerHTML = '&#10006 Not Verified ';
					// 	div_stat1.appendChild(div)
					// 	div_stat1.appendChild(ver)
					// }
					// else {
					// 	div_stat1.innerHTML = '&#10003 Verified';
					// }

					// var div_stat2 = document.createElement('div')
					// div_stat2.setAttribute('class', 'litepoint_status')
					// div_stat2.innerHTML = 'Litepoint: ' + user['user_litepoint']

					// var div_stat3 = document.createElement('div')
					// div_stat3.setAttribute('class', 'litegold_status')
					// div_stat3.innerHTML = 'Litegold: ' + user['user_litegold']

					var div_username = document.createElement('div')
					div_username.setAttribute('class', 'title_xhover')
					div_username.setAttribute('style', 'text-align: center;')
					div_username.innerHTML = user['user_username']

					var div_info = document.createElement('div')
					div_info.setAttribute('class', 'title')
					div_info.innerHTML = TXT['header']['word']['information']
					div_info.addEventListener('click', function() {
						func_info()
					})

					var div_profile = document.createElement('div')
					div_profile.setAttribute('class', 'title')
					div_profile.innerHTML = TXT['header']['word']['profile']
					div_profile.addEventListener('click', function() {
						func_profile()
					})

					var div_notif = document.createElement('div')
					div_notif.setAttribute('class', 'title notif')
					div_notif.innerHTML = TXT['header']['word']['notification']
					div_notif.addEventListener('click', function() {
						func_notif()
					})

					var div_logout = document.createElement('div')
					div_logout.setAttribute('class', 'title')
					div_logout.setAttribute('id', 'header_logout_btn')
					div_logout.addEventListener('click', function(){logout()})
					div_logout.innerHTML = TXT['header']['word']['sign_out']

					var div_ddc = document.createElement('div')
					div_ddc.setAttribute('class', 'dropdown-content')
					div_ddc.appendChild(div_username)
					div_ddc.appendChild(div_notif)
					div_ddc.appendChild(div_profile)
					div_ddc.appendChild(div_info)
					div_ddc.appendChild(div_logout)

					var img = document.createElement('img')
					img.setAttribute('id', 'user_img')
					img.src = BASE_URL + "assets/lite.img/black.svg"
					// img.src = user['user_image']
					img.addEventListener('click', function() {
						// L.header.account.has_login.open()
						var dd = document.querySelector('.dropdown')
						if (dd.className == 'dropdown open') {
							L.header.account.close()
						}
						else {
							L.header.account.open()
						}
					})

					var notif = str_to_elm('<span>'+'</span>')
					// notif.innerHTML = JSON.parse(atob(sessionStorage.getItem(MD5("user"))))['notif_count']
					notif.setAttribute('id','acc_notif')
					notif.setAttribute('class','transparent')
					notif.setAttribute('style', 'position: absolute; top: -5px; right: -4px; font-weight: bold; font-size: small; font-family: arial; background-color: #fa3e3e; border-radius: 2px; color: #fff; padding: 1px 3px;')
    
    			var initial_name = str_to_elm('<div style="color: goldenrod; font-family: Libre Baskerville; font-size: 12px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">' +
    				user['user_fullname'][0]+
    				'</div>')
					initial_name.addEventListener('click', function() {
						// L.header.account.has_login.open()
						var dd = document.querySelector('.dropdown')
						if (dd.className == 'dropdown open') {
							L.header.account.close()
						}
						else {
							L.header.account.open()
						}
					})

					var div_dd = document.createElement('div')
					div_dd.setAttribute('class', 'dropdown')
					div_dd.setAttribute('id', 'userimg_div')
					var style = ([
						'float: right;',
				    'width: 100%;',
				    'height: 30px;',
				  ]).join(' ')
					div_dd.setAttribute('style', style)
					div_dd.appendChild(initial_name)
					div_dd.appendChild(img)
					div_dd.appendChild(notif)
					div_dd.appendChild(div_ddc)

					// var lbl = document.createElement('label')
					// lbl.setAttribute('id', 'header-username')
					// lbl.setAttribute('class', 'ff_general')
					// var style = ([
					// 	'color: goldenrod;',
				 //  ]).join(' ')
					// lbl.setAttribute('style', style)
					// lbl.innerHTML = user['user_username']

					// var td_1 = document.createElement('td')
					// td_1.setAttribute('id', 'header-col-username')
					// td_1.appendChild(lbl)

					var td_2 = document.createElement('td')
					td_2.setAttribute('id', 'header-col-image')
					td_2.appendChild(div_dd)

					var tr = document.createElement('tr')
					// tr.appendChild(td_1)
					tr.appendChild(td_2)	

					var tbl = document.createElement('table')
					$(tbl).css({
						'margin': '0px 10px',
				  })
					tbl.appendChild(tr)	
					
					return tbl

					function func_notif() {
						change_notif_to_backend('all', 'has_checked', true, function(a){
							// var _tr = document.querySelectorAll('.notif_hover')[index]
							// console.log(index)
							// $(_tr).addClass('has_read')
						})

						var tbl = document.createElement('table')
						// tbl.setAttribute('style', 'width: 100%; background-color: gold;')

						getNotifFromBackend(function(notif) {
							for(var i=0; i<notif[DATA].length; i++) {
								var td_msg = document.createElement('td')
								td_msg.setAttribute('style', 'padding: 10px;')
									var msg = document.createElement('div')
									$(msg).addClass('theme_clr_text1')
									msg.setAttribute('style', 'font-family: calibri;')
									msg.innerHTML = notif[DATA][i]['msg']
									var func = func_create(i, notif[DATA][i]['link'])
									function func_create(index, link) {
										return function() { 
											if (link != "") {
												window.location.href = link
											}
											change_notif_to_backend(index, 'has_read', true, function(a){
												var _tr = document.querySelectorAll('.notif_hover')[index]
												$(_tr).addClass('has_read theme_clr_bg2')
											})
										}
									}
									msg.addEventListener('click', func)

								// var td_date = document.createElement('td')
								// td_date.setAttribute('style', 'width: 100px; vertical-align: top;')

								var div_date = document.createElement('div')
								div_date.setAttribute('style', 'text-align: right; padding: 0px 0px 5px 0px;')
									var date = document.createElement('span')
									date.setAttribute('style', 'text-align: center; padding: 2px 5px; margin: 5px; background-color: #C3E9FF; border-radius: 7px; font-family: Arial; font-size: small;')
									date.innerHTML = notif[DATA][i]['date']
								div_date.appendChild(date)
								// td_date.appendChild(date)
								td_msg.appendChild(div_date)
								td_msg.appendChild(msg)

								var tr = document.createElement('tr')
								tr.appendChild(td_msg)

								// var css = '.notif_hover:hover{ background-color: '++' }';
								// var style = document.createElement('style');
								// if (style.styleSheet) {
								//     style.styleSheet.cssText = css;
								// } else {
								//     style.appendChild(document.createTextNode(css));
								// }
								// document.getElementsByTagName('head')[0].appendChild(style);

								if (notif[DATA][i]['has_read'])
									tr.setAttribute('class', 'notif_hover has_read theme_clr_bg3_hover theme_clr_bg2')
								else
									tr.setAttribute('class', 'notif_hover theme_clr_bg3_hover theme_clr_bg1')

								tbl.appendChild(tr)
							}
						})

						L.fcanvas.title(TXT['header']['word']['notification'])
						var div = document.createElement('div')
						div.appendChild(tbl)
						L.fcanvas.add(div)
						L.fcanvas.open()
					}

					function func_info() {
						var div_lg = str_to_elm('<div class="div">'+
						  '<span class="title">Litegold : </span>'+
							'<span class="val">'+user['user_litegold']+'</span>'+
						'</div>')

						var div_lp = str_to_elm('<div class="div">'+
						  '<span class="title">Litepoint : </span>'+
							'<span class="val">'+user['user_litepoint']+'</span>'+
						'</div>')

						var div_l = str_to_elm('<div class="fcanvas_info"></div>')
						div_l.appendChild(div_lg)
						div_l.appendChild(div_lp)

						var accord = L.accordion.create('asd1')
							var btn = str_to_elm('<button class="std gold">'+TXT['header']['word']['buy_license_card']+'</button>')

							if (APP_PLATFORM == 'des')
								btn.addEventListener('click', function() { window.open(HOST+'tradelite.lanterlite.com/store/lanterlite', "Lanterlite", "resizable,scrollbars,status") } )
							else
								btn.addEventListener('click', function() { window.open(HOST+'tradelite.lanterlite.com/store/lanterlite') } )

							var div = str_to_elm('<div>'+'<div style="padding: 0px 0px 10px 0px;">'+'('+TXT['header']['word']['no_license_card']+')'+'</div>'+'</div>')
							div.appendChild(btn)
							var obj = {'title': TXT['header']['word']['license_card'], 'elm':div, 'content_id': '1'}
						L.accordion.add(accord, obj)

							var div = document.createElement('div')
							div.innerHTML = '('+TXT['header']['word']['no_achievement']+')'
							var obj = {'title': TXT['header']['word']['achievement'], 'elm':div, 'content_id': '2'}
						L.accordion.add(accord, obj)
 						L.accordion.activate()

						var div = document.createElement('div')
						div.appendChild(div_l)
						div.appendChild(accord)

						L.fcanvas.title(TXT['header']['word']['information'])
						L.fcanvas.add(div)
						L.fcanvas.open()
					}

					function func_profile() {
						L.fcanvas.title(TXT['header']['word']['profile'])

						var td_username_title = document.createElement('td'); td_username_title.setAttribute('class', 'fcanvas_profile title theme_clr_text1'); td_username_title.innerHTML = TXT['header']['word']['username']
						var td_fullname_title = document.createElement('td'); td_fullname_title.setAttribute('class', 'fcanvas_profile title theme_clr_text1'); td_fullname_title.innerHTML = TXT['header']['word']['fullname']
						var td_email_title = document.createElement('td'); td_email_title.setAttribute('class', 'fcanvas_profile title theme_clr_text1'); td_email_title.innerHTML = TXT['header']['word']['email']
						var td_verification_title = document.createElement('td'); td_verification_title.setAttribute('class', 'fcanvas_profile title theme_clr_text1'); td_verification_title.innerHTML = TXT['header']['word']['status']

						var td_username_val = document.createElement('td'); td_username_val.setAttribute('class', 'fcanvas_profile val theme_clr_text3'); td_username_val.innerHTML = user['user_username']
						var td_fullname_val = document.createElement('td'); td_fullname_val.setAttribute('class', 'fcanvas_profile val theme_clr_text3'); td_fullname_val.innerHTML = user['user_fullname']
						var td_email_val = document.createElement('td'); td_email_val.setAttribute('class', 'fcanvas_profile val theme_clr_text3'); td_email_val.innerHTML = user['user_email']
						var verf = str_to_elm('<div>'+'</div>')
						if (user['user_isverified']) {
							verf.appendChild(str_to_elm('<span>'+TXT['header']['word']['verified']+'</span>'))
						}
						else {
							var span = str_to_elm('<div style="padding: 0px 0px 10px 0px;">'+TXT['header']['word']['not_verified']+' </div>')
							var btn = str_to_elm('<button class="std gold">'+TXT['header']['word']['send_verification_email']+'</button>')
							btn.addEventListener('click', function (e) {		
								e.target.disabled = true;
								L.loading.open()
								resendVerEmail(function(obj) {
									L.snackbar.open(TXT['header']['word']['ver_email_has_sent'])
									L.loading.close()
								})
							})

							verf.appendChild(span)
							verf.appendChild(btn)
						}

						var td_verification_val = document.createElement('td'); td_verification_val.setAttribute('class', 'fcanvas_profile val theme_clr_text3'); td_verification_val.appendChild(verf)

						var tr_username = document.createElement('tr'); tr_username.setAttribute('style', 'width: 100%;'); tr_username.appendChild(td_username_title); tr_username.appendChild(td_username_val);
						var tr_fullname = document.createElement('tr'); tr_fullname.setAttribute('style', 'width: 100%;'); tr_fullname.appendChild(td_fullname_title); tr_fullname.appendChild(td_fullname_val);
						var tr_email = document.createElement('tr'); tr_email.setAttribute('style', 'width: 100%;'); tr_email.appendChild(td_email_title); tr_email.appendChild(td_email_val);
						var tr_verification = document.createElement('tr'); tr_verification.setAttribute('style', 'width: 100%;'); tr_verification.appendChild(td_verification_title); tr_verification.appendChild(td_verification_val);

						var tbl = document.createElement('table')
						tbl.setAttribute('style', 'width: 100%;');
						tbl.appendChild(tr_username)
						tbl.appendChild(tr_fullname)
						tbl.appendChild(tr_email)
						tbl.appendChild(tr_verification)

						var div = document.createElement('div')
						div.appendChild(tbl)
						L.fcanvas.add(div)
						L.fcanvas.open()
					}
				}

				function account_loginform_create() {
					// var page = JSON.parse(atob(sessionStorage.getItem(MD5('lang'))))

					var img = document.createElement('img')
					img.setAttribute('id', 'user_img')
					img.src = BASE_URL + "assets/lite.img/user.svg"
					img.addEventListener('click', function() {
						var dd = document.querySelector('.dropdown')
						if (dd.className == 'dropdown open') {
							L.header.account.close()
						}
						else {
							L.header.account.open()
						}
					})

					var div_ddc = document.createElement('div')
					div_ddc.setAttribute('class', 'dropdown-content')
					div_ddc.appendChild(sign_menu_create())

					var div_dd = document.createElement('div')
					div_dd.setAttribute('class', 'dropdown')
					div_dd.setAttribute('id', 'userimg_div')
					var style = ([
						'float: right;',
				    'width: 100%;',
				    'height: 30px;',
				  ]).join(' ')
					div_dd.setAttribute('style', style)
					div_dd.appendChild(img)
					div_dd.appendChild(div_ddc)

					var td_2 = document.createElement('td')
					td_2.setAttribute('id', 'header-col-image')
					td_2.appendChild(div_dd)

					var tr = document.createElement('tr')
					tr.appendChild(td_2)	

					var tbl = document.createElement('table')
					$(tbl).css({
						'margin': '0px 10px',
				  })
					tbl.appendChild(tr)	
					
					return tbl
				}

				function sign_menu_create() {
					// var page = JSON.parse(atob(sessionStorage.getItem(MD5('lang'))))

					var inp_e = document.createElement('input')
					inp_e.setAttribute('class', 'signin_box')
					inp_e.setAttribute('id', 'email')
					inp_e.setAttribute('autocomplete', 'off')
					inp_e.setAttribute('type', 'text')
					inp_e.setAttribute('placeholder', TXT['header']['word']['email'])

					var td_e = document.createElement('td')
					td_e.setAttribute('id','header-col-email')
					var style = ([
						'padding: 5px 0px 5px 0px'
					]).join(' ')
					td_e.setAttribute('style', style)
					td_e.appendChild(inp_e)

					// var inp_p = document.createElement('input')
					// inp_p.setAttribute('class', 'signin_box')
					// inp_p.setAttribute('id', 'password')
					// inp_p.setAttribute('type', 'password')
					// inp_p.setAttribute('placeholder', TXT['header']['word']['password'])

					var inp_p = str_to_elm('<input class="signin_box" id="password" type="password" placeholder="'+TXT['header']['word']['password']+'" autocomplete="current-password">'+'</input>')

					var td_p = document.createElement('td')
					td_p.setAttribute('id','header-col-pass')
					var style = ([
						'padding: 5px 0px 5px 0px'
					]).join(' ')
					td_p.setAttribute('style', style)
					td_p.appendChild(inp_p)

					var inp_si = document.createElement('button')
					inp_si.setAttribute('class', 'std gold')
					inp_si.setAttribute('id', 'signin_btn')
					inp_si.setAttribute('type', 'submit')
					inp_si.innerHTML = TXT['header']['word']['sign_in']
					inp_si.addEventListener('click', function() {
						signIn()
						// inp_si.disabled = true;
					})

					var td_si = document.createElement('td')
					var style = ([
						'width: 50%;',
						'padding: 10px 5px 5px 0px'
					]).join(' ')
					td_si.setAttribute('style', style)
					td_si.setAttribute('id','header-col-signin-btn')
					td_si.appendChild(inp_si)

					var inp = document.createElement('input')
					inp.setAttribute('type', 'checkbox')
					inp.setAttribute('id', 'pass_cbx')
					inp.addEventListener('click', function() {showPassword()})

					var lbl_2 = document.createElement('label')
					lbl_2.setAttribute('id', 'signin_warn_lbl')

					var td_b1 = document.createElement('td')
					td_b1.setAttribute('id', 'header-col-warn')
					// var style = 'display: none;'
					// td_b1.setAttribute('style', style)
					td_b1.appendChild(lbl_2)

					var lbl_1 = document.createElement('label')
					lbl_1.setAttribute('id', 'pass_cbx_txt')
					lbl_1.setAttribute('for', 'checkbox')
					lbl_1.innerHTML = "Show Password"

					var div = document.createElement('div')
					div.setAttribute('class', 'inline-field')
					div.setAttribute('id', 'showpass_cbox')
					div.appendChild(inp)
					div.appendChild(lbl_1)

					var td_b2 = document.createElement('td')
					td_b2.setAttribute('id', 'header-col-pass')
					// var style = 'display: none;'
					// td_b2.setAttribute('style', style)
					td_b2.appendChild(div)

					var inp_su = document.createElement('button')
					inp_su.setAttribute('class', 'std gold')
					inp_su.setAttribute('id', 'signup_btn')
					inp_su.innerHTML = TXT['header']['word']['sign_up']

					if (APP_PLATFORM == 'des')
						inp_su.addEventListener('click', function() {window.open(CORELITE_URL + 'register', "Lanterlite", "resizable,scrollbars,status")})
					else
						inp_su.addEventListener('click', function() {window.open(CORELITE_URL + 'register')})

					var td_su = document.createElement('td')
					var style = ([
						'width: 50%;',
						'padding: 10px 0px 5px 5px'
					]).join(' ')
					td_su.setAttribute('style', style)
					td_su.setAttribute('id','header-col-signup-btn')
					// var style = 'display: none;'
					// td_su.setAttribute('style',style)
					td_su.appendChild(inp_su)

					var tr_e = document.createElement('tr')
					var tr_p = document.createElement('tr')
					// tr_a.appendChild(form)
					tr_e.appendChild(td_e)
					tr_p.appendChild(td_p)
					// tr_a.appendChild(td_si)
					var tbl_ep = document.createElement('table')
					var style = ([
						'width: 100%;'
					]).join(' ')
					tbl_ep.setAttribute('style', style)
					tbl_ep.appendChild(tr_e)
					tbl_ep.appendChild(tr_p)

					var tr_b = document.createElement('tr')
					// tr_b.appendChild(td_b1)
					// tr_b.appendChild(td_b2)
					// tr_b.appendChild(td_p)
					tr_b.appendChild(td_si)
					tr_b.appendChild(td_su)

					var tbl_b = document.createElement('table')
					var style = ([
						'width: 100%;'
					]).join(' ')
					tbl_b.setAttribute('style', style)
					tbl_b.appendChild(tr_b)

					var tbl = document.createElement('table')
					var style = ([
						'width: 100%;'
					]).join(' ')
					tbl.setAttribute('id', 'account')
					tbl.setAttribute('class', 'account')
					tbl.setAttribute('style', style)
					tbl.appendChild(tbl_ep)
					tbl.appendChild(tbl_b)

					var form = str_to_elm('<form action=""></form>')

					// form.setAttribute('id', 'signin_form')
					form.appendChild(tbl)
					$( form ).submit(function( event ) {
					  return false;
					});
					return form
				}
			}
		}
	
		function blank_col() {
			this.set = set

			function set() {
				var td_x = document.createElement('td')
				td_x.setAttribute('width', '100%')
			  document.querySelectorAll('.canvas .header table tr')[0].appendChild(td_x)
			}
		}
	
		function hide_when_scroll_on() {
			$(".canvas > .ctable > tr > td > .body").scroll(function() { //.box is the class of the div
				if (scrollPos > $(this).scrollTop()) {
			    document.querySelector("#canvas #header").style.top = TOP_HEIGHT.toString() + "px";
				}
				else {
					document.querySelector("#canvas #header").style.top = (TOP_HEIGHT-50).toString() + "px";
			    var dd = document.querySelector('.dropdown')
			    if (dd.className != 'dropdown') {
			    	L.header.account.close()
			    }
				}
					
				scrollPos = $(this).scrollTop()
			});

			// var prevScrollpos = window.pageYOffset;
			// window.onscroll = function() {
			// var currentScrollPos = window.pageYOffset;
			//   if (prevScrollpos > currentScrollPos) {
			//     document.querySelector("#canvas #header").style.top = TOP_HEIGHT.toString() + "px";
			//   } else {
			//     document.querySelector("#canvas #header").style.top = (TOP_HEIGHT-50).toString() + "px";
			//     var dd = document.querySelector('.dropdown')
			//     if (dd.className != 'dropdown') {
			//     	L.header.account.close()
			//     }
			//   }
			//   prevScrollpos = currentScrollPos;
			// }
		}
	}

	/* ================================================
	SIDEBAR
	================================================ */
	function sidebar() {
		this.set = set
		this.is_opened = is_opened
		this.open = open
		this.close = close
		this.img = img
		this.img_click = img_click
		this.add = add
		this.remove = remove
		this.content_hide = content_hide
		this.content_show = content_show
		this.change_titles = change_titles
		this.is_exist = is_exist

		function is_opened() {
			var sidebar = document.querySelector('div.sidebar')
			if (sidebar.className == 'sidebar open')
				return true
			else
				return false
		}

		function open() {
			var sidebar = document.querySelector('div.sidebar')
			sidebar.className = 'sidebar open'
			document.querySelector('div.bg.dark').style.display = ''
			disable_canvas_scroll();
		}

		function close() {
			var sidebar = document.querySelector('div.sidebar')
			sidebar.className = 'sidebar'
			document.querySelector('div.bg.dark').style.display = 'none'
			enable_canvas_scroll();
		}

		function img(src) {
			if (src === undefined)
				src = BASE_URL + "assets/lite.img/lanterlite-new.png"
			var img = document.createElement('img')
			img.src = src
			document.querySelectorAll('#sidebar #header')[0].appendChild(img)
		}

		function content_hide(id) {
			var content = document.querySelector('#sidebar #'+id)
			content.style.display = 'none'
		}

		function content_show(id) {
			var content = document.querySelector('#sidebar #'+id)
			content.style.display = ''
		}

		function change_titles(titles) {
			if (is_exist) {
				var menu_bar = document.querySelectorAll('.sidebar .menu-bar')
				for (var i=0; i<menu_bar.length; i++) {
					menu_bar[i].innerHTML = titles[i]['title']
				}
			}
		}

		function is_exist() {
			return is_exist('.sidebar')
		}

		function remove() {
			clear_content('.sidebar')
			clear_content('.bg.dark')
		}

		function add(obj) {
			var content = document.createElement('a')
			content.setAttribute('id', obj['id'])
			content.setAttribute('class', 'menu-bar')
			content.innerHTML = obj['title']
			content.addEventListener('click', function(e) {
				obj['callback'](e.target)
				// sidebar_callback(obj['callback'],e.target)
			})

			var td = document.createElement('td')
			td.appendChild(content)

			var tr = document.createElement('tr')
			tr.appendChild(td)

			document.querySelector('#sidebar #body').appendChild(tr)
		}

		function img_click(func) {
			if (func === undefined) 
				func = function() { change_page_by_url(HOME_URL) }

			var header = document.querySelector('#sidebar #header')
			header.addEventListener('click', func) 
		}

		function set() {
			// var tbl = createMenuBarVertical(obj, callback)

			var header = document.createElement('div')
			header.setAttribute('class', 'header')
			header.setAttribute('id', 'header')

			var tbl = document.createElement('table')
			tbl.setAttribute('class', 'body')
			tbl.setAttribute('id', 'body')

			var sidebar = document.createElement('div')
			sidebar.appendChild(header)
			sidebar.appendChild(tbl)
			sidebar.setAttribute('class', 'sidebar')
			sidebar.setAttribute('id', 'sidebar')
			$(sidebar).css({'top': TOP_HEIGHT.toString()+'px'})

			var bg = document.createElement('div')
			bg.setAttribute('class', 'bg dark')
			// style = "background-color: black;"
			style = "opacity: 0.5;"
			style += "display: none;"
			bg.setAttribute('style',style)
			bg.addEventListener('click', function() {
				var sidebar = document.querySelector('div.sidebar')
				if (sidebar.className == 'sidebar') {
					L.sidebar.open()
					// sidebar.className = 'sidebar open'
					// document.querySelector('div.bg.dark').style.display = ''
					// document.querySelector("html").style.overflow = "hidden";
				}
				else {
					L.sidebar.close()
					// sidebar.className = 'sidebar'
					// document.querySelector('div.bg.dark').style.display = 'none'
					// document.querySelector("html").style.overflow = "auto";
				}
			})

			var canvas = document.querySelector('#canvas #header')
			canvas.appendChild(sidebar)
			canvas.appendChild(bg)
			L.sidebar.img_click()
		}
	}

	/* ======================================
	MOVE TOP BUTTON
	====================================== */
	function mtbutton() {
		this.set = set
		this.on = on

		function set() {
			// <a id="back2Top" title="Back to top" href="#"></a>
			var a = document.createElement('a')
			a.setAttribute('id', 'back2Top')
			a.setAttribute('title', 'Back to top')
			a.innerHTML = "&#10148"
			a.setAttribute('href', '#')

			var canvas = document.querySelector('.canvas')
			canvas.appendChild(a)
		}

		function on() {
			$(".canvas > .ctable > tr > td > .body").scroll(function() {
			// $(window).on('scroll', function() {  
		    var height = $(".canvas > .ctable > tr > td > .body").scrollTop();
		    // var height = $(window).scrollTop();
		    if (height > 100) {
	        $('#back2Top').fadeIn();
		    } else {
	        $('#back2Top').fadeOut();
		    }
			});
			$(document).ready(function() {
		    $("#back2Top").click(function(event) {
	        event.preventDefault();
	        $(".canvas > .ctable > tr > td > .body").animate({ scrollTop: 0 }, "slow");
	        // $("html, body").animate({ scrollTop: 0 }, "slow");
	        return false;

					// $(".canvas > .ctable > tr > td > .body").scroll(function() { //.box is the class of the div
					// 	if (scrollPos > $(this).scrollTop()) {
					//     document.querySelector("#canvas #header").style.top = TOP_HEIGHT.toString() + "px";
					// 	}
					// 	else {
					// 		document.querySelector("#canvas #header").style.top = (TOP_HEIGHT-50).toString() + "px";
					//     var dd = document.querySelector('.dropdown')
					//     if (dd.className != 'dropdown') {
					//     	L.header.account.close()
					//     }
					// 	}
							
					// 	scrollPos = $(this).scrollTop()
					// });

		    });
			});
		}
	}
	
	/* =============================================
	SNACKBAR 
	============================================= */
	function snackbar() {
		this.set = set
		this.close = close
		this.open = open

		function set() {
			var snackbar = document.createElement('div')
			snackbar.setAttribute('id', 'snackbar')
			snackbar.setAttribute('class', 'snackbar')
			$(snackbar).fadeOut(1)

			var canvas = document.querySelector('#canvas')
			canvas.appendChild(snackbar)
		}

		function close() {
		  var snackbar = document.getElementById("snackbar");
			$(snackbar).fadeOut()
		  setTimeout(function(){ 
				snackbar.className = snackbar.className.replace(" show", ""); 
				clear_content('#snackbar div')
		  }, 300);
		}

		function open(str, class_name, nolimit) {
			if (str === undefined) {str = ''}
			if (class_name === undefined) {class_name = 'def'}
			if (nolimit === undefined) {nolimit = false}

		  var snackbar = document.getElementById("snackbar");
			if (snackbar.className != "snackbar show") {
			  var div = document.createElement('div')
			  div.setAttribute('class', 'bar ' +class_name)
			  div.innerHTML = str
			  snackbar.appendChild(div);
			  $(snackbar).fadeIn()
			  snackbar.className = snackbar.className + " show";
			  if (!nolimit) {
				  setTimeout(function(){ 
				  	close()
				  }, 3000);
			  }
			  else {
  				var bg = document.createElement('div')
					bg.setAttribute('class', 'bg gen')
					// style = "background-color: black;"
					style = "opacity: 0.5;"
					bg.setAttribute('style',style)
					bg.addEventListener('click', function() {
				  	close()
				  	clear_content('.bg.gen')
					})

					var canvas = document.querySelector('#canvas')
					canvas.appendChild(bg)
			  }
			}
		}
	}

	/* ===============================================
	FLOATING CANVAS
	=============================================== */
	function fcanvas() {
		this.set = set
		this.title = title
		this.add = add
		this.open = open
		this.close = close
		this.is_opened = is_opened

		function is_opened() {
			var elm = document.querySelector('.fcanvas')
			if (elm.className == 'fcanvas open')
				return true
			else
				return false
		}

		function close() {
			enable_canvas_scroll();
			$('#fcanvas').fadeOut(150)
			$('#fcanvas').removeClass('open')
			clear_content('#fcanvas #body #content')
		}

		function open(is_large) {
			if (is_large === undefined) 
				is_large = false
			if (is_large) {
				$('#fcanvas #main').css({'top': (TOP_HEIGHT+5).toString()+'px'})
				$('#fcanvas #main').removeClass('small').addClass('large')
				$('#fcanvas #body').removeClass('small').addClass('large')
			}
			else {
				$('#fcanvas #main').css({'top': (TOP_HEIGHT+75).toString()+'px'})
				$('#fcanvas #main').removeClass('large').addClass('small')
				$('#fcanvas #body').removeClass('large').addClass('small')
			}
		  setTimeout(function(){
				disable_canvas_scroll();
		  },150);
			$('#fcanvas').fadeIn(150)
			$('#fcanvas').addClass('open')
		}

		// function content_scrollbar(elm) {
		// 	var container = document.createElement('div')
		// 	container.setAttribute('class', 'container')
		// 	container.appendChild(elm)

		// 	var content = document.createElement('div')
		// 	content.setAttribute('class', 'content scrollbar')
		// 	content.setAttribute('data-msc-theme', 'minimal-dark')
		// 	content.setAttribute('style', 'overflow: visible;')
		// 	content.appendChild(container)
		// 	return content
		// }

		// function fcanvas_body_xscroll_enable() {
		// 	var body = document.querySelector('#fcanvas #body')
		// 	$(body).css({'overflow-x': 'auto'})	
		// }

		function add(elm) {
			if (!is_exist('#fcanvas #body #content')) {
				var div = document.createElement('div')
				div.setAttribute('class', 'content')
				div.setAttribute('id', 'content')
				div.appendChild(elm)

				var canvas = document.querySelector('#fcanvas #body')
				canvas.appendChild(div)	
			}
			else {
				var div = document.querySelector('#fcanvas #body #content')
				div.appendChild(elm)
			}
		}

		function title(str) {
			var fcanvas = document.querySelector('#fcanvas #title')
			fcanvas.innerHTML = str
		}

		function set() {
			var td_h1 = document.createElement('td')
			style = 'width: 100px;'
			style += 'padding: 10px;'
			style += 'color: goldenrod;'
			td_h1.setAttribute('style',style)
			td_h1.innerHTML = '(logo)'
			
			var td_h2 = document.createElement('td')
			style = 'width: 100%;'
			style += 'padding: 10px;'
			style += 'color: goldenrod;'
			td_h2.setAttribute('style',style)
			td_h2.setAttribute('id', 'title')
			td_h2.setAttribute('class', 'title')
			
			var td_h3 = document.createElement('td')
			style = 'width: 100%;'
			style += 'padding: 10px;'
			style += 'color: goldenrod;'
			td_h3.setAttribute('style',style)

			var td_h4 = document.createElement('td')
			style = 'width: 100px;'
			style += 'padding: 10px;'
			style += 'color: goldenrod;'
			td_h4.setAttribute('style',style)
			td_h4.setAttribute('class','close')
			td_h4.setAttribute('id','close')

			var img_path = BASE_URL + "assets/lite.img/close.svg"
			var img = document.createElement('img')
			img.src = img_path

			td_h4.appendChild(img)
			img.addEventListener('click', function() {L.fcanvas.close()})

			var td_body = document.createElement('td')

			var tr_header = document.createElement('tr')
			// tr_header.appendChild(td_h1)
			tr_header.appendChild(td_h2)
			tr_header.appendChild(td_h3)
			tr_header.appendChild(td_h4)
			style = ''
			style += 'background-color: #1a1a1a;'
			tr_header.setAttribute('style', style)

			var tr_body = document.createElement('tr')
			tr_body.appendChild(td_body)

			var tbl = document.createElement('table')
			tbl.setAttribute('class', 'header')
			tbl.setAttribute('id', 'header')
			tbl.appendChild(tr_header)
			// tbl.appendChild(tr_body)

			var body_div = document.createElement('div')
			// body_div.setAttribute('class', 'body')
			$(body_div).addClass('body')
			$(body_div).addClass('theme_bgclr_main1')
			body_div.setAttribute('id', 'body')

			var div = document.createElement('div')
			// div.setAttribute('class', 'main')
			div.setAttribute('id', 'main')
			$(div).addClass('main')
			$(div).addClass('theme_bgclr_main1')
			div.appendChild(tbl)
			div.appendChild(body_div)

			var bgcanvas = document.createElement('div')
			style = ''
		  style += "position: fixed;"
		  style += "width: 100%;"
		  style += "z-index: 9;"
		  style += "height: 100%;"
			style += 'opacity: 0.5;'
			style += 'background-color: black;'
		  style += "top: 0px;"
			bgcanvas.setAttribute('class', 'bg fcanvas')
			bgcanvas.setAttribute('style', style)
			bgcanvas.addEventListener('click', function() {
				L.fcanvas.close()
				// var dd = document.querySelector('div.dropdown')
				// if (dd.className == 'dropdown') {
				// 	L.fcanvas.open()
				// }
				// else {
				// 	L.fcanvas.close()
				// }
			})
			// bgcanvas.style.display = 'none'

			var canvas = document.createElement('div')
			style = ''
			style += 'display: none;'
			canvas.setAttribute('style', style)
			canvas.setAttribute('class', "fcanvas")
			canvas.setAttribute('id', "fcanvas")
			canvas.appendChild(div)
			canvas.appendChild(bgcanvas)
			// canvas.style.display = 'none'

			var body = document.querySelector('body')
			body.appendChild(canvas)
			// body.appendChild(bgcanvas)
		}
	}

	/* ========================================
	TOGGLE
	======================================== */
	function toggle() {
		this.create = create
		this.title = title
		this.changed = changed
		this.checked = checked

		function create(id) {

			var input = document.createElement('input')
			input.setAttribute('type', 'checkbox')
			input.setAttribute('name', 'switch')

			var span2 = document.createElement('span')
			span2.setAttribute('class', 'switch-style')

			var label = document.createElement('label')
			label.setAttribute('class', 'switch')
			label.appendChild(input)
			label.appendChild(span2)

			var td1 = document.createElement('td')
			td1.setAttribute('id', 'title')
			td1.setAttribute('class', 'title')

			var td2 = document.createElement('td')
			td2.appendChild(label)

			var tr = document.createElement('tr')
		  tr.setAttribute('class', 'transparent')
			tr.appendChild(td1)
			tr.appendChild(td2)

			var table = document.createElement('table')
			table.appendChild(tr)

			var div = document.createElement('div')
			div.setAttribute('class', 'toggle theme_clr_text1 ff_general ' + id)
			div.setAttribute('id', 'toggle')
			div.appendChild(table)

			return div
		}

		function title(id, str) {
			var title = document.querySelector('#toggle.'+id+' #title')
			title.innerHTML = str
		}

		function changed(id, func) {
		  var defer = $.Deferred()
			var input = document.querySelector('#toggle.'+id+' input')
			input.addEventListener('click', function (e) {
		    var is_checked = e.target.checked
				defer.resolve(is_checked)
		  })

			when_on()
			function when_on() {
				$.when( defer ).done(function (is_checked) {
					defer = $.Deferred()
					when_on()
					setTimeout( func(is_checked), 5 )
				})		
			}
		}

		function checked(id, is_checked) {
			var input = document.querySelector('#toggle.'+id+' input')
			input.checked = is_checked
		}

	}

	/* ========================================
	CHECKBOX
	======================================== */
	function checkbox() {
		this.create = create
		this.title  = title
		this.click = click
		this.checked = checked
		this.is_checked = is_checked
		this.swap = swap

		function create(id) {

  		var inp = document.createElement('input')
  		inp.setAttribute('class', 'inp-cbx')
  		inp.setAttribute('id', 'cbx')
  		inp.setAttribute('type', 'checkbox')
  		inp.setAttribute('style', 'display:none;')

  		var lbl = document.createElement('label')
  		lbl.setAttribute('class', 'cbx')
  		lbl.setAttribute('for', 'cbx')

  		var span1 = document.createElement('span')
  		span1.className = 'svg'
  		span1.id = 'svg'

  		var span2 = document.createElement('span')
  		span2.className = 'title theme_clr_text1 ff_general'
  		span2.id = 'title'
  		span2.innerHTML = 'title'
  		
  		lbl.appendChild(span1)
  		// lbl.appendChild(span2)

  		var td1 = document.createElement('td')
  		td1.appendChild(inp)
  		td1.appendChild(lbl)

  		var td2 = document.createElement('td')
  		td2.setAttribute('style', 'width: 110px;')
  		td2.appendChild(span2)

  		var tr = document.createElement('tr')
  		tr.setAttribute('style', 'background-color: transparent;')
  		tr.appendChild(td1)
  		tr.appendChild(td2)

  		var tbl = document.createElement('table')
  		tbl.appendChild(tr)

  		var div = document.createElement('div')
  		div.setAttribute('class', 'checkbox ' + id)
  		div.setAttribute('id', id)
  		div.appendChild(tbl)
  		// div.appendChild(inp)
  		// div.appendChild(lbl)
  		// div.appendChild(span2)

  		return div
		}
		
		function title(obj, title) {
			allDescendants(obj)
			function allDescendants (node) {
		    for (var i = 0; i < node.childNodes.length; i++) {
		      var child = node.childNodes[i];
		      allDescendants(child);
					if (child.id == "title") {
			      child.innerHTML = title;
			      break;
			    }
		    }
			}
		}

		// function set_id(obj, id) {
		// 	obj.className = obj.className + ' ' + id
		// }

		// function set_class(obj, class_name) {
		// 	obj.className = obj.className + ' ' + class_name
		// }

		function click(obj, callback) {
			allDescendants(obj)
			function allDescendants (node) {
		    for (var i = 0; i < node.childNodes.length; i++) {
		      var child = node.childNodes[i];
		      allDescendants(child);
			    if (child.nodeName == "INPUT") {
			      add_event(child)
			      break;
			    }        
		    }
			}

			function add_event(node) {
				node.addEventListener('click', function() {
					// var cbx = document.querySelector('.container input')
					if (node.checked) {
						$(document.querySelector('.cbx svg')).fadeIn(1)
					}
					else {
						$(document.querySelector('.cbx svg')).fadeOut(1)
					}
					callback(node.checked)
				})
			}
		}

		function checked(obj, is_checked) {
			allDescendants(obj)
			function allDescendants (node) {
		    for (var i = 0; i < node.childNodes.length; i++) {
		      var child = node.childNodes[i];
		      allDescendants(child);
					if (child.nodeName == "INPUT") {
			      child.checked = is_checked
						asd(is_checked)
			      break;
			    }
		    }
			}

			function asd(checked) {
				$.when( get_svg(name='check', id='white', is_str=true) ).done(function(svg){
					allDescendants(obj)
					function allDescendants (node) {
				    for (var i = 0; i < node.childNodes.length; i++) {
				      var child = node.childNodes[i];
				      allDescendants(child);
							if (child.className == "svg") {
								var icon = str_to_elm(svg)
								icon.setAttribute('class', 'white')
								$(icon).css ({
							    'height': '18px',
							    'width': '18px',
							    'top': '0',
							    'left': '0',
								})
								child.appendChild(icon)
								if (checked) 
									$(icon).fadeIn(1)
								else
									$(icon).fadeOut(1)
					      break;
					    }
				    }
					}
				});
			}
		}

		function is_checked(obj) {
			allDescendants(obj)
			function allDescendants (node) {
		    for (var i = 0; i < node.childNodes.length; i++) {
		      var child = node.childNodes[i];
		      allDescendants(child);
					if (child.nodeName == "INPUT") {
			      return child.checked;
			      break;
			    }
		    }
			}
		}

		function swap(obj) {
			var tr = obj.childNodes[0].childNodes[0]
			$(tr.childNodes[0]).before($(tr.childNodes[1]));
		}

		function swap2(obj) {
		$(obj.childNodes[0]).before($(obj.childNodes[1]));
			allDescendants(obj)
			function allDescendants (node) {
		    for (var i = 0; i < node.childNodes.length; i++) {
		      var child = node.childNodes[i];
		      allDescendants(child);
					if (child.className == "cbx") {
						$(child.childNodes[0]).before($(child.childNodes[1]));
			      break;
			    }
		    }
			}
		}


		// function create2() {
		// 	var inp = document.createElement('input')
		// 	inp.setAttribute('type', 'checkbox')			

		// 	var span = document.createElement('span')
		// 	span.setAttribute('class', 'checkmark')

		// 	var label = document.createElement('div')
		// 	label.setAttribute('id', 'title')
		// 	label.setAttribute('class', 'title')

		// 	var cont = document.createElement('label')
		// 	cont.setAttribute('class', 'container')
		// 	// cont.appendChild(label)
		// 	cont.appendChild(inp)
		// 	cont.appendChild(span)
			
		// 	// var td1 = document.createElement('td')
		// 	// td1.setAttribute('id', 'title')
		// 	// td1.setAttribute('class', 'title')
		// 	// td1.appendChild(label)

		// 	// var td2 = document.createElement('td')
		// 	// td2.setAttribute('id', 'box')
		// 	// td2.setAttribute('class', 'box')
		// 	// td2.appendChild(cont)

		// 	// var tr = document.createElement('tr')
		//  //  tr.setAttribute('class', 'row transparent')
		//  //  tr.setAttribute('id', 'row')
		// 	// tr.appendChild(td1)
		// 	// tr.appendChild(td2)

		// 	// var table = document.createElement('table')
		// 	// table.appendChild(tr)

		// 	// var div = document.createElement('div')
		// 	// div.appendChild(label)
		// 	// div.appendChild(cont)

		// 	var checkbox = document.createElement('div')
		// 	checkbox.setAttribute('id', 'checkbox')
		// 	checkbox.setAttribute('class', 'checkbox')
		// 	// if (id === undefined)
		// 	// 	checkbox.setAttribute('class', 'checkbox')
		// 	// else
		// 	// 	checkbox.setAttribute('class', 'checkbox')
		// 	// checkbox.appendChild(div)
		// 	checkbox.appendChild(label)
		// 	checkbox.appendChild(cont)


		// 	return checkbox
		// }
	}

	/* ========================================
	FLOATING BUTTON
	======================================== */
	function fbutton() {
		this.set = set
		this.is_opened = is_opened
		this.open = open
		this.close = close
		this.add = add

		function set() {
			var tr = document.createElement('tr')

			var tbl = document.createElement('table')
			tbl.appendChild(tr)

			var fbtn = document.createElement('div')
			fbtn.setAttribute('class', 'fbutton')
			fbtn.appendChild(tbl)

			
			// var bg = document.createElement('div')
			// bg.setAttribute('class', 'bg dark')
			// // style = "background-color: black;"
			// style = "opacity: 0.5;"
			// style += "display: none;"
			// bg.setAttribute('style',style)
			// bg.addEventListener('click', function() {
			// })

			var bg = document.createElement('div')
			bg.setAttribute('class', 'bg transparent')
			bg.style.display = 'none'
			bg.addEventListener('click', function() {
				var fbutton = document.querySelector('div.fbutton')
				if (fbutton.className == 'fbutton') {
					fbutton.className = 'fbutton open'
					document.querySelector('div.bg.transparent').style.display = ''
					document.querySelector("html").style.overflow = "hidden";
				}
				else {
					fbutton.className = 'fbutton'
					document.querySelector('div.bg.transparent').style.display = 'none'
					document.querySelector("html").style.overflow = "auto";
				}
				close()
			})

			var canvas = document.querySelector('.canvas')
			canvas.appendChild(fbtn)
			canvas.appendChild(bg)
		}

		function is_opened() {
			var elm = document.querySelector('.fbutton')
			if (elm.className == 'fbutton open')
				return true
			else
				return false
		}

		function open() {
			var fbtn = document.querySelector('.fbutton')
			fbtn.className = 'fbutton open'
			document.querySelector('div.bg.transparent').style.display = ''
		}

		function close() {
			var fbtn = document.querySelector('.fbutton')
			fbtn.className = 'fbutton';
			document.querySelector('div.bg.transparent').style.display = 'none'
		}

		function add (obj) {
			var btn = document.createElement('div')
			$.when( get_svg(obj['icon'], 'white') ).done(function(svg){
				btn.appendChild(svg)
			});

			// var svg = get_svg(obj['icon'], 'asd')
			// console.log(svg)
			// btn.appendChild(get_svg(obj['icon'], 'asd'))
			// btn.innerHTML = obj['title']
			btn.setAttribute('class', 'btn ' + obj['id'])
			btn.addEventListener('click', function() {
				obj['callback']()
			})

			var td = document.createElement('td')
			td.appendChild(btn)

			var tr = document.querySelector('.fbutton > table > tr')
			tr.appendChild(td)
		}
	}

	/* ========================================
	SPLASH SCREEN
	======================================== */
	function splash() {
		this.set = set
		this.open = open
		this.close = close
		this.elm = ''

		function set(appname) {
			var logo = '<div class="splash" id="splash" display="none">'+
				'<div>'+
					'<div style="background: url(' + BASE_URL + 'assets/lite.img/goldenrod.svg) center center / 100% 100% no-repeat;    width: 75px; height: 75px; margin-right: 0px; display: inline-block; vertical-align: middle;" >'+
					// '<div style="background-image: url(' + BASE_URL + 'assets/lite.img/goldenrod.svg);">'+
					'</div>'+
					// '<div>'+
					// 	'<img src="'+BASE_URL+'assets/lite.img/goldenrod.svg">'+
					// 	'</img>'+
					// '</div>'+
					'<div style="display: inline-block; color: goldenrod; font-size: 50px; font-family: Libre Baskerville; vertical-align: middle;">'+
						'<span>'+APP_NAME+'</span>'+
					'</div>'+
				'</div>'+
			'</div>'
			// var logo = '<div id="bg_loader"> <div id="loader"> <svg class="loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 46 33"> <g stroke-width="1" fill="none" fill-rule="evenodd"> </g> </svg> </div> </div>'
			logo = str_to_elm(logo)
			this.elm = logo
			// logo.childNodes[1].childNodes[1].style = "background-image: url('" + BASE_URL + "assets/lite.img/goldenrod.svg');"
			document.querySelector('.canvas').appendChild(logo)
		}

		function open() {
			$(L.splash.elm).fadeIn()
		}

		function close() {
			$(L.splash.elm).fadeOut()
		}
	}

	/* ========================================
	LOADING
	======================================== */
	function loading() {
		this.set = set
		this.open = open
		this.close = close

		function open() {
			$('#loading').fadeIn()
		}

		function close() {
			$('#loading').fadeOut()
		}

	// 	function set() {
	// 		var loader = document.createElement('div')
	// 		loader.setAttribute('class', 'loader')

	// 		for (var i=0; i<4; i++) {
	// 			var circle = document.createElement('div')
	// 			circle.setAttribute('class', 'splash-circle')
	// 			circle.innerHTML = '&nbsp;'
	// 			loader.appendChild(circle)
	// 		}

	// 		var splash = document.createElement('div')
	// 		splash.setAttribute('class', 'splash')
	// 		splash.appendChild(loader)

	// 		var loading = document.createElement('div')
	// 		loading.setAttribute('class', 'loading')
	// 		loading.setAttribute('id', 'loading')
	// 		loading.appendChild(splash)

	// 		document.querySelector('.canvas').appendChild(loading)
	// 		$(loading).fadeOut()
	// 	}

		function set() {
			// var elm = "<div class='lds-ellipsis'><div></div><div></div><div></div><div></div></div>"
			var elm = '<div class="loading" id="loading"> <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>'
			// var elm = '<div class="loading spinner" id="loading"> <div class="dot1"></div> <div class="dot2"></div> </div>'
			elm = str_to_elm(elm)
			elm.style.display = 'none'

			// var loading = document.createElement('div')
			// loading.setAttribute('class', 'loading2')
			// loading.setAttribute('id', 'loading2')
			// loading.appendChild(elm)

			document.querySelector('.canvas').appendChild(elm)
			$(elm).fadeOut()
			// document.querySelector('.canvas').appendChild(elm)
			// $(loading).fadeOut()
		}

	}		
	/* ========================================
	RANGE SLIDER
	======================================== */
	function rslider() {
		this.title = title
		this.min = min
		this.max = max
		this.val = val
		this.move = move
		this.create = create

		function title(id, string) {
		  document.querySelector('#rslider #'+id+' #title').innerHTML = string
		}

		function min(id, value) {
		  document.querySelector('#rslider #'+id+' input#bar').setAttribute('min', value)
		}

		function max(id, value) {
		  document.querySelector('#rslider #'+id+' input#bar').setAttribute('max', value)
		}

		function val(id, value) {
		  document.querySelector('#rslider #'+id+' input#bar').value = value
		  document.querySelector('#rslider #'+id+' span#value').innerHTML = value
		}

		function move(id, func) {
			var defer = $.Deferred()
		  var input = document.querySelector('#rslider #'+id+' input#bar')
		  input.addEventListener('mouseup', function() {
		  	// document.querySelector('#rslider #'+id+' #value').innerHTML = this.value
				// callback(this.value)
		  })
		  input.addEventListener('input', function() {
		  	document.querySelector('#rslider #'+id+' #value').innerHTML = this.value
				defer.resolve(this.value)
				// on()
		  })

		  // on() {
		  // 	if
		  // }
			when_on()
			function when_on() {
				$.when( defer ).done(function (value) {
					defer = $.Deferred()
					when_on()
					value = document.querySelector('#rslider #'+id+' #value').innerHTML
					func(value)
				})		
			}
		}

		function create(id) {
		  var input = document.createElement('input')
		  // input.setAttribute('id', 'arabic_size')
		  input.setAttribute('class', 'bar')
		  input.setAttribute('id', 'bar')
		  input.setAttribute('type', 'range')
		  
		  var span_size = document.createElement('span')
		  span_size.setAttribute('id', 'size')
		  span_size.innerHTML = TXT["page"]["word"]["size"]

		  var span_semicolon = document.createElement('span')
		  span_semicolon.innerHTML = ": "

		  var span_value = document.createElement('span')
		  span_value.setAttribute('id', 'value')

		  var div_span = document.createElement('p')
		  $(div_span).addClass('theme_clr_text1')
		  // div_span.appendChild(span_size)
		  // div_span.appendChild(span_semicolon)
		  div_span.appendChild(span_value)

		  var div = document.createElement('div')
		  div.setAttribute('class', 'bar')
		  div.setAttribute('id', 'bar')
		  div.appendChild(input)
		  // div.appendChild(p)

		  var td_option = document.createElement('td')
		  td_option.appendChild(div)

		  var div = document.createElement('div')
		  style = ''
		  style += 'padding: 0px 10px;'
		  div.setAttribute('style', style)
		  div.appendChild(div_span)

		  var td_3 = document.createElement('td')
		  td_3.appendChild(div)

		  var td_title = document.createElement('td')
		  td_title.setAttribute('id', 'title')
		  td_title.setAttribute('class', 'title')

		  var tr = document.createElement('tr')
		  tr.setAttribute('class', 'transparent')
		  tr.appendChild(td_title)
		  tr.appendChild(td_option)
		  tr.appendChild(td_3)

		  // var table = document.querySelector('.opt_canvas table.options')
		  var table = document.createElement('table')
		  table.setAttribute('id', id)
		  table.appendChild(tr)

		  var rslider = document.createElement('div')
		  rslider.setAttribute('id', 'rslider')
		  rslider.setAttribute('class', 'rslider theme_clr_text1 ff_general')
		  rslider.appendChild(table)
		  return rslider
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

	function rbutton() {
		this.title = title
		this.create = create
		this.change = change
		this.get = get

		function title(obj, title) {
			obj.childNodes[1].innerHTML = title
		}

		function get(id) {
			var rbtn = document.querySelector('.rbutton.' + id)
			return rbtn
		}

		function create(obj) {
			var input = document.createElement('input')
			input.setAttribute('id', obj['id'])
			input.setAttribute('name', 'radio ' + obj['group'])
			input.setAttribute('type', 'radio')
			if (obj['is_checked'])
				input.checked = true
			if (obj['is_disabled'])
				input.disabled = true
			
			input.value = obj['value']

			var label = document.createElement('label')
			label.setAttribute('for', obj['id'])
			label.setAttribute('class', 'radio-label theme_clr_text1')
			label.innerHTML = obj['title']

			var radio = document.createElement('div')
			// radio.setAttribute('class', 'rbutton')
			radio.setAttribute('class', 'rbutton ' + obj['id'])
			radio.appendChild(input)
			radio.appendChild(label)

			return radio
		}

		function change(obj, func) {
			// $(obj.childNodes[0]).before($(obj.childNodes[1]));
			// allDescendants(obj)
			// function allDescendants (node) {
		 //    for (var i = 0; i < node.childNodes.length; i++) {
		 //      var child = node.childNodes[i];
		 //      allDescendants(child);
		 //      console.log(child)
			// 		if (child.className == "cbx") {
			// 			$(child.childNodes[0]).before($(child.childNodes[1]));
			//       break;
			//     }
		 //    }
			// }
			obj.childNodes[0].addEventListener('change', function() {
				func(this.value)
			})
		}
	}
}



	

	

/* ========================================

FUNCTIONS

======================================== */

function get_svg(name, id, is_str) {
	if (is_str === undefined)
		is_str=false
	var def = $.Deferred()
	var svg = ''
	var file_path = BASE_URL + './assets/lite.icon/icons/' + name + '.svg'
	read_svg(file_path, function(svg_str) {
		if (!is_str) {
			svg = str_to_elm(svg_str)
			svg.setAttribute('class', id)
			def.resolve(svg)
		}
		else {
			def.resolve(svg_str)
		}
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

function str_to_elm(htmlString) {
  var div = document.createElement('div');
  div.innerHTML = htmlString.trim();

  // Change this to div.childNodes to support multiple top-level nodes
  return div.firstChild; 
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

function json_save(file_dir, file_name, obj, callback) {
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
  	xhr.setRequestHeader(FUNC_NAME, 'json_save');
  	xhr.setRequestHeader(FILE_DIR, file_dir);
  	xhr.setRequestHeader(FILE_NAME, file_name);
  }
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
    success: function(obj) { callback(obj); },
    error: function(e) { callback(e.responseText); }
	});  
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

function json_save_to_php(file_dir, obj, callback) {
  var data = { "Data" : obj };
	$.ajax({
	    type: "POST",
	    url: BASE_URL + "lanterlite.gen.php",
	    data: JSON.stringify(data),
	    contentType: "application/json;",
	    dataType: "json",
      beforeSend: header_set,
      success: function(obj) { callback(obj); },
      error: function(e) {callback(e.responseText)}
      // error: function(e) { console.log(e.responseText); }
	});

  function header_set(xhr) { 
  	xhr.setRequestHeader(FUNC_NAME, 'json_to_php');
  	xhr.setRequestHeader(FILE_DIR, file_dir);
  }
}

function json_read_local(file_path, callback) {
	$.ajax({
    type: "GET",
    url: file_path,
    contentType: "application/json;",
    dataType: "json",
    success: function(obj) { callback(obj); },
    // error: function(e) {}
    error: function(e) { callback(e.responseText); }
	});  
}

function json_read(file_dir, file_name, callback) {
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
  	xhr.setRequestHeader(FUNC_NAME, 'json_read');
  	xhr.setRequestHeader(FILE_DIR, file_dir);
  	xhr.setRequestHeader(FILE_NAME, file_name);
  }
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

function str_to_json(string, parser) {
	return string.split(parser);
}


function str_split(str, splitter) { return str.split(splitter); }


function clean_str(string) {
  var str = string.toLowerCase()
  str = str.replace(/<i>/gi, '');
  str = str.replace(/<\/i>/gi, '');
  str = str.replace(/<b>/gi, '');
  str = str.replace(/<\/b>/gi, '');
  str = str.replace(/[^A-Za-z0-9\s-]/gi, '');
  return str;
}

function is_str_in_array(arr, str) {
	return arr.indexOf(str.toLowerCase()) > -1;
}

function is_int_in_array(arr, int) {
	return arr.includes(int);
}

function str_in_array_index(arr, str) {
	return arr.indexOf(str.toLowerCase());
}

function is_obj_in_arr(arr, obj) {
  var i;
  var found = false;
  for (i = 0; i < arr.length; i++) {
    if (JSON.stringify(arr[i]) === JSON.stringify(obj)) {
    	found = true;
      return true;
    }
    else {
	    if (i == (arr.length-1) && found) {
			  return false;
	    }
    }
  }
}


function is_exist(query) {
	if ($(query).length > 0)
	  return true
	else
		return false
}

function is_exist_arr_index(array, index) {
	if(typeof array[index] === 'undefined') {
    return false
	}
	else {
		return true
	}
}

//HOW TO USE: index = is_exist_arr_val.call(myArray, needle); // true
function is_exist_arr_val(arr, val) {
	return is_exist_arr_val2.call(arr, val)
	function is_exist_arr_val2(needle) {
	    var findNaN = needle !== needle;
	    var indexOf;

	    if(!findNaN && typeof Array.prototype.indexOf === 'function') {
	        indexOf = Array.prototype.indexOf;
	    } else {
	        indexOf = function(needle) {
	            var i = -1, index = -1;

	            for(i = 0; i < this.length; i++) {
	                var item = this[i];

	                if((findNaN && item !== item) || item === needle) {
	                    index = i;
	                    break;
	                }
	            }

	            return index;
	        };
	    }
	    return indexOf.call(this, needle) > -1;
	};
}

function is_exist_json_key(json, key) {
	if(json.hasOwnProperty(key))
		return true
	else
		return false
}

function is_key_exist_in_json_arr (json, str) {
	for (var i=0; i<json.length; i++) {
		if (json[i]['word'].toLowerCase() == str.toLowerCase()) {
			return true;
		}
		else if (i==json.length-1) {
			return false;
		}
	}
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

function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

function arr_val_rmv(arr, value) {
	var index = arr.indexOf(value);
	if (index !== -1) arr.splice(index, 1);
   // return arr.filter(function(ele){
   //     return ele != value;
   // });
}

function functions() {
	this.arr = new arr()
	this.amp = new amp()
	
	function amp() {
		this.create_page = create_page
		
		function create_page() {
			$.when(
			  $.getScript( FE_BASE_URL + 'assets/'+APP_CODENAME+'/js/'+PAGE_CODENAME+'.js' ),
			  $.Deferred(function( deferred ){$( deferred.resolve );})
			).done(function(){});
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

function str_to_list(str) {
	return str.split('')
}

function str_parse_by(str, parser) {
	return str.split(parser)
}

function str_get_last_str(str, total) {
	str.substr(str.length - total);
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

function completeHadith(obj) {
	var id = obj['id'].split('.')
	if (id[0] == 'BM') {
		obj['source'] = 'Bulughul Maram'
	}
	var fd = 'hadith2/enlite_db/each_hadith/'
	var fn = 'BM.json'
	json_read(fd, fn, function (obj2) {
		obj['chapter'] = obj2[DATA][id[1]-1]["title"]
		if (id[2]-1 >= 0)
			obj['sub_chapter'] = obj2[DATA][id[1]-1]['chapter'][id[2]-1]['title']
		else
			obj['sub_chapter'] = obj2[DATA][id[1]-1]["title"]
		obj['hadith_no'] = id[3]
		obj['chapter_no'] = id[1]
	})

	return obj
}

function num_to_roman(num) {
  var lookup = {M:1000,CM:900,D:500,CD:400,C:100,XC:90,L:50,XL:40,X:10,IX:9,V:5,IV:4,I:1},roman = '',i;
  for ( i in lookup ) {
    while ( num >= lookup[i] ) {
      roman += i;
      num -= lookup[i];
    }
  }
  return roman;
}

function lightHadith(obj) {
	var _obj = {}
	_obj['id'] =	obj['id']
	var str = ''
	str += 'Kitab: ' + obj['source'] + '. '
	str += 'Bab: ' + obj['chapter'] + ' (' + romanize(obj['chapter_no']) +')'+ '. '
	str += 'Subbab: ' + obj['sub_chapter'] + '. '
	str += 'Nomor Hadits: ' + obj['hadith_no'] + '. '
	str += 'Halaman: ' + obj['page'] + '. '
	str += 'Riwayat: ' + obj['collector'] + '. '
	str += 'Derajat: ' + obj['degree'] + '. '
	str += 'Perawi dari: ' + obj['narrator'] + '. '

	var content = ''
	content += str + 'Tambahan informasi: ' + obj['comment'] + '. '
	content += 'Bunyi Hadits: ' + obj['hadith']
	_obj['content'] =	 content
	_obj['body'] = obj['hadith']
	_obj['header'] = str
	return _obj
}

function lightQuran(obj) {
	var _obj = {}
	_obj['id'] =	obj['id']
	var str = ''
	str += 'Kitab: ' + obj['source'] + '. '
	str += 'Surat: ' + obj['surah'] + ' (' + obj['surah_no'] +')'+ '. '
	str += 'Ayat: ' + obj['ayat_no'] + '. '

	var content = ''
	content += str + 'Bunyi Ayat: ' + obj['content'] + '. '
	_obj['content'] =	 content
	_obj['body'] = obj['content']
	_obj['header'] = str
	return _obj
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

function strToJsonStr(string) {
  var str = string.replace(/"/g, '\\"');
  str = str.replace(new RegExp('\r?\n','g'), '&lt;br&gt;');
  str = str.replace(/<br>/gi, '&lt;br&gt;');
  str = str.replace(/<i>/gi, '&lt;i&gt;');
  str = str.replace(/<\/i>/gi, '&lt;&sol;i&gt;');
  // str = str.replace(/(?:\r\n|\r|\n)/g, '<br>');
  // var asd = str.replace(/(?:\r\n|\r|\n)/g, '<br>');
  // var asd = str.replace(/\r\n|\r|\n/g, 'asd');
  return str;
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
				'<tr>'+'<td>'+'<a onclick="change_page_by_url(\''+HOME_URL+'about\')">'+TXT['footer']['footer']['company']['about']+'</a>'+'</td>'+'</tr>'+
				'<tr>'+'<td>'+'<a onclick="change_page_by_url(\''+HOME_URL+'team\')">'+TXT['footer']['footer']['company']['team']+'</a>'+'</td>'+'</tr>'+
			'</table>'

		var tbl = str_to_elm(elm)
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
	console.log('1', url)
	alert('1')
	dirs = str_split(url, '/')
	console.log(dirs)
	var start_index = dirs.indexOf(APP_DOMAIN)

	for (var i=0; i<start_index+1; i++) {
		F.arr.del_first_index(dirs)
	}

	console.log('2', url)
	alert('2')
	if (url.match(/\/\//g).length > 1) {
		var done = true
	}
	else {
		var done = false
		route()
	}

	console.log('3', url)
	alert('3')
	while (done) {
		if (url.search(/\/\//i) >= 0) {
			url = url.replace(/\/\//gi, '\/');
		}
		else {
			done = false
			dirs = str_split(url, '/')
			console.log(dirs)
			var start_index = dirs.indexOf(APP_DOMAIN)

			for (var i=0; i<start_index+1; i++) {
				F.arr.del_first_index(dirs)
			}
			url = arr_to_str(dirs, '/')
			console.log('4', url)
			alert('4')
			window.location.href = HOME_URL + url

		}
	}
}

function arr_to_str(arr, parser) {
	return arr.join(parser)
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

function json_one_to_many_create(json, key, val) {
	key = key.toLowerCase()
	val = val.toLowerCase()
	if (is_exist_json_key(json, key)) {
		json[key].push(val)
	}
	else {
		json[key] = []
	}
	return json
}

function str_from_to_get(str, from, to) {
	return str.split(from).pop().split(to)[0];
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
	 	json_read_local(BE_URL + '/storage/languages/page_news/'+news_id+'/id', function(obj) {
			// console.log(str_to_elm(obj))
			obj = obj[DATA];
		})
	}
}
	
