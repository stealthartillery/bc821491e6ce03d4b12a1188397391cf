


page_home = new PageHome()

function PageHome () {
	this.name = 'page_home'
	
	this.set_lang = set_lang
	function set_lang (lang) {
		var urls = [
			{'name': 'page_home', 'url':HOME_URL + 'assets/lang/page_home/' + lang+'.lgen'}, 
			{'name': 'sidebar', 'url':HOME_URL + 'assets/lang/component/sidebar/' + lang+'.lgen'}, 
			{'name': 'footer', 'url':HOME_URL + 'assets/lang/component/footer/' + lang+'.lgen'}, 
			{'name': 'header', 'url':HOME_URL + 'assets/lang/component/header/' + lang+'.lgen'} 
		]

		text_get(urls, 0, function() {
			// lprint('dada')
			// page_set(); header_set(); sidebar_set(); footer_set();
		})
	}

	this.set = set
	function set () {
		this.screen = LGen.String.to_elm(
		'<div class="page_home">'+
			'<div class="banner">'+
				'<div class="bground">'+
					'<img/>'+
					'<div class="title">'+''+'</div>'+
					'<div class="subtitle">'+''+'</div>'+
				'</div>'+
				'<div class="bground" style="display: none;">'+
					'<img/>'+
					'<div class="title">'+''+'</div>'+
					'<div class="subtitle">'+''+'</div>'+
				'</div>'+
				'<div class="bground" style="display: none;">'+
					'<img/>'+
					'<div class="title">'+''+'</div>'+
					'<div class="subtitle">'+''+'</div>'+
				'</div>'+
				'<div class="bground" style="display: none;">'+
					'<img/>'+
					'<div class="title">'+''+'</div>'+
					'<div class="subtitle">'+''+'</div>'+
				'</div>'+
			'</div>'+
			'<div class="poster">'+
			'<div class="section_title">'+'Berita'+'</div>'+
				'<div class="bground">'+
					'<img class="img2"/>'+
					'<div class="date2">'+''+'</div>'+
					'<div class="title2">'+''+'</div>'+
					'<div class="subtitle2">'+''+'</div>'+
					'<a class="std link2">'+''+'</a>'+
				'</div>'+
				'<div class="bground">'+
					'<img class="img2"/>'+
					'<div class="date2">'+''+'</div>'+
					'<div class="title2">'+''+'</div>'+
					'<div class="subtitle2">'+''+'</div>'+
					'<a class="std link2">'+''+'</a>'+
				'</div>'+
				'<div class="bground">'+
					'<img class="img2"/>'+
					'<div class="date2">'+''+'</div>'+
					'<div class="title2">'+''+'</div>'+
					'<div class="subtitle2">'+''+'</div>'+
					'<a class="std link2">'+''+'</a>'+
				'</div>'+
				'<div class="bground">'+
					'<img class="img2"/>'+
					'<div class="date2">'+''+'</div>'+
					'<div class="title2">'+''+'</div>'+
					'<div class="subtitle2">'+''+'</div>'+
					'<a class="std link2">'+''+'</a>'+
				'</div>'+
			'<div class="section_title">'+'Produk'+'</div>'+
				'<div class="bground">'+
					'<img class="img3"/>'+
					'<div class="title3">'+''+'</div>'+
					'<div class="subtitle3">'+''+'</div>'+
					'<a class="std link3">'+''+'</a>'+
				'</div>'+
				'<div class="bground">'+
					'<img class="img3"/>'+
					'<div class="title3">'+''+'</div>'+
					'<div class="subtitle3">'+''+'</div>'+
					'<a class="std link3">'+''+'</a>'+
				'</div>'+
				'<div class="bground">'+
					'<img class="img3"/>'+
					'<div class="title3">'+''+'</div>'+
					'<div class="subtitle3">'+''+'</div>'+
					'<a class="std link3">'+''+'</a>'+
				'</div>'+
				'<div class="bground">'+
					'<img class="img3"/>'+
					'<div class="title3">'+''+'</div>'+
					'<div class="subtitle3">'+''+'</div>'+
					'<a class="std link3">'+''+'</a>'+
				'</div>'+
			'</div>'+
		'</div>')
		this.screen.appendChild(LGen.component.footer.screen)
	}

	this.move_banner = move_banner
	function move_banner() {
		this.move_banner_interval = setInterval(
			function() {
				$(page_home.screen.querySelectorAll('.banner .bground')[page_home.current_banner]).fadeOut(0)
				page_home.current_banner += 1
				if (page_home.current_banner >= page_home.banner_total)
					page_home.current_banner = 0
				$(page_home.screen.querySelectorAll('.banner .bground')[page_home.current_banner]).fadeIn()
			}
		,7000)
	}

	this.update_poster = update_poster
	function update_poster() {
		LGen.f.send_get(
			'update.lanterlite.com/update/',
			'get_data("assets/www.lanterlite.com/lang/page_home/banners/id.lgen", "lgen")', 
			function(obj) {
				for (var i=0; i< obj.length; i++) {
					page_home.screen.querySelectorAll('.banner .bground img')[i].src = LGen.system.fe_url+'update.lanterlite.com/'+obj[i]['img']
					page_home.screen.querySelectorAll('.banner .bground .title')[i].innerText = obj[i]['title']
					page_home.screen.querySelectorAll('.banner .bground .subtitle')[i].innerText = obj[i]['sub']
				}
				page_home.banner_total = obj.length
				page_home.current_banner = 0
				page_home.move_banner()
			}
		)
		LGen.f.send_get(
			'update.lanterlite.com/update/',
			'get_data("assets/www.lanterlite.com/lang/page_home/news/id.lgen", "lgen")', 
			function(obj) {
				for (var i=0; i< obj.length; i++) {
					page_home.screen.querySelectorAll('.title2')[i].innerText = obj[i]['title']
					page_home.screen.querySelectorAll('.subtitle2')[i].innerText = obj[i]['sub']
					page_home.screen.querySelectorAll('.date2')[i].innerText = obj[i]['date']
					page_home.screen.querySelectorAll('.link2')[i].innerText = obj[i]['link']['title']
					page_home.screen.querySelectorAll('.img2')[i].src = LGen.system.fe_url+'update.lanterlite.com/'+obj[i]['img']
				}
			}
		)
		LGen.f.send_get(
			'update.lanterlite.com/update/',
			'get_data("assets/www.lanterlite.com/lang/page_home/products/id.lgen", "lgen")', 
			function(obj) {
				for (var i=0; i< obj.length; i++) {
					page_home.screen.querySelectorAll('.title3')[i].innerText = obj[i]['title']
					page_home.screen.querySelectorAll('.subtitle3')[i].innerText = obj[i]['sub']
					page_home.screen.querySelectorAll('.link3')[i].innerText = obj[i]['link']['title']
					page_home.screen.querySelectorAll('.img3')[i].src = LGen.system.fe_url+'update.lanterlite.com/'+obj[i]['img']
				}
			}
		)		
	}

	this.when_closed = when_closed
	function when_closed() {
		clearInterval(page_home.move_banner_interval)
		// clearInterval(this.move_banner_interval)
	}

	this.when_opened = when_opened
	function when_opened() {
		LGen.Elm.clear_childs(LGen.component.sidebar.screen)
		LGen.component.sidebar.add({'icon':'bell', 'name':'Artikel', 'callback':function(obj){ 
			LGen.Page.change('page_article')
			lprint(obj) 
		}})
		LGen.component.sidebar.add({'icon':'bell', 'name':'Produk', 'callback':function(obj){ lprint(obj) }})
		LGen.component.sidebar.add({'icon':'bell', 'name':'Tentang Kami', 'callback':function(obj){ lprint(obj) }})

		page_home.update_poster()
	}

}