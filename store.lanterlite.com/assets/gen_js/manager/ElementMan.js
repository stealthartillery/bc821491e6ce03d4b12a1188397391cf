LGen.elm = {
	clear_childs : function (node) {
	  while (node.firstChild) {
	    node.removeChild(node.firstChild);
	  }
	},
	clear_self : function (query) {
		var content = ''
		if (typeof(query) === 'string')
		  content = document.querySelector(query);
		else
			content = query
	  if (content != null)
	    content.parentNode.removeChild(content);    
	},
	get : function (obj) {
		if (typeof(obj) == 'string')
			obj = document.querySelector(obj)
		return obj
	},
	is_focus : function (query) {
		return $(query).is(":focus")
	},
	rmv_first_child : function (parent) {
		$(parent).find(':first-child').remove();
	},
	input : {
		to_number : function (elm) {
			$(elm).css({"text-transform": "lowercase"})
			elm.addEventListener('keydown', function(e) {
		    var keypressed = e.which
		    // lprint(keypressed)
	      if(!e.shiftKey && (keypressed === 9 || keypressed === 8 || keypressed === 13 || keypressed === 46 || (keypressed >= 37 && keypressed <= 40)) ) { 
		    	// lprint('keypressed')
	      }
	      else if(e.shiftKey || !(keypressed >=48 && keypressed <= 57) && !(keypressed >=96 && keypressed <= 105)) { 
	        e.preventDefault()
	        return false             
	      }
			  if (
	  			(keypressed === 9) || // tab
			  	(keypressed >=65 && keypressed <= 90) || // character 
	  			(keypressed >=48 && keypressed <= 57) || // num
	  			(keypressed >=96 && keypressed <= 105)
				) {
					this.value = this.value.toLowerCase();
				} else if ( keypressed === 8 || keypressed === 27 || keypressed === 46  || (keypressed >= 35 && keypressed <= 40) ) {
	    		// Accepted but the event it's not propagated because those are the special chars
	      } else {
	        // We don't allow anything else
	        e.preventDefault()
	        return false
	      }
			})
		},
		to_email : function (elm){
			$(elm).css({"text-transform": "lowercase"})
			elm.addEventListener('keydown', function(e) {
		    var keypressed = e.which
	      if(e.shiftKey && (keypressed === 50)) { 
		    	// lprint('keypressed')
	      }
	      else if(e.shiftKey && (keypressed >=48 && keypressed <= 57)) { 
	        e.preventDefault()
	        return false             
	      }
			  var key = String.fromCharCode(e.which)
		    // lprint(keypressed)

			  if (
	  			(keypressed === 9) || // tab
	  			(keypressed === 190) || // dot
			  	(keypressed >=65 && keypressed <= 90) || // character 
	  			(keypressed >=48 && keypressed <= 57) || // num
	  			(keypressed >=96 && keypressed <= 105)
				) {
					this.value = this.value.toLowerCase();
				} else if ( keypressed === 8 || keypressed === 27 || keypressed === 46  || (keypressed >= 35 && keypressed <= 40) ) {
	    		// Accepted but the event it's not propagated because those are the special chars
	      } else {
	        // We don't allow anything else
	        e.preventDefault()
	        return false
	      }
			})
		},
		to_username : function (elm){
			$(elm).css({"text-transform": "lowercase"})
			elm.addEventListener('keydown', function(e) {
		    var keypressed = e.which
		    // lprint(keypressed)
	      if(e.shiftKey && (keypressed >=48 && keypressed <= 57)) { 
	        e.preventDefault()
	        return false             
	      }
			  var key = String.fromCharCode(e.which)

			  if (
	  			(keypressed === 9) || // tab
			  	(keypressed >=65 && keypressed <= 90) || // character 
	  			(keypressed >=48 && keypressed <= 57) || // num
	  			(keypressed >=96 && keypressed <= 105)
				) {
					this.value = LGen.call({'c':'str','f':'to_alphanumeric'})(this.value).toLowerCase();
				} else if ( keypressed === 8 || keypressed === 27 || keypressed === 46  || (keypressed >= 35 && keypressed <= 40) ) {
	    		// Accepted but the event it's not propagated because those are the special chars
	      } else {
	        // We don't allow anything else
	        e.preventDefault()
	        return false
	      }
			})
		},
		to_alphanum : function (elm){
			elm.addEventListener('keydown', function(e) {
		    var keypressed = e.which
		    // lprint(keypressed)
	      if(e.shiftKey && (keypressed >=48 && keypressed <= 57)) { 
	        e.preventDefault()
	        return false             
	      }
			  var key = String.fromCharCode(e.which)

			  if (
	  			(keypressed === 9) || // tab
			  	(keypressed >=65 && keypressed <= 90) || // character 
	  			(keypressed >=48 && keypressed <= 57) || // num
	  			(keypressed >=96 && keypressed <= 105)
				) {
					this.value = LGen.call({'c':'str','f':'to_alphanumeric'})(this.value).toUpperCase();
				} else if ( keypressed === 8 || keypressed === 27 || keypressed === 46  || (keypressed >= 35 && keypressed <= 40) ) {
	    		// Accepted but the event it's not propagated because those are the special chars
	      } else {
	        // We don't allow anything else
	        e.preventDefault()
	        return false
	      }
			})
		}
	},
	select : {
		get_selected_val : function (elm) {
			return elm.options[elm.selectedIndex].value;
		}
	},
}


function shade_set() {
	LGen.set_func({'val':'elm','func':LGen.elm})
	delete LGen.elm
}
shade_set()
