LGen.Num = new NumMan()
LGen.NumMan = new NumMan()

function NumMan () {
	this.to_idr = to_idr
	function to_idr (x)  {
	  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}

	this.to_roman = to_roman
	function to_roman(num) {
	  var lookup = {M:1000,CM:900,D:500,CD:400,C:100,XC:90,L:50,XL:40,X:10,IX:9,V:5,IV:4,I:1},roman = '',i;
	  for ( i in lookup ) {
	    while ( num >= lookup[i] ) {
	      roman += i;
	      num -= lookup[i];
	    }
	  }
	  return roman;
	}
}