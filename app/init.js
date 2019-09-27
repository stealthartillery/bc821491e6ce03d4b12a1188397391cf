LGen.start = function () {
	// LGen.citizen.id = 'C92754B29028'
	
	// LGen.component.account.set()
	// LGen.component.sidebar.set()
	// LGen.component.signin.set()
	// LGen.component.snackbar.set()
	// LGen.component.mtbtn.set()
	// LGen.component.fcanvas.set()

	// LGen.component.notif_msg.set(); LGen.Page.add(LGen.component.notif_msg)
	// LGen.component.notif.set(); LGen.Page.add(LGen.component.notif)
	// LGen.component.info.set(); LGen.Page.add(LGen.component.info)
	// LGen.component.profile.set(); LGen.Page.add(LGen.component.profile)
	// LGen.component.create_account.set(); LGen.Page.add(LGen.component.create_account)
	// LGen.component.terms.set(); LGen.Page.add(LGen.component.terms)
	// LGen.component.email_verification.set(); LGen.Page.add(LGen.component.email_verification)
	// LGen.component.option.set(); LGen.Page.add(LGen.component.option)
	lprint(LGen.component.header)
	// LGen.component.header.set()
	LGen.component.header.menu.set()
	LGen.component.header.logo.set()
	// LGen.component.header.srcbar.set()
	LGen.component.header.acc.set()

	// LGen.component.footer.set()
	
	// LGen.head.icon_set()
	// LGen.head.meta.add_viewport()
	// icon_init()
	if (LGen.app.platform === 'web') {
		var asd = {'gate':'savior'}
		var _obj = {
			"json": asd,
			"func": '$citizen->get_ship_id'
		}
		LGen.f.send_post(LGen.system.be_domain+'/citizen', _obj, function(obj){
			lprint(obj)
			if (obj.hasOwnProperty('id'))
				LGen.citizen.set(obj)
			run_app()
		})
	}
	else {
		run_app()
	}

}

function run_app () {
	LGen.f.recursive_css_import([
		LGen.system.home_url+'app/lantersite.css'
	], 0, function() {

	})

	LGen.f.recursive_js_import([
		// BASE_URL+'app/gen.js/jquery.translate.js',
		LGen.system.home_url+'app/route.js',
		LGen.system.home_url+'app/lantersite.js',
		LGen.system.home_url+'app/page/page_home.js',
		LGen.system.home_url+'app/page/page_news.js',
		LGen.system.home_url+'app/page/page_product.js',
		LGen.system.home_url+'app/page/page_team.js',
		LGen.system.home_url+'app/page/page_about.js',
		LGen.system.home_url+'app/page/page_article.js',
		LGen.system.home_url+'app/page/page_content.js'
	], 0, function() {

	  setTimeout(function () {
	  	route()
			LGen.Page.update_lang(LGen.citizen.lang)
			if (!LGen.f.is_mobile())
				when_desktop()
			else
				when_mobile()

			LGen.component.header.hide_when_scroll_on()
		});
	})
}

// var count = 0
// text_get(count)
LGen.app.text = {}
function text_get(list, inc, callback) {
	console.log(list)
 	LGen.Json.read(list[inc].url, function(obj) {
		LGen.app.text[list[inc]['name']] = obj
		inc += 1
		if (inc < list.length)
			text_get(list, inc, callback)
		else
			if (callback !== undefined) callback()
	})
}



function icon_init() {
	function add_style(svg) {
		svg = LGen.String.to_elm(svg)
		svg.setAttribute('style', 'vertical-align: -webkit-baseline-middle;')
		return svg.outerHTML
	}
	
	ready_list = [];
	ready_tot = 0;
	page_ready = false

	I.obj['heart'] = add_style(I.obj['heart'])
	I.obj['cart'] = add_style(I.obj['cart'])
	I.obj['bell'] = add_style(I.obj['bell'])
	I.obj['account'] = add_style(I.obj['account'])
	I.obj['info'] = add_style(I.obj['info'])
	I.obj['earth'] = add_style(I.obj['earth'])
	I.obj['store'] = add_style(I.obj['store'])
	I.obj['home'] = add_style(I.obj['home'])
	I.obj['exit'] = add_style(I.obj['exit'])
	I.obj['quote'] = add_style(I.obj['quote'])
	I.obj['option'] = add_style(I.obj['option'])
	I.obj['theme'] = add_style(I.obj['theme'])
	// I.obj['copy'] = add_style(I.obj['copy'])
	I.obj['brain'] = add_style(I.obj['brain'])
	I.obj['list'] = add_style(I.obj['list'])
}

function when_desktop() {
	SimpleScrollbar.initEl(LGen.Page.screen);
	document.querySelector("html").style.overflow = "hidden";
}
function when_mobile() {
}

function lang_get() {
	app = L.app.get(APP_ID)
	if (app[RES_STAT] == NOT_EXIST) {
	  app["FSIZE_RSLIDER_AR"] = 11,
	  app["FSIZE_RSLIDER_LAT"] = 11,
	  app["TOGGLE_TRANSLATION_CHECKED"] = true,
	  app["TOGGLE_TRANSLITERATION_CHECKED"] = true,
	  app["CHECKBOX_WBW_CHECKED"] = true,
	  app["SURAH_NUM"] = 1
	  app["FSIZE_AR"] = 28
	  app["FSIZE_LAT"] = 18
	  app["THEME"] = 'day'
	  app["LANG"] = 'id'
		L.app.set(APP_ID, app)
	}
	LANG = app['LANG']
}