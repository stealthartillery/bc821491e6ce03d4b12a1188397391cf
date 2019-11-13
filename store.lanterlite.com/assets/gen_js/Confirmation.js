LGen.component.confirmation = new Confirmation()
LGen.component.confirmation.set()

/* =============================================
confirmation 
============================================= */
function Confirmation() {

	this.set = set
	function set() {
		var compo = LGen.component.confirmation
		compo.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div id="confirmation" class="theme confirmation">'+
				'<div class="bground">'+
					'<div class="content">'+
						'<div class="theme fp text">'+'</div>'+
					'</div>'+
					'<button class="yes_btn theme fp std gold bgclr1 hover1">Yes</button>'+
					'<button class="no_btn theme fp std gold bgclr1 hover1">No</button>'+
				'</div>'+
			'</div>'
		)
		compo.lang_elms = [
			{"elm":compo.screen.querySelector('.yes_btn')},
			{"elm":compo.screen.querySelector('.no_btn')},
		]
		$(compo.screen).fadeOut(0)

		LGen.set_button((compo.screen.querySelector('.yes_btn')))
		LGen.set_button((compo.screen.querySelector('.no_btn')))
		// LGen.Page.set_css(compo)
		LGen.Page.set_keys(compo)
		LGen.Page.screen.appendChild(compo.screen)
	}

	this.close = close
	function close() {
	  var compo = LGen.component.confirmation;
		// $(compo.screen).slideUp()
		$(compo.screen).removeClass('open')
		$(compo.screen).css({'opacity':0})
	  setTimeout(function(){ 
			$(compo.screen).fadeOut(0)
	  }, LGen.Page.speed);
	}

	this.open = open
	function open(obj) {
	  var compo = LGen.component.confirmation;
		LGen.Page.Self.update(compo)
		if (obj['yes'] === undefined) {yes = function(){}} else {yes = obj['yes']}
		if (obj['no'] === undefined) {no = function(){}} else {no = obj['no']}
		if (obj['str'] === undefined) {str = ''} else {str = obj['str']}
		compo.screen.querySelector('.text').innerText = str
		$(compo.screen.querySelector('.yes_btn')).off('click')
		$(compo.screen.querySelector('.yes_btn')).on("click", function(e) { 
			var _this = this
			yes(_this)
			setTimeout(function() {compo.close()}, LGen.Page.speed)
			
		});
		$(compo.screen.querySelector('.no_btn')).off('click')
		$(compo.screen.querySelector('.no_btn')).on("click", function(e) { 
			var _this = this
			no(_this)
			setTimeout(function() {compo.close()}, LGen.Page.speed)
		});
		// $(compo.screen).slideDown()
		$(compo.screen).fadeIn(0)
		$(compo.screen).css({'opacity':1})
		$(compo.screen).addClass('open')
	}
	// this.open = open
	// function open(obj) {
	// }
}
