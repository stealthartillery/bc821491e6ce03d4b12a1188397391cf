LGen.req = {
	to_server : function (obj_req) {
		// if (LGen.app.get({'safe':'safe'}).status !== 'dep') {
		// 	return false;
		// }
		if (!navigator.onLine) {
			if (LGen.Page.current !== '')
				LGen.component.offline.previous_page = ''
			LGen.Page.change('offline')
			return false;
		}
		LGen.call({'c':'gen','f':'is_online'}) (
			function () {
				if (obj_req['method'] == 'get') {
					LGen.request = $.ajax({
				    type: "GET",
				    url: obj_req['url'],
				    // contentType: "text/plain",
				    // dataType: "text",
				    success: function(obj_res) { obj_req['callback'](obj_res); },
				    error: function(e) { lprint(e.responseText); }
					});  
				}
				else if (obj_req['method'] == 'post') {
				  var data = {};
				  data[DATA] = obj_req['data']
					LGen.request = $.ajax({
				    type: "POST",
				    url: obj_req['url'],
				    data: JSON.stringify(data),
				    // contentType: "application/json;",
				    // dataType: "json",
				    success: function(obj) { obj_req['callback'](obj); },
				    error: function(e) { lprint(e.responseText); }
					});  
				}
			},
			function() {
				LGen.Page.change('offline')
				return false;
			}
		)
	},
	get : function (url, data, callback) {
		if (data == undefined) data = function() {}
		lprint(LGen.system.get({'safe':'safe'}).fe_url+url+'?f='+encodeURI(LGen.call({'c':'black','f':'get'})({'val':data,'safe':'safe'})))
		LGen.call({'c':'req','f':'to_server'})({	
			'method':'get', 
			'url':LGen.system.get({'safe':'safe'}).fe_url+url+'?f='+encodeURI(LGen.call({'c':'black','f':'get'})({'val':data,'safe':'safe'})), 
			'callback':function(obj) {
				// lprint(url, obj)
				if (obj !== undefined) 
					callback(LGen.call({'c':'white','f':'get'})({'val':obj,'safe':'safe'}))
			}
		})
	},
	post : function (url, data, callback=function() {}) {
		lprint(LGen.system.get({'safe':'safe'}).fe_url+url)
		// lprint(data)
		LGen.call({'c':'req','f':'to_server'})({
			'method':'post',
			'url':LGen.system.get({'safe':'safe'}).fe_url+url, 
			'callback':function(obj) {
				// lprint(url, obj)
				if (obj !== undefined) 
					callback(LGen.call({'c':'white','f':'get'})({'val':obj,'safe':'safe'}))
			},
			'data': LGen.call({'c':'black','f':'get'})({'val':data,'safe':'safe'})
		})
	}
}


function shade_set() {
	LGen.set_func({'val':'req','func':LGen.req})
	delete LGen.req
}
shade_set()