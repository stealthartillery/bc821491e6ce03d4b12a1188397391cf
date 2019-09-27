
function route() {

	// var dirs = window.location.pathname;
	// dirs = LGen.StringMan.split(dirs, '/')

	// var start_index = dirs.indexOf(LGen.app.domain)
	// for (var i=0; i<start_index+1; i++) {
	// 	LGen.ArrayMan.rmv_first(dirs)
	// }

	var dir = window.location.pathname;
	dir = dir.replace(LGen.system.change_url+'/', '')
	
	var keys = Object.keys(LGen.Page.names)
	for (var i=0; i<keys.length; i++) {
		lprint(keys[i])
		if (LGen.Array.is_val_exist(LGen.Page.names[keys[i]].url_names, dir)) {
		// if (LGen.Array.is_val_exist(LGen.Page.names[keys[i]].url_names, dirs[0])) {
			var index = LGen.Array.get_index_by_strval(LGen.Page.names[keys[i]].url_names, dir)
			lprint(keys[i])
			LGen.Page.names[keys[i]].url_name_index = index
			LGen.Page.change(keys[i])
			break;
		}
		else if (i === keys.length-1) {
			LGen.Page.change('not_found')
		}
	}
}