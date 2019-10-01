LGen.String = new StringMan()
LGen.StringMan = new StringMan()

function StringMan () {
	
	this.to_arr = to_arr
	function to_arr(str, parser) {
		if (parser === undefined)
			parser = ' '
		return str.split('', parser)
	}

	this.to_elms = to_elms
	function to_elms(htmlString) {
	  var template = document.createElement('template');
	  template.innerHTML = html;
	  return template.content.childNodes;
	}

	this.to_elm = to_elm
	function to_elm(htmlString) {
	  var template = document.createElement('template');
	  html = htmlString.trim(); // Never return a text node of whitespace as the result
	  template.innerHTML = html;
	  return template.content.firstChild;
	      // var div = document.createElement('div');
	  // div.innerHTML = htmlString.trim();

	  // // Change this to div.childNodes to support multiple top-level nodes
	  // return div.firstChild; 
	}

	this.to_title_case = to_title_case
	function to_title_case(str) {
	   var splitStr = str.toLowerCase().split(' ');
	   for (var i = 0; i < splitStr.length; i++) {
	       // You do not need to check if i is larger than splitStr length, as your for does that for you
	       // Assign it back to the array
	       splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
	   }
	   // Directly return the joined string
	   return splitStr.join(' '); 
	}

	this.is_aphanumeric = is_aphanumeric
	function is_aphanumeric(str) {
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
	};

	this.to_alphanumeric = to_alphanumeric
	function to_alphanumeric(string) {
		return string.replace(/[^a-z0-9]/gi,'')
	}

	this.clean = clean
	function clean(string) {
	  var str = string.toLowerCase()
	  str = str.replace(/<i>/gi, '');
	  str = str.replace(/<\/i>/gi, '');
	  str = str.replace(/<b>/gi, '');
	  str = str.replace(/<\/b>/gi, '');
	  str = str.replace(/[^A-Za-z0-9\s-]/gi, '');
	  return str;
	}

	this.to_url = to_url
	function to_url(string) {
		return encodeURIComponent(string)
	}

	this.split = split
	function split(str, splitter) { 
		return str.split(splitter); 
	}

	this.to_json = to_json
	function to_json(string) {
		return JSON.parse(string);
	}

	this.get_last_substr = get_last_substr
	function get_last_substr(str, total) {
		str.substr(str.length - total);
	}

	this.rmv_last_char = rmv_last_char
	function rmv_last_char(str) {
		return str.slice(0, -1);
	}

	this.get_num = get_num
	function get_num(str) {
		var numb = str.match(/\d/g);
		if (numb != null)
			numb = numb.join("");
		else 
			numb = ""
		return numb;
	}


	function get_substr_between(str, from_substr, to_substr) {
		return str.split(from_substr).pop().split(to_substr)[0];
	}



	function to_json_str(string) {
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

}