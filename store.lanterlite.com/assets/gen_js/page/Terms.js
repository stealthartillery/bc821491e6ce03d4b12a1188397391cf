LGen.component.terms = new Terms()
LGen.component.terms.set()

function Terms () {
	this.name = 'terms'
	this.url_names = ['terms']

	this.set = set
	function set () {
		var page = LGen.component.terms
		page.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="terms" style="display: none;">'+
			'<div class="bground">'+
			'<div class="content_parent">'+
				// '<div class="title">'+'Message'+'</div>'+
				'<div class="child">'+'</div>'+
				'<button class="std gold back_btn theme fp bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm": page.screen.querySelector('.bground .back_btn')}
		]

		page.set_event()
		LGen.Page.init(page)
		LGen.component.header.hide_when_scroll2(page.screen.querySelector('.bground'))
	}


	this.set_event = set_event
	function set_event() {
		var page = LGen.component.terms
		LGen.set_button(page.screen.querySelector('.back_btn'))
		LGen.set_button_click(page.screen.querySelector('.back_btn'), function() {
			LGen.Page.change(page.previous_page)
		})
	}

	this.update = update
	function update() {
		var page = LGen.component.terms

		LGen.Page.Self.update(page)

		var _obj = {
			"json": {'def':'helps', 'namelist':['title_'+LGen.citizen.get({'key':'lang','safe':'safe'}), 'content_'+LGen.citizen.get({'key':'lang','safe':'safe'}), 'created_date'],
				'bridge':[
					{'id':'helps', 'puzzled': true},
					{'id':'privacy_and_terms', 'puzzled': false}
				]
			},
			"func": 'LGen("SaviorMan")->read'
		}
		LGen.call({'c':'req','f':'get'})(LGen.system.get({'safe':'safe'}).citizen_domain+'/gate', _obj, function(obj){
			// lprint(obj)
			var elm = LGen.call({'c':'str', 'f':'to_elm'})(
				'<div class="val theme fp">'+
					// '<div class="title">'+atob(obj['title_'+LGen.citizen.get({'key':'lang','safe':'safe'})])+'</div>'+
					'<div class="content">'+decodeURIComponent((obj['content_'+LGen.citizen.get({'key':'lang','safe':'safe'})]))+'</div>'+
					// '<div class="date">'+LGen.call({'c':'date','f':'to_local'})(atob(obj[i]['created_date']))+'</div>'+
				'</div>'
			)
			// LGen.Page.set_css(elm)
			// LGen.Page.Self.update_css(elm)
			page.screen.querySelector('.terms .child').appendChild(elm)
		})
	}

	this.when_closed = when_closed
	function when_closed() {
		var page = LGen.component.terms
		LGen.Page.clear_childs(page.screen.querySelector('.terms .child'))
		page.previous_page = ''
	}

	this.when_opened = when_opened
	function when_opened() {
		var page = LGen.component.terms
		page.update()
		LGen.component.footbar.hide()
		LGen.component.header.show()
	}
}