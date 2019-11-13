LGen.component.information = new Information()
LGen.component.information.set()

/* =============================================
information 
============================================= */
function Information() {

	this.set = set
	function set() {
		var compo = LGen.component.information
		compo.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div id="information" class="theme information">'+
				'<div class="bground">'+
					'<div class="content">'+
						'<div class="theme fp text">'+'</div>'+
					'</div>'+
					'<button class="ok_btn theme fp std gold bgclr1 hover1">OK</button>'+
				'</div>'+
			'</div>'
		)
		compo.lang_elms = [
			{"elm":compo.screen.querySelector('.ok_btn')},
		]
		$(compo.screen).fadeOut(0)

		// LGen.Page.set_css(compo)
		LGen.Page.set_keys(compo)
		LGen.Page.screen.appendChild(compo.screen)
	}

	this.close = close
	function close() {
	  var compo = LGen.component.information;
		// $(compo.screen).slideUp()
		$(compo.screen).removeClass('open')
		$(compo.screen).css({'opacity':0})
	  setTimeout(function(){ 
			$(compo.screen).fadeOut(0)
	  }, LGen.Page.speed);
	}

	this.open = open
	function open(obj) {
	  var compo = LGen.component.information;
		LGen.Page.Self.update(compo)
		// if (obj['yes'] === undefined) {yes = function(){}} else {str = obj['yes']}
		// if (obj['no'] === undefined) {no = function(){}} else {str = obj['no']}
		if (typeof (obj) === 'string') str = obj
		else if (obj['str'] === undefined) {str = ''}
		else {str = obj['str']}

		// if (LGen.call({'c':'gen','f':'is_element'})(obj))
		// 	compo.screen.querySelector('.text').appendChild(str)
		// else
			compo.screen.querySelector('.text').innerText = str
		LGen.set_button(compo.screen.querySelector('.ok_btn'))
		LGen.set_button_click(compo.screen.querySelector('.ok_btn'), function() {
			compo.close()
		});
		// $(compo.screen.querySelector('.no_btn')).off('click')
		// $(compo.screen.querySelector('.no_btn')).on("click", function(e) { 
		// 	no()
		// 	compo.close()
		// });
		// $(compo.screen).slideDown()
		$(compo.screen).fadeIn(0)
		$(compo.screen).css({'opacity':1})
		$(compo.screen).addClass('open')
	}
	// this.open = open
	// function open(obj) {
	// }
}
