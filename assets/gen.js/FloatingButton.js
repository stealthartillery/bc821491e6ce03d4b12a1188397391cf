	/* ========================================
	FLOATING BUTTON
	======================================== */
	function fbutton() {
		this.set = set
		this.is_opened = is_opened
		this.open = open
		this.close = close
		this.add = add

		function set() {
			var tr = document.createElement('tr')

			var tbl = document.createElement('table')
			tbl.appendChild(tr)

			var fbtn = document.createElement('div')
			fbtn.setAttribute('class', 'fbutton')
			fbtn.appendChild(tbl)

			
			// var bg = document.createElement('div')
			// bg.setAttribute('class', 'bg dark')
			// // style = "background-color: black;"
			// style = "opacity: 0.5;"
			// style += "display: none;"
			// bg.setAttribute('style',style)
			// bg.addEventListener('click', function() {
			// })

			var bg = document.createElement('div')
			bg.setAttribute('class', 'bg transparent')
			bg.style.display = 'none'
			bg.addEventListener('click', function() {
				var fbutton = document.querySelector('div.fbutton')
				if (fbutton.className == 'fbutton') {
					fbutton.className = 'fbutton open'
					document.querySelector('div.bg.transparent').style.display = ''
					document.querySelector("html").style.overflow = "hidden";
				}
				else {
					fbutton.className = 'fbutton'
					document.querySelector('div.bg.transparent').style.display = 'none'
					document.querySelector("html").style.overflow = "auto";
				}
				close()
			})

			var canvas = document.querySelector('.canvas')
			canvas.appendChild(fbtn)
			canvas.appendChild(bg)
		}

		function is_opened() {
			var elm = document.querySelector('.fbutton')
			if (elm.className == 'fbutton open')
				return true
			else
				return false
		}

		function open() {
			var fbtn = document.querySelector('.fbutton')
			fbtn.className = 'fbutton open'
			document.querySelector('div.bg.transparent').style.display = ''
		}

		function close() {
			var fbtn = document.querySelector('.fbutton')
			fbtn.className = 'fbutton';
			document.querySelector('div.bg.transparent').style.display = 'none'
		}

		function add (obj) {
			var btn = document.createElement('div')
			// $.when( get_svg(obj['icon'], 'white') ).done(function(svg){
			var svg = str_to_elm(obj['icon'])
			btn.appendChild(svg)
			// });

			// var svg = get_svg(obj['icon'], 'asd')
			// console.log(svg)
			// btn.appendChild(get_svg(obj['icon'], 'asd'))
			// btn.innerHTML = obj['title']
			btn.setAttribute('class', 'btn ' + obj['id'])
			btn.addEventListener('click', function() {
				obj['callback']()
			})

			var td = document.createElement('td')
			td.appendChild(btn)

			var tr = document.querySelector('.fbutton > table > tr')
			tr.appendChild(td)
		}
	}

