var icons = {}
var is_icon_ready = false
$.when( get_svg(name='donate', id='white', is_str=true) ).done(function(svg){ icons['donate'] = svg; is_icon_ready=true;});

var page = ''
var FF_SIZE = 12;
getLangFromBackend('en', function(obj) {
	sessionStorage.setItem(MD5('lang'), btoa(JSON.stringify(obj['Data'])));
})

header_set()
importScript('./assets/js/footer.js');

(function wait() {
  if (sessionStorage.getItem(MD5("lang")) != null) {
		page_create()
		toTop()
	} else {
    setTimeout( wait, 500 );
  }
}) ();

function page_create() {
	page = JSON.parse(atob(sessionStorage.getItem(MD5('lang'))))
	sidebar_set()
	L.head.meta.add_desc(page.home_page.meta.description)
	L.head.title_set(page.home_page.title)

	var page_donate = document.createElement('div')
	page_donate.setAttribute('class', 'page_donate')
	page_donate.setAttribute('id', 'page_donate')
	L.body.add(page_donate)
	json_read_local(BE_URL + '/storage/languages/donate/en', function(obj) {
		// console.log(str_to_elm(obj))
		console.log(obj)
		for(var i=0; i<obj.length; i++) {
		  var keys = Object.keys(obj[i]);
		  if (keys == 'title') {
		  	var txt = document.createElement('h1')
		  	txt.innerHTML = obj[i][keys]
			  page_donate.appendChild(txt)
		  }
		  else {
		  	var txt = document.createElement('p')
		  	txt.innerHTML = obj[i][keys]		  	
			  page_donate.appendChild(txt)
		  }
		};

		(function wait() {
		  if (is_icon_ready) {
				page_donate.appendChild(create_donor_table())
			} else {
		    setTimeout( wait, 500 );
		  }
		}) ();
	})
}

