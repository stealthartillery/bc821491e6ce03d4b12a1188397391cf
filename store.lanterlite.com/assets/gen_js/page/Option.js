LGen.component.option = new Option()
LGen.component.option.set()

function Option () {
	this.name = 'option'

	this.set = set
	function set () {
		var page = LGen.component.option
		page.screen_footbar = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="_footbar n1 theme fp">'+
				'<button class="std gold back theme bgclr1 hover1">'+LGen.icon.theme('left')+'</button>'+
			'</div>'
		)
		page.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="option" style="display: none;">'+
			'<div class="bground">'+
			'<div class="content">'+
				'<div class="top_title title theme fttl">'+'Profile Option'+'</div>'+
				'<div class="child lang">'+
					'<div class="title theme fp">'+'Language'+'</div>'+
					'<div class="val">'+
					'<select class="select theme fp">'+
				    '<option value="id">Indonesia (Bahasa)</option>'+
				    '<option value="en">English</option>'+
					'</select>'+
					'</div>'+
				'</div>'+
				'<div class="child _theme_color">'+
					'<div class="title theme fp">'+'Color'+'</div>'+
					'<div class="val">'+
					'<select class="select theme fp">'+
				    // '<option class="ca01" value="ca01">Original</option>'+
				    // '<option class="ca02" value="ca02">Navy</option>'+
					'</select>'+
					'</div>'+
				'</div>'+
				'<div class="child _theme_font">'+
					'<div class="title theme fp">'+'Font'+'</div>'+
					'<div class="val">'+
					'<select class="select theme fp">'+
				    // '<option class="fa01" value="fa01">Original</option>'+
				    // '<option class="fa02" value="fa02">Montserrat</option>'+
					'</select>'+
					'</div>'+
				'</div>'+
				'<div class="child _fsize">'+
					'<div class="title theme fp">'+'Font'+'</div>'+
					'<div class="val">'+
					'<select class="select theme fp">'+
				    // '<option class="fa01" value="fa01">Original</option>'+
				    // '<option class="fa02" value="fa02">Montserrat</option>'+
					'</select>'+
					'</div>'+
				'</div>'+
				// '<button class="std gold back_btn theme theme_color bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm":page.screen.querySelector('.top_title')},
			{"elm":page.screen.querySelector('.bground ._theme_color .title')},
			{"elm":page.screen.querySelector('.bground ._theme_font .title')},
			{"elm":page.screen.querySelector('.bground .lang .title')},
			// {"elm":page.screen.querySelector('.back_btn')}
		]
		LGen.Page.init(page)
		page.set_event()
		LGen.component.header.hide_when_scroll2(page.screen.querySelector('.bground'))
	}

	this.set_event = set_event
	function set_event () {
		var page = LGen.component.option

		LGen.set_button(page.screen_footbar.querySelector('.back'))
		LGen.set_button_click(page.screen_footbar.querySelector('.back'), function() {
			LGen.Page.change(page.previous_page)
		})

		// LGen.set_button(page.screen.querySelector('.back_btn'))
		// LGen.set_button_click(page.screen.querySelector('.back_btn'), function() {
		// 	LGen.Page.change(page.previous_page)
		// })

		$(page.screen.querySelector('.lang select')).change(function(){
			LGen.citizen.set_all({'val':{'lang':$(this).val()},'safe':'safe'})
		});

		$(page.screen.querySelector('._theme_color select')).change(function(){ 
			LGen.citizen.set_all({'val':{'theme_color':$(this).val()},'safe':'safe'})
		});

		$(page.screen.querySelector('._theme_font select')).change(function(){ 
			LGen.citizen.set_all({'val':{'theme_font':$(this).val()},'safe':'safe'})
		});

		$(page.screen.querySelector('._fsize select')).change(function(){ 
			LGen.citizen.set_all({'val':{'fsize':$(this).val()},'safe':'safe'})
		});
	}

	this.update_font_list = update_font_list
	function update_font_list() {
		var page = LGen.component.option
		page.screen.querySelector('._theme_font select').appendChild(
			LGen.call({'c':'str', 'f':'to_elm'})('<option class="fa01" value="fa01">Original</option>')
		)
		page.screen.querySelector('._theme_font select').appendChild(
			LGen.call({'c':'str', 'f':'to_elm'})('<option class="fa02" value="fa02">Montserrat</option>')
		)
		var has_theme_font = false
		var _licenses = LGen.citizen.get({'key':'licenses','safe':'safe'})
		for (var i=0; i<_licenses.length; i++) {
			if (_licenses[i]['type'] === 'theme_font' || _licenses[i]['type'] === 'full') {
				has_theme_font = true
				i = _licenses.length
			}
		}
		if (has_theme_font) {
			page.screen.querySelector('._theme_font select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="fa03" value="fa03">Arvo</option>')
			)
			page.screen.querySelector('._theme_font select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="fa04" value="fa04">Capriola</option>')
			)
			page.screen.querySelector('._theme_font select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="fa05" value="fa05">Farro</option>')
			)
			page.screen.querySelector('._theme_font select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="fa06" value="fa06">Armata</option>')
			)
			page.screen.querySelector('._theme_font select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="fa07" value="fa07">Quando</option>')
			)
			page.screen.querySelector('._theme_font select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="fa08" value="fa08">Rubik</option>')
			)
			page.screen.querySelector('._theme_font select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="fa09" value="fa09">Work Sans</option>')
			)
			page.screen.querySelector('._theme_font select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="fa10" value="fa10">Libre Baskerville</option>')
			)
		}
	}

	this.update_fsize_list = update_fsize_list
	function update_fsize_list() {
		var page = LGen.component.option
		page.screen.querySelector('._fsize select').appendChild(
			LGen.call({'c':'str', 'f':'to_elm'})('<option class="fs01" value="fs01">Small</option>')
		)
		page.screen.querySelector('._fsize select').appendChild(
			LGen.call({'c':'str', 'f':'to_elm'})('<option class="fs02" value="fs02">Medium</option>')
		)
		page.screen.querySelector('._fsize select').appendChild(
			LGen.call({'c':'str', 'f':'to_elm'})('<option class="fs03" value="fs03">Big</option>')
		)
	}

	this.update_color_list = update_color_list
	function update_color_list() {
		var page = LGen.component.option
		page.screen.querySelector('._theme_color select').appendChild(
			LGen.call({'c':'str', 'f':'to_elm'})('<option class="ca01" value="ca01">Original</option>')
		)
		page.screen.querySelector('._theme_color select').appendChild(
			LGen.call({'c':'str', 'f':'to_elm'})('<option class="ca02" value="ca02">Navy</option>')
		)
		var has_theme_color = false
		var _licenses = LGen.citizen.get({'key':'licenses','safe':'safe'})
		for (var i=0; i<_licenses.length; i++) {
			if (_licenses[i]['type'] === 'theme_color' || _licenses[i]['type'] === 'full') {
				has_theme_color = true
				i = _licenses.length
			}
		}
		if (has_theme_color) {
			page.screen.querySelector('._theme_color select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="ca03" value="ca03">Maroon</option>')
			)
			page.screen.querySelector('._theme_color select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="ca04" value="ca04">Green</option>')
			)
			page.screen.querySelector('._theme_color select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="ca05" value="ca05">Violet</option>')
			)
			page.screen.querySelector('._theme_color select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="ca06" value="ca06">Brown</option>')
			)
			page.screen.querySelector('._theme_color select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="ca07" value="ca07">Turquoise</option>')
			)
			page.screen.querySelector('._theme_color select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="ca08" value="ca08">Gold</option>')
			)
			page.screen.querySelector('._theme_color select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="ca09" value="ca09">Blue</option>')
			)
			page.screen.querySelector('._theme_color select').appendChild(
				LGen.call({'c':'str', 'f':'to_elm'})('<option class="ca10" value="ca10">Grey</option>')
			)
		}
	}

	this.update = update
	function update() {
		var page = LGen.component.option

		LGen.Page.Self.update(page)

		page.update_font_list()
		page.update_color_list()
		page.update_fsize_list()

		if (LGen.citizen.get({'key':'theme_color','safe':'safe'}) !== '')
			$(page.screen.querySelector('._theme_color .val .select')).val(LGen.citizen.get({'key':'theme_color','safe':'safe'}));
		else
			$(page.screen.querySelector('._theme_color .val .select')).val("ca01");

		if (LGen.citizen.get({'key':'theme_font','safe':'safe'}) !== '')
			$(page.screen.querySelector('._theme_font .val .select')).val(LGen.citizen.get({'key':'theme_font','safe':'safe'}));
		else
			$(page.screen.querySelector('._theme_font .val .select')).val("fa01");

		if (LGen.citizen.get({'key':'fsize','safe':'safe'}) !== '')
			$(page.screen.querySelector('._fsize .val .select')).val(LGen.citizen.get({'key':'fsize','safe':'safe'}));
		else
			$(page.screen.querySelector('._fsize .val .select')).val("fs01");

		if (LGen.citizen.get({'key':'lang','safe':'safe'}) !== '')
			$(page.screen.querySelector('.lang .val .select')).val(LGen.citizen.get({'key':'lang','safe':'safe'}));
		else
			$(page.screen.querySelector('.lang .val .select')).val("en");
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.option
		page.previous_page = ''
		LGen.Page.clear_childs(document.querySelector('._theme_font select'))
		LGen.Page.clear_childs(document.querySelector('._theme_color select'))
		LGen.Page.clear_childs(document.querySelector('._fsize select'))
		LGen.component.footbar.clear()
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.option
		page.update()
		LGen.component.footbar.add_plain(page.screen_footbar)
		LGen.component.footbar.show()
		LGen.component.header.show()
	}
}