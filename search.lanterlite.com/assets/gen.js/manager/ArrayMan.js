LGen.Array = new ArrayMan()
LGen.ArrayMan = new ArrayMan()

function ArrayMan () {

	this.is_index_exist = is_index_exist
	function is_index_exist(array, index) {
		if(typeof array[index] === 'undefined') {
	    return false
		}
		else {
			return true
		}
	}
	
	this.rmv_by_val = rmv_by_val
	function rmv_by_val(arr, value) {
		var index = arr.indexOf(value);
		if (index !== -1)
			arr.splice(index, 1);
		return arr
	   // return arr.filter(function(ele){
	   //     return ele != value;
	   // });
	}

	this.is_val_exist = is_val_exist
	function is_val_exist(arr, text) {
		if (arr.indexOf(text) === -1)
			return false
		else
			return true
	}

	this.rmv_first = rmv_first
	function rmv_first(arr) {
		arr.shift();
		return arr;
	}

	this.rmv_last = rmv_last
	function rmv_last(arr) {
		arr.pop();
		return arr;
	}


	this.to_str = to_str
	function to_str(arr, parser) {
		return arr.join(parser)
	}


	this.is_str_exist = is_str_exist
	function is_str_exist(arr, str) {
		return arr.indexOf(str.toLowerCase()) > -1;
	}

	this.is_int_exist = is_int_exist
	function is_int_exist(arr, int) {
		return arr.includes(int);
	}

	this.get_index_by_strval = get_index_by_strval
	function get_index_by_strval(arr, str) {
		return arr.indexOf(str.toLowerCase());
	}

	this.is_val_exist = is_val_exist
	function is_val_exist(arr, val) {
		return is_exist_arr_val2.call(arr, val)
		function is_exist_arr_val2(needle) {
		    var findNaN = needle !== needle;
		    var indexOf;

		    if(!findNaN && typeof Array.prototype.indexOf === 'function') {
		        indexOf = Array.prototype.indexOf;
		    } else {
		        indexOf = function(needle) {
		            var i = -1, index = -1;

		            for(i = 0; i < this.length; i++) {
		                var item = this[i];

		                if((findNaN && item !== item) || item === needle) {
		                    index = i;
		                    break;
		                }
		            }

		            return index;
		        };
		    }
		    return indexOf.call(this, needle) > -1;
		};
	}


	this.is_obj_exist = is_obj_exist
	function is_obj_exist(arr, obj) {
	  var i;
	  var found = false;
	  for (i = 0; i < arr.length; i++) {
	    if (JSON.stringify(arr[i]) === JSON.stringify(obj)) {
	    	found = true;
	      return true;
	    }
	    else {
		    if (i == (arr.length-1) && found) {
				  return false;
		    }
	    }
	  }
	}


}