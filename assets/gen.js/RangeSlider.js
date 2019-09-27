/* ========================================
RANGE SLIDER
======================================== */
function rslider() {
	this.title = title
	this.min = min
	this.max = max
	this.val = val
	this.move = move
	this.create = create

	function title(id, string) {
	  document.querySelector('#rslider #'+id+' #title').innerHTML = string
	}

	function min(id, value) {
	  document.querySelector('#rslider #'+id+' input#bar').setAttribute('min', value)
	}

	function max(id, value) {
	  document.querySelector('#rslider #'+id+' input#bar').setAttribute('max', value)
	}

	function val(id, value) {
	  document.querySelector('#rslider #'+id+' input#bar').value = value
	  document.querySelector('#rslider #'+id+' span#value').innerHTML = value
	}

	function move(id, func) {
		var defer = $.Deferred()
	  var input = document.querySelector('#rslider #'+id+' input#bar')
	  input.addEventListener('mouseup', function() {
	  	// document.querySelector('#rslider #'+id+' #value').innerHTML = this.value
			// callback(this.value)
	  })
	  input.addEventListener('input', function() {
	  	document.querySelector('#rslider #'+id+' #value').innerHTML = this.value
			defer.resolve(this.value)
			// on()
	  })

	  // on() {
	  // 	if
	  // }
		when_on()
		function when_on() {
			$.when( defer ).done(function (value) {
				defer = $.Deferred()
				when_on()
				value = document.querySelector('#rslider #'+id+' #value').innerHTML
				func(value)
			})		
		}
	}

	function create(id) {
	  var input = document.createElement('input')
	  // input.setAttribute('id', 'arabic_size')
	  input.setAttribute('class', 'bar')
	  input.setAttribute('id', 'bar')
	  input.setAttribute('type', 'range')
	  
	  var span_size = document.createElement('span')
	  span_size.setAttribute('id', 'size')
	  span_size.innerHTML = TXT["page"]["word"]["size"]

	  var span_semicolon = document.createElement('span')
	  span_semicolon.innerHTML = ": "

	  var span_value = document.createElement('span')
	  span_value.setAttribute('id', 'value')

	  var div_span = document.createElement('p')
	  $(div_span).addClass('theme_clr_text1')
	  // div_span.appendChild(span_size)
	  // div_span.appendChild(span_semicolon)
	  div_span.appendChild(span_value)

	  var div = document.createElement('div')
	  div.setAttribute('class', 'bar')
	  div.setAttribute('id', 'bar')
	  div.appendChild(input)
	  // div.appendChild(p)

	  var td_option = document.createElement('td')
	  td_option.appendChild(div)

	  var div = document.createElement('div')
	  style = ''
	  style += 'padding: 0px 10px;'
	  div.setAttribute('style', style)
	  div.appendChild(div_span)

	  var td_3 = document.createElement('td')
	  td_3.appendChild(div)

	  var td_title = document.createElement('td')
	  td_title.setAttribute('id', 'title')
	  td_title.setAttribute('class', 'title')

	  var tr = document.createElement('tr')
	  tr.setAttribute('class', 'transparent')
	  tr.appendChild(td_title)
	  tr.appendChild(td_option)
	  tr.appendChild(td_3)

	  // var table = document.querySelector('.opt_canvas table.options')
	  var table = document.createElement('table')
	  table.setAttribute('id', id)
	  table.appendChild(tr)

	  var rslider = document.createElement('div')
	  rslider.setAttribute('id', 'rslider')
	  rslider.setAttribute('class', 'rslider theme_clr_text1')
	  rslider.appendChild(table)
	  return rslider
	}
}

