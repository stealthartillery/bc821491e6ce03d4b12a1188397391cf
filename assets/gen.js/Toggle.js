/* ========================================
TOGGLE
======================================== */
function toggle() {
	this.create = create
	this.title = title
	this.changed = changed
	this.checked = checked

	function create(id) {

		var input = document.createElement('input')
		input.setAttribute('type', 'checkbox')
		input.setAttribute('name', 'switch')

		var span2 = document.createElement('span')
		span2.setAttribute('class', 'switch-style')

		var label = document.createElement('label')
		label.setAttribute('class', 'switch')
		label.appendChild(input)
		label.appendChild(span2)

		var td1 = document.createElement('td')
		td1.setAttribute('id', 'title')
		td1.setAttribute('class', 'title')

		var td2 = document.createElement('td')
		td2.appendChild(label)

		var tr = document.createElement('tr')
	  tr.setAttribute('class', 'transparent')
		tr.appendChild(td1)
		tr.appendChild(td2)

		var table = document.createElement('table')
		table.appendChild(tr)

		var div = document.createElement('div')
		div.setAttribute('class', 'toggle theme_clr_text1 ' + id)
		div.setAttribute('id', 'toggle')
		div.appendChild(table)

		return div
	}

	function title(id, str) {
		var title = document.querySelector('#toggle.'+id+' #title')
		title.innerHTML = str
	}

	function changed(id, func) {
	  var defer = $.Deferred()
		var input = document.querySelector('#toggle.'+id+' input')
		input.addEventListener('click', function (e) {
	    var is_checked = e.target.checked
			defer.resolve(is_checked)
	  })

		when_on()
		function when_on() {
			$.when( defer ).done(function (is_checked) {
				defer = $.Deferred()
				when_on()
				setTimeout( func(is_checked), 5 )
			})		
		}
	}

	function checked(id, is_checked) {
		var input = document.querySelector('#toggle.'+id+' input')
		input.checked = is_checked
	}

}

