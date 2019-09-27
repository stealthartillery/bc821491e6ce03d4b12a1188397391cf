function Table() {

	this.add_elm_to_cell = add_elm_to_cell
	function add_elm_to_cell(elm, cell_id) {
		if (cell_id === undefined) {
			for (var i=0; i<this.elm.querySelectorAll('td').length; i++) 
				this.elm.querySelectorAll('td')[i].appendChild(LGen.StringMan.to_elm(elm.outerHTML))
		}
		else {
			this.elm.querySelector('#'+cell_id).appendChild(elm)
		}
	}

	this.set = set
	function set(row, col, cell_id) {
		var tbl = document.createElement('table')
		var slot_num = 0	
		for (var i=0; i<row; i++) {
			var tr = document.createElement('tr')	
			for (var j=0; j<col; j++) {
				var td = document.createElement('td')	
				if (cell_id !== undefined) {
					td.setAttribute('id', cell_id+slot_num)
					td.setAttribute('class', cell_id)
				}
				tr.appendChild(td)
				slot_num += 1
			}
			tbl.appendChild(tr)
		}
		this.elm = tbl;
	}

}