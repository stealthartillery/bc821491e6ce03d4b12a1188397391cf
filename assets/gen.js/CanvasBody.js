	/* ================================================
	CANVAS BODY
	================================================ */
	function body() {
		this.set = set
		this.add = add
		this.clear = clear
		this.elm = ''

		function clear() {
			clear_self(L.body.elm.childNodes[0])
		}

		function set() {
			var cbody = document.createElement('div')
			cbody.setAttribute('class', 'body')
			cbody.setAttribute('id', 'body')
		  $(cbody).css({'height': 'calc(100vh - '+(51+TOP_HEIGHT).toString()+'px)'})

			// var body = document.querySelector('#canvas')
			// body.appendChild(cbody)
			L.canvas.ctable.add(cbody)
			this.elm = cbody
		}

		function add(elm) {
			L.body.elm.appendChild(elm)
		}
	}
