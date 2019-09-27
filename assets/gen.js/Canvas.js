	/* ================================================
	CANVAS
	================================================ */
	function Canvas() {
		this.set = set
		this.add = add
		this.elm = ''
		this.ctable = new ctable()

		function ctable() {
			this.add = add
			this.set = set
			this.clear = clear
			this.elm = ''

			function add (elm, style) {
				if (style === undefined)
					style = ''

				var tbl = '<table>'+
					'<tr>'+
					'<td>'+
					'</td>'+
					'</tr>'+
				'</table>'
				tbl = LGen.StringMan.to_elm(tbl)
				tbl.childNodes[0].childNodes[0].childNodes[0].setAttribute('style', style)
				tbl.childNodes[0].childNodes[0].childNodes[0].appendChild(elm)
				L.canvas.ctable.elm.appendChild(tbl.childNodes[0].childNodes[0])
			}

			function set() {
				var ctable = '<div class="ctable" id="ctable" cellpadding=0 cellspacing=0></div>'
				ctable = LGen.StringMan.to_elm(ctable)
				L.canvas.ctable.elm = ctable
				L.canvas.elm.appendChild(ctable)
			}

			function clear() {
				clear_all_childs(L.canvas.ctable.elm)
			}
		}

		function set() {
			var canvas = '<div class="canvas theme_clr_main1" id="canvas" cellpadding=0 cellspacing=0></div>'
			canvas = LGen.StringMan.to_elm(canvas)
			L.canvas.elm = canvas

			var body = document.querySelector('body')
			body.appendChild(canvas)
			L.canvas.ctable.set()
		}

		function add (elm, style) {
			if (style === undefined)
				style = ''

			var tbl = '<table>'+
				'<tr>'+
				'<td>'+
				'</td>'+
				'</tr>'+
			'</table>'
			tbl = LGen.StringMan.to_elm(tbl)
			tbl.childNodes[0].childNodes[0].childNodes[0].setAttribute('style', style)
			tbl.childNodes[0].childNodes[0].childNodes[0].appendChild(elm)
			L.canvas.elm.childNodes[0].appendChild(tbl.childNodes[0].childNodes[0])
		}
	}
	
