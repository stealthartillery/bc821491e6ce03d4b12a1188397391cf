
var icons = {}
var is_icon_ready = false
$.when( get_svg(name='coins', id='white', is_str=true) ).done(function(svg){ icons['coins'] = svg; is_icon_ready=true;});

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

	var page_purchase = document.createElement('div')
	page_purchase.setAttribute('class', 'page_purchase')
	page_purchase.setAttribute('id', 'page_purchase')
	L.body.add(page_purchase)
	json_read_local(BE_URL + '/storage/languages/page_purchase/en', function(obj) {
		// console.log(str_to_elm(obj))
		console.log(obj)
		for(var i=0; i<obj.length; i++) {
		  var keys = Object.keys(obj[i]);
		  if (keys == 'title') {
		  	var txt = document.createElement('h1')
		  	txt.innerHTML = obj[i][keys]
			  page_purchase.appendChild(txt)
		  }
		  else {
		  	var txt = document.createElement('p')
		  	txt.innerHTML = obj[i][keys]		  	
			  page_purchase.appendChild(txt)
		  }
		};

		(function wait() {
		  if (is_icon_ready) {
		  	var div = document.createElement('div')
		  	div.setAttribute('style', 'width:100%; text-align:-webkit-center;')
		  	div.appendChild(create_purchase_table())
				page_purchase.appendChild(div)
			} else {
		    setTimeout( wait, 500 );
		  }
		}) ();
	})
}


