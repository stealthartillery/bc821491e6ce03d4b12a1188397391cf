LGen.component.fcanvas = new FloatingCanvas()
/* ===============================================
FLOATING CANVAS
=============================================== */
function FloatingCanvas() {
	this.title = title

	this.open = open
	function open() {
		if (!$(LGen.component.fcanvas.screen).hasClass("opened")) {
			$(LGen.component.fcanvas.screen).fadeIn(250)
			$(LGen.component.fcanvas.screen).addClass("opened")
			$(LGen.component.fcanvas.bg).fadeIn(250)
			disable_canvas_scroll();
		}
	}

	this.close = close
	function close() {
		if ($(LGen.component.fcanvas.screen).hasClass("opened")) {
			$(LGen.component.fcanvas.screen).fadeOut(250)
			$(LGen.component.fcanvas.screen).removeClass("opened")
			$(LGen.component.fcanvas.bg).fadeOut(250)
			enable_canvas_scroll();
		}
	}

	this.add = add
	function add(elm) {
		if (!is_exist('#fcanvas #body #content')) {
			var div = document.createElement('div')
			div.setAttribute('class', 'content')
			div.setAttribute('id', 'content')
			div.appendChild(elm)

			var canvas = document.querySelector('#fcanvas #body')
			canvas.appendChild(div)	
		}
		else {
			var div = document.querySelector('#fcanvas #body #content')
			div.appendChild(elm)
		}
	}

	function title(str) {
		var fcanvas = document.querySelector('#fcanvas #title')
		fcanvas.innerHTML = str
	}

	this.set = set
	function set() {
		this.screen = LGen.String.to_elm(
			'<div class="fcanvas">'+
				'asd'+
			'</div>'
		)
		this.bg = LGen.String.to_elm(
			'<div class="bg dark">'+
			'</div>'
		)

		this.bg.addEventListener('click', function() {
			if (!$(LGen.component.fcanvas.screen).hasClass('opened')) {
				LGen.component.fcanvas.open()
			}
			else {
				LGen.component.fcanvas.close()
			}
		})
		document.body.appendChild(this.screen)
		document.body.appendChild(this.bg)
	}
}

