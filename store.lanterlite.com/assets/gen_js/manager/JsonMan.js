LGen.set_func({'val':'obj','func':{
	is_key_exist : function (json, key) {
		return (json.hasOwnProperty(key))? true : false;
	},
	is_json : function (p) {
    if (Array.isArray(p)) return false;
    else if (typeof p == 'string') return false;
    else if (p != null && typeof p == 'object') return true;
    else return false;
	},
	to_str : function (obj) {
		return JSON.stringify(obj);
	},
	rmv_by_key : function (json, key) {
		delete json[key]
	  return json
	},
	get_keys : function (json) {
	  return Object.keys(json);
	},
	get_length : function (json) {
	  return Object.keys(json).length;
	},
	read : function (file_path, callback) {
		if (LGen.app.get({'safe':'safe'}).platform === 'mob')
			var file_path = '../www/'+file_path
			// var file_path = cordova.file.applicationDirectory+'www/'+file_path
		$.ajax({
	    type: "GET",
	    url: file_path,
	    contentType: "application/json;",
	    dataType: "json",
	    success: function(obj) { callback(obj); },
	    error: function(e) {  lprint(e.responseText); }
		});  
	}
}
})
