if (APP_PLATFORM == 'web') {
	ampweb_switch_page(window.location.href)
}
else {
	ampxweb_switch_page('')
}

function route() {
	switch (dirs[0]) {
		case '':
			PAGE_CODENAME = 'page_home'
			route_home(); break;
		case undefined:
			PAGE_CODENAME = 'page_home'
			route_home(); break;
		case 'product':
			PAGE_CODENAME = 'page_product'
			route_product(); break;
		case 'about':
			PAGE_CODENAME = 'page_about'
			route_about(); break;
		case 'article':
			route_article(); break;
		case 'news':
			PAGE_CODENAME = 'page_news'
			route_news(); break;
		case 'compat':
			PAGE_CODENAME = 'page_compat'
			route_compat(); break;
		case 'register':
			PAGE_CODENAME = 'page_register'
			route_register(); break;
		case 'team':
			PAGE_CODENAME = 'page_team'
			route_team(); break;
		case 'terms':
			PAGE_CODENAME = 'page_terms'
			route_terms(); break;
		default:
			PAGE_CODENAME = 'page_notfound'
			F.amp.create_page(); break;
	}
}

function route_home() {
	F.amp.create_page()
}

function route_product() {
	if (dirs[1] == undefined) {
		F.amp.create_page()
	}
	else {
		PAGE_CODENAME = 'page_notfound'
		F.amp.create_page()
	}
}

function route_about() {
	if (dirs[1] == undefined) {
		F.amp.create_page()
	}
	else {
		PAGE_CODENAME = 'page_notfound'
		F.amp.create_page()
	}
}

function route_register() {
	if (dirs[1] == undefined) {
		F.amp.create_page()
	}
	else {
		PAGE_CODENAME = 'page_notfound'
		F.amp.create_page()
	}
}

function route_terms() {
	if (dirs[1] == undefined) {
		F.amp.create_page()
	}
	else {
		PAGE_CODENAME = 'page_notfound'
		F.amp.create_page()
	}
}

function route_article() {
	if (dirs[1] == undefined) {
		article_id = 'default'
		PAGE_CODENAME = 'page_article_home'
		F.amp.create_page()
	}
	else {
		var data = '$C->get_articles();'
		req_to_frontlite('corelite', data, function(obj) {
			for (var i=0; i<obj[DATA].length; i++) {
				if (obj[DATA][i] === dirs[1]) {
					article_id = dirs[1]
					PAGE_CODENAME = 'page_article'					
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
}

function route_team() {
	if (dirs[1] == undefined) {
		page_id = 'default'
		PAGE_CODENAME = 'page_team_home'
		F.amp.create_page()
	}
	else {
		var data = '$C->get_team();'
		req_to_frontlite('corelite', data, function(obj) {
			for (var i=0; i<obj[DATA].length; i++) {
				if (obj[DATA][i] === dirs[1]) {
					page_id = dirs[1]
					PAGE_CODENAME = 'page_team'					
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
}

function route_news() {
	var data = '$C->get_news();'
	req_to_frontlite('corelite', data, function(obj) {
		for (var i=0; i<obj[DATA].length; i++) {
			if (obj[DATA][i] === dirs[1]) {
				news_id = dirs[1]
				PAGE_CODENAME = 'page_news'					
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

function route_compat() {
	F.amp.create_page()
}
