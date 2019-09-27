LGen.PropKey = new PropKeyMan()
LGen.PropKeyMan = new PropKeyMan()

function PropKeyMan () {

	this.get_prop_by_key = get_prop_by_key
	function get_prop_by_key(propkey, key) {
    var obj = propkey
    var keys = Object.keys(obj)
    for (var i=0; i<keys.length; i++) {
      if (obj[keys[i]] === key) {
        return keys[i]
      }
    }
    return false
	}

	this.get_key_by_prop = get_key_by_prop
	function get_key_by_prop(propkey, prop) {
		if (propkey.hasOwnProperty(prop))
		  return propkey[prop]
		else
		  return false
	}

	this.obj_key_to_prop = obj_key_to_prop
	function obj_key_to_prop(propkey, obj) {
	  var keys = Object.keys(obj)
	  for (var i=0; i<keys.length; i++) {
	  	if (LGen.JsonMan.is_json(obj[keys[i]])) {
	  		obj[keys[i]] = this.obj_key_to_prop(propkey, obj[keys[i]]);
	  	}
	    var _prop = get_prop_by_key(propkey, keys[i])
	    if (_prop) {
		    obj[_prop] = obj[keys[i]]
		    obj = LGen.JsonMan.rmv_by_key(obj, keys[i])
		  }
	  }
	  return obj
	}

	this.obj_prop_to_key = obj_prop_to_key
	function obj_prop_to_key(propkey, obj) {
	  var props = Object.keys(obj)
	  for (var i=0; i<props.length; i++) {
	  	if (LGen.JsonMan.is_json(obj[props[i]])) {
	  		obj[props[i]] = this.obj_prop_to_key(propkey, obj[props[i]]);
	  	}
	    var _key = get_key_by_prop(propkey, props[i])
	    if (_key) {
		    obj[_key] = obj[props[i]]
		    obj = LGen.JsonMan.rmv_by_key(obj, props[i])
	    }
	  }
	  return obj
	}
}