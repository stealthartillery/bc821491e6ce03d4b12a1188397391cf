LGen.component.footbar = new Footbar()
LGen.component.footbar.set()

function Footbar() {
	this.keep_closed = false

	this.set = set
	function set() {
		var compo = LGen.component.footbar
		compo.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div id="footbar" class="footbar opened theme fp bgclr1">'+
			'<div class="bground">'+
			'</div>'+
			'</div>'
		)
		compo.lang_elms = []
		LGen.Page.set_keys(compo)
		LGen.Page.screen.appendChild(compo.screen)
		compo.update()
	}

	this.update = update
	function update() {
		var compo = LGen.component.footbar
		LGen.Page.Self.update(compo)
	}

	this.open = open
	function open() {
		var compo = LGen.component.footbar
		if (!compo.keep_closed && !$(compo.screen).hasClass("opened"))
			$(compo.screen).addClass("opened")
	}

	this.close = close
	function close() {
		var compo = LGen.component.footbar
		if ($(compo.screen).hasClass("opened"))
			$(compo.screen).removeClass("opened")
	}

	this.hide = hide
	function hide(speed) {
		var compo = LGen.component.footbar
		compo.close()
		compo.keep_closed = true
	}

	this.show = show
	function show(speed) {
		var compo = LGen.component.footbar
		compo.keep_closed = false
		compo.open()
	}

	this.clear = clear
	function clear(obj) {
		var compo = LGen.component.footbar
		// setTimeout(function(){
			$(compo.screen.querySelector('.bground')).css({'opacity':0})
			setTimeout(function(){
				LGen.call({'c':'elm','f':'clear_childs'})(compo.screen.querySelector('.bground'))
			}, LGen.Page.speed)
		// }, LGen.Page.speed)
	}

	this.add_plain = add_plain
	function add_plain(obj) {
		var compo = LGen.component.footbar
		// setTimeout(function(){
			// $(compo.screen.querySelector('.bground')).css({'opacity':0})
				// LGen.call({'c':'elm','f':'clear_childs'})(compo.screen.querySelector('.bground'))
			compo.screen.querySelector('.bground').appendChild(obj)
			// // LGen.Page.Self.update_css(compo)
			setTimeout(function(){
				$(compo.screen.querySelector('.bground')).css({'opacity':1})
			}, LGen.Page.speed)
		// }, LGen.Page.speed*2)
	}

	this.add = add
	function add(obj) {
		var compo = LGen.component.footbar
		var logo = LGen.call({'c':'str', 'f':'to_elm'})(LGen.icon.obj[obj.icon])
		$(logo).addClass('img '+obj.id)

		compo.logo.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="add">'+
				logo.outerHTML+
			'</div>'
		)
		compo.logo.screen.querySelector('.img').addEventListener('click', function() {
			obj.func()
		})
		// var logo = compo.querySelector('.add .'+obj.id)
		compo.screen.appendChild(compo.logo.screen)
	}

	// this.scrollPos = 0;
	this.hide_when_scroll = hide_when_scroll
	function hide_when_scroll(screen) {
		var compo = LGen.component.footbar
		$(screen).scroll(function() {
			// lprint('this.scrollPos', this.scrollPos)
			// lprint('$(this).scrollTop())', $(this).scrollTop())
			if (this.scrollPos === undefined)
				this.scrollPos = $(this).scrollTop()
			if ((this.scrollPos - $(this).scrollTop()) > 50) {
		    compo.open()
				this.scrollPos = $(this).scrollTop()
			}
			else if ((this.scrollPos - $(this).scrollTop()) < -50) {
		    compo.close()
				this.scrollPos = $(this).scrollTop()
			}
		});
	}

	this.hide_when_scroll_on = hide_when_scroll_on
	function hide_when_scroll_on() {
		var compo = LGen.component.footbar
		if (LGen.call({'c':'gen','f':'is_mobile'})()) {
			$(window).scroll(function() {
				// lprint('this.scrollPos', this.scrollPos)
				// lprint('$(this).scrollTop())', $(this).scrollTop())
				if (this.scrollPos === undefined)
					this.scrollPos = $(this).scrollTop()
				if ((this.scrollPos - $(this).scrollTop()) > 50) {
			    compo.open()
					this.scrollPos = $(this).scrollTop()
				}
				else if ((this.scrollPos - $(this).scrollTop()) < -50) {
			    compo.close()
					this.scrollPos = $(this).scrollTop()
				}
			});
		}
		else {
			$(document.querySelector('.ss-content')).scroll(function() {
				// lprint('this.scrollPos', this.scrollPos)
				// lprint('$(this).scrollTop())', $(this).scrollTop())
				if (this.scrollPos === undefined)
					this.scrollPos = $(this).scrollTop()
				if ((this.scrollPos - $(this).scrollTop()) > 50) {
			    compo.open()
					this.scrollPos = $(this).scrollTop()
				}
				else if ((this.scrollPos - $(this).scrollTop()) < -50) {
			    compo.close()
					this.scrollPos = $(this).scrollTop()
				}
			});
		}
	}
}
