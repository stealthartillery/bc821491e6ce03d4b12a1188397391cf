/* ================================================================ */
var app = L.app.get(APP_ID)
if (app[RES_STAT] == NOT_EXIST) {
	// if (visitor.geo.countryName  == 'Indonesia')
	  app["LANG"] = 'id'
	// else
	//   app["LANG"] = 'en'
	L.app.set(APP_ID, app)
}

var LANG = app['LANG']

var URL = {}
URL['page'] = 'page_maintenance/' + LANG
var KEYS = Object.keys(URL);

var TXT = []
TXT.push('page')

var _page_set = function(){page_set()}

var SET = []
SET.push(_page_set)

var count = 0
text_get(count)

function text_get(count) {
 	json_read_local(BASE_URL + 'assets/'+APP_CODENAME+'/lang/'+URL[KEYS[count]], function(obj) {
		TXT[KEYS[count]] = obj
		SET[count]()
		count += 1
		if (count < KEYS.length) {
			text_get(count)
		}
	})
}
/* ================================================================ */

function page_set() {
	L.head.meta.add_desc(TXT['page']['tag']['meta']['description'])
	L.head.title_set(TXT['page']['tag']['title'])

	var elm = str_to_elm(
		'<div class="page_maintenance">'+
		'<table>'+
				'<tr>'+
					'<td>'+
						'<img src="'+BASE_URL+'assets/lite.img/under_construction.png" class="img">'+
  
					'</td>'+
				'</tr>'+
				'<tr>'+
					'<td>'+
						// '<span class="num404">404</span>'+
					'</td>'+
				'</tr>'+
				'<tr>'+
					'<td>'+
						'<div>'+TXT['page']['word']['page_under_maintenance']+'</div>'+
					'</td>'+
					'<td>'+
					'</td>'+
				'</tr>'+
				'<tr>'+
					'<td style="height: 70px">'+
						'<a href="'+HOME_URL+'" class="std home">'+TXT['page']['word']['back_to_home']+'</a>'+
					'</td>'+
					'<td>'+
					'</td>'+
				'</tr>'+
			'</table>'+
			'</div>'
			)
	L.body.add(elm)
}
