<?php
	class PropKeyMan {
		function get_prop_by_key($propkey, $key) {
	    $obj = $propkey;
	    foreach ($obj as $prop => $value) {
        if ($obj[$prop] === $key) {
          return $prop;
        }
	    }
	    return false;
		}

		function get_key_by_prop($propkey, $prop) {
			if (LGen('JsonMan')->is_key_exist($propkey, $prop))
			  return $propkey[$prop];
			else
			  return false;
		}

		function obj_key_to_prop($propkey, &$obj) {
  		// LGen('JsonMan')->print($obj);
  		$_obj = $obj;
		  foreach ($_obj as $key => $value) {
		  	if (LGen('JsonMan')->is_json($value)) {
		  		$this->obj_key_to_prop($propkey, $obj[$key]);
		  	}
		    $_prop = $this->get_prop_by_key($propkey, $key);
		    if ($_prop) {
			    $obj[$_prop] = $obj[$key];
			    LGen('JsonMan')->rmv_by_key($obj, $key);
			  }
		  }
		}

		function obj_prop_to_key($propkey, &$obj) {
			// LGen('JsonMan')->print($obj);
  		$_obj = $obj;
		  foreach ($_obj as $prop => $value) {
		  	if (LGen('JsonMan')->is_json($value)) {
		  		$this->obj_prop_to_key($propkey, $obj[$prop]);
		  	}
		    $_key = $this->get_key_by_prop($propkey, $prop);
		    if ($_key) {
			    $obj[$_key] = $obj[$prop];
			    LGen('JsonMan')->rmv_by_key($obj, $prop);
		    }
		  }
		}
	}
?>