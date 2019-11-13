LGen.component.info = new Info()
LGen.component.info.set()

function Info () {
	this.name = 'info'

	this.set = set
	function set () {
		var page = LGen.component.info
		page.screen_footbar = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="_footbar n1 theme fp">'+
				'<button class="std gold back theme fp bgclr1 hover1">'+LGen.icon.theme('left')+'</button>'+
			'</div>'
		)
		page.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="lgen_page_info" style="display: none;">'+
			'<div class="bground">'+
			'<div class="content">'+
				'<div class="title theme fttl">'+'Account Information'+'</div>'+
				'<div class="child point">'+
					'<div class="title theme fp">'+'Point'+'</div>'+
					'<input class="std gold val theme fp" value="" disabled/>'+
				'</div>'+
				'<div class="child silver">'+
					'<div class="title theme fp">'+'Silver'+'</div>'+
					'<input class="std gold val theme fp" value="" disabled/>'+
				'</div>'+
				'<button class="std gold purchase_silver_btn theme fp bgclr1 hover1">'+'Purchase Silver'+'</button>'+
				'<div class="child license" disabled>'+
					'<div class="title theme fp">'+'License'+'</div>'+
					'<div class="val theme fp">'+'</div>'+
				'</div>'+
				'<button class="std gold purchase_license_btn theme fp bgclr1 hover1">'+'Purchase License'+'</button>'+
				// '<button class="std gold back_btn theme fp bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.title')},
			{"elm":page.screen.querySelector('.license .title')},
			{"elm":page.screen.querySelector('.purchase_silver_btn')},
			{"elm":page.screen.querySelector('.purchase_license_btn')},
			// {"elm":page.screen.querySelector('.back_btn')}
		]
		page.set_event()
		LGen.Page.init(page)
		LGen.component.header.hide_when_scroll2(page.screen.querySelector('.bground'))
	}

	this.set_event = set_event
	function set_event () {
		var page = LGen.component.info
		LGen.set_button(page.screen_footbar.querySelector('.back'))
		LGen.set_button_click(page.screen_footbar.querySelector('.back'), function() {
			LGen.Page.change(page.previous_page)
		})
		// LGen.set_button(page.screen.querySelector('.back_btn'))
		// LGen.set_button_click(page.screen.querySelector('.back_btn'), function() {
		// 	LGen.Page.change(page.previous_page)
		// })
		LGen.set_button(page.screen.querySelector('.purchase_silver_btn'))
		LGen.set_button_click(page.screen.querySelector('.purchase_silver_btn'), function() {
			LGen.Page.open_new_tab('store.lanterlite.com/silver')
		})
		LGen.set_button(page.screen.querySelector('.purchase_license_btn'))
		LGen.set_button_click(page.screen.querySelector('.purchase_license_btn'), function() {
			LGen.Page.open_new_tab('store.lanterlite.com/')
		})
	}

	this.update = update
	function update() {
		var page = LGen.component.info

		LGen.Page.Self.update(page)

		if (navigator.onLine)
			page.update2()
		else {
			page.screen.querySelector('.point input').value = LGen.citizen.get({'key':'point','safe':'safe'})
			page.screen.querySelector('.silver input').value = LGen.citizen.get({'key':'silver','safe':'safe'})
			var _licenses = LGen.citizen.get({'key':'licenses','safe':'safe'})
			for (var i=0; i<_licenses.length; i++) {
				var _elm = LGen.call({'c':'str', 'f':'to_elm'})(
					'<div class="lgd">'+
						'<div class="type theme fp">'+LGen.Theme.get_name_by_type(_licenses[i]['type'])+'</div>'+
						'<div class="date">'+LGen.call({'c':'date','f':'to_local'})(_licenses[i]['created_date'])+'</div>'+
					'</div>'
				)
				page.screen.querySelector('.license .val').appendChild(_elm)
			}
		}
	}

	// get online
	this.update2 = function () {
		var page = LGen.component.info

		LGen.Page.Self.update(page)

		var _obj = {
			"json": {
				'gate':'savior', 'namelist':['point', 'silver'], 'def':'citizens', 
				'bridge':[{'id':'citizens', 'puzzled': true}, {'id':LGen.citizen.get({'key':'id','safe':'safe'}), 'puzzled': false}]
			},
			"func": 'LGen("SaviorMan")->read'
		}
		LGen.call({'c':'req','f':'get'})(LGen.system.get({'safe':'safe'}).citizen_domain+'/gate', _obj, function(obj){
			LGen.citizen.set_all({'val':obj,'safe':'safe'})

			page.screen.querySelector('.point input').value = LGen.citizen.get({'key':'point','safe':'safe'})
			page.screen.querySelector('.silver input').value = LGen.citizen.get({'key':'silver','safe':'safe'})
		})

		var _obj = {
			"json": {
				'gate':'savior', 'namelist':['type', 'id', 'created_date'], 'def':'licenses', 
				'bridge':[{'id':'citizens', 'puzzled': true}, {'id':LGen.citizen.get({'key':'id','safe':'safe'}), 'puzzled': false}, {'id':'licenses', 'puzzled': true}]
			},
			"func": 'LGen("SaviorMan")->get_all'
		}
		LGen.call({'c':'req','f':'get'})(LGen.system.get({'safe':'safe'}).citizen_domain+'/gate', _obj, function(obj){
			var _licenses = {}
			_licenses['licenses'] = obj
			LGen.citizen.set_all({'val':_licenses,'safe':'safe'})
			// LGen.citizen.set({'key':'licenses','val':_licenses,'safe':'safe'})
			for (var i=0; i<_licenses.licenses.length; i++) {
				var _elm = LGen.call({'c':'str', 'f':'to_elm'})(
					'<div class="lgd">'+
						'<div class="type">'+LGen.Theme.get_name_by_type(_licenses.licenses[i]['type'])+'</div>'+
						'<div class="date">'+LGen.call({'c':'date','f':'to_local'})(_licenses.licenses[i]['created_date'])+'</div>'+
					'</div>'
				)
				page.screen.querySelector('.license .val').appendChild(_elm)
			}
		})
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.info
		LGen.Page.clear_childs(page.screen.querySelector('.license .val'))
		page.previous_page = ''
		LGen.component.footbar.clear()
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.info
		page.update()
		LGen.component.footbar.add_plain(page.screen_footbar)
		LGen.component.footbar.show()
		LGen.component.header.show()
	}
}