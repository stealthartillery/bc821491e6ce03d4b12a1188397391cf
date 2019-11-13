(function() {
	LGen.obj.read(BASE_URL+'assets/gen.obj/globvar.lgen', function(obj) {
		var keys = Object.keys(obj);
		for (var i=0; i<keys.length; i++) {
			LGen.GlobVar[keys[i]] = obj[keys[i]]
		}
	})
})()