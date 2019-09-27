LGen.component.option = new Option()
LGen.component.option.set()

function Option () {
	this.name = 'option'

	this.set = set
	function set () {
		var page = LGen.component.option
		page.screen = LGen.String.to_elm(
			'<div class="option" style="display: none;">'+
			'<div class="bground">'+
				'<div class="top_title title theme theme_font">'+'Profile Option'+'</div>'+
				'<div class="child lang">'+
					'<div class="title theme theme_font">'+'Language'+'</div>'+
					'<div class="val">'+
					'<select class="select theme theme_font">'+
				    '<option value="id">Indonesia (Bahasa)</option>'+
				    '<option value="en">English</option>'+
					'</select>'+
					'</div>'+
				'</div>'+
				'<div class="child _theme_color">'+
					'<div class="title theme theme_font">'+'Color'+'</div>'+
					'<div class="val">'+
					'<select class="select theme theme_font">'+
				    '<option class="ca01" value="ca01">Original</option>'+
				    '<option class="ca02" value="ca02">Navy</option>'+
					'</select>'+
					'</div>'+
				'</div>'+
				'<div class="child _theme_font">'+
					'<div class="title theme theme_font">'+'Font'+'</div>'+
					'<div class="val">'+
					'<select class="select theme theme_font">'+
				    '<option class="fa01" value="fa01">Original</option>'+
				    '<option class="fa02" value="fa02">Montserrat</option>'+
					'</select>'+
					'</div>'+
				'</div>'+
				'<button class="std gold back_btn theme theme_font theme_color bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.top_title')},
			{"elm":page.screen.querySelector('.bground ._theme_color .title')},
			{"elm":page.screen.querySelector('.bground ._theme_font .title')},
			{"elm":page.screen.querySelector('.bground .lang .title')},
			{"elm":page.screen.querySelector('.back_btn')}
		]
		LGen.Page.set_keys(page)
		page.set_event()
		LGen.Page.add(page)
	}

	this.set_event = set_event
	function set_event () {
		var page = LGen.component.option

		page.screen.querySelector('.back_btn').addEventListener('click', function() {
			LGen.Page.change(page.previous_page)
		})

		$(page.screen.querySelector('.lang select')).change(function(){
	    LGen.Page.update_lang($(this).val());
		});

		$(page.screen.querySelector('._theme_color select')).change(function(){ 
	    LGen.Page.update_color($(this).val());
		});

		$(page.screen.querySelector('._theme_font select')).change(function(){ 
	    LGen.Page.update_font($(this).val());
		});
	}

	this.update_font_list = update_font_list
	function update_font_list() {
		var page = LGen.component.option
		var has_theme_font = false
		for (var i=0; i<LGen.citizen.licenses.length; i++) {
			if (LGen.citizen.licenses[i]['type'] === 'theme_font') {
				has_theme_font = true
				i = LGen.citizen.licenses.length
			}
		}
		if (has_theme_font) {
			page.screen.querySelector('._theme_font select').appendChild(
				LGen.String.to_elm('<option class="fa03" value="fa03">Comic Sans</option>')
			)
		}
	}

	this.update_color_list = update_color_list
	function update_color_list() {
		var page = LGen.component.option
		var has_theme_color = false
		for (var i=0; i<LGen.citizen.licenses.length; i++) {
			if (LGen.citizen.licenses[i]['type'] === 'theme_color') {
				has_theme_color = true
				i = LGen.citizen.licenses.length
			}
		}
		if (has_theme_color) {
			page.screen.querySelector('._theme_color select').appendChild(
				LGen.String.to_elm('<option class="ca03" value="ca03">Rose</option>')
			)
		}
	}

	this.update = update
	function update() {
		var page = LGen.component.option

		LGen.Page.Self.update_css(page)
		LGen.Page.Self.update_lang(page)
		LGen.Page.Self.update_color(page)
		LGen.Page.Self.update_font(page)

		page.update_font_list()
		page.update_color_list()

		if (LGen.citizen.theme_color !== '')
			$(page.screen.querySelector('._theme_color .val .select')).val(LGen.citizen.theme_color);
		else
			$(page.screen.querySelector('._theme_color .val .select')).val("ta01");

		if (LGen.citizen.theme_font !== '')
			$(page.screen.querySelector('._theme_font .val .select')).val(LGen.citizen.theme_font);
		else
			$(page.screen.querySelector('._theme_font .val .select')).val("ta01");

		if (LGen.citizen.lang !== '')
			$(page.screen.querySelector('.lang .val .select')).val(LGen.citizen.lang);
		else
			$(page.screen.querySelector('.lang .val .select')).val("en");
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.option
		page.previous_page = ''
		LGen.Page.clear_childs(document.querySelector('._theme_font select'))
		LGen.Page.clear_childs(document.querySelector('._theme_color select'))
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.option
		page.update()
	}
}