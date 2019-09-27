LGen.component.notif = new Notif()
LGen.component.notif.set()

function Notif () {
	this.name = 'notif'

	this.set = set
	function set () {
		var page = LGen.component.notif
		page.screen = LGen.String.to_elm(
			'<div class="notif theme_font" style="display: none;">'+
			'<div class="bground">'+
				'<div class="title theme theme_font">'+'Help'+'</div>'+
				'<div class="child">'+
				'</div>'+
				'<button class="std gold back_btn theme_font theme_color bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.bground .title')},
			{"elm":page.screen.querySelector('.bground .back_btn')},
		]

		LGen.Page.set_keys(page)
		page.set_event()
		LGen.Page.add(page)
	}

	this.set_event = set_event
	function set_event() {
		var page = LGen.component.notif
		page.screen.querySelector('.back_btn').addEventListener('click', function() {
			LGen.Page.change(page.previous_page)
		})
	}

	this.update = update
	function update() {
		var page = LGen.component.notif

		LGen.Page.Self.update_css(page)
		LGen.Page.Self.update_font(page)
		LGen.Page.Self.update_color(page)
		LGen.Page.Self.update_lang(page)

		var _obj = {
			"json" : {'gate':'savior', 'def':'helps', 'namelist':[
				'title_'+LGen.citizen.lang, 
				'content_'+LGen.citizen.lang, 
				'created_date'], 'bridge':[{'id':'helps', 'puzzled': true}]},
			"func" : 'LGen("SaviorMan")->get_all'
		}
		LGen.f.send_get(LGen.system.be_domain+'/citizen', _obj, function(obj){
			for (var i=0; i<obj.length; i++) {
				var elm = LGen.String.to_elm(
					'<div class="val theme_color hover2">'+
						'<div class="title theme_font">'+atob(obj[i]['title_'+LGen.citizen.lang])+'</div>'+
						'<div class="content theme_font" style="display: none;">'+decodeURIComponent(atob(obj[i]['content_'+LGen.citizen.lang]))+'</div>'+
						// '<div class="date">'+LGen.f.convert_to_local_date(atob(obj[i]['created_date']))+'</div>'+
					'</div>'
				)
				elm.addEventListener('click', function() {
					var _elm = this.querySelector('.content').outerHTML
					_elm = LGen.String.to_elm(_elm)
					$(_elm).fadeIn()
					LGen.component.notif_msg.previous_page = 'notif'
					LGen.component.notif_msg.add(_elm)
					LGen.Page.change('notif_msg')
				})
				page.screen.querySelector('.notif .child').appendChild(elm)
			}
		})
	}

	// this.update2 = update2
	// function update2() {
	// 	// var asd = {'gate':'backlite', 'limited': false, 'namelist':['point', 'silver'], 'def':'citizens', 'bridge':[{'id':'citizens', 'puzzled': true}, {'id':LGen.citizen.id, 'puzzled': false}]}
	// 	// LGen.f.send_get(LGen.system.be_domain+'/savior', '$citizen->read('+LGen.Json.to_php_str(asd)+')', function(obj){
	// 	// 	lprint(obj)

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
	// 	LGen.f.send_get(LGen.system.be_domain+'/savior', '$citizen->get_all('+LGen.Json.to_php_str(asd)+')', function(obj){
	// 		lprint(obj)
	// 		for (var i=0; i<obj.length; i++) {
	// 			var elm = LGen.String.to_elm(
	// 				'<div class="val">'+
	// 					'<div class="title">'+atob(obj[i]['title'])+'</div>'+
	// 					'<div class="content" style="display: none;">'+atob(obj[i]['content'])+'</div>'+
	// 					// '<div class="date">'+LGen.f.convert_to_local_date(atob(obj[i]['created_date']))+'</div>'+
	// 				'</div>'
	// 			)
	// 			elm.addEventListener('click', function() {
	// 				var _elm = this.querySelector('.content').outerHTML
	// 				_elm = LGen.String.to_elm(_elm)
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
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.notif
		page.update()
	}


}