LGen.component.image = new ComponentImage()
LGen.component.image.set()

function ComponentImage() {
	this.max_height = 500
	this.max_width = 500
	this.filetype = 'image/webp'
	this.callback = function() {}

	this.open = open
	function open() {
		var compo = LGen.component.image
		$(compo.screen.querySelector("input[type='file']")).trigger('click');
	}

	this.set = set
	function set() {
		var compo = LGen.component.image
		compo.screen = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div class="img_croppie">'+
				'<div class="img">'+'</div>'+
				'<input class="std gold file" type="file" id="files" accept=".webp">'+
				'<button class="cancel_btn std gold theme fp">Cancel</button>'+
				'<button class="save_btn std gold theme fp">Save</button>'+
			'</div>'
		)
		$(compo.screen.querySelector('input')).on('change', compo.handleFileSelect2)
		$(compo.screen.querySelector('input')).css({'opacity':'0'})
		$(compo.screen.querySelector('input')).css({'pointer-events':'none'})

		// LGen.Page.set_css(compo.screen)
		// LGen.Page.Self.update_css(compo.screen)
		compo.screen.querySelector('.cancel_btn').addEventListener('click', function() {
			if ($(compo.screen).hasClass('open')) {
	      $(compo.screen).removeClass('open')
	      setTimeout(function() {
	      	$(compo.screen).css({'display':'none'})
	      }, LGen.Page.speed)
			}
      setTimeout(function() {
        LGen.call({'c':'elm','f':'clear_childs'})(compo.screen.querySelector('.img'))
        $(compo.screen.querySelector('.img')).removeClass('croppie-container')
      }, LGen.Page.speed)
      compo.current_img.value = ''
		})
		compo.screen.querySelector('.save_btn').addEventListener('click', function() {
			$(compo.screen.querySelector('.img')).croppie('result',{
				type:'base64',
				format:'webp'
			}).then(function(r) { 
				if ($(compo.screen).hasClass('open')) {
	        $(compo.screen).removeClass('open')
		      setTimeout(function() {
		      	$(compo.screen).css({'display':'none'})
		      }, LGen.Page.speed)
				}
        setTimeout(function() {
	        LGen.call({'c':'elm','f':'clear_childs'})(compo.screen.querySelector('.img'))
	        $(compo.screen.querySelector('.img')).removeClass('croppie-container')
        }, LGen.Page.speed)
        compo.current_img.value = ''
        compo.callback(r)
        lprint(r)
			});
		})
		LGen.Page.screen.appendChild(compo.screen)
	}

	this.create = create
	function create() {
		var compo = LGen.component.image
		compo.screen_compo = LGen.call({'c':'str', 'f':'to_elm'})(
			'<div>'+
				'<button class="std gold theme fp">'+'Upload Image'+'</button>'+
			'</div>'
		)
		// LGen.Page.set_css(compo.screen_compo)
		// LGen.Page.Self.update_css(compo.screen_compo)
		compo.screen_compo.querySelector('button').addEventListener('click', function() {
			compo.open()
		})
	  // compo.screen.querySelector('#files').addEventListener('change', compo.compress, false);
	  // compo.screen_compo.querySelector('#files').addEventListener('change', compo.handleFileSelect3);
		return compo.screen_compo
	}

	this.handleFileSelect = handleFileSelect
	function handleFileSelect(evt) {
		lprint(evt.target.files)
    var fr = new FileReader;
    
    fr.onload = function() {
        var img = new Image;
        lprint(img.width)
        img.onload = function() {
            alert(img.width);
        };
        
        img.src = fr.result;
    };
    
    fr.readAsDataURL(evt.target.files[0]);
	}

	this.handleFileSelect3 = handleFileSelect3
	function handleFileSelect3(evt) {
		var compo = LGen.component.image
		$(evt.target).off('change')
		$(evt.target).on('change', compo.handleFileSelect3)
		lprint(evt.target)
	}

	this.handleFileSelect2 = handleFileSelect2
	function handleFileSelect2(evt) {
		var compo = LGen.component.image
		compo.current_img = evt.target;
		var files = evt.target.files; // FileList object
		lprint(files)
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      lprint(f)
			// if (f.type.toLowerCase() !== compo.filetype.toLowerCase()) {
			// 	LGen.component.snackbar.open({'str':'filetype is incorrect.'})
			// 	return 0;
			// }
			// if (f.size > compo.max_size) {
			// 	LGen.component.snackbar.open({'str':'file exceeds the maximum file-size.'})
			// 	return 0;
			// }

      var reader = new FileReader();
      // Closure to capture the file information.
      reader.onload = (function(theFile) {

        return function(e) {
					var i = new Image(); 
					i.onload = function(){
		        // if (compo.max_width === i.width && compo.max_height === i.height) {
		        // 	lprint('ok')
		        // }
		        // else {
		        // 	LGen.component.snackbar.open({'str':'image resolution is not match.'})
		        // }
						// lprint(i.width+", "+i.height)
		        lprint(i)

	          $(compo.screen.querySelector('.img')).croppie({
	          	'url':i.src,
        	    "viewport": {
					        'width': compo.max_width,
					        'height': compo.max_height
					    }
	          })
	     //      .then(function (resp) {
	     //      	$(compo.screen).fadeOut()
	     //      	lprint(resp)
						// });
						if (!$(compo.screen).hasClass('open')) {
			      	$(compo.screen).css({'display':'block'})
				      setTimeout(function() {
			          $(compo.screen).addClass('open')
				      }, LGen.Page.speed)
						}
					};
					i.src = e.target.result; 

        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
		// document.getElementById('list').innerHTML = '<ul>' + output.join('') + '</ul>';
	}

	this.compress = compress
	function compress(e) {
		var compo = LGen.component.image
    const width = LGen.component.max_width;
    const height = LGen.component.max_height;
    const fileName = e.target.files[0].name;
    const reader = new FileReader();
    reader.readAsDataURL(e.target.files[0]);
    reader.onload = event => {
    	var canvas = document.getElementById("canvasa");
			var ctx = canvas.getContext("2d");
      const img = new Image();
      img.src = event.target.result;
      img.onload = () => {
 
		    // set size proportional to image
		    canvas.height = canvas.width * (img.height / img.width);

		    // step 1 - resize to 50%
		    var oc = document.createElement('canvas'),
		        octx = oc.getContext('2d');

		    oc.width = compo.max_width;
		    oc.height = compo.max_height;
		    octx.drawImage(img, 0, 0, oc.width, oc.height);

		    // step 2
		    octx.drawImage(oc, 0, 0, oc.width * 0.5, oc.height * 0.5);

		    // step 3, resize to final size
		    ctx.drawImage(oc, 0, 0, oc.width * 0.5, oc.height * 0.5,
		    0, 0, canvas.width, canvas.height);
      },
      reader.onerror = error => lprint(error);
    };
	}
}