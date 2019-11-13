White = Shade = {

	get : function (obj) {
		if (!LGen.Safe.system(arguments.callee)) return LGen.stat.failed
		if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed

		if (obj['val'] === undefined)
			return ''
		var str = obj['val']
		var s5 = step5({'val':str,'safe':'safe'})
		var s4 = step4({'val':s5,'safe':'safe'})
		var s3 = step3({'val':s4,'safe':'safe'})
		var s2 = step2({'val':s3,'safe':'safe'})
		var s1 = step1({'val':s2,'safe':'safe'})
		// lprint(obj, s1)
		return s1
		// return LGen.White.step1(LGen.White.step2(LGen.White.step3(LGen.White.step4(LGen.White.step5(str)))))

		function step5(obj) {
			if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed
			var str = obj['val']
			str = str.substr(3,str.length)
			// var _d = Array.from("DRJ42ulf7ShBjzwq9gEra1FYNtWOM6bdQXTepVvPmLiUCG0x3k8AoK5cyIHZsn_")
			var _d = "QakDy61n5vBXsgjw9zLmJKcPuSIdMZqtfUWbhp4eR73HNlCT082VoAGiOrFYxE"
			var num = parseInt(str[3]);
			str = rmv_val_by_index(str, 3);
			for (var i=0; i<num; i++) {
				_d = step5a({'val':_d,'safe':'safe'})
			}
			_d = Array.from(_d)
			var str2 = ''
			for (var i=0; i<str.length; i++) {
				if (!is_val_exist(_d, str[i]))
					str2 += str[i]
				else
					str2 += _d.hasOwnProperty(_d.indexOf(str[i])-1)? _d[_d.indexOf(str[i])-1]: _d[_d.indexOf(str[i])-1+_d.length];
				// var index = _d.indexOf(str[i])-i
				// if (index<0)
				// 	index = _d.length-(Math.abs(_d.indexOf(str[i])-i)%_d.length)
				// str2 += _d[index]
				// str2 += (_d.hasOwnProperty(_d.indexOf(str[i])-i) && _d.hasOwnProperty(_d.indexOf(str[i])+i))? str[i] : str[i];
			}
			// str2 += _d[Math.abs(_d.indexOf(str[i])-i%_d.length)];
			return str2
			function is_val_exist(arr, text) {
				return (arr.indexOf(text) === -1)? false : true
			}
			function rmv_val_by_index(str,index) {
				return str.slice(0, index) + str.slice(index+1);
			}
			function step5a(obj) { // naikin alfabet
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

		function step4(obj) {
			if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed
			var str = obj['val']
			return (str.slice(0,str.length-12)+str.slice(str.length-5)).slice(5,(str.slice(0,str.length-12)+str.slice(str.length-5)).length)
		}

		function step3(obj) {
			if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed
			var str = obj['val']
	    if (str.length % 4 != 0)
	      str += ('===').slice(0, 4 - (str.length % 4));
	    return str.replace(/-/g, '+').replace(/_/g, '/');
		}

		function step2(obj) {
			if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed
			var key_str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/="
			var str = obj['val']
	    var output = "";
	    var chr1, chr2, chr3;
	    var enc1, enc2, enc3, enc4;
	    var i = 0;
	    str = str.replace(/[^A-Za-z0-9\+\/\=]/g, "");
	    while (i < str.length) {
	      enc1 = key_str.indexOf(str.charAt(i++));
	      enc2 = key_str.indexOf(str.charAt(i++));
	      enc3 = key_str.indexOf(str.charAt(i++));
	      enc4 = key_str.indexOf(str.charAt(i++));
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
	    output = prop({'val':output,'safe':'safe'});
	    return output;

			function prop(obj) {
				if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed
				var str = obj['val']
		    var string = "";
		    var i = 0;
		    var c = c1 = c2 = 0;
		    while ( i < str.length ) {
		      c = str.charCodeAt(i);
		      if (c < 128) {
		        string += String.fromCharCode(c);
		        i++;
		      }
		      else if((c > 191) && (c < 224)) {
		        c2 = str.charCodeAt(i+1);
		        string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
		        i += 2;
		      }
		      else {
		        c2 = str.charCodeAt(i+1);
		        c3 = str.charCodeAt(i+2);
		        string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
		        i += 3;
		      }
		    }
		    return string;
			}
		}

		function step1(obj) {
			if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed
			var str = obj['val']
			str = decodeURIComponent(str).replace(/\+/g,' ')
			if (str !== '')
				str = JSON.parse(str)
			return str
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
				str2 += _d.hasOwnProperty(_d.indexOf(str[i])-1)? _d[_d.indexOf(str[i])-1]: _d[_d.indexOf(str[i])-1+_d.length];
		}
		return str2
		function is_val_exist(arr, text) {
			return (arr.indexOf(text) === -1)? false : true
		}
	}
}

var shade_set = function () {
	// LGen.wd = LGen.call({'c':'black','f':'get'})({'val':'White','safe':'safe'})
	LGen.set_func({'val':'white','func':White})
	// LGen.sf[LGen.wd] = new Shade
	delete White
	delete Shade
}
shade_set()
shade_set = function () {}