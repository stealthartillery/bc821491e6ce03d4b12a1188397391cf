LGen.start = function () {
	// LGen.citizen.id = 'C92754B29028'
	
	LGen.storage.config({
    driver      : LGen.storage.WEBSQL, // Force WebSQL; same as using setDriver()
    name        : LGen.app.get({'safe':'safe'}).codename,
    version     : 1.0,
    size        : 4980736, // Size of database, in bytes. WebSQL-only for now.
    storeName   : 'storage', // Should be alphanumeric, with underscores.
    description : LGen.app.get({'safe':'safe'}).fullname + ' Storage'
	});

	LGen.storage.getItem('app.config', function(err, value){
		// if (value === null) {
		// 	set_config()
		// }
		// else {
			LGen.call({'c':'gen','f':'read_file'})(LGen.system.get({'safe':'safe'}).home_url + "app/app.config.lgen", function(obj) {
				// lprint(obj)
				if (value !== null) {
					if (LGen.call({'c':'black','f':'check'})({'val':obj,'safe':'safe'}))
						obj = LGen.call({'c':'white','f':'get'})({'val':obj,'safe':'safe'})
					if (LGen.call({'c':'black','f':'check'})({'val':value,'safe':'safe'}))
						value = LGen.call({'c':'white','f':'get'})({'val':value,'safe':'safe'})
					var keys = Object.keys(obj)
					for (var i=0; i<keys.length; i++) {
						if (value.hasOwnProperty(keys[i]) && value[keys[i]].hasOwnProperty('sel')) {
							obj[keys[i]].sel = value[keys[i]].sel
						}
					}
				}

				if (!LGen.call({'c':'black','f':'check'})({'val':obj,'safe':'safe'}))
					obj = LGen.call({'c':'black','f':'get'})({'val':obj,'safe':'safe'})
				LGen.storage.setItem('app.config', obj)
	    	LGen.config.obj = obj
	    	get_intro()
	    })
		// }
	})
	

	// function set_config () {
	// 	LGen.call({'c':'gen','f':'read_file'})(LGen.system.get({'safe':'safe'}).home_url + "app/app.config.lgen", function(obj) {
	// 		// lprint(obj)
	// 		if (!LGen.call({'c':'black','f':'check'})({'val':obj,'safe':'safe'}))
	// 			obj = LGen.call({'c':'black','f':'get'})({'val':obj,'safe':'safe'})
	// 		LGen.storage.setItem('app.config', obj)
 //    	LGen.config.obj = obj
 //    	get_intro()
 //    })
	// }
	// lprint(LGen.component.header)
}

function get_intro() {
	// if (LGen.app.get({'safe':'safe'}).platform !== 'mob') {
 //  	run_app()
	// 	return 0;
	// }

	LGen.storage.getItem('app.intro', function(err, value){
		if (value === null) {
			set_new_intro()
		}
		else {
			var obj = value
			if (LGen.call({'c':'black','f':'check'})({'val':value,'safe':'safe'}))
				obj = LGen.call({'c':'white','f':'get'})({'val':value,'safe':'safe'})
			if (!obj.hasOwnProperty('version')) {
				set_new_intro()
			}
			else if (obj.version !== LGen.app.get({'safe':'safe'}).version) {
				set_new_intro()
			}
			else {
	    	LGen.intro.obj = value
	    	run_app()
			}
		}
	})

	function set_new_intro() {
		LGen.call({'c':'gen','f':'read_file'})(LGen.system.get({'safe':'safe'}).home_url + "app/app.intro.lgen", function(obj) {
			// lprint(obj)
			obj.version = LGen.app.get({'safe':'safe'}).version
			if (!LGen.call({'c':'black','f':'check'})({'val':obj,'safe':'safe'}))
				obj = LGen.call({'c':'black','f':'get'})({'val':obj,'safe':'safe'})
			LGen.storage.setItem('app.intro', obj)
    	LGen.intro.obj = obj
    	run_app()
    })
	}
}

function run_app () {

	LGen.call({'c':'gen','f':'recursive_css_import'})([
		LGen.system.get({'safe':'safe'}).home_url+'app/lanterapp.css'
	], 0, function() {

	})

	LGen.call({'c':'gen','f':'recursive_js_import'})([
		LGen.system.get({'safe':'safe'}).home_url+'app/lanterapp.js',
	], 0, function() {
		function page_readiness_check() {
	    if( !LGen.Page.ready ){
        setTimeout( page_readiness_check, 100 );
	    }
	    else {
	    	// lprint('page_readiness_check')
				LGen.storage.getItem('citizen', function(err, value){
		    	// lprint('citizen value ', value)
		    	var need_check_ship_online = true
					if ( value !== null ) {
						var obj = value
						if (LGen.call({'c':'black','f':'check'})({'val':value, 'safe':'safe'}))
							obj = LGen.call({'c':'white','f':'get'})({'val':value, 'safe':'safe'})
	 	   			if (obj.id !== '') {
							LGen.citizen.set_all({'val':obj,'safe':'safe'})
							check_version()
							need_check_ship_online = false
	 	   			}
		 	   		// lprint('citizen value (b)  ', obj)
					}
					if (need_check_ship_online) {
						if (LGen.app.get({'safe':'safe'}).platform === 'mob' && navigator.onLine) {
							var _obj = {
								"json": {'val':{'ship_id': device.uuid}},
								"func": '$citizen->get_ship_id'
							}
							LGen.call({'c':'req','f':'post'})(LGen.system.get({'safe':'safe'}).be_domain+'/gate', _obj, function(obj){
								// lprint('citizen obj ', obj)
								if (obj.hasOwnProperty('id')) {
									// LGen.storage.setItem('citizen', LGen.call({'c':'black','f':'get'})({'val':obj,'safe':'safe'}))
									LGen.citizen.set_all({'val':obj,'safe':'safe'})
								}
								check_version()
							})
						}
						else {
							// LGen.citizen.set_default()
							check_version()
						}
					}
				})
	    }
		}
		page_readiness_check();
	})
}

