_globvar = new GlobVar()
_globvar.init()
delete _globvar

function GlobVar() {
	this.init = init
	function init() {
		console.log(window.location.pathname)
		LGen.JsonMan.read(BASE_URL+'assets/gen.obj/globvar.lgen', function(obj) {
			keys = LGen.JsonMan.get_keys(obj);
			for (var i=0; i<keys.length; i++) {
				LGen.GlobVar[keys[i]] = obj[keys[i]]
			}
		})
	}
}
