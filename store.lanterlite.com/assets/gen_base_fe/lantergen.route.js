
function route() {

	// var dirs = window.location.pathname;
	// dirs = LGen.str.split(dirs, '/')

	// var start_index = dirs.indexOf(LGen.app.get({'safe':'safe'}).domain)
	// for (var i=0; i<start_index+1; i++) {
	// 	LGen.arr.rmv_first(dirs)
	// }

	var dir = window.location.pathname;
	dir = dir.replace(LGen.system.get({'safe':'safe'}).change_url+'/', '')

	if (window.location.pathname === '/android_asset/www/index.html')
		dir = ''
	// lprint(LGen.app.get({'safe':'safe'}).platform === 'des' && LGen.app.get({'safe':'safe'}).os === 'windows', LGen.app.get({'safe':'safe'}).platform, LGen.app.get({'safe':'safe'}).os)
	if (LGen.app.get({'safe':'safe'}).platform === 'des' && LGen.app.get({'safe':'safe'}).os === 'windows') {
		require('electron').remote.app.getAppPath()
		var dir = window.location.pathname;
		dir = dir.replace(encodeURI('/'+require('electron').remote.app.getAppPath().split('\\').join('/')+'/'), '')
		dir = dir.replace('index.html', '')
		dir = dir.split(':/')[dir.split(':/').length-1]
		// var dir = window.location.pathname;
		// dir = dir.replace(LGen.system.get({'safe':'safe'}).change_url+'/', '')
	}
	// lprint('route', window.location.pathname, dir)
	
	var keys = Object.keys(LGen.Page.names)
	for (var i=0; i<keys.length; i++) {
		// lprint(keys[i])
		if (LGen.call({'c':'arr','f':'is_val_exist'})(LGen.Page.names[keys[i]].url_names, dir)) {
		// if (LGen.call({'c':'arr','f':'is_val_exist'})(LGen.Page.names[keys[i]].url_names, dirs[0])) {
			var index = LGen.call({'c':'arr','f':'get_index_by_strval'})(LGen.Page.names[keys[i]].url_names, dir)
			// lprint(keys[i])
			// lprint(LGen.Page.names[keys[i]].url_names, dir)			
			LGen.Page.names[keys[i]].url_name_index = index
			if (keys[i] === 'lgen_page_content')
				LGen.Page.names[keys[i]].previous_page = LGen.Page.current
			LGen.Page.change(keys[i])
			break;
		}
		else if (i === keys.length-1) {
			LGen.Page.change('not_found')
		}
	}
}