function set_theme () {
	LGen.Theme.new_change_clr(LGen.citizen.get({'key':'theme_color','safe':'safe'}))
	LGen.Theme.new_change_ft(LGen.citizen.get({'key':'theme_font','safe':'safe'}))
	LGen.Theme.new_change_fs(LGen.citizen.get({'key':'fsize','safe':'safe'}))
}

function check_version () {
	set_theme()
	// lprint('check_version')
	if (LGen.app.get({'safe':'safe'}).version === '-') {
		app_launch()
		return false;
	}

	if (LGen.app.get({'safe':'safe'}).platform === 'mob' && navigator.onLine) {
		LGen.call({'c':'gen','f':'is_online'})(
			function () {
				var _obj = {
					"func": "get_app",
					"json": {}
				}
				// lprint(LGen.app.get({'safe':'safe'}))
				LGen.call({'c':'req','f':'get'})(LGen.app.get({'safe':'safe'}).be_domain+'/gate', _obj, function(obj) {
					LGen.component.splash.close()
					// lprint(obj)
					var current_version = LGen.app.get({'safe':'safe'}).version
					var new_version = obj['version']
					// if (current_version === new_version) {
					if (current_version !== new_version) {
						var link = ''
						if (LGen.app.get({'safe':'safe'}).os === 'android')
							link = LGen.app.get({'safe':'safe'}).android_app_store
						else
							app_launch()
						LGen.component.update.download_link = link
						LGen.component.update.screen.querySelector('.version1').innerText = current_version
						LGen.component.update.screen.querySelector('.version2').innerText = new_version
						LGen.Page.change('update')
					}
					else
						app_launch()
				})
			}, function () {
			app_launch()
		})
	}
	else
		app_launch()
}

function app_launch() {
	LGen.component.splash.close()
	route()
	// LGen.citizen.set_all({'val':{'lang':''},'safe':'safe'})
	// LGen.Page.update('lang',LGen.citizen.get({'key':'lang','safe':'safe'}))
	if (!LGen.call({'c':'gen','f':'is_mobile'})())
		when_desktop()
	else
		when_mobile()
	// LGen.component.header.hide_when_scroll_on()
}

LGen.app.get({'safe':'safe'}).text = {}
function text_get(list, inc, callback) {
 	LGen.call({'c':'obj','f':'read'})(list[inc].url, function(obj) {
		LGen.app.get({'safe':'safe'}).text[list[inc]['name']] = obj
		inc += 1
		if (inc < list.length)
			text_get(list, inc, callback)
		else
			if (callback !== undefined) callback()
	})
}


function icon_init2() {
	function add_style(svg) {
		svg = LGen.call({'c':'str', 'f':'to_elm'})(svg)
		svg.setAttribute('style', 'vertical-align: -webkit-baseline-middle;')
		return svg.outerHTML
	}
	
	ready_list = [];
	ready_tot = 0;
	page_ready = false

	LGen.icon.obj['heart'] = add_style(LGen.icon.obj['heart'])
	LGen.icon.obj['cart'] = add_style(LGen.icon.obj['cart'])
	LGen.icon.obj['bell'] = add_style(LGen.icon.obj['bell'])
	LGen.icon.obj['account'] = add_style(LGen.icon.obj['account'])
	LGen.icon.obj['info'] = add_style(LGen.icon.obj['info'])
	LGen.icon.obj['earth'] = add_style(LGen.icon.obj['earth'])
	LGen.icon.obj['store'] = add_style(LGen.icon.obj['store'])
	LGen.icon.obj['home'] = add_style(LGen.icon.obj['home'])
	LGen.icon.obj['exit'] = add_style(LGen.icon.obj['exit'])
	LGen.icon.obj['quote'] = add_style(LGen.icon.obj['quote'])
	LGen.icon.obj['option'] = add_style(LGen.icon.obj['option'])
	LGen.icon.obj['theme'] = add_style(LGen.icon.obj['theme'])
	// LGen.icon.obj['copy'] = add_style(LGen.icon.obj['copy'])
	LGen.icon.obj['brain'] = add_style(LGen.icon.obj['brain'])
	LGen.icon.obj['list'] = add_style(LGen.icon.obj['list'])
}

function when_desktop() {
	// SimpleScrollbar.initEl(LGen.Page.screen);
	// document.querySelector("html").style.overflow = "hidden";
}
function when_mobile() {
}