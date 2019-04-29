/* ================================================================ */
var app = L.app.get(APP_ID)
if (app[RES_STAT] == NOT_EXIST) {
	// if (visitor.geo.countryName  == 'Indonesia')
	  app["LANG"] = 'id'
	// else
	//   app["LANG"] = 'en'
	L.app.set(APP_ID, app)
}

var LANG = app['LANG']

var URL = {}
URL['page'] = 'page_register/' + LANG
URL['header'] = 'component/header/' + LANG
URL['sidebar'] = 'component/sidebar/' + LANG
URL['footer'] = 'component/footer/' + LANG
var KEYS = Object.keys(URL);

var TXT = []
TXT.push('page')
TXT.push('header')
TXT.push('sidebar')
TXT.push('footer')

var _page_set = function(){page_set()}
var _header_set = function(){header_set()}
var _sidebar_set = function(){sidebar_set()}
var _footer_set = function(){footer_set()}

var SET = []
SET.push(_page_set)
SET.push(_header_set)
SET.push(_sidebar_set)
SET.push(_footer_set)

if (login) {
	change_page_by_url(HOME_URL);
	// window.open(HOME_URL,"_self");
}
else {
	init()
}

function init() {

	var count = 0
	text_get(count)

	function text_get(count) {
	 	json_read_local(BASE_URL + 'assets/'+APP_CODENAME+'/lang/'+URL[KEYS[count]], function(obj) {
			TXT[KEYS[count]] = obj
			SET[count]()
			count += 1
			if (count < KEYS.length) {
				text_get(count)
			}
		})
	}
}

function page_set() {
	L.head.meta.add_desc(TXT['page']['tag']['meta']['description'])
	L.head.title_set(TXT['page']['tag']['meta']['title'])

	var d = createDesc()
	var f = createFields2()

	var td_1 = document.createElement('td')
	var style = 'vertical-align: top;'
	style += 'width: 50%;'
	td_1.setAttribute('style',style)
	td_1.appendChild(d)

	var td_2 = document.createElement('td')
	var style = 'vertical-align: top;'
	style += 'width: 50%;'
	td_2.setAttribute('style',style)
	var div = document.createElement('div')
	div.appendChild(f)
	td_2.appendChild(f)

	var tr_1 = document.createElement('tr')
	tr_1.appendChild(td_1)
	var tr_2 = document.createElement('tr')
	tr_2.appendChild(td_2)

	var tbl = document.createElement('table')
	tbl.appendChild(tr_2)
	tbl.appendChild(tr_1)

	var reg_page = document.createElement('div')
	reg_page.setAttribute('class', 'register-page')
	reg_page.appendChild(tbl)

	var home_page = document.createElement('div')
	home_page.setAttribute('class', 'home-page')
	home_page.appendChild(reg_page)

	L.body.add(home_page)

}


