LGen.component.checkbox = Checkbox

function Checkbox() {
	// this.set = set
	// function set() {
	this.screen = LGen.String.to_elm(
		'<div class="checkbox">'+
			'<button class="std gold checkbox_btn theme '+LGen.citizen.theme_color+' bgclr1 hover1"">'+
				I.obj['check']+
			'</button>'+
			'<span class="title theme '+LGen.citizen.theme_font+'">'+''+'</span>'+
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
			lprint(this)
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

