LGen = new LanterGen()
// LGen.init()
lprint = console.log

var DATA = 'Data';

function post_license() {
	var asd = {'gate':'backlite', 'limited': false, 'val':btoa(LGen.Json.to_str(
	{
	    "fullname": "Ifan Dhani Prasojo",
	    "type": "theme"
	}
	)), 'def':'licenses', 'bridge':[{'id':'citizens', 'puzzled': true}, {'id':LGen.citizen.id, 'puzzled': false}, {'id':'licenses', 'puzzled': true}]}			
	LGen.f.send_get('be.lanterlite.com/savior', 'LGen("SaviorMan")->insert('+LGen.Json.to_php_str(asd)+')', function(obj){lprint(obj)})
}

function send_post(data, func) {
	if (func == undefined) func = function() {}
	// var _data = {}
	// _data[DATA] = data
	req_to_server({
		'method':'post',
		'url':be_url, 
		'callback':function(obj) {
			func(obj)
		},
		'data': data
	})
}


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

function disable_canvas_scroll() {
	if (LGen.f.is_mobile())
		document.querySelector("html").style.overflow = "hidden";
}

function enable_canvas_scroll() {
	if (LGen.f.is_mobile())
		document.querySelector("html").style.overflow = "auto";
}

function LanterGen() {
	this.load_finished = false
	this.component = {}

	this.citizen = new Citizen()
	function Citizen() {
		this.id = ''
		this.username = ''
		this.fullname = ''
		this.is_verified = ''
		this.email = ''
		this.address = ''
		this.phonenum = ''
		this.lang = 'id'
		this.gender = 'male'
		this.theme_color = 'ca01'
		this.theme_font = 'fa01'

		this.set = set
		function set(obj) {
			// lprint(obj)
			if (obj.hasOwnProperty('id'))
				LGen.citizen.id = atob(obj['id'])
			if (obj.hasOwnProperty('username'))
				LGen.citizen.username = atob(obj['username'])
			if (obj.hasOwnProperty('fullname'))
				LGen.citizen.fullname = atob(obj['fullname'])
			if (obj.hasOwnProperty('email'))
				LGen.citizen.email = atob(obj['email'])
			if (obj.hasOwnProperty('gender'))
				LGen.citizen.gender = atob(obj['gender'])
			if (obj.hasOwnProperty('phonenum'))
				LGen.citizen.phonenum = atob(obj['phonenum'])
			if (obj.hasOwnProperty('address'))
				LGen.citizen.address = atob(obj['address'])
			if (obj.hasOwnProperty('is_verified'))
				LGen.citizen.is_verified = parseInt(atob(obj['is_verified']))
			if (obj.hasOwnProperty('silver'))
				LGen.citizen.silver = parseInt(atob(obj['silver']))
			if (obj.hasOwnProperty('point'))
				LGen.citizen.point = parseInt(atob(obj['point']))
			if (obj.hasOwnProperty('licenses')) {
				LGen.citizen.licenses = obj['licenses']
				for (var i=0; i<LGen.citizen.licenses.length; i++) {
					LGen.citizen.licenses[i]['id'] = atob(LGen.citizen.licenses[i]['id'])
					LGen.citizen.licenses[i]['type'] = atob(LGen.citizen.licenses[i]['type'])
					LGen.citizen.licenses[i]['created_date'] = LGen.f.convert_to_local_date(atob(LGen.citizen.licenses[i]['created_date']))
				}
			}

			if (!$(LGen.component.header.acc.screen.querySelector('.img')).hasClass('active'))
				$(LGen.component.header.acc.screen.querySelector('.img')).addClass('active')
			LGen.component.account.screen.querySelector('span').innerText = '@'+LGen.citizen.username

			if (obj.hasOwnProperty('lang'))
				LGen.Page.update_lang(atob(obj['lang']))
			if (obj.hasOwnProperty('theme_color'))
				LGen.Page.update_color(atob(obj['theme_color']))
			if (obj.hasOwnProperty('theme_font'))
				LGen.Page.update_font(atob(obj['theme_font']))

			// if (LGen.Theme.Font.id !== LGen.citizen.theme_font) {
			// 	LGen.Theme.Font.update(LGen.citizen.theme_font)
			// 	LGen.Theme.Font.id = LGen.citizen.theme_font
			// }
		}

		this.set_default = set_default
		function set_default() {
			this.id = ''
			this.username = ''
			this.fullname = ''
			this.is_verified = ''
			this.email = ''
			this.address = ''
			this.phonenum = ''
			this.licenses = []
			// this.theme_color = 'ca01'
			// this.theme_font = 'fa01'
			// if (this.lang === '')
			// 	this.lang = 'en'
			if (this.gender === '')
				this.gender = 'male'
			
			LGen.Page.update_color('ca01')
			LGen.Page.update_font('fa01')
			if ($(LGen.component.header.acc.screen.querySelector('.img')).hasClass('active'))
				$(LGen.component.header.acc.screen.querySelector('.img')).removeClass('active')

			// if (LGen.Theme.Font.id !== LGen.citizen.theme_font) {
			// 	LGen.Theme.Font.update(LGen.citizen.theme_font)
			// 	LGen.Theme.Font.id = LGen.citizen.theme_font
			// }
		}

		this.update_savior = update_savior
		function update_savior(obj) {
			var val = {}
	    for (var i=0; i<obj['namelist'].length; i++)
	    	val[obj['namelist'][i]] = LGen.citizen[obj['namelist'][i]]
			var _obj = {
				"json": {
					'namelist':obj['namelist'],
					'gate':'savior', 
					'def':'citizens', 
					'val': val, 
					'bridge':[
						{'id':'citizens', 'puzzled': true}, 
						{'id': LGen.citizen.id, 'puzzled': false}
					]
				},
				"func": 'LGen("SaviorMan")->update'
			}
			LGen.f.send_post(LGen.system.be_domain+'/citizen', _obj, function(obj){})
		}
	}

	this.init = init
	function init() {
		var js_list = [
			// BASE_URL + 'lanterlite.gen.js',
			BASE_URL + 'lanterlite.icon.js',
			BASE_URL + 'system.js',
			BASE_URL + 'assets/gen.js/Table.js'
		]
		LGen.func.recursive_js_import(js_list, 0, function() {
			LGen.GlobVar.base_url = BASE_URL
	    LGen.func.read_file(LGen.GlobVar.base_url + "assets/gen.obj/propkey", function(obj) {
	    	LGen.propkey = obj
	    })
		})

		var css_list = [
			BASE_URL + 'lanterlite.gen.css',
			BASE_URL + 'assets/gen.css/snackbar.css'
		]
		LGen.func.recursive_css_import(css_list, 0)


	}

	this.GlobVar = {
		"css_dir" : BASE_URL + 'assets/gen.js/'
	}


	this.lang = new Language()
	function Language () {
		this.text = {}
		this.recursive_get = recursive_get
		function recursive_get (lang_obj, count, callback) {
			if (count === undefined) count = 0
			if (callback === undefined) callback = function(){}
			// if (lang_obj[KEYS[count]]['from'] == 'backlite') {
			// 	req_to_backlite({'method':'get', 'url':lang_obj[KEYS[count]]['url'], 'callback':function(obj) {
			// 		this.lang.text[KEYS[count]] = obj[DATA]
			// 		count += 1
			// 		if (count < KEYS.length)
			// 			this.lang.recursive_get(count)
			// 		else if (callback !== undefined)
			// 			callback()
			// 	}})
			// }
			// else {
				console.log(lang_obj)
				console.log(count)
			 	LGen.JsonMan.read_local(HOME_URL + 'assets/lang/'+ lang_obj[count]['url'], function(obj) {
					LGen.lang.text[lang_obj[count]['title']] = obj
					count += 1
					if (count < lang_obj.length)
						LGen.lang.recursive_get(lang_obj, count, callback)
					else
						callback()
				})
			// }
		}

		this.text_get = text_get
		function text_get(list, inc, callback) {
			console.log(list)
		 	LGen.Json.read(list[inc].url, function(obj) {
				LGen.lang.text[list[inc]['name']] = obj
				inc += 1
				if (inc < list.length)
					LGen.lang.text_get(list, inc, callback)
				else
					if (callback !== undefined) callback()
			})
		}



	}

	this.Elm = new Element()
	function Element () {

		this.decrypt = decrypt
		function decrypt(str) {
			return LGen.String.to_json(decodeURIComponent(LGen.base64.decode(str).replace(/\+/g, '%20')))
		}

		this.encrypt = encrypt
		function encrypt(str) {
			return LGen.base64.encode(encodeURIComponent(LGen.Json.to_str(str)))
			// return btoa(unescape(encodeURIComponent(str)))
		}

		this.clear_childs = clear_childs
		function clear_childs(node) {
		  while (node.firstChild) {
		    node.removeChild(node.firstChild);
		  }
		}

		this.clear_self = clear_self
		function clear_self(query) {
			var content = ''
			if (typeof(query) === 'string')
			  content = document.querySelector(query);
			else
				content = query
		  if (content != null)
		    content.parentNode.removeChild(content);    
		}

		this.input = new Input()
		this.Input = new Input()
		function Input() {
			this.to_number = to_number
			function to_number(elm){
				$(elm).css({"text-transform": "lowercase"})
				elm.addEventListener('keydown', function(e) {
			    var keypressed = e.which
			    lprint(keypressed)
		      if(!e.shiftKey && (keypressed === 9 || keypressed === 8 || keypressed === 13 || keypressed === 46 || (keypressed >= 37 && keypressed <= 40)) ) { 
			    	lprint('keypressed')
		      }
		      else if(e.shiftKey || !(keypressed >=48 && keypressed <= 57) && !(keypressed >=96 && keypressed <= 105)) { 
		        e.preventDefault()
		        return false             
		      }
				  if (
		  			(keypressed === 9) || // tab
				  	(keypressed >=65 && keypressed <= 90) || // character 
		  			(keypressed >=48 && keypressed <= 57) || // num
		  			(keypressed >=96 && keypressed <= 105)
					) {
						this.value = this.value.toLowerCase();
					} else if ( keypressed === 8 || keypressed === 27 || keypressed === 46  || (keypressed >= 35 && keypressed <= 40) ) {
		    		// Accepted but the event it's not propagated because those are the special chars
		      } else {
		        // We don't allow anything else
		        e.preventDefault()
		        return false
		      }
				})
			}

			this.to_email = to_email
			function to_email(elm){
				$(elm).css({"text-transform": "lowercase"})
				elm.addEventListener('keydown', function(e) {
			    var keypressed = e.which
		      if(e.shiftKey && (keypressed === 50)) { 
			    	lprint('keypressed')
		      }
		      else if(e.shiftKey && (keypressed >=48 && keypressed <= 57)) { 
		        e.preventDefault()
		        return false             
		      }
				  var key = String.fromCharCode(e.which)
			    lprint(keypressed)

				  if (
		  			(keypressed === 9) || // tab
		  			(keypressed === 190) || // dot
				  	(keypressed >=65 && keypressed <= 90) || // character 
		  			(keypressed >=48 && keypressed <= 57) || // num
		  			(keypressed >=96 && keypressed <= 105)
					) {
						this.value = this.value.toLowerCase();
					} else if ( keypressed === 8 || keypressed === 27 || keypressed === 46  || (keypressed >= 35 && keypressed <= 40) ) {
		    		// Accepted but the event it's not propagated because those are the special chars
		      } else {
		        // We don't allow anything else
		        e.preventDefault()
		        return false
		      }
				})
			}

			this.to_username = to_username
			function to_username(elm){
				$(elm).css({"text-transform": "lowercase"})
				elm.addEventListener('keydown', function(e) {
			    var keypressed = e.which
			    lprint(keypressed)
		      if(e.shiftKey && (keypressed >=48 && keypressed <= 57)) { 
		        e.preventDefault()
		        return false             
		      }
				  var key = String.fromCharCode(e.which)

				  if (
		  			(keypressed === 9) || // tab
				  	(keypressed >=65 && keypressed <= 90) || // character 
		  			(keypressed >=48 && keypressed <= 57) || // num
		  			(keypressed >=96 && keypressed <= 105)
					) {
						this.value = LGen.StringMan.to_alphanumeric(this.value).toLowerCase();
					} else if ( keypressed === 8 || keypressed === 27 || keypressed === 46  || (keypressed >= 35 && keypressed <= 40) ) {
		    		// Accepted but the event it's not propagated because those are the special chars
		      } else {
		        // We don't allow anything else
		        e.preventDefault()
		        return false
		      }
				})
			}

			this.to_alphanum = to_alphanum
			function to_alphanum(elm){
				elm.addEventListener('keydown', function(e) {
			    var keypressed = e.which
			    lprint(keypressed)
		      if(e.shiftKey && (keypressed >=48 && keypressed <= 57)) { 
		        e.preventDefault()
		        return false             
		      }
				  var key = String.fromCharCode(e.which)

				  if (
		  			(keypressed === 9) || // tab
				  	(keypressed >=65 && keypressed <= 90) || // character 
		  			(keypressed >=48 && keypressed <= 57) || // num
		  			(keypressed >=96 && keypressed <= 105)
					) {
						this.value = LGen.StringMan.to_alphanumeric(this.value).toUpperCase();
					} else if ( keypressed === 8 || keypressed === 27 || keypressed === 46  || (keypressed >= 35 && keypressed <= 40) ) {
		    		// Accepted but the event it's not propagated because those are the special chars
		      } else {
		        // We don't allow anything else
		        e.preventDefault()
		        return false
		      }
				})
			}
		}


		this.get = get
		function get (obj) {
			if (typeof(obj) == 'string')
				obj = document.querySelector(obj)
			return obj
		}

		this.is_focus = is_focus
		function is_focus(query) {
			return $(query).is(":focus")
		}

		this.rmv_first_child = rmv_first_child
		function rmv_first_child(parent) {
			$(parent).find(':first-child').remove();
		}

		this.btn = btn
		function btn (attr) {
			if (attr.style === undefined) attr.style = ''
			if (attr.id === undefined) attr.id = ''
			if (attr.class === undefined) attr.class = ''
			if (attr.val === undefined) attr.val = ''
			return str_to_elm('<button id="'+attr.id+'", class="'+attr.class+'" style="'+attr.style+'">'+attr.val+'</button>')
		}

		this.div = div
		function div (attr) {
			if (attr.style === undefined) attr.style = ''
			if (attr.id === undefined) attr.id = ''
			if (attr.class === undefined) attr.class = ''
			if (attr.val === undefined) attr.val = ''
			return str_to_elm('<div id="'+attr.id+'", class="'+attr.class+'" style="'+attr.style+'">'+attr.val+'</div>')
		}
	}

	this.head = new head()
	function head() {

		this.icon_set = icon_set
		function icon_set() {
		  var head = document.getElementsByTagName('head')[0];
		  var link = document.createElement('link');
		  link.rel = 'icon';
		  link.type = 'image/gif';
		  link.href = BASE_URL + './assets/lite.img/icon.gif';
		  head.appendChild(link);
		}

		this.meta = new meta()
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

		this.title_set = title_set
		function title_set(title) {
			if (title === undefined)
				title = ''
			var t = document.createElement('title');
			t.innerHTML = title;
			document.getElementsByTagName('head')[0].appendChild(t);
		}
	}


	/****  Base64 encode / decode*  http://www.webtoolkit.info/***/
	this.base64 = {
	  // private property
	  _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
	  // public method for encoding
	  encode : function (input) {
	      var output = "";
	      var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
	      var i = 0;
	      input = LGen.base64._utf8_encode(input);
	      while (i < input.length) {
	          chr1 = input.charCodeAt(i++);
	          chr2 = input.charCodeAt(i++);
	          chr3 = input.charCodeAt(i++);
	          enc1 = chr1 >> 2;
	          enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
	          enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
	          enc4 = chr3 & 63;
	          if (isNaN(chr2)) {
	              enc3 = enc4 = 64;
	          } else if (isNaN(chr3)) {
	              enc4 = 64;
	          }
	          output = output +
	          this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
	          this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
	      }
	      return output;
	  },
	  // public method for decoding
	  decode : function (input) {
	      var output = "";
	      var chr1, chr2, chr3;
	      var enc1, enc2, enc3, enc4;
	      var i = 0;
	      input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
	      while (i < input.length) {
	          enc1 = this._keyStr.indexOf(input.charAt(i++));
	          enc2 = this._keyStr.indexOf(input.charAt(i++));
	          enc3 = this._keyStr.indexOf(input.charAt(i++));
	          enc4 = this._keyStr.indexOf(input.charAt(i++));
	          chr1 = (enc1 << 2) | (enc2 >> 4);
	          chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
	          chr3 = ((enc3 & 3) << 6) | enc4;
	          output = output + String.fromCharCode(chr1);
	          if (enc3 != 64) {
	              output = output + String.fromCharCode(chr2);
	          }
	          if (enc4 != 64) {
	              output = output + String.fromCharCode(chr3);
	          }
	      }
	      output = LGen.base64._utf8_decode(output);
	      return output;
	  },
	  // private method for UTF-8 encoding
	  _utf8_encode : function (string) {
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
	  },
	  // private method for UTF-8 decoding
	  _utf8_decode : function (utftext) {
	      var string = "";
	      var i = 0;
	      var c = c1 = c2 = 0;
	      while ( i < utftext.length ) {
	          c = utftext.charCodeAt(i);
	          if (c < 128) {
	              string += String.fromCharCode(c);
	              i++;
	          }
	          else if((c > 191) && (c < 224)) {
	              c2 = utftext.charCodeAt(i+1);
	              string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
	              i += 2;
	          }
	          else {
	              c2 = utftext.charCodeAt(i+1);
	              c3 = utftext.charCodeAt(i+2);
	              string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
	              i += 3;
	          }
	      }
	      return string;
	  } }

	this.f = new Func()
	this.func = new Func()
	function Func () {

		this.is_online = is_online
		function is_online () {
			return navigator.onLine
		}

		this.is_mobile = is_mobile
		function is_mobile () {
			// device detection
			if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
			    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
			    return true;
			}
			else
		    return false;
		}

		this.create = create
		function create(_eval) {
			return function() { eval(_eval) }
		}

		this.to_top = to_top
		function to_top(with_animation = false) {
			if (LGen.f.is_mobile()) {
				var query = 'html'
			}
			else {
				var query = '.ss-content'
			}
			if (with_animation) {
				$(document).ready(function() {
			    $(query).animate({ scrollTop: 0 }, "slow");
				});	
			}
			else {
				$(query).scrollTop(0);
			}
		}

		this.convert_to_local_date = convert_to_local_date
		function convert_to_local_date(_date) {
			function get_month_by_num(num) {
				var monthNames = ["January", "February", "March", "April", "May", "June",
				  "July", "August", "September", "October", "November", "December"
				];
				return monthNames[num]
			}

			if (_date === '' || _date === null || _date === undefined)
				return ''
			var _date = _date.toString()
			var date = new Date(_date);
			// November 12, 2018 at 4:39
			var result = get_month_by_num(date.getMonth()) + ' ' + date.getDate()+', '+ date.getFullYear()+' at '+date.getHours()+':'+date.getMinutes()
			return result
		}


		this.req_to_server = req_to_server
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
			  // data['LSSK'] = LSSK
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

		this.to_php_server = to_php_server
		function to_php_server(str) {
			return btoa(str)
		}

		this.send_get = send_get
		function send_get(url, data, callback) {
			if (data == undefined) data = function() {}
			// data['func'] = encodeURI(data['func'])
			if (!LGen.f.is_online()) {
				// setTimeout(function() {
					LGen.Page.change('offline')
				// }, 250)
				return false;
			}
			LGen.f.req_to_server({	
				'method':'get', 
				'url':LGen.system.fe_url+url+'?f='+encodeURI(LGen.Elm.encrypt(data)), 
				'callback':function(obj) {
					lprint(obj)
					// lprint(atob(obj))
					// lprint(LGen.Elm.decrypt(obj))
					callback(LGen.Elm.decrypt(obj))
				}
			})
		}

		// this.send_get = send_get
		// function send_get(url, func, callback) {
		// 	if (func == undefined) func = function() {}
		// 	LGen.f.req_to_server({	
		// 		'method':'get', 
		// 		'url':LGen.system.fe_url+url+'?f='+encodeURI(btoa(func)), 
		// 		'callback':function(obj) {
		// 			lprint(obj)
		// 			// lprint(atob(obj))
		// 			lprint(LGen.String.to_json(atob(obj)))
		// 			callback(LGen.String.to_json(atob(obj)))
		// 		}
		// 	})
		// }

		this.send_post = send_post
		function send_post(url, data, callback=function() {}) {
			// data['func'] = encodeURI(data['func'])
			// lprint(data)
			if (!LGen.f.is_online()) {
				// setTimeout(function() {
					LGen.Page.change('offline')
				// }, 250)
				return false;
			}
			LGen.f.req_to_server({
				'method':'post',
				'url':LGen.system.fe_url+url, 
				'callback':function(obj) {
					lprint(obj)
					// lprint(LGen.Elm.decrypt(obj))
					callback(LGen.Elm.decrypt(obj))
					// lprint(LGen.String.to_json(atob(obj)))
					// callback(LGen.String.to_json(atob(obj)))
				},
				// 'data': btoa(data)
				'data': LGen.Elm.encrypt(data)
			})

		// this.send_post = send_post
		// function send_post(url, data, callback=function() {}) {
		// 	req_to_server({
		// 		'method':'post',
		// 		'url':LGen.system.fe_url+url, 
		// 		'callback':function(obj) {
		// 			lprint(obj)
		// 			// lprint(LGen.String.to_json(atob(obj)))
		// 			// callback(LGen.String.to_json(atob(obj)))
		// 		},
		// 		// 'data': btoa(data)
		// 		'data': LGen.Elm.encrypt(data)
		// 	})

			// if (func == undefined) func = function() {}
			// LGen.f.req_to_server({	
			// 	'method':'get', 
			// 	'url':LGen.system.fe_url+url+'?f='+encodeURI(btoa(func)), 
			// 	'callback':function(obj) {
			// 		lprint(obj)
			// 		// lprint(atob(obj))
			// 		lprint(LGen.String.to_json(atob(obj)))
			// 		callback(LGen.String.to_json(atob(obj)))
			// 	}
			// })
		}

		this.unset = unset
		function unset(asd) {
			eval('delete '+asd+'');
		}

		this.change_url = change_url
		function change_url(url) {
			window.history.pushState({}, document.title, "/" + url);
		}

		//// Function to check letters and numbers.
		this.password_validated = password_validated
		function password_validated(text) { 
	    var passw_a = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/; //// To check a password between 6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase letter
	    var paswd_b =  /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/; //// To check a password between 7 to 15 characters which contain at least one numeric digit and a special character
	    var paswd_c =  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/; //// To check a password between 8 to 15 characters which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character
	    if (text.match(paswd_c))
        return true;
	    else
        return false;
		}

		this.email_validated = email_validated
		function email_validated(mail)	{
			if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
				return true
			}
			return false
		}

		this.str_to_elms = str_to_elms
		function str_to_elms(htmlString) {
		  var template = document.createElement('template');
		  template.innerHTML = html;
		  return template.content.childNodes;
		}

		this.str_to_elm = str_to_elm
		function str_to_elm(htmlString) {
		  var template = document.createElement('template');
		  html = htmlString.trim(); // Never return a text node of whitespace as the result
		  template.innerHTML = html;
		  return template.content.firstChild;
		      // var div = document.createElement('div');
		  // div.innerHTML = htmlString.trim();

		  // // Change this to div.childNodes to support multiple top-level nodes
		  // return div.firstChild; 
		}

		this.load_html = load_html
		function load_html(obj) {
			$(obj.container).load(obj.html_path);
		}

		this.is_alphanumeric = is_alphanumeric
		function is_alphanumeric(value) {
			var letterNumber = /^[0-9a-zA-Z]+$/;
			if((value.match(letterNumber))) {
			 return true;
			}
			else {
			 return false; 
			}
		}
		  
		//Returns true if it is a DOM node
		this.is_node = is_node
		function is_node(o){
		  return (
		    typeof Node === "object" ? o instanceof Node : 
		    o && typeof o === "object" && typeof o.nodeType === "number" && typeof o.nodeName==="string"
		  );
		}

		//Returns true if it is a DOM element    
		this.is_element = is_element
		function is_element(o){
			return (
				typeof HTMLElement === "object" ? o instanceof HTMLElement : //DOM2
				o && typeof o === "object" && o !== null && o.nodeType === 1 && typeof o.nodeName==="string"
			);
		}

		this.recursive_css_import = recursive_css_import
		function recursive_css_import(css_list, inc, callback) {
			$.when(
				$('<link/>', {rel: 'stylesheet', type: 'text/css', href: css_list[inc]}).appendTo('head'),
			  $.Deferred(function( deferred ){$( deferred.resolve );})
			).done(function(){
				inc += 1
				// console.log(inc)
				if (inc < css_list.length) {
					recursive_css_import(css_list, inc, callback)
				}
				else {
					if (callback !== undefined)
						callback()
				}
			});
		}

		this.recursive_js_import = recursive_js_import
		function recursive_js_import(js_list, inc, callback) {
			$.when(
			  $.getScript( js_list[inc] ),
			  $.Deferred(function( deferred ){$( deferred.resolve );})
			).done(function(){
				inc += 1
				// console.log(inc)
				if (inc < js_list.length) {
					recursive_js_import(js_list, inc, callback)
				}
				else {
					if (callback !== undefined)
						callback()
				}
			});
		}

		this.addEvent = addEvent
		function addEvent(element, eventName, callback) {
		  if (element.addEventListener) {
		      element.addEventListener(eventName, callback, false);
		  } else if (element.attachEvent) {
		      element.attachEvent("on" + eventName, callback);
		  } else {
		      element["on" + eventName] = callback;
		  }
		}

		this.read_file = read_file
		function read_file(file_path, callback) {
			console.log(file_path)
			$.ajax({
		    type: "GET",
		    url: file_path,
		    contentType: "application/json;",
		    dataType: "json",
		    success: function(obj) { callback(obj); },
		    error: function(e) {}
		    // error: function(e) {  console.log(obj); }
			});  
		}

		this.lhash = LanterHash
		function LanterHash(string) {
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

	}
}

