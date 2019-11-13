LGen.component.snackbar = new snackbar()
LGen.component.snackbar.set()

/* =============================================
SNACKBAR 
============================================= */
function snackbar() {

	this.set = set
	function set() {
		this.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div id="snackbar" class="snackbar">'+
			'</div>'
		)

		// this.bg = LGen.call({'c':'str', 'f':'to_elm'})(
		// 	'<div class="bg dark">'+
		// 	'</div>'
		// )

		// this.bg.addEventListener('click', function() {
	 //  	LGen.component.snackbar.close()
		// })

		$(this.screen).fadeOut(0)
		LGen.Page.screen.appendChild(this.screen)
	}

	this.close = close
	function close() {
	  var snackbar = LGen.component.snackbar.screen;
		$(snackbar).fadeOut()
	  setTimeout(function(){ 
			snackbar.className = snackbar.className.replace(" show", ""); 
	  	LGen.call({'c':'elm','f':'clear_self'})('#snackbar div')
	  }, 300);
	}

	this.open = open
	function open(obj) {

		if (obj['str'] === undefined) {obj['str'] = ''} else 
		if (obj['class_name'] === undefined) {obj['class_name'] = 'def'}
		if (obj['nolimit'] === undefined) {obj['nolimit'] = false}
		if (obj['elm'] === undefined) {obj['elm'] = false}
		obj['str'] = LGen.translator.get({'from_lang':'en','words':obj['str']})

	  var snackbar = LGen.component.snackbar.screen;
		if (snackbar.className != "snackbar show") {
		  var div = document.createElement('div')
		  div.setAttribute('class', 'bar theme fp ' +obj['class_name'])
		  if (!obj['elm'])
			  div.innerHTML = obj['str']
			else
				div.appendChild(obj['elm'])
		  snackbar.appendChild(div);
		  $(snackbar).fadeIn()
		  snackbar.className = snackbar.className + " show";
		  if (!obj['nolimit']) {
			  setTimeout(function(){ 
			  	LGen.component.snackbar.close()
			  }, 3000);
		  }
		  else {
				var bg = document.createElement('div')
				bg.setAttribute('class', 'bg gen')
				// style = "background-color: black;"
				style = "opacity: 0.5;"
				bg.setAttribute('style',style)
				bg.addEventListener('click', function() {
			  	LGen.component.snackbar.close()
			  	LGen.call({'c':'elm','f':'clear_self'})('.bg.gen')
				})

				LGen.Page.screen.appendChild(bg)
		  }
		}
	}
}
