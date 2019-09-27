/* ========================================
LOADING
======================================== */
function loading() {
	this.set = set
	this.open = open
	this.close = close

	function open() {
		$('#loading').fadeIn()
	}

	function close() {
		$('#loading').fadeOut()
	}

// 	function set() {
// 		var loader = document.createElement('div')
// 		loader.setAttribute('class', 'loader')

// 		for (var i=0; i<4; i++) {
// 			var circle = document.createElement('div')
// 			circle.setAttribute('class', 'splash-circle')
// 			circle.innerHTML = '&nbsp;'
// 			loader.appendChild(circle)
// 		}

// 		var splash = document.createElement('div')
// 		splash.setAttribute('class', 'splash')
// 		splash.appendChild(loader)

// 		var loading = document.createElement('div')
// 		loading.setAttribute('class', 'loading')
// 		loading.setAttribute('id', 'loading')
// 		loading.appendChild(splash)

// 		document.querySelector('.canvas').appendChild(loading)
// 		$(loading).fadeOut()
// 	}

	function set() {
		// var elm = "<div class='lds-ellipsis'><div></div><div></div><div></div><div></div></div>"
		var elm = '<div class="loading" id="loading"> <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>'
		// var elm = '<div class="loading spinner" id="loading"> <div class="dot1"></div> <div class="dot2"></div> </div>'
		elm = LGen.StringMan.to_elm(elm)
		elm.style.display = 'none'

		// var loading = document.createElement('div')
		// loading.setAttribute('class', 'loading2')
		// loading.setAttribute('id', 'loading2')
		// loading.appendChild(elm)

		document.querySelector('.canvas').appendChild(elm)
		$(elm).fadeOut()
		// document.querySelector('.canvas').appendChild(elm)
		// $(loading).fadeOut()
	}

}		
