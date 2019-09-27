function rbutton() {
	this.title = title
	this.create = create
	this.change = change
	this.get = get

	function title(obj, title) {
		obj.childNodes[1].innerHTML = title
	}

	function get(id) {
		var rbtn = document.querySelector('.rbutton.' + id)
		return rbtn
	}

	function create(obj) {
		var input = document.createElement('input')
		input.setAttribute('id', obj['id'])
		input.setAttribute('name', 'radio ' + obj['group'])
		input.setAttribute('type', 'radio')
		if (obj['is_checked'])
			input.setAttribute('checked', 'checked')
		if (obj['is_disabled'])
			input.disabled = true
		
		input.value = obj['value']

		var label = document.createElement('label')
		label.setAttribute('for', obj['id'])
		label.setAttribute('class', 'radio-label theme_clr_text1')
		label.innerHTML = obj['title']

		var radio = document.createElement('div')
		// radio.setAttribute('class', 'rbutton')
		radio.setAttribute('class', 'rbutton ' + obj['id'])
		radio.appendChild(input)
		radio.appendChild(label)

		return radio
	}

	function change(obj, func) {
		// $(obj.childNodes[0]).before($(obj.childNodes[1]));
		// allDescendants(obj)
		// function allDescendants (node) {
	 //    for (var i = 0; i < node.childNodes.length; i++) {
	 //      var child = node.childNodes[i];
	 //      allDescendants(child);
	 //      console.log(child)
		// 		if (child.className == "cbx") {
		// 			$(child.childNodes[0]).before($(child.childNodes[1]));
		//       break;
		//     }
	 //    }
		// }
		obj.childNodes[0].addEventListener('change', function() {
			func(this.value)
		})
	}
}