function create_donor_table () {
	var td1 = document.createElement('th')
	td1.setAttribute('colspan', '2')
	td1.innerHTML = 'Donate Form'

	var tr1 = document.createElement('tr')
	tr1.appendChild(td1)

	var th1 = document.createElement('thead')
	th1.appendChild(tr1)

	var inp = document.createElement('input')
	inp.style.margin = "5px 0px"
	inp.setAttribute('class', 'std name')
	inp.setAttribute('id', 'name')
	inp.setAttribute('placeholder', 'Name')

	var inp2 = document.createElement('input')
	inp2.style.margin = "5px 0px"
	inp2.setAttribute('class', 'std')
	inp2.setAttribute('type', 'number')
	inp2.setAttribute('step', '1')
	inp2.setAttribute('pattern', "\d+")
	inp2.setAttribute('placeholder', 'Amount')

	var ta = document.createElement('textarea')
	ta.style.margin = "5px 0px"
	ta.setAttribute('class', 'std')
	ta.setAttribute('placeholder', 'Comment')

	var div0 = document.createElement('div')
	div0.innerHTML = 'Donor information:'
	
	var cbox = L.checkbox.create()
	L.checkbox.name(cbox, 'Anonymous')
	L.checkbox.icon(cbox)
	// L.checkbox.swap(cbox)
	L.checkbox.checked(cbox, false)
	L.checkbox.onclick(cbox, function(is_checked) {
		if (is_checked) {
			document.querySelector('input#name').disabled = true
			document.querySelector('input#name').setAttribute('placeholder', 'Anonymous')
		}
		else {
			document.querySelector('input#name').disabled = false				
			document.querySelector('input#name').setAttribute('placeholder', 'Name')
		}
	})

	var div1 = document.createElement('div')
	div1.appendChild(cbox)
	div1.setAttribute('style', 'margin: 10px 0px;')
	
	var container1 = document.createElement('div')
	container1.setAttribute('style', 'margin: 10px')
	container1.appendChild(div1)
	container1.appendChild(inp)
	container1.appendChild(inp2)
	container1.appendChild(ta)

	var td_a1 = document.createElement('td')
	td_a1.setAttribute('class', 'flexible')
	td_a1.appendChild(div0)
	td_a1.appendChild(container1)

	var div0 = document.createElement('div')
	div0.innerHTML = 'Choose Currency'

	var rbtn = {}
	rbtn['id'] = 'rbtn_idr'
	rbtn['group'] = 'g2'
	rbtn['is_checked'] = true
	rbtn['is_disabled'] = false
	rbtn['title'] = 'IDR (Rupiah)'

	var div1 = document.createElement('div')
	div1.appendChild(L.rbutton.create(rbtn))

	td_a1.appendChild(div0)
	td_a1.appendChild(div1)

	var div0 = document.createElement('div')
	div0.innerHTML = 'Payment Method:'

	var rbtn = {}
	rbtn['id'] = 'rbtn_pm'
	rbtn['group'] = 'g3'
	rbtn['is_checked'] = true
	rbtn['is_disabled'] = false
	rbtn['title'] = 'Google Pay'

	var div1 = document.createElement('div')
	div1.appendChild(L.rbutton.create(rbtn))

	td_a1.appendChild(div0)
	td_a1.appendChild(div1)

	var div1 = document.createElement('div')
	var rbtn = {}
	rbtn['id'] = 'rbtn_lan'
	rbtn['group'] = 'g1'
	rbtn['is_checked'] = true
	rbtn['is_disabled'] = false
	rbtn['title'] = 'Project in General'

	div1.appendChild(L.rbutton.create(rbtn))

	var rbtn = {}
	rbtn['id'] = 'rbtn_en'
	rbtn['group'] = 'g1'
	rbtn['is_checked'] = false
	rbtn['is_disabled'] = false
	rbtn['title'] = 'Enlite Project'

	var div2 = document.createElement('div')
	div2.appendChild(L.rbutton.create(rbtn))

	var rbtn = {}
	rbtn['id'] = 'rbtn_qu'
	rbtn['group'] = 'g1'
	rbtn['is_checked'] = false
	rbtn['is_disabled'] = false
	rbtn['title'] = 'Qulite Project'

	var div3 = document.createElement('div')
	div3.appendChild(L.rbutton.create(rbtn))

	var div0 = document.createElement('div')
	div0.innerHTML = 'Choose to Donate:'
	
	var td_a2 = document.createElement('td')
	td_a2.setAttribute('class', 'flexible')
	td_a2.setAttribute('style', 'text-align: left; vertical-align: top; min-width: 150px;')
	td_a2.appendChild(div0)
	td_a2.appendChild(div1)
	td_a2.appendChild(div2)
	td_a2.appendChild(div3)

	var tr2 = document.createElement('tr')
	tr2.appendChild(td_a1)
	tr2.appendChild(td_a2)

	var btn_donate = document.createElement('button')

	btn_donate.setAttribute('class', 'std gold')
	var div_icon = document.createElement('div')
	$(div_icon).css({'display': 'inline-block'})
	var icon = str_to_elm(icons['donate'])
	icon.setAttribute('class', 'white')
	$(icon).css ({
		'height': '15px',
		'width': '26px',
		'transform': 'rotate(360deg)',
    'vertical-align': 'top',
	})
	div_icon.appendChild(icon)
	var div_txt = document.createElement('div')
	$(div_txt).css({'display': 'inline-block', 'width': '70px'})
	div_txt.innerHTML = 'Donate'

	btn_donate.appendChild(div_icon)
	btn_donate.appendChild(div_txt)
	btn_donate.addEventListener('click', function() {	})

	var td_b1 = document.createElement('td')
	td_b1.setAttribute('colspan', '2')
	td_b1.setAttribute('style', 'text-align: center;')
	td_b1.appendChild(btn_donate)

	var tr3 = document.createElement('tr')
	tr3.appendChild(td_b1)

	var tb1 = document.createElement('tbody')
	tb1.appendChild(tr2)
	tb1.appendChild(tr3)

	var tbl = document.createElement('table')
	tbl.setAttribute('class', 'std donate')
	tbl.appendChild(th1)
	tbl.appendChild(tb1)
	return tbl
}

function sidebar_set() {
	L.sidebar.set()

	var sidebar_img = BASE_URL + "assets/lite.img/lanterlite+logo.svg"
	L.sidebar.img(sidebar_img)

	L.sidebar.add({'id': 'sb1', 'title': page['sidebar']['home'], 'callback': function(e) { window.location.href = HOME_URL + '/' }})
	L.sidebar.add({'id': 'sb2', 'title': page['sidebar']['product'], 'callback': function(e) { window.location.href = HOME_URL + '/product' }})
	L.sidebar.add({'id': 'sb3', 'title': page['sidebar']['about'], 'callback': function(e) { window.location.href = HOME_URL + '/about' } })
}

function header_set() {
	L.header.set()
	L.header.menu.set()
	var menu_logo = BASE_URL + "assets/lite.img/sidebar.svg"
	L.header.menu.img(menu_logo)
	L.header.logo.set()
	L.header.blank_col.set()
	L.header.account.set()
	L.header.hide_when_scroll_on()
	var header_img = BASE_URL + "assets/lite.img/lanterlite.svg"
	L.header.logo.img(header_img)
}