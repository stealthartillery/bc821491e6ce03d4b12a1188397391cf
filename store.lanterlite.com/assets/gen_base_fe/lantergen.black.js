

Black = Shade = {

	check : function (obj) { // cek black
		if (!LGen.Safe.system(arguments.callee)) return LGen.stat.failed
		if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed
		var str = obj['val']
		// var _d = Array.from("DRJ42ulf7ShBjzwq9gEra1FYNtWOM6bdQXTepVvPmLiUCG0x3k8AoK5cyIHZsn_")

		if (typeof (str) !== 'string')
			return false
		if (str.length<15)
			return false
		if (str.substr(0,3) !== 'LTS')
			return false
		if (isNaN(parseInt(str[6])))
			return false
		return true
	},

	get : function (obj) {
		if (!LGen.Safe.system(arguments.callee)) return LGen.stat.failed
		if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed
		var str = obj['val']
		var s1 = step1({'val':str,'safe':'safe'})
		var s2 = step2({'val':s1,'safe':'safe'})
		var s3 = step3({'val':s2,'safe':'safe'})
		var s4 = step4({'val':s3,'safe':'safe'})
		var s5 = step5({'val':s4,'safe':'safe'})
		return s5


		function step1(obj) { // json to string
			// if (!LGen.Safe.system(this.step1)) return LGen.stat.failed
			if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed

			var str = obj['val']
			var asd = JSON.stringify(str);
			asd = encodeURIComponent(asd);
		  return asd
		}

		function step2(obj) { // encode base64
			// if (!LGen.Safe.system(this.step2)) return LGen.stat.failed
			if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed

			var key_str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/="
			var str = obj['val']
	    var output = "";
	    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
	    var i = 0;
	    str = prop({'val':str,'safe':'safe'});
	    while (i < str.length) {
	      chr1 = str.charCodeAt(i++);
	      chr2 = str.charCodeAt(i++);
	      chr3 = str.charCodeAt(i++);
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
	      key_str.charAt(enc1) + key_str.charAt(enc2) +
	      key_str.charAt(enc3) + key_str.charAt(enc4);
	    }
	    return output;

	  	function prop(obj) {
				if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed

				var str = obj['val']
			  str = str.replace(/\r\n/g,"\n");
			  var utftext = "";
			  for (var n = 0; n < str.length; n++) {
			    var c = str.charCodeAt(n);
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
			}
		}

		function step3(obj) { // hide =
			// if (!LGen.Safe.system(this.step3)) return LGen.stat.failed
			if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed
			var str = obj['val']
		  return str.replace(/\+/g, '-').replace(/\//g, '_').replace(/\=+$/, '');
		}

		function step4(obj) { // algoritma 57
			// if (!LGen.Safe.system(this.step4)) return LGen.stat.failed
			if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed
			var str = obj['val']
			var asd = (rand(5)+str)
			return asd.substring(0,asd.length-5)+rand(7)+asd.substring(asd.length-5,asd.length)
			function rand(length) {
				var result           = '';
				var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
				var charactersLength = characters.length;
				for ( var i = 0; i < length; i++ )
					result += characters.charAt(Math.floor(Math.random() * charactersLength));
				return result;
			}
		}

		function step5(obj) { // naik per index sebesar index
			// if (!LGen.Safe.system(this.step5)) return LGen.stat.failed
			if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed
			var str = obj['val']
			// var _d = Array.from("Ya4NeRmjO3`xi(_lJ[X!b~^o %&PLZDU;12fp*+d{VE|u/:Ar0?8sq>}w6QSk7W@GTh.,Fn#tc$z5y]_=IKvg)-B<HCM9")
			// var _d = [
			// 	Array.from("DRJ42ulf7ShBjzwq9gEra1FYNtWOM6bdQXTepVvPmLiUCG0x3k8AoK5cyIHZsn"),
			// 	Array.from("QakDy61n5vBXsgjw9zLmJKcPuSIdMZqtfUWbhp4eR73HNlCT082VoAGiOrFYxE"),
			// 	Array.from("8UcvC5lARsBi6krdFm9fDEVeQnJXy0gxKq3ouOSGzZIT4Mb2jLN17WpaPHtwhY"),
			// 	Array.from("Zl6pbiEB8HOcxsj5IgLUXaqrzdRy7Sw0m2VuFNAWKPtYGCkhM194v3DTnJofeQ"),
			// 	Array.from("EsUil1x7qkNfdoOIyv3zS8Ar9nPVebCJMDFah5Kp0YZ6GjtH4BRcuWgTw2XLQm"),
			// 	Array.from("4eT0LMHbjc7pztmrkUs8wWl2qN1EoSdXZ3iPFIg5Ja9ADBvQnyCRf6uhGxYVKO")
			// ]
			var _d = "QakDy61n5vBXsgjw9zLmJKcPuSIdMZqtfUWbhp4eR73HNlCT082VoAGiOrFYxE"
			var num = Math.floor(Math.random() * 10); 
			for (var i=0; i<num; i++) {
				_d = step5a({'val':_d,'safe':'safe'})
			}
			_d = Array.from(_d)
			var str2 = ''
			for (var i=0; i<str.length; i++) {
				if (!is_val_exist(_d, str[i]))
					str2 += str[i]
				else
					str2 += _d.hasOwnProperty(_d.indexOf(str[i])+1)? _d[_d.indexOf(str[i])+1]: _d[_d.indexOf(str[i])+1-_d.length];
				// str2 += _d[(_d.indexOf(str[i])+i)%_d.length];
			}
				// str2 += (_d.hasOwnProperty(_d.indexOf(str[i])-i) && _d.hasOwnProperty(_d.indexOf(str[i])+i))? _d[_d.indexOf(str[i])+i] : str[i];
			str2 = add_val_by_index(str2, num, 3);
			str2 = 'LTS'+str2;
			return str2
			function is_val_exist(arr, text) {
				return (arr.indexOf(text) === -1)? false : true
			}
			function add_val_by_index(str, val, index) {
				return str.slice(0, index) + val + str.slice(index);
			}
			function step5a(obj) { // naikin alfabet
				// if (!LGen.Safe.system(this.step5a)) return LGen.stat.failed
				if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed
				var str = obj['val']
				var _d = Array.from("DRJ42ulf7ShBjzwq9gEra1FYNtWOM6bdQXTepVvPmLiUCG0x3k8AoK5cyIHZsn")
				var str2 = ''
				for (var i=0; i<str.length; i++) {
					if (!is_val_exist(_d, str[i]))
						str2 += str[i]
					else
						str2 += _d.hasOwnProperty(_d.indexOf(str[i])+1)? _d[_d.indexOf(str[i])+1]: _d[_d.indexOf(str[i])+1-_d.length];
				}
				return str2
				function is_val_exist(arr, text) {
					return (arr.indexOf(text) === -1)? false : true
				}
			}
		}
	},

	mini : function (obj) { // naik per index sebesar index
		if (!LGen.Safe.system(arguments.callee)) return LGen.stat.failed
		if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed

		var str = obj['val']
		var _d = "QakDy61n5vBXsgjw9zLmJKcPuSIdMZqtfUWbhp4eR73HNlCT082VoAGiOrFYxE"
		_d = Array.from(_d)
		var str2 = ''
		for (var i=0; i<str.length; i++) {
			if (!is_val_exist(_d, str[i]))
				str2 += str[i]
			else
				str2 += _d.hasOwnProperty(_d.indexOf(str[i])+1)? _d[_d.indexOf(str[i])+1]: _d[_d.indexOf(str[i])+1-_d.length];
		}
		return str2
		function is_val_exist(arr, text) {
			return (arr.indexOf(text) === -1)? false : true
		}	
	},
}


// Shade = new Black
// LGen.Black = new Black;
var shade_set = function () {
	LGen.be = (Black).get({'val':'Black','safe':'safe'})
	LGen.sf[LGen.be] = Shade
	LGen.set_func({'val':'black','func':Black})
	// var asd = new Black
	delete LGen.sf[LGen.be]
	delete LGen.be
}


shade_set()
delete Black
delete Shade	
shade_set = function () {}