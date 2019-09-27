LGen.Json = new JsonMan()
LGen.JsonMan = new JsonMan()

function JsonMan () {

	this.is_key_exist = is_key_exist
	function is_key_exist(json, key) {
		if(json.hasOwnProperty(key))
			return true
		else
			return false
	}

	this.is_json = is_json
	function is_json(p) {
    if (Array.isArray(p)) return false;
    else if (typeof p == 'string') return false;
    else if (p != null && typeof p == 'object') return true;
    else return false;
	}

	this.to_str = to_str
	function to_str(obj) {
		obj = JSON.stringify(obj);
		return obj;
	}

	this.rmv_by_val = rmv_by_val
	function rmv_by_val(json, value) {
		delete json[value]
	  return json
	}

	this.get_keys = get_keys
	function get_keys(json) {
	  return Object.keys(json);
	}

	this.get_length = get_length
	function get_length(json) {
	  return Object.keys(json).length;
	}

	this.rmv_by_key = rmv_by_key
	function rmv_by_key(json, key) {
		delete json[key]
	  return json
	}

	this.save_to_json_php = save_to_json_php
	function save_to_json_php(file_dir, obj, callback) {
	}

	this.save_to_json_php = save_to_json_php
	function save_to_json_php(file_dir, obj, callback) {
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
	      // error: function(e) { lprint(e.responseText); }
		});

	  function header_set(xhr) { 
	  	xhr.setRequestHeader(FUNC_NAME, 'json_to_php');
	  	xhr.setRequestHeader(FILE_DIR, file_dir);
	  }
	}

	this.read_local = read_local
	function read_local(file_path, callback) {
		// lprint(file_path)
		$.ajax({
	    type: "GET",
	    url: file_path,
	    contentType: "application/json;",
	    dataType: "json",
	    success: function(obj) { callback(obj); },
	    // error: function(e) {}
	    error: function(e) {  lprint(obj); }
		});  
	}

	this.to_php_str = to_php_str
	function to_php_str(json) {
		var _info = JSON.stringify(json) 
		return "json_decode('"+_info+"', true)"
	}

	this.read = read
	function read(file_path, callback) {
		lprint(file_path)
		$.ajax({
	    type: "GET",
	    url: file_path,
	    contentType: "application/json;",
	    dataType: "json",
	    success: function(obj) { callback(obj); },
	    // error: function(e) {}
	    error: function(e) {  lprint(e.responseText); }
		});  
	}

	this.read2 = read2
	function read2(file_dir, file_name, callback) {
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

	this.save = save
	function save(file_dir, file_name, obj, callback) {
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

	function one_to_many_create(json, key, val) {
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


}