function createFields2() {
	var td_t = document.createElement('td')
	td_t.setAttribute("colspan", "2")
	td_t.setAttribute("class", "title")
	var div = document.createElement('div')
	div.innerHTML = TXT['page']['words']['create_account']
	div.setAttribute('class', 'title')
	div.setAttribute('id', 'register_create_account')
	td_t.appendChild(div)

	var tr_t = document.createElement('tr')
	tr_t.appendChild(td_t)

	//// User Image
	var td_1a = document.createElement('td')
	var div = document.createElement('div')
	div.setAttribute("class", "subtitle")
	div.setAttribute("id", "register_profile_image")
	div.innerHTML = TXT['page']['words']['image']
	td_1a.appendChild(div)

	var inp = document.createElement('input')
	inp.setAttribute('id', 'upload')
	inp.setAttribute('type', 'file')
	inp.setAttribute('name', 'upload')
	inp.setAttribute('name', 'upload')
	style = "visibility: hidden;"
	style += "width: 1px;"
	style += "height: 1px;"
	inp.setAttribute('style', style)
	inp.multiple = true
	inp.addEventListener('change', function () {previewFile()})
	
	var img = document.createElement('img')
	img.setAttribute('id', 'user_img_register')
	img.setAttribute('class', 'profile-image')
	img.src = BASE_URL + "assets/lite.img/user.png"
	img.setAttribute("height", "200")
	img.setAttribute("alt", "Image preview...")

	var td_1b = document.createElement('td')
	style = "text-align: center;"
	td_1b.setAttribute('style', style)
	td_1b.appendChild(inp)
	td_1b.appendChild(img)

	var tr_1 = document.createElement('tr')
	// tr_1.appendChild(td_1a)
	tr_1.appendChild(td_1b)


	//// Fullname
	var td_2b = document.createElement('td')
	var inp = document.createElement('input')
	inp.setAttribute('id', 'user_fullname')
	inp.setAttribute('type', 'text')
	inp.setAttribute('placeholder', TXT['page']['words']['full_name'])
	inp.setAttribute('autocomplete', 'off')
	inp.setAttribute('spellcheck', 'false')
	var span_1 = document.createElement('span')
	span_1.setAttribute('class', 'register-point')
	span_1.innerHTML = "*"
	var span_2 = document.createElement('span')
	span_2.setAttribute('id', 'fullname_warn')
	td_2b.appendChild(inp)

	var tr_2 = document.createElement('tr')
	tr_2.appendChild(td_2b)

	//// Username
	var td_3b = document.createElement('td')
	var inp = document.createElement('input')
	inp.setAttribute('id', 'user_username')
	inp.setAttribute('type', 'text')
	inp.setAttribute('placeholder', TXT['page']['words']['username'])
	inp.setAttribute('autocomplete', 'off')
	inp.setAttribute('spellcheck', 'false')
	var span_1 = document.createElement('span')
	span_1.setAttribute('class', 'register-point')
	span_1.innerHTML = "*"
	var span_2 = document.createElement('span')
	span_2.setAttribute('id', 'username_warn')
	td_3b.appendChild(inp)

	var tr_3 = document.createElement('tr')
	tr_3.appendChild(td_3b)

	//// Email
	var inp = document.createElement('input')
	inp.setAttribute('id', 'user_email')
	inp.setAttribute('type', 'text')
	inp.setAttribute('placeholder', TXT['page']['words']['email'])
	inp.setAttribute('autocomplete', 'off')
	inp.setAttribute('spellcheck', 'false')

	var span_1 = document.createElement('span')
	span_1.setAttribute('class', 'register-point')
	span_1.innerHTML = "*"
	var span_2 = document.createElement('span')
	span_2.setAttribute('id', 'email_warn')
	
	var td_4b = document.createElement('td')
	td_4b.appendChild(inp)

	var tr_4 = document.createElement('tr')
	tr_4.appendChild(td_4b)

	//// Password
	var inp = document.createElement('input')
	inp.setAttribute('id', 'user_password')
	inp.setAttribute('type', 'password')
	inp.setAttribute('placeholder', TXT['page']['words']['password'])
	inp.setAttribute('autocomplete', 'off')
	inp.setAttribute('spellcheck', 'false')
	var span_1 = document.createElement('span')
	span_1.setAttribute('class', 'register-point')
	span_1.innerHTML = "*"
	var span_2 = document.createElement('span')
	span_2.setAttribute('id', 'password_warn')

	var td_5b = document.createElement('td')
	td_5b.appendChild(inp)

	var tr_5 = document.createElement('tr')
	tr_5.appendChild(td_5b)

	//// Confirm Password
	var td_6b = document.createElement('td')
	var inp = document.createElement('input')
	inp.setAttribute('id', 'user_confirm_password')
	inp.setAttribute('type', 'password')
	inp.setAttribute('placeholder', TXT['page']['words']['password_confirmation'])
	inp.setAttribute('autocomplete', 'off')
	inp.setAttribute('spellcheck', 'false')
	var span_1 = document.createElement('span')
	span_1.setAttribute('class', 'register-point')
	span_1.innerHTML = "*"
	var span_2 = document.createElement('span')
	span_2.setAttribute('id', 'confirm_password_warn')
	td_6b.appendChild(inp)

	var tr_6 = document.createElement('tr')
	tr_6.appendChild(td_6b)

	//// Agreement
	var inp = document.createElement('input')
	inp.setAttribute('type', 'checkbox')			
	inp.setAttribute('id', 'agreement-cbx')

	inp.addEventListener('click', function() {
		var cbx = document.querySelector('.container input')
    if (cbx.checked) {
      $("#register-create-account-btn").fadeIn();
    }
    else {
      $("#register-create-account-btn").fadeOut();
    }
	})


	// inp.setAttribute('class', '')


	var span = document.createElement('span')
	span.setAttribute('class', 'checkmark')


	var label = document.createElement('label')
	style = ([
		'color:black;',
		'font-size: 16px;',
	]).join(' ')
	label.setAttribute('style', style)
	label.setAttribute('for', 'checkbox')
	label.innerHTML = TXT['page']['words']['terms_statement_1']
	var a = document.createElement('a')
	style = ([
		'color:#0600AD;',
		'font-size: 16px;',
	]).join(' ')
	a.setAttribute('style', style)
	a.setAttribute('id', 'register_terms_cond_2')
	a.setAttribute('class', 'terms_cond_link')
	a.href = HOME_URL + 'terms'
	a.target = "_blank"
	a.innerHTML = TXT['page']['words']['terms_statement_2']

	var stc = document.createElement('div')
	stc.appendChild(label)
	stc.appendChild(a)
	var td_7b = document.createElement('td')
	// var style = 'height: 100px;'
	// td_7b.setAttribute('style', style)
	td_7b.setAttribute('colspan', '2')

	var cont = document.createElement('label')
	cont.setAttribute('class', 'container')
	cont.appendChild(stc)
	cont.appendChild(inp)
	cont.appendChild(span)
	td_7b.appendChild(cont)

	// td_7b.appendChild(inp)
	// td_7b.appendChild(label)
	// td_7b.appendChild(a)

	var tr_7 = document.createElement('tr')
	tr_7.appendChild(td_7b)

	//// Create Button
	var btn = document.createElement('button')
	btn.setAttribute('class', 'brown-btn')
	btn.setAttribute('id', 'register-create-account-btn')
	btn.style.display = 'none'
	btn.innerHTML = TXT['page']['words']['create_account']
	btn.addEventListener('click', function() {
		btn.disabled = true
		L.loading.open()		
		signUp()
	})
	var td_8 = document.createElement('td')
	style = "text-align: center;"
	td_8.setAttribute('style',style)
	td_8.appendChild(btn)

	var tr_8 = document.createElement('tr')
	tr_8.appendChild(td_8)

	var tbl = document.createElement('table')
	tbl.setAttribute('class', 'fields')
	var style = 'width: auto;'
	style += 'margin: auto;'
	tbl.setAttribute('style',style)
	tbl.appendChild(tr_t)
	tbl.appendChild(tr_1)
	tbl.appendChild(tr_2)
	tbl.appendChild(tr_3)
	tbl.appendChild(tr_4)
	tbl.appendChild(tr_5)
	tbl.appendChild(tr_6)
	tbl.appendChild(tr_7)
	tbl.appendChild(tr_8)
	return tbl

}