function create_purchase_table () {
	var td1 = document.createElement('th')
	td1.setAttribute('colspan', '2')
	td1.innerHTML = 'Purchase Form'

	var tr1 = document.createElement('tr')
	tr1.appendChild(td1)

	var th1 = document.createElement('thead')
	th1.appendChild(tr1)


	var div0 = document.createElement('div')
	div0.innerHTML = 'Litegold Price:'

	var rbtn1 = {}
	rbtn1['id'] = 'rbtn_1'
	rbtn1['group'] = 'g1'
	rbtn1['is_checked'] = false
	rbtn1['is_disabled'] = false
	rbtn1['title'] = '10 Litegold (50.000 IDR)'
	rbtn1['value'] = '10_litegold'
	rbtn1 = L.rbutton.create(rbtn1)
	L.rbutton.onchange(rbtn1, function(val) { rbtn_onchange(val) })

	var div1 = document.createElement('div')
	div1.appendChild(rbtn1)

	var rbtn2 = {}
	rbtn2['id'] = 'rbtn_2'
	rbtn2['group'] = 'g1'
	rbtn2['is_checked'] = true
	rbtn2['is_disabled'] = false
	rbtn2['title'] = '5 Litegold (25.000 IDR)'
	rbtn2['value'] = '5_litegold'
	rbtn2 = L.rbutton.create(rbtn2)
	L.rbutton.onchange(rbtn2, function(val) { rbtn_onchange(val) })

	var div2 = document.createElement('div')
	div2.appendChild(rbtn2)

	var rbtn3 = {}
	rbtn3['id'] = 'rbtn_3'
	rbtn3['group'] = 'g1'
	rbtn3['is_checked'] = false
	rbtn3['is_disabled'] = false
	rbtn3['title'] = '2 Litegold (10.000 IDR)'
	rbtn3['value'] = '2_litegold'
	rbtn3 = L.rbutton.create(rbtn3)
	L.rbutton.onchange(rbtn3, function(val) { rbtn_onchange(val) })

	var rbtn = {}
	rbtn['id'] = 'rbtn_4'
	rbtn['group'] = 'g1'
	rbtn['is_checked'] = false
	rbtn['is_disabled'] = false
	rbtn['title'] = 'Custom'
	rbtn['value'] = 'custom'
	rbtn = L.rbutton.create(rbtn)
	L.rbutton.onchange(rbtn, function(val) { rbtn_onchange(val) })

	var inp = document.createElement('input')
	inp.style.margin = "5px 0px"
	inp.setAttribute('class', 'amount')
	inp.setAttribute('id', 'amount')
	inp.setAttribute('type', 'number')
	inp.setAttribute('step', '1')
	inp.setAttribute('pattern', "\d+")
	inp.setAttribute('placeholder', 'Amount')
	inp.disabled = true
	inp.onkeyup = function() {
		function isNormalInteger(str) {
	    var n = Math.floor(Number(str));
	    return n !== Infinity && String(n) === str && n > 0;
		}
		function lg_to_idr(val) {
	    return numberWithCommas(val*5000);
		}
		function numberWithCommas (x)  {
		  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
		}

		if (this.value != null && !isNormalInteger(this.value)) {
			this.value = ""
			var rbtn = L.rbutton.get('rbtn_4')
			L.rbutton.title(rbtn, this.value+ " Litegold ( IDR)")
		}
		else {
			var rbtn = L.rbutton.get('rbtn_4')
			L.rbutton.title(rbtn, this.value+ " Litegold (" + lg_to_idr(parseInt(this.value)) + " IDR)")
		}
	}

	var div3 = document.createElement('div')
	div3.appendChild(rbtn3)

	function rbtn_onchange (val) {
		if (val == 'custom') {
			document.querySelector('input#amount').disabled = false
		}
		else {
			document.querySelector('input#amount').disabled = true

		}
	}
	var div4 = document.createElement('div')
	div4.appendChild(rbtn)


	var title_a1 = document.createElement('span')
	title_a1.innerHTML = 'Payment Method:'

	var rbtn1 = {}
	rbtn1['id'] = 'rbtn_pm1'
	rbtn1['group'] = 'g2'
	rbtn1['is_checked'] = true
	rbtn1['is_disabled'] = false
	rbtn1['title'] = 'Google Pay'
	rbtn1['value'] = 'gpay'
	rbtn1 = L.rbutton.create(rbtn1)
	L.rbutton.onchange(rbtn1, function(val) {  })

	var rbtn2 = {}
	rbtn2['id'] = 'rbtn_pm2'
	rbtn2['group'] = 'g2'
	rbtn2['is_checked'] = false
	rbtn2['is_disabled'] = false
	rbtn2['title'] = 'PayPal'
	rbtn2['value'] = 'paypal'
	rbtn2 = L.rbutton.create(rbtn2)
	L.rbutton.onchange(rbtn2, function(val) {  })

	var div_a1 = document.createElement('div')
	div_a1.setAttribute('style', 'margin: 10px 0px;')
	div_a1.appendChild(title_a1)
	div_a1.appendChild(rbtn1)
	div_a1.appendChild(rbtn2)

	var title_a1 = document.createElement('span')
	title_a1.innerHTML = 'Currency:'

	var rbtn1 = {}
	rbtn1['id'] = 'rbtn_c1'
	rbtn1['group'] = 'g3'
	rbtn1['is_checked'] = true
	rbtn1['is_disabled'] = false
	rbtn1['title'] = 'IDR (Rupiah)'
	rbtn1['value'] = 'idr'
	rbtn1 = L.rbutton.create(rbtn1)
	L.rbutton.onchange(rbtn1, function(val) {  })

	var rbtn2 = {}
	rbtn2['id'] = 'rbtn_c2'
	rbtn2['group'] = 'g3'
	rbtn2['is_checked'] = false
	rbtn2['is_disabled'] = false
	rbtn2['title'] = 'Dollar'
	rbtn2['value'] = 'dlr'
	rbtn2 = L.rbutton.create(rbtn2)
	L.rbutton.onchange(rbtn2, function(val) {  })

	var div_a2 = document.createElement('div')
	div_a2.setAttribute('style', 'margin: 10px 0px;')
	div_a2.appendChild(title_a1)
	div_a2.appendChild(rbtn1)
	div_a2.appendChild(rbtn2)


	var td_a1 = document.createElement('td')
	td_a1.appendChild(div0)
	td_a1.appendChild(div1)
	td_a1.appendChild(div2)
	td_a1.appendChild(div3)
	td_a1.appendChild(div4)
	td_a1.appendChild(inp)
	td_a1.appendChild(div_a1)
	td_a1.appendChild(div_a2)

	var tr2 = document.createElement('tr')
	tr2.appendChild(td_a1)
	// tr2.appendChild(td_a2)

	// var tb1 = document.createElement('tbody')
	// tb1.appendChild(tr2)

	var btn_donate = document.createElement('button')
	btn_donate.setAttribute('class', 'std gold')
	var div_icon = document.createElement('div')
	$(div_icon).css({'display': 'inline-block'})
	var icon = str_to_elm(icons['coins'])
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
	div_txt.innerHTML = 'Purchase'

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
	tbl.setAttribute('class', 'std fitcontent purchase')
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