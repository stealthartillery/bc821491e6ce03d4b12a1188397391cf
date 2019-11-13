LGen.component.checkbox = Checkbox

function Checkbox() {
	// this.set = set
	// function set() {
	this.screen = LGen.call({'c':'str', 'f':'to_elm'})(
		'<div class="checkbox">'+
			'<button class="std gold checkbox_btn theme '+LGen.citizen.get({'key':'theme_color','safe':'safe'})+' bgclr1 hover1"">'+
				LGen.icon.obj['check']+
			'</button>'+
			'<span class="title theme '+LGen.citizen.get({'key':'theme_font','safe':'safe'})+'">'+''+'</span>'+
		'</div>'
	)

	$(this.screen.querySelector('button')).off('click')
	$(this.screen.querySelector('button')).on("click", function(e) { 
		if (!$(this).hasClass('checked')) {
			$(this).addClass('checked')
		}
		else {
			$(this).removeClass('checked')
		}
	});

	// this.click()
	// }
	
	this.click = click
	function click(click_callback=function(){}, unclick_callback=function(){}) {
		$(this.screen.querySelector('button')).off('click')
		$(this.screen.querySelector('button')).on("click", function(e) { 
			// lprint(this)
			if (!$(this).hasClass('checked')) {
				$(this).addClass('checked')
				click_callback()
			}
			else {
				$(this).removeClass('checked')
				unclick_callback()
			}
		});
	}

	this.title  = title
	function title(title='') {
		this.screen.querySelector('span').innerText = title
	}

	this.checked  = checked
	function checked() {
		return $(this.screen.querySelector('button')).hasClass('checked')
	}
}