function createDesc() {


	var div = document.createElement('div')
	div.innerHTML = TXT['page']['words']['account_purpose']
	div.setAttribute('class', 'subtitle')

	var td_2 = document.createElement('td')
	td_2.appendChild(div)

	var tr_2 = document.createElement('tr')
	tr_2.appendChild(td_2)

	var tbl = document.createElement('table')
	var style = ([
		// 'vertical-align: top;',
		'width:0%;',
		'margin:10px;',
	]).join(' ')
	tbl.setAttribute('style', style)
	tbl.appendChild(tr_2)
	return tbl
}

//// Function to check letters and numbers.
function checkPassword(text) { 
    var passw_a = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/; //// To check a password between 6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase letter
    var paswd_b =  /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/; //// To check a password between 7 to 15 characters which contain at least one numeric digit and a special character
    var paswd_c =  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/; //// To check a password between 8 to 15 characters which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character
    if (text.match(paswd_b)) { 
        return true;
    }
    else { 
        return false;
    }
}

//// Function to check letters and numbers.
function validateAlphanumeric(text) {
  var letterNumber = /^[0-9a-zA-Z]+$/;
  if(text.match(letterNumber)) {
      return true;
  }
  else {
      return false; 
  }
}

function signUp() {
    var user_fullname = document.getElementById('user_fullname').value;
    var user_username = document.getElementById('user_username').value.toLowerCase();
    var user_email = document.getElementById('user_email').value.toLowerCase();
    var user_password = document.getElementById('user_password').value;
    var user_confirm_password = document.getElementById('user_confirm_password').value;
    var user_image = document.getElementById('user_img_register').src;
    var isValid = true; 

    //// Full name field is empty.
    if  (user_fullname == "") { 
				L.loading.close()
        L.snackbar.open(TXT['page']['words']['fullname_empty'])
        document.querySelector('#register-create-account-btn').disabled = false
        isValid = false
    }
		
		//// Username field is empty.
    if (user_username == "") { 
				L.loading.close()
        L.snackbar.open(TXT['page']['words']['username_empty'])
        document.querySelector('#register-create-account-btn').disabled = false
        isValid = false
    }
    //// Username field is below 4 characters.
    else if (user_username.length < 4) { 
				L.loading.close()
        L.snackbar.open(TXT['page']['words']['username_min'])
        document.querySelector('#register-create-account-btn').disabled = false        
        isValid = false
    }
    //// Username field is below 4 characters.
    else if (user_username.length > 10) { 
				L.loading.close()
        L.snackbar.open(TXT['page']['words']['username_max'])
        document.querySelector('#register-create-account-btn').disabled = false
        isValid = false
    }
    //// Username field is alphanumeric.
    else if (!validateAlphanumeric(user_username)) { 
				L.loading.close()
        L.snackbar.open(TXT['page']['words']['username_spec'])
        document.querySelector('#register-create-account-btn').disabled = false
        isValid = false
    }

    //// Email field is empty.
    if (user_email == "") { 
				L.loading.close()
        L.snackbar.open(TXT['page']['words']['email_empty'])
        document.querySelector('#register-create-account-btn').disabled = false
        isValid = false
    }
    //// Email field is not valid.
    else if (validateEmail(user_email) == false) { 
				L.loading.close()
        L.snackbar.open(TXT['page']['words']['email_invalid'])
        document.querySelector('#register-create-account-btn').disabled = false
        isValid = false
    }

    //// Password field is empty.
    if (user_password == "") { 
				L.loading.close()
        L.snackbar.open(TXT['page']['words']['pass_empty'])
        document.querySelector('#register-create-account-btn').disabled = false
        isValid = false
    }
    
    //// Password is not valid.
    if (!checkPassword(user_password)) { 
				L.loading.close()
        L.snackbar.open(TXT['page']['words']['pass_min'])
        document.querySelector('#register-create-account-btn').disabled = false
        isValid = false
    }

    //// Confirm password field is empty.
    if (user_confirm_password == "") { 
				L.loading.close()
        L.snackbar.open(TXT['page']['words']['cpass_empty'])
        document.querySelector('#register-create-account-btn').disabled = false
        isValid = false
    }
    //// Password and confirm password fields does not match.
    else if (user_password != user_confirm_password){ 
				L.loading.close()
        L.snackbar.open(TXT['page']['words']['pass_not_match'])
        document.querySelector('#register-create-account-btn').disabled = false
        isValid = false
    }

    //// Every field is ok.
    if (isValid) { 
		
			document.getElementById("register-create-account-btn").disabled = true;
        
      var data = { //// Assign JSON data to send.
        'user_fullname' : user_fullname, 
        'user_username' : user_username, 
        'user_email' : user_email,
        'user_password' : MD5(user_password),
        // 'user_image' : user_image,
      }

      signUpFromBackend(data, function(obj) {
      	console.log(obj)
        if (obj[RES_STAT] == USERNAME_EXIST) {
					L.loading.close()
       		L.snackbar.open(TXT['page']['words']['username_exist'])
					document.getElementById("register-create-account-btn").disabled = false;
        }
        else if (obj[RES_STAT] == EMAIL_EXIST) {
					L.loading.close()
	        L.snackbar.open(TXT['page']['words']['email_exist'])
					document.getElementById("register-create-account-btn").disabled = false;
        }
        else if (obj[RES_STAT] == SUCCESS) {
					L.loading.close()
					sessionStorage.setItem(MD5("user"), btoa(JSON.stringify(obj['Data'])));
          location.reload();
        }
      })
    }

    return false;
}


function previewFile() {
	var preview = document.querySelector('.register-page #user_img_register');
	var file		= document.querySelector('.register-page input[type=file]').files[0];
	var reader	= new FileReader();

	reader.addEventListener("load", function () {
		preview.src = reader.result;
		document.getElementById('user_img_register').src = preview.src
	}, false);

	if (file) {
		reader.readAsDataURL(file);
	 } else {
		 preview.src = document.getElementById('user_img_register').src;
	 }
}

function sidebar_set () {
	L.sidebar.set()

	var sidebar_img = BASE_URL + "assets/lite.img/lanterlite+logo.svg"
	L.sidebar.img(sidebar_img)
	function func_create(link) {
		return function() { change_page_by_url(HOME_URL + link) }		
	}
	for (var i=0; i<TXT['sidebar']['sidebar'].length; i++) {
		var func = func_create(TXT['sidebar']['sidebar'][i]['link'])
		L.sidebar.add({'id': 'sb' + i, 'title': TXT['sidebar']['sidebar'][i]['title'], 'callback': func })
	}
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
