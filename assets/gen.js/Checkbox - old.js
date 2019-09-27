LGen.component.checkbox = Checkbox

function Checkbox() {
	this.set = set
	function set() {

		this.screen = LGen.String.to_elm(
			'<div class="checkbox">'+
				'<input style="display: none;" type="checkbox" class="id" class="inp-cbx"/>'+
				'<label class="cbx" for="cbx">'+
					'<span class="svg" id="svg">'+'</span>'+
				'</label>'+
				'<span class="title" id="title">'+'</span>'+
			'</div>'
		)
	}
	
	this.title  = title
	function title(title) {
		allDescendants(this.screen)
		function allDescendants (node) {
	    for (var i = 0; i < node.childNodes.length; i++) {
	      var child = node.childNodes[i];
	      allDescendants(child);
				if (child.id == "title") {
		      child.innerHTML = title;
		      break;
		    }
	    }
		}
	}

	this.click = click
	function click(callback) {
		allDescendants(this.screen)
		function allDescendants (node) {
	    for (var i = 0; i < node.childNodes.length; i++) {
	      var child = node.childNodes[i];
	      allDescendants(child);
		    if (child.nodeName == "INPUT") {
		      add_event(child)
		      break;
		    }        
	    }
		}

		function add_event(node) {
			node.addEventListener('click', function() {
				// var cbx = document.querySelector('.container input')
				if (node.checked) {
					$(document.querySelector('.cbx svg')).fadeIn(1)
				}
				else {
					$(document.querySelector('.cbx svg')).fadeOut(1)
				}
				callback(node.checked)
			})
		}
	}

	this.check = check
	function check(is_checked) {
		allDescendants(this.screen)
		function allDescendants (node) {
	    for (var i = 0; i < node.childNodes.length; i++) {
	      var child = node.childNodes[i];
	      allDescendants(child);
				if (child.nodeName == "INPUT") {
		      child.checked = is_checked
					asd(is_checked)
		      break;
		    }
	    }
		}

		function asd(checked) {
			// $.when( get_svg(name='check', id='white', is_str=true) ).done(function(svg){
				allDescendants(this.screen)
				function allDescendants (node) {
			    for (var i = 0; i < node.childNodes.length; i++) {
			      var child = node.childNodes[i];
			      allDescendants(child);
						if (child.className == "svg") {
							var icon = str_to_elm(I.obj['check'])
							icon.setAttribute('class', 'white')
							$(icon).css ({
						    'height': '18px',
						    'width': '18px',
						    'top': '0',
						    'left': '0',
							})
							child.appendChild(icon)
							if (checked) 
								$(icon).fadeIn(1)
							else
								$(icon).fadeOut(1)
				      break;
				    }
			    }
				}
			// });
		}
	}

	this.checked = checked
	function checked() {
		allDescendants(this.screen)
		function allDescendants (node) {
	    for (var i = 0; i < node.childNodes.length; i++) {
	      var child = node.childNodes[i];
	      allDescendants(child);
				if (child.nodeName == "INPUT") {
		      return child.checked;
		      break;
		    }
	    }
		}
	}

	this.swap = swap
	function swap(obj) {
		var tr = obj.childNodes[0].childNodes[0]
		$(tr.childNodes[0]).before($(tr.childNodes[1]));
	}

	function swap2(obj) {
	$(obj.childNodes[0]).before($(obj.childNodes[1]));
		allDescendants(obj)
		function allDescendants (node) {
	    for (var i = 0; i < node.childNodes.length; i++) {
	      var child = node.childNodes[i];
	      allDescendants(child);
				if (child.className == "cbx") {
					$(child.childNodes[0]).before($(child.childNodes[1]));
		      break;
		    }
	    }
		}
	}
}

