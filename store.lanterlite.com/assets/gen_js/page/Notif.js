LGen.component.notif = new Notif()
LGen.component.notif.set()

function Notif () {
	this.name = 'notif'

	this.set = set
	function set () {
		var page = LGen.component.notif
		page.screen_footbar = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="_footbar n1 theme fp">'+
				'<button class="std gold back theme fp bgclr1 hover1">'+LGen.icon.theme('left')+'</button>'+
			'</div>'
		)
		page.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="notif theme_font" style="display: none;">'+
			'<div class="bground">'+
			'<div class="content">'+
				'<div class="title theme fttl">'+'Help'+'</div>'+
				'<div class="child">'+
				'</div>'+
				// '<button class="std gold back_btn theme fp bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.bground .title')},
			// {"elm":page.screen.querySelector('.bground .back_btn')},
		]


		page.set_event()
		LGen.Page.init(page)
		LGen.component.header.hide_when_scroll2(page.screen.querySelector('.bground'))
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.notif
		LGen.set_button(page.screen_footbar.querySelector('.back'))
		LGen.set_button_click(page.screen_footbar.querySelector('.back'), function() {
			LGen.Page.change(page.previous_page)
		})
		// LGen.set_button(page.screen.querySelector('.back_btn'))
		// LGen.set_button_click(page.screen.querySelector('.back_btn'), function() {
		// 	LGen.Page.change(page.previous_page)
		// })
	}

	this.update = update
	function update() {
		var page = LGen.component.notif
		// LGen.Page.Self.update(page)

		LGen.call({'c':'gen','f':'read_file'})(LGen.system.get({'safe':'safe'}).base_url+'assets/gen_obj/help.lgen', function(obj) {
		// LGen.call({'c':'gen','f':'read_file'})(LGen.system.get({'safe':'safe'}).base_url+'assets/gen_obj/help/'+LGen.citizen.get({'key':'lang','safe':'safe'})+'.lgen', function(obj) {
		// LGen.call({'c':'gen','f':'read_file'})(LGen.system.get({'safe':'safe'}).home_url+'app/lang/page/help/'+LGen.citizen.get({'key':'lang','safe':'safe'})+'.lgen', function(obj) {
		// LGen.call({'c':'req','f':'read_local'})(LGen.system.get({'safe':'safe'}).home_url+'app/lang/page/content/'+LGen.citizen.get({'key':'lang','safe':'safe'}), function(obj) {
			// lprint(obj)
			for (var i=0; i<obj.length; i++) {
				var name = LGen.translator.get({"from_lang":"en","words":obj[i].name})
				var elm = LGen.call({'c':'str', 'f':'to_elm'})(
					'<div class="val theme hover2">'+
						'<div class="title theme fp">'+name+'</div>'+
						// '<div class="content theme fp" style="display: none;">'+decodeURIComponent((obj[i]['content_'+LGen.citizen.get({'key':'lang','safe':'safe'})]))+'</div>'+
						// '<div class="date">'+LGen.call({'c':'date','f':'to_local'})(atob(obj[i]['created_date']))+'</div>'+
					'</div>'
				)
				LGen.set_button(elm)
				LGen.set_button_click(elm, LGen.call({'c':'gen','f':'create'})(obj[i]['func']))
				page.screen.querySelector('.notif .child').appendChild(elm)
			}
			// LGen.Page.set_css(page.screen.querySelector('.notif .child'))
			// LGen.Page.Self.update_css(page.screen.querySelector('.notif .child'))
			LGen.Page.Self.update(page)
		})
	}
	this.update2 = update2
	function update2() {
		var page = LGen.component.notif
		LGen.Page.Self.update(page)

		var _obj = {
			"json" : {'def':'helps', 'namelist':[
				'title_'+LGen.citizen.get({'key':'lang','safe':'safe'}), 
				'content_'+LGen.citizen.get({'key':'lang','safe':'safe'}), 
				'created_date'], 'bridge':[{'id':'helps', 'puzzled': true}]},
			"func" : 'LGen("SaviorMan")->get_all'
		}
		LGen.call({'c':'req','f':'get'})(LGen.system.get({'safe':'safe'}).be_domain+'/gate', _obj, function(obj){
			for (var i=0; i<obj.length; i++) {
				var elm = LGen.call({'c':'str', 'f':'to_elm'})(
					'<div class="val theme hover2">'+
						'<div class="title theme fp">'+obj[i].name+'</div>'+
						// '<div class="content theme fp" style="display: none;">'+decodeURIComponent((obj[i]['content_'+LGen.citizen.get({'key':'lang','safe':'safe'})]))+'</div>'+
						// '<div class="date">'+LGen.call({'c':'date','f':'to_local'})(atob(obj[i]['created_date']))+'</div>'+
					'</div>'
				)
				LGen.set_button(elm)
				LGen.set_button_click(elm, LGen.call({'c':'gen','f':'create'})(obj[i]['func']))
				page.screen.querySelector('.notif .child').appendChild(elm)
			}
			// LGen.Page.set_css(page.screen.querySelector('.notif .child'))
			// LGen.Page.Self.update_css(page.screen.querySelector('.notif .child'))
		})
	}

	// this.update2 = update2
	// function update2() {
	// 	// var asd = {'gate':'backlite', 'limited': false, 'namelist':['point', 'silver'], 'def':'citizens', 'bridge':[{'id':'citizens', 'puzzled': true}, {'id':LGen.citizen.id, 'puzzled': false}]}
	// 	// LGen.call({'c':'req','f':'get'})(LGen.system.get({'safe':'safe'}).be_domain+'/savior', '$citizen->read('+LGen.obj.to_php_str(asd)+')', function(obj){
	// 	// 	// lprint(obj)

	// 	// 	LGen.citizen.point = atob(obj['point'])
	// 	// 	LGen.citizen.silver = atob(obj['silver'])

	// 	// 	LGen.component.notif.screen.querySelector('.point input').value = LGen.citizen.point
	// 	// 	LGen.component.notif.screen.querySelector('.silver input').value = LGen.citizen.silver
	// 	// })

	// 	var asd = {'gate':'savior', 'limited': false, 'namelist':['title', 'content', 'created_date'], 'def':'notifications', 'bridge':[
	// 		{'id':'citizens', 'puzzled': true}, 
	// 		{'id':LGen.citizen.id, 'puzzled': false}, 
	// 		{'id':'notifications', 'puzzled': true}
	// 	]}
	// 	LGen.call({'c':'req','f':'get'})(LGen.system.get({'safe':'safe'}).be_domain+'/savior', '$citizen->get_all('+LGen.obj.to_php_str(asd)+')', function(obj){
	// 		// lprint(obj)
	// 		for (var i=0; i<obj.length; i++) {
	// 			var elm = LGen.call({'c':'str', 'f':'to_elm'})(
	// 				'<div class="val">'+
	// 					'<div class="title">'+atob(obj[i]['title'])+'</div>'+
	// 					'<div class="content" style="display: none;">'+atob(obj[i]['content'])+'</div>'+
	// 					// '<div class="date">'+LGen.call({'c':'date','f':'to_local'})(atob(obj[i]['created_date']))+'</div>'+
	// 				'</div>'
	// 			)
	// 			elm.addEventListener('click', function() {
	// 				var _elm = this.querySelector('.content').outerHTML
	// 				_elm = LGen.call({'c':'str', 'f':'to_elm'})(_elm)
	// 				$(_elm).fadeIn()
	// 				page.previous_page = 'notif'
	// 				page.update(_elm)
	// 				LGen.Page.change('notif_msg')
	// 			})
	// 			LGen.component.notif.screen.querySelector('.notif .child').appendChild(elm)
	// 		}
	// 	})
	// }

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.notif
		LGen.Page.clear_childs(page.screen.querySelector('.notif .child'))
		page.previous_page = ''
		LGen.component.footbar.clear()
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.notif
		page.update()
		LGen.component.footbar.add_plain(page.screen_footbar)
		LGen.component.footbar.show()
		LGen.component.header.show()
	}


}