
LGen.citizen = new function () {
	this.def_obj = LGen.call({'c':'black','f':'get'})({'val':	{
		"id":"",
		"email":"",
		"username":"",
		"fullname":"",
		"is_verified":0,
		"verification_code":"",
		"lang":"id",
		"theme_color":"ca01",
		"theme_font":"fa01",
		"fsize":"fs01",
		"gender":"",
		"address":"",
		"phonenum":"",
		"created_date":"",
		"silver":0,
		"licenses":[],
		"point":0
	},'safe':'safe'})
	this.obj = this.def_obj
	this.get = get
	function get(obj) {
		if (!LGen.Safe.system(this.get)) return LGen.stat.failed
		if (!LGen.Safe.param(obj, ['key'])) return LGen.stat.failed

		var cit = LGen.call({'c':'white','f':'get'})({'val':LGen.citizen.obj,'safe':'safe'})
		return cit[obj['key']]
	}

	this.set = set
	function set(obj) {
		if (!LGen.Safe.system(this.set)) return LGen.stat.failed
		if (!LGen.Safe.param(obj, ['key','val'])) return LGen.stat.failed
		LGen.citizen.obj[obj['key']] = LGen.call({'c':'black','f':'get'})({'val':obj['val'],'safe':'safe'})
		LGen.citizen.update_storage()
	}

	this.set_all = set_all
	function set_all(obj) {
		if (!LGen.Safe.system(this.set_all)) return LGen.stat.failed
		if (!LGen.Safe.param(obj, ['val'])) return LGen.stat.failed

		obj = obj['val']
		if (LGen.call({'c':'black','f':'check'})({'val':LGen.citizen.obj, 'safe':'safe'}))
			var cit = LGen.call({'c':'white','f':'get'})({'val':LGen.citizen.obj,'safe':'safe'})
		else
			var cit = {}
		if (obj.hasOwnProperty('id'))
			cit.id = obj['id']
		if (obj.hasOwnProperty('username'))
			cit.username = obj['username']
		if (obj.hasOwnProperty('fullname'))
			cit.fullname = obj['fullname']
		if (obj.hasOwnProperty('email'))
			cit.email = obj['email']
		if (obj.hasOwnProperty('gender'))
			cit.gender = obj['gender']
		if (obj.hasOwnProperty('phonenum'))
			cit.phonenum = obj['phonenum']
		if (obj.hasOwnProperty('address'))
			cit.address = obj['address']
		if (obj.hasOwnProperty('is_verified'))
			cit.is_verified = parseInt(obj['is_verified'])
		if (obj.hasOwnProperty('silver'))
			cit.silver = parseInt(obj['silver'])
		if (obj.hasOwnProperty('point'))
			cit.point = parseInt(obj['point'])
		if (obj.hasOwnProperty('lang') && cit.lang !== obj.lang)
			cit.lang = (obj['lang'])
		if (obj.hasOwnProperty('theme_color') && cit.theme_color !== obj.theme_color)
			cit.theme_color = (obj['theme_color'])
		if (obj.hasOwnProperty('theme_font') && cit.theme_font !== obj.theme_font)
			cit.theme_font = (obj['theme_font'])
		if (obj.hasOwnProperty('fsize') && cit.fsize !== obj.fsize)
			cit.fsize = (obj['fsize'])
		if (obj.hasOwnProperty('created_date'))
			cit.created_date = obj['created_date']
		if (obj.hasOwnProperty('verification_code'))
			cit.verification_code = obj['verification_code']
		if (obj.hasOwnProperty('licenses')) {
			cit.licenses = obj['licenses'].sort(function(a,b){
			  // Turn your strings into dates, and then subtract them
			  // to get a value that is either negative, positive, or zero.
			  return new Date(b.created_date) - new Date(a.created_date);
			});
		}

		if (cit.id !== '') {
			if (!$(LGen.component.header.acc.screen.querySelector('.img')).hasClass('active')) {
				$(LGen.component.header.acc.screen.querySelector('.img')).addClass('active')
			}
			if (LGen.component.account.screen.querySelector('span').innerText !== '@'+cit.username) {
				LGen.component.account.screen.querySelector('span').innerText = '@'+cit.username
			}
		}

		LGen.citizen.obj = LGen.call({'c':'black','f':'get'})({'val':cit,'safe':'safe'})
		LGen.storage.setItem('citizen', LGen.citizen.obj)

		if (obj.hasOwnProperty('lang'))
			LGen.Page.update('lang',(obj['lang']))
		if (obj.hasOwnProperty('theme_color'))
			LGen.Theme.new_change_clr(obj['theme_color'])
			// LGen.Page.update('theme_color',(obj['theme_color']))
		if (obj.hasOwnProperty('theme_font'))
			LGen.Theme.new_change_ft(obj['theme_font'])
			// LGen.Page.update('theme_font',(obj['theme_font']))
		if (obj.hasOwnProperty('fsize'))
			LGen.Theme.new_change_fs(obj['fsize'])
			// LGen.Page.update('fsize',(obj['fsize']))

		if (cit.id !== '') {
			var _obj = Object.keys(obj)
			LGen.citizen.update_savior({'namelist':_obj})
		}
	}

	this.set_default = set_default
	function set_default() {
		
		if (LGen.component.hasOwnProperty('header') && $(LGen.component.header.acc.screen.querySelector('.img')).hasClass('active'))
			$(LGen.component.header.acc.screen.querySelector('.img')).removeClass('active')

		LGen.citizen.obj = this.def_obj
		// LGen.citizen.obj = LGen.call({'c':'black','f':'get'})({'val':cit,'safe':'safe'})
		LGen.storage.setItem('citizen', LGen.citizen.obj)
		var citizen = LGen.call({'c':'white','f':'get'})({'val':this.def_obj,'safe':'safe'})
		LGen.Page.update('lang', LGen.Page.def_lang)
		LGen.Theme.new_change_clr(citizen['theme_color'])
		LGen.Theme.new_change_ft(citizen['theme_font'])
		LGen.Theme.new_change_fs(citizen['fsize'])
		// LGen.Page.update('theme_color', LGen.Page.def_color)
		// LGen.Page.update('theme_font', LGen.Page.def_font)
		// LGen.Page.update('fsize', LGen.Page.def_fsize)
	}

	this.update_storage = update_storage
	function update_storage() {
		// if (!LGen.Safe.system(this.update_storage)) return LGen.stat.failed

		// var _obj = {}
		// var keys = Object.keys(LGen.citizen.obj)
		// for (var i=0; i<keys.length; i++) {
		// 	_obj[keys[i]] = LGen.call({'c':'white','f':'get'})({'val':LGen.citizen.obj[keys[i]],'safe':'safe'})
		// }
		// LGen.storage.setItem('citizen', _obj)
	}

	this.update_savior = update_savior
	function update_savior(obj) {
		if (!LGen.Safe.system(this.update_savior)) return LGen.stat.failed

		var val = {}
		var cit = LGen.call({'c':'white','f':'get'})({'val':LGen.citizen.obj,'safe':'safe'})
    for (var i=0; i<obj['namelist'].length; i++)
    	val[obj['namelist'][i]] = cit[obj['namelist'][i]]
    delete val['silver']
    delete val['created_date']
    delete val['is_verified']
    delete val['point']
    delete val['licenses']
    delete val['verification_code']
		var _obj = {
			"json": {
				// 'namelist':obj['namelist'],
				'def':'citizens', 
				'val': val, 
				'bridge':[
					{'id':'citizens', 'puzzled': true},
					{'id': LGen.citizen.get({'key':'id','safe':'safe'}), 'puzzled': false}
				]
			},
			"func": 'LGen("SaviorMan")->update'
		}
		LGen.call({'c':'req','f':'post'})(LGen.system.get({'safe':'safe'}).citizen_domain+'/gate', _obj, function(obj){})
	}
}

