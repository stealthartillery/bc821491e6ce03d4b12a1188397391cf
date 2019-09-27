LGen.component.terms = new Terms()
LGen.component.terms.set()

function Terms () {
	this.name = 'terms'
	this.url_names = ['terms']

	this.set = set
	function set () {
		var page = LGen.component.terms
		page.screen = LGen.String.to_elm(
			'<div class="terms theme theme_font" style="display: none;">'+
			'<div class="bground">'+
				// '<div class="title">'+'Message'+'</div>'+
				'<div class="child">'+'</div>'+
				'<button class="std gold back_btn theme theme_font theme_color bgclr1 hover1">'+'Back'+'</button>'+
			'</div>'+
			'</div>'
		)
		page.lang_elms = [
			{"elm": page.screen.querySelector('.bground .back_btn')}
		]

		LGen.Page.set_keys(page)
		page.set_event()
		LGen.Page.add(page)
	}


	this.set_event = set_event
	function set_event() {
		var page = LGen.component.terms
		page.screen.querySelector('.back_btn').addEventListener('click', function() {
			LGen.Page.change(page.previous_page)
		})
	}

	this.update = update
	function update() {
		var page = LGen.component.terms

		LGen.Page.Self.update_css(page)
		LGen.Page.Self.update_font(page)
		LGen.Page.Self.update_color(page)
		LGen.Page.Self.update_lang(page)

		var _obj = {
			"json": {'gate':'savior', 'def':'helps', 'limited': false, 'namelist':['title_'+LGen.citizen.lang, 'content_'+LGen.citizen.lang, 'created_date'],
				'bridge':[
					{'id':'helps', 'puzzled': true},
					{'id':'privacy_and_terms', 'puzzled': false}
				]
			},
			"func": 'LGen("SaviorMan")->read'
		}
		LGen.f.send_get(LGen.system.be_domain+'/citizen', _obj, function(obj){
			lprint(obj)
			var elm = LGen.String.to_elm(
				'<div class="val theme theme_font">'+
					// '<div class="title">'+atob(obj['title_'+LGen.citizen.lang])+'</div>'+
					'<div class="content">'+decodeURIComponent(atob(obj['content_'+LGen.citizen.lang]))+'</div>'+
					// '<div class="date">'+LGen.f.convert_to_local_date(atob(obj[i]['created_date']))+'</div>'+
				'</div>'
			)
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
	}
}