LGen.str = {
 	shuffle : function (str) {
    var a = str.split(""), n = a.length;
    for(var i = n - 1; i > 0; i--) {
      var j = Math.floor(Math.random() * (i + 1));
      var tmp = a[i];
      a[i] = a[j];
      a[j] = tmp;
    }
    return a.join("");
	},
	to_arr : function (str, parser=' ') {
		return str.split('', parser)
	},
	to_elms : function (htmlString) {
	  var template = document.createElement('template');
	  template.innerHTML = html;
	  return template.content.childNodes;
	},
	to_elm : function (htmlString) {
	  var template = document.createElement('template');
	  html = htmlString.trim(); // Never return a text node of whitespace as the result
	  template.innerHTML = html;
	  return template.content.firstChild;
	},
	rand : function (length) {
		var result           = '';
		var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		var charactersLength = characters.length;
		for ( var i = 0; i < length; i++ )
			result += characters.charAt(Math.floor(Math.random() * charactersLength));
		return result;
	},
	to_title_case : function (str) {
		var splitStr = str.toLowerCase().split(' ');
		for (var i = 0; i < splitStr.length; i++)
			splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
		return splitStr.join(' '); 
	},
	add_val_by_index : function (str, val, index) {
		return str.slice(0, index) + val + str.slice(index);
	},
	rmv_val_by_index : function (str,index) {
		return str.slice(0, index) + str.slice(index+1);
	},
	copy : function (str) {
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
	},
	is_val_exist : function (str, substr) {
		return str.includes(substr)
	},
	is_aphanumeric : function (str) {
	  var code, i, len;
	  for (i = 0, len = str.length; i < len; i++) {
	    code = str.charCodeAt(i);
	    if (!(code > 47 && code < 58) && // numeric (0-9)
	        !(code > 64 && code < 91) && // upper alpha (A-Z)
	        !(code > 96 && code < 123)) { // lower alpha (a-z)
	      return false;
	    }
	  }
	  return true;
	},
	to_alphanumeric : function (string) {
		return string.replace(/[^a-z0-9]/gi,'')
	},
	clean : function (string) {
	  var str = string.toLowerCase()
	  str = str.replace(/<i>/gi, '');
	  str = str.replace(/<\/i>/gi, '');
	  str = str.replace(/<b>/gi, '');
	  str = str.replace(/<\/b>/gi, '');
	  str = str.replace(/[^A-Za-z0-9\s-]/gi, '');
	  return str;
	},
	to_url : function (string) {
		return encodeURIComponent(string)
	},
	split : function (str, splitter) { 
		return str.split(splitter); 
	},
	to_json : function (string) {
		return JSON.parse(string);
	},
	get_last_substr : function (str, total) {
		str.substr(str.length - total);
	},
	rmv_last_char : function (str) {
		return str.slice(0, -1);
	},
	get_num : function (str) {
		var numb = str.match(/\d/g);
		if (numb != null)
			numb = numb.join("");
		else 
			numb = ""
		return numb;
	},
	get_substr_between : function (str, from_substr, to_substr) {
		return str.split(from_substr).pop().split(to_substr)[0];
	}
}

function shade_set() {
	LGen.set_func({'val':'str','func':LGen.str})
	delete LGen.str
}
shade_set()