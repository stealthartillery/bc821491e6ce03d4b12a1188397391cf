if (APP_PLATFORM == 'web') {
	ampweb_switch_page(window.location.href)
}
else {
	ampxweb_switch_page('')
}

function route() {
	// PAGE_CODENAME = 'page_maintenance'
	// route_home();
	switch (dirs[0]) {
		case '':
		case undefined:
			PAGE_CODENAME = 'page_home'
			route_home(); break;
		case 'store':
			PAGE_CODENAME = 'page_store'
			route_store(); break;
		case 'item':
			PAGE_CODENAME = 'page_item'
			route_item(); break;
		case 'wishlist':
			PAGE_CODENAME = 'page_wishlist'
			route_wishlist(); break;
		case 'cart':
			PAGE_CODENAME = 'page_cart'
			route_cart(); break;
		case 'order':
			PAGE_CODENAME = 'page_order'
			route_order(); break;
		default:
			PAGE_CODENAME = 'page_notfound'
			F.amp.create_page(); break;
	}
}

function route_home() {
	F.amp.create_page()
}

function route_order() {
	if (dirs[1] == undefined) {
		PAGE_CODENAME = 'page_notfound'
		F.amp.create_page()
	}
	else if (dirs[1] == 'success') {
		PAGE_CODENAME = 'page_order_success'
		F.amp.create_page()
	}
	else {
		item_id = dirs[1]
		PAGE_CODENAME = 'page_order'					
		F.amp.create_page()
	}
}

function route_cart() {
	F.amp.create_page()
}

function route_wishlist() {
	F.amp.create_page()
}

function route_store() {
	if (dirs[1] == undefined) {
		page_id = 'default'
		PAGE_CODENAME = 'page_store_home'
		F.amp.create_page()
	}
	else {
		var url = encodeURI(btoa('$G->get_store_list();'))
		req_to_backlite({'method':'get', 'url':'tradelite/?f='+url, 'callback':function(obj) {
			console.log(obj)
			for (var i=0; i<obj[DATA].length; i++) {
				if (obj[DATA][i] === dirs[1]) {
					page_id = dirs[1]
					PAGE_CODENAME = 'page_store'					
					F.amp.create_page()
					i=obj[DATA].length
				}
				else if (i == obj[DATA].length-1) {
					PAGE_CODENAME = 'page_notfound'
					F.amp.create_page()
				}
			}
		}})
		// req_to_frontlite('tradelite', data, function(obj) {
		// })
	}
}

function route_item() {
	var data = '$G->get_item_list();'
	req_to_frontlite('tradelite', data, function(obj) {
		for (var i=0; i<obj[DATA].length; i++) {
			if (obj[DATA][i] === dirs[1]) {
				item_id = dirs[1]
				PAGE_CODENAME = 'page_item'					
				F.amp.create_page()
				i=obj[DATA].length
			}
			else if (i == obj[DATA].length-1) {
				PAGE_CODENAME = 'page_notfound'
				F.amp.create_page()
			}
		}
	})
}
