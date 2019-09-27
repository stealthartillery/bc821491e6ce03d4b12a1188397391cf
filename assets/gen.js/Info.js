LGen.component.info = new Info()
LGen.component.info.set()

function Info () {
	this.name = 'info'

	this.set = set
	function set () {
		var page = LGen.component.info
		page.screen = LGen.String.to_elm(
			'<div class="info" style="display: none;">'+
			'<div class="bground">'+
				'<div class="title theme theme_font">'+'Account Information'+'</div>'+
				'<div class="child point">'+
					'<div class="title theme theme_font">'+'Point'+'</div>'+
					'<input class="std gold val theme theme_font" value="" disabled/>'+
				'</div>'+
				'<div class="child silver">'+
					'<div class="title theme theme_font">'+'Silver'+'</div>'+
					'<input class="std gold val theme theme_font" value="" disabled/>'+
				'</div>'+
				'<button class="std gold purchase_silver_btn theme theme_font theme_color bgclr1 hover1">'+'Purchase Silver'+'</button>'+
				'<div class="child license" disabled>'+
					'<div class="title theme theme_font">'+'License'+'</div>'+
					'<div class="val theme theme_font">'+'</div>'+
				'</div>'+
				'<button class="std gold purchase_license_btn theme theme_font theme_color bgclr1 hover1">'+'Purchase License'+'</button>'+
				'<button class="std gold back_btn theme theme_font theme_color bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.title')},
			{"elm":page.screen.querySelector('.license .title')},
			{"elm":page.screen.querySelector('.purchase_silver_btn')},
			{"elm":page.screen.querySelector('.purchase_license_btn')},
			{"elm":page.screen.querySelector('.back_btn')}
		]
		LGen.Page.set_keys(page)
		page.set_event()
		LGen.Page.add(page)
	}

	this.set_event = set_event
	function set_event () {
		var page = LGen.component.info
		page.screen.querySelector('.back_btn').addEventListener('click', function() {
			LGen.Page.change(page.previous_page)
		})
		page.screen.querySelector('.purchase_silver_btn').addEventListener('click', function() {
			LGen.Page.open_new_tab('store.lanterlite.com/silver')
		})
		page.screen.querySelector('.purchase_license_btn').addEventListener('click', function() {
			LGen.Page.open_new_tab('store.lanterlite.com/')
		})
	}

	this.update = update
	function update() {
		var page = LGen.component.info

		LGen.Page.Self.update_css(page)
		LGen.Page.Self.update_font(page)
		LGen.Page.Self.update_color(page)
		LGen.Page.Self.update_lang(page)

		var _obj = {
			"json": {
				'gate':'savior', 'namelist':['point', 'silver'], 'def':'citizens', 
				'bridge':[{'id':'citizens', 'puzzled': true}, {'id':LGen.citizen.id, 'puzzled': false}]
			},
			"func": 'LGen("SaviorMan")->read'
		}
		LGen.f.send_get(LGen.system.be_domain+'/savior', _obj, function(obj){
			LGen.citizen.set(obj)

			page.screen.querySelector('.point input').value = LGen.citizen.point
			page.screen.querySelector('.silver input').value = LGen.citizen.silver
		})

		var _obj = {
			"json": {
				'gate':'savior', 'namelist':['type', 'id', 'created_date'], 'def':'licenses', 
				'bridge':[{'id':'citizens', 'puzzled': true}, {'id':LGen.citizen.id, 'puzzled': false}, {'id':'licenses', 'puzzled': true}]
			},
			"func": 'LGen("SaviorMan")->get_all'
		}
		LGen.f.send_get(LGen.system.be_domain+'/savior', _obj, function(obj){
			var _licenses = {}
			_licenses['licenses'] = obj
			LGen.citizen.set(_licenses)
			for (var i=0; i<LGen.citizen.licenses.length; i++) {
				var _elm = LGen.String.to_elm(
					'<div class="lgd">'+
						'<div class="type">'+LGen.Theme.get_name_by_type(LGen.citizen.licenses[i]['type'])+'</div>'+
						'<div class="date">'+LGen.citizen.licenses[i]['created_date']+'</div>'+
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
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.info
		page.update()
	}
}