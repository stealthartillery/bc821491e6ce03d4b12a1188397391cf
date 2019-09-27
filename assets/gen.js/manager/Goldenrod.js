LGen.Goldenrod = new Goldenrod()

function Goldenrod () {

	this.get = get
	function get(url, func) {
		if (func == undefined) func = function() {}
		req_to_server({
			'method':'get', 
			'url':BE_URL+'goldenrod/?f='+encodeURI(url), 
			'callback':function(obj) {
				func(obj)
			}
		})
	}

	this.set = set
	function set(data, func) {
		if (func == undefined) func = function() {}
		req_to_server({
			'method':'post',
			'url':BE_URL+'goldenrod/', 
			'callback':function(obj) {
				func(obj)
			},
			'data': data
		})
	}
}