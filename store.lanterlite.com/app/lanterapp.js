var lanterapp_set = function () {
	// LGen.component.header.set()
	// LGen.component.header.menu.set()
	LGen.component.header.logo.set()
	// LGen.component.header.srcbar.set()
	LGen.component.header.acc.set()
	// LGen.component.header.add({'id':'h_option','icon':'option', 'func':function(){
	// 	page_config.previous_page = LGen.Page.current
	// 	LGen.Page.change('page_config')
	// }})

	// LGen.component.content.set_online()
	LGen.component.sidebar.set()
	LGen.component.footer.set()

	LGen.call({'c':'gen','f':'recursive_js_import'})([
		LGen.system.get({'safe':'safe'}).home_url+'app/page/page_home.js',
		LGen.system.get({'safe':'safe'}).home_url+'app/page/page_team.js',
		LGen.system.get({'safe':'safe'}).home_url+'app/page/page_about.js',
		LGen.system.get({'safe':'safe'}).home_url+'app/page/page_order_success.js',
		LGen.system.get({'safe':'safe'}).home_url+'app/page/page_order_success_xweb.js',
		LGen.system.get({'safe':'safe'}).home_url+'app/page/page_item.js',
		LGen.system.get({'safe':'safe'}).home_url+'app/page/page_store.js',
		// LGen.system.get({'safe':'safe'}).home_url+'app/page/page_product.js',
	], 0, function() {
		// LGen.citizen.set_default()
		LGen.Page.ready = true	
	})
}

lanterapp_set()
lanterapp_set = function(){}