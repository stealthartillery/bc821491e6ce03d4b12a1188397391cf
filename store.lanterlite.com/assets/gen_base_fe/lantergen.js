// LGen.init()


var DATA = 'Data';



LGen = new function () {
	this.test = {}
	this.sf = {}
	this.load_finished = false
	this.component = {}

	this.set_button_click = function (obj, func=function(){}) {
		obj.addEventListener('click', function(obj){
			var _this = this
			// lprint(obj)
			// lprint(this)
			// var _this = this
			setTimeout(function() {func(_this)}, LGen.Page.speed)
		})
	}

	this.set_button = function (obj, is_recursive=true) {
		var canHover = !(matchMedia('(hover: none)').matches);
		if (canHover) {
		  $(obj).addClass('can-hover');
		}
		else {
			obj.addEventListener('click', function() {
				$(obj).addClass('hover')
				setTimeout(function(){
					$(obj).removeClass('hover')
				}, LGen.Page.speed*2)
			})
		}
		if (is_recursive) {
			var svg = obj.children
			for (var i=0; i<svg.length; i++) {
				if ($(svg[i]).is('svg'))
					this.set_button(svg[i], false)
			}
		}
	}

	this.set_func = function (obj) {
		if (typeof obj.val !== "string") return LGen.stat.failed
		if (typeof obj.func !== "object" && typeof obj.func !== "function") return LGen.stat.failed
		// lprint(arguments.callee.caller)
		if (!LGen.hasOwnProperty('be'))
			var mini = LGen.sf['hCkPD']['JO5O']
		else 
			var mini = LGen.sf[LGen.be].mini
		var name = mini({'val':obj.val,'safe':'safe'})
		var keys = Object.keys(obj.func)
		for (var i=0; i<keys.length; i++) {
			var f = mini({'val':keys[i],'safe':'safe'})
			obj.func[f] = obj.func[keys[i]]
			delete obj.func[keys[i]]
		}
		LGen.sf[name] = obj.func
	}

	this.call = call
	function call(obj) {
		if (!HOME_URL.includes('localhost') && !LGen.hasOwnProperty('test')) {
			if (!LGen.Safe.system(arguments.callee)) return LGen.stat.failed + ' (a)'
		}
		// if (!LGen.Safe.param(obj, ['c','f'])) return LGen.stat.failed
		// if (!obj.hasOwnProperty('c') || !obj.hasOwnProperty('f')) return LGen.stat.failed
		if (typeof obj.c !== "string") return LGen.stat.failed
		if (typeof obj.f !== "string") return LGen.stat.failed

		var c = LGen.sf['hCkPD']['JO5O']({'val':obj.c,'safe':'safe'})
		var f = LGen.sf['hCkPD']['JO5O']({'val':obj.f,'safe':'safe'})
		if (LGen.sf.hasOwnProperty(c) && LGen.sf[c].hasOwnProperty(f)) {
			return LGen.sf[c][f]
		}
		return LGen.stat.failed + ' (b)';

		// if (is_arr(obj)) {
		// 	return LGen.sf[LGen.sf.be.mini({'val':'arr','safe':'safe'})]
		// }
		
		// function is_arr(what) {
	 //    return Object.prototype.toString.call(what) === '[object Array]';
		// }
	}

	this.config = new Config()
	function Config() {
		this.obj = ''

		this.get = get
		function get (obj) {
			if (!HOME_URL.includes('localhost') && !LGen.hasOwnProperty('test')) {
				if (this.get.caller === null) return false
				var keys = Object.keys(obj);
				if (!keys.indexOf('safe') === -1) return false;
				else if (obj['safe'] !== 'safe')  return false;
			}
			return LGen.call({'c':'white','f':'get'})({'val':LGen.config.obj,'safe':'safe'})
		}

		this.set = set
		function set(obj) {
			if (!LGen.Safe.system(this.set)) return LGen.stat.failed
			if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed

			if (LGen.call({'c':'black','f':'check'})({'val':LGen.config.obj, 'safe':'safe'}))
				var cnf = LGen.call({'c':'white','f':'get'})({'val':LGen.config.obj,'safe':'safe'})
			else
				var cnf = {}

			obj = obj['val']
			var keys = Object.keys(obj)
			for (var i=0; i<keys.length; i++) {
				cnf[keys[i]].sel = obj[keys[i]].sel
			}

			LGen.config.obj = LGen.call({'c':'black','f':'get'})({'val':cnf,'safe':'safe'})
			LGen.storage.setItem('app.config', LGen.config.obj)
		}
	}

	this.app = new App()
	function App() {
		this.get = get
		function get (obj) {
			if (!HOME_URL.includes('localhost') && !LGen.hasOwnProperty('test')) {
				if (this.get.caller === null) return false
				var keys = Object.keys(obj);
				if (!keys.indexOf('safe') === -1) return false;
				else if (obj['safe'] !== 'safe')  return false;
			}
			return LGen.call({'c':'white','f':'get'})({'val':LGen.app.obj,'safe':'safe'})
		}
	}

	this.Safe = new Safe()
	function Safe() {
		this.system = system
		function system(func) {
			if (!HOME_URL.includes('localhost') && !LGen.hasOwnProperty('test')) {
				if (func.caller === null)
					return false
			}
			return true
		}

		this.param = param
		function param(obj, arr) {
			var keys = Object.keys(obj);
			if (keys.indexOf('admin') === -1 && obj['admin'] === 'admin') 
				return true;
			if (!HOME_URL.includes('localhost') && !LGen.hasOwnProperty('test')) {
				for (var i=0; i<arr.length; i++) {
					if (arr.indexOf(keys[i]) === -1)
						return false;
				}
				if (!keys.indexOf('safe') === -1) 
					return false;
				else if (obj['safe'] !== 'safe')
					return false;
			}
			return true;
		}
	}

	this.init = init
	function init() {
		var js_list = [
			// BASE_URL + 'lanterlite.gen_js',
			BASE_URL + 'lanterlite.icon.js',
			BASE_URL + 'system.js',
			BASE_URL + 'assets/gen_js/Table.js'
		]
		LGen.call({'c':'gen','f':'recursive_js_import'})(js_list, 0, function() {
			LGen.stat.base_url = BASE_URL
	    LGen.call({'c':'gen','f':'read_file'})(LGen.stat.base_url + "assets/gen_obj/propkey", function(obj) {
	    	LGen.propkey = obj
	    })
		})

		var css_list = [
			BASE_URL + 'lanterlite.gen_css',
			BASE_URL + 'assets/gen_css/snackbar.css'
		]
		LGen.call({'c':'gen','f':'recursive_css_import'})(css_list, 0)


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
			 	LGen.call({'c':'obj','f':'read_local'})(HOME_URL + 'assets/lang/'+ lang_obj[count]['url'], function(obj) {
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
		 	LGen.call({'c':'obj','f':'read'})(list[inc].url, function(obj) {
				LGen.lang.text[list[inc]['name']] = obj
				inc += 1
				if (inc < list.length)
					LGen.lang.text_get(list, inc, callback)
				else
					if (callback !== undefined) callback()
			})
		}
	}
}

var lprint = console.log
