LGen.num = {
	rand : function (length) {
		var result           = '';
		var characters       = '0123456789';
		var charactersLength = characters.length;
		for ( var i = 0; i < length; i++ )
			result += characters.charAt(Math.floor(Math.random() * charactersLength));
		return result;
	},
	to_idr : function (x)  {
	  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	},
	to_roman : function (num) {
	  var lookup = {M:1000,CM:900,D:500,CD:400,C:100,XC:90,L:50,XL:40,X:10,IX:9,V:5,IV:4,I:1},roman = '',i;
	  for ( i in lookup ) {
	    while ( num >= lookup[i] ) {
	      roman += i;
	      num -= lookup[i];
	    }
	  }
	  return roman;
	},
	gen_rand : function (from, to) {
		return Math.floor(Math.random() * (to - from + 1)) + from
	}
}


function shade_set() {
	LGen.set_func({'val':'num','func':LGen.num})
	delete LGen.num
}
shade_set()