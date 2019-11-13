LGen.component.footer = new Footer()

function Footer () {
	this.name = 'footer'

	this.open = open
	function open() {
		var compo = LGen.component.footer
		if (!$(compo.screen).hasClass("opened"))
			$(compo.screen).addClass("opened")
	}

	this.close = close
	function close() {
		var compo = LGen.component.footer
		if ($(compo.screen).hasClass("opened"))
			$(compo.screen).removeClass("opened")
	}

	this.set = set
	function set () {
		var compo = LGen.component.footer
		compo.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="footer theme bgclr1" >'+
				// '<div class="tag">'+LGen.icon.obj.footer_tag+'</div>'+
				'<div class="footer_bground">'+
					'<div class="upper">'+
						'<div class="title theme fp">'+'Lanterlite'+'</div>'+
						'<div class="icon twitter">'+LGen.icon.theme('twitter', 2)+'</div>'+
						'<div class="icon fb">'+LGen.icon.theme('facebook', 2)+'</div>'+
						'<div class="icon insta">'+LGen.icon.theme('instagram', 2)+'</div>'+
					'</div>'+
					'<div class="bgchild">'+
						// '<div class="child col0">'+'</div>'+
						// '<div class="child col1">'+'</div>'+
						// '<div class="child col2">'+'</div>'+
						// '<div class="child col3">'+'</div>'+
					'</div>'+
					'<div class="lower theme fp">'+'© Lanterlite 2019'+'</div>'+
				'</div>'+
			'</div>'
		)

		compo.lang_elms = []
		LGen.Page.init(compo)
		$(compo.screen).css({'opacity':1})
		compo.update(1)
		compo.set_event()
		// document.body.appendChild(compo.screen)
		// compo.hide_when_scroll_on()
		// $(compo.screen).show(0)
	}

	this.set_event = set_event
	function set_event() {
		var compo = LGen.component.footer
		compo.screen.querySelector('.twitter svg').addEventListener('click', function() {
			window.open('https://twitter.com/lanterlite', '_blank')
		})
		compo.screen.querySelector('.fb svg').addEventListener('click', function() {
			// lprint('asd')
			window.open('https://www.facebook.com/lanterlite', '_blank')
		})
		compo.screen.querySelector('.insta svg').addEventListener('click', function() {
			window.open('https://www.instagram.com/lanterlite/', '_blank')
		})
	}

	this.update = update
	function update(first_update=false) {
		var compo = LGen.component.footer


		var go = true
		if (compo.lang === LGen.citizen.get({'key':'lang','safe':'safe'}))
			go = false
		if (first_update)
			go = true
		if (go) {
			if (first_update) {
				var urls = [
					{'name': 'footer', 'url':HOME_URL + 'app/lang/footer.lgen'}
					// {'name': 'footer', 'url':HOME_URL + 'app/lang/component/footer/'+LGen.citizen.get({'key':'lang','safe':'safe'})+'.lgen'}
				]

				LGen.lang.text_get(urls, 0, function() {
					if (LGen.call({'c':'black','f':'check'})({'val':LGen.lang.text['footer'],'safe':'safe'}))
						var obj = LGen.call({'c':'white','f':'get'})({'val':LGen.lang.text['footer'],'safe':'safe'})
					else
						var obj = LGen.lang.text['footer']
					// lprint(obj)
					for (var i=0; i<obj.length; i++) {
						// lprint(obj[i])
						if (first_update) {
							var child = LGen.call({'c':'str', 'f':'to_elm'})('<div class="child child'+i+'">'+'</div>')
							// lprint('title', obj[i]['title'])
							child.appendChild(LGen.call({'c':'str', 'f':'to_elm'})('<div class="title theme fp">'+obj[i]['title']+'</div>'))
							compo.lang_elms.push({"elm":child.querySelector('.title')})

							for (var j=0; j<obj[i]['content'].length; j++) {
								var _child = LGen.call({'c':'str', 'f':'to_elm'})('<div class="val theme fp">'+obj[i]['content'][j]['title']+'</div>')
								LGen.set_button(_child)
								LGen.set_button_click(_child, LGen.call({'c':'gen','f':'create'})(obj[i]['content'][j]['func']))
								// _child.addEventListener('click', LGen.call({'c':'gen','f':'create'})(obj[i]['content'][j]['func']))
								child.appendChild(_child)
								compo.lang_elms.push({"elm":_child})
							}
							compo.screen.querySelector('.bgchild').appendChild(child);
						}
						// else {
						// 	var child = compo.screen.querySelector('.child'+i)
						// 	// lprint(obj[i]['title'])
						// 	// lprint(child.querySelector('.title'))
						// 	// lprint({"elm":child.querySelector('.title'), "text":obj[i]['title'] })
						// 	LGen.translator.update({"elm":child.querySelector('.title'), "text":obj[i]['title'] })
						// 	var child_val = compo.screen.querySelectorAll('.child'+i+' .val')

						// 	for (var j=0; j<obj[i]['content'].length; j++) {
						// 		LGen.translator.update({"elm":child_val[j], "text":obj[i]['content'][j]['title'] })
						// 	}
						// }
					}
					// LGen.Page.set_css(compo.screen)
					// LGen.Page.Self.update_css(compo.screen)
					LGen.Page.Self.update(compo)
					compo.lang = LGen.citizen.get({'key':'lang','safe':'safe'})
				})
			}
			// else {
			// 	var child = compo.screen.querySelector('.child'+i)
			// 	// lprint(obj[i]['title'])
			// 	// lprint(child.querySelector('.title'))
			// 	// lprint({"elm":child.querySelector('.title'), "text":obj[i]['title'] })
			// 	LGen.translator.update({"elm":child.querySelector('.title'), "text":obj[i]['title'] })
			// 	var child_val = compo.screen.querySelectorAll('.child'+i+' .val')

			// 	for (var j=0; j<obj[i]['content'].length; j++) {
			// 		LGen.translator.update({"elm":child_val[j], "text":obj[i]['content'][j]['title'] })
			// 	}
			// }
		}
	}

	this.scrollPos = 0;
	this.hide_when_scroll_on = hide_when_scroll_on
	function hide_when_scroll_on() {
		var compo = LGen.component.footer
		$(window).scroll(function() {
			if (compo.scrollPos !== $(this).scrollTop()) {
		    compo.close()
			}
			compo.scrollPos = $(this).scrollTop()
		});
	}